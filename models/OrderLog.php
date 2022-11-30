<?php

namespace app\models;

use app\widgets\Anchor;
use app\helpers\App;
use app\widgets\Label;

/**
 * This is the model class for table "{{%order_logs}}".
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $remarks
 * @property int $status
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class OrderLog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_logs}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'order-log',
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
            [['order_id', 'status', 'remarks'], 'required'],
            [['order_id', 'status'], 'integer'],
            [['remarks'], 'string'],
            ['status', 'in', 'range' => [
                Order::STATUS_PENDING,
                Order::STATUS_PROCESSING,
                Order::STATUS_DELIVERY,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED,
            ]],
            ['order_id', 'exist', 'targetRelation' => 'order']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'order_id' => 'Order ID',
            'remarks' => 'Remarks',
            'status' => 'Status',
        ]);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\OrderLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\OrderLogQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'order_id' => [
                'attribute' => 'order_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->order_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'remarks' => ['attribute' => 'remarks', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'order_id:raw',
            'remarks:raw',
        ];
    }

    public static function insertLog($order)
    {
        $log = new self([
            'order_id' => $order->id,
            'remarks' => $order->remarks ?: 'Order log at ' . App::formatter()->asDateToTimezone(),
            'status' => $order->status
        ]);

        $log->save();

        // $log->flashErrors();
    }

    public function getStatusBadge()
    {
        return Label::widget(['options' => App::params('order_status')[$this->status] ?? '']);
    }

    public function getStatusClass()
    {
        $data = App::params('order_status')[$this->status] ?? '';

        return $data ? $data['class']: '';
    }
}