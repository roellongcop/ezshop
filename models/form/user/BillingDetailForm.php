<?php

namespace app\models\form\user;

use app\models\Municipality;
use app\models\Province;
use app\helpers\App;

class BillingDetailForm extends UserForm
{
    const META_NAME = 'billing-detail';

    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $street;
    public $city_id;
    public $province_id;
    public $zip;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return $this->setRules([
            [['first_name', 'last_name', 'street', 'city_id', 'province_id', 'zip', 'phone', 'email'], 'required'],
            [['city_id', 'province_id'], 'integer'],
            [['first_name', 'last_name', 'street', 'zip', 'phone', 'email'], 'string'],
            [['email'], 'trim'],
            [['email'], 'email'],
            ['province_id', 'exist', 'targetRelation' => 'province'],
            ['city_id', 'exist', 'targetRelation' => 'municipality'],
        ]);
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'city_id' => 'City',
            'province_id' => 'Province',
            'street' => 'Barangay | Street',
        ];
    } 

    public function getDetailColumns()
    {
        return [
            'first_name:raw',
            'last_name:raw',
        ];
    }

    public function getFullname()
    {
        return implode(' ', array_filter([
            $this->first_name,
            $this->last_name,
        ]));
    }

    public function getProvince()
    {
        return Province::findOne($this->province_id);
    }

    public function getMunicipality()
    {
        return Municipality::findOne($this->city_id);
    }

    public function getProv()
    {
        return App::if($this->province, fn($province) => $province->prov);
    }

    public function getProvinceName()
    {
        return App::if($this->province, fn($province) => $province->Province);
    }

    public function getMunicipalityName()
    {
        return App::if($this->municipality, fn($municipality) => $municipality->Municipality);
    }
}