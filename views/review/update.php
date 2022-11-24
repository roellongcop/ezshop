<?php

use app\models\search\ReviewSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Review */

$this->title = 'Update Review: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ReviewSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="review-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>