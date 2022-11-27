<?php

namespace app\models;

use app\widgets\Anchor;

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

    public $same = 1;

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
            [['order_no', 'billing_firstname', 'billing_lastname', 'billing_email', 'billing_mobile', 'billing_address1', 'billing_zip', 'products', 'subtotal', 'shipping', 'total'], 'required'],

            [['shipping_firstname', 'shipping_lastname', 'shipping_email', 'shipping_mobile', 'shipping_address1', 'shipping_zip', 'shipping_province_id', 'shipping_municipality_id'], 'required', 'when' => fn($model) => !$model->same],

            [['billing_province_id', 'billing_municipality_id', 'shipping_province_id', 'shipping_municipality_id', 'payment_mode', 'same'], 'integer'],
            [['products'], 'safe'],
            [['subtotal', 'shipping', 'total'], 'number'],
            [['order_no', 'billing_firstname', 'billing_lastname', 'billing_email', 'billing_mobile', 'billing_address1', 'billing_zip', 'shipping_firstname', 'shipping_lastname', 'shipping_email', 'shipping_mobile', 'shipping_address1', 'shipping_zip'], 'string', 'max' => 255],
            [['order_no'], 'unique'],
            [['billing_email', 'shipping_email'], 'trim'],
            [['billing_email', 'shipping_email'], 'email'],
            ['billing_province_id', 'exist', 'targetRelation' => 'billingProvince'],
            ['billing_municipality_id', 'exist', 'targetRelation' => 'billingMunicipality'],

            ['shipping_province_id', 'exist', 'targetRelation' => 'shippingProvince', 'when' => fn($model) => !$model->same],
            ['shipping_municipality_id', 'exist', 'targetRelation' => 'shippingMunicipality', 'when' => fn($model) => !$model->same],
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
            'billing_province_id' => 'Billing Province ID',
            'billing_municipality_id' => 'Billing Municipality ID',
            'billing_zip' => 'Billing Zip',
            'shipping_firstname' => 'Shipping Firstname',
            'shipping_lastname' => 'Shipping Lastname',
            'shipping_email' => 'Shipping Email',
            'shipping_mobile' => 'Shipping Mobile',
            'shipping_address1' => 'Shipping Address1',
            'shipping_province_id' => 'Shipping Province ID',
            'shipping_municipality_id' => 'Shipping Municipality ID',
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

    public function getBillingMunicipality()
    {
        return $this->hasOne(Province::class, ['id' => 'billing_municipality_id']);
    }

    public function getShippingProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'shipping_province_id']);
    }

    public function getShippingMunicipality()
    {
        return $this->hasOne(Province::class, ['id' => 'shipping_municipality_id']);
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
            'products' => ['attribute' => 'products', 'format' => 'raw'],
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
            'products:raw',
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
}