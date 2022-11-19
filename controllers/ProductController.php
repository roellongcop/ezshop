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
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Product::controllerFind($id),
        ]);
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
            if ($step == 'gallery') {
                $post['Product']['categories'] = $post['Product']['categories'] ?? [];
            }

            if ($step == 'photos') {
                $post['Product']['gallery'] = $post['Product']['gallery'] ?? [];
            }

            if ($step == 'others') {
                $post['Product']['tags'] = $post['Product']['tags'] ?? [];
            }

            if ($step == 'completed') {
                $model->setActive();
            }

            if ($model->load($post) && $model->save()) {

                switch ($step) {
                    case 'general':
                        App::success('Successfully Created');

                        return $this->redirect(['create', 'slug' => $model->slug, 'step' => 'inventory']);
                        break;

                    case 'inventory':
                        App::success('Inventory Created');

                        return $this->redirect(['create', 'slug' => $model->slug, 'step' => 'photos']);
                        break;

                    case 'photos':
                        App::success('Photo Gallery Created');

                        return $this->redirect(['create', 'slug' => $model->slug, 'step' => 'others']);
                        break;

                    case 'others':
                        App::success('Tags & Shipping Created');

                        return $this->redirect(['create', 'slug' => $model->slug, 'step' => 'completed']);
                        break;

                    case 'completed':
                        App::success('Product Successfully Completed');
                        return $this->redirect($model->viewUrl);
                        break;
                    
                    default:
                        return $this->redirect($model->viewUrl);
                        break;
                }

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
    public function actionDuplicate($id)
    {
        $originalModel = Product::controllerFind($id);
        $model = new Product();
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
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Product::controllerFind($id);

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect($model->viewUrl);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Product::controllerFind($id);

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