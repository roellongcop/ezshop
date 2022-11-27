<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

$paginations = App::params('pagination');
?>
<div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap">
        <div class="mr-2">
            {summary}
        </div>
        <?= Html::if($dataProvider->totalCount > $searchModel->pagination,
            function() use($searchModel, $paginations) {

                $links = Html::foreach($paginations, function($page) {
                    return Html::a($page, Url::current(['pagination' => $page]), [
                        'class' => 'dropdown-item'
                    ]);
                });

                return <<< HTML
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Show: {$searchModel->pagination}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {$links}
                        </div>
                    </div>
                HTML;
            }
        ) ?>
    </div>
    <div class="" style="min-width: 25em;">
        <?= $content ?>
    </div>
</div>
<div class="my-2">
    {items}
</div>
<div class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap">
        <div class="mr-2">
            {summary}
        </div>
    </div>
    <div class="">
        {pager}
    </div>
</div>
