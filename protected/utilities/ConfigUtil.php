<?php
class ConfigUtil {
	private static $siteName = 'http://www.prdapp.net/itechservice/';
	private static $ApplicationTitle = 'FAA | Fire and Applied Arts Division';
	private static $ApplicationCopyRight = 'Copyright © 2010 Mahidol University. All rights reserved.';
	private static $ApplicationAddress = '';
	private static $ApplicationUpdateVersion = '<li class="fa fa-clock-o"></li> &nbsp;Lasted Update 2016-03-20';
	private static $AppName = '';	


	private static $defaultPageSize = 15;

	public static function getDbName() {
		$str = Yii::app()->db->connectionString;
		list($host, $db) = explode(';', $str);
		list($xx, $dbName) = explode('=', $db);
		return $dbName;
	}
	public static function getHostName() {
		$str = Yii::app()->db->connectionString;
		list($host, $db) = explode(';', $str);
		list($xx, $hostName) = explode('=', $host);
		return $hostName;
	}
	public static function getUsername() {
		return Yii::app()->db->username;
	}
	public static function getPassword() {
		return Yii::app()->db->password;
	}
	public static function getSiteName() {
		return self::$siteName;
	}
	public static function getAppName() {
		return self::$AppName;
	}
	public static function getApplicationTitle() {
		return self::$ApplicationTitle;
	}
	public static function getApplicationCopyRight() {
		return self::$ApplicationCopyRight;
	}
	public static function getApplicationAddress() {
		return self::$ApplicationAddress;
	}
	
	public static function getApplicationUpdateVersion() {
		return self::$ApplicationUpdateVersion;
	}
	
	public static function getDefaultPageSize() {
		return self::$defaultPageSize;
	}
}
?>