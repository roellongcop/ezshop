<?php

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
?>
<div class="product-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>