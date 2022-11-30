<?php

use app\models\search\TrainingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Training */

$this->title = 'Duplicate Training: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Trainings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new TrainingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="training-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>