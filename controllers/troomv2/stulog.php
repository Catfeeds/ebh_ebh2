<?php
/**
 * 学员学习听课记录查看控制器类 StulogController
 */
class StulogController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
		
		$memberid = $this->input->get('uid');	//学生编号
		if(!is_numeric($memberid) || $memberid <= 0) {
			$memberid = 0;
		}
		$member = FALSE;
		if($memberid > 0){
			$usermodel = $this->model('User');
			$member = $usermodel->getuserbyuid($memberid);
			if(!empty($member)) {
				$membername = empty($member['realname']) ? $member['username'] : $member['realname'];
			}
		}
		$plogmodel = $this->model('Playlog');

		//获取作业列表
		$q = $this->input->get('q');
		$d = $this->input->get('d');
		$queryarr = parsequery();
		$queryarr['uid'] = $memberid;
		$queryarr['crid'] = $roominfo['crid'];
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

		$queryarr['startDate'] = $stardateline;
		$queryarr['endDate'] = $enddateline;
		$queryarr['hasanswer'] = 1;
		$queryarr['totalflag'] = 0;
		$logs = $plogmodel->getList($queryarr);
		$count = $plogmodel->getListCount($queryarr);
		

		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('d',$d);
		$this->assign('begintime',$begintime);
		$this->assign('endtime',$endtime);
		$this->assign('logs',$logs);
		$this->assign('pagestr',$pagestr);
		$this->assign('memberid',$memberid);
		$this->assign('membername',$membername);
        $this->assign('pagestr', $pagestr);
        $this->display('troomv2/stulog');
    }
	/**
	*时长秒转换成字符显示
	*/
	function getltimestr($ltime) {
		if(empty($ltime))
			return '';
		$h = intval($ltime / 3600); 
		$m = intval(($ltime - $h * 3600)/60);
		$s = $ltime -$h * 3600 - $m*60;
		$str = $h.':'.str_pad($m,2,'0',STR_PAD_LEFT).':'.str_pad($s,2,'0',STR_PAD_LEFT);

		return $str;
	}
}
