<?php
/**
 *第三方通知类
 */
class ThirdPushUtils{
	private $db = NULL;
	public function __construct(){
		$this->db = Ebh::app()->getDb();
	}

	public function t(){
		// $this->pushExamToStudent(8386);
		// $this->PushNotice(190);//向目标推通知
		// $this->pushAskToTeacher(298287);//向教师推送问题
		// $this->PushAskToStudent(298287);//像提问者推送问题被解答
		// $this->pushCourseToStudent(116886);//向购买过课程的学生推送课件
	}
	//教师向学生推送作业
	public function pushExamToStudent($eid = 0){
		$sql = 'select e.title,e.uid,e.crid,e.grade,e.classid,e.folderid,e.dateline from ebh_schexams e where eid = '.$eid;
		$eInfo = $this->db->query($sql)->row_array();
		if(empty($eInfo)){
			log_message('作业查询失败,eid:'.$eid);
			return;
		}
		$folderid = $eInfo['folderid'];
		if(empty($folderid)){
			log_message('作业对应的课程为0,eid:'.$eid);
			return;
		}

		//获取课程信息开始
		$folder = $this->_getFolder($folderid);
		if(empty($folder)){
			log_message('课件所属课程查询失败,eid:'.$eid);
			return;
		}
		$foldername = $folder['foldername'];
		//获取课程信息结束

		//根据作业信息判断出需要推送的用户列表
		if(!empty($eInfo['grade'])){
			$sql_for_classes = 'select classid from ebh_classes c where c.grade = '.$eInfo['grade'];
			$classList = $this->db->query($sql_for_classes)->list_array();
			if(empty($classList)){
				log_message("PushExamToStudent[".$eid."]的作业,推送失败，查询改作业的班级信息");
				return false;
			}
			$classid_in = $this->_getFieldArr($classList,'classid');
		}else{
			$classid_in = array($eInfo['classid']);
		}
		//获取班级里的学生信息
		$sql_for_students = 'select cs.uid,cs.classid from ebh_classstudents cs where cs.classid in ('.implode(',', $classid_in).')';
		$studentList = $this->db->query($sql_for_students)->list_array();
		if(empty($studentList)){
			log_message("PushExamToStudent[".$eid."]的作业,推送失败，查询不到要推送的目标对象");
			return false;
		}
		$touidlist = $this->_getFieldArr($studentList,'uid');
		$userlsit_related = $this->_getUserRelatedWithFolder($folderid);

		//第三方用户筛选开始
		$useruidlist = array();
		foreach ($userlsit_related as $user_related) {
			if(in_array($user_related['uid'],$touidlist)){
				$useruidlist[] = $user_related['useruid'];
			}
		}

		if(empty($useruidlist)){
			log_message("PushExamToStudent[".$eid."]的作业,推送失败，查询不到要推送的第三方目标对象");
			return false;
		}
		//第三方用户筛选结束

		//教师信息开始
		$uid = $eInfo['uid'];
		$teacher = $this->_getUser($uid);
		if(empty($teacher)){
			log_message("PushExamToStudent[".$eid."]的作业,作业发布教师账号查询失败");
			return;
		}
		($uname = $teacher['username']) || ($uname = $teacher['username']);
		//教师信息结束

		// 作业信息开始

		$etitle = $eInfo['title'];
		$etime = date('Y-m-d H:i:s',$eInfo['dateline']);

		// 作业信息结束

		$msg = sprintf('%s 于 %s 在 %s 课程下布置了作业 %s',$uname,$etime,$foldername,$etitle);
		$datapackage = array(
			'subaction'=>'doexam',
			'id'=>strval($eid)
		);
		$this->_dopush($msg,$useruidlist,$datapackage);
	}

	//学生做完作业告诉老师
	public function pushExamToTeacher(){

	}

