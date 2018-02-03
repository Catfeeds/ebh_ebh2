<?php
/*
云端图表
*/
class CloudController extends CControl{
	public function __construct(){
		parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();	
		if(empty($roominfo)){	//非网校页面直接跳转到首页
			header('location: /');
			exit;
		}
	}
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$paramuser = array('crid'=>$roominfo['crid']);
	
	
		// $stime = microtime(true);
		//性别比例
		$rumodel = $this->model('roomuser');
		$paramuser['sex'] = 0;
		$sex[0] = $rumodel->getSexCount($paramuser);
		$paramuser['sex'] = 1;
		$sex[1] = $rumodel->getSexCount($paramuser);
		if($sex[0]==0 && $sex[1]==0){
			$sexpercent[0] = 0;
			$sexpercent[1] = 0;
		}else{
			$sexpercent[0] = round($sex[0]/($sex[0]+$sex[1])*100,2);
			$sexpercent[1] = 100-$sexpercent[0];
		}
		//性别登录比例
		$paramuser['sex'] = 0;
		$logincount[0] = $rumodel->getLoginCount($paramuser);
		$paramuser['sex'] = 1;
		$logincount[1] = $rumodel->getLoginCount($paramuser);
		
		if($logincount[0]==0 && $logincount[1]==0){
			$loginpercent[0] = 0;
			$loginpercent[1] = 0;
		}else{
			$loginpercent[0] = round($logincount[0]/($logincount[0]+$logincount[1])*100,2);
			$loginpercent[1] = 100-$loginpercent[0];
		}
		// $etime = microtime(true);
		// echo $etime-$stime;
		
		$chart = Ebh::app()->lib('ChartLib');
		$analysismodel = $this->model('analysis');
		
		
		$parampeak['crid'] = $roominfo['crid'];
		
		//峰值表
		$spkey = $this->cache->getcachekey('studypeak',$parampeak);
        $datas = $this->cache->get($spkey);
        if(empty($datas)) {
			$studyarr = $analysismodel->getStudyTimeForClassroom($parampeak);
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
		$datastudypeak = array(
			'caption'=>' ',
			'datas'=>$datas
		);
		
		$crmodel = $this->model('classroom');
		$param = array('name'=>'cloudchart','for'=>'one');
		
		//课件,作业,答疑
		$cloudkey = $this->cache->getcachekey('cloud',$param);
		$cloudlist = $this->cache->get($cloudkey);
		if(empty($cloudlist)){
			$cloudlist = $analysismodel->getCloudData();
			$this->cache->set($cloudkey,$cloudlist,3600);
		}
		// var_dump($cloudlist);exit;
		
		$myclassroomcount = array('coursenum'=>0,'examcount'=>0,'asknum'=>0);
		$maxcount = array('coursenum'=>0,'examcount'=>0,'asknum'=>0);
		$sumcount = array('coursenum'=>0,'examcount'=>0,'asknum'=>0);
		foreach($cloudlist as $count){
			if($count['crid'] == $roominfo['crid']){
				$myclassroomcount['coursenum'] = $count['coursenum'];
				$myclassroomcount['examcount'] = $count['examcount'];
				$myclassroomcount['asknum'] = $count['asknum'];
			}
			if($count['coursenum']>$maxcount['coursenum'])
				$maxcount['coursenum'] = $count['coursenum'];
			if($count['examcount']>$maxcount['examcount'])
				$maxcount['examcount'] = $count['examcount'];
			if($count['asknum']>$maxcount['asknum'])
				$maxcount['asknum'] = $count['asknum'];
			$sumcount['coursenum']+= $count['coursenum'];
			$sumcount['examcount']+= $count['examcount'];
			$sumcount['asknum']+= $count['asknum'];
		}
		$crcount = count($cloudlist);

		//课件
		$datacw = array(
			'caption'=>'课件',
			'datas'=>array(
				'本校'=>$myclassroomcount['coursenum'],
				'最大值'=>$maxcount['coursenum'],
				'平均'=>$sumcount['coursenum']/$crcount
			)
		);
		
		//作业
		$dataexam = array(
			'caption'=>'作业',
			'datas'=>array(
				'本校'=>$myclassroomcount['examcount'],
				'最大值'=>$maxcount['examcount'],
				'平均'=>$sumcount['examcount']/$crcount
			)
		);
		
		//答疑
		$dataanswer = array(
			'caption'=>'答疑',
			'datas'=>array(
				'本校'=>$myclassroomcount['asknum'],
				'最大值'=>$maxcount['asknum'],
				'平均'=>$sumcount['asknum']/$crcount
			)
		);

        //客服浮窗
        $kefu=array();
        if($roominfo['kefuqq']!=0){
            $kefu['kefu'] = explode(',',$roominfo['kefu']);
            $kefu['kefuqq'] = explode(',',$roominfo['kefuqq']);
        }
        if(!empty($roominfo['crphone'])){
            $phone = array();
            $phone = explode(',',$roominfo['crphone']);
            $this->assign('phone',$phone);
        }
        $this->assign('kefu',$kefu);
		
		$this->assign('datastudypeak',$datastudypeak);
		$this->assign('datacw',$datacw);
		$this->assign('dataexam',$dataexam);
		$this->assign('dataanswer',$dataanswer);
		$this->assign('chart',$chart);
		$this->assign('sexpercent',$sexpercent);
		$this->assign('loginpercent',$loginpercent);
		$this->assign('adlist', $adlist);
		$this->assign('room',$roominfo);
		$this->display('shop/one/cloud');
	}
}
?>