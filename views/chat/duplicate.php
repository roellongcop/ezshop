<?php

use app\models\search\ChatSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Duplicate Chat: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ChatSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="chat-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>