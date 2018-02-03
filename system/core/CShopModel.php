<?php
/**
*商城
*/
class CShopModel extends CModel{
	var $shopdb;
	public function __construct(){
		parent::__construct();
		$this->shopdb = Ebh::app()->getOtherDb('shopdb');
	}
}