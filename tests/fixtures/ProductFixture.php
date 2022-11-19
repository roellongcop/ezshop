<?php

namespace app\tests\fixtures;

class ProductFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Product';
    public $dataFile = '@app/tests/fixtures/data/product.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}