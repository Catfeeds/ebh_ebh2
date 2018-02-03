<?php
class SchexamsModel extends CModel{
	/**
	 *获取学校作业列表
	 *
	 */
	public function getSchexamsList($param = array(),$fields =''){
		if(empty($fields)){
			$sql = 'select * from ebh_schexams se';
		}else{
			$sql = 'select '.$fields.' from ebh_schexams se';
		}
		$wherearr = array();

		if(!empty($param['crid'])){
			$wherearr[] = ' se.crid = '.$param['crid'];
		}

		if(!empty($param['folderid'])){
			$wherearr[] = ' se.folderid = '.$param['folderid'];
		}

		if(!empty($param['uid'])){
			$wherearr[] = ' se.uid = '.$param['uid'];
		}

		if(!empty($param['folderid'])){
			$wherearr[] = ' se.folderid = '.$param['folderid'];
		}

		if(!empty($param['cwid'])){
			$wherearr[] = ' se.cwid = '.$param['cwid'];
		}

		if(!empty($param['cwid_lt'])){
			$wherearr[] = ' se.cwid >0 ';
		}
		if(!empty($param['status'])){
			$wherearr[] = 'se.status in('.$param['status'].')';
		}

		if(!empty($wherearr)){
			$sql.=' WHERE '.implode(' AND ', $wherearr);
		}

		if(!empty($param['order'])) {
			$sql .= ' ORDER BY '.$param['order'];
		} else {
			$sql .= ' ORDER BY se.eid';
		}

		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
		} else{
			$sql .= ' limit 0,10 ';
		}

		return $this->db->query($sql)->list_array();
	}
}
?>