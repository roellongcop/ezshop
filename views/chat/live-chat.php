<?php

use app\widgets\Grid;
use app\widgets\Anchor;
use app\helpers\Url;
use app\helpers\Html;
use app\models\Chat;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chats: Live';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['activeMenuLink'] = '/chat/live-chat';
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
                        'link' => Url::toRoute(['chat/live-chat-view', 'session_id' => $model->session_id]),
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
            'total_message' => [
                'label' => 'Total Messages',
                'attribute' => 'totalPerSession', 
                'format' => 'raw',
                'value' => fn ($model) => $model->totalPerSession 
            ],
            'created_at' => ['attribute' => 'created_at', 'format' => 'fulldate'],
            'last_updated' => [
                'attribute' => 'updated_at',
                'label' => 'last updated',
                'format' => 'ago',
                'value' => function($model) {
                    $chat = Chat::find()
                        ->where(['session_id' => $model->session_id])
                        ->orderBy(['id' => SORT_DESC])
                        ->one();

                    return $chat ? $chat->updated_at: 0;
                }
            ],
            'actions' => [
                'label' => 'action',
                'attribute' => 'totalPerSession', 
                'format' => 'raw',
                'value' => fn ($model) => Html::a('View Live Chat', ['chat/live-chat-view', 'session_id' => $model->session_id], [
                    'class' => 'btn btn-primary btn-sm font-weight-bold'
                ])
            ]
        ]
    ]); ?>
</div>