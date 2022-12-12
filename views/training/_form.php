<?php

use app\widgets\ActiveForm;
use app\widgets\DataList;
use app\widgets\InputList;
use app\models\Training;
use app\models\Chat;
use app\helpers\App;

$this->params['wrapCard'] = false;

/* @var $this yii\web\View */
/* @var $model app\models\Training */
/* @var $form app\widgets\ActiveForm */

$this->registerJsFile(App::publishedUrl("/plugins/custom/datatables/datatables.bundle.js"), [
    'depends' => ['app\themes\keen\sub\demo1\main\assets\AppAsset']
]);

$this->registerJs(<<< JS
    $('.datatable').DataTable({
        pageLength: 5,
        order: [[0, 'desc']]
    });
JS);
?>
<?php $form = ActiveForm::begin(['id' => 'training-form']); ?>
    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Training Data'
            ]) ?>
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
                    'data' => $model->response,
                    'type' => 'textarea'
                ]) ?>
                <div class="mt-10"></div>
    			<?= $form->field($model, 'suggestion')->dropDownList([
                    'Multiple' => 'Multiple',
                    'Random' => 'Random',
                ]) ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Available Placeholder'
            ]) ?>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>placeholder</th>
                        <th>description</th>
                        <th>value</th>
                    </thead>
                    <tbody>
                        <?= App::foreach((new Chat())->replace(), function($data, $key) {
                            $value = is_callable($data['value']) ? call_user_func($data['value']): $data['value'];
                            return <<< HTML
                                <tr>
                                    <td>{$key}</td>
                                    <td>{$data['description']}</td>
                                    <td>{$value}</td>
                                </tr>
                            HTML;
                        }) ?>
                    </tbody>
                </table>
            <?php $this->endContent() ?>
        </div>
    </div>
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>