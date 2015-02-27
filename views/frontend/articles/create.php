<?php

use alexsers\articles\Module;
use alexsers\themes\backend\widgets\Box;

$this->title = Module::t('articles', 'Статьи');
$this->params['subtitle'] = Module::t('articles', 'Создание статьи');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];
?>

<section id="blog" class="container">
    <div class="row">

        <aside class="col-sm-4 col-sm-push-8">
            <?= $this->render('_sidebar') ?>
        </aside>
        <div class="col-sm-8 col-sm-pull-4">
            <?= $this->render(
                '_form',
                [
                    'model' => $model,
                    'categoryList' => $categoryList,
                ]
            );?>
        </div>

    </div>
</section>