<?php

namespace tests\unit\models;

use app\models\ProductCategory;

class ProductCategoryTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'name' => '191.168.1.3asd',  
            'value' => 'test',  
            'record_status' => ProductCategory::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new ProductCategory($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => ProductCategory::RECORD_INACTIVE]);

        $model = new ProductCategory($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new ProductCategory($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateInvalidType()
    {
        $model = new ProductCategory($this->data());
        $model->type = 10;
        expect_not($model->save());
        expect($model->errors)->hasKey('type');
    }

    public function testCreateNoData()
    {
        $model = new ProductCategory();

        expect_not($model->save());
    }

  
    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\ProductCategory', ['record_status' => ProductCategory::RECORD_ACTIVE]);
        $model->value = 'updated';
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\ProductCategory', ['record_status' => ProductCategory::RECORD_ACTIVE]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\ProductCategory', ['record_status' => ProductCategory::RECORD_INACTIVE]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\ProductCategory', ['record_status' => ProductCategory::RECORD_ACTIVE]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testExistingName()
    {
        $model = new ProductCategory($this->data());
        $model->name = 'product-category-1';
        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }

    public function testExistingNameOnUpdate()
    {
        $model = $this->tester->grabRecord('app\models\ProductCategory', ['name' => 'product-category-1']);
        $model->name = 'product-category-2';
        expect_not($model->save());
        expect($model->errors)->hasKey('name');
    }
}