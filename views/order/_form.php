<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'order-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'billing_firstname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'billing_lastname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'billing_email')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'billing_mobile')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'billing_address1')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'billing_province_id')->textInput() ?>
			<?= $form->field($model, 'billing_municipality_id')->textInput() ?>
			<?= $form->field($model, 'billing_zip')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipping_firstname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipping_lastname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipping_email')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipping_mobile')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipping_address1')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipping_province_id')->textInput() ?>
			<?= $form->field($model, 'shipping_municipality_id')->textInput() ?>
			<?= $form->field($model, 'shipping_zip')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'products')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'shipping')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'payment_mode')->textInput() ?>
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