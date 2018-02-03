<?php
/**
 * 选课管理
 */
class SelectcourseController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkteacher();
	}

	public function index() {
		$this->courselist();
	}

	public function courselist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['nosubfolder'] = 1;
		$param['order'] = 'f.displayorder asc,f.folderid desc';
		$courselist = $this->model('selectcourse')->getCourseList($param);
		$coursecount = $this->model('selectcourse')->getCourseCount($param);

		$pagestr = show_page($coursecount);
		$this->assign('q',$param['q']);
		$this->assign('pagestr',$pagestr);
		$this->assign('courselist',$courselist);
		$this->display('troom/selectcourse_list');
	}

	/**
	 * 查看报名学生
	 * @return [type] [description]
	 */
	public function student_view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$param = parsequery();
		$param['folderid'] = $folderid;
		$param['crid'] = $roominfo['crid'];
		$param['isnew'] = 1;//当期报名学生
		$param['pagesize'] = 50;
		$studentlist = $this->model('selectcourse')->getStudentList($param);
		$studentcount = $this->model('selectcourse')->getStudentCount($param);
		$pagestr = show_page($studentcount,$param['pagesize']);
		$this->assign('folderid', $folderid);
		$this->assign('studentlist',$studentlist);
		$this->assign('pagestr',$pagestr);
		$this->display('troom/selectcourse_student');
	}

	/**
	 * 导出excel
	 */
	public function doexcel() {
		$tag = intval($this->input->get('tag'));
		$filename = '选课报名学生统计';
		$titleArr = array('学生账号','姓名','性别','班级','邮箱','联系电话');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['folderid'] = $this->input->get('folderid');
		$param['crid'] = $roominfo['crid'];
		$param['isnew'] = 1;//当期报名学生
		$param['pagesize'] = 50;
		$param['limit'] = 10000;
		$studentlist = $this->model('selectcourse')->getStudentList($param);
		$coursedetail = $this->model('selectcourse')->getCourseDetail($param['folderid']);

		$dataArr = array();
		$titlesum = 0;
		$countsum = 0;
		$k1 = 0;
		foreach($studentlist as $k=>$data){
			$l = count($dataArr);
			$dataArr[$l][0] = $data['username'];
			$dataArr[$l][1] = $data['realname'];
			$dataArr[$l][2] = empty($data['sex']) ? '男' : '女';
			$dataArr[$l][3] = $data['classname'];
			$dataArr[$l][4] = $data['email'];
			$dataArr[$l][5] = $data['mobile'];
		}
		$dataArr[$l+1][0] = '';
		$dataArr[$l+1][1] = '';
		$dataArr[$l+1][2] = '';
		$dataArr[$l+1][3] = '';
		$dataArr[$l+1][4] = '';
		$dataArr[$l+1][5] = '';

		$dataArr[$l+2][0] = '';
		$dataArr[$l+2][1] = '';
		$dataArr[$l+2][2] = '';
		$dataArr[$l+2][3] = '';
		$dataArr[$l+2][4] = '课程：';
		$dataArr[$l+2][5] = $coursedetail['foldername'];

		$dataArr[$l+3][0] = '';
		$dataArr[$l+3][1] = '';
		$dataArr[$l+3][2] = '';
		$dataArr[$l+3][3] = '';
		$dataArr[$l+3][4] = '计划数：';
		$dataArr[$l+3][5] = $coursedetail['admitnum'];

		$dataArr[$l+4][0] = '';
		$dataArr[$l+4][1] = '';
		$dataArr[$l+4][2] = '';
		$dataArr[$l+4][3] = '';
		$dataArr[$l+4][4] = '报名数：';
		$dataArr[$l+4][5] = $coursedetail['regnum'];

		$widtharr = array(20,20,20,20,20,20);
		$this->input->setcookie('export',$tag,3600);
		$this->_exportExcel($titleArr,$dataArr,'FFFFFFFF',$filename,$widtharr);
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