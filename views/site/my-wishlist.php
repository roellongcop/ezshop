<?php

use app\helpers\App;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\widgets\Grid;

$this->title = 'My Wishlist';
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = 'My Wishlist';
$this->params['activePage'] = 'my-wishlist';

$this->addJsFile('frontend/js/my-wishlist');
?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-md-12 table-responsive">
            <?= Grid::widget([
                'columns' => [
                    'serial' => ['class' => 'yii\grid\SerialColumn'],
                    'photo' => [
                        'label' => 'Photo',
                        'attribute' => 'id',
                        'format' => 'raw',
                        'value' => 'productImage',
                    ],
                    'product_name' => [
                        'label' => 'Product',
                        'attribute' => 'productName',
                    ],
                    'regular_price' => [
                        'label' => 'Reg. Price',
                        'attribute' => 'productRegularPrice', 
                        'format' => 'peso'
                    ],
                    'sale_price' => [
                        'label' => 'Sale Price',
                        'attribute' => 'productSalePrice', 
                        'format' => 'peso'
                    ],
                    'ago' => [
                        'label' => 'Added',
                        'attribute' => 'created_at', 
                        'format' => 'ago'
                    ],
                    'actions' => [
                        'attribute' => 'id',
                        'format' => 'raw',
                        'label' => 'Remove',
                        'value' => fn($model) => Html::tag('button', '<i class="fa fa-times"></i>', [
                            'type' => 'button',
                            'class' => 'btn-remove-from-wishlist btn btn-sm btn-danger',
                            'data-product_id' => $model->product_id,
                        ])
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