<?php

/**
 * 教师后台首页入口控制器
 */
class DefaultController extends CControl {

    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }

    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$trmodel = $this->model('teacher');

		//学校后台禁用
		$rteacher = $trmodel->getroomteacherdetail($user['uid'],$roominfo['crid']);
		if(!empty($rteacher) && $rteacher['status'] == 0){
			header('Location: /loginlimit/blacklist/user.html');
			exit;
		}
        $this->assign('roominfo', $roominfo);
        $this->assign('room', $roominfo);
        $this->assign('user', $user);
        $ammodel = $this->model('appmodule');
        //分配教师模块
        //顶部模块
        $modulelist = $ammodel->getmodulelist(array('system'=>1,'limit'=>200,'tors'=>'1,2'), true);
		//网校教师模块配置
        $custom_modulelist = $ammodel->getRoomSet(array('crid'=>$roominfo['crid'],'order'=>'displayorder','limit'=>200,'tors'=>'1,2', 'showmode' => 0), true);
        if (!empty($custom_modulelist)) {
			foreach ($custom_modulelist as $moduleid => $custom_moduleitem) {
				$modulelist[$moduleid] = $custom_moduleitem;
			}
			unset($custom_modulelist);
        }
		$modulelist = array_filter($modulelist, function($module) {
            return !isset($module['available']) || !empty($module['available']);
        });
        //读取角色权限模块
        $api = Ebh::app()->getApiServer('ebh');
        $ret = $api->reSetting()
            ->setService('Role.TeacherRole.getTeacherRole')
            ->addParams('crid', $roominfo['crid'])
            ->addParams('tid', $user['uid'])
            ->request();
        if (is_array($ret)) {
            if ($ret['category'] == 1) {
                $moduleTmp = $modulelist;
                $modulelist = array();
                $moduleids = json_decode($ret['permissions'], true);
				
                if (!empty($moduleids) && is_array($moduleids)) {
                    //分配角色模块
                    foreach ($moduleTmp as $tmp) {
                        if (in_array($tmp['moduleid'], $moduleids)) {
                            $tmp['available'] = true;
                            $modulelist[] = $tmp;
                        }
                    }
					$this->assign('rolename', $ret['rolename']);
                }
            } else {
				$moduleids = json_decode($ret['permissions'], true);
				//ak decode,查看uid是否为登录账号uid
				$ak = $this->input->cookie('ak');
				$authstr = authcode($ak,'DECODE');
				$uidindex = strpos($authstr,Chr(9))+1;
				$authuid = substr($authstr,$uidindex);
				
				if($user['uid'] != $roominfo['uid'] && $authuid == $user['uid'] && !empty($moduleids)){//自己登录，不是从aroom进入老师后台的情况
					$this->assign('adminRole', true);
				}
				if (!empty($moduleids) && is_array($moduleids)) {
					$this->assign('rolename', $ret['rolename']);
				}
            }
        }

        if (!empty($modulelist)) {
            //模块排序
            $displayorder = array_column($modulelist, 'displayorder');
            $moduleids = array_keys($modulelist);
            array_multisort($displayorder, SORT_ASC, SORT_NUMERIC,
                $moduleids, SORT_ASC, SORT_NUMERIC, $modulelist);
        }
        foreach($modulelist as $k=>$module){
            if(!empty($systemonly) && $module['moduleid']==6){
                unset($modulelist[$k]);
                continue;
            }
            if($module['moduleid'] == 17 && $roominfo['property'] == 3 && (empty($module['nickname']) || $module['nickname'] == '微校通')){ //企业版，微校通显示为企业微信
                $modulelist[$k]['nickname'] = '企业微信';
            }
            $temp = str_replace('[crid]',$roominfo['crid'],$module['url_t']);
            $temp = str_replace('[domain]',$roominfo['domain'],$temp);
            $modulelist[$k]['url_t'] = str_replace('[uid]',$user['uid'],$temp);
        }
		$this->assign('modulelist', $modulelist);
		
		
		//积分等级
		$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
		$clinfo = array('percent'=>10,'title'=>'训导');
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
		
		//粉丝
		$snsmodel = $this->model('Snsbase');
		$mybaseinfo = $snsmodel->getbaseinfo($user['uid']);
		$myfanscount = $mybaseinfo['fansnum'];
		//关注
		$myfavoritcount = $mybaseinfo['followsnum'];
		$this->assign('myfanscount',$myfanscount);
		$this->assign('myfavoritcount',$myfavoritcount);

		

        $this->display('troomv2/troom');
    }
	
	// 判断是否弹窗

	 public function getpercent($user){
    	$pc = 50;
    	if($user['face'])
    		$pc+=10;
    	$mmodel = $this->model('Member');
    	$info = $mmodel->getfullinfoT($user['uid']);
    	unset($info['uid'],$info['realname'],$info['face']);
    	foreach($info as $value){
    		if(!empty($value))
    			$pc+=2;
    	}
    	if($pc>100){$pc=100;}
    	return $pc;
    }

    /**
         * [getmsgAjax 通过ajax获取老师端的问题数（新问题+新回答）]
         * @return [type] [description]
         */
        public function getmsgAjax(){
            $user = Ebh::app()->user->getloginuser();
            $roominfo = Ebh::app()->room->getcurroom();
            if(empty($user) || empty($roominfo)) {
                echo json_encode(array('total'=>0));
                exit();
            }
            $unreadlist = Ebh::app()->lib('EMessage')->getUnReadCount($user['uid'],$roominfo['crid']);
            $data = array();
            $data['total'] = 0;
            if (!empty($unreadlist))
            {
                foreach ($unreadlist as $key => $value)
                {
                    $data['type_' . $key] = intval($value);
                    
                }
                if (!empty($data['type_2']))
                	$data['total'] += $data['type_2'];
                if (!empty($data['type_5']))
                	$data['total'] += $data['type_5'];
            }
            echo json_encode($data);
        }


        // 【教师】是否有通知弹窗提醒
        public function getnoticeRemind(){
            $roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getloginuser();
            $loginNum = $this->model('Loginlog')->getUserDayLoginNum($user['uid'],SYSTIME);//当日登录次数
            $noticemodel = $this->model('Notice');
            $param = parsequery();
            $param['type'] = '0';//0为学校管理员发送的，1为普通老师发送
            $param['crid'] = $roominfo['crid'];
            $param['ntype'] = '1,2';//1为全校师生 2为全校教师
            $param['remind']='1';//1开启弹窗
            $notices = $noticemodel->getnoticelist($param);
            $count = $noticemodel->getnoticelistcount($param);//总的弹窗通知
            // 查询已读的弹窗通知
            $idarr = array();
            $idarr=array_column($notices,'noticeid');
            $readedNum=$noticemodel->getusernoticeCount($user['uid'],$idarr);//已读的弹窗通知
            $unreadNum=$count-$readedNum;//未读的弹窗通知
            if($unreadNum>=1 && $loginNum<=1){
                return renderjson(1,'有弹窗');
            }else{
                return renderjson(0,'无弹窗');
            }

        }


}
