<?php
/* @var $this yii\web\View */
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\ActiveForm;

$this->title = 'Customer Dashboard';
$this->params['activePage'] = 'customer-dashboard';
?>
<div class="container-fluid">
    <h2 class="text-center section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">My Dashboard</span>
    </h2>
    <div class="row px-xl-5 pb-3 pointer">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4 p-30">
                <h1 class="fas fa-cart-plus text-primary m-0 mr-3"></h1>
                <a href="<?= Url::toRoute(['site/my-cart']) ?>">
                    <h5 class="font-weight-semi-bold m-0">
                        My Shopping Cart
                        <?= App::if(App::identity('myTotalCart'), fn($total) => Html::tag('span', $total, ['class' => 'badge badge-danger'])) ?>
                    </h5>
                </a>
            </div>
        </div>  
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4 p-30">
                <h1 class="fas fa-book text-primary m-0 mr-3"></h1>
                <a href="<?= Url::toRoute(['site/my-orders']) ?>">
                    <h5 class="font-weight-semi-bold m-0">My Orders History</h5>
                </a>
            </div>
        </div>     
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4 p-30">
                <h1 class="fas fa-bookmark text-primary m-0 mr-3"></h1>
                <a href="<?= Url::toRoute(['site/my-wishlist']) ?>">
                    <h5 class="font-weight-semi-bold m-0">My Wishlist
                        <?= App::if(App::identity('myTotalWishlist'), fn($total) => Html::tag('span', $total, ['class' => 'badge badge-danger'])) ?>
                    </h5>
                </a>
            </div>
        </div>     
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4 p-30">
                <h1 class="fas fa-star-half-alt text-primary m-0 mr-3"></h1>
                <a href="<?= Url::toRoute(['site/my-reviews']) ?>">
                    <h5 class="font-weight-semi-bold m-0">My Product Reviews
                        <?= App::if(App::identity('myTotalReviews'), fn($total) => Html::tag('span', $total, ['class' => 'badge badge-danger'])) ?>
                    </h5>
                </a>
            </div>
        </div>     
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4 p-30">
                <h1 class="fas fa-user-lock text-primary m-0 mr-3"></h1>
                <a href="<?= Url::toRoute(['site/my-account-details']) ?>">
                    <h5 class="font-weight-semi-bold m-0">My Account Details</h5>
                </a>
            </div>
        </div>    
    </div>
</div>