<?php

namespace app\models;


class ProductCategory extends Setting
{

    public function config()
    {
        $config = parent::config();
        $config['controllerID'] = 'product-category';
        $config['paramName'] = 'slug';

        return $config;
    }

    public function gridColumns()
    {
        $columns = parent::gridColumns();

        $columns['description'] = $columns['value'];

        unset($columns['value']);

        return $columns;
    }

    public function rules()
    {
        $rules = parent::rules();

        $rules[] = ['name', 'validateName'];

        return $rules;
    }

    public function init()
    {
        parent::init();

        $this->type = parent::TYPE_PRODUCT_CATEGORY;
    }

    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();

        $attributeLabels['value'] = 'Description';

        return $attributeLabels;
    }

    public function validateName($attribute, $params)
    {
        if ($this->isNewRecord) {
            if (($model = self::findOne(['name' => $this->name])) != null) {
                $this->addError($attribute, 'Name already exist.');
            }
        }
        else {
            $model = self::find()
                ->where(['name' => $this->name])
                ->andWhere(['<>', 'id', $this->id])
                ->one();

            if ($model) {
                $this->addError($attribute, 'Name already exist.');
            }
        }
    }

    public function beforeSave($insert)
    {
        if (! parent::beforeSave($insert)) {
            return false;
        }

        $this->type = parent::TYPE_PRODUCT_CATEGORY;

        return true;
    }

    public static function dropdown($key='id', $value='name', $condition=[], $map=true, $limit=false)
    {
        $condition['type'] = parent::TYPE_PRODUCT_CATEGORY;;

        return parent::dropdown($key, $value, $condition, $map, $limit);
    }
}