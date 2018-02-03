<?php
/**
 *订单详情修复工具，用于批量开通的退款详情fee不正确的问题
 *使用说明：1.教师账号登录 2.请求地址 ： a(所有学校订单)：http://www.ebh.net/payfix.html b(指定学校[crid=10440的学校]订单):http://www.ebh.net/payfix.html?crid=10440
 * 看到页面显示内容包含 fixed ok 即修复成功
 */
class PayfixController extends CControl{
	public function __construct(){
		parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			echo 'user not login in  , fix  fail !';
			exit;
		}
		if($user['groupid'] !=5){
			echo 'permission deney  , fix  fail !';
			exit;
		}else{
			echo 'fix start !<br />';
		}
		set_time_limit(0);
		$this->db = Ebh::app()->getDb();
	}
	public function index(){
		$crid = intval($this->input->get('crid'));
		if(!empty($crid)){
			$sql = 'select o.orderid,o.sourceid from ebh_pay_orders o where o.orderid in (select od1.orderid from ebh_pay_orderdetails od1  where od1.fee < 0 and od1.dstatus =1) and sourceid  > 0 and crid = '.$crid;
		}else{
			$sql = 'select o.orderid,o.sourceid from ebh_pay_orders o where o.orderid in (select od1.orderid from ebh_pay_orderdetails od1  where od1.fee < 0 and od1.dstatus =1) and sourceid  > 0';
		}
		//获取退款成功时的生成的订单
		
		$refund_new_orders = $this->db->query($sql)->list_array();
		if(empty($refund_new_orders)){
			echo '没有符合条件的订单','<br />','fixed over!';
			exit;
		}
		$old_new_Map = $this->_createOldNewMap($refund_new_orders);

		//从退款订单中查出原订单

		//老订单号,用于查出购买时生成的详情
		$orderid_old = $this->_getFieldArr($refund_new_orders,'sourceid');
		$sql_for_old_detail = 'select orderid,itemid,uid,pid,fee as fee,crid,folderid,rname,oname,osummary,omonth,oday,dstatus from ebh_pay_orderdetails od2 where od2.orderid in ('.implode(',', $orderid_old).')';
		$old_details = $this->db->query($sql_for_old_detail)->list_array();

		if($this->db->begin_trans()){
			echo 'trans start ok !','<br />';
		}else{
			echo 'trans start fail!','<br />';
			exit;
		}
		//退款时产生的订单号,用于删除原先退款时产生的详情
		$orderid_new = $this->_getFieldArr($refund_new_orders,'orderid');
		//删除旧退款详情
		$sql_delete_old_details = 'delete from ebh_pay_orderdetails where orderid in ('.implode(',', $orderid_new).')';
		$this->db->query($sql_delete_old_details);
		$delete_num = $this->db->affected_rows();
		if($delete_num == 0){
			echo 'delete_num:',$delete_num,' trans roolback !<br />';
			$this->db->rollback_trans();
			exit;
		}
		echo 'delete_num:',$delete_num,'<br />';

		$sql_create_new_details_values = array();

		$fields = '(orderid,itemid,uid,pid,fee,crid,folderid,rname,oname,osummary,omonth,oday,dstatus)';
		foreach ($old_details as $old_detail) {
			$old_detail['orderid'] = $old_new_Map[$old_detail['orderid']];
			$old_detail['fee'] = -$old_detail['fee'];
			$old_detail['osummary'] = '退款'.$old_detail['osummary'];
			$sql_create_new_details_values[] = '("'.implode('","', $old_detail).'")';
		}
		$sql_create_new_details = 'insert into ebh_pay_orderdetails '.$fields.' values '.implode(',', $sql_create_new_details_values);
		$this->db->query($sql_create_new_details);
		$create_num = $this->db->affected_rows();
		if($create_num == 0){
			echo 'create_num:',$create_num,'trans roolback!<br />';
			$this->db->rollback_trans();
			exit;
		}
		echo 'create_num:',$create_num,'<br />';
		if($delete_num != $create_num){
			echo 'fixed error : delete_num 不等于 create_num';
			$this->db->rollback_trans();
			exit;
		}else{
			echo 'fixed ok ！ fixed num : ',$create_num,'<br />';
		}
		$this->db->commit_trans();
		echo 'trans_commit ok !<br />';
		echo 'fix end !<br />';
		
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

		return $reuturnArr;
	}
	/**
	 *产生原订单和退款订单映射
	 */
	private function _createNewOldMap($orders = array()){
		$retArr = array();
		foreach ($orders as $order) {
			$retArr[$order['orderid']] = $order['sourceid'];
		}
		return $retArr;
	}

	/**
	 *产生退款订单和原订单映射
	 */
	private function _createOldNewMap($orders = array()){
		$retArr = array();
		foreach ($orders as $order) {
			$retArr[$order['sourceid']] = $order['orderid'];
		}
		return $retArr;
	}
}