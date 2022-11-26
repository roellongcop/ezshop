<?php

namespace tests\unit\models;

use app\models\Cart;

class CartTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'product_id' => 1,
            'user_id' => 1,
            'color' => 'Color',
            'size' => 'Size',
            'quantity' => 1,
            'record_status' => Cart::RECORD_ACTIVE
        ], $replace);
    }

    public function testInvalidProductId()
    {
        $model = new Cart($this->data([
            'product_id' => 'invalid'
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('product_id');
    }

    public function testInvalidUserId()
    {
        $model = new Cart($this->data([
            'user_id' => 'invalid'
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testCreateSuccess()
    {
        $model = new Cart($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Cart::RECORD_INACTIVE]);

        $model = new Cart($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Cart();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Cart($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Cart', [
            'record_status' => Cart::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Cart', [
            'record_status' => Cart::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Cart', [
            'record_status' => Cart::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Cart', [
            'record_status' => Cart::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}