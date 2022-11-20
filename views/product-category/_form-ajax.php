<?php

use app\helpers\Html;
use app\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-' . time(),
    'addClass' => 'product-category-form-ajax',
    'enableAjaxValidation' => true,
    'validationUrl' => ['product-category/create', 'ajaxValidate' => true]
]); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'value')->textarea(['rows' => 8]) ?>
        </div>
    </div>
    <div class="form-group float-right">
        <?= Html::submitButton('Save', [
            'class' => 'btn btn-success',
        ]) ?>

        <?= Html::resetButton('Cancel', [
            'class' => 'btn btn-light-danger', 
            'data-dismiss' => 'modal',
        ]) ?>
        
    </div>
<?php ActiveForm::end(); ?>