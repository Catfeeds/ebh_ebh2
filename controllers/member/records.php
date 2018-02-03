<?php
class RecordsController extends CControl{
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		if(empty($this->user)){
			header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
			exit;
		}
		$this->assign('user',$this->user);
	}
	public function index(){
		// $tempstudent = $this->model('tempstudent');
		// $tempstudentdata = $tempstudent->getbuylist($this->user['username']);
		$param = parsequery();
		// $param['pagesize'] = 10;
		$param['uid'] = $this->user['uid'];
		$param['status'] = 1;
		$offset = max(($param['page']-1)*$param['pagesize'],0);
		$param['limit'] = $offset.','.$param['pagesize'];
		$payorderModel = $this->model('payorder');
		$payorderList = $payorderModel->getOrderList($param);
		$this->assign('payorderList',$payorderList);
		$payorderCount = $payorderModel->getOrderCount($param);
		$pageStr = show_page($payorderCount,$param['pagesize']);
		$this->assign('pageStr',$pageStr);
		// $this->assign('tempstudentdata',$tempstudentdata);
		$this->display('member/records');
	}
}
?>