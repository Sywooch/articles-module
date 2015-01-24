<?php

use alexsers\articles\Module;
use yii\widgets\ListView;

$this->title = Module::t('articles', 'Статьи');
$this->params['breadcrumbs'][] = $this->title;
?>

<section id="blog" class="container">
    <div class="row">

        <aside class="col-sm-4 col-sm-push-8">
            <?= $this->render('_sidebar') ?>
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