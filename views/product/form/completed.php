<?php

use app\helpers\Url;
use app\helpers\Html;
use app\widgets\InputList;
?>
<h4 class="mb-10 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>

<h6 class="font-weight-bolder mb-3">
	General Information:
	<a href="<?= Url::current(['step' => 'general']) ?>">
		<i class="fa fa-edit"></i>
	</a>
</h6>
<div class="text-dark-50 line-height-lg">
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('name') ?>:
		</span> 
		<?= $model->name ?>
	</div>
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('regular_price') ?>:
		</span> 
		<?= number_format($model->regular_price) ?> 
	</div>
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('sale_price') ?>:
		</span> 
		<?= number_format($model->sale_price) ?>
	</div>

	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('description') ?>:
		</span> 
		<?= $model->description ?>
	</div>
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('categories') ?>:
		</span> 
		<ul>
			<?= Html::foreach($model->categories, function($category) {
				return Html::tag('li', $category);
			}) ?>
		</ul>
	</div>
</div>


<div class="separator separator-dashed my-5"></div>
<h6 class="font-weight-bolder mb-3">
	Inventory Details:
	<a href="<?= Url::current(['step' => 'inventory']) ?>">
		<i class="fa fa-edit"></i>
	</a>
</h6>
<div class="text-dark-50 line-height-lg">
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('sku') ?>:
		</span> 
		<?= $model->sku ?>
	</div>
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('quantity') ?>:
		</span> 
		<?= number_format($model->quantity) ?>
	</div>
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('low_stock_threshold') ?>:
		</span> 
		<?= number_format($model->low_stock_threshold) ?>
	</div>
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('high_stock_threshold') ?>:
		</span> 
		<?= number_format($model->high_stock_threshold) ?>
	</div>

	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('stock_threshold_status') ?>:
		</span>
		<?= $model->thresholdBagde ?>
	</div>
</div>


<div class="separator separator-dashed my-5"></div>
<h6 class="font-weight-bolder mb-3">
	Photos:
	<a href="<?= Url::current(['step' => 'photos']) ?>">
		<i class="fa fa-edit"></i>
	</a>
</h6>
<div class="text-dark-50 line-height-lg">
	<div>
		<span class="font-weight-bolder"> Primary Image </span>
		<div>
			<?= Html::image($model->image, ['w' => 200], ['class' => 'img-thumbnail']) ?>
		</div>
	</div>

	<div class="mt-2">
		<span class="font-weight-bolder"> Gallery </span>
		<div class="row">
			<?= Html::foreach($model->imageFiles, function($file) {
				return Html::tag('div', Html::image($file, ['w' => 200], ['class' => 'img-thumbnail']), [
					'class' => 'col-md-4'
				]);
			}) ?>
		</div>
	</div>
</div>


<div class="separator separator-dashed my-5"></div>
<h6 class="font-weight-bolder mb-3">
	Variations:
	<a href="<?= Url::current(['step' => 'variations']) ?>">
		<i class="fa fa-edit"></i>
	</a>
</h6>
<div class="text-dark-50 line-height-lg">
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('colors') ?>:
		</span> 
		<ul>
			<?= Html::foreach($model->colors, function($color) {
				return Html::tag('li', $color);
			}) ?>
		</ul>
	</div>

	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('sizes') ?>:
		</span> 
		<ul>
			<?= Html::foreach($model->sizes, function($size) {
				return Html::tag('li', $size);
			}) ?>
		</ul>
	</div>
</div>


<div class="separator separator-dashed my-5"></div>
<h6 class="font-weight-bolder mb-3">
	Other Details:
	<a href="<?= Url::current(['step' => 'others']) ?>">
		<i class="fa fa-edit"></i>
	</a>
</h6>
<div class="text-dark-50 line-height-lg">
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('added_shipping_fee') ?>:
		</span> 
		<?= number_format($model->added_shipping_fee) ?>
	</div>
	<div>
		<span class="font-weight-bolder">
			<?= $model->getAttributeLabel('tags') ?>:
		</span> 
		<ul>
			<?= Html::foreach($model->tags, function($tag) {
				return Html::tag('li', $tag);
			}) ?>
		</ul>
	</div>
</div>