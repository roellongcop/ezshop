<?php

namespace tests\unit\models;

use app\models\Shipping;

class ShippingTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'province_id' => 1,
            'municipality_id' => 3,
            'rate' => 200,
            'record_status' => Shipping::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Shipping($this->data());
        expect_that($model->save());
    }

    public function testUniqueProvinceAndMunicipality()
    {
        $model = new Shipping($this->data(['municipality_id' => 1]));
        expect_not($model->save());
        expect($model->errors)->hasKey('municipality_id');
        expect($model->errors)->hasKey('province_id');
    }

    public function testInvalidProductId()
    {
        $model = new Shipping($this->data(['province_id' => 99999]));
        expect_not($model->save());
        expect($model->errors)->hasKey('province_id');
    }

    public function testInvalidMunicipalityId()
    {
        $model = new Shipping($this->data(['municipality_id' => 99999]));
        expect_not($model->save());
        expect($model->errors)->hasKey('municipality_id');
    }


    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Shipping::RECORD_INACTIVE]);

        $model = new Shipping($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Shipping();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Shipping($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Shipping', [
            'record_status' => Shipping::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Shipping', [
            'record_status' => Shipping::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Shipping', [
            'record_status' => Shipping::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Shipping', [
            'record_status' => Shipping::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}