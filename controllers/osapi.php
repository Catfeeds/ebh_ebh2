<?php 
/**
 *第三方登录跳转(接受从wap过来的跳转)
 */
class OsapiController extends CControl{
	public function index(){
		$k = $this->input->get('k');
		$to = $this->input->get('to');
		$user = $this->model('user')->getloginbyauth($k);
        if(!empty($user)) {
			if($user['groupid'] == 6) {
				if($to == 'ykt100') {
					$returnurl = 'http://'.$to.'.ebh.net/';
				} else {
					$returnurl = 'http://'.$to.'.ebh.net/myroom.html';
				}
			} else {
				$returnurl = 'http://'.$to.'.ebh.net/troom.html';
			}
			$durl = $this->savecookie($user);
			$this->assign('returnurl',$returnurl);
			$this->assign('durl',$durl);
			$this->display('common/sapi');
		} else {
			echo 'error:600006<br />';
			echo 'msg:login error<br />';
			exit();
		}
	}

	/**
	*保存登录状态，同时生成多域名处理请求
	*/
	private function savecookie($user){	
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$uid = $user['uid'];
		$pwd = $user['password'];
		$auth = authcode("$pwd\t$uid", 'ENCODE');
		$savestate = $this->input->post('cookietime');
		$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
		$this->input->setcookie('auth', $auth, $cookietime);
		$this->input->setcookie('lasttime', $user['lastlogintime'], $cookietime);
		$this->input->setcookie('thistime', SYSTIME, $cookietime);
		$this->input->setcookie('lastip', $user['lastloginip'], $cookietime);
		$durl = '';
		if(!empty(Ebh::app()->domains)) {	//处理多域名配置，如果存在多域名，则需要对其他域名cookie注入操作
			$curdomain = $this->uri->curdomain;
			if(!empty($curdomain) && in_array($curdomain,Ebh::app()->domains)) {
				$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
				$ssovalue = $auth.'___'.$user['lastlogintime'].'___'.SYSTIME.'___'.$user['lastloginip'].'___'.$cookietime.'___'.$ctime;
				$ssovalue = base64_encode($ssovalue);
				foreach(Ebh::app()->domains as $mydomain) {
					if($mydomain != $curdomain) {
						$newdurl = 'http://www.'.$mydomain.'/sso.html?k='.$ssovalue;
						$durl = empty($durl) ? $newdurl : $durl.','.$newdurl;
					}
				}
			}
		}
		return $durl;
	}
}
