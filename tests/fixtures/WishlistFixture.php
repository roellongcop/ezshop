<?php

namespace app\tests\fixtures;

class WishlistFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Wishlist';
    public $dataFile = '@app/tests/fixtures/data/wishlist.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}