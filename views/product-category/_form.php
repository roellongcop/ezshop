<?php

use app\helpers\App;
use app\models\ProductCategory;
use app\widgets\ActiveForm;
use app\widgets\BootstrapSelect;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'product-category-form']); ?>
	<div class="row">
		<div class="col-md-5">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

			<?= ActiveForm::recordStatus([
	            'model' => $model,
	            'form' => $form,
	        ]) ?>
		</div>
	</div>
	<div class="form-group">
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>