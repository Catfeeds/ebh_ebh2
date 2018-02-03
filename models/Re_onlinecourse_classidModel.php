<?php
class Re_onlinecourse_classidModel extends CModel{
	
	public function getList($param = array()){
		$sql = 'select roc.* from ebh_re_onlinecourses_classid roc ';
		$whereArr = array();
		if(!empty($param['oid'])){
			$whereArr[] = 'roc.oid = '.intval($param['oid']);
		}

		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ', $whereArr);
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$parm['limit'];
		}else{
			$sql.=' limit 200';
		}
		return $this->db->query($sql)->list_array();
	}

	public function _insert($param = array()){
		if(empty($param)){
			return 0;
		}else{
			return $this->db->insert('ebh_re_onlinecourses_classid',$param);
		}
	}

	/**
	 *删除一条数据
	 *@param int $id 或者 array $id
	 *@return int 影响的行数
	 */
	public function _delete($id){
		if(empty($aid)){
			return 0;
		}
		if(is_numeric($id)){
			$where = array('id'=>$id);
		}else{
			$where = ' id in '.$id;
		}
		
		return $this->db->delete('ebh_re_onlinecourses_classid',$where);
	}

	public function delByOid($oid = 0){
		if(empty($oid)){
			return 0;
		}
		return $this->db->delete('ebh_re_onlinecourses_classid',array('oid'=>intval($oid))); 
	}
}