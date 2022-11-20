<?php

use app\helpers\App;
use app\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\ImageGallery;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'product-category-form']); ?>
	<div class="row">
		<div class="col-md-5">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>
		</div>
		<div class="col-md-7">
			<?= Html::image($model->files, ['w' => 200], [
			    'class' => 'img-thumbnail product-category-photo',
			    'loading' => 'lazy',
			] ) ?>
			<div class="my-2"></div>

			<?= ImageGallery::widget([
				'finalCropWidth' => 1000,
				'finalCropHeight' => 430,
			    'tag' => 'Product',
			    'model' => $model,
			    'attribute' => 'files',
			    'ajaxSuccess' => "
			        if(s.status == 'success') {
			            $('.product-category-photo').attr('src', s.src);
			        }
			    ",
			]) ?> 
		</div>
	</div>
	<div class="form-group">
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>