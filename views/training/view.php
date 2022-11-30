<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\TrainingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Training */

$this->title = 'Training: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Trainings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new TrainingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="training-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>