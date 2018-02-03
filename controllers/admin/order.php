<?php
/**
 * 积分订单
 */
class OrderController extends AdminControl {
	/**
	 * 首页
	 * @return [type] [description]
	 */
	public function index() {
		//$this->getlist(1);
		$this->display('admin/order');
	}

	/**
	 * ajax获取列表
	 */
	public function getListAjax() {
		$queryArr['q'] = $this->input->post('query');
		$pageNumber= intval($this->input->post('pageNumber'));
		$pageSize = intval($this->input->post('pageSize'));
		$offset=max(($pageNumber-1)*$pageSize,0);
		$queryArr['limit']=$offset.','.$pageSize;
		$list = $this->model('credit')->getOrderListDetail($queryArr);
		$total = $this->model('credit')->getOrderCount($queryArr);
		array_unshift($list, array('total'=>$total));
		echo json_encode($list);
	}

	public function setstatus() {
		$param['oid'] = $this->input->post('oid');
		$param['status'] = $this->input->post('status');
		$param['expressname'] = $this->input->post('expressname');
		$param['expressNo'] = $this->input->post('expressNo');
		$param['remark'] = $this->input->post('remark');
		$res = $this->model('credit')->setOrderStatus($param);
		if ($res !== FALSE)
			echo 1;
		else
			echo 0;
	}
}