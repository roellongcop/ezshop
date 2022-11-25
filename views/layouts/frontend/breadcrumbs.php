<?php

use yii\helpers\Html as YiiHtml;
use app\helpers\Html;
use app\helpers\App;
?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <div class="d-flex mb-4">
                <nav class="breadcrumb bg-light">
                    <a title="Go back" data-toggle="tooltip" href="<?= App::referrer() ?>" class="breadcrumb-item text-dark m-auto">
                        <i class="fa fa-angle-left"></i>
                    </a>
                </nav>
                <nav class="breadcrumb bg-light" style="width: 100%">
                    <?= $this->params['homeBreadcrumbs'] ?? YiiHtml::a('Home', ['site/home'], [
                        'class' => 'breadcrumb-item text-dark'
                    ]) ?>
                    <?= Html::if($this->params['breadcrumbs'] ?? '', function($breadcrumbs) {
                        return Html::foreach($breadcrumbs, function($breadcrumb) {
                            return Html::ifElse(isset($breadcrumb['url']), function()use($breadcrumb) {
                                return YiiHtml::a($breadcrumb['label'], $breadcrumb['url'], [
                                    'class' => 'breadcrumb-item text-dark'
                                ]);
                            }, function() use($breadcrumb) {
                                return Html::tag('span', $breadcrumb, [
                                    'class' => 'breadcrumb-item active'
                                ]);
                            });
                        });
                    }) ?>
                </nav>
            </div>
        </div>
    </div>
</div>


