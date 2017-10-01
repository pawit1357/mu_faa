<?php

class UsersLogin extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'users_login';
	}

	public function relations()
	{
		return array(
				'users_role' => array(self::BELONGS_TO, 'UsersRole', 'role_id'),
				'title' => array(self::BELONGS_TO, 'Title', 'title_id'),
				'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
		);
	}

	public function rules() {
		return array(
				array(
						'id,
						role_id,
						username,
						password,
						latest_login,
						email,
						create_by,
						create_date,
						status,
						is_force_change_password,
						title_id,
						first_name,
						last_name,
						mobile_phone,department_id,update_by,update_date', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
				
		);
	}

	public function getUrl($post=null)
	{
		if($post===null)
			$post=$this->post;
		return $post->url.'#c'.$this->id;
	}

	protected function beforeSave()
	{
		return true;
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
				'sort' => array(
						'defaultOrder' => 't.create_date desc',
				),
				'pagination' => array(
						'pageSize' => 15//ConfigUtil::getDefaultPageSize()
				),
		));
	}
}