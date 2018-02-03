<?php
/**
*免费资源对应的数据库Model类
*/
class CFreeResourceModel extends CModel{
	var $freeresourcedb;
	public function __construct(){
		parent::__construct();
		$this->freeresourcedb = Ebh::app()->getOtherDb('freeresourcedb');
	}
}