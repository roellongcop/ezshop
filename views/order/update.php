<?php

use app\models\search\OrderSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Update Order: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new OrderSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="order-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>