<?php
/**
 *服务包购买数据统计
 *教师账号登陆，然后请求网址：
 *www.ebh.net/pbuy.html?pid=101 (pid为服务包的id)
 */
class PbuyController extends CControl{
	private $pid = 0;
	public function __construct(){
		parent::__construct();
		$this->_checkTeacher();
		$pid = $this->input->get('pid');
		if(!is_numeric($pid) || $pid <= 0){
			echo '服务包id错误';
			exit;
		}
		$this->pid = $pid;
	}

	private function _checkTeacher(){
		$user = $this->user = Ebh::app()->user->getloginuser();
		if(empty($user) || $user['groupid']!=5){
			echo 'illigle!';exit;
		}
	} 
	public function index(){
		$this->init();
		$this->run();
	}

	private function init(){
		$this->db = Ebh::app()->getDb();
		$this->grademap = Ebh::app()->getConfig()->load('grademap');
		$packInfo = $this->_getPackageInfo($this->pid);
		if(empty($packInfo)){
			echo '服务包信息错误';
			exit;
		}
		$this->crid = $packInfo['crid'];
		$this->pname = $packInfo['pname'];
		$this->crname = $packInfo['crname'];
		$this->title = $this->crname.'_'.$this->pname.'_'.date('Y年m月d日_H时i分s秒');
	}

	private function run(){
		$items = $this->_getItems();
		$classes = $this->_getClassInfo();
		
		$ret = array();
		foreach ($items as $item) {
			foreach ($classes as $class) {
				if($class['grade'] != $item['grade']){
					continue;
				}
				$ckey = 'c_'.$class['classid'];
				if(!array_key_exists($ckey, $ret)){
					$ret[$ckey] = array();
					$ret[$ckey]['classname'] = $class['classname'];
					$ret[$ckey]['grade'] = $class['grade'];
					$ret[$ckey]['data'] = array();
					
				}
				$title = $item['iname'];
				$ikey = $title;
				if(!array_key_exists($ikey, $ret[$ckey]['data'])){
					$ret[$ckey]['data'][$title] = 0;
				}
				//获取班级学生
				$stus = $this->_getClassStudent($class['classid']);
				//获取学生uid
				$uids = $this->_getFields($stus,'uid');
				$ret[$ckey]['data'][$title] = $this->_getBuyInfo($item['itemid'],$uids);
			}
		}
		$sortArr = array();
		$sheets = array();
		$currgrade = 0;
		foreach ($ret as $rkey => $rvalue) {
			if(empty($currgrade)){
				$currgrade = $rvalue['grade'];
				$tmpArr = array();
				$titleArr = array('班级');
				$sheets[] = $this->_getGradeName($rvalue['grade']);
			}
			if($rvalue['grade'] != $currgrade){
				$currgrade = $rvalue['grade'];
				$tmpArr[] = $this->_getYTotal($tmpArr);
				$sortArr[] = $tmpArr;
				$tmpArr = array();
				$titleArr = array('班级');
				$sheets[] = $this->_getGradeName($rvalue['grade']);
			}

			$data = $rvalue['data'];
			krsort($data);
			if(count($titleArr) == 1){
				$titleArr = array_merge($titleArr,array_keys($data),array('总计'));
				$tmpArr[] = $titleArr;
			}
			$gradeInfo = array($rvalue['classname']);
			$gradeInfo = array_merge($gradeInfo,array_values($data),array(array_sum($data)));
			$tmpArr[] = $gradeInfo;
			
		}
		$tmpArr[] = $this->_getYTotal($tmpArr);
		$sortArr[] = $tmpArr;
		$this->_exportExcel($sortArr,$sheets,$this->title);
	}

	// 获取y方向的统计结果
	private function _getYTotal($arr = array()){
		$ret = array();
		foreach ($arr as $akey => $avalue) {
			foreach ($avalue as $key => $value) {
				if(!array_key_exists($key, $ret)){
					$ret[$key] = 0;
				}
				$ret[$key] += $value;
			}
		}
		$ret[0] = '总计';
		return $ret;
	}
	//获取年级信息
	private function _getGradeName($grade = 0){
		$ret = '年级_'.$grade;
		if(array_key_exists($grade, $this->grademap)){
			$ret = $this->grademap[$grade];
		}
		return $ret;
	}

