<?php

use app\helpers\Html;
use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ProductSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Product: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ProductSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false; 
?>
<div class="product-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Html::tag('a', 'View on Shop', [
        'href' => $model->frontendUrl,
        'class' => 'btn btn-primary',
        'target' => '_blank'
    ]) ?>
    <div class="my-2"></div>
    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'General Information',
                'stretch' => true
            ]) ?>
                <?= Detail::widget([
                    'model' => $model,
                    'attributes' => [
                        'name:raw',
                        'regular_price:numberFormat',
                        'sale_price:numberFormat',
                        'description:raw',
                        'categories:ul',
                    ]
                ]) ?>
            
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Inventory',
                'stretch' => true
            ]) ?>
                <?= Detail::widget([
                    'model' => $model,
                    'attributes' => [
                        'sku:raw',
                        'quantity:numberFormat',
                        'low_stock_threshold:numberFormat',
                        'high_stock_threshold:numberFormat',
                        'thresholdBagde:raw',
                    ]
                ]) ?>
            
            <?php $this->endContent() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Other Details',
                'stretch' => true
            ]) ?>
                <?= Detail::widget([
                    'model' => $model,
                    'attributes' => [
                        'added_shipping_fee:numberFormat',
                        'tags:ul',
                    ]
                ]) ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'System Data',
                'stretch' => true
            ]) ?>
                <?= Detail::widget([
                    'model' => $model,
                    'attributes' => $model->footerDetailColumns
                ]) ?>
            <?php $this->endContent() ?>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-3">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Main Image',
                'stretch' => true
            ]) ?>
                <div class="text-center">
                    <?= Html::image($model->image, ['w' => 200], ['class' => 'img-fluid']) ?>
                </div>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-9">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Gallery',
                'stretch' => true
            ]) ?>
                <div class="row">
                    <?= Html::ifElse($model->imageFiles, function($files) {
                        return Html::tag(
                            'div', 
                            Html::foreach($files, function($file) {
                                return Html::tag('div', Html::image($file, ['w' => 200], ['class' => 'img-thumbnail']), [
                                    'class' => 'col-md-4'
                                ]);
                            }), 
                            [
                                'class' => 'row'
                            ]
                        );
                    }, "No Photo Gallery") ?>
                </div>
            <?php $this->endContent() ?>
        </div>
    </div>
</div>