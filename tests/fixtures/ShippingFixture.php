<?php

namespace app\tests\fixtures;

class ShippingFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Shipping';
    public $dataFile = '@app/tests/fixtures/data/shipping.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}