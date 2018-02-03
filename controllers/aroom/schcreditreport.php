<?php
class SchcreditreportController extends CControl{
	/*
	学生学习统计
	*/
	public function index(){
		$roomuser = $this->model('roomuser');
		$roominfo = Ebh::app()->room->getcurroom();

		//获取当前学校的类型
		$type = $roominfo['grade'];

		//判断学校的类型是否合法
		if(!in_array($type, array(0,1,7,10))){
			show_404();
			exit;
		}

		$roomdetail = $this->_getRoomDetail();

		//根据学校类型获取学校年级列表
		$_SG = Ebh::app()->getConfig()->load('schoolgrade');
		$gradeList = $_SG[$type];

		$this->assign('gradeList',$gradeList);

		//组织参数
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$classid = $this->uri->uri_attr(0);
		$grade = $this->uri->uri_attr(1);
		if(is_numeric($classid)&&$classid>0){
			$uids = $this->_getClassStu($classid);
			if(!empty($uids)){
				$param['uid_in'] = $uids;
			}else{
				$param['uid_in'] = array(-1);
			}
		}

		if(is_numeric($grade)&&$grade>0){
			$uids = $this->_getGradeStu($grade);
			if(!empty($uids)){
				$param['uid_in'] = $uids;
			}else{
				$param['uid_in'] = array(-1);
			}
		}
		$param['order'] = 'score desc';
		$offset = max(($param['page']-1)*$param['pagesize'],0);
		$param['limit'] = $offset.','.$param['pagesize'];
		$classes = $this->model('classes');
		$classlist = $classes->getroomClassList($roominfo['crid']);

		$schcreditlogmodel = $this->model('schcreditlog');
		$schcreditlog = $schcreditlogmodel->getTotalList($param);
		$schcreditlogCount = $schcreditlogmodel->getTotalListCount($param);
		$pageStr = show_page($schcreditlogCount,$param['pagesize']);
		$this->assign('pageStr',$pageStr);
		$this->assign('schcreditlog',$schcreditlog);
		$this->assign('classid',$classid);
		$this->assign('grade',$grade);
		$this->assign('classlist',$classlist);
		$this->assign('roomdetail',$roomdetail);
		$this->assign('q',$param['q']);
		$this->display('aroom/schcreditreport');
	}

	//获取指定班级下面所有的学生uid数组
	private function _getClassStu($classid = 0){
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array(
			'classid'=>$classid,
			'crid'=>$roominfo['crid'],
			'limit'=>2000
		);
		$classModel = $this->model('classes');
		$studentsList = $classModel->getClassStudentList($param);
		return $this->_getFields($studentsList,'uid');
	}

	//获取指定年级下面所有的学生uid数组
	private function _getGradeStu($grade = 0){
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array(
			'crid'=>$roominfo['crid'],
			'grade'=>$grade,
			'limit'=>2000
		);
		$classModel = $this->model('classes');
		$classlist = $classModel->getClasses($param);
		if(empty($classlist)){
			return;
		}
		$classArr =  $this->_getFields($classlist,'classid');
		$param2 = array(
			'crid'=>$roominfo['crid'],
			'classidlist'=>implode(',',$classArr),
			'limit'=>2000
		);
		$studentsList = $classModel->getClassStudentList($param2);
		return $this->_getFields($studentsList,'uid');
	}
	/**
	 *获取二维数组指定字段合集
	 */
	private function _getFields($dataList = array(),$fieldName = ''){
		$returnArr = array();
		if(empty($fieldName)||empty($dataList)){
			return $returnArr;
		}
		foreach ($dataList as $data) {
			array_push($returnArr, $data[$fieldName]);
		}
		return $returnArr;
	}

	//获取学校详情
	private function _getRoomDetail(){
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
		return $roomdetail;
	}

	/**
	 * 学分获取统计导出excel
	 */
	public function schcreditlogexcel(){
		$filename = "学生学分统计";
		$titleArr = array("学生账号","学生姓名"," 年级 "," 班级 ","获取学分","达标学分");
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array(
			'crid'=>$roominfo['crid'],
			'order'=>'cs.grade asc,cs.classid asc,score desc',
			'limit'=>100000
		);
		$schcreditlogmodel = $this->model('schcreditlog');
		$schcreditlogList = $schcreditlogmodel->getTotalList($param);

		//获取学生所在年级对应的合格学分
		$schcreditModel = $this->model('schcredit');
		$gradeScoreList = $schcreditModel->getScoreList(array('crid'=>$roominfo['crid']));
		$gradeScoreList = $this->_formatGradeScore($gradeScoreList);
		//根据学校类型获取学校年级列表
		$type = $roominfo['grade'];
		$_SG = Ebh::app()->getConfig()->load('schoolgrade');
		$gradeList = $_SG[$type];

		$dataArr = array();//存储数据
		foreach ($schcreditlogList as $tl) {
			$classname = $tl['classname'];
			$score = is_null($tl['score'])?0:$tl['score'];
			$gradename = empty($gradeList[$tl['grade']])?"":$gradeList[$tl['grade']];
			$username = $tl['username'];
			$realname = $tl['realname'];
			$okscore = empty($gradeScoreList[$tl['grade']]['score'])?0:$gradeScoreList[$tl['grade']]['score'];
			array_push($dataArr,array($username,$realname,$gradename,$classname,$score,$okscore));
		}

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

	public function _formatGradeScore($gradescoreList = array()){
		$returnArr = array();
		if(empty($gradescoreList)){
			return $returnArr;
		}
		foreach ($gradescoreList as  $gradescore) {
			$returnArr[$gradescore['grade']] = $gradescore;
		}
		return $returnArr;
	}
}