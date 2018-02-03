<?php

/**
 * 第三方直接注册入口
 */
class RsapiController extends CControl {
	private $applist = array(
		'1111111111111'=>array('appsec'=>'888888888888888','prefix'=>'cnasfc_','rooms'=>array('cnasfckh')),
	);	//key appid value appsecret
	private $curroom = NULL;
	/**
	*http://sso.ebh.net/csapi.html?param=YXBwaWQ9Jm9wPXJlZyZpZD0mdXNlcj11c2VyJnI9MSZzZXg9MSZwPTEyMzQ1NiZ0bz0xMzE5MiZ0PTE0NTExMTQxNDEmc2lnbj1lMzEyMzViMTFkYmQ5MTU3MjI3YjMyMzFiN2IwMjg2Mg==
	*paramvalue=base64_encode(appid=xx&op=login&id=xx&user=xx&name=xx&r=1&sex=xx&p=xx&to=xx&t=xx&sign=xx)
	*/
    public function index() {
    	$k = $this->input->get('k');
		if(!empty($k)){
			$this->_handle_by_k();
			exit;
		}

		$key = $this->input->get('param');
		if(empty($key)) {
			exit();
		}
		//appid=10125029349&op=login&id=102658&user=13858129054&sex=1&p=d54d1702ad0f8326224b817c796763c9&to=dh&t=1446269723&sign=appid10125029349oploginid102658user13858129054sex1pd54d1702ad0f8326224b817c796763c9todht1446269723

		$key = base64_decode($key);
		if(empty($key)) {
			echo 'error:600001<br />';
			echo 'msg:key is null<br />';
			exit();
		}
		parse_str($key,$keylist);
		if(!is_array($keylist)) {
			echo json_encode(array('code'=>600002,'msg'=>'key is not valid','data'=>array()));
			exit();
		}
		if(!$this->checkSign($keylist)) {
			echo json_encode(array('code'=>600003,'msg'=>'key is not valid','data'=>array()));
			exit();
		}
		if(empty($keylist['op'])) {
			echo json_encode(array('code'=>600004,'msg'=>'miss args','data'=>array()));
			exit();
		}
		if($keylist['op'] == 'reg' || $keylist['op'] == 'info') {
			$this->doReg($keylist);
		}else if($keylist['op'] == 'login'){
			$this->doLogin($keylist);
		}
	}

	private function _handle_by_k(){
		$action = $this->input->get('action');
		if($action == 'ibuy'){
			$this->_ibuy();
		}
	}

