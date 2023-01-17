<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Chat;
use app\models\ChatSession;
use app\models\Training;
use app\models\search\ChatSearch;

/**
 * ChatController implements the CRUD actions for Chat model.
 */
class ChatController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Chat::findByKeywords($keywords, ['c.session_id', 'c.message', 'u.email'])
        );
    }

    /**
     * Lists all Chat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChatSearch(['type' => Chat::TYPE_USER]);
        $dataProvider = $searchModel->search(['ChatSearch' => App::queryParams()]);
        $dataProvider->query->groupBy(['c.id']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chat model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Chat::controllerFind($id),
        ]);
    }

    /**
     * Creates a new Chat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chat();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Chat model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($id)
    {
        $originalModel = Chat::controllerFind($id);
        $model = new Chat();
        $model->attributes = $originalModel->attributes;

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Duplicated');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing Chat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Chat::controllerFind($id);

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect($model->viewUrl);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Chat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function _actionDelete($id)
    {
        $model = Chat::controllerFind($id);

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }

    public function actionChangeRecordStatus()
    {
        return $this->changeRecordStatus();
    }

    public function actionBulkAction()
    {
        return $this->bulkAction();
    }

    public function actionPrint()
    {
        return $this->exportPrint();
    }

    public function actionExportPdf()
    {
        return $this->exportPdf();
    }

    public function actionExportCsv()
    {
        return $this->exportCsv();
    }

    public function actionExportXls()
    {
        return $this->exportXls();
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx();
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }

    public function actionLiveChat()
    {
        $searchModel = new ChatSearch();
        $dataProvider = $searchModel->search(['ChatSearch' => App::queryParams()]);
        $dataProvider->query->groupBy(['c.session_id']);

        return $this->render('live-chat', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLiveChatView($session_id)
    {
        $model = Chat::find()
            ->where(['session_id' => $session_id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (!$model) {
            App::danger('Chat not found');
            return $this->redirect(['live-chat']);
        }

        $chatSession = ChatSession::findOrCreate(['session_id' => $session_id]);

        if ($chatSession->isNewRecord) {
            $chatSession->status = chatSession::CHATBOT;
            $chatSession->save(false);
        }

        return $this->render('live-chat-view', [
            'model' => $model,
            'chatSession' => $chatSession,
        ]);
    }

    public function actionTrain($id)
    {
        $chat = Chat::controllerFind($id);
        $training = new Training([
            'query' => $chat->message
        ]);

        if ($training->load(App::post()) && $training->save()) {
            $chat->status = Chat::TRAINED;
            $chat->save();

            App::success('Successfully Train');
            return $this->redirect($chat->viewUrl);
        }

        return $this->render('train', [
            'chat' => $chat,
            'training' => $training,
        ]);
    }

    public function actionChatSession()
    {
        if (($post = App::post()) != null) {
            $model = ChatSession::findOne($post['id']);

            if (!$model) {
                return $this->asJson([
                    'status' => 'failed',
                    'errors' => 'No data found.',
                    'errorSummary' => 'No data found.'
                ]);
            }

            $model->status = $post['record_status'];

            if ($model->save(false)) {
                $model->refresh();
                return $this->asJson([
                    'status' => 'success',
                    'attributes' => $model->attributes
                ]);
            }
            else {
                return $this->asJson([
                    'status' => 'failed',
                    'errors' => $model->errors,
                    'errorSummary' => $model->errorSummary
                ]);
            }
        }
    }

    public function actionSendNewMessage()
    {
        if (($post = App::post()) != null) {
            $chat = new Chat([
                'session_id' => $post['session_id'],
                'type' => Chat::TYPE_CHATBOT,
                'message' => $post['message'],
                'hidden_message' => $post['hiddenMessage'],
                'status' => Chat::ANSWERED
            ]);


            if ($chat->save()) {
                return $this->asJson([
                    'status' => 'success',
                ]);
            }
            return $this->asJson([
                'status' => 'failed',
                'errorSummary' => $chat->errorSummary
            ]);
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => 'No post data'
        ]);
    }
}