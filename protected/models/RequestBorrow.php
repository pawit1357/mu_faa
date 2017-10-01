<?php
class RequestBorrow extends CActiveRecord {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function tableName() {
		return 'request_borrow';
	}
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
				'user_login' => array (
						self::BELONGS_TO,
						'UsersLogin',
						'create_by' 
				),
	
		);
	}
	public function rules() {
		return array (
				array (
						'DocumentNo,
						location,
						description,
						from_date,
						to_date,
						status_code,
						otherDevice,
						remark,
						create_date,
						create_by,approver_1,approver_2',
						'safe' 
				) 
		);
	}
	public function attributeLabels() {
		return array ();

		
	}
	public function getUrl($post = null) {
		if ($post === null)
			$post = $this->post;
		return $post->url . '#c' . $this->id;
	}
	protected function beforeSave() {
		return true;
	}
	public function search() {
		$criteria = new CDbCriteria ();
		switch (UserLoginUtils::getUserRole ()) {
			case 1 : // Admin
				break;
			case 3 : // Approver 1
				$criteria->condition = "create_by = ".UserLoginUtils::getUsersLoginId()." or (approver_1=".UserLoginUtils::getUsersLoginId()." and status_code='WAIT_APPROVE_1')";
				break;
			case 4 : // Approver 2
				$criteria->condition = "create_by = ".UserLoginUtils::getUsersLoginId()." or (approver_2=".UserLoginUtils::getUsersLoginId()." and status_code='WAIT_APPROVE_2')";
				break;
			case 2 : // Staff
			case 5 : // Lecturer
			case 6 : // Student
				$criteria->condition = "create_by = ".UserLoginUtils::getUsersLoginId();
				break;
		}
		
		return new CActiveDataProvider ( get_class ( $this ), array (
				'criteria' => $criteria,
				'sort' => array (
						'defaultOrder' => 't.ID asc' 
				),
				'pagination' => array (
						'pageSize' => ConfigUtil::getDefaultPageSize () 
				) 
		) );
	}
}