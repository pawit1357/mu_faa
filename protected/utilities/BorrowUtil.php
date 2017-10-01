<?php
class BorrowUtil {
	
	public static function getDocumentNo() {
		$borrows = RequestBorrow::model ()->findAll ();
		
		return sprintf ( '%d%2$08d', substr ( date ( 'Y' ), 2, 2 ), (count ( $borrows ) + 1) );
	}
	
	
	public static function getApprover1() {
	
		$criteria = new CDbCriteria ();
		$criteria->condition = "role_id = 3";
		$UsersLogin = UsersLogin::model ()->findAll ( $criteria );
		return $UsersLogin[0]->id;
	}
	
	public static function getApprover2() {
	
		$criteria = new CDbCriteria ();
		$criteria->condition = "role_id = 4";
		$UsersLogin = UsersLogin::model ()->findAll ( $criteria );
		return $UsersLogin[0]->id;
	}
}