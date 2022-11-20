<?php

use app\models\Product;
use app\helpers\Html;
?>

<div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5">
        <?= Html::if(Product::random(), function($products) {
            return Html::foreach($products, function($product) {
                return <<< HTML
                    <div class="col-md-6">
                        <div class="product-offer mb-30" style="height: 300px;">
                            <img class="img-fluid" src="{$product->productCategoryImageUrl}" alt="">
                            <div class="offer-text">
                                <h6 class="text-white text-uppercase">Save {$product->salePercentage}%</h6>
                                <h3 class="text-white mb-3">Special Offer</h3>
                                <a href="" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </div>
                HTML;
            });
        }) ?>
    </div>
</div>