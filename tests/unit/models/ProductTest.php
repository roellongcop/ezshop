<?php

namespace tests\unit\models;

use app\models\Product;
use yii\db\Expression;

class ProductTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'name' => 'Test',
            'categories' => json_encode(['Categories']),
            'description' => 'Description',
            'tags' => json_encode(['Tags']),
            'image' => 'Image',
            'gallery' => json_encode(['Gallery']),
            'regular_price' => 10,
            'sale_price' => 5,
            'sku' => 'Sku',
            'quantity' => 100,
            'low_stock_threshold' => 5,
            'high_stock_threshold' => 500,
            // 'stock_threshold_status' => Product::THRESHOLD_SAFE,
            'added_shipping_fee' => 12,
            'record_status' => Product::RECORD_ACTIVE,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => new Expression('UTC_TIMESTAMP'),
            'updated_at' => new Expression('UTC_TIMESTAMP'),
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Product($this->data());
        expect_that($model->save());
    }

    public function testSafeThresholdInventory()
    {
        $model = new Product($this->data());
        expect_that($model->save());
        expect_that($model->isSafe);
    }

    public function testHighThresholdInventory()
    {
        $model = new Product($this->data(['quantity' => 600]));
        expect_that($model->save());
        expect_that($model->isHigh);
    }

    public function testLowThresholdInventory()
    {
        $model = new Product($this->data(['quantity' => 5]));
        expect_that($model->save());
        expect_that($model->isLow);
    }

    public function testLowStockGreaterThanHighStock()
    {
        $model = new Product($this->data(['low_stock_threshold' => 600, 'high_stock_threshold' => 500]));
        expect_not($model->save());
        expect($model->errors)->hasKey('low_stock_threshold');
        expect($model->errors)->hasKey('high_stock_threshold');
    }

    public function testLowStockEqualHighStock()
    {
        $model = new Product($this->data(['low_stock_threshold' => 500, 'high_stock_threshold' => 500]));
        expect_not($model->save());
        expect($model->errors)->hasKey('low_stock_threshold');
        expect($model->errors)->hasKey('high_stock_threshold');
    }

    public function testSalePriceGreaterThanRegular()
    {
        $model = new Product($this->data(['sale_price' => 600, 'regular_price' => 500]));
        expect_not($model->save());
        expect($model->errors)->hasKey('sale_price');
        expect($model->errors)->hasKey('regular_price');
    }


    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Product::RECORD_INACTIVE]);

        $model = new Product($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Product();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Product($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Product', [
            'record_status' => Product::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Product', [
            'record_status' => Product::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Product', [
            'record_status' => Product::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Product', [
            'record_status' => Product::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}