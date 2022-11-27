<?php

use app\widgets\ConfirmBulkAction;
use app\models\search\OrderSearch;

$this->title = 'Confirm Bulk Action';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new OrderSearch();
?>
<div class="order-bulk-action-page">
	<?= ConfirmBulkAction::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>