<?php
/*
云平台留言
*/
class CloudnoteModel extends CModel{
	/*
	留言列表
	@param array $param 
	@return array 列表数组
	*/
	public function getcloudnotelist($param){
		$sql = 'select c.* from ebh_cloudnotes c ';
		
		if(!empty($param['q']))
			$wherearr[] =  ' ( c.realname like \'%'. $this->db->escape_str($param['q']) .'%\' or c.message like \'%' . $this->db->escape_str($param['q']).'%\')';
		if(strlen($param['status'])>0){
			$wherearr[] = 'c.status='.intval($param['status']);
		}
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$sql.=' order by noteid desc';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		
		return $this->db->query($sql)->list_array();
	}
	/*
	留言总数
	@param array $param 
	@return int
	*/
	public function getcloudnotecount($param){
		$sql = 'select count(*) count from ebh_cloudnotes c';
		if(!empty($param['q']))
			$wherearr[] =  ' ( c.realname like \'%'. $this->db->escape_str($param['q']) .'%\' or c.message like \'%' . $this->db->escape_str($param['q']).'%\')';
		if(strlen($param['status'])>0){
			$wherearr[] = 'c.status='.intval($param['status']);
		}
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
			//return $sql;
			//return $sql;
		$count = $this->db->query($sql)->row_array();
		
		return $count['count'];
	}
	/*
	编辑留言
	@param array $param
	@return int
	*/
	public function editcloudnote($param){
		
		if(isset($param['status'])){
			$setarr['status'] = $param['status'];
			$setarr['verifydateline'] = time();
		}
		$wherearr = array('noteid'=>$param['noteid']);
		//return $setarr;
		$row = $this->db->update('ebh_cloudnotes',$setarr,$wherearr);
		return $row;
	}
	/**
	 *根据noteid获取单条的留言信息
	 *@author zkq
	 *@param int $noteid
	 *@return array (一维数组)
	 */
	public function getOne($noteid=0){
		$sql = 'select c.* from ebh_cloudnotes c where c.noteid='.$noteid.' limit 1';
		return  $this->db->query($sql)->row_array();
	}
}