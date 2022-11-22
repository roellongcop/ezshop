<?php

use app\models\search\WishlistSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */

$this->title = 'Duplicate Wishlist: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Wishlists', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new WishlistSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="wishlist-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>