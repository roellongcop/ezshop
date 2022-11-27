<?php

use app\helpers\App;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\widgets\Grid;

$this->title = 'My Wishlist';
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = 'My Wishlist';
$this->params['activePage'] = 'my-wishlist';

$this->addJsFile('frontend/js/my-wishlist', ['app\assets\frontend\AppAsset'], [
    'type' => 'module'
]);
?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-md-12 table-responsive">
            <?= Grid::widget([
                'layout' => $this->render('_grid-layout', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'content' => $this->render('_grid-search-input', [
                        'searchModel' => $searchModel
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
                        'value' => fn($model) => YiiHtml::a($model->productName, $model->productFrontendUrl, ['class' => 'text-dark']),
                        'contentOptions' => ['class' => 'align-middle'],
                        'format' => 'raw'
                    ],
                    'regular_price' => [
                        'label' => 'Reg. Price',
                        'attribute' => 'productRegularPrice', 
                        'format' => 'peso',
                        'contentOptions' => ['class' => 'align-middle']
                    ],
                    'sale_price' => [
                        'label' => 'Sale Price',
                        'attribute' => 'productSalePrice', 
                        'format' => 'peso',
                        'contentOptions' => ['class' => 'align-middle']
                    ],
                    'ago' => [
                        'label' => 'Added',
                        'attribute' => 'created_at', 
                        'format' => 'ago',
                        'contentOptions' => ['class' => 'align-middle']
                    ],
                    'actions' => [
                        'attribute' => 'productName',
                        'format' => 'raw',
                        'label' => 'Remove',
                        'value' => fn($model) => implode(' ', [
                            Html::tag('button', '<i class="fa fa-times"></i>', [
                                'type' => 'button',
                                'class' => 'btn-remove-from-wishlist btn btn-sm btn-danger',
                                'data-product_id' => $model->product_id,
                                'title' => 'Remove From Cart',
                                'data-toggle' => 'tooltip'
                            ]),
                            Html::tag('button', '<i class="fa fa-shopping-cart"></i>', [
                                'type' => 'button',
                                'class' => 'btn-add-to-cart btn btn-sm btn-success',
                                'data-product_id' => $model->product_id,
                                'title' => 'Add To Cart',
                                'data-toggle' => 'tooltip'
                            ])
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
        </div>
    </div>
</div>