<?php

namespace app\components;

use app\models\Theme;
use app\models\form\setting\EmailSettingForm;
use app\models\form\setting\ImageSettingForm;
use app\models\form\setting\NotificationSettingForm;
use app\models\form\setting\SystemSettingForm;
use app\models\form\setting\AboutUsForm;
use app\models\form\setting\SocialMediaForm;
use app\models\form\setting\ShippingForm;
use app\models\form\setting\ChatbotForm;
use app\models\form\setting\PriceSettingForm;

class SettingComponent extends \yii\base\Component
{
    public $system;
    public $email;
    public $image;
    public $notification;
    public $aboutUs;
    public $socialMedia;
    public $shipping;
    public $chatbot;
    public $price;

    public $theme;

	public function init()
    {
        parent::init();

        $this->system = new SystemSettingForm();
        $this->email = new EmailSettingForm();
        $this->image = new ImageSettingForm();
        $this->notification = new NotificationSettingForm();
        $this->aboutUs = new AboutUsForm();
        $this->socialMedia = new SocialMediaForm();
        $this->shipping = new ShippingForm();
        $this->chatbot = new ChatbotForm();
        $this->price = new PriceSettingForm();

        $this->theme = Theme::findOne($this->system->theme);
    }
}