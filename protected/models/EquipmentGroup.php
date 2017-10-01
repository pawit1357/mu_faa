<?php

class EquipmentGroup extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'equipment_group';
	}

	public function relations()
	{
		return array(
				'equipment_type' => array(self::BELONGS_TO, 'EquipmentType', 'equipment_type_id'),
				
		);
	}

	public function rules() {
		return array(
				array('id,equipment_type_id,name,img_path','safe'),
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