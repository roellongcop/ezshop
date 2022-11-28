<?php

use app\widgets\ActiveForm;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use app\models\Province;
use app\models\Municipality;

$this->title = 'My Account Details';
$this->params['activePage'] = 'my-account-details';


$this->params['homeBreadcrumbs'] = YiiHtml::a('Dashboard', ['site/customer-dashboard'], ['class' => 'breadcrumb-item text-dark']);
$this->params['breadcrumbs'][] = 'My Account Details';

$this->addJsFile('frontend/js/my-account-details', ['app\assets\frontend\AppAsset'], [
    'type' => 'module'
]);
?>
<div class="container-fluid">
    <h2 class="text-center section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">My Account Details</span>
    </h2>
    <div class="row px-xl-5 pb-3">
        <div class="col-md-8">
            <div class="bg-light p-30">
                <p class="lead text-uppercase pointer font-weight-bold">
                    Billing Detail Information
                </p>

                <?php $form = ActiveForm::begin(['id' => 'billing-form']); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($billing, 'first_name')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($billing, 'last_name')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($billing, 'email')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($billing, 'phone')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($billing, 'province_id')->dropDownList(Province::dropdown('id', 'Province'), [
                                'prompt' => 'Select Province'
                            ]) ?>
                            <?= $form->field($billing, 'city_id')->dropDownList(Municipality::dropdown('id', 'Municipality', ['prov' => $billing->prov])) ?>
                            <?= $form->field($billing, 'street')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($billing, 'zip')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <?= Html::submitButton('Save changes', [
                        'class' => 'btn btn-primary'
                    ]) ?>

                <?php ActiveForm::end(); ?>

            </div>
            
        </div>
        <div class="col-md-4">
            <div class="bg-light p-30">
                <p class="lead text-uppercase pointer font-weight-bold">
                    Change Password
                </p>
                <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>
                    <?= $form->field($password, 'old_password')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($password, 'new_password')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($password, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($password, 'password_hint')->textInput(['maxlength' => true]) ?>

                    <?= Html::submitButton('Change Password', [
                        'class' => 'btn btn-primary'
                    ]) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
