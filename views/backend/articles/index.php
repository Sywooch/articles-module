<?php

use alexsers\articles\Module;
use alexsers\themes\backend\widgets\Box;
use alexsers\themes\backend\widgets\GridView;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = Module::t('articles', 'Статьи');
$this->params['subtitle'] = Module::t('articles', 'Список статей');
$this->params['breadcrumbs'] = [
    $this->title
];

if(Yii::$app->user->can('BArticleCreate')){
    $buttonsTemplate[]='{create}';
}

if(Yii::$app->user->can('BArticleBatchDelete')){
    $buttonsTemplate[]='{batch-delete}';
}

$buttonsTemplate = !empty($buttonsTemplate) ? implode(' ', $buttonsTemplate) : null;
?>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'title' => $this->params['subtitle'],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $buttonsTemplate,
                'grid' => 'articles-grid'
            ]
        ); ?>
        <?= GridView::widget(
            [
                'id' => 'articles-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => SerialColumn::classname()],
                    ['class' => CheckboxColumn::classname()],
                    [
                        'attribute' => 'title',
                        'format' => 'html',
                        'value' => function ($model) {
                            return Html::a(
                                $model['title'],
                                ['update', 'id' => $model['id']]
                            );
                        }
                    ],
                    [
                        'attribute' => 'category_id',
                        'format' => 'html',
                        'value' => function ($model) {
                                if($model->category_id !== NULL)
                                {
                                    return Html::a($model->category['title'], ['/article-category/view', 'id' => $model->category['id']]);
                                }else{
                                    return NULL;
                                }
                            },
                        'filter' => Html::activeDropDownList(
                                $searchModel,
                                'category_id',
                                $categoryList,
                                [
                                    'class' => 'form-control',
                                    'prompt' => Module::t('articles', 'Выберите категорию')
                                ]
                            )
                    ],
                    [
                        'attribute' => 'status_id',
                        'format' => 'html',
                        'value' => function ($model) {
                            $class = ($model->status_id === $model::STATUS_PUBLISHED) ? 'label-success' : 'label-danger';

                            return '<span class="label ' . $class . '">' . $model->status . '</span>';
                        },
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'status_id',
                            $statusArray,
                            [
                                'class' => 'form-control',
                                'prompt' => Module::t('articles', 'Выберите статус')
                            ]
                        )
                    ],
                    [
                        'attribute' => 'author_id',
                        'format' => 'html',
                        'value' => function ($model) {
                                if($model->author_id !== NULL)
                                {
                                    return Html::a($model->user['username'], ['/users/user/update', 'id' => $model->user['id']]);
                                }else{
                                    return NULL;
                                }
                            },
                        'filter' => Html::activeDropDownList(
                                $searchModel,
                                'author_id',
                                $userList,
                                [
                                    'class' => 'form-control',
                                    'prompt' => Module::t('articles', 'Выберите автора')
                                ]
                            )
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'date',
/*                        'filter' => DatePicker::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'created_at',
                                'options' => [
                                    'class' => 'form-control'
                                ],
                                'clientOptions' => [
                                    'dateFormat' => 'dd.mm.yy',
                                ]
                            ]
                        )*/
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{update} {delete}'
                    ]
                ]
            ]
        ); ?>
        <?php Box::end(); ?>
    </div>
</div>