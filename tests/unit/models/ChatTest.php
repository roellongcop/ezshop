<?php

namespace tests\unit\models;

use app\models\Chat;

class ChatTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'user_id' => 3,
            'reply_id' => 1,
            'session_id' => '123',
            'message' => 'Message',
            'status' => Chat::ANSWERED,
            'record_status' => Chat::RECORD_ACTIVE
        ], $replace);
    }

    public function testInvalidUserId()
    {
        $data = $this->data(['user_id' => 9999999]);

        $model = new Chat($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testAcceptZeroUserId()
    {
        $data = $this->data(['user_id' => 0]);

        $model = new Chat($data);
        expect_that($model->save());
    }

    public function testInvalidReplyId()
    {
        $data = $this->data(['user_id' => 9999999]);

        $model = new Chat($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testAcceptZeroReplyId()
    {
        $data = $this->data(['user_id' => 0]);

        $model = new Chat($data);
        expect_that($model->save());
    }

    public function testInvalidRStatus()
    {
        $data = $this->data(['status' => 9999999]);

        $model = new Chat($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('status');
    }

    public function testCreateSuccess()
    {
        $model = new Chat($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Chat::RECORD_INACTIVE]);

        $model = new Chat($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Chat();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Chat($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Chat', [
            'record_status' => Chat::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Chat', [
            'record_status' => Chat::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Chat', [
            'record_status' => Chat::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Chat', [
            'record_status' => Chat::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}