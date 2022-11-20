<?php

use app\models\Product;
use app\models\ProductCategory;
use app\helpers\Html;
?>

<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#header-carousel" data-slide-to="1"></li>
                    <li data-target="#header-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <?= Html::foreach(ProductCategory::random(), function($category, $key) {
                        $active = $key == 0 ? 'active': '';

                        return <<< HTML
                            <div class="carousel-item position-relative {$active}" style="height: 430px;">
                                <img class="position-absolute w-100 h-100" src="{$category->imageUrl}" style="object-fit: cover;">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                            {$category->name}
                                        </h1>
                                        <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                            {$category->truncatedDescription}
                                        </p>
                                        <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        HTML;
                    }) ?>
                    

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <?= Html::foreach(Product::random(), function($product) {
                return <<< HTML
                    <div class="product-offer mb-30" style="height: 200px;">
                        <img class="img-fluid" src="{$product->productCategoryImageUrl}" alt="">
                        <div class="offer-text">
                            <h6 class="text-white text-uppercase">Save {$product->salePercentage}%</h6>
                            <h3 class="text-white mb-3">
                                Special Offer
                            </h3>
                            <a href="" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                HTML;
            }) ?>
        </div>
    </div>
</div>