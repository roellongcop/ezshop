<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Wishlist;
use app\helpers\App;

/**
 * WishlistSearch represents the model behind the search form of `app\models\Wishlist`.
 */
class WishlistSearch extends Wishlist
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'wishlist/_search';
    public $searchAction = ['wishlist/index'];
    public $searchLabel = 'Wishlist';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_id', 'created_by', 'updated_by'], 'integer'],
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
        $query = Wishlist::find()
            ->alias('w')
            ->groupBy('w.id')
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

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'w.id' => $this->id,
            'w.user_id' => $this->user_id,
            'w.product_id' => $this->product_id,
            'w.record_status' => $this->record_status,
            'w.created_by' => $this->created_by,
            'w.updated_by' => $this->updated_by,
            'w.created_at' => $this->created_at,
            'w.updated_at' => $this->updated_at,
        ]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'p.name', $this->keywords],  
            ['like', 'p.regular_price', $this->keywords],  
            ['like', 'p.sale_price', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}