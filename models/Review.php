<?php

namespace app\models;

use app\widgets\Anchor;

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
            [['product_id', 'user_id', 'score'], 'integer'],
            [['name', 'email', 'review'], 'required'],
            [['review'], 'string'],
            [['name', 'email'], 'string', 'max' => 255],
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

    /**
     * {@inheritdoc}
     * @return \app\models\query\ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ReviewQuery(get_called_class());
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