<?php

use app\models\search\ShippingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Shipping */

$this->title = 'Duplicate Shipping: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Shippings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ShippingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="shipping-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>