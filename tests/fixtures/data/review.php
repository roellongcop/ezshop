<?php

use app\models\Review;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'product_id' => 1,
		'user_id' => 4,
		'score' => 5,
		'name' => 'Name',
		'email' => 'test@email.com',
		'review' => 'Review',
		'record_status' => Review::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Review::RECORD_INACTIVE
]);

return $model->getData();