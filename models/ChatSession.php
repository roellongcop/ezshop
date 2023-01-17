<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%chat_sessions}}".
 *
 * @property int $id
 * @property string $session_id
 * @property int $status
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class ChatSession extends ActiveRecord
{
    const CHATBOT = 0;
    const USER = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chat_sessions}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'chat-session',
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
            [['session_id'], 'required'],
            [['status'], 'integer'],
            [['session_id'], 'string', 'max' => 40],
            ['status', 'in', 'range' => [
                self::CHATBOT,
                self::USER,
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
            'session_id' => 'Session ID',
            'status' => 'Status',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ChatSessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ChatSessionQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'session_id' => [
                'attribute' => 'session_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->session_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
        ];
    }

    public function detailColumns()
    {
        return [
            'session_id:raw',
        ];
    }

    public function getIsUser()
    {
        return $this->status == self::USER;
    }
}