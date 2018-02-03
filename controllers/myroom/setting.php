<?php
/**
 * 学校学生我的首页 MysettingController
 */
class SettingController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkstudent();
    }
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$stumodulelist = array();
		if(!empty($roominfo['stumodulepower']))
			$stumodulelist = explode(',',$roominfo['stumodulepower']);
		$this->assign('stumodulelist',$stumodulelist);
		
		//获取最新课件
		$coursemodel = $this->model('Courseware');
		$courses = $coursemodel->getnewcourselist(array('crid'=>$roominfo['crid'],'limit'=>'0,3'));
		$this->assign('courses',$courses);
		//获取最新未答作业
		$exammodel = $this->model('Exam');
		$examparam = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'filteranswer'=>1,'limit'=>'0,3');
		$exams = $exammodel->getRoomExamListByMemberid($examparam);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
        $this->display('myroom/setting');
    }
}
