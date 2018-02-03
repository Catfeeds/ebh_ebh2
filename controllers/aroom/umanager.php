<?php
/*
用户管理控制器
可用于进入教师或学生后台
*/
class UmanagerController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getAdminLoginUser();
	}
	public function index(){
		
	}
	/**
	*管理员进入学生后台
	*/
	public function student() {
		$roominfo = Ebh::app()->room->getcurroom();
		$s = $this->input->get('s');
		if(empty($s)) {
			exit();
		}
		$uid = authcode($s,'DECODE');
		if(empty($uid) || !is_numeric($uid) || $uid < 0) {
			exit();
		}
		$usermodel = $this->model('User');
		$uinfo = $usermodel->getUserPwd($uid);
		if(empty($uinfo)) {
			echo 'user not found';
			exit();
		}
		$roommodel = $this->model('Classroom');
		$haspower = $roommodel->checkstudent($uid,$roominfo['crid']);	//判断该学生是否为本网校内的
		if($haspower != -1) {
			$durl = $this->savecookie($uinfo);
			$this->_sso_redirect($durl,'/myroom.html');
		}
	}
	/**
	*管理员进入教师后台
	*/
	public function teacher() {
		$roominfo = Ebh::app()->room->getcurroom();
		$s = $this->input->get('s');
		if(empty($s)) {
			exit();
		}
		$uid = authcode($s,'DECODE');
		if(empty($uid) || !is_numeric($uid) || $uid < 0) {
			exit();
		}
		$usermodel = $this->model('User');
		$uinfo = $usermodel->getUserPwd($uid);
		if(empty($uinfo)) {
			echo 'user not found';
			exit();
		}
		$roommodel = $this->model('Classroom');
		$haspower = $roommodel->checkteacher($uid,$roominfo['crid']);	//判断该教师是否为本网校内的
		if($haspower != -1) {	//在本网校内的才允许处理
			$durl = $this->savecookie($uinfo);
			$troomurl = gettroomurl($roominfo['crid']);
			$this->_sso_redirect($durl,$troomurl);
		}
	}
	/**
	*保存登录状态，同时生成多域名处理请求
	*/
	private function savecookie($uinfo){
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$uid = $uinfo['uid'];
		$pwd = $uinfo['password'];
		$auth = authcode("$pwd\t$uid", 'ENCODE');
		$savestate = 0;
		$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
		$this->input->setcookie('auth', $auth, $cookietime);
		$durl = '';
		if(!empty(Ebh::app()->domains)) {	//处理多域名配置，如果存在多域名，则需要对其他域名cookie注入操作
			$curdomain = $this->uri->curdomain;
			if(!empty($curdomain)) {
				$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
				$ssovalue = $auth.'___0___'.SYSTIME.'___0___'.$cookietime.'___'.$ctime;
				$ssovalue = base64_encode($ssovalue);
				foreach(Ebh::app()->domains as $mydomain) {
					if($mydomain != $curdomain) {
						$durl = 'http://www.'.$mydomain.'/sso.html?k='.$ssovalue;
						break;
					}
				}
			}
		}
		return $durl;
	}

	//同步登录
	private function _sso_redirect($durl = '',$descurl = ''){
		echo '<script>var img = new Image();img.src ="'.$durl.'";img.onload = function(){location.href="'.$descurl.'";};</script>';
		exit;
	}
}
?>