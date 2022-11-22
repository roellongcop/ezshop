<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Wishlist */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'wishlist-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'user_id')->textInput() ?>
			<?= $form->field($model, 'product_id')->textInput() ?>
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