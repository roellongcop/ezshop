<?php

use app\models\search\ChatSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Train Chat';
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => $chat->indexUrl];
$this->params['breadcrumbs'][] = 'Train';
$this->params['searchModel'] = new ChatSearch();
?>
<div class="chat-train-page">
	<?= $this->render('/training/_form', [
		'model' => $training,
	]) ?>
</div>