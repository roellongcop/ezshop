<?php
/* @var $this yii\web\View */
use app\helpers\App;
use yii\helpers\Html as YiiHtml;
use app\helpers\Html;
use app\widgets\ActiveForm;

$this->title = 'Sign Up';
$this->params['activePage'] = 'sign-up';
// $this->params['breadcrumbs'][] = 'Sign Up';
?>
<div class="container-fluid signup-container">
    <h2 class="text-center section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Sign Up</span>
    </h2>
    <div class="content-container">
        <div class="contact-form bg-light p-30">
            <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
                <p>
                    Already have an account? <?= YiiHtml::a('Sign In here', ['site/login']) ?>
                </p>
                <?= Html::submitButton('Sign Up', [
                    'class' => 'btn btn-primary py-2 px-4'
                ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>