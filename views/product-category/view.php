<?php

use app\models\search\ProductCategorySearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */

$this->title = 'Product Category: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ProductCategorySearch();
$this->params['showCreateButton'] = true; 
?>
<div class="product-category-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model,
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>