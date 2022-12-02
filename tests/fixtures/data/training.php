<?php

use app\models\Training;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'query' => 'Query',
		'intent' => 'Intent',
		'response' => json_encode(['Response']),
		'suggestion' => 'Suggestion',
		'record_status' => Training::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'query' => 'Query2',
	'record_status' => Training::RECORD_INACTIVE
]);

return $model->getData();