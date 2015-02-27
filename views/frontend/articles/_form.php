<?php

use alexsers\articles\Module;
use dosamigos\selectize\Selectize;
use vova07\fileapi\Widget as FileAPI;
use vova07\imperavi\Widget as Imperavi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>

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
            <?= $form->field($model, 'snippet')->widget(
                Imperavi::className(),
                [
                    'settings' => [
                        'minHeight' => 200,
                        'imageGetJson' => Url::to(['/articles/articles/imperavi-get']),
                        'imageUpload' => Url::to(['/articles/articles/imperavi-image-upload']),
                        'fileUpload' => Url::to(['/articles/articles/imperavi-file-upload'])
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
                        'imageGetJson' => Url::to(['/articles/articles/imperavi-get']),
                        'imageUpload' => Url::to(['/articles/articles/imperavi-image-upload']),
                        'fileUpload' => Url::to(['/articles/articles/imperavi-file-upload'])
                    ]
                ]
            ) ?>
        </div>
    </div>

<?= $form->field($model, 'tagNames')->widget(Selectize::className(), [
    'url' => ['/tag/tag/list'],
    'options' => ['class' => 'form-control'],
    'clientOptions' => [
        'plugins' => ['remove_button'],
        'valueField' => 'name',
        'labelField' => 'name',
        'searchField' => ['name'],
        'create' => true,
    ],
])->hint('Используйте запятые для разделения меток') ?>


<?= Html::submitButton(
    $model->isNewRecord ? Module::t('articles', 'Сохранить') : Module::t('articles','Обнавить'),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php ActiveForm::end(); ?>