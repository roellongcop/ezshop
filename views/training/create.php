<?php

use app\models\search\TrainingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Training */

$this->title = 'Create Training';
$this->params['breadcrumbs'][] = ['label' => 'Trainings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new TrainingSearch();
?>
<div class="training-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>