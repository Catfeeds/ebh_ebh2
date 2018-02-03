<?php
/**
 *教师分组模型
 */
class TgroupsModel extends CModel{
	/**
	 *获取分组列表
	 */
	public function getList($param = array()){
		$sql = 'select t.groupid,t.upid,t.groupname,t.crid,t.uid,t.displayorder,t.summary from ebh_tgroups t';
		$wherearr = array();
		if(!empty($param['crid'])){
			$wherearr[] = 't.crid='.$param['crid'];
		}
		if(!empty($param['upid'])){
			$wherearr[] = 't.upid='.$param['upid'];
		}
		if(!empty($param['uid'])){
			$wherearr[] = 't.uid='.$param['uid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		if(!empty($param['order'])){
			$sql.= ' order by '.$param['order'];
		}else{
			$sql.= ' order by t.displayorder asc';
		}
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
            if (empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
		return $this->db->query($sql)->list_array();
	}

	/**
	 *获取分组条数
	 */
	public function getListCount($param = array()){
		$sql = 'select count(t.groupid) count from ebh_tgroups t';
		$wherearr = array();
		if(!empty($param['crid'])){
			$wherearr[] = 't.crid='.$param['crid'];
		}
		if(!empty($param['upid'])){
			$wherearr[] = 't.upid='.$param['upid'];
		}
		if(!empty($param['uid'])){
			$wherearr[] = 't.uid='.$param['uid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}

	/**
	 *获取单条记录
	 */
	public function getGroupDetail($param = array()){
		$sql = 'select t.groupid,t.upid,t.groupname,t.crid,t.uid,t.displayorder,t.summary from ebh_tgroups t';
		$wherearr = array();
		if(!empty($param['groupid'])){
			$wherearr[] = 't.groupid='.$param['groupid'];
		}
		if(!empty($param['crid'])){
			$wherearr[] = 't.crid='.$param['crid'];
		}
		if(!empty($param['uid'])){
			$wherearr[] = 't.uid='.$param['uid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		return $this->db->query($sql)->row_array();
	}
	//添加一条记录
	public function _insert($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->insert('ebh_tgroups',$param);
	}

	//修改一条记录
	public function _update($param = array(),$where = array()){
		if(empty($param)||empty($where)){
			return 0;
		}
		return $this->db->update('ebh_tgroups',$param,$where);
	}
	//删除一条记录
	public function _delete($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->delete('ebh_tgroups',$param);
	}
	/**
	 *获取学校组信息
	 */
	public function getRoomGroupInfo($crid = 0,$schoolname = ""){
		$sql = 'select t.groupname,t.groupid,u.uid,u.username,u.realname,u.sex,u.face from ebh_tgroups t 
		left join ebh_teachergroups tg on t.groupid = tg.groupid 
		left join ebh_users u on tg.tid = u.uid where t.crid = '.$crid;
		if(isset($schoolname)){
			$sql .= ' AND u.schoolname = \''.$this->db->escape_str($schoolname).'\'';
		}
		$res = $this->db->query($sql)->list_array();
		$infoArr = array();
		foreach ($res as $info) {
			$key = 'group_'.$info['groupid'];
			if(!array_key_exists($key, $infoArr)){
				$infoArr[$key] = array();
			}
			$infoArr[$key][] = $info;
		}
		return $infoArr;
	}
	
	/*
	获取组,不处理数据
	*/
	public function getRoomGroup($crid = 0){
		$sql = 'select t.groupname,t.groupid,u.uid,u.username,u.realname,u.sex,u.face from ebh_tgroups t 
		left join ebh_teachergroups tg on t.groupid = tg.groupid 
		left join ebh_users u on tg.tid = u.uid where t.crid = '.$crid;
		$res = $this->db->query($sql)->list_array();
		return $res;
	}
}