<?php
/*
*师资团队控制器
*/
class ThteamController extends CControl {
    public function index() {
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		$teacherteam = $this->model('item');
		$param = array('crid'=>$crid,'catid'=>854,'displayorder'=>'i.itemid desc','limit'=>'0,10');
		$thteamchachekey = $this->cache->getcachekey('item',$param);
		$teamlist = $this->cache->get($thteamchachekey);
		if(empty($teamlist)) {
			$teamlist = $teacherteam->getadit($param);
			$this->cache->set($thteamchachekey,$teamlist,30);
		}
		$this->assign('teamlist', $teamlist);
		$this->display('shop/stores/thteam');
	}
}
?>