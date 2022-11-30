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

$this->registerCss(<<< CSS
    .detail-view{margin-top: 0;}
    .app-iconbox {
        box-shadow: rgb(0 0 0 / 30%) 0px 1px 4px 0
    }
    
    .dataTables_filter {
        text-align: right;
    }
    .dataTables_filter label,
    .dataTables_length label {
        display: inline-flex;
    }

    .dataTables_filter input {
        margin-top: -5px;
        margin-left: 5px;
    }
    .dataTables_length select{
        margin-top: -5px;
        margin-left: 5px;
        margin-right: 5px;
    }
    .dataTables_paginate {
        float: right;
    }
    .th-file {
        width: 80% !important;
    }
CSS);

$this->registerJsFile(App::publishedUrl("/plugins/custom/datatables/datatables.bundle.js"), [
    'depends' => [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ]
]);

$this->registerJs(<<< JS
    $('.datatable').DataTable({
        pageLength: 5,
        order: [[0, 'desc']]
    });
JS)
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
                'title' => 'Logs'
            ]) ?>
               <div class="timeline timeline-2">
                    <div class="timeline-bar"></div>
                    <?= App::foreach($model->orderLogs, fn($orderLog) => <<< HTML
                        <div class="timeline-item">
                            <span class="timeline-badge bg-{$orderLog->statusClass}"></span>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                {$orderLog->remarks} | <span class="font-weight-bold">{$model->billingFullname}</span>

                                {$orderLog->statusBadge}</span>
                                <span class="text-muted font-italic text-right">
                                    {$orderLog->ago}
                                </span>
                            </div>
                        </div>

                    HTML) ?>
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
    <div class="row">
        <div class="col-md-12">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Products'
            ]) ?>
                <table class="table table-bordered datatable">
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
            <?php $this->endContent() ?>
        </div>
    </div>
</div>