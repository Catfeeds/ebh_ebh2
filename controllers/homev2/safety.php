<?php
/**
 * 安全设置
 * @author eker
 * 2016年3月1日16:49:38
 */
class SafetyController extends CControl {
	private $user = null;
	public function __construct(){
		parent::__construct();
		
		//邮箱回调验证 不检测用户信息
		if($this->uri->uri_method() !='checkmail'){
			$this->user = Ebh::app()->user->getloginuser();
			Ebh::app()->user->checkUserLogin($this->user ,true);
			$this->assign('user',$this->user);
			$this->getassigintop();
		}

	}
	
	/**
	 * 绑定页
	 */
	public function index(){
		
		//隐藏顶部信息
		$hidetop = $this->input->get('ht');
		if(!empty($hidetop))
			$this->assign('hidetop',$hidetop);
		$bdmodel = $this->model("Bind");
		$bind = $bdmodel->getUserBInd($this->user['uid']);
		$this->assign('bind',$bind);
		
		$callback = $this->input->get('callback');
		if(!empty($callback)&&($callback=='bind_success')){
			//先禁止跳转
			$this->display("homev2/safety_bind_success");
			exit();
		} 
		$this->display("homev2/safety_index");
	}

	/**
	 * 绑定处理
	 */
	public function bind(){
		//隐藏顶部信息
		$hidetop = $this->input->get('ht');
		if(!empty($hidetop))
		$this->assign('hidetop',$hidetop);
	
		$request = $this->input->get();
		$this->assign('request',$request);
		if($request['type']=='mobile'){
			$this->display("homev2/safety_mobile");
		}elseif($request['type']=='email'){
			$this->display("homev2/safety_email");
		}
	}
	
	/**
	 * 解绑处理
	 */
	public function unbind(){
		$request = $this->input->post();
		$arr = array("status"=>0,'msg'=>'');
		$bdmodel = $this->model("Bind");
		if($request['type']=='qq'){//qq解绑
			$ck = $bdmodel->doUnbind('qq',$this->user['uid']);
			$arr['status'] = empty($ck) ? 0 : 1;
			$arr['msg'] = empty($ck) ? '解绑失败,请刷新后再试': '';
		}elseif($request['type']=='wx'){//微信解绑
			$ck = $bdmodel->doUnbind('wx',$this->user['uid']);
			$arr['status'] = empty($ck) ? 0 : 1;
			$arr['msg'] = empty($ck) ? '解绑失败,请刷新后再试': '';
		}elseif($request['type']=='weibo'){//微博解绑
			$ck = $bdmodel->doUnbind('weibo',$this->user['uid']);
			$arr['status'] = empty($ck) ? 0 : 1;
			$arr['msg'] = empty($ck) ? '解绑失败,请刷新后再试': '';
		}
		echo json_encode($arr);
	}
	
