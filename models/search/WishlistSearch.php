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
        $query = Wishlist::find();

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
            'product_id' => $this->product_id,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'user_id', $this->keywords],  
            ['like', 'product_id', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}