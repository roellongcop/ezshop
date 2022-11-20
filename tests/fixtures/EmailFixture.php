<?php

namespace app\tests\fixtures;

class EmailFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Email';
    public $dataFile = '@app/tests/fixtures/data/email.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}