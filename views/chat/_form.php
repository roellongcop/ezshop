<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'chat-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'user_id')->textInput() ?>
			<?= $form->field($model, 'reply_id')->textInput() ?>
			<?= $form->field($model, 'session_id')->textInput(['maxlength' => true]) ?>
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