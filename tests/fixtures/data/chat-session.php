<?php

use app\models\ChatSession;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'session_id' => 'Session ID',
		'status' => 'Status',
		'record_status' => ChatSession::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => ChatSession::RECORD_INACTIVE
]);

return $model->getData();