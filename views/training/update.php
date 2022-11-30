<?php

use app\models\search\TrainingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Training */

$this->title = 'Update Training: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Trainings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new TrainingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="training-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>