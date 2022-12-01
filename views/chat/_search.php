<?php

use app\widgets\Pagination;
use app\widgets\Search;
use app\widgets\DateRange;
use yii\widgets\ActiveForm;
use app\widgets\SearchButton;
use app\widgets\RecordStatusFilter;
use app\widgets\Filter;
use app\helpers\App;

/* @var $this yii\web\View */
/* @var $model app\models\search\ChatSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => $model->searchAction,
    'method' => 'get',
    'id' => 'chat-search-form'
]); ?>
    <?= Search::widget(['model' => $model]) ?>
    <?= DateRange::widget(['model' => $model]) ?>
    <?= Filter::widget([
        'model' => $model,
        'form' => $form,
        'attribute' => 'status',
        'data' => App::keyMapParams('chat_status')
    ]) ?>

    <?= Filter::widget([
        'model' => $model,
        'form' => $form,
        'attribute' => 'type',
        'data' => App::keyMapParams('chat_type')
    ]) ?>

    <?= RecordStatusFilter::widget([
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Pagination::widget([
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= SearchButton::widget() ?>
<?php ActiveForm::end(); ?>