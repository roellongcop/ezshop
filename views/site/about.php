<?php
/* @var $this yii\web\View */
use app\helpers\App;
use app\helpers\Html;

$this->title = 'About Us';
$this->params['breadcrumbs'][] = 'About Us';
$this->params['activePage'] = 'about';
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
                <?= Html::image(App::setting('image')->primary_logo, [], ['class' => 'img-fluid']) ?>
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