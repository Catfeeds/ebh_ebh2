<?php

/**
 * 教室教师管理关系Model类 RoomteacherModel
 */
class RoomteacherModel extends CModel {

    public function insert($param) {
        if (empty($param['crid']) || empty($param['tid']))
            return FALSE;
        $setarr = array();
        $setarr['crid'] = intval($param['crid']);
        $setarr['tid'] = $param['tid'];
        if (isset($param['status']))
            $setarr['status'] = $param['status'];
        if (!empty($param['role'])) {
            $setarr['role'] = $param['role'];
        }
        if (!empty($param ['cdateline'])) {
            $setarr['cdateline'] = $param['cdateline'];
        } else {
            $setarr['cdateline'] = SYSTIME;
        }
        $afrows = $this->db->insert('ebh_roomteachers', $setarr);
		$this->db->update('ebh_classrooms', array(), array('crid' => $param['crid']), array('teanum' => 'teanum+1'));
        return $afrows;
    }

    /**
     * 更新教室内的教师信息，需要带上$crid和$tid
     * @param type $param
     */
    public function update($param) {
        if (empty($param['crid']) || (empty($param['tid'])&&empty($param['role'])))
            return FALSE;
        $wherearr = array('crid' => $param['crid']);
		if(!empty($param['tid']))
			$wherearr['tid'] = $param['tid'];
		if(!empty($param['role']))
			$wherearr['role'] = $param['role'];
        $setarr = array();
        if (isset($param['status'])) { //状态，1正常 0 锁定
            $setarr ['status'] = $param['status'];
        }
		if(!empty($param['changetid']))
			$setarr['tid'] = $param['changetid'];
		if(!empty($param['changerole']))
			$setarr['role'] = $param['changerole'];
        if (empty($setarr))
            return FALSE;
        $afrows = $this->db->update('ebh_roomteachers', $setarr, $wherearr);
		return $afrows;
    }

