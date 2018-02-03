<?php

/**
 * OnlinecourseModel 直播课程Model类
 */
class OnlinecourseModel extends CModel {
	/**
     * 获取平台最新发布的直播数(可以时间过滤） 
     */
       public function getnewcourselistcount($queryarr) {
		$count = 0;
        $sql = 'SELECT count(*) count FROM ebh_onlinecourses o ';
        $wherearr = array();
        if (!empty($queryarr['crid'])) {
            $wherearr[] = 'o.crid=' . $queryarr['crid'];
        }
		if (isset($queryarr['subtime']))
			$wherearr[] = 'o.dateline > '.$queryarr['subtime'];
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
        return $count;
    }


    /**
     *获取直播列表
     *
     */
    public function getList($param = array()){
        $sql = 'select o.id,o.crid,o.title,o.tid,o.tname,o.cdate,o.ctime,o.summary,o.message,o.dateline,u.username,u.realname,u.groupid,u.sex,u.face from ebh_onlinecourses o 
        left join ebh_users u on o.tid = u.uid ';
        if(!empty($param['folderinfo'])){
            $sql = 'select o.id,o.crid,o.title,o.tid,o.tname,o.cdate,o.ctime,o.summary,o.message,o.dateline,u.username,u.realname,f.foldername from ebh_onlinecourses o 
                     left join ebh_users u on o.tid = u.uid 
                     left join ebh_folders f on o.folderid = f.folderid';
        }
        $wherearr = array();
        if(!empty($param['crid'])){
            $wherearr[] = 'o.crid ='.intval($param['crid']);
        }
        if(!empty($param['tid'])){
            $wherearr[] = 'o.tid='.intval($param['tid']);
        }
        if(!empty($param['classid'])){
            $wherearr[] = 'roc.classid='.intval($param['classid']);
        }
        if(!empty($param['grade'])){
            $wherearr[] = 'roc.grade='.intval($param['grade']);
        }
        if(!empty($param['classid'])||!empty($param['grade'])){
            $sql.=' left join ebh_onlinecourse_classes roc on roc.oid = o.id ';
        }
        if(!empty($param['q'])){
            if(!empty($param['folderinfo'])){
                $wherearr[] = '(o.title like \'%'.$param['q'].'%\' or f.foldername like \'%'.$param['q'].'%\')';
            }else{
                $wherearr[] = 'o.title like \'%'.$param['q'].'%\'';
            }
            
        }
        if(!empty($param['folderinfo'])){
                $wherearr[] = 'o.folderid > 0';
            }else{
                $wherearr[] = 'o.folderid = 0';
        }
        if(!empty($wherearr)){
            $sql.=' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['grade'])){
            $sql.=' group by roc.oid ';
        }

        if(empty($param['order'])){
            $sql.= ' order by o.id desc';
        }else{
            $sql.=$param['order'];
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
    public function getListCount($param = array()){
        $sql = 'select count(*) count from ebh_onlinecourses o ';
        if(!empty($param['folderinfo'])){
            $sql = 'select count(*) count from ebh_onlinecourses o 
                     left join ebh_users u on o.tid = u.uid 
                     left join ebh_folders f on o.folderid = f.folderid';
        }
        $wherearr = array();
        if(!empty($param['crid'])){
            $wherearr[] = 'o.crid ='.intval($param['crid']);
        }
        if(!empty($param['tid'])){
            $wherearr[] = 'o.tid='.intval($param['tid']);
        }
        if(!empty($param['classid'])){
            $wherearr[] = 'roc.classid='.intval($param['classid']);
        }
        if(!empty($param['grade'])){
            $wherearr[] = 'roc.grade='.intval($param['grade']);
        }
        if(!empty($param['classid'])||!empty($param['grade'])){
            $sql.=' left join ebh_onlinecourse_classes roc on roc.oid = o.id ';
        }
        if(!empty($param['q'])){
            if(!empty($param['folderinfo'])){
                $wherearr[] = '(o.title like\'%'.$param['q'].'%\' or f.foldername like \'%'.$param['q'].'%\')';
            }else{
                $wherearr[] = 'o.title like \'%'.$param['q'].'%\'';
            }
            
        }
        if(!empty($param['folderinfo'])){
                $wherearr[] = 'o.folderid > 0';
            }else{
                $wherearr[] = 'o.folderid = 0';
        }
        if(!empty($wherearr)){
            $sql.=' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['grade'])){
            $sql.=' group by roc.oid ';
        }
        $res = $this->db->query($sql)->row_array();
        return $res['count'];

    }
    //直播时，得到班级列表
    public function getpclass($uid,$crid){
        $sql = 'select c.classid,c.classname,c.grade,c.district FROM ebh_classteachers ct left JOIN ebh_classes c on ct.classid = c.classid where uid='.$uid.' and crid='.$crid;
        return $this->db->query($sql)->list_array();
    }

    /**
     *新增一条数据
     *
     */
    public function _insert($param = array()){
        if(empty($param)){
            return 0;
        }
        $param = $this->db->escape_str($param);
        return $this->db->insert('ebh_onlinecourses',$param);
    }

    /**
     *修改一条记录
     *
     */
    public function _update($param = array(),$where = array()){
        if(empty($param)||empty($where)){
            return 0;
        }
        $param = $this->db->escape_str($param);
        $where = $this->db->escape_str($where);
        return $this->db->update('ebh_onlinecourses',$param,$where);
    }

    public function _delete($param = array()){
        if(empty($param)){
            return false;
        }
        return $this->db->delete('ebh_onlinecourses',$param);
    }
    
    /**
     *根据直播课编号获取直播信息
	 *@param int $id 直播课编号
     */
    public function getOneById($id = 0){
        if(empty($id)){
            return array();
        }
        $sql = 'select o.* from ebh_onlinecourses o where id = '.intval($id).' limit 1';
        return $this->db->query($sql)->row_array();
    }
	/**
	*根据直播课编号获取直播课详细信息，包括教室和课程信息
	*@param int $id 直播课编号
	*/
	public function getOnlineDetailsById($id = 0) {
		if(empty($id)){
            return FALSE;
        }
		$sql = 'select o.id,o.crid,o.folderid,o.title,o.tid,o.auid,cr.ispublic,cr.isschool, f.fprice from ebh_onlinecourses o '.
				'join ebh_classrooms cr on (cr.crid = o.crid) '.
				'left join ebh_folders f on (f.folderid = o.folderid) '.
				'where o.id='.$id;
        return $this->db->query($sql)->row_array();
	}

    /**
     *获取用户是否有权限操作某条直播(-1只检查拥有权限,其它则检查拥有权限和是否过期)
     *
     */
    public function hasPower($uid=0,$id=0,$tag = -1){
        if(empty($uid)||empty($id)){
            return false;
        }
        if($tag==-1){
            $sql = 'select count(*) count from ebh_onlinecourses o where o.id='.intval($id).' AND (o.cdate+o.ctime*60)>='.time().' AND o.tid='.intval($uid).' limit 1 ';
        }else{
            $sql = 'select count(*) count from ebh_onlinecourses o where o.id='.intval($id).' AND o.tid='.intval($uid).' limit 1 ';
        }
        $res = $this->db->query($sql)->row_array();
        if($res['count']==1){
            return true;
        }else{
            return false;
        }
    }
	/**
     *根据课程获取直播列表
     *
     */
    public function getListByFolder($param = array()){
		if(empty($param['folderid']))
			return FALSE;
		$curtime = SYSTIME;
        $sql = "select o.id,o.crid,o.title,o.tid,o.tname,o.cdate,o.ctime,o.summary,o.message,o.dateline,u.username,u.realname,case when (cdate+ctime*60>$curtime) then 0  else 1 end as rstatus ,ABS(cdate+ctime*60-$curtime) as rtime from ebh_onlinecourses o 
        left join ebh_users u on o.tid = u.uid ";
        $wherearr = array();
        if(!empty($param['crid'])){
            $wherearr[] = 'o.crid ='.intval($param['crid']);
        }
        if(!empty($param['tid'])){
            $wherearr[] = 'o.tid='.intval($param['tid']);
        }
		if(!empty($param['folderid'])){
            $wherearr[] = 'o.folderid='.intval($param['folderid']);
        }
        if(!empty($param['q'])){
            $wherearr[] = 'o.title like \'%'.$param['q'].'%\'';
        }
        if(!empty($wherearr)){
            $sql.=' WHERE '.implode(' AND ',$wherearr);
        }
        if(empty($param['order'])){
            $sql.= ' order by rstatus asc,rtime asc ,cdate desc';
        }else{
            $sql.=$param['order'];
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
        $list = $this->db->query($sql)->list_array();
		$onlinelist = array();
		foreach($list as $myonline) {
			$status = 0;	//正在进行
			$cdate = $myonline['cdate'];
			$ctime = $myonline['ctime'];
			if($curtime < $cdate) {	//即将开始
				$status = 1;
			} else if($curtime > ($cdate + $ctime*60)) {	//已经过期
				$status = -1;
			}
			$myonline['status'] = $status;
			$onlinelist[] = $myonline;
		}
		return $onlinelist;
    }

    /**
     *判断直播课是否属于该教室
     *@param int $oid 直播课oid
     *@param int $crid 教室crid
     *@return boolean 
     */
    public function ifInClassroom($oid = 0,$crid = 0){
        if(empty($oid)||empty($crid)){
            return false;
        }
        $sql = 'select count(*) count from ebh_onlinecourses o where o.id ='.$oid.' AND o.crid='.$crid;
        $res = $this->db->query($sql)->row_array();
        if($res['count']==1){
            return true;
        }else{
            return false;
        }
    }
    /**
     *获取学生有权限的直播课(不包含按课程布置的直播课)
     */
    public function getStuOnline($param = array()){
        $curtime = time();
        $sql = "select distinct(id),o.id,o.title,o.tid,o.tname,o.cdate,o.ctime,case when (cdate+ctime*60>$curtime) then 0  else 1 end as rstatus,ABS(cdate+ctime*60-$curtime) as rtime from ebh_onlinecourses o join ebh_onlinecourse_classes oc on o.id = oc.oid";
        if(!isset($param['district']) || !isset($param['grade']) || !isset($param['classid'])){
            return array();
        }
        $wherearr = array();
        $wherearr[] = ' o.folderid = 0 ';
        $wherearr[] = ' oc.classid = '.$param['classid'];
        if(!empty($param['q'])){
            $wherearr[] = 'o.title like \'%'.$param['q'].'%\'';
        }
        $sql.=' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['q'])){
            $sql.=' OR (oc.grade = '.$param['grade'].' AND oc.district= '.$param['district'].' AND o.crid ='.$param['crid'].' AND o.title like \'%'.$this->db->escape_str($param['q']).'%\')';
        }else{
            $sql.=' OR (oc.grade = '.$param['grade'].' AND oc.district= '.$param['district'].' AND o.crid ='.$param['crid'].')';
        }

        if(empty($param['order'])){
            $sql .= ' order by rstatus asc,rtime asc ,o.cdate desc '; 
        }else{
            $sql.=$param['order'];
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
     *获取学生有权限的直播课数目(不包含按课程布置的直播课)
     */
    public function getStuOnlineCount($param = array()){
        $sql = "select count(distinct(id)) count from ebh_onlinecourses o join ebh_onlinecourse_classes oc on o.id = oc.oid";
        if(!isset($param['district']) || !isset($param['grade']) || !isset($param['classid'])){
            return 0;
        }
        $wherearr = array();
        $wherearr[] = ' o.folderid = 0 ';
        $wherearr[] = ' oc.classid = '.$param['classid'];
        if(!empty($param['q'])){
            $wherearr[] = 'o.title like \'%'.$param['q'].'%\'';
        }
        $sql.=' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['q'])){
            $sql.=' OR (oc.grade = '.$param['grade'].' AND oc.district= '.$param['district'].' AND o.crid ='.$param['crid'].' AND o.title like \'%'.$this->db->escape_str($param['q']).'%\')';
        }else{
            $sql.=' OR (oc.grade = '.$param['grade'].' AND oc.district= '.$param['district'].' AND o.crid ='.$param['crid'].')';
        }
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }
}
