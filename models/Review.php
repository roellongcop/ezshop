<?php

namespace app\models;

use app\widgets\Anchor;
use app\helpers\App;
use app\helpers\Url;

/**
 * This is the model class for table "{{%reviews}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $score
 * @property string $name
 * @property string $email
 * @property string $review
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Review extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reviews}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'review',
            'mainAttribute' => 'name',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['product_id', 'user_id', 'score'], 'integer'],
            [['name', 'email', 'review', 'user_id', 'score'], 'required'],
            [['review'], 'string'],
            [['name', 'email'], 'string', 'max' => 255],
            ['product_id', 'exist', 'targetRelation' => 'product'],
            ['user_id', 'exist', 'targetRelation' => 'user'],
            ['email', 'email'],
            [['email', 'name'], 'trim'],
            ['score', 'integer', 'max' => 5, 'min' => 1],
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
            'score' => 'Score',
            'name' => 'Name',
            'email' => 'Email',
            'review' => 'Review',
        ]);
    }

    public function beforeValidate()
    {
        if (! parent::beforeValidate()) {
            return false;
        }

        $this->name = App::if($this->user, fn($user) => $user->username);
        $this->email = App::if($this->user, fn($user) => $user->email);

        return true;
    }

    public function getUserImageUrl($w=45)
    {
        return App::if($this->user, fn($user) => Url::image($user->photo, ['w' => $w]));
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ReviewQuery(get_called_class());
    }

    public function getProductName()
    {
        return App::if($this->product, fn($product) => $product->name);
    }
     
    public function gridColumns()
    {
        return [
            'product_id' => [
                'attribute' => 'product_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->productName,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'user_id' => ['attribute' => 'user_id', 'format' => 'raw'],
            'score' => ['attribute' => 'score', 'format' => 'raw'],
            'name' => ['attribute' => 'name', 'format' => 'raw'],
            'email' => ['attribute' => 'email', 'format' => 'raw'],
            'review' => ['attribute' => 'review', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'product_id:raw',
            'user_id:raw',
            'score:raw',
            'name:raw',
            'email:raw',
            'review:raw',
        ];
    }
}