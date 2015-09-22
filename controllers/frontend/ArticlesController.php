<?php

namespace alexsers\articles\controllers\frontend;

use alexsers\articles\models\frontend\Articles;
use alexsers\articles\models\frontend\ArticlesCategory;
use alexsers\tag\models\Tag;
use alexsers\users\models\User;
use alexsers\base\components\frontend\Controller;
use alexsers\comments\models\frontend\Comments;
use alexsers\articles\Module;
use Yii;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * Контроллер для вывода статей
 * Class ArticlesController
 * @package frontend\controllers
 */
class ArticlesController extends Controller
{
    /**
     * @return string
     */
    function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find()->published(),
            'sort'=>array(
                'defaultOrder'=> [
                    'id' => SORT_DESC
                ],
            ),
            'pagination' => [
                'pageSize' => $this->module->recordPerPage
            ]
        ]);
        $this->storeReturnUrl();

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * Вывод статей по категории
     * @param $category
     * @return string
     */
    function actionCategory($category)
    {
        $articleCategory = ArticlesCategory::find()->where(['alias' => $category])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find()->published()->category($articleCategory['id']),
            'sort'=>array(
                'defaultOrder'=> [
                    'id' => SORT_DESC
                ],
            ),
            'pagination' => [
                'pageSize' => $this->module->recordPerPage
            ]
        ]);
        $this->storeReturnUrl();

        return $this->render(
            'category',
            [
                'dataProvider' => $dataProvider,
                'categoryName' => $articleCategory['title']
            ]
        );
    }

    /**
     * Вывод статей по категории
     *
     */
    function actionTag($tag)
    {
        $articlesArrayId = Articles::getTagAlias($tag);
        $tagName = Tag::getTagName($tag);

        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find()->published()->tag($articlesArrayId),
            'sort'=>array(
                'defaultOrder'=> [
                    'id' => SORT_DESC
                ],
            ),
            'pagination' => [
                'pageSize' => $this->module->recordPerPage
            ]
        ]);
        $this->storeReturnUrl();

        return $this->render(
            'tag',
            [
                'dataProvider' => $dataProvider,
                'tagName' => $tagName,
            ]
        );
    }

    /**
     * Просмотр статьи
     * @param $alias
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionView($alias)
    {
        if (($model = Articles::findOne(['alias' => $alias])) !== null) {
            $this->counter($model);
            $username = User::getUsername($model->author_id);
            $comments = Comments::find()->where(['model_id' => $model->id])->all();
            $tags = Articles::getTags($model->id);
            $keywords = Articles::getKeywords($model->id);
            $modelComment = new Comments();
            $this->storeReturnUrl();

            // ToDo Переделать!!!!!!!!!!!!!!!!!
            $description = strip_tags($model->content);
            $count = stripos($description,'.');
            $description = substr($description, 0, $count).'...';


            return $this->render(
                'view',
                [
                    'model' => $model,
                    'username' => $username,
                    'comments' => $comments,
                    'modelComment' => $modelComment,
                    'tags' => $tags,
                    'keywords' => $keywords,
                    'description' => $description,
                ]
            );
        } else {
            throw new HttpException(404);
        }
    }

    /**
     * Создание статьи
     * @return array|string|Response
     */
/*    public function actionCreate()
    {
        $model = new Articles();
        $categoryList = ArticlesCategory::getCategoryListArray();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->redirect(['view', 'alias' => $model->alias]);
                } else {
                    Yii::$app->session->setFlash('danger', Module::t('articles', 'Не удалось сохранить статью. Попробуйте пожалуйста еще раз!'));
                    return $this->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->render(
            'create',
            [
                'model' => $model,
                'categoryList' => $categoryList,
            ]
        );
    }*/

    /**
     * Обновление просмотров статьи
     * @param $model
     */
    protected function counter($model)
    {
        $cookieName = 'articles-views';
        $shouldCount = false;
        $views = Yii::$app->request->cookies->getValue($cookieName);

        if ($views !== null) {
            if (is_array($views)) {
                if (!in_array($model->id, $views)) {
                    $views[] = $model->id;
                    $shouldCount = true;
                }
            } else {
                $views = [$model->id];
                $shouldCount = true;
            }
        } else {
            $views = [$model->id];
            $shouldCount = true;
        }

        if ($shouldCount === true) {
            if ($model->updateViews()) {
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => $cookieName,
                    'value' => $views,
                    'expire' => time() + 86400 * 365
                ]));
            }
        }
    }


}
