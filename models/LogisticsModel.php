<?php
/**
 * 物流model
 */
class logisticsModel extends CModel{
	public function __construct(){
		parent::__construct();
		$this->shopdb = Ebh::app()->getOtherDb('shopdb');
	}
	/**
	 * [getLogisticsList 获取物流公司列表]
	 * @return [type] [description]
	 */
	public function getLogisticsList(){
		$sql = 'select lid,name from `shop_logistics` order by lid asc limit 1000';
		return $this->shopdb->query($sql)->list_array();
	}
}