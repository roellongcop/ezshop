<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Backup;
use app\models\File;
use app\models\Ip;
use app\models\Log;
use app\models\Notification;
use app\models\Queue;
use app\models\Role;
use app\models\Session;
use app\models\Setting;
use app\models\Theme;
use app\models\User;
use app\models\UserMeta;
use app\models\VisitLog;
use app\models\Visitor;
use app\models\Order;
use app\helpers\ArrayHelper;
use app\models\search\DashboardSearch;

/**
 * BackupController implements the CRUD actions for Backup model.
 */
class DashboardController extends Controller
{
    public function actionFindByKeywords($keywords='')
    {
        $data = array_merge(
            File::findByKeywords($keywords, ['name', 'extension', 'token']),
            Backup::findByKeywords($keywords, ['filename', 'tables', 'description']),
            Ip::findByKeywords($keywords, ['name', 'description']),
            Log::findByKeywords($keywords, ['method', 'action', 'controller', 'table_name', 'model_name']),
            Notification::findByKeywords($keywords, ['message']),
            Queue::findByKeywords($keywords, ['channel', 'job', 'pushed_at']),
            Role::findByKeywords($keywords, ['name']),
            Session::findByKeywords($keywords, ['id', 'expire', 'ip', 'browser', 'os', 'device']),
            Setting::findByKeywords($keywords, ['name', 'value']),
            Theme::findByKeywords($keywords, ['name', 'description']),
            User::findByKeywords($keywords, ['username', 'email']), 
            UserMeta::findByKeywords($keywords, ['name', 'value']), 
            VisitLog::findByKeywords($keywords, ['ip']), 
            Visitor::findByKeywords($keywords, ['expire', 'cookie', 'ip', 'browser', 'os', 'device', 'location'])
        );

        $data = array_unique($data);
        $data = array_values($data);
        sort($data);

        return $this->asJson($data);
    }

    /**
     * Lists all Backup models.
     * @return mixed
     */
    public function actionIndex($year='')
    {
        $year = $year ?: App::formatter()->asDateToTimezone('', 'Y');


        $searchModel = new DashboardSearch();

        if (($queryParams = App::queryParams()) != null) {
            $dataProviders = $searchModel->search(['DashboardSearch' => $queryParams]);

            if ($searchModel->keywords) {
                return $this->render('search_result', [
                    'dataProviders' => $dataProviders,
                    'searchModel' => $searchModel,
                ]);
            }
            else {
                if (! App::queryParams('year')) {
                    return $this->redirect(['index']);
                }
            }
        }

        $monthlySales = Order::find()
            ->select(['MONTH(created_at) AS month', 'AVG(total) as average'])
            ->where([
                'status' => Order::STATUS_COMPLETED,
                'DATE_FORMAT(created_at, "%Y")' => $year
            ])
            ->groupBy('month')
            ->orderBy(['month' => SORT_ASC])
            ->asArray()
            ->all();

        if ($monthlySales) {
            $max = max(array_keys(ArrayHelper::map($monthlySales, 'average', 'month')));
            $totalMontlySales = 0;
            foreach ($monthlySales as &$data) {
                $totalMontlySales += $data['average'];
                $data['percent'] = number_format(($data['average'] / $max) * 100, 2);
                $data['average'] = App::formatter()->asPeso($data['average']);
                $data['month'] = App::params('months')[$data['month']];
            }
        }
        else {
            $monthlySales = [];
            $totalMontlySales = 0;
        }

        $years = Order::find()
            ->select(['DATE_FORMAT(created_at, "%Y") as year'])
            ->groupBy('year')
            ->asArray()
            ->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'monthlySales' => $monthlySales,
            'totalMontlySales' => $totalMontlySales,
            'year' => $year,
            'years' => $years,
        ]);
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }

    public function actionMonthlyOrders($year='')
    {
        $year = $year ?: App::formatter()->asDateToTimezone('', 'Y');

        $monthlyOrders = Order::find()
            ->select(['MONTH(created_at) AS month', 'COUNT("*") as total'])
            ->where([
                'status' => Order::STATUS_COMPLETED,
                'DATE_FORMAT(created_at, "%Y")' => $year
            ])
            ->groupBy('month')
            ->orderBy(['month' => SORT_ASC])
            ->asArray()
            ->all();

        if (!$monthlyOrders) {
            return $this->asJson([
                'status' => 'success',
                'months' => [],
                'totals' => [],
                'totalOrders' => 0
            ]);
        }

        foreach ($monthlyOrders as &$data) {
            $data['month'] = App::params('months')[$data['month']];
        }

        $monthlyOrders = ArrayHelper::map($monthlyOrders, 'month', 'total');

        return $this->asJson([
            'status' => 'success',
            'months' => array_keys($monthlyOrders),
            'totals' => array_values($monthlyOrders),
            'totalOrders' => array_sum(array_values($monthlyOrders))
        ]);
    }
}