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

    public function getImageUrl()
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

    public function getProducts()
    {
        return Product::find()
            ->where(['LIKE', 'categories', $this->name])
            ->active()
            ->all();
    }

    public function getTotalProducts()
    {
        return Product::find()
            ->where(['LIKE', 'categories', $this->name])
            ->active()
            ->count();
    }

    public function getFormattedTotalProducts()
    {
        return number_format($this->totalProducts);
    }

    public function getProduct()
    {
        if (($products = $this->products) != null) {
            $count = count($products);

            return $products[rand(0, $count-1)];
        }
    }

    public function getProductImageUrl($w=100)
    {
        if (($product = $this->product) != null) {
            return $product->getImageUrl($w);
        }

        return Url::image(null, ['w' => $w]);
    }

    public static function random($limit=3)
    {
        return self::find()
            ->where(['<>', 'files', ''])
            ->active()
            ->orderBy(new Expression('rand()'))
            ->limit($limit)
            ->all();
    }

    public function getFrontendUrl()
    {
        return Url::toRoute(['/site/shop', 'categories' => $this->name]);
    }
}