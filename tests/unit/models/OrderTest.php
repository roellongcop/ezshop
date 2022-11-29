<?php

namespace tests\unit\models;

use app\models\Order;

class OrderTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'order_no' => '333',
            'billing_firstname' => 'Billing Firstname',
            'billing_lastname' => 'Billing Lastname',
            'billing_email' => 'billing@email.com',
            'billing_mobile' => 'Billing Mobile',
            'billing_address1' => 'Billing Address1',
            'billing_province_id' => 1,
            'billing_municipality_id' => 1,
            'billing_zip' => 'Billing Zip',
            'shipping_firstname' => 'Shipping Firstname',
            'shipping_lastname' => 'Shipping Lastname',
            'shipping_email' => 'shipping@email.com',
            'shipping_mobile' => 'Shipping Mobile',
            'shipping_address1' => 'Shipping Address1',
            'shipping_province_id' => 1,
            'shipping_municipality_id' => 1,
            'shipping_zip' => 'Shipping Zip',
            'products' => [
                [
                    'product_id' => 1, 
                    'quantity' => 1, 
                    'price' => 1, 
                    'added_shipping_fee' => 1,
                    'color' => 'color', 
                    'size' => 'size', 
                    'name' => 'name'
                ]
            ],
            'subtotal' => 2,
            'shipping' => 1,
            'total' => 3,
            'status' => Order::STATUS_PENDING,
            'payment_mode' => Order::PAYMENT_COD,
            'record_status' => Order::RECORD_ACTIVE,
        ], $replace);
    }

    public function testInvalidStatus()
    {
        $model = new Order($this->data());
        $model->status = 999;
        expect_not($model->save());
        expect($model->errors)->hasKey('status');
    }

    public function testInvalidShipTo()
    {
        $model = new Order($this->data());
        $model->shipTo = 'invalid;';
        expect_not($model->save());
        expect($model->errors)->hasKey('shipTo');
    }

    public function testInvalidBillingAddress()
    {
        $model = new Order($this->data(['billing_email' => 'invalid']));
        expect_not($model->save());
        expect($model->errors)->hasKey('billing_email');
    }

    public function testInvalidShippingAddress()
    {
        $model = new Order($this->data(['shipping_email' => 'invalid']));
        expect_not($model->save());
        expect($model->errors)->hasKey('shipping_email');
    }

    public function testInvalidBillingProvinceId()
    {
        $model = new Order($this->data(['billing_province_id' => 99999]));
        expect_not($model->save());
        expect($model->errors)->hasKey('billing_province_id');
    }

    public function testInvalidBillingMunicipalityId()
    {
        $model = new Order($this->data(['billing_municipality_id' => 99999]));
        expect_not($model->save());
        expect($model->errors)->hasKey('billing_municipality_id');
    }

    public function testInvalidShippingProvinceId()
    {
        $model = new Order($this->data(['shipping_province_id' => 99999]));
        $model->shipTo = 'different';
        expect_not($model->save());
        expect($model->errors)->hasKey('shipping_province_id');
    }

    public function testInvalidShippingMunicipalityId()
    {
        $model = new Order($this->data(['shipping_municipality_id' => 99999]));
        $model->shipTo = 'different';
        expect_not($model->save());
        expect($model->errors)->hasKey('shipping_municipality_id');
    }


    public function testRequiredShippingDetailsWhenNotSameWithBilling()
    {
        $model = new Order($this->data());
        $model->shipTo = 'different';
        $model->shipping_firstname = '';
        $model->shipping_lastname = '';
        $model->shipping_email = '';
        $model->shipping_mobile = '';
        $model->shipping_address1 = '';
        $model->shipping_province_id = '';
        $model->shipping_municipality_id = '';
        $model->shipping_zip = '';
        expect_not($model->save());


        expect($model->errors)->hasKey('shipping_firstname');
        expect($model->errors)->hasKey('shipping_lastname');
        expect($model->errors)->hasKey('shipping_email');
        expect($model->errors)->hasKey('shipping_mobile');
        expect($model->errors)->hasKey('shipping_address1');
        expect($model->errors)->hasKey('shipping_province_id');
        expect($model->errors)->hasKey('shipping_municipality_id');
        expect($model->errors)->hasKey('shipping_zip');
    }

    public function testDuplicateOrderNo()
    {
        $model = new Order($this->data(['order_no' => 1]));
        expect_not($model->save());
        expect($model->errors)->hasKey('order_no');
    }

    public function testCreateSuccess()
    {
        $model = new Order($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Order::RECORD_INACTIVE]);

        $model = new Order($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Order();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Order($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Order', [
            'record_status' => Order::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testCannotDeleteS()
    {
        $model = $this->tester->grabRecord('app\models\Order', [
            'record_status' => Order::RECORD_ACTIVE
        ]);
        expect_not($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Order', [
            'record_status' => Order::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Order', [
            'record_status' => Order::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}