	//有人向教师提问，通知教师
	public function pushAskToTeacher($qid = 0){
		//1.根据问题标号查出问题信息
		$sql = 'select aq.crid,aq.qid,aq.title,aq.tid,aq.uid,aq.dateline from ebh_askquestions aq where qid = '.$qid.' limit 1';
		$qInfo = $this->db->query($sql)->row_array();
		if(empty($qInfo)){
			log_message("PushAskToTeacher：找不到qid为[".$qid."]的问题,推送失败");
			return false;
		}
		if(empty($qInfo['tid'])){//无需推送
			return;
		}
		$ouser = $this->_getOUser($qInfo['tid']);
		if(empty($ouser)){
			return;
		}
		$useruid = $ouser['useruid'];

		$askuser = $this->_getUser($qInfo['uid']);
		if(empty($askuser)){
			log_message("pushAskToTeacher[".$qid."]的问题,推送失败，查询不到提问用户");
			return;
		}

		$atitle = $qInfo['title'];
		$atime = date('Y-m-d H:i:s',$qInfo['dateline']);
		$useruidlist = array($useruid);
		($uname = $askuser['username']) || ($uname = $askuser['username']);

		$msg = sprintf('%s 于 %s 向您提问 %s',$uname,$atime,$atitle);
		$datapackage = array(
			'subaction'=>'showask_t',
			'id'=>strval($qid)
		);
		$this->_dopush($msg,$useruidlist,$datapackage);
	}

	//问题有人回答，通知提问人
	public function PushAskToStudent($qid = 0){
		//1.根据问题标号查出问题信息
		$sql = 'select aq.crid,aq.qid,aq.uid,aq.title from ebh_askquestions aq where qid = '.$qid.' limit 1';
		$qInfo = $this->db->query($sql)->row_array();
		if(empty($qInfo)){
			log_message("PushAskToStudent[".$qid."]的问题,推送失败，查询不到该问题信息");
			return false;
		}

		$ouser = $this->_getOUser($qInfo['uid']);
		if(empty($ouser)){
			return;
		}
		$useruid = $ouser['useruid'];

		$useruidlist = array($useruid);
		$atitle = $qInfo['title'];
		$atime = date('Y-m-d H:i:s',SYSTIME);

		$msg = sprintf('您的问题  %s 于 %s 被回答了',$atitle,$atime);
		$datapackage = array(
			'subaction'=>'showask_s',
			'id'=>strval($qid)
		);
		$this->_dopush($msg,$useruidlist,$datapackage);
	}


	//教师发布新课件，通知学生 (根据购买课程推)
	public function pushCourseToStudent($cwid = 0){
		//1.首先查出课件关联的课程的信息
		$sql = 'select r.crid,r.folderid,cw.uid,cw.title,cw.dateline,cw.uid from ebh_roomcourses r join ebh_coursewares cw on r.cwid = cw.cwid where r.cwid = '.$cwid.' limit 1';
		$course = $this->db->query($sql)->row_array();
		if(empty($course)){
			log_message('课件查询失败,cwid:'.$cwid);
			return;
		}
		$folderid = $course['folderid'];

		//获取课程信息开始
		$folder = $this->_getFolder($folderid);
		if(empty($folder)){
			log_message('课件所属课程查询失败,cwid:'.$cwid);
			return;
		}
		$foldername = $folder['foldername'];
		//获取课程信息结束

		$crid = $folder['crid'];
		$uid = $course['uid'];

		//获取改学校该课程购买多该课程的用户第三方uid
		$useruidlist = $this->_getUseruidRelatedWithFolder($folderid,$crid);
		if(empty($useruidlist)){
			log_message('没有推送目标,cwid:'.$cwid);
			return;
		}
		//第三方id查询完毕,下面开始组织信息

		// 课件信息开始

		$cwtitle = $course['title'];
		$cwtime = date('Y-m-d H:i:s',$course['dateline']);

		// 课件信息结束

		//教师信息开始
		$teacher = $this->_getUser($uid);
		if(empty($teacher)){
			log_message('课件发布教师账号查询失败,cwid:'.$cwid);
			return;
		}
		($uname = $teacher['username']) || ($uname = $teacher['username']);

		//教师信息结束

		$msg = sprintf('%s 于 %s 在 %s 课程下发布了课件 %s',$uname,$cwtime,$foldername,$cwtitle);
		$datapackage = array(
			'subaction'=>'showcw',
			'id'=>strval($cwid)
		);
		$this->_dopush($msg,$useruidlist,$datapackage);
	}