	/**
	 * 支付密码
	 */
	public function paypass(){
		
			//隐藏顶部信息
		$hidetop = $this->input->get('ht');
		if(!empty($hidetop))
			$this->assign('hidetop',$hidetop);
		$request = $this->input->get();
		$bdmodel = $this->model("Bind");
		if(!empty($request['op'])&&($request['op']=="bind")){
			$this->display("homev2/safety_paypass_bind");
		}elseif(!empty($request['op'])&&($request['op']=="checkuserpwd")){
			//验证支付密码与用户密码
			$password = trim($request['password']);
			$ckppwd = $bdmodel->checksameuserpwd($this->user['uid'],$password);
			echo json_encode(array('code'=>$ckppwd));
		}elseif(!empty($request['op'])&&($request['op']=="save")){
			//保存支付密码
			$password = trim($request['password']);
			$level = intval($request['level']);
			$ckppwd = $bdmodel->bindPaypwd($password,$level,$this->user['uid']);
			echo json_encode(array('code'=>empty($ckppwd)?0:1));
		}elseif(!empty($request['op'])&&($request['op']=="edit")){
			//设置支付密码
			$bind = $bdmodel->getUserBInd($this->user['uid']);
			$this->assign('bind',$bind);
			$this->display("homev2/safety_paypass_edit");
		}elseif(!empty($request['op'])&&($request['op']=="checkoldpaypwd")){
			//验证旧的支付密码
			$oldpaypwd = trim($request['oldpaypwd']);
			$ckoldpwd = $bdmodel->checkoldpaypwd($oldpaypwd,$this->user['uid']);
			echo json_encode(array('code'=>empty($ckoldpwd)?0:1));
		}elseif(!empty($request['op'])&&($request['op']=="save_edit")){
			//替换新的支付密码
			$oldpaypwd = trim($request['oldpaypwd']);
			$password = trim($request['password']);
			$level = intval($request['level']);
			if($oldpaypwd == $password){
				echo json_encode(array('code'=>0,'msg'=>'新的支付密码与旧的支付密码相同'));
				exit(0);
			}elseif($bdmodel->checkoldpaypwd($oldpaypwd,$this->user['uid'])==false){
				echo json_encode(array('code'=>0,'msg'=>'旧的支付密码验证错误'));
				exit(0);
			}elseif($bdmodel->checksameuserpwd($this->user['uid'],$password)==true){
				echo json_encode(array('code'=>0,'msg'=>'旧的支付密码与用户密码相同'));
				exit(0);
			}else{
				$ckppwd = $bdmodel->bindPaypwd($password,$level,$this->user['uid']);
				echo json_encode(array('code'=>empty($ckppwd)?0:1));
			}
		}elseif(!empty($request['op'])&&($request['op']=="forget")){
			$bind = $bdmodel->getUserBInd($this->user['uid']);
			$this->assign('bind',$bind);
			$this->display("homev2/safety_paypass_forget");
		}elseif(!empty($request['op'])&&($request['op']=="checkmobilebind")){
			$bind = $bdmodel->getUserBInd($this->user['uid']);
			echo json_encode(array('code'=>empty($bind['is_mobile'])?0:1));
		}else{
			$bind = $bdmodel->getUserBInd($this->user['uid']);
			$this->assign('bind',$bind);
			$this->display("homev2/safety_paypass");
		}

	}

