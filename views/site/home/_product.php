<?php

use app\helpers\App;

$this->addJsFile('frontend/js/product');
$productIds = App::identity('wishlistProductIds');

?>

<div class="product-item bg-light mb-4">
    <div class="product-img position-relative overflow-hidden">
        <img class="img-fluid w-100" src="<?= $product->getImageUrl(326) ?>" alt="">
        <div class="product-action">
            <a title="Add to Cart" data-toggle="tooltip" class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
            <a title="<?= in_array($product->id, $productIds)? 'Remove from Wishlists': 'Add to Wishlist' ?>" data-toggle="tooltip" data-product_id="<?= $product->id ?>" class="btn-add-to-wishlist btn btn-outline-dark btn-square" href="#">
                <i class="far fa-heart"></i></a>
            <!-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a> -->
            <a title="View Product" data-toggle="tooltip" class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
        </div>
    </div>
    <div class="text-center py-4">
        <a class="h6 text-decoration-none text-truncate" href="">
            <?= $product->name ?>
        </a>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <?= $product->displayPrice ?>
        </div>
        <div class="d-flex align-items-center justify-content-center mb-1">
            <small class="fa fa-star text-primary mr-1"></small>
            <small class="fa fa-star text-primary mr-1"></small>
            <small class="fa fa-star text-primary mr-1"></small>
            <small class="fa fa-star text-primary mr-1"></small>
            <small class="fa fa-star text-primary mr-1"></small>
            <small>(99)</small>
        </div>
    </div>
</div>