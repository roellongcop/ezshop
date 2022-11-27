<?php

use app\helpers\App;
use app\helpers\Html;

$this->addJsFile('frontend/js/product', ['app\assets\frontend\AppAsset'], [
    'type' => 'module'
]);
$wishlist = in_array($product->id, $this->params['wishlistProductIds']);
?>

<div class="product-item bg-light mb-4 product-item-<?= $product->id ?>">
        <?= App::if($wishlist, Html::tag('span', '<i class="fas fa-heart"></i>', [
            'class' => 'text-warning wishlist-span',
        ])) ?>

    <div class="product-img position-relative overflow-hidden">
        <img class="img-fluid w-100" src="<?= $product->getImageUrl(326) ?>" alt="">
        <div class="product-action">
            <a data-product_id="<?= $product->id ?>" title="Add to Cart" data-toggle="tooltip" class="btn-add-to-cart btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
            <a title="<?= $wishlist ? 'Remove from Wishlist': 'Add to Wishlist' ?>" data-toggle="tooltip" data-product_id="<?= $product->id ?>" class="btn-add-to-wishlist btn btn-outline-dark btn-square" href="#">
                <i class="far fa-heart"></i></a>
            <!-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a> -->
            <a title="View Product" data-toggle="tooltip" class="btn btn-outline-dark btn-square" href="<?= $product->frontendUrl ?>"><i class="fa fa-search"></i></a>
        </div>
    </div>
    <div class="text-center py-4">
        <a class="h6 text-decoration-none text-truncate" href="<?= $product->frontendUrl ?>">
            <?= $product->name ?>
        </a>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <?= $product->displayPrice ?>
        </div>
        <div class="d-flex align-items-center justify-content-center mb-1">
            <?= $product->generateStar() ?>
            <small>(<?= number_format($product->totalReviews) ?>)</small>
        </div>
    </div>
</div>