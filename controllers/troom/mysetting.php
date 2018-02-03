<?php
/**
 * 教师我的首页控制器MysettingController
 */
class MysettingController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $this->assign('room', $roominfo);
        $this->assign('user', $user);
		$coursemodel = $this->model('courseware');
        if($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {  //学校类型
            $noticemodel = $this->model('Notice');
            $noticeparam = array('crid'=>$roominfo['crid'],'ntype'=>'1,2','limit'=>'0,6');
            $notices = $noticemodel->getnoticelist($noticeparam);
            $this->assign('notices', $notices);
            
            $courseparam = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'limit'=>'0,2','power'=>'0,1');
            $courses = $coursemodel->getnewcourselist($courseparam);
            $this->assign('courses', $courses);
            $exammodel = $this->model('exam');
            $examparam = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'limit'=>'0,3','getall'=>true);
            $exams = $exammodel->getnewexamlist($examparam);
            $this->assign('exams', $exams);
			
			//向我提的问题
			$askparam['crid'] = $roominfo['crid'];
			$askparam['tid'] = $user['uid'];
			$askparam['shield'] = 0;
			$askparam['pagesize'] = 10;
			$askmodel = $this->model('Askquestion');
			$asks = $askmodel->getallasklist($askparam);
			$this->assign('asks', $asks);
        } else {    //网校类型
            $answermodel = $this->model('Examanswer');
            $answerparam = array('crid'=>$roominfo['crid'],'limit'=>'0,5');
            $answers = $answermodel->getnewsanswers($answerparam);
            $this->assign('answers', $answers);
            $askmodel = $this->model('Askquestion');
            $askparam = array('crid'=>$roominfo['crid'],'limit'=>'0,5');
            $asks = $askmodel->getnewasklistbycrid($askparam);
            $this->assign('asks', $asks);
        }
		
		//最近一次课件
		$param['crid'] = $roominfo['crid'];
		$param['limit'] = 1;
		$param['uid'] = $user['uid'];
		$dateoflast = $coursemodel->getRecentCourseCount($param);
		$dol = SYSTIME;
		if(!empty($dateoflast[0]))
			$dol = $dateoflast[0]['truedateline'];
		$this->assign('dateoflast',$dol);
		
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
		$this->assign('continuous',$continuous);

        $_SMS = EBH::app()->getConfig()->load('sms');
        if(in_array($roominfo['crid'], $_SMS['crids'])){//特殊学校未回答课程问题数(如杭四中)
			$queryarr = parsequery();
			$queryarr['crid'] = $roominfo['crid'];
			$queryarr['shield'] = 0;
			$queryarr['answered'] = 1;
			$askmodel = $this->model('Askquestion');
			$folderlist = $this->model('folder')->getTeacherFolderList($queryarr);
			$folderids = array();
			$folders = current($folderlist);
			if($this->input->get('folderid')){
				$folderid = $this->input->get('folderid');
				$this->assign('checkfolderid',$folderid);
				$folderids = array(intval($folderid));
			}else{
				foreach ($folders['folder'] as  $value) {
					$folderids[] = $value['folderid'];
				}
			}
            $folderid = $this->input->get('folderid');
            $queryarr['tid'] = $user['uid'];
            $queryarr['folderid'] = intval($folderid);
            $askList = $askmodel->getRequiredAnswers($queryarr);
            $userdata = EBH::app()->lib('UserUtil')->init($askList,array('uid'));
            $asks = array();
            foreach ($askList as $ask) {
                $userdata->setUser($ask['uid']);
                $ask['username'] = $userdata->getUsername();
                $ask['realname'] = $userdata->getRealname();
                $ask['face'] = $userdata->getFace();
                $ask['sex'] = $userdata->getSex(false);
                $ask['groupid'] = $userdata->getGroupId();
                $asks[] = $ask;
            }
            $count = $askmodel->getRequiredAnswersCount($queryarr);
            $this->assign('requiredTeacher',true);

			//课件的评论未回复数
			$param['crid'] = $roominfo['crid'];
			$param['replysubject'] = '';
			$param['opid'] = 8192;
			$param['type'] = 'courseware';
			$param['shield'] = 0;
			$reviewmodel = $this->model('review');
			$creview = $reviewmodel->getreviewlistcountbycrid($param);

        }else{
		//课程提问老师未回答数(课程问题-课程提问该老师已回答数)
			$queryarr = parsequery();
			$queryarr['crid'] = $roominfo['crid'];
			$queryarr['shield'] = 0;
			$queryarr['uid'] = $user['uid'];
			$askmodel = $this->model('Askquestion');
			$folderlist = $this->model('folder')->getTeacherFolderList($queryarr);
			$folderids = array();
			$folders = current($folderlist);
			if($this->input->get('folderid')){
				$folderid = $this->input->get('folderid');
				$this->assign('checkfolderid',$folderid);
				$folderids = array(intval($folderid));
			}else{
				foreach ($folders['folder'] as  $value) {
					$folderids[] = $value['folderid'];
				}
			}
            $countc = $askmodel->getcoursequestionscount($folderids,$queryarr);//课程问题数
			$countq = $askmodel->getcoursequestionedcount($folderids,$queryarr);
			//未回答课程问题数(普通学校)
			$count = $countc-$countq;

			//课件的评论未回复数
			$param['crid'] = $roominfo['crid'];
			$param['replysubject'] = '';
			$param['opid'] = 8192;
			$param['type'] = 'courseware';
			$param['shield'] = 0;
			$reviewmodel = $this->model('review');
			$creview = $reviewmodel->getreviewlistcountbycrid($param);
        }
		
		//$this->creditRank($roominfo,$user);
		$this->assign("creview",$creview);
		
		$this->assign('count', $count);
        $this->display('troom/mysetting');
    }
	
	public function scalendar(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
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
        $param = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'startDate'=>$startDate,'endDate'=>$endDate);
		$coursemodel = $this->model('courseware');
		
		if ($type == 0) {	//获取所有记录
			$result['subjectcount'] = $coursemodel->getRecentCourseCount($param);//课件
            $result['examcount'] = $coursemodel->getRecentExamCount($param);//作业
            // $result['askcount'] = $coursemodel->getRecentAskCount($param);//答疑
		}
		// var_dump($result);
        echo json_encode($result);
	}
	
	/*
	签到
	*/
	public function sign(){
		$credit = $this->model('credit');
		$credit->addCreditlog(22);
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
		$this->assign('clinfo',$clinfo);
		// var_dump($clconfig);
	}
}
