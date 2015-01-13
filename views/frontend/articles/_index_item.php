<?php

use alexsers\articles\Module;
use alexsers\articles\models\ArticlesCategory;
use alexsers\users\models\User;
use yii\helpers\Html;

?>

<div class="blog-item well">
    <h3>
        <?= Html::a($model->title, ['/articles/'.$model->alias]) ?>
    </h3>
    <div class="blog-meta clearfix">
        <p class="pull-left">
            <i class="icon-user"></i> <?= User::getUsername($model->author_id) ?>
            | <i class="icon-folder-close"></i>
            <a href="<?= ArticlesCategory::getArticleCategoryUrl($model->category_id) ?>">
                <?= ArticlesCategory::getArticleCategory($model->category_id) ?>
            </a>
            | <i class="icon-calendar"></i> <?= $model->created ?>
            | <i class="icon-eye-open"></i> <?= $model->views ?>
        </p>
<!--        <p class="pull-right"><i class="icon-comment pull"></i> <a href="blog-item.html#comments">3 Comments</a></p>-->
    </div>

        <?= $model->snippet ?>

    <?= Html::a(
        Module::t('articles', 'Читать далее') . '  <i class="icon-angle-right"></i><i class="icon-angle-right"></i><i class="icon-angle-right"></i>',
        ['/articles/'.$model->alias],
        ['class' => 'btn btn-link']
    ) ?>
</div>
<!-- End Blog Item -->