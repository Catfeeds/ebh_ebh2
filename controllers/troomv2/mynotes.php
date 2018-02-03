<?php
/**
 * 学员笔记记录查看控制器类 MynotesController
 */
class MynotesController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
		$q = $this->input->get('q');	//搜索条件
        $d = $this->input->get('d');	//笔记时间
		$memberid = $this->input->get('uid');	//学生编号
		if(!is_numeric($memberid) || $memberid <= 0) {
			$memberid = 0;
		}
		$begintime = $this->input->get('begintime');
		$endtime = $this->input->get('endtime');
        $stardateline = '';
        $enddateline = '';
        if(!empty($d)) {
           $stardateline = strtotime($d);
		   if($stardateline !== FALSE) {
				$enddateline = $stardateline + 86400;
				$begintime = date('Y-m-d',$stardateline);
				$endtime = date('Y-m-d',$stardateline);
		   }
        } else {
			$stardateline = strtotime($begintime);
			$enddateline = strtotime($endtime);
			if($enddateline !== FALSE) 
				$enddateline = $enddateline + 86400;
		}
        $notemodel = $this->model('Note');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['stardateline'] = $stardateline;
        $queryarr['enddateline'] = $enddateline;
		$queryarr['uid'] = $memberid;
        $notes = $notemodel->getnotelistbycrid($queryarr);
		$membername = '';
		if(!empty($notes)) {
			$membername = empty($notes[0]['realname']) ? $notes[0]['username'] : $notes[0]['realname'];
		} else if($memberid > 0){
			$usermodel = $this->model('User');
			$member = $usermodel->getuserbyuid($memberid);
			if(!empty($member)) {
				$membername = empty($member['realname']) ? $member['username'] : $member['realname'];
			}
		}
        $count = $notemodel->getnotelistcountbycrid($queryarr);
        $pagestr = show_page($count);
        $this->assign('q', $q);
		$this->assign('memberid',$memberid);
		$this->assign('begintime',$begintime);
		$this->assign('endtime',$endtime);
        $this->assign('notes', $notes);
		$this->assign('membername',$membername);
        $this->assign('pagestr', $pagestr);
        $this->display('troomv2/mynotes');
    }
}
