<?php
/**
 * 充值记录类,对应ebh_charges表
 * @author eker
 * 2016年3月1日13:51:17
 *
 */
class ChargeModel extends CModel{
	/**
	 *根据参数获取对应的charge列表 
	 *@param array $param
	 *@return array
	 */
	public function getList($param=array()){
		$sql = 'SELECT c.rid,c.chargeid,c.orderno,c.uid,c.toid,c.cardno,c.type,c.value,c.curvalue,c.status,c.fromip,c.signMsg,c.dateline,u.username FROM ebh_charges c left join ebh_users u on c.uid = u.uid ';
		$whereArr = array();
		if(!empty($param['begintime'])){
			$whereArr[] = ' c.dateline > '.strtotime($param['begintime']);
		}
		if(!empty($param['endtime'])){
			$whereArr[] = ' c.dateline < '.strtotime($param['endtime']);
		}
		if(!empty($param['searchkey'])){
			$whereArr[] = ' (u.username like \'%'.$this->db->escape_str($param['searchkey']).'%\' or c.value = '.intval($param['searchkey']).')';
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		if(!empty($param['order'])){
			$sql.=' order by '.$param['order'];
		}else{
			$sql.=' order by c.dateline desc ';
		}
		if(!empty($param['limit'])){
			$sql.= 'limit '.$param['limit'];
		}else{
			$sql.= 'limit 0,20'; 
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	 *根据参数获取对应的charge条数
	 *@param array $param
	 *@return int
	 */
	public function getListCount($param){
		$sql = 'SELECT count(*) count from ebh_charges c left join ebh_users u on c.uid = u.uid ';
		$whereArr = array();
		if(!empty($param['begintime'])){
			$whereArr[] = ' c.dateline > '.strtotime($param['begintime']);
		}
		if(!empty($param['endtime'])){
			$whereArr[] = ' c.dateline < '.strtotime($param['endtime']);
		}
		if(!empty($param['searchkey'])){
			$whereArr[] = ' (u.username like \'%'.$this->db->escape_str($param['searchkey']).'%\' or c.value = '.intval($param['searchkey']).')';
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		$res = $this->db->query($sql)->row_array();
		if($res!=false){
			return $res['count'];
		}else{
			return 0;
		}
	}
	
	/**
	 * 插入一条记录
	 * 
	 */
	public function add($param=array()){
		if(empty($param)){
			return false;
		}
		$data = array();
		if(!empty($param['rid'])){
			$data['rid'] = $param['rid'];
		}
		if(!empty($param['uid'])){
			$data['uid'] = $param['uid'];
		}
		if(!empty($param['useuid'])){
			$data['useuid'] = $param['useuid'];
		}
		if(!empty($param['cardno'])){
			$data['cardno'] = $param['cardno'];
		}
		if(!empty($param['type'])){
			$data['type'] = $param['type'];
		}
		if(!empty($param['value'])){
			$data['value'] = $param['value'];
		}
		if(!empty($param['curvalue'])){
			$data['curvalue'] = $param['curvalue'];
		}
		if(!empty($param['status'])){
			$data['status'] = $param['status'];
		}
		if(!empty($param['fromip'])){
			$data['fromip'] = $param['fromip'];
		}
		if(!empty($param['dateline'])){
			$data['dateline'] = $param['dateline'];
		}
		return $this->db->insert('ebh_charges',$data);
	}
}