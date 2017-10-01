<?php
class AjaxRequestController extends CController {
	public $layout = 'ajax';
	private $_model;
	
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex() {
	}
	public function actionGetTypeOfEvent() {
		
		// Create connection
		mysql_connect ( ConfigUtil::getHostName (), ConfigUtil::getUsername (), ConfigUtil::getPassword () );
		mysql_select_db ( ConfigUtil::getDbName () );
		
		$json = array ();
		$sql = "SELECT id,name FROM m_type_of_event";
		
		if ($result = mysql_query ( $sql )) {
			while ( $item = mysql_fetch_assoc ( $result ) ) {
				$json [] = $item;
			}
		} else {
			print mysql_error ();
		}
		echo json_encode ( $json );
	}
	public function actionGetEquipmentType() {
		
		// Create connection
		mysql_connect ( ConfigUtil::getHostName (), ConfigUtil::getUsername (), ConfigUtil::getPassword () );
		mysql_select_db ( ConfigUtil::getDbName () );
		
		$json = array ();
		
		// $sql_condition = "";
		// switch ($typeOfEventID) {
		// case 7 :
		// $sql_condition = " where id>=11";
		// break;
		// default :
		// break;
		// }
		$sql = "SELECT id,name FROM equipment_type";
		
		if ($result = mysql_query ( $sql )) {
			while ( $item = mysql_fetch_assoc ( $result ) ) {
				$json [] = $item;
			}
		} else {
			print mysql_error ();
		}
		echo json_encode ( $json );
	}
	public function actionGetEquipmentGroup($equipment_type_id) {
		
		// Create connection
		mysql_connect ( ConfigUtil::getHostName (), ConfigUtil::getUsername (), ConfigUtil::getPassword () );
		mysql_select_db ( ConfigUtil::getDbName () );
		
		$json = array ();
		
		$sql = "SELECT id,name,img_path FROM equipment_group WHERE equipment_type_id = " . $equipment_type_id . " ORDER BY ID";
		
		if ($result = mysql_query ( $sql )) {
			while ( $item = mysql_fetch_assoc ( $result ) ) {
				$json [] = $item;
			}
		} else {
			print mysql_error ();
		}
		echo json_encode ( $json );
	}
	public function actionGetEquipmentRemain($equipment_group_id, $borrow_date) {
		
		// Create connection
		mysql_connect ( ConfigUtil::getHostName (), ConfigUtil::getUsername (), ConfigUtil::getPassword () );
		mysql_select_db ( ConfigUtil::getDbName () );
		
		$json = array ();
		
		$sqlUse = "SELECT eg.name,sum(rbq.quantity) as useEquip FROM request_borrow_quantity rbq left join request_borrow rb on rbq.request_borrow_id = rb.id left join equipment_group eg on eg.id = rbq.equipment_group_id where rbq.equipment_group_id=" . $equipment_group_id . " and rbq.seq=(select max(seq) from  request_borrow_quantity where request_borrow_id=rb.id ) and '" . $borrow_date . "' between rb.from_date and rb.to_date group by rbq.equipment_group_id";
		
		// $json[] = $sql;
		$json ['id'] = $equipment_group_id;
		$json ['useEquip'] = 0;
		if ($result = mysql_query ( $sqlUse )) {
			while ( $item = mysql_fetch_assoc ( $result ) ) {
				$json ['useEquip'] = $item ['useEquip'];
			}
		} else {
			
			// print mysql_error ();
		}
		
		$sqlTotal = "select name,count(id) as totalEquip from equipment where equipment_group_id = " . $equipment_group_id;
		if ($result = mysql_query ( $sqlTotal )) {
			while ( $item = mysql_fetch_assoc ( $result ) ) {
				$json ['name'] = $item ['name'];
				$json ['totalEquip'] = $item ['totalEquip'];
			}
		} else {
			print mysql_error ();
		}
		$json['remainEquip'] = $json ['totalEquip']-$json ['useEquip'];
		echo json_encode ( $json );
	}
	public function actionGetEquipmentGroupById($id) {
		$data = array ();
		if ($id != '') {
			
			$criteria = new CDbCriteria ();
			$criteria->condition = "id=" . $id . "";
			$equipments = EquipmentGroup::model ()->findAll ( $criteria );
			
			if (isset ( $equipments ) && count ( $equipments ) > 0) {
				$equipment = $equipments [0];
				$data ['id'] = $equipment->id;
				$data ['img_path'] = $equipment->img_path;
			} else {
				$data ['e'] = '';
			}
		} else {
			$data ['e'] = '';
		}
		echo json_encode ( $data );
	}
	public function actionGetEquipmentDetailByBarcode($id) {
		// $id = addslashes($_GET['id']);
		$data = array ();
		if ($id != '') {
			
			$criteria = new CDbCriteria ();
			$criteria->condition = "REPLACE(barcode, ' ', '') = '" . $id . "'";
			$equipments = Equipment::model ()->findAll ( $criteria );
			
			if (isset ( $equipments ) && count ( $equipments ) > 0) {
				$equipment = $equipments [0];
				$data ['id'] = $equipment->id;
				$data ['barcode'] = $id;
				$data ['equipment_type_id'] = $equipment->equipment_group->equipment_type->id;
				$data ['equipment_type_name'] = $equipment->equipment_group->equipment_type->name;
				
				$data ['equipment_group_id'] = $equipment->equipment_group_id;
				$data ['equipment_group_name'] = $equipment->equipment_group->name;
				// $data['equipment_type_list_id'] = $equipment->equipment_type_list_id;
				// $data['equipment_type_list_name'] = $equipment->equipment_type_list->name;
			} else {
				$data ['e'] = '';
			}
		} else {
			$data ['e'] = '';
		}
		echo json_encode ( $data );
	}
}