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
            [['id', 'user_id', 'reply_id', 'created_by', 'updated_by'], 'integer'],
            [['session_id', 'message', 'created_at', 'updated_at', 'status', 'type'], 'safe'],
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
        $query = Chat::find()
            ->alias('c')
            ->joinWith(['user u']);

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);


        $dataProvider->sort->attributes['totalPerSession'] = [
            'asc' => ['(SELECT COUNT("*") WHERE `c`.`session_id` = `c`.`session_id`)' => SORT_ASC],
            'desc' => ['(SELECT COUNT("*") WHERE `c`.`session_id` = `c`.`session_id`)' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['userEmail'] = [
            'asc' => ['u.email' => SORT_ASC],
            'desc' => ['u.email' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'c.id' => $this->id,
            'c.user_id' => $this->user_id,
            'c.reply_id' => $this->reply_id,
            'c.status' => $this->status,
            'c.type' => $this->type,
            'c.record_status' => $this->record_status,
            'c.created_by' => $this->created_by,
            'c.updated_by' => $this->updated_by,
            'c.created_at' => $this->created_at,
            'c.updated_at' => $this->updated_at,
            'c.message' => $this->message,
        ]);


        $query->andFilterWhere(['or', 
            // ['like', 'c.user_id', $this->keywords],  
            // ['like', 'c.reply_id', $this->keywords],  
            ['like', 'c.session_id', $this->keywords],  
            ['like', 'c.message', $this->keywords],  
            ['like', 'u.email', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}