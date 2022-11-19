<?php

use app\models\search\ProductSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Duplicate Product: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ProductSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="product-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
        'activeStep' => $activeStep,
        'stepForms' => $stepForms
    ]) ?>
</div>