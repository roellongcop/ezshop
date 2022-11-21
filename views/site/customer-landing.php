<?php
/* @var $this yii\web\View */
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\ActiveForm;

$this->title = 'Customer Landing';
?>
<div class="container-fluid pt-5">
    <h2 class="text-center section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">My Account</span>
    </h2>
    <div class="row px-xl-5 pb-3 pointer">
        <?= Html::foreach(App::params('customer_links'), function($link) {
            $url = Url::toRoute($link['url']);
            return <<< HTML
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                        <h1 class="{$link['icon']} text-primary m-0 mr-3"></h1>
                        <a href="{$url}">
                            <h5 class="font-weight-semi-bold m-0">{$link['label']}</h5>
                        </a>
                    </div>
                </div>
            HTML;
        }) ?>
    </div>
</div>