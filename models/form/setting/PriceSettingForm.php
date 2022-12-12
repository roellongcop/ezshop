<?php

namespace app\models\form\setting;

class PriceSettingForm extends SettingForm
{
    const NAME = 'price-settings';

    public $range;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
	        [['range', ], 'safe'],
        ];
    }

    public function default()
    {
        return [
            'range' => [
                'name' => 'range',
                'default' => [
                    '0-100',
                    '100-500',
                    '500-1000',
                    '1000-5000',
                    '5000-10000',
                    '50000-100000',
                ]
            ],
           
        ];
    }

    public function getPriceRange()
    {
        $data = [];

        foreach ($this->range as $range) {
            list($from, $to) = explode('-', $range);
            $from = (int) trim($from);
            $to = (int) trim($to);

            $data[$from] = $to;
        }

        return $data;
    }
}