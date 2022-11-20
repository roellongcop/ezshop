<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use yii\widgets\ListView;
use app\models\Product;
?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="price-all">
                        <label class="custom-control-label" for="price-all">All Price</label>
                        <!-- <span class="badge border font-weight-normal">1000</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-1">
                        <label class="custom-control-label" for="price-1">₱0 - ₱100</label>
                        <!-- <span class="badge border font-weight-normal">150</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-2">
                        <label class="custom-control-label" for="price-2">₱100 - ₱500</label>
                        <!-- <span class="badge border font-weight-normal">295</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-3">
                        <label class="custom-control-label" for="price-3">₱500 - ₱1000</label>
                        <!-- <span class="badge border font-weight-normal">246</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-4">
                        <label class="custom-control-label" for="price-4">₱1000 - ₱5000</label>
                        <!-- <span class="badge border font-weight-normal">145</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" id="price-5">
                        <label class="custom-control-label" for="price-5">₱5000 - ₱10,000</label>
                        <!-- <span class="badge border font-weight-normal">168</span> -->
                    </div>
                </form>
            </div>
            <!-- Price End -->
            
            <!-- Color Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by color</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="color-all">
                        <label class="custom-control-label" for="price-all">All Color</label>
                        <!-- <span class="badge border font-weight-normal">1000</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-1">
                        <label class="custom-control-label" for="color-1">Black</label>
                        <!-- <span class="badge border font-weight-normal">150</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-2">
                        <label class="custom-control-label" for="color-2">White</label>
                        <!-- <span class="badge border font-weight-normal">295</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-3">
                        <label class="custom-control-label" for="color-3">Red</label>
                        <!-- <span class="badge border font-weight-normal">246</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-4">
                        <label class="custom-control-label" for="color-4">Blue</label>
                        <!-- <span class="badge border font-weight-normal">145</span> -->
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" id="color-5">
                        <label class="custom-control-label" for="color-5">Green</label>
                        <!-- <span class="badge border font-weight-normal">168</span> -->
                    </div>
                </form>
            </div>
            <!-- Color End -->

            <!-- Size Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="size-all">
                        <label class="custom-control-label" for="size-all">All Size</label>
                        <!-- <span class="badge border font-weight-normal">1000</span> -->
                    </div>
                    <?= Html::if(Product::uniqueSizes(), function($sizes) {
                        return Html::foreach($sizes, function($size) {
                            return <<< HTML
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="size-1">
                                    <label class="custom-control-label" for="size-1">
                                        {$size}
                                    </label>
                                    <!-- <span class="badge border font-weight-normal">150</span> -->
                                </div>
                            HTML;
                        });
                    }) ?>
                </form>
            </div>
            <!-- Size End -->
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <!-- <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button> -->
                        </div> 
                        <div class="ml-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                                    <?= $searchModel->sortLabel ?>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?= YiiHtml::a('Latest', Url::current(['sort' => 'latest']), [
                                        'class' => 'dropdown-item'
                                    ]) ?>
                                    <?= YiiHtml::a('Popularity', Url::current(['sort' => 'popularity']), [
                                        'class' => 'dropdown-item'
                                    ]) ?>
                                    <?= YiiHtml::a('Best Rating', Url::current(['sort' => 'rating']), [
                                        'class' => 'dropdown-item'
                                    ]) ?>
                                </div>
                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?= Html::foreach(App::params('pagination'), function($page) {
                                        return YiiHtml::a($page, Url::current(['pagination' => $page]), [
                                            'class' => 'dropdown-item'
                                        ]);
                                    }) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'div',
                    'class' => 'row',
                    'id' => 'list-wrapper',
                ],
                'summaryOptions' => [
                    'class' => 'col-12'
                ],
                'layout' => "{summary}\n{items}\n<div class='col-12'><nav>{pager}</nav></div>",
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('home/_product', [
                        'product' => $model
                    ]);
                },
                'beforeItem' => function ($model, $key, $index, $widget) {
                    return '<div class="col-lg-4 col-md-6 col-sm-6 pb-1">';
                },
                'afterItem' => function ($model, $key, $index, $widget) {
                    return '</div>';
                },
                'pager' => [
                    'class' => 'yii\widgets\LinkPager',
                    'options' => [
                        'class' => 'pagination justify-content-center'
                    ],
                    'registerLinkTags' => true,
                    'nextPageLabel' => 'Next',
                    'prevPageLabel' => 'Previous',
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active',
                    'disabledListItemSubTagOptions' => [
                        'tag' => 'a',
                        'class' => 'page-link'
                    ]
                ]
            ]); ?>
        </div>
        <!-- Shop Product End -->
    </div>
</div>