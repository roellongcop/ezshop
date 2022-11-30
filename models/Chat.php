<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%chats}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $reply_id
 * @property string $session_id
 * @property string|null $message
 * @property int $status
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Chat extends ActiveRecord
{
    const ANSWERED = 0;
    const UN_ANSWERED = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chats}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'chat',
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
            [['user_id', 'reply_id', 'status'], 'integer'],
            [['session_id'], 'required'],
            [['message'], 'string'],
            [['session_id'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user', 'when' => fn($model) => $model->user_id],
            ['reply_id', 'exist', 'targetRelation' => 'reply', 'when' => fn($model) => $model->reply_id],
            ['status', 'in', 'range' => [
                self::ANSWERED,
                self::UN_ANSWERED,
            ]]
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
            'reply_id' => 'Reply ID',
            'session_id' => 'Session ID',
            'message' => 'Message',
            'status' => 'Status',
        ]);
    }

    public function getReply()
    {
        return $this->hasOne(Chat::class, ['id' => 'reply_id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ChatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ChatQuery(get_called_class());
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
            'reply_id' => ['attribute' => 'reply_id', 'format' => 'raw'],
            'session_id' => ['attribute' => 'session_id', 'format' => 'raw'],
            'message' => ['attribute' => 'message', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'user_id:raw',
            'reply_id:raw',
            'session_id:raw',
            'message:raw',
        ];
    }
}