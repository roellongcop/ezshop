<?php

use app\widgets\ActiveForm;
use app\widgets\ImageGallery;
use app\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'setting-shipping-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">Chatbot
    	
	<div class="row">
		<div class="col-md-8">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'welcome_message')->textarea(['rows' => 8]) ?>
			<?= $form->field($model, 'default_message')->textarea(['rows' => 8]) ?>
			<?= $form->field($model, 'theme_color')->textInput(['type' => 'color']) ?>
		</div>
		<div class="col-md-4 text-center">
			<div>
				<label>Chatbot Photo</label>
			</div>
			<?= Html::image($model->photo, ['w' => 200], [
                'class' => 'img-thumbnail chatbot-photo',
                'loading' => 'lazy',
            ] ) ?>
            <div class="my-2"></div>

            <?= ImageGallery::widget([
                'tag' => 'Setting',
                'model' => $model,
                'attribute' => 'photo',
                'ajaxSuccess' => "
                    if(s.status == 'success') {
                        $('.chatbot-photo').attr('src', s.src);
                    }
                ",
            ]) ?> 

		</div>
	</div>
	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>