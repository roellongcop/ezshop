<?php

use app\helpers\App;
use yii\helpers\Html as YiiHtml;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Product Detail: ' . $product->mainAttribute;
$this->params['activePage'] = 'shop';
$this->params['breadcrumbs'][] = ['label' => 'Shop', 'url' => ['site/shop']];
$this->params['breadcrumbs'][] = $product->mainAttribute;
$this->addJsFile('frontend/js/product-detail');
?>

<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">

                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="<?= $product->getImageUrl(557) ?>" alt="Image">
                    </div>

                    <?= App::foreach($product->gallery, fn($token) => <<< HTML
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="{$product->getGalleryImageUrl($token, 557)}" alt="Image">
                        </div>
                    HTML) ?>
                    
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3><?= $product->name ?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <?= $product->generateStar('<small class="fas fa-star"></small>', '<small class="far fa-star"></small>') ?>
                    </div>
                    <small class="pt-1">(<?= number_format($product->totalReviews) ?> Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">
                    <?= App::formatter('asPeso', $product->sale_price) ?>
                    <?= App::if($product->isOnSale, Html::tag('small', number_format($product->regular_price), ['class' => 'text-muted line-through'])) ?>
                </h3>
                <p class="mb-4">
                    <?= $product->specification ?>
                </p>
                <div class="d-flex mb-3">
                    <?= App::if($product->sizes, Html::tag('strong', 'Sizes: ', [
                        'class' => 'text-dark mr-3'
                    ])) ?>
                    <?= App::foreach($product->sizes, fn($size, $key) => <<< HTML
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-{$key}" name="size">
                            <label class="custom-control-label" for="size-{$key}">
                                {$size}
                            </label>
                        </div>
                    HTML) ?>
                </div>
                <div class="d-flex mb-4">
                    <?= App::if($product->sizes, Html::tag('strong', 'Colors: ', [
                        'class' => 'text-dark mr-3'
                    ])) ?>

                    <?= App::foreach($product->colors, fn($color, $key) => <<< HTML
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-{$key}" name="color">
                            <label class="custom-control-label" for="color-{$key}">
                                {$color}
                            </label>
                        </div>
                    HTML) ?>
                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                        Cart</button>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">More on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="<?= App::setting('socialMedia')->facebook ?>">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="<?= App::setting('socialMedia')->twitter ?>">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="<?= App::setting('socialMedia')->linkedin ?>">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="<?= App::setting('socialMedia')->instagram ?>">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark <?= $tab == 'description' ? 'active': '' ?>" data-toggle="tab" href="#description"  data-link="<?= Url::to(Url::current(['tab' => 'description']), true) ?>#leave-a-review"> Description</a>
                    <a class="nav-item nav-link text-dark <?= $tab == 'reviews' ? 'active': '' ?>" data-toggle="tab" href="#reviews"  data-link="<?= Url::to(Url::current(['tab' => 'reviews']), true) ?>#leave-a-review">Reviews (<?= number_format($dataProvider->totalCount) ?>)</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade <?= $tab == 'description' ? 'show active': '' ?>" id="description">
                        <h4 class="mb-3">Product Description</h4>
                        <p><?= $product->description ?></p>
                    </div>
                    <div class="tab-pane fade <?= $tab == 'reviews' ? 'show active': '' ?>" id="reviews">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4"><?= number_format($dataProvider->totalCount) ?> review(s) for "<?= $product->name ?>"</h4>

                                <?php Pjax::begin(['timeout' => false]); ?>
                                    <?= ListView::widget([
                                        'dataProvider' => $dataProvider,
                                        'options' => [
                                            'tag' => 'div',
                                            'class' => 'list-wrapper',
                                            'id' => 'list-wrapper',
                                        ],
                                        'layout' => "{summary}\n{items}\n{pager}",
                                        'itemView' => fn($model) => $this->render('_review', [
                                            'review' => $model
                                        ]),
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
                                    ]) ?>
                                <?php Pjax::end(); ?>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4" id="leave-a-review">Leave a review</h4>

                                <?= App::ifElse(App::isLogin(), fn() => implode('', [
                                    Html::tag('small', 'Your email address will not be published. Please fill up required fields.'),
                                    $this->render('_review-form', ['product' => $product])
                                ]), implode('', [
                                    Html::tag('small', 'Please sign in to leave a review.'),
                                    YiiHtml::a('Sign In', ['site/login'], ['class' => 'btn btn-primary'])
                                ])) ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


