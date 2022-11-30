<?php

namespace app\filters;

use app\helpers\App;
use app\models\Chat;

class ChatbotFilter extends \yii\base\ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $chat = Chat::findOrCreate(['session_id' => App::session('id')]);
        if ($chat->isNewRecord) {
            $chat->message = App::setting('chatbot')->welcome_message;
            $chat->type = Chat::TYPE_CHATBOT;
            $chat->save();
        }
        return true;
    }
}