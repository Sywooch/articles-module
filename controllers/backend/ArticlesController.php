<?php

namespace alexsers\articles\controllers\backend;

use alexsers\articles\Module;
use alexsers\base\components\backend\Controller;
use alexsers\articles\models\backend\Articles;
use alexsers\articles\models\backend\ArticlesCategory;
use alexsers\articles\models\backend\ArticlesSearch;
use alexsers\users\models\backend\User;
use vova07\imperavi\actions\GetAction as ImperaviGet;
use vova07\imperavi\actions\UploadAction as ImperaviUpload;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use Yii;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Контроллер управления статьями
 * Class ArticlesController
 * @package backend\controllers
 */
class ArticlesController extends Controller
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
                'roles' => ['BArticleIndex']
            ],
            [
                'allow' => true,
                'actions' => ['create','imperavi-get','imperavi-image-upload','imperavi-file-upload','fileapi-upload'],
                'roles' => ['BArticleCreate']
            ],
            [
                'allow' => true,
                'actions' => ['update','imperavi-get','imperavi-image-upload','imperavi-file-upload','fileapi-upload'],
                'roles' => ['BArticleUpdate']
            ],
            [
                'allow' => true,
                'actions' => ['delete'],
                'roles' => ['BArticleDelete']
            ],
            [
                'allow' => true,
                'actions' => ['batch-delete'],
                'roles' => ['BArticleBatchDelete']
            ],
            [
                'allow' => false,
            ]
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'batch-delete' => ['post', 'delete']
            ],
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'imperavi-get' => [
                'class' => ImperaviGet::className(),
                'url' => $this->module->contentUrl,
                'path' => $this->module->contentPath
            ],
            'imperavi-image-upload' => [
                'class' => ImperaviUpload::className(),
                'url' => $this->module->contentUrl,
                'path' => $this->module->contentPath
            ],
            'imperavi-file-upload' => [
                'class' => ImperaviUpload::className(),
                'url' => $this->module->fileUrl,
                'path' => $this->module->filePath,
                'uploadOnlyImage' => false
            ],
        ];
    }

    /**
     * Список статей
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticlesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statusArray = Articles::getStatusArray();
        $categoryList = ArticlesCategory::getCategoryListArray();
        $userList = User::getUserListArray();

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'statusArray' => $statusArray,
                'categoryList' => $categoryList,
                'userList' => $userList
            ]
        );
    }

    /**
     * Создание статьи
     * @return array|string|Response
     */
    public function actionCreate()
    {
        $model = new Articles(['scenario' => 'admin-create']);
        $statusArray = Articles::getStatusArray();
        $categoryList = ArticlesCategory::getCategoryListArray();
        $userList = User::getUserListArray();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->redirect(['update', 'id' => $model->id]);
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
                'statusArray' => $statusArray,
                'categoryList' => $categoryList,
                'userList' => $userList
            ]
        );
    }

    /**
     * Обновление статьи
     * @param $id
     * @return array|string|Response
     * @throws HttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('admin-update');
        $statusArray = Articles::getStatusArray();
        $categoryList = ArticlesCategory::getCategoryListArray();
        $userList = User::getUserListArray();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('danger', Module::t('articles', 'Не удалось обновить статью. Попробуйте пожалуйста еще раз!'));
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
                'userList' => $userList
            ]
        );
    }

    /**
     * Поиск статьи по id
     * @param $id
     * @return static|static[]
     * @throws \yii\web\HttpException
     */
    protected function findModel($id)
    {
        if (is_array($id)) {
            $model = Articles::findAll($id);
        } else {
            $model = Articles::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }

    /**
     * Удаление статьи
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
     * Удаление статей
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