	//推送通知给各种人
	public function PushNotice($noticeid = 0){
		//1.获取通知的详情，用来主要用来判断推送的对象
		$sql_for_notice = 'select n.noticeid,n.crid,n.title,n.ntype,n.cids,n.grades,n.districts,n.dateline from ebh_notices n where n.noticeid = '.$noticeid.' limit 1';
		$nInfo = $this->db->query($sql_for_notice)->row_array();
		if(empty($nInfo)){
			log_message("PushNotice[".$noticeid."]的通知,推送失败，查询不到该通知信息");
			return false;
		}
		//3.发送对象获取
		//通知类型,1为全校师生 2为全校教师 3为全校学生 4为班级学生 5年级学生
		$useruidlist = array();
		$crid = $nInfo['crid'];
		$noticetype = '全校通知';
		$all_userlist = $this->_getOusersOfRoom($crid);
		switch ($nInfo['ntype']) {
			case '1':
				break;
			case '2':
				$touids = $this->_getRoomTeachers($crid);
				$noticetype = '全校教师通知';
				break;
			case '3':
				$touids = $this->_getRoomStudents($crid);
				$noticetype = '全校学生通知';
				break;
			case '4':
				$touids = $this->_getClassStudents($nInfo['cids']);
				$noticetype = '全校班级通知';
				break;
			case '5':
				$touids = $this->_getGradeStudents($crid,$nInfo['grades']);
				$noticetype = '全校年级通知';
				break;
			default:
				break;
		}

		if($nInfo['ntype'] == '1'){
			foreach ($all_userlist as $u) {
				$useruidlist[] = $u['useruid'];
			}
		}else{
			foreach ($all_userlist as $u) {
				if(in_array($u['uid'],$touids)){
					$useruidlist[] = $u['useruid'];
				}
			}
		}

		if(empty($useruidlist)){
			return;
		}

		$ntitle = $nInfo['title'];
		$ntime = date('Y-m-d H:i:s',$nInfo['dateline']);

		$msg = sprintf('您收到%s:%s',$noticetype,$ntitle);
		$datapackage = array(
			'subaction'=>'shownotice',
			'id'=>strval($noticeid)
		);
		$this->_dopush($msg,$useruidlist,$datapackage);

	}

	//信息推送
	private function _dopush($msg='',$useruidlist = array(),$datapackage = array(),$content = '',$imgUrl = ''){
		if(empty($msg) || empty($useruidlist) || empty($datapackage) ){
			return;
		}
		$useruidlist = array('5045928');

		$postarr = array(
			'title'=>$msg,
			'certIds'=>implode(',',$useruidlist),
			'package'=>base64_encode(json_encode($datapackage)),
			'content'=>$content,
			'imgUrl'=>$imgUrl
		);
		$datas = $this->_getDataForNotice($postarr);
		$url = 'http://api.jxhlw.com/control.php';
		$ret = $this->do_post($url,$datas,false);
		if(empty($ret) || $ret->dingtalk_ebhnotice_response->result != '1'){
			log_message('push err'.var_export($datas,true));
		}
	}

	private function _getDataForNotice($p = array()){
		$appkey = 'ebh';
		$appsecret = '8375908470c428d59003de7beef5f988';
		$paramarr = array(
			'method'=>'jxt.dingtalk.ebhnotice',
			'charset'=>'utf-8',
			'format'=>'json',
			'v'=>'1.0'
		);
		$paramarr = array_merge($paramarr,$p);
		$pram = http_build_query($paramarr);
		$strforsign = sprintf("%s%s%s",$appkey,$pram,$appsecret);
		$strforsign = urldecode($strforsign);
		$sign = md5($strforsign);
		$paramarr['appkey'] = $appkey;
		$paramarr['appsecret'] = $appsecret;
		$paramarr['sign'] = $sign;
		return $paramarr;
	}


	//--------------------------------------------------------------------------------------------------------------------------------------------------------

	//获取课程信息
	private function _getFolder($folderid = 0){
		$sql = 'select folderid,crid,foldername from ebh_folders where folderid = '.$folderid.' limit 1';
		return $this->db->query($sql)->row_array();
	}

