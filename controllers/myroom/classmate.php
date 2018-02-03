<?php

/**
 * 学生我的同学控制器类 ClassmateController
 */
class ClassmateController extends CControl {

    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }

    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        
        $classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$this->assign('myclass',$myclass);
		$students = array();
		if(!empty($myclass)) {
			$queryarr = parsequery();
			$queryarr['classid'] = $myclass['classid'];
			$queryarr['pagesize'] = 100;
			$students = $classmodel->getClassStudentList($queryarr);
			$count = $classmodel->getClassStudentCount($queryarr);
		}else{
			$count = 0;
			$queryarr['pagesize'] = 10;
		}
		$pagestr = show_page($count,$queryarr['pagesize']);
		$this->assign('pagestr',$pagestr);
		$this->assign('students',$students);
        $this->display('myroom/classmate');
    }
}
