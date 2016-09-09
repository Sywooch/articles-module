<?php

namespace alexsers\articles\models\backend;

use alexsers\articles\Module;
use alexsers\users\models\User;
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
     * Категория статьи
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticlesCategory::className(), ['id' => 'category_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
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
    public function scenarios()
    {
        return[
            'admin-create' => [
                'title',
                'alias',
                'category_id',
                'author_id',
                'snippet',
                'content',
                'status_id',
                'tagNames',
            ],
            'admin-update' => [
                'title',
                'alias',
                'category_id',
                'author_id',
                'snippet',
                'content',
                'status_id',
                'tagNames',
            ]
        ];
    }
}
