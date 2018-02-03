<?php
/*
学校各种统计
*/
class ReportController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$modulecredit = $this->model('appmodule')->getstudentmodule(array('crid'=>$roominfo['crid'],'available'=>1,'modulecode'=>'mycredit','order'=>'displayorder','limit'=>1));
		$this->assign('modulecredit',$modulecredit);
		$this->display('aroomv2/report');
	}
	public function teacher(){
		$roominfo = Ebh::app()->room->getcurroom();
		$teachermodel = $this->model('teacher');
		$param = parsequery();
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');
		$param['startdate'] = strtotime($startdate);
		$param['enddate'] = strtotime($enddate);
		$crid = $roominfo['crid'];
		// var_dump($param);
		//教师列表
		$teacherlist = $teachermodel->getroomteacherlist($crid,$param);
		$teachercount = $teachermodel->getroomteachercount($crid,$param);
		// var_dump($teacherlist);exit;
		if(!empty($teacherlist)){
		$teacherids = '';
		$teacherListByUid = array();
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
		
		//积分收入及签到记录
		$creditmodel = $this->model('credit');
		$rulelist = $creditmodel->getCreditRuleList(array('action'=>'+'));
		$ruleids = '';
		foreach($rulelist as $rule){
			$ruleids .= $rule['ruleid'].',';
		}
		$ruleids = rtrim($ruleids,',');
		$param['ruleids'] = $ruleids;
		$param['group'] = 'toid';
		$creditlist = $creditmodel->getCreditComingList($param);
		
		foreach($creditlist as $credit){
			$teacherListByUid[$credit['toid']]['sumcredit'] = $credit['sumcredit'];
			$teacherListByUid[$credit['toid']]['sumsign'] = $credit['sumsign'];
		}
		
		//课程
		$foldermodel = $this->model('folder');
		$folderlist = $foldermodel->getTeachersFolderCount($param);
		foreach($folderlist as $folder){
			$teacherListByUid[$folder['tid']]['foldernum'] = $folder['foldernum'];
		}
		
		//课件
		$cwmodel = $this->model('courseware');
		$cwlist = $cwmodel->getTeachersCWCount($param);
		foreach($cwlist as $cw){
			$teacherListByUid[$cw['uid']]['cwnum'] = $cw['cwnum'];
		}
		
		//班级
		$classesmodel = $this->model('classes');
		$classlist = $classesmodel->getTeachersClassCount($param);
		foreach($classlist as $class){
			$teacherListByUid[$class['uid']]['classnum'] = $class['classnum'];
		}
		
		//作业，试题
		$exammodel = $this->model('exam');
		$examlist = $exammodel->getTeachersExamCount($param);
		foreach($examlist as $exam){
			$teacherListByUid[$exam['uid']]['examnum'] = $exam['examnum'];
			$teacherListByUid[$exam['uid']]['examquesnum'] = $exam['examquesnum'];
		}
		
		//评论数
		$reviewmodel = $this->model('review');
		$reviewlist = $reviewmodel->getTeachersReviewCount($param);
		foreach($reviewlist as $review){
			$teacherListByUid[$review['uid']]['reviewnum'] = $review['reviewnum'];
		}
		
		
		$this->assign('teacherlist',$teacherListByUid);
		}
		$pagestr = show_page($teachercount);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('q',$param['q']);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/report_teacher');
	}
	/*
	课程课件统计
	*/
	public function fcreport(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['limit'] = '0,1000';
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		$teacher = $this->model('teacher');
		$courselist = $folder->getfolderlist($param);
		$courseteacherlist = $teacher->getcourseteacherlist($roomdetail['crid']);
		$tempteacherarr = array();
		foreach($courseteacherlist as $ct){
			if(!in_array($ct['tid'],$tempteacherarr)){
				array_push($tempteacherarr,$ct['tid']);
			}
		}
		$course = array();
		//处理课程拥有的教师
		foreach($courseteacherlist as $ct){
			if(!empty($course[$ct['folderid']]['teacherids'])){
				$course[$ct['folderid']]['teacherids'].= ','.$ct['tid'];
				$course[$ct['folderid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$course[$ct['folderid']]['teacherids'] = $ct['tid'];
				$course[$ct['folderid']]['teachers'] = $ct['realname'];
			}
		}
		$tempcount = count($courselist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($course[$courselist[$i]['folderid']]['teacherids'])){
				$courselist[$i]['teacherids'] = $course[$courselist[$i]['folderid']]['teacherids'];
				$courselist[$i]['teachers'] = $course[$courselist[$i]['folderid']]['teachers'];
			}
			else{
				$courselist[$i]['teacherids'] = '';
			}
		}
		$this->assign('roomdetail',$roomdetail);
		$this->assign('courselist',$courselist);
		$this->assign('teachernum',count($tempteacherarr));
		$this->display('aroomv2/fcreport');
	}
	/*
	教师课件统计
	*/
	public function tcreport(){
		$starttime_str = $this->input->get('starttime');
		$endtime_str = $this->input->get('endtime');
		$this->assign('starttime_str',$starttime_str);
		$this->assign('endtime_str',$endtime_str);
		if(!empty($starttime_str)){
			$starttime = strtotime($starttime_str);
		}else{
			$starttime = "";
		}
		if(!empty($endtime_str)){
			$endtime = strtotime($endtime_str);
			if(!empty($endtime)){
				$endtime += 3600*24;
			}
		}else{
			$endtime = "";
		}

		if(!empty($endtime) && !empty($starttime)){
			if($endtime<$starttime){
				$tmp = $starttime;
				$endtime = $starttime;
				$starttime = $tmp;
				$this->assign('starttime_str',$endtime_str);
				$this->assign('endtime_str',$starttime_str);
			}
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$classlist = $classes->getroomClassList($roominfo['crid']);
		$folder = $this->model('folder');
		$param = parsequery();
		$param['pagesize'] = 100;
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		//课件信息
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;
		$classid = $this->uri->uri_attr(0);
		if(is_numeric($classid)){
			$param['classid'] = $classid;
		}

		/**课件信息获取开始**/
		$exportlogsModel = $this->model('Exportlogs');
		$exportlogsModel->courseware($param);
		$result = $exportlogsModel->getResult();
		$pagestr = show_page($result['count'],$param['pagesize']);
		/**课件信息获取结束**/

		$this->assign('classid',$classid);
		$this->assign('classlist',$classlist);
		$this->assign('roomdetail',$roomdetail);
		$this->assign('datalist',$result['data']);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/tcreport');
	}
	/*
	教师作业统计
	*/
	public function tereport(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		$teacher = $this->model('teacher');
		$teacherlist = $teacher->getRoomTeacherListExamCount($roominfo['crid']);
		// var_dump($teacherlist);
		$this->assign('teacherlist',$teacherlist);
		$this->assign('roomdetail',$roomdetail);
		$this->display('aroomv2/tereport');
	}
	
	/**
	 *班级作业统计 
	 */
	public function cereport(){
		$classes = $this->model('classes');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$classlist = $classes->getRoomClassListExamCount($param);
		$teacher = $this->model('teacher');
		$classteacherlist = $teacher->getclassteacherlist($roominfo['crid']);
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		$tempteacherarr = array();
		foreach($classteacherlist as $ct){
			if(!in_array($ct['uid'],$tempteacherarr)){
				array_push($tempteacherarr,$ct['uid']);
			}
		}
		$class = array();
		//处理班级拥有的教师
		foreach($classteacherlist as $ct){
			if(!empty($class[$ct['classid']]['teacherids'])){
				$class[$ct['classid']]['teacherids'].= ','.$ct['uid'];
				$class[$ct['classid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$class[$ct['classid']]['teacherids'] = $ct['uid'];
				$class[$ct['classid']]['teachers'] = $ct['realname'];
			}
		}
		$tempcount = count($classlist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($class[$classlist[$i]['classid']]['teacherids'])){
				$classlist[$i]['teacherids'] = $class[$classlist[$i]['classid']]['teacherids'];
				$classlist[$i]['teachers'] = $class[$classlist[$i]['classid']]['teachers'];
			}
			else
				$classlist[$i]['teacherids'] = '';
		}
		$this->assign('classlist',$classlist);
		$teacher = $this->model('teacher');
		$param = array();
		$this->assign('roomdetail',$roomdetail);
		$this->assign('teachernum',count($tempteacherarr));
		$this->display('aroomv2/cereport');
	}

	/*
	学生学习统计
	*/
	public function ssreport(){
		$starttime_str = $this->input->get('starttime');
		$endtime_str = $this->input->get('endtime');
		$this->assign('starttime_str',$starttime_str);
		$this->assign('endtime_str',$endtime_str);
		if(!empty($starttime_str)){
			$starttime = strtotime($starttime_str);
		}else{
			$starttime = "";
		}
		if(!empty($endtime_str)){
			$endtime = strtotime($endtime_str);
			if(!empty($endtime)){
				$endtime += 3600*24;
			}
		}else{
			$endtime = "";
		}

		if(!empty($endtime) && !empty($starttime)){
			if($endtime<$starttime){
				$tmp = $starttime;
				$endtime = $starttime;
				$starttime = $tmp;
				$this->assign('starttime_str',$endtime_str);
				$this->assign('endtime_str',$starttime_str);
			}
		}

		$roomuser = $this->model('roomuser');
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];

		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;

		$classid = $this->uri->uri_attr(0);
		if(is_numeric($classid))
			$param['classid'] = $classid;
		
		$roomuserlist = $roomuser->getaroomstudentlist($param);
		$roomusercount = $roomuser->getaroomstudentcount($param);
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);
		// var_dump($param);
		$param['pagesize'] = 50;
		$param['crid'] = $roominfo['crid'];
		$param['get_nologs'] = true;
		$playlogmodel = $this->model('playlog');
		$studylist = $playlogmodel->getListForClassroom2($param);
		$studylistcount = $playlogmodel->getListForClassroomCount2($param);
		$pagestr = show_page($studylistcount,$param['pagesize']);
		
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		$this->assign('pagestr',$pagestr);
		$this->assign('classid',$classid);
		$this->assign('classlist',$classlist);
		$this->assign('roomdetail',$roomdetail);
		$this->assign('studylist',$studylist);
		$this->assign('roominfo',$roominfo);
		$this->display('aroomv2/ssreport');
	}

	/** 
	 * 通过java服务器进行统计excel,包括按班级，年级和学生
	 */
	public function outexcelByJava(){
		$starttime_str = $this->input->get('starttime');
		$endtime_str = $this->input->get('endtime');
		$tag = intval($this->input->get('tag'));
		$grade = intval($this->input->get('grade'));
		$outType = $this->input->get('outType');

		if (!($outType == 'exportclass' OR  $outType == 'exportstu'))
			exit(0);
		$roominfo = Ebh::app()->room->getcurroom();
		$filename = $outType == 'exportclass' ? $roominfo['crname'].'班级统计.xls' : '学生学习统计.xls';
		$this->input->setcookie('export',$tag,3600);
		$dataserver = EBH::app()->getConfig('dataserver')->load('dataserver');
        $servers = $dataserver['exportservers'];
        //随机抽取一台服务器
        $target_server = $servers[array_rand($servers,1)];
        $exportUrl = $dataserver['exporturl'];//'/stuexport/stu/';
		$url = 'http://'.$target_server.$exportUrl.$outType.'/'.$roominfo['crid'];
		if (!empty($grade)) {
			$queryArr['grade'] = $grade;
		}
        if (!empty($starttime_str)) {
			$queryArr['startdate'] = strtotime($starttime_str);
		}
		if (!empty($endtime_str)) {
			$endtime = strtotime($endtime_str);
			if (!empty($endtime)) {
				$endtime += 3600*24;
			}
			$queryArr['lastdate'] = $endtime;
		}
		if (!empty($queryArr['lastdate']) && !empty($queryArr['startdate'])) {
			if ($queryArr['lastdate']<$queryArr['startdate']) {
				$tmp = $queryArr['lastdate'];
				$queryArr['lastdate'] = $queryArr['startdate'];
				$queryArr['startdate'] = $tmp;
			}
		}
		if (isset($queryArr))
			$url .= '?'.http_build_query($queryArr);
		//$url = 'http://192.168.6.130/aaa.xls';
		header("Content-Disposition:attachment;filename={$filename}");
		header("Pragma: public"); // required   
		header("Expires: 0"); 
		header("Content-type:application/vnd.ms-excel");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   
		header("Cache-Control: private",false); // required for certain browsers   
		header("Content-Transfer-Encoding: binary");   
		ob_clean();   
    	flush();
    	$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		echo $file_contents;
		//echo file_get_contents($url);
	}

	/*
	学生学习统计excel
	*/
	public function ssexcel(){
		$starttime_str = $this->input->get('starttime');
		$endtime_str = $this->input->get('endtime');
		$tag = intval($this->input->get('tag'));
		if(!empty($starttime_str)){
			$starttime = strtotime($starttime_str);
		}else{
			$starttime = "";
		}
		if(!empty($endtime_str)){
			$endtime = strtotime($endtime_str);
			if(!empty($endtime)){
				$endtime += 3600*24;
			}
		}else{
			$endtime = "";
		}
		if(!empty($endtime) && !empty($starttime)){
			if($endtime<$starttime){
				$tmp = $starttime;
				$endtime = $starttime;
				$starttime = $tmp;
			}
		}
		$showschoolname = TRUE;	//此参数来控制导出是否包含单位名称,即显示用户表的schoolname数据字段
		$filename = '学生学习统计';
		$titleArr = array('学生账号','姓名','班级','课程','学习时间','学习次数');
		if($showschoolname) {
			$titleArr[] = '单位';
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->input->get('classid');
		if(is_numeric($classid))
			$param['classid'] = $classid;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;
		$param['limit'] = 100000;
		if($showschoolname) {	//需要其他县
			$param['showschoolname'] = 1;
		}
		$playlogmodel = $this->model('playlog');
		$studylist = $playlogmodel->getListForClassroom2($param);
		$dataArr = array();
		$timesum = 0;
		$countsum = 0;
		$k1 = 0;
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		$subfolderlib = Ebh::app()->lib('SubFolder');
		foreach($studylist as $k=>$sl){
			$l = count($dataArr);
			if(!empty($studylist[$k-1]) && ($studylist[$k-1]['username'] == $sl['username'])){
				$dataArr[$l][0] = '';
				$dataArr[$l][1] = '';
				$dataArr[$l][2] = '';
				if($showschoolname) {
					$dataArr[$l][6] = '';
				}
			}else{
				$dataArr[$l][0] = $sl['username'];
				$dataArr[$l][1] = $sl['realname'];
				$dataArr[$l][2] = $sl['classname'];
				if($showschoolname) {
					$dataArr[$l][6] = $sl['schoolname'];
				}
			}
			
			if(in_array($roominfo['crid'],$cridarr)){
				$dataArr[$l][3] = $subfolderlib->getSubFolderNames($sl['folderid']);
				if(!empty($dataArr[$l][3]))
					$dataArr[$l][3].= '--';
				$dataArr[$l][3].= $sl['foldername'];
			}else{
				$dataArr[$l][3] = $sl['foldername'];
			}
			$dataArr[$l][4] = secondToStr($sl['stime']);
			$dataArr[$l][5] = $sl['scount'];
			
			$timesum += $sl['stime'];
			$countsum += $sl['scount'];
			if(empty($studylist[$k+1]) || $studylist[$k+1]['username']!=$sl['username']){
				$dataArr[$l+1][0] = '';
				$dataArr[$l+1][1] = '';
				$dataArr[$l+1][2] = '';
				$dataArr[$l+1][3] = '总计：';
				$dataArr[$l+1][4] = secondToStr($timesum);
				$dataArr[$l+1][5] = $countsum;
				$timesum = 0;
				$countsum = 0;
			}
		}
		if(!empty($starttime_str) || !empty($endtime_str)){
			$filename .= '(';
			$filename .= empty($starttime_str)?'_':$starttime_str;
			$filename .= '至';
			$filename .= empty($endtime_str)?'_':$endtime_str;
			$filename .= ')';
		}
		// var_dump($studylist);exit;
		$widtharr = array(20,20,20,50,20,15);
		if($showschoolname) {
			$widtharr[] = 50;
		}
		$this->input->setcookie('export',$tag,3600);
		$this->_exportExcel($titleArr,$dataArr,'FFFFFFFF',$filename,$widtharr);
	}
	/**
	 * 按班级导出学生学习统计excel
	 */
	public function ssclsexcel(){
		$starttime_str = $this->input->get('starttime');
		$endtime_str = $this->input->get('endtime');
		$tag = intval($this->input->get('tag'));
		$grade = intval($this->input->get('grade'));
		if(!empty($starttime_str)){
			$starttime = strtotime($starttime_str);
		}else{
			$starttime = "";
		}
		if(!empty($endtime_str)){
			$endtime = strtotime($endtime_str);
			if(!empty($endtime)){
				$endtime += 3600*24;
			}
		}else{
			$endtime = "";
		}
		if(!empty($endtime) && !empty($starttime)){
			if($endtime<$starttime){
				$tmp = $starttime;
				$endtime = $starttime;
				$starttime = $tmp;
			}
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$filename = $roominfo['crname'].'班级统计';
		$param['crid'] = $roominfo['crid'];
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;
		$param['limit'] = 100000;
		$playlogmodel = $this->model('playlog');
		$studylist = $playlogmodel->getListForClassroom2($param);
		if(!empty($starttime_str) || !empty($endtime_str)){
			$filename .= '(';
			$filename .= empty($starttime_str)?'_':$starttime_str;
			$filename .= '至';
			$filename .= empty($endtime_str)?'_':$endtime_str;
			$filename .= ')';
		}
		$this->input->setcookie('export',$tag,3600);
		//获取网校所有班级学生总人数
		$classesmodel = $this->model('Classes');
		$foldermodel = $this->model('Folder');
		$classes = $classesmodel->getroomClassList($param['crid']);
		$data_x = $data_y = array();
		//获取学生班级id
		if(!empty($studylist)){
			foreach ($studylist as $st){
				$uids[] = $st['uid'];
				$fuids[$st['uid']][] = $st;
				if(!isset($data_x[$st['folderid']])){
					$data_x[$st['folderid']] = $st['foldername'];
				}
				if(!in_array($st['classname'],$data_y)){
					$data_y[] = $st['classname'];
				}
			}
			$classesstu = $classesmodel->getClassStudentList(array('uids'=>$uids,'limit'=>100000));
			if(!empty($classesstu)){
				foreach ($classesstu as $stu){
					$nclasses[$stu['classid']][] = $stu['uid'];
				}
			}
		}	
		ksort($data_x);
		//班级课程相关统计
		$data = $classnames = array();
		foreach ($classes as $cla){
			$classnames[$cla['classname']] = $cla['classid'];
		}
		$classesfarr = $this->fetchfoldernums($nclasses,$fuids,$data_x,$classnames);
		$fitercids = array();
		foreach ($classes as $cla){
			//根据年级过滤
			if($grade >0){
				if($cla['grade'] != $grade){
					$fitercids[] = $cla['classid'];
					continue;
				}
			}
			$row['stunum'] = $cla['stunum'];//班级总人数
			$row['classname'] = $cla['classname'];
			$row['folders'] = $classesfarr[$cla['classid']];
			$data[$cla['classid']] = $row;
			$classnames[$cla['classname']] = $cla['classid'];
		}
		foreach ($data_y as $dy){
			$classid = $classnames[$dy];
			if(!empty($classid) && !in_array($classid,$fitercids)){
				$ndata_y[$classid] = $dy;
			}
		}
		$this->_exportNExcel($data_x, $ndata_y, $data, $filename);
	}
	
	//统计班级课程相关记录
	private function fetchfoldernums($classes,$fuids,$data_x,$classnames){
		if(empty($classes) || empty($fuids)){
			return array();	
		}
		$clafolders = array(); //班级课程数组
		foreach ($classes as $ck=>$cla){
			foreach ($cla as $uid){
				foreach ($fuids[$uid] as $folder){
					if(!in_array($folder['folderid'],$clafolders[$ck])){
						$clafolders[$ck][] = $folder['folderid'];
					}
				}
			}
		}
		//统计班级课程的学习人数、学习次数、学习时间
		$foldernums = array();
		foreach ($fuids as $folder){
			foreach ($folder as $ffolder){
				$classid = $classnames[$ffolder['classname']];
				if(isset($foldernums[$classid][$ffolder['folderid']])){
					$tmparr['stime'] = $foldernums[$classid][$ffolder['folderid']]['stime'] + $ffolder['stime'];
					$tmparr['scount'] = $foldernums[$classid][$ffolder['folderid']]['scount'] + $ffolder['scount'];
					$tmparr['stynum'] = $foldernums[$classid][$ffolder['folderid']]['stynum'] + 1;
					$foldernums[$classid][$ffolder['folderid']] = $tmparr;
				}else{
					$foldernums[$classid][$ffolder['folderid']] = array(
															'stime'=>$ffolder['stime'],
															'scount'=>$ffolder['scount'],
															'stynum'=>1
													   );
				}
			}
		}
		if(!empty($clafolders)){
			//依次统计班级课程学习相关数目
			$clanums = array();
			foreach($clafolders as $key=>$cf){
				foreach ($data_x as $kx=>$x){
					if(!empty($foldernums[$key][$kx])){
						$clanums[$key][$kx] = $foldernums[$key][$kx];
					}else{
						$clanums[$key][$kx] = array('stime'=>0,'scount'=>0,'stynum'=>0);
					}
				}
			}
		}
		return $clanums;
	}
	
	/**
	 * 课程课件统计导出excel
	 */
	public function fcexcel(){
		$filename = "课程课件统计";
		$titleArr = array("课程名称","任课教师","课件数量");

		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['limit'] = '0,1000';
		$roomdetail['foldernum'] = $folder->getcount($param);
		$teacher = $this->model('teacher');
		$courselist = $folder->getfolderlist($param);
		$roomteacherlist = $teacher->getRoomTeacherListCWCount($roomdetail['crid']);
		$courseteacherlist = $teacher->getcourseteacherlist($roomdetail['crid']);
		$tempteacherarr = array();
		foreach($courseteacherlist as $ct){
			if(!in_array($ct['tid'],$tempteacherarr)){
				array_push($tempteacherarr,$ct['tid']);
			}
		}
		$course = array();
		//处理课程拥有的教师
		foreach($courseteacherlist as $ct){
			if(!empty($course[$ct['folderid']]['teacherids'])){
				$course[$ct['folderid']]['teacherids'].= ','.$ct['tid'];
				$course[$ct['folderid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$course[$ct['folderid']]['teacherids'] = $ct['tid'];
				$course[$ct['folderid']]['teachers'] = $ct['realname'];
			}
		}
		$tempcount = count($courselist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($course[$courselist[$i]['folderid']]['teacherids'])){
				$courselist[$i]['teacherids'] = $course[$courselist[$i]['folderid']]['teacherids'];
				$courselist[$i]['teachers'] = $course[$courselist[$i]['folderid']]['teachers'];
			}
			else{
				$courselist[$i]['teacherids'] = '';
			}
		}
		
		$coursenum = 0;
		$dataArr = array();//存储数据
		foreach($courselist as $cl){
			$coursenum += $cl['coursewarenum'];
			$foldername = !empty($cl['foldername'])?$cl['foldername']:'';
			$teachers = !empty($cl['teachers'])?$cl['teachers']:'';
			$coursewarenum = !empty($cl['coursewarenum'])?$cl['coursewarenum']:'0';

			array_push($dataArr,array($foldername,$teachers,$coursewarenum));
		}
		$dataArr[count($dataArr)] = array('统计: '.count($courselist)." 个课程",
				'统计: '.count($tempteacherarr)." 个教师",
				'统计: '.$coursenum." 个课件",
		);
		$this->_exportExcel($titleArr, $dataArr,"FFFFFFFF",$filename);
	}
	
	/**
	 * 教师课件统计导出excel
	 */
	public function tcexcel(){
		$starttime_str = $this->input->get('starttime');
		$endtime_str = $this->input->get('endtime');
		$tag = intval($this->input->get('tag'));
		if(!empty($starttime_str)){
			$starttime = strtotime($starttime_str);
		}else{
			$starttime = "";
		}
		if(!empty($endtime_str)){
			$endtime = strtotime($endtime_str);
			if(!empty($endtime)){
				$endtime += 3600*24;
			}
		}else{
			$endtime = "";
		}
		if(!empty($endtime) && !empty($starttime)){
			if($endtime<$starttime){
				$tmp = $starttime;
				$endtime = $starttime;
				$starttime = $tmp;
			}
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->input->get('classid');
		if(is_numeric($classid))
			$param['classid'] = $classid;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;
		$param['limit'] = 100000;
		$exportlogsModel = $this->model('Exportlogs');
		$exportlogsModel->courseware($param);
		$result = $exportlogsModel->getResult();
		$datalist = $result['data'];
		$filename = '课件统计';
		$titleArr = array('年级','老师','课程','课件名称','上传时间','课件时长','点击量');
		$dataArr = array();
		$timesum = 0;
		$viewsum = 0;
		$k1 = 0;
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		$subfolderlib = Ebh::app()->lib('SubFolder');
		foreach($datalist as $k=>$data){
			$l = count($dataArr);
			if(!empty($datalist[$k-1]) && ($datalist[$k-1]['name'] == $data['name'])){
				if($datalist[$k-1]['gradename'] != $data['gradename']){
					$dataArr[$l][0] = $data['gradename'];	
				}else{
					$dataArr[$l][0] = '';
				}
				$dataArr[$l][1] = '';
				if($datalist[$k-1]['foldername'] != $data['foldername']){
					if(in_array($roominfo['crid'],$cridarr)){
						$dataArr[$l][2] = $subfolderlib->getSubFolderNames($data['folderid']);
						if(!empty($dataArr[$l][2]))
							$dataArr[$l][2].= '--';
						$dataArr[$l][2].= $data['foldername'];
					}else{
						$dataArr[$l][2] = $data['foldername'];
					}
				}else{
					$dataArr[$l][2] = '';
				}
			}else{
				$dataArr[$l][0] = $data['gradename'];
				$dataArr[$l][1] = $data['name'];
				if(in_array($roominfo['crid'],$cridarr)){
					$dataArr[$l][2] = $subfolderlib->getSubFolderNames($data['folderid']);
					if(!empty($dataArr[$l][2]))
						$dataArr[$l][2].= '--';
					$dataArr[$l][2].= $data['foldername'];
				}else{
					$dataArr[$l][2] = $data['foldername'];
				}
			}
			$dataArr[$l][3] = $data['title'];
			$dataArr[$l][4] = date('Y-m-d H:i',$data['dateline']);
			$dataArr[$l][5] = secondToStr($data['cwlength']);
			$dataArr[$l][6] = $data['viewnum'];
			$timesum += $data['cwlength'];
			$viewsum += $data['viewnum'];
			if(empty($datalist[$k+1]) || $datalist[$k+1]['name']!=$data['name']){
				$dataArr[$l+1][0] = '';
				$dataArr[$l+1][1] = '';
				$dataArr[$l+1][2] = '';
				$dataArr[$l+1][3] = '';
				$dataArr[$l+1][4] = '总计：';
				$dataArr[$l+1][5] = secondToStr($timesum);
				$dataArr[$l+1][6] = $viewsum;
				$timesum = 0;
				$viewsum = 0;
			}
		}
		if(!empty($starttime_str) || !empty($endtime_str)){
			$filename .= '(';
			$filename .= empty($starttime_str)?'_':$starttime_str;
			$filename .= '至';
			$filename .= empty($endtime_str)?'_':$endtime_str;
			$filename .= ')';
		}
		// var_dump($datalist);exit;
		$widtharr = array(20,20,20,30,20,15);
		$this->input->setcookie('export',$tag,3600);
		$this->_exportExcel($titleArr,$dataArr,'FFFFFFFF',$filename,$widtharr);
	}
	/**
	 * 班级作业统计导出excel
	 */
	public function ceexcel(){
		$filename = "班级作业统计";
		$titleArr = array("班级名称","任课教师","班级人数","作业数","试题数");
	
		$classes = $this->model('classes');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$classlist = $classes->getRoomClassListExamCount($param);
		$teacher = $this->model('teacher');
		$classteacherlist = $teacher->getclassteacherlist($roominfo['crid']);
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		$tempteacherarr = array();
		foreach($classteacherlist as $ct){
			if(!in_array($ct['uid'],$tempteacherarr)){
				array_push($tempteacherarr,$ct['uid']);
			}
		}
		$class = array();
		//处理班级拥有的教师
		foreach($classteacherlist as $ct){
			if(!empty($class[$ct['classid']]['teacherids'])){
				$class[$ct['classid']]['teacherids'].= ','.$ct['uid'];
				$class[$ct['classid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$class[$ct['classid']]['teacherids'] = $ct['uid'];
				$class[$ct['classid']]['teachers'] = $ct['realname'];
			}
		}
		$tempcount = count($classlist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($class[$classlist[$i]['classid']]['teacherids'])){
				$classlist[$i]['teacherids'] = $class[$classlist[$i]['classid']]['teacherids'];
				$classlist[$i]['teachers'] = $class[$classlist[$i]['classid']]['teachers'];
			}
			else
				$classlist[$i]['teacherids'] = '';
		}

		$examnum = 0;
		$quescount = 0;
		$dataArr = array();//存储数据
		foreach($classlist as $cl){
			$examnum += $cl['count'];
			$quescount += $cl['quescount'];
			$ts = empty($cl['teachers'])?0:$cl['teachers'];
			array_push($dataArr,array($cl['classname'],$ts,$cl['stunum'],$cl['count'],$cl['quescount']));

		}

		$dataArr[count($dataArr)] = array('统计: '.$roomdetail['classnum']." 个班级",
				'统计: '.count($tempteacherarr)." 个教师",
				'统计: '.$roomdetail['stunum']." 个班级人数",
				'统计: '.$examnum." 个作业数",
				'统计: '.$quescount." 个试题数",
		);
	//var_dump($dataArr);
		$this->_exportExcel($titleArr, $dataArr,"FFFFFFFF",$filename);
	}
	
	/**
	 * 教师作业统计导出excel
	 */
	public function teexcel(){
		$filename = "教师作业统计";
		$titleArr = array("用户名","教师姓名","布置作业 ","布置试题数");
	
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		$teacher = $this->model('teacher');
		$teacherlist = $teacher->getRoomTeacherListExamCount($roominfo['crid']);
		
		$coursenum = 0;
		$quesnum = 0;
		$dataArr = array();//存储数据
		foreach($teacherlist as $tl){
			$coursenum += $tl['count'];
			$quesnum += $tl['quescount'];
			$ts = empty($tl['count'])?0:$tl['count'];
			$qs = empty($tl['quescount'])?0:$tl['quescount'];
			array_push($dataArr,array($tl['username'],$tl['realname'],$ts,$qs));
		}
	
		$dataArr[count($dataArr)] = array(
				" ",
				'统计: '.count($teacherlist)." 个教师",
				'统计: '.$coursenum." 个作业数",
				'统计: '.$quesnum." 个试题数",
		);
				
		//var_dump($dataArr);
		$this->_exportExcel($titleArr, $dataArr,"FFFFFFFF",$filename);
	}
	
	/*
	答疑导出excel
	*/
	public function taexcel(){
		$roominfo = Ebh::app()->room->getcurroom();
		$typeArr = array(0,1);
		$stype = $this->input->get('stype');
		$startdate = $this->input->get('sdate');
		$enddate = $this->input->get('edate');
		if($startdate>$enddate && !empty($enddate)){
			$tdate = $startdate;
			$startdate = $enddate;
			$enddate = $tdate;
		}
		if(!in_array($stype,$typeArr))
			$stype = 0;
		$askmodel = $this->model('askquestion');
		$sortbygrade = false;
		$dataArr = array();
		if($stype == 0){//按教师分组
			$groupInfo = $this->model('tgroups')->getRoomGroup($roominfo['crid']);
			if(empty($groupInfo)){//学校没有分组
				$sortbygrade = true;
			}else{//有分组
				$tids = '';
				foreach($groupInfo as $g){
					$tids .= $g['uid'].',';
				}
			}
			
		}
		$foldermodel = $this->model('folder');
		if($stype == 1 || $sortbygrade == true){//按年级
			$gradelist = $foldermodel->getTeachersFolderList(array('crid'=>$roominfo['crid']));
			$tids = '';
			foreach($gradelist as $t){
				$tids .= $t['uid'].',';
			}
			
		}
		
		
		$param['crid'] = $roominfo['crid'];
		$param['tids'] = rtrim($tids,',');
		$param['startdate'] = strtotime($startdate);
		$param['enddate'] = empty($enddate)?'':strtotime($enddate)+86400;
		$answeredlist = $askmodel->getTeacherAnsweredList($param);//教师的指定问题/回答统计
				// var_dump($answeredlist);
		$answersArr = array();
		foreach($answeredlist as $al){//回答数拼到数组内
			$answersArr[$al['tid']]['asknum'] = $al['asknum'];
			$answersArr[$al['tid']]['answernum'] = $al['answernum'];
		}
		$folderlist = $foldermodel->getTeachersFolderList(array('tids'=>$param['tids'],'crid'=>$roominfo['crid']));
				// var_dump($folderlist);exit;
		foreach($folderlist as $folder){//课程名称拼到数组内
			if(empty($answersArr[$folder['tid']]['foldername']))
				$answersArr[$folder['tid']]['foldername'] = $folder['foldername'];
			else
				$answersArr[$folder['tid']]['foldername'] .= ','.$folder['foldername'];
		}
				// var_dump($answersArr);
		$typestr = '';
		if(!empty($groupInfo)){
			$curname = '';
			foreach($groupInfo as $k=>$g){
				if(!empty($answersArr[$g['uid']]) && !empty($answersArr[$g['uid']]['asknum'])){
					$l = count($dataArr);
					if(!empty($groupInfo[$k-1]) && ($groupInfo[$k-1]['groupname'] == $g['groupname']) && $curname == $g['groupname']){
						$dataArr[$l][0] = '';
					}else{
						$dataArr[$l][0] = $g['groupname'];
						$curname = $g['groupname'];
					}
					
					$dataArr[$l][1] = $g['realname'];
					$dataArr[$l][2] = !empty($answersArr[$g['uid']]['foldername'])?$answersArr[$g['uid']]['foldername']:'';
					$dataArr[$l][3] = $answersArr[$g['uid']]['asknum'];
					$dataArr[$l][4] = $answersArr[$g['uid']]['answernum'];
					$dataArr[$l][5] = $answersArr[$g['uid']]['asknum']-$answersArr[$g['uid']]['answernum'];
				}
			}
			$typestr = '教研组';
		}else{
		// var_dump($gradelist);
			$gradeArr = array(
				0=>'其他',
				1=>'一年级',
				2=>'二年级',
				3=>'三年级',
				4=>'四年级',
				5=>'五年级',
				6=>'六年级',
				7=>'初一',
				8=>'初二',
				9=>'初三',
				10=>'高一',
				11=>'高二',
				12=>'高三'
			);
			
			$ignore = false;
			$curgrade = '';
			foreach($gradelist as $k=>$g){
				if(!empty($answersArr[$g['uid']]) && !empty($answersArr[$g['uid']]['asknum']) && $g['grade']!=0){
					$l = count($dataArr);
					if(!empty($gradelist[$k-1]) && ($gradelist[$k-1]['grade'] == $g['grade']) && $curgrade == $g['grade']){
						if($gradelist[$k-1]['uid'] != $g['uid'])
							$dataArr[$l][0] = '';
						else//年级-老师,重复时忽略
							$ignore = true;
					}else{
						$dataArr[$l][0] = $gradeArr[$g['grade']];
						$curgrade = $g['grade'];
					}
					if(!$ignore){
						$dataArr[$l][1] = $g['realname'];
						$dataArr[$l][2] = !empty($answersArr[$g['uid']]['foldername'])?$answersArr[$g['uid']]['foldername']:'';
						$dataArr[$l][3] = $answersArr[$g['uid']]['asknum'];
						$dataArr[$l][4] = $answersArr[$g['uid']]['answernum'];
						$dataArr[$l][5] = $answersArr[$g['uid']]['asknum']-$answersArr[$g['uid']]['answernum'];
					}
					$ignore = false;
				}
			}	
			$typestr = '年级';
		}
		
		
		
		$titleArr = array($typestr,'老师','所教课程','问题数','回答数','未回答数');
		
		$filename = '答疑报表';
		if(!empty($startdate) || !empty($enddate)){
			$filename .= '(';
			$filename .= empty($startdate)?'_':$startdate;
			$filename .= '至';
			$filename .= empty($enddate)?'_':$enddate;
			$filename .= ')';
		}
		$widtharr = array(20,20,30,20,20);
		$this->_exportExcel($titleArr, $dataArr,"FFFFFFFF",$filename,$widtharr);
	}
	
	/**
	 * 导出excel
	 * @param Array array("编号",'用户名','性别'....)
	 * @param Array array('1','李华','男'...)
	 * @param String rgbColor
	 * @param String execl文件名称
	 *
	 */
	protected  function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$name,$manuallywidth=array()){
		$objPHPExcel = Ebh::app()->lib('PHPExcel');
		
		// 以下是一些设置 ，什么作者  标题啊之类的
		$objPHPExcel->getProperties()
					->setTitle("数据EXCEL导出")
					->setSubject("数据EXCEL导出")
					->setDescription("备份数据")
					->setKeywords("excel")
					->setCategory("result file");
	
		// 设置列表标题
		if(is_array($titleArr)){
			$str = "A";
			foreach($titleArr as $k=>$v){
				$p = $str++.'1';//列A1,B1,C1,D1
				if(empty($manuallywidth))
				$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
				$pt = $objPHPExcel->getActiveSheet()->getStyle($p);
				
				$pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
				$pt->getFont()->setSize(14);
				$pt->getFont()->setBold(true);
				
				//$pt->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置列填充模式 solid
				$pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
				//$pt->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//设置列边宽
				$objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
			}
		}
		//传值
		if(is_array($dataArr)){
			foreach ($dataArr as $k=>$v) {
				$str = "A";
				foreach($titleArr as $kt=>$vt){
					$p = $str.($k+2);//从第二列填充内容 A22,B22...A33 B33
					$pt = $objPHPExcel->getActiveSheet();
					if(empty($manuallywidth))
					$pt->getColumnDimension($str)->setAutoSize(true);//单元格每项内容自适应
					if(is_numeric($v[$kt])){
						if(empty($manuallywidth))
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);//A列头标题自适应
						$pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
						$pt->getColumnDimension($str)->setWidth(20);//设置单元格宽度
						$pt->setCellValue($p, $v[$kt].' ');//填充内容
					}else{
						$pt->setCellValue($p, ' '.$v[$kt]);
					}
						
					$str++;
				}
			}
		}
		if(!empty($manuallywidth)){
			$str = 'A';
			foreach($manuallywidth as $width){
				$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
				$str++;
			}
		}
		//exit(0);
		// 输出下载文件 到浏览器
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
			$name = urlencode($name);
		} else {
			$name = str_replace(' ', '', $name);
		}
		
		$filename  = $name.".xls";//文件名,带格式
		header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
		header('Content-Type:application/x-msexecl;name="'.$name.'"');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		$objWriter->save('php://output');
	}

	/**
	 * 导出excel
	 * @param $xArr关联课程
	 * @param $yAarr关联班级
	 * @param $data关联统计数据,array('classid'=>array('folderid'=>array('学习人数','学习次数','学习总时间'),'foldername'=>'课程名称'),'totalnum'=>'班级学生总人数'))
	 * @param $name导出xls名
	 */
	protected function _exportNExcel($xArr,$yAarr,$data,$name){
		$objPHPExcel = Ebh::app()->lib('PHPExcel');
		// 以下是一些设置 ，什么作者  标题啊之类的
		$objPHPExcel->getProperties()
		->setTitle("数据EXCEL导出")
		->setSubject("数据EXCEL导出")
		->setDescription("备份数据")
		->setKeywords("excel")
		->setCategory("result file");
		// 设置列表标题
		if(!empty($xArr)){
			//xls第一行开始
			$str = "C";
			foreach($xArr as $k=>$v){
				$pp = array();
				for($j = 0;$j<3;$j++){
					$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth(15);//设置列宽
					$p = $str++.'1';//C1,D1,E1
					$pp[] = $p;
				}
				unset($pp[1]);
				$mergetds = implode(':', $pp);
				$objPHPExcel->getActiveSheet()->getStyle($mergetds)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
				$objPHPExcel->getActiveSheet()->mergeCells($mergetds); //每三个合并成一个单元格
				$objPHPExcel->getActiveSheet()->setCellValue($pp[0],' '.$v);
				$objPHPExcel->getActiveSheet()->getStyle($mergetds)->applyFromArray(
						array(
								'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
										'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
								)
						)
				);
			}
			//第二行开始
			$str = "C";
			foreach ($xArr as $k=>$v){
				$j = 0;
				$p1 = $str++.'2';//A2,B2,C2
				$p2 = $str++.'2';
				$p3 = $str++.'2';
				
				//$objPHPExcel->getActiveSheet()->getStyle($p1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
				//$objPHPExcel->getActiveSheet()->getStyle($p2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
				//$objPHPExcel->getActiveSheet()->getStyle($p3)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
				//设置对齐方式
				$objPHPExcel->getActiveSheet()->getStyle($p1)->applyFromArray(
						array(
								'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
										'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
								)
						)
				);
				$objPHPExcel->getActiveSheet()->getStyle($p2)->applyFromArray(
						array(
								'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
										'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
								)
						)
				);
				$objPHPExcel->getActiveSheet()->getStyle($p3)->applyFromArray(
						array(
								'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
										'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
								)
						)
				);
				//设置自动换行
				$objPHPExcel->getActiveSheet()->getStyle($p1)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle($p2)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle($p3)->getAlignment()->setWrapText(true);
				//设置值
				$objPHPExcel->getActiveSheet()->setCellValue('A2','班级');
				$objPHPExcel->getActiveSheet()->setCellValue('B2','学生总人数');
				$objPHPExcel->getActiveSheet()->setCellValue($p1,'学习人数');
				$objPHPExcel->getActiveSheet()->setCellValue($p2,'学习次数');
				$objPHPExcel->getActiveSheet()->setCellValue($p3,'学习总时间');
			}
			//填充数据开始
			$yi = 3;
			foreach ($yAarr as $ky=>$ya){
				$row = $data[$ky];
				$folders = $row['folders'];
				$folders = !empty($folders) ? $folders : array_pad(array(), count($xArr), array('stynum'=>0,'scount'=>0,'stime'=>0));
				
				$p_1 = "A" . $yi;
				$p_2 = "B" . $yi;
				$objPHPExcel->getActiveSheet()->setCellValue($p_1,' '.$ya);
				$objPHPExcel->getActiveSheet()->setCellValue($p_2,$row['stunum']);
				$xstr = "C";
				foreach ($folders as $folder){
					$p_31 = $xstr++.$yi;
					$p_32 = $xstr++.$yi;
					$p_33 = $xstr++.$yi;
					$p_31_v = $folder['stynum'];
					$p_32_v = $folder['scount'];
					$p_33_v = $folder['stime'] > 0 ? secondToHstr($folder['stime']) : 0;
					$objPHPExcel->getActiveSheet()->setCellValue($p_31,$p_31_v);
					$objPHPExcel->getActiveSheet()->setCellValue($p_32,$p_32_v);
					$objPHPExcel->getActiveSheet()->setCellValue($p_33,$p_33_v);
				}
				$yi++;
			}
		}
		// 输出下载文件 到浏览器
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
			$name = urlencode($name);
		} else {
			$name = str_replace(' ', '', $name);
		}
		$filename  = $name.".xls";//文件名,带格式
		header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
		header('Content-Type:application/x-msexecl;name="'.$name.'"');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		$objWriter->save('php://output');
	}
	
	/*
	查看课程
	*/
	public function course(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['nosubfolder'] = 1;
		$foldermodel = $this->model('folder');
		$courselist = $foldermodel->getfolderlist($param);
		$coursecount = $foldermodel->getcount($param);
		$teachermodel = $this->model('teacher');
		$courseteacherlist = $teachermodel->getcourseteacherlist($roominfo['crid']);
		$course = array();
		//处理课程拥有的教师
		foreach($courseteacherlist as $ct){
			if(!empty($course[$ct['folderid']]['teacherids'])){
				$course[$ct['folderid']]['teacherids'].= ','.$ct['tid'];
				$course[$ct['folderid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$course[$ct['folderid']]['teacherids'] = $ct['tid'];
				$course[$ct['folderid']]['teachers'] = $ct['realname'];
			}
		}
		
		$tempcount = count($courselist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($course[$courselist[$i]['folderid']]['teacherids'])){
				$courselist[$i]['teacherids'] = $course[$courselist[$i]['folderid']]['teacherids'];
				$courselist[$i]['teachers'] = $course[$courselist[$i]['folderid']]['teachers'];
			}
			else
				$courselist[$i]['teacherids'] = '';
		}
		
		$pagestr = show_page($coursecount);
		$this->assign('q',$param['q']);
		$this->assign('pagestr',$pagestr);
        $this->assign('roominfo', $roominfo);
		$this->assign('courselist',$courselist);
		$this->display('aroomv2/report_course');
	}
	
	/*
	课件列表
	*/
	public function coursewarelist_view(){
		$folderid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['folderid'] = $folderid;
		$param['crid'] = $roominfo['crid'];
		$param['status'] = 1;
		$cwmodel = $this->model('courseware');
		$cwlist = $cwmodel->getfolderseccourselist($param);
		$cwcount = $cwmodel->getfolderseccoursecount($param);
		$pagestr = show_page($cwcount);
		$this->assign('cwlist',$cwlist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/report_courseware');
	}

	/**
	 * 课程浏览
	 */
	public function coursebrowse(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cataloglist = $this->model('schcatalog')->getList($roominfo['crid']);
		if(empty($cataloglist))
			header('Location: /aroomv2/report/course.html');
		else
			$this->display('aroomv2/coursebrowse');
	}

	/**
	 * 课程浏览树节点
	 */
	public function coursebrowsenodes(){
		$roominfo = Ebh::app()->room->getcurroom();
		$result = array();
		$crid = $roominfo['crid'];
		if($crid>0) {
			//获取所有课程目录
			$result['cataloglist']	= $this->model('schcatalog')->getList($crid);
			//获取所有课程目录下的课程
			$result['courselist']	= $this->model('schcatalog')->getcatalogcourses(array('crid' => $crid));
			//获取所有章节
			$result['sectionlist']	= $this->model('section')->getallsections(array('crid' => $crid));
		}
		echo json_encode($result);
	}
	/*
	 * ajax获取课件列表
	*/
	public function coursewarelistajax(){
		$idstr = $this->input->post('idstr');
		$cwlist = array();
		if (!empty($idstr))
		{
			$idarray = explode('_', $idstr);
			$type = $idarray[0];
			$param['folderid'] = $idarray[2];
			if ($type == 'snode')
			{
				$param['sid'] = $idarray[3];
			}
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['status'] = 1;
			$param['page'] = $this->input->post('page');
			$param['pagesize'] = 10;
			$param['limit'] = max(0, ($param['page'] - 1) * $param['pagesize']).','.$param['pagesize'];
			$cwmodel = $this->model('courseware');
			$count = $cwmodel->getfolderseccoursecount($param);
			$pagestr = $this->show_page_ajax($count,$param['pagesize']);
			$templist = $cwmodel->getfolderseccourselist($param);
			
			//格式化列表
			$cwlist = array();
			if(!empty($templist)){
				$viewnumlib = Ebh::app()->lib('Viewnum');
				$sumsize = 0;
				$sumviewnum = 0;
				foreach($templist as $key => $cw){
					$face = getthumb($cw['face'],'50_50');
					if(empty($face))
						$face = 'http://static.ebanhui.com/ebh/tpl/default/images/'.(empty($cw['sex'])?'t_man_50_50.jpg':'t_woman_50_50.jpg');
					$cwsize = round($cw['cwsize']/1024/1024,1);
					$viewnum = $viewnumlib->getViewnum('courseware',$cw['cwid']);
					$viewnum = empty($viewnum)?$cw['viewnum']:$viewnum;
					$arr = explode('.',$cw['cwurl']);
					$type = $arr[count($arr)-1];
					$target = '';
					$coursetype = 'classcourse';
					if(empty($cw['cwurl']) || in_array($type,array('flv','mp4','avi','mp3','mpeg','mpg','rmvb','rm','mov'))){
						$target = '_blank';
						$coursetype = 'course';
					}
					$sumsize += $cw['cwsize'];
					$sumviewnum += $viewnum;

					$cwlist[$key]['face']		= $face;
					$cwlist[$key]['title']		= $cw['title'];
					$cwlist[$key]['date']		= date('Y-m-d H:i:s',$cw['dateline']);
					$cwlist[$key]['cwsize']		= $cwsize;
					$cwlist[$key]['cwlength']	= secondToStr($cw['cwlength']);
					$cwlist[$key]['viewnum']	= $viewnum;
					$cwlist[$key]['target']		= $target;
					$cwlist[$key]['viewurl']	= geturl('troom/'.$coursetype.'/'.$cw['cwid']);
					$cwlist[$key]['logurl']		= geturl('aroomv2/teacher/cwstudylog/'.$cw['cwid']);
				}
			}

		}

		echo json_encode(array('cwlist' => $cwlist, 'pagestr' => $pagestr, 'total' => $count));
	}

	/**
	 * 获取AJAX分页html代码
	 * @param int $listcount总记录数
	 * @param int $pagesize分页大小
	 * @return string
	 */
	function show_page_ajax($listcount, $pagesize = 20) {
		$pagecount = @ceil($listcount / $pagesize);
		$curpage = $this->input->post('page');

		if ($curpage > $pagecount) {
		$curpage = $pagecount;
		}
		if ($curpage < 1) {
		    $curpage = 1;
		}
		//这里写前台的分页
		$centernum = 8; //中间分页显示链接的个数
		$multipage = '<div class="pages"><div class="listPage">';
		if ($pagecount <= 1) {
			$back = '';
			$next = '';
			$center = '';
		//   $gopage = '';
		} else {
			$back = '';
			$next = '';
			$center = '';
			if ($curpage == 1) {
				for ($i = 1; $i <= $centernum; $i++) {
					if ($i > $pagecount) {
						break;
					}
					if ($i != $curpage) {
						$center .= '<a href="javascript:;" rel="' . $i . '">' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
				$next .= '<a href="javascript:;" rel="' . ($curpage + 1) . '" id="next">下一页&gt;&gt;</a>';
			} elseif ($curpage == $pagecount) {
				$back .= '<a href="javascript:;" rel="' . ($curpage - 1) . '" id="next">&lt;&lt;上一页</a>';
				for ($i = $pagecount - $centernum + 1; $i <= $pagecount; $i++) {
					if ($i < 1) {
						$i = 1;
					}
					if ($i != $curpage) {
						$center .= '<a href="javascript:;" rel="' . $i . '">' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
			} else {
				$back .= '<a href="javascript:;" rel="' . ($curpage - 1) . '" id="next">&lt;&lt;上一页</a>';
				$left = $curpage - floor($centernum / 2);
				$right = $curpage + floor($centernum / 2);
				if ($left < 1) {
					$left = 1;
					$right = $centernum < $pagecount ? $centernum : $pagecount;
				}
				if ($right > $pagecount) {
					$left = $centernum < $pagecount ? ($pagecount - $centernum + 1) : 1;
					$right = $pagecount;
				}
		        for ($i = $left; $i <= $right; $i++) {
					if ($i != $curpage) {
						$center .= '<a href="javascript:;" rel="' . $i . '">' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
				$next .= '<a href="javascript:;" rel="' . ($curpage + 1) . '" id="next">下一页&gt;&gt;</a>';
			}
		}
		$multipage .= $back . $center . $next . '</div></div>';

		return $multipage;
	}
}
?>