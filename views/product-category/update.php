<?php

use app\models\search\ProductCategorySearch;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */

$this->title = 'Update Product Category: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'ProductCategories', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ProductCategorySearch();
$this->params['showCreateButton'] = true; 
?>
<div class="product-category-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>