<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Shipping;
use app\helpers\App;

/**
 * ShippingSearch represents the model behind the search form of `app\models\Shipping`.
 */
class ShippingSearch extends Shipping
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'shipping/_search';
    public $searchAction = ['shipping/index'];
    public $searchLabel = 'Shipping';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'province_id', 'municipality_id', 'created_by', 'updated_by'], 'integer'],
            [['rate'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = Shipping::find()
            ->alias('s')
            ->joinWith(['province p', 'municipality m']);

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        $dataProvider->sort->attributes['provinceName'] = [
            'asc' => ['p.Province' => SORT_ASC],
            'desc' => ['p.Province' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['municipalityName'] = [
            'asc' => ['m.Municipality' => SORT_ASC],
            'desc' => ['m.Municipality' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            's.id' => $this->id,
            's.province_id' => $this->province_id,
            's.municipality_id' => $this->municipality_id,
            's.rate' => $this->rate,
            's.record_status' => $this->record_status,
            's.created_by' => $this->created_by,
            's.updated_by' => $this->updated_by,
            's.created_at' => $this->created_at,
            's.updated_at' => $this->updated_at,
        ]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'p.Province', $this->keywords],  
            ['like', 'm.Municipality', $this->keywords],  
            ['like', 's.rate', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}