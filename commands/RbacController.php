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

        /* Статьи Backend */
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


        /* Статьи Backend */
        $FArticleIndex = $auth->createPermission('FArticleIndex');
        $FArticleIndex->description = 'Просмотр статей';
        $auth->add($FArticleIndex);

        $FArticleCategory = $auth->createPermission('FArticleCategory');
        $FArticleCategory->description = 'Просмотр статей по категориям';
        $auth->add($FArticleCategory);

        $FArticleTag = $auth->createPermission('FArticleTag');
        $FArticleTag->description = 'Просмотр статей по тегам';
        $auth->add($FArticleTag);

        $FArticleCreate = $auth->createPermission('FArticleCreate');
        $FArticleCreate->description = 'Создание статьи';
        $auth->add($FArticleCreate);


        $user = $auth->getRole('user');
        $admin = $auth->getRole('admin');
        $superadmin = $auth->getRole('superadmin');

        //  User
        $auth->addChild($user, $FArticleIndex);
        $auth->addChild($user, $FArticleCategory);
        $auth->addChild($user, $FArticleTag);
        $auth->addChild($user, $FArticleCreate);

        // Admin
        $auth->addChild($admin, $BArticleCategoryIndex);
        $auth->addChild($admin, $BArticleCategoryCreate);
        $auth->addChild($admin, $BArticleCategoryUpdate);
        $auth->addChild($admin, $BArticleIndex);
        $auth->addChild($admin, $BArticleCreate);
        $auth->addChild($admin, $BArticleUpdate);

        // Superadmin
        $auth->addChild($superadmin, $BArticleCategoryDelete);
        $auth->addChild($superadmin, $BArticleCategoryBatchDelete);
        $auth->addChild($superadmin, $BArticleDelete);
        $auth->addChild($superadmin, $BArticleBatchDelete);
        $auth->addChild($superadmin, $BUpdateAuthorArticles);

        return static::EXIT_CODE_NORMAL;
    }
}