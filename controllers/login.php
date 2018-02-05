<?php

/**
 * 用户登录控制器
 */
class LoginController extends CControl {

    public function index() {
        $loginsubmit = $this->input->post('loginsubmit');
        if (isset($loginsubmit)) {//post提交
            $status = array('code' => 0, 'message' => '', 'returnurl' => '');
            $username = h($this->input->post('username'));
            $password = h($this->input->post('password'));
            $login_from = h($this->input->get('login_from'));
            $returnurl = h($this->input->get('returnurl'));
            if (empty($username) || empty($password)) {
                $status['message'] = '账号和密码不能为空';
                echo json_encode($status);
                return;
            }
            $usermodel = $this->model('user');
            $user = $usermodel->login($username, $password);
			$roominfo = Ebh::app()->room->getcurroom();
			$spclassroom = array(10420);//首次登录需要改密码的学校
			$sppassword = array(md5('123456'),md5('hzsz11'));//太简单需要修改的密码
			if(!empty($user) && in_array($roominfo['crid'],$spclassroom)){
				$toosimple = in_array($user['password'],$sppassword);
				if(!$toosimple)
				$res = $this->model('classroom')->checkforfirstlogin($user,$roominfo['crid']);
				if($toosimple || !empty($res)){
					$durl = $this->savecookie($user);
					echo json_encode(array('code'=>1,'returnurl'=>'/editpass.html','durl'=>$durl));
					exit;
				}
			}
			if(empty($user) && $login_from == 'classroom') {	//判断是否为第三方登录
				$user = $this->loginbyosign($username,$password);
			}
			if(empty($user)){
				//判断登录账号是否符合年卡规则
				if(is_numeric($username) && strlen($username)>=10 && strlen($username)<=12){
					//符合年卡规则，则进行年卡首次登录验证
					$user =$this->openyearcards($username,$password);
				}
			}
			if(empty($user) || $user['groupid']==1 || $user['groupid']==4 || ($user['groupid']>=7 && $user['groupid']<=14) ){
				$status['message'] ='账号或密码输入不正确。';
				echo json_encode($status);
				return;
			}
            if (!empty($user)) {
				// 国土资源厅学生登陆状态保持 24 小时在线
				$conf = Ebh::app()->getConfig()->load('othersetting');
		        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
		        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
		        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
		        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
				if (!empty($is_zjdlr) && $user['groupid'] == 6) {
					$onLimeTime = time() + 86400;
					$redis = Ebh::app()->getCache('cache_redis');
					$redis->hset('zjdlr', $user['uid'], $onLimeTime);
				}

				//登录成功，则更新上次登录时间和IP信息
				$clientip = $this->input->getip();
				$userparam = array('lastlogintime'=>SYSTIME,'lastloginip'=>$clientip,'logincount'=>1);
				if($user['groupid'] == 6 && empty($user['allowip']))
					$userparam['allowip'] = $clientip;
				$usermodel->update($userparam,$user['uid']);
				$screen = '';
				$other = array();
				if(NULL !== $this->input->post('screen')) {
					$screen = $this->input->post('screen');
					$other['sc'] = $screen;
				}
				$durl = null;//不做sso处理
				$this->savecookie($user,$other);
				$status['code']= 1;
                $status['message'] = '登录成功';
				$status['durl'] = $durl;
                $status['groupid'] = $user['groupid'];
                if (empty($returnurl)) {
                    if ($login_from == 'classroom') {    //暂不判断权限
                        if ($user['groupid'] == 5) {
							$aroomv = $roominfo['property'] == 3?'comaroomv3':'aroomv3';
                            $roominfo = Ebh::app()->room->getcurroom();
                            if (!empty($roominfo) && $roominfo['uid'] == $user['uid'] && ($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7)) {
								$returnurl = geturl($aroomv);
                            } else if($roominfo['isschool'] == 5) {
                                $returnurl = geturl('croom');
                            } else {
								$troomurl = gettroomurl($roominfo['crid']);
								$returnurl = $troomurl;
								//如果是大学版，则判断教师是否有管理权限
								if($roominfo['iscollege']) {
									$roomcontrol = $this->model('Roomcontrol');
									$tpower = $roomcontrol->getcontrol(array('rid'=>$roominfo['crid'],'tid'=>$user['uid']));
									if(!empty($tpower)) {
										$returnurl = geturl($aroomv);
									}
								}
							}
                        } else {
                            $returnurl = geturl('myroom');
                        }
                    } else {
                        $returnurl = geturl('homev2');
                    }
                }
				if($this->input->post('sharp')){
					$returnurl.= '#'.$this->input->post('sharp');
				}
                $status['returnurl'] = $returnurl;
                //有发布登录前首次问卷的网校,登录要判断是否做过问卷
                $status = $this->checkSurvey($user,$roominfo,$status);
                echo json_encode($status);
            }
        } else {    //其他，默认加载模板
			if($this->input->get('un')){
				$this->assign('un',$this->input->get('un'));
			}
			$this->assign('sharp',$this->input->get('sharp'));
            $this->_show_login();
        }
    }

