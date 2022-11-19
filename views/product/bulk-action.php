<?php

use app\widgets\ConfirmBulkAction;
use app\models\search\ProductSearch;

$this->title = 'Confirm Bulk Action';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new ProductSearch();
?>
<div class="product-bulk-action-page">
	<?= ConfirmBulkAction::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>