<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\widgets\Grid;
use yii\widgets\Pjax;

$this->title = 'My Orders';
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = 'My Orders';
$this->params['activePage'] = 'my-orders';

?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-md-12 table-responsive">
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
                            'action' => ['site/my-orders'],
                            'url' => Url::toRoute(['site/find-orders-by-keywords'])
                        ])
                    ]),
                    'columns' => [
                        'serial' => ['class' => 'yii\grid\SerialColumn'],
                        'order_no' => [
                            'label' => 'Order No',
                            'attribute' => 'order_no',
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'align-middle'],
                            'value' => fn($model) => YiiHtml::a($model->order_no, ['site/view-order', 'order_no' => $model->order_no], ['class' => 'text-dark'])
                        ],

                        'total_products' => [
                            'label' => 'Total Product',
                            'attribute' => 'products',
                            'value' => 'totalProducts',
                            'format' => 'raw'
                        ],

                        'shipping' => [
                            'attribute' => 'shipping', 
                            'format' => 'peso',
                            'contentOptions' => ['class' => 'align-middle']
                        ],
                    
                        'total' => [
                            'attribute' => 'total', 
                            'format' => 'peso',
                            'contentOptions' => ['class' => 'align-middle']
                        ],
                    
                        'ago' => [
                            'label' => 'Date',
                            'attribute' => 'created_at', 
                            'format' => 'ago',
                            'contentOptions' => ['class' => 'align-middle']
                        ],
                        'address1' => [
                            'label' => 'Shipping Address',
                            'attribute' => 'billing_address1', 
                            'value' => 'shippingAddress1',
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'align-middle']
                        ],
                        'actions' => [
                            'attribute' => 'record_status',
                            'format' => 'raw',
                            'label' => 'Status',
                            'value' => 'statusBadgeFront',
                            'contentOptions' => ['class' => 'align-middle']
                        ],

                        'cancel' => [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'label' => 'Action',
                            'value' => 'cancelButton',
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
        </div>
    </div>
</div>