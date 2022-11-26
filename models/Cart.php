<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%carts}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string|null $color
 * @property string|null $size
 * @property int|null $quantity
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Cart extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%carts}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'cart',
            'mainAttribute' => 'id',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['product_id', 'user_id', 'quantity'], 'required'],
            [['product_id', 'user_id', 'quantity'], 'integer'],
            [['color', 'size'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'color' => 'Color',
            'size' => 'Size',
            'quantity' => 'Quantity',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\CartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CartQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'product_id' => [
                'attribute' => 'product_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->product_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'user_id' => ['attribute' => 'user_id', 'format' => 'raw'],
            'color' => ['attribute' => 'color', 'format' => 'raw'],
            'size' => ['attribute' => 'size', 'format' => 'raw'],
            'quantity' => ['attribute' => 'quantity', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'product_id:raw',
            'user_id:raw',
            'color:raw',
            'size:raw',
            'quantity:raw',
        ];
    }
}