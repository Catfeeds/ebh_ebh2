<?php

/**
 * 教师我的答疑控制器类 MyaskController
 */
class MyaskController extends CControl {

    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }

    public function allquestion() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
		$aq = $this->input->get('aq');
		$cwid = $this->input->get('cwid');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['shield'] = 0;
		$queryarr['aq'] = $aq;
		$queryarr['cwid'] = intval($cwid);
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklists($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);
        
		//我回答
        $queryarr['uid'] = $user['uid'];
		$queryarr['qshield'] = 0;
		$queryarr['ashield'] = 0;
        $askanswers = $askmodel->getasklistbyanswersid($queryarr);
		$array = array();
		foreach($askanswers as $arr){
			$array[] = intval($arr['qid']);
		}
		$this->assign("myanswered",$array);
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
		$this->assign('aq', $aq);
        $this->display('troom/myask');
    }

    public function addquestion() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        if (NULL === $this->input->post('title')) {
            $upcontrol = Ebh::app()->lib('UpcontrolLib');
            $editor = Ebh::app()->lib('UMEditor');
            $classsubjectmodel = $this->model('Classsubject');
            $subjects = $classsubjectmodel->getsubjectlist($roominfo['crid']);
            $teachArr = array();
            $teachsubjects =array();
            
            foreach($subjects as $key=>$sbj){
            	$teacherid = $sbj['uid'];
            	$face = $this->_getfaceurl($sbj['face'],$sbj['sex']);
            	$sbj['face'] = $face;
            	if(!in_array($teacherid, $teachArr)){
            		$teachArr[] = $teacherid;
            	}
            	$teachsubjects[$teacherid][]=$sbj;
            }
            $folderid = intval($this->input->get('folderid'));
			$foldermodel = $this->model('Folder');
			$folder = $foldermodel->getfolderbyid($folderid);
			$this->assign('folder', $folder);
			
            $myfolders= $classsubjectmodel->getTeacherfolders($roominfo['crid'],$user['uid']);
            $this->assign('myfolders', $myfolders);
            
			//var_dump($myfolders);
			//echo '<pre>';
            //var_dump($teachsubjects);
			//所有的课程
			$allfolders = $classsubjectmodel->getfolders($roominfo['crid']);
			foreach($allfolders as $arr){
				$arrayall[$arr['folderid']] = array('foldername'=>$arr['foldername'],'realname'=>$arr['realname'],'tid'=>$arr['tid']);
			}
			if(!empty($myfolders)){
				foreach($myfolders as $arr){
					$arraymy[$arr['folderid']] = $arr['foldername'];
				}
				$this->assign("myfolders",$arraymy);
				//其他课程
				$otherfolders = array_diff_key($arrayall, $arraymy);
			}else{
				$otherfolders = $allfolders;
			}
			$this->assign('myfolders', $myfolders);
			$this->assign("allfolders",$allfolders);
			$this->assign('otherfolders', $otherfolders);
			$this->assign('user', $user);
            $this->assign('teachsubjects', $teachsubjects);
            $this->assign('subjects', $subjects);
            $this->assign('upcontrol', $upcontrol);
            $this->assign('editor', $editor);
            $this->display('troom/myask_add');
        } else {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
			if(!isset($title) || !isset($message))
				return false;
			else{
				$title = h($title);
				$message = h($message);
			}
            $imagearr = $this->input->post('image');
            $imagename = $imagearr['upfilename'];
            $imagesrc = $imagearr['upfilepath'];
            
            $audiosrc = $this->input->post('audio');
            $setaudio['audiosrc'] = array();
            $setaudio['audioname'] = array();
            $setaudio['audiotime'] = array();
            if(!empty($audiosrc)){
                $audioarr = array();
                $setaudio = array();
                foreach ($audiosrc as $k => $src) {
                    $audioarr = explode('_',$src);
                    $audioname = substr( $audioarr[0] , strrpos($audioarr[0] , '/')+1 );
                    $setaudio['audiosrc'][] = $audioarr[0];
                    $setaudio['audioname'][] = $audioname;
                    $setaudio['audiotime'][] = $audioarr[1];
                }
                $setaudio['audiosrc'] = json_encode($setaudio['audiosrc']);
                $setaudio['audioname'] = json_encode($setaudio['audioname']);
                $setaudio['audiotime'] = json_encode($setaudio['audiotime']);
            }
            $folderid = $this->input->post('folderid');
            $fromip = $this->input->getip();
            if ($folderid === NULL || !is_numeric($folderid)) {
                $result = array('status' => 0, 'message' => '请选择分类');
                echo json_encode($result);
                exit();
            }
            $param = array('uid' => $user['uid'], 'folderid' => $folderid, 'crid' => $roominfo['crid'], 'title' => $title, 'message' => $message, 'imagename' => $imagename, 'imagesrc' => $imagesrc, 'audioname' => $setaudio['audioname'], 'audiosrc' => $setaudio['audiosrc'],'fromip'=>$fromip,'audiotime'=>$setaudio['audiotime']);
            $askmodel = $this->model('Askquestion');
            $qid = $askmodel->insert($param);
            if ($qid > 0) {
                $result = array('status' => 1, 'message' => '添加成功');
                echo json_encode($result);
                fastcgi_finish_request();
				if(!empty($roominfo['crid'])){
					//更新答疑数
					$roommodel = $this->model('Classroom');
					$roommodel->addasknum($roominfo['crid'],1);
				}
				//同步SNS数据(当成功提问时同步)
				Ebh::app()->lib('Sns')->do_sync($user['uid'], 1);
            } else {
                $result = array('status' => 0, 'message' => '添加失败，请稍后再试或联系管理员');
                echo json_encode($result);
            }
        }
    }
    /**
     * 编辑问题
     */
    public function editquestion_view() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $qid = $this->uri->itemid;
        if ($qid === NULL || !is_numeric($qid)) {
            exit();
        }
        if (NULL === $this->input->post('title')) {
            $editor = Ebh::app()->lib('UMEditor');
            $upcontrol = Ebh::app()->lib('UpcontrolLib');
            $askmodel = $this->model('Askquestion');
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
            $classsubjectmodel = $this->model('Classsubject');
            $subjects = $classsubjectmodel->getsubjectlist($roominfo['crid']);
            
            $teachArr = array();
            $teachsubjects =array();
            
            foreach($subjects as $key=>$sbj){
            	$teacherid = $sbj['uid'];
            	$face = $this->_getfaceurl($sbj['face'],$sbj['sex']);
            	$sbj['face'] = $face;
            	if(!in_array($teacherid, $teachArr)){
            		$teachArr[] = $teacherid;
            	}
            	if($sbj['folderid']==$ask['folderid']){
            		$folder= $sbj;
            	}
            	$teachsubjects[$teacherid][]=$sbj;
            }
//var_dump($ask);
			$myfolders= $classsubjectmodel->getTeacherfolders($roominfo['crid'],$user['uid']);
			//所有的课程
			$allfolders = $classsubjectmodel->getfolders($roominfo['crid']);
			foreach($allfolders as $arr){
				$arrayall[$arr['folderid']] = array('foldername'=>$arr['foldername'],'realname'=>$arr['realname'],'tid'=>$arr['tid']);
			}
			if(!empty($myfolders)){
				foreach($myfolders as $arr){
					$arraymy[$arr['folderid']] = $arr['foldername'];
				}
				$this->assign("myfolders",$arraymy);
				//其他课程
				$otherfolders = array_diff_key($arrayall, $arraymy);
			}else{
				$otherfolders = $allfolders;
			}
            //组装语音消息
            if(!empty($ask['audiosrc'])){
                $audiosrc = json_decode($ask['audiosrc']);
                $audioname = json_decode($ask['audioname']);
                $audiotime = json_decode($ask['audiotime']);
                $audio = array();
                foreach ($audiosrc as $k => $src) {
                    $audio[$k]['audiosrc'] = $src;
                    $audio[$k]['audioname'] = $audioname[$k];
                    $audio[$k]['audiotime'] = $audiotime[$k];
                }
                $ask['audio'] = $audio;
            }
			$this->assign('myfolders', $myfolders);
			$this->assign("allfolders",$allfolders);
			$this->assign('otherfolders', $otherfolders);
			$this->assign('user', $user);
            $this->assign('myfolders', $myfolders);
            $this->assign('teachsubjects', $teachsubjects);
            $this->assign('folder', $folder);
            $this->assign('ask', $ask);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->assign('upcontrol', $upcontrol);
            $this->display('troom/myask_edit');
        } else {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
			if(!isset($title) || !isset($message))
				return false;
			else{
				$title = h($title);
				$message = h($message);
			}
            $imagearr = $this->input->post('image');
            $imagename = $imagearr['upfilename'];
            $imagesrc = $imagearr['upfilepath'];
 
            $audiosrc = $this->input->post('audio');
            $setaudio['audiosrc'] = '';
            $setaudio['audioname'] = '';
            $setaudio['audiotime'] = '';
            if(!empty($audiosrc)){
                $audioarr = array();
                foreach ($audiosrc as $k => $src) {
                    $audioarr = explode('_',$src);
                    $audioname = substr( $audioarr[0] , strrpos($audioarr[0] , '/')+1 );
                    $setaudio['audiosrc'][] = $audioarr[0];
                    $setaudio['audioname'][] = $audioname;
                    $setaudio['audiotime'][] = $audioarr[1];
                }
                $setaudio['audiosrc'] = json_encode($setaudio['audiosrc']);
                $setaudio['audioname'] = json_encode($setaudio['audioname']);
                $setaudio['audiotime'] = json_encode($setaudio['audiotime']);
            }

            $folderid = $this->input->post('folderid');
            $fromip = $this->input->getip();
            if ($folderid === NULL || !is_numeric($folderid)) {
                $result = array('status' => 0, 'message' => '请选择分类');
                echo json_encode($result);
                exit();
            }
            $param = array('qid'=>$qid,'uid' => $user['uid'], 'folderid' => $folderid, 'crid' => $roominfo['crid'], 'title' => $title, 'message' => $message, 'imagename' => $imagename, 'imagesrc' => $imagesrc, 'audioname' => $setaudio['audioname'], 'audiosrc' => $setaudio['audiosrc'],'fromip'=>$fromip,'audiotime'=>$setaudio['audiotime']);
            $askmodel = $this->model('Askquestion');
            $result = $askmodel->update($param);
            if ($result !== FALSE) {
                $resultarr = array('status' => 1, 'message' => '修改成功');
                echo json_encode($resultarr);
            } else {
                $resultarr = array('status' => 0, 'message' => '修改失败，请稍后再试或联系管理员');
                echo json_encode($resultarr);
            }
        }
    }
    /**
     * 问题详情
     */
    public function view() {
        $qid = $this->uri->itemid;
        if (is_numeric($qid)) {
			$roominfo = Ebh::app()->room->getcurroom();
			$crid = $roominfo['crid'];
            $editor = Ebh::app()->lib('UMEditor');
            $param = parsequery();
			$param['qid'] = $qid;
			$param['pagesize'] = 10;
            $askmodel = $this->model('Askquestion');
			$askmodel->addviewnum($qid);
            $user = Ebh::app()->user->getloginuser();
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid'],$crid);
            if(empty($ask)){
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题不存在或已删除";
                echo '<a href="'. $url.'">返回</a>';
                exit;
            }
            elseif(!empty($ask) && $ask['shield']==1){
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题被屏蔽，无法查看";
                echo '<a href="'. $url.'">返回</a>';
                exit;
            }
            if(!empty($ask['audiosrc']) && empty($ask['audiotime'])){//检验语音是否已经读取过语音时长
                //组装成保存路径
                //读取配置文件
                $config = Ebh::app()->getConfig()->load('upconfig');
                $audioconfig = $config['ask'];
                $showpath = $audioconfig['showpath'];
                $savepath = $audioconfig['savepath'];
                $path = trim($ask['audiosrc'],$showpath);
                $path = $savepath . $path;
                if(!empty($path)){
                    $time = $this->_checkAudioTime($path);
                    if(isset($time['playtime_seconds'])){
                        $audiotime = ceil($time['playtime_seconds']);
                        $setarr = array();
                        $setarr['audioname'] = json_encode(array(0 => $ask['audioname']));
                        $setarr['audiosrc'] = json_encode(array(0 => $ask['audiosrc']));
                        $setarr['audiotime'] = json_encode(array(0 => $audiotime));
                        $askmodel->updateAudio($setarr,$qid);
                        $ask['audiotime'] = $setarr['audiotime'];
                        $ask['audioname'] = $setarr['audioname'];
                        $ask['audiosrc'] = $setarr['audiosrc'];
                    }
                }
            }
            $answers = $askmodel->getdetailanswersbyqid($param);
            if(!empty($answers)){
                foreach ($answers as $key => $answer) {
                    if(!empty($answer['audiosrc']) && empty($answer['audiotime'])){
                        $config = Ebh::app()->getConfig()->load('upconfig');
                        $audioconfig = $config['ask'];
                        $showpath = $audioconfig['showpath'];
                        $savepath = $audioconfig['savepath'];
                        $path = trim($answer['audiosrc'],$showpath);
                        $path = $savepath . $path;
                        if(!empty($path)){
                            $time = $this->_checkAudioTime($path);
                            if(isset($time['playtime_seconds'])){
                                $audiotime = round($time['playtime_seconds']);
                                $setarr = array();
                                $setarr['audioname'] = json_encode(array(0 => $answer['audioname']));
                                $setarr['audiosrc'] = json_encode(array(0 => $answer['audiosrc']));
                                $setarr['audiotime'] = json_encode(array(0 => $audiotime));
                                $askmodel->updateAnswerAudioTime($setarr,$answer['aid']);
                                $answers[$key]['audiotime'] = $setarr['audiotime'];
                                $answers[$key]['audioname'] = $setarr['audioname'];
                                $answers[$key]['audiosrc'] = $setarr['audiosrc'];
                            }
                        }
                    }
                    if(!empty($answers[$key]['audiosrc'])){
                        $anaudio = array();
                        $anaudiochild = array();
                        $anaudiosrc = json_decode($answers[$key]['audiosrc']);
                        $anaudiotime = json_decode($answers[$key]['audiotime']);
                        $anaudioname = json_decode($answers[$key]['audioname']);
                        foreach ($anaudiosrc as $k => $ansrc) {
                            $anaudiochild['audiosrc'] = $ansrc;
                            $anaudiochild['audiotime'] = $anaudiotime[$k];
                            $anaudiochild['audioname'] = $anaudioname[$k];
                            $anaudio[] = $anaudiochild;
                            unset($anaudiochild);
                        }
                        $answers[$key]['audio'] = $anaudio;
                    }
                }
            }
            $count = $askmodel->getdetailanswerscountbyqid($qid);
            $pagestr = show_page($count);
			
			//悬赏奖励者名单
			$rewardlist = array();
			if ($ask['isrewarded'] == 1)
			{
				$rewardlist = $this->model('credit')->getRewardList($qid);
			}
            if(!empty($ask['audiosrc'])){ 
                $audio = array();
                $audiochild = array();
                $audiosrc = json_decode($ask['audiosrc']);
                $audiotime = json_decode($ask['audiotime']);
                $audioname = json_decode($ask['audioname']);
                foreach ($audiosrc as $key => $src) {
                    $audiochild['audiosrc'] = $src;
                    $audiochild['audiotime'] = $audiotime[$key];
                    $audiochild['audioname'] = $audioname[$key];
                    $audio[] = $audiochild;
                    unset($audiochild);
                }
            }
            $this->assign('audioque',$audio);
            $this->assign('rewardlist', $rewardlist);

            $this->assign('ask', $ask);
            $this->assign('answers', $answers);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->display('troom/myask_view');
        }
    }

    /**
     * 教师我的问题
     */
    public function myquestion() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
        $queryarr['shield'] = 0;
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);
		
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->display('troom/myquestion');
    }
	
	/*
	向我提的问题
	*/
	public function askme(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$aq = $this->input->get('aq');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['tid'] = $user['uid'];
		$queryarr['shield'] = 0;
		$queryarr['aq'] = $aq;
		$askmodel = $this->model('Askquestion');
		$asks = $askmodel->getallasklist($queryarr);
		$count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);
		$this->assign('asks', $asks);
		$this->assign('pagestr',$pagestr);
		// var_dump($asks);
		$this->display('troom/askme');
	}
	
	
    /**
     * 我的回答
     */
    public function myanswer() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
		$queryarr['qshield'] = 0;
		$queryarr['ashield'] = 0;
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getasklistbyanswers($queryarr);
        $count = $askmodel->getaskcountbyanswers($queryarr);
        $pagestr = show_page($count);
        
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->display('troom/myanswer');
    }

    /**
     * 我的关注
     */
    public function myfavorit() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getasklistbyfavorit($queryarr);
        $count = $askmodel->getaskcountbyfavorit($queryarr);
        $pagestr = show_page($count);
        
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->display('troom/myfavorit');
    }

    /**
     * 删除我的提问
     */
    public function delask() {
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $ask = $askmodel->getaskbyqid($qid);
        if (empty($ask) || $ask['crid'] != $roominfo['crid'] || $ask['uid'] != $user['uid']) {
            echo 'fail';
            exit();
        }
        //删除回答对应的文件
//        $answerlist = $askmodel->getanswersbyqid($qid);
//        foreach($answerlist as $myanswer) {
//            
//        }
        $result = $askmodel->delask($qid);
        if ($result) {
			if(!empty($roominfo['crid'])){
				//更新答疑数
				$roommodel = $this->model('Classroom');
				$roommodel->addasknum($roominfo['crid'],-1);
			}
            echo 'success';
			fastcgi_finish_request();
			//同步SNS数据(当删除问题时，问题数-1)
			Ebh::app()->lib('Sns')->do_sync($ask['uid'], -1);
            exit();
        } else {
            echo 'fail';
            exit();
        }
    }

    /**
     * 取消关注
     */
    public function delfavorit() {
        $aid = $this->input->post('aid');
        if ($aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $param = array('uid' => $user['uid'], 'aid' => $aid);
        $result = $askmodel->delfavorit($param);
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 关注获取消关注问题
     */
    public function addfavorit() {
        $qid = $this->input->post('qid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $flag = $this->input->post('flag');
        $param = array('uid' => $user['uid'], 'qid' => $qid);
        $askmodel = $this->model('Askquestion');
        if ($flag == 1) {
            $result = $askmodel->addfavorit($param);
        } else {
            $result = $askmodel->delfavorit($param);
        }
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 添加感谢
     */
    public function addthank() {
        $qid = $this->input->post('qid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
		$reviewmodel = $this->model('Review');
		$logparam =  array('uid'=>$user['uid'],'toid'=>$qid,'opid'=>1,'type'=>'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次投票
			echo 'thatday';
			exit();
		}
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addthank($qid);
        if ($result > 0) {
			$logparam['message'] = '回答感谢';
			$logparam['fromip'] = $this->input->getip();
			$reviewmodel->insertlog($logparam);
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 添加回答的感谢
     */
    public function addthankanswer() {
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$reviewmodel = $this->model('Review');
		$logparam =  array('uid'=>$user['uid'],'toid'=>$aid,'opid'=>1,'type'=>'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次投票
			echo 'thatday';
			exit();
		}
        $param = array('qid' => $qid, 'aid' => $aid);
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addthankanswer($param);
        if ($result > 0) {
			$logparam['message'] = '回答感谢';
			$logparam['fromip'] = $this->input->getip();
			$reviewmodel->insertlog($logparam);
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 添加回答
     */
    public function addanswer() {
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
        $param = array();
        $param['qid'] = $qid;
        $param['uid'] = $user['uid'];
        $param['message'] = $this->input->post('message');
		if(!isset($param['message']))
			return false;
		else{
			$param['message'] = h($param['message']);
		}
        $audiosrc = $this->input->post('audio');
        $setaudio['audiosrc'] = array();
        $setaudio['audioname'] = array();
        $setaudio['audiotime'] = array();
        if(!empty($audiosrc)){
            $audioarr = array();
            $setaudio = array();
            foreach ($audiosrc as $k => $src) {
                $audioarr = explode('_',$src);
                $audioname = substr( $audioarr[0] , strrpos($audioarr[0] , '/')+1 );
                $setaudio['audiosrc'][] = $audioarr[0];
                $setaudio['audioname'][] = $audioname;
                $setaudio['audiotime'][] = $audioarr[1];
            }
            $setaudio['audiosrc'] = json_encode($setaudio['audiosrc']);
            $setaudio['audioname'] = json_encode($setaudio['audioname']);
            $setaudio['audiotime'] = json_encode($setaudio['audiotime']);
        }
        $param['audiosrc'] = $setaudio['audiosrc'];
        $param['audioname'] = $setaudio['audioname'];
        $param['audiotime'] = $setaudio['audiotime'];
        $param['imagename'] = $this->input->post('imagename');
        $param['imagesrc'] = $this->input->post('imagesrc');
        $param['attname'] = $this->input->post('attname');
        $param['attsrc'] = $this->input->post('attsrc');
        $param['fromip'] = $this->input->getip();
        $param['cwid'] = intval($this->input->post('cwid'));
        $param['cwsource'] = $this->input->post('cwsource');
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addanswer($param);
        if ($result > 0) {
            echo 'success';
            fastcgi_finish_request();
            Ebh::app()->lib('PushUtils')->PushAskToStudent($qid);//信鸽推送
            Ebh::app()->lib('ThirdPushUtils')->PushAskToStudent($qid);//第三方推送
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
            $upparam = array(
                'qid'=>$qid,
                'uid'=>$ask['uid'],
                'lastansweruid'=>$user['uid']
            );
            $askmodel->update($upparam);
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>21,'qid'=>$param['qid']));
            if($ask['tid'] == $user['uid']){
               $askmodel->setAnswered($qid,1);
               //短信发送
               EBH::app()->lib('SMS')->run($qid,$user['uid'],2);
            }
            //新回答通过私信告诉提问人
            $msglib = Ebh::app()->lib('EMessage');
			$type = 2; //答疑新回答
			$lastmsg = $msglib->getLastUnReadMessage($ask['uid'],$qid,$type);
			$uname = empty($user['realname']) ? $user['username'] : $user['realname'];
			if(empty($lastmsg)) {	//如果当前的答疑私信没有未读的，则直接添加消息
				$title = $ask['title'];
				$msg = $title;
				$msglib->sendMessage($user['uid'],$uname,$ask['uid'],$qid,$type,$msg);
			} else {	//否则更新消息即可
				$ulist = $lastmsg['ulist'];
				parse_str($ulist,$uarr);
				if(!isset($uarr[$user['uid']])) {
					if(empty($ulist)) {
						$ulist = $user['uid'].'='.$uname;
					} else {
						$ulist .= '&'.$user['uid'].'='.$uname;
					}
					$lastmsg['ulist'] = $ulist;
					$lastmsg['dateline'] = SYSTIME;
					$msglib->updateMessage($lastmsg);
				}
			}
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 删除解答
     */
    public function delanswer() {
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $param = array('qid' => $qid, 'aid' => $aid, 'uid' => $user['uid']);
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->delanswer($param);
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }
	/*
	设置最佳答案
	*/
	public function setbest(){
		$qid = $this->input->post('qid');
		$aid = $this->input->post('aid');
        $user = Ebh::app()->user->getloginuser();
		if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$param = array('uid' => $user['uid'], 'qid' => $qid, 'aid'=>$aid);
		$askmodel = $this->model('Askquestion');
		$result = $askmodel->setBestT($param);
		if ($result) {
            echo 'success';
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>14,'aid'=>$aid));
            exit();
        } else {
            echo 'fail';
            exit();
        }
	}
	/**
	*获取播放器提问和播放器回答所需的key值
	*/
	private function _getplaykey() {
		$clientip = $this->input->getip();
        $ktime = SYSTIME;
        $auth = $this->input->cookie('auth');
        $sauth = authcode($auth, 'DECODE');
        @list($password, $uid) = explode("\t", $sauth);
        $skey = $ktime . '\t' . $uid . '\t' . $password . '\t' . $clientip;
        $key = authcode($skey, 'ENCODE');
		return $key;
	}
	/**
	* 更新新问题用户状态时间
	*/
	private function _updateuserstate() {
		//更新新问题用户状态时间
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
        $statemodel = $this->model('Userstate');
        $typeid = 2;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
	}

    /**
     *关于教师所教课程的所有问题
     *
    */
    public function index(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();

        $q = $this->input->get('q');
		$aq = $this->input->get('aq');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
		$queryarr['aq'] = $aq;
        $queryarr['shield'] = 0;
        $askmodel = $this->model('Askquestion');
		$queryarr['power'] = '0,1';
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
        $_SMS = EBH::app()->getConfig()->load('sms');
        if(in_array($roominfo['crid'], $_SMS['crids'])){
            $folderid = $this->input->get('folderid');
            $queryarr['tid'] = $user['uid'];
            $queryarr['folderid'] = intval($folderid);
            unset($queryarr['uid']);//需要指定老师回答的不需要提问者uid
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
        }else{
            $asks = $askmodel->getcoursequestionslist($folderids,$queryarr);
            $count = $askmodel->getcoursequestionscount($folderids,$queryarr);
        }
       
        $pagestr = show_page($count);
		//我回答
        $queryarr['uid'] = $user['uid'];
		$queryarr['qshield'] = 0;
		$queryarr['ashield'] = 0;
        $askanswers = $askmodel->getasklistbyanswersid($queryarr);//所有我回答的id
		$array = array();
		foreach($askanswers as $arr){
			$array[] = intval($arr['qid']);
		}
		$this->assign("myanswered",$array);
        $this->assign('folders',$folders['folder']);
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
		$this->assign('aq', $aq);
        $this->display('troom/allcoursequestion');
    }

    /**
     *老师所教班级问题
     *
     */
    public function classquestion(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
		$aq = $this->input->get('aq');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
		$queryarr['aq'] = $aq;
        $classesModel = $this->model('classes');
        $folderids = array();
		$queryarr['power'] = '0,1';
        $folderlist = $this->model('folder')->getTeacherFolderList($queryarr);
        $folders = current($folderlist);
        foreach ($folders['folder'] as  $value) {
            $folderids[] = $value['folderid'];
        }
        $tClasses = $classesModel->getTeacherClassList($roominfo['crid'],$user['uid']);
        $classids = array();
        if($this->input->get('classid')){
            $classid = $this->input->get('classid');
            $classids[] = intval($classid);
            $this->assign('checkclassid',$classid);
        }else{
            foreach ($tClasses as $class) {
                $classids[] = $class['classid'];
            }
        }
        
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getClassesAsk($classids,$queryarr,$folderids);
        $count = $askmodel->getClassesAskCount($classids,$queryarr,$folderids);
        $pagestr = show_page($count);
        $this->assign('asks', $asks);
        $this->assign('tClasses',$tClasses);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
		$this->assign('aq', $aq);
        $this->display('troom/classquestion');
    }
    
    //已解决(已经有最佳答案的)
    public function settled(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
    	$q = $this->input->get('q');
    	$aq = $this->input->get('aq');
    	$folderid = $this->input->get('fid');
    	$cwid = $this->input->get('cwid');
    	$queryarr = parsequery();
    	$queryarr['crid'] = $roominfo['crid'];
    	$queryarr['shield'] = 0;
    	$queryarr['aq'] = $aq;
    	$queryarr['cwid'] = intval($cwid);
    	$folderid = intval($folderid);
    	if(!empty($folderid)){
    		$queryarr['folderid'] = $folderid;
    	}
    	$queryarr['status'] = 1;
    	$queryarr['hasbest']=1;
    	$askmodel = $this->model('Askquestion');
    	$asks = $askmodel->getallasklist($queryarr);
    	$count = $askmodel->getallaskcount($queryarr);
    	$pagestr = show_page($count);
    	
    	$this->assign('asks', $asks);
    	$this->assign('pagestr', $pagestr);
    	$this->assign('user', $user);
    	$this->assign('crid', $roominfo['crid']);
    	$this->assign('q', $q);
    	$this->assign('aq', $aq);
    	$this->display('troom/myask_settled');
    }
    
    //热门(回答最多倒叙,却没有最佳答案的)
    public function hot(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
    	$q = $this->input->get('q');
    	$aq = $this->input->get('aq');
    	$folderid = $this->input->get('fid');
    	$cwid = $this->input->get('cwid');
    	$queryarr = parsequery();
    	$queryarr['crid'] = $roominfo['crid'];
    	$queryarr['shield'] = 0;
    	$queryarr['aq'] = $aq;
    	$queryarr['cwid'] = intval($cwid);
    	$folderid = intval($folderid);
    	if(!empty($folderid)){
    		$queryarr['folderid'] = $folderid;
    	}
    	$queryarr['status'] = 0;
    	$queryarr['hasbest'] = 0;
    	$queryarr['order'] = 'q.answercount desc';
    	$askmodel = $this->model('Askquestion');
    	$asks = $askmodel->getallasklist($queryarr);
    	$count = $askmodel->getallaskcount($queryarr);
    	$pagestr = show_page($count);
    	
    	$this->assign('asks', $asks);
    	$this->assign('pagestr', $pagestr);
    	$this->assign('user', $user);
    	$this->assign('crid', $roominfo['crid']);
    	$this->assign('q', $q);
    	$this->assign('aq', $aq);
    	$this->display('troom/myask_hot');
    }
    
    //推荐(回答数最多倒叙)
    public function recommend(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
    	$q = $this->input->get('q');
    	$aq = $this->input->get('aq');
    	$folderid = $this->input->get('fid');
    	$cwid = $this->input->get('cwid');
    	$queryarr = parsequery();
    	$queryarr['crid'] = $roominfo['crid'];
    	$queryarr['shield'] = 0;
    	$queryarr['aq'] = $aq;
    	$queryarr['cwid'] = intval($cwid);
    	$folderid = intval($folderid);
    	if(!empty($folderid)){
    		$queryarr['folderid'] = $folderid;
    	}
    	$queryarr['order'] = 'q.answercount desc';
    	$askmodel = $this->model('Askquestion');
    	$asks = $askmodel->getallasklist($queryarr);
    	$count = $askmodel->getallaskcount($queryarr);
    	$pagestr = show_page($count);
    	
    	$this->assign('asks', $asks);
    	$this->assign('pagestr', $pagestr);
    	$this->assign('user', $user);
    	$this->assign('crid', $roominfo['crid']);
    	$this->assign('q', $q);
    	$this->assign('aq', $aq);
    	$this->display('troom/myask_recommend');
    }
    
    //等待回复(我没有回复过的)
    public function wait(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
    	$aq = $this->input->get('aq');
    	$q = $this->input->get('q');
    	$folderid = $this->input->get('fid');
    	$cwid = $this->input->get('cwid');
    	$queryarr = parsequery();
    	$queryarr['aq'] = $aq;
    	$queryarr['crid'] = $roominfo['crid'];
    	$queryarr['uid'] = $user['uid'];
    	$queryarr['qshield'] = 0;
    	$queryarr['ashield'] = 0;
    	$queryarr['cwid'] = intval($cwid);
    	$folderid = intval($folderid);
    	if(!empty($folderid)){
    		$queryarr['folderid'] = $folderid;
    	}
    	$askmodel = $this->model('Askquestion');
    	$asks = $askmodel->getasklistbynoanswers($queryarr);
    	$count = $askmodel->getaskcountbynoanswers($queryarr);
    	$pagestr = show_page($count);
    	
    	$this->assign('aq', $aq);
    	$this->assign('asks', $asks);
    	$this->assign('pagestr', $pagestr);
    	$this->assign('user', $user);
    	$this->assign('crid', $roominfo['crid']);
    	$this->assign('q', $q);
    	$this->display('troom/myask_wait');
    }

	/*
	屏蔽回答
	*/
	public function shield(){
		$qid = $this->input->post('qid');
		$aid = $this->input->post('aid');
		$user = Ebh::app()->user->getloginuser();
		if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$param = array('uid' => $user['uid'], 'qid' => $qid, 'aid'=>$aid, 'shield'=>1);
		$askmodel = $this->model('Askquestion');
		$result = $askmodel->upShield($param);
		if ($result) {
			$res = $askmodel->updateanswercount($qid,1);
			if($res){
				 echo json_encode(array('status'=>1));
				 exit();
			}else{
				echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
				exit();
			}
            echo json_encode(array('status'=>1));
            exit();
		} else {
			echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
            exit();
        }
	}
	/*
	屏蔽问题
	*/
	public function qshield(){
		$roominfo = Ebh::app()->room->getcurroom();
		$qid = $this->input->post('qid');
		$user = Ebh::app()->user->getloginuser();
		if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
		$param = array('qid' => $qid, 'shield' => 1, 'crid'=>$roominfo['crid']);
		$askmodel = $this->model('Askquestion');		
        $ask = $askmodel->getaskbyqid($qid);
		$result = $askmodel->upQshield($param);
		if ($result) {
            echo json_encode(array('status'=>1));
            fastcgi_finish_request();
			//同步SNS数据(当屏蔽问题时，问题数-1)
			Ebh::app()->lib('Sns')->do_sync($ask['uid'], -1);
            exit();
		} else {
			echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
            exit();
        }
	}
	
	/**
	 * 获取课程关联的教师头像
	 * 
	 */
	protected function _getfaceurl($face='',$sex){
		$defaulturl = $sex == 1 ? 'm_woman.jpg' : 'm_man.jpg';
		$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/'.$defaulturl;
		$face =  empty($face) ? $defaulturl:$face;
		return $face = getthumb($face,'40_40');
	}
    //检测语音的时长
    private function _checkAudioTime($audiosrc){
        if(!empty($audiosrc)){
            $GetId3 = Ebh::app()->lib('Getid3Lib');
            return $GetId3->analyze($audiosrc);
        }
    }

	/*
	*页面内弹出的选择课程的框
	*/
//	public function box(){
//		$roominfo = Ebh::app()->room->getcurroom();
//        $user = Ebh::app()->user->getloginuser();
//		$classsubjectmodel = $this->model('Classsubject');         
//		//我的课程
//		$myfolders = $classsubjectmodel->getTeacherfolders($roominfo['crid'],$user['uid']);
//
//		//所有的课程
//		$allfolders = $classsubjectmodel->getfolders($roominfo['crid']);
//		foreach($allfolders as $arr){
//			$arrayall[$arr['folderid']] = array('foldername'=>$arr['foldername'],'realname'=>$arr['realname'],'tid'=>$arr['tid']);
//		}
//		if(!empty($myfolders)){
//			foreach($myfolders as $arr){
//				$arraymy[$arr['folderid']] = $arr['foldername'];
//			}
//			$this->assign("myfolders",$arraymy);
//			//其他课程
//			$otherfolders = array_diff_key($arrayall, $arraymy);
//		}else{
//			$otherfolders = $allfolders;
//		}
//		$this->assign('myfolders', $myfolders);
//		$this->assign("allfolders",$allfolders);
//		$this->assign('otherfolders', $otherfolders);
//		$this->assign('user', $user);
//		$this->display('common/askcourse_box');
//	}
}
