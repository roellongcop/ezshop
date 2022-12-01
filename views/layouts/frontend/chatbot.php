<?php

use app\helpers\App;

$this->addCssFile('frontend/css/chatbot');
$this->registerJsFile(App::publishedUrl('/vue3/vue.global.js', Yii::getAlias('@app/assets')));
$this->addJsFile('frontend/js/chatbot', ['app\assets\frontend\AppAsset'], ['type' => 'module']);

$themeColor = App::setting('chatbot')->theme_color;
$this->registerCss(<<< CSS
    .chat-logs::-webkit-scrollbar-thumb {
        background-color: {$themeColor};
    }
    .btn-scroller:hover {
        background: {$themeColor};
        border-color: {$themeColor};
        color: #fff;
    }
CSS);

?>

<div id="chatbot">
    
    <div id="chat-circle" class="btn btn-raised" :style="{background: chatbot.theme_color}">
        <div id="chat-overlay"></div>
        <i class="fab fa-rocketchat"></i>
    </div>

    <div class="chat-box">
        <div class="chat-box-header" :style="{background: chatbot.theme_color}">
            <img :src="chatbotPhotoUrl" class="img-fluid chatbot-photo">
            {{chatbot.name}}
            <span class="chat-box-toggle"><i class="far fa-window-close"></i></span>
        </div>
        <div class="chat-box-body">
            <div class="chat-box-overlay">   
            </div>
            <div class="chat-logs" ref="conversationsContainer" @scroll="messageScroll">
                <div v-for="(message, index) in messages" :key="message.id" :class="messageClass(message)" class="chat-msg">
                    <div v-if="showTimesent(index)" class="timeSent" v-html="message.timeSent"></div>
                    <div class="cm-msg-text" :class="messageStyleClass(index)" :style="messageStyle(message)" :id="'message-id-' + message.id" v-html="message.message">
                    </div>
                </div>

                <div v-if="messageFormState.content.length">
                    <div v-for="(content, index) in messageFormState.content" :key="index" class="chat-msg self">
                        <div class="timeSent">Just now</div>
                        <div class="cm-msg-text-placeholder" v-html="content"></div>
                    </div>
                </div>
            </div>

            <div class="text-center" v-if="showScrollable">
                <button @click="scrollToBottom" class="btn btn-outline-primary font-weight-bold btn-sm btn-pill btn-scroller">
                    Scroll to Bottom
                </button>
            </div>
        </div>
        <div class="chat-input">      
            <form @submit.prevent="sendNewMessage">
                <input autocomplete="off" maxlength="225" type="text" id="chat-input" v-model="messageModel" placeholder="Send a message..."/>
                <button type="submit" class="chat-submit" id="chat-submit"><i class="fab fa-telegram-plane" :style="{color: chatbot.theme_color}"></i></button>
            </form>      
        </div>
    </div>
</div>
