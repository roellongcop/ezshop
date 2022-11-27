<?php

use app\widgets\ConfirmBulkAction;
use app\models\search\CartSearch;

$this->title = 'Confirm Bulk Action';
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new CartSearch();
?>
<div class="cart-bulk-action-page">
	<?= ConfirmBulkAction::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>