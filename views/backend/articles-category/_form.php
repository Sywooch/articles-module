<?php

use alexsers\articles\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?php $box->beginBody(); ?>
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
        <?= $form->field($model, 'parent_id')->dropDownList($categoryList, [
            'prompt' => Module::t('articles', 'Выберите категорию')
        ]) ?>
    </div>
</div>

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('articles', 'Сохранить') : Module::t('articles','Обновить'),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>
