<?php

namespace app\behaviors;

use app\helpers\App;
use app\helpers\ArrayHelper;

use app\models\Cart;
use app\models\Order;
use app\models\Role;
use app\models\User;
use app\models\Notification;
use app\models\Product;
use app\models\OrderLog;
use app\models\ActiveRecord;

class OrderBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            // ActiveRecord::EVENT_AFTER_FIND => 'eventAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'eventBeforeInsert',
            ActiveRecord::EVENT_AFTER_INSERT => 'eventAfterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'eventAfterUpdate',
            // ActiveRecord::EVENT_AFTER_DELETE => 'eventAfterDelete',
        ];
    }

    public function eventBeforeInsert($event)
    {
        $order = $this->owner;

        if ($order->shipTo == 'same') {
            $this->owner->shipping = Cart::shipping($order->billing_province_id, $order->billing_municipality_id);
        }
        else {
            $this->owner->shipping = Cart::shipping($order->shipping_province_id, $order->shipping_municipality_id);
        }

        $this->owner->setTheTotal();
        $this->owner->order_no = $this->generateOrderNo();
        $this->owner->status = Order::STATUS_PENDING;
    }

    public function generateOrderNo()
    {
        $total = Order::find()->count();
        $order_no = implode('-', [str_pad($total + 1, 7, "0", STR_PAD_LEFT), time()]);

        if (Order::find()->where(['order_no' => $order_no])->exists()) {
            return $this->generateOrderNo();
        }

        return $order_no;
    }



    public function eventAfterInsert($event)
    {
        $order = $this->owner;

        $roles = [
            Role::DEVELOPER,
            Role::SUPERADMIN,
            Role::ADMIN,
        ];

        if (($users = User::findAll(['role_id' => $roles])) != null) {
            foreach ($users as $user) {
                $notification = new Notification([
                    'status' => Notification::STATUS_UNREAD,
                    'record_status' => Notification::RECORD_ACTIVE,
                    'user_id' => $user->id,
                    'type' => Notification::TYPE_NEW_ORDER,
                    'link' => $order->getViewUrl(false, true),
                    'message' => "{$order->formattedTotal} total amount ordered by {$order->billingFullname}",
                ]);
                $notification->save();
            }
        }

        Cart::clear();
        OrderLog::insertLog($order);
    }


    public function eventAfterUpdate($event)
    {
        $order = $this->owner;
        

        if ($order->status == Order::STATUS_PROCESSING) {
            if ($order->products) {
                $data = ArrayHelper::map($order->products, 'product_id', 'quantity');
                
                if (($products = Product::findAll(array_keys($data))) != null) {
                    foreach ($products as $product) {

                        $quantity = $data[$product->id] ?? false;

                        if ($quantity !== false) {
                            $product->quantity = $product->quantity - $quantity;
                            $product->quantity = $product->quantity > 0 ? $product->quantity: 0;
                            $product->save();
                        }
                    }
                }
            }
        }

        OrderLog::insertLog($order);
    }
}