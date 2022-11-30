<?php

use app\widgets\ActiveForm;
use app\widgets\DataList;
use app\widgets\InputList;
use app\models\Training;
use app\models\Chat;
use app\helpers\App;

/* @var $this yii\web\View */
/* @var $model app\models\Training */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'training-form']); ?>
    <div class="row">
        <div class="col-md-6">
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
        <div class="col-md-6">
            <table class="table table-bordered">
                <tbody>
                    <?= App::foreach((new Chat())->replace(), fn($value, $key) => <<< HTML
                        <tr>
                            <th>{$key}</th>
                            <td>{$value}</td>
                        </tr>
                    HTML) ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>