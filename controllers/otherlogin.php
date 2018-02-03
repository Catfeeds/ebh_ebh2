<?php
/**
 * 开发平台登录并绑定
 * qq,sina(weibo),wx
 * 
 * @author eker
 * @email qq704855854@126.com
 */
class OtherloginController extends CControl{

	/**
	 * QQ登录
	 * 
	 */
	public function qq(){
		$oauth = Ebh::app()->getConfig()->load('oauth');
		$appid    = $oauth['qq']['appid']; 
		$appkey   = $oauth['qq']['appkey'];
		$redirect_uri = $oauth['qq']['redirect_uri'];
		
		$state= md5(uniqid(rand(), TRUE)); //存储backurl的键
		$backurl = '';//用于返回网站操作登录前的那个地址
		$type = $this->input->get('type');//标识pc/wap端 默认pc
		$type = !empty($type) ? $type : 'pc'; 
		
		$scope = "get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo";
		$returnurl = $this->input->get('returnurl');
		if(!empty($returnurl)){
			$backurl = $returnurl;
		}else{
			$server_host = $this->uri->uri_domain();
			$server_host =empty($server_host)? 'www' : $server_host;
			$backurl = 'http://'.$server_host.'.'.$this->uri->curdomain;
		}
		//缓存数据
		$cacahe_data = array('backurl'=>$backurl,'type'=>$type);
		$this->cache->set($state,serialize($cacahe_data),60);//缓存在cache中 便于回调
	    
	    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
			        . $appid . "&redirect_uri=" . urlencode($redirect_uri)
			        . "&state=" . $state
			        . "&scope=".$scope;
	    header("Location:$login_url");
	}
	
