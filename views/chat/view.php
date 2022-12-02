<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ChatSearch;
use app\models\Chat;
use app\helpers\App;
use app\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Chat: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ChatSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="chat-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 

    <?= App::if($model->status != Chat::TRAINED, 
        Html::a('Train', ['train', 'id' => $model->id], [
            'class' => 'btn btn-success font-weight-bold'
        ])
    ) ?>
    <?= Detail::widget(['model' => $model]) ?>
</div>