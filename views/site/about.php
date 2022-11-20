<?php
/* @var $this yii\web\View */
use app\helpers\App;
use app\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = 'About';
?>
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">About Us</span></h2>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="bg-light p-30">
                <?= App::setting('aboutUs')->information ?>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <div class="bg-light p-30 mb-30">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30909.45580894858!2d121.37141547101629!3d14.445482386251284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ee6768e8a36d%3A0xe466853e8760b5ca!2sPaagahan%2C%20Mabitac%2C%20Laguna!5e0!3m2!1sen!2sph!4v1668933625242!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="bg-light p-30 mb-3">
                <p class="mb-2">
                    <i class="fa fa-map-marker-alt text-primary mr-3"></i>
                    <?= App::setting('aboutUs')->address ?>
                </p>
                <p class="mb-2">
                    <i class="fa fa-envelope text-primary mr-3"></i>
                    <?= App::setting('email')->admin_email ?>
                </p>
                <p class="mb-2">
                    <i class="fa fa-phone-alt text-primary mr-3"></i>
                    <?= App::setting('aboutUs')->contact_no ?>
                </p>
            </div>
        </div>
    </div>
</div>