	/**
	 * QQ回调
	 */
	public function qq_callback(){
		//QQ配置
		$oauth = Ebh::app()->getConfig()->load('oauth');
		$appid = $oauth['qq']['appid'];
		$appkey = $oauth['qq']['appkey'];
		$redirect_uri = $oauth['qq']['redirect_uri'];
		
		
		$state = Ebh::app()->getInput()->get('state');
		$code = Ebh::app()->getInput()->get('code');
		$cacahe_data = $this->cache->get($state);
		
		//缓存backurl和type标识 type为pc/wap
		$backurl = '';
		$type = '';
		
		if(!empty($cacahe_data)){
			$cacahe_data = unserialize($cacahe_data);
			$backurl = $cacahe_data['backurl'];
			$type = $cacahe_data['type'];
		}

		if( (!empty($state)&&!empty($backurl))){ 
			//1.获取token
			$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
						. "client_id=" . $appid . "&redirect_uri=" . urlencode($redirect_uri)
						. "&client_secret=" . $appkey. "&code=" . $code;
	
			$response = $this->get_url_contents($token_url);
			if (strpos($response, "callback") !== false){
				//授权失败 在请求一次
				header("Location:/otherlogin/qq.html?returnurl=".$backurl."&type=".$type);
				exit(0);
				//授权失败 输出错误信息 结束程序
				//$this->show_qq_error($response,true);
			}

			$params = array();
			parse_str($response, $params);
			$access_token = $params["access_token"];
			
			//2.依据token 获取openid
			$graph_url = "https://graph.qq.com/oauth2.0/me?access_token=". $access_token;
			$meResponse  = $this->get_url_contents($graph_url);
			
			if(strpos($meResponse, "callback" ) !== false){
				$lpos  =  strpos ( $meResponse ,  "(" );
				$rpos  =  strrpos ( $meResponse ,  ")" );
				$meResponseStr   =  substr ( $meResponse ,  $lpos + 1,  $rpos - $lpos -1);
			}
			if (empty($meResponseStr)) {
				//验证失败 重新请求
				header("Location:/otherlogin/qq.html?returnurl=".$backurl."&type=".$type);
				exit(0);
			}
			$userJson  = json_decode( $meResponseStr );
			if (empty($userJson)) {
				//验证失败 重新请求
				header("Location:/otherlogin/qq.html?returnurl=".$backurl."&type=".$type);
				exit(0);
			}
			$openid = $userJson->openid;
			//var_dump($userJson);exit;

			if (isset($userJson->error)||empty($openid)){
				//验证失败 重新请求
				header("Location:/otherlogin/qq.html?returnurl=".$backurl."&type=".$type);
				exit(0);
				//获取失败 输出错误信息 结束程序
				//$this->show_qq_error($userJson,false);
			}else{
				
				//3.验证用户是否授权 已经授权 直接登录 未授权绑定
				$usermodel = $this->model('user');
				$userinfo = $usermodel->openlogin($openid,'qq');
			}

			if($userinfo==false){
				//4.依据token 获取用户信息
				$get_user_info = "https://graph.qq.com/user/get_user_info?"
								. "access_token=" . $access_token
								. "&oauth_consumer_key=" . $appid
								. "&openid=" .$openid
								. "&format=json";
				
				$infoResponse = $this->get_url_contents($get_user_info);
				$userArr = json_decode($infoResponse, true);
				$sex = ($userArr['gender']=='男') ? 0 : 1;
				
				if(isset($userArr->ret)&&intval($userArr->ret)>0){
					//输出错误信息
					echo 'ERROR:get_user_info error...,MSG : '.$userArr['msg'];
				}
				$ulogo = !empty($userArr['figureurl_qq_2']) ? $userArr['figureurl_qq_2'] : $userArr['figureurl_qq_1']  ;
				$uname = $userArr['nickname'];
				
				//wap端过来的 跳转到wap绑定页面
				if($type=='wap'){
					$userData = array(
						'openid'=>$openid,
						'nickname'=>$uname,
						'sex'=>$sex,
					);
					//创建绑定key
					$bindkey = $this->getBindKey($userData, 'qq');
					$wap_openbind_url = 'http://wap.ebh.net/openbind.html?k='.urlencode($bindkey);
					header("location:$wap_openbind_url");
					exit();
				}
				
				//弹窗绑定 --个人信息-安全设置-直接绑定
				if(preg_match("/callback=bind_success/", $backurl)){
					$this->popup_callback('qq',$backurl,$openid,$uname);
					exit();
				}
				
				//pc端 让用户自己选择绑定方式:创建新用户/绑定已有账号
				
				$this->assign('openid',$openid);
				$this->assign('uname',$uname);
				$this->assign('ulogo',$ulogo);
				$this->assign('state',$state);
				$this->assign('sex',$sex);
				$this->assign('type','qq');
				$this->display('common/open_bind');
			}else{
				//弹窗绑定 --个人信息-安全设置-直接绑定
				if(preg_match("/callback=bind_success/", $backurl)){
					$this->popup_callback('qq',$backurl,$openid,'');
					exit(0);
				}
				//wap端过来的 直接创建新账号
				if($type=='wap'){
					//创建登录key
					$loginkey = $this->getKey($userinfo);
					$wap_login_href = $backurl."?k=".urlencode($loginkey);
					header("location:$wap_login_href");
					exit(0);
				}
				//pc端 直接登录
				$this->login($userinfo,$backurl);
			}
		}
		else
		{
			//验证失败,重新跳转到授权页
			header("Location:/otherlogin/qq.html");
			exit;
		}

	}
		
	
	/**
	 * 微博授权
	 */
	public function sina(){	
		//微博配置
		$oauth = Ebh::app()->getConfig()->load('oauth');
		$appkey    = $oauth['sina']['appkey']; 
		$appsecret   = $oauth['sina']['appsecret']; 
		$redirect_uri = $oauth['sina']['redirect_uri'];
		
		$state= md5(uniqid(rand(), TRUE)); //存储backurl的键
		$backurl = '';//用于返回网站操作登录前的那个地址
		$type = @ $this->input->get('type');//标识pc/wap端 默认pc
		$type = !empty($type) ? $type : 'pc';
		
		$server_host = $this->uri->uri_domain();
		$server_host = empty($server_host) ? 'www' : $server_host;
		$backurl = 'http://'.$server_host.'.'.$this->uri->curdomain;
		$returnurl = $this->input->get('returnurl');
		$backurl = !empty($returnurl) ? $returnurl : $backurl;
		
		//缓存backurl type
		$cache_data = array('backurl'=>$backurl,'type'=>$type);
	    $this->cache->set($state,serialize($cache_data),60);
	    
	    $auth_url = "https://api.weibo.com/oauth2/authorize?client_id="
	    		.$appkey."&redirect_uri=".urlencode($redirect_uri)."&scope=all"
	    		."&state=".$state."&response_type=code";
		header('Location:'.$auth_url);
	}
	

