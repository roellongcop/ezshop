<?php

use app\widgets\ActiveForm;
use app\models\Province;
use app\models\Municipality;

/* @var $this yii\web\View */
/* @var $model app\models\Shipping */
/* @var $form app\widgets\ActiveForm */

$this->addJsFile('js/shipping-form');
?>
<?php $form = ActiveForm::begin(['id' => 'shipping-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'province_id')->dropDownList(
                Province::dropdown('id', 'name'), [
                    'prompt' => 'Select Province'
                ]
            ) ?>

			<?= $form->field($model, 'municipality_id')->dropDownList(
                ($model->provinceNo ? Municipality::dropdown('id', 'name', ['province_no' => $model->provinceNo]): [])
            ) ?>

			<?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>