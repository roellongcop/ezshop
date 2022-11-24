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
        $query = Review::find();

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'score' => $this->score,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'review', $this->review]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'product_id', $this->keywords],  
            ['like', 'user_id', $this->keywords],  
            ['like', 'score', $this->keywords],  
            ['like', 'name', $this->keywords],  
            ['like', 'email', $this->keywords],  
            ['like', 'review', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}