<?php

use alexsers\articles\Module;
use alexsers\themes\backend\widgets\Box;

$this->title = Module::t('articles', 'Статьи');
$this->params['subtitle'] = Module::t('articles', 'Обновление статьи');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];

$buttonsTemplate[]='{cancel}';

if(Yii::$app->user->can('BArticleCreate')){
    $buttonsTemplate[]='{create}';
}

if(Yii::$app->user->can('BArticleDelete')){
    $buttonsTemplate[]='{delete}';
}

$buttonsTemplate = !empty($buttonsTemplate) ? implode(' ', $buttonsTemplate) : null;
?>
<div class="row">
    <div class="col-sm-7">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-success'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $buttonsTemplate
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                'statusArray' => $statusArray,
                'categoryList' => $categoryList,
                'box' => $box,
                'userList' => $userList
            ]
        );
        Box::end(); ?>
    </div>

    <div class="col-sm-5">
    </div>
</div>
