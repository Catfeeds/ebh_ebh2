<?php
/**
 * 学生后台入口默认控制器类 DefaultController
 */
class DefaultController extends CControl {
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;

        if (is_mobile()) {
            $user = Ebh::app()->user->getloginuser();
            if (empty($user) || $user['groupid']== 5) {
                $url = 'http://wap.ebh.net/login.html?redirecturl='.'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                header("location:$url");exit;
            }
        }
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
    public function index() {
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
      
    	//判断后台是否勾选非网校内部不用禁止进入
    	$systeminfo = Ebh::app()->room->getSystemSetting();
        if(isset($systeminfo['refuse_stranger']) && $systeminfo['refuse_stranger'] == 1){
            //判断当前登录用户是否为本网校用户   
        	$model = $this->model('Roomuser');
        	$result = $model->checkUser($user,$roominfo['crid']);
        	//非网校内部用户进入个人中心
        	if(!$result){
        		header("location:homev2.html");exit;
        	}	
        }
        
		$clientlib = Ebh::app()->lib('Clientlimit');
		//用户访问设备限制
		$clientlib->checkClient(TRUE, '/loginlimit.html');
		$blacklistlib = Ebh::app()->lib('Blacklist');
		$blacklistlib->check();

        //手机登入页面
        if (is_mobile()) {
            //剔除不需要响应式的网校
            $othersetting = Ebh::app()->getConfig()->load('othersetting');
            if (empty($othersetting['mobilemyroom_filter']) || !in_array($roominfo['crid'], $othersetting['mobilemyroom_filter'])) {
                EBH::app()->getInput()->setcookie('crname',$roominfo['crname'],'8640000');
                EBH::app()->getInput()->setcookie('crid',$roominfo['crid'],'8640000');
                $SERVER_NAME = $this->getHostDomainByServer($_SERVER['HTTP_HOST']);
                //独立域名第三方登入,需要跳转到wap端，wap跳转到独立域名sso地址，然后再返回
                if(substr($SERVER_NAME, -7) != 'ebh.net' && substr($SERVER_NAME, -11) != 'ebanhui.com') {
                    $ssovalue = $roominfo['crid'].'___'.$roominfo['crname'].'___'.SYSTIME.'8640000';
                    $ssovalue = base64_encode($ssovalue);
                    $ssofulldomain = 'http://'.$_SERVER['HTTP_HOST'].'/sso.html?roomkey='.$ssovalue;
                    $this->assign('ssofulldomain',rawurlencode($ssofulldomain));
                }
                $appmodulesConfig = Ebh::app()->getConfig()->load('appmodule');
                $this->assign('appmodule_config',$appmodulesConfig);
                //获取个人中心的模块
                $result = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.Module.modules')->addParams(array(
                    'tor'   =>  0,
                    'crid'  =>  $roominfo['crid']
                ))->request();

                if ($result === false) {
                    $appmodules = array();
                } else {
                    $appmodules = $result;
                }
                
                //获取学生积分学分信息
                $this->getUserSum($user['uid'],$roominfo['crid']);
                //判断是否有未读的消息通知，true存在未读的
                $noticemodel = $this->model('Notice');
                $noRead = $noticemodel->checkExitNoRead($user['uid'],$roominfo['crid'],$user['groupid']);
                $this->room = $roominfo;
                $this->user = $user;
                $this->getHeaderAndFooter();
                $this->assign('noRead',$noRead);
                $this->assign('user',$user);
                $this->assign('roominfo',$roominfo);
                $this->assign('appmodules',$appmodules);
                $this->display('myroom/myroom_mobile');
                exit;
            }
        }

		//有发布登录前首次问卷的网校,登录要判断是否做过问卷start
        $crid = $roominfo['crid'];
        $redis = Ebh::app()->getCache('cache_redis');
        $redis_key = 'loginsurvey_' . $crid;
        $surveyinfo = $redis->get($redis_key);//读取缓存中有添加首次调查问卷的网校id
        if(!empty($surveyinfo)){
            $surveyinfo = json_decode($surveyinfo,true);
        }
        $surveycrid = !empty($surveyinfo['crid']) ? $surveyinfo['crid'] : 0;
        if(!empty($surveycrid) && ($surveycrid==$crid)){
            $isroomclass = (!empty($surveyinfo['isroomclass']) && ($surveyinfo['isroomclass'] == 1)) ? 1 : 0;//1年级/班级,0全校
            $classids = !empty($surveyinfo['classids']) ? $surveyinfo['classids'] : array();    //指定被调查班级id集
            $classids = array_filter($classids, function($classid) {    //过滤数组
                return is_numeric($classid) && ($classid>0);
            });
            if(($isroomclass ==0) || (($isroomclass ==1) && !empty($classids))){
                //判断当前登录用户是否为本网校用户
                $model = $this->model('Roomuser');
                $result = $model->checkUser($user,$roominfo['crid']);
                if(!empty($result)){
                    $surveyparam = array('uid'=>$user['uid'],'crid' =>$crid,'classids' =>$classids,'isroomclass' =>$isroomclass);
                    $check = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Classroom.Survey.checkSurvey')->addParams($surveyparam)->request();
                    if(!empty($check)){
                        $url = geturl('survey/'.intval($check)).'?return='.urlencode(geturl('myroom'));
                        header("location:$url");exit;
                    }
                }
            }
        }
        //有发布登录前首次问卷的网校,登录要判断是否做过问卷end
		$this->assign('room', $roominfo);
        $this->assign('user', $user);
        /*头部链接 start*/
        $api = Ebh::app()->getApiServer('ebh');
        $clientSetting = $api->reSetting()
            ->setService('College.ClientLink.roomSetting')
            ->addParams('crid', $roominfo['crid'])
            ->request();
        if (!empty($clientSetting['showlink'])) {
            $toplinks = $api->reSetting()
                ->setService('College.ClientLink.index')
                ->addParams('crid', $roominfo['crid'])
                ->request();
            $this->assign('toplinks', $toplinks);
        }
        $beginTime     = strtotime(date('Y'.'-01-01'));
        $endTime       = SYSTIME;
        //获取年度学分
        $yearCredit = $api->reSetting()->setService('Aroomv3.Student.getCreditList')->addParams(array('uids'=>$user['uid'],'crid' =>$crid,'beginTime'=>$beginTime,'endTime'=>$endTime))->request();
        $yearCredit = isset($yearCredit[$user['uid']]['score'])&&$yearCredit[$user['uid']]['score']>0?$yearCredit[$user['uid']]['score']:0;
        $this->assign('yearCredit',$yearCredit);//本年读获取到的学分
        if (empty($clientSetting) || !isset($clientSetting['showmodule']) || !empty($clientSetting['showmodule'])) {
            $this->assign('showModuleMenu', true);
        }
		//资料完成百分比
        $percent = $this->getpercent($user);
        $this->assign('percent',$percent);
		if(empty($roominfo['iscollege'])){//非大学
			$this->showmyroom($roominfo,$user);
        
		}else{//大学				
			$this->showcollege($roominfo,$user);
		
		}
    }

    /**
     *用户详情页面
     */
    public function userinfo() {
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->display('myroom/userinfo');
    }

    /**
     *通知列表页面
     */
    public function noticelist() {
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $this->display('myroom/noticelist_mobile');
    }

    /**
     *通知详情页面
     */
    public function notice_view() {
        $user = Ebh::app()->user->getloginuser();
        $noticeid = $this->uri->itemid;
        $noticemodel = $this->model('Notice');
        $noticemodel->addviewnum($noticeid);
        //判断该条通知是否已读，未读则加入记录
        $readedlist = $noticemodel->getusernotice($user['uid'],$noticeid);
        if(!$readedlist){
            $noticemodel->adduserviewnum($user['uid'],$noticeid,$user['groupid']);
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('noticeid',$noticeid);
        $this->assign('roominfo', $roominfo);
        $this->display('myroom/notice_mobile');
    }
    
    /**
     *获取个人的信息
     */
    public function getUserInfo() {
        $user = Ebh::app()->user->getloginuser();
        $user['face'] = getavater($user);
        echo json_encode($user);
        exit;
    }

    /**
     *获取个人中心通知列表接口
     */
    public function getNoticeList() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $api = Ebh::app()->getApiServer('ebh');
        $page = intval($this->input->get('page'));
        $res = $api->reSetting()->setService('Classroom.Notice.list')->addParams(array('uid'=>$user['uid'],'crid' =>$roominfo['crid'],'p'=>$page))->request();
        echo json_encode($res);
        exit;
    }

    /**
     *获取个人中心通知详情接口
     */
    public function getNoticeDetail() {
        $noticeid = intval($this->input->get('noticeid'));
        if ($noticeid <= 0) {
            echo 'noticeid error';
            exit;
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $api = Ebh::app()->getApiServer('ebh');
        $res = $api->reSetting()->setService('Classroom.Notice.detail')->addParams(array('noticeid'=>$noticeid,'crid' =>$roominfo['crid']))->request();
        echo json_encode($res);
        exit;
    }
    
    public function getpercent($user){
    	$pc = 50;
    	if($user['face'])
    		$pc+=10;
    	$mmodel = $this->model('Member');
    	$info = $mmodel->getfullinfo($user['uid']);
    	unset($info['memberid'],$info['realname'],$info['face']);
    	foreach($info as $value){
    		if(!empty($value))
    			$pc+=2;
    	}
    	if($pc>100){$pc=100;}
    	return $pc;
    }

	
	/*
	老版本myroom
	*/
	private function showmyroom($roominfo,$user){
		//加载菜单模块信息
        $code = 'myroom';
        $catmodel = $this->model('Category');
        $curcat = $catmodel->getCatByCode($code);
        $upid = $curcat['catid'];
        $subcat = $catmodel->getCatlistByUpid($upid,NULL,NULL,1);
        $modulelist = array();
        $modulepower = $roominfo['stumodulepower'];
        $modulepowerarr = explode(',', $modulepower);
        //需要在学校平台显示的模块
        // $schoolcatarr = array('mysubject','myexam','myerrorbook','forum','notes','favorite','stuexam','myask','online','mysetting','studycalendar','stusubject');
        $schoolcatarr = array('mysubject','myexam','forum','stuexam','myask','online','mysetting','stusubject','analysis','review','mycredit','iaclassroom','ghrecord','evaluate','mypaper');
        //不需要在网校平台显示的模块
        $noinroomcatarr = array('mysubject','myexam','myerrorbook','mysetting','studycalendar','stusubject','analysis');
        if($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {  //学校模块
            foreach ($subcat as $catitem) {
				if($roominfo['crid'] == 10420 && $catitem['code'] == 'review') {
					continue;
				}
                if($catitem['system'] == 1 && in_array($catitem['code'], $schoolcatarr)) {
                    $modulelist[$catitem['code']] = $catitem;
                    continue;
                }
                if($catitem['system'] == 0 && in_array($catitem['catid'], $modulepowerarr) && in_array($catitem['code'], $schoolcatarr)) {
                    $modulelist[$catitem['code']] = $catitem;
                    continue;
                }
            }
        } else {    //网校模块
            foreach ($subcat as $catitem) {
                if($catitem['system'] == 1 && !in_array($catitem['code'], $noinroomcatarr)) {
                    $modulelist[$catitem['code']] = $catitem;
                    continue;
                }
                if($catitem['system'] == 0 && in_array($catitem['catid'], $modulepowerarr) && !in_array($catitem['code'], $noinroomcatarr)) {
                    $modulelist[$catitem['code']] = $catitem;
                    continue;
                }
            }
        }
		
		
        $this->assign('modulelist', $modulelist);
        
		//我的网校
		$roomuser = $this->model('roomuser');
		$roomlist = $roomuser->getroomlist($user['uid']);
		$roomcount = $roomuser->getroomcount($user['uid']);
		$this->assign('roomcount',$roomcount);
		$this->assign('roomlist',$roomlist);
        //加载全科模块信息
		$rpmodel = $this->model('Roompermission');
		$roompers = $rpmodel->getModulesByCrid($roominfo['crid']);
		$this->assign('roompers',$roompers);
        $nophoto = $this->input->cookie('nophoto');	//默认弹出修改头像后是否设置了不再显示
        $helpcrid = 10372;
        $helpcid = 1562;
        
          
        $this->assign('helpcrid', $helpcrid);
        $this->assign('helpcid', $helpcid);
        $this->assign('nophoto', $nophoto);	
		$this->assign('roominfo',$roominfo);
        $this->display('myroom/index');
	}
	
	/*
	colleg形式myroom
	*/
	private function showcollege($roominfo,$user){
    
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$this->assign('myclass',$myclass);
		$roomcache = Ebh::app()->lib('Roomcache');
		$modulekey = array('name'=>'appmodule','tors'=>0);

		$modulelist = $roomcache->getCache($roominfo['crid'],'other',$modulekey);
		
		if(true||empty($modulelist)){
			$ammodel = $this->model('appmodule');
            $modulelist = $ammodel->getmodulelist(array('system'=>1,'limit'=>100,'tors'=>'0,2'), true);
            $custom_modulelist = $ammodel->getRoomSet(array('crid'=>$roominfo['crid'],'order'=>'displayorder','limit'=>100,'tors'=>'0,2','showmode'=>0), true);
            if (!empty($custom_modulelist)) {
                foreach ($custom_modulelist as $moduleid => $custom_moduleitem) {
                    $modulelist[$moduleid] = $custom_moduleitem;
                }
                unset($custom_modulelist);
            }
            $modulelist = array_filter($modulelist, function($module) {
                return (!isset($module['available']) || !empty($module['available']))
                    && empty($module['ismore']);
            });
            $room_type = Ebh::app()->room->getRoomType();
            $room_type = ($room_type == 'com') ? 1 : 0;
            if (!empty($modulelist)) {
                $displayorders = array_column($modulelist, 'displayorder');
                $moduleids = array_keys($modulelist);
                $max_displayorder = max($displayorders);
                array_walk($modulelist, function(&$v, $k, $user_data) {
                    if ($v['modulecode'] == 'more') {
                        $v['nickname'] = '更多';
                    }
                    $temp = str_replace('[crid]',$user_data['roominfo']['crid'],$v['url']);
                    $temp = str_replace('[domain]',$user_data['roominfo']['domain'],$temp);
                    $v['url'] = str_replace('[uid]',$user_data['user']['uid'],$temp);
                    if ($v['modulecode'] == 'more') {
                        $v['displayorder'] = $user_data['max_displayorder'] + 1;
                    }
                    if(!empty($user_data['roomtype'])){
                        $v['modulename'] = str_replace('我的班级','我的部门',$v['modulename']);
                        $v['nickname'] = !empty($v['nickname']) ? str_replace('我的班级','我的部门',$v['nickname']) : '';
                        $v['modulename'] = str_replace('我的同学','我的同事',$v['modulename']);
                        $v['nickname'] = !empty($v['nickname']) ? str_replace('我的同学','我的同事',$v['nickname']) : '';
                    }
                }, array(
                    'roominfo' => $roominfo,
                    'max_displayorder' => $max_displayorder,
                    'user' => $user,
					'roomtype' => $room_type
                ));
                $displayorders = array_column($modulelist, 'displayorder');
                //模块排序
                array_multisort($displayorders, SORT_ASC, SORT_NUMERIC,
                    $moduleids, SORT_ASC, SORT_NUMERIC, $modulelist);
                unset($displayorders, $moduleids);
               
            }
			$roomcache->setCache($roominfo['crid'],'other',$modulekey,$modulelist,30);
		}
		// var_dump($modulelist);
		$this->assign('modulelist', $modulelist);
		//签到记录
		$signlib = Ebh::app()->lib('Sign');
		$signstatus = $signlib->getSignStatus(array('uid'=>$user['uid'],'crid'=>$roominfo['crid']));
		$this->assign('continuous',$signstatus['continuous']);
		$this->assign('signed',$signstatus['signed']);

        /*头部链接 end*/
		
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
		$this->assign('clinfo',$clinfo);
		$roomtype = Ebh::app()->room->getRoomType();
		$this->assign('roomtype',$roomtype);
		$conf = Ebh::app()->getConfig()->load('othersetting');
		$conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
		$is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
		$this->assign('is_zjdlr',$is_zjdlr);
        $this->assign('is_newzjdlr',$is_newzjdlr);
        //获取一个学生总学分
        $this->getUserSum($user['uid'],$roominfo['crid']);
		if(!$is_zjdlr){//非国土
			//获取学分
			// $this->getFolderCredit($user['uid'],$roominfo['crid']);
		} else {//国土
            if($is_newzjdlr){
                $this->myarticleCount($user['uid'],$roominfo['crid']);//文章数
                $this->reviewCount($user['uid'],$roominfo['crid']);//评论数
            }
			//粉丝
			$snsmodel = $this->model('Snsbase');
			$mybaseinfo = $snsmodel->getbaseinfo($user['uid']);
			$myfanscount = $mybaseinfo['fansnum'];
			//关注
			$myfavoritcount = $mybaseinfo['followsnum'];

			$this->assign('myfanscount',$myfanscount);
			$this->assign('myfavoritcount',$myfavoritcount);
			
				//评论
				$reviewmodel = $this->model('review');
				$myreviewcount = $reviewmodel->getreviewcount(array('uid'=>$user['uid'],'audit'=>1,'type'=>'courseware', 'rcrid' => $roominfo['crid']));
				$this->assign('myreviewcount', $myreviewcount);
				$surpass_count = $this->model('Roomuser')->getRank($user['credit'], $roominfo['crid']);
				if ($surpass_count !== false) {
					$this->assign('credit_rank', $surpass_count + 1);
				}
				$unit = $this->model('Classes')->getClassInfoByUserids($user['uid'], $roominfo['crid']);
				if (!empty($unit)) {
					$this->assign('unit', $unit[$user['uid']]['classname']);
				}
			
		}
		
		$url = $this->input->get('url');
		$this->assign('url',$url);
		$roomuser = $this->model('roomuser');
		$roomlist = $roomuser->getroomlist($user['uid']);
		$roomcount = $roomuser->getroomcount($user['uid']);
		$this->assign('roomcount',$roomcount);
		$this->assign('roomlist',$roomlist);
		$nophoto = $this->input->cookie('nophoto');	//默认弹出修改头像后是否设置了不再显示
        $this->assign('nophoto', $nophoto);	
        $this->assign('roominfo',$roominfo);
		
		//优惠码
		$mycoupon = $this->model('coupons')->getOne(array('uid'=>$user['uid']));
		$mycoupon = empty($mycoupon['code']) ? '' : $mycoupon['code'];
		$this->assign('mycoupon', $mycoupon);

		$this->display('college/college');
	}
	
	/*
	 *获取学分
	 */
	private function getFolderCredit($uid,$crid){
		$foldercredit = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Member.User.folderCredit')->addParams(array(
                'uid'   =>  $uid,
                'crid' =>	$crid
            ))->request();
		$this->assign('foldercredit',$foldercredit['foldercredit']);
		$this->assign('ltime',$foldercredit['ltime']);
	}
    /*
     *获取单个学生的总学分,学习时长
     */
    private function getUserSum($uid,$crid){
		$redis_name = 'ebh_userstudyinfo_'.$crid;
		$redis_key = $uid;
		$redis = Ebh::app()->getCache('cache_redis');
		
		//先获取缓存
		$scoresum = $redis->hget($redis_name,$redis_key,TRUE);
		if(empty($scoresum)){
			$scoresum = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Classroom.Score.getUserSum')->addParams(array(
				'uid'   =>  $uid,
				'crid' =>	$crid
			))->request();
			if(empty($scoresum)){
				$scoresum = array('scoresum'=>0,'ltime'=>0);
			}
			$redis->hset($redis_name,$redis_key,array('scoresum'=>$scoresum['scoresum'],'ltime'=>$scoresum['ltime']));
		}
		$this->assign('scoresum',$scoresum['scoresum']);
		$this->assign('ltime',$scoresum['ltime']);
    }
    /**
     * 获取指定用户发表的原创文章数量
     */
    private function myarticleCount($uid,$crid){
        $myarticle = Ebh::app()->getApiServer('ebh')->reSetting()->setService('College.Myarticle.myarticleCount')->addParams(array('uid' => $uid,'crid' => $crid))->request();
        if(!empty($myarticle['count'])){
            $this->assign('articlecount',$myarticle['count']);
        }else{
            $this->assign('articlecount',0);
        }
    }
    /**
     * 获取指定用户的评论数量（包含（视频/非视频）课件、原创文章评论）
     */
    private function reviewCount($uid,$crid){
        $reviewcount = Ebh::app()->getApiServer('ebh')->reSetting()->setService('College.Myarticle.reviewCount')->addParams(array('uid' => $uid,'crid' => $crid))->request();
        if(!empty($reviewcount)){
            $this->assign('reviewcount',$reviewcount);
        }else{
            $this->assign('reviewcount',0);
        }
    }


    // 【学生】是否有通知弹窗提醒
    public function getnoticeRemind(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $loginNum = $this->model('Loginlog')->getUserDayLoginNum($user['uid'],SYSTIME);//当日登录次数
        $classmodel = $this->model('Classes');
        $myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
        if(empty($myclass)) {
            $notices = array();
        } else {
            $noticemodel = $this->model('Notice');
            $param = parsequery();
            $param['crid'] = $roominfo['crid'];
            $param['ntype'] = '1,3,4,5';//1为全校师生 3全校学生 4班级学生 5其他
            $param['classid'] = $myclass['classid'];
            $param['remind']='1';//1开启弹窗
            $param['needgrade'] = true;
            $param['needdistrict'] = true;
            $notices = $noticemodel->getnoticelist($param);
            $count = $noticemodel->getnoticelistcount($param);//总的弹窗通知
            // 查询已读的弹窗通知
            $idarr = array();
            $idarr = array_column($notices,'noticeid');
            $readedNum = $noticemodel->getusernoticeCount($user['uid'],$idarr);//已读的弹窗通知
            $unreadNum = $count - $readedNum;//未读的弹窗通知
            if($unreadNum>=1 && $loginNum<=1){
                return renderjson(1,'有弹窗');
            }else{
                return renderjson(0,'无弹窗');
            }
            
        }
    }

    //获取手机端个人中心的模块
    public function getAppModule($crid) {
        if($crid > 0){
            $result = $this->apiServer->reSetting()->setService('Aroomv3.Module.modules')->addParams(array(
                'tor'   =>  0,
                'crid'  =>  $crid
            ))->request();

            if ($result === false) {
                $appmodules = array();
            }
            $appmodules = $result;
        }else{
            $appmodules = array();
        }
        $appmodulesConfig = Ebh::app()->getConfig()->load('appmodule');
        $this->assign('appmodules',$appmodules);
        $this->assign('appmodule_config',$appmodulesConfig);
    }

    /**
     *获取共用的头部和尾部数据
     */
    public function getHeaderAndFooter($roomdetail=NULL) {
        $model = $this->model('portfolio');
        if (!empty($this->user)) {
            $this->user['isadmin'] = $this->user['groupid'] == 5;
            $this->user['showname'] = !empty($this->user['realname']) ? $this->user['realname'] : $this->user['username'];
            $this->user['face'] = getavater($this->user, '120_120');
            $user = array(
                'showname' => $this->user['showname'],
                'groupid' => $this->user['groupid'],
                'isadmin' => $this->user['isadmin'],
                'face' => $this->user['face'],
                'lastlogtime' => $this->user['lastlogintime']
            );
            $this->assign('plateUser', $user);
        }
        if (!empty($this->room)) {
            $room = array(
                'crname' => $this->room['crname'],
                'crphone' => $this->room['crphone'],
                'kefuqq' => $this->room['kefuqq'],
                'summary' => $this->room['summary'],
                'wechatimg' => $this->room['wechatimg'],
                'cface' => $this->room['cface'],
                'lat' => $this->room['lat'],
                'lng' => $this->room['lng'],
                'craddress' => $this->room['craddress']
            );
            $this->assign('plateRoom', $room);
        }
        $this->assign('user', $this->user);
        $this->assign('roominfo', $this->room);
        if (empty($roomdetail)) {
            $roomdetail = $model->getClassroomDetail($this->room['crid']);
        }
        if (!empty($roomdetail['isdesign'])) {
            $room_type = Ebh::app()->room->getRoomType();
            $apiServer = Ebh::app()->getApiServer('ebh');
            $roomtype = Ebh::app()->room->getRoomType();
            $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.getdesign')
                ->addParams('crid', $roomdetail['crid'])
                ->addParams('roomtype', $room_type)
                ->addParams('clientType', is_mobile())
                ->request();
            if (!empty($ret['status'])) {
                $this->assign('head', str_replace('\"', '"', $ret['data']['head']));
                $this->assign('foot', str_replace('\"', '"', $ret['data']['foot']));
                $settings = str_replace('\"', '"', $ret['data']['settings']);
                $settings = json_decode($settings, true);
                $this->assign('settings', $settings);
            }
        }
    }

    /*
    *获取当前的以及域名，如 wl.sy.ebanhui.com 那就为 ebanhui.com sy.ebh.net 则为ebh.net
    */
    function getHostDomainByServer($server_name) {
        $slist = explode('.',$server_name);
        if(empty($slist) || count($slist) < 2)
            return "";
        $seglen = count($slist);
        if(is_numeric($slist[$seglen-1]))
            return "";
        $host = $slist[$seglen - 2].'.'.$slist[$seglen-1];
        return strtolower($host);
    }

}
