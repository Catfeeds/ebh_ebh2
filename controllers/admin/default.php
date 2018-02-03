<?php
/**
*后台控制器
*/
class DefaultController extends CControl{
	public $action_menuid = array('settings'=>159,'users'=>70,'item'=>86,'paymanage'=>348,'serial'=>269,'interactive'=>104,'template'=>115,'statistic'=>128,'portal'=>332);
	public $staffarr = array(1,7,10,11,12,13,14,19);
	public function index(){
	    $returnurl = trim($this->input->get('returnurl'));
	    $this->assign('returnurl', $returnurl);
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			
			$this->display('admin/login');
		}
		else if(!in_array($user['groupid'],$this->staffarr))
		{
			$this->display('admin/login');
		}
		else
		{
			$this->assign('username',$user['username']);
			$this->assign('groupid',$user['groupid']);
			$this->assign('logincount',$user['logincount']);
			$this->assign('lastlogintime',$user['lastlogintime']);
			$this->inittopmenu();
			if($this->input->get('action'))
			{
				$action = $this->input->get('action');
				if($action=='sidemenu')
				{
					$this->showsidemenu($this->action_menuid[$this->input->get('upaction')]);//切换主模块
					$this->display("admin/$action");
				}
				else if($this->input->get('op')||$action=='logout'){
					$this->$action();
				}
				else{
					
					$this->display("admin/$action");
				}
			}
			else{
				$this->display('admin/index');
			}
		}
		
	}
	
	/*
	初始化列表
	*/
	public function inittopmenu(){
		$menu = $this->model('adminmenu');
		$topmenulist = $menu->getTopmenu();
		
		$this->assign('topmenulist',$topmenulist);
		
		$this->showsidemenu(159);
		
	}
	/*
	侧边列表
	*/
	public function showsidemenu($upid){
		$menu = $this->model('adminmenu');
		$sidemenulist = $menu->getSidemenu($upid);
		$this->assign('sidemenulist',$sidemenulist);
		foreach($sidemenulist as $listitem){
			$submenulist[] = $menu->getSidemenu($listitem['moduleid']);
		}
		//var_dump($submenulist);
		
		$this->assign('submenulist',$submenulist);
		
	}
	/*
	注销
	*/
	public function logout(){
		$cookietime = -365 * 66400;
		$this->input->setcookie('auth','',$cookietime);
		$this->input->setcookie('lasttime','',$cookietime);
		$this->input->setcookie('lastip','',$cookietime);
		$returnurl = geturl('admin');
		header("Location: $returnurl");
	}
	
}
?>