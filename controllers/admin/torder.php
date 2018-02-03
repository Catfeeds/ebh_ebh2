<?php
/**
 * 教师服务项订单
 */
class TorderController extends AdminControl {
	/**
	 * 教师服务项订单
	 */
	public function index(){
		$this->display('admin/tservice_orderlist');
	}
	/**
	 * 获取服务项目订单
	 */
	public function getListAjax(){
		$query = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$queryArr['q'] = $query;
		$status = $this->input->post('status');
		if($status!='')
			$queryArr['status'] = $this->input->post('status');
		$payfrom = $this->input->post('payfrom');
		if($payfrom!='')
			$queryArr['payfrom'] = $this->input->post('payfrom');
		$crid = $this->input->post('crid');
		if($crid!='')
			$queryArr['crid'] = $this->input->post('crid');
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$list = $this->model('Paytorder')->getOrderList($queryArr);
		$total = $this->model('Paytorder')->getOrderCount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}
	/**
	 * 订单详情
	 *
	 */
	public function view(){
		$orderid = $this->uri->itemid;
		if($orderid<=0||!is_numeric($orderid)){
			exit();
		}
		$payorderModel = $this->model('Paytorder');
		$order = $payorderModel->getOrderDetailById($orderid);
		$this->assign("order",$order);
		$this->display('admin/torderview');
	}
	
}