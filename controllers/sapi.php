<?php

/**
 * 第三方直接登录入口
 */
class SapiController extends CControl {
	private $applist = array('10125029349'=>array('appsec'=>'3984948596859','prefix'=>'mz_','rooms'=>array('jxhlw','wxyz')));	//key appid value appsecret
	private $curroom = NULL;
	/**
	*http://sso.ebh.net/sapi.html?param=paramvalue
	*paramvalue=base64_encode(appid=xx&op=login&id=xx&user=xx&name=xx&r=1&sex=xx&p=xx&to=xx&t=xx&sign=xx)
	*/
    public function index() {
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
			echo 'error:600002<br />';
			echo 'msg:key is not valid<br />';
			exit();
		}
		if(!$this->checkSign($keylist)) {
			echo 'error:600003<br />';
			echo 'msg:key is not valid<br />';
			exit();
		}
		if(empty($keylist['op'])) {
			echo 'error:600004<br />';
			echo 'msg:miss op arg<br />';
			exit();
		}
//		var_dump($keylist);exit();
		if($keylist['op'] == 'login') {
			$this->doLogin($keylist);
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
	*添加教师记录，并且将教师权限加入到$to对应的网校中
	*@param $tparam array 教师参数
	*@param $to $string 对应的域名
	*@param $check bool 是否对教师已经存在网校中进行验证
	*/
	private function addTeacher($tparam,$to,$check = FALSE) {
		//添加教师
		$tid = FALSE;
		if(!empty($tparam['uid']))
			$tid = $tparam['uid'];
		$roominfo = $this->getRoominfo($to);

		$user = $this->model('user');
		$code = 0;
		$message = '';
		$username = $tparam['username'];
		$exists = $user->exists($username);
		if($check === FALSE && !empty($exists)) {	//存在同名账号，不允许加入
			return FALSE;
		}
		$addflag = FALSE;
		$tmodel = $this->model('Teacher');
		if(empty($exists)) {	//如果不存在则先进行注册
			$tparam['dateline'] = SYSTIME;
			$tid = $tmodel->addteacher($tparam);
			$addflag = TRUE;
		}
		if(!$addflag && !$check) {	//不需要检测的，只需直接加入到网校
			$trow = $tmodel->getroomteacherdetail($roominfo['crid'],$tid);
			if(!empty($trow))	//已经在网校 则直接返回
			{
				return $tid;
			}
		}
		$param['tid'] = $tid;
		$param['crid'] = $roominfo['crid'];
		$param['status'] = 1;
		$param['cdateline'] = SYSTIME;
		$param['role'] = 1;
		$aresult = $tmodel->addroomteacher($param);
		return $tid;
		
	}
	/**
	*根据子域名获取网校信息
	*/
	private function getRoomInfo($to) {
		if(isset($this->curroom))
			return $this->curroom;
		$roommodel = $this->model('Classroom');
		$this->curroom = $roommodel->getroomdetailbydomain($to);
		return $this->curroom;
	}
	private function syncTeacherInfo($tid,$to) {
		fastcgi_finish_request();
		$roominfo = $this->getRoomInfo($to);
		$crid = $roominfo['crid'];
		//更新SNS网校用户缓存
		$snslib = Ebh::app()->lib('Sns');
		$snslib->updateRoomUserCache(array('crid'=>$crid,'uid'=>$tid));
		//同步SNS数据(用户网校操作)
		$snslib->do_sync($tid, 4);
		//header('location:'.geturl('aroomv2/teacher'));
		Ebh::app()->lib('xNums')->add('user');
       	Ebh::app()->lib('xNums')->add('teacher');
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
}
?>
