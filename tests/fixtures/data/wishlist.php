<?php

use app\models\Wishlist;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'user_id' => 1,
		'product_id' => 1,
		'record_status' => Wishlist::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Wishlist::RECORD_INACTIVE
]);

return $model->getData();