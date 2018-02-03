<?php
/**
 * @desc 微信控制器   weixin
 */
class WxbindController extends CControl{
	//首页
	public function index()
	{
		$code = $this->input->get('code');
		$this->assign('code',$code);
		$this->display('common/wxbind');
	}
	//移动端表表单数据提交做绑定
	public function do_bind(){
		$unmae = $this->input->post("username");
		$pass = $this->input->post("password");
		$code = $this->input->post("code");
		if(empty($unmae) || empty($pass) || empty($code)) {
			echo json_encode(array('code'=>3,'message'=>'输入信息有无，请重新输入！')) ;
			exit;
		}
		$usermodel = $this->model('User');
		$user = $usermodel->login($unmae,$pass);
		if(empty($user)) {
			echo json_encode(array('code'=>3,'message'=>'用户名或密码错误，请重新输入！')) ;
			exit;
		}
		$wechatObj = Ebh::app()->lib('WechatCallback');//得到微信扩展类的实例
		$uid = $user['uid'];
		//根据带过来的code参数获取微信号的openid
		$openid = $wechatObj->getopenidbycode($code);	
		if(empty($openid)) {
			echo json_encode(array('code'=>3,'message'=>'绑定失败，请重新点击家长绑定菜单进行绑定！')) ;
			exit;
		}
		$result = $this->model('Weixin')->bindUid($uid,$openid);
		if($result == 1){
			echo json_encode(array('code'=>1,'message'=>'绑定成功！')) ;
		}else if ($result == -1){
			echo json_encode(array('code'=>2,'message'=>'您的微信号已跟此账号绑定，无需重复绑定！')) ;
		} else {
			echo json_encode(array('code'=>3,'message'=>'绑定失败，请重新点击家长绑定菜单进行绑定！')) ;
		}
	}
	/**
	*微信获取最新消息
	*/
	public function wxlist(){
		$code = $this->input->get('code');
		$ocode = $this->input->get('ocode');
		$frompage = $this->input->get('frompage');
		$q = $this->input->get('q');
		if(empty($code) && empty($ocode))
			return FALSE;
		if(!empty($ocode))
			$openid = $ocode;
		else
			$openid = Ebh::app()->lib('WechatCallback')->getopenidbycode($code);
		$weixinmodel = $this->model('Weixin');
		$uidlist = $weixinmodel->getUidListByOpenid($openid);
		$page = $this->input->post('num');
		if(NULL == $page || !is_numeric($page))
			$page = 1;
		if(empty($uidlist))
			return FALSE;
		//$uid = 12233;
		//$openid = 'o1Zuzju4t3vFiLTc8i1NCuK2206E';
		$param = array('uidlist'=>$uidlist,'page'=>$page,'q'=>$q);
		$msglist = $weixinmodel->getMessageListByUidList($param);
		if(empty($ocode)||!empty($frompage)) {
			$this->assign('q',$q);
			$this->assign('openid',$openid);
			$this->assign('msglist',$msglist);
			$this->display('common/wxlist');
		} else {

			$jmsglist = array();
			for($i = 0; $i < count($msglist); $i ++) {
				$uname = empty($msglist[$i]['realname']) ? $msglist[$i]['username'] :  $msglist[$i]['realname'];
				$thedate = date("Y年m月d日H:i",$msglist[$i]['dateline']);
				$content = shortstr($msglist[$i]['weixin_content'],60);
				$face = getthumb($msglist[$i]['face'],'50_50');
				if(empty($face)){
					if($msglist[$i]['sex']==1){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					 }else{ 
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					 }

					 $face = getthumb($defaulturl,'50_50');
				}
				$jmsglist[] = array('uname'=>$uname,'date'=>$thedate,'content'=>$content,'face'=>$face);
			}
			echo json_encode($jmsglist);
		}
	}

