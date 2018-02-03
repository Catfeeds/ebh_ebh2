<?php
/**
 * 班级试卷控制器类ClasspaperController
 */
class ClasspaperController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        
    }
    public function index() {
    	$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo',$roominfo);
		$this->display('troom/classpaper');    }
	/*
	*批改作业
	*/
	public function cor(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classmodel = $this->model('Classes');
        $param = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'type'=>1);
        $cexams = $classmodel->getTeacherclassexam($param);

        $this->assign('cexams', $cexams);
        $this->display('troom/classpaper_cor');
		$this->_updateuserstate();
	}
	/**
	*班级作业对应的具体班级
	*/
	public function my() {
		$classid = $this->uri->uri_attr(0);
		if(is_numeric($classid) && $classid > 0) {
			$roominfo = Ebh::app()->room->getcurroom();
			$classmodel = $this->model('Classes');
			$myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
			if(empty($myclass))
				exit;
			$exammodel = $this->model('Exam');
			$param = parsequery();
			$param['crid'] = $roominfo['crid'];
			$param['classid'] = $classid;
			if(!empty($myclass['grade'])) {	//加上年级作业信息
				$param['grade'] = $myclass['grade'];
				$param['district'] = $myclass['district'];
			}
			$param['type'] = array(1,3);
			$user = Ebh::app()->user->getloginuser();
			$param['uid'] = $user['uid'];
			$exams = $exammodel->getschexamlist($param);
			$count = $exammodel->getschexamlistcount($param);
			$pagestr = show_page($count);
			$this->assign('exams',$exams);
			$this->assign('pagestr',$pagestr);
			$this->assign('roominfo',$roominfo);
			$this->assign('uid',$user['uid']);
			$this->assign('myclass',$myclass);
			$this->display('troom/classpaper_my');
		}
	}
	/**
	*班级作业对应的作业批阅
	*/
	public function all() {
		$classid = $this->uri->uri_attr(0);
		$eid = $this->uri->uri_attr(1);
		if(!is_numeric($classid) || $classid <= 0 || !is_numeric($eid) || $eid <= 0 ) {
			exit();
		}
		$sort = $this->uri->sortmode;
		$roominfo = Ebh::app()->room->getcurroom();
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
		if(empty($myclass))
			exit();
		$exammodel = $this->model('Exam');
		$myexam = $exammodel->getschexambyeid($eid);
		if(empty($myexam))
			exit();
		$param = array();
		$param['eid'] = $eid;
		$param['classid'] = $classid;
		if(!empty($myclass['grade'])) {
			$param['grade'] = $myclass['grade'];
			$param['district'] = $myclass['district'];
		}
		$param['limit'] = 100;
		if($sort == 1) {	//按答题用时倒叙排序
			$param['order'] = 'ea.completetime desc';
		} else if ($sort == 2) {
			$param['order'] = 'ea.completetime';
		} else if ($sort == 3) {
			$param['order'] = 'ea.totalscore desc';
		} else if ($sort == 4) {
			$param['order'] = 'ea.totalscore';
		}
		$param['type'] = array(1,3);
		if(!empty($myclass['grade'])) {
			$param['crid'] = $roominfo['crid'];
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
		//获取已答数
		$answercount = 0;
		foreach($answers as $myanswer) {
			if(!empty($myanswer['aid']) && !empty($myanswer['status'])) {
				$answercount ++;
			}
		}
		$myexam['answercount'] = $answercount;
		//批阅人数
		$correctcount = $exammodel->getRoomExamCount($classid,$eid,1);
		$myexam['correctcount'] = $correctcount;
		
		$this->assign('sort',$sort);
		$this->assign('myexam',$myexam);
		$this->assign('answers',$answers);
		$this->assign('roominfo',$roominfo);
		$this->assign('myclass',$myclass);
		$this->display('troom/classpaper_all');
	}
	
	/**
	 * 教师批量批阅作业
	 * 
	 */
	public function correct(){
		$dopost = $this->input->post('dopost');
		$classmodel = $this->model('Classes');
		$exammodel = $this->model('Exam');
		if($dopost=='correct'){//批量批改
			$post = $this->input->post();
			$startscore = $post['startscore'];
			$endscore = $post['endscore'];
			$aidarr = $post['aidarr'];
			$eid = $post['eid'];
			//var_dump(is_numeric( $startscore <= 0));
			//form验证
			if(!is_numeric($startscore) || $startscore < 0 || !is_numeric($endscore) || $endscore < 0
				|| !is_numeric($eid) || $eid <= 0 ||!preg_match('/\d+(,\d+)*$/',$aidarr)) {
				exit(0);
			}
			
			$user = Ebh::app()->user->getloginuser();
			$param = array(
				'tid' => $user['uid'],
				'aidarr'=>$aidarr,
				'startscore'=>$startscore,
				'endscore'=>$endscore,
				'eid'=>	$eid,
				'remark'=>	$post['remark'],
				'type'=>1	
			);
			
			$nums = $exammodel->correctRoomExam($param);
			$code = ($nums>0)?true:false;
			echo json_encode(array('code'=>$code,'nums'=>$nums));
			exit(0);
		}
	}
	/**
	*更新待批作业用户状态时间
	*/
	private function _updateuserstate() {
		 //更新评论用户状态时间
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $statemodel = $this->model('Userstate');
        $typeid = 1;
        $statemodel->insert($roominfo['crid'],$user['uid'],$typeid,SYSTIME);
	}
	/**
	*删除作业
	*/
	public function del() {
		$eid = $this->input->post('eid');
		if(is_numeric($eid) && $eid > 0) {
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getloginuser();
			$param = array('eid'=>$eid,'crid'=>$roominfo['crid'],'uid'=>$user['uid']);
			$exammodel = $this->model('Exam');
			$examanswermodel = $this->model('Examanswer');
			$examanserlist = $examanswermodel->getexamanswerlist($eid);//获取所有回答记录
			$afrows = $exammodel->delschexambyeid($param);
			if($afrows > 0)
			{
				echo 1;
				fastcgi_finish_request();
				foreach ($examanserlist as $examanswer)
				{
					//同步SNS数据(学生作业数减1)
					Ebh::app()->lib('Sns')->do_sync($examanswer['uid'], -3);
				}
				//同步SNS数据(教师作业数减1)
				Ebh::app()->lib('Sns')->do_sync($user['uid'], -3);
			}	
			else
				echo 0;
		} else {
			echo 0;
		}
	}
	//老师删除某个学生的已做作业
	public function deleteanswer(){
		$aid = $this->input->post('aid');
		$eid = $this->input->post('eid');
		$uid = $this->input->post('uid');
		$param1 = array(
			'aid'=>intval($aid),
			'uid'=>intval($uid)
			);
		if(false!=($this->model('examanswer')->deleteOne($param1))){
			$this->model('exam')->decAnswerCount($eid);
			$errormodel = $this->model('Errorbook');
			$param2 = array(
					'exid'=>intval($eid),
					'uid' =>intval($uid)
					);
			$errormodel->deletebyExidAndUid($param2);

			echo 1;
			fastcgi_finish_request();
			//同步SNS数据(当删除作业时，学生作业数减1)
			Ebh::app()->lib('Sns')->do_sync($uid, -3);
		}else{
			echo 0;	
		}
	}

	/*
	*作业批阅导出excel
	*/
	public function examexcel(){
		$titleArr = array("账号","姓名","答题时间","用时","得分","评语","答题");

		$roominfo = Ebh::app()->room->getcurroom();
		$classid = $this->uri->uri_attr(0);
		$eid = $this->uri->uri_attr(1);
		if(!is_numeric($classid) || $classid <= 0 || !is_numeric($eid) || $eid <= 0 ) {
			exit();
		}
		$sort = $this->uri->sortmode;
		$classmodel = $this->model('Classes');
		$myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
		if(empty($myclass))
			exit();
		$exammodel = $this->model('Exam');
		$myexam = $exammodel->getschexambyeid($eid);
		$filename = $myexam['title'];
		$param = array();
		$param['eid'] = $eid;
		$param['classid'] = $classid;
		if(!empty($myclass['grade'])) {
			$param['grade'] = $myclass['grade'];
			$param['district'] = $myclass['district'];
		}
		$param['limit'] = 100;
		if($sort == 1) {	//按答题用时倒叙排序
			$param['order'] = 'ea.completetime desc';
		} else if ($sort == 2) {
			$param['order'] = 'ea.completetime';
		} else if ($sort == 3) {
			$param['order'] = 'ea.totalscore desc';
		} else if ($sort == 4) {
			$param['order'] = 'ea.totalscore';
		}
		$param['type'] = array(1,3);
		if(!empty($myclass['grade'])) {
			$param['crid'] = $roominfo['crid'];
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

		$dataArr = array();//存储数据
		foreach($answers as $tl){
			$rl = (empty($tl['realname'])?$tl['username']:$tl['realname']).'('.($tl['sex']==1?'女':'男').')';
			$ts = (empty($tl['dateline'])|| $tl['status']==0)?'':(date('Y-m-d H:i',$tl['dateline']));
			$qs = (!empty($tl['aid']) && $tl['status']!=0)?ceil($tl['completetime']/60).' 分钟':'';
			$tt = round($tl['totalscore'],2);
			$rm = $tl['remark'];
			$st = (!empty($tl['aid']) && $tl['status']!=0)?'已提交':'未提交';
			array_push($dataArr,array($tl['username'],$rl,$ts,$qs,$tt,$rm,$st));
		}
	//var_dump($dataArr);
		$this->_exportExcel($titleArr,$dataArr,"FFFFFFFF",$filename);
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
				//$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
				$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth(20);//设置列宽
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
					//$pt->getColumnDimension($str)->setAutoSize(true);//单元格每项内容自适应
					$pt->getColumnDimension($str)->setWidth(20);//单元格每项内容宽度
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
	*班级作业对应的具体班级
	*/
	public function todayexams() {
		$classid = intval($this->uri->uri_attr(0));
        $classmodel = $this->model('Classes');
		$roominfo = Ebh::app()->room->getcurroom();
        $param = parsequery();
        $param['crid'] = $roominfo['crid'];
        $d = $this->input->get('d');
        if(empty($d)){
        	$d = date('Y-m-d',time());
        }
        $starttime = strtotime($d);
        $endtime = $starttime+3600*24;
        $param['starttime'] = $starttime;
        $param['endtime'] = $endtime;
        $param['type'] = array(1,3);
		if($classid>0){
            $param['classid'] = $classid;
            $myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
            if(!empty($myclass['grade'])) { //加上年级作业信息
                $grade = $param['grade'] = $myclass['grade'];
                $district = $param['district'] = $myclass['district'];
            }
            if(empty($myclass))
            exit;
        }else{
            $myclass['classname'] = "所有班级";
            $param['classid'] = 0;
        }
        $user = Ebh::app()->user->getloginuser();
        $classList = $classmodel->getTeacherClassList($roominfo['crid'],$user['uid']);

        $classDb = array();
        $gradeDb = array();
        $gradeClassDb = array();
        $gradeClassMapDb = array();
        if(!empty($classList)){
            foreach ($classList as $class) {
                $classDb['c_'.$class['classid']] = $class;
                if($class['grade'] > 0){
                    $key = 'g_'.$class['grade'].'_'.$class['district'];
                    if(!array_key_exists($key, $gradeDb)){
                        $gradeDb[$key] = array('stunum'=>$class['stunum'],'grade'=>$class['grade'],'district'=>$class['district']);
                    }else{
                        $gradeDb[$key]['stunum']+=$class['stunum'];
                    }
                    if(empty($gradeClassDb[$class['grade'].'_'.$class['district']])){
                        $gradeClassDb[$class['grade'].'_'.$class['district']] = array();
                        $gradeClassMapDb[$class['grade'].'_'.$class['district']] = array();
                    }
                    $gradeClassDb[$class['grade'].'_'.$class['district']][] = '<a href="/troom/classexam/todayexams-0-0-0-'.$class['classid'].'.html?d='.$d.'">'.$class['classname'].'</a>';
                	$gradeClassMapDb[$class['grade'].'_'.$class['district']][] = $class['classid'];
                }
            }
        }
        $this->assign('classDb',$classDb);
        $this->assign('gradeDb',$gradeDb);
        $this->assign('gradeClassDb',$gradeClassDb);
        $this->assign('gradeClassMapDb',$gradeClassMapDb);
        $grademap = Ebh::app()->getConfig()->load('grademap');
        $this->assign('grademap',$grademap);
        $param['uid'] = $user['uid'];
        $param['tid'] = $user['uid'];
       
		$exammodel = $this->model('Exam');

		$exams = $exammodel->getschexamlist($param);
		$count = $exammodel->getschexamlistcount($param);
		$pagestr = show_page($count);

		$coursewareList = array();
		$coursewareDb = array();
        $cwids = array();
		if(!empty($exams)){
			foreach ($exams as $exam) {
				if(!empty($exam['cwid'])){
					$cwids[] = $exam['cwid'];
				}
			}
			$cwids = array_unique($cwids);
		}
		$coursewareList = $this->model('courseware')->getCourseListByCwids($cwids);
		if(!empty($coursewareList)){
			foreach ($coursewareList as $courseware) {
				$key = 'cw_'.$courseware['cwid'];
				$coursewareDb[$key] = $courseware;
			}
		}
		$this->assign('coursewareDb',$coursewareDb);
        $this->assign('curclassid',$classid);
		$this->assign('exams',$exams);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('uid',$user['uid']);
		$this->assign('myclass',$myclass);
		$this->assign('d',$d);
		$this->display('troom/classpaper_today');
	}
}
