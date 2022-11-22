<?php

use yii\helpers\Html as YiiHtml;
use app\helpers\Html;

?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
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


