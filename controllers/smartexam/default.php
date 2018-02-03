<?php
/**
 * 微题控制器
 */
class DefaultController extends CControl {
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
        $this->assign('crid',$roominfo['crid']);
		$this->assign('check',$check);
    }
	/*
	*评论交流
	*/
	 public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
        $this->display('smartexam/index');
    }
}
