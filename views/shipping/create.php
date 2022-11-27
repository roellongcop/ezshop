<?php

use app\models\search\ShippingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Shipping */

$this->title = 'Create Shipping';
$this->params['breadcrumbs'][] = ['label' => 'Shippings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ShippingSearch();
?>
<div class="shipping-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>