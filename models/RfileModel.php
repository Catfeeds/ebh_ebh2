<?php
/*
文件
*/
class RfileModel extends CModel{
	/*
	文件列表
	@param array $param
	@return array
	*/
	public function getrfilelist($param){
		$sql = 'select r.rid,r.title,r.downnum,u.realname,c.name,r.dateline ,r.status,r.top,r.best,r.hot
			from ebh_rfiles r 
			left join ebh_users u on u.uid = r.uid 
			left join ebh_categories c on c.catid = r.catid';
		if(!empty($param['q']))
			$wherearr[] = ' (r.title like \'%'. $this->db->escape_str($param['q']) .'%\' or u.realname like \'%' . $this->db->escape_str($param['q']).'%\')';
		if(!empty($wherearr))
			$sql.= ' where ' . implode(' AND ',$wherearr);
		$sql.=' order by rid desc';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
		
	}
	/*
	文件数量
	@param array $param
	@return int
	*/
	public function getrfilecount($param){
		$sql = 'select count(*) count from ebh_rfiles r left join ebh_users u on u.uid = r.uid';
		if(!empty($param['q']))
			$wherearr[] = ' (r.title like \'%'. $this->db->escape_str($param['q']) .'%\' or u.realname like \'%' . $this->db->escape_str($param['q']).'%\')';
		if(!empty($wherearr))
			$sql.= ' where ' . implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	编辑
	@param array $param
	@return int
	*/
	public function editrfile($param){
		if(isset($param['status']))
			$setarr['status'] = $param['status'];
		if(isset($param['top']))
			$setarr['top'] = $param['top'];
		if(isset($param['hot']))
			$setarr['hot'] = $param['hot'];
		if(isset($param['best']))
			$setarr['best'] = $param['best'];
		if(isset($param['displayorder']))
			$setarr['displayorder'] = $param['displayorder'];
		if(!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
		if(!empty($param['tag']))
			$setarr['tag'] = $param['tag'];
		if(!empty($param['summary']))
			$setarr['summary'] = $param['summary'];
		if(!empty($param['title']))
			$setarr['title'] = $param['title'];
		if(isset($param['catid']))
			$setarr['catid'] = $param['catid'];
		$wherearr = array('rid'=>$param['rid']);
		$row = $this->db->update('ebh_rfiles',$setarr,$wherearr);
		return $row;
	}
	/*
	删除
	@param int $rid
	@return bool
	*/
	public function deleterfile($rid){
		$sql = 'delete r.* from ebh_rfiles r where r.rid ='.$rid;
		return $this->db->simple_query($sql);
	}
	/*
	添加
	@param array $param
	@return int
	*/
	public function addrfile($param){
		$param['status'] = 1;
		$param['dateline'] = time();
		$res = $this->db->insert('ebh_rfiles',$param);
		return $res;
	}
	/*
	详情
	@param int $rid
	@return array
	*/
	public function getrfiledetail($rid){
		$sql = 'select r.rid,r.title,u.username,u.uid,r.tag,r.summary,r.catid,c.name,r.hot,r.top,r.best,r.displayorder 
			from ebh_rfiles r 
			left join ebh_users u on r.uid=u.uid
			left join ebh_categories c on c.catid = r.catid
			where rid='.$rid;
		return $this->db->query($sql)->row_array();
	}
}
?>