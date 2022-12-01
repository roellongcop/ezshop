<?php

use app\widgets\Grid;
use app\widgets\Anchor;
use app\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chats: Live';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
?>
<div class="chat-index-page">
    <?= Grid::widget([
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'columns' => [
            'serial' => ['class' => 'yii\grid\SerialColumn'],
            'session_id' => [
                'attribute' => 'session_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->session_id,
                        'link' => Url::toRoute(['chat/live-chat-view', 'id' => $model->id]),
                        'text' => true
                    ]);
                }
            ],
            'user_email' => [
                'label' => 'User email',
                'attribute' => 'userEmail', 
                'format' => 'raw',
                'value' => 'userEmail'
            ],
            'created_at' => ['attribute' => 'created_at', 'format' => 'fulldate'],
            'last_updated' => [
                'attribute' => 'updated_at',
                'label' => 'last updated',
                'format' => 'ago',
            ],
            'actions' => [
                'label' => 'view',
                'attribute' => 'totalPerSession', 
                'format' => 'raw',
                'value' => fn ($model) => $model->totalPerSession 
            ]
        ]
    ]); ?>
</div>