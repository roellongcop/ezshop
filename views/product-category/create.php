<?php

use app\models\search\ProductCategorySearch;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */

$this->title = 'Create Product Category';
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ProductCategorySearch();
?>
<div class="product-category-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>