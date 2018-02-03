<?php
/**
 * 学校学生我的作业相关控制器 MycourseController
 */
class MyexamController extends CControl {
    public function __construct() {
        parent::__construct();
    }
	public function index(){
		$this->display('jingpin/myexam');
	}
	/**
	*我的作业(所有作业)
	*/
	public function all() {
		$exammodel = $this->model('Exam');	
		$user = Ebh::app()->user->getloginuser();
		//获取作业列表
		$queryarr = parsequery();
		$requireFolderid = $this->input->get('folderid');
		if(!empty($requireFolderid)){
			$folderid = $requireFolderid;
			$foldermodel = $this->model('folder');
			$folder = $foldermodel->getfolderbyid($requireFolderid);
			$this->assign('folder',$folder);
		}
		if(!empty($folderid)){
			$queryarr['folderid'] = $folderid;
		}
		$tid = $this->uri->uri_attr(0);
		if(!empty($tid)){
			$queryarr['tid'] = intval($tid);
		}
		$queryarr['uid'] = $user['uid'];
		$queryarr['filteranswer'] = 1;
		$queryarr['type'] = array(0,2);
		$exams = $exammodel->getExamListByMemberid($queryarr);
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count,$queryarr['pagesize']);
		$this->assign('notop',1);
		$this->assign('exams',$exams);
		//$this->assign('roominfo',$roominfo);
		$this->assign('pagestr',$pagestr);
        $this->display('jingpin/myexam_all');
	}
	
}
