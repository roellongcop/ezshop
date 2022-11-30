<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Chat;
use app\helpers\App;

/**
 * ChatSearch represents the model behind the search form of `app\models\Chat`.
 */
class ChatSearch extends Chat
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'chat/_search';
    public $searchAction = ['chat/index'];
    public $searchLabel = 'Chat';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'reply_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['session_id', 'message', 'created_at', 'updated_at'], 'safe'],
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
        $query = Chat::find();

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
            'user_id' => $this->user_id,
            'reply_id' => $this->reply_id,
            'status' => $this->status,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'session_id', $this->session_id])
            ->andFilterWhere(['like', 'message', $this->message]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'user_id', $this->keywords],  
            ['like', 'reply_id', $this->keywords],  
            ['like', 'session_id', $this->keywords],  
            ['like', 'message', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}