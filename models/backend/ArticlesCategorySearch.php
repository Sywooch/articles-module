<?php

namespace alexsers\articles\models\backend;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Поиск для модели ArticlesCategory
 * Class ArticlesCategorySearch
 * @package alexsers\articles\models\backend
 */
class ArticlesCategorySearch extends ArticlesCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'status_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'alias'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Для поиска
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticlesCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}
