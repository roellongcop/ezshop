<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%emails}}".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Email extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%emails}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'email',
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
            [['name', 'email', 'subject', 'message'], 'required'],
            [['message'], 'string'],
            [['email'], 'trim'],
            [['email'], 'email'],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'subject' => 'Subject',
            'message' => 'Message',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\EmailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EmailQuery(get_called_class());
    }

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            'name',
            'email',
            'subject',
            'created_at',
        ];
    }
     
    public function gridColumns()
    {
        return [
            'name' => [
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'email' => ['attribute' => 'email', 'format' => 'raw'],
            'subject' => ['attribute' => 'subject', 'format' => 'raw'],
            'message' => ['attribute' => 'message', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'email:raw',
            'subject:raw',
            'message:raw',
        ];
    }
}