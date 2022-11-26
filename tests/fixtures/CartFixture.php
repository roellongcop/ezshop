<?php

namespace app\tests\fixtures;

class CartFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Cart';
    public $dataFile = '@app/tests/fixtures/data/cart.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}