	//根据课程获取与之相关的学生信息
	private function _getUseruidRelatedWithFolder($folderid = 0,$crid = 0){
		$userlist = $this->_getUserRelatedWithFolder($folderid,$crid);
		$useruidlist = array();
		foreach ($userlist as $user) {
			$useruidlist[] = $user['useruid'];
		}
		return $useruidlist;
	}

	//根据课程获取与之相关的学生信息
	private function _getUserRelatedWithFolder($folderid = 0,$crid = 0){
		$res = array();
		if(empty($crid)){
			$folder = $this->_getFolder($folderid);
			if(empty($folder)){
				return $res;
			}
			$crid = $folder['crid'];
		}
		$sql = 'select p.uid,ou.useruid from ebh_userpermisions p join ebh_ousers ou on p.uid = ou.uid where ou.crid = '.$crid.' AND p.folderid = '.$folderid.' AND p.enddate > '.SYSTIME;
		$userlist = $this->db->query($sql)->list_array();
		if(empty($userlist)){
			return $res;
		}
		return $userlist;
	}

	//获取用户信息
	private function _getUser($uid = 0){
		$sql = 'select username,realname from ebh_users where uid = '.$uid.' limit 1';
		return $this->db->query($sql)->row_array();
	}

	private function _getOUser($uid = 0){
		$sql = 'select useruid from ebh_ousers where uid = '.$uid;
		return $this->db->query($sql)->row_array();
	}

	private function _getOusersOfRoom($crid = 0){
		$sql = 'select uid,useruid,usertag from ebh_ousers where crid = '.$crid;
		return $this->db->query($sql)->list_array();
	}

	/**
	 *获取全校教师
	 */
	private function _getRoomTeachers($crid = 0,$ifReturnUidArr = true){
		$sql = 'select rt.tid as uid from ebh_roomteachers rt where rt.status = 1 and rt.crid = '.$crid;
		$res = $this->db->query($sql)->list_array();
		if($ifReturnUidArr){
			$res = $this->_getFieldArr($res,'uid');
		}
		return $res;
	}
	/**
	 *获取全校学生
	 */
	private function _getRoomStudents($crid = 0,$ifReturnUidArr = true){
		$sql = 'select ru.uid from ebh_roomusers ru where ru.cstatus = 1 AND ru.crid = '.$crid;
		$res = $this->db->query($sql)->list_array();
		if($ifReturnUidArr){
			$res = $this->_getFieldArr($res,'uid');
		}
		return $res;
	}

	private function _getClassStudents($classids,$ifReturnUidArr = true){
		if(is_array($classids)){
			$classids = $classids;
		}else if(is_scalar($classids)){
			if(stripos($classids, ',') === false){
				$classids = array(intval($classids));
			}else{
				$classids = explode(',', $classids);
			}
		}
		$sql = 'select ct.uid from ebh_classstudents ct where ct.classid in ('.implode(',', $classids).')';
		$res = $this->db->query($sql)->list_array();
		if($ifReturnUidArr){
			$res = $this->_getFieldArr($res,'uid');
		}
		return $res;
	}

	private function _getGradeStudents($crid = 0,$grades){
		if(is_array($grades)){
			$grades = $grades;
		}else if(is_scalar($grades)){
			if(stripos($grades, ',') === false){
				$grades = array(intval($grades));
			}else{
				$grades = explode(',', $grades);
			}
		}
		$sql_for_classes = 'select * from ebh_classes c where c.crid = '.$crid.' AND c.grade in ('.implode(',', $grades).')';
		$classes = $this->db->query($sql_for_classes)->list_array();
		$classids = $this->_getFieldArr($classes,'classid');
		return $this->_getClassStudents($classids);
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

	private function do_post($url, $data , $retJson = true){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
	    curl_setopt($ch, CURLOPT_POST, TRUE); 
	    curl_setopt($ch, CURLOPT_HEADER, FALSE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	    curl_setopt($ch, CURLOPT_URL, $url);
	    $ret = curl_exec($ch);
	    curl_close($ch);
	    if($retJson == false){
	        $ret = json_decode($ret);
	    }
	    return $ret;
	}

}