<?php

namespace app\models\form\setting;

use Yii;

class SocialMediaForm extends SettingForm
{
    const NAME = 'social-media-settings';

    public $twitter;
    public $facebook;
    public $linkedin;
    public $instagram;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['twitter', 'facebook', 'linkedin', 'instagram'], 'string'],
        ];
    }

    public function default()
    {
        return [
            'twitter' => [
                'name' => 'twitter',
                'default' => 'https://twitter.com'
            ],
            'facebook' => [
                'name' => 'facebook',
                'default' => 'https://www.facebook.com'
            ],
            'linkedin' => [
                'name' => 'linkedin',
                'default' => 'https://www.linkedin.com'
            ],
            'instagram' => [
                'name' => 'instagram',
                'default' => 'https://www.instagram.com'
            ],
        ];
    }
}