<?php

namespace app\models;

use app\widgets\Anchor;
use app\widgets\Label;
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

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

    const TYPE_CHATBOT = 0;
    const TYPE_USER = 1;

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chats}}';
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['timeSent'] = 'timeSent';

        return $fields;
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
            [['user_id', 'reply_id', 'status', 'type'], 'integer'],
            [['session_id', 'type'], 'required'],
            [['message'], 'string'],
            [['session_id'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user', 'when' => fn($model) => $model->user_id],
            ['reply_id', 'exist', 'targetRelation' => 'reply', 'when' => fn($model) => $model->reply_id],
            ['status', 'in', 'range' => [
                self::ANSWERED,
                self::UN_ANSWERED,
            ]],
            ['type', 'in', 'range' => [
                self::TYPE_CHATBOT,
                self::TYPE_USER,
            ]],
            [['message'], 'trim']
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

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->message = $this->setTheMessage();

        $this->user_id = App::ifElse(App::identity(), fn($user) => $user->id, 0);

        return true;
    }

    public function setTheMessage()
    {
        $replace = $this->replace();

        $message = $this->message;

        foreach ($replace as $key => $value) {
            if (str_contains($message, $key)) {
                $value = is_callable($value) ? call_user_func($value): $value;

                $message = str_replace($key, $value, $message);
            }
        }

        return $message;
    }

    public function replace()
    {
        $chatbot = App::setting('chatbot');

        return [
            '[CHATBOT_NAME]' => $chatbot->name,
            '[PRICE_RANGE]' => function() {
                return implode('<br>', [
                    Html::tag('a', '₱0 - ₱100', [
                        'href' => Url::toRoute(['site/shop', 'price_range[]' => '0-100'])
                    ]),
                    Html::tag('a', '₱100 - ₱500', [
                        'href' => Url::toRoute(['site/shop', 'price_range[]' => '100-500'])
                    ]),
                    Html::tag('a', '₱500 - ₱1,000', [
                        'href' => Url::toRoute(['site/shop', 'price_range[]' => '500-1000'])
                    ]),
                    Html::tag('a', '₱1,000 - ₱5,000', [
                        'href' => Url::toRoute(['site/shop', 'price_range[]' => '1000-5000'])
                    ]),
                    Html::tag('a', '₱5,000 - ₱10,000', [
                        'href' => Url::toRoute(['site/shop', 'price_range[]' => '5000-10000'])
                    ]),
                ]);
            }
        ];
    }

    public function getReply()
    {
        return $this->hasOne(Chat::class, ['id' => 'reply_id']);
    }

    public function getUserEmail()
    {
        return App::if($this->user, fn($user) => $user->email);
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

    public function getStatusBadge()
    {
        $param = App::params('chat_status')[$this->status];

        if ($param) {
            return Label::widget(['options' => $param]);
        }
    }


    public function getTypeBadge()
    {
        $param = App::params('chat_type')[$this->type];

        if ($param) {
            return Label::widget(['options' => $param]);
        }
    }

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            'session_id',
            'message',
            'status',
            'type',
            'created_at',
            'last_updated',
            'active',
        ];
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
            'message' => ['attribute' => 'message', 'format' => 'raw'],
            'user_email' => [
                'label' => 'User email',
                'attribute' => 'userEmail', 
                'format' => 'raw',
                'value' => 'userEmail'
            ],
            'status' => ['attribute' => 'status', 'format' => 'raw', 'value' => 'statusBadge'],
            'type' => ['attribute' => 'type', 'format' => 'raw', 'value' => 'typeBadge'],
            // 'reply_id' => ['attribute' => 'reply_id', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            // 'reply_id:raw',
            'session_id:raw',
            'userEmail:raw',
            'message:raw',
            'statusBadge:raw',
            'typeBadge:raw',
        ];
    }

    public function dateDiff($date1, $date2, $format="days")
    {
        $date1 = new \DateTime($date1);
        $date2 = new \DateTime($date2);

        $diff = $date1->diff($date2);

        return $diff->{$format};
    }

    public function getTimeSent()
    {
        $start = date("Y-m-d", strtotime(App::formatter()->asDateToTimezone('', 'Y-m-d H:i:s'))); 
        $end = date("Y-m-d", strtotime($this->created_at)); 

        $day   = $this->dateDiff($start, $end);
        $month = $this->dateDiff($start, $end, 'm');
        $year  = $this->dateDiff($start, $end, 'y');

        if ($year > 1) {
            return implode(' AT ', [
                date('M d, Y', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        elseif ($month > 1 || $day >= 6) {
            return implode(' AT ', [
                date('M d', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        elseif ($day > 1 || $start != $end) {
            return implode(' AT ', [
                date('D', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        else {
            return date('h:i A', strtotime($this->createdAt));
        }
    }

    public static function response($training)
    {
        foreach ($training->response as $response) {
            $chat = new self([
                'session_id' => App::session('id'),
                'type' => self::TYPE_CHATBOT,
                'message' => $response,
                'status' => self::ANSWERED 
            ]);
            $chat->save();
        }
    }

    public static function dummy()
    {
        $chat = new Chat([
            'session_id' => App::session('id'),
            'type' => Chat::TYPE_CHATBOT,
            'message' => App::setting('chatbot')->default_message,
            'status' => Chat::ANSWERED 
        ]);
        $chat->save();
    }

    public static function findByKeywords($keywords='', $attributes='', $limit=10, $andFilterWhere=[])
    {
        return parent::findByKeywordsData($attributes, function($attribute) use($keywords, $limit, $andFilterWhere) {
            return self::find()
                ->select("{$attribute} AS data")
                ->alias('c')
                ->joinWith('user u')
                ->groupBy($attribute)
                ->where(['LIKE', $attribute, $keywords])
                ->andFilterWhere($andFilterWhere)
                ->limit($limit)
                ->asArray()
                ->all();
        });
    }
}