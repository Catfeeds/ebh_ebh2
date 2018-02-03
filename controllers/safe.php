<?php
/*
修改密码
*/
class SafeController extends CControl{
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user) || $user['groupid'] != 6) {
			$url = '/';
			header("Location: $url");
			exit();
		}
		if(empty($roominfo) || $roominfo['domain'] != 'svn1') {
			$url = '/';
			header("Location: $url");
			exit();
		}
		$curip = $this->input->getip();
		$limittime = 10800;	//限制3小时
		$limitmodel = $this->model('Limitlog');
		$limitparam = array('uid'=>$user['uid'],'fromip'=>$curip,'isfinish'=>0);
		$mylog = $limitmodel->getLogByIp($limitparam);
		$curtime = SYSTIME;
		if(($curtime - $mylog['startdate']) >= $limittime) {
			$url = '/myroom.html';
			header("Location: $url");
			exit();
		}
		$countdown = $limittime - (SYSTIME - $mylog['startdate']);
		$this->assign('countdown',$countdown);
		$this->assign('room',$roominfo);
		$this->assign('limittime',$limittime);
		$this->assign('mylog',$mylog);
		$this->assign('user',$user);
		$this->display('common/safe');
	}
}
?>