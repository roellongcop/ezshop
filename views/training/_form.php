<?php

use app\widgets\ActiveForm;
use app\widgets\DataList;
use app\widgets\InputList;
use app\models\Training;

/* @var $this yii\web\View */
/* @var $model app\models\Training */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'training-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'query')->textInput(['maxlength' => true]) ?>
            <?= DataList::widget([
                'form' => $form,
                'model' => $model,
                'attribute' => 'intent',
                'data' => Training::filter('intent')
            ]) ?>

            <label>Response</label>
            <?= InputList::widget([
                'label' => 'Response',
                'name' => 'Training[response][]',
                'data' => $model->response
            ]) ?>

			<?php # $form->field($model, 'suggestion')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>