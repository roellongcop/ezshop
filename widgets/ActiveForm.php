<?php

namespace app\widgets;

use app\helpers\App;
use app\models\Theme;
use app\widgets\AnchorForm;
use app\widgets\RecordStatusInput;

class ActiveForm extends \yii\widgets\ActiveForm
{
	public $addClass;

	public function init()
	{
		parent::init();

		$currentTheme = App::identity('currentTheme');

		$this->addClass = 'form ' . $this->addClass;

		if ($currentTheme) {
			if (in_array($currentTheme->slug, Theme::KEEN)) {
				$this->errorCssClass = 'is-invalid';
				$this->successCssClass = 'is-valid';
				$this->validationStateOn = 'input';

				$this->options['class'] = $this->addClass;
				$this->options['novalidate'] = 'novalidate';
			}
		}
	}

	public static function buttons()
	{
		return AnchorForm::widget();
	}

	public static function recordStatus($params)
	{
		return RecordStatusInput::widget($params);
	}
}
