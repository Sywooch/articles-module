<?php

namespace alexsers\articles\models\backend;

use yii\data\ActiveDataProvider;

/**
 * Поиск для модели Articles
 * Class ArticlesSearch
 * @package backend\models\search
 */
class ArticlesSearch extends Articles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Integer
            ['id', 'integer'],
            // String
            [['snippet', 'content'], 'string'],
            [['title', 'alias'], 'string', 'max' => 255],
            // Status
            ['status_id', 'in', 'range' => array_keys(self::getStatusArray())],
            // Date
            [['created_at', 'updated_at'], 'date', 'format' => 'd.m.Y']
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params Search params
     *
     * @return ActiveDataProvider DataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'category_id' => $this->category_id,
                'status_id' => $this->status_id,
                'author_id' => $this->author_id,
            ]
        );

        $query->andFilterWhere(['like', 'alias', $this->alias]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
