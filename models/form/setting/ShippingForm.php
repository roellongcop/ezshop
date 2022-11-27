<?php

namespace app\models\form\setting;

class ShippingForm extends SettingForm
{
    const NAME = 'shipping-settings';

    public $flat_rate;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['flat_rate',], 'required'],
	        [['flat_rate', ], 'number'],
        ];
    }

    public function default()
    {
        return [
            'flat_rate' => [
                'name' => 'flat_rate',
                'default' => 0
            ],
        ];
    }
}