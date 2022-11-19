<?php

namespace app\behaviors;

use app\models\Product;
use app\models\ActiveRecord;

class ProductBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            // ActiveRecord::EVENT_AFTER_FIND => 'eventAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'eventBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'eventBeforeSave',
            // ActiveRecord::EVENT_AFTER_DELETE => 'eventAfterDelete',
        ];
    }

    public function eventBeforeSave($event)
    {
        $product = $this->owner;

        if ($product->quantity > $product->low_stock_threshold) {
            if ($product->quantity >= $product->high_stock_threshold) {
                $this->owner->stock_threshold_status = Product::THRESHOLD_HIGH;
            }
            else {
                $this->owner->stock_threshold_status = Product::THRESHOLD_SAFE;
            }
        }
        else {
            $this->owner->stock_threshold_status = Product::THRESHOLD_LOW;
        }
    }
}