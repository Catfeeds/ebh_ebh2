<?php
/*
云教育网校
*/
class MycloudController extends CControl{
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		if(empty($this->user)){
			header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
			exit;
		}
		$this->assign('user',$this->user);
	}
	public function index(){
		$roomuser = $this->model('roomuser');
		$roomlist = $roomuser->getroomlist($this->user['uid']);
		$this->assign('roomlist',$roomlist);
		$this->display('myroom/mycloud');
	}
}
?>