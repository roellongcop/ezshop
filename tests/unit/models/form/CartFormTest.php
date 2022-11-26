<?php

namespace tests\unit\models;

use app\models\form\CartForm;
use Yii;

class CartFormTest extends \Codeception\Test\Unit
{

    public function _before()
    {
        $session = Yii::$app->session;

        $session->destroy();
    }
    protected function data($replace=[])
    {
        return array_replace([
            'product_id' => 1,
            'color' => 'Color',
            'size' => 'Size',
            'quantity' => 1,
        ], $replace);
    }

   
    public function testCreateNewSuccess()
    {
        $model = new CartForm($this->data());
        expect_that($model->save());
    }

    public function testCreateNewColorSuccess()
    {
        $model = new CartForm($this->data());
        expect_that($model->save());

        $model = new CartForm($this->data(['color' => 'new color']));
        expect_that($model->save());

        $CartForm = new CartForm();
        expect($CartForm->data[0]['quantity'])->equals(1);
        expect($CartForm->data[1]['color'])->equals('new color');
    }


    public function testCreateNewSizeSuccess()
    {
        $model = new CartForm($this->data());
        expect_that($model->save());

        $model = new CartForm($this->data(['size' => 'new size']));
        expect_that($model->save());

        $CartForm = new CartForm();
        var_dump($CartForm->data); die;
        expect($CartForm->data[0]['quantity'])->equals(2);
        expect($CartForm->data[1]['size'])->equals('new size');
    }

    public function testInvalidProductId()
    {
        $model = new CartForm($this->data([
            'product_id' => 'invalid'
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('product_id');
    }

    public function testAddQuantity()
    {
        $model = new CartForm($this->data());
        expect_that($model->save());

        $model = new CartForm($this->data());
        expect_that($model->save());

        $CartForm = new CartForm();
        expect($CartForm->data[0]['quantity'])->equals(2);
    }

}