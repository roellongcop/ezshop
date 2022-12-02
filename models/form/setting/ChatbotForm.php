<?php

namespace app\models\form\setting;

use app\helpers\Url;

class ChatbotForm extends SettingForm
{
    const NAME = 'chatbot-settings';

    public $name;
    public $photo;
    public $welcome_message;
    public $default_message;
    public $theme_color;

    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'photo', 'welcome_message', 'default_message', 'theme_color'], 'required'],
            [['name', 'photo', 'welcome_message', 'default_message', 'theme_color'], 'string'],
        ];
    }

    public function getPhotoUrl()
    {
        return Url::image($this->photo, ['w' => 50]);
    }

    public function default()
    {
        return [
            'name' => [
                'name' => 'name',
                'default' => 'Chatbot'
            ],
            'photo' => [
                'name' => 'photo',
                'default' => 'token-default-image_200'
            ],
            'welcome_message' => [
                'name' => 'welcome_message',
                'default' => "Good day!\nWhat can I do for you today?"
            ],
            'default_message' => [
                'name' => 'default_message',
                'default' => "Sorry I can't understand your query right now.\nAre you searching for a product? Click the button below.\n[CATEGORY_BUTTON] [PRICE_RANGE_BUTTON]
                "
            ],
            'theme_color' => [
                'name' => 'theme_color',
                'default' => '#5A5EB9'
            ],
        ];
    }
}