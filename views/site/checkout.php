<?php

use app\widgets\ActiveForm;
use app\models\Municipality;
use app\models\Province;
use app\helpers\App;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;

$this->title = 'Checkout';
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = ['label' => 'My Cart', 'url' => ['site/my-cart']];
$this->params['breadcrumbs'][] = 'Checkout';
$this->params['activePage'] = 'my-cart';

$this->addJsFile('frontend/js/checkout', ['app\assets\frontend\AppAsset'], [
    'type' => 'module'
]);
?>

<div class="container-fluid">
    <?php $form = ActiveForm::begin(['id' => 'billing-form']); ?>
    <div class="row px-xl-5">

        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_firstname')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_lastname')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_email')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_mobile')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_address1')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_address2')->textInput(['maxlength' => true]) ?>
                    </div>
               

                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_province_id')->dropDownList(Province::dropdown('id', 'Province'), [
                                'prompt' => 'Select Province'
                            ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_municipality_id')->dropDownList(
                            App::ifElse($order->billingProv, fn($prov) => Municipality::dropdown('id', 'Municipality', ['prov' => $prov]) ?: [], [])
                        ) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'billing_zip')->textInput(['maxlength' => true]) ?>
                    </div>
                  
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input name="Order[shipTo]" type="checkbox" class="custom-control-input" id="shipto" value="different" <?= $order->shipTo == 'same'? '': 'checked' ?>>
                            <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse mb-5" id="shipping-address">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
                <div class="bg-light p-30 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_firstname')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_lastname')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_email')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_mobile')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_address1')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_address2')->textInput(['maxlength' => true]) ?>
                    </div>
               

                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_province_id')->dropDownList(Province::dropdown('id', 'Province'), [
                                'prompt' => 'Select Province'
                            ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_municipality_id')->dropDownList([]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'shipping_zip')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom">
                    <h6 class="mb-3">Products</h6>
                    <?= App::foreach($order->products, function($product) {
                        $price = App::formatter()->asPeso($product['price']);
                        return <<< HTML
                            <div class="d-flex justify-content-between">
                                <p>{$product['name']}</p>
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
                        <h6 class="font-weight-medium"><?= App::formatter()->asPeso($order->shipping) ?></h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5><?= App::formatter()->asPeso($order->total) ?></h5>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                <div class="bg-light p-30">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="paypal">
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                            <label class="custom-control-label" for="directcheck">Direct Check</label>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                            <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>