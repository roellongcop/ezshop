<?php

use app\models\search\ReviewSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Review */

$this->title = 'Duplicate Review: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ReviewSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="review-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>