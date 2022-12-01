<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ChatSearch;
use app\models\Chat;
use app\helpers\App;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Live Chat: ' . $model->session_id;
$this->params['breadcrumbs'][] = ['label' => 'Live Chats', 'url' => ['live-chat']];
$this->params['breadcrumbs'][] = $model->session_id;
$this->params['searchModel'] = new ChatSearch();
$this->params['wrapCard'] = false; 
$this->params['activeMenuLink'] = '/chat/live-chat';
?>
<div class="chat-view-page">
    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Chat Details'
            ]) ?>
                <?= Detail::widget([
                    'model' => $model,
                    'attributes' => [
                        'session_id' => [
                            'attribute' => 'session_id', 
                            'format' => 'raw',
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
                    ]
                ]) ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Live Chat'
            ]) ?>
            <?php $this->endContent() ?>
        </div>
    </div>
   
</div>