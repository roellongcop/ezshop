<?php

namespace app\tests\fixtures;

class ReviewFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Review';
    public $dataFile = '@app/tests/fixtures/data/review.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}