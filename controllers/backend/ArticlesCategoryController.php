<?php

namespace alexsers\articles\controllers\backend;

use alexsers\articles\Module;
use alexsers\base\components\backend\Controller;
use alexsers\articles\models\backend\ArticlesCategory;
use alexsers\articles\models\backend\ArticlesCategorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Контроллер управления категориями статей
 * @package backend\controllers
 */
class ArticlesCategoryController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['BArticleCategoryIndex']
            ],
            [
                'allow' => true,
                'actions' => ['create'],
                'roles' => ['BArticleCategoryCreate']
            ],
            [
                'allow' => true,
                'actions' => ['update'],
                'roles' => ['BArticleCategoryUpdate']
            ],
            [
                'allow' => true,
                'actions' => ['delete'],
                'roles' => ['BArticleCategoryDelete']
            ],
            [
                'allow' => true,
                'actions' => ['batch-delete'],
                'roles' => ['BArticleCategoryBatchDelete']
            ],
            [
                'allow' => false,
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'view' => ['get'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'batch-delete' => ['post', 'delete']
            ],
        ];
        return $behaviors;
    }

    /**
     * Список категорий
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticlesCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categoryList = ArticlesCategory::getCategoryListArray();
        $statusArray = ArticlesCategory::getStatusArray();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryList' => $categoryList,
            'statusArray' => $statusArray
        ]);
    }

    /**
     * Создание категории
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticlesCategory(['scenario' => 'admin-create']);
        $statusArray = ArticlesCategory::getStatusArray();
        $categoryList = ArticlesCategory::getCategoryListArray();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('danger', Module::t('articles', 'Не удалось сохранить категорию. Попробуйте пожалуйста еще раз!'));
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
                'statusArray' => $statusArray,
                'categoryList' => $categoryList,
            ]
        );
    }

    /**
     * Обновление категории
     * @param $id
     * @return array|string|Response
     * @throws HttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('admin-update');
        $statusArray = ArticlesCategory::getStatusArray();
        $categoryList = ArticlesCategory::getCategoryListArray();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('danger', Module::t('articles', 'Не удалось обновить категорию. Попробуйте пожалуйста еще раз!'));
                    return $this->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->render(
            'update',
            [
                'model' => $model,
                'statusArray' => $statusArray,
                'categoryList' => $categoryList,
            ]
        );
    }

    /**
     * Поиск категории по ID
     * @param $id
     * @return static|static[]
     * @throws \yii\web\HttpException
     */
    protected function findModel($id)
    {
        if (is_array($id)) {
            $model = ArticlesCategory::findAll($id);
        } else {
            $model = ArticlesCategory::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }

    /**
     * Удаление категории
     * @param $id
     * @return Response
     * @throws HttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Удаление нескольких категорий
     * @throws HttpException
     */
    public function actionBatchDelete()
    {
        if (($ids = Yii::$app->request->post('ids')) !== null) {
            $models = $this->findModel($ids);
            foreach ($models as $model) {
                $model->delete();
            }
            return $this->redirect(['index']);
        } else {
            throw new HttpException(400);
        }
    }
}
