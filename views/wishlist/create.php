<?php

use app\models\search\WishlistSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */

$this->title = 'Create Wishlist';
$this->params['breadcrumbs'][] = ['label' => 'Wishlists', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new WishlistSearch();
?>
<div class="wishlist-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>