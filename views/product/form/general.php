<?php

use app\widgets\Checkbox;
use app\models\ProductCategory;

$this->addJsFile('js/create-product');
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
	<div class="col-md-4 product-categories-container">
		<label>
			Categories 
			<span class="badge badge-secondary pointer btn-add-new-category">Add New</span>
		</label>

		<?= Checkbox::widget([
			'data' => ProductCategory::dropdown('name', 'name'),
			'name' => 'Product[categories][]',
			'checkedFunction' => function($key, $value) use($model) {
				return in_array($value, $model->categories) ? 'checked': '';
			}
		]) ?>
	</div>
</div>



<div class="modal fade" id="modal-add-category" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>