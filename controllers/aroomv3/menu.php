<?php

/**
 * User: ckx
 * 菜单控制器
 */
class MenuController extends ARoomV3Controller {
	/**
	 *菜单列表 
	 */
	public function lists(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['nohide'] = 1;//不返回隐藏的菜单
		$param['withmodule'] = 1;//模块权限关联，双重判断
		//ak decode,查看uid是否为登录账号uid
		$ak = $this->input->cookie('ak');
		$authstr = authcode($ak,'DECODE');
		$uidindex = strpos($authstr,Chr(9))+1;
		$authuid = substr($authstr,$uidindex);
		if($user['uid'] != $roominfo['uid'] && $authuid == $user['uid']){//普通老师
			$param['nomalteacher'] = 1;
			$param['uid'] = $user['uid'];
		}
		$menulist = $this->apiServer->reSetting()->setService('Adminv2.Menu.list')->addParams($param)->request();
		echo json_encode($menulist);
	}
}