<?php
/**
 * 认证申请
 */
class ExamapplyController extends CControl {
	public function __construct() {
		parent::__construct();
		Ebh::app()->room->checkteacher();
	}

	public function index() {
		$this->display('troomv2/examapply_index');
	}

	/**
	 * 待审核列表
	 */
	public function applylist() {
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['status'] = 0;
		$applylist = $this->model('examapply')->getapplylist($queryarr);
		$count = $this->model('examapply')->getapplycount($queryarr);
		$pagestr = show_page($count);

		$this->assign('applylist', $applylist);
		$this->assign('q',$queryarr['q']);
		$this->assign('pagestr', $pagestr);
		$this->display('troomv2/examapply_applylist');
	}

	/**
	 * 已通过列表
	 */
	public function passapply() {
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['status'] = 1;
		$applylist = $this->model('examapply')->getapplylist($queryarr);
		$count = $this->model('examapply')->getapplycount($queryarr);
		$pagestr = show_page($count);

		$this->assign('applylist', $applylist);
		$this->assign('q',$queryarr['q']);
		$this->assign('pagestr', $pagestr);
		$this->display('troomv2/examapply_passapply');
	}

	/**
	 * 未通过列表
	 */
	public function unpassapply() {
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['status'] = 2;
		$applylist = $this->model('examapply')->getapplylist($queryarr);
		$count = $this->model('examapply')->getapplycount($queryarr);
		$pagestr = show_page($count);

		$this->assign('applylist', $applylist);
		$this->assign('q',$queryarr['q']);
		$this->assign('pagestr', $pagestr);
		$this->display('troomv2/examapply_unpassapply');
	}

	/**
	 * ajax获取申请详情
	 */
	public function applydetail(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['applyid'] = $this->input->post('applyid');
		$param['crid'] = $roominfo['crid'];
		$apply = $this->model('examapply')->getOneApply($param);
		if(!empty($apply)){
			echo json_encode(array('code'=>1, 'apply'=>$apply));
			exit;
		}
		else
		{
			echo json_encode(array('code'=>0));
			exit;
		}

	}

	public function check(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param['applyid'] = $this->input->post('applyid');
		$param['status'] = $this->input->post('status');
		$param['verifymessage'] = $this->input->post('verifymessage');
		$param['nexttype'] = $this->input->post('nexttype');
		$param['crid'] = $roominfo['crid'];
		$param['verifyuid'] = $user['uid'];
		$result = $this->model('examapply')->check($param);
		if ($result){
			$nextapply = $this->model('examapply')->getNextOne($param);
			echo json_encode(array('code'=>1, 'nextapply' => $nextapply));
		}else{
			echo json_encode(array('code'=>0));
		}
	}

	/**
	 * 批量审核
	 */
	public function batchcheck(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param['status'] = $this->input->post('status');
		$param['ids'] = $this->input->post('ids');
		$param['crid'] = $roominfo['crid'];
		$param['verifyuid'] = $user['uid'];
		$result = $this->model('examapply')->batchcheck($param);
		if ($result){
			echo json_encode(array('code'=>1,'msg'=>'审核成功'));
		}else{
			echo json_encode(array('code'=>0,'msg'=>'审核失败'));
		}

	}

