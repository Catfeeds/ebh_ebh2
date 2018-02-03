<?php
/**
 * 教师统计分析控制器类statisticanalysis
 */
class StatisticanalysisController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
    public function index() {
        $this->display('troom/statisticanalysis');
    }
    /**
     * 班级错题排名
     */
    public function classerrorbook() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$param = parsequery();
		$q = $this->input->get('q');
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->uri_attr(0);
		if(!is_numeric($classid) || $classid < 0)
			$classid = 0;
		$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		if(!empty($classlist)) {
			$classidlist = '';
			$infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
			foreach($classlist as $class) {
				if($classid == $class['classid']) {
					$infalg = TRUE;
					break;
				}
				if(empty($classidlist))
					$classidlist = $class['classid'];
				else
					$classidlist = $classidlist.','.$class['classid'];
			}
			if($infalg)
				$param['classid'] = $classid;
			else
				$param['classid'] = $classidlist;
		}
		$errorbook = $this->model('errorbook');
		$errorlist = $errorbook->getSchoolErrorBookList($param);
		$count= $errorbook->getSchoolErrorBookCount($param);
		$pagestr = show_page($count);
		// var_dump($errorlist);
		$this->assign('errorlist',$errorlist);
		$this->assign('pagesize',$param['pagesize']);
		$this->assign('pagestr',$pagestr);
		$this->assign('classid',$classid);
		$this->assign('q',$q);
		$this->assign('room',$roominfo);
		$this->assign('classlist',$classlist);
		$this->display('troom/classerrorbook');
    }
    /**
     * 成绩统计
     */
    public function scorecount() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$param = parsequery();
		$q = $this->input->get('q');
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->uri_attr(0);
		if(!is_numeric($classid) || $classid < 0)
			$classid = 0;
		$myclasslist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classlist = array();
		$grade = 0;
		$district = 0;
		if(!empty($myclasslist)) {
			$classidlist = '';
			$infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
			foreach($myclasslist as $class) {
				if($classid == $class['classid']) {
					$grade = $class['grade'];
					$district = $class['district'];
					$infalg = TRUE;
					break;
				}
				if(empty($classidlist))
					$classidlist = $class['classid'];
				else
					$classidlist = $classidlist.','.$class['classid'];
			}
			foreach($myclasslist as $class) {
				$classlist[$class['classid']] = $class;
			}
			if($infalg) {
				$param['classid'] = $classid;
				$param['grade'] = $grade;
				$param['district'] = $district;
			} else
				$param['classid'] = $classidlist;
			$param['uid'] = $user['uid'];
			$exammodel = $this->model('Exam');
			$exams = $exammodel->getschexamscore($param);
			$count = $exammodel->getschexamscorecount($param);
			$pagestr = show_page($count);
		} else {
			$exams = array();
			$pagestr = '';
		}
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('classid',$classid);
		$this->assign('q',$q);
		$this->assign('classlist',$classlist);
		$this->assign('exams',$exams);
        $this->display('troom/scorecount');
    }
	/**
     * 成绩统计，点击某个具体的作业后
     */
    public function scorecount_view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$eid = $this->uri->itemid;
		if(!is_numeric($eid) || $eid <= 0) {
			exit();
		}
		$classid = $this->uri->uri_attr(0);
		if(empty($classid) || !is_numeric($classid) || $classid <= 0)
			$classid = 0;
		//获取班级信息
		$classmodel = $this->model('classes');
		//获取作业详情
		$myclass = '';
		$exammodel = $this->model('Exam');
		if($classid > 0) {
			$classparam = array('crid'=>$roominfo['crid'],'classid'=>$classid);
			$myclass = $classmodel->getclassdetail($classparam);
		
		}
		$isflag = FALSE;
		$examparam = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'eid'=>$eid);
		if(!empty($myclass) && !empty($myclass['grade'])) {
			$examparam['classid'] = $myclass['classid'];
			$examparam['grade'] = $myclass['grade'];
			$examparam['district'] = $myclass['district'];
			$isflag = TRUE;
		}
		$exams = $exammodel->getschexamscore($examparam);
		$exam = FALSE;
		if(!empty($exams))
			$exam = $exams[$eid];
		if(empty($exam))
			exit();
		if(empty($myclass)) {
			$classid = $exam['classid'];
			$classparam = array('crid'=>$roominfo['crid'],'classid'=>$classid);
			$myclass = $classmodel->getclassdetail($classparam);
		}
		if(empty($myclass))
			exit();
		//获取学生答题信息
		$param = array();
		$param['eid'] = $eid;
		$param['classid'] = $classid;
		$param['limit'] = 100;
		if($isflag) {
			$param['crid'] = $roominfo['crid'];
			$param['grade'] = $myclass['grade'];
			$param['district'] = $myclass['district'];
			$answerlist = $exammodel->getschexamanswerlistbygrade($param);
			$answers = array();
			foreach($answerlist as $myanswer) {
				$answers[$myanswer['uid']] = $myanswer;
			}
			//需要加上未答的学生列表
			$studentlist = $classmodel->getClassStudentList(array('classid'=>$classid,'limit'=>'1000'));
			foreach($studentlist as $mystudent) {
				if(!isset($answers[$mystudent['uid']])) {
					$answers[$mystudent['uid']] = array('aid'=>'','sex'=>$mystudent['sex'],'totalscore'=>0,'remark'=>'','username'=>$mystudent['username'],'realname'=>$mystudent['realname']);
				}
			}
		} else {
			$answers = $exammodel->getschexamanswerlistbyeid($param);
		}
		$answercount = 0;
		foreach($answers as $myanswer) {
			if(!empty($myanswer['aid']) && !empty($myanswer['status'])) {
				$answercount ++;
			}
		}
		$exam['answercount'] = $answercount;

		$this->assign('eid',$eid);
		$this->assign('roominfo',$roominfo);
		$this->assign('myclass',$myclass);
		$this->assign('answers',$answers);
		$this->assign('exam',$exam);
        $this->display('troom/scorecount_view');
    }
    /**
     * 学生笔记汇总
     */
    public function notessum() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$param = parsequery();
		$q = $this->input->get('q');
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->uri_attr(0);
		if(!is_numeric($classid) || $classid < 0)
			$classid = 0;
		$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		if(!empty($classlist)) {
			$infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
			foreach($classlist as $class) {
				if($classid == $class['classid']) {
					$infalg = TRUE;
					break;
				}
				if(empty($classidlist))
					$classidlist = $class['classid'];
				else
					$classidlist = $classidlist.','.$class['classid'];
			}
			if($infalg)
				$param['classid'] = $classid;
			else
				$param['classid'] = $classidlist;
			$param['tid'] = $user['uid'];
			$notemodel = $this->model('Note');
			$notes = $notemodel->getnotelistbyclassid($param);
			$count = $notemodel->getnotelistcountbyclassid($param);
			$pagestr = show_page($count);
		} else {
			$notes = array();
			$pagestr = '';
		}
		
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('classid',$classid);
		$this->assign('q',$q);
		$this->assign('classlist',$classlist);
		$this->assign('notes',$notes);
        $this->display('troom/notessum');
    }
    /**
     * 学习记录汇总
     */
    public function logs() {
        $roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$param = parsequery();
		$q = $this->input->get('q');
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->uri_attr(0);
		if(!is_numeric($classid) || $classid < 0)
			$classid = 0;
		$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		if(!empty($classlist)) {
			$infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
			foreach($classlist as $class) {
				if($classid == $class['classid']) {
					$infalg = TRUE;
					break;
				}
				if(empty($classidlist))
					$classidlist = $class['classid'];
				else
					$classidlist = $classidlist.','.$class['classid'];
			}
			if($infalg)
				$param['classid'] = $classid;
			else
				$param['classid'] = $classidlist;
			$param['tid'] = $user['uid'];
			$playmodel = $this->model('Playlog');
			$logs = $playmodel->getListByClassid($param);
			$count = $playmodel->getListCountByClassid($param);
			$pagestr = show_page($count);
		} else {
			$notes = array();
			$pagestr = '';
		}
		
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('classid',$classid);
		$this->assign('q',$q);
		$this->assign('classlist',$classlist);
		$this->assign('logs',$logs);
        $this->display('troom/logs');
    }
    /**
     * 错题集汇总
     */
    public function errors() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$param = parsequery();
		$q = $this->input->get('q');
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->uri_attr(0);
		if(!is_numeric($classid) || $classid < 0)
			$classid = 0;

		$folderid = intval($this->uri->uri_attr(1));
		if(!is_numeric($folderid) || $folderid < 0){
			$folderid = 0;
		}
		$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		if(!empty($classlist)) {
			$infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
			foreach($classlist as $class) {
				if($classid == $class['classid']) {
					$infalg = TRUE;
					break;
				}
				if(empty($classidlist))
					$classidlist = $class['classid'];
				else
					$classidlist = $classidlist.','.$class['classid'];
			}
			if($infalg)
				$param['classid'] = $classid;
			else
				$param['classid'] = $classidlist;
			$param['tid'] = $user['uid'];
			$param['folderid'] = $folderid;
			$param['order'] = 'e.eid desc,er.eid desc';
			$errormodel = $this->model('Errorbook');
			$errors = $errormodel->getSchErrorBookListByClassid($param);
			$count = $errormodel->getSchErrorBookListCountByClassid($param);
			$pagestr = show_page($count);
		} else {
			$notes = array();
			$pagestr = '';
		}
		// 获取教师所在学校的课程
		$folderModel = $this->model('folder');
		$teacherFolderList = $folderModel->getTeacherFolderList(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'power'=>'0,1'));
		$folderList = array();
		if(!empty($teacherFolderList)){
			$tmp = array_pop($teacherFolderList);
			$folderList = $tmp['folder'];
		}
		$this->assign('folderList',$folderList);
		$this->assign('pagesize',$param['pagesize']);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('classid',$classid);
		$this->assign('folderid',$folderid);
		$this->assign('q',$q);
		$this->assign('classlist',$classlist);
		$this->assign('errors',$errors);
        $this->display('troom/errors');
    }
	/**
	*时长秒转换成字符显示
	*/
	function getltimestr($ltime) {
		if(empty($ltime))
			return '';
		$h = intval($ltime / 3600); 
		$m = intval(($ltime - $h * 3600)/60);
		$s = $ltime -$h * 3600 - $m*60;
		$str = $h.':'.str_pad($m,2,'0',STR_PAD_LEFT).':'.str_pad($s,2,'0',STR_PAD_LEFT);

		return $str;
	}
	
	public function scexcel(){
		$filename = '学生成绩';
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$eid = $this->input->get('eid');
		if(!is_numeric($eid) || $eid <= 0) {
			exit();
		}
		//获取作业详情
		$exammodel = $this->model('Exam');
		$examparam = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'eid'=>$eid);
		$exams = $exammodel->getschexamscore($examparam);
		$exam = FALSE;
		if(!empty($exams))
			$exam = $exams[$eid];
		if(empty($exam))
			exit();
		
		//获取学生答题信息
		$param = array();
		$param['eid'] = $eid;
		$param['classid'] = $exam['classid'];
		$param['limit'] = 100;
		$answers = $exammodel->getschexamanswerlistbyeid($param);
		$titleArr = array('学生账号','姓名','得分');
		$dataArr = array();
		foreach($answers as $answer){
			array_push($dataArr,array($answer['username'],$answer['realname'],$answer['totalscore']));
		}
		$widtharr = array(20,20,20);
		$this->_exportExcel($titleArr,$dataArr,'FFFFFFFF',$filename,$widtharr);
	}
	
	
	private function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$name,$manuallywidth=array()){
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

	/**
	 *获取指定题目下面的错题列表和学生信息(ajax获取)
	 *@param quesid (错题对应schquestions里面的qid) post参数 必选
	 *@param classid (对应的班级id) post参数 可选
	 *@return 数组 json格式
	 */
	public function getTotalErrors(){
		$result = array();
		$rec = $this->input->post();
		if(empty($rec['quesid'])){
			$result['status'] = -1;
			$result['msg'] = '题目编号错误';
			echo json_encode($result);
			exit;
		}
		$quesid = intval($rec['quesid']);
		!empty($rec['classid']) && ($classid = intval($rec['classid']));
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		//获取教师所教班级
		$classModel = $this->model('classes');
		$classList = $classModel->getTeacherClassList($roominfo['crid'],$user['uid']);
		if(empty($classList)){
			$result['status'] = -2;
			$result['msg'] = '教师没有教任何班级';
			echo json_encode($result);
			exit;
		}
		$classidArr = $this->_getFieldArr($classList,'classid');
		if(!empty($classid) && !in_array($classid, $classidArr)){
			$result['status'] = -3;
			$result['msg'] = '教师该班级';
			echo json_encode($result);
			exit;
		}
		if(!empty($classid)){
			//classid为非空,获取该班级的学生
			$studentList = $classModel->getClassStudentList(array('classid'=>$classid,'limit'=>'1000'));
		}else{
			//获取所有班级学生
			$classidlist = implode(',', $classidArr);
			$studentList = $classModel->getClassStudentList(array('classidlist'=>$classidlist,'limit'=>'1000'));
		}
		if(empty($studentList)){
			$result['status'] = -4;
			$result['msg'] = '班级下不存在学生';
			echo json_encode($result);
			exit;
		}
		$uidArr = $this->_getFieldArr($studentList,'uid');

		//组织参数
		$param = array(
			'uid_in'=>$uidArr,
			'quesid'=>$quesid,
			'limit'=>1000
		);
		$errorModel = $this->model('errorbook');
		$errorList = $errorModel->getTotalErrors($param);
		array_walk($errorList, function(&$v,$k){
			$v['erranswers'] = base64str(unserialize($v['erranswers']));
		});
		
		//组织结果
		$result['status'] = 1;
		$result['msg'] = '查询成功';
		$result['data'] = json_encode($errorList);
		echo json_encode($result);
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

	 /**
     * 单个学员的成绩统计
     */
    public function scorefind_view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$param = parsequery();
		$q = $this->input->get('q');
		$param['crid'] = $roominfo['crid'];
		$uid = $this->uri->itemid;
		if(!is_numeric($uid) || $uid <= 0) {
			$uid = 0;
		}
		$member = FALSE;
		if($uid > 0){
			$usermodel = $this->model('User');
			$member = $usermodel->getuserbyuid($uid);
			if(!empty($member)) {
				$membername = empty($member['realname']) ? $member['username'] : $member['realname'];
			}
			
		}
		$classid = $this->uri->uri_attr(0);
		if(!is_numeric($classid) || $classid < 0)
			$classid = 0;
		$myclasslist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classlist = array();
		$grade = 0;
		$district = 0;
		if(!empty($myclasslist)) {
			$classidlist = '';
			$infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
			foreach($myclasslist as $class) {
				if($classid == $class['classid']) {
					$grade = $class['grade'];
					$district = $class['district'];
					$infalg = TRUE;
					break;
				}
				if(empty($classidlist))
					$classidlist = $class['classid'];
				else
					$classidlist = $classidlist.','.$class['classid'];
			}
			foreach($myclasslist as $class) {
				$classlist[$class['classid']] = $class;
			}
			if($infalg) {
				$param['classid'] = $classid;
				$param['grade'] = $grade;
				$param['district'] = $district;
			} else
				$param['classid'] = $classidlist;
			$param['uid'] = $uid;
			$exammodel = $this->model('Exam');
			$exams = $exammodel->getschexams($param);
			$count = $exammodel->getschexamscorecount($param);
			$pagestr = show_page($count);
		} else {
			$exams = array();
			$pagestr = '';
		}
		$this->assign('membername',$membername);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('classid',$classid);
		$this->assign('q',$q);
		$this->assign('classlist',$classlist);
		$this->assign('exams',$exams);
		$this->assign('uid',$uid);
        $this->display('troom/scorefind');
    }

	/**
     * 学习记录(单个学生学习记录列表)
     */
    public function studylogs_view() {
        $roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classes = $this->model('classes');
		$param = parsequery();
		$q = $this->input->get('q');
		$param['crid'] = $roominfo['crid'];
		$uid = $this->uri->itemid;
		if(!is_numeric($uid) || $uid <= 0) {
			$uid = 0;
		}
		$member = FALSE;
		if($uid > 0){
			$usermodel = $this->model('User');
			$member = $usermodel->getuserbyuid($uid);
			if(!empty($member)) {
				$membername = empty($member['realname']) ? $member['username'] : $member['realname'];
			}
			
		}
		$classid = $this->uri->uri_attr(0);
		if(!is_numeric($classid) || $classid < 0)
			$classid = 0;
		$classlist = $classes->getTeacherClassList($roominfo['crid'],$user['uid']);
		if(!empty($classlist)) {
			$infalg = FALSE;	//判断给定的班级编号是否在教师的班级列表中
			foreach($classlist as $class) {
				if($classid == $class['classid']) {
					$infalg = TRUE;
					break;
				}
				if(empty($classidlist))
					$classidlist = $class['classid'];
				else
					$classidlist = $classidlist.','.$class['classid'];
			}
			if($infalg)
				$param['classid'] = $classid;
			else
				$param['classid'] = $classidlist;
			$param['uid'] = $uid;
			$playmodel = $this->model('Playlog');
			$logs = $playmodel->getListByClassid($param);
			$count = $playmodel->getListCountByClassid($param);
			$pagestr = show_page($count);
		} else {
			$notes = array();
			$pagestr = '';
		}
		$this->assign('membername',$membername);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('classid',$classid);
		$this->assign('q',$q);
		$this->assign('classlist',$classlist);
		$this->assign('logs',$logs);
		$this->assign('uid', $uid);
        $this->display('troom/studylogs');
    }

	 /**
     * 错题集(单个学生错题集列表)
     */
    public function errorlogs_view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$memberid = $this->uri->itemid;;	//学生编号
		if(!is_numeric($memberid) || $memberid <= 0) {
			$memberid = 0;
		}
		$member = FALSE;
		if($memberid > 0){
			$usermodel = $this->model('User');
			$member = $usermodel->getuserbyuid($memberid);
			if(!empty($member)) {
				$membername = empty($member['realname']) ? $member['username'] : $member['realname'];
			}
			
		}
		$errormodel = $this->model('Errorbook');
		//获取作业列表
		$q = $this->input->get('q');
		$d = $this->input->get('d');
		$queryarr = parsequery();
		$queryarr['uid'] = $memberid;
		$queryarr['crid'] = $roominfo['crid'];
		$begintime = $this->input->get('begintime');
		$endtime = $this->input->get('endtime');
        $stardateline = '';
        $enddateline = '';
        if(!empty($d)) {
           $stardateline = strtotime($d);
		   if($stardateline !== FALSE) {
				$enddateline = $stardateline + 86400;
				$begintime = date('Y-m-d',$stardateline);
				$endtime = date('Y-m-d',$stardateline);
		   }
        } else {
			$stardateline = strtotime($begintime);
			$enddateline = strtotime($endtime);
			if($enddateline !== FALSE)
				$enddateline = $enddateline + 86400;
		}
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $memberid;
		$queryarr['startDate'] = $stardateline;
		$queryarr['endDate'] = $enddateline;
		$errors = $errormodel->myscherrorbooklist($queryarr);
		$count = $errormodel->myscherrorbooklistcount($queryarr); 

		$pagestr = show_page($count);
		$this->assign('q',$q);
		$this->assign('d',$d);
		$this->assign('membername',$membername);
		$this->assign('begintime',$begintime);
		$this->assign('endtime',$endtime);
		$this->assign('errors',$errors);
		$this->assign('pagestr',$pagestr);
		$this->assign('memberid',$memberid);
        $this->assign('pagestr', $pagestr);
        $this->display('troom/errorlogs');
    }
	 /**
     * 答疑记录(单个学生答疑列表)
     */
    public function question_view() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$uid = $this->uri->itemid;
		if(!is_numeric($uid) || $uid <= 0) {
			$uid = 0;
		}
		$member = FALSE;
		if($uid > 0){
			$usermodel = $this->model('User');
			$member = $usermodel->getuserbyuid($uid);
			if(!empty($member)) {
				$membername = empty($member['realname']) ? $member['username'] : $member['realname'];
			}
			
		}
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['uid'] = $uid;
        $askmodel = $this->model('Askquestion');
		$qids = $askmodel->getaskanswersqids(array('uid'=>$queryarr['uid']));
		$queryarr['qids'] = $qids;
		$queryarr['cridsis'] = $roominfo['crid'];
		$myask = $askmodel->getmyasklist($queryarr);
		$count = $askmodel->getmyaskcount($queryarr);
		$pagestr = show_page($count);
		$this->assign('membername', $membername);
		$this->assign('asks', $myask);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->display('troom/question');
    }

	//教师统计
	public function teach() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$teachermodel = $this->model('teacher');
		$param = parsequery();
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');
		$param['startdate'] = strtotime($startdate);
		$param['enddate'] = strtotime($enddate);
		$crid = $roominfo['crid'];
		$param['uid'] = $user['uid'];
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
        $this->display('troom/teach');
    }
}
