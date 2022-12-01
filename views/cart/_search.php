<?php

use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\DateRange;
use yii\widgets\ActiveForm;
use app\widgets\SearchButton;
use app\widgets\RecordStatusFilter;
use app\helpers\App;
use app\widgets\Filter;

/* @var $this yii\web\View */
/* @var $model app\models\search\CartSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'cart-search-form'
]); ?>
    <?= Search::widget(['model' => $model]) ?>
    <?= DateRange::widget(['model' => $model]) ?>
    <?= Filter::widget([
        'model' => $model,
        'form' => $form,
        'attribute' => 'record_status',
        'data' => App::keyMapParams('cart_status')
    ]) ?>
    <?= Pagination::widget([
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= SearchButton::widget() ?>
<?php ActiveForm::end(); ?>