	/**
	 * 成绩统计
	 */
	public function resultlist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classmodel = $this->model('Classes');
		$exammodel = $this->model('Exam');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['type'] = array(1,3);
		$user = Ebh::app()->user->getloginuser();
		//$param['uid'] = $user['uid'];
		$exams = $exammodel->getschexamlist($param);
		$count = $exammodel->getschexamlistcount($param);
		$pagestr = show_page($count);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('q',$param['q']);
		$this->assign('exams',$exams);
		$this->display('troomv2/examapply_resultlist');
	}

	//已通过未发证书
	public function result_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$eid = $this->uri->itemid;
		if(!is_numeric($eid) || $eid <= 0) {
			exit();
		}
		$param = parsequery();
		$param['eid'] = $eid;
		$param['crid'] = $roominfo['crid'];
		$param['ispass'] = 1;//已通过
		$param['isaward'] = 0 ;//未发证
		$answers = $this->model('exam')->getschexamansweredlist($param);
		$count = $this->model('exam')->getschexamansweredcount($param);

		$exam = $this->model('exam')->getschexambyeid($eid);

		$pagestr = show_page($count);
		$this->assign('pagestr',$pagestr);
		$this->assign('eid',$eid);
		$this->assign('roominfo',$roominfo);
		$this->assign('answers',$answers);
		$this->assign('exam',$exam);
		$this->assign('q',$param['q']);
		$this->display('troomv2/examapply_resultview');
	}

	//未通过
	public function resultfail_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$eid = $this->uri->itemid;
		if(!is_numeric($eid) || $eid <= 0) {
			exit();
		}
		$param = parsequery();
		$param['eid'] = $eid;
		$param['crid'] = $roominfo['crid'];
		$param['ispass'] = 0;//未通过
		$answers = $this->model('exam')->getschexamansweredlist($param);
		$count = $this->model('exam')->getschexamansweredcount($param);

		$exam = $this->model('exam')->getschexambyeid($eid);

		$pagestr = show_page($count);
		$this->assign('pagestr',$pagestr);
		$this->assign('eid',$eid);
		$this->assign('roominfo',$roominfo);
		$this->assign('answers',$answers);
		$this->assign('exam',$exam);
		$this->assign('q',$param['q']);
		$this->display('troomv2/examapply_resultfailview');
	}

	//已发证
	public function resultaward_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$eid = $this->uri->itemid;
		if(!is_numeric($eid) || $eid <= 0) {
			exit();
		}
		$param = parsequery();
		$param['eid'] = $eid;
		$param['crid'] = $roominfo['crid'];
		$param['isaward'] = 1 ;//已发证
		$answers = $this->model('exam')->getschexamansweredlist($param);
		$count = $this->model('exam')->getschexamansweredcount($param);

		$exam = $this->model('exam')->getschexambyeid($eid);

		$pagestr = show_page($count);
		$this->assign('pagestr',$pagestr);
		$this->assign('eid',$eid);
		$this->assign('roominfo',$roominfo);
		$this->assign('answers',$answers);
		$this->assign('exam',$exam);
		$this->assign('q',$param['q']);
		$this->display('troomv2/examapply_resultawardview');
	}


	/**
	 * 批量发证
	 */
	public function batchaward(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param['ids'] = $this->input->post('ids');
		$param['crid'] = $roominfo['crid'];
		$param['tid'] = $user['uid'];
		$result = $this->model('examapply')->batchaward($param);
		if ($result){
			echo json_encode(array('code'=>1,'msg'=>'发证成功'));
		}else{
			echo json_encode(array('code'=>0,'msg'=>'发证失败'));
		}

	}

	//考试导出
	public function examexcel_view(){
		$eid = $this->uri->itemid;
		$type = $this->input->get('type');
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');

		$titleArr = array("姓名","性别","姓名拼音","专业","学生证号","身份证号","联系电话","邮箱","成绩");

		$roominfo = Ebh::app()->room->getcurroom();
		if(!is_numeric($eid) || $eid <= 0 ) {
			exit;
		}

		$exammodel = $this->model('Exam');
		$myexam = $exammodel->getschexambyeid($eid);
		$filename = $myexam['title'];

		$param = array();
		$param['eid'] = $eid;
		$param['crid'] = $roominfo['crid'];
		$param['startdate'] = empty($startdate) ? '' : strtotime($startdate);
		$param['enddate'] = empty($enddate) ? '' : (strtotime($enddate)+86400);

		$param['limit'] = 100;
		if($type == 1) {
			$param['ispass'] = 1;//已通过
			$param['isaward'] = 0 ;//未发证
		} else if ($sort == 2) {
			$param['ispass'] = 0;//未通过
		} else if ($sort == 3) {
			$param['isaward'] = 1 ;//已发证
		}

		$answers = $this->model('exam')->getschexamexcellist($param);

		$dataArr = array();//存储数据
		foreach($answers as $answer){
			//"姓名","性别","姓名拼音","专业","学生证号","身份证号","联系电话","邮箱","成绩"
			$sex = $answer['sex'] == 1 ? '女':'男';
			$score = round($answer['totalscore'],2);
			$rm = $tl['remark'];
			$st = (!empty($tl['aid']) && $tl['status']!=0)?'已提交':'未提交';
			array_push($dataArr,array($answer['realname'],$sex,$answer['namespell'],$answer['major'],$answer['stuid'],$answer['idcard'],$answer['email'],$answer['email'],$score));
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
}