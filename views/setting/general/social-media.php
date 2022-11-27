<?php

use app\helpers\App;
use app\widgets\ActiveForm;
use app\widgets\TinyMce;


?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-social-media-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">Social Media</h4>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'linkedin')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>
		</div>
	</div>


	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>