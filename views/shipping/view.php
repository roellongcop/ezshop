<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ShippingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Shipping */

$this->title = 'Shipping: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Shippings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ShippingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="shipping-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>