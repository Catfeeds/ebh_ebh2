<?php
//答疑查看
class AskController extends CControl{
	public function __construct(){
		parent::__construct();
		$this->haspower = Ebh::app()->room->checkRoomControl();
	}
	
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$teachermodel = $this->model('teacher');
		$param = parsequery();
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');
		if(!empty($startdate)){
			$param['startdate'] = strtotime($startdate);
		}
		if(!empty($enddate)){
			$param['enddate'] = strtotime($enddate)+86400;
		}
		$crid = $roominfo['crid'];
		// var_dump($param);
		//教师列表
		$teacherlist = $teachermodel->getroomteacherlist($crid,$param);
		$teachercount = $teachermodel->getroomteachercount($crid,$param);
		$teacherids = '';
		$teacherListByUid = array();
		if(!empty($teacherlist)){
		foreach($teacherlist as $teacher){
			$teacherids.= $teacher['uid'].',';
			$teacherListByUid[$teacher['uid']] = $teacher;
		}
		
		$teacherids = rtrim($teacherids,',');
		$param['uids'] = $teacherids;
		$param['crid'] = $crid;
		//定提
		$askTeacherCount = $teachermodel->getRoomTeacherListAnswerCount($param);
		foreach($askTeacherCount as $ask){
			$teacherListByUid[$ask['uid']]['asknum'] = $ask['asknum'];
			// $teacherListByUid[$teacher['uid']]['answernum'] = $teacher['answernum'];
		}
		
		//回答
		$askmodel = $this->model('askquestion');
		$answerCount = $askmodel->getAnswerCountByDistinctQid($param);
		foreach($answerCount as $answer){
			$teacherListByUid[$answer['uid']]['answernum'] = $answer['answernum'];
		}
		
		$bestCount = $askmodel->getBestCount($param);
		foreach($bestCount as $best){
			$teacherListByUid[$best['uid']]['bestnum'] = $best['bestnum'];
		}
		}
		
		$pagestr = show_page($teachercount);
		$this->assign('q',$param['q']);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('pagestr',$pagestr);
		$this->assign('teacherlist',$teacherListByUid);
		$this->display('aroomv2/ask_list');
	}
	
	/*
	屏蔽问题
	*/
	public function qshield(){
		$roominfo = Ebh::app()->room->getcurroom();
		$qid = $this->input->post('qid');
		$shield = $this->input->post('shield');
		if(empty($shield) || $shield == 1){
			$shield = 1;
			$scount = -1;
		}elseif($shield == -1){
			$shield = 0;
			$scount = 1;
		}
		if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
		$param = array('qid' => $qid, 'shield' => $shield,'crid'=>$roominfo['crid']);
		$askmodel = $this->model('Askquestion');		
        $askuid = $askmodel->getaskuidbyqid($qid);
		$result = $askmodel->upQshield($param);
		if ($result) {
            echo json_encode(array('status'=>1));
            fastcgi_finish_request();
			//同步SNS数据(当屏蔽问题时问题数-1,取消屏蔽时问题数+1)
			Ebh::app()->lib('Sns')->do_sync($askuid, $scount);
            exit();
		} else {
			echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
            exit();
        }
	}
}
?>