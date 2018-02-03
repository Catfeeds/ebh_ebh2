<?php
class CreateroomController extends CControl{
	//是否是后台判断
	private $inner_check = false;
	private $errorno = 0;
	private $errormsg = '';
	
	//创建网校首页view显示
	public function index(){
		$this->display('common/newtemplate/createroom');
	}

	//创建网校
	public function create(){
		if(!$this->_beforecreate()){
			$this->inner_check = false;
			$this->_ret_msg($this->errorno,$this->errormsg);
			return;
		}
		$teacherinfo = $this->_teacher_add();
		$roominfo = $this->_room_add($teacherinfo);
		$res = $this->_roomteacher_add($roominfo['crid'],$teacherinfo);
		if($res){
			//添加老师成功 对手机号进行绑定
			$this->_bindMobile($teacherinfo['uid'],$teacherinfo['mobile']);

			$ret = array(
				'crname'=>$roominfo['crname'],
				'domain'=>$roominfo['domain'],
				'mobile'=>$teacherinfo['mobile'],
				'password'=>$teacherinfo['password'],
				'realname'=>$teacherinfo['realname']
			);
			$usermodel = $this->model('user');
            $user = $usermodel->login($ret['mobile'], $ret['password']);
            $durl = $this->savecookie($user);
            $ret['durl'] = $durl;
			echo json_encode(array(
				'status'=>0,
				'msg'=>'创建成功',
				'attr'=>$ret
			));
			fastcgi_finish_request();
			//网校数据拷贝逻辑
            if ($roominfo['template'] == 'plate') {
                //新模板
                $config = Ebh::app()->getConfig()->load('othersetting');
                if ($roominfo['property'] == 0) {
                    $scrid = intval($config['default_plate']);
                } else {
                    $scrid = intval($config['property']);
                }
                $this->_synplate($scrid, $roominfo['crid'], $user['uid']);
            } else {
                $this->_syncroom(10643,$roominfo['crid'],$user['uid']);
            }

			$this->_sendmsg_after_createroom_success($ret);
			//默认APP
			$this->defaultapp($roominfo['crid']);
			//默认APP Module
			$this->_defaultAppModule($roominfo['crid']);
			
		}else{
			$this->inner_check = false;
			$this->_ret_msg(-1,'创建失败');
		}
        //将用户注册信息记录到日志
        if($res){
            $logdata = array();
            if(isset($roominfo['uid']) && isset($roominfo['crid'])){
                $logdata['uid']=$roominfo['uid'];
                $logdata['crid']=$roominfo['crid'];
            }
            $logdata['logtype'] = 4;
            $registerloglib=Ebh::app()->lib('RegisterLog');
            $registerloglib->addOneRegisterLog($logdata);
        }
	}

	//判断用户是否存在(单个手机可以注册多个网校)
	public function is_user_exists2(){
		//手机号就是登陆账号
		$mobile = $this->input->post('mobile');
		$password = $this->input->post('password');
		$realname = $this->input->post('realname');
		if(empty($realname)){
			$this->_ret_msg(-1,'姓名不能为空');
			return;
		}
		$username = $mobile;
		if(empty($username)){
			$this->_ret_msg(-1,'手机号不能为空');
			return;
		}
		if(empty($password)){
			$this->_ret_msg(-1,'手机号正确,请在密码栏输入登录密码');
			return;
		}
		$teacherModel = $this->model('Teacher');
		$teacherinfo = $teacherModel->getteacherbyusername($username);
		if(!empty($teacherinfo)){
			$this->_ret_msg(-1,'手机号已经存在，一个手机号码只能注册一个网校');
			return;
			if( $teacherinfo['password']==md5($password) ){
				$this->_ret_msg(0,'手机号可用');
			}else{
				$this->_ret_msg(-1,'手机号已经存在，但是密码不匹配');
			}
		}else{
			$this->_ret_msg(0,'手机号可用');
		}
	}

