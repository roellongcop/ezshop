<?php

use app\widgets\Search;
use app\widgets\ActiveForm;
use app\helpers\Url;
?>
<?php $form = ActiveForm::begin([
    'id' => 'main-search-form',
    'action' => $action ?? ['site/my-wishlist'], 
    'method' => 'get'
]); ?>
    <?= Search::widget([
        'url' => $url ?? Url::toRoute(['site/find-wishlist-by-keywords']),
        'submitOnclick' => true,
        'model' => $searchModel,
        'options' => [
            'class' => 'form-control border-0 p-4'
        ]
    ]) ?>
<?php ActiveForm::end(); ?>