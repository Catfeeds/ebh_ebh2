<?php
/**
 * 选课管理
 */
class SelectcourseController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}

	public function index() {
		$this->display('aroomv2/selectcourse');
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
		$this->display('aroomv2/selectcourse_list');
	}

	public function add(){
		if($this->input->post()){
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getAdminLoginUser();
			$folder = $this->model('folder');
			$param['crid'] = $roominfo['crid'];
			$param['order'] = 'folderid asc';
			$roomfolder = $folder->getfolderlist($param);
			$param['folderlevel'] = 2;
			$param['upid'] = 0;
			$param['img'] = $this->input->post('img');
			$param['foldername'] = $this->input->post('foldername');
			// $param['displayorder'] = $this->input->post('displayorder');
			$param['summary'] = $this->input->post('summary');
			$param['uid'] = $user['uid'];
			$param['speaker'] = $this->input->post('speaker');
			$param['detail'] = h($this->input->post('detail'));
			if($roominfo['isschool'] == 7) {
				if(NULL !== $this->input->post('isfree')) {
					$param['fprice'] = 0;
				}else{
					$param['fprice'] = 1;
				}
				if(NULL !== $this->input->post('coursewarelogo')) {
					$param['coursewarelogo'] = 1;
				}else{
					$param['coursewarelogo'] = 0;
				}
			}
			$param['folderpath'] = $roomfolder[0]['folderpath'];
			$param['grade'] = $this->input->post('grade');
			$param['power'] = $this->input->post('power');
			$displayorder = $folder->getCurdisplayorder(array('crid'=>$roominfo['crid'],'folderlevel'=>2));
			if($displayorder == null)
				$param['displayorder'] = 200;
			else
				$param['displayorder'] = $displayorder - 1;
			if($roominfo['iscollege']) {	//如果是大学版，则处理学分等信息
				$credit = intval($this->input->post('credit'));	//学分
				$coursecredit = intval($this->input->post('coursecredit'));
				if($coursecredit < 0)
					$coursecredit = 0;
				$examcredit = intval($this->input->post('examcredit'));
				if($examcredit < 0)
					$examcredit = 0;
				if(($coursecredit + $examcredit) < 100) {
					$coursecredit = 100 - $examcredit;
				}
				$playmode = intval($this->input->post('playmode'));
				$isremind = intval($this->input->post('isremind'));
				$remindtime = $this->input->post('remindtime');
				$remindmsg = $this->input->post('remindmsg');
				$remindtimestr = ''; //多个提醒时间以逗号,隔开
				$remindmsgstr = '';	//多个提醒文字以井号#隔开
				if(!empty($remindtime) && count($remindtime)>0) {
					foreach($remindtime as $remindt) {
						if(is_numeric($remindt) && $remindt > 0) {
							if($remindtimestr == '')
								$remindtimestr = $remindt*60;
							else
								$remindtimestr = $remindtimestr.','.$remindt*60;
						}
					}
				}
				if(!empty($remindmsg) && count($remindmsg)>0) {
					$remindmsgstr = implode('#',$remindmsg);
				}
				$param['credit'] = $credit;
				$param['creditrule'] = $coursecredit.':'.$examcredit;
				$param['playmode'] = $playmode;
				$param['isremind'] = $isremind;
				$param['remindtime'] = $remindtimestr;
				$param['remindmsg'] = $remindmsgstr;

			}
			$folderid = $folder->addfolder($param);

			if ($folderid)
			{
				$location = $this->input->post('location');
				$admitnum = $this->input->post('admitnum');
				$isforbidden = $this->input->post('isforbidden');
				$allowgrade = $this->input->post('allowgrade');
				if (empty($allowgrade)) {
					$allowgrade = '0';
				} elseif (in_array('0', $allowgrade)) {
					$allowgrade = '0';
				} else {
					$allowgrade = ',' . implode(',', $allowgrade) . ',';
				}
				$this->model('selectcourse')->addSelectCourse(array(
					'folderid' => $folderid,
					'location' => $location,
					'admitnum' => $admitnum,
					'isforbidden' => $isforbidden,
					'allowgrade' => $allowgrade
				));
			}

			/**写日志开始**/
			$message = '开设课程 '.$param['foldername'];
			Ebh::app()->lib('LogUtil')->add(
				array(
					'toid'=>$param['crid'],
					'message'=>$message,
					'opid'=>1,
					'type'=>'classroom'
					)
			);
			/**写日志结束**/

			header('location:'.geturl('aroomv2/selectcourse/courselist'));
		}else{
			$roominfo = Ebh::app()->room->getcurroom();
			$folder = $this->model('folder');
			$param['crid'] = $roominfo['crid'];

			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$this->assign('imgarr',$this->getimages());
			$this->assign('roominfo',$roominfo);
			$this->display('aroomv2/selectcourse_add');
		}
	}

	public function edit_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$coursedetail = $this->model('selectcourse')->getCourseDetail($folderid);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('imgarr',$this->getimages());
		$this->assign('coursedetail',$coursedetail);
		$this->assign('roominfo',$roominfo);
		$this->display('aroomv2/selectcourse_edit');
	}

	public function del(){
		$roominfo = Ebh::app()->room->getcurroom();
		$param['folderid'] = $this->input->post('folderid');
		$param['crid'] = $roominfo['crid'];
		$res = $this->model('selectcourse')->deletecourse($param);
		if($res)
		echo json_encode(array('code'=>1,'message'=>'删除成功'));
		else
		echo json_encode(array('code'=>0,'message'=>'删除失败'));

		/**写日志开始**/
		fastcgi_finish_request();
		$message = json_encode($param);
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['folderid'],
				'message'=>$message,
				'opid'=>4,
				'type'=>'folder'
				)
		);
		/**写日志结束**/
	}
	public function edit(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderid'] = $this->input->post('folderid');
		$param['foldername'] = $this->input->post('foldername');
		$param['summary'] = $this->input->post('summary');
		$param['img'] = $this->input->post('img');
		$param['speaker'] = $this->input->post('speaker');
		$param['detail'] = h($this->input->post('detail'));
		if(NULL !== $this->input->post('grade')) {
			$param['grade'] = intval($this->input->post('grade'));
		}
		$param['power'] = $this->input->post('power');
		if($roominfo['isschool'] == 7) {
			if(NULL !== $this->input->post('isfree')) {
					$param['fprice'] = 0;
				}else{
					$param['fprice'] = 1;
				}
			if(NULL !== $this->input->post('coursewarelogo')) {
					$param['coursewarelogo'] = 1;
				}else{
					$param['coursewarelogo'] = 0;
				}
		}
		$param['displayorder'] = $this->input->post('displayorder');
		if($roominfo['iscollege']) {	//如果是大学版，则处理学分等信息
			$credit = intval($this->input->post('credit'));	//学分
			$coursecredit = intval($this->input->post('coursecredit'));
			if($coursecredit < 0)
				$coursecredit = 0;
			$examcredit = intval($this->input->post('examcredit'));
			if($examcredit < 0)
				$examcredit = 0;
			if(($coursecredit + $examcredit) < 100) {
				$coursecredit = 100 - $examcredit;
			}
			$playmode = intval($this->input->post('playmode'));
			$isremind = intval($this->input->post('isremind'));
			$remindtime = $this->input->post('remindtime');
			$remindmsg = $this->input->post('remindmsg');
			$remindmsg = $this->input->post('remindmsg');
			if(!empty($remindtime) && count($remindtime)>0) {
				foreach($remindtime as $remindt) {
					if(is_numeric($remindt) && $remindt > 0) {
						if($remindtimestr == '')
							$remindtimestr = $remindt*60;
						else
							$remindtimestr = $remindtimestr.','.$remindt*60;	//多个提醒时间以逗号,隔开
					}
				}
			}
			if(!empty($remindmsg) && count($remindmsg)>0) {
				$remindmsgstr = implode('#',$remindmsg);					//多个提醒文字以井号#隔开
			}
			$param['credit'] = $credit;
			$param['creditrule'] = $coursecredit.':'.$examcredit;
			$param['playmode'] = $playmode;
			$param['isremind'] = $isremind;
			$param['remindtime'] = $remindtimestr;
			$param['remindmsg'] = $remindmsgstr;
		}
		$result = $folder->editcourse($param);

		if ($result !== false)
		{
			$param['location'] = $this->input->post('location');
			$param['admitnum'] = $this->input->post('admitnum');
			$isforbidden = $this->input->post('isforbidden');
			$allowgrade = $this->input->post('allowgrade');
			if (empty($allowgrade)) {
				$allowgrade = '0';
			} elseif (in_array('0', $allowgrade)) {
				$allowgrade = '0';
			} else {
				$allowgrade = ',' . implode(',', $allowgrade) . ',';
			}
			$this->model('selectcourse')->editSelectCourse(array(
				'folderid' => $param['folderid'],
				'location' => $param['location'],
				'admitnum' => $param['admitnum'],
				'isforbidden' => $isforbidden,
				'allowgrade' => $allowgrade
			));
		}
		/**写日志开始**/
		$message = '['.implode(',', $param).']';
		Ebh::app()->lib('LogUtil')->add(
			array(
				'toid'=>$param['folderid'],
				'message'=>$message,
				'opid'=>2,
				'type'=>'folder'
				)
		);
		/**写日志结束**/
		header('location:'.geturl('aroomv2/selectcourse/courselist'));

	}

	/**
	 * 查看报名学生
	 * @return [type] [description]
	 */
	public function student_view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$isnew = $this->input->get('isnew');
		$isnew = empty($isnew) ? 0 : 1;//1当期报名学生 0历年报名学生
		$param = parsequery();
		$param['folderid'] = $folderid;
		$param['crid'] = $roominfo['crid'];
		$param['isnew'] = $isnew;
		$param['pagesize'] = 50;
		$studentlist = $this->model('selectcourse')->getStudentList($param);
		$studentcount = $this->model('selectcourse')->getStudentCount($param);
		$pagestr = show_page($studentcount,$param['pagesize']);
		$this->assign('folderid', $folderid);
		$this->assign('isnew', $isnew);
		$this->assign('studentlist',$studentlist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroomv2/selectcourse_student');
	}

	public function getimages(){
        $roominfo = Ebh::app()->room->getcurroom();
        if ($roominfo['template'] == 'plate') {
            $pre_path = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/';
        } else {
            $pre_path = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimg/';
        }

		$imgarr = array();
		for($i=1;$i<=96;$i++){
			$imgarr[] = $pre_path.$i.'.jpg'; 
		}
		$imgarr[] = $pre_path.'guwen.jpg';
		return $imgarr;
	}

	private function getKey($user,$cwurl='',$id=0) {
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time\t$cwurl\t$id";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}

	/*
	上移下移课程
	*/
	public function move(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->input->post('folderid');
		$flag = $this->input->post('flag');
		if($flag == 1){
			$res = $this->model('selectcourse')->moveit(array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'compare'=>'<','order'=>'f.displayorder desc,f.folderid asc'));
		}else{
			$res = $this->model('selectcourse')->moveit(array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'compare'=>'>','order'=>'f.displayorder asc,f.folderid asc'));
		}

		if($res)
			echo 1;
		else
			echo 0;
	}

	/**
	 * 导出excel
	 */
	public function doexcel() {
		$tag = intval($this->input->get('tag'));
		$isnew = $this->input->get('isnew');
		$isnew = empty($isnew) ? 0 : 1;//1当期报名学生 0历年报名学生
		$filename = empty($isnew) ? '历年选课报名学生统计' : '选课报名学生统计';
		$titleArr = array('学生账号','姓名','性别','班级','邮箱','联系电话');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['folderid'] = $this->input->get('folderid');
		$param['crid'] = $roominfo['crid'];
		$param['isnew'] = $isnew;
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
		$l = count($dataArr);
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

		if (!empty($isnew)) {
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
		}
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

	/**
	 * 获得报名时间
	 */
	public function getregtime() {
		$roominfo = Ebh::app()->room->getcurroom();
		$regtime = $this->model('selectcourse')->getRegTime($roominfo['crid']);
		$regtime['begintime'] = empty($regtime['begintime']) ? '' : date("Y-m-d H:i:s",$regtime['begintime']);
		$regtime['endtime'] = empty($regtime['endtime']) ? '' : date("Y-m-d H:i:s", $regtime['endtime']);
		echo json_encode($regtime);
	}

	/**
	 * 设置报名时间
	 */
	public function setregtime() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $user['uid'];
		$param['begintime'] = $this->input->post('begintime');
		$param['begintime'] = strtotime($param['begintime']);
		$param['endtime'] = $this->input->post('endtime');
		$param['endtime'] = strtotime($param['endtime']);
		if (empty($param['begintime']) || empty($param['endtime']))
		{
			echo '-1';
			exit;
		}

		$result = $this->model('selectcourse')->setRegTime($param);
		if ($result !== FALSE)
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}

	/**
	 * 重置报名
	 */
	public function reset(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$res = $this->model('selectcourse')->resetreg($crid);
		if($res)
		echo json_encode(array('code'=>1,'message'=>'重置成功'));
		else
		echo json_encode(array('code'=>0,'message'=>'重置失败'));
	}

}
?>