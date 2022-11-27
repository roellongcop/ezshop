<?php

use app\models\search\ShippingSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Shipping */

$this->title = 'Update Shipping: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Shippings', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ShippingSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="shipping-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>