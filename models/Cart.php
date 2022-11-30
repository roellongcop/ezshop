<?php

namespace app\models;

use app\helpers\App;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\widgets\Anchor;
use app\models\form\user\BillingDetailForm;

/**
 * This is the model class for table "{{%carts}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string|null $color
 * @property string|null $size
 * @property int|null $quantity
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Cart extends ActiveRecord
{
    const CART_ACTIVE = 1;
    const CART_ORDERED = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%carts}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'cart',
            'mainAttribute' => 'id',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['product_id', 'user_id', 'quantity'], 'required'],
            [['product_id', 'user_id', 'quantity'], 'integer'],
            [['color', 'size', 'session_id'], 'string', 'max' => 255],
            ['product_id', 'exist', 'targetRelation' => 'product'],
            ['user_id', 'exist', 'targetRelation' => 'user'],
            [['product_id', 'quantity'], 'validateQuantity'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'color' => 'Color',
            'size' => 'Size',
            'quantity' => 'Quantity',
        ]);
    }

    public function validateQuantity($attribute, $params)
    {
        if (($product = $this->product) != null) {
            if ($this->quantity > $product->quantity) {
                $this->addError($attribute, 'Product quantity is less than cart quantity');
            }
        }
    }

    public function getProductQuantity()
    {
        return App::ifElse($this->product, fn($model) => $model->quantity, 0);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\CartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CartQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'product_id' => [
                'attribute' => 'product_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->product_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'user_id' => ['attribute' => 'user_id', 'format' => 'raw'],
            'color' => ['attribute' => 'color', 'format' => 'raw'],
            'size' => ['attribute' => 'size', 'format' => 'raw'],
            'quantity' => ['attribute' => 'quantity', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'product_id:raw',
            'user_id:raw',
            'color:raw',
            'size:raw',
            'quantity:raw',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getProductName()
    {
        return App::if($this->product, fn($product) => $product->name);
    }

    public function getProductRegularPrice()
    {
        return App::if($this->product, fn($product) => $product->regular_price);
    }

    public function getProductSalePrice()
    {
        return App::if($this->product, fn($product) => $product->sale_price);
    }

    public function getProductImage($w=50)
    {
        return App::if($this->product, fn($product) => Html::image($product->image, ['w' => $w]));
    }

    public function getProductView($w=50)
    {
        return App::if($this->product, fn($product) => $product->getProductView($w));
    }


    public function getProductFrontendUrl()
    {
        return App::if($this->product, fn($product) => $product->frontendUrl);
    }

    public static function findByKeywords($keywords='', $attributes='', $limit=10, $andFilterWhere=[])
    {
        return parent::findByKeywordsData($attributes, function($attribute) use($keywords, $limit, $andFilterWhere) {
            return self::find()
                ->select("{$attribute} AS data")
                ->alias('c')
                ->joinWith('product p')
                ->groupBy($attribute)
                ->where(['LIKE', $attribute, $keywords])
                ->andFilterWhere($andFilterWhere)
                ->limit($limit)
                ->asArray()
                ->all();
        });
    }

    public function getProductTableView()
    {
         return  implode('<br>', array_filter([
            YiiHtml::a($this->productName, $this->productFrontendUrl, ['class' => 'text-dark']),
            Html::tag('small', implode(' | ', array_filter([$this->color, $this->size])), ['class' => 'text-muted font-weight-bold'])
        ]));
    }

    public function getProductTableViewWithQuantity()
    {
         return  implode('<br>', array_filter([
            YiiHtml::a($this->productName . ' (x' . $this->quantity . ')', $this->productFrontendUrl, ['class' => 'text-dark', 'target' => '_blank']),
            Html::tag('small', implode(' | ', array_filter([$this->color, $this->size])), ['class' => 'text-muted font-weight-bold'])
        ]));
    }

    public function getProductDisplayPrice()
    {
        if (($product = $this->product) != null) {
            if ($product->isOnSale) {
                return Html::tag('span', App::formatter()->asPeso($product->sale_price) . ' ('.Html::tag('small', App::formatter()->asPeso($product->regular_price), ['class' => 'line-through text-muted font-weight-bold']).')');
            }
            else {
                return App::formatter()->asPeso($product->sale_price);
            }
        }
    }

    public function getTotal()
    {
        return $this->productSalePrice  *  $this->quantity;
    }

    public static function subtotal()
    {
        $carts = self::findAll([
            'user_id' => App::identity('id'),
            'session_id' => App::session('id'),
            'record_status' => self::RECORD_ACTIVE
        ]);

        $totals = App::foreach($carts, fn($cart) => $cart->total, false);

        return $totals ? array_sum($totals): 0;
    }

    public function getAddedShipping()
    {
        return App::if($this->product, fn($product) => $product->added_shipping_fee);
    }

    public static function shipping($province_id='', $municipality_id='')
    {
        $total = App::setting('shipping')->flat_rate;

        $billing = new BillingDetailForm(['user_id' => App::identity('id')]);

        $shipping = Shipping::findOne([
            'province_id' => $province_id ?: $billing->province_id,
            'municipality_id' => $municipality_id ?: $billing->city_id,
            'record_status' => Shipping::RECORD_ACTIVE
        ]);

        if ($shipping) {
            $total += $shipping->rate;
        }

        $carts = self::findAll([
            'user_id' => App::identity('id'),
            'session_id' => App::session('id'),
            'record_status' => self::RECORD_ACTIVE
        ]);

        $addedShipping = App::foreach($carts, fn($cart) => $cart->addedShipping, false);

        if ($addedShipping) {
            $total += array_sum($addedShipping);
        }

        return $total;
    }

    public static function clear()
    {
        self::updateAll(['record_status' => self::RECORD_INACTIVE], [
            'user_id' => App::identity('id'),
            'session_id' => App::session('id'),
        ]);
    }
}