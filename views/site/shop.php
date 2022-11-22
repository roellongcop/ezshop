<?php

use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;
use yii\helpers\Html as YiiHtml;
use yii\widgets\ListView;
use app\models\Product;

$this->title = 'Shop';
$this->params['activePage'] = 'shop';

$this->addJsFile('frontend/js/shop', ['app\assets\frontend\AppAsset']);
?>

<div class="container-fluid shop-page">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">

            <form method="get" action="<?= Url::to(['site/shop']) ?>">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
                <div class="bg-light p-4 mb-30">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-all">
                        <label class="custom-control-label" for="price-all">All Price</label>
                    </div>
                    <?= Html::foreach(App::params('price_filter'), function($to, $from) use($searchModel) {
                        list($_from, $_to) = [number_format($from), number_format($to)];
                        return <<< HTML
                            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input id="price-{$from}-{$to}" value="{$from}-{$to}" type="checkbox" class="custom-control-input filter price-filter" name="price_range[]" {$searchModel->checkedPriceFilter($from, $to)}>
                                <label class="custom-control-label" for="price-{$from}-{$to}">
                                    ₱{$_from} - ₱{$_to}
                                </label>
                            </div>
                        HTML;
                    }) ?>
                </div>
                <!-- Price End -->
                
                <!-- Color Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by color</span></h5>
                <div class="bg-light p-4 mb-30">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-all">
                        <label class="custom-control-label" for="color-all">All Color</label>
                    </div>
                    <?= Html::if(Product::uniqueColors(), function($colors) use($searchModel) {
                        return Html::foreach($colors, function($color) use($searchModel) {
                            return <<< HTML
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input name="colors[]" value="{$color}" id="color-{$color}" type="checkbox" class="custom-control-input filter color-filter" {$searchModel->checkedColorFilter($color)}>
                                    <label class="custom-control-label" for="color-{$color}">
                                        {$color}
                                    </label>
                                </div>
                            HTML;
                        });
                    }) ?>
                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
                <div class="bg-light p-4 mb-30">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="size-all">
                        <label class="custom-control-label" for="size-all">All Size</label>
                    </div>
                    <?= Html::if(Product::uniqueSizes(), function($sizes) use($searchModel) {
                        return Html::foreach($sizes, function($size) use($searchModel) {
                            return <<< HTML
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input name="sizes[]" value="{$size}" id="size-{$size}" type="checkbox" class="custom-control-input filter size-filter" {$searchModel->checkedSizeFilter($size)}>
                                    <label class="custom-control-label" for="size-{$size}">
                                        {$size}
                                    </label>
                                </div>
                            HTML;
                        });
                    }) ?>
                </div>
            </form>

        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between">
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