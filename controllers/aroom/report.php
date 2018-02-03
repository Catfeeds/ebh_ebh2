<?php
/*
学校各种统计
*/
class ReportController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getAdminLoginUser();
		$this->assign('user',$this->user);
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
		$this->display('aroom/fcreport');
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
		$this->display('aroom/tcreport');
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
		$this->display('aroom/tereport');
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
		$this->display('aroom/cereport');
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
		
		$this->assign('jquery11',true);
		$this->assign('pagestr',$pagestr);
		$this->assign('classid',$classid);
		$this->assign('classlist',$classlist);
		$this->assign('roomdetail',$roomdetail);
		$this->assign('studylist',$studylist);
		$this->display('aroom/ssreport');
	}
	/*
	学生学习统计excel
	*/
	public function ssexcel(){
		$starttime_str = $this->input->get('starttime');
		$endtime_str = $this->input->get('endtime');
		$tag = intval($this->input->get('tag'));
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
		$filename = '学生学习统计';
		$titleArr = array('学生账号','姓名','班级','课程','学习时间','学习次数');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->input->get('classid');
		if(is_numeric($classid))
			$param['classid'] = $classid;
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;
		$param['limit'] = 100000;
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
			}else{
				$dataArr[$l][0] = $sl['username'];
				$dataArr[$l][1] = $sl['realname'];
				$dataArr[$l][2] = $sl['classname'];
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
		$this->input->setcookie('export',$tag,3600);
		$this->_exportExcel($titleArr,$dataArr,'FFFFFFFF',$filename,$widtharr);
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
						$pt->setCellValue($p, $v[$kt]);
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
}
?>