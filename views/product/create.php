<?php

use app\models\search\ProductSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ProductSearch();
$this->params['wrapCard'] = false;
?>
<div class="product-create-page">
	<?= $this->render('_form', [
		'model' => $model,
        'activeStep' => $activeStep,
        'stepForms' => $stepForms
	]) ?>
</div>