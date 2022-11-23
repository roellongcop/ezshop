<?php

namespace tests\unit\models\form;

use app\helpers\App;
use app\models\form\CustomerSignupForm;
use app\models\form\user\BillingDetailForm;

class CustomerSignupFormTest extends \Codeception\Test\Unit
{
    private function data($replace=[])
    {
        return array_replace([
            'email' => 'sample@email.com',
            'password' => 'password',
            'confirm_password' => 'password',
        ], $replace);
    }

    public function testSuccess()
    {
        $model = new CustomerSignupForm($this->data());
        $user = $model->signup();
        expect_that($user);

        $billing = new BillingDetailForm(['user_id' => $user->id]);
        expect($billing->email)->equals($user->email);
    }

    public function testExistingEmail()
    {
        $model = new CustomerSignupForm($this->data([
            'email' => 'developer@developer.com'
        ]));
        expect_not($model->signup());
        expect($model->errors)->hasKey('email');
    }


    public function testPasswordConfirmInvalid()
    {
        $model = new CustomerSignupForm($this->data([
            'confirm_password' => 'test@test.com',
        ]));
        expect_not($model->signup());
        expect($model->errors)->hasKey('confirm_password');
    }

}