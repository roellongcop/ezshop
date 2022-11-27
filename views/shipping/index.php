<?php

use app\helpers\Html;
use app\helpers\App;
use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ShippingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shippings';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['showCreateButton'] = true; 
$this->params['showExportButton'] = true;
?>
<div class="shipping-index-page">
    <p class="lead font-weight-bold">
        General Shipping: Flat Rate (<?= App::formatter('asNumberFormat', App::setting('shipping')->flat_rate) ?>)
        <span>
            <?= Html::a('<i class="fa fa-edit"></i>', ['setting/general', 'tab' => 'shipping'], [
                'class' => 'text-warning'
            ]) ?>
        </span>
    </p>
    <?= FilterColumn::widget(['searchModel' => $searchModel]) ?>
    <?= Html::beginForm(['bulk-action'], 'post'); ?>
        <?= BulkAction::widget(['searchModel' => $searchModel]) ?>
        
        <?= Grid::widget([
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]); ?>
    <?= Html::endForm(); ?> 
</div>