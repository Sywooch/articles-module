<?php

use frontend\widgets\Menu;
use alexsers\articles\models\frontend\ArticlesCategory;

$this->title = $model['title'];
$this->params['breadcrumbs'] = [
    [
        'label' => ' / ' . Yii::t('frontend', 'Статьи'),
        'url' => ['index']
    ],
    ' / ' . $this->title
]; ?>

<section id="about-us" class="container">
<div class="row-fluid">
<div class="span8">
    <div class="blog">
        <div class="blog-item well">
            <h2><?= $model->title ?></h2>
            <div class="blog-meta clearfix">
                <p class="pull-left">
                    <i class="icon-user"></i> <?= $username ?>
                    | <i class="icon-folder-close"></i>
                    <a href="<?= ArticlesCategory::getArticleCategoryUrl($model->category_id) ?>">
                        <?= ArticlesCategory::getArticleCategory($model->category_id) ?>
                    </a>
                    | <i class="icon-calendar"></i> <?= $model->created ?>
                    | <i class="icon-eye-open"></i> <?= $model->views ?>
                </p>
<!--                <p class="pull-right"><i class="icon-comment pull"></i> <a href="#comments">3 Comments</a></p>-->
            </div>

                <?= $model->content ?>

<!--            <div class="tag"><i class="icon-tags"></i>-->
<!--                 <a href="#"><span class="label label-success">CSS3</span></a>-->
<!--                <a href="#"><span class="label label-success">HTML5</span></a>-->
<!--                <a href="#"><span class="label label-success">Bootstrap</span></a>-->
<!--                <a href="#"><span class="label label-success">WordPress</span></a>-->
<!--            </div>-->



                <?= \frontend\widgets\comment\Comment::widget(
                    [
                        'model' => $model,
                        'jsOptions' => [
                            'offset' => 80
                        ]
                    ]
                );?>


        </div>
        <!-- End Blog Item -->

    </div>
</div>

    <?= $this->render('_sidebar') ?>

</div>

</section>