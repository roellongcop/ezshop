<?php

use app\models\search\ReviewSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Review */

$this->title = 'Create Review';
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ReviewSearch();
?>
<div class="review-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>