	public function wxdetail(){
		$batchid = $this->input->get('batchid');
		$weixin_name = $this->input->get('weixin_name');
		$htype = $this->input->get('htype');
		$frompage = $this->input->get('frompage');
		$weixinModel = $this->model('weixin');
		$param = array(
			'batchid'=>$batchid,
			'weixin_name'=>$weixin_name,
			'htype'=>$htype
		);
		$detail = $weixinModel->getDetail($param);
		$filterdetail = EBH::app()->lib('UserUtil')->init(array($detail),array('send_uid'),true);
		$detail = $filterdetail[0];
		if(empty($detail)){
			show_404();exit;
		}else{
			$this->assign('frompage',$frompage);
			$this->assign('detail',$detail);
			$this->display('common/wxdetail');
		}
	}

	
	/************************************pc端跳转到微信端处理 start***************************************************************/
	/**
	 * 微信客户端跳转到手机端
	 * 
	 */
	public function towap(){
	    $get = $this->input->get();
	    $code = isset($get['code']) ? h($get['code']) : ''; //获取微信返回的code值
		$state = isset($get['state']) ? h($get['state']) : '';//兼容之前的老版本
		$domain = isset($get['domain']) ? h($get['domain']) : '';//设置网校域名
		
		$wechatObj = Ebh::app()->lib('WechatCallback');//得到微信扩展类的实例
		if(($state=='parent') && !empty($code)){//家长  --需要微信授权回调
			$openid = $wechatObj->getopenidbycode($code);
			$ebhcode = '820ea38c4901eb285f9aedf33948bb7b';//对应小学crid 10194
			$wxtConfig = Ebh::app()->getConfig()->load('wxt');
			$domain = !empty($wxtConfig['domain']) ? $wxtConfig['domain'] :"eth.ebh.net";
			$url = 'http://'.$domain.'/ebh.html?openid='.$openid.'&type=parent&ebhcode='.$ebhcode;
		}elseif(($state=='teacher') && !empty($code)){//老师 --需要微信授权回调
			$openid = $wechatObj->getopenidbycode($code);
			$this->input->setcookie('scrid',0,-8640000);
			$this->input->setcookie('scrname','',-8640000);
			$url = 'http://wap.ebh.net/index.html?wxopenid='.$openid.'&type=teacher';
		}else{//学生或者其他 这个是以前的程序 --2016年6月30日11:45:37 @eker
		    $openid = '';//微信openid
		    $attach = '';//带有跳转地址url的base64加密 {"url":"http:\/\/wap.ebh.net\/myroom\/folder\/clist\/5901.html"}
		    $scrname = '';//网校名称
		    $scrid = '';//网校crid
		    
		    if(!empty($state) && (strpos($state,"wapshop_school") !== FALSE)){
		        $state_arr = explode('_', $state);
		        if(!empty($state_arr[2])){
		            
		        }
		    }
			// $state = 'wapshop_school_10440_eyJ1cmwiOiJodHRwOlwvXC93YXAuZWJoLm5ldFwvbXlyb29tXC9mb2xkZXJcL2NsaXN0XC81OTAxLmh0bWwifQ==';
		    if(strpos($state,"wapshop_school") !== FALSE){
				$state_arr = explode('_', $state);
				if(!empty($state_arr[2])){
					$scrid = $state_arr[2];
					if(!is_numeric($scrid)){
						$res = $this->model('classroom')->getroomdetailbydomain($scrid);
						if(!empty($res)){
							$scrid = $res['crid'];
						}else{
							$scrid = 0;
						}
					}
				}else{
					$scrid = 0;
				}
				if(!empty($state_arr[3])){
					$attach = $state_arr[3];
				}else{
					$attach = '';
				}
			}
			$wechatObj = Ebh::app()->lib('WechatCallback');//得到微信扩展类的实例
			$openid = '';
			if($state == "wapshop_school"){
				$openid = $wechatObj->getopenidbycode($code);
				$this->input->setcookie('scrid',0,-8640000);
				$this->input->setcookie('scrname','',-8640000);
				$url = 'http://wap.ebh.net/shop.html?c=school&wxopenid='.$openid;
			}else{
				if(!empty($scrid)){
					$url = 'http://wap.ebh.net/index.html?fromebh=1&wxopenid='.$openid.'&scrid='.$scrid.'&attach='.$attach;
				}else{
					$openid = $wechatObj->getopenidbycode($code);
					$this->input->setcookie('scrid',0,-8640000);
					$this->input->setcookie('scrname','',-8640000);
					$url = 'http://wap.ebh.net/index.html?wxopenid='.$openid;
				}
			}
		}

		header("Location:".$url);
	}

	//第三方微信跳转到本地址再次绑定ebh微信
	public function xbind(){
		$code = $this->input->get('code');
		$datapacakge = $this->input->get('state');
		$infos = json_decode(base64_decode($datapacakge));
		// $k = $infos->k;
		$scrid = $infos->scrid;
		$crname = $infos->crname;
		$attach = $infos->attach;
		$tourl = $infos->tourl;


		$scrid = intval($scrid);

		$wechatObj = Ebh::app()->lib('WechatCallback');//得到微信扩展类的实例
		//$openid = $wechatObj->getopenidbycode($code);

		//获取用户信息, 判断是否关注
		$userinfo = $wechatObj->getAuthUserInfo($code);
		$this->filterweixinuser($userinfo);
		$openid = $userinfo['openid'];
		
		if(!empty($tourl)) {
		    $url = $tourl.'&wxopenid='.$openid;
		}else {
			$this->input->setcookie('scrid',$scrid,8640000);
			$this->input->setcookie('scrname',$crname,8640000);
			$this->input->setcookie('code',$openid,8640000);
            
			$this->ytzkjump($scrid,$attach,$crname,$openid);//亚投智库 

			$url = 'http://wap.ebh.net/index.html?hasredirect=1&fromebh=1&crname='.$crname.'&wxopenid='.$openid.'&scrid='.$scrid.'&attach='.$attach;
		}
		
		header("Location:".$url);
	}
	
	/**
	 * 亚投智库 跳转单独处理
	 */
	private function ytzkjump($scrid,$attach='',$crname,$openid){
	    //亚投智库 单独处理 没有用户的 创建用户
	    $ytzkconfig = Ebh::app()->getConfig()->load('ytzkconfig');
	    if(!empty($ytzkconfig) && ($ytzkconfig['crid'] > 0)){
	        if($scrid==$ytzkconfig['crid'] && !empty($attach)){
	            $url = 'http://wap.ebh.net/ytzk.html?hasredirect=1&fromebh=1&crname='.$crname.'&wxopenid='.$openid.'&scrid='.$scrid.'&attach='.$attach;
	            header("Location:".$url);
	            exit;
	        }
	    }
	}
	
	/**
	 * 获取用户信息 写入微信用户信息表
	 */
	private function filterweixinuser($userinfo){
	    if(empty($userinfo)){
	        return false;
	    }
	    $param = array(
	        'openid' => $userinfo['openid'],
	        'unionid' => $userinfo['unionid'],
	        'nickname' => $userinfo['nickname'],
	        'sex' => $userinfo['sex'],
	        'province' => $userinfo['province'],
	        'city' => $userinfo['city'],
	        'country' => $userinfo['country'],
	        'headimgurl' => $userinfo['headimgurl'],
	        'status' => 0,
	        'dateline' => SYSTIME
	    );
	    $weixinmodel = Ebh::app()->model('Weixin');
	    $result = $weixinmodel->insertWeixinInfo($param);
	    return $result;
	}
	
}
