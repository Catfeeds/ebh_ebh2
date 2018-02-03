<?php
/*
年级
*/
class GradeModel extends CModel{
	/*
	年级列表
	@param array $param
	@return array 列表数组
	*/
	public function getgradelist($param){
		$sql = 'select g.gradeid,g.gradename,g.displayorder from ebh_grades g ';
		if(isset($param['q']))
			$wherearr[] = ' g.gradename like \'%'. $this->db->escape_str($param['q']) .'%\'';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.=' order by g.displayorder';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
	}
	/*
	年级数量
	@param array $param
	@return int
	*/
	public function getgradecount($param){
		$sql = 'select count(*) count from ebh_grades g ';
		if(isset($param['q']))
			$wherearr[] = ' g.gradename like \'%'. $this->db->escape_str($param['q']) .'%\'';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	删除年级
	@param int $gradeid
	@return bool
	*/
	public function deletegrade($gradeid){
		$sql = 'delete g.* from ebh_grades g where gradeid='.$gradeid;
		return $this->db->simple_query($sql);
	}
	/*
	编辑年级
	@param array $param
	@return int 
	*/
	public function editgrade($param){
		if(isset($param['displayorder']))
			$setarr['displayorder'] = $param['displayorder'];
		if(!empty($param['gradename']))
			$setarr['gradename'] = $param['gradename'];
		$wherearr = array('gradeid'=>$param['gradeid']);
		return $this->db->update('ebh_grades',$setarr,$wherearr);
	}
	/*
	添加年级
	@param array $param
	@return int 
	*/
	public function addgrade($param){
		if(isset($param['displayorder']))
			$gradearr['displayorder'] = $param['displayorder'];
		if(!empty($param['gradename']))
			$gradearr['gradename'] = $param['gradename'];
		$res = $this->db->insert('ebh_grades',$gradearr);
		return $res;
	}
}

?>