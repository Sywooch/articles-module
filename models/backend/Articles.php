<?php

namespace alexsers\articles\models\backend;

use alexsers\articles\Module;
use Yii;
use alexsers\base\behaviors\PurifierBehavior;
use alexsers\base\behaviors\TransliterateBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class Article
 * @package alexsers\articles\models\backend
 * Article model.
 *
 * @property integer $id ИД
 * @property string $title Заголовок
 * @property string $alias Псевдоним
 * @property string $snippet Краткое содержание
 * @property string $content Контент
 * @property integer $views Просмотры
 * @property integer $status_id Статус
 * @property integer $created_at Дата создания
 * @property integer $updated_at Дата обновления
 */
class Articles extends \alexsers\articles\models\Articles
{
    /**
     * Читаемый статус статьи
     * @return mixed || null
     */
    public function getStatus()
    {
        if($statuses = self::getStatusArray()){
            return $statuses[$this->status_id];
        }else{
            return null;
        }
    }

    /**
     * Массив статусов
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_UNPUBLISHED => Module::t('articles', 'Скрыта'),
            self::STATUS_PUBLISHED => Module::t('articles', 'Опубликована')
        ];
    }

    /**
     * Категория статьи
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticlesCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(
            $rules,
            [
                ['status_id', 'in', 'range' => array_keys(self::getStatusArray())],
            ]
        );

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return array_merge(
            $labels,
            [
                'category_id' => Module::t('articles', 'Категория'),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return[
            'admin-create' => [
                'title',
                'alias',
                'category_id',
                'snippet',
                'content',
                'status_id',
                'tagNames',
            ],
            'admin-update' => [
                'title',
                'alias',
                'category_id',
                'snippet',
                'content',
                'status_id',
                'tagNames',
            ]
        ];
    }
}