	//判断用户是否存在(单个手机只可以注册一个网校)
	public function is_user_exists(){
		//手机号就是登陆账号
		$mobile = $this->input->post('mobile');
		//校验手机是否已经绑定 已绑定过的手机不允许注册
		$bdmodel =  $this->model("Bind");
		$ckexist = $bdmodel->checkmobile($mobile);
		if($ckexist){
			$this->_ret_msg(-1,'该手机号已绑定,请换一个手机号');
			exit(0);
		}
		$password = $this->input->post('password');
		$username = $mobile;
		$realname = $this->input->post('realname');
		// if(empty($realname)){
		// 	$this->_ret_msg(-1,'姓名不能为空');
		// 	return;
		// }
		if(empty($username)){
			$this->_ret_msg(-1,'手机号不能为空');
			return;
		}
//		//黑名单校验 //黑名单注释
//		if($this->_isInBlack($username)){
//			$this->_ret_msg(-1,'系统检测失败，请联系靳老师，陈老师。');
//			return;
//		}
		
		$teacherModel = $this->model('Teacher');
		$teacherinfo = $teacherModel->getteacherbyusername($username);
		if(!empty($teacherinfo)){
			$this->_ret_msg(-1,'手机号已经存在，一个手机号码只能注册一个网校');
			return;
		}else{
			$this->_ret_msg(0,'手机号可用');
		}
	}

	public function is_crname_exists(){
		$crname = $this->input->post('crname');
		$db = Ebh::app()->getDb();
		$sql = 'select count(1) count from ebh_classrooms where crname = \''.$db->escape_str($crname).'\'';
		$res = $db->query($sql)->row_array();
		if($res['count'] > 0){
			$this->_ret_msg(-1,'网校已经存在，请换个网校名字');
		}else{
			$this->_ret_msg(0,'网校名称正确');
		}
	}