	/**
	 * 微博授权回调
	 */
	public function sina_callback(){
		$oauth = Ebh::app()->getConfig()->load('oauth');
		$appkey    = $oauth['sina']['appkey'];
		$appsecret   = $oauth['sina']['appsecret'];
		$redirect_uri = $oauth['sina']['redirect_uri'];
		
		$type = 'pc';//终端标识
		$backurl = '/';//返回地址
		
		$state = $this->input->get('state');
		$cache_data = $this->cache->get($state);
		if(!empty($cache_data)){
			$cache_data = unserialize($cache_data);
			$type = $cache_data['type'];
			$backurl = $cache_data['backurl'];
		}

		$code = $this->input->get('code');
		//获取token
		$get_token_url= "https://api.weibo.com/oauth2/access_token?client_id=$appkey&client_secret=$appsecret&grant_type=authorization_code&code=$code&redirect_uri=".urldecode($redirect_uri)."";
		$returnObj = $this->get_post_contents($get_token_url);
		$tokenJson = json_decode($returnObj,true);
		$token = $tokenJson['access_token'];
		if(!empty($token)){
			//获取授权信息
			$get_info_url = "https://api.weibo.com/oauth2/get_token_info?access_token=$token";
			$userObj = $this->get_post_contents($get_info_url);
			$userJson = json_decode($returnObj,true);
			$openid = $userJson['uid'];
			
			//验证是否已经绑定
			$usermodel = $this->model('user');
			$userinfo = $usermodel->openlogin($openid,'sina');
			if($userinfo==false){
				//获取用户详细信息
				$get_userinfo_url = "https://api.weibo.com/2/users/show.json?access_token=$token&uid=$openid";
				$fenObj = $this->get_url_contents($get_userinfo_url);
				$feninfo = json_decode($fenObj);

				//wap端过来的 跳转到wap绑定页面
				if($type=='wap'){
					$userData = array(
							'openid'=>$openid,
							'nickname'=>$feninfo->name,
							'sex'=>($feninfo->gender == 'f')?1:0,
					);
					//创建绑定key
					$bindkey = $this->getBindKey($userData, 'sina');
					$wap_openbind_url = 'http://wap.ebh.net/openbind.html?k='.urlencode($bindkey);
					header("location:$wap_openbind_url");
					exit();
				}
				
				//弹窗绑定 --个人信息-安全设置-直接绑定
				if(preg_match("/callback=bind_success/", $backurl)){
					$this->popup_callback('sina', $backurl, $openid, $feninfo->name);
					exit();
				}
				
				//pc端 让用户自己选择绑定方式:创建新用户/绑定已有账号
				$sex = ($feninfo->gender == 'f')?1:0;
				$this->assign('uname',$feninfo->name);
				$this->assign('ulogo',$feninfo->avatar_large);
				$this->assign('face',$feninfo->avatar_large);
				$this->assign('openid',$feninfo->id);
				$this->assign('sex',$sex);
				$this->assign('type','sina');
				$this->assign('state',$state);
				$this->display('common/open_bind');
			}else{
				//弹窗绑定 --个人信息-安全设置-直接绑定
				if(preg_match("/callback=bind_success/", $backurl)){
					$this->popup_callback('sina', $backurl, $openid, '');
					exit(0);
				}
				//wap端过来的 直接创建新账号
				if($type=='wap'){
					//创建登录key
					$loginkey = $this->getKey($userinfo);
					$wap_login_href = $backurl."?k=".urlencode($loginkey);
					header("location:$wap_login_href");
					exit(0);
				}
				//绑定过 pc端 直接登录
				$this->login($userinfo,$backurl);
			}
		}else{
			$error = $this->input->get('error');
			$error = !empty($error)?$error : "";
			if($error=='access_denied'){
				//取消授权
				header("Location:$backurl");
			}else{
				header("Location:/otherlogin/sina.html?returnurl=".urlencode($backurl)."&type={$type}");
			}
			exit;
		}
	}
	


	/**
	 * 验证用户名 密码
	 * @param unknown $username
	 * @param unknown $password
	 * @param string $ajax
	 * @param string $type
	 * @param string $create
	 */
	function check($username='',$password='',$type='qq',$ajax=true,$create = true){
		$flag = false;
		$retArr = array('code'=>0,'msg'=>'验证失败!!!');
		if($ajax){
			$post =  $this->input->post();
			$username = !empty($post['username'])?$post['username']:"";
			$type = !empty($post['type'])?$post['type']:"";
			$password = !empty($post['password'])?$post['password']:'';
			$create = isset($post['create'])?(bool)$post['create']:true;
		}
		$usermodel = $this->model('user');
		$user = $usermodel->getAssociateInfoByUsername($username);
		
		if(!empty($user)){
			//验证账号是否存在
			if($create){
				$retArr = array('code'=>0,'msg'=>'对不起，帐号已经被注册！');
				$flag = false;
			}else{
				$retArr = array('code'=>1,'msg'=>'');
				$flag = true;
			}
		
			//验证账号+密码
			if(!empty($password) && $create==false){
				if(md5($password) != $user['password']){
					$retArr = array('code'=>0,'msg'=>'对不起，密码错误！');
					$flag = false;
				}else{
					//验证是否已经绑定
					$openid = 'qqopid';
					switch ($type){
						case 'qq':$openid='qqopid';
						break;
						case 'sina':$openid='sinaopid';
						break;
						case 'wx':$openid='wxunionid';
						break;
					}
					if(!empty($user[$openid])){
						$retArr = array('code'=>0,'msg'=>'对不起，该帐号已经关联，请输入其他帐号！');
						$flag = false;
					}else{
						$retArr = array('code'=>1,'msg'=>'');
						$flag = true;
					}
				}
			}
			
		}else{
			if($create){
				$retArr = array('code'=>1,'msg'=>'');
				$flag = true;
			}else{
				$retArr = array('code'=>0,'msg'=>'对不起，您输入的帐号不存在！');
				$flag = false;
			}
		}
		
		//返回消息
		if($ajax){
			echo json_encode($retArr);
		}else{
			return $flag;
		}
		
	}
	


