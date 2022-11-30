<?php

namespace app\models\form\setting;

class ChatbotForm extends SettingForm
{
    const NAME = 'chatbot-settings';

    public $photo;
    public $welcome_message;
    public $theme_color;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['photo', 'welcome_message', 'theme_color'], 'required'],
            [['photo', 'welcome_message', 'theme_color'], 'string'],
        ];
    }

    public function default()
    {
        return [
            'photo' => [
                'name' => 'photo',
                'default' => 'token-default-image_200'
            ],
            'welcome_message' => [
                'name' => 'welcome_message',
                'default' => 'Good day! \n What can I do for you today?'
            ],
            'theme_color' => [
                'name' => 'theme_color',
                'default' => '#5A5EB9'
            ],
        ];
    }
}