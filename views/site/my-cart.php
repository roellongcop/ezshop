<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\widgets\Grid;
use app\widgets\Search;
use app\widgets\ActiveForm;

$this->title = 'My Cart';
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = 'My Cart';
$this->params['activePage'] = 'my-cart';

$this->addJsFile('frontend/js/my-cart');
?>

<div class="container-fluid">
    <div class="my-3 text-center">
        <div style="max-width: 500px;margin: 0 auto;">
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
        </div>
    </div>

    <div class="row px-xl-5">
        <div class="col-md-12 table-responsive">
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
                        'value' => fn($model) => implode('<br>', [
                            YiiHtml::a($model->productName, $model->productFrontendUrl, ['class' => 'text-dark']),
                            Html::tag('small', implode(' | ', array_filter([$model->color, $model->size])), ['class' => 'text-muted font-weight-bold'])
                        ]),
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
        </div>
    </div>
</div>