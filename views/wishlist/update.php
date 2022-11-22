<?php

use app\models\search\WishlistSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */

$this->title = 'Update Wishlist: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Wishlists', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new WishlistSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="wishlist-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>