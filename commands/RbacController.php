<?php

namespace alexsers\articles\commands;

use Yii;
use yii\console\Controller;


class RbacController extends Controller
{
    public $defaultAction = 'add';

    public function actionAdd()
    {
        $auth = Yii::$app->authManager;




        /* Категории статей */
        $BArticleCategoryIndex = $auth->createPermission('BArticleCategoryIndex');
        $BArticleCategoryIndex->description = 'Список категорий статей';
        $auth->add($BArticleCategoryIndex);

        $BArticleCategoryCreate = $auth->createPermission('BArticleCategoryCreate');
        $BArticleCategoryCreate->description = 'Создание категрорий статей';
        $auth->add($BArticleCategoryCreate);

        $BArticleCategoryUpdate = $auth->createPermission('BArticleCategoryUpdate');
        $BArticleCategoryUpdate->description = 'Обновление категрорий статей';
        $auth->add($BArticleCategoryUpdate);

        $BArticleCategoryDelete = $auth->createPermission('BArticleCategoryDelete');
        $BArticleCategoryDelete->description = 'Удаление категрори статей';
        $auth->add($BArticleCategoryDelete);

        $BArticleCategoryBatchDelete = $auth->createPermission('BArticleCategoryBatchDelete');
        $BArticleCategoryBatchDelete->description = 'Удаление категрорий статей';
        $auth->add($BArticleCategoryBatchDelete);

        /* Статьи */
        $BArticleIndex = $auth->createPermission('BArticleIndex');
        $BArticleIndex->description = 'Список статей';
        $auth->add($BArticleIndex);

        $BArticleCreate = $auth->createPermission('BArticleCreate');
        $BArticleCreate->description = 'Создание статей';
        $auth->add($BArticleCreate);

        $BArticleUpdate = $auth->createPermission('BArticleUpdate');
        $BArticleUpdate->description = 'Обновление статей';
        $auth->add($BArticleUpdate);

        $BArticleDelete = $auth->createPermission('BArticleDelete');
        $BArticleDelete->description = 'Удаление статьи';
        $auth->add($BArticleDelete);

        $BArticleBatchDelete = $auth->createPermission('BArticleBatchDelete');
        $BArticleBatchDelete->description = 'Удаление статей';
        $auth->add($BArticleBatchDelete);

        $BUpdateAuthorArticles = $auth->createPermission('BUpdateAuthorArticles');
        $BUpdateAuthorArticles->description = 'Редактирование автора';
        $auth->add($BUpdateAuthorArticles);



        $admin = $auth->getRole('admin');
        $superadmin = $auth->getRole('superadmin');



        $auth->addChild($admin, $BArticleCategoryIndex);
        $auth->addChild($admin, $BArticleCategoryCreate);
        $auth->addChild($admin, $BArticleCategoryUpdate);
        $auth->addChild($admin, $BArticleIndex);
        $auth->addChild($admin, $BArticleCreate);
        $auth->addChild($admin, $BArticleUpdate);


        $auth->addChild($superadmin, $BArticleCategoryDelete);
        $auth->addChild($superadmin, $BArticleCategoryBatchDelete);
        $auth->addChild($superadmin, $BArticleDelete);
        $auth->addChild($superadmin, $BArticleBatchDelete);
        $auth->addChild($superadmin, $BUpdateAuthorArticles);

        return static::EXIT_CODE_NORMAL;
    }
}