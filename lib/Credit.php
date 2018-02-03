<?php
class Credit {
	//学生积分日志
	public function getCreditLogs(){
		$user = Ebh::app()->user->getloginuser();
		$credit = Ebh::app()->model('credit');
		$param = parsequery();
		$param['pagesize'] = 5;
		$param['toid'] = $user['uid'];
		$creditlist = $credit->getcreditlist($param);
		return $creditlist;
		
	}
}
?>