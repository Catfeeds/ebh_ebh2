<?php
/**
 * 充值记录主表 ebh_records表
 * @author Eker
 *
 */
class RecordModel extends CModel{
	/**
	 * 插入一条记录
	 * 
	 */
	public function add($param=array()){
		if(empty($param)){
			return false;
		}
		$data = array();
		if(!empty($param['uid'])){
			$data['uid'] = $param['uid'];
		}
		if(!empty($param['cate'])){
			$data['cate'] = $param['cate'];
		}
		if(!empty($param['dateline'])){
			$data['dateline'] = $param['dateline'];
		}
		if(!empty($param['status'])){
			$data['status'] = $param['status'];
		}
		return $this->db->insert('ebh_records',$data);
	}
	

	/**
	 * 更新记录
	 * 
	 */
	public function update($param,$rid){
		$setarr = array();
		if(isset($param['status'])){
			$setarr['status'] = $param['status'];
		}
		if(!empty($param['dateline'])){
			$setarr['dateline'] = $param['dateline'];
		}
		return $this->db->update("ebh_records",$setarr,array('rid'=>$rid));
	}
	
	/**
	 * 获取充值/提现记录
	 */
	public function getRecordList($param){
		if(!is_array($param) && !empty($param)){
			return false;
		}
		$sql = "select rid,uid,cate,dateline,status from ebh_records ";
		$wherearr = array();
		if(!empty($param['uid'])){
			$wherearr[] = " uid = ".$param['uid'];
		}
		if(isset($param['status'])){
			$wherearr[] = " status = ".$param['status'];
		}
		if(!empty($param['cate'])){
			$wherearr[] = " cate = ".$param['cate'];
		}
		if(!empty($wherearr)){
			$sql.= " WHERE ".implode(" AND ", $wherearr);
		}
		if(!empty($param['orderby'])){
			$sql.= " order by  ".$param['orderby'];
		}else{
			$sql.= " order by dateline desc ";
		}
		if(!empty($param['limit'])){
			$sql.= " LIMIT ".$param['limit'];
		}else{
			$sql.= " LIMIT 0,10 ";
		}
		//echo $sql;
		$list = $this->db->query($sql)->list_array();
		if(!empty($list)){
			foreach ($list as &$item){
				if($item['cate']==1){//充值
					$csql = "select * from ebh_charges where rid = {$item['rid']}";
				}elseif($item['cate']==2){//提现
					$csql = "select * from ebh_cashs where rid = {$item['rid']}";
				}
				$crow = $this->db->query($csql)->row_array();
				$item['info'] = $crow;
			}
		}
		
		return $list;
	}
	
	/**
	 * 获取充值/提现总数
	 * @param unknown $param
	 * 
	 */
	public function getRecordCount($param){
		if(!is_array($param) && !empty($param)){
			return false;
		}
		$sql = "select count(*) as count  from ebh_records ";
		$wherearr = array();
		if(!empty($param['uid'])){
			$wherearr[] = " uid = ".$param['uid'];
		}
		if(isset($param['status'])){
			$wherearr[] = " status = ".$param['status'];
		}
		if(!empty($param['cate'])){
			$wherearr[] = " cate = ".$param['cate'];
		}
		if(!empty($wherearr)){
			$sql.= " WHERE ".implode(" AND ", $wherearr);
		}

		$row = $this->db->query($sql)->row_array();
		
		return $row['count'];
	}


	/**
	 * 获取充值/提现记录
	 */
	public function getRecordChargeList($param){
		if(!is_array($param) && !empty($param)){
			return false;
		}
		$sql = "select c.curvalue,c.buyer_info,c.value,c.type,c.cardno,r.rid,r.uid,r.cate,r.dateline,r.status from ebh_records r left join ebh_charges c using(rid) ";
		$wherearr = array();
		if(!empty($param['uid'])){
			$wherearr[] = " r.uid = ".$param['uid'];
		}
		if(isset($param['status'])){
			$wherearr[] = " r.status = ".$param['status'];
		}
		if(!empty($param['type'])){
			$wherearr[] = " c.type = ".$param['type'];
		} else  {
			$wherearr[] = " c.type <> 12 ";
		}
		if (!empty($param['buyer_info'])){
			$wherearr[] = " c.buyer_info = ".$param['buyer_info'];
		} 
		$wherearr[] = " r.cate = 1";
		if(!empty($wherearr)){
			$sql.= " WHERE ".implode(" AND ", $wherearr);
		}
		if(!empty($param['orderby'])){
			$sql.= " order by  ".$param['orderby'];
		}else{
			$sql.= " order by r.dateline desc ";
		}
		if(!empty($param['limit'])){
			$sql.= " LIMIT ".$param['limit'];
		}else{
			$sql.= " LIMIT 0,10 ";
		}
		//echo $sql;
		$list = $this->db->query($sql)->list_array();
		
		return $list;
	}
	
	/**
	 * 获取充值/提现总数
	 * @param unknown $param
	 * 
	 */
	public function getRecordChargeCount($param){
		if(!is_array($param) && !empty($param)){
			return false;
		}
		$sql = "select count(1) as count from ebh_records r left join ebh_charges c using(rid) ";
		$wherearr = array();
		if(!empty($param['uid'])){
			$wherearr[] = " r.uid = ".$param['uid'];
		}
		if(!empty($param['type'])){
			$wherearr[] = " c.type = ".$param['type'];
		} else  {
			$wherearr[] = " c.type <> 12 ";
		}
		if (!empty($param['buyer_info'])){
			$wherearr[] = " c.buyer_info = ".$param['buyer_info'];
		} 
		if(isset($param['status'])){
			$wherearr[] = " r.status = ".$param['status'];
		}
		$wherearr[] = " r.cate = 1";
		if(!empty($wherearr)){
			$sql.= " WHERE ".implode(" AND ", $wherearr);
		}

		$row = $this->db->query($sql)->row_array();
		
		return $row['count'];
	}
}