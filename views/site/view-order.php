<?php

use app\helpers\App;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\models\Product;

$this->title = 'Order: ' . $order->order_no;
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = ['label' => 'My Order History', 'url' => ['site/my-orders']];
$this->params['breadcrumbs'][] = $order->order_no;
$this->params['activePage'] = 'checkout';
?>

<div class="container-fluid">
    
    <div class="row px-xl-5">
        <div class="col-lg-12">
            <?= $order->statusBadgeFront ?>
            <?= $order->getCancelButton('') ?>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
            <div class="bg-light p-30 mb-5">
                <div>
                    <strong><?= $order->getAttributeLabel('billing_firstname') ?>:</strong>
                    <?= $order->billing_firstname ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('billing_lastname') ?>:</strong>
                    <?= $order->billing_lastname ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('billing_email') ?>:</strong>
                    <?= $order->billing_email ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('billing_mobile') ?>:</strong>
                    <?= $order->billing_mobile ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('billing_address1') ?>:</strong>
                    <?= $order->billing_address1 ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('billing_address2') ?>:</strong>
                    <?= $order->billing_address2 ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('billing_province_id') ?>:</strong>
                    <?= $order->billingProvinceName ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('billing_municipality_id') ?>:</strong>
                    <?= $order->billingMunicipalityName ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('billing_zip') ?>:</strong>
                    <?= $order->billing_zip ?>
                </div>
            </div>

            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
            <div class="bg-light p-30 mb-5">
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_firstname') ?>:</strong>
                    <?= $order->shipping_firstname ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_lastname') ?>:</strong>
                    <?= $order->shipping_lastname ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_email') ?>:</strong>
                    <?= $order->shipping_email ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_mobile') ?>:</strong>
                    <?= $order->shipping_mobile ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_address1') ?>:</strong>
                    <?= $order->shipping_address1 ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_address2') ?>:</strong>
                    <?= $order->shipping_address2 ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_province_id') ?>:</strong>
                    <?= $order->shippingProvinceName ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_municipality_id') ?>:</strong>
                    <?= $order->shippingMunicipalityName ?>
                </div>
                <div>
                    <strong><?= $order->getAttributeLabel('shipping_zip') ?>:</strong>
                    <?= $order->shipping_zip ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom order-total-products" style="max-height: 27em;">
                    <?= App::foreach($order->products, function($product) {
                        $price = App::formatter()->asPeso($product['price']);
                        $productModel = Product::findOne($product['product_id']);
                        $productName = $productModel ? implode(' ', [
                            Html::image($productModel->image, ['w' => 50], ['class' => 'img-fluid']),
                            implode('<br>', array_filter([
                                YiiHtml::a($productModel->name . ' (x' . $product['quantity'] . ')', $productModel->frontendUrl, ['class' => 'text-dark', 'target' => '_blank']),
                                Html::tag('small', implode(' | ', array_filter([$product['color'], $product['size']])), ['class' => 'text-muted font-weight-bold'])
                            ]))
                        ]): $product['name'];


                        return <<< HTML
                            <div class="d-flex justify-content-between">
                                <p>{$productName}</p>
                                <p>{$price}</p>
                            </div>
                        HTML;
                    }) ?>
                </div>
                <div class="border-bottom pt-3 pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6><?= App::formatter()->asPeso($order->subtotal) ?></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium checkout-shipping"><?= App::formatter()->asPeso($order->shipping) ?></h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 class="checkout-total"><?= App::formatter()->asPeso($order->total) ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>