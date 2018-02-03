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
        $this->display('troomv2/statisticanalysis');
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
		$this->display('troomv2/classerrorbook');
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
        $this->display('troomv2/scorecount');
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
        $this->display('troomv2/scorecount_view');
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
        $this->display('troomv2/notessum');
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
        $this->display('troomv2/logs');
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
        $this->display('troomv2/errors');
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
        $param['limit'] = 10000;
        if(!empty($exam['classid'])){
            $param['classid'] = $exam['classid'];
            $answers = $exammodel->getschexamanswerlistbyeid($param);
        }else{
            $myexam = $exammodel->getschexambyeid($eid);
            $classes = $this->model('classes')->getClasses(array('crid'=>$roominfo['crid'],'grade'=>$myexam['grade']));
            if(empty($classid)){
                $classid = '';
                foreach($classes as &$class){
                    if(empty($classid)){
                        $classid = $class['classid'];
                    }else{
                        $classid .= ','.$class['classid'];
                    }
                }
            }
            $myexam['classid'] = $classid;
            $answers = $exammodel->getschexamanswerlistbygrade($myexam);
        }

		$titleArr = array('学生账号','姓名','得分');
		$dataArr = array();
		foreach($answers as $answer){
			array_push($dataArr,array($answer['username'],$answer['realname'],$answer['totalscore']));
		}
		$widtharr = array(20,20,20);
		$this->_exportExcel($titleArr,$dataArr,'FFFFFFFF',$filename,$widtharr);
	}

    //选课学生信息导出
    public function xk_excel(){
        $get = $this->input->get();
        $get['group'] = ' group by s.uid';
        $list = $this->model('xuanke')->getStudentList($get);
        $dataArr = array();
        foreach($list as $answer){
            $time = date('Y-m-d H:i',$answer['sign_time']);
            array_push($dataArr,array($answer['username'],$answer['realname'],$answer['classname'],$time));
        }
        $filename = '选课学生报名列表';
        $titleArr = array('学生账号','姓名','班级','报名时间');
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
        $classModel = $this->model('classes');
        if(!empty($rec['classid'])){
            //获取教师所教班级
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
        }elseif(!empty($rec['gradeid'])){
            $classes = $classModel->getClasses(array('crid'=>$roominfo['crid'],'grade'=>$rec['gradeid']));
            if(empty($classid)){
                $classid = '';
                foreach($classes as &$class){
                    if(empty($classid)){
                        $classid = $class['classid'];
                    }else{
                        $classid .= ','.$class['classid'];
                    }
                }
            }
        }
//		if(!empty($classid)){
//			//classid为非空,获取该班级的学生
//			$studentList = $classModel->getClassStudentList(array('classid'=>$classid,'limit'=>'10000'));
//		}else{
//			//获取所有班级学生
//			$classidlist = implode(',', $classidArr);
//			$studentList = $classModel->getClassStudentList(array('classidlist'=>$classidlist,'limit'=>'100000'));
//		}
//		if(empty($studentList)){
//			$result['status'] = -4;
//			$result['msg'] = '班级下不存在学生';
//			echo json_encode($result);
//			exit;
//		}
//		$uidArr = $this->_getFieldArr($studentList,'uid');

		//组织参数
		$param = array(
//			'uid_in'=>$uidArr,
			'quesid'=>$quesid,
			'limit'=>1000
		);
		$errorModel = $this->model('errorbook');
		$errorList = $errorModel->getTotalErrors($param);
        if(empty($classid)){
            if(!empty($errorList)){
                foreach($errorList as $key=>$error){
                    $roomlist = $this->model('classroom')->getroomlistbyuid($error['uid']);
                    $roomlist = $this->_getFieldArr($roomlist,'crid');
                    if(in_array($roominfo['crid'],$roomlist)){
                        $errorList_r[] = $error;
                    }
                }
            }
            $errorList = $errorList_r;

        }else{
            if(!empty($errorList)){
                foreach($errorList as $key=>$error){
                    $classes = $this->model('classes')->getClassidsByUid($roominfo['crid'],$error['uid']);
                    if(in_array($rec['classid'],$classes)){
                        $errorList_r[] = $error;
                    }
                }
            }
            $errorList = $errorList_r;
        }
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
		$this->assign('room',$roominfo);
        $this->assign('user', $user);
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

		//新版作业新页面
		$exampower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($exampower) {
			$this->assign('membername',$membername);
			$this->assign('name',$membername);
			$this->assign('examPower',1);
			$this->assign('roominfo',$roominfo);
			$this->assign('uid',$uid);
			$this->display('troomv2/scorefind');
			exit();
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
            $param['type'] = array(0,2);
			$exammodel = $this->model('Exam');
			$exams = $exammodel->getschexams($param);
			$count = $exammodel->getschexamscount($param);
			$pagestr = show_page($count);
		} else {
			$exams = array();
			$pagestr = '';
		}
		$this->assign('membername',$membername);
		$this->assign('name',$membername);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('classid',$classid);
		$this->assign('q',$q);
		$this->assign('classlist',$classlist);
		$this->assign('exams',$exams);
		$this->assign('uid',$uid);
        $this->display('troomv2/scorefind');
    }

	/**
     * 学习记录(单个学生学习记录列表)
     */
    public function studylogs_view() {
        $roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('room',$roominfo);
        $this->assign('user', $user);
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
		$this->assign('name',$membername);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('classid',$classid);
		$this->assign('q',$q);
		$this->assign('classlist',$classlist);
		$this->assign('logs',$logs);
		$this->assign('uid', $uid);
        $this->display('troomv2/studylogs');
    }

	 /**
     * 错题集(单个学生错题集列表)
     */
    public function errorlogs_view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('room',$roominfo);
    	$this->assign('roominfo',$roominfo);
        $this->assign('user', $user);
		$memberid = $this->uri->itemid;;	//学生编号
		$uid = $this->uri->itemid;
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
		//新版作业新页面
		$exampower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($exampower) {
			$this->assign('membername',$membername);
			$this->assign('name',$membername);
			$this->assign('examPower',1);
			$this->assign('roominfo',$roominfo);
			$this->assign('uid',$uid);
			$this->display('troomv2/errorlogs');
			exit();
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
		$this->assign('uid', $uid);
		$this->assign('membername',$membername);
		$this->assign('name',$membername);
		$this->assign('begintime',$begintime);
		$this->assign('endtime',$endtime);
		$this->assign('errors',$errors);
		$this->assign('pagestr',$pagestr);
		$this->assign('memberid',$memberid);
        $this->assign('pagestr', $pagestr);
        $this->display('troomv2/errorlogs');
    }
	 /**
     * 答疑记录(单个学生答疑列表)
     */
    public function question_view() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
    	$this->assign('room',$roominfo);
    	$this->assign('roominfo',$roominfo);
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
		$this->assign('name', $membername);
		$this->assign('asks', $myask);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('uid', $uid);
        $this->display('troomv2/question');
    }
    
    /**
     * 积分明细
     */
    public function credit_view(){
    	$roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
    	$this->assign('room',$roominfo);
    	$this->assign('roominfo',$roominfo);
    	$uid = $this->uri->itemid;
    	if(!is_numeric($uid) || $uid <= 0) {
    		$uid = 0;
    	}
    	if($uid > 0){
    		$usermodel = $this->model('User');
    		$member = $usermodel->getuserbyuid($uid);
    		if(!empty($member)) {
    			$membername = empty($member['realname']) ? $member['username'] : $member['realname'];
    		}
    	}
    	$this->assign('user',$user);
    	$credit = $this->model('credit');
    	$param = parsequery();
    	$param['pagesize'] = 15;
    	$param['toid'] = $uid;
    	$creditlist = $credit->getCreditList($param);
    	$creditcount = $credit->getUserCreditCount($param);
    	
    	$pagestr = show_page($creditcount,$param['pagesize']);
    	$this->assign('pagestr', $pagestr);
    	
    	$this->assign('uid', $uid);
    	$this->assign('name',$membername);
    	$this->assign('creditlist',$creditlist);
    	$this->assign('creditcount',$creditcount);
    	$this->assign('pagesize',$param['pagesize']);
    	$this->display('troomv2/credit_view');
    }

    /*
     基本信息页面
    */
    public function profile_view(){
    	$uid = $this->uri->itemid;
    	if(!is_numeric($uid) || $uid <= 0) {
    		$uid = 0;
    	}

		$user = Ebh::app()->user->getloginuser();
    	$room = Ebh::app()->room->getcurroom();
    	$this->assign('room',$room);
    	$this->assign('roominfo',$room);
        $this->assign('user', $user);
    	$member = $this->model('member');
    	$memberdetail = $member->getfullinfo($uid);
    	//var_dump($memberdetail);
    	$name = !empty($memberdetail['realname']) ? $memberdetail['realname']:$memberdetail['username'] ;
    	$explist = $this->model('experiences')->getList($uid);
    	$this->assign('memberdetail',$memberdetail);
    	$this->assign('explist', $explist);
    	$this->assign('uid', $uid);
    	$this->assign('name', $name);
    	$this->display('troomv2/profile_view');
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
        $this->display('troomv2/teach');
    }
    /*
     * 成长记录
     */
    public function growlist_view(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user_t = Ebh::app()->user->getloginuser();
        $this->assign('user',$user_t);
        $this->assign('roominfo',$roominfo);
        $this->assign('room',$roominfo);
        $uid = $this->uri->itemid;
        $baseinfo = $this->getbaseinfo();//成长记录
        //互动课堂统计
        //获取这个学生所在该校所属的班级
        $IaLogsModel = $this->model('iaclassroomlog');
        $classesModel = $this->model('classes');
        $stuClassInfo = $classesModel->getClassByUid($roominfo['crid'],$uid);
        if(empty($stuClassInfo)){
            exit;
        }
        $classTeacherList = $classesModel->getClassTeacherByClassid($stuClassInfo['classid']);
        if(empty($classTeacherList)){
            exit;
        }
        $tidArr = array();
        foreach ($classTeacherList as $classTeacher) {
            array_push($tidArr, $classTeacher['uid']);
        }
        $tid_in = '('.implode(',', $tidArr).')';
        $param = array(
            'crid'=>$roominfo['crid'],
            'uid'=>$uid,
            'tid_in'=>$tid_in,
            'classid'=>$stuClassInfo['classid'],
            'order'=>'ic.icid desc'
        );
        $ialogsCount = $IaLogsModel->getListCount($param);//互动课堂数
        $ialogsCount_c = $IaLogsModel->getCompleteCount($param);//学生完成互动数

        //学习时长
        $par['crid'] = $roominfo['crid'];
        $par['uid'] = $this->uri->itemid;
        $time_t = $this->model('playlog')->getPlayTime($par);
        $time = $this->sec2time($time_t);

        $folderids = '';
        if($roominfo['isschool']!=7) {
            $foldermodel = $this->model('Folder');
            $myclass = $this->model('classes')->getClassByUid($roominfo['crid'], $uid);
            $queryarr['crid'] = $roominfo['crid'];
            if (!empty($myclass['classid'])) {
                $queryarr['classid'] = $myclass['classid'];
            }
            if (!empty($queryarr['classid'])) {
                if (!empty($myclass['grade']))
                    $queryarr['grade'] = $myclass['grade'];
                $queryarr['pagesize'] = 100;
                $queryarr['order'] = '  displayorder asc,folderid desc';
                $folders = $foldermodel->getClassFolder($queryarr);
            }
            $classcoursesmodel = $this->model('Classcourses');
            $myclassid = empty($myclass['classid']) ? 0 : $myclass['classid'];
            $classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
            if(!empty($classfolders)){
                $filterfids = array();
                foreach ($classfolders as $fd){
                    $filterfids[] = $fd['folderid'];
                }
            }
            foreach($folders as $key=>$folder){
                //过滤网校班级课程
                if(!empty($filterfids)){
                    if(in_array($folder['folderid'],$filterfids)){
                        if(empty($folderids)){
                            $folderids = $folder['folderid'];
                        }else{
                            $folderids.= ','.$folder['folderid'];
                        }
                    }else{
                        unset($folders[$key]);
                    }
                    continue;
                }
                if(empty($folderids)){
                    $folderids = $folder['folderid'];
                }else{
                    $folderids.= ','.$folder['folderid'];
                }
            }
        }
        $user['uid'] = $uid;
        $spmodel = $this->model('PayPackage');
        $thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
        $splist = array();
        $spidlist = '';
        //将结果数组以pid为下标排列,并记录pid合集字符串
        foreach($thelist as $mysp) {
            $splist[$mysp['pid']] = $mysp;
            $splist[$mysp['pid']]['itemlist'] = array();
            if(empty($spidlist)) {
                $spidlist = $mysp['pid'];
            } else {
                $spidlist .= ','.$mysp['pid'];
            }
        }
        ///////开通的课程
        $spfolders = $splist;
        if(!empty($spidlist)) {
            $pitemmodel = $this->model('PayItem');
            $itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>0);
            $itemlist = $pitemmodel->getItemFolderList($itemparam);
            if(!empty($itemlist)) {
                foreach($itemlist as $myitem) {
                    if(isset($spfolders[$myitem['pid']])) {
                        $spfolders[$myitem['pid']]['itemlist'][] = $myitem;
                    }
                }
            }
        }
        $mylist = array();
        if(!empty($user)) {
            $userpermodel = $this->model('Userpermission');
            $myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
            $myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
            foreach($myfolderlist as $myfolder) {
                $mylist[$myfolder['folderid']] = $myfolder;
            }
        }
        //var_dump($spfolders);
        foreach($spfolders as $k=>$package){
            $showpack = false;
            foreach($package['itemlist'] as $l=>$folder){
                if($folder['fprice']==0 || isset($mylist[$folder['folderid']]) || $folder['iprice'] ==0){
                    $showpack = true;
                    if(empty($folderids))
                        $folderids = $folder['folderid'];
                    else
                        $folderids .= ','.$folder['folderid'];
                }
                else
                    unset($spfolders[$k]['itemlist'][$l]);
            }
            if($showpack == false)
                unset($spfolders[$k]);
        }
        $ids['folderid'] = $folderids;
        $coursewarelenth_t = $this->model('progress')->getCWlenthFolderid($ids);
        $coursewarelenth = $this->sec2time($coursewarelenth_t);
        $study = $coursewarelenth_t == 0 ? 0 : ceil($time_t/$coursewarelenth_t*100);
        $this->assign('study',$study);
        $this->assign('coursewarelenth',$coursewarelenth);