	private function _ibuy(){
		$user = $this->getloginuser();
		if(empty($user)){
			echo 'user is not login ';exit;
		}
		$itemid = $this->input->get('itemid');
		if(!is_numeric($itemid)){
			echo 'itemid error';exit;
		}
		$durl = $this->savecookie($user);
		$room = $this->input->get('room');
		if(empty($room)){
			$room = 'www';
		}
		$returnurl = 'http://'.$room.'.ebh.net/ibuy.html?itemid='.$itemid;
		$this->assign('returnurl',$returnurl);
		$this->assign('durl',$durl);
		$this->display('common/sapi');
	}
	/**
	*处理用户注册
	*/
	private function doReg($param) {
		//check param
		if(empty($param['id']) || empty($param['user']) || empty($param['p']) ) {
			echo json_encode(array('code'=>600004,'msg'=>'miss args','data'=>array()));
			exit();
		}
		$appid = $param['appid'];
		$curtime = SYSTIME;
		$id = $param['id'];	//原始ID
		$user = $param['user'];	//原始账号	
		$realname = $param['name'];	//姓名
		$sex = $param['sex'];	//性别
		$pass = $param['p'];
		$rule = 0;	//用户类型表示 2表示学生
		if(!empty($param['r']) && $param['r'] == 2)
			$rule = 2;	
		$to = $param['to'];		//目的网校子域名，如果是老师 会注册教师权限
		$taddflag = FALSE;
		$ousermodel = $this->model('OUser');
		$ouser = $ousermodel->getOuserByUserName($user);
		$pre = $this->getAppPrefix($appid);
		$eusername = $pre.$user;
		if(!empty($ouser)) {	//用户已经存在，则判断是否修改过密码 如果修改过 则更新密码
			if($ouser['userpass'] != $pass) {
				//修改ouser密码
				$ouparam = array('userpass'=>$pass);
				$whereparam = array('ouid'=>$ouser['ouid']);
				$ousermodel->update($ouparam,$whereparam);
				//修改user密码
				$usermodel = $this->model('User');
				$uparam = array('mpassword'=>$pass);
				$usermodel->update($uparam,$ouser['uid']);
			}
		} else {	//不存在则进行注册操作
			$appinfo = $this->getAppInfo($appid);
			$rooms = $appinfo['rooms'];
			$uid = 0;
			if($rule == 1 && !in_array($to,$rooms)) {	//如果是教师而且对应的to不存在，则返回错误1675.13
				echo json_encode(array('code'=>600005,'msg'=>'error to arg','data'=>array()));
				exit();
			}
			if($rule == 2) {
				$memmodel = $this->model('Member');
				$mparam = array('username'=>$eusername,'realname'=>$realname,'mpassword'=>$pass,'dateline'=>$curtime,'sex'=>$sex);
				$uid = $memmodel->addmember($mparam);
			}
			if(empty($uid)) {
				echo json_encode(array('code'=>600007,'msg'=>'reg error','data'=>array()));
				exit();
			}
			$oparam = array('uid'=>$uid,'useruid'=>$id,'username'=>$user,'userpass'=>$pass,'usertag'=>$rule);
			$ouid = $ousermodel->add($oparam);
			if($ouid === FALSE) {
				echo json_encode(array('code'=>600008,'msg'=>'reg error','data'=>array()));
				exit();
			}
		}
		$usermodel = $this->model('user');
        $user = $usermodel->login($eusername, $pass, TRUE);
		if(!empty($user)) {
			$user['k'] = $this->getKey($user);
			echo json_encode(array('code'=>0,'msg'=>'','data'=>$user));
		} else {
			echo json_encode(array('code'=>600006,'msg'=>'reg error','data'=>array()));
			exit();
		}

	}

