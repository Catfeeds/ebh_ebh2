<?php
/**
 * 网校学生我的作业相关控制器 ExamController
 */
class ExamController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkstudent();
    }
	/**
	*我的作业(所有作业)
	*/
	public function index() {
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取作业列表
		$q = $this->input->get('q');
		$folderid = $this->input->get('folderid');
		$queryarr = parsequery();
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		if(is_numeric($folderid) && $folderid > 0) {
			$queryarr['folderid'] = $folderid;
		}
		$foldermodel = $this->model('Folder');
		$folderparam = array('crid'=>$roominfo['crid'],'upid'=>0);
		$folders = $foldermodel->getfolderlist($folderparam);
		$exams = $exammodel->getRoomExamListByMemberidWithCourse($queryarr);
		$count = $exammodel->getRoomExamListCountByMemberidWithCourse($queryarr);
		$pagestr = show_page($count);
		$this->assign('folderid',$folderid);
		$this->assign('folders',$folders);
		$this->assign('q',$q);
		$this->assign('exams',$exams);
		$this->assign('pagestr',$pagestr);
        $this->display('myroom/exam');
	}
	/**
	* 我做过的作业
	*/
	public function my() {
		$exammodel = $this->model('Exam');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();

		//获取作业列表
		$q = $this->input->get('q');
		$folderid = $this->input->get('folderid');
		$queryarr = parsequery();
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];

		$queryarr['hasanswer'] = 1;
		if(is_numeric($folderid) && $folderid > 0) {
			$queryarr['folderid'] = $folderid;
		}
		$exams = $exammodel->getRoomExamListByMemberidWithCourse($queryarr);
		$count = $exammodel->getRoomExamListCountByMemberidWithCourse($queryarr);
		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('folderid',$folderid);
		$this->assign('exams',$exams);
		$this->assign('pagestr',$pagestr);
        $this->display('myroom/exam_my');
	}
	/**
	* 我的错题本
	*/
	public function errorbook() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$errormodel = $this->model('Errorbook');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$errors = $errormodel->myerrorbooklist($queryarr);
		$count = $errormodel->myerrorbooklistcount($queryarr); 
		$pagestr = show_page($count);
		$this->assign('errors',$errors);
		$this->assign('pagestr',$pagestr);
		$this->display('myroom/errorbook');
	}

}