	/**
	 * 账号绑定
	 * @author erker
	 */
	public function associate(){
		$post = $this->input->post();
		if(empty($post)){
			echo 'no post';
			exit;
		}
		$create = (bool)$post['create'];
		$username = h($post['username']);
		$password = h($post['password']);
		$type= h($post['type']);
		$openid = h($post['openid']);
		$unionid = !empty($post['unionid']) ? h($post['unionid']) : '';
		$state = h($post['state']);
		$sex = intval($post['sex']);
		$face = !empty($post['face']) ? h($post['face']): '';
		$nickname = h($post['nickname']);
		$token= h($post['token']);
		
		$member = $this->model('member');
		$usermodel = $this->model('user');

		//验证token
		if(checkToken($token)==false){
			echo 'TOKEN CHECK ERROR!!!';
			exit;
		}
		//验证账号长度
		if(strlen($username)<6 || strlen($username)>20 || !preg_match("/^[a-zA-Z][a-z0-9A-Z_]{5,19}$/",$username)){
			echo 'username not match 6~20!!!';
			exit;
		}
		if(strlen($password)<6 || strlen($password) > 16){
			echo 'password not match 6~16!!!';
			exit;
		}

		if($create==true){//创建新账号
			if($this->check($username,'',$type,false,true)){
				$param['username'] = $username;
				$param['password'] = $password;
				$param['realname'] = $nickname;//昵称 存在 姓名字段
				$param['dateline'] = SYSTIME;
				if($type == 'qq'){
					$param['qqopid'] = $openid;
				}elseif($type == 'wx'){
					$param['wxopenid'] = $openid;
					$param['wxunionid'] = $unionid;
					$param['sex'] = $sex;
				}elseif($type=='sina'){
					$param['sinaopid'] = $openid;
					$param['sex'] = $sex;
				}
				$uid = $member->addmember($param);

                //将注册信息记录到日志
                if ($uid>0 && !empty($type)){
                    $this->afterUserRegister($uid,$param);
                }
				if($uid>0){
					$cuser = array('uid'=>$uid);
					$data = array('openid'=>$openid,'unionid'=>$unionid,'nickname'=>$nickname);
					$this->dobind($type, $data, $cuser);
				}
                //微信注册后处理微信头像,生成缩略图并更新到用户数据库
                if($uid>0 && !empty($face)){
                    $this->afterWxRegister($uid,$face);
                }
			}else{
				echo '001.OPEN CREATE PARAM ERROR!!!';
				exit(0);
			}
			
		}else{//绑定账号
			if($this->check($username,$password,$type,false,false)){
				$userinfo = $usermodel->getAssociateInfoByUsername($username);
				$uid = $userinfo['uid'];
				
				if($type == 'qq'){
					$data = array(
						'openid'=>$openid,
						'nickname'=>$nickname	
					);
					$this->dobind($type, $data, $userinfo);
				//	$usermodel->update(array('qqopid'=>$openid),$uid);
				}elseif($type == 'wx'){
					$data = array(
							'openid'=>$openid,
							'unionid'=>$unionid,
							'nickname'=>$nickname,
							'sex'=>$sex,
							'headimgurl'=>$face
					);
					$this->dobind($type, $data, $userinfo);
				//	$usermodel->update(array('wxopenid'=>$openid),$uid);
				}elseif($type == 'sina'){
					$data = array(
							'openid'=>$openid,
							'nickname'=>$nickname
					);
					$this->dobind($type, $data, $userinfo);
					
				//	$usermodel->update(array('sinaopid'=>$openid),$uid);
				}
			}else{
				echo '002.OPEN BIND PARAM ERROR!!!';
				exit(0);
			}
			
		}
	
		//登录
		$login_openid = ($type=='wx') ? $unionid :$openid;
		
		$userinfo = $usermodel->openlogin($login_openid,$type);
		$credit = $this->model('credit');
		if($create==true){//创建
			//$credit->addCreditlog(array('ruleid'=>1,'uid'=>$userinfo['uid']));
		}
		
		$cache_data  =  $this->cache->get($state);
		$backurl = '/';
		if(!empty($cache_data)){
			$cache_data_us = unserialize($cache_data);
			if($cache_data_us === FALSE){//非序列化的，直接使用cache_data（微信）
				$backurl = $cache_data;
			} else {
				$backurl = $cache_data_us['backurl'];
			}
		}
		$this->login($userinfo,$backurl);
	}

