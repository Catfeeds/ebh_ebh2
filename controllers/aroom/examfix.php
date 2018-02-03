<?php
class ExamfixController extends CControl{
	public function __construct(){
		parent::__construct();
		$user = $this->user = Ebh::app()->user->getAdminLoginUser();
		$roominfo = $this->roominfo = Ebh::app()->room->getcurroom();
		if(empty($user) || empty($roominfo) || $user['groupid']!=5){
			echo 'illigle!';exit;
		}
	}
	public function fixFolderid(){
		set_time_limit(0);
		$badExamList = $this->_getBadExamList();
		$cwids = $this->_getFieldArr($badExamList,'cwid');
		$param = array(
			'crid'=>$this->roominfo['crid'],
			'cwid_in'=>$cwids,
			'limit'=>10000
		);
		$courseList = $this->_getCourseInfo($param);
		if(empty($courseList)){
			echo '没有找到对应课件';return;
		}
		$courseDb = array();
		foreach ($courseList as $course) {
			$key = 'c_'.$course['cwid'];
			$courseDb[$key] = $course; 
		}
		$setInfo = array();
		foreach ($badExamList as $badExam) {
			$key = 'c_'.$badExam['cwid'];
			if(array_key_exists($key,$courseDb )){
				$setInfo[] = array('eid'=>$badExam['eid'],'folderid'=>$courseDb[$key]['folderid']);
			}
		}
		$res1 = 0;
		if(empty($setInfo)){
			echo 'all exams is ok !';
		}else{
			$res1 = $this->model('roomcourse')->mupdate($setInfo);
			if($res1 >= 0){
				echo 'exams fixed:'.$res1;
			}else{
				echo 'exams fix fail!';
			}
		}
		

		echo '<br />';

		$badLogsList = $this->_getBadLogs();
		if(empty($badLogsList)){
			echo 'all logs is ok !';
			return ;
		}
		foreach ($badLogsList as $badLog) {
			$key = 'c_'.$badLog['cwid'];
			if(array_key_exists($key,$courseDb )){
				$setInfo2[] = array('logid'=>$badLog['logid'],'folderid'=>$courseDb[$key]['folderid']);
			}
		}
		if(empty($setInfo2)){
			echo 'logs fail';exit;
		}
		$res2 = $this->model('roomcourse')->mupdate_logs($setInfo2);
		if($res2 >= 0){
			echo 'logs fixed:'.$res2;
		}else{
			echo 'logs fix fail!';
		}
	}

	//获取学校课件信息
	private function _getCourseInfo($param = array()){
		if(empty($param))return;
		$roomCourseModel = $this->model('roomcourse');
		return $roomCourseModel->getRoomCourseList($param);
	}
	//获取学校作业中包含cwid但是不包含folderid的作业列表
	private function _getBadExamList(){
		$roomCourseModel = $this->model('roomcourse');
		return $roomCourseModel->getExamWithCwidButNotFolderid($this->roominfo['crid']);
	}
	//获取学分表中包含cwid但是不包含folderid的记录列表
	private function _getBadLogs(){
		$roomCourseModel = $this->model('roomcourse');
		return $roomCourseModel->getSLogWithCwidButNotFolderid($this->roominfo['crid']);
	}
	/**
	 *获取二维数组指定的字段集合
	 */
	private function _getFieldArr($param = array(),$filedName=''){
		
		$reuturnArr = array();

		if(empty($filedName)||empty($param)){
			return $reuturnArr;
		}

		foreach ($param as $value) {
			array_push($reuturnArr, $value[$filedName]);
		}

		return $reuturnArr;
	}
}