<?php
/**
* 黑名单限制
*/
class Blacklist{
	public function check(){
		$roominfo = Ebh::app()->room->getcurroom();
			if(!empty($roominfo['crid']))
				$crid = $roominfo['crid'];
			else
				$crid = 0;
		if(empty($crid))	//不对非网校进行限制
			return TRUE;
		
		$user = Ebh::app()->user->getloginuser();
		$rumodel = Ebh::app()->model('roomuser');
		//学校后台禁用
		$udetail = $rumodel->getroomuserdetail($crid,$user['uid']);
		if(!empty($udetail) && $udetail['cstatus'] == 0){
			header('Location: /loginlimit/blacklist/user.html');
			exit;
		}	
		
		$blmodel = Ebh::app()->model('blacklist');
		
		//ip黑名单
		$ip = ip2long(getip());
		$record = $blmodel->getIpRecord($ip,$crid);
		if(!empty($record)){
			header('Location: /loginlimit/blacklist/ip.html');
			exit;
		}
		//用户黑名单
		$record = $blmodel->getUserRecord($user['uid'],$crid);
		if(!empty($record)){
			header('Location: /loginlimit/blacklist/user.html');
			exit;
		}
	}
}
?>