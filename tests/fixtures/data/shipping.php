<?php

use app\models\Shipping;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'province_id' => 1,
		'municipality_id' => 1,
		'rate' => 100,
		'record_status' => Shipping::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'municipality_id' => 2,
	'record_status' => Shipping::RECORD_INACTIVE
]);

return $model->getData();