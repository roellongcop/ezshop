<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Cart;
use app\helpers\App;

/**
 * CartSearch represents the model behind the search form of `app\models\Cart`.
 */
class CartSearch extends Cart
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'cart/_search';
    public $searchAction = ['cart/index'];
    public $searchLabel = 'Product';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'user_id', 'quantity', 'created_by', 'updated_by'], 'integer'],
            [['color', 'size', 'created_at', 'updated_at', 'session_id'], 'safe'],
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
        $query = Cart::find()
            ->alias('c')
            ->joinWith(['product p', 'user u']);

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        $dataProvider->sort->attributes['userEmail'] = [
            'asc' => ['u.email' => SORT_ASC],
            'desc' => ['u.email' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['productName'] = [
            'asc' => ['p.name' => SORT_ASC],
            'desc' => ['p.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['productRegularPrice'] = [
            'asc' => ['p.regular_price' => SORT_ASC],
            'desc' => ['p.regular_price' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['productSalePrice'] = [
            'asc' => ['p.sale_price' => SORT_ASC],
            'desc' => ['p.sale_price' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['total'] = [
            'asc' => ['(p.sale_price * c.quantity)' => SORT_ASC],
            'desc' => ['(p.sale_price * c.quantity)' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'c.id' => $this->id,
            'c.product_id' => $this->product_id,
            'c.user_id' => $this->user_id,
            'c.session_id' => $this->session_id,
            'c.quantity' => $this->quantity,
            'c.record_status' => $this->record_status,
            'c.created_by' => $this->created_by,
            'c.updated_by' => $this->updated_by,
            'c.created_at' => $this->created_at,
            'c.updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['or', 
            ['like', 'c.color', $this->keywords],  
            ['like', 'c.size', $this->keywords],  
            ['like', 'c.quantity', $this->keywords],  
            ['like', 'p.name', $this->keywords],  
            ['like', 'p.regular_price', $this->keywords],  
            ['like', 'p.sale_price', $this->keywords],  
            ['like', 'u.email', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}