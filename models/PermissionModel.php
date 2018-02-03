<?php
/*
权限
*/
class PermissionModel extends CModel{
/*
用户组列表
*/
	public function getgrouplist($param){
		$sql = 'select g.groupid,g.groupname,g.upid,g.type from ebh_groups g ';
		if(!empty($param['q']))
			$wherearr[] = ' (g.groupname like \'%'. $this->db->escape_str($param['q']) .'%\' or g.type like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$sql.= ' order by type';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		return $this->db->query($sql)->list_array();
	}
	/*
	用户组数量
	*/
	public function getgroupcount($param){
		$sql = 'select count(*) count FROM ebh_groups g ';
		if(!empty($param['q']))
			$wherearr[] = ' (g.groupname like \'%'. $this->db->escape_str($param['q']) .'%\' or g.type like \'%' . $this->db->escape_str($param['q']) .'%\')';
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	添加用户组
	*/
	public function addgroup($param){
		$grouparr['upid'] = $param['groupid'];
		$grouparr['groupname'] = $param['groupname'];
		$grouparr['type'] = $param['type'];
		return $this->db->insert('ebh_groups',$grouparr);
	}
	/*
	编辑用户组
	*/
	public function editgroup($param){
		//if(!empty($param['upid']))
		//	$setarr['upid'] = $param['upid'];
		if(!empty($param['groupname']))
			$setarr['groupname'] = $param['groupname'];
		$wherearr = array('groupid'=>$param['groupid']);
		return $this->db->update('ebh_groups',$setarr,$wherearr);
	}
	/*
	删除用户组
	*/
	public function deletegroup($groupid){
		$sql = 'delete g.* from ebh_groups g where groupid='.$groupid;
		return $this->db->simple_query($sql);
	}
	/*
	获取用户组
	@param int $groupid
	@return string
	*/
	public function getgrouptype($groupid){
		$sql = 'select g.type from ebh_groups g where groupid='.$groupid;
		$res = $this->db->query($sql)->row_array();
		return $res['type'];
	}
	/*
	模块列表
	*/
	public function getpermissionlist($param){
		if($param['type']=='staff'){
			$sql = 'SELECT mg.*,p.opvalue popvalue FROM (
			SELECT m.upid,m.name,m.opvalue,m.moduleid,m.displayorder,g.groupid,g.type,g.groupname
			FROM ebh_modules m,ebh_groups g) mg 
			LEFT JOIN ebh_permissions p 
			ON (mg.moduleid = p.moduleid OR p.moduleid IS NULL ) AND (mg.groupid = p.groupid OR p.groupid IS NULL) 
			WHERE mg.groupid IN ('.$param['groupid'].') 
			ORDER BY mg.upid,mg.displayorder 
			LIMIT 0,1000';
			$idtype = 'moduleid';
		}
		else{
			$sql = 'SELECT mg.*,p.opvalue popvalue FROM (
			SELECT m.upid,m.catid,m.code,m.displayorder, m.ischannel,m.name,m.position,m.visible,m.opvalue,g.groupid,g.type,g.groupname 
			FROM ebh_categories m,ebh_groups g) mg 
			LEFT JOIN ebh_permissions p 
			ON (mg.catid = p.moduleid OR p.moduleid IS NULL ) AND (mg.groupid = p.groupid OR p.groupid IS NULL) 
			WHERE mg.groupid IN ('.$param['groupid'].') 
			ORDER BY mg.upid,mg.displayorder 
			LIMIT 0,1000';
			$idtype = 'catid';
		}
		$resarr = $this->db->query($sql)->list_array();
		$rescount = count($resarr);
		//var_dump($resarr);
		return $this->getTree($resarr,$idtype);
		return $resarr;
	}
	function getTree($arr = array(),$idtype,$upid=0,$index=0){
    $tree = array();
    foreach ($arr as $value) {

          if($value['upid']==$upid){
               $value['name'] = str_repeat('┣━ ', $index).$value['name'];
               $tree[] = $value;
               $tree = array_merge($tree,$this->getTree($arr,$idtype,$value[$idtype],$index+1));
          }
    }
     return $tree;
}
	/*
	操作列表
	*/
	public function getoperationlist($type){
		if($type=='staff')
			$sql = 'select o.opid,o.opname from ebh_operations o where position in(2,3)';
		else
			$sql = 'select o.opid,o.opname from ebh_operations o where position in(1,3)';
		//var_dump($sql);
		return $this->db->query($sql)->list_array();
	}
	
	public function editpermission($param,$groupid){
		$keys = array_keys($param);
		//$values = array_keys($param);
		// var_dump($param);
		foreach($keys as $key){
			$valuearr = array('opvalue'=>array_sum($param[$key]));
			$wherearr = array('moduleid'=>$key,'groupid'=>$groupid);
			$sql = 'select * from ebh_permissions where moduleid='.$wherearr['moduleid'].' and groupid='.$wherearr['groupid'];
			$permission = $this->db->query($sql)->row_array();
			if(empty($permission)){
				$insertarr = array('opvalue'=>array_sum($param[$key]),'moduleid'=>$key,'groupid'=>$groupid);
				$res = $this->db->insert('ebh_permissions',$insertarr);
			}else{
				$res = $this->db->update('ebh_permissions',$valuearr,$wherearr);
			}
			return $res;
		}
	}
	
	public function haspermission($param){
		$sql = 'select p.opvalue from ebh_permissions p join ebh_modules m on p.moduleid=m.moduleid where m.identifier like \''.$param['controller'].'%\' and groupid='.$param['groupid'].' limit 1';
		$permissions = $this->db->query($sql)->row_array();
		return $permissions['opvalue'];
	}
	
}

?>