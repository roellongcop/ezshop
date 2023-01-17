<?php

namespace app\tests\fixtures;

class ChatSessionFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\ChatSession';
    public $dataFile = '@app/tests/fixtures/data/chat-session.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}