<?php
/**
 *系统设置 
 * @author Eker
 */
class SysconfigController extends CControl{
	private $crid = NULL;
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$roominfo = Ebh::app()->room->getcurroom();
		$this->crid = $roominfo['crid'];
	}
	
	/**
	 * 系统设置页
	 */
	public function index(){
		$cfobj = new stdClass();
		$cfmodel = $this->model("Roomconfig");
		$cfobj =$cfmodel->getConfig($this->crid );
		$this->assign('cfobj', $cfobj);
		//var_dump($cfobj);
		$this->display('aroomv2/sysconfig');
	}
	
	/**
	 * 保存设置
	 */
	public function doajax(){
		$request = $this->input->post();
		$exam_relate_mode = intval($request['exam_relate_mode']);
		if($exam_relate_mode<0 || $exam_relate_mode>3){
			exit(0);
		}
		$cfmodel = $this->model("Roomconfig");
		//先查找
		$configRow = $cfmodel->getConfig($this->crid);
		$param['json_str'] = json_encode(array('exam_relate_mode'=>$exam_relate_mode));
		if(!empty($configRow)){
			$ck = $cfmodel->updateConfig($param,$this->crid);
		}else{
			$ck = $cfmodel->addConfig($param,$this->crid);
		}

		echo json_encode(array('code'=>($ck>0)?0: 1));
	}
	
}
?>