	/**
	*处理用户登录
	*/
	private function doLogin($param) {
		//check param
		if(empty($param['id']) || empty($param['user']) || empty($param['p']) ) {
			echo 'error:600004<br />';
			echo 'msg:miss args<br />';
			exit();
		}
		$appid = $param['appid'];
		$curtime = SYSTIME;
		$id = $param['id'];	//原始ID
		$user = $param['user'];	//原始账号	
		$realname = $param['name'];	//姓名
		$sex = $param['sex'];	//性别
		$pass = $param['p'];
		$rule = 0;	//用户类型表示 1表示老师 空或者其他表示学生
		if(!empty($param['r']) && $param['r'] == 1)
			$rule = 1;	
		$to = $param['to'];		//目的网校子域名，如果是老师 会注册教师权限
		$taddflag = FALSE;
		$ousermodel = $this->model('OUser');
		$ouser = $ousermodel->getOuserByUserName($user);
		$pre = $this->getAppPrefix($appid);
		$eusername = $pre.$user;
		if(!empty($ouser)) {	//用户已经存在，则判断是否修改过密码 如果修改过 则更新密码
			if($ouser['userpass'] != $pass) {
				//修改ouser密码
				$ouparam = array('userpass'=>$pass);
				$whereparam = array('ouid'=>$ouser['ouid']);
				$ousermodel->update($ouparam,$whereparam);
				//修改user密码
				$usermodel = $this->model('User');
				$uparam = array('mpassword'=>$pass);
				$usermodel->update($uparam,$ouser['uid']);
			}
		} else {	//不存在则进行注册操作
			$appinfo = $this->getAppInfo($appid);
			$rooms = $appinfo['rooms'];
			$uid = 0;
			if($rule == 1 && !in_array($to,$rooms)) {	//如果是教师而且对应的to不存在，则返回错误1675.13
				echo 'error:600005<br />';
				echo 'msg:error to arg<br />';
				exit();
			}
			if($rule == 1) {	//添加教师
				$teachmodel = $this->model('Teacher');
				$tparam = array('username'=>$eusername,'realname'=>$realname,'mpassword'=>$pass,'dateline'=>$curtime,'sex'=>$sex);
				$uid = $this->addTeacher($tparam,$to,FALSE);
				if($uid !== FALSE)
					$taddflag = TRUE;
			} else {	//添加学生
				$memmodel = $this->model('Member');
				$mparam = array('username'=>$eusername,'realname'=>$realname,'mpassword'=>$pass,'dateline'=>$curtime,'sex'=>$sex);
				$uid = $memmodel->addmember($mparam);
				if($uid !== FALSE){
					$saddflag = TRUE;
				}
			}
			if(empty($uid)) {
				echo 'error:600007<br />';
				echo 'msg:reg error<br />';
				exit();
			}
			$oparam = array('uid'=>$uid,'useruid'=>$id,'username'=>$user,'userpass'=>$pass,'usertag'=>$rule);
			$ouid = $ousermodel->add($oparam);
			if($ouid === FALSE) {
				echo 'error:600008<br />';
				echo 'msg:reg error<br />';
				exit();
			}
		}
		$usermodel = $this->model('user');
        $user = $usermodel->login($eusername, $pass, TRUE);
		if(!empty($user)) {
			
			if($user['groupid'] == 6) {
				$returnurl = 'http://'.$to.'.ebh.net/myroom.html';
			} else {
				$returnurl = 'http://'.$to.'.ebh.net/troom.html';
			}
			$durl = $this->savecookie($user);
			$this->assign('returnurl',$returnurl);
			$this->assign('durl',$durl);
			$this->display('common/sapi');
			if($taddflag) {
				$this->syncTeacherInfo($uid,$to);
			}else if($saddflag){
				$this->syncStudentInfo($uid,$to);
			}
		} else {
			echo 'error:600006<br />';
			echo 'msg:login error<br />';
			exit();
		}

	}
	/**
	*验证
	*/
	private function checkSign($param) {
		if(empty($param['appid']) || empty($param['sign']) || empty($param['t']))
			return FALSE;
		$t = intval($param['t']);
		$curtime = SYSTIME;
		if(($curtime - $t) > 86400) {	//有效期1天
			return FALSE;
		}
		$appsec = $this->getAppSecret($param['appid']);
		if(empty($appsec))
			return FALSE;
		$sign = $param['sign'];
		unset($param['sign']);
		$newsign = $this->buildsign($param,$appsec);
		if($newsign == $sign)
			return TRUE;
		return FALSE;
	}
	/**
	*根据AppID获取对应的加密key
	*/
	private function getAppSecret($appid) {
		$appinfo = $this->getAppInfo($appid);
		if(!empty($appinfo))
			return $appinfo['appsec'];
		return FALSE;
	}
	/**
	*根据AppID获取对应的账户前缀
	*/
	private function getAppPrefix($appid) {
		$appinfo = $this->getAppInfo($appid);
		if(!empty($appinfo))
			return $appinfo['prefix'];
		return FALSE;
	}
	/**
	*根据应用ID获取对应的第三方应用信息
	*/
	private function getAppInfo($appid) {
		if(isset($this->applist[$appid]))
			return $this->applist[$appid];
		return FALSE;
	}

	private function buildsign($arr,$appsec) {
		$sign = $appsec;
		foreach($arr as $ak=>$av) {
			$sign .=$ak.$av;
		}
		$sign = md5($sign);
		return $sign;
	}
	
	/**
	*根据子域名获取网校信息
	*/
	private function getRoomInfo($to) {
		if(isset($this->curroom))
			return $this->currom;
		$roommodel = $this->model('Classroom');
		$this->curroom = $roommodel->getroomdetailbydomain($to);
		return $this->curroom;
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
						$durl = 'http://www.'.$mydomain.'/sso.html?k='.$ssovalue;
						break;
					}
				}
			}
		}
		return $durl;
	}

	/**
	*return new valid user token key
	*/
	private function getKey($user) {
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}

	private function getloginuser() {
        if (isset($this->user))
            return $this->user;
        $input = EBH::app()->getInput();
        $usermodel = $this->model('user');
        $auth = $input->get('k');
        if (!empty($auth)) {
            @list($password, $uid,$ip,$time) = explode("\t", authcode($auth, 'DECODE'));
            $curip = $input->getip();
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            if(!empty($user)) {
                $lastlogintime = $input->cookie('lasttime');
                $lastloginip = $input->cookie('lastip');
                $user['lastlogintime'] = empty($lastlogintime) ? '' : date('Y-m-d H:i',$lastlogintime);
                $user['lastloginip'] = $lastloginip;
            }
            $this->user = $user;
            return $user;
        }
        return FALSE;
    }
}
?>
