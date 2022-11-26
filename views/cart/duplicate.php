<?php

use app\models\search\CartSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Cart */

$this->title = 'Duplicate Cart: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new CartSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="cart-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>