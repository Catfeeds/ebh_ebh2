<?php
/**
 * 学校学生我的作业相关控制器 MycourseController
 */
class SexamController extends CControl {
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
	public function index(){
		$this->display('myroom/sexam');
	}
	/**
	*我的作业(所有作业)
	*/
	public function all() {
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);	
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['classid'] = $myclass['classid'];
		
		$queryarr['filteranswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		$exams = $exammodel->getExamListByMemberid($queryarr);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('myroom/sexam_all');

		$this->_updateuserstate();
	}
	/**
	* 我做过的作业
	*/
	public function my() {
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);	
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['classid'] = $myclass['classid'];
		$queryarr['hasanswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		$exams = $exammodel->getExamListByMemberid($queryarr);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('myroom/sexam_my');
	}
	/**
	* 我的作业草稿箱
	*/
	public function box() {
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取班级信息
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);	
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['classid'] = $myclass['classid'];
		$queryarr['astatus'] = 0;
		$queryarr['hasanswer'] = 1;
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		$exams = $exammodel->getExamListByMemberid($queryarr);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('myroom/sexam_box');
	}
	/**
	*更新新作业用户状态时间
	*/
	private function _updateuserstate() {
		 //更新评论用户状态时间
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $statemodel = $this->model('Userstate');
        $typeid = 1;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
	}
	/*
	获取做作业，已做作业，草稿箱，错题本数量
	*/
	public function getcountinfo(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classesmodel = $this->model('Classes');
		$myclass = $classesmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$errormodel = $this->model('Errorbook');
		$count['myerrorbook'] = $errormodel->myscherrorbooklistcount($param);
		$param['classid'] = $myclass['classid'];
		$exammodel = $this->model('exam');
		$param['filteranswer'] = 1;
		$count['all'] = $exammodel->getExamListCountByMemberid($param);
		unset($param['filteranswer']);
		$param['hasanswer'] = 1;
		$count['my'] = $exammodel->getExamListCountByMemberid($param);
		$param['astatus'] = 0;
		$count['box'] = $exammodel->getExamListCountByMemberid($param);
		
		echo json_encode($count);
	}
}
