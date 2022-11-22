<?php

use app\widgets\ConfirmBulkAction;
use app\models\search\WishlistSearch;

$this->title = 'Confirm Bulk Action';
$this->params['breadcrumbs'][] = ['label' => 'Wishlists', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new WishlistSearch();
?>
<div class="wishlist-bulk-action-page">
	<?= ConfirmBulkAction::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>