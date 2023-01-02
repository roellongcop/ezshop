<?php

namespace app\components;

class MailerComponent extends \yii\symfonymailer\Mailer
{
   public $useFileTransport = true;
	// const TRANSPORT = [
	// 	'scheme' => 'smtps',
	// 	'host' => 'ezstore.site',
	// 	'username' => '',
	// 	'password' => '',
	// 	'port' => 25,
	// 	'encryption'=>'tls',
	// ];

	// public function init()
	// {
	// 	parent::init();
	// 	$this->setTransport(self::TRANSPORT);
	// }
}