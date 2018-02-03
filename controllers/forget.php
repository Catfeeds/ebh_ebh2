<?php
/**
 * 忘记密码
 * @author eker
 *
 */
class ForgetController extends CControl{
	
	/**
	 * 邮箱找回密码
	 */
	public function index(){
		$returnurl = '';
		if(NULL !== $this->input->get('returnurl')) {
			$returnurl = $this->input->get('returnurl');
		}
		if($this->input->post('forget')){
			$email = trim ( $this->input->post('email') );
			$ajax = $this->input->post('ajax');
			$code=strtolower($this->input->post('emailcode'));
			//检测验证码
			$verify = Ebh::app()->lib('Verify');
			$verify->init();
			if(empty($code) || $verify -> check($code)===false){
				echo json_encode(array('status'=>-1,'msg'=>'验证码错误'));
				exit(0);
			}
			
			//验证限制次数
			$ip = getip();
			$retarr = $this->checkLimitTimes($email, $ip);
			if(!empty($retarr)&&is_array($retarr)){
				echo json_encode($retarr);
				exit(0);
			}
			
			$model = $this->model('user');
			$user = $model->getUserByEmail($email);

			if ($user) {
				$msgarr = $this->getmessagetpl($user, $email, $returnurl);
				$codekey = $msgarr['codekey'];
				$msgtpl = $msgarr['message'];
				$mailer = Ebh::app()->lib('EBHMailer');
				$toarr = array('username'=>$user['username'],'email'=>$email);
				$retarr = $mailer->sendMessage($toarr,'找回密码-e板会',$msgtpl);
				if(!$retarr['status']){
					//发送成功 设置缓存
					$this->setLimitTimes($email, $ip);
					echo json_encode(array('status'=>0,'msg'=>'邮件发送成功'));
				}else{
					echo json_encode(array('status'=>-1,'msg'=>'邮件发送失败'));
				}
			} 
		}else{
			$this->assign('returnurl',$returnurl);
			$this->assign('mobile',$this->input->get('mobile'));
			$this->display('common/newtemplate/forget');
		}
	}
	
	
	
	
	/**********************************验证发送次数限制**************************************************/
	const EXPIRE_SEC = 1800;    // 过期时间间隔
	const RESEND_SEC = 60;     // 重发时间间隔
	const ONE_DAY_EMAIL_COUNT = 10;    //每日向同一个邮箱号发送邮件的次数
	const ONE_DAY_IP_COUNT = 100; //同一个ip每天限制最大次数
	
	/**
	 * 向指定手机号发送验证码
	 * @param $mobile
	 * @param $imei
	 * @return bool
	*/
	public function checkLimitTimes($email, $ip) {
		$redis = Ebh::app()->getCache('cache_redis');
		$vcKey = 'VC_'.$email;
		$iplimitKey = 'VC_IP_LIMIT_'.$ip;
		$emaillimitkey = 'VC_EMAIL_LIMIT_'.$email;
	
		// 验证码重发限制
		$data = json_decode($redis->get($vcKey), true);
		if($data && time() < $data['resend_expire']) {
			return array('status' => -1, 'msg' => '邮件已在1分钟内发出，请耐心等待');
		}
	
		// 邮箱限制
		$sendCnt = $redis->zScore($emaillimitkey, $email);
		if($sendCnt && $sendCnt >= self::ONE_DAY_EMAIL_COUNT) {
			return  array('status' => -1, 'msg' => '您的找回次数已超过最大限制(同一个邮箱,每天限制10次)，请明天再试.');
		}
		// ip限制
		$ipCnt = $redis->get($iplimitKey);
		if($ipCnt && $ipCnt >= self::ONE_DAY_IP_COUNT) {
			return array('status' => -1, 'msg' => '您的找回次数已超过最大限制(同一个IP,每天限制100次)，请明天再试.');
		}
	}
	
	/**
	 * 发送成功后 设置缓存
	 * @param unknown $email
	 * @param unknown $ip
	 * @return boolean
	 */
	public function  setLimitTimes($email,$ip){
		$redis = Ebh::app()->getCache('cache_redis');
		$vcKey = 'VC_'.$email;
		$iplimitKey = 'VC_IP_LIMIT_'.$ip;
		$emaillimitkey = 'VC_EMAIL_LIMIT_'.$email;

		//重设时限
		$data = array('vc' => $ip, 'resend_expire' =>  time() + self::RESEND_SEC);
		$redis->set($vcKey, json_encode($data));
		$redis->expire($vcKey, self::EXPIRE_SEC); // 设置验证码过期时间

		//设置邮箱每天限制
		$redis->zIncrBy($emaillimitkey, 1, $email);
		$redis->expireAt($emaillimitkey, strtotime(date('Y-m-d',strtotime('+1 day'))));
		
		// 设置ip每天限制
		$redis->incr($iplimitKey);
		$redis->expireAt($iplimitKey, strtotime(date('Y-m-d',strtotime('+1 day'))));

		return true;
	}
	
