<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Review;
use app\helpers\App;

/**
 * ReviewSearch represents the model behind the search form of `app\models\Review`.
 */
class ReviewSearch extends Review
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'review/_search';
    public $searchAction = ['review/index'];
    public $searchLabel = 'Review';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'user_id', 'score', 'created_by', 'updated_by'], 'integer'],
            [['name', 'email', 'review', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status'], 'safe'],
            [['keywords'], 'trim'],
        ];
    }

    public function init()
    {
        $this->pagination = App::setting('system')->pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return \yii\base\Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Review::find()
            ->alias('r')
            ->joinWith('product p');

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        $dataProvider->sort->attributes['productName'] = [
            'asc' => ['p.name' => SORT_ASC],
            'desc' => ['p.name' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'r.id' => $this->id,
            'r.product_id' => $this->product_id,
            'r.user_id' => $this->user_id,
            'r.score' => $this->score,
            'r.record_status' => $this->record_status,
            'r.created_by' => $this->created_by,
            'r.updated_by' => $this->updated_by,
            'r.created_at' => $this->created_at,
            'r.updated_at' => $this->updated_at,
        ]);
        
        // $query->andFilterWhere(['like', 'r.name', $this->name])
        //     ->andFilterWhere(['like', 'r.email', $this->email])
        //     ->andFilterWhere(['like', 'r.review', $this->review]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'p.name', $this->keywords],  
            // ['like', 'r.user_id', $this->keywords],  
            // ['like', 'r.score', $this->keywords],  
            // ['like', 'r.name', $this->keywords],  
            // ['like', 'r.email', $this->keywords],  
            ['like', 'r.review', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}