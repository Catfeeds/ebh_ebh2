<?php
/**
 * 学生我的笔记控制器类 NotesController
 */
class NotesController extends CControl {
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
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$q = $this->input->get('q');
		$begintime = $this->input->get('begintime');
		$endtime = $this->input->get('endtime');
		$notemodel = $this->model('Note');
		$queryarr = parsequery();
		$queryarr['uid'] = $user['uid'];
		$queryarr['crid'] = $roominfo['crid'];
		if(!empty($begintime)) {
			$begindate = strtotime($begintime);
			if($begindate !== FALSE) {
				$queryarr['stardateline'] = $begindate;
			}
		}
		if(!empty($endtime)) {
			$enddate = strtotime($endtime);
			if($enddate !== FALSE) {
				$queryarr['enddateline'] = $enddate;
			}
		}
		$notes = $notemodel->getnotelistbyuid($queryarr);
		$count = $notemodel->getnotelistcountbyuid($queryarr);
		$pagestr = show_page($count);
		$this->assign('notes',$notes);
		$this->assign('q',$q);
		$this->assign('begintime',$begintime);
		$this->assign('endtime',$endtime);
		$this->assign('pagestr',$pagestr);
		$this->display('myroom/notes');
	}
}
