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

$this->registerJsFile(App::publishedUrl('/vue3/vue.global.js', Yii::getAlias('@app/assets')));
$this->addJsFile('js/chatbot', ['app\assets\AppAsset'], ['type' => 'module']);

?>
<div class="chat-view-page" id="live-chat" data-session_id="<?= $model->session_id ?>">
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
                            'value' => fn ($model) => $model->userEmail 
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
                <div class="scroll scroll-pull chat-box-body scroller-thumb" data-height="375" data-mobile-height="300" style="height: 58vh; overflow: auto;" ref="conversationsContainer" @scroll="messageScroll">
                    <div class="messages ">
                        <div v-for="(message, index) in messages" :key="message.id" class="d-flex flex-column" :class="setContainerClass(message, index)" :id="'message-id-' + message.id">
                            <div class="d-flex align-items-center" v-if="showTimesent(index)">
                                <div>
                                    <span class="text-muted font-size-sm" v-html="message.timeSent"></span>
                                </div>
                            </div>
                            <div class="mt-2 rounded p-5 text-dark-50 font-weight-bold font-size-lg max-w-400px" v-html="message.message" :class="setMessageClass(message)"></div>
                        </div>
                    </div>
                </div>

                <div class="scrollToBottomContainer" v-if="showScrollable">
                    <span></span>
                    <span>
                        <button @click="scrollToBottom" class="btn btn-primary font-weight-bold btn-sm btn-pill" >
                            Scroll to Bottom
                        </button>
                    </span>
                    <span></span>
                </div>
               
            <?php $this->endContent() ?>
        </div>
    </div>
   
</div>