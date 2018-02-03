<?php

/**
 * 教师后台首页入口控制器
 */
class TroomController extends CControl {

    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }

    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $this->assign('roominfo', $roominfo);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
        //教学记录
        $this->getteachrecord();

		$this->newcourse();
        //通知
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $noticemodel = $this->model('Notice');
        $param = parsequery();
        $param['type'] = '0';
        $param['crid'] = $roominfo['crid'];
        $param['ntype'] = '1,2';
        $param['limit'] = '0,7';
        $notices = $noticemodel->getnoticelist($param);
        $this->assign('notices',$notices);

        //签到记录
		$signlib = Ebh::app()->lib('Sign');
		$signstatus = $signlib->getSignStatus(array('uid'=>$user['uid'],'crid'=>$roominfo['crid']));
		$this->assign('continuous',$signstatus['continuous']);
		$this->assign('signed',$signstatus['signed']);
		$this->assign('monnum',$signstatus['monnum']);

        //我的课程
        $classsubjectmodel = $this->model('Classsubject');
        $page = $this->uri->page;
        $subjectlist = $classsubjectmodel->getsubjectlistbytid($roominfo['crid'],$user['uid']);
        $this->assign('subjectlist', $subjectlist);
        $folderids = '';
        $subjectlistByFolderid = array();
        if (!empty($subjectlist)) {
            foreach($subjectlist as $subject){
                $subject['pname'] = '其他课程';
                $subjectlistByFolderid[$subject['folderid']] = $subject;
                $folderids.= $subject['folderid'].',';
            }
        }
        $folderids = rtrim($folderids,',');
        $folderByPid = array();
        if(!empty($folderids)){
            $packagemodel = $this->model('Paypackage');
            $packages = $packagemodel->getPackByFolderid(array('folderids'=>$folderids,'crid'=>$roominfo['crid']));
            // var_dump($packages);
            foreach($packages as $package){
                if(empty($folderByPid[$package['pid']]))
                    $folderByPid[$package['pid']] = array($package);
                else
                    $folderByPid[$package['pid']][] = $package;
                unset($subjectlistByFolderid[$package['folderid']]);
            }
            sort($subjectlistByFolderid);
            $folderByPid[0] = $subjectlistByFolderid;
        }
        // var_dump($folderByPid);


        //积分排名
        $params['crid']=$roominfo['crid'];
        $params['credit']=$user['credit'];
        $params['type']='h';
        $m = $this->model('credit')->getTeacherCreditList($params);
        $creditinfo=array(
            'realname'=>empty($user['realname'])?$user['username']:$user['realname'],
            'credit'=>$user['credit'],
            'mine'=>'1',
        );
        $m[]=$creditinfo;
        $params['type']='l';
        $params['uid']=$user['uid'];
        $m2 = $this->model('credit')->getTeacherCreditList($params);
        if (empty($m2)) {
            $m2 = array();
        }
        $Cinfo=array_merge($m,$m2);
        $i=1;
        $ranking=array();
        foreach($Cinfo as $v){
			$rname = empty($v['realname'])?$v['username']:$v['realname'];
            $ranking['name'][]='"<b>'.shortstr($rname,8).'</b>"';
            if(isset($v['mine'])&&$v['mine']==1){
                $ranking['credit'][] = '{"color":"#ff9024",y:'.intval($v['credit']).'}';
            }else{
                $ranking['credit'][] = intval($v['credit']);
            }
            $i++;
            if($i>12) break;
        }

        // 过滤按分类收费的课程
        if (!empty($folderByPid)) {
            $sidArr = array();
            foreach ($folderByPid as $value) {
                foreach ($value as $val) {
                    if(!empty($val)&&!empty($val['sid'])){
                        $sidArr[] = $val['sid'];
                    }
                }
            }
            $sidArr = array_unique($sidArr);
        }
		if(!empty($sidArr))
			$nowshowArr = $this->model('Paypackage')->checkRepeatPackage($sidArr);
        //var_dump($nowshowArr);
        if (!empty($folderByPid)) {
            foreach ($folderByPid as $key => &$value) {
                foreach ($value as $kk=> &$val) {
                    if (!empty($val['sid']) && !empty($nowshowArr)) {
                        if (in_array($val['sid'], $nowshowArr)) {
                            unset($value[$kk]);
                        }
                    }
                }
            }
        }

        //重新排列课程数组下标  从0开始
        foreach($folderByPid as $ks =>$folderArr){
            $nArr = array();
            if(!empty($folderArr)){
                foreach($folderArr as $itemArr){
                    $nArr[] = $itemArr;
                }
                $folderByPid[$ks] = $nArr;
            }else{
                unset($folderByPid[$ks]);
            }
        }

        $ranking['name']=implode(',',$ranking['name']);
        $ranking['credit']=implode(',',$ranking['credit']);
        $this->assign('rank',$ranking);
        $this->assign('roominfo',$roominfo);
        $this->assign('folderbypid',$folderByPid);
        $this->display('troomv2/index');
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
//            $result['subjectcount'] = $coursemodel->getRecentCourseCount($param);//课件
//            $result['examcount'] = $coursemodel->getRecentExamCount($param);//作业
            // $result['askcount'] = $coursemodel->getRecentAskCount($param);//答疑
            // $result['signcount'] = $this->model('credit')->getSign($param);
			$data['uid'] = $param['uid'];
			$data['crid'] = $param['crid'];
			$data['starttime'] = $param['startDate'];
			$data['endtime'] = $param['endDate'];
			$data['byday'] = 1;
			$result['signcount'] = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Member.User.signList')->addParams($data)->request();
			
        }
        // var_dump($result);
        echo json_encode($result);
    }

    //获取教师教学记录
    public function getteachrecord(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $recordinfo='';

        //作业
        $param['crid']=$roominfo['crid'];
        $examcount_all=$this->model('exam')->getschexamlistcount($param);
        $param['tid']=$user['uid'];
        $examcount_t=$this->model('exam')->getschexamlistcount($param);
        $exam=$examcount_all == 0 ? 0 : ceil($examcount_t/$examcount_all*100);
        if($exam>50) $exam=50;
        $recordinfo=$exam;

        //互动
        unset($param['tid']);
        $iacount_all = $this->model('iaclassroom')->getListCount($param);
        $param['uid']=$user['uid'];
        $iacount_t = $this->model('iaclassroom')->getListCount($param);
        $ia=$iacount_all == 0 ? 0 : ceil($iacount_t/$iacount_all*100);
        if($ia>50) $ia=50;
        $recordinfo.=','.$ia;

        //附件
        $attachcount_t = $this->model('attachment')->getlistcountwithcourse($param);
        unset($param['uid']);
        $attachcount_all = $this->model('attachment')->getlistcountwithcourse($param);
        $attach=$attachcount_all == 0 ? 0 : ceil($attachcount_t/$attachcount_all*100);
        if($attach>50) $attach=50;
        $recordinfo.=','.$attach;

        //评论
        $reviewcount_all = $this->model('review')->getreviewlistcountbycrid($param);
        $param['uid'] = $user['uid'];
        $reviewcount_t = $this->model('review')->getreviewlistcountbycrid($param);
        $review=$reviewcount_all == 0 ? 0 : ceil($reviewcount_t/$reviewcount_all*100);
        if($review>50) $review=50;
        $recordinfo.=','.$review;

        //答疑
        $answercount_t = $this->model('askquestion')->getAnswersCount($param,false);
        unset($param['uid']);
        $answercount_all = $this->model('askquestion')->getAnswersCount($param,false);
        $answer=$answercount_all == 0 ? 0 : ceil($answercount_t/$answercount_all*100);
        if($answer>50) $answer=50;
        $recordinfo.=','.$answer;

        //课件
        $coursecount_all = $this->model('courseware')->getTcoursecount($param);
        $param['uid']=$user['uid'];
        $coursecount_t = $this->model('courseware')->getTcoursecount($param);
        $course=$coursecount_all['count'] == 0 ? 0 : ceil($coursecount_t['count']/$coursecount_all['count']*100);
        if($course>50) $course=50;
        $recordinfo.=','.$course;
        $this->assign('recordinfo',$recordinfo);
    }
	
	/*
	最新课程
	*/
	private function newcourse(){
        $roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param['status'] = 1;
		$param['limit'] = 200;
		$param['order'] = 'c.truedateline asc';
		$param['truedatelineto'] = strtotime('today')+86400*7;//七天内
		$param['truedatelinefrom'] = strtotime('today');
		$param['crid'] = $roominfo['crid'];
		$cwlist = $this->model('courseware')->getnewcourselist($param);
		$cwarr = array();
		$cwcount = 0;
		$newcwlist = array();
		if (!empty($cwlist)) {
            foreach($cwlist as $cw){
                if($cw['uid'] != $user['uid']){
                    $assistantidarr = explode(',',$cw['assistantid']);
                    if(!in_array($user['uid'],$assistantidarr)){
                        continue;
                    }
                }
                $dayis = date('Y-m-d',$cw['truedateline']);
                if($dayis == date('Y-m-d'))
                    $dayis = 'z今天';
                elseif($dayis == date('Y-m-d',SYSTIME+86400))
                    $dayis = 'y明天';
                elseif($dayis == date('Y-m-d',SYSTIME-86400))
                    $dayis = 'x昨天';
                $newcwlist[$dayis][] = $cw;
                $cwcount ++;
                if($cwcount>=20){
                    break;
                }
            }
        }

		if(!empty($newcwlist['z今天'])){
			//今天的单独处理下
			$totaycourses = $newcwlist['z今天'];
			$todaylist = $this->sortTodayCourse($totaycourses);
			unset( $newcwlist['z今天']);
			$newcwlist['z今天'] = array_merge_recursive($todaylist['staring'],$todaylist['coming'],$todaylist['expired']);
		}
		//正在上课->即将开课->已结束（今天）->明天->昨天->[日期]->[日期]...排序
		krsort($newcwlist);
		$this->assign('newcwlist',$newcwlist);
	}
	
	/**
	 * 今天的课程 排序处理 
	 * 按照 正在上课->即将开课->已结束
	 */
	private function sortTodayCourse($courselist){
	    $todaylist = array('staring'=>array(),'coming'=>array(),'expired'=>array());
	    if(empty($courselist))
	        return false;
	    foreach ($courselist as $course){
	        $starttime = $course['truedateline'];//开始时间
	        $cwlenth = $course['cwlength'];//课件时长
	        $nowtime = SYSTIME;//当前时间
	        if($nowtime <= $starttime){
	            //即将开始
	            $course['todaysort'] = 'coming';
	            $todaylist['coming'][] = $course;
	        }elseif(!empty($cwlenth) && ($nowtime>=$starttime) && (($starttime+$cwlenth) >= $nowtime) && (empty($course['endat']) || $course['endat']>=$nowtime)){
	            //正在上课
	            $course['todaysort'] = 'staring';
	            $todaylist['staring'][] = $course;
	        }elseif($nowtime > ($starttime+$cwlenth) || (!empty($course['endat']) && $nowtime>$course['endat'])){
	            //已结束
	            $course['todaysort'] = 'expired';
	            $todaylist['expired'][] = $course;
	        }
	    }
	    
	    return $todaylist;
	}
}
