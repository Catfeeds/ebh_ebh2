<?php
class MyaskController extends CControl{
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		if(empty($this->user)){
			header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
			exit;
		}
		$this->assign('user',$this->user);
		
	}
	/*
	全部问题页面
	*/
	public function index(){
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
		$this->display('member/myask');
	}
	/*
	我的问题页面
	*/
	public function myquestion(){
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
		$this->display('member/myquestion');
	}
	/*
	我的回答页面
	*/
	public function myanswer(){
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
		$this->display('member/myanswer');
	}
	/*
	我的关注页面
	*/
	public function myfavorit(){
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
		$this->display('member/myfavorit');
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
		$this->display('member/myask_view');
	}
	
	/**
     * 添加回答
     */
    public function addanswer() {
		echo 'fail';	//屏蔽个人中心的回答
            exit();
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
        $param['audioname'] = $this->input->post('audioname');
        $param['audiosrc'] = $this->input->post('audiosrc');
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
        //删除回答对应的文件
//        $answerlist = $askmodel->getanswersbyqid($qid);
//        foreach($answerlist as $myanswer) {
//            
//        }
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
			$this->display('member/myask_edit');
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
	/*
	添加问题
	*/
	public function addquestion(){
		if($this->input->post()){
			echo json_encode(array('status'=>0));	//屏蔽会员中心的提问
			exit();
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
			$this->display('member/myask_add');
		}
	}
	
}
?>