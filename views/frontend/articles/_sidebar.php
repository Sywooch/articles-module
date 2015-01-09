<?php

use frontend\widgets\Menu;
use alexsers\articles\models\frontend\ArticlesCategory;

?>
<aside class="span4">
    <!--            <div class="widget search">
                    <form>
                        <input type="text" class="input-block-level" placeholder="Search">
                    </form>
                </div>-->
    <!-- /.search -->

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

</aside>