<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%wishlists}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Wishlist extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wishlists}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'wishlist',
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
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id'], 'integer'],
            ['user_id', 'exist', 'targetRelation' => 'user'],
            ['product_id', 'exist', 'targetRelation' => 'product'],
            [['user_id', 'product_id'], 'validateExistense'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\WishlistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\WishlistQuery(get_called_class());
    }

    public function validateExistense($attribute, $params)
    {
        if ($this->isNewRecord) {
            $wishlist = self::findOne(['user_id' => $this->user_id, 'product_id' => $this->product_id]);
            if ($wishlist) {
                $this->addError($attribute, 'already in the wishlist');
            }
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
     
    public function gridColumns()
    {
        return [
            'user_id' => [
                'attribute' => 'user_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->user_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'product_id' => ['attribute' => 'product_id', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'user_id:raw',
            'product_id:raw',
        ];
    }
}