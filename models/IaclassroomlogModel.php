<?php
class IaclassroomlogModel extends CModel{
	/**
	 *学生端互动列表
	 */
	public function getList($param = array()){
		if(empty($param['uid'])){
			return array();
		}
		$sql = 'select ic.icid,ic.uid,ic.title,ic.resource,ic.dateline,IF(isnull(icl.iclogid),0,1) as dotag,icl.img from ebh_iaclassroom ic left join ebh_iaclassroomlog icl on ic.icid = icl.icid and icl.uid = '.$param['uid'].' left join ebh_ia_class iac on ic.icid = iac.icid';
		$whereArr = array();
		if(!empty($param['crid'])){
			$whereArr[] = 'ic.crid = '.$param['crid'];
		}
		if(!empty($param['tid'])){
			$whereArr[] = 'ic.uid = '.$param['tid'];
		}
		if(!empty($param['tid_in'])){
			$whereArr[] = 'ic.uid in '.$param['tid_in'];
		}
		if(!empty($param['q'])) {
            $whereArr[] = '(ic.title like \'%'.$this->db->escape_str($param['q']).'%\')';
        }
        if(!empty($param['classid'])){
        	$whereArr[] = '(isnull(iac.classid) or iac.classid = '.$param['classid'].')';
        }
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}

		if(!empty($param['order'])){
			$sql.= ' order by '.$param['order'];
		}else{
			$sql.= ' order by dotag asc,icl.iclogid desc,ic.icid desc';
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
	 *获取学生互动列表条数
	 */
	public function getListCount($param = array()){
		$sql = 'select count(*) count from ebh_iaclassroom ic left join ebh_ia_class iac on ic.icid = iac.icid';
		$whereArr = array();
		if(!empty($param['crid'])){
			$whereArr[] = 'ic.crid = '.$param['crid'];
		}
		if(!empty($param['tid'])){
			$whereArr[] = 'ic.uid = '.$param['tid'];
		}
		if(!empty($param['tid_in'])){
			$whereArr[] = 'ic.uid in '.$param['tid_in'];
		}
		if(!empty($param['q'])) {
            $whereArr[] = '(ic.title like \'%'.$this->db->escape_str($param['q']).'%\')';
        }
        if(!empty($param['classid'])){
        	$whereArr[] = '(isnull(iac.classid) or iac.classid = '.$param['classid'].')';
        }
        if(!empty($param['Y'])){
            $whereArr[] = 'FROM_UNIXTIME(ic.dateline,\'%Y\') = '.$param['Y'];
         }
        if(!empty($param['m'])){
            $whereArr[] = 'FROM_UNIXTIME(ic.dateline,\'%c\') = '.$param['m'];
         }
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}
	/**
	 *获取一条互动记录
	 */
	public function getialog($param = array()){
		$sql = 'select icl.iclogid,icl.uid,icl.icid,icl.img,icl.dateline,icl.lastpost from ebh_iaclassroomlog icl';
		$whereArr = array();
		if(!empty($param['iclogid'])){
			$whereArr[] = 'icl.iclogid='.$param['iclogid'];
		}
		if(!empty($param['uid'])){
			$whereArr[] = 'icl.uid='.$param['uid'];
		}
		if(!empty($param['icid'])){
			$whereArr[] = 'icl.icid='.$param['icid'];
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		return $this->db->query($sql)->row_array();
	}

	//添加一条记录
	public function _insert($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->insert('ebh_iaclassroomlog',$param);
	}

	//修改一条记录
	public function _update($param = array(),$where = array()){
		if(empty($param)||empty($where)){
			return 0;
		}
		return $this->db->update('ebh_iaclassroomlog',$param,$where);
	}
	//删除一条记录
	public function _delete($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->delete('ebh_iaclassroomlog',$param);
	}

	//获取指定互动的答题列表
	public function getAnswerList($param = array()){
		$sql = 'select ic.title,icl.iclogid,icl.img,icl.uid,icl.dateline,icl.lastpost,u.username,u.realname from ebh_iaclassroomlog icl 
		left join ebh_iaclassroom ic on ic.icid = icl.icid  
		left join ebh_users u on icl.uid = u.uid';
		$whereArr = array();
		if(!empty($param['icid'])){
			$whereArr[] = 'icl.icid='.$param['icid'];
		}
		if(!empty($param['tid'])){
			$whereArr[] = 'ic.uid='.$param['tid'];
		}
		if(!empty($param['stuid_in'])){
			$whereArr[] = 'icl.uid in '.$param['stuid_in'];
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ', $whereArr);
		}
		if(!empty($param['order'])){
			$sql.=' order by '.$this->db->escape_str($param['order']);
		}else{
			$sql.=' order by icl.lastpost desc,icl.iclogid desc';
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}else{
			$sql.=' limit 1000';
		}
		return $this->db->query($sql)->list_array();
	}
    /*
     * 获取学生完成互动数量
     */
    public function getCompleteCount($param){
        $sql = 'select count(*) as count from ebh_iaclassroomlog al LEFT JOIN ebh_iaclassroom a on al.icid=a.icid';
        if(empty($param['uid'])||empty($param['crid'])){
            return false;
        }else{
            $where = ' where al.uid = '.$param['uid'].' and a.crid = '.$param['crid'];
        }
        if(!empty($param['Y'])){
            $where .= ' and FROM_UNIXTIME(al.dateline,\'%Y\') = '.$param['Y'];
        }
        if(!empty($param['m'])){
            $where .= ' and FROM_UNIXTIME(al.dateline,\'%c\') = '.$param['m'];
        }
        $sql .= $where;
        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }
}