	//获取服务项信息
	private function _getItems(){
		$sql = 'select pi.itemid,pi.iname,f.grade from ebh_pay_items pi 
		join ebh_folders f on pi.folderid = f.folderid 
		where pi.pid = '.$this->pid;
		$itemlist = $this->db->query($sql)->list_array();
		return $itemlist;
	}

	//获取写下片班级信息
	private function _getClassInfo(){
		$sql = 'select classid,classname,grade from ebh_classes where crid = '.$this->crid.' order by grade asc';
		$classInfo = $this->db->query($sql)->list_array();
		return $classInfo;
	}

	//获取班级学生
	private function _getClassStudent($classid = 0){
		$ret = array();
		if(!empty($classid)){
			$sql = 'select uid,classid from ebh_classstudents cs where cs.classid = '.$classid;
			$ret = $this->db->query($sql)->list_array();
		}
		return $ret;
	}

	//获取服务购买信息
	private function _getBuyInfo($itemid = array(),$uids = array()){
		if(empty($itemid) || empty($uids)){
			return 0;
		}
		$sql1 = 'select count(1)  count from ebh_pay_orderdetails po where po.dstatus = 1 AND po.invalid = 0 AND po.fee >0 AND po.itemid = '.$itemid.' AND po.uid in ('.implode(',', $uids).')';
		$sql2 = 'select count(1)  count from ebh_pay_orderdetails po where po.dstatus = 1 AND po.invalid = 0 AND po.fee <0 AND po.itemid = '.$itemid.' AND po.uid in ('.implode(',', $uids).')';
		$res1 = $this->db->query($sql1)->row_array();
		$res2 = $this->db->query($sql2)->row_array();
		$res = $res1['count'] - $res2['count'];
		return $res;
	}

	//获取二维数组指定字段合集
	private function _getFields($param = array(),$fieldName = ''){
		$ret = array();
		foreach ($param as $value) {
			$ret[] = $value[$fieldName];
		}
		return array_unique($ret);
	}

	//获取服务包信息
	private function _getPackageInfo($pid = 0){
		$sql = 'select p.pid,p.pname,p.crid,cr.crname from ebh_pay_packages p join ebh_classrooms cr on p.crid = cr.crid where pid = '.$pid.' limit 1';
		return $this->db->query($sql)->row_array();
	}

	//excel导出
	private function _exportExcel($datas = array(),$sheets = array(),$name = ''){
		if(empty($datas) || empty($sheets)){
			echo '没有数据';
			exit;
		}
	    $objExcel = Ebh::app()->lib('PHPExcel');
	    $objWriter = new PHPExcel_Writer_Excel5($objExcel);   // 用于其他版本格式  
  		$objProps = $objExcel->getProperties(); 
	  // 以下是一些设置 ，什么作者  标题啊之类的
		$objExcel->getProperties()
					->setTitle("数据EXCEL导出")
					->setSubject("数据EXCEL导出")
					->setDescription("备份数据")
					->setKeywords("excel")
					->setCategory("result file");

	    $titleMap = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T');

	    foreach ($datas as $key => $data) {
	    	try{
	    		$objExcel->setActiveSheetIndex($key); 
	    	}catch(Exception $e){
	    		$objExcel->createSheet();
		   		$objExcel->setActiveSheetIndex($key); 
	    	}
		    $objActSheet = $objExcel->getActiveSheet(); 
		    $objActSheet->setTitle($sheets[$key]); 

		    for($i=0;$i<count($data[0]);$i++){
		    	 $objStyle = $objActSheet->getStyle($titleMap[$i].'1');
		    	 $objStyle->getFont()->setSize(10);  
		    	 $objStyle->getFont()->setBold(true);  
		    }
		   	
		   	foreach ($data as $k => $d) {
		   		for($index=0;$index<count($d);$index++){
		   			$objActSheet->getStyle($titleMap[$index].($k+1))->applyFromArray(
		   				array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER))
                    );
		   			$objActSheet->setCellValue($titleMap[$index].($k+1), $d[$index]); // 字符串内容 
		   		}
		   	}
	    }


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