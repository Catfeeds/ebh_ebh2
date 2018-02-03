<?php
/**
 *互动课堂模型
 */
class IaclassroomModel extends CModel{
	//获取互动列表
	public function getList($param = array()){
		$sql = 'select ic.icid,ic.title,ic.resource,ic.crid,ic.uid,ic.dateline,u.username,u.realname from ebh_iaclassroom ic
		left join ebh_users u on ic.uid = u.uid';
		$whereArr = array();
		if(!empty($param['icid'])){
			$whereArr[] = 'ic.icid='.$param['icid'];
		}
		if(!empty($param['crid'])){
			$whereArr[] = 'ic.crid='.$param['crid'];
		}
		if(!empty($param['uid'])){
			$whereArr[] = 'ic.uid='.$param['uid'];
		}
		if(!empty($param['q'])) {
            $whereArr[] = '(ic.title like \'%'.$this->db->escape_str($param['q']).'%\')';
        }
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ', $whereArr);
		}
		if(!empty($param['order'])){
			$sql.=' order by '.$this->db->escape_str($param['order']);
		}else{
			$sql.=' order by ic.icid desc';
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}else{
			$sql.=' limit 1000';
		}
		return $this->db->query($sql)->list_array();
	}

	//获取互动数目
	public function getListCount($param = array()){
		$sql = 'select count(ic.icid) count from ebh_iaclassroom ic';
		$whereArr = array();
		if(!empty($param['icid'])){
			$whereArr[] = 'ic.icid='.$param['icid'];
		}
		if(!empty($param['crid'])){
			$whereArr[] = 'ic.crid='.$param['crid'];
		}
		if(!empty($param['uid'])){
			$whereArr[] = 'ic.uid='.$param['uid'];
		}
		if(!empty($param['q'])) {
            $whereArr[] = '(ic.title like \'%'.$this->db->escape_str($param['q']).'%\')';
        }
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ', $whereArr);
		}
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}
	//添加一条记录
	public function _insert($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->insert('ebh_iaclassroom',$param);
	}

	//修改一条记录
	public function _update($param = array(),$where = array()){
		if(empty($param)||empty($where)){
			return 0;
		}
		return $this->db->update('ebh_iaclassroom',$param,$where);
	}
	//删除一条记录
	public function _delete($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->delete('ebh_iaclassroom',$param);
	}
	/**
	 *获取一条记录
	 */
	public function getIa($param = array()){
		$sql = 'select ic.icid,ic.title,ic.resource,ic.crid,ic.uid,ic.dateline from ebh_iaclassroom ic';
		$whereArr = array();
		if(!empty($param['icid'])){
			$whereArr[] = 'ic.icid='.$param['icid'];
		}
		if(!empty($param['crid'])){
			$whereArr[] = 'ic.crid='.$param['crid'];
		}
		if(!empty($param['uid'])){
			$whereArr[] = 'ic.uid='.$param['uid'];
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ', $whereArr);
		}
		$sql.=' limit 1';
		return $this->db->query($sql)->row_array();
	}

	/**
	 *保存互动和班级关联信息
	 *
	 */
	public function saveClassInfo($param = array()){
		if(empty($param)){
			return ;
		}
		return $this->db->insert('ebh_ia_class',$param);
	}

	/**
	 *保存互动和班级关联信息
	 *
	 */
	public function deleteClassInfo($param = array()){
		if(empty($param)){
			return ;
		}
		return $this->db->delete('ebh_ia_class',$param);
	}
	/**
	 *
	 */
	public function getClassInfo($icid = 0){
		$sql = 'select icid,classid from ebh_ia_class where icid = '.$icid;
		return $this->db->query($sql)->list_array();
	}
    public function getIaClass($param){
        $sql = 'select c.classname from ebh_ia_class ic left join ebh_classes c on ic.classid = c.classid';
        $where = ' where 1=1';
        if(!empty($param['icid'])){
            $where.= ' and ic.icid = '.$param['icid'];
        }
        if(!empty($param['crid'])){
            $where.= ' and c.crid = '.$param['crid'];
        }
        $sql.=$where;
        $res = $this->db->query($sql)->list_array();
        return $res;
    }
}