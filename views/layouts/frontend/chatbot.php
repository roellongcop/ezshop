<?php

use app\helpers\App;

$this->addCssFile('frontend/css/chatbot');
$this->registerJsFile(App::publishedUrl('/vue3/vue.global.js', Yii::getAlias('@app/assets')));
$this->addJsFile('frontend/js/chatbot', ['app\assets\frontend\AppAsset'], ['type' => 'module']);

$this->registerJs(<<< JS
    $(function() {
  var INDEX = 0; 
  // $("#chat-submit").click(function(e) {
  //   e.preventDefault();
  //   var msg = $("#chat-input").val(); 
  //   if(msg.trim() == ''){
  //     return false;
  //   }
  //   generate_message(msg, 'self');
  //   var buttons = [
  //       {
  //         name: 'Existing User',
  //         value: 'existing'
  //       },
  //       {
  //         name: 'New User',
  //         value: 'new'
  //       }
  //     ];
  //   setTimeout(function() {      
  //     generate_message(msg, 'user');  
  //   }, 1000)
    
  // })
  
  function generate_message(msg, type) {
    INDEX++;
    var str="";
    str += "<div id='cm-msg-"+INDEX+"' class=\"chat-msg "+type+"\">";
    str += "          <span class=\"msg-avatar\">";
    str += "            <img src=\"https://picsum.photos/50\">";
    str += "          <\/span>";
    str += "          <div class=\"cm-msg-text\">";
    str += msg;
    str += "          <\/div>";
    str += "        <\/div>";
    $(".chat-logs").append(str);
    $("#cm-msg-"+INDEX).hide().fadeIn(300);
    if(type == 'self'){
     $("#chat-input").val(''); 
    }    
    $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);    
  }  
  
  function generate_button_message(msg, buttons){    
    /* Buttons should be object array 
      [
        {
          name: 'Existing User',
          value: 'existing'
        },
        {
          name: 'New User',
          value: 'new'
        }
      ]
    */
    INDEX++;
    var btn_obj = buttons.map(function(button) {
       return  "              <li class=\"button\"><a href=\"javascript:;\" class=\"btn btn-primary chat-btn\" chat-value=\""+button.value+"\">"+button.name+"<\/a><\/li>";
    }).join('');
    var str="";
    str += "<div id='cm-msg-"+INDEX+"' class=\"chat-msg user\">";
    str += "          <span class=\"msg-avatar\">";
    str += "            <img src=\"https://picsum.photos/50\">";
    str += "          <\/span>";
    str += "          <div class=\"cm-msg-text\">";
    str += msg;
    str += "          <\/div>";
    str += "          <div class=\"cm-msg-button\">";
    str += "            <ul>";   
    str += btn_obj;
    str += "            <\/ul>";
    str += "          <\/div>";
    str += "        <\/div>";
    $(".chat-logs").append(str);
    $("#cm-msg-"+INDEX).hide().fadeIn(300);   
    $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);
    $("#chat-input").attr("disabled", true);
  }
  
  $(document).delegate(".chat-btn", "click", function() {
    var value = $(this).attr("chat-value");
    var name = $(this).html();
    $("#chat-input").attr("disabled", false);
    generate_message(name, 'self');
  })
  
  $("#chat-circle").click(function() {    
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
  
  $(".chat-box-toggle").click(function() {
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
})

JS)
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
            <div class="chat-logs">
                <div v-for="message in messages" :key="message.id" :class="messageClass(message)" class="chat-msg">
                    <div class="cm-msg-text">
                        {{message.message}}
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-input">      
            <form @submit.prevent="sendNewMessage">
                <input type="text" id="chat-input" v-model="messageModel" placeholder="Send a message..."/>
                <button type="submit" class="chat-submit" id="chat-submit"><i class="fab fa-telegram-plane" :style="{color: chatbot.theme_color}"></i></button>
            </form>      
        </div>
    </div>
</div>
