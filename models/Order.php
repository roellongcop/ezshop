<?php

namespace app\models;

use app\widgets\Anchor;
use app\helpers\Html;
use app\helpers\App;
use app\helpers\Url;
use app\widgets\Label;
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

    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_DELIVERY = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_VOID = 5;

    public $shipTo = 'same';
    public $remarks;

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

            [['billing_province_id', 'billing_municipality_id', 'shipping_province_id', 'shipping_municipality_id', 'payment_mode', 'status'], 'integer'],
            [['products', 'remarks'], 'safe'],
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
            ]],
            ['status', 'in', 'range' => [
                self::STATUS_PENDING,
                self::STATUS_PROCESSING,
                self::STATUS_DELIVERY,
                self::STATUS_COMPLETED,
                self::STATUS_CANCELLED,
                self::STATUS_VOID,
            ]],
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

            'billing_firstname' => 'Firstname',
            'billing_lastname' => 'Lastname',
            'billing_email' => 'Email',
            'billing_mobile' => 'Mobile',
            'billing_address1' => 'Address1',
            'billing_address2' => 'Address2',
            'billing_province_id' => 'Province',
            'billing_municipality_id' => 'Municipality',
            'billing_zip' => 'Zip',

            'shipping_firstname' => 'Firstname',
            'shipping_lastname' => 'Lastname',
            'shipping_email' => 'Email',
            'shipping_mobile' => 'Mobile',
            'shipping_address1' => 'Address1',
            'shipping_address2' => 'Address2',
            'shipping_province_id' => 'Province',
            'shipping_municipality_id' => 'Municipality',
            'shipping_zip' => 'Zip',

            'products' => 'Products',
            'subtotal' => 'Subtotal',
            'shipping' => 'Shipping',
            'total' => 'Total',
            'payment_mode' => 'Payment Mode',

            'billingProvinceName' => 'Province',
            'billingMunicipalityName' => 'Municipality',
            'shippingProvinceName' => 'Province',
            'shippingMunicipalityName' => 'Municipality',
            'statusBadge' => 'Status',
        ]);
    }


    public function getOrderLogs()
    {
        return $this->hasMany(OrderLog::class, ['order_id' => 'id']);
    }

    public function getBillingProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'billing_province_id']);
    }

    public function getBillingProvinceName()
    {
        return App::if($this->billingProvince, fn($province) => $province->name);
    }

    public function getBillingProvinceNo()
    {
        return App::if($this->billingProvince, fn($province) => $province->no);
    }

    public function getBillingMunicipality()
    {
        return $this->hasOne(Municipality::class, ['id' => 'billing_municipality_id']);
    }

    public function getBillingMunicipalityName()
    {
        return App::if($this->billingMunicipality, fn($municipality) => $municipality->name);
    }


    public function getShippingProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'shipping_province_id']);
    }

    public function getShippingProvinceName()
    {
        $name = App::if($this->shippingProvince, fn($province) => $province->name);
        return $name ?: $this->billingProvinceName;
    }

    public function getShippingProvinceNo()
    {
        return App::if($this->shippingProvince, fn($province) => $province->no);
    }

    public function getShippingMunicipality()
    {
        return $this->hasOne(Municipality::class, ['id' => 'shipping_municipality_id']);
    }

    public function getShippingMunicipalityName()
    {
        $name = App::if($this->shippingMunicipality, fn($municipality) => $municipality->name);
        return $name ?: $this->billingMunicipalityName;
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
        $behaviors['OrderBehavior'] = [
            'class' => 'app\behaviors\OrderBehavior'
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
            'session_id' => App::session('id'),
            'record_status' => self::RECORD_ACTIVE
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

    public function getCanDelete()
    {
        return false;
    }

    public function getPaymentMode()
    {
        return ($this->payment_mode == self::PAYMENT_COD) ? 'Cash on Delivery': '';
    }

    public function getStatusBadge()
    {
        return Label::widget(['options' => App::params('order_status')[$this->status] ?? '']);
    }

    public function getStatusLabel()
    {
        $data = App::params('order_status')[$this->status] ?? '';

        if (!$data) {
            return;
        }


        return $data['label'] ?? '';
    }

    public function getStatusClass()
    {
        $data = App::params('order_status')[$this->status] ?? '';

        if (!$data) {
            return;
        }


        return $data['class'] ?? '';
    }

    public function getStatusBadgeFront()
    {
        $data = App::params('order_status')[$this->status] ?? '';

        if (!$data) {
            return;
        }


        return Html::tag('label', $data['label'], [
            'class' => 'badge badge-' . $data['class']
        ]);
    }

    public function getShippingAddress1()
    {
        return $this->shipping_address1 ?: $this->billing_address1;
    }


    public function getCancelButton($default='---')
    {
        if ($this->status == self::STATUS_PENDING) {
            return \yii\helpers\Html::a('Cancel', ['site/cancel-order', 'order_no' => $this->order_no],  [
                'class' => 'btn btn-danger btn-sm', 
                'data-confirm' => 'Cancel Order?',
                'data-method' => 'post',
            ]);
        }

        return $default;
    }

    public function process()
    {
        if ($this->status == self::STATUS_PENDING) {
            $this->status = self::STATUS_PROCESSING;
            $this->save();
        }
    }

    public function getChangeStatusMenu()
    {
        $status = [];

        switch ($this->status) {
            case self::STATUS_PROCESSING:
                $status[] = self::STATUS_DELIVERY;
                $status[] = self::STATUS_COMPLETED;
                $status[] = self::STATUS_VOID;
                break;
            
            case self::STATUS_DELIVERY:
                $status[] = self::STATUS_COMPLETED;
                $status[] = self::STATUS_VOID;
                break;

            default:
                // code...
                break;
        }

        $actions = App::foreach($status, function($s) {
            $param = App::params('order_status')[$s];
            return Html::tag('a', $param['label'], [
                'href' => '#',
                'class' => 'dropdown-item',
                'data-status' => $s,
                'data-label' => $param['label'],
            ]);
        });

        return $actions ? <<< HTML
            <div class="dropdown">
                <button class="btn btn-{$this->statusClass} dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {$this->statusLabel}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    {$actions}
                </div>
            </div>
        HTML: '';

        // <a class="dropdown-item" href="#">Action</a>
    }
}