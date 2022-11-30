<?php

use app\models\Chat;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'user_id' => 3,
		'reply_id' => 1,
		'session_id' => '123',
		'message' => 'Message',
		'status' => Chat::ANSWERED,
		'record_status' => Chat::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Chat::RECORD_INACTIVE
]);

return $model->getData();