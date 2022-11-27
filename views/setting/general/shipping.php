<?php

use app\widgets\ActiveForm;
use app\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-shipping-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">Shipping
    	<?= Html::a('View all Shipping', ['shipping/index'], [
    		'class' => 'btn btn-primary btn-sm'
    	]) ?>
	<div class="row">
		<div class="col-md-4">
			<?= $form->field($model, 'flat_rate')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>