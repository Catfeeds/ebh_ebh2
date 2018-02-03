<?php
/*
教师服务项订单
*/
class PaytorderModel extends CModel{
	/**
	*生成订单信息
	*/
	public function addOrder($param = array()) {
		if(empty($param))
			return false;
		$setarr = array();
		if(!empty($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(!empty($param['ordername']))
			$setarr['ordername'] = $param['ordername'];
		if(!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
		if(!empty($param['paytime']))
			$setarr['paytime'] = $param['paytime'];
		if(!empty($param['dateline']))
			$setarr['dateline'] = $param['dateline'];
		if(!empty($param['payfrom']))
			$setarr['payfrom'] = $param['payfrom'];
		if(!empty($param['totalfee']))
			$setarr['totalfee'] = $param['totalfee'];
		if(!empty($param['ip']))
			$setarr['ip'] = $param['ip'];
		if(!empty($param['payip']))
			$setarr['payip'] = $param['payip'];
		if(!empty($param['paycode']))
			$setarr['paycode'] = $param['paycode'];
		if(!empty($param['remark']))
			$setarr['remark'] = $param['remark'];
		if(!empty($param['ordernumber']))
			$setarr['ordernumber'] = $param['ordernumber'];
		if(!empty($param['buyer_id']))
			$setarr['buyer_id'] = $param['buyer_id'];
		if(!empty($param['buyer_info']))
			$setarr['buyer_info'] = $param['buyer_info'];
		if(!empty($param['status']))
			$setarr['status'] = $param['status'];
		if(!empty($param['dateline']))
			$setarr['dateline'] = $param['dateline'];
		if(!empty($param['refunded']))
			$setarr['refunded'] = $param['refunded'];
		if(!empty($param['out_trade_no']))
			$setarr['out_trade_no'] = $param['out_trade_no'];
		if(isset($param['invalid']))
			$setarr['invalid'] = $param['invalid'];
		if(isset($param['itype']))
			$setarr['itype'] = $param['itype'];
		if(isset($param['isbatchrefund']))
			$setarr['isbatchrefund'] = $param['isbatchrefund'];
		if(isset($param['redeemcode']))
			$setarr['redeemcode'] = $param['redeemcode'];
		if(isset($param['batchid']))
			$setarr['batchid'] = $param['batchid'];
		if(isset($param['ptype']))
			$setarr['ptype'] = $param['ptype'];
		$orderid = $this->db->insert('ebh_pay_torders',$setarr);
		return $orderid;
	}
	
	/**
	*更新订单信息，如果包含明细，则同时更新明细信息
	*/
	public function updateOrder($param = array()) {
		if(empty($param) || empty($param['orderid']))
			return false;
		$setarr = array();
		$wherearr = array('orderid'=>$param['orderid']);
		if(!empty($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(!empty($param['ordername']))
			$setarr['ordername'] = $param['ordername'];
		if(!empty($param['paytime']))
			$setarr['paytime'] = $param['paytime'];
		if(!empty($param['payfrom']))
			$setarr['payfrom'] = $param['payfrom'];
		if(!empty($param['totalfee']))
			$setarr['totalfee'] = $param['totalfee'];
		if(!empty($param['ip']))
			$setarr['ip'] = $param['ip'];
		if(!empty($param['payip']))
			$setarr['payip'] = $param['payip'];
		if(!empty($param['paycode']))
			$setarr['paycode'] = $param['paycode'];
		if(!empty($param['remark']))
			$setarr['remark'] = $param['remark'];
		if(!empty($param['ordernumber']))
			$setarr['ordernumber'] = $param['ordernumber'];
		if(!empty($param['buyer_id']))
			$setarr['buyer_id'] = $param['buyer_id'];
		if(!empty($param['buyer_info']))
			$setarr['buyer_info'] = $param['buyer_info'];
		if(isset($param['status']))
			$setarr['status'] = $param['status'];
		if(!empty($param['refunded']))
			$setarr['refunded'] = $param['refunded'];
		if(isset($param['invalid']))
			$setarr['invalid'] = $param['invalid'];
		$afrows = $this->db->update('ebh_pay_torders',$setarr,$wherearr);
		return $afrows;
	}
	/**
	 * 获取教师服务项订单列表
	 * @param unknown $param
	 */
	public function getOrderList($param){
		$sql = 'select o.orderid,o.ordername,o.payfrom,o.paytime,o.refunded,o.dateline,o.totalfee,o.ordernumber,o.remark,cr.crname,u.username,u.realname,o.status from ebh_pay_torders o left join ebh_classrooms cr on o.crid=cr.crid left join ebh_users u on u.uid=o.uid ';
		$wherearr = array();
		
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(o.ordername like \'%'.$q.'%\' or u.username like \'%'.$q.'%\' )';
		}
		if(!empty($param['crid'])) {
			$wherearr[] = 'o.crid='.$param['crid'];
		}
		if(isset($param['status'])) {
			$wherearr[] = 'o.status='.$param['status'];
		}
		if(isset($param['payfrom'])) {
			$wherearr[] = 'o.payfrom='.$param['payfrom'];
		}
		if(!empty($param['uid'])){
			$wherearr[] = 'o.uid='.$param['uid'];
 		}
 		if(isset($param['isbatchrefund'])) {
			$wherearr[] = 'o.isbatchrefund='.$param['isbatchrefund'];
		}
		if(!empty($param['ptype'])) {
			if ($param['ptype']==2) {
				$wherearr[] = 'o.ptype>=2';
			} else {
				$wherearr[] = 'o.ptype='.$param['ptype'];
			}
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY orderid desc';
        }
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 获取教师服务项订单数目
	 * @param unknown $param
	 */
	public function getOrderCount($param){
		$count = 0;
		$sql = 'select count(*) count from ebh_pay_torders o left join ebh_users u on o.uid = u.uid left join ebh_classrooms cr on o.crid = cr.crid ';
		$wherearr = array();
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(o.ordername like \'%'.$q.'%\' or u.username like \'%'.$q.'%\' )';
		}
		if(isset($param['isbatchrefund'])) {
			$wherearr[] = 'o.isbatchrefund='.$param['isbatchrefund'];
		}
		if(!empty($param['ptype'])) {
			if ($param['ptype']==2) {
				$wherearr[] = 'o.ptype>=2';
			} else {
				$wherearr[] = 'o.ptype='.$param['ptype'];
			}
		}
		if(!empty($param['crid'])) {
			$wherearr[] = 'o.crid='.$param['crid'];
		}
		if(isset($param['status'])) {
			$wherearr[] = 'o.status='.$param['status'];
		}
		if(isset($param['payfrom'])) {
			$wherearr[] = 'o.payfrom='.$param['payfrom'];
		}
		if(!empty($param['uid'])){
			$wherearr[] = 'o.uid='.$param['uid'];
 		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$res = $this->db->query($sql)->row_array();
		if(!empty($res))
			$count = $res['count'];
		return $count;
	}
	//获取订单详情
	public function getOrderDetailById($orderid) {
		$orderid = intval($orderid);
		if ($orderid <=0 ) {
			return false;
		}
		$sql = "select u.username,u.realname,cr.crname,o.refunded,o.invalid,o.orderid,o.ordername,o.crid,o.uid,o.dateline,o.paytime,o.payfrom,o.totalfee,o.ip,o.payip,o.paycode,o.ordernumber,o.remark,o.status from ebh_pay_torders o 
				left join ebh_users u on o.uid = u.uid  
				left join ebh_classrooms cr on cr.crid= o.crid where o.orderid=$orderid";
		$myorder = $this->db->query($sql)->row_array();
		return $myorder;
	}
	//根据商户订单号获取订单详情
	public function getOrderByOutTradeNo($out_trade_no){
		$sql = "select u.username,u.realname,cr.crname,o.itype,o.isbatchrefund,o.batchid,o.ptype,o.refunded,o.invalid,o.orderid,o.ordername,o.crid,o.uid,o.dateline,o.paytime,o.payfrom,o.totalfee,o.ip,o.payip,o.paycode,o.ordernumber,o.remark,o.status from ebh_pay_torders o
				left join ebh_users u on o.uid = u.uid
				left join ebh_classrooms cr on cr.crid= o.crid where o.out_trade_no='".$this->db->escape_str($out_trade_no)."'";
		$myorder = $this->db->query($sql)->row_array();
		return $myorder;
	}
}