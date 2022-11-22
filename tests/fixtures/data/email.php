<?php

use app\models\Email;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'name' => 'Name',
		'email' => 'sample@email.com',
		'subject' => 'Subject',
		'message' => 'Message',
		'record_status' => Email::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Email::RECORD_INACTIVE
]);

return $model->getData();