    /**
     * 删除教室内的教师并更新教室教师数
     * @param type $param
     * @return boolean
     */
    public function del($param) {
        if (empty($param['crid']) || (empty($param['tid'])&&empty($param['role'])))
            return FALSE;
        $wherearr = array('crid' => $param['crid']);
		if(!empty($param['tid']))
			$wherearr['tid'] = $param['tid'];
		if(!empty($param['role']))
			$wherearr['role'] = $param['role'];
        $this->db->begin_trans();
        $afrows = $this->db->delete('ebh_roomteachers', $wherearr);
        if ($afrows > 0) {
            $this->db->update('ebh_classrooms', array(), array('crid' => $param['crid']), array('teanum' => 'teanum-1'));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
        return TRUE;
    }

    /**
     * 根据教室编号获取教师列表，一般适合于教师网校的教师列表
     * @param type $param
     * @param boolean $showcoursenum 是否显示教师在该平台的课件数
     * @return boolean
     */
    public function getroomteacherlist($param, $showcoursenum = FALSE) {
        if (empty($param['crid']))
            return FALSE;
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select u.uid,u.username,u.realname,u.sex,u.face,u.email,u.mobile,rt.status as tstatus,rt.cdateline,rt.role from ebh_roomteachers rt ' .
                'join ebh_users u on (rt.tid = u.uid) ';
        $wherearr = array();
        $wherearr[] = 'rt.crid=' . $param['crid'];
        if (isset($param['status']))
            $wherearr[] = 'rt.status=' . $param['status'];
        if (!empty($param['q'])) {
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = '(u.username like \'%' . $q . '%\' OR u.realname like \'%' . $q . '%\')';
        }
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY rt.cdateline DESC';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        $list = $this->db->query($sql)->list_array();
        if ($showcoursenum && !empty($list)) {    //显示课件数
            $newlist = array();
            $tids = '';
            foreach ($list as $teacher) {
                if (empty($tids))
                    $tids = $teacher['uid'];
                else
                    $tids .= ',' . $teacher['uid'];
                $teacher['coursenum'] = 0;
                $newlist[$teacher['uid']] = $teacher;
            }
            $numsql = 'select c.uid,count(*) count from ebh_roomcourses rc ' .
                    'join ebh_coursewares c on (rc.cwid = c.cwid) ' .
                    'where rc.crid=' . $param['crid'] . ' and c.uid in (' . $tids . ') ' .
                    'group by c.uid';
            $numlist = $this->db->query($numsql)->list_array();
            foreach ($numlist as $numitem) {
                $newlist[$numitem['uid']]['coursenum'] = $numitem['count'];
            }
            $list = $newlist;
        }
        return $list;
    }

    /**
     * 根据教室编号获取教师列表记录数，一般适合于教师网校的教师列表
     * @param type $param
     * @return boolean
     */
    public function getroomteachercount($param) {
        $count = 0;
        if (empty($param['crid']))
            return $count;
        $sql = 'select count(*) count from ebh_roomteachers rt ' .
                'join ebh_users u on (rt.tid = u.uid) ';
        $wherearr = array();
        $wherearr[] = 'rt.crid=' . $param['crid'];
        if (isset($param['status']))
            $wherearr[] = 'rt.status=' . $param['status'];
        if (!empty($param['q'])) {
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = '(u.username like \'%' . $q . '%\' OR u.realname like \'%' . $q . '%\')';
        }
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
    }

    /**
     * 获取网校教师id列表
     * @param  integer $crid     网校id
     * @param  integer $page     页号
     * @param  integer $pagesize 每页记录数
     * @return array            教师ID数组
     */
    public function getTeacheIdList($crid,$page=1,$pagesize=100) {
		$sql = "select tid from ebh_roomteachers where crid=$crid";
		$start = ($page - 1) * $pagesize;
		$sql .= ' limit ' . $start . ',' . $pagesize;
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 批量导入教师账号
	 */
	public function addMultipleTeacher($roomarr){
		$sql = 'insert into ebh_roomteachers (crid,tid,status,cdateline,role) values ';
		foreach($roomarr as $room){
			if(!empty($room['tid'])){
				$crid = $room['crid'];
				$uid = $room['tid'];
				$status = $room['status'];
				$cdateline = SYSTIME;
				$role = $room['role'];
				$sql.= "($crid,$uid,$status,$cdateline,$role),";
			}
		}
		if(!empty($crid)){
			$sql = rtrim($sql,',');
			$this->db->query($sql);
		}
	}

    /**
     * 检验网校下的老师是否为超级管理员
     */
    public function checkTeacher($crid, $tid){
        if (empty($crid) OR empty($tid)) {
            return FALSE;
        }
        $sql = 'select crid,role from ebh_roomteachers where crid='.$crid.' and tid='.$tid.' and role=2;';
        $res = $this->db->query($sql)->row_array();
        return $res ? 1 : 0;
    }

    /**
     * 跟据教师ID获取网校下的教师信息
     * @param $teacherid
     * @param $crid
     * @return mixed
     */
	public function getTeacherById($teacherid, $crid) {
        $teacherid = (int) $teacherid;
        $crid = (int) $crid;
        $sql = "SELECT `ebh_users`.`username`,`ebh_users`.`realname` FROM ".
            "(SELECT `tid` FROM `ebh_roomteachers` WHERE `crid`=$crid AND `tid`=$teacherid AND `status`=1) AS `m` ".
            "LEFT JOIN `ebh_users` ON `m`.`tid`=`ebh_users`.`uid`";
        return $this->db->query($sql)->row_array();
    }

    /**
     * 根据教室ID获取网校下教师信息列表
     * @param $teacherids
     * @param $crid
     * @return bool
     */
    public function getTeachersByIds($teacherids,$crid){
        if(is_array($teacherids) && count($teacherids) > 0){
            $ids = implode(',',$teacherids);
            $crid = (int) $crid;
            $sql = "SELECT `ebh_users`.`uid`,`ebh_users`.`username`,`ebh_users`.`realname` FROM ".
                "(SELECT `tid` FROM `ebh_roomteachers` WHERE `crid`=$crid AND `tid` in ($ids) AND `status`=1) AS `m` ".
                "LEFT JOIN `ebh_users` ON `m`.`tid`=`ebh_users`.`uid`";
            $res = $this->db->query($sql)->list_array();
            return $res;
        }else{
            return false;
        }

    }
	
	/*
	是否是课程的老师
	*/
	public function ifCourseTeacher($uid,$folderid){
		if(empty($uid) || empty($folderid)){
			return FALSE;
		}
		$sql = 'select 1 from ebh_teacherfolders where tid='.$uid .' and folderid='.$folderid;
		$res = $this->db->query($sql)->row_array();
		if(!empty($res)){
			return TRUE;
		}
		return FALSE;
	}
}
