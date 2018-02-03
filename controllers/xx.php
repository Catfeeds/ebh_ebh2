<?php
/**
 *某个学校
 */
class XxController extends CControl{
	public function __construct(){
		set_time_limit(0);
		$this->db = Ebh::app()->getDb();
		$this->gradelist = Ebh::app()->getConfig()->load('grademap');
		$this->viewLib = Ebh::app()->lib('Viewnum');
		$this->gradelist[0] = "0年级";
	}
	public function index(){
		$this->_init();
		$this->_run();
	}

	private function _init(){
		$this->crid = 10420;
		$this->starttime_str = "2015-02-01";
		$this->endtime_str = "";
		$this->starttime = strtotime($this->starttime_str);
		$this->endtime = strtotime($this->endtime_str);
	}

	private function _run(){
		$this->_getCwList();//获取课件列表
		$this->_updateCwTime();//升级课件时间
		$this->_getFolderInfo();//提取课程信息
		$this->_getUserInfo();//提取教师信息
		$this->_combineData();//合并数据
		$this->_export();//数据导出
	}
	private function _getCwList(){
		$sql = 'select cw.uid,cw.cwid,cw.title,cw.cwlength,cw.dateline,cw.viewnum,cw.cwurl,rc.folderid from ebh_coursewares  cw 
		join ebh_roomcourses rc on cw.cwid = rc.cwid where cw.status = 1 AND rc.crid = '.$this->crid.' and cw.dateline >='.$this->starttime.' order by cw.uid,rc.folderid';
		$cwlist = $this->db->query($sql)->list_array();
		$this->cwlist = $cwlist;
	}

	private function _updateCwTime(){
		$viewLib = $this->viewLib;
		//获取所有的课件的cwid
		$cwids = $this->_getFieldArr($this->cwlist,'cwid');
		//从课件记录里面获取指定的cwid的记录
		$sql = 'select distinct(p.cwid),p.ctime from ebh_playlogs p where p.cwid in ('.implode(',', $cwids).')';
		$loglist = $this->db->query($sql)->list_array();
		$loglist = $this->_modifyKeys($loglist,'cwid','log');
		$this->loglist = $loglist;
		$new_cwlist = array();
		$when_then = array();
		$cwids_where_when_then = array();
		foreach ($this->cwlist as $cw) {
			$key = 'log_'.$cw['cwid'];
			if(array_key_exists($key, $loglist)){
				$cwlength = $loglist[$key]['ctime'];
				$cw['cwlength'] = $cwlength;
				$when_then[] = ' WHEN cwid ='.$cw['cwid'].' THEN '.$cwlength;
				$cwids_where_when_then[] = $cw['cwid'];
			}else{
				//记录么有被播放的课件
				$cw['cwlength'] = 0;
			}
			$ext = $this->_getFileExt($cw['cwurl']);
			$cw['title'] = $cw['title'].$ext;
			$viewnum_cache = $viewLib->getViewnum('courseware',$cw['cwid']);
			if(!empty($viewnum_cache)){
				$cw['viewnum'] = $viewnum_cache;
			}
			$new_cwlist[] = $cw;
		}
		$this->cwlist = $new_cwlist;
		if(empty($when_then)){
			//么有要升级课件
			return;
		}
		$sql = 'UPDATE ebh_coursewares SET cwlength = (CASE '.implode(' ', $when_then).' END ) WHERE cwid in ('.implode(',', $cwids_where_when_then).')';
		$result = $this->db->query($sql);
		if(empty($result)){
			log_message("数据库课件升级时间失败,脚本退出执行");
			//数据库执行失败
			exit();
		}
		$affected_rows = $this->db->affected_rows();
		log_message("数据库课件时间更新条数:".$affected_rows);
	}

	//根据folderid数组获取课程信息
	private function _getFolderInfo(){
		$folderidArr = $this->_getFieldArr($this->cwlist,'folderid');
		$sql = 'select folderid,foldername,grade from ebh_folders where folderid in ('.implode(',', $folderidArr).')';
		$res = $this->db->query($sql)->list_array();
		$folderlist = $this->_modifyKeys($res,'folderid','fid');
		$this->folderlist = $folderlist;
	}

