<?php
/*
学生作业
*/
class AstuexamController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getloginuser();
		$this->assign('user',$this->user);
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$param = parsequery();
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		
		$roomuser = $this->model('roomuser');
		$classid = $this->uri->uri_attr(0);
		$param['classid'] = $classid;
		$roomuserlist = $roomuser->getaroomstudentlist($param);
		$roomusercount = $roomuser->getaroomstudentcount($param);
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);
		$pagestr = show_page($roomusercount);
		// var_dump($param);
		$this->assign('roomdetail',$roomdetail);
		$this->assign('classid',$classid);
		$this->assign('roomusercount',$roomusercount);
		$this->assign('pagestr',$pagestr);
		$this->assign('search',$param['q']);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->assign('roomuserlist',$roomuserlist);
		$this->display('aroomv2/astuexam');
	}
	
	public function astuexamlist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$exam = $this->model('exam');
		$param = parsequery();
		$param['uid'] = $this->uri->uri_attr(0);
		$classes = $this->model('classes');
		
		$param['crid'] = $roominfo['crid'];
		$classdetail = $classes->getClassByUid($param['crid'],$param['uid']);
		$param['classid'] = $classdetail['classid'];
		
		$examlist = $exam->getExamListByMemberid($param);
		$examcount = $exam->getExamListCountByMemberid($param);
		$pagestr = show_page($examcount);
		$this->assign('pagestr',$pagestr);
		$this->assign('examcount',$examcount);
		$this->assign('examlist',$examlist);
		$this->display('aroomv2/astuexam_list');
	}
	
	
}
?>