    /**
     * 显示登录模板
     */
    function _show_login() {
        //获取分类列表
        $catlist = $this->cache->get('catlist1');
        if (empty($catlist)) {
            $catmodel = $this->model('Category');
            $catlist = $catmodel->getCatlistByUpid(0, 2, NULL);
            $this->cache->set('catlist1', $catlist, 30);
        }
        $this->assign('catlist', $catlist);
        $this->display('common/newtemplate/login');
    }
	
	/**
	*判断是否为年卡首次登录，如果是，则直接开通年卡，并注册用户登录
	*1，用户没有登录，判断账号是否是年卡
	*2，如是年卡：插入user表，成功，关联roomuser表
	*   更新status状态  积分
	*/
	private function openyearcards($username,$password){
		$yearcardsmodel = $this->model('yearcard');
		$yearcard = $yearcardsmodel->getYearcardByCardnumber($username);
		$user = FALSE;
		if(!empty($yearcard) && $yearcard['cardpass']==$password && $yearcard['status'] == 0){//判断是年卡，且未激活过
			//密码正确					
			//根据年卡信息生成会员信息记录
			$member = $this->model('member');
			$param = array('username'=>$yearcard['cardnumber'],'password'=>$yearcard['cardpass']);
			$result = $member->addmember($param);
			if($result){
				$cardmonth = $yearcard['time'];	//年卡的服务周期，一般为12个月
				$usermodel = $this->model('user');
				$user = $usermodel->login($username,$password);
				$roomusermodel = $this->model('roomuser');
				//当前时间加上年卡开通时间
				$enddate = strtotime("+$cardmonth month");
				//年卡会员插入到roomusers表，便于个人信息里面查询开通的学校
				$uid = $user['uid'];
				$param = array('crid'=>$yearcard['crid'],'uid'=>$uid,'begindate'=>SYSTIME,'enddate'=>$enddate);
				$ruresult = $roomusermodel->insert($param);
				if($ruresult !== FALSE) {	//如果生成roomuser成功，则更新年卡状态
					//更新年卡status状态
					$cardparam = array('cardid'=>$yearcard['cardid'],'status'=>1);
					$yearcardsmodel->update($cardparam);
					//生成年卡开通记录
					$openmodel = $this->model('Opencount');
					$openparam = array('username'=>$user['username'],'type'=>1,'paytime'=>SYSTIME,'addtime'=>$cardmonth,'status'=>1,'ip'=>$this->input->getip(),'crid'=>$yearcard['crid'],'payfrom'=>1,'ordernumber'=>$yearcard['cardnumber'],'password'=>$password);
					$openmodel->insert($openparam);
				}
				//积分
				$credit = $this->model('credit');
				$credit->addCreditlog(array('ruleid'=>1,'uid'=>$uid));//注册积分
				
			}
		}
		return $user;
	}
	/**
	*判断是否为第三方登录
	*是第三方账号，则返回关联的ebh用户对象
	*/
	private function loginbyosign($username,$password){
		$oumodel = $this->model('OUser');
		$ouser = $oumodel->getuserbyouser($username,$password);
		$user = FALSE;
		if(!empty($ouser)){//是第三方登录
			$usermodel = $this->model('user');
			$user = $usermodel->login($ouser['username'],$ouser['password'],true);
		}
		return $user;
	}
	/**
	*保存登录状态，同时生成多域名处理请求
	*/
	private function savecookie($user,$other = null){	
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$uid = $user['uid'];
		$pwd = $user['password'];
		$auth = authcode("$pwd\t$uid", 'ENCODE');
		$savestate = $this->input->post('cookietime');
		$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
		$ak = $this->input->cookie('ak');
		if($user['groupid'] == 6 && !empty($ak)){
			$this->input->setcookie('ak','');
		}
		$this->input->setcookie('sessioncrid','');//重新登录，去掉域名记录（登录日志用）
		$this->input->setcookie('auth', $auth, $cookietime);
		$this->input->setcookie('lasttime', $user['lastlogintime'], $cookietime);
		$this->input->setcookie('thistime', SYSTIME, $cookietime);
		$this->input->setcookie('lastip', $user['lastloginip'], $cookietime);
		if($user['groupid'] == 5) {	//如果是教师，则添加ak的cookie设置，主要用于学校后台获取权限
			$this->input->setcookie('ak', $auth, $cookietime);
		}
		if(!empty($other) && is_array($other)) {
			foreach($other as $okey=>$ovalue) {
				$this->input->setcookie($okey, $ovalue, $cookietime);
			}
		}
		$durl = '';
		if(!empty(Ebh::app()->domains)) {	//处理多域名配置，如果存在多域名，则需要对其他域名cookie注入操作
			$curdomain = $this->uri->curdomain;
			if(!empty($curdomain)) {
				$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
				$sc = empty($other['sc'])?'':$other['sc'];//分辨率信息
				$ssovalue = $auth.'___'.$user['lastlogintime'].'___'.SYSTIME.'___'.$user['lastloginip'].'___'.$cookietime.'___'.$sc.'___'.$ctime;
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

    /**
     * 验证问卷调查new
     * @param unknown $user
     * @param unknown $status
     */
    protected function checkSurvey($user,$roominfo,&$status){
        if(!empty($roominfo['crid']) && !empty($user['groupid']) && ($user['groupid']==6)){
            $crid = $roominfo['crid'];
            $redis = Ebh::app()->getCache('cache_redis');
            $redis_key = 'loginsurvey_' . $crid;
            $surveyinfo = $redis->get($redis_key);//读取缓存中有添加首次调查问卷的网校id
            if(!empty($surveyinfo)) {
                $surveyinfo = json_decode($surveyinfo, true);
            }
            $surveycrid = !empty($surveyinfo['crid']) ? $surveyinfo['crid'] : 0;
            if(!empty($surveycrid) && ($surveycrid==$crid)){
                $isroomclass = (!empty($surveyinfo['isroomclass']) && ($surveyinfo['isroomclass'] == 1)) ? 1 : 0;//1是年级/班级，0是全校
                $classids = !empty($surveyinfo['classids']) ? $surveyinfo['classids'] : array();    //被调查班级id集
                $classids = array_filter($classids, function($classid) {    //过滤数组
                    return is_numeric($classid) && ($classid>0);
                });
                if(($isroomclass ==1) && empty($classids)){
                    return $status;
                }
                //判断当前登录用户是否为本网校用户
                $model = $this->model('Roomuser');
                $result = $model->checkUser($user,$roominfo['crid']);
                if(!empty($result)){
                    $surveyparam = array('uid'=>$user['uid'],'crid' =>$crid,'classids' =>$classids,'isroomclass' =>$isroomclass);
                    $check = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Classroom.Survey.checkSurvey')->addParams($surveyparam)->request();
                    if($check){
                        $status['returnurl'] = geturl('survey/'.intval($check)).'?return='.urlencode(geturl('myroom'));
                    }
                }
            }
        }
        return $status;
    }
}
