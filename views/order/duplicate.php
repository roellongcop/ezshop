<?php

use app\models\search\OrderSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Duplicate Order: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new OrderSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="order-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>