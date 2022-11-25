<?php

namespace tests\unit\models;

use app\models\Review;

class ReviewTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'product_id' => 2,
            'user_id' => 4,
            'score' => 5,
            'name' => 'Name',
            'email' => 'test@email.com',
            'review' => 'Review',
            'status' => Review::PENDING,
            'record_status' => Review::RECORD_ACTIVE
        ], $replace);
    }

    public function testInvalidStatus()
    {
        $model = new Review($this->data([
            'status' => 9999
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('status');
    }

    // public function testInvalidEmail()
    // {
    //     $model = new Review($this->data([
    //         'email' => 'invalid'
    //     ]));
    //     expect_not($model->save());
    //     expect($model->errors)->hasKey('email');
    // }

    public function testInvalidScore()
    {
        $model = new Review($this->data([
            'score' => 99999
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('score');


        $model = new Review($this->data([
            'score' => -1
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('score');
    }

    public function testInvalidProductId()
    {
        $model = new Review($this->data([
            'product_id' => 99999
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('product_id');
    }

    public function testInvalidUserId()
    {
        $model = new Review($this->data([
            'user_id' => 99999
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testCreateSuccess()
    {
        $model = new Review($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Review::RECORD_INACTIVE]);

        $model = new Review($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Review();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Review($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Review', [
            'record_status' => Review::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Review', [
            'record_status' => Review::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Review', [
            'record_status' => Review::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Review', [
            'record_status' => Review::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}