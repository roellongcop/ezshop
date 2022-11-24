<?php

use app\models\Product;
use app\helpers\Html;
?>

<div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5">
        <?= Html::foreach(Product::random(), 
            fn($product) => Html::tag('div',
                $this->render('_product-offer', ['product' => $product]),
                ['class' => 'col-md-6']
            )
        ) ?>
    </div>
</div>