	/**
	 * 获取top信息
	 */
	public function getassigintop(){
		$user = $this->user;
		//uri
		$this->assign('controller',$this->uri->uri_control());
		$this->assign('action',$this->uri->uri_method());
        $clinfo = array();
        $clinfo['title']='';
		if($user['groupid']==5){//老师
			//积分等级
			$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
			foreach($clconfig as $clevel){
				if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
					$clinfo['title'] = $clevel['title'];
					if($user['credit']<=500){
						$clinfo['percent'] = 50*intval($user['credit'])/500;
					}elseif($user['credit']<=3000){
						$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
					}elseif($user['credit']<=10000){
						$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
					}else{
						$clinfo['percent'] = 100;
					}
					break;
				}
			}
		}elseif($user['groupid']==6){//学生
			//积分等级
			$clconfig = Ebh::app()->getConfig()->load('creditlevel');
			foreach($clconfig as $clevel){
				if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
					$clinfo['title'] = $clevel['title'];
					if($user['credit']<=500){
						$clinfo['percent'] = 50*intval($user['credit'])/500;
					}elseif($user['credit']<=3000){
						$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
					}elseif($user['credit']<=10000){
						$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
					}else{
						$clinfo['percent'] = 100;
					}
					break;
				}
			}
		}
		$this->assign('clinfo',$clinfo);
		//完成度百分比
		$percent = Ebh::app()->user->getpercent($this->user);
		$this->assign('percent',$percent);
		 
		//粉丝
		$snsmodel = $this->model('Snsbase');
		$mybaseinfo = $snsmodel->getbaseinfo($this->user['uid']);
		$myfanscount = max(0,$mybaseinfo['fansnum']);
		//关注
		$myfavoritcount = max(0,$mybaseinfo['followsnum']);
		$this->assign('myfanscount',$myfanscount);
		$this->assign('myfavoritcount',$myfavoritcount);
	}
	
	
	/**
	 * 发送邮件
	 */
	public function sendmsg(){
		$user = $this->user;
		$post = $this->input->post();
		$email = trim($post['email']);
		
		//邮箱验证 是否已绑定了
		$bdmodel = $this->model("Bind");
		$ckexist = $bdmodel->checkemail($email);
		if($ckexist){
			echo json_encode(array('status'=>1,'msg'=>'该邮箱已绑定,请换一个邮箱试试'));
			exit(0);
		}
		
		$emailer = Ebh::app()->lib('EBHMailer');
		$toarr = array('email'=>$email,'username'=>$user['username']);
		$subject = "e板会-邮箱验证";
		$message = $this->getEmailBIndTpl($email);
		$retarr = $emailer->sendMessage($toarr,$subject,$message);
		if($retarr['status']==1){
			$retarr['msg'] = '邮件发送失败,请刷新后重试';
		}
		echo json_encode($retarr);
	}
	
	/**
	 * 验证邮件
	 */
	public function checkmail(){
		header("Content-type:text/html;charset=utf-8");
		$codekey = $this->input->get('codekey');
		$codekey = str_ireplace('+', '%2B', $codekey);
		$codekey = urldecode($codekey);
		//var_dump(explode('\t',authcode($codekey, 'DECODE')));
		$info = array('code'=>0,'msg'=>'');
		
		@list($uid,$email,$dateline) = explode('\t',authcode($codekey, 'DECODE'));
		if(empty($codekey)||empty($uid)||empty($email)||empty($dateline)){
			//验证失败
			$info['code']=0;
			$info['msg']= '验证失败,codekey 错误';
		}else{
			//验证是否过期 时效 24h
			if($dateline+3600*24<SYSTIME){
				//失效
				$info['code']=0;
				$info['msg']= '验证失败,连接失效';
			}else{
				//获取用户信息
				$user = $this->model('User')->getuserbyuid($uid);
				//绑定
				$chflag = $this->_dobind('email', $email,$user);
								
				if(!empty($chflag)){
					//绑定成功
					$info['code']=1;
					$info['msg']= '绑定成功';
				}else{
					//绑定失败
					$info['code']=1;
					$info['msg']= '绑定失败';
				}
			}
		}
		
		$this->assign('info', $info);
		$this->display("homev2/safety_email_check");
	}
	/**
	 * 绑定银行卡
	 */
	public function bindbank(){
		$tdata = $this->input->post('data');
		$khname = trim($tdata['khname']);
		$yhaccount = trim($tdata['yhaccount']);
		$yhnameindex = intval($tdata['yhname']);
		if(empty($khname) || empty($yhaccount) || $yhnameindex <=0 || $yhnameindex >10){
			echo json_encode(array('code'=>-1));
			exit;
		}
		$data['bindex'] = $yhnameindex;
		$data['account'] = $yhaccount;
		$data['khname'] = $khname;
		$bindflag = $this->_dobind('bank',array(0=>$data));
		echo json_encode(array('code'=> $bindflag >0 ? 1 : $bindflag));	
	}
	/**
	 * 解绑银行卡
	 */
	public function unbindbank(){
		$user =$this->user;
		$data = trim($this->input->post('data'));
		if(empty($data)){
			echo json_encode(array('code'=>-1));
			exit;
		}
		$bdmodel = $this->model("Bind");
		$obank = $bdmodel->getUserBankInfo($user['uid']);
		$tmpbank = json_decode($obank['bank_str'],true);
		if(empty($tmpbank['bank'])){
			echo json_encode(array('code'=>-2));
			exit;
		}
		$nbank = array();
		$postarr = explode('#', $data);
		foreach ($tmpbank['bank'] as $val){
			if($val['bindex'] == $postarr[0] && $val['khname'] == $postarr[1] && $val['account'] == $postarr[2]){
				continue;
			}
			$nbank[] = array('bindex'=>$val['bindex'],'account'=>$val['account'],'khname'=>$val['khname']);
		}
		$is_bank = count($nbank) > 0 ? 1 : 0;
		$bankstr = count($nbank) > 0 ? json_encode(array('uid'=>$user['uid'],'dateline'=>SYSTIME,'bank'=>$nbank)) : '';
		$setarr['is_bank'] = $is_bank;
		$setarr['bank_str'] = $bankstr;
		$result = $bdmodel->update($setarr,$user['uid']);
		echo json_encode(array('code'=>$result));
	}
	
	
	/**
	 * 绑定处理
	 * $type mobile->手机号  email->邮箱
	 */
	private function _dobind($type,$data,$user=NULL){
		$retflag = false;
		if(empty($user)){
			$user =$this->user;
		}
		$bdmodel = $this->model("Bind");
		$member = $this->model('Member');
		$usermodel = $this->model('user');
		if($type=='mobile'){
			$bdata =array(
			'uid'=>$user['uid'],
			'is_mobile'=>1,
		    'mobile'=>$data,
			'mobile_str'=>json_encode(
					array('mobile'=>$data,
							'uid'=>$user['uid'],
							'dateline'=>SYSTIME
						)
				)		
			);
			$retflag = $bdmodel->doBind($bdata,$user['uid']);
			
			//更新主表mobile字段
			if(!empty($retflag)){
				$member->editmember(array('mobile'=>$data,'uid'=>$user['uid']));
			}
		}elseif($type=='email'){
			$bdata =array(
					'uid'=>$user['uid'],
					'is_email'=>1,
					'email_str'=>json_encode(
							array('email'=>$data,
									'uid'=>$user['uid'],
									'dateline'=>SYSTIME
							)
					)
			);
			$retflag = $bdmodel->doBind($bdata,$user['uid']);
			
			//更新主表email字段
			if(!empty($retflag)){
				$member->editmember(array('email'=>$data,'uid'=>$user['uid']));
			}
			
		}elseif($type=='bank'){
			$bdata =array(
					'uid'=>$user['uid'],
					'is_bank'=>1,
					'bank_str'=>json_encode(
							array('bank'=>$data,
									'uid'=>$user['uid'],
									'dateline'=>SYSTIME
							)
					)
			);
			$retflag = $bdmodel->bindBank($bdata,$user['uid']);
		}
		return $retflag;
	}
	
	/**
	 * 获取短信验证模板
	 */
	public function getEmailBIndTpl($email){
		$username = $this->user['username'];
		$href = $this->_getauthorurl($email);
		$viewpath = VIEW_PATH.'homev2/safety_email_msg_tpl.php';
		$view_vars['username'] = $username;
		$view_vars['email'] = $email;
		$view_vars['href'] = $href;
		
		ob_start();
		extract($view_vars);
		include $viewpath;
		$outputstr = ob_get_contents();
		@ob_end_clean();
		//echo $outputstr;
		return  $outputstr;
	}
	
	/**
	 * 获取验证url
	 * @param unknown $email
	 * @return string
	 */
	private function _getauthorurl($email){
		$uid = $this->user['uid'];
		$dateline = SYSTIME;
		$url = "http://www.ebh.net/homev2/safety/checkmail.html?codekey=";
		$codekey = urlencode(authcode($uid.'\t'.$email.'\t'.$dateline, 'ENCODE'));
		$url.=$codekey;
		log_message("$uid\t$email\t$dateline");
		log_message($url);
		return $url;
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
		$bdmodel =  $this->model("Bind");
		$check= @ $this->input->post('check');
		$check  = ($check == 'true')? true : false;
		$ckexist = $bdmodel->checkmobile($mobile);
		
		if($ckexist && $check){
			$this->_ret_msg(-1,'该手机号已绑定,请换一个手机号试试');
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
		@list($uid,$mobile,$ip) = explode('\t', $str);
		if(empty($mobile) || empty($uid) || empty($ip)){
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
			$curuid = $this->user['uid'];
			if($curuid!=$uid){
				$this->_ret_msg(-1,'用户信息被篡改，校验失败');
				return;
			}
			
			//开始绑定操作
			$ck = $this->_dobind('mobile',$mobile);
			if(!empty($ck)){
				$this->_ret_msg(0,'短信校验成功');
			}else{
				$this->_ret_msg(-1,'绑定失败,请刷新后重新试');
			}
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
		$uid = $this->user['uid'];
		$mobile = trim($this->input->post('mobile'));
		$ip = $this->input->getip();
		$str = $uid.'\t'.$mobile.'\t'.$ip;
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