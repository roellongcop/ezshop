<?php

use app\models\search\ProductCategorySearch;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */

$this->title = 'Duplicate Product Category: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ProductCategorySearch();
$this->params['showCreateButton'] = true;
?>
<div class="product-category-duplicate-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>