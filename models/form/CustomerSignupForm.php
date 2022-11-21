<?php

namespace app\models\form;

use app\models\User;
use app\models\Role;

class CustomerSignupForm extends \yii\base\Model
{
    public $email;
    public $password; 
    public $confirm_password; 

    public $_user; 

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password', 'confirm_password'], 'required'],
            [['email', 'password', 'confirm_password'], 'string'],
            [['email', 'password', 'confirm_password'], 'trim'],
            [['email'], 'email'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password'],
            ['email', 'validateEmail'],
            ['password', 'string', 'min' => 6]
        ];
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }

    public function validateEmail($attribute, $params)
    {
        if (($user = $this->getUser()) != null) {
            $this->addError($attribute, 'Email exist');
        }
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->email;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->role_id = Role::CUSTOMER;
            $user->status = User::STATUS_UNVERIFIED;
            $user->is_blocked = User::UNBLOCKED;

            if ($user->save()) {

                return $user;
            }
            else {
                $this->addError('user', $user->errors);
            }
        }
    }
}