<?php 
class ShopModel extends CModel{
	public function __construct(){
		parent::__construct();
		$this->shopdb = Ebh::app()->getOtherDb('shopdb');
	}
	/**
	 * [updateOrder 更新订单]
	 * @return [type] [description]
	 */
	public function updateOrder($param = array(), $ordernum = '', $gid = 0, $crid = 0){
		if(empty($param) || empty($ordernum) || empty($gid) || empty($crid)){
			return false;
		}
		$setarr = array();
		if(!empty($param['exptype'])){
			$setarr['is_cod'] =  $param['exptype'];
		}
		if(!empty($param['lid'])){
			$setarr['lid'] =  $param['lid'];
		}
		if(!empty($param['remark'])){
			$setarr['remark'] =  $param['remark'];
		}
		if(!empty($param['expnum'])){
			$setarr['express_num'] =  $param['expnum'];
		}
		if(!empty($param['ordertype'])){
			$setarr['order_type'] =  $param['ordertype'];
		}
		$where = array('oid' => $ordernum, 'crid' => $crid, 'goods_id' => $gid);
		return $this->shopdb->update('shop_order_details',$setarr,$where);
	}

	/**
	 * 获取订单的状态
	 */
	public function checkOrderStatus($ordernum = '', $gid = 0, $crid = 0){
		if(empty($ordernum) || empty($gid) || empty($crid)){
			return false;
		}
		$sql = 'select order_type from `shop_order_details` where oid ='.$ordernum.' and crid ='.intval($crid).' and goods_id ='.intval($gid);
		$res = $this->shopdb->query($sql)->row_array();
		if(!empty($res)){
			return $res['order_type'];
		}else{
			return false;
		}
	}
}