//        $folderlist = $this->model('folder')->getmemberfolderlist($par);
//        $par['folderid'] = 3811;
//        $f = $this->model('courseware')->getfolderseccourselist($par);
        if($uid > 0){
            $usermodel = $this->model('User');
            $member = $usermodel->getuserbyuid($uid);
            if(!empty($member)) {
                $membername = empty($member['realname']) ? $member['username'] : $member['realname'];
            }

        }

        $this->assign('name',$membername);
        $this->assign('time',$time);
        $this->assign('ialogsCount',$ialogsCount);
        $this->assign('ialogsCount_c',$ialogsCount_c);
        $this->assign('baseinfo',$baseinfo);
        $this->display('troomv2/growlist_view');
    }

    /*
     * 统计分析
     * 课件统计
     */
    public function statistical_view(){
        $roominfo = Ebh::app()->room->getcurroom();
        $user_t = Ebh::app()->user->getloginuser();
        $this->assign('user',$user_t);
        $this->assign('roominfo',$roominfo);
        $this->assign('room',$roominfo);
        $uid = $this->uri->itemid;
        $this->assign('uid',$uid);
        $post = $this->input->post();
        $askmodel = $this->model('askquestion');
        if(!empty($post)){
            if(isset($post['month'])){
                $hwcountstr = array();
                $istr=array();
//                $days = cal_days_in_month(CAL_GREGORIAN, $post['month'], $post['year']);
                $days = date("t",strtotime($post['year'].'-'.$post['month']));
                for($i=1;$i<$days+1;$i++){
                    $hwcount = $this->model('playlog')->getPlayTime(array('uid'=>$uid,'crid'=>$roominfo['crid'],'day'=>$i,'m'=>$post['month'],'Y'=>$post['year']));
                    $hwcount = intval($hwcount);
                    $hwcountstr[] = ceil($hwcount/60);
                    $istr[]=$i;
                }
                $info['homework']=$hwcountstr;
                $info['x'] = $istr;
//            $mcountstr = array(1,2,3,45,5);
                echo json_encode($info);
            }else{
                $hwcountstr = array();
                for($i=1;$i<13;$i++){
                    $hwcount = $this->model('playlog')->getPlayTime(array('uid'=>$uid,'crid'=>$roominfo['crid'],'m'=>$i,'Y'=>$post['year']));
                    $hwcount = intval($hwcount);
//                    $hwcountstr[] = sprintf('%.1f',$hwcount/3600);
                    $hwcountstr[] = floatval(number_format($hwcount/3600,1));
                }
                $info['homework']=$hwcountstr;
//            $mcountstr = array(1,2,3,45,5);
                echo json_encode($info);
            }

        }else{
            //课件总时长
            $folderids = '';
            if($roominfo['isschool']!=7) {
                $foldermodel = $this->model('Folder');
                $myclass = $this->model('classes')->getClassByUid($roominfo['crid'], $uid);
                $queryarr['crid'] = $roominfo['crid'];
                if (!empty($myclass['classid'])) {
                    $queryarr['classid'] = $myclass['classid'];
                }
                if (!empty($queryarr['classid'])) {
                    if (!empty($myclass['grade']))
                        $queryarr['grade'] = $myclass['grade'];
                    $queryarr['pagesize'] = 100;
                    $queryarr['order'] = '  displayorder asc,folderid desc';
                    $folders = $foldermodel->getClassFolder($queryarr);
                }
                $classcoursesmodel = $this->model('Classcourses');
                $myclassid = empty($myclass['classid']) ? 0 : $myclass['classid'];
                $classfolders = $classcoursesmodel->getfolderidsbyclassid($myclassid);
                if(!empty($classfolders)){
                    $filterfids = array();
                    foreach ($classfolders as $fd){
                        $filterfids[] = $fd['folderid'];
                    }
                }
                foreach($folders as $key=>$folder){
                    //过滤网校班级课程
                    if(!empty($filterfids)){
                        if(in_array($folder['folderid'],$filterfids)){
                            if(empty($folderids)){
                                $folderids = $folder['folderid'];
                            }else{
                                $folderids.= ','.$folder['folderid'];
                            }
                        }else{
                            unset($folders[$key]);
                        }
                        continue;
                    }
                    if(empty($folderids)){
                        $folderids = $folder['folderid'];
                    }else{
                        $folderids.= ','.$folder['folderid'];
                    }
                }
            }
            $user['uid'] = $uid;
            $spmodel = $this->model('PayPackage');
            $thelist = $spmodel->getsplist(array('crid'=>$roominfo['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
            $splist = array();
            $spidlist = '';
            //将结果数组以pid为下标排列,并记录pid合集字符串
            foreach($thelist as $mysp) {
                $splist[$mysp['pid']] = $mysp;
                $splist[$mysp['pid']]['itemlist'] = array();
                if(empty($spidlist)) {
                    $spidlist = $mysp['pid'];
                } else {
                    $spidlist .= ','.$mysp['pid'];
                }
            }
            ///////开通的课程
            $spfolders = $splist;
            if(!empty($spidlist)) {
                $pitemmodel = $this->model('PayItem');
                $itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>0);
                $itemlist = $pitemmodel->getItemFolderList($itemparam);
                if(!empty($itemlist)) {
                    foreach($itemlist as $myitem) {
                        if(isset($spfolders[$myitem['pid']])) {
                            $spfolders[$myitem['pid']]['itemlist'][] = $myitem;
                        }
                    }
                }
            }
            $mylist = array();
            if(!empty($user)) {
                $userpermodel = $this->model('Userpermission');
                $myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
                $myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
                foreach($myfolderlist as $myfolder) {
                    $mylist[$myfolder['folderid']] = $myfolder;
                }
            }
            //var_dump($spfolders);
            foreach($spfolders as $k=>$package){
                $showpack = false;
                foreach($package['itemlist'] as $l=>$folder){
                    if($folder['fprice']==0 || isset($mylist[$folder['folderid']]) || $folder['iprice'] ==0){
                        $showpack = true;
                        if(empty($folderids))
                            $folderids = $folder['folderid'];
                        else
                            $folderids .= ','.$folder['folderid'];
                    }
                    else
                        unset($spfolders[$k]['itemlist'][$l]);
                }
                if($showpack == false)
                    unset($spfolders[$k]);
            }
            $ids['folderid'] = $folderids;
            $coursewarelenth_t = $this->model('progress')->getCWlenthFolderid($ids);
            $coursewarelenth = $this->sec2time($coursewarelenth_t);

            //学习时长
            $par['crid'] = $roominfo['crid'];
            $par['uid'] = $this->uri->itemid;
            $time_t = $this->model('playlog')->getPlayTime($par);
            $time = $this->sec2time($time_t);
            $study = ceil($time_t/$coursewarelenth_t*100);

            if($uid > 0){
                $usermodel = $this->model('User');
                $member = $usermodel->getuserbyuid($uid);
                if(!empty($member)) {
                    $membername = empty($member['realname']) ? $member['username'] : $member['realname'];
                }

            }
            $data_m = array();
            for($i=1;$i<date('m')+1;$i++){
                $data_m[]=$i;
            }
            $data_y = array();
            $begin_y = date('Y',$roominfo['dateline']);
            $now_y = date('Y');
            for($i=$begin_y;$i<$now_y+1;$i++){
                $data_y[] = $i;
            }

            $this->assign('data_y',$data_y);
            $this->assign('data_m',$data_m);
            $this->assign('study',$study);
            $this->assign('name',$membername);
            $this->assign('time',$time);
            $this->assign('coursewarelenth',$coursewarelenth);
            $this->display('troomv2/tastulog_sta');
        }
    }

    /*
     *作业统计
     */
    public function homework_view(){
        $post = $this->input->post();
        $uid = $this->uri->itemid;
        $roominfo = Ebh::app()->room->getcurroom();
        $user_t = Ebh::app()->user->getloginuser();
        $this->assign('user',$user_t);
        $this->assign('roominfo',$roominfo);
        $this->assign('room',$roominfo);
        $exammodel = $this->model('Exam');

        $myclass = $this->model('classes')->getClassByUid($roominfo['crid'],$uid);
        $zqarr = parsequery();
        $zqarr['uid'] = $uid;
        $zqarr['crid'] = $roominfo['crid'];
        $zqarr['classid'] = $myclass['classid'];
        $zqarr['hasanswer'] = 1;
        if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
            $zqarr['grade'] = $myclass['grade'];
            $zqarr['district'] = $myclass['district'];
        }
        if(isset($post['page'])){
            //完成作业列表
            $zqarr['hasanswer'] = 1;
            $zqarr['pagesize'] = 15;
            $zqarr['page'] = $post['page'];
            $myexamlist = $exammodel->getExamListByMemberid($zqarr);
            $x=array();//x轴信息
            $score = array();
            if(!empty($myexamlist)){
                $i = 0;
                foreach($myexamlist as $v){
                    $x[] = $v['title'];
                    $score[] = ceil($v['totalscore']/$v['score']*100);
                    $i++;
                }
                $exam['num'] = $i;
                $exam['x'] = $x;
                $exam['score'] = $score;
            }else{
                $exam['x'] = array(0);
                $exam['score'] = array(0);
                $exam['num'] = 0;
            }
            echo json_encode($exam);
        }else{

            //作业
			$exampower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
			if ($exampower) {//判断有没有开通新的作业
				$user['uid'] = $uid;
				$param = $this->_getNewExamNum($roominfo,$user);
				$myexamcount = $param['myexamcount'];
				$this->assign('examPower',1);
			} else {
				$myexamcount = $exammodel->getExamListCountByMemberid($zqarr);
			}
	        $info['myexamcount'] = $myexamcount;
            $count = ceil($myexamcount/15);
            if($count==0){
                $count=1;
            }
            $redis = Ebh::app()->getCache('cache_redis');
            $redis_key = 'class_allexamcount_' . $myclass['classid'];
            $myallexamcount = $redis->get($redis_key);
            //没有缓存则从数据库读取
            if($myallexamcount === false)
            {
                $qarr['uid'] = $uid;
                $qarr['crid'] = $roominfo['crid'];
                $qarr['classid'] = $myclass['classid'];
                if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
                    $qarr['grade'] = $myclass['grade'];
                    $qarr['district'] = $myclass['district'];
                }
                //作业数
				if ($exampower) {//判断有没有开通新的作业
					$myallexamcount = $this->_getAllNewExamNum($param,$user,$roominfo);
				} else {
					$myallexamcount = $exammodel->getExamListCountByMemberid($qarr);
				}
                $redis->set($redis_key, $myallexamcount, 360);//360秒过期
            }else{
                $myallexamcount = intval($myallexamcount);
            }
            $info['myallexamcount'] = $myallexamcount;

            if($uid > 0){
                $usermodel = $this->model('User');
                $member = $usermodel->getuserbyuid($uid);
                if(!empty($member)) {
                    $membername = empty($member['realname']) ? $member['username'] : $member['realname'];
                }

            }

            $this->assign('name',$membername);
            $this->assign('count',$count);
            $this->assign('page',1);
            $this->assign('info',$info);
            $this->assign('uid',$uid);
            $this->display('troomv2/tatulog_hwork');
        }
    }

    /*
     * 互动统计
     */
    public function iaclassroom_view(){
        $post = $this->input->post();
        $roominfo = Ebh::app()->room->getcurroom();
        $user_t = Ebh::app()->user->getloginuser();
        $this->assign('user',$user_t);
        $this->assign('roominfo',$roominfo);
        $this->assign('room',$roominfo);
        $uid = $this->uri->itemid;
        $IaLogsModel = $this->model('iaclassroomlog');
        $classesModel = $this->model('classes');
        $stuClassInfo = $classesModel->getClassByUid($roominfo['crid'],$uid);
        if(empty($stuClassInfo)){
            exit;
        }
        $classTeacherList = $classesModel->getClassTeacherByClassid($stuClassInfo['classid']);
        if(empty($classTeacherList)){
            exit;
        }
        $tidArr = array();
        foreach ($classTeacherList as $classTeacher) {
            array_push($tidArr, $classTeacher['uid']);
        }
        $tid_in = '('.implode(',', $tidArr).')';
        $param = array(
            'crid'=>$roominfo['crid'],
            'uid'=>$uid,
            'tid_in'=>$tid_in,
            'classid'=>$stuClassInfo['classid'],
            'order'=>'ic.icid desc'
        );
//        $ialogslist = $IaLogsModel->getList($param);
        if(!empty($post)){
            $param['Y'] = $post['year'];
            $mcountstr = array();
            $mcountstr_c = array();
            for($i=1;$i<13;$i++){

                $param['m'] = $i;

                $mcount = intval($IaLogsModel->getListCount($param));

                $mcount_c = intval($IaLogsModel->getCompleteCount($param));

                $mcountstr[] = intval($mcount);

                $mcountstr_c[] = intval($mcount_c);

            }
            $info['str']=$mcountstr;
            $info['str_c']=$mcountstr_c;
//            $mcountstr = array(1,2,3,45,5);
            echo json_encode($info);
//            $this->assign('mcountstr',$mcountstr);
//            $this->assign('mcountstr_c',$mcountstr_c);
        }else{
            $ialogsCount = $IaLogsModel->getListCount($param);//互动课堂数
            $ialogsCount_c = $IaLogsModel->getCompleteCount($param);//学生完成互动数

            if($uid > 0){
                $usermodel = $this->model('User');
                $member = $usermodel->getuserbyuid($uid);
                if(!empty($member)) {
                    $membername = empty($member['realname']) ? $member['username'] : $member['realname'];
                }

            }

            $this->assign('name',$membername);
            $this->assign('ialogsCount',$ialogsCount);
            $this->assign('ialogsCount_c',$ialogsCount_c);
            $this->assign('uid',$uid);
            $this->display('troomv2/tatulog_iaclassroom');
        }
    }

    /*
     * 答疑统计
     */
    public function ask_view(){
        $post = $this->input->post();
        $roominfo = Ebh::app()->room->getcurroom();
        $user_t = Ebh::app()->user->getloginuser();
        $this->assign('user',$user_t);
        $this->assign('roominfo',$roominfo);
        $this->assign('room',$roominfo);
        $uid = $this->uri->itemid;
        $askmodel = $this->model('askquestion');

        if(!empty($post)){
            if(isset($post['month'])){
                $ancountstr = array();
                $askcountstr = array();
                $istr=array();
//                $days = cal_days_in_month(CAL_GREGORIAN, $post['month'], $post['year']);
                $days = date("t",strtotime($post['year'].'-'.$post['month']));
                for($i=1;$i<$days+1;$i++){

                    $ancount = $askmodel->getaskcountbyanswers(array('uid'=>$uid,'crid'=>$roominfo['crid'],'qshield'=>0,'ashield'=>0,'m'=>$post['month'],'Y'=>$post['year'],'day'=>$i));

                    $askcount = $askmodel->getmyaskcount(array('uid'=>$uid,'shield'=>0,'crid'=>$roominfo['crid'],'m'=>$post['month'],'Y'=>$post['year'],'day'=>$i));

                    $ancountstr[] = intval($ancount);

                    $askcountstr[] = intval($askcount);

                    $istr[]=$i;
                }
                $info['an']=$ancountstr;
                $info['ask']=$askcountstr;
                $info['x'] = $istr;
//            $mcountstr = array(1,2,3,45,5);
                echo json_encode($info);
            }else{
                $ancountstr = array();
                $askcountstr = array();
                for($i=1;$i<13;$i++){

                    $ancount = $askmodel->getaskcountbyanswers(array('uid'=>$uid,'crid'=>$roominfo['crid'],'qshield'=>0,'ashield'=>0,'m'=>$i,'Y'=>$post['year']));

                    $askcount = $askmodel->getmyaskcount(array('uid'=>$uid,'shield'=>0,'crid'=>$roominfo['crid'],'m'=>$i,'Y'=>$post['year']));

                    $ancountstr[] = intval($ancount);

                    $askcountstr[] = intval($askcount);

                }
                $info['an']=$ancountstr;
                $info['ask']=$askcountstr;
//            $mcountstr = array(1,2,3,45,5);
                echo json_encode($info);
            }

//            $this->assign('mcountstr',$mcountstr);
//            $this->assign('mcountstr_c',$mcountstr_c);
        }else{
            $myanscount = $askmodel->getaskcountbyanswers(array('uid'=>$uid,'crid'=>$roominfo['crid'],'qshield'=>0,'ashield'=>0));
            $myaskcount = $askmodel->getmyaskcount(array('uid'=>$uid,'shield'=>0,'crid'=>$roominfo['crid']));

            if($uid > 0){
                $usermodel = $this->model('User');
                $member = $usermodel->getuserbyuid($uid);
                if(!empty($member)) {
                    $membername = empty($member['realname']) ? $member['username'] : $member['realname'];
                }

            }
            //时间年月列表
            $data_m = array();
            for($i=1;$i<date('m')+1;$i++){
                $data_m[]=$i;
            }
            $data_y = array();
            $begin_y = date('Y',$roominfo['dateline']);
            $now_y = date('Y');
            for($i=$begin_y;$i<$now_y+1;$i++){
                $data_y[] = $i;
            }

            $this->assign('data_y',$data_y);
            $this->assign('data_m',$data_m);
            $this->assign('name',$membername);
            $this->assign('myanscount',$myanscount);
            $this->assign('myaskcount',$myaskcount);
            $this->assign('uid',$uid);
            $this->display('troomv2/tatulog_ask');
        }
    }

    /**
     * 获取成长记录基础数据
     */
    private function getbaseinfo(){
        $roominfo = Ebh::app()->room->getcurroom();
        //积分
        $user['uid'] = $this->uri->itemid;
        $userinfo = $this->model('user')->getuserbyuid($user['uid']);
        $info['credit'] = $userinfo['credit'];
        //签到
        $creditmodel = $this->model('credit');
        $signlogcount = $creditmodel->getSignLogCount(array('uid'=>$user['uid']));
        $info['signlogcount'] = $signlogcount;

        $askmodel = $this->model('Askquestion');
        $studymodel = $this->model('Studylog');
        $exammodel = $this->model('Exam');
        $classesmodel = $this->model('Classes');

        //作业
        $myclass = $this->model('classes')->getClassByUid($roominfo['crid'],$user['uid']);
        $zqarr['uid'] = $user['uid'];
        $zqarr['crid'] = $roominfo['crid'];
        $zqarr['classid'] = $myclass['classid'];
        $zqarr['hasanswer'] = 1;
        if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
            $zqarr['grade'] = $myclass['grade'];
            $zqarr['district'] = $myclass['district'];
        }
        //作业数
		$exampower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
		if ($exampower) {//判断有没有开通新的作业
			$param = $this->_getNewExamNum($roominfo,$user);
			$myexamcount = $param['myexamcount'];
		} else {
			$myexamcount = $exammodel->getExamListCountByMemberid($zqarr);
		}
        $info['myexamcount'] = $myexamcount;
        //学习
        $mystudycount = $studymodel->getStudyCount(array('uid'=>$user['uid'],'totalflag'=>0,'crid'=>$roominfo['crid']));
        $info['mystudycount'] = $mystudycount;
        //提问
        $myaskcount = $askmodel->getmyaskcount(array('uid'=>$user['uid'],'shield'=>0,'crid'=>$roominfo['crid']));
        $info['myaskcount'] = $myaskcount;

        //所有作业
        //先从缓存读取所有作业计数
        $redis = Ebh::app()->getCache('cache_redis');
        $redis_key = 'class_allexamcount_' . $myclass['classid'];
        $myallexamcount = $redis->get($redis_key);
        //没有缓存则从数据库读取
        if($myallexamcount === false)
        {
            $qarr['uid'] = $user['uid'];
            $qarr['crid'] = $roominfo['crid'];
            $qarr['classid'] = $myclass['classid'];
            if(!empty($myclass['grade'])) {	//班级有年级信息，则显示此年级下的所有作业
                $qarr['grade'] = $myclass['grade'];
                $qarr['district'] = $myclass['district'];
            }
            //作业数
			if ($exampower) {//判断有没有开通新的作业
				$myallexamcount = $this->_getAllNewExamNum($param,$user,$roominfo);
			} else {
				$myallexamcount = $exammodel->getExamListCountByMemberid($qarr);
			}
            $redis->set($redis_key, $myallexamcount, 360);//360秒过期
        }
        else
        {
            $myallexamcount = intval($myallexamcount);
        }
        $info['myallexamcount'] = $myallexamcount;

        //答疑
        $myanscount = $askmodel->getaskcountbyanswers(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'qshield'=>0,'ashield'=>0));
        $info['myanscount'] = $myanscount;
        //评论
        $reviewmodel = $this->model('review');
        $myreviewcount = $reviewmodel->getreviewcount(array('uid'=>$user['uid'],'rcrid'=>1,'status'=>1,'crid'=>$roominfo['crid']));
        $info['myreviewcount'] = $myreviewcount;
        //感谢(我的提问与我的回答)
        $myaskthankcount = $askmodel->getaskcountbythank(array('uid'=>$user['uid'],'crid'=>$roominfo['crid']));
        $myansthankcount = $askmodel->getanscountbythank(array('uid'=>$user['uid'],'crid'=>$roominfo['crid']));
        $info['mythankcount'] = $myaskthankcount + $myansthankcount;
        //日志
        $snsmodel = $this->model('Snsbase');
        $myarticlescount = $snsmodel->getarticlescount(array('uid'=>$user['uid'],'status'=>0));
        $info['myarticlescount'] = $myarticlescount;
        //新鲜事
        $myfeedscount = $snsmodel->getfeedscount(array('uid'=>$user['uid'],'status'=>0));
        $info['myfeedscount'] = $myfeedscount;
        //粉丝
        $mybaseinfo = $snsmodel->getbaseinfo($user['uid']);
        $info['myfanscount'] = $mybaseinfo['fansnum'];
        //关注
        $info['myfavoritcount'] = $mybaseinfo['followsnum'];
        return $info;
    }

   /*
	获取有权限的课程：(免费，全校免费，开通未过期忽略),免费的课程也需要开通，所以注释掉了
	*/
	private function getfolderids($uid,$roominfo){
		$userpermodel = $this->model('Userpermission');
		$myperparam = array('uid'=>$uid,'crid'=>$roominfo['crid'],'filterdate'=>1);
		$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
		$folderids = array();
		if($roominfo['isschool'] == 7){
			//全校免费课程
			$foldermodel = $this->model('Folder');
			$rumodel = $this->model('roomuser');
			$userin = $rumodel->getroomuserdetail($roominfo['crid'],$uid);
			if(!empty($userin)){
				$schoolfreelist = $foldermodel->getfolderlist(array('crid'=>$roominfo['crid'],'isschoolfree'=>1,'limit'=>1000));
				foreach($schoolfreelist as $f){
					$folderids[]= $f['folderid'];
				}
			}
			
		}

		foreach($myfolderlist as $f){
			$folderids[]= $f['folderid'];
		}
		return $folderids;
	}

	/**
	 * 获取新版本作业
	 * @param array $roominfo
	 * @param array $user
	 * @return array $param 
	 */
	private function _getNewExamNum($roominfo=array(),$user=array()) {
		$dataserver = EBH::app()->getConfig('dataserver')->load('dataserver');
        $servers = $dataserver['servers'];
        //随机抽取一台服务器
        $target_server = $servers[array_rand($servers,1)];
		$url = 'http://'.$target_server.'/exam/selist';
		$param['tids'] = array();
		$param['ttype'] = 'FOLDER';
		$param['crid'] = $roominfo['crid'];
		$param['action'] = 'hasdo';
		$param['status'] = 1;
		$param['size'] = 1;
		$param['k'] = authcode(json_encode(array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'t'=>SYSTIME)),'ENCODE');
		$postParam = json_encode($param);
		$postRet = do_post($url,$postParam,FALSE,TRUE);
		$param['myexamcount'] = $postRet->datas->pageInfo->totalElement;
		$param['url'] = $url;
		return $param;
	}

	/*
	 *获取新版所有作业的数量基于_getNewExamNum()的返回值
	 */
	private function _getAllNewExamNum($param = array(),$user,$roominfo) {
		$param['tids'] = $this->getfolderids($user['uid'],$roominfo);
		if (empty($param['tids'])) {
			$myallexamcount = 0;
		} else {
			$param['action'] = 'fordo';
			$postParam = json_encode($param);
			$postRet = do_post($param['url'],$postParam,FALSE,TRUE);
			$myallexamcount = $postRet->datas->pageInfo->totalElement + $param['myexamcount'];
		}
		return $myallexamcount;
	}

    /**
     * 秒转小时,分
     */
    function sec2time($sec){
        $sec = ceil($sec/60);
        if ($sec >= 60){
            $hour = floor($sec/60);
            $min = $sec%60;
            $res = $hour.' 小时 ';
            $min != 0  &&  $res .= $min.' 分';
        }else{
            $res = $sec.' 分钟';
        }
        return $res;
    }
}
