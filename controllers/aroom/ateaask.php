<?php
/*
教师答疑查看
*/
class AteaaskController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getAdminLoginUser();
		$this->assign('user',$this->user);
	}
	
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$startdate = $this->input->get('sdate');
		$enddate = $this->input->get('edate');
		$param['startdate'] = strtotime($startdate);
		$param['enddate'] = empty($enddate)?'':strtotime($enddate)+86400;
		$teacher = $this->model('teacher');
		$teacherlist = $teacher->getRoomTeacherListAnswerCount($param);
		$roomdetail['foldernum'] = $folder->getcount($param);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('teacherlist',$teacherlist);
		$this->assign('roomdetail',$roomdetail);
		$this->display('aroom/ateaask');
	}
	
	public function ateaasklist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$ask = $this->model('askquestion');
		$param = parsequery();
		$param['uid'] = $this->uri->uri_attr(0);
		//$param['crid'] = $roominfo['crid'];
		$param['ashield'] = 0;
		$param['qshield'] = 0;
		$param['pagesize'] = 10;
		$answercount = $ask->getaskcountbyanswers($param);
		$answerlist = $ask->getasklistbyanswers($param);
		// var_dump($answerlist);
		$pagestr = show_page($answercount,$param['pagesize']);
		$this->assign('answerlist',$answerlist);
		//$this->assign('uid',$param['uid']);
		$this->assign('answercount',$answercount);
		$this->assign('pagestr', $pagestr);
		$this->display('aroom/ateaask_list');
	}
}
?>