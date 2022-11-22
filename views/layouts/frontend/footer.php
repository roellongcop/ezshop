<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;

$activePage = $this->params['activePage'] ?? 'home';
?>
<!-- Footer Start -->
<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
            <p class="mb-4">
                You can contact us with our email, contact number or directly to our store location.
            </p>
            <p class="mb-2">
                <i class="fa fa-map-marker-alt text-primary mr-3"></i>
                <?= App::setting('aboutUs')->address ?>
            </p>
            <p class="mb-2">
                <i class="fa fa-envelope text-primary mr-3"></i>
                <?= App::setting('email')->admin_email ?>
            </p>
            <p class="mb-0">
                <i class="fa fa-phone-alt text-primary mr-3"></i>
                <?= App::setting('aboutUs')->contact_no ?>
            </p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="<?= $activePage == 'home' ? 'active': 'text-secondary' ?> mb-2" href="<?= Url::toRoute(['site/home']) ?>">
                            <i class="fa fa-angle-right mr-2"></i>
                            Home
                        </a>
                        <a class="<?= $activePage == 'shop' ? 'active': 'text-secondary' ?> mb-2" href="<?= Url::toRoute(['site/shop']) ?>">
                            <i class="fa fa-angle-right mr-2"></i>
                            Shop
                        </a>
                        
                        <a class="<?= $activePage == 'cart' ? 'active': 'text-secondary' ?> mb-2" href="<?= Url::toRoute(['site/cart']) ?>">
                            <i class="fa fa-angle-right mr-2"></i>
                            Cart
                        </a>
                        <a class="<?= $activePage == 'checkout' ? 'active': 'text-secondary' ?> mb-2" href="<?= Url::toRoute(['site/checkout']) ?>">
                            <i class="fa fa-angle-right mr-2"></i>
                            Checkout
                        </a>
                        <a class="<?= $activePage == 'about' ? 'active': 'text-secondary' ?> mb-2" href="<?= Url::toRoute(['site/about']) ?>">
                            <i class="fa fa-angle-right mr-2"></i>
                            About Us
                        </a> 
                        <a class="<?= $activePage == 'contact' ? 'active': 'text-secondary' ?> mb-2" href="<?= Url::toRoute(['site/contact']) ?>">
                            <i class="fa fa-angle-right mr-2"></i>
                            Contact Us
                        </a> 
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">My Account</h5>

                    <div class="d-flex flex-column justify-content-start">
                        <?= Html::foreach(App::params('customer_links'), function($link) {
                            return YiiHtml::a('<i class="fa fa-angle-right mr-2"></i> ' . $link['label'], $link['url'], ['class' => 'text-secondary mb-2']) ;
                        }) ?>
                       
                        <?= Html::ifElse(App::isLogin(), function() use ($activePage) {
                            $url = Url::toRoute(['site/logout']);
                            return <<< HTML
                                <a class="text-secondary mb-2" href="{$url}">
                                    <i class="fa fa-angle-right mr-2"></i>
                                    Sign Out
                                </a>
                            HTML;
                        }, function() use ($activePage) {
                            $url = Url::toRoute(['site/login']);
                            $class = $activePage == 'sign-in' ? 'active': 'text-secondary';
                            return <<< HTML
                                <a class="{$class} mb-2" href="{$url}">
                                    <i class="fa fa-angle-right mr-2"></i>
                                    Sign In
                                </a>
                            HTML;
                        }) ?>
                        
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">FOLLOW US</h5>
                    <div class="d-flex">
                        <a target="_blank" class="btn btn-primary btn-square mr-2" href="<?= App::setting('socialMedia')->twitter ?>">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a target="_blank" class="btn btn-primary btn-square mr-2" href="<?= App::setting('socialMedia')->facebook ?>">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a target="_blank" class="btn btn-primary btn-square mr-2" href="<?= App::setting('socialMedia')->linkedin ?>">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a target="_blank" class="btn btn-primary btn-square" href="<?= App::setting('socialMedia')->instagram ?>">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-secondary">
                &copy; 
                <a class="text-primary" href="<?= Url::toRoute(['site/home']) ?>">
                   <?= App::setting('aboutUs')->shop_name ?>                 
                </a>. All Rights Reserved. 
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <!-- <img class="img-fluid" src="img/payments.png" alt=""> -->
        </div>
    </div>
</div>
<!-- Footer End -->
