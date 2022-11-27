<?php

namespace tests\unit\models;

use app\models\form\CartForm;

class CartFormTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'product_id' => 1,
            'user_id' => 1,
            'color' => 'Color',
            'size' => 'Size',
            'quantity' => 1,
        ], $replace);
    }

   
    public function testCreateSuccess()
    {
        $model = new CartForm($this->data());
        expect_that($model->save());
    }


    public function testInvalidProductId()
    {
        $model = new CartForm($this->data([
            'product_id' => 'invalid'
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('product_id');
    }

    public function testInvalidUserId()
    {
        $model = new CartForm($this->data([
            'user_id' => 'invalid'
        ]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testAddQuantity()
    {
        $model = new CartForm($this->data(['user_id' => 1]));

        expect_that($model->save());

        $cart = $this->tester->grabRecord('app\models\Cart', [
            'product_id' => 1,
            'user_id' => 1,
            'color' => 'Color',
            'size' => 'Size',
        ]);

        expect($cart->quantity)->equals(2);
    }

}