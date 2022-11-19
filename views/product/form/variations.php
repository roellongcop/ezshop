<?php

use app\widgets\InputList;
?>
<h4 class="mb-10 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>

<label>Colors</label>
<?= InputList::widget([
	'label' => 'Color',
	'name' => 'Product[colors][]',
	'data' => $model->colors,
]) ?>

<div class="my-5"></div>
<label>Sizes</label>
<?= InputList::widget([
	'label' => 'Size',
	'name' => 'Product[sizes][]',
	'data' => $model->sizes,
]) ?>