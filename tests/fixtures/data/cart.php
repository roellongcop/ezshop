<?php

use app\models\Cart;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'product_id' => 1,
		'user_id' => 1,
		'session_id' => 1,
		'color' => 'Color',
		'size' => 'Size',
		'quantity' => 1,
		'record_status' => Cart::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'user_id' => 4,
	'record_status' => Cart::RECORD_INACTIVE
]);

return $model->getData();