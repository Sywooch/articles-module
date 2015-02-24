<?php

namespace alexsers\articles\controllers\frontend;

use alexsers\articles\models\frontend\Articles;
use alexsers\articles\models\frontend\ArticlesCategory;
use alexsers\tag\models\Tag;
use alexsers\users\models\User;
use alexsers\base\components\frontend\Controller;
use alexsers\comments\models\frontend\Comments;
use Yii;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\data\ActiveDataProvider;

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
            'pagination' => [
                'pageSize' => $this->module->recordPerPage
            ]
        ]);

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
            'query' => Articles::find()->category($articleCategory['id']),
            'pagination' => [
                'pageSize' => $this->module->recordPerPage
            ]
        ]);

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
     * @param $category
     * @return string
     */
    function actionTag($tag)
    {
        $articlesArrayId = Articles::getTagAlias($tag);
        $tagName = Tag::getTagName($tag);

        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find()->tag($articlesArrayId),
            'pagination' => [
                'pageSize' => $this->module->recordPerPage
            ]
        ]);

        return $this->render(
            'tag',
            [
                'dataProvider' => $dataProvider,
                'tagName' => $tagName,
                //'test' => $test
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
            $modelComment = new Comments();

            return $this->render(
                'view',
                [
                    'model' => $model,
                    'username' => $username,
                    'comments' => $comments,
                    'modelComment' => $modelComment,
                    'tags' => $tags
                ]
            );
        } else {
            throw new HttpException(404);
        }
    }

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
