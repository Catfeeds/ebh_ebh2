<?php
/**
 * logout控制器类
 * 主要用来控制用户的退出登录
 */
class LogoutController extends CControl{
    public function index() {
		$this->doPad();
        $cookietime = -365 * 66400;
		$auth = $this->input->cookie('auth');
		$ak = $this->input->cookie('ak');
		$this->input->setcookie('auth','',$cookietime);
        $this->input->setcookie('lasttime','',$cookietime);
		$this->input->setcookie('thistime','',$cookietime);
        $this->input->setcookie('lastip','',$cookietime);
        $this->input->setcookie('sessioncrid','',$cookietime);
        $referer = !empty($_SERVER['HTTP_REFERER']) ? strtolower($_SERVER['HTTP_REFERER']) : NULL;
		//如果是学校管理员登录，则需要控制是否为管理员退出还是模拟用户退出。如果模拟教师或学生登录后
		//ToDO:在网校首页退出，需要退出两次，模拟cookie登录，不好处理
        if(!empty($ak) && ( empty($referer) || (strpos($referer, 'aroom')!=false)  || $auth == $ak || empty($auth)) ) {
			$this->input->setcookie('ak','',$cookietime);
		}
        $returnurl = '/';
		$durl = '';
		$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
		if(!empty(Ebh::app()->domains)) {	//处理多域名配置，如果存在多域名，则需要对其他域名cookie注入操作
			$curdomain = $this->uri->curdomain;
			if(!empty($curdomain)) {
				$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
				$ssovalue = '0___0___0___0___0___0___'.$ctime;
				$ssovalue = base64_encode($ssovalue);
				foreach(Ebh::app()->domains as $mydomain) {
					if($mydomain != $curdomain && $mydomain != 'ebanhui.com') {//ebanhui.com不做处理
						$newdurl = 'http://www.'.$mydomain.'/sso.html?k='.$ssovalue;
						$durl = empty($durl) ? $newdurl : $durl.','.$newdurl;
					}
				}
			}
		}
		$this->assign('returnurl',$returnurl);
		$this->assign('durl',$durl);
        $this->display('common/logout');
    }
	/**
	*处理平板APP的退出，如果是APP 退出点击后 则直接到APP登录界面
	*/
	private function doPad() {
		if (isset($_SERVER['HTTP_ISEBH']) && $_SERVER['HTTP_ISEBH'] == '1') {
			$appurl = 'http://login';
			header("Location: $appurl");
			exit();
		}
		return TRUE;
	}
}
