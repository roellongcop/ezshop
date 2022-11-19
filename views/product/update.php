<?php

use app\models\search\ProductSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Update Product: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ProductSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false;
?>
<div class="product-update-page">
	<?= $this->render('_form', [
        'model' => $model,
        'activeStep' => $activeStep,
        'stepForms' => $stepForms
    ]) ?>
</div>