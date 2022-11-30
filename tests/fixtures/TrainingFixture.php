<?php

namespace app\tests\fixtures;

class TrainingFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Training';
    public $dataFile = '@app/tests/fixtures/data/training.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}