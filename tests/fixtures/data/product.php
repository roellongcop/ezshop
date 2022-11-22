<?php

use app\models\Product;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'name' => 'Name',
		'categories' => json_encode(['Categories']),
		'description' => 'Description',
		'specification' => 'specification',
		'tags' => json_encode(['Tags']),
		'image' => 'Image',
		'gallery' => json_encode(['Gallery']),
		'regular_price' => 10,
		'sale_price' => 5,
		'sku' => 'Sku',
		'quantity' => 100,
		'low_stock_threshold' => 5,
		'high_stock_threshold' => 500,
		'stock_threshold_status' => Product::THRESHOLD_SAFE,
		'added_shipping_fee' => 12,
		'token' => 'token1',
		'slug' => 'name',
		'record_status' => Product::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'name' => 'Name2',
	'token' => 'token2',
	'slug' => 'name2',
	'record_status' => Product::RECORD_INACTIVE
]);

return $model->getData();