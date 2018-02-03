<?php 
class ModuleditController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	
	public function index(){
		$this->display('aroomv2/moduledit');
	}
	
}
?>