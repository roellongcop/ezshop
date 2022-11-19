<?php

use app\widgets\InputList;
?>
<h4 class="mb-10 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>

<?= $form->field($model, 'added_shipping_fee')->textInput(['maxlength' => true]) ?>

<?= InputList::widget([
	'label' => 'Tag',
	'name' => 'Product[tags][]',
	'data' => $model->tags,
]) ?>