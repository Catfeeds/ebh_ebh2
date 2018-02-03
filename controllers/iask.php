<?php

/**
 * 答疑专区列表页
 */
class IaskController extends CControl {
    public function index() {
        $this->_show_question();
    }

	function view() {	//答疑详情
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
        $this->assign('user', $user);
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//答疑详情
		$qid = $this->uri->itemid;
		$askmodel = $this->model('askquestion');
		$qdetail = $askmodel->getdetailaskbyqid($qid,$user['uid']);
		$askmodel->addviewnum($qid);
		$this->assign('qdetail', $qdetail);
		//回答答疑列表
		$param = parsequery();
		$param['qid'] = $qid;
		$askanswers = $askmodel->getdetailanswersbyqid($param);
		$this->assign('askanswers', $askanswers);
		$subtitle = '答疑专区';
		if(!empty($qdetail))
			$subtitle = $qdetail['title']. '-答疑专区';
		$this->assign('subtitle',$subtitle);
		$this->display('common/iask');
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
}
?>
