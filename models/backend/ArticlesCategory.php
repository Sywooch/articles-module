<?php

namespace alexsers\articles\models\backend;

use alexsers\articles\Module;
use common\behaviors\PurifierBehavior;
use common\behaviors\TransliterateBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class ArticlesCategory
 * @package alexsers\articles\models\backend
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $parent_id
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Articles[] $articles
 * @property ArticlesCategory $parent
 * @property ArticlesCategory[] $articlesCategories
 */
class ArticlesCategory extends \alexsers\articles\models\ArticlesCategory
{

    /**
     * Читаемый статус категории
     * @var
     */
    protected $_categoryList;

    /**
     * Читаемый статус котегории
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
     * @return array Status array.
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_PUBLISHED => Module::t('articles', 'Активный'),
            self::STATUS_UNPUBLISHED => Module::t('articles', 'Не активный'),
        ];
    }

    /**
     * Упорядоченный массив категорий
     * @return mixed
     */
    public function getCategoryList()
    {
        if(!empty($this->parent_id)){
            if($this->_categoryList === NULL){
                $categoryList = self::getCategoryListArray();
                $this->_categoryList = $categoryList[$this->parent_id];
            }
            return $this->_categoryList;
        }
        return $this->_categoryList = NULL;
    }

    /**
     * Массив категорий
     * @param null $parent_id
     * @param int $level
     * @return array
     */
    public static function getCategoryListArray($parent_id = null, $level = 0)
    {
        if (empty($parent_id)) {
            $parent_id = null;
        }

        $categories = self::find()->where(['parent_id' => $parent_id])->all();

        $list = array();

        foreach ($categories as $category) {

            $category->title = str_repeat(' - ', $level) . $category->title;

            $list[$category->id] = $category->title;

            $list = ArrayHelper::merge($list, self::getCategoryListArray($category->id, $level + 1));
        }

        return $list;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'transliterateBehavior' => [
                'class' => TransliterateBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['title' => 'alias'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['title' => 'alias'],
                ]
            ],
            'purifierBehavior' => [
                'class' => PurifierBehavior::className(),
                'textAttributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['title'],
                    ActiveRecord::EVENT_BEFORE_INSERT => ['title'],
                ],
                'purifierOptions' => [
                    'HTML.AllowedElements' => Yii::$app->params['allowHtmlTags']
                ]
            ]
        ];
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
                [['title', 'alias'], 'unique']
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'admin-create' => ['title', 'parent_id', 'status_id'],
            'admin-update' => ['title', 'parent_id', 'status_id'],
        ];
    }
}
