<?php

namespace app\models\form;

use Yii;
use app\helpers\ArrayHelper;

class CartForm extends \yii\base\Model
{
    public $product_id;
    public $quantity;
    public $color;
    public $size;

    public $data;
    public $session;

    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'required'],
            [['product_id', 'quantity'], 'integer'],
            [['color', 'size'], 'string', 'max' => 255],
        ];
    }

    public function init()
    {
        parent::init();
        $this->session = Yii::$app->session;

        $this->data = $this->session['cart'] ?? [];
    }


    public function addNewProduct()
    {
        $this->data[] = [
            'product_id' => $this->quantity,
            'quantity' => $this->quantity,
            'color' => $this->color,
            'size' => $this->size,
        ];

        $this->session['cart'] = $this->data;
    }

    public function save()
    {
        if ($this->validate()) {
            if ($this->data) {

                $exist = false;
                foreach ($this->data as &$data) {
                    if ($data['product_id'] == $this->product_id) {
                        if ($this->color && $this->size) {
                            if ($data['color'] == $this->color && $data['size'] == $this->size) {
                                $data['quantity'] = $data['quantity'] + $this->quantity;
                                $exist = true;
                                break;
                            }
                        }
                        elseif ($this->color && $this->size == null) {
                            if ($data['color'] == $this->color) {
                                $data['quantity'] = $data['quantity'] + $this->quantity;
                                $exist = true;
                                break;
                            }
                        }
                        elseif ($this->size && $this->color == null) {
                            if ($data['size'] == $this->size) {
                                $data['quantity'] = $data['quantity'] + $this->quantity;
                                $exist = true;
                                break;
                            }
                        }
                        else {
                            $data['quantity'] = $data['quantity'] + $this->quantity;
                            $exist = true;
                            break;
                        }
                    }
                }

                if ($exist) {
                    $this->session['cart'] = $this->data;
                }
                else {
                    $this->addNewProduct();
                }
            }
            else {
                $this->addNewProduct();
            }

            return $this->data;
        }
    }
}