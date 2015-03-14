<?php

use alexsers\articles\Module;
use alexsers\frontend\widgets\Menu;
use alexsers\articles\models\frontend\ArticlesCategory;
use yii\widgets\ListView;

$this->title = Module::t('articles', 'Статьи');
$this->params['breadcrumbs']=[
    [
        'label' => $this->title,
        'url' => ['/articles'],
    ],
    'Категория - '.$categoryName
];
?>

<section id="blog" class="container">
    <div class="row">

        <aside class="col-sm-4 col-sm-push-8">
            <div class="sidebar">
                <?= $this->render('_sidebar') ?>
            </div>
        </aside>
        <div class="col-sm-8 col-sm-pull-4">
            <?=
            ListView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'itemView' => '_index_item',
                    'options' => [
                        'class' => 'blog'
                    ],
                    'itemOptions' => [
                        'class' => 'blog-item',
                        'tag' => 'article'
                    ]
                ]
            ); ?>
        </div>

    </div>
</section>