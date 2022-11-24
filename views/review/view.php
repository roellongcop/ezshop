<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ReviewSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Review */

$this->title = 'Review: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ReviewSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="review-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>