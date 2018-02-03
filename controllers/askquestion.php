<?php
class AskquestionController extends CControl {
	public function __construct(){
		parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($roominfo)){
			header("Location:/");
		}
	}
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		if($roominfo['template']=='zwx'){
			$this->_show_zwx();
		}else if($roominfo['template']=='stores'){
			$this->_show_stores();
		}
    }
	function _show_zwx() {
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$zwxmodel = $this->model('classroom');
		$param = array('crid'=>$crid,'order'=>'displayorder,dateline desc','limit'=>'0,10');
		$zwxlist = $zwxmodel->getzwxlist($param);
		$this->cache->set('zwxlist',$zwxlist,30);
		$this->assign('zwxlist', $zwxlist);

		$roomu = $this->model('Roomuser');
		$rmuser = $roomu->getroomuser($crid);
		$this->cache->set('rmuser',$rmuser,30);
		$this->assign('rmuser', $rmuser);
		$this->display('shop/zwx/platform');
	}
	function _show_stores(){
		$folderid = $this->input->get('folderid');
		if(!is_numeric($folderid) || $folderid < 0)
			$folderid = 0;
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//课件答疑左列显示
		$cqmodel = $this->model('folder');
		$param = array('crid'=>$crid,'order'=>'f.displayorder','limit'=>'0,1000');
		$courqlist = $cqmodel->getfolderlist($param);

		foreach($courqlist as &$arr){
			$askmodel = $this->model('askquestion');
			$param = array('folderid'=>$arr['folderid'],'crid'=>$crid);
			$arr['count'] = $askmodel->getaskquestioncount($param);
		}
		$this->cache->set('courqlist',$courqlist,30);
		$this->assign('courqlist', $courqlist);

		//网校stories答疑列表
		$askmodel = $this->model('askquestion');
		$keyword = $this->input->get('q');
		$sortmode = $this->uri->sortmode;
		$sort = '';
		if($sortmode == ''){
			$sortmode = 0;
		}
		if($sortmode == 1){
			$sort = 'q.qid desc';
		}elseif($sortmode == 2){
			$sort = 'answercount desc';
		}else{
			$sort = 'q.qid desc';
		}
		$params = parsequery();
		if(!empty($folderid)){
			$params['folderid'] = $folderid;
		}
		$params['crid'] = $crid;
		$params['order'] = $sort;
		if(!empty($user)){
			$params['auid'] = $user['uid'];
			$params['shield'] = 0;
			$asklist = $askmodel->getasklistwithfavorite($params);
			$askcount = $askmodel->getaskcount($params);
		}else{
			$params['shield'] = 0;
			$asklist = $askmodel->getaskquestionlist($params);
			$askcount = $askmodel->getaskcount($params);
		}
		$this->assign('asklist', $asklist);
		//答疑数量
		$askcount = $askmodel->getaskcount($params);
		$pagestr = show_page($askcount);
		$this->assign('askcount', $askcount);
		$this->assign('pagestr',$pagestr);

		$this->display('shop/stores/askquestion');
	}
	function view(){
	//	$this->_show_stores();
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
        $this->assign('user', $user);
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//课件答疑左列显示
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'order'=>'f.displayorder','limit'=>'0,1000');
		$courqlist = $foldermodel->getfolderlist($param);

		$askmodel = $this->model('askquestion');
		foreach($courqlist as &$arr){
			$param = array('folderid'=>$arr['folderid'],'crid'=>$crid);
			$arr['count'] = $askmodel->getaskquestioncount($param);
		}
		//$this->cache->set('courqlist',$courqlist,30);
		$this->assign('courqlist', $courqlist);

		//答疑详情
		$qid = $this->uri->itemid;
		$qdetail = $askmodel->getdetailaskbyqid($qid,$user['uid']);
		//$this->cache->set('qdetail',$qdetail,30);
		$this->assign('qdetail', $qdetail);
		$this->assign('qid',$qid);
		//回答答疑列表
		$param = array();
		$param['qid'] = $qid;
		$question = $askmodel->getdetailanswersbyqid($param);
		//$this->cache->set('question',$question,30);
		$this->assign('question', $question);
		$this->display('shop/stores/askquestion_view');
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
	
}
?>
