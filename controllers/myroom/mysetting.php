<?php
/**
 * 学校学生我的首页 MysettingController
 */
class MysettingController extends CControl {
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			if($roominfo['isschool'] == 7 && $check != 1) {
				$perparam = array('crid'=>$roominfo['crid']);
				$payitem = Ebh::app()->room->getUserPayItem($perparam);
				$this->assign('payitem',$payitem);
				if(!empty($payitem)) {
					$checkurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$payitem['itemid'];	//购买url
					$this->assign('checkurl',$checkurl);
				}

			}
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$nophoto = $this->input->cookie('nophoto');
		$stumodulelist = array();
		if(!empty($roominfo['stumodulepower']))
			$stumodulelist = explode(',',$roominfo['stumodulepower']);
		$this->assign('stumodulelist',$stumodulelist);
		//获取学生我的首页广告
		$admodel = $this->model('Ad');
		$param = array('code'=>'centerbanner','channel'=>'680','folder'=>2,'crid'=>$roominfo['crid'],'limit'=>'0,1');
		$headadkey = $this->cache->getcachekey('ad',$param);
        //$adlist = $this->cache->get($headadkey);
        if(empty($adlist)) {
            $adlist = $admodel->getAdList($param);
            $this->cache->set($headadkey,$adlist,3600);
        }
		$this->assign('adlist',$adlist);

