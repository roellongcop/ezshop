<?php

use app\models\search\ChatSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Create Chat';
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ChatSearch();
?>
<div class="chat-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>