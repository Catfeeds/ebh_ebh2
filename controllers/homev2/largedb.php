<?php
/**
 * 大数据相关控制器 LargedbController
 */
class LargedbController extends CControl {
  	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		if(empty($this->user)){
			header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
			exit;
		}
	}
	
	public function index(){
		//获取学习数据总数
		$this->display('home/largedb');
	}
	/**
	*我的学习记录
	*/
	public function study() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$playmodel = $this->model('Playlog');
		$courseware = $this->model('Courseware');
		$queryarr = parsequery();
		$q = $this->input->get('q');
		$d = $this->input->get('d');
		if(!empty($d)) {
			$startDate = strtotime($d);
			if($startDate !== FALSE) {
				$endDate = $startDate + 86400;
				$queryarr['startDate'] = $startDate;
				$queryarr['endDate'] = $endDate;
			}
		}
		$queryarr['uid'] = $user['uid'];
		$queryarr['totalflag'] = 0;
		$playlogs = $playmodel->getList($queryarr);
		if(strstr($_SERVER['HTTP_HOST'], '.ebh.net') == '.ebh.net'){
			$flg = '.ebh.net';
		}else{
			$flg = '.ebanhui.com';
		}
		//附加课程名和附件数量网校名称,课件链接地址,课件主题链接地址
		foreach($playlogs as $k=>$v){
			$tmpcourseware = $courseware->getcoursedetails($v['cwid']); 
			$coursewaresubjecturl = 'http://'.$tmpcourseware['domain'].$flg.geturl('myroom/stusubject/'.$tmpcourseware['folderid'].'-0-0-0-1');	
			$coursewareurl = 'http://'.$tmpcourseware['domain'].$flg.geturl('myroom/mycourse/'.$v['cwid']);
			$playlogs[$k]['coursewarenum'] = $tmpcourseware['coursewarenum'];
			$playlogs[$k]['foldername'] = $tmpcourseware['foldername'];
			$playlogs[$k]['crname'] = $tmpcourseware['crname'];
			$playlogs[$k]['folderid'] = $tmpcourseware['folderid'];
			$playlogs[$k]['murl'] = 'http://'.$tmpcourseware['domain'].$flg.'/myroom.html';
			$playlogs[$k]['subjecturl'] = $coursewaresubjecturl;
			$playlogs[$k]['cousewareurl'] = $coursewareurl;
		}
		
		$count = $playmodel->getListCount($queryarr);
		$pagestr = show_page($count);
		$this->assign('roominfo',$roominfo);
		$this->assign('q',$q);
		$this->assign('d',$d);
		$this->assign('playlogs',$playlogs);
		$this->assign('pagestr',$pagestr);
		$this->display('home/mystudy');
	}
	/**
	* 我做过的作业
	*/
	public function exam() {
		$classmodel = $this->model('Classroom');
		$exammodel = $this->model('Exam');
		$user = Ebh::app()->user->getloginuser();
		
		//获取作业列表
		$q = $this->input->get('q');
		$answerdate = $this->input->get('d');
		$queryarr = parsequery();
		$queryarr['uid'] = $user['uid'];
		$queryarr['hasanswer'] = 1;
		if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
			$queryarr['grade'] = $myclass['grade'];
			$queryarr['district'] = $myclass['district'];
		}
		if(!empty($answerdate)) {	//过滤答题时间
			$answertime = strtotime($answerdate);
			if($answertime !== FALSE) {
				$queryarr['abegindate'] = $answertime;
				$queryarr['aenddate'] = $answertime + 86400;
			} else {
				$answerdate = '';
			}
		}
		$exams = $exammodel->getExamListByMemberid($queryarr);
			
		
		//附加网校名称
		if(strstr($_SERVER['HTTP_HOST'], '.ebh.net') == '.ebh.net'){
			$flg = '.ebh.net';
		}else{
			$flg = '.ebanhui.com';
		}
		foreach($exams as $k=>$v){
			$tmparr = $classmodel->getclassroomdetail($v['crid']);
			$exams[$k]['crname'] = $tmparr['crname'];
			$exams[$k]['murl'] = 'http://'.$tmparr['domain'].$flg.'/myroom.html';
		}
		$count = $exammodel->getExamListCountByMemberid($queryarr);
		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('d',$answerdate);
		$this->assign('exams',$exams);
		$this->assign('pagestr',$pagestr);
        $this->display('home/myzuoye');
	}
	/**
	* 我的答疑数据
	*/
	public function myquestion() {
		$classmodel = $this->model('Classroom');
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();	
        $q = $this->input->get('q');
		$aq = $this->input->get('aq');
        $queryarr = parsequery();
		$queryarr['aq'] = $aq;
        $queryarr['uid'] = $user['uid'];
        $askmodel = $this->model('Askquestion');
        $key = $this->_getplaykey();
		$qids = $askmodel->getaskanswersqids(array('uid'=>$queryarr['uid']));
		$queryarr['qids'] = $qids;
		$myask = $askmodel->getmyasklist($queryarr);
		$count = $askmodel->getmyaskcount($queryarr);
		$pagestr = show_page($count);
		
		//附加网校名称
		if(strstr($_SERVER['HTTP_HOST'], '.ebh.net') == '.ebh.net'){
			$flg = '.ebh.net';
		}else{
			$flg = '.ebanhui.com';
		}
		foreach($myask as $k=>$v){
			$askurl = geturl('home/myask/'.$v['qid']);
			$tmparr = $classmodel->getclassroomdetail($v['crid']);	
			$myask[$k]['crname'] = $tmparr['crname'];
			$myask[$k]['murl'] = 'http://'.$tmparr['domain'].$flg.'/myroom.html';
			$myask[$k]['askurl'] = 'http://'.$_SERVER['HTTP_HOST'].$askurl;
		}
		$this->assign('asks', $myask);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('key', $key);
        $this->display('home/myquestion');
    }
   	/**
	*我的评论数据
	*/
	public function mycomment(){
		$classmodel = $this->model('Classroom');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$crid = $roominfo['crid'];
		$reviewmodel = $this->model('review');
		$q = $this->input->get('q');
		$params = parsequery();
		$params['uid'] = $user['uid'];
		$params['type'] = 'courseware';
		$params['displayorder'] = 'r.logid desc';
		$params['pagesize'] = 10;
		$params['q'] = $q;
		$reviews = $reviewmodel->getReviewListByUid($params);
		$count = $reviewmodel->getreviewcount($params);
		$reviews = parseEmotion($reviews);
		
		//附加网校名称
		if(strstr($_SERVER['HTTP_HOST'], '.ebh.net') == '.ebh.net'){
			$flg = '.ebh.net';
		}else{
			$flg = '.ebanhui.com';
		}
		foreach($reviews as $k=>$v){
			$tmparr = $classmodel->getclassroomdetail($v['crid']);	
			$reviews[$k]['crname'] = $tmparr['crname'];
			$reviews[$k]['murl'] = 'http://'.$tmparr['domain'].$flg.'/myroom.html';
		}
		$this->assign('emotionarr',getEmotionarr());
		$pagestr = show_page($count,10);
		$this->assign('reviews', $reviews);
		$this->assign('pagestr', $pagestr);
		$this->assign('count', $count);
		$this->assign('roominfo', $roominfo);
		$this->assign('user', $user);
		$this->display('home/mycomment');
	}
	
	/*
	答疑专区全部问题页面
	*/
	public function aqindex(){
		$myask = $this->model('askquestion');
		$param = parsequery();
		$param['pagesize'] = 15;
		$param['folderid'] = 0;
		$param['shield'] = 0;
		$myaskcount = $myask->getallaskcount($param);
		$myasklist = $myask->getallasklist($param);
		$key = $this->_getplaykey();
		$this->assign('key', $key);
		$this->assign('myaskcount',$myaskcount);
		$this->assign('myasklist',$myasklist);
		$this->assign('pagesize',$param['pagesize']);
		$this->assign('q',$param['q']);
		$this->display('home/aq_myask');
	}
	
	/*
	我的问题页面
	*/
	public function aqquestion(){
		$myask = $this->model('askquestion');
		$param = parsequery();
		$param['uid'] = $this->user['uid'];
		$key = $this->_getplaykey();
		$this->assign('key', $key);
		$param['pagesize'] = 15;
		$param['folderid'] = 0;
		$param['shield'] = 0;
		$myaskcount = $myask->getallaskcount($param);
		$myasklist = $myask->getallasklist($param);
		$this->assign('myaskcount',$myaskcount);
		$this->assign('myasklist',$myasklist);
		$this->assign('pagesize',$param['pagesize']);
		$this->assign('q',$param['q']);
		$this->display('home/aq_myquestion');
	}
	/*
	我的回答页面
	*/
	public function aqanswers(){
		$myask = $this->model('askquestion');
		$param = parsequery();
		$param['uid'] = $this->user['uid'];
		$param['pagesize'] = 15;
		$param['folderid'] = 0;
		$param['qshield'] = 0;
		$param['ashield'] = 0;
		$key = $this->_getplaykey();
		$this->assign('key', $key);
		$myaskcount = $myask->getaskcountbyanswers($param);
		$myasklist = $myask->getasklistbyanswers($param);
		$this->assign('myaskcount',$myaskcount);
		$this->assign('myasklist',$myasklist);
		$this->assign('pagesize',$param['pagesize']);
		$this->assign('q',$param['q']);
		$this->display('home/aq_myanswer');
	}
	/*
	我的关注页面
	*/
	public function aqfavorit(){
		$myask = $this->model('askquestion');
		$param = parsequery();
		$param['uid'] = $this->user['uid'];
		$param['pagesize'] = 15;
		$param['folderid'] = 0;
		$key = $this->_getplaykey();
		$this->assign('key', $key);
		$myaskcount = $myask->getaskcountbyfavorit($param);
		$myasklist = $myask->getasklistbyfavorit($param);
		$this->assign('myaskcount',$myaskcount);
		$this->assign('myasklist',$myasklist);
		$this->assign('pagesize',$param['pagesize']);
		$this->assign('q',$param['q']);
		$this->display('home/aq_myfavorit');
	}
	public function view(){
		$param = parsequery();
		$myask = $this->model('askquestion');
		$editor = Ebh::app()->lib('UMEditor');
		$qid = $this->uri->itemid;
		$param['qid'] = $qid;
		$param['pagesize'] = 10;
		$qdetail = $myask->getdetailaskbyqid($qid,$this->user['uid']);
		$this->assign('qdetail',$qdetail);
		$answerlist = $myask->getdetailanswersbyqid($param);
		$count = $myask->getdetailanswerscountbyqid($qid);
		$this->assign('uid',$this->user['uid']);
		$this->assign('count',$count);
		$this->assign('qid',$qid);
		$this->assign('answerlist',$answerlist);
		$this->assign('editor',$editor);
		$this->display('home/aq_views');
	}
	/*
	添加问题
	*/
	public function addquestion(){
		if($this->input->post()){
			$myask = $this->model('askquestion');
			$param['uid'] = $this->user['uid'];
			$param['catid'] = $this->input->post('catid');
			$param['grade'] = $this->input->post('grade');
			$param['title'] = $this->input->post('title');
			$param['message'] = $this->input->post('message');
			if(!isset($param['title']) || !isset($param['message']))
				return false;
			else{
				$param['title'] = h($param['title']);
				$param['message'] = h($param['message']);
			}
			$param['catpath'] = $this->input->post('catpath');
			$imagearr = $this->input->post('image');
			$audioarr = $this->input->post('audio');
			if(!empty($imagearr['upfilename']))
				$param['imagename'] = $imagearr['upfilename'];
			if(!empty($imagearr['upfilepath']))
				$param['imagesrc'] = $imagearr['upfilepath'];
			
			$audiosrc = $this->input->post('audio');
			if(!empty($audiosrc)){
				$audioname = substr( $audiosrc , strrpos($audiosrc , '/')+1 );
				$param['audioname'] = $audioname;
				$param['audiosrc'] = $audiosrc;
			}
			
			$res = $myask->insert($param);
			if($res){
				echo json_encode(array('status'=>1));
				$credit = $this->model('credit');
				// $credit->addCreditlog(15);
			}
			else
				echo json_encode(array('status'=>0)); 
			
		}else{
			$editor = Ebh::app()->lib('UMEditor');
			$upcontrol = Ebh::app()->lib('UpcontrolLib');
			$category = $this->model('category');
			$catlist = $category->getCategoriesForAskquestion();
			$askgrade = Ebh::app()->getConfig()->load('askgrade');
			$this->assign('grade',$askgrade);
			$this->assign('catlist',$catlist);
			$this->assign('editor',$editor);
			$this->assign('upcontrol',$upcontrol);
			$this->display('home/myask_add');
		}
	}
	
	/**
     * 关注或取消关注问题
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
	public function addthank(){
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
        //Todo:此处需要判断当天是否已经感谢过。
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
        $param = array();
        $param['qid'] = $qid;
        $param['uid'] = $user['uid'];
        $param['message'] = $this->input->post('message');
		if(!isset($param['message']))
			return false;
		else{
			$param['message'] = h($param['message']);
		}
		$param['audiosrc'] = $this->input->post('audio');
        $param['audioname'] = substr( $param['audiosrc'] , strrpos($param['audiosrc'] , '/')+1 );
        $param['imagename'] = $this->input->post('imagename');
        $param['imagesrc'] = $this->input->post('imagesrc');
        $param['attname'] = $this->input->post('attname');
        $param['attsrc'] = $this->input->post('attsrc');
		
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addanswer($param);
        if ($result > 0) {
            echo 'success';
			$credit = $this->model('credit');
			$credit->addCreditlog(array('ruleid'=>21,'qid'=>$param['qid']));
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
		$result = $askmodel->setbest($param);
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
     * 删除我的提问
     */
    public function delask() {
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        //$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $ask = $askmodel->getaskbyqid($qid);
        if (empty($ask) || $ask['uid'] != $user['uid']) {
            echo 'fail';
            exit();
        }
        $result = $askmodel->delask($qid);
        if ($result) {
            echo 'success';
            exit();
        } else {
            echo 'fail';
            exit();
        }
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
	修改问题
	*/
	public function edit_view(){
		if($this->input->post()){
			$myask = $this->model('askquestion');
			$param['qid'] = $this->uri->itemid;
			$param['uid'] = $this->user['uid'];
			$param['catid'] = $this->input->post('catid');
			$param['grade'] = $this->input->post('grade');
			$param['title'] = $this->input->post('title');
			$param['message'] = $this->input->post('message');
			if(!isset($param['title']) || !isset($param['message']))
				return false;
			else{
				$param['title'] = h($param['title']);
				$param['message'] = h($param['message']);
			}
			$param['catpath'] = $this->input->post('catpath');
			$imagearr = $this->input->post('image');
			 
			if(!empty($imagearr['upfilename']))
				$param['imagename'] = $imagearr['upfilename'];
			if(!empty($imagearr['upfilepath']))
				$param['imagesrc'] = $imagearr['upfilepath'];
			
			$audiosrc = $this->input->post('audio');
			if(!empty($audiosrc)){
				$audioname = substr( $audiosrc , strrpos($audiosrc , '/')+1 );
				$param['audioname'] = $audioname;
				$param['audiosrc'] = $audiosrc;
			}
			
			$res = $myask->update($param);
			if(isset($res))
				echo json_encode(array('status'=>1));
			else
				echo json_encode(array('status'=>0));
		}else{
			$editor = Ebh::app()->lib('UMEditor');
			$upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('editor',$editor);
			$this->assign('upcontrol',$upcontrol);
			$myask = $this->model('askquestion');
			$qid = $this->uri->itemid;
			$qdetail = $myask->getdetailaskbyqid($qid,$this->user['uid']);
			$category = $this->model('category');
			$catlist = $category->getCategoriesForAskquestion();
			$askgrade = Ebh::app()->getConfig()->load('askgrade');
			$this->assign('grade',$askgrade);
			$this->assign('catlist',$catlist);
			$this->assign('qdetail',$qdetail);
			$this->display('home/myask_edit');
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
	*时长秒转换成字符显示
	*/
	function getltimestr($ltime) {
		if(empty($ltime))
			return '';
		$h = intval($ltime / 3600); 
		$m = intval(($ltime - $h * 3600)/60);
		$s = $ltime -$h * 3600 - $m*60;
		$str = $h.':'.str_pad($m,2,'0',STR_PAD_LEFT).':'.str_pad($s,2,'0',STR_PAD_LEFT);

		return $str;
	}
}
