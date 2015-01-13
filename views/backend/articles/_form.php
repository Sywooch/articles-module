<?php

use alexsers\articles\Module;
use vova07\fileapi\Widget as FileAPI;
use vova07\imperavi\Widget as Imperavi;
use dosamigos\selectize\Selectize;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?php $box->beginBody(); ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'category_id')->dropDownList($categoryList, [
                'prompt' => Module::t('articles', 'Выберите категорию')
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'alias') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'status_id')->dropDownList($statusArray) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'snippet')->widget(
                Imperavi::className(),
                [
                    'settings' => [
                        'minHeight' => 200,
                        'imageGetJson' => Url::to(['/articles/imperavi-get']),
                        'imageUpload' => Url::to(['/articles/imperavi-image-upload']),
                        'fileUpload' => Url::to(['/articles/imperavi-file-upload'])
                    ]
                ]
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'content')->widget(
                Imperavi::className(),
                [
                    'settings' => [
                        'minHeight' => 300,
                        'imageGetJson' => Url::to(['/articles/imperavi-get']),
                        'imageUpload' => Url::to(['/articles/imperavi-image-upload']),
                        'fileUpload' => Url::to(['/articles/imperavi-file-upload'])
                    ]
                ]
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'tagNames')->widget(Selectize::className(), [
                // calls an action that returns a JSON object with matched
                // tags
                'url' => ['tag/list'],
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'plugins' => ['remove_button'],
                    'valueField' => 'name',
                    'labelField' => 'name',
                    'searchField' => ['name'],
                    'create' => true,
                ],
            ])->hint('Используйте запятые "," для разделения тегов') ?>
        </div>
    </div>


<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('articles', 'Сохранить') : Module::t('articles','Обнавить'),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>