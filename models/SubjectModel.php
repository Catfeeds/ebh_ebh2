<?php
/*
学科
*/
class SubjectModel extends CModel{
	/*
	学科列表
	@param array $param
	@return array
	*/
	public function getsubjectlist($param){
		$sql = 'select s.subjectid,s.subjectname,s.displayorder from ebh_subjects s ';
		if(isset($param['q']))
			$wherearr[] = ' s.subjectname like \'%'. $this->db->escape_str($param['q']) .'%\'';
		if(!empty($wherearr))
			$sql.=' where '.implode(' AND ',$wherearr);
		$sql.=' order by s.displayorder';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
	}
	/*
	学科数量
	@param array $param
	@return int
	*/
	public function getsubjectcount($param){
		$sql = 'select count(*) count from ebh_subjects s ';
		if(isset($param['q']))
			$wherearr[] = ' s.subjectname like \'%'. $this->db->escape_str($param['q']) .'%\'';
		if(!empty($wherearr))
			$sql.=' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	编辑
	@param array $param
	@return int
	*/
	
	public function editsubject($param){
		if(isset($param['displayorder']))
			$setarr['displayorder'] = $param['displayorder'];
		if(!empty($param['subjectname']))
			$setarr['subjectname'] = $param['subjectname'];
		$wherearr = array('subjectid'=>$param['subjectid']);
		return $this->db->update('ebh_subjects',$setarr,$wherearr);
	}
	/*
	添加
	@param array $param
	@return int
	*/
	public function addsubject($param){
		if(isset($param['displayorder']))
			$subjectarr['displayorder'] = $param['displayorder'];
		if(!empty($param['subjectname']))
			$subjectarr['subjectname'] = $param['subjectname'];
		$res = $this->db->insert('ebh_subjects',$subjectarr);
		return $res;
	}
	/*
	删除
	@param int $subjectid
	@return bool
	*/
	public function deletesubject($subjectid){
		$sql = 'delete s.* from ebh_subjects s where subjectid='.$subjectid;
		return $this->db->simple_query($sql);
	}
}

?>