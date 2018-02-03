<?php
class DefaultController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkteacher();
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->display('croom/index');
	}
}
?>