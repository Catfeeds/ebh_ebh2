<?php
/*
学校教师列表
*/
class TlistController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getloginuser();
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$teacher = $this->model('teacher');
		$param = parsequery();
		$roomteacherlist = $teacher->getroomteacherlist($roominfo['crid'],$param);
		$teachercount = $teacher->getroomteachercount($roominfo['crid'],$param);
		$pagestr = show_page($teachercount);
		$this->assign('teachercount',$teachercount);
		$this->assign('pagestr',$pagestr);
		$this->assign('room',$roominfo);
		$this->assign('search',$param['q']);
		$this->assign('roomteacherlist',$roomteacherlist);
		$this->display('aroomv2/tlist');
	}
}
?>