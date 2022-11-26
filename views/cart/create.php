<?php

use app\models\search\CartSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Cart */

$this->title = 'Create Cart';
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new CartSearch();
?>
<div class="cart-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>