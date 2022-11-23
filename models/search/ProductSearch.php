<?php

namespace app\models\search;

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
    public $price_range;

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
            [['keywords', 'pagination', 'date_range', 'record_status', 'sort', 'sizes', 'price_range', 'colors'], 'safe'],
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
            ->andFilterWhere(['like', 'categories', $this->categories]);


        if ($this->price_range) {
            $where = ['or'];
            foreach ($this->price_range as $price_range) {
                list($from, $to) = explode('-', $price_range);

                $where[] = ['BETWEEN', 'sale_price', $from, $to];
            }

            $query->andFilterWhere($where);
        }

        if ($this->colors) {
            $where = ['or'];
            foreach ($this->colors as $color) {
                $where[] = ['LIKE', 'colors', $color];
            }

            $query->andFilterWhere($where);
        }

        if ($this->sizes) {
            $where = ['or'];
            foreach ($this->sizes as $size) {
                $where[] = ['LIKE', 'sizes', $size];
            }

            $query->andFilterWhere($where);
        }
        
                
        $query->andFilterWhere(['or', 
            ['like', 'name', $this->keywords],  
            ['like', 'categories', $this->keywords],  
            ['like', 'description', $this->keywords],  
            ['like', 'tags', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }

    public function getSortLabel()
    {
        $sort = App::params('product_sorting')[$this->sort] ?? '';

        return $sort ? $sort['label']: 'Sorting';
    }

    public function checkedPriceFilter($from, $to)
    {
        if (!$this->price_range) {
            return '';
        }

        return in_array("{$from}-{$to}", $this->price_range) ? 'checked': '';
    }

    public function checkedColorFilter($color)
    {
        if (!$this->colors) {
            return '';
        }

        return in_array($color, $this->colors) ? 'checked': '';
    }

    public function checkedSizeFilter($size)
    {
        if (!$this->sizes) {
            return '';
        }

        return in_array($size, $this->sizes) ? 'checked': '';
    }
    
}