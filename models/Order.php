<?php

namespace app\models;

use app\widgets\Anchor;
use app\helpers\App;
use app\helpers\Url;
use app\helpers\StringHelper;
use app\helpers\ArrayHelper;
use app\models\form\user\BillingDetailForm;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property string $order_no
 * @property string $billing_firstname
 * @property string $billing_lastname
 * @property string $billing_email
 * @property string $billing_mobile
 * @property string $billing_address1
 * @property int $billing_province_id
 * @property int $billing_municipality_id
 * @property string $billing_zip
 * @property string $shipping_firstname
 * @property string $shipping_lastname
 * @property string $shipping_email
 * @property string $shipping_mobile
 * @property string $shipping_address1
 * @property int $shipping_province_id
 * @property int $shipping_municipality_id
 * @property string $shipping_zip
 * @property string $products
 * @property float $subtotal
 * @property float $shipping
 * @property float $total
 * @property int $payment_mode
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Order extends ActiveRecord
{
    const PAYMENT_COD = 0;

    public $shipTo = 'same';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'order',
            'mainAttribute' => 'order_no',
            'paramName' => 'order_no',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['billing_firstname', 'billing_lastname', 'billing_email', 'billing_mobile', 'billing_address1', 'billing_zip', 'products', 'subtotal', 'shipping', 'total', 'billing_province_id', 'billing_municipality_id', 'shipTo'], 'required'],

            [['shipping_firstname', 'shipping_lastname', 'shipping_email', 'shipping_mobile', 'shipping_address1', 'shipping_zip', 'shipping_province_id', 'shipping_municipality_id'], 'required', 'when' => fn($model) => $model->shipTo != 'same', 'enableClientValidation' => false],

            [['billing_province_id', 'billing_municipality_id', 'shipping_province_id', 'shipping_municipality_id', 'payment_mode'], 'integer'],
            [['products'], 'safe'],
            [['subtotal', 'shipping', 'total'], 'number'],
            [['order_no', 'billing_firstname', 'billing_lastname', 'billing_email', 'billing_mobile', 'billing_address1', 'billing_address2', 'billing_zip', 'shipping_firstname', 'shipping_lastname', 'shipping_email', 'shipping_mobile', 'shipping_address1', 'shipping_address2', 'shipping_zip', 'shipTo'], 'string', 'max' => 255],

            [['order_no'], 'unique'],

            [['billing_email', 'shipping_email'], 'trim'],
            [['billing_email', 'shipping_email'], 'email'],

            ['billing_province_id', 'exist', 'targetRelation' => 'billingProvince'],
            ['billing_municipality_id', 'exist', 'targetRelation' => 'billingMunicipality'],

            ['shipping_province_id', 'exist', 'targetRelation' => 'shippingProvince', 'when' => fn($model) => $model->shipTo != 'same'],
            ['shipping_municipality_id', 'exist', 'targetRelation' => 'shippingMunicipality', 'when' => fn($model) => $model->shipTo != 'same'],

            ['shipTo', 'in', 'range' => [
                'same',
                'different'
            ]]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'order_no' => 'Order No',

            'billing_firstname' => 'Billing Firstname',
            'billing_lastname' => 'Billing Lastname',
            'billing_email' => 'Billing Email',
            'billing_mobile' => 'Billing Mobile',
            'billing_address1' => 'Billing Address1',
            'billing_province_id' => 'Billing Province',
            'billing_municipality_id' => 'Billing Municipality',
            'billing_zip' => 'Billing Zip',

            'shipping_firstname' => 'Shipping Firstname',
            'shipping_lastname' => 'Shipping Lastname',
            'shipping_email' => 'Shipping Email',
            'shipping_mobile' => 'Shipping Mobile',
            'shipping_address1' => 'Shipping Address1',
            'shipping_province_id' => 'Shipping Province',
            'shipping_municipality_id' => 'Shipping Municipality',
            'shipping_zip' => 'Shipping Zip',

            'products' => 'Products',
            'subtotal' => 'Subtotal',
            'shipping' => 'Shipping',
            'total' => 'Total',
            'payment_mode' => 'Payment Mode',
        ]);
    }

    public function getBillingProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'billing_province_id']);
    }

    public function getBillingProv()
    {
        return App::if($this->billingProvince, fn($province) => $province->prov);
    }

    public function getBillingMunicipality()
    {
        return $this->hasOne(Municipality::class, ['id' => 'billing_municipality_id']);
    }

    public function getShippingProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'shipping_province_id']);
    }

    public function getShippingProv()
    {
        return App::if($this->shippingProvince, fn($province) => $province->prov);
    }

    public function getShippingMunicipality()
    {
        return $this->hasOne(Municipality::class, ['id' => 'shipping_municipality_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\OrderQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'order_no' => [
                'attribute' => 'order_no', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->order_no,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'billing_firstname' => ['attribute' => 'billing_firstname', 'format' => 'raw'],
            'billing_lastname' => ['attribute' => 'billing_lastname', 'format' => 'raw'],
            'billing_email' => ['attribute' => 'billing_email', 'format' => 'raw'],
            'billing_mobile' => ['attribute' => 'billing_mobile', 'format' => 'raw'],
            'billing_address1' => ['attribute' => 'billing_address1', 'format' => 'raw'],
            'billing_province_id' => ['attribute' => 'billing_province_id', 'format' => 'raw'],
            'billing_municipality_id' => ['attribute' => 'billing_municipality_id', 'format' => 'raw'],
            'billing_zip' => ['attribute' => 'billing_zip', 'format' => 'raw'],
            'shipping_firstname' => ['attribute' => 'shipping_firstname', 'format' => 'raw'],
            'shipping_lastname' => ['attribute' => 'shipping_lastname', 'format' => 'raw'],
            'shipping_email' => ['attribute' => 'shipping_email', 'format' => 'raw'],
            'shipping_mobile' => ['attribute' => 'shipping_mobile', 'format' => 'raw'],
            'shipping_address1' => ['attribute' => 'shipping_address1', 'format' => 'raw'],
            'shipping_province_id' => ['attribute' => 'shipping_province_id', 'format' => 'raw'],
            'shipping_municipality_id' => ['attribute' => 'shipping_municipality_id', 'format' => 'raw'],
            'shipping_zip' => ['attribute' => 'shipping_zip', 'format' => 'raw'],
            'products' => ['attribute' => 'products', 'format' => 'jsonEditor'],
            'subtotal' => ['attribute' => 'subtotal', 'format' => 'raw'],
            'shipping' => ['attribute' => 'shipping', 'format' => 'raw'],
            'total' => ['attribute' => 'total', 'format' => 'raw'],
            'payment_mode' => ['attribute' => 'payment_mode', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'order_no:raw',
            'billing_firstname:raw',
            'billing_lastname:raw',
            'billing_email:raw',
            'billing_mobile:raw',
            'billing_address1:raw',
            'billing_province_id:raw',
            'billing_municipality_id:raw',
            'billing_zip:raw',
            'shipping_firstname:raw',
            'shipping_lastname:raw',
            'shipping_email:raw',
            'shipping_mobile:raw',
            'shipping_address1:raw',
            'shipping_province_id:raw',
            'shipping_municipality_id:raw',
            'shipping_zip:raw',
            'products:jsonEditor',
            'subtotal:raw',
            'shipping:raw',
            'total:raw',
            'payment_mode:raw',
        ];
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'products', 
        ];

        return $behaviors;
    }

    public function bindBillingDetails()
    {
        $billing = new BillingDetailForm(['user_id' => App::identity('id')]);

        $this->billing_firstname = $billing->first_name;
        $this->billing_lastname = $billing->last_name;
        $this->billing_email = $billing->email;
        $this->billing_mobile = $billing->phone;
        $this->billing_address1 = $billing->street;
        $this->billing_zip = $billing->zip;
        $this->billing_municipality_id = $billing->city_id;
        $this->billing_province_id = $billing->province_id;
    }

    public function bindProducts()
    {
        $carts = Cart::findAll([
            'user_id' => App::identity("id"),
            'session_id' => App::session('id')
        ]);

        $products = App::foreach($carts, function($cart) {
            return [
                'product_id' => $cart->product_id, 
                'quantity' => $cart->quantity, 
                'price' => $cart->productSalePrice, 
                'added_shipping_fee' => $cart->addedShipping,
                'color' => $cart->color, 
                'size' => $cart->size, 
                'name' => $cart->productName, 
                'productTableViewWithQuantity' => $cart->productTableViewWithQuantity, 
                
            ];
        }, false);

        $this->products = $products ?: [];
    }


    public function setTheTotal()
    {
        $this->total = $this->subtotal + $this->shipping;
    }

    public function generateOrderNo()
    {
        $total = self::find()->count();
        $order_no = implode('-', [str_pad($total + 1, 7, "0", STR_PAD_LEFT), time()]);

        if (self::find()->where(['order_no' => $order_no])->exists()) {
            return $this->generateOrderNo();
        }

        return $order_no;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->shipTo == 'same') {
            $this->shipping = Cart::shipping($this->billing_province_id, $this->billing_municipality_id);
        }
        else {
            $this->shipping = Cart::shipping($this->shipping_province_id, $this->shipping_municipality_id);
        }

        $this->setTheTotal();

        $this->order_no = $this->generateOrderNo();

        return true;
    }

    public function getBillingFullname()
    {
        return implode(' ', [
            $this->billing_firstname,
            $this->billing_lastname,
        ]);
    }

    public function getTotalProducts()
    {
        if ($this->products && is_countable($this->products)) {
            return number_format(count($this->products));
        }
    }

    public function getFormattedTotal()
    {
        return App::formatter()->asPeso($this->total);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $roles = [
                Role::DEVELOPER,
                Role::SUPERADMIN,
                Role::ADMIN,
            ];

            if (($users = User::findAll(['role_id' => $roles])) != null) {
                foreach ($users as $user) {
                    $notification = new Notification([
                        'status' => Notification::STATUS_UNREAD,
                        'record_status' => Notification::RECORD_ACTIVE,
                        'user_id' => $user->id,
                        'type' => Notification::TYPE_NEW_ORDER,
                        'link' => $this->getViewUrl(false, true),
                        'message' => "New ordered by {$this->billingFullname} with a total price of {$this->formattedTotal}",
                    ]);
                    $notification->save();
                }
            }

            $this->refresh();
            if ($this->products) {
                $data = ArrayHelper::map($this->products, 'product_id', 'quantity');
                
                if (($products = Product::findAll(array_keys($data))) != null) {
                    foreach ($products as $product) {

                        $quantity = $data[$product->id] ?? false;

                        if ($quantity !== false) {
                            $product->quantity = $product->quantity - $quantity;
                            $product->quantity = $product->quantity > 0 ? $product->quantity: 0;
                            $product->save();
                        }
                    }
                }
            }
        }
    }

    public function getViewUrl($fullpath=true, $force = false)
    {
        if ($this->checkLinkAccess('view') || $force) {
            $paramName = $this->paramName();
            $url = [
                implode('/', [$this->controllerID(), 'view']),
                $paramName => $this->{$paramName}
            ];
            return Url::toRoute($url, $fullpath);
        }
    }
}