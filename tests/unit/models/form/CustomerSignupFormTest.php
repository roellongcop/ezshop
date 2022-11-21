<?php

namespace tests\unit\models\form;

use app\helpers\App;
use app\models\form\CustomerSignupForm;

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
        expect_that($model->signup());
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