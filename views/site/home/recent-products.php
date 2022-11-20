<?php

use app\models\Product;
use app\helpers\Html;
?>

<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Recent Products</span></h2>
    <div class="row px-xl-5">
        <?= Html::if(Product::recent(), function($products) {
            return Html::foreach($products, function($product) {
                return Html::tag(
                    'div', 
                    $this->render('_product', ['product' => $product]),
                    ['class' => 'col-lg-3 col-md-4 col-sm-6 pb-1']
                );
            });
        }) ?>
    </div>
</div>