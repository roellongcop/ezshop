<?php

use app\helpers\App;
use app\widgets\ActiveForm;
use app\widgets\TinyMce;

$this->registerJsFile(App::publishedUrl("/plugins/custom/tinymce/tinymce.bundle.js"), [
    'depends' => App::setting('theme')->appAssetClass
]);

?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-notification-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">Notification</h4>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'owner')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'shop_name')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?= TinyMce::widget([
				'model' => $model,
				'attribute' => 'information'
			]) ?>
		</div>
	</div>

	<div class="row mt-10">
		<div class="col-md-12">
			<?= $form->field($model, 'mapIframe')->textarea(['rows' => 8]) ?>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>