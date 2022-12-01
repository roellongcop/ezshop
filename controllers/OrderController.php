<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Order;
use app\models\search\OrderSearch;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Order::findByKeywords($keywords, [
                'order_no', 
                'billing_firstname', 
                'billing_lastname',
                'subtotal',
                'shipping',
                'total',
            ])
        );
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(['OrderSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $order_no
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($order_no)
    {
        $model = Order::controllerFind($order_no, 'order_no');
        $model->process();

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Order model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($order_no)
    {
        $originalModel = Order::controllerFind($order_no, 'order_no');
        $model = new Order();
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
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $order_no
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($order_no)
    {
        $model = Order::controllerFind($order_no, 'order_no');

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
        }

        return $this->redirect($model->viewUrl);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $order_no
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($order_no)
    {
        $model = Order::controllerFind($order_no, 'order_no');

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
}