<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends CController {
	public $layout = '_login';
	private $_model;
	public function actionIndex() {
		// Authen Login
		if (! UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( '' ) );
		}
		// Render
		$this->redirect ( Yii::app ()->createUrl ( 'DashBoard/' ) );
	}
	
	/**
	 * Login Page
	 */
	public function actionLogin() {
		// if login redirect to index
		if (UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( '' ) );
		}
		
		if (isset ( $_POST ['UsersLogin'] ['username'] ) && isset ( $_POST ['UsersLogin'] ['password'] )) {
			
			$username = addslashes ( $_POST ['UsersLogin'] ['username'] );
			$password = addslashes ( $_POST ['UsersLogin'] ['password'] );
			
			// Authen
			if (UserLoginUtils::authen ( $username, $password )) {
				$this->redirect ( Yii::app ()->createUrl ( 'DashBoard/' ) );
			} else {				
				$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
			}
		}
		$this->render ( 'login' );
	}
	
	/**
	 * Logout
	 */
	public function actionLogout() {
		UserLoginUtils::logout ();
		$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
	}
}