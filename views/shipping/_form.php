<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shipping */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'shipping-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'province_id')->textInput() ?>
			<?= $form->field($model, 'municipality_id')->textInput() ?>
			<?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>
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