	//根据uid数组获取用户信息
	private function _getUserInfo(){
		$uidArr = $this->_getFieldArr($this->cwlist,'uid');
		$sql = 'select uid,username,realname from ebh_users where uid in ('.implode(',', $uidArr).')';
		$res = $this->db->query($sql)->list_array();
		$userlist = $this->_modifyKeys($res,'uid','uid');
		$this->userlist = $userlist;
	}
	//组合导出数据
	private function _combineData(){
		$data_export = array();
		$folderlist = $this->folderlist;
		$cwlist = $this->cwlist;
		$userlist = $this->userlist;
		$gradelist = $this->gradelist;
		foreach ($cwlist as $cw) {
			$fkey = 'fid_'.$cw['folderid'];
			$ukey = 'uid_'.$cw['uid'];
			if(array_key_exists($fkey, $folderlist)){
				$cw['foldername'] = $folderlist[$fkey]['foldername'];
				$grade = intval($folderlist[$fkey]['grade']);
				$cw['gradename']  = $gradelist[$grade] or "未知年级";
				$cw['grade'] = $grade;
			}else{
				$cw['foldername'] = "未知课程";
				$cw['grade'] = 0;
			}
			$cw['foldername'] = array_key_exists($fkey, $folderlist)?$folderlist[$fkey]['foldername']:"未知课程";
			if(array_key_exists($ukey, $userlist)){
				$cw['name'] = empty($userlist[$ukey]['realname'])?$userlist[$ukey]['username']:$userlist[$ukey]['realname'];
			}else{
				$cw['name'] = "未知老师";
			}
			$data_export[]= $cw;
		}
		$this->_data_export = $this->_sortList($data_export);
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

		return array_unique($reuturnArr);
	}

	/**
	 *将索引数组变成关联数组
	 */
	private function _modifyKeys($objs = array(),$fieldName,$prefix){
		if(empty($objs) || empty($fieldName) || empty($prefix)){
			var_export("转换数据不对");
			return array();
		}
		$returnArr = array();
		foreach ($objs as $obj) {
			$key = $prefix.'_'.$obj[$fieldName];
			$returnArr[$key] = $obj;
		}
		return $returnArr;
	}

	/*
	学生学习统计excel
	*/
	private function _export(){
		$datalist = $this->_data_export;
		
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
		$filename = '课件统计';
		// $titleArr = array('学生账号','姓名','班级','课程','学习时间','学习次数');
		$titleArr = array('年级','老师','课程','视频名称','上传时间','课件时长','点击量');
		// $roominfo = Ebh::app()->room->getcurroom();
		// $param['crid'] = $roominfo['crid'];
		// $classid = $this->input->get('classid');
		// if(is_numeric($classid))
		// 	$param['classid'] = $classid;
		// $param['starttime'] = $starttime;
		// $param['endtime'] = $endtime;
		// $param['limit'] = 100000;
		// $playlogmodel = $this->model('playlog');
		// $datalist = $playlogmodel->getListForClassroom2($param);
		$dataArr = array();
		$timesum = 0;
		$viewsum = 0;
		$k1 = 0;
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
					$dataArr[$l][2] = $data['foldername'];	
				}else{
					$dataArr[$l][2] = '';
				}
			}else{
				$dataArr[$l][0] = $data['gradename'];
				$dataArr[$l][1] = $data['name'];
				$dataArr[$l][2] = $data['foldername'];
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

	//按年级格式化数据
	private function _sortList($data_export = array()){
		$returnArr = array();
		$restmp = array();
		foreach ($data_export as $data) {
			$key = 'g_'.$data['grade'];
			if(!array_key_exists($key, $restmp)){
				$restmp[$key] = array();
			}
			$restmp[$key][] = $data;
		}
		ksort($restmp);
		// var_dump($restmp);die();
		foreach ($restmp as $res) {
			$returnArr = array_merge($returnArr,$res);
		}
		return $returnArr;
	}

	/**
     * 获取文件扩展名
     * @return string
     */
    private function _getFileExt($url){
        return '.'.substr($url, strrpos($url,'.')+1);
    }	
}