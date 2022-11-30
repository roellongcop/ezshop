<?php

use app\models\search\ChatSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Update Chat: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ChatSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="chat-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>