    /**
     * 用户注册后将注册信息记录到日志
     */
    public function afterUserRegister($uid,$param){
        $logdata = array();
        $type = !empty($param['type']) ? $param['type'] : 0;
        $logdata['uid'] = $uid;
        if($type == 'qq'){
            $logdata['othertype'] = 3;
        }elseif($type == 'wx'){
            $logdata['othertype'] = 2;
        }elseif($type == 'sina'){
            $logdata['othertype'] = 1;
        }else{
            $logdata['othertype'] = 0;
        }
        $logdata['logtype'] = 1;  //1用户注册时创建的日志
        $registerloglib = Ebh::app()->lib('RegisterLog');
        $registerloglib->addOneRegisterLog($logdata);
    }
    /**
     * 微信注册后处理微信头像,生成缩略图并更新到用户数据库
     */
    public function afterWxRegister($uid,$face){
        if($uid>0 && !empty($face)){
            $facestyle = preg_match ('/\/\d+$/', $face);
            if(!empty($facestyle)){
                $face = preg_replace ('/\/\d+$/', '/0', $face);
            }
            $encodeuid =  authcode($uid,'ENCODE');
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            if(!empty($_UP['avatar']['wxnotify'])){
                $wxnotify = $_UP['avatar']['wxnotify'];
                $res = do_post($wxnotify, array('uid'=>$encodeuid, 'face'=>$face), false);
                if(!empty($res->msg) && !empty($res->status) && $res->status== -1){
                    log_message($res->msg);
                }
            }
        }
    }
	/****************微信扫码授权登录  Eker*********************/
	/**
	 * 微信登录 跳转
	 */
	public function wx(){
		$oauth = Ebh::app()->getConfig()->load('oauth');
		$appid = $oauth['weixin']['AppID'];
		$AppSecret = $oauth['weixin']['AppSecret'];
		$scope = intval($this->input->get('scope'));
		if($scope == 1){
            $redirect_uri = urlencode($oauth['weixin']['redirect_uri_tv']);
		}else{
            $redirect_uri = urlencode($oauth['weixin']['redirect_uri']);
		}
		
		$state = md5(uniqid(rand(), TRUE));
		$auth_url = "https://open.weixin.qq.com/connect/qrconnect?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
		
		$server_host = $this->uri->uri_domain();
		if(empty($server_host))
			$server_host = 'www';
		$backurl = 'http://'.$server_host.'.'.$this->uri->curdomain;
		$returnurl = $this->input->get('returnurl');
		if(!empty($returnurl))
			$backurl = $returnurl;
		$this->cache->set($state,$backurl,60);
		header("Location:$auth_url");
	}

