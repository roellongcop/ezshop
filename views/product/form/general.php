<?php

use app\widgets\Checkbox;
use app\models\ProductCategory;

$this->addJsFile('create-product');
?>
<h4 class="mb-10 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>

<div class="row">
	<div class="col-md-8">
		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

		<div class="row">
			<div class="col-md-6">
			<?= $form->field($model, 'regular_price')->textInput(['type' => 'number']) ?>
			</div>
			<div class="col-md-6">
			<?= $form->field($model, 'sale_price')->textInput(['type' => 'number']) ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<label>
			Categories 
			<span class="badge badge-secondary pointer btn-add-new-category">Add New</span>
		</label>

		<?= Checkbox::widget([
			'data' => ProductCategory::dropdown('name', 'name'),
			'name' => 'Product[categories][]'
		]) ?>
	</div>
</div>

