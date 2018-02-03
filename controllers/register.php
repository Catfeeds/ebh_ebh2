<?php
class RegisterController extends CControl{

	public function index(){
		if($this->input->post()){
			header("Content-type:text/html;charset=utf-8");
			$curdomain =  $this->uri->curdomain;
			if(empty($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'],$curdomain)===false)
				return false;
			$username = $this->input->post('username');
			if(strlen($username)<6 || strlen($username)>20 || !preg_match("/^[a-zA-Z][a-z0-9A-Z_]{5,19}$/",$username))
				return false;
			$password = $this->input->post('password');
			if(strlen($password)<6 || strlen($password)>16)
				return false;

			$realname = $this->input->post('realname');

			if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z\s]{1,20}$/u",$realname))
				$realname = '';
			$mobile = $this->input->post('mobile') ? $this->input->post('mobile') : '';
			if(!preg_match("/^1[3-8]{1}\d{9}$/",$mobile))
				$mobile = '';
			$usermodel = $this->model('user');
			$exists = $usermodel->exists($username);
			if($exists)
				return false;

			$sex = $this->input->post('sex');
			$param['username'] = $username;
			$param['password'] = $password;
			//$param['email'] = $email;
			$param['schoolname'] = h($this->input->post('schoolname'));
			$param['mobile'] = $mobile;
			$param['realname'] = $realname;
			$param['dateline'] = SYSTIME;
			$param['sex'] = ($sex!=1)?0:$sex;
			$member = $this->model('member');
			$res = $member->addmember($param);
            //将注册信息记录到日志
            if($res){
                $logdata = array();
                $logdata['uid']=$res;
                $logdata['logtype']=1;
                $roominfo = Ebh::app()->room->getcurroom();
                $logdata['crid']=isset($roominfo['crid'])?$roominfo['crid']:0;
                $registerloglib=Ebh::app()->lib('RegisterLog');
                $registerloglib->addOneRegisterLog($logdata);
            }
			if($res){
				$user = $usermodel->login($param['username'],$param['password']);
				$uid = $user['uid'];
                $pwd = $user['password'];

                //如果管理后台勾选验证手机 则绑定手机
                $room = Ebh::app()->room->getcurroom();
                if($room['crid']){
                	$systeminfo = Ebh::app()->room->getSystemSetting();
					if($systeminfo['mobile_register'] == 1){
						//绑定手机
						//向ebh_binds表插入绑定数据
						$bindmodel = $this->model('Bind');
						$binddata = array(
							'uid'=>$user['uid'],
							'is_mobile'=>1,
						    'mobile'=>$mobile,
							'mobile_str'=>json_encode(
									array('mobile'=>$mobile,
											'uid'=>$user['uid'],
											'dateline'=>SYSTIME
										)
								)
						);
						$bindmodel->doBind($binddata,$user['uid']);
					}

					if($systeminfo['isdepartment'] == 1){//开启部门注册
						$classid = intval($this->input->post('departmentid'));
						if ($classid > 0) {
							//绑定部门
							//向ebh_classstudents表插入绑定数据
							$classModel = $this->model('Classes');
							$binddata = array(
								'crid'=>$roominfo['crid'],
								'uid'=>$user['uid'],
								'classid'=>$classid
							);
							$res = $classModel->addclassstudent($binddata);
							$roomuserModel = $this->model('Roomuser');
							$param['uid'] = $user['uid'];
							$param['crid'] = $roominfo['crid'];
							$param['cstatus'] = 1;
							$param['cnname'] = $realname;
							$roomuserModel->insert($param);
							
						}
						
					}
                }

				$auth = authcode("$pwd\t$uid", 'ENCODE');
				$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年

				$this->input->setcookie('auth', $auth, $cookietime);
                $this->input->setcookie('lasttime', $user['lastlogintime']);
                $this->input->setcookie('lastip', $user['lastloginip']);
				$credit = $this->model('credit');
				$credit->addCreditlog(array('ruleid'=>1,'uid'=>$uid));
				$durl = $this->savecookie($user);
				echo json_encode(array('code'=>0,'msg'=>'success'));
				fastcgi_finish_request();
				//同步SNS数据(当用户注册成功时同步)
				Ebh::app()->lib('Sns')->do_sync($uid, 5);
				//同步用户总数
				Ebh::app()->lib('xNums')->add('user');
			}
			else
				echo '注册失败';
		}else{
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Cache-Control: no-store, must-revalidate");
			header("Pragma: no-cache");
			$this->display('common/newtemplate/register');
		}
	}
	public function checkusername(){
		$username = $this->input->post('username');
		if($username){
			$usermodel = $this->model('user');
			$exists = $usermodel->exists($this->input->post('username'));
//			$isblack = $this->_isInBlack($username);//验证用户名是不是在黑名单  //黑名单注释
//			if($exists || $isblack)
            if($exists)
				echo json_encode(array('code'=>1));
			else
				echo json_encode(array('code'=>0));

		}else{
			return false;
		}
	}

	public function checkemail(){
		if($this->input->post('email')){
			$user = $this->model('user');
			$res = $user->existsEmail($this->input->post('email'));
			if($res)
				echo json_encode(array('code'=>1));
			else
				echo json_encode(array('code'=>0));
		}else{
			return false;
		}
	}

	/**
	*保存登录状态，同时生成多域名处理请求
	*/
	private function savecookie($user){
		$uid = $user['uid'];
		$pwd = $user['password'];
		$auth = authcode("$pwd\t$uid", 'ENCODE');
		$savestate = $this->input->post('cookietime');
		$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
		$durl = '';
		if(!empty(Ebh::app()->domains)) {	//处理多域名配置，如果存在多域名，则需要对其他域名cookie注入操作
			$curdomain = $this->uri->curdomain;
			if(!empty($curdomain)) {
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

	/*
	页面内弹出的注册框
	*/
	public function inpage(){
		$this->display('common/register_inpage');
	}

	/**
	 * [获取手机验证码]
	 */
	public function getsmscode(){
		//验证手机号是否已经绑定了
		$mobile = trim($this->input->post('mobile'));
		$bdmodel =  $this->model("Bind");
		$ckexist = $bdmodel->checkmobile($mobile);
		if($ckexist){
			$this->retmsg(-1,'该手机号已绑定,请换一个手机号试试');
			exit(0);
		}
//		//验证该手机号是否在黑名单中     //黑名单注释
//		$isblack = $this->_isInBlack($mobile);
//		if($isblack){
//			$this->retmsg(-1,'该手机号被限制注册');
//			exit(0);
//		}
		$code = $this->ticketget($mobile);
		//先判断该ip距离上次发送短信的时间是否大于40，只有大于40才能再次请求发送短信(改成40S是为了配合新接口)
		$ip = getip();
		$mip = md5($ip);
		$powertag = !$this->cache->get($mip);
		if($powertag){
			$this->cache->set($mip,1,60);
		}else{
			$this->retmsg(-1,'距离上次发送短信时间间隔小于60秒，请稍后再试！');
		}
		//发送短信
		$this->smssend($code,$mobile);
	}

	/**
	 * [短信验证码校验]
	 */
	public function smscheck(){
		session_start();
		$code = intval(trim($this->input->post('smscode')));
		if(empty($code)){
			$this->retmsg(-1,'短信验证码不能为空');
			return;
		}
		$mcode = md5($code);
		$smscode_cache = isset($_SESSION[$mcode]) ? $_SESSION[$mcode] : '';
		if(empty($smscode_cache)){
			$this->retmsg(-1,'短信验证码校验失败');
			return;
		}
		$str = authcode($smscode_cache,'DECODE');

		if((time() - $_SESSION[$mcode.'time'] > 60) || empty($str)){
			$_SESSION[$mcode.'time'] = null;
			$this->retmsg(-1,'校验码填写不正确或者已过期');
			return;
		}
		@list($mobile,$ip) = explode("\t", $str);
		if(empty($mobile) || empty($ip)){
			$this->retmsg(-1,'短信验证码校验失败');
			return;
		}else{
			$curip = getip();
			if($curip!= $ip){
				$this->retmsg(-1,'IP发生改变，校验失败');
				return;
			}
			$curmobile = trim($this->input->post('mobile'));
			if($curmobile != $mobile){
				$this->retmsg(-1,'手机号不匹配，校验失败');
				return;
			}
			//成功
			echo json_encode(array('status'=>0,'msg'=>'验证成功','attr'=>$code));

		}
	}

	/**
	 * [发送短信逻辑]
	 */
	public function smssend($code,$mobile){
		$msg = $code.'（手机验证码，请完成验证）如非本人操作，请忽略此短信。';
		$fix = $this->input->get('fix');
		if(!empty($fix)){
			$res = Ebh::app()->lib('SMS')->send_fix($mobile,$msg);
		}else{
			$res = Ebh::app()->lib('SMS')->send_dayu($mobile,$code);
		}
		$this->retmsg(0,'短信校验码已发送');
	}

	/**
	 * [生成验证码，有效期60秒]
	 */
	private function ticketget($mobile){
		session_start();
		//生成票据
		$ip = getip();
		$str = $mobile."\t".$ip;
		$k = authcode($str,'ENCODE');
		$code = rand(1000,9999);
		$mcode = md5($code);
		$_SESSION[$mcode.'time'] = time();
		$_SESSION[$mcode] = $k;
		return $code;
	}
	/**
	 * [信息反馈]
	 */
	private function retmsg($status,$msg,$attr = array()){
		echo json_encode(array(
				'status'=>$status,
				'msg'=>$msg,
				'attr'=>$attr
		));
		exit;
	}

	/**
	 * [获取网校后台设置手机绑定的状态]
	 */
	public function getbindstatus(){
		$result = Ebh::app()->room->getSystemSetting();
	    if($result){
	    	$result['isenterprise'] = Ebh::app()->room->getRoomType() == 'com' ? 1 : 0;
	        echo json_encode(array('error_code'=>0,'msg'=>'','data'=>$result));
	    }else{
	        echo json_encode(array('error_code'=>1,'msg'=>'稍后重试'));
	    }
	}

//	//判断用户名或手机号码是否在黑名单      //黑名单注释
//	private function _isInBlack($param){
//	    $this->apiServer = Ebh::app()->getApiServer('ebh');
//		//从缓存获取黑名单  不存在缓存则查询 并设置缓存
//		$redis = Ebh::app()->getCache('cache_redis');
//		$redis_key = 'register_blacks';
//		$blacklist = $redis->hget($redis_key);
//
//		if (empty($blacklist)){
//			$blacks = $this->apiServer->reSetting()
//			    ->setService('Adminv2.Black.getRegisterBlack')
//	            ->request();
//	         $blacklist = array();
//	         foreach($blacks as $black){
//	         	foreach($black as $value){
//	         		$blacklist[] = $value;
//	         	}
//	         }
//			$redis->hMset($redis_key, $blacklist);
//		}
//	    return in_array($param, $blacklist);
//	}
}
?>