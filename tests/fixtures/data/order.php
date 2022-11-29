<?php

use app\models\Order;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'order_no' => '111',
		'billing_firstname' => 'Billing Firstname',
		'billing_lastname' => 'Billing Lastname',
		'billing_email' => 'billing@email.com',
		'billing_mobile' => 'Billing Mobile',
		'billing_address1' => 'Billing Address1',
		'billing_province_id' => 1,
		'billing_municipality_id' => 1,
		'billing_zip' => 'Billing Zip',
		'shipping_firstname' => 'Shipping Firstname',
		'shipping_lastname' => 'Shipping Lastname',
		'shipping_email' => 'shipping@email.com',
		'shipping_mobile' => 'Shipping Mobile',
		'shipping_address1' => 'Shipping Address1',
		'shipping_province_id' => 1,
		'shipping_municipality_id' => 1,
		'shipping_zip' => 'Shipping Zip',
		'products' => json_encode([
			[
				'product_id' => 1, 
				'quantity' => 1, 
				'price' => 1, 
				'added_shipping_fee' => 1,
				'color' => 'color', 
				'size' => 'size', 
				'name' => 'name'
			]
		]),
		'subtotal' => 2,
		'shipping' => 1,
		'total' => 3,
		'status' => Order::STATUS_PENDING,
		'payment_mode' => Order::PAYMENT_COD,
		'record_status' => Order::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'order_no' => '222',
	'record_status' => Order::RECORD_INACTIVE
]);

return $model->getData();