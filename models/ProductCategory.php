<?php

namespace app\models;

use app\helpers\Html;
use app\helpers\Url;
use app\helpers\StringHelper;
use yii\db\Expression;

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

        $columns['photo'] = [
            'attribute' => 'files',
            'format' => 'raw',
            'label' => 'Photo'
        ];

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


    public function detailColumns()
    {
        $columns = parent::detailColumns();
        $columns['photo'] = [
            'label' => 'Photo',
            'format' => 'raw',
            'value' => function($model) {
                return Html::image($model->files, ['w' => 200], ['class' => 'img-thumbnail']);
            }
        ];

        return $columns;
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

    public function getPhotoLink()
    {
        return Url::image($this->files);
    }

    public function getDescription()
    {
        return $this->value;
    }

    public function getTruncatedDescription()
    {
        return StringHelper::truncate($this->description, 100);
    }

    public static function random($limit=3)
    {
        return self::find()
            ->where(['<>', 'files', ''])
            ->orderBy(new Expression('rand()'))
            ->limit($limit)
            ->all();
    }
}