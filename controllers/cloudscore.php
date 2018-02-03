<?php
class CloudscoreController extends CControl {
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user', $user);
		$this->_show_stores();
    }
	function _show_stores(){
		if($this->input->post()){

		}else{
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$user = Ebh::app()->user->getloginuser();
			$this->assign('user', $user);
			$crid = $roominfo['crid'];
			$uid = $user['uid'];
			$classroommodel = $this->model('classroom');
			$myroom = $classroommodel->getRoomByCrid($crid);	//获取教室对应的评分等信息
			$this->assign('myroom',$myroom);
			//我的点评
			$reviewmodel = $this->model('review');
			$param = array('toid'=>$crid,'opid'=>8192,'uid'=>$uid,'order'=>'r.logid desc','limit'=>'0,1');
			$myscore = $reviewmodel->getReviewScore($param);
		//	$this->cache->set('review',$review,30);
	        $this->assign('myscore', $myscore);
			//评论
			$param = parsequery();
			$param['toid'] = $crid;
			$param['opid'] = 8192;
			$param['type'] = 'classroom';
			$reviewlist = $reviewmodel->getreviewlist($param);
			$count = $reviewmodel->getreviewcount($param);
			$pagestr = show_page($count);
			$this->assign('reviewlist', $reviewlist);
			$this->assign('pagestr',$pagestr);
			$this->display('shop/stores/cloudscore');
		}
	}
	/**
	*处理评论
	*/
	public function review() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)) {
			echo json_encode(array('code'=>'error','message'=>'请先登录！'));
			exit();
		}
		if($user['groupid'] != 6) {
			echo json_encode(array('code'=>'error','message'=>'请使用学生账户进行评价！'));
			exit();
		}
		if(empty($roominfo)) {
			echo json_encode(array('code'=>'error','message'=>'平台不存在！'));
			exit();
		}
		$reviewmodel = $this->model('Review');
		$logparam =  array('uid'=>$user['uid'],'toid'=>$roominfo['crid'],'opid'=>8192,'type'=>'classroom','value'=>0,'fromip'=>$this->input->getip(),'dateline'=>time());
		$lasttime = $reviewmodel->getLastLogTime($logparam);
		$today = date('Y-m-d');
		$todaybegintime = strtotime($today);
		if(!empty($lasttime) && ($lasttime >= $todaybegintime) ) {	//一天只能一次评分
			echo json_encode(array('code'=>'error','message'=>'您今天已经评论过了！'));
			exit();
		}
		$subject = $this->input->post('subject');
		$good = $this->input->post('good');
		$bad = $this->input->post('bad');
		$useful = $this->input->post('useful');
		$score =  intval(($good+$bad+$useful)/3);
		$logparam['credit'] = 0;
		$logparam['subject'] = $subject;
		$logparam['good'] = $good;
		$logparam['bad'] = $bad;
		$logparam['useful'] = $useful;
		$logparam['score'] = $score;		
		$logid = $reviewmodel->insert($logparam);
		$result = FALSE;
		if(!empty($logid)){
			$roommodel = $this->model('Classroom');
			$roommodel->addViewnum($roominfo['crid']);
			$param = array('good'=>$good,'bad'=>$bad,'useful'=>$useful,'score'=>$score);
			$result = $roommodel->updatescore($roominfo['crid'],$param);
		}
		if(!empty($result)){
			echo json_encode(array('code'=>'success','message'=>'提交评论成功!'));		
		} else {
			echo json_encode(array('code'=>'error','message'=>'提交评论失败!'));		
		}
		exit();
	}
}
?>
