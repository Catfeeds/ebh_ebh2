<?php
/*
*	积分兑换的订单OrderModel层
*/
class OrderModel extends CModel{
	function insert($param) {
		$setarr = array();
		if(!empty($param ['oid'])){
			$setarr['oid'] = intval($param['oid']);
		}
		if(!empty($param ['uid'])){
			$setarr['uid'] = $param['uid'];
		}
		if(!empty($param ['name'])){
			$setarr['name'] = $param['name'];
		}
		if(!empty($param ['address'])){
			$setarr['address'] = $param['address'];
		}
		if(!empty($param ['postcode'])){
			$setarr['postcode'] = $param['postcode'];
		}
		if(!empty($param ['pid'])){
			$setarr['pid'] = $param['pid'];
		}
		if(!empty($param ['dateline'])){
			$setarr['dateline'] = $param['dateline'];
		}
		if(!empty($param ['status'])){
			$setarr['status'] = $param['status'];
		}
		if(isset($param ['type'])){
			$setarr['type'] = $param['type'];
		}
		if(isset($param ['phone'])){
			$setarr['phone'] = $param['phone'];
		}
		if(isset($param ['expressNo'])){
			$setarr['expressNo'] = $param['expressNo'];
		}
		if(isset($param ['expressname'])){
			$setarr['expressname'] = $param['expressname'];
		}
		$oid = $this->db->insert('ebh_orders',$setarr);
		return $oid;
	}
}
?>