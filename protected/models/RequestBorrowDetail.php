<?php

class RequestBorrowDetail extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'request_borrow_detail';
	}

	public function relations()
	{
		return array(
				//'request_borrow_quantity' => array(self::BELONGS_TO, 'EquipmentGroup', 'request_borrow_quantity_id'),
				'equipment' => array(self::BELONGS_TO, 'Equipment', 'equipment_id'),
				
				
		);
	}

	public function rules() {
		return array(
				array('request_borrow_quantity_id,request_borrow_id,equipment_id,return_date,return_price,broken_price,remark','safe'),
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