	//获取验证码，用于前台的ajax请求
	public function getcode(){
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

	//发送短信逻辑
	public function sms_send($code){
		$mobile = trim($this->input->post('mobile'));
		$msg = $code.'（手机验证码，请完成验证）如非本人操作，请忽略此短信。';
		$fix = $this->input->get('fix');
		if(!empty($fix)){
			$res = Ebh::app()->lib('SMS')->send_fix($mobile,$msg);
		}else{
			// $res = Ebh::app()->lib('SMS')->send($mobile,$msg);
			$res = Ebh::app()->lib('SMS')->send_dayu($mobile,$code);
		}
		$this->inner_check = false;
		$this->_ret_msg(0,'短信校验码已发送');
	}

	//短信验证码校验
	public function sms_check(){
        /*start 测试*/
        //$this->_ret_msg(0,'短信校验成功');return;
        /*end 测试*/
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
		@list($domain,$mobile,$password,$ip) = explode('\t', $str);
		if(empty($domain) || empty($mobile) || empty($password) || empty($ip)){
			$this->_ret_msg(-1,'短信验证码校验失败');
			return;
		}else{
			$curip = $this->input->getip();
			if($curip!=$ip){
				$this->_ret_msg(-1,'获取验证码之后更换了IP，校验失败');
				return;
			}
			$curdomain = trim($this->input->post('domain'));
			if($curdomain!=$domain){
				$this->_ret_msg(-1,'获取验证码之后更换了域名，校验失败');
				return;
			}
			$curmobile = trim($this->input->post('mobile'));
			if($curmobile!=$mobile){
				$this->_ret_msg(-1,'获取验证码之后更换了手机，校验失败');
				return;
			}
			$curpassword = trim($this->input->post('password'));
			if($curpassword!=$password){
				$this->_ret_msg(-1,'获取验证码之后更换了密码，校验失败');
				return;
			}
			$this->_ret_msg(0,'短信校验成功');
		}
	}

	//生成验证码，有效期120秒，手机网络差的就坑了O(∩_∩)O哈哈~
	private function _ticket_get(){
		if($this->_inner_check()){//校验成功，生成票据
			$this->inner_check = false;
			$mobile = trim($this->input->post('mobile'));
			$domain = trim($this->input->post('domain'));
			$password = trim($this->input->post('password'));
			$ip = $this->input->getip();
			$str = $domain.'\t'.$mobile.'\t'.$password.'\t'.$ip;
			$k = authcode($str,'ENCODE');
			do{
				$code = random(6,true);
				$mcode = md5($code);
			}while($this->cache->get($mcode));
			$this->cache->set($mcode,$k,120);
			return $code;
		}else{
			$this->inner_check = false;
			$this->_ret_msg($this->errorno,$this->errormsg);
		}
	}

	//服务端校验用户信息
	private function _inner_check(){
		//将校验转为服务端校验
		$this->inner_check = true;
		//校验域名合法性
		$this->domain_check();
		if($this->errorno == -1){
			return false;			
		}
		//校验用户信息合法性
		$this->is_user_exists2();
		if($this->errorno == -1){
			return false;			
		}
		//校验学校名称合法性
		$this->is_crname_exists();
		if($this->errorno == -1){
			return false;			
		}
		return true;
	}

	//前端域名校验
	public function domain_check(){
		$mobile = $this->input->post('mobile');
		$domain = $this->input->post('domain');
		$password = $this->input->post('password');
		if(empty($domain)){
			$this->_ret_msg(-1,'域名不能为空');
			return;
		}
		$domain = strtolower($domain);
		//获取禁止注册的域名配置
		$fdomain = Ebh::app()->getConfig()->load('fdomain');
		if(!empty($fdomain) && in_array($domain, $fdomain)){
			$this->_ret_msg(-1,'该域名不允许注册');
			return;
		}
		$username = $mobile;
		$classroomModel = $this->model('classroom');
		$roominfo = $classroomModel->getroomdetailbydomain($domain);
		/***不自动升级网校信息逻辑开始***/
		if(!empty($roominfo)){
			$this->_ret_msg(-1,'域名已存在');
		}else{
			$this->_ret_msg(0,'域名可用');
		}
		return;
		/***不自动升级网校信息逻辑结束***/


		/***自动升级网校信息逻辑开始[暂未启用]***/
		/***(教师可以通过创建网校页面修改网校信息高级逻辑O(∩_∩)O哈哈~)***/
		if(empty($username) && !empty($roominfo)){
			$this->_ret_msg(-1,'域名已存在，请输入手机号和密码继续验证该域名的所属权，验证成功可修改网校信息');
			return;
		}
		if(empty($roominfo)){
			$this->_ret_msg(0,'域名可用');
		}else{
			$crid = $roominfo['crid'];
			$roominfo = $classroomModel->getclassroomdetail($crid);
			if($roominfo['username']!=trim($username)){
				$this->_ret_msg(-1,'域名已存在，并且不属于当前用户');
			}else{
				if(empty($password)){
					$this->_ret_msg(-1,'域名属于当前用户，请输入密码继续验证该域名的所属权');
				}else{
					//获取用户信息
					$teacherModel = $this->model('Teacher');
					$teacherinfo = $teacherModel->getteacherbyusername($username);
					if(empty($teacherinfo)){
						$this->_ret_msg(-1,'域名已存在，当时所属者被删除了，您无法拥有此域名');
					}else if($teacherinfo['password'] == md5(trim($password))){
						$this->_ret_msg(0,'域名可用');
					}else{
						$this->_ret_msg(-1,'域名已存在，属于当前用户，但是密码验证失败，无法使用');
					}
				}
			}
		}
		/***自动升级网校信息逻辑结束***/
	}
	//用户信息获取
	private function _userinfo_get(){
		$realname = $this->input->post('realname');
		$password = $this->input->post('password');
		$mobile = $this->input->post('mobile');
		$username = $mobile;
		$dataline =SYSTIME;
		$param = array(
			'username'=>$mobile,
			'realname'=>$realname,
			'mobile'=>$mobile,
			'password'=>$password,
            'dateline'=>$dataline
		);
		return $this->_userinfo_check($param);
	}

	private function _userinfo_check($param = array()){
		//检测用户名是否存在
		return $param;
	}

	//教室信息获取
	private function _roominfo_get($teacherinfo){
		$expiry = 7;	//新注册网校默认有效期7天
		if(empty($teacherinfo) || empty($teacherinfo['uid']) ){
			$this->_ret_msg(-1,'用来生成教室的教师信息不完整');
		}
		$crname = $this->input->post('crname');
		$domain = $this->input->post('domain');
		$property = $this->input->post('property');
		$property = empty($property)?0:3;//网校版或企业版
		$domain = strtolower($domain);
		$status = 1;
		$uid = $teacherinfo['uid'];
		$param = array(
			'crname'=>$crname,
			'domain'=>$domain,
			'status'=>$status,
			'uid'=>$uid,
			'ctype'=>1,
			'isschool'=>7,
			//'template'=>'drag',
            'template' => 'plate',
			'begindate'=>SYSTIME,
			'enddate'=>SYSTIME+86400*$expiry,
			'iscollege'=>1,
			'property'=>$property,
			'cface'=>$property==3?'http://static.ebanhui.com/ebh/tpl/newschoolindex/images/com_logo.jpg':'http://static.ebanhui.com/ebh/tpl/2012/images/face/2.jpg'
		);
		return $this->_roominfo_check($param);
	}

	private function _roominfo_check($param = array()){
		return $param;
	}

	//增加用户，如果有则返回用户信息
	private function _teacher_add(){
		//获取post用户信息
		$param = $this->_userinfo_get();

		$teacherModel = $this->model('Teacher');
		$teacherinfo = $teacherModel->getteacherbyusername($param['username']);

		if(empty($teacherinfo)){//用户信息和老师信息同时不存在
			$uid = $teacherModel->addteacher($param);
			Ebh::app()->lib('xNums')->add('user');
        	Ebh::app()->lib('xNums')->add('teacher');
		}else{//存在用户信息
			//校验密码
			if($teacherinfo['password']!= md5($param['password'])){
				$this->_ret_msg(-1,'用户已经存在，但是密码和当前用户输入的密码不匹配');
			}
			if(empty($teacherinfo['teacherid'])){//用户信息存在但是教师信息不存在则修改教师信息
				$res = $teacherModel->editteacher($teacherinfo);
				if(empty($res)){
					$this->_ret_msg(-1,'升级教师信息失败');
				}
				$uid = $teacherinfo['uid'];
				//单独生成教师信息
			}else{//用户信息和教师信息完整
				$uid = $teacherinfo['uid'];
			}
		}
		if(empty($uid)){
			$this->_ret_msg(-1,'教师信息生成失败');
		}
		$param['uid'] = $uid;
		return $param;
	}

	//为指定的教师添加教室
	private function _room_add($teacherinfo = array()){
		$param = $this->_roominfo_get($teacherinfo);
		$classroomModel = $this->model('Classroom');

		$roominfo = $classroomModel->getroomdetailbydomain($param['domain']);
		if(!empty($roominfo)){
			if( $roominfo['uid']!=$teacherinfo['uid'] ){
				$this->_ret_msg(-1,'教室已经存在，但是您不是该学校的创建者!');		
			}else{
				//升级教室信息
				$param['crid'] = $roominfo['crid'];
				$res = $classroomModel->editclassroom($param);
				if(empty($res)){
					$this->_ret_msg(-1,'升级已存在教室信息失败');
				}

				//更新SNS学校信息缓存
				EBh::app()->lib('Sns')->updateClassRooomCache(array('crid'=>$param['crid'],'domain'=>$param['domain'],'crname'=>$param['crname'],'cface'=>$param['cface']));

				return $param;
			}
		}
        if (!isset($param['profitratio']) && isset($param['isschool']) && $param['isschool'] == 7) {
            //设置分层学校默认比例
            $profitratio = array(
                'company' => 30,
                'agent' => 0,
                'teacher' => 70
            );
            $param['profitratio'] = serialize($profitratio);
        }
		$crid = $classroomModel->addclassroom($param);
		if(empty($crid)){
			$this->_ret_msg(-1,'教室生成失败!');
		}
		$param['crid'] = $crid;
		//更新SNS学校信息缓存
		EBh::app()->lib('Sns')->updateClassRooomCache(array('crid'=>$param['crid'],'domain'=>$param['domain'],'crname'=>$param['crname'],'cface'=>$param['cface']));
		Ebh::app()->lib('xNums')->add('room');
		return $param;
	}

	//把教师添加到教室里去
	private function _roomteacher_add($crid,$teacherinfo){
		$teacherModel = $this->model('Teacher');
		$param = array(
			'crid'=>$crid,
			'tid'=>$teacherinfo['uid'],
			'status'=>1,
			'role'=>2
		);
		$isTeacherHasInRoom = $teacherModel->isTeacherHasInRoom($param['tid'],$crid);
		if($isTeacherHasInRoom){
			return true;
		}
		$res = $teacherModel->addroomteacher($param);
		return true;
	}

	//信息反馈
	private function _ret_msg($status,$msg,$attr = array()){
		if($this->inner_check == true){
			$this->errorno = $status;
			$this->errormsg = $msg;
		}else{
			echo json_encode(array(
				'status'=>$status,
				'msg'=>$msg,
				'attr'=>$attr
			));
			exit;
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
    private function _synplate($scrid, $dcrid, $uid) {
        $lib = Ebh::app()->lib('RoomCpy');
        $param = array(
            'scrid'=>$scrid,
            'dcrid'=>$dcrid,
            'uid'=>$uid
        );
        $lib->config($param)->docopy(true);
    }
	//从模板网校拷贝数据到新开通的网校
	private function _syncroom($scrid = 0,$dcrid = 0,$uid = 0){
		$lib = Ebh::app()->lib('RoomCpy');
    	$param = array(
    		'scrid'=>$scrid,
    		'dcrid'=>$dcrid,
    		'uid'=>$uid
    	);
    	$lib->config($param)->docopy();
	}

	//注册成功之后发送短信到手机
	private function _sendmsg_after_createroom_success($param = array()){
		$mobile = $param['mobile'];
		$msg = '恭喜您，您已成为 '.$param['crname'].' 网络学校校长，地址 http://'.$param['domain'].'.ebh.net，管理员 '.$mobile.',密码 '.$param['password'].' ,请牢记。';
		//外网的 才发短信 局域网屏蔽短信通知
		if($this->_checkLocalNet()==false){
		     Ebh::app()->lib('SMS')->send($mobile,$msg);
		}
		//通知后勤人员(手机短信+邮箱)
		$fromip = Ebh::app()->getInput()->getip();
		$IPObj = Ebh::app()->lib('IPaddress');//查找ip所在区域
		$address = $IPObj ->find($fromip);
		$ucity = '其他';
		$province = $address['1'];
		$city = $address['2'];
		if(!empty($province) || !empty($city)){
			if(!empty($city)){
				if($province != $city){
					$ucity = $province.$city;
				}else{
					$ucity = $province;
				}
			}else{
				$ucity = !empty($province) ? $province : '其他';
			}
				
		}
		$sparam = array(
				'name'=>$param['crname'],
				'code'=>$param['domain'],
				'ucode'=>$mobile,
				'realname'=>$param['realname'],
				'ucity'=>$ucity,
				'fromip'=>$fromip
			);
		Ebh::app()->lib('SNotify')->run($sparam);

	}

//	//判断手机号码是否在黑名单  //黑名单注释
//	private function _isInBlack($tel = 0){
//		$this->apiServer = Ebh::app()->getApiServer('ebh');
//		//从缓存获取黑名单  不存在缓存则查询 并设置缓存
//		$redis = Ebh::app()->getCache('cache_redis');
//		$redis_key = 'createroom_blacks';
//		$blacklist = $redis->hget($redis_key);
//
//		if (empty($blacklist)){
//			$blacks = $this->apiServer->reSetting()
//			    ->setService('Adminv2.Black.getCreateroomBlack')
//	            ->request();
//	         $blacklist = array();
//	         foreach($blacks as $black){
//	         	$blacklist[] = $black['mobile'];
//	         }
//			$redis->hMset($redis_key, $blacklist);
//		}
//		return in_array($tel, $blacklist);
//	}
	
	private function _beforecreate(){
		if($this->_inner_check()){
			$this->sms_check();
			if($this->errorno == -1){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
	/**
	 * 验证是否是局域网
	 */
	private function _checkLocalNet($ip=null){
	    $check = false;
	    $ckip = !empty($ip) ? $ip:getip();
	    if(in_array(strtok($ckip, '.'), array('10', '127', '168', '192'))){
	        $check = true;
	    }
	    return $check;
	}
	//默认APP
	private function defaultapp($crid){
		$applist[0]['img'] = 'http://img.ebanhui.com/ebh/2015/11/24/14483495643740.png';
		$applist[0]['title'] = '网络学校电视版下载';
		$applist[0]['url'] = 'http://soft.ebh.net/ebh_tv.apk';
		
		$applist[1]['img'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/app_jiazhang.png';
		$applist[1]['title'] = '家长监控平台';
		$applist[1]['url'] = 'http://jiazhang.ebh.net';
		
		$applist[2]['img'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/app_suoping.png';
		$applist[2]['title'] = '锁屏浏览器';
		$applist[2]['url'] = 'http://soft.ebh.net/ebhbrowser.exe';
		
		$applist[3]['img'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/app_app.png';
		$applist[3]['title'] = 'APP应用';
		$applist[3]['url'] = '/intro/app.html';
		
		$appstr = serialize($applist);
		$crmodel = $this->model('classroom');
		$crmodel->editcustommessage(array('crid'=>$crid,'index'=>1,'appstr'=>$appstr));
	}
	//默认设置appmodule（主要加上直播功能+云盘+活动）
	private function _defaultAppModule($crid) {
		$modulelist = array('1','2','5','6','9','12','13','14','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');//后续策略需要改变
		//学生端：主页-学习-我的作业-问题-互动课堂-空间-云盘-选课系统-活动-学分统计-体质健康-更多
		$slist = array(1,2,22,5,23,6,9,19,13,21,20,24);
		//教师端：主页-授课管理-布置作业-互动答疑-我的题库-互动课堂-数据中心-调查问卷-微校通—云盘--选课系统-体质健康-我的空间
		$tlist = array(1,2,22,5,31,23,18,14,17,9,19,20,6);
		$ammodel = $this->model('appmodule');
		$aresult = $ammodel->defaultmodule(array('crid'=>$crid,'modulelist'=>$modulelist,'slist'=>$slist,'tlist'=>$tlist));
		if(!$aresult) {
			log_message("新注册注入直播信息失败");
		}
	}

	/**
	 * 注册网校成功 绑定手机
	 */
	protected function _bindMobile($uid,$mobile){
		//向ebh_binds表插入绑定数据
		$bindmodel = $this->model('Bind');
		$binddata = array(
			'uid'=>$uid,
			'is_mobile'=>1,
		    'mobile'=>$mobile,
			'mobile_str'=>json_encode(
					array('mobile'=>$mobile,
							'uid'=>$uid,
							'dateline'=>SYSTIME
						)
				)		
		);
		$bindmodel->doBind($binddata,$uid);
	}
}