<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Product;
use app\models\search\ProductSearch;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Product::findByKeywords($keywords, ['id'])
        );
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(['ProductSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => Product::controllerFind($slug, 'slug'),
        ]);
    }

    private function setPostData($post, $step)
    {
        if ($step == 'general') {
            $post['Product']['categories'] = $post['Product']['categories'] ?? [];
        }

        if ($step == 'photos') {
            $post['Product']['gallery'] = $post['Product']['gallery'] ?? [];
        }

        if ($step == 'variations') {
            $post['Product']['colors'] = $post['Product']['colors'] ?? [];
            $post['Product']['sizes'] = $post['Product']['sizes'] ?? [];
        }

        if ($step == 'others') {
            $post['Product']['tags'] = $post['Product']['tags'] ?? [];
        }

        if ($step == 'completed') {
            $post['Product']['record_status'] = Product::RECORD_ACTIVE;
        }

        return $post;
    }

    private function setRedirectLink($model, $step, $action='create')
    {
        switch ($step) {
            case 'general':
                $redirect = [$action, 'slug' => $model->slug, 'step' => 'inventory'];
                break;

            case 'inventory':
                $redirect = [$action, 'slug' => $model->slug, 'step' => 'photos'];
                break;

            case 'photos':
                $redirect = [$action, 'slug' => $model->slug, 'step' => 'variations'];
                break;

            case 'variations':
                $redirect = [$action, 'slug' => $model->slug, 'step' => 'others'];
                break;

            case 'others':
                $redirect = [$action, 'slug' => $model->slug, 'step' => 'completed'];
                break;

            case 'completed':
                $redirect = $model->viewUrl;
                break;

            default:
                $redirect = $model->viewUrl;
                break;
        }

        return $redirect;
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($slug='', $step='general')
    {
        $model = Product::findOrCreate(['slug' => $slug]);
        $model->setInactive();
        $stepForms = Product::stepForms($step);

        if (($post = App::post()) != null) {
            $post = $this->setPostData($post, $step);

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Processed');
                return $this->redirect($this->setRedirectLink($model, $step));
            }
        }

        $model->flashErrors();

        return $this->render('create', [
            'model' => $model,
            'activeStep' => $stepForms[$step],
            'stepForms' => $stepForms,
        ]);
    }

    /**
     * Duplicates a new Product model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($slug, $step='general')
    {
        $originalModel = Product::controllerFind($slug, 'slug');
        $model = new Product();
        $model->attributes = $originalModel->attributes;

        $model->setInactive();
        $stepForms = Product::stepForms($step);

        if (($post = App::post()) != null) {
            $post = $this->setPostData($post, $step);

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Processed');
                return $this->redirect($this->setRedirectLink($model, $step, 'update'));
            }
        }

        $model->flashErrors();

        return $this->render('duplicate', [
            'originalModel' => $originalModel,
            'model' => $model,
            'activeStep' => $stepForms[$step],
            'stepForms' => $stepForms,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug, $step='general')
    {
        $model = Product::controllerFind($slug, 'slug');
        $stepForms = Product::stepForms($step);

        if (($post = App::post()) != null) {
            $post = $this->setPostData($post, $step);

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Processed');
                return $this->redirect($this->setRedirectLink($model, $step, 'update'));
            }
        }


        $model->flashErrors();

        return $this->render('update', [
            'model' => $model,
            'activeStep' => $stepForms[$step],
            'stepForms' => $stepForms,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = Product::controllerFind($slug, 'slug');

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