	/********************************验证发送次数限制****************************************************/
	
	
	/**
	 * 邮箱返回-重新设置新密码
	 */
	public function reset(){
		$post = $this->input->post();
		$flag = true;
		$returnurl = '';
		
		if(!empty($post['doreset'])){
			$returnurl = empty($post['returnurl'])?"/homev2.html":$post['returnurl'];
			$codekey = $post['codekey'];
			list($uid,$email,$time) = @ explode("\t", authcode($codekey, 'DECODE'));
			if(!empty($post['pwd']) && ($uid>0)){
				$userarr['password'] = $post['pwd'];
				$usermodel = $this->model('user');
				$res = $usermodel->update($userarr,$uid);
				if($res){
					$userinfo  = $usermodel ->getloginbyuid($uid,$post['pwd']);
					$durl = $this->savecookie($userinfo);
					echo json_encode(array('code'=>true,'backurl'=>$returnurl,'durl'=>$durl));
				}else{
					echo json_encode(array('code'=>false));
				}
			}else{
				echo json_encode(array('code'=>false));
			}

			
		}else{
			if(NULL !== $this->input->get('returnurl')) {
				$returnurl = $this->input->get('returnurl');
			}
			$codekey = $this->input->get('codekey');
			if(!empty($codekey)){
				list($uid,$email,$time) = @ explode("\t", authcode($codekey, 'DECODE'));
			}
			if(empty($uid) || empty($email) || empty($time) || empty($codekey) || (SYSTIME-24*3600>$time)){
				$this->assign('flag', false);
				$this->display('common/newtemplate/forget_reset');
				exit(0);
			}
			$this->assign('codekey', $codekey);
			$this->assign('flag', $flag);
			$this->assign('returnurl',$returnurl);
			$this->display('common/newtemplate/forget_reset');
		}

	}
	
	/**
	 * 手机-重新设置密码
	 */
	public function mobile_reset(){
		$flag  = true;
		$post = $this->input->post();
		if(!empty($post['doreset'])){
			$returnurl = "/homev2.html";
			$codekey = $post['codekey'];
			list($time,$mobile,$ip) = @ explode('\t', authcode($codekey, 'DECODE'));
			if(!empty($mobile)){
				$usermodel = $this->model('user');
				$user = $usermodel->getUserByMobile($mobile);
				
				if(!empty($post['pwd']) && !empty($user)){
					$userarr['password'] = $post['pwd'];
					$res = $usermodel->update($userarr,$user['uid']);
					if($res){
						$userinfo  = $usermodel ->getloginbyuid($user['uid'],$post['pwd']);
						$durl = $this->savecookie($userinfo);
						echo json_encode(array('code'=>true,'backurl'=>$returnurl,'durl'=>$durl));
					}else{
						echo json_encode(array('code'=>false));
					}
				}else{
					echo json_encode(array('code'=>false));
				}
				
			}else{
				echo json_encode(array('code'=>false));
			}
		}else{
			$codekey = $this->input->get('codekey');
			if(!empty($codekey)){
				list($time,$mobile,$ip) = @ explode('\t', authcode($codekey, 'DECODE'));
			}
			if(empty($time) || empty($mobile) || empty($ip) || empty($codekey) || (SYSTIME-3600>$time)){
				$this->assign('flag', false);
				$this->display('common/newtemplate/forget_mobile_reset');
				exit(0);
			}
			$this->assign('codekey', $codekey);
			$this->assign('flag', $flag);
			$this->display('common/newtemplate/forget_mobile_reset');
		}
		
	}
	
	
	/**
	 * 注册手机找回密码
	 */
	public function mobile(){
		$this->display('common/forget_mobile');
	}


