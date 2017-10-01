<?php
return array(
		'name'=>'faa',
		'defaultController'=>'dashBoard',
		'import'=>array(
				'application.models.*',
				'application.components.*'
		),
		'components'=>array(
				'urlManager'=>array(
						'urlFormat'=>'path'
				),
				'db'=>array(
						'class'=>'CDbConnection',
// 						'class'=>'application.extensions.PHPPDO.CPdoDbConnection',
// 						'pdoClass' => 'PHPPDO',
						'connectionString' => 'mysql:host=localhost;dbname=faadb',
// 						'connectionString' => 'mysql:host=localhost;dbname=iceqdb01',
						'emulatePrepare' => true,
// 						'username' => 'iceqdbusr01',
// 						'password' => '1c3dpii57',		
						'username' => 'root',
						'password' => 'P@ssw0rd',
						'charset' => 'utf8',
				),
				/*
				 * UNCOMMENT extension=php_openssl.dll
* */
// 				'Smtpmail'=>array(
// 						'class'=>'application.extensions.smtpmail.PHPMailer',
// 						'Host'=>"smtp.gmail.com",
// 						'Username'=>'pawitvaap@gmail.com',
// 						'Password'=>'xxxxxx',
// 						'Mailer'=>'smtp',
// 						'Port'=>465,
// 						'SMTPAuth'=>true,
// 						'SMTPSecure'=>'ssl',
// 						'SMTPDebug'=>1
// 				),
					
		),
		
// 		muicmlea_muicv2
// 		Host:	localhost
// 		Username:	muicmlea_usr1
// 		Password:	password

);
?>