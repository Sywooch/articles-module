<?php

namespace alexsers\store\commands;

use Yii;
use yii\console\Controller;


class RbacController extends Controller
{
    public $defaultAction = 'add';

    public function actionAdd()
    {
        $auth = Yii::$app->authManager;


        /* Основной модуль магазина */
        $bcStoreCategoryIndex = $auth->createPermission('bcStoreCategoryIndex');
        $bcStoreCategoryIndex->description = 'Список категорий товара';
        $auth->add($bcStoreCategoryIndex);



        $admin = $auth->getRole('admin');
        $superadmin = $auth->getRole('superadmin');



        $auth->addChild($admin, $bcStoreCategoryIndex);

        return static::EXIT_CODE_NORMAL;
    }
}