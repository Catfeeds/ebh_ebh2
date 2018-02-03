<?php
class TeachingplanModel extends CModel{
	/*
	添加教案
	@param array $param
	*/
	public function addTeachingplan($param){
		if(empty($param['uid']) || empty($param['crid']))
			return false;
		$tarr['uid'] = $param['uid'];
		$tarr['crid'] = $param['crid'];
		if(!empty($param['title']))
			$tarr['title'] = $param['title'];
		if(!empty($param['content']))
			$tarr['content'] = $param['content'];
		if(!empty($param['dateline']))
			$tarr['dateline'] = $param['dateline'];
		else
			$tarr['dateline'] = SYSTIME;
		return $this->db->insert('ebh_teachingplans',$tarr);
	}
	/*
	教案列表
	*/
	public function getTeachingplanList($param){
		$sql = 'select t.tpid,t.title,t.content,t.dateline 
				from ebh_teachingplans t';
		$wherearr = array();
		$wherearr[]= ' t.uid='.$param['uid'];
		$wherearr[]= ' t.crid='.$param['crid'];
		if(!empty($param['q']))
			$wherearr[]= ' t.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		else
			$sql.= ' order by t.tpid desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		// echo $sql;
		return $this->db->query($sql)->list_array();
	}
	/*
	修改教案
	*/
	public function editTeachingplan($param){
		if(empty($param['uid']) || empty($param['crid']) || empty($param['tpid']))
			return false;
		if(!empty($param['title']))
			$tarr['title'] = $param['title'];
		if(!empty($param['content']))
			$tarr['content'] = $param['content'];
		$wherearr['crid'] = $param['crid'];
		$wherearr['uid'] = $param['uid'];
		$wherearr['tpid'] = $param['tpid'];
		return $this->db->update('ebh_teachingplans',$tarr,$wherearr);
	}
	/*
	教案数量
	*/
	public function getTeachingplanCount($param){
		$sql = 'select count(*) count from ebh_teachingplans t';
		$wherearr = array();
		$wherearr[]= ' t.uid='.$param['uid'];
		$wherearr[]= ' t.crid='.$param['crid'];
		if(!empty($param['q']))
			$wherearr[]= ' t.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	/*
	教案详情
	*/
	public function getTeachingplanDetail($param){
		$sql = 'select t.tpid,t.title,t.content,t.dateline from ebh_teachingplans t
			where t.uid='.$param['uid'].' and t.crid='.$param['crid'].' and t.tpid='.$param['tpid'];
		return $this->db->query($sql)->row_array();
		
	}
	
	/*
	教案的附件列表
	*/
	public function getTeachingplanAttachList($param){
		if(empty($param['uid']) || empty($param['tpid']))
			return false;
		$sql = 'select a.attid,a.name,a.url,a.dateline from ebh_teachingplanatts a ';
		$wherearr = array();
		$wherearr[]= 'a.uid='.$param['uid'];
		$wherearr[]= 'a.tpid='.$param['tpid'];
		if(!empty($param['attid']))
			$wherearr[]= 'a.attid='.$param['attid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		else
			$sql.= ' order by a.attid desc';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	删除附件
	*/
	public function deleteTeachingplanAttach($param){
		if(empty($param['uid']) || empty($param['tpid']) ||empty($param['attid']))
			return false;
		$wherearr['uid'] = $param['uid'];
		$wherearr['tpid'] = $param['tpid'];
		$wherearr['attid'] = $param['attid'];
		return $this->db->delete('ebh_teachingplanatts',$wherearr);
	}
	/*
	删除教案
	*/
	
	public function deleteTeachingplan($param){
		if(empty($param['uid']) || empty($param['tpid']) || empty($param['crid']))
			return false;
		$this->db->begin_trans();
		$wherearr['uid'] = $param['uid'];
		$wherearr['tpid'] = $param['tpid'];
		$wherearr['crid'] = $param['crid'];
		$this->db->delete('ebh_teachingplans',$wherearr);
		unset($wherearr['crid']);
		$this->db->delete('ebh_teachingplanatts',$wherearr);
		if($this->db->trans_status()===FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
        return TRUE;
	}
	
	public function addTeachingplanAttach($param){
		if(empty($param['tpid']) || empty($param['uid']))
			return false;
		$attarr['tpid'] = $param['tpid'];
		$attarr['uid'] = $param['uid'];
		if(!empty($param['name']))
			$attarr['name'] = $param['name'];
		if(!empty($param['url']))
			$attarr['url'] = $param['url'];
		
		$attarr['dateline'] = SYSTIME;
		return $this->db->insert('ebh_teachingplanatts',$attarr);
	}
}
?>