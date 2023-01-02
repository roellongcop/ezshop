<?php

use app\helpers\Html;
use app\helpers\Url;
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
                Hello <span class="font-weight-bold">
                	<?= $user->email ?>
                </span>!
            </p>
            <p>
                Please click the button below to verify your account
            </p>
            <div>
            	<?= Html::tag('a', 'Verify Account', [
            		'href' => Url::toRoute(['site/signup-verification', 'verification_token' => $user->verification_token], true),
            		'class' => 'btn btn-primary',
            		'style' => 'background: #337ab7; padding: 10px; border-radius: 4px; font-weight: 600; color: #fff;'
            	]) ?>
            </div>
        </div>
    </div>
</div>