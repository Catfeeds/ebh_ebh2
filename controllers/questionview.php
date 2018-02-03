<?php
/**
 * 答疑详情
 */
class QuestionviewController extends CControl {
   
	function view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//答疑详情
		$qid = $this->uri->itemid;
		$askmodel = $this->model('askquestion');
		$qdetail = $askmodel->getaskcoursebycwid($qid);
		$this->cache->set('qdetail',$qdetail,30);
		$this->assign('qdetail', $qdetail);
		//回答答疑列表
		$askanswers = $askmodel->getdetailanswersbyqid($qid);
		$this->cache->set('askanswers',$askanswers,30);
		$this->assign('askanswers', $askanswers);
		//答题动态
		//$askanswersmodel = $this->model('askanswers');
		//$askanswer = $askanswersmodel->getaskanswers();
		$this->cache->set('askanswer',$askanswer,30);
		$this->assign('askanswer', $askanswer);
		//热门问题
		$param = array('order'=>'answercount desc','limit'=>'0,5');
		$askquestion = $askmodel->getquestionhot($param);
		$this->cache->set('askquestion',$askquestion,30);
		$this->assign('askquestion', $askquestion);
		$this->display('common/questionview');
	}
}
?>