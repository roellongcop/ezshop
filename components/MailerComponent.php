<?php

namespace app\components;

class MailerComponent extends \yii\symfonymailer\Mailer
{
    public $useFileTransport = true;
   
}