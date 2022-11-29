<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\OrderSearch;
use app\helpers\App;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Order: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new OrderSearch();
$this->params['wrapCard'] = false; 

$this->registerCss(".detail-view{margin-top: 0;}");
?>
<div class="order-view-page">
    <?= Anchors::widget([
    	'names' => ['log'], 
    	'model' => $model
    ]) ?> 

    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Order Details'
            ]) ?>
                <?= Detail::widget([
                    'model' => $model,
                    'attributes' => [
                        'statusBadge:raw',
                        'order_no:raw',
                        'paymentMode:raw',
                        [
                            'label' => 'DATE',
                            'value' => $model->created_at,
                            'format' => 'fulldate'
                        ],
                        // 'products:jsonEditor',
                        'subtotal:peso',
                        'shipping:peso',
                        'total:peso',
                        
                        // 'created_at:ago',
                    ]
                ]) ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Products'
            ]) ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NAME</th>
                                <th>ADDED SHIPPING</th>
                                <th>QUANTITY</th>
                                <th>PRICE</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= App::foreach($model->products, function($product, $key) {
                                $total = App::formatter()->asPeso($product['quantity'] * $product['price']);
                                $price = App::formatter()->asPeso($product['price']);
                                $added_shipping_fee = App::formatter()->asPeso($product['added_shipping_fee']);
                                $serial = $key + 1;
                                return <<< HTML
                                    <tr>
                                        <td>{$serial}</td>
                                        <td>{$product['productTableViewWithQuantity']}</td>
                                        <td>{$added_shipping_fee}</td>
                                        <td>{$product['quantity']}</td>
                                        <td>{$price}</td>
                                        <td>{$total}</td>
                                    </tr>
                                HTML;
                            }) ?>
                        </tbody>
                    </table>
                </div>
                
            <?php $this->endContent() ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Billing Details'
            ]) ?>
                <?= Detail::widget([
                    'model' => $model,
                    'attributes' => [
                        'billing_firstname:raw',
                        'billing_lastname:raw',
                        'billing_email:raw',
                        'billing_mobile:raw',
                        'billing_address1:raw',
                        'billing_address2:raw',
                        'billingProvinceName:raw',
                        'billingMunicipalityName:raw',
                        'billing_zip:raw',
                    ]
                ]) ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Shipping Details'
            ]) ?>
                <?= Detail::widget([
                    'model' => $model,
                    'attributes' => [
                        'shipping_firstname:raw',
                        'shipping_lastname:raw',
                        'shipping_email:raw',
                        'shipping_mobile:raw',
                        'shipping_address1:raw',
                        'shipping_address2:raw',
                        'shippingProvinceName:raw',
                        'shippingMunicipalityName:raw',
                        'shipping_zip:raw',
                    ]
                ]) ?>
            <?php $this->endContent() ?>
        </div>
    </div>
</div>