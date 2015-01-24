<?php

namespace alexsers\articles\models;

use alexsers\articles\Module;
use alexsers\articles\traits\ModuleTrait;
use alexsers\base\helpers\Sitemap;
use alexsers\base\behaviors\PurifierBehavior;
use vova07\fileapi\behaviors\UploadBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Articles
 * @package common\modules\articles\models
 * Articles model.
 *
 * @property integer $id ID
 * @property string $title Title
 * @property string $alias Alias
 * @property integer $category_id Articles Category
 * @property integer $author_id Author
 * @property string $snippet Intro text
 * @property string $content Content
 * @property integer $views Views
 * @property integer $status_id Status
 * @property integer $created_at Created time
 * @property integer $updated_at Updated time
 */
class Articles extends ActiveRecord
{
    use ModuleTrait;
    /**
     * Unpublished status
     */
    const STATUS_UNPUBLISHED = 0;
    /**
     * Published status
     */
    const STATUS_PUBLISHED = 1;
    /**
     * @var string helper attribute to work with tags
     */
    public $tagNames;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new ArticlesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
            ],
            'sluggableBehavior' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'alias'
            ],
            'purifierBehavior' => [
                'class' => PurifierBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_VALIDATE => [
                        'snippet',
                        'content' => [
                            'HTML.AllowedElements' => '',
                            'AutoFormat.RemoveEmpty' => true
                        ]
                    ]
                ],
                'textAttributes' => [
                    self::EVENT_BEFORE_VALIDATE => ['title', 'alias']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Title
            ['title', 'required'],
            ['title', 'trim'],
            ['title', 'string', 'length' => [1,100]],

            // Alias
            ['alias', 'trim'],
            ['alias', 'string', 'length' => [1,100]],

            // Category_id
            ['category_id', 'required'],
            ['category_id', 'integer'],

            // Author_id
            ['author_id', 'integer'],

            // Snippet
            ['snippet', 'required'],

            // Content
            ['content', 'required'],

            // Status
            ['status_id', 'integer'],
            [
                'status_id',
                'default',
                'value' => $this->module->moderation ? self::STATUS_PUBLISHED : self::STATUS_UNPUBLISHED
            ],

            // CreatedAtJui and UpdatedAtJui
            [['createdAtJui', 'updatedAtJui'], 'date', 'format' => 'd.m.Y'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('articles', 'ID'),
            'title' => Module::t('articles', 'Заголовок'),
            'alias' => Module::t('articles', 'Алиас'),
            'snippet' => Module::t('articles', 'Введение'),
            'content' => Module::t('articles', 'Контент'),
            'views' => Module::t('articles', 'Просмотры'),
            'status_id' => Module::t('articles', 'Статус'),
            'created_at' => Module::t('articles', 'Создана'),
            'updated_at' => Module::t('articles', 'Обновлёна'),
            'preview_url' => Module::t('articles', 'Мини-изображение'),
            'image_url' => Module::t('articles', 'Изображение'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool|void
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                if(!$this->author_id){
                    $this->author_id = Yii::$app->getUser()->id;
                }
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->getCache()->delete(Sitemap::ARTICLES_CACHE);
        Sitemap::init();
    }

    public function afterDelete()
    {
        Yii::$app->getCache()->delete(Sitemap::ARTICLES_CACHE);
        Sitemap::init();
    }
}
