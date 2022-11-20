<?php

namespace app\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Product;
use app\helpers\App;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $sort;

    public $searchTemplate = 'product/_search';
    public $searchAction = ['product/index'];
    public $searchLabel = 'Product';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantity', 'low_stock_threshold', 'high_stock_threshold', 'stock_threshold_status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'categories', 'description', 'tags', 'image', 'gallery', 'sku', 'token', 'slug', 'created_at', 'updated_at'], 'safe'],
            [['regular_price', 'sale_price', 'added_shipping_fee'], 'number'],
            [['keywords', 'pagination', 'date_range', 'record_status', 'sort'], 'safe'],
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
        $query = Product::find();

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
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'quantity' => $this->quantity,
            'low_stock_threshold' => $this->low_stock_threshold,
            'high_stock_threshold' => $this->high_stock_threshold,
            'stock_threshold_status' => $this->stock_threshold_status,
            'added_shipping_fee' => $this->added_shipping_fee,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'categories', $this->categories])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'gallery', $this->gallery])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'slug', $this->slug]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'name', $this->keywords],  
            ['like', 'categories', $this->keywords],  
            ['like', 'description', $this->keywords],  
            ['like', 'tags', $this->keywords],  
            ['like', 'image', $this->keywords],  
            ['like', 'gallery', $this->keywords],  
            ['like', 'regular_price', $this->keywords],  
            ['like', 'sale_price', $this->keywords],  
            ['like', 'sku', $this->keywords],  
            ['like', 'token', $this->keywords],  
            ['like', 'slug', $this->keywords],  
            ['like', 'quantity', $this->keywords],  
            ['like', 'low_stock_threshold', $this->keywords],  
            ['like', 'high_stock_threshold', $this->keywords],  
            ['like', 'stock_threshold_status', $this->keywords],  
            ['like', 'added_shipping_fee', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }

    public function getSortLabel()
    {
        $sort = App::params('product_sorting')[$this->sort] ?? '';

        return $sort ? $sort['label']: 'Sorting';
    }
}