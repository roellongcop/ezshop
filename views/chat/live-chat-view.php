<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ChatSearch;
use app\models\Chat;
use app\helpers\App;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Chat: ' . $model->session_id;
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->session_id;
$this->params['searchModel'] = new ChatSearch();
$this->params['wrapCard'] = false; 
?>
<div class="chat-view-page">
    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title'
            ]) ?>
                <?= Detail::widget(['model' => $model]) ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
            <?php $this->endContent() ?>
        </div>
    </div>
   
</div>