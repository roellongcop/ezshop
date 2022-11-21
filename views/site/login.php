<?php
/* @var $this yii\web\View */
use app\helpers\App;
use app\helpers\Html;
use app\widgets\ActiveForm;

$this->title = 'Sign In';
$this->params['breadcrumbs'][] = 'Sign In';
?>
<div class="container-fluid signup-container">
    <h2 class="text-center section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Sign In</span>
    </h2>
    <div class="content-container">
        <div class="contact-form bg-light p-30">
            <?php $form = ActiveForm::begin(['id' => 'signin-form']); ?>
                <?= $form->field($model, 'username')->textInput([
                    'maxlength' => true,
                ])->label('Email') ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                <?= Html::submitButton('Sign In', [
                    'class' => 'btn btn-primary py-2 px-4'
                ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>