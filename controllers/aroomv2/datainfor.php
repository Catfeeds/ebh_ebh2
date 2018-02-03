<?php
/*
管理员资讯管理
*/
class DatainforController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getloginuser();
		$this->assign('user',$this->user);
	}
	
	public function index(){
		$this->display('aroomv2/datainfor');
	}
}
?>