<?php

use app\widgets\ActiveForm;
use app\widgets\InputList;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-email-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">Price Ranges</h4>
	<div class="row">
		<div class="col-md-6">
			<?= InputList::widget([
                'label' => 'Price range',
                'name' => 'PriceSettingForm[range][]',
                'data' => $model->range,
            ]) ?>
		</div>
	</div>

	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>