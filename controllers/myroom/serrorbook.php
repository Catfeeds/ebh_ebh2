<?php
/**
 * 学校学生我的错题本相关控制器 MyerrorbookController
 */
class SerrorbookController extends CControl {
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
		$errormodel = $this->model('Errorbook');
		$queryarr = parsequery();
		$sdate = $this->input->get('sdate');
		if(!empty($sdate)) {
			$starttime = strtotime($sdate);
			if($starttime !== FALSE) {
				$queryarr['startDate'] = $starttime;
			}
		}
		$edate = $this->input->get('edate');
		if(!empty($edate)) {
			$endtime = strtotime($edate);
			if($endtime !== FALSE) {
				$queryarr['endDate'] = $endtime + 86400;
			}
		}
		$pagesize = empty($queryarr['pagesize']) ? 20 : $queryarr['pagesize'];
		$this->assign('pagesize',$pagesize);
		$q = $this->input->get('q');
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$errors = $errormodel->myscherrorbooklist($queryarr);
		$count = $errormodel->myscherrorbooklistcount($queryarr); 
		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('sdate',$sdate);
		$this->assign('edate',$edate);
		$this->assign('errors',$errors);
		$this->assign('pagestr',$pagestr);
		$this->display('myroom/serrorbook');
	}
	/**
	*删除我的错题
	*/
	public function del() {
		$eid = $this->input->post('eid');
		if(is_numeric($eid) && $eid > 0) {
			$errormodel = $this->model('Errorbook');
			$user = Ebh::app()->user->getloginuser();
			$param['eid'] = $eid;
			$param['uid'] = $user['uid'];
			$result = $errormodel->delete($param);
			if($result) {
				echo 'success';
			} else {
				echo 'fail';
			}
		}
	}
}
