<?php
class AteaexamController extends CControl{
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
		$roomdetail['foldernum'] = $folder->getcount($param);
		$teacher = $this->model('teacher');
		$teacherlist = $teacher->getRoomTeacherListExamCount($roominfo['crid']);
		// var_dump($teacherlist);
		$this->assign('teacherlist',$teacherlist);
		$this->assign('roomdetail',$roomdetail);
		$this->display('aroom/ateaexam');
	}
	
	public function class_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classes = $this->model('classes');
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $this->uri->itemid;
		$classlist = $classes->getRoomClassListExamCount($param);
		$this->assign('uid',$param['uid']);
		$this->assign('classlist',$classlist);
		$this->display('aroom/ateaexam_class');
	}
	
	public function class_exam_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['classid'] = $this->uri->itemid;
		$param['uid'] = $this->uri->uri_attr(0);
		
		$exam = $this->model('exam');
		$examcount = $exam->getRoomExamCountByTeacherid($param);
		$examlist = $exam->getRoomExamListByTeacherid($param);
		$classes = $this->model('classes');
		$classdetail = $classes->getclassdetail($param);
		$this->assign('stunum',$classdetail['stunum']);
		$this->assign('uid',$param['uid']);
		$this->assign('examcount',$examcount);
		$this->assign('examlist',$examlist);
		$this->display('aroom/ateaexam_class_exam');
	}
}
?>