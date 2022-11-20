<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Email */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'email-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
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