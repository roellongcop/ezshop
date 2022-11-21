<?php

namespace app\filters;

use Yii;
use app\helpers\App;

class CustomerFilter extends \yii\base\ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (App::isLogin()) {
            if (App::identity('isCustomer')) {
                $this->redirect(['site/home']);
                return false;
            }
        }

        return true;
    }
}