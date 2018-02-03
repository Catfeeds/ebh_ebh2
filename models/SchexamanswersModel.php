<?php
/**
 *学校作业回答模型
 */
class SchexamanswersModel extends CModel{
	/**
	 *获取回答列表
	 */
	public function getAnswerList($param = array(),$fields = ''){
		if(empty($fields)){
			$sql = 'select * from ebh_schexamanswers sea';
		}else{
			$sql = 'select '.$fields.' from ebh_schexamanswers sea';
		}
		$wherearr = array();

		if(!empty($param['aid'])){
			$wherearr[] = ' sea.aid = '.$param['aid'];
		}

		if(!empty($param['eid'])){
			$wherearr[] = ' sea.eid = '.$param['eid'];
		}

		if(!empty($param['eid_in'])){
			$wherearr[] = ' sea.eid in ('.implode(',', $param['eid_in']).')';
		}
		if(!empty($param['uid'])){
			$wherearr[] = ' sea.uid = '.$param['uid'];
		}

		if(!empty($param['status'])){
			$wherearr[] = ' sea.status = '.$param['status'];
		}

		if(!empty($wherearr)){
			$sql.=' WHERE '.implode(' AND ', $wherearr);
		}

		if(!empty($param['order'])) {
			$sql .= ' ORDER BY '.$param['order'];
		} else {
			$sql .= ' ORDER BY sea.aid';
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