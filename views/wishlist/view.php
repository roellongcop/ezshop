<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\WishlistSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */

$this->title = 'Wishlist: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Wishlists', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new WishlistSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="wishlist-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>