		//我的班级信息
		$cmodel = $this->model('Classes');
		$myclass = $cmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$myclassid = empty($myclass) ? 0 : $myclass['classid'];
		$this->assign('myclass',$myclass);
		//获取通知
		$noticemodel = $this->model('Notice');
        $noticeparam = array('crid'=>$roominfo['crid'],'classid'=>$myclassid,'ntype'=>'1,3,4,5','limit'=>'0,6','needgrade'=>true,'needdistrict'=>true);
        $notices = $noticemodel->getnoticelist($noticeparam);
        $this->assign('notices', $notices);
		//获取最新课件
		// $coursemodel = $this->model('Courseware');
		// $courses = $coursemodel->getnewcourselist(array('crid'=>$roominfo['crid'],'limit'=>'0,3'));
		// $this->assign('courses',$courses);
		//获取最新未答作业
		// $exammodel = $this->model('Exam');
		// $examparam = array('crid'=>$roominfo['crid'],'classid'=>$myclassid,'uid'=>$user['uid'],'filteranswer'=>1,'limit'=>'0,3');
		// $exams = $exammodel->getExamListByMemberid($examparam);
		//签到记录
		$continuous = 0;
		$credit = $this->model('credit');
		$signparam['uid'] = $user['uid'];
		$signlog = $credit->getSignLog($signparam);
		if(!empty($signlog)){
			$lastsign = $signlog[0]['dateline'];
			$today = strtotime('today');
			$todayd = Date('z',SYSTIME);
			if($lastsign>$today){//今天已签到
				$this->assign('signed',1);
				$lastday = $todayd+1;
			}else{//今天未签到
				$lastday = $todayd;
			}
			foreach($signlog as $sign){//按天数倒序计算连续性,2,1,0,364,363...
				$day = Date('z',$sign['dateline']);
				$leap = Date('L',$sign['dateline']);
				
				if($day==$todayd || $lastday-$day==1 || ($leap && $lastday-$day==-365) || (!$leap && $lastday-$day==-364)){
					$lastday = $day;
					$continuous ++;
				}else{
					break;
				}
			}
		}
		$coursemodel = $this->model('courseware');
		$param['folderids'] = '';
		if($roominfo['isschool']==7){
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid']);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}else{
			$foldermodel = $this->model('folder');
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
			$queryarr['crid'] = $roominfo['crid'];
			$queryarr['classid'] = $myclass['classid'];
			if(empty($myclass)){
				$queryarr['classid'] = 0;
			}
			if(!empty($myclass['grade']))
				$queryarr['grade'] = $myclass['grade'];

			$myfolderlist = $foldermodel->getClassFolder($queryarr);
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}
		$param['limit'] = 1;
		$dateoflast = $coursemodel->getRecentCourseCount($param);//最近一次课件
		$dol = SYSTIME;
		if(!empty($dateoflast[0]))
			$dol = $dateoflast[0]['truedateline'];
		$this->assign('dateoflast',$dol);
		$this->assign('continuous',$continuous);
		$this->assign('folderids',$param['folderids']);
		// $this->assign('exams',$exams);
		$this->assign('nophoto',$nophoto);
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->newcourse($roominfo,$user);
		$this->creditRank($roominfo,$user);
        $this->display('myroom/mysetting');
    }
	/*
	签到
	*/
	public function sign(){
		$credit = $this->model('credit');
		$credit->addCreditlog(22);		//jsonp方式
		$callback = $this->input->get('callback');
		if ( ! empty($callback))
		{
			echo $callback.'(1)';
		}
		fastcgi_finish_request();
		//记录到签到表
		$signlib = Ebh::app()->lib('Sign');
		$signlib->addSignLog();
	}
	
	/*
	学习表
	*/
	public function scalendar(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$cmodel = $this->model('Classes');
		$myclass = $cmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$myclassid = empty($myclass) ? 0 : $myclass['classid'];
		
        $type = $this->input->post('type');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
		
        $result = array('examcount'=>array(),'subjectcount'=>array(),'askcount'=>array(),'listencount'=>array());
        if($type === NULL || empty($startDate) || empty($endDate)) {
            echo json_encode($result);
            return;
        }
		$startDate = strtotime($startDate);
		$endDate = strtotime($endDate);
		if($startDate === FALSE || $endDate === FALSE) {
			echo json_encode($result);
            return;
		}
		$endDate = $endDate + 86400;
        $param = array('crid'=>$roominfo['crid'],'startDate'=>$startDate,'endDate'=>$endDate,'classid'=>$myclassid);
		$coursemodel = $this->model('courseware');
		//开通课程的id
		$param['folderids'] = '';
		if($roominfo['isschool']==7){
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid']);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}else{
			$foldermodel = $this->model('folder');
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
			$queryarr['crid'] = $roominfo['crid'];
			$queryarr['classid'] = $myclass['classid'];
			if(!empty($myclass['grade']))
				$queryarr['grade'] = $myclass['grade'];
			$queryarr['pagesize'] = 100;
			$myfolderlist = $foldermodel->getClassFolder($queryarr);
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}
		//学生不需要看见教师草稿箱的作业
		$param['status'] = 1;
		if ($type == 0) {	//获取所有记录
			$result['subjectcount'] = $coursemodel->getRecentCourseCount($param);//课件
            $result['examcount'] = $coursemodel->getRecentExamCount($param);//作业
            $result['askcount'] = $coursemodel->getRecentAskCount($param);//答疑
		}
        echo json_encode($result);
	}
	
	
	//最新课程
	public function newcourse($roominfo,$user){
		$cwmodel = $this->model('courseware');
		//开通课程的id
		if($roominfo['isschool']==7){
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid']);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}else{
			$foldermodel = $this->model('folder');
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
			
			if(empty($myclass)){
				$myclass['classid'] = 0;
			}
			
			$paramf['crid'] = $roominfo['crid'];
			$paramf['classid'] = $myclass['classid'];
			$paramf['limit'] = 100;
			if(!empty($myclass['grade'])){
				$paramf['grade'] = $myclass['grade'];
				$myfolderlist = $foldermodel->getClassFolderWithoutTeacher($paramf);
			}else{
				$myfolderlist = $foldermodel->getClassFolder($paramf);
			}
			if(!empty($myfolderlist)){
				$folderids = '';
				foreach($myfolderlist as $folder){
					$folderids .= $folder['folderid'].',';
				}
				$param['folderids'] = rtrim($folderids,',');
			}
		}
		$param['crid'] = $roominfo['crid'];
		$param['limit'] = 50;
		$param['order'] = 'c.truedateline desc';
		$param['truedatelineto'] = strtotime('tomorrow')+86400;//明天
		$param['truedatelinefrom'] = strtotime('today')-86400*5;//5天前
		$param['power'] = 0;
		$cwlist = $cwmodel->getnewcourselist($param);
		$newcwlist = array();
		
		$redis = Ebh::app()->getCache('cache_redis');
		// var_dump($cwlist);
		
		//以cwid倒序取的数据.
		//按时间排序,有submitat取submitat,没有submitat取dateline.
		/*
		$cwcount = count($cwlist);
		for($i=0;$i<$cwcount;$i++){
			for($j=$i;$j<$cwcount;$j++){
				$date1 = !empty($cwlist[$i]['submitat'])?$cwlist[$i]['submitat']:$cwlist[$i]['dateline'];
				$date2 = !empty($cwlist[$j]['submitat'])?$cwlist[$j]['submitat']:$cwlist[$j]['dateline'];
				if($date1<$date2){
					$temp = $cwlist[$i];
					$cwlist[$i] = $cwlist[$j];
					$cwlist[$j] = $temp;
				}
			}
		}*/
		
		foreach($cwlist as $cw){
			$viewnum = $redis->hget('coursewareviewnum',$cw['cwid']);
			if(!empty($viewnum))
				$cw['viewnum'] = $viewnum;
			// $cw['dateline'] = !empty($cw['submitat'])?$cw['submitat']:$cw['dateline'];
			$dayis = date('Y-m-d',$cw['truedateline']);
			if($dayis == date('Y-m-d'))
				$dayis = 'z今天';
			elseif($dayis == date('Y-m-d',SYSTIME+86400))
				$dayis = 'y明天';
			elseif($dayis == date('Y-m-d',SYSTIME-86400))
				$dayis = 'x昨天';
			$newcwlist[$dayis][] = $cw;
			
		}
		//今天->明天->昨天->[日期]->[日期]...排序
		krsort($newcwlist);
		// var_dump($newcwlist);
		
		//取前20条
		/*
		$showcount = 20;
		$ncwcount = 0;
		$daycount = 0;
		$daylimit = 30; //离列表顶端课件30天的
		$timelimit = $daylimit*86400;
		$topdate = 0;
		foreach($newcwlist as $k=>$daylist){
			if(empty($topdate))
				$topdate = $daylist[0]['dateline'];
			$daycount++;
			foreach($daylist as $l=>$cw){
				$ncwcount++;
				if($ncwcount == $showcount){
					array_splice($newcwlist[$k],$l+1);
					break;
				}
			}
			if($topdate-$daylist[0]['dateline']>$timelimit && $daycount>1){
				array_splice($newcwlist,$daycount-1);
				break;
			}
			if($ncwcount == $showcount){
				array_splice($newcwlist,$daycount);
				break;
			}
		}*/
		// var_dump($newcwlist);
		//服务包限制时间,用于判断往期课件
		$packagelimit = Ebh::app()->getConfig()->load('packagelimit');
		if(in_array($roominfo['crid'],$packagelimit)){
			$pmodel = $this->model('paypackage');
			$datelist = $pmodel->getFirstLimitDate(array('crid'=>$roominfo['crid'],'uid'=>$user['uid']));
			$folderdate = array();
			foreach($datelist as $date){
				$folderdate[$date['folderid']] = $date['firstday'];
			}
			$this->assign('folderdate',$folderdate);
			// var_dump($folderdate);
		}
		$this->assign('newcwlist',$newcwlist);
	}
	
	/*
	积分统计图表
	*/
	public function creditStat(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$datefrom = strtotime($this->input->get('dayfrom'));
		$dateto = strtotime($this->input->get('dayto'));
		$creditmodel = $this->model('credit');
		$rulelist = $creditmodel->getCreditRuleList(array('action'=>'+'));
		$ruleids = '';
		foreach($rulelist as $rule){
			if($rule['ruleid'] != 29)
			$ruleids.= empty($ruleids)?$rule['ruleid']:','.$rule['ruleid'];
		}
		$param['ruleids'] = $ruleids;
		$param['uids'] = $user['uid'];
		$param['group'] = ' d ';
		$param['datefrom'] = $datefrom;
		$param['dateto'] = $dateto+86400;
		// var_dump($param);
		$mycclist = $creditmodel->getCreditComingList($param);//我的积分记录
		
		$redis = Ebh::app()->getCache('cache_redis');
		$crcclist = $redis->hget('credit',$roominfo['crid']);
		$crcclist = unserialize($crcclist);
		// var_dump($crcclist);
		$fromcache = true;
		$rumodel = $this->model('roomuser');
		$usercount = $rumodel->getUserCountWhoLoged($roominfo['crid']);
		if(empty($crcclist)){
			// if($roominfo['domain'] == 'jx')
			$rulist = $rumodel->getUserListWhoLoged($roominfo['crid']);
			// else
				// $rulist = $rumodel->getroomuserlist(array('crid'=>$roominfo['crid'],'pagesize'=>1000));//学校学生列表
			$uids = '';
			foreach($rulist as $ru){
				$uids.= $ru['uid'].',';
			}
			
			$param['uids'] = rtrim($uids,',');
			$crcclist = $creditmodel->getCreditComingList($param);//全校积分记录
			
			foreach($crcclist as $crcredit){
				$creditcache[Date('Y/m/d',$crcredit['dateline'])] = $crcredit['sumcredit'];
			}
			// var_dump($creditcache);
			$redis->hset('credit',$roominfo['crid'],$creditcache);
			$fromcache = false;
		}
		// var_dump($rulist);
		$str = '"day,我的积分,全校平均积分\n';
		// var_dump($crcclist);
		$dayarr = array();

		foreach($mycclist as $k=>$mycredit){
			$dayarr[Date('Y/m/d',$mycredit['dateline'])] = Date('Y/m/d',$mycredit['dateline']).','.$mycredit['sumcredit'].',';
		}
		//var_dump($dayarr);
		foreach($crcclist as $k=>$crcredit){
			if(empty($fromcache)){
				$day = Date('Y/m/d',$crcredit['dateline']);
				$avg = ceil($crcredit['sumcredit']/$usercount);
			}else{
				$day = $k;
				$avg = ceil($crcredit/$usercount);
			}
			if($day >= Date('Y/m/d',$param['datefrom']) && $day < Date('Y/m/d',$param['dateto'])){
				if(empty($dayarr[$day]))
					$dayarr[$day]= $day.',0,'.$avg.'\n';
				else
					$dayarr[$day].= $avg.'\n';
			}
		}//var_dump($dayarr);
		for($i=$param['datefrom'];$i<$param['dateto'];$i=$i+86400){
			$day = Date('Y/m/d',$i);
			if(empty($dayarr[$day]))
				$dayarr[$day] = $day.',0,0\n';
			elseif(substr($dayarr[$day],-2,2)!='\n')
				$dayarr[$day].= '0\n';
		}
		ksort($dayarr);
		
		
		foreach($dayarr as $k=>$day){
			$str.= $day;
		}
		$str.= '"';
		echo $str;
		
	}
	
	/*
	积分排名
	*/
	protected function creditRank($roominfo,$user){
		$crid = $roominfo['crid'];
		$creditmodel = $this->model('credit');
		$ranklist = $creditmodel->getRankList(array('crid'=>$crid));
		$this->assign('ranklist',$ranklist);
		
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
		// var_dump($clconfig);
	}
}
