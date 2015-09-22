<?php

use alexsers\articles\Module;
use alexsers\themes\backend\widgets\Box;

$this->title = Module::t('articles', 'Категории статей');
$this->params['subtitle'] = Module::t('articles', 'Обновление категории');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];

$buttonsTemplate[]='{cancel}';

if(Yii::$app->user->can('BArticleCategoryCreate')){
    $buttonsTemplate[]='{create}';
}

if(Yii::$app->user->can('BArticleCategoryDelete')){
    $buttonsTemplate[]='{delete}';
}

$buttonsTemplate = !empty($buttonsTemplate) ? implode(' ', $buttonsTemplate) : null;

?>

<div class="row">
    <div class="col-sm-12">
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
                'box' => $box
            ]
        );
        Box::end(); ?>
    </div>
</div>
