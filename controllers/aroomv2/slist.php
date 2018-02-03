<?php
/*
学校学生列表
*/
class SlistController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	public function index(){
		$roomuser = $this->model('roomuser');
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->uri_attr(0);
		if(!is_numeric($classid) || $classid <= 0)
			$classid = 0;
		$param['classid'] = $classid;
		$roomuserlist = $roomuser->getaroomstudentlist($param);
		$roomusercount = $roomuser->getaroomstudentcount($param);
		$pagestr = show_page($roomusercount);
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);
		// var_dump($param);
		$this->assign('classid',$classid);
		$this->assign('pagestr',$pagestr);
		$this->assign('search',$param['q']);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->assign('roomuserlist',$roomuserlist);
		$this->display('aroomv2/slist');
	}
}
?>