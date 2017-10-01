<?php
class BorrowController extends CController {
	public $layout = '_main';
	private $_model;
	public function actionIndex() {
		// Authen Login
		// if (! UserLoginUtils::isLogin ()) {
		// $this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		// }
		$model = new RequestBorrow();
		$this->render ( 'main', array (
				'data' => $model 
		) );
	}
	public function actionCreate() {
		// Authen Login
		if (! UserLoginUtils::isLogin ()) {
			$this->redirect ( Yii::app ()->createUrl ( 'Site/login' ) );
		}
		
		if (isset ( $_POST ['RequestBorrow'] )) {
			
			$transaction = Yii::app ()->db->beginTransaction ();
			// Add Request
			$eqs = $_POST ['eqs'];
			$model = new RequestBorrow ();
			$model->attributes = $_POST ['RequestBorrow'];
			$model->DocumentNo = BorrowUtil::getDocumentNo ();
			$model->create_date = date ( "Y-m-d H:i:s" );
			$model->create_by = UserLoginUtils::getUsersLoginId ();
			
			
			// Initial Approver
			switch (UserLoginUtils::getUserRole ()) {
				case 6 : // Student
					$model->approver_1 = BorrowUtil::getApprover1 ();
					$model->approver_2 = BorrowUtil::getApprover2 ();
					$model->status_code = 'WAIT_APPROVE_1';
					break;
				case 2 : // Staff
				case 5 : // Lecturer
					$model->approver_1 = - 1;
					$model->approver_2 = BorrowUtil::getApprover2 ();
					$model->status_code = 'WAIT_APPROVE_2';
					break;
				default : // Other specail
					$model->status_code = 'PREPARE_EQUIPMENT';
					break;
			}
			
// 			echo $model->DocumentNo.'<br>';
// 			echo $model->location.'<br>';
// // 			echo $model->description .'<br>';
// 			echo $model->from_date .'<br>';
// 			echo $model->to_date.'<br>';
// 			echo $model->otherDevice.'<br>';
// 			echo $model->remark.'<br>';
// 			echo $model->approver_1.'<br>';
// 			echo $model->approver_2.'<br>';
// 			echo $model->status_code.'<br>';
// 			echo $model->create_date.'<br>';
// 			echo $model->create_by.'<br>';
				
			
			
			$addSuccess = true;
			try {
				$addSuccess = $model->save ();
				
				if (isset ( $eqs )) {
					foreach ( $eqs as $equipment => $qty ) {
						
						$equipId = addslashes ( $equipment );
						list ( $equipment_type_id, $quantity ) = split ( ',', $equipId );
						$requestBorrowQuantity = new RequestBorrowQuantity ();
						$requestBorrowQuantity->request_borrow_id = $model->getPrimaryKey ();
						$requestBorrowQuantity->equipment_group_id = $equipment_type_id;
						$requestBorrowQuantity->quantity = $quantity;
						$requestBorrowQuantity->seq = 1;
						if (! $requestBorrowQuantity->save ()) {
							$addSuccess = false;
							break;
						}
					}
				}
				if ($addSuccess) {
					$transaction->commit ();
					
					// Initial Send Mail
					switch ($model->status_code) {
						case 'WAIT_APPROVE_1' :
							// send mail to approver 1
							// send mail to borrower
							break;
						case 'PREPARE_EQUIPMENT' :
							// send to borrower
							break;
					}
					
					$this->redirect ( Yii::app ()->createUrl ( 'Borrow/' ) );
				} else {
					$transaction->rollback ();
					$this->render ( 'create' );
				}

			} catch ( CDbException $e ) {
				echo $e;
// 				$this->redirect ( Yii::app ()->createUrl ( 'Error/503' . $e ) );
			}
		} else {
			// Render
			$this->render ( 'create' );
		}
	}
	public function actionPrepare() {
		$model = $this->loadModel ();
		
		if (isset ( $_POST ['RequestBorrow'] )) {
			
			$transaction = Yii::app ()->db->beginTransaction ();
			
			try {
				$eqItems = $_POST ['eqItems'];
				
				$model->attributes = $_POST ['RequestBorrow'];
				$model->status_code = 'READY';
				
				// "::::::" . $model->otherDevice;
				
				if (isset ( $eqItems )) {
					foreach ( $eqItems as $key => $value ) {
						
						$equipId = addslashes ( $key );
						list ( $equipment_group_id, $equipment_id ) = split ( ',', $equipId );
						
						// echo $equipment_group_id . "," . $barcode . "," . $quantity . "<br>";
						
						$criteria = new CDbCriteria ();
						$criteria->condition = "seq = 2 and request_borrow_id = " . $model->getPrimaryKey () . " and equipment_group_id=" . $equipment_group_id;
						$bqs = RequestBorrowQuantity::model ()->findAll ( $criteria );
						
						if (isset ( $bqs ) && count ( $bqs ) > 0) {
							$bq = $bqs [0];
							$bq->quantity = $bq->quantity + 1;
							$bq->update ();
						} else {
							$requestBorrowQuantity = new RequestBorrowQuantity ();
							$requestBorrowQuantity->request_borrow_id = $model->getPrimaryKey ();
							$requestBorrowQuantity->equipment_group_id = $equipment_group_id;
							$requestBorrowQuantity->quantity = 1;
							$requestBorrowQuantity->seq = 2;
							$requestBorrowQuantity->save ();
							echo $model->getPrimaryKey () . "," . $equipment_group_id . "<br>";
						}
						
						$requestBorrowDetail = new RequestBorrowDetail ();
						$requestBorrowDetail->request_borrow_quantity_id = $equipment_group_id;
						$requestBorrowDetail->request_borrow_id = $model->getPrimaryKey ();
						$requestBorrowDetail->equipment_id = $equipment_id;
						// $requestBorrowDetail->return_date = 1;
						// $requestBorrowDetail->return_price = 2;
						// $requestBorrowDetail->broken_price;
						// $requestBorrowDetail->remark
						$requestBorrowDetail->save ();
					}
				}
				
				$model->update ();
				$transaction->commit ();
				$this->redirect ( Yii::app ()->createUrl ( 'Borrow/' ) );
			} catch ( CDbException $e ) {
				$transaction->rollback ();
				
				$this->redirect ( Yii::app ()->createUrl ( 'Error/503' . $e ) );
			}
		} else {
			$this->render ( 'prepare', array (
					'data' => $model 
			) );
		}
	}
	public function actionReturn() {
		$model = $this->loadModel ();
		
		if (isset ( $_POST ['RequestBorrow'] )) {
			
			// $transaction = Yii::app ()->db->beginTransaction ();
			
			// try {
			
			//echo "hi";
			$selectedItems = $_POST ['selectedItems'];
			
			$model->attributes = $_POST ['RequestBorrow'];
			$model->status_code = 'RETURNED';
			
			// // "::::::" . $model->otherDevice;
			
			if (isset ( $selectedItems )) {
				foreach ( $selectedItems as $key => $value ) {
					echo "-->".$key;
					// $equipId = addslashes ( $key );
					// list ( $equipment_group_id, $equipment_id ) = split ( ',', $equipId );
					
					// $criteria = new CDbCriteria ();
					// $criteria->condition = "seq = 2 and request_borrow_id = " . $model->getPrimaryKey () . " and equipment_group_id=" . $equipment_group_id;
					// $bqs = RequestBorrowQuantity::model ()->findAll ( $criteria );
					
					// if (isset ( $bqs ) && count ( $bqs ) > 0) {
					// $bq = $bqs [0];
					// $bq->quantity = $bq->quantity + 1;
					// $bq->update ();
					// } else {
					// $requestBorrowQuantity = new RequestBorrowQuantity ();
					// $requestBorrowQuantity->request_borrow_id = $model->getPrimaryKey ();
					// $requestBorrowQuantity->equipment_group_id = $equipment_group_id;
					// $requestBorrowQuantity->quantity = 1;
					// $requestBorrowQuantity->seq = 2;
					// $requestBorrowQuantity->save ();
					// echo $model->getPrimaryKey() . "," . $equipment_group_id . "<br>";
					
					// }
					
					// $requestBorrowDetail = new RequestBorrowDetail ();
					// $requestBorrowDetail->request_borrow_quantity_id = $equipment_group_id;
					// $requestBorrowDetail->equipment_id = $equipment_id;
					// //$requestBorrowDetail->return_date = 1;
					// // $requestBorrowDetail->return_price = 2;
					// // $requestBorrowDetail->broken_price;
					// // $requestBorrowDetail->remark
					// $requestBorrowDetail->save ();
				}
			}
			
			// $model->update ();
			// $transaction->commit ();
			// $this->redirect ( Yii::app ()->createUrl ( 'Borrow/' ) );
			
			// } catch ( CDbException $e ) {
			// $transaction->rollback ();
			
			// $this->redirect ( Yii::app ()->createUrl ( 'Error/503' . $e ) );
			// }
		} else {
			$this->render ( 'return', array (
					'data' => $model 
			) );
		}
	}
	public function actionApprove() {
		$model = $this->loadModel ();
		$transaction = Yii::app ()->db->beginTransaction ();
		try {
			switch ($model->status_code) {
				case 'WAIT_APPROVE_1' :
					$model->status_code = 'WAIT_APPROVE_2';
					// send mail to approver 1
					// send mail to borrower
					break;
				case 'WAIT_APPROVE_2' :
					$model->status_code = 'PREPARE_EQUIPMENT';
					// send to borrower
					break;
			}
			if ($model->save ()) {
				$transaction->commit ();
				$this->redirect ( Yii::app ()->createUrl ( 'Borrow/' ) );
			}
		} catch ( CDbException $e ) {
			$transaction->rollback ();
			$this->redirect ( Yii::app ()->createUrl ( 'Error/503' . $e ) );
		}
	}
	public function actionDisApprove() {
		$model = $this->loadModel ();
		$transaction = Yii::app ()->db->beginTransaction ();
		try {
			$model->status_code = 'DIS_APPROVE';
			if ($model->save ()) {
				$transaction->commit ();
				$this->redirect ( Yii::app ()->createUrl ( 'Borrow/' ) );
			}
		} catch ( CDbException $e ) {
			$transaction->rollback ();
			$this->redirect ( Yii::app ()->createUrl ( 'Error/503' . $e ) );
		}
	}
	public function actionDelete() {
		$model = $this->loadModel ();
		$model->delete ();
		
		$this->redirect ( Yii::app ()->createUrl ( 'Ad/' ) );
	}
	public function actionUpdate() {
		
		// Permission
		// $model = $this->loadModel ();
		// if (isset ( $_POST ['AdPlan'] )) {
		// $transaction = Yii::app ()->db->beginTransaction ();
		// // Add Request
		// $model->attributes = $_POST ['AdPlan'];
		// $addSuccess = true;
		
		// try {
		
		// $name = $_FILES ['fileUpload'] ['name'];
		// $tmpName = $_FILES ['fileUpload'] ['tmp_name'];
		// $error = $_FILES ['fileUpload'] ['error'];
		// $size = $_FILES ['fileUpload'] ['size'];
		// $ext = strtolower ( pathinfo ( $name, PATHINFO_EXTENSION ) );
		
		// switch ($error) {
		// case UPLOAD_ERR_OK :
		// $valid = true;
		// // validate file extensions
		// if (! in_array ( $ext, array (
		// 'mp4'
		// ) )) {
		// $valid = false;
		// $response = 'Invalid file extension.';
		// }
		// // validate file size
		// // if ( $size/1024/1024 > 2 ) {
		// // $valid = false;
		// // $response = 'File size is exceeding maximum allowed size.';
		// // }
		// // upload file
		// if ($valid) {
		// $targetPath = 'uploads' . DIRECTORY_SEPARATOR . $name;
		// move_uploaded_file ( $tmpName, $targetPath );
		// // header( 'Location: index.php' ) ;
		// // exit ();
		// }
		// break;
		// case UPLOAD_ERR_INI_SIZE :
		// $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
		// break;
		// case UPLOAD_ERR_FORM_SIZE :
		// $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
		// break;
		// case UPLOAD_ERR_PARTIAL :
		// $response = 'The uploaded file was only partially uploaded.';
		// break;
		// case UPLOAD_ERR_NO_FILE :
		// $response = 'No file was uploaded.';
		// break;
		// case UPLOAD_ERR_NO_TMP_DIR :
		// $response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
		// break;
		// case UPLOAD_ERR_CANT_WRITE :
		// $response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
		// break;
		// case UPLOAD_ERR_EXTENSION :
		// $response = 'File upload stopped by extension. Introduced in PHP 5.2.0.';
		// break;
		// default :
		// $response = 'Unknown error';
		// break;
		// }
		// //
		// $adPlan->file_path = DIRECTORY_SEPARATOR . ConfigUtil::getAppName () . DIRECTORY_SEPARATOR . $targetPath;
		
		// if (! $model->update ()) {
		// $addSuccess = false;
		// }
		// if ($addSuccess) {
		// $transaction->commit ();
		// $this->redirect ( Yii::app ()->createUrl ( 'Ad/' ) );
		// } else {
		// $transaction->rollback ();
		// }
		// } catch ( CDbException $e ) {
		// $this->redirect ( Yii::app ()->createUrl ( 'Error/503' ) );
		// }
		// }
		
		// $this->render ( 'update', array (
		// 'model' => $model
		// ) );
	}
	public function loadModel() {
		if ($this->_model === null) {
			if (isset ( $_GET ['id'] )) {
				$id = addslashes ( $_GET ['id'] );
				$this->_model = RequestBorrow::model ()->findbyPk ( $id );
			}
			if ($this->_model === null)
				throw new CHttpException ( 404, 'The requested page does not exist.' );
		}
		return $this->_model;
	}
}