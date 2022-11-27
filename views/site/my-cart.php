<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\widgets\Grid;
use app\widgets\Search;
use app\widgets\ActiveForm;
use app\models\Cart;


$this->title = 'My Cart';
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = 'My Cart';
$this->params['activePage'] = 'my-cart';

$this->addJsFile('frontend/js/my-cart', [
    'app\assets\frontend\AppAsset'
]);

$subtotal = Cart::subtotal();
$shipping = Cart::shipping();
?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-2">
            <?php $form = ActiveForm::begin([
                'id' => 'main-search-form',
                'action' => ['site/my-cart'], 
                'method' => 'get'
            ]); ?>
                <?= Search::widget([
                    'url' => Url::toRoute(['site/find-cart-by-keywords']),
                    'submitOnclick' => true,
                    'model' => $searchModel,
                ]) ?>
            <?php ActiveForm::end(); ?>

            <?= Html::beginForm(['site/my-cart'], 'post', ['id' => 'cart-form']) ?>
                <?= Grid::widget([
                    'columns' => [
                        'serial' => ['class' => 'yii\grid\SerialColumn'],
                         'photo' => [
                            'label' => 'Photo',
                            'attribute' => 'productName',
                            'format' => 'raw',
                            'value' => 'productImage',
                            'contentOptions' => ['class' => 'align-middle']
                        ],
                        'product_name' => [
                            'label' => 'Product',
                            'attribute' => 'productName',
                            'contentOptions' => ['class' => 'align-middle'],
                            'format' => 'raw'
                        ],
                        'sale_price' => [
                            'label' => 'Price',
                            'attribute' => 'productSalePrice', 
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'align-middle'],
                            'value' => function($model) {
                                return $model->productDisplayPrice;
                            }
                        ],
                        'quantity' => [
                            'label' => 'Quantity',
                            'attribute' => 'quantity', 
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'align-middle'],
                            'value' => function($model) {
                                return <<< HTML
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input name="cart[{$model->id}]" type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="{$model->quantity}">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                HTML;
                            }
                        ],

                        'total' => [
                            'label' => 'Total',
                            'attribute' => 'total', 
                            'format' => 'peso',
                            'contentOptions' => ['class' => 'align-middle'],
                        ],
                        'actions' => [
                            'attribute' => 'productName',
                            'format' => 'raw',
                            'label' => 'Remove',
                            'value' => fn($model) => Html::tag('button', '<i class="fa fa-times"></i>', [
                                'type' => 'button',
                                'class' => 'btn-remove-from-cart btn btn-sm btn-danger',
                                'data-product_id' => $model->product_id,
                            ]),
                            'contentOptions' => ['class' => 'align-middle']
                        ],
                    ],
                    
                    'headerRowOptions' => [
                        'class' => 'thead-dark'
                    ],
                    'tableOptions' => [
                        'class' => 'table table-light table-borderless table-hover text-center mb-0'
                    ],
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'pager' => [
                        'class' => 'yii\widgets\LinkPager',
                        'options' => [
                            'class' => 'pagination justify-content-center'
                        ],
                        'registerLinkTags' => true,
                        'nextPageLabel' => 'Next',
                        'prevPageLabel' => 'Previous',
                        'linkContainerOptions' => ['class' => 'page-item'],
                        'linkOptions' => ['class' => 'page-link'],
                        'activePageCssClass' => 'active',
                        'disabledListItemSubTagOptions' => [
                            'tag' => 'a',
                            'class' => 'page-link'
                        ]
                    ]
                ]); ?>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-lg btn-update-cart">
                        Update Cart
                    </button>
                </div>
            <?= Html::endForm() ?> 
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>
                            <?= App::formatter('asPeso', $subtotal) ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping
                        </h6>
                        <h6 class="font-weight-medium">
                            <?= App::formatter('asPeso', $shipping) ?>
                        </h6>
                    </div>
                    <small>May change depends on your shipping address</small>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>
                            <?= App::formatter('asPeso', $subtotal + $shipping) ?>
                        </h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>