    /*
    验证邮箱是否存在 
    */
    public function checkemail(){
        if($this->input->post()){
            $email = $this->input->post('email');
            $usermodel = $this->model('user');
            $user = $usermodel->getUserByEmail($email);
            if($user){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    
    /**
     * 验证手机号是否存在
     */
    public function checkmobile(){
    	$mobile = $this->input->post('mobile');
    	$usermodel = $this->model('user');
    	$user = $usermodel->getUserByMobile($mobile);
    	if($user){
    		echo  json_encode(array('code'=>true));
    	}else{
    		echo  json_encode(array('code'=>false));
    	}
    }
    
    /*****************************改版处理********************************************************/
    /**
     * 获取消息模板
     * @param unknown $user
     * @param unknown $email
     * @param unknown $returnurl
     * @return mixed
     */
    public function getmessagetpl($user,$email,$returnurl){
    	//log_message(var_export($user,true));
    	$username = $user['username'];
    	$time = SYSTIME;
    	$codekey = urlencode(authcode("{$user['uid']}\t$email\t$time",'ENCODE'));
    	$url = "http://www.ebh.net/forget/reset.html?codekey=".$codekey."&returnurl=".$returnurl;
    	$message = "" . '<p>亲爱的：' .$username.' 你好</p>' . "\n" . '----------------------------------------------------------------------<br />' . "\n" . '您已经申请了忘记密码，请在24小时内更换您的密码，如果不做任何操作，系统将保留原密码。<br />' . "\n" . '----------------------------------------------------------------------<br />' . "\n" . '<br />' . "\n" . '您可以点击下面的链接进行更换密码：</p>' . "\n" . '<p><a href="%s" target="_blank">%s</a></p>' . "\n" . '<p>(如果上面不是链接形式，请将地址手工粘贴到浏览器地址栏再访问)<p>' . '此邮件为系统邮件，请勿直接回复。<br/>' . 'e板会系统     www.ebh.net';
    	$message = str_replace ( "%s", $url, $message );
    	log_message($message);
    	return array('message'=>$message,'codekey'=>$codekey);
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
    	if($user['groupid'] == 5) {	//如果是教师，则添加ak的cookie设置，主要用于学校后台获取权限
    		$this->input->setcookie('ak', $auth, $cookietime);
    	}
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
    
    
    /***************************************************/
    /**
     * @author eker
     *	2016年3月2日16:45:31
     *短信验证码接口
     */
    /***************************短信验证码 start*****************************************************************/
    //获取验证码，用于前台的ajax请求
    public function getsmscode(){
    	$check = false;
    	//验证手机号是否已经绑定了
    	$mobile = trim($this->input->post('mobile'));
    	//$bdmodel =  $this->model("Bind");
    	$usermodel = $this->model('user');
    	
    	
    	$check= @ $this->input->post('check');
    	$check  = ($check == 'true')? true : false;
    	//$ckexist = $bdmodel->checkmobile($mobile);
    	$ckexist = $usermodel->getUserByMobile($mobile);
    	
    	if(($ckexist && $check) !=true){
    		$this->_ret_msg(-1,'该手机号尚未绑定,请更换一个,重新再试！');
    		exit(0);
    	}
    
    	$code = $this->_ticket_get();
    	//先判断该ip距离上次发送短信的时间是否大于40，只有大于40才能再次请求发送短信(改成40S是为了配合新接口)
    	$ip = $this->input->getip();
    	$mip = md5($ip);
    	$powertag = !$this->cache->get($mip);
    	if($powertag){
    		$this->cache->set($mip,1,40);
    	}else{
    		$this->_ret_msg(-1,'距离上次发送短信时间间隔小于60秒，请稍后再试！');
    	}
    	//发送短信
    	$this->sms_send($code);
    }
    
    //短信验证码校验
    public function sms_check(){
    	$code = trim($this->input->post('smscode'));
    	if(empty($code)){
    		$this->_ret_msg(-1,'短信验证码校验失败');
    		return;
    	}
    	$mcode = md5($code);
    	$smscode_cache = $this->cache->get($mcode);
    	$str = authcode($smscode_cache,'DECODE');
    	if(empty($str)){
    		$this->_ret_msg(-1,'校验码填写不正确或者已过期');
    		return;
    	}
    	@list($time,$mobile,$ip) = explode('\t', $str);
    	if(empty($mobile) || empty($time) || empty($ip)){
    		$this->_ret_msg(-1,'短信验证码校验失败');
    		return;
    	}else{
    		$curip = $this->input->getip();
    		if($curip!=$ip){
    			$this->_ret_msg(-1,'IP发生改变，校验失败');
    			return;
    		}
    		$curmobile = trim($this->input->post('mobile'));
    		if($curmobile!=$mobile){
    			$this->_ret_msg(-1,'手机号不匹配，校验失败');
    			return;
    		}
    		$curtime =SYSTIME;
    		if($curtime-1800>$time){
    			$this->_ret_msg(-1,'验证码已过期，校验失败');
    			return;
    		}

    		$codekey = urlencode(authcode($str,'ENCODE'));
    		//log_message($codekey);
    		$this->_ret_msg(0,'短信校验成功',array('codekey'=>$codekey));
    	}
    }
    
    //发送短信逻辑
    public function sms_send($code){
    	$mobile = trim($this->input->post('mobile'));
    	$msg = $code.'（手机验证码，请完成验证）如非本人操作，请忽略此短信。';
    	$fix = $this->input->get('fix');
    	if(!empty($fix)){
    		$res = Ebh::app()->lib('SMS')->send_fix($mobile,$msg);
    	}else{
    		$res = Ebh::app()->lib('SMS')->send_dayu($mobile,$code);
    		//$res = Ebh::app()->lib('SMS')->send($mobile,$msg);
    	}
    	$this->_ret_msg(0,'短信校验码已发送');
    }
    
    //生成验证码，有效期120秒，手机网络差的就坑了O(∩_∩)O哈哈~
    private function _ticket_get(){
    	//校验成功，生成票据
    	$time = SYSTIME;
    	$mobile = trim($this->input->post('mobile'));
    	$ip = $this->input->getip();
    	$str = $time.'\t'.$mobile.'\t'.$ip;
    	$k = authcode($str,'ENCODE');
    	do{
    		$code = random(6,true);
    		$mcode = md5($code);
    	}while($this->cache->get($mcode));
    	$this->cache->set($mcode,$k,120);
    	return $code;
    }
    //信息反馈
    private function _ret_msg($status,$msg,$attr = array()){
    	echo json_encode(array(
    			'status'=>$status,
    			'msg'=>$msg,
    			'attr'=>$attr
    	));
    	exit;
    }
    /***************************短信验证码 end*******************************************************************/
    
    
}
?>