    /**
     * tv微信登录 回调
     */
	public function wx_tv_callback(){
        $code = $this->input->get('code');
        $oauth = Ebh::app()->getConfig()->load('oauth');
        $appid = $oauth['weixin']['AppID'];
        $appsecret = $oauth['weixin']['AppSecret'];

        //1.根据code 获取token
        $get_access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        $returnJSON = $this->get_url_contents($get_access_token_url);
        $jsonObj = json_decode($returnJSON);
        //授权成功
        if(empty($jsonObj->errcode)){
            //检测是否存在
			$usermodel = $this->model('User');
			$openid = $jsonObj->openid;

            //获取微信用户信息
            $token =$jsonObj->access_token;
            $get_userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$token}&openid={$openid}";
            $userJSON = $this->get_url_contents($get_userinfo_url);
            $userObj = json_decode($userJSON);


            //关于微信的改版用unionid 2016年5月17日17:23:12 @eker
            $unionid = $userObj->unionid;

            $check = $usermodel->checkWeixinExist($unionid);
            if($check==true){//存在 直接登录
                $login_user = $usermodel->getUserbyWeixin($unionid);

            }else{//不存在 直接创建帐号
                $sex = ($userObj->sex == 1)? 0 : 1;
                //创建账号
                $param = array(
                    'nickname'=>$userObj->nickname,
                    'face'=>$userObj->headimgurl,
                    'sex'=>$sex,
                    'unionid'=>$unionid,
                    'openid'=>$openid,
                );
                $login_user =  $this->createUser($param, 'wx');
            }
			$pwd = $login_user['password'];
            $uid = $login_user['uid'];

            $auth = authcode("$pwd\t$uid", 'ENCODE');
            $url = "ebhp://keylogin?key=".urlencode($auth);

            echo "<script>location.href='".$url."'</script>";
            //header("Location: ebhp://keylogin?key=".urlencode($auth));
            exit;
        }
	}
	/**
	 * 微信登录 回调接口
	 */
	public function wx_callback(){
		$code = $this->input->get('code');
		$oauth = Ebh::app()->getConfig()->load('oauth');
		$appid = $oauth['weixin']['AppID'];
		$appsecret = $oauth['weixin']['AppSecret'];
		
		//1.根据code 获取token
		$get_access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
		$returnJSON = $this->get_url_contents($get_access_token_url);
		$jsonObj = json_decode($returnJSON);
		//授权成功
		if(empty($jsonObj->errcode)){
			//检测是否存在
			$usermodel = $this->model('User');
			$openid = $jsonObj->openid;
			
			$state = $this->input->get('state');
			$backurl = $this->cache->get($state);

			//获取微信用户信息
			$token =$jsonObj->access_token;
			$get_userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$token}&openid={$openid}";
			$userJSON = $this->get_url_contents($get_userinfo_url);
			$userObj = json_decode($userJSON);
			
			//关于微信的改版用unionid 2016年5月17日17:23:12 @eker
			$unionid = $userObj->unionid;
			
			//弹窗绑定 --个人信息-安全设置-直接绑定
			if(preg_match("/callback=bind_success/", $backurl)){
				$this->popup_callback('wx', $backurl, $openid, $userObj->nickname,$unionid);
			}
			
			$check = $usermodel->checkWeixinExist($unionid);
			if($check==true){//存在 直接登录
				$login_user = $usermodel->getUserbyWeixin($unionid);
				//判断是否是公众号过来的
				if(empty($login_user['wxopenid'])){
					//回写wxopenid
					$usermodel->update(array('wxopenid'=>$openid),$login_user['uid']);
				}
				$this->login($login_user,$backurl);
			}else{//不存在  去绑定
		 		$sex = ($userObj->sex == 1)? 0 : 1;
		 		//处理下头像 默认 /0代表640*640, /64 代表64*64
		 		$headimgurl = preg_replace ('/\/\d+$/', '/96', $userObj->headimgurl);
		 		
				$this->assign('uname',$userObj->nickname);
				$this->assign('ulogo',$headimgurl);
				$this->assign('face',$headimgurl);
				$this->assign('openid',$openid);
				$this->assign('unionid',$unionid);
				$this->assign('sex',$sex);
				$this->assign('type','wx');
				$this->assign('state',$state);
			
				$this->display('common/open_bind');
			}
		}else{
			//授权失败
			header("Location:/otherlogin/wx.html");
			exit;
		}

		
	}
	
	/***********************************工具方法*******************************************/
	
	/**
	 * 获取远程页面信息
	 * @param unknown $url
	 * @return string|mixed
	 */
	private function get_url_contents($url){
		//if (ini_get("allow_url_fopen") == "1")
		//	return file_get_contents($url);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result =  curl_exec($ch);
		curl_close($ch);
	
		return $result;
	}
	
	/**
	 * 模拟post
	 * @param unknown $url
	 * @return string
	 */
	private function  get_post_contents($url){
		$post_data =substr($url, (stripos( $url,"?")+1));
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		ob_start();
		curl_exec($ch);
		$result = ob_get_contents() ;
		ob_end_clean();
		
		return $result;
	}
	
	/**
	 * 输出QQ授权错误消息
	 */
	private function show_qq_error($response,$callback = false){
		if($callback){
			$lpos = strpos($response, "(");
			$rpos = strrpos($response, ")");
			$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
			$data = json_decode($response);
		}else{
			$data = $response;
		}
		if (isset($data->error)){
			echo "<h3>error:</h3>" . $data->error;
			echo "<h3>msg  :</h3>" . $data->error_description;
			echo "<script>setTimeout(function(){location.href='/';},3000)</script>";
			exit;
		}
	}
	
	/**
	 * 用户登录
	 * @param unknown $userinfo
	 */
	private function login($userinfo,$backurl='/'){
		$backurl = !empty($backurl)?$backurl:"/";
		//登录成功，则更新上次登录时间和IP信息
		$usermodel = $this->model('user');
		$clientip = $this->input->getip();
		$userparam = array('lastlogintime'=>SYSTIME,'lastloginip'=>$clientip,'logincount'=>1);
		$usermodel->update($userparam,$userinfo['uid']);
		
		$uid = $userinfo['uid'];
		$pwd = $userinfo['password'];
		$auth = authcode("$pwd\t$uid", 'ENCODE');
		$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
		$this->input->setcookie('auth', $auth, $cookietime);
		$this->input->setcookie('lasttime', $userinfo['lastlogintime']);
		$this->input->setcookie('lastip', $userinfo['lastloginip']);
		$durlarr = $this->savecookie($userinfo,$backurl);
		//var_dump($durlarr);exit;
		//多域名处理 写cookie
		$scripthtml = '<script type="text/javascript">';
		$scripthtml.='window.imgcount = 0;';
		if(!empty($durlarr)){
			foreach($durlarr as $key=>$durl){
				$scripthtml.=' var img_'.$key.' = new Image();';
				$scripthtml.='img_'.$key.'.src ="'.$durl.'";';
				$scripthtml.='img_'.$key.'.onload = function(){window.imgcount++;';
				$scripthtml.='if(window.imgcount=='.count($durlarr).'){';
				$scripthtml.='location.href="'.$backurl.'";';
				$scripthtml.='}};';
			}
		}
		//$scripthtml.=";console.log(window.imgcount);";
		$scripthtml.="</script>";
		echo $scripthtml;
	}
	
	/**
	*保存登录状态，同时生成多域名处理请求
	*/
	private function savecookie($user,$backurl){	
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
		$durlarr = array();
		
		if(!empty(Ebh::app()->domains)) {	//处理多域名配置，如果存在多域名，则需要对其他域名cookie注入操作
			$curdomain = $this->uri->curdomain;
			if(!empty($curdomain)) {
				$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
				$ssovalue = $auth.'___'.$user['lastlogintime'].'___'.SYSTIME.'___'.$user['lastloginip'].'___'.$cookietime.'___'.$ctime;
				$ssovalue = base64_encode($ssovalue);
				foreach(Ebh::app()->domains as $mydomain) {
					if($mydomain != $curdomain) {
						$newdurl = 'http://www.'.$mydomain.'/sso.html?k='.$ssovalue;
						array_push($durlarr, $newdurl);
					}
				}
			}
		}
		//处理独立域名
		if($backurl!='/'){
			$regcheck = preg_match("#[\w-]+\.(com|net|org|gov|cc|biz|info|cn|co)(\.(cn|hk|uk))*#", $backurl, $match);
			if($regcheck && !empty($match[0])){
				$allonedomain = $match[0];
				if(in_array($allonedomain, Ebh::app()->domains)==false){
					$allone_host = parse_url($backurl,PHP_URL_HOST);
					$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
					$ssovalue = $auth.'___'.$user['lastlogintime'].'___'.SYSTIME.'___'.$user['lastloginip'].'___'.$cookietime.'___'.$ctime;
					$ssovalue = base64_encode($ssovalue);
					$new_allone_durl = 'http://'.$allone_host.'/sso.html?k='.$ssovalue;
					array_push($durlarr, $new_allone_durl);
				}
			}
		}
		
		return $durlarr;
	}

	
	/**
	 * qq wx weibo 弹窗绑定 调用这个方法
	 */
	private function popup_callback($type,$backurl,$openid,$nickname,$unionid=''){
		//弹窗绑定 --个人信息-安全设置-直接绑定
		header("Content-type:text/html;charset=utf-8");
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			echo '请先登录...';
			exit(0);
		}
		
		$open_openid = ($type=='wx') ? $unionid :$openid;
		if(empty($open_openid)){
			echo '获取授权错误!!!';
			echo '
				<script>
					var timer = setTimeout(function(){
						window.close();
					},1000*10);
				</script>
				';
			exit(0);
		}
		//验证是否绑定了
		$bdmodel = $this->model("Bind");
		$hadbd = $bdmodel->checkbind($open_openid);
		if($hadbd){
			echo '该账号已经被使用,如果继续使用,请先解绑!!!';
			echo '
				<script>
					var timer = setTimeout(function(){
						window.close();
					},1000*10);
				</script>	
				';
			exit(0);
		}
		$data = array(
				'openid'=>$openid,
				'unionid'=>$unionid,
				'nickname'=>$nickname,
			);
		//log_message(var_export($data,true));
		$ck = $this->dobind($type, $data, $user);
		if($ck){
			header("location:$backurl");
		}else{
			echo '绑定失败...';
		}
		exit;
	}
	
	/**
	 * 绑定处理
	 * 对应 ebh_binds表
	 * $type qq,wx,sina
	 * $data 对应的开发平台昵称openid nickname等
	 */
	private function dobind($type,$data,$user){
		$retflag = false;
		$bdmodel = $this->model("Bind");
		$umodel = $this->model("User");
		if($type=='qq'){//QQ
			$bdata =array(
					'uid'=>$user['uid'],
					'is_qq'=>1,
					'qq_str'=>json_encode(
							array(
								'qq'=>'',
								'uid'=>$user['uid'],
								'openid'=>	$data['openid'],
								'nickname'=>$data['nickname'],	
								'dateline'=>SYSTIME
							)
					)
				);
			//log_message(var_export($bdata,true));
			$retflag = $bdmodel->doBind($bdata,$user['uid']);
				
			//更新主表qqopid字段
			if(!empty($retflag)){
				$udata = array(
					'qqopid'=>$data['openid'],
				);
				$umodel->update($udata,$user['uid']);
			}
		}elseif($type=='wx'){//微信
			$bdata =array(
					'uid'=>$user['uid'],
					'is_wx'=>1,
					'wx_str'=>json_encode(
							array(
								'wx'=>'',
								'uid'=>$user['uid'],
								'openid'=>$data['openid'],
								'unionid'=>$data['unionid'],	
								'nickname'=>$data['nickname'],
								'dateline'=>SYSTIME,
								'from'=>'shaoma'
							)
						)
				);
			$retflag = $bdmodel->doBind($bdata,$user['uid']);
			
			//更新主表wxopenid字段
			if(!empty($retflag)){
				$udata = array(
						'wxunionid'=>$data['unionid'],
						'wxopenid'=>$data['openid']
				);
				$umodel->update($udata,$user['uid']);
			}

		}elseif($type=='sina'){//微博
			$bdata =array(
					'uid'=>$user['uid'],
					'is_weibo'=>1,
					'weibo_str'=>json_encode(
							array(
									'weibo'=>'',
									'uid'=>$user['uid'],
									'sinaopid'=>$data['openid'],
									'nickname'=>$data['nickname'],
									'dateline'=>SYSTIME
							)
					)
			);
			$retflag = $bdmodel->doBind($bdata,$user['uid']);
				
			//更新主表wxopenid字段
			if(!empty($retflag)){
				$udata = array(
						'sinaopid'=>$data['openid'],
				);
				$umodel->update($udata,$user['uid']);
			}
		}
		
		return $retflag;
	}
	
	/**
	 * 创建新用户
	 * $param 需要参数 openid,unionid(非必选),nickname,sex
	 */
	private function  createUser($param,$type){
		$sex = 0;//性别 0男  1女
        $face = !empty($param['face']) ? $param['face'] : '';
		$openid = $param['openid'];
		$unionid =  empty($param['unionid'])? '': $param['unionid'];
		$nickname = $param['nickname'];;
		$data = array();
	
		if($type == 'qq'){
			$data['qqopid'] = $openid;
		}elseif($type == 'wx'){
			$data['wxunionid'] = $unionid;
			$data['wxopid'] = $openid;
			$data['sex'] = $param['sex'];
		}elseif($type=='sina'){
			$data['sinaopid'] = $openid;
			$data['sex'] = $param['sex'];
		}
		$mima = $this->generateStr(6);
		$username = $type.rand(1000,9999).$mima;
		$password = $mima;
		$data['username'] = $username;
		$data['mpassword'] = md5($password);
		$data['realname'] = shortstr($nickname,50);//昵称 存在 姓名字段
		$data['dateline'] = SYSTIME;
	
		$member = $this->model("Member");
		$uid = $member->addmember($data);
		if($uid>0){
			$cuser = array('uid'=>$uid);
			$datas = array('openid'=>$openid,'unionid'=>$unionid,'nickname'=>$nickname);
			$this->dobind($type, $datas, $cuser);
		}

        //处理微信头像,生成缩略图并更新用户数据库
        if($uid>0 && !empty($face)){
            $encodeuid =  authcode($uid,'ENCODE');
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            if(!empty($_UP['avatar']['wxnotify'])){
                $wxnotify = $_UP['avatar']['wxnotify'];
                $res = do_post($wxnotify, array('uid'=>$encodeuid, 'face'=>$face), false);
                if(!empty($res->msg) && !empty($res->status) && $res->status== -1){
                    log_message($res->msg);
                }
            }
        }

		$user = array('uid'=>$uid,'realname'=>$data['realname'],'sex'=>$data['sex'],'username'=>$username,'password'=>md5($password),'openid'=>$openid,'unionid'=>$unionid);
		
		$this->afterCreateUser($user);
		
		return $user;
	}
	
	/**
	 * 创建用户 指定到默认网校 默认班级 同步sns数据等
	 */
	public function afterCreateUser($user){
		$appconfig = Ebh::app()->getConfig()->load('appsetting');
		$democrid = $appconfig['democrid'];
		$democlassid = $appconfig['democlassid'];
		
		//添加用户到教室
		$param['crid'] = $democrid;
		$param['uid'] = $user['uid'];
		$param['cnname'] = $user['realname'];
		$param['sex'] = $user['sex'];
		$roomuser = $this->model('roomuser');
		$roomuser->insert($param);
		
		//添加用户到网校
		$param['classid'] = $democlassid;
		$classes = $this->model('classes');
		$classes->addclassstudent($param);
		
		//更新SNS的学校学生、班级学生缓存
		Ebh::app()->lib('XNums')->add('user');
		$snslib = Ebh::app()->lib('Sns');
		$snslib->updateClassUserCache(array('classid'=>$democlassid,'uid'=>$user['uid']));
		$snslib->updateRoomUserCache(array('crid'=>$democrid,'uid'=>$user['uid']));
		
		//调用SNS同步接口，类型为4用户网校操作
		$snslib->do_sync($user['uid'], 4);
		
	}
	
	/**
	 * 生成随机字符串
	 * @param number $length
	 * @return string
	 */
	private function generateStr( $length = 8 ) {
		// 密码字符集，可任意添加你需要的字符
		$chars = '0123456789';
	
		$str = '';
		for ( $i = 0; $i < $length; $i++ )
		{
			$str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
	
		return $str;
	}
	
	/**
	 *创建用户登录key
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

	/**
	 * 创建bindkey
	 * @param  array $userdata 用户数据(包括openid,unionid,nickname,sex)
	 * @param  string $type 第三方登录名称(sina,qq,wx)
	 * @return string       key
	 */
	private function getBindKey($userdata, $type) {
		if (!isset($userdata['openid']) || !isset($userdata['nickname'])  || !isset($userdata['sex'])){
			return '';
		}
		if (!in_array($type, array('sina', 'qq', 'wx'))){
			return '';
		}
		$openid = $userdata['openid'];
		$unionid = empty($userdata['unionid']) ? 0 : $userdata['unionid'];
		$nickname = $userdata['nickname'];
		$sex = $userdata['sex'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$type\t$openid\t$unionid\t$nickname\t$sex\t$ip\t$time";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}
}

?>
