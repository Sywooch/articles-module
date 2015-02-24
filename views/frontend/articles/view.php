<?php

use alexsers\articles\Module;
use alexsers\frontend\widgets\Menu;
use alexsers\articles\models\frontend\ArticlesCategory;

$this->title = $model['title'];
$this->params['breadcrumbs'] = [
    [
        'label' => Module::t('articles', 'Статьи'),
        'url' => ['index']
    ],
    $this->title
]; ?>

<div class="row">
    <aside class="col-sm-4 col-sm-push-8">
        <?= $this->render('_sidebar') ?>
    </aside>
    <div class="col-sm-8 col-sm-pull-4">
        <div class="blog">
            <div class="blog-item">
                <div class="blog-content">
                    <h3><?= $model->title ?></h3>

                    <div class="entry-meta">
                        <span><i class="icon-user"></i> <?= $username ?></span>
                            <span><i class="icon-folder-close"></i> <a
                                    href="<?= ArticlesCategory::getArticleCategoryUrl($model->category_id) ?>"><?= ArticlesCategory::getArticleCategory($model->category_id) ?></a></span>
                        <span><i class="icon-calendar"></i> <?= $model->created ?></span>
                        <!--                            <span><i class="icon-comment"></i> <a href="blog-item.html#comments">3 Comments</a></span>-->
                        <span><i class="icon-eye-open"></i> <?= $model->views ?></span>
                    </div>

                    <?= $model->content ?>
                    <hr>
                    <?php if ($tags): ?>
                    <div class="tags">
                        <i class="icon-tags"></i> Метки <?= $tags ?>
                    </div>
                    <?php endif ?>
                    <p>&nbsp;</p>

                    <?=
                    \alexsers\comments\widgets\comment\Comment::widget(
                        [
                            'model' => $model,
                            'jsOptions' => [
                                'offset' => 80
                            ]
                        ]
                    );
                    ?>
                </div>
            </div>
            <!--/.blog-item-->
        </div>
    </div>
    <!--/.col-md-8-->
</div>
<!--/.row-->
