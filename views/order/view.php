<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\OrderSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Order: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new OrderSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="order-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>