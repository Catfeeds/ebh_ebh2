<?php

/**
 * 教师我的答疑控制器类 MyaskController
 */
class MyaskController extends CControl {

	public function __construct() {
		parent::__construct();
		Ebh::app()->room->checkteacher();
		//获取modulename
		$method = $this->uri->uri_method();
		$needmnarr = array('askme','index','classquestion','allquestion','myquestion','myanswer','myfavorit','settled','hot','recommend','wait','tjfx','rank');
		if(in_array($method,$needmnarr)){
			$roominfo = Ebh::app()->room->getcurroom();
			$mnlib = Ebh::app()->lib('Modulename');
			$mnlib->getmodulename($this,array('modulecode'=>'myask','tors'=>1,'crid'=>$roominfo['crid']));
		}
	}

    public function allquestion() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
            $q = $this->input->get('q');
            $aq = $this->input->get('aq');
            $cwid = $this->input->get('cwid');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['shield'] = 0;
            $queryarr['aq'] = $aq;
            $queryarr['cwid'] = intval($cwid);
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklists($queryarr);
            $count = $askmodel->getallaskcount($queryarr);
            //我回答
            $queryarr['uid'] = $user['uid'];
            $queryarr['qshield'] = 0;
            $queryarr['ashield'] = 0;
            $askanswers = $askmodel->getasklistbyanswersid($queryarr);
            $array = array();
            foreach($askanswers as $arr){
                $array[] = intval($arr['qid']);
            }
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pagestr = show_page($count,45);
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $pagestr = show_page($count,45);
            $this->assign('p',$p);
            $this->assign("myanswered",$array);
            $this->assign('asks', $asks);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->assign('method','allquestion');
            $this->assign('aq', $aq);
            $this->assign('cwarr',$cwarr);
            $this->assign('pageflag',$pageflag);
            $this->display('troomv2/askNew');
            //$this->display('troomv2/myask');
        }else{
            $q = $this->input->get('q');
            $aq = $this->input->get('aq');
            $cwid = $this->input->get('cwid');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['shield'] = 0;
            $queryarr['aq'] = $aq;
            $queryarr['cwid'] = intval($cwid);
            $p = $post['p'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklists($queryarr);
            $count = $askmodel->getallaskcount($queryarr);
            
            //我回答
            $queryarr['uid'] = $user['uid'];
            $queryarr['qshield'] = 0;
            $queryarr['ashield'] = 0;
            $askanswers = $askmodel->getasklistbyanswersid($queryarr);
            $array = array();
            foreach($askanswers as $arr){
                $array[] = intval($arr['qid']);
            }
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        } 
    }

    public function addquestion() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        if (NULL === $this->input->post('title')) {
            $upcontrol = Ebh::app()->lib('UpcontrolLib');
            $editor = Ebh::app()->lib('UEditor');
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
				$otherfolders = array();
				foreach($allfolders as $folder){
					$otherfolders[$folder['folderid']] = $folder;
				}
			}
			$this->assign('myfolders', $myfolders);
			$this->assign("allfolders",$allfolders);
			$this->assign('otherfolders', $otherfolders);
			$this->assign('user', $user);
            $this->assign('teachsubjects', $teachsubjects);
            $this->assign('subjects', $subjects);
            $this->assign('upcontrol', $upcontrol);
            $this->assign('editor', $editor);
            $this->display('troomv2/myask_add');
        } else {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
            $post = $this->input->post();
			if(!isset($title) || !isset($message))
				return false;
			else{
				$title = h($title);
				$message = h($message);
			}
			$this->checkSensitive($title,$message);
            //$imagearr = $this->input->post('image');
            //$imagename = $imagearr['upfilename'];
            //$imagesrc = $imagearr['upfilepath'];
            $imagesrc = $this->input->post('images');
            $imagename = $this->input->post('imagesname');
            if(count($imagesrc) >9){
                $result = array('status' => 0, 'message' => '上传图片不能超过9张！');
                echo json_encode($result);
                exit();
            }
            $coverstr = '';
            if(!empty($imagesrc)){
               if(count($imagesrc) < 4){
                    $editorimg = array();
                    $editorimg = $this->getImgFromEdit($message);
                    $eimgnum = 4;
                    $eimgnum = 4 - count($imagesrc);
                    $img = array_slice($editorimg,0,$eimgnum);
                    $coverimg = array_merge($img,$imagesrc);
                }else{
                    $coverimg = array_slice($imagesrc,0,4);
                }
                $coverstr = json_encode($coverimg);
            }else{
                $editorimg = array();
                $editorimg = $this->getImgFromEdit($message);
                $coverimg = array_slice($editorimg,0,4);
                $coverstr = json_encode($coverimg);
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
            $imagesrc = empty($imagesrc)?'':implode(',',$imagesrc);
            $imagename = empty($imagename)?'':implode(',',$imagename);
            $folderid = $this->input->post('folderid');
            $fromip = $this->input->getip();
            if ($folderid === NULL || !is_numeric($folderid)) {
                $result = array('status' => 0, 'message' => '请选择分类');
                echo json_encode($result);
                exit();
            }
            $param = array('uid' => $user['uid'], 'folderid' => $folderid, 'crid' => $roominfo['crid'], 'title' => $title, 'message' => $message, 'imagename' => $imagename, 'imagesrc' => $imagesrc, 'audioname' => $setaudio['audioname'], 'audiosrc' => $setaudio['audiosrc'],'fromip'=>$fromip,'audiotime' => $setaudio['audiotime'],'coverimg'=>$coverstr);
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
				
				//清除userstate数量缓存
				$userstatelib = Ebh::app()->lib('Userstate');
				$userstatelib->clearCache_count($roominfo['crid'],0,4);
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
            $editor = Ebh::app()->lib('UEditor');
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
            //p($ask);die;
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
            $this->assign('roominfo', $roominfo);
            $this->assign('room', $roominfo);
            $this->display('troomv2/myask_edit');
        } else {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
			if(!isset($title) || !isset($message))
				return false;
			else{
				$title = h($title);
				$message = h($message);
			}
			$this->checkSensitive($title,$message);
            $imagesrc = $this->input->post('images');
            $imagename = $this->input->post('imagesname');
            if(count($imagesrc) >9){
                $result = array('status' => 0, 'message' => '上传图片不能超过9张！');
                echo json_encode($result);
                exit();
            }
            $coverstr = '';
            if(!empty($imagesrc)){
               if(count($imagesrc) < 4){
                    $editorimg = array();
                    $editorimg = $this->getImgFromEdit($message);
                    $eimgnum = 4;
                    $eimgnum = 4 - count($imagesrc);
                    $img = array_slice($editorimg,0,$eimgnum);
                    $coverimg = array_merge($img,$imagesrc);
                }else{
                    $coverimg = array_slice($imagesrc,0,4);
                }
                $coverstr = json_encode($coverimg);
            }else{
                $editorimg = array();
                $editorimg = $this->getImgFromEdit($message);
                $coverimg = array_slice($editorimg,0,4);
                $coverstr = json_encode($coverimg);
            }
            $imagesrc = empty($imagesrc)?'':implode(',',$imagesrc);
            $imagename = empty($imagename)?'':implode(',',$imagename);
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
            $param = array('qid'=>$qid,'uid' => $user['uid'], 'folderid' => $folderid, 'crid' => $roominfo['crid'], 'title' => $title, 'message' => $message, 'imagename' => $imagename, 'imagesrc' => $imagesrc, 'audioname' => $setaudio['audioname'], 'audiosrc' => $setaudio['audiosrc'],'fromip'=>$fromip,'audiotime' => $setaudio['audiotime'],'coverimg'=>$coverstr);
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
            $editor = Ebh::app()->lib('UEditor');
            $param = parsequery();
			$param['qid'] = $qid;
			$param['pagesize'] = 20;
            $askmodel = $this->model('Askquestion');
			$askmodel->addviewnum($qid);
            $user = Ebh::app()->user->getloginuser();
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid'],$crid);
            //p($ask);die;
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
                $audioconfig = $config['audio'];
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
            $reviewmodel = $this->model('Review');
            $logparam =  array('uid'=>$user['uid'],'toid'=>$qid,'opid'=>1,'type'=>'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
            $lasttime = $reviewmodel->getLastLogTime($logparam);
            $ask['thatday'] = 0;
            if(!empty($lasttime)) {
                $ask['thatday'] = 1;
            }
            $answers = $askmodel->getdetailanswersbyqid($param);
            if(!empty($answers)){
                foreach ($answers as $key=>$answer) {
                    if(!empty($answer['fromip'])){
                        @$data = Ebh::app()->lib('IPaddress')->find($answer['fromip']);//根据ip获取地址
                        $IPaddress = '';
                        if(!empty($data)){
                           $IPaddress = rtrim(implode('-',$data),'-'); 
                        }
                        $answers[$key]['IPaddress'] = $IPaddress;
                    }
                    if(!empty($answer['audiosrc']) && empty($answer['audiotime'])){
                        $config = Ebh::app()->getConfig()->load('upconfig');
                        $audioconfig = $config['audio'];
                        $showpath = $audioconfig['showpath'];
                        $savepath = $audioconfig['savepath'];
                        $path = trim($answer['audiosrc'],$showpath);
                        $path = $savepath . $path;
                        if(!empty($path)){
                            $time = $this->_checkAudioTime($path);
                            if(isset($time['playtime_seconds'])){
                                $audiotime = ceil($time['playtime_seconds']);
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
                    $aid = 0;
                    if(!empty($answer['aid'])){
                        $aid = $answer['aid'];
                    }
                    $logparam =  array('uid'=>$user['uid'],'toid'=>$aid,'opid'=>1,'type'=>'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
                    $lasttime = $reviewmodel->getLastLogTime($logparam);
                    if(!empty($lasttime)) {
                        $answers[$key]['thatday'] = 1;
                    }else{
                        $answers[$key]['thatday'] = 0;
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
            $audio = array();
            if(!empty($ask['audiosrc'])){  
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
			if(!empty($ask['folderid'])){
				//设置最佳答案的权限
				$rtmodel = $this->model('roomteacher');
				$ifcourseteacher = $rtmodel->ifCourseTeacher($user['uid'],$ask['folderid']);
				$this->assign('bestpower',$ifcourseteacher);
			}
			$answers = arraySequence($answers,'groupid','SORT_ASC');
            $this->assign('audioque',$audio);
            $this->assign('rewardlist', $rewardlist);
            $this->assign('head',1);//头部不同
            $this->assign('ask', $ask);
            $this->assign('answers', $answers);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->assign('roominfo', $roominfo);
            $this->assign('room', $roominfo);
            if($ask['uid'] == $user['uid']){
                $this->display('troomv2/myask_view_mine');
            }else{
                $this->display('troomv2/myask_view_other');
            }
            //$this->display('troomv2/myask_view');
           
        }
    }

    /**
     * 教师我的问题
     */
    public function myquestion() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
            $q = $this->input->get('q');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $queryarr['shield'] = 0;
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $count = $askmodel->getallaskcount($queryarr);
            $pagestr = show_page($count,45);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pagestr = show_page($count,45);
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $this->assign('asks', $asks);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->assign('p',$p);
            $this->assign('pageflag',$pageflag);
            $this->assign('method','myquestion');
            $this->assign('cwarr',$cwarr);
            $this->display('troomv2/askNew');  
        }else{
            $q = $this->input->get('q');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $queryarr['shield'] = 0;
            $p = $post['p'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $count = $askmodel->getallaskcount($queryarr);
            $pagestr = show_page($count,45);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pagestr = show_page($count,45);
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        }
    }
	
	/*
	向我提的问题
	*/
	public function askme(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
            $aq = $this->input->get('aq');
            $q = $this->input->get('q');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['tid'] = $user['uid'];
            $queryarr['shield'] = 0;
            $queryarr['aq'] = $aq;
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $count = $askmodel->getallaskcount($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pagestr = show_page($count,45);
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $pagestr = show_page($count,45);
            $this->assign('asks', $asks);
            $this->assign('p',$p);
            $this->assign('q',$q);
            $this->assign('cwarr',$cwarr);
            $this->assign('pagestr',$pagestr);
            $this->assign('pageflag',$pageflag);
            $this->assign('method','askme');
            $this->display('troomv2/askNew'); 
        }else{
            $aq = $this->input->get('aq');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['tid'] = $user['uid'];
            $queryarr['shield'] = 0;
            $queryarr['aq'] = $aq;
            $p = $post['p'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $count = $askmodel->getallaskcount($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        }
	}
	
	
    /**
     * 我的回答
     */
    public function myanswer() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
            $q = $this->input->get('q');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $queryarr['qshield'] = 0;
            $queryarr['ashield'] = 0;
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getasklistbyanswers($queryarr);
            $count = $askmodel->getaskcountbyanswers($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pagestr = show_page($count,45);
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $this->assign('p',$p);
            $this->assign('method','myanswer');
            $this->assign('cwarr',$cwarr);
            $this->assign('pageflag',$pageflag);
            $this->assign('asks', $asks);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->display('troomv2/askNew');
        }else{
            $q = $this->input->get('q');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $queryarr['qshield'] = 0;
            $queryarr['ashield'] = 0;
            $p = $post['p'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getasklistbyanswers($queryarr);
            $count = $askmodel->getaskcountbyanswers($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        } 
    }

    /**
     * 我的关注
     */
    public function myfavorit() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
            $q = $this->input->get('q');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getasklistbyfavorit($queryarr);
            $count = $askmodel->getaskcountbyfavorit($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pagestr = show_page($count,45);
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }

            $this->assign('p',$p);
            $this->assign('pageflag',$pageflag);
            $this->assign('method','myfavorit');
            $this->assign('cwarr',$cwarr);
            $this->assign('asks', $asks);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->display('troomv2/askNew');
        }else{
            $q = $this->input->get('q');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $p = $post['p'];
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getasklistbyfavorit($queryarr);
            $count = $askmodel->getaskcountbyfavorit($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        }
        
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
        $this->checkSensitive('',$param['message']);
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
            echo json_encode(array('status'=>1));
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
        echo json_encode(array('status'=>0));
        exit();
    }

    /**
     * 删除解答
     */
    public function delanswer() {
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        $isbest = $this->input->post('isbest');
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $param = array('qid' => $qid, 'aid' => $aid, 'uid' => $user['uid']);
        $askmodel = $this->model('Askquestion');
        $ans = $askmodel->getAnswerInfoByAid($aid);
        $result = $askmodel->delanswer($param);
        if(!empty($isbest)){//如果对最佳答案进行删除，则将问题的状态改成为解答
            $askmodel->updateQueStatusByQid($qid);
        }else{
            if($ans['isbest'] == 1){
                $askmodel->updateQueStatusByQid($qid);
            }
        }
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
            echo json_encode('success');
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>14,'aid'=>$aid));
            exit();
        } else {
            echo json_encode('fail');
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
        $post = $this->input->post();
        if(empty($post)){
            $q = $this->input->get('q');
            $aq = $this->input->get('aq');
            $queryarr = parsequery();
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $queryarr['aq'] = $aq;
            $queryarr['shield'] = 0;
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
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
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $rangecount = ($queryarr['page'] - 1) * 15;
            
            $pagestr = show_page($count,45);
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
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
            $this->assign('method', 'index');
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->assign('p',$p);
            $this->assign('aq', $aq);
            $this->assign('cwarr',$cwarr);
            $this->assign('pageflag',$pageflag);
            
            $this->display('troomv2/askNew');
            //$this->display('troomv2/allcoursequestion');
        }else{
            $q = $this->input->get('q');
            $aq = $this->input->get('aq');
            $p = $post['p'];
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $queryarr['aq'] = $aq;
            $queryarr['shield'] = 0;
            $queryarr['pagesize'] = 15;
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
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
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
            //p($asks);die;
            //获取modulename
        }
    }

    /**
     *老师所教班级问题
     *
     */
    public function classquestion(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
            $q = $this->input->get('q');
            $aq = $this->input->get('aq');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $queryarr['aq'] = $aq;
            $queryarr['pagesize'] = 15;
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
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
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getClassesAskCount($classids,$queryarr,$folderids);
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $pagestr = show_page($count,45);
            $this->assign('method','classquestion');
            $this->assign('asks', $asks);
            $this->assign('tClasses',$tClasses);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('cwarr',$cwarr);
            $this->assign('q', $q);
            $this->assign('aq', $aq);
            $this->assign('p',$p);
            $this->assign('pageflag',$pageflag);
            $this->display('troomv2/askNew');
        }else{
            $q = $this->input->get('q');
            $aq = $this->input->get('aq');
            $queryarr = parsequery();
            $queryarr['crid'] = $roominfo['crid'];
            $queryarr['uid'] = $user['uid'];
            $queryarr['aq'] = $aq;
            $queryarr['pagesize'] = 15;
            $p = $post['p'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
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
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getClassesAskCount($classids,$queryarr,$folderids);
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        } 
    }
    
    //已解决(已经有最佳答案的)
    public function settled(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
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
            $queryarr['pagesize'] = 15;
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            if(!empty($folderid)){
                $queryarr['folderid'] = $folderid;
            }
            $queryarr['status'] = 1;
            $queryarr['hasbest']=1;
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getallaskcount($queryarr);
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $pagestr = show_page($count,45);
            $this->assign('asks', $asks);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->assign('aq', $aq);
            $this->assign('p',$p);
            $this->assign('method','settled');
            $this->assign('pageflag',$pageflag);
            $this->assign('cwarr',$cwarr);
            $this->display('troomv2/askNew');
        }else{
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
            $queryarr['pagesize'] = 15;
            $p = $post['p'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            $queryarr['status'] = 1;
            $queryarr['hasbest']= 1;
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getallaskcount($queryarr);
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        }
    }
    
    //热门(回答最多倒叙,却没有最佳答案的)
    public function hot(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
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
            $queryarr['pagesize'] = 15;
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            if(!empty($folderid)){
                $queryarr['folderid'] = $folderid;
            }
            $queryarr['status'] = 0;
            $queryarr['hasbest'] = 0;
            $queryarr['order'] = 'q.answercount desc';
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getallaskcount($queryarr);
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $pagestr = show_page($count,45);
            $this->assign('p',$p);
            $this->assign('pageflag',$pageflag);
            $this->assign('method','hot');
            $this->assign('cwarr',$cwarr);          
            $this->assign('asks', $asks);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->assign('aq', $aq);
            $this->display('troomv2/askNew'); 
        }else{
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
            $queryarr['pagesize'] = 15;
            $queryarr['pagesize'] = 15;
            $p = $post['p'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            $queryarr['status'] = 0;
            $queryarr['hasbest'] = 0;
            $queryarr['order'] = 'q.answercount desc';
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getallaskcount($queryarr);
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        }
    }
    
    //推荐(回答数最多倒叙)
    public function recommend(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
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
            $queryarr['pagesize'] = 15;
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            if(!empty($folderid)){
                $queryarr['folderid'] = $folderid;
            }
            $queryarr['order'] = 'q.answercount desc';
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getallaskcount($queryarr);
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $pagestr = show_page($count,45);
            $this->assign('p',$p);
            $this->assign('pageflag',$pageflag);
            $this->assign('method','recommend');
            $this->assign('cwarr',$cwarr);
            $this->assign('asks', $asks);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->assign('aq', $aq);
            $this->display('troomv2/askNew');  
        }else{
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
            $queryarr['pagesize'] = 15;
            $p = $post['p'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            if(!empty($folderid)){
                $queryarr['folderid'] = $folderid;
            }
            $queryarr['order'] = 'q.answercount desc';
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getallasklist($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getallaskcount($queryarr);
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        }
    	
    }
    
    //等待回复(我没有回复过的)
    public function wait(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
        $post = $this->input->post();
        if(empty($post)){
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
            $queryarr['pagesize'] = 15;
            $p = empty($queryarr['page']) ? 1 : $queryarr['page'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + 1;
            }
            $folderid = intval($folderid);
            if(!empty($folderid)){
                $queryarr['folderid'] = $folderid;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getasklistbynoanswers($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getaskcountbynoanswers($queryarr);
            $rangecount = ($queryarr['page'] - 1) * 15;
            $pageflag = false;
            if($rangecount < $count && ($count <= ($rangecount + 15))){
                $pageflag = true;
            }
            $pagestr = show_page($count,45);
            $this->assign('p',$p);
            $this->assign('pageflag',$pageflag);
            $this->assign('method','wait');
            $this->assign('cwarr',$cwarr);
            $this->assign('aq', $aq);
            $this->assign('asks', $asks);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('crid', $roominfo['crid']);
            $this->assign('q', $q);
            $this->display('troomv2/askNew'); 
        }else{
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
            $queryarr['pagesize'] = 15;
            $p = $post['p'];
            if(empty($queryarr['page']) || $queryarr['page'] == 1){
                $queryarr['page'] = 1 + $p;
            }else{
                $queryarr['page'] = ($queryarr['page'] - 1) * 3 + $p + 1;
            }
            $folderid = intval($folderid);
            if(!empty($folderid)){
                $queryarr['folderid'] = $folderid;
            }
            $askmodel = $this->model('Askquestion');
            $asks = $askmodel->getasklistbynoanswers($queryarr);
            $cwarr = array();
            if(!empty($asks)){//处理音频消息,获取课件名
                $asks = $this->_audioRebuild($asks);
                $cwarr = $this->getCwname($asks);
            }
            $count = $askmodel->getaskcountbynoanswers($queryarr);
            $pageflag = false;
            $rangecount = ($queryarr['page']) * 15;
            if(($count - $rangecount) <= 0){
                $pageflag = true;
            }
            foreach ($asks as &$ask) {
                if(!empty($ask['cwid'])){
                    $ask['cwname'] = $cwarr[$ask['cwid']];
                }
                $ask['realnameshort'] = getusername($ask,8);
                $ask['realname'] = getusername($ask);
                $ask['face'] = getavater($ask);
                $ask['message'] = strip_tags($ask['message']);
                if((SYSTIME - $ask['dateline']) > 86400 * 3){
                    $ask['threeago'] = 1;
                }else{
                    $ask['threeago'] = 0;
                }
                $ask['dateline'] = timetostr($ask['dateline'],'Y-m-d');
                if(!empty($ask['coverimg']) && $ask['coverimg'] != 'null'){
                    $coverimg = json_decode($ask['coverimg'],false);
                }else{
                    if(!empty($ask['imagesrc'])){
                        $coverimg = explode(',',$ask['imagesrc']);
                        $coverimg = array_slice($coverimg,0,4);
                    }else{
                        $coverimg = array();
                    }
                }
                $ask['audiosrc'] = empty($ask['audiosrc']) ? '' : trim($ask['audiosrc']);
                $ask['audiotime'] = empty($ask['audiotime']) ? '' : trim($ask['audiotime']);
                if(!empty($ask['audiosrc']) && !empty($ask['audiotime'])){
                    $audioarr = json_decode($ask['audiosrc'],false);
                    $timearr = json_decode($ask['audiotime'],false);
                    $audio = array();
                    foreach ($audioarr as $key => $ad) {
                        $audio[] = array('src'=>$ad,'time'=>$timearr[$key]);
                    }
                }else{
                    $audio = array(); 
                }
                $ask['audio'] = $audio;
                $ask['cover'] = $coverimg;
            }
            echo json_encode(array(
                    'data'=>$asks,
                    'status'=>1,
                    'pageflag'=>$pageflag
                )
            );
        }
    }

	/*
	屏蔽回答
	*/
	public function shield(){
		$qid = $this->input->post('qid');
		$aid = $this->input->post('aid');
        $isbest = $this->input->post('isbest');
		$user = Ebh::app()->user->getloginuser();
		if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
		$param = array('uid' => $user['uid'], 'qid' => $qid, 'aid'=>$aid, 'shield'=>1);
		$askmodel = $this->model('Askquestion');
		$result = $askmodel->upShield($param);
        $creditmodel = $this->model('credit');
        $creditmodel->addCreditlog(array(
                        'aid' => $aid,
                        'ruleid' => 34)
                );
        if(!empty($isbest)){//如果对最佳答案进行屏蔽，则将问题的状态改成为解答
            $askmodel->updateQueStatusByQid($qid);
        }else{
            $ans = $askmodel->getAnswerInfoByAid($aid);
            if($ans['isbest'] == 1){
                $askmodel->updateQueStatusByQid($qid);
            }
        }
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
            $creditmodel = $this->model('credit');
            $creditmodel->addCreditlog(array(
                                            'qid' => $qid,
                                            'ruleid' => 33
                                            ));
			Ebh::app()->lib('Sns')->do_sync($ask['uid'], -1);

            //屏蔽问题操作成功后记录到操作日志
            if (isset($param['shield'])) {
                $logdata = array();
                $logdata['toid'] = $qid;                    //问题的qid
                //根据问题编号获取问题信息
                $askdetail = Ebh::app()->getApiServer('ebh')->reSetting()->setService('Aroomv3.AskQuestion.getAskByQid')->addParams('qid',$qid)->request();
                if(!empty($askdetail['title'])){
                    $logdata['title'] = $askdetail['title'];
                    Ebh::app()->lib('OperationLog')->addLog($logdata,'shieldask');
                }
            }
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
    /**
     * 统计分析
     *
     */
    public function tjfx(){
        $roominfo = Ebh::app()->room->getcurroom();
        $m = $this->model('classes')->getAllstudent($roominfo);
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['shield'] = 0;
        $studentscount = $this->model('classes')->getAllstudentcount($queryarr);//全校人数
        $teacherscount = $this->model('teacher')->getroomteachercount($roominfo['crid'],array());

        //学校男女比例
//        $asks = $askmodel->getallasklists($queryarr);
        $queryarr['sex'] = 1;
        $studentscount_g = $this->model('classes')->getAllstudentcount($queryarr);//全校女生人数
//        $girlquescount = $askmodel->getallaskcount($queryarr);
//        $girlaskcount = $askmodel->getaskcountbyanswers($queryarr);
        $ratio = ceil($studentscount_g/$studentscount*100);
        unset($queryarr['sex']);
        if(isset($_GET['endtime'])&&!empty($_GET['endtime'])){
            $queryarr['aenddate'] = strtotime($_GET['endtime'])+86400;
            $this->assign('endtime',strtotime($_GET['endtime']));
        }
        if(isset($_GET['starttime'])&&!empty($_GET['starttime'])){
            $queryarr['abegindate'] = strtotime($_GET['starttime']);
            $this->assign('starttime',strtotime($_GET['starttime']));
        }else{
            $queryarr['abegindate'] = $user['dateline'];
        }
        $quescount = $askmodel->getallaskcount($queryarr);//总提问数212
        $askcount = $askmodel->getaskcountbyanswers($queryarr);//总回答数
        //提问情况比例
        if(empty($quescount)){
            $noquesrtion = 1;
            $this->assign('noquestion',$noquesrtion);
        }else{
            $queryarr['hasbest'] = 1;
            $bestqcount = $askmodel->getallaskcount($queryarr);//有最佳答案问题数56
            $queryarr['hasbest'] = 0;
            $queryarr['answercount'] = 'q.answercount > 0';
            $aqcount = $askmodel->getallaskcount($queryarr);//有回答没有最佳答案问题数17
            $noanqcount = $quescount-$bestqcount-$aqcount;//没有回答的问题数
            $this->assign('bestqcount',$bestqcount);
            $this->assign('aqcount',$aqcount);
            $this->assign('noanqcount',$noanqcount);
            unset($queryarr['hasbest']);
            unset($queryarr['answercount']);
            $bestqcount_h = sprintf('%.0f',$bestqcount/$quescount*100);
            $aqcount_h = sprintf('%.0f',$aqcount/$quescount*100);
            $noanqcount_h = sprintf('%.0f',$noanqcount/$quescount*100);
            $this->assign('bestqcount_h',$bestqcount_h);
            $this->assign('aqcount_h',$aqcount_h);
            $this->assign('noanqcount_h',$noanqcount_h);
//            $data_question['最佳答案'] = $bestqcount;
//            $data_question['普通解答'] = $aqcount;
//            $data_question['没有回答'] = $noanqcount;
        }
//        $datacol_question = array(
//            'caption' => '',
//            'datas' => $data_question
//        );

        //活跃度
        $queryarr['group'] = 'q.uid';
        $quesstcount = $askmodel->getallaskcount($queryarr);//提问人个数
        $anstcount = $askmodel->getAnswersCount($queryarr);//回答人个数
        $allcount = $studentscount+$teacherscount;
        $str = '';
        if($quesstcount/$allcount>1){
            $str.=100;
        }else{
            $str.=ceil($quesstcount/$allcount*100);
        }
        if($anstcount/$allcount>1){
            $str.=100;
        }else{
            $str.=','.ceil($anstcount/$allcount*100);
        }
        unset($queryarr['group']);



        $this->assign('str',$str);
        $this->assign('dateline',$user['dateline']);
//        $this->assign('active',$datacol_active);
//        $chart = Ebh::app()->lib('ChartLib');
//        $this->assign('chart',$chart);
        $this->assign('ratio',$ratio);
        $this->display('troomv2/myask_tjfx');
    }

    /**
     * 排行榜
     */
    public function rank(){
        $roominfo = Ebh::app()->room->getcurroom();
        $param['crid'] = $roominfo['crid'];
        $qusetion = $this->model('askquestion')->getQcountGroupByUid($param);//问题
        $answers = $this->model('askquestion')->getAcountGroupByUid($param);//回答
        $final = array_merge($qusetion,$answers);
//        p($final);die;
        $item=array();
        foreach($final as $k=>$v){
            if(!isset($item[$v['uid']])){
                $item[$v['uid']]=$v;
            }else{
                $item[$v['uid']]['count']+=$v['count'];
            }
        }
        foreach($item as $key=>$value){
            $ids[$key]=$value['count'];
        }
        array_multisort($ids,SORT_DESC,$item);
        $item = (array_slice($item,0,200));
        $this->assign('item',$item);
        $this->display('troomv2/myask_rank');
    }
    /**
     * 对添加或编辑的问题的标题和内容进行敏感词验证
     */
    public function checkSensitive($title,$message){
        require(LIB_PATH."SimpleDict.php");
        if(!file_exists(LIB_PATH."sensitive.cache")){
            SimpleDict::make(LIB_PATH."sensitive.dat",LIB_PATH."sensitive.cache");
        } 
        $dict = new SimpleDict(LIB_PATH."sensitive.cache");
        $title =  preg_replace("/\s/","",$title);
        $result = $dict->search($title);
        $resultarr= array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $resultarr[] =  $value['value'];
            }
            echo json_encode(array('status'=>-1,'Sensitive'=>$resultarr));
            exit;
        }

        $message = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", strip_tags($message));
        $result1 = $dict->search($message);
        $resultarr1= array();
        if(!empty($result1)){
            foreach ($result1 as $key => $value) {
                $resultarr1[] = $value['value'];
            }
            echo json_encode(array('status'=>-1,'Sensitive'=>$resultarr1));
            exit;
        }
    }
    //ajax上传图片
    public function uploadimg(){
        $askconfig = Ebh::app()->getConfig()->load('upconfig');
        $url = $askconfig['ask']['multipleserver'][0];
        $savepath = $askconfig['ask']['savepath'];
        $showpath = $askconfig['ask']['showpath'];
        $data = $_POST;
        $count = count($_POST)/2;
        if($count >9){
            echo json_encode(array('success'=>false,'message'=>'上传图片不能超过9张！'));
        }
        $result = $this->do_post($url, $data);
        //返回的图片信息
        $imgarr = json_decode($result,1);
        if($imgarr['success']){
            echo json_encode(array('data'=>$imgarr['data'],'success'=>true));
        }else{
            echo json_encode(array('success'=>false,'message'=>'上传失败，图片格式只支持jpg,jpeg,gif,png'));
        }
    }
    
    function do_post($url, $data , $retJson = true){
        $auth = Ebh::app()->getInput()->cookie('auth');
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_POST, TRUE); 
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //有文件上传
        if(!empty($data['upfile']) || !empty($data['Filedata'])){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
        }else{//无文件上传
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        }
      //  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) ); 
       // curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIE, 'ebh_auth='.urlencode($auth).';ebh_domain='.$domain);
        $ret = curl_exec($ch);
        curl_close($ch);
        if($retJson == false){
            $ret = json_decode($ret);
        }
        return $ret;
    }

    //检测语音的时长
    private function _checkAudioTime($audiosrc){
        if(!empty($audiosrc)){
            $GetId3 = Ebh::app()->lib('Getid3Lib');
            return $GetId3->analyze($audiosrc);
        }
    }
    //匹配编辑器中的图片
    //http://img.ebanhui.com/ebh/2016/11/11/14788470178098.png
    private function getImgFromEdit($content){
        if(empty($content)){
            return false;
        }
        $imgarr = array();
        $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
        $imgconfig = Ebh::app()->getConfig()->load('upconfig');
        $url = $imgconfig['pic']['showpath'];
        preg_match_all($pattern,$content,$matchs);
        if(!empty($matchs)){
            foreach ($matchs[1] as $match) {
                $match = strip_tags($match);
                if(!empty($match)){
                    if(strpos($match,$url) !== false){
                        array_push($imgarr,$match);
                    }
                }
            }
        }
        return $imgarr;
    }
    //处理音频消息
    private function _audioRebuild($asks){
        if(empty($asks)){
            return false;
        }
        foreach ($asks as $key => $ask) {
            if(!empty($ask['audiosrc']) && empty($ask['audiotime'])){//检验语音是否已经读取过语音时长
                //组装成保存路径
                //读取配置文件
                $config = Ebh::app()->getConfig()->load('upconfig');
                $audioconfig = $config['audio'];
                $showpath = $audioconfig['showpath'];
                $savepath = $audioconfig['savepath'];
                $path = trim($ask['audiosrc'],$showpath);
                $path = $savepath . $path;
                $askmodel = $this->model('askquestion');
                if(!empty($path)){
                    $time = $this->_checkAudioTime($path);
                    if(isset($time['playtime_seconds'])){
                        $audiotime = ceil($time['playtime_seconds']);
                        $setarr = array();
                        $setarr['audioname'] = json_encode(array(0 => $ask['audioname']));
                        $setarr['audiosrc'] = json_encode(array(0 => $ask['audiosrc']));
                        $setarr['audiotime'] = json_encode(array(0 => $audiotime));
                        $askmodel->updateAudio($setarr,$ask['qid']);
                        $asks[$key]['audiotime'] = $setarr['audiotime'];
                        $asks[$key]['audioname'] = $setarr['audioname'];
                        $asks[$key]['audiosrc'] = $setarr['audiosrc'];
                    }
                }
            }
        }
        return $asks;
    }
    //获取课件名
    private function getCwname($asks){
        if(empty($asks)){
            return false;
        }
        $cwid = array();
        $cwarr = array();
        foreach ($asks as $ask) {
            if(!empty($ask['cwid'])){
                $cwid[] = $ask['cwid'];
            }
        }
        if(!empty($cwid)){
            $cwidstr = implode(',',$cwid);
            $cwmodel = $this->model('courseware');
            $cwinfo = $cwmodel->getCwinfoListRewardByCwid($cwidstr);
            if(!empty($cwinfo)){
                foreach ($cwinfo as $cw) {
                    $cwarr[$cw['cwid']] = $cw['title'];
                }
            }
        }
        return $cwarr;
    }
}
