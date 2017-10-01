<?php
session_start();
// include Yii bootstrap file
require_once(dirname(__FILE__).'/framework/yii.php');
$config=dirname(__FILE__).'/protected/config/main.php';

// include custom class
require_once dirname(__FILE__).'/protected/utilities/UserLoginUtils.php';
require_once dirname(__FILE__).'/protected/utilities/ConfigUtil.php';
require_once dirname(__FILE__).'/protected/utilities/MenuUtil.php';
require_once dirname(__FILE__).'/protected/utilities/GridUtil.php';
require_once dirname(__FILE__).'/protected/utilities/BorrowUtil.php';





// create a Web application instance and run
$app = Yii::createWebApplication($config);
Yii::app()->setTimeZone('UTC');
$app->run();
// Yii::createWebApplication($config);
// Yii::app()->setTimeZone('UTC');
// app->run()