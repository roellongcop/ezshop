<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\widgets\Grid;
use app\models\Cart;
use yii\widgets\Pjax;


$this->title = 'My Cart';
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = 'My Cart';
$this->params['activePage'] = 'my-cart';

$this->addJsFile('frontend/js/my-cart', ['app\assets\frontend\AppAsset'], [
    'type' => 'module'
]);

$searchModel->searchLabel = 'from Cart';
$subtotal = Cart::subtotal();
$shipping = Cart::shipping();
?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-2 cart-grid">
            <?php Pjax::begin([
                'timeout' => false,
                'linkSelector' => '.pagination a.page-link'
            ]); ?>
                <?= Grid::widget([
                    'layout' => $this->render('_grid-layout', [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'content' => $this->render('_grid-search-input', [
                            'searchModel' => $searchModel,
                            'action' => ['site/my-cart'],
                            'url' => Url::toRoute(['site/find-cart-by-keywords'])
                        ])
                    ]),
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
                            'format' => 'raw',
                            'value' => 'productTableView',
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
                                    <form method="post">
                                        
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input max="{$model->productQuantity}" data-product-id="{$model->id}" type="number" class="form-control form-control-sm bg-secondary border-0 text-center qty-input" value="{$model->quantity}">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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
                                'data-id' => $model->id,
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
            <?php Pjax::end(); ?>
            <div class="text-right">
                <?= App::if($dataProvider->totalCount, <<< HTML
                    <button type="submit" class="btn btn-primary font-weight-bold py-2 text-uppercase btn-update-cart">
                        Update Cart
                    </button>
                HTML) ?>
            </div>
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

                    <?= Html::a('Proceed To Checkout', ['site/checkout'], [
                        'class' => 'btn btn-block btn-primary font-weight-bold my-3 py-3'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>