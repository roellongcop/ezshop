<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\widgets\Grid;
use app\widgets\Search;
use app\widgets\ActiveForm;

$this->title = 'My Reviews';
$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = 'My Reviews';
$this->params['activePage'] = 'my-reviews';

?>

<div class="container-fluid">
    <div class="my-3 text-center">
        <div style="max-width: 500px;margin: 0 auto;">
            <?php $form = ActiveForm::begin([
                'id' => 'main-search-form',
                'action' => ['site/my-reviews'], 
                'method' => 'get'
            ]); ?>
                <?= Search::widget([
                    'url' => Url::toRoute(['site/find-reviews-by-keywords']),
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
                        'value' => fn($model) => YiiHtml::a($model->productName, $model->productFrontendUrl, ['class' => 'text-dark']),
                        'contentOptions' => ['class' => 'align-middle'],
                        'format' => 'raw'
                    ],
                    'review' => [
                        'attribute' => 'review', 
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'align-middle', 'style' => 'max-width: 200px']
                    ],
                    'score' => [
                        'attribute' => 'score', 
                        'format' => 'raw',
                        'value' => fn($model) => $model->generateStar('<i class="text-warning fas fa-star"></i>', '<i class="text-warning far fa-star"></i>'),
                        'contentOptions' => ['class' => 'align-middle']
                    ],
                    'ago' => [
                        'label' => 'Published',
                        'attribute' => 'created_at', 
                        'format' => 'ago',
                        'contentOptions' => ['class' => 'align-middle']
                    ],
                    'actions' => [
                        'attribute' => 'record_status',
                        'format' => 'raw',
                        'label' => 'Status',
                        'value' => 'statusBadge',
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