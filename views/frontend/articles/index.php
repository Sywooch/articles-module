<?php

use yii\widgets\ListView;

$this->title = Yii::t('frontend', 'Статьи');
$this->params['breadcrumbs'][] = ' / ' . $this->title;
?>

<section id="about-us" class="container main">
    <div class="row-fluid">
        <div class="span8">
            <div class="blog">

                <?= ListView::widget(
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

        <?= $this->render('_sidebar') ?>

    </div>

</section>