<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use yii\helpers\Html as YiiHtml;
use app\models\ProductCategory;


$activePage = $this->params['activePage'] ?? 'home';
$totalWishlist = App::isLogin() ? App::identity('myTotalWishlist'): 0;
$totalCart = App::isLogin() ? App::identity('myTotalCart'): 0;

$this->addJsFile('frontend/js/navbar');
$this->registerJs(<<< JS
    navbarPoll({
        totalWishlist: {$totalWishlist},
        totalCart: {$totalCart},
    })
JS);
?>

<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>
                    <?= App::get('categories') ?: 'Filter by Categories' ?>
                </h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <!-- <div class="nav-item dropdown dropright">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dresses <i class="fa fa-angle-right float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div> -->
                    <?= YiiHtml::a('- Filter by Categories -', ['site/shop'], [
                            'class' => 'nav-item nav-link'
                        ]) ?>
                    <?= Html::foreach(ProductCategory::dropdown('id', 'name'), function($category) {
                        return YiiHtml::a($category, ['site/shop', 'categories' => $category], [
                            'class' => 'nav-item nav-link'
                        ]);
                    }) ?>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">MS</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Furniture</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <?= YiiHtml::a('Home', ['site/home'], [
                            'class' => 'nav-item nav-link' . ($activePage == 'home' ? ' active': '')
                        ]) ?>
                        <?= YiiHtml::a('Shop', ['site/shop'], [
                            'class' => 'nav-item nav-link' . ($activePage == 'shop' ? ' active': '')
                        ]) ?>
                        <?= YiiHtml::a('Cart', ['site/my-cart'], [
                            'class' => 'nav-item nav-link' . ($activePage == 'my-cart' ? ' active': '')
                        ]) ?>

                        <?= YiiHtml::a('Checkout', ['site/checkout'], [
                            'class' => 'nav-item nav-link' . ($activePage == 'checkout' ? ' active': '')
                        ]) ?>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="<?= Url::toRoute(['site/my-wishlist']) ?>" class="btn px-0">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle total-wishlist" style="padding-bottom: 2px;">
                                <?= number_format($totalWishlist) ?>
                            </span>
                        </a>
                        <a href="<?= Url::toRoute(['site/my-cart']) ?>" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle total-cart" style="padding-bottom: 2px;">
                                <?= number_format($totalCart) ?>
                            </span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->