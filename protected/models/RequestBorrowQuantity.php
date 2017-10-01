<?php

class RequestBorrowQuantity extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'request_borrow_quantity';
	}

	public function relations()
	{
		return array(
				'equipment_group' => array(self::BELONGS_TO, 'EquipmentGroup', 'equipment_group_id'),
				
				
		);
	}

	public function rules() {
		return array(
				array(
						'request_borrow_id,equipment_group_id,quantity,seq','safe'),
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
						'defaultOrder' => 't.DISPLAY_ORDER asc',
				),
				'pagination' => array(
						'pageSize' => ConfigUtil::getDefaultPageSize()
				),
		));
	}
}