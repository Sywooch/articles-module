<?php

use alexsers\articles\Module;
use alexsers\frontend\widgets\Menu;
use alexsers\articles\models\frontend\ArticlesCategory;

$this->title = $model['title'] . ' / ' . Module::t('articles', 'Статьи о рыбалке');
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
$this->params['breadcrumbsTitle'] = Module::t('articles', 'Статьи');

$this->params['breadcrumbs'] = [
    [
        'label' => Module::t('articles', 'Статьи'),
        'url' => ['index']
    ],
    $model['title']
]; ?>

<div class="row">
    <aside class="col-sm-4 col-sm-push-8">
        <div class="sidebar">
            <?= $this->render('_sidebar') ?>
        </div>
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
                    <?php if ($tags): ?>
                        <div class="tags">
                            <i class="icon-tags"></i> Метки <?= $tags ?>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-8">
                                <p>Поделитесь статьёй с друзьями.</p>
                            </div>
                            <div class="col-xs-6 col-md-4">
                                    <script type="text/javascript" src="//yastatic.net/share/share.js"
                                            charset="utf-8"></script>
                                <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="small"
                                     data-yashareQuickServices="vkontakte,facebook,twitter,moimir"
                                     data-yashareTheme="counter">
                                </div>
                            </div>
                        </div>

                    <?php endif ?>

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
