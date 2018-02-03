<?php
/*
学习分析
*/
class AnalysisController extends CControl{
	
	public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo',$roominfo);
		$this->display('myroom/analysis');
	}
	//活跃
	public function active(){
		$chart = Ebh::app()->lib('ChartLib');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$analysismodel = $this->model('analysis');
		$daystate = $this->input->get('daystate')==NULL?1:intval($this->input->get('daystate'));
		if($daystate>4){
			$daystate = 5;
			$param['dayfrom'] = strtotime($this->input->get('dayfrom'));
			$param['dayto'] = strtotime($this->input->get('dayto')) + 86400;
			$this->assign('dayfrom',$this->input->get('dayfrom'));
			$this->assign('dayto',$this->input->get('dayto'));
		}else{
			$param = $this->getDayPeriod($daystate);
		}
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$myaskcount = intval($analysismodel->getAskCount($param));
		$myanswercount = intval($analysismodel->getAnswerCount($param));
		$myreviewcount = intval($analysismodel->getReviewCount($param));
		
		
		$param['needall'] = 1;
		$allaskcount = intval($analysismodel->getAskCount($param));
		$allanswercount = intval($analysismodel->getAnswerCount($param));
		$allreviewcount = intval($analysismodel->getReviewCount($param));
		
		
		
		$classstunum = intval($analysismodel->getclassmatecount($user['uid'],$roominfo['crid']));
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		
		$datamy = $myaskcount+$myanswercount+$myreviewcount;
		$dataall = $allaskcount+$allanswercount+$allreviewcount;;
		
		if(!empty($myclass)){
			$param['needclass'] = 1;
			$classaskcount = intval($analysismodel->getAskCount($param));
			$classanswercount = intval($analysismodel->getAnswerCount($param));
			$classreviewcount = intval($analysismodel->getReviewCount($param));
			$dataclass = $classaskcount+$classanswercount+$classreviewcount;
			$datas['同班同学的'] = ceil($dataclass/$classstunum);
			$datasask['同班同学的'] = ceil($classaskcount/$classstunum);
			$datasanswer['同班同学的'] = ceil($classanswercount/$classstunum);
			$datasreview['同班同学的'] = ceil($classreviewcount/$classstunum);
			$comparedata['class'] = $dataclass;
		}
		
		
		$datas['我的'] = $datamy;
		$datas['全校同学的'] = ceil($dataall/$roomdetail['stunum']);
		
		$dataarr = array(
			'caption'=>'活跃指数表',
			'datas'=>$datas
		);
		
		$datasask['我的'] = $myaskcount;
		$datasask['全校同学的'] = ceil($allaskcount/$roomdetail['stunum']);
		$dataarrask = array(
			'caption'=>'提问数',
			'datas'=>$datasask
		);
		
		$datasanswer['我的'] = $myanswercount;
		
		$datasanswer['全校同学的'] = ceil($allanswercount/$roomdetail['stunum']);
		$dataarranswer = array(
			'caption'=>'解答数',
			'datas'=>$datasanswer
		);
		
		$datasreview['我的'] = $myreviewcount;
		$datasreview['全校同学的'] = ceil($allreviewcount/$roomdetail['stunum']);
		$dataarrreview = array(
			'caption'=>'评论数',
			'datas'=>$datasreview
		);
		
		if(!empty($myclass)){
			$this->assign('classaskcount',$classaskcount);
			$this->assign('classanswercount',$classanswercount);
			$this->assign('classreviewcount',$classreviewcount);
			
			$comparedata['my'] = $datamy;
			$judgement = $this->getJudgement($comparedata,$classstunum);
			$this->assign('judgement',$judgement);
		}
		$this->assign('myclass',$myclass);
		$this->assign('daystate',$daystate);
		$this->assign('chart',$chart);
		$this->assign('myaskcount',$myaskcount);
		$this->assign('myanswercount',$myanswercount);
		$this->assign('myreviewcount',$myreviewcount);
		$this->assign('allaskcount',$allaskcount);
		$this->assign('allanswercount',$allanswercount);
		$this->assign('allreviewcount',$allreviewcount);
		
		$this->assign('dataarr',$dataarr);
		$this->assign('dataarrask',$dataarrask);
		$this->assign('dataarranswer',$dataarranswer);
		$this->assign('dataarrreview',$dataarrreview);
		$this->display('myroom/analysis_active');
	}
	//勤奋
	public function hardwork(){
		$chart = Ebh::app()->lib('ChartLib');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getClassByUid($roominfo['crid'],$user['uid']);
		$analysismodel = $this->model('analysis');
		$daystate = $this->input->get('daystate')==NULL?1:intval($this->input->get('daystate'));
		if($daystate>4){
			$daystate = 5;
			$param['dayfrom'] = strtotime($this->input->get('dayfrom'));
			$param['dayto'] = strtotime($this->input->get('dayto')) + 86400;
			$this->assign('dayfrom',$this->input->get('dayfrom'));
			$this->assign('dayto',$this->input->get('dayto'));
		}else{
			$param = $this->getDayPeriod($daystate);
		}
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		
		$myexamcount = intval($analysismodel->getExamCount($param));
		$mystudycount = intval($analysismodel->getStudyCount($param));
		
		$param['needall'] = 1;
		$allexamcount = intval($analysismodel->getExamCount($param));
		$allstudycount = intval($analysismodel->getStudyCount($param));
		$classstunum = intval($analysismodel->getclassmatecount($user['uid'],$roominfo['crid']));
		$datamy = $myexamcount + $mystudycount;
		$dataall = $allexamcount + $allstudycount;
		if(!empty($myclass)){
			$param['needclass'] = 1;
			$classexamcount = intval($analysismodel->getExamCount($param));
			$classstudycount = intval($analysismodel->getStudyCount($param));
			$dataclass = $classexamcount + $classstudycount;
			$datas['同班同学的'] = ceil($dataclass/$classstunum);
			$datasexam['同班同学的'] = ceil($classexamcount/$classstunum);
			$datasstudy['同班同学的'] = ceil($classstudycount/$classstunum);
			$comparedata['class'] = $dataclass;
			$comparedata['my'] = $datamy;
		}
		
		
		
		
		
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		
		$datas['我的'] = $datamy;
		$datas['全校同学的'] = ceil($dataall/$roomdetail['stunum']);
		$dataarr = array(
			'caption'=>'勤奋指数表',
			'datas'=>$datas
		);
		
		
		$datasexam['我的'] = $myexamcount;
		$datasexam['全校同学的'] = ceil($allexamcount/$roomdetail['stunum']);
		$dataarrexam = array(
			'caption'=>'作业数',
			'datas'=>$datasexam
		);
		
		$datasstudy['我的'] = $mystudycount;
		
		$datasstudy['全校同学的'] = ceil($allstudycount/$roomdetail['stunum']);
		$dataarrstudy = array(
			'caption'=>'听课数',
			'datas'=>$datasstudy
		);
		
		if(!empty($myclass)){
			$judgement = $this->getJudgement($comparedata,$classstunum);
			$this->assign('judgement',$judgement);
			$this->assign('classexamcount',$classexamcount);
			$this->assign('classstudycount',$classstudycount);
		}
		$this->assign('myclass',$myclass);
		$this->assign('daystate',$daystate);
		$this->assign('chart',$chart);
		$this->assign('myexamcount',$myexamcount);
		$this->assign('allexamcount',$allexamcount);
		$this->assign('mystudycount',$mystudycount);
		$this->assign('allstudycount',$allstudycount);
		$this->assign('dataarr',$dataarr);
		$this->assign('dataarrexam',$dataarrexam);
		$this->assign('dataarrstudy',$dataarrstudy);
		$this->display('myroom/analysis_hardwork');
	}
	//能力
	public function capability(){
		$chart = Ebh::app()->lib('ChartLib');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$analysismodel = $this->model('analysis');
		
	}
	//强弱
	public function advantage(){
		
		$chart = Ebh::app()->lib('ChartLib');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$analysismodel = $this->model('analysis');
		$daystate = $this->input->get('daystate')==NULL?1:intval($this->input->get('daystate'));
		$param = $this->getDayPeriod($daystate);
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$mylist = $analysismodel->getExamList($param);

		foreach($mylist as $ml){
			$answersarr = unserialize($ml['answers']);
			foreach($answersarr as $answers){
			// var_dump($answers);
				// if(is_array($answers['answers'])){
					// foreach($answers['answers'] as $answer){
						// echo $answer;
					// }
				// }else{
					echo $answers['answers'].'.';
				// }
			}
			
			
		}//var_dump($mylist);
		$this->assign('daystate',$daystate);
		$this->assign('chart',$chart);
		$this->display('myroom/analysis_advantage');
	}
	
	//24小时学习峰值
	public function studypeak(){
		$chart = Ebh::app()->lib('ChartLib');
		$analysismodel = $this->model('analysis');
		
		$param['all'] = 1;
		$spkey = $this->cache->getcachekey('studypeak',$param);
        $datas = $this->cache->get($spkey);
        if(empty($datas)) {
			$studyarr = $analysismodel->getStudyTime($param);
			$datas = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			foreach($studyarr as $study){
				$dayhour = intval(Date('H',$study['lastdate']));
				if(empty($datas[$dayhour]))
					$datas[$dayhour] = 1;
				else
					$datas[$dayhour]++;
			}
            $this->cache->set($spkey,$datas,86400);
        }
		
		$param2['my'] = 1;
		// $spkeymy = $this->cache->getcachekey('studypeak',$param2);
        // $datasmy = $this->cache->get($spkeymy);
        if(empty($datasmy)) {
			$user = Ebh::app()->user->getloginuser();
			$studyarr = $analysismodel->getStudyTime($param2,$user['uid']);
			$datasmy = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			foreach($studyarr as $k=>$study){
				$dayhour = intval(Date('H',$study['lastdate']));
				if(empty($datasmy[$dayhour]))
					$datasmy[$dayhour] = 1;
				else
					$datasmy[$dayhour]++;
			}
            // $this->cache->set($spkeymy,$datasmy,600);
        }
		
		$dataarr = array(
			'caption'=>'学习峰值表',
			'datas'=>$datas
		);
		
		$dataarrmy = array(
			'caption'=>'我的学习峰值表',
			'datas'=>$datasmy
		);
		$this->assign('dataarr',$dataarr);
		$this->assign('dataarrmy',$dataarrmy);
		$this->assign('chart',$chart);
		$this->display('myroom/analysis_studypeak');
	}
	
	private function getDayPeriod($daystate){
		switch($daystate){
			case 1://今天
				$param['dayfrom'] = strtotime('today');
				$param['dayto'] = $param['dayfrom'] + 86400;
				$param['prefix'] = '';
				$param['suffix'] = '';
				$param['xData'] = '';
			break;
			case 2://昨天
				$param['dayto'] = strtotime('today');
				$param['dayfrom'] = $param['dayto'] - 86400;
				$param['prefix'] = '';
				$param['suffix'] = '';
			break;
			case 3://本周
				$param['dayfrom'] = strtotime('last monday');
				$param['dayto'] = strtotime('next sunday');
				$param['prefix'] = '周';
				$param['suffix'] = '';
			break;
			case 4://本月
				$param['dayfrom'] = strtotime(Date("Y-m-01"));
				$param['dayto'] = strtotime('+1 month',$param['dayfrom']);
				$param['prefix'] = '';
				$param['suffix'] = '';
			break;
			
			default:
				$param['dayfrom'] = 0;
				$param['dayto'] = 9999999999;
				$param['prefix'] = '';
				$param['suffix'] = '';
			break;
		}
		return $param;
	}
	//刷新数据
	public function refreshdata(){
		// $analysismodel = $this->model('analysis');
		// $analysismodel->refreshdata();
		
	}
	private function getJudgement($comparedata,$stunum){
		$judgearr = array(
		'0'=>array('img'=>'buhao','des'=>'不给力哦','level'=>'下游'),
		'1'=>array('img'=>'yiban','des'=>'一般','level'=>'中等'),
		'2'=>array('img'=>'henhao','des'=>'非常好','level'=>'上游')
		);
		$avg = $comparedata['class']/$stunum;
		if(($comparedata['my']-$avg)>3)
			return $judgearr[2];
		elseif(($comparedata['my']-$avg)>=0)
			return $judgearr[1];
		else
			return $judgearr[0];
	}
}
?>