<?php
/*
教室课件
*/
class ClassroomcourseModel extends CModel{
	/*
	教室课件列表
	@param array $param 
	@return array 列表数组
	*/
	public function getclassroomcourselist($param){
		$wherearr = array();
		$sql = 'select c.cwid,c.title,c.cwurl,c.cwname,c.cwsource,u.username,c.displayorder,u.realname,c.dateline,c.status,c.viewnum,cr.crname,f.foldername from ebh_roomcourses r join ebh_coursewares c on r.cwid=c.cwid  join ebh_users u on c.uid=u.uid left join ebh_classrooms cr on cr.crid=r.crid left join ebh_folders f on f.folderid=r.folderid';
		if(!empty($param['q']))
			$wherearr[] = ' (c.title like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(strlen($param['status'])>0){
			$wherearr[] = ' c.status ='.intval($param['status']);
		}
		if(!empty($param['crid'])){
			$wherearr[] = ' r.crid='.intval($param['crid']);
		}
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$sql.=' order by r.crid,r.cwid desc';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
	}
	/*
	教室课件总数
	@param array $param 
	@return int
	*/
	public function getclassroomcoursecount($param){
		$wherearr = array();
		$sql = 'select count(*) count from ebh_roomcourses r join ebh_coursewares c on r.cwid=c.cwid join ebh_users u on c.uid=u.uid';
		if(!empty($param['q']))
			$wherearr[] = ' (c.title like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(strlen($param['status'])>0){
			$wherearr[] = ' c.status ='.intval($param['status']);
		}
		if(!empty($param['crid'])){
			$wherearr[] = ' r.crid='.intval($param['crid']);
		}
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	删除
	@param int $cwid
	@return bool
	*/
	public function deleteclassroomcourse($cwid){
		$sql = 'delete c.*,r.* from ebh_coursewares c,ebh_roomcourses r where c.cwid = '.$cwid.' and r.cwid = '.$cwid;
		
		return $this->db->simple_query($sql);
	}
	/*
	编辑
	@param array $param 
	@return int
	*/
	public function editclassroomcourse($param){
		if(isset($param['status']))
			$setarr['status'] = $param['status'];
		$wherearr = array('cwid'=>$param['cwid']);
		$row = $this->db->update('ebh_coursewares',$setarr,$wherearr);
		return $row;
	}
}
?>