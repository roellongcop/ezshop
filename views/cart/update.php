<?php

use app\models\search\CartSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Cart */

$this->title = 'Update Cart: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new CartSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="cart-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>