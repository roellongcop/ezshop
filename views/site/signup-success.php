<?php

use yii\helpers\Html as YiiHtml;
/* @var $this yii\web\View */
$this->title = 'Sign Up: Email Verification';
$this->params['breadcrumbs'][] = ['label' => 'Sign Up', 'url' => ['site/signup']];
$this->params['breadcrumbs'][] = 'Email Verification';
?>
<div class="container-fluid signup-success-container">
    <h2 class="text-center section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Email Verification</span>
    </h2>
    <div class="content-container">
        <div class="contact-form bg-light p-30 text-center">
            <p class="lead">
                Successfully Registered
            </p>
            <p>
                Hello <span class="font-weight-bold"><?= $user->email ?></span>!
            </p>
            <p>
                Please click the button below to verify your account
            </p>
            <div>
                <?= YiiHtml::a('Verify Account', ['site/signup-verification', 'verification_token' => $user->verification_token], [
                    'class' => "btn btn-primary"
                ]) ?>
            </div>
        </div>
    </div>
</div>