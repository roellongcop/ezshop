<?php

namespace app\components;

use app\models\Theme;
use app\models\form\setting\EmailSettingForm;
use app\models\form\setting\ImageSettingForm;
use app\models\form\setting\NotificationSettingForm;
use app\models\form\setting\SystemSettingForm;
use app\models\form\setting\AboutUsForm;

class SettingComponent extends \yii\base\Component
{
    public $system;
    public $email;
    public $image;
    public $notification;
    public $aboutUs;

    public $theme;

	public function init()
    {
        parent::init();

        $this->system = new SystemSettingForm();
        $this->email = new EmailSettingForm();
        $this->image = new ImageSettingForm();
        $this->notification = new NotificationSettingForm();
        $this->aboutUs = new AboutUsForm();

        $this->theme = Theme::findOne($this->system->theme);
    }
}