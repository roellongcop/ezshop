<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Order;
use app\helpers\App;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'order/_search';
    public $searchAction = ['order/index'];
    public $searchLabel = 'Order';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'billing_province_id', 'billing_municipality_id', 'shipping_province_id', 'shipping_municipality_id', 'payment_mode', 'created_by', 'updated_by'], 'integer'],
            [['order_no', 'billing_firstname', 'billing_lastname', 'billing_email', 'billing_mobile', 'billing_address1', 'billing_zip', 'shipping_firstname', 'shipping_lastname', 'shipping_email', 'shipping_mobile', 'shipping_address1', 'shipping_zip', 'products', 'created_at', 'updated_at'], 'safe'],
            [['subtotal', 'shipping', 'total'], 'number'],
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
        $query = Order::find();

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        $dataProvider->sort->attributes['products'] = [
            'asc' => ['LENGTH(products)' => SORT_ASC],
            'desc' => ['LENGTH(products)' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'billing_province_id' => $this->billing_province_id,
            'billing_municipality_id' => $this->billing_municipality_id,
            'shipping_province_id' => $this->shipping_province_id,
            'shipping_municipality_id' => $this->shipping_municipality_id,
            'subtotal' => $this->subtotal,
            'shipping' => $this->shipping,
            'total' => $this->total,
            'payment_mode' => $this->payment_mode,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'billing_firstname', $this->billing_firstname])
            ->andFilterWhere(['like', 'billing_lastname', $this->billing_lastname])
            ->andFilterWhere(['like', 'billing_email', $this->billing_email])
            ->andFilterWhere(['like', 'billing_mobile', $this->billing_mobile])
            ->andFilterWhere(['like', 'billing_address1', $this->billing_address1])
            ->andFilterWhere(['like', 'billing_zip', $this->billing_zip])
            ->andFilterWhere(['like', 'shipping_firstname', $this->shipping_firstname])
            ->andFilterWhere(['like', 'shipping_lastname', $this->shipping_lastname])
            ->andFilterWhere(['like', 'shipping_email', $this->shipping_email])
            ->andFilterWhere(['like', 'shipping_mobile', $this->shipping_mobile])
            ->andFilterWhere(['like', 'shipping_address1', $this->shipping_address1])
            ->andFilterWhere(['like', 'shipping_zip', $this->shipping_zip])
            ->andFilterWhere(['like', 'products', $this->products]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'order_no', $this->keywords],  
            ['like', 'billing_firstname', $this->keywords],  
            ['like', 'billing_lastname', $this->keywords],  
            ['like', 'billing_email', $this->keywords],  
            ['like', 'billing_mobile', $this->keywords],  
            ['like', 'billing_address1', $this->keywords],  
            ['like', 'billing_province_id', $this->keywords],  
            ['like', 'billing_municipality_id', $this->keywords],  
            ['like', 'billing_zip', $this->keywords],  
            ['like', 'shipping_firstname', $this->keywords],  
            ['like', 'shipping_lastname', $this->keywords],  
            ['like', 'shipping_email', $this->keywords],  
            ['like', 'shipping_mobile', $this->keywords],  
            ['like', 'shipping_address1', $this->keywords],  
            ['like', 'shipping_province_id', $this->keywords],  
            ['like', 'shipping_municipality_id', $this->keywords],  
            ['like', 'shipping_zip', $this->keywords],  
            ['like', 'products', $this->keywords],  
            ['like', 'subtotal', $this->keywords],  
            ['like', 'shipping', $this->keywords],  
            ['like', 'total', $this->keywords],  
            ['like', 'payment_mode', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}