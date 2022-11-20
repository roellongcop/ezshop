<?php

use app\widgets\Autocomplete;
use app\helpers\App;
use app\helpers\Url;
use yii\helpers\Html as YiiHtml;
?>
<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                <?= YiiHtml::a('About', ['site/about'], [
                    'class' => 'text-body mr-3'
                ]) ?>
                <?= YiiHtml::a('Contact', ['site/contact'], [
                    'class' => 'text-body mr-3'
                ]) ?>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My Account</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">My Orders History</button>
                        <button class="dropdown-item" type="button">My Wishlist</button>
                        <button class="dropdown-item" type="button">My Product Reviews</button>
                        <button class="dropdown-item" type="button">My Account Details</button>
                    </div>
                </div>
            </div>
            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">MS</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Furniture</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="<?= Url::toRoute(['site/shop']) ?>" method="get">
                <?= Autocomplete::widget([
                    'canRoute' => true,
                    'url' => Url::toRoute(['site/find-products-by-keywords']),
                    'input' => <<< HTML
                        <div class="input-group">
                            <input type="text" name="keywords" class="form-control" placeholder="Search for products">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent text-primary">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                    HTML
                ]) ?>
            </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0">Customer Service</p>
            <h5 class="m-0">
                <?= App::setting('aboutUs')->contact_no ?>
            </h5>
        </div>
    </div>
</div>
<!-- Topbar End -->