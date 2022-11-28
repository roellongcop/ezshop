<?php

namespace app\models\form;

use app\models\Cart;
use app\helpers\App;
use app\helpers\Html;

class CartForm extends \yii\base\Model
{
    public $product_id;
    public $user_id;
    public $session_id;
    public $quantity;
    public $color;
    public $size;

    public function rules()
    {
        return [
            [['product_id', 'user_id', 'quantity'], 'required'],
            [['product_id', 'user_id', 'quantity', 'session_id'], 'integer'],
            [['color', 'size'], 'string', 'max' => 255],
        ];
    }


    public function save()
    {
        if ($this->validate()) {
            $condition = [
                'product_id' => $this->product_id,
                'user_id' => $this->user_id,
                'session_id' => $this->session_id ?: App::session('id')
            ];

            if ($this->color) {
                $condition['color'] = $this->color;
            }

            if ($this->size) {
                $condition['size'] = $this->size;
            }

            $cart = Cart::findOne($condition) ?: new Cart($condition);

            if ($cart->isNewRecord) {
                $cart->quantity = $this->quantity;
            }
            else {
                $cart->quantity = $cart->quantity + $this->quantity;
            }

            if ($cart->save()) {
                return $cart;
            }


            $this->addError('cart', Html::errorSummary($cart, ['header' => '']));
        }
    }
}