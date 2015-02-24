<?php

namespace alexsers\articles\models;

use creocoder\taggable\TaggableQueryBehavior;
use yii\db\ActiveQuery;

/**
 * Class ArticleQuery
 */
class ArticlesQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
    /**
     * Select published posts.
     *
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['status_id' => Articles::STATUS_PUBLISHED]);

        return $this;
    }

    /**
     * Select unpublished posts.
     *
     * @return $this
     */
    public function unpublished()
    {
        $this->andWhere(['status_id' => Articles::STATUS_UNPUBLISHED]);

        return $this;
    }


    public function category($category)
    {
        $this->andWhere(['category_id' => $category]);

        return $this;
    }

    public function tag($articleId)
    {
        $this->andWhere(['id'=>$articleId]);

        return $this;
    }
}
