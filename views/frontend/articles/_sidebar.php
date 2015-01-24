<?php

use alexsers\frontend\widgets\Menu;
use alexsers\articles\models\frontend\ArticlesCategory;

?>

<div class="widget categories">

    <?=
    Menu::widget(
        [
            'options' => [
                'class' => 'nav nav-pills nav-stacked'
            ],
            'items' => ArticlesCategory::getMenuArticleCategory()
        ]
    );
    ?>

</div>