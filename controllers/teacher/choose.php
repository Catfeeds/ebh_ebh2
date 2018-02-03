<?php
/**
 * 教师选择教室控制器
 * 一般用户教师在大厅登录后的返回页面
 */
class ChooseController extends CControl {
	public function index() {
		$user = Ebh::app()->user->getloginuser();
		if(empty($user) || $user['groupid'] != 5) {
			header("Location: /");
			return;
		}
		$roommodel = $this->model('Classroom');
		$roomlist = $roommodel->getroomlistbytid($user['uid']);
		if(!empty($roomlist) && count($roomlist) == 1) {	//如果教师只有一个教室权限，则直接跳转到教室后台
			$myroom = $roomlist[0];
			$myurl = empty($myroom['fulldomain']) ? $myroom['domain'].'.ebh.net' : $myroom['fulldomain'];
			$troomurl = gettroomurl($myroom['crid']);
			$myurl = 'http://'.$myurl.$troomurl;
			header("Location: $myurl");
			return ;
		}
		$plist = array();	//父级网校集合，即upid为0的
		$allchildlist = array();	//所有子网校集合
		$nopchildlist = array();	//所有没有父网校权限的子网校列表
		foreach($roomlist as $room) {	//列出所有父网校和子网校
			if($room['upid'] == 0) {
				$plist[$room['crid']] = $room;
				$plist[$room['crid']]['child'] = array();	//初始化父网校的子网校列表
			} else {
				$allchildlist[] = $room;
			}
		}
		foreach($allchildlist as $child) {	//关联父网校和子网校
			if(isset($plist[$child['upid']]))
				$plist[$child['upid']]['child'][] = $child;
			else
				$nopchildlist[] = $child;
		}


		$this->assign('user',$user);
		$this->assign('plist',$plist);
		$this->assign('nopchildlist',$nopchildlist);
		$this->display('teacher/choose');
	}
}