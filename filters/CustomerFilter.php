<?php

namespace app\filters;

use app\helpers\App;
use app\controllers\SiteController;

class CustomerFilter extends \yii\base\ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (App::isLogin() && App::identity('isCustomer')) {


            if ($this->owner->id == 'site' && in_array($action->id, SiteController::PUBLIC_ACTIONS)) {
                return true;
            }

            if (! App::identity()->can($action->id, $this->owner->id)) {
                if (App::identity()->can('customer-dashboard', 'site')) {
                    $this->owner->redirect(['site/customer-dashboard']);
                }
                else {
                    $this->owner->redirect(['site/home']);
                }

                return false;
            }
        }

        return true;
    }
}