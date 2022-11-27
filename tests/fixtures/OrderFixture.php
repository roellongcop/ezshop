<?php

namespace app\tests\fixtures;

class OrderFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Order';
    public $dataFile = '@app/tests/fixtures/data/order.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}