<?php

namespace alexsers\articles\models\frontend;

use alexsers\articles\models\ArticleTagAssn;
use alexsers\tag\models\Tag;
use Yii;

/**
 * Статьи
 * Class Articles
 * @package alexsers\articles\models\frontend
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
     * Дата создания
     * @var string
     */
    private $_created;

    /**
     * Дата обновления
     * @var string
     */
    private $_updated;

    /**
     * Дата создания
     * @return string
     */
    public function getCreated()
    {
        if ($this->_created === null) {
            $this->_created = Yii::$app->formatter->asDate($this->created_at);
        }
        return $this->_created;
    }

    /**
     * Дата обновления
     * @return string
     */
    public function getUpdated()
    {
        if ($this->_updated === null) {
            $this->_updated = Yii::$app->formatter->asDate($this->updated_at);
        }
        return $this->_updated;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['title', 'snippet', 'content'];
        $scenarios['update'] = ['title', 'snippet', 'content'];

        return $scenarios;
    }

    /**
     * Update views counter.
     *
     * @return boolean Whether views counter was updated or not
     */
    public function updateViews()
    {
        return $this->updateCounters(['views' => 1]);
    }



    public static function getTagAlias($tag)
    {
        $tagId = Tag::find()->where(['alias' => $tag])->one();
        $articleId = ArticleTagAssn::find()->where(['tag_id' => $tagId['id']])->all();

        $array=[];

        foreach($articleId as $id)
        {
            array_push($array, $id['article_id']);
        }

        return $array;
    }
}
