<?php
/*
学生听课监察
*/
class AstulogController extends CControl{
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
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		
		$roomuser = $this->model('roomuser');
		$classid = $this->uri->uri_attr(0);
		$param['classid'] = $classid;
		
		$roomuserlist = $roomuser->getaroomstudentlist($param);
		$roomusercount = $roomuser->getaroomstudentcount($param);
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);
		$pagestr = show_page($roomusercount);
		$this->assign('roomdetail',$roomdetail);
		$this->assign('classid',$classid);
		$this->assign('roomusercount',$roomusercount);
		$this->assign('pagestr',$pagestr);
		$this->assign('search',$param['q']);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->assign('roomuserlist',$roomuserlist);
		$this->display('aroom/astulog');
	}
	
	public function astuloglist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $this->uri->uri_attr(0);
		$param['q'] = urldecode($this->uri->uri_attr(1));
		$playlog = $this->model('playlog');
		$loglist = $playlog->getList($param);
		$logcount = $playlog->getListCount($param);
		$tempcount = count($loglist);
		for($i=0;$i<$tempcount;$i++){
			$loglist[$i]['ctime'] = $this->getltimestr($loglist[$i]['ctime']);
			$loglist[$i]['ltime'] = $this->getltimestr($loglist[$i]['ltime']);
		}
		$this->assign('search',$param['q']);
		$this->assign('uid',$param['uid']);
		$this->assign('loglist',$loglist);
		$this->assign('logcount',$logcount);
		$this->display('aroom/astulog_list');
	}
	function getltimestr($ltime) {
		if(empty($ltime))
			return '';
		$h = intval($ltime / 3600); 
		$m = intval(($ltime - $h * 3600)/60);
		$s = $ltime -$h * 3600 - $m*60;
		$str = $h.':'.str_pad($m,2,'0',STR_PAD_LEFT).':'.str_pad($s,2,'0',STR_PAD_LEFT);

		return $str;
	}

	public function astuloglist_fordialog(){
		$starttime_str = $this->input->get('starttime');
		$endtime_str = $this->input->get('endtime');
		$this->assign('starttime_str',$starttime_str);
		$this->assign('endtime_str',$endtime_str);
		if(!empty($starttime_str)){
			$starttime = strtotime($starttime_str);
		}else{
			$starttime = "";
		}
		if(!empty($endtime_str)){
			$endtime = strtotime($endtime_str);
			if(!empty($endtime)){
				$endtime += 3600*24;
			}
		}else{
			$endtime = "";
		}

		if(!empty($endtime) && !empty($starttime)){
			if($endtime<$starttime){
				$tmp = $starttime;
				$endtime = $starttime;
				$starttime = $tmp;
				$this->assign('starttime_str',$endtime_str);
				$this->assign('endtime_str',$starttime_str);
			}
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['pagesize'] = 8;
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = intval($this->uri->uri_attr(0));
		$param['folderid'] = intval($this->uri->uri_attr(1));
		$param['q'] = urldecode($this->uri->uri_attr(2));
		$param['startDate'] = $starttime;
		$param['endDate'] = $endtime;
		$param['totalflag'] = 0;
		$param['order'] = 'p.logid desc';
		$playlog = $this->model('playlog');
		$loglist = $playlog->getList($param);
		$logcount = $playlog->getListCount($param);
		$pagestr = show_page($logcount,$param['pagesize']);
		$tempcount = count($loglist);
		$this->assign('search',$param['q']);
		$this->assign('uid',$param['uid']);
		$this->assign('loglist',$loglist);
		$this->assign('logcount',$logcount);
		$this->assign('pagestr',$pagestr);
		$this->assign('folderid',$param['folderid']);
		$this->display('aroom/astulog_dialog');
	}
}

?>