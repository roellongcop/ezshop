<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Training;
use app\helpers\App;

/**
 * TrainingSearch represents the model behind the search form of `app\models\Training`.
 */
class TrainingSearch extends Training
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'training/_search';
    public $searchAction = ['training/index'];
    public $searchLabel = 'Training';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['query', 'intent', 'response', 'suggestion', 'created_at', 'updated_at'], 'safe'],
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
        $query = Training::find();

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
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'query', $this->query])
            ->andFilterWhere(['like', 'intent', $this->intent])
            ->andFilterWhere(['like', 'response', $this->response])
            ->andFilterWhere(['like', 'suggestion', $this->suggestion]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'query', $this->keywords],  
            ['like', 'intent', $this->keywords],  
            ['like', 'response', $this->keywords],  
            ['like', 'suggestion', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}