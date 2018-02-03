<?php
/*
内部用户
*/
class StaffModel extends CModel{
	/*
	内部用户列表
	@param array $param
	@return array
	*/
	public function getstafflist($param){
		$sql = 'SELECT u.uid,u.username,u.lastlogintime,u.logincount,u.status,g.type,u.groupid FROM ebh_users u join ebh_groups g on u.groupid = g.groupid ';
		$wherearr[]=' g.type=\'staff\'';
		if(!empty($param['q']))
			$wherearr[] = ' (u.realname like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$sql.=' order by dateline desc';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
	}
	/*
	内部用户数量
	@param array $param
	@return int
	*/
	public function getstaffcount($param){
		$sql = 'select count(*) count FROM ebh_users u join ebh_groups g on u.groupid = g.groupid ';
		$wherearr[]='g.type=\'staff\'';
		if(!empty($param['q']))
			$wherearr[]='(u.realname like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']).'%\')';
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	获取组列表
	@return array
	*/
	public function getgrouplist(){
		$sql = 'select g.groupname,g.groupid from ebh_groups g where type=\'staff\'';
		return $this->db->query($sql)->list_array();
	}
	/*
	修改用户
	@param array $param
	@return int
	*/
	public function editstaff($param){
		if(!empty($param['password']))
			$setarr['password'] = md5($param['password']);
		if(isset($param['groupid']))
			$setarr['groupid'] = $param['groupid'];
		if(isset($param['status']))
			$setarr['status'] = $param['status'];
		$wherearr = array('uid'=>$param['uid']);
		//return $setarr;
		$row = $this->db->update('ebh_users',$setarr,$wherearr);
		return $row;
	}
	/*
	添加用户
	@param array $param
	@return int
	*/
	public function addstaff($param){
		$userarr['username'] = $param['username'];
		$userarr['password'] = md5($param['password']);
		$userarr['groupid'] = $param['groupid'];
		$userarr['status'] = $param['status'];
		$userarr['dateline'] = SYSTIME;
		$row = $this->db->insert('ebh_users',$userarr);
		return $row;
	}
}
?>