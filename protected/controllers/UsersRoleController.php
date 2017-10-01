<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class UsersRoleController extends CController {
	public $layout = '_main';
	private $_model;
	
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex() {
		// Authen Login
		if (! UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		
		$model = new UsersRole ();
		$this->render ( 'main', array (
				'data' => $model 
		) );
	}
	public function actionCreate() {
		// Authen Login
		if (! UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		
		if (isset ( $_POST ['UsersRole'] )) {
			
			$transaction = Yii::app ()->db->beginTransaction ();
			
			$model = new UsersRole ();
			$model->attributes = $_POST ['UsersRole'];
			$model->UPDATE_BY = UserLoginUtils::getUsersLoginId ();
			$model->CREATE_DATE = date ( "Y-m-d H:i:s" );
			$model->UPDATE_DATE = date ( "Y-m-d H:i:s" );
			$model->save ();
			
			
			// ADD NEW
			$dataProvider = Menu::model ()->search ();
			$index = 1;
			foreach ( $dataProvider->data as $menu ) {
				
				$menu_role = new MenuRole ();
				$menu_role->ROLE_ID = $model->ROLE_ID;
				$menu_role->MENU_ID = $menu->MENU_ID;
				$menu_role->IS_ACTIVE = false;
				$menu_role->IS_REQUIRED_ACTION = false;
				$menu_role->IS_CREATE = false;
				$menu_role->IS_EDIT = false;
				$menu_role->IS_DELETE = false;
				
				$listOfActive = $_POST ['listOfActive'];
				$listOfCreate = $_POST ['listOfCreate'];
				$listOfEdit = $_POST ['listOfEdit'];
				$listOfDelete = $_POST ['listOfDelete'];
				
				if (isset ( $listOfActive )) {
					foreach ( $listOfActive as $item ) {
						if ($item == $menu->MENU_ID) {
							$menu_role->IS_ACTIVE = true;
							break;
						}
					}
				}
				if (isset ( $listOfCreate )) {
					foreach ( $listOfCreate as $item ) {
						if ($item == $menu->MENU_ID) {
							$menu_role->IS_CREATE = true;
							break;
						}
					}
				}
				if (isset ( $listOfEdit )) {
					foreach ( $listOfEdit as $item ) {
						if ($item == $menu->MENU_ID) {
							$menu_role->IS_EDIT = true;
							break;
						}
					}
				}
				if (isset ( $listOfDelete )) {
					foreach ( $listOfDelete as $item ) {
						if ($item == $menu->MENU_ID) {
							$menu_role->IS_DELETE = true;
							break;
						}
					}
				}
				$menu_role->UPDATE_BY = UserLoginUtils::getUsersLoginId ();
				$menu_role->CREATE_DATE = date ( "Y-m-d H:i:s" );
				$menu_role->UPDATE_DATE = date ( "Y-m-d H:i:s" );
				$menu_role->save ();
			}
			
			$transaction->commit ();
			
			$this->redirect ( Yii::app ()->createUrl ( 'UsersRole' ) );
		} else {
			$model = new UsersRole ();
			$this->render ( 'create', array (
					'data' => $model 
			) );
		}
	}
	public function actionUpdate() {
		// Authen Login
		if (! UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		$model = $this->loadModel ();
		
		if (isset ( $_POST ['UsersRole'] )) {
			
			$transaction = Yii::app ()->db->beginTransaction ();
			
			$model->attributes = $_POST ['UsersRole'];
			$model->UPDATE_BY = UserLoginUtils::getUsersLoginId ();
			$model->CREATE_DATE = date ( "Y-m-d H:i:s" );
			$model->UPDATE_DATE = date ( "Y-m-d H:i:s" );
			$model->update ();
			
			// Delete old role
			$cri = new CDbCriteria ();
			$cri->condition = " ROLE_ID=" . $model->ROLE_ID;
			MenuRole::model ()->deleteAll ( $cri );
			// ADD NEW
			$dataProvider = Menu::model ()->search ();
			$index = 1;
			foreach ( $dataProvider->data as $menu ) {
				
				$menu_role = new MenuRole ();
				$menu_role->ROLE_ID = $model->ROLE_ID;
				$menu_role->MENU_ID = $menu->MENU_ID;
				$menu_role->IS_ACTIVE = false;
				$menu_role->IS_REQUIRED_ACTION = false;
				$menu_role->IS_CREATE = false;
				$menu_role->IS_EDIT = false;
				$menu_role->IS_DELETE = false;
				
				$listOfActive = $_POST ['listOfActive'];
				$listOfCreate = $_POST ['listOfCreate'];
				$listOfEdit = $_POST ['listOfEdit'];
				$listOfDelete = $_POST ['listOfDelete'];
				
				if (isset ( $listOfActive )) {
					foreach ( $listOfActive as $item ) {
						if ($item == $menu->MENU_ID) {
							$menu_role->IS_ACTIVE = true;
							break;
						}
					}
				}
				if (isset ( $listOfCreate )) {
					foreach ( $listOfCreate as $item ) {
						if ($item == $menu->MENU_ID) {
							$menu_role->IS_CREATE = true;
							break;
						}
					}
				}
				if (isset ( $listOfEdit )) {
					foreach ( $listOfEdit as $item ) {
						if ($item == $menu->MENU_ID) {
							$menu_role->IS_EDIT = true;
							break;
						}
					}
				}
				if (isset ( $listOfDelete )) {
					foreach ( $listOfDelete as $item ) {
						if ($item == $menu->MENU_ID) {
							$menu_role->IS_DELETE = true;
							break;
						}
					}
				}
				$menu_role->UPDATE_BY = UserLoginUtils::getUsersLoginId ();
				$menu_role->CREATE_DATE = date ( "Y-m-d H:i:s" );
				$menu_role->UPDATE_DATE = date ( "Y-m-d H:i:s" );
				$menu_role->save ();
			}
			
			$transaction->commit ();
			
			$this->redirect ( Yii::app ()->createUrl ( 'UsersRole' ) );
		} else {
			$this->render ( 'update', array (
					'data' => $model 
			) );
		}
	}
	
	
	public function actionDelete() {
		
		$transaction = Yii::app ()->db->beginTransaction ();
		$model = $this->loadModel ();
		
		//delete fk
			$cri = new CDbCriteria ();
			$cri->condition = " ROLE_ID=" . $model->ROLE_ID;
			MenuRole::model ()->deleteAll ( $cri );
		//delete pk
		$model->delete ();
		$transaction->commit ();
		
		$this->redirect ( Yii::app ()->createUrl ( 'UsersRole/' ) );
	}	
	
	
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] )) {
				$id = addslashes ( $_GET ['id'] );
				$this->_model = UsersRole::model ()->findbyPk ( $id );
			}
			if ($this->_model === null)
				throw new CHttpException ( 404, 'The requested page does not exist.' );
		}
		return $this->_model;
	}
}