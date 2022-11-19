<?php

use app\models\search\ProductCategorySearch;
use app\widgets\ConfirmBulkAction;

$this->title = 'Confirm Bulk Action';
$this->params['breadcrumbs'][] = ['label' => 'ProductCategorys', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new ProductCategorySearch();
?>
<div class="product-category-bulk-action-page">
	<?= ConfirmBulkAction::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>