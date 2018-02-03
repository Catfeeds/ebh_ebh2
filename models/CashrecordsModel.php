<?php
/**
 * 申请提现模型类
 */
class CashrecordsModel extends CModel { 
	//提现申请记录列表
	public function getCashRecordsList($param) {
		$sql = 'select c.value, c.curvalue, c.applytype, c.status, c.dateline, a.desc from ebh_cashrecords c left join ebh_applycash a on a.cid = c.tocid';
		$where = array();
		if(!empty($param['uid'])){
			$where[] = 'c.uid = '.$param['uid'];
		}
		if(!empty($param['cids'])){
			$where[] = 'c.cid in ('.implode(',',$param['cids']).')';
		}
		if(isset($param['status'])){
			$where[] = 'c.status = '.$param['status'];
		}
		if(!empty($where)){
			$sql .= ' where ' . implode(' AND ', $where);
		}
		$sql.=' order by c.dateline desc,c.tocid desc';
		if (!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		$rows =  $this->db->query($sql)->list_array();
		return $rows;
	}
	//提现申请记录数目
	public function getCashRecordsCount($param) {
		$sql = 'select count(*) count from ebh_cashrecords c';
		$where = array();
		if(!empty($param['uid'])){
			$where[] = 'c.uid = '.$param['uid'];
		}
		if(!empty($param['cids'])){
			$where[] = 'c.cid in ('.implode(',',$param['cids']).')';
		}
		if(isset($param['status'])){
			$where[] = 'c.status = '.$param['status'];
		}
		if(!empty($where)){
			$sql.=' where ' . implode(' AND ', $where);
		}
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	//提现申请逻辑
	public function applayCash($param){
		$sql_1 = "insert into `ebh_applycash` (`uid`,`username`,`realname`,`applytype`,`recaccount`,`recbank`,`recname`,`recbprovince`,`recbcity`,`recsubbank`,`desc`,`applyvalue`,`applytime`,`paystatus`) values ";
		$sql_1 .= "(".$param['uid'].",".$this->db->escape($param['username']).",".$this->db->escape($param['realname']).",".$param['applytype'].",".$this->db->escape($param['recaccount']);
		$sql_1 .= ",".$this->db->escape($param['recbank']).",".$this->db->escape($param['recname']).",".$this->db->escape($param['recbprovince']).",".$this->db->escape($param['recbcity']);
		$sql_1 .= ",".$this->db->escape($param['recsubbank']).",".$this->db->escape($param['desc']).",".$param['applyvalue'].",".$param['dateline'].",".$param['paystatus'].")";
		$sql_3 = "update ebh_users set balance = balance - ".($param['applyvalue'] + $param['hfee'])." where uid = ".$param['uid'];
		//事务开始
		$this->db->begin_trans();
		$res1 = $this->db->query($sql_1);
		$res3 = $this->db->query($sql_3);
		//执行完上述事务再插入一条关联记录
		$sql = "select max(cid) maxcid from `ebh_applycash`";
		$ret = $this->db->query($sql)->row_array();
		$tocid = $ret['maxcid'];
		
		$sql_2 = "insert into ebh_cashrecords (`uid`,`status`,`value`,`curvalue`,`applytype`,`fromip`,`dateline`,`tocid`) values ";
		$sql_2 .= "(".$param['uid'].",".$param['paystatus'].",".$param['applyvalue'].",".$param['curvalue'].",".$param['applytype'];
		$sql_2 .= ",".$this->db->escape($param['fromip']).",".$param['dateline'].",".$tocid.")";
		$result2 = $this->db->query($sql_2);
		$trans = $this->db->trans_status();
		if($trans){//根据事务执行状态，来进行提交或回滚
			$this->db->commit_trans();
		}else{
			$this->db->rollback_trans();
		}
		return $trans;
	}
}