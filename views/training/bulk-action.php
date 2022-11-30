<?php

use app\widgets\ConfirmBulkAction;
use app\models\search\TrainingSearch;

$this->title = 'Confirm Bulk Action';
$this->params['breadcrumbs'][] = ['label' => 'Trainings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $this->title;
$this->params['showCreateButton'] = true;
$this->params['searchModel'] = new TrainingSearch();
?>
<div class="training-bulk-action-page">
	<?= ConfirmBulkAction::widget([
		'models' => $models,
		'process' => $process,
	    'post' => $post,
	]) ?>
</div>