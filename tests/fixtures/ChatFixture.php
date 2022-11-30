<?php

namespace app\tests\fixtures;

class ChatFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Chat';
    public $dataFile = '@app/tests/fixtures/data/chat.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}