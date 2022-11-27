<?php

use app\models\search\OrderSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Create Order';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new OrderSearch();
?>
<div class="order-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>