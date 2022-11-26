<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\CartSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Cart */

$this->title = 'Cart: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new CartSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="cart-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>