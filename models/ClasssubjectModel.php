<?php
class ClasssubjectModel extends CModel {
    /**
     * 获取某平台下教师的课程列表
     * @param int $crid 平台id
     * @param int $tid 教师编号
     * @return array    课程列表
     */
    function getsubjectlistbytid($crid,$tid) {
        $sql = 'select f.folderid,f.foldername,f.img,f.coursewarenum from ebh_teacherfolders tf '.
                'join ebh_folders f on (tf.folderid = f.folderid) '.
                'where tf.crid='.$crid.' and tf.tid='.$tid .' and f.power <>2 and f.del=0 ORDER BY f.displayorder asc';
        return $this->db->query($sql)->list_array();
    }
    
    /**
     * 
     *获取某网校下的老师的课程
     */
    public function getsubjectlist($crid) {
        $sql = 'select u.uid,u.face,u.sex,u.realname,u.username,f.folderid,f.foldername,f.img,f.coursewarenum from ebh_teacherfolders t  '.
              'left join ebh_folders f on t.folderid = f.folderid '.
              'left join ebh_users u on u.uid = t.tid '.
                'where f.crid='.$crid.' and f.del=0 ORDER BY f.displayorder asc,f.folderid asc';
        return $this->db->query($sql)->list_array();
    }
    
	/**
	 *获取学生的课程分类 
	 */
    public function getMyfolders($crid,$uid){
        if(empty($crid) || empty($uid)){
            return FALSE;
        }
    	$sql = "SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs ".
				"JOIN ebh_classes c on (c.classid = cs.classid) ".
				"WHERE c.crid=$crid and cs.uid = $uid";
		$class = $this->db->query($sql)->row_array();
		
		$sqls = 'select ct.uid from ebh_classteachers ct where ct.classid='.$class['classid'];
		$tidlist = $this->db->query($sqls)->list_array();
		$tids = '';
		if(!empty($tidlist)) {
			foreach($tidlist as $tid) {
				if(empty($tids))
					$tids = $tid['uid'];
				else
					$tids .= ','.$tid['uid'];
			}
		}
		if(!empty($class['grade'])){
			$gradestr = ' or f.grade = '.$class['grade'];
		}else{
			$gradestr = '';
		}
		if(!empty($tids) || !empty($class['grade'])) {
			if(empty($tids))
				$tids = '\'\'';
			$fsql = 'select f.folderid,f.foldername,f.coursewarenum,f.img from ebh_folders f '.
					'where (f.folderid in(select tf.folderid from ebh_teacherfolders tf  '.
					'where tf.tid in ('.$tids.')) '.$gradestr.')and f.crid='.$crid.' and f.del=0';

			return $this->db->query($fsql)->list_array();
		}
		return FALSE;
    }
    
    /**
     * 获取老师的课程分类
     */
    public function getTeacherfolders($crid,$uid){
    	$sql = " select f.folderid,f.foldername from ebh_folders f left join ebh_teacherfolders tf on tf.folderid =  f.folderid where tf.crid = {$crid} and tf.tid = {$uid} and f.power<>2 and f.del=0";
    	return $this->db->query($sql)->list_array();
    }
	 /**
     * 获取学校的所有课程
     */
    public function getfolders($crid){
    	$sql = " select f.folderid,f.foldername,f.uid,u.realname,tf.tid from ebh_folders f left join ebh_teacherfolders tf on tf.folderid = f.folderid left join ebh_users u on tf.tid = u.uid where f.crid = ".$crid.' and folderlevel<>1 and f.power<>2 and f.del=0 group by f.folderid' ;
    	return $this->db->query($sql)->list_array();
    }
    /**
     *获取我所处于的年级的课程,并绑定默认老师(老师默认为学生的老师,如果没有则绑定教该课程的老师)
     */
    public function getMyfoldersForSMS($crid,$uid = 0){
        if(empty($crid) || empty($uid)){
            return FALSE;
        }
       $sql = "SELECT cs.classid,c.classname,c.grade,c.district from  ebh_classstudents cs ".
                "JOIN ebh_classes c on (c.classid = cs.classid) ".
                "WHERE c.crid=$crid and cs.uid = $uid";
        $class = $this->db->query($sql)->row_array();
        if(empty($class)){
            return array();//学生不在班级里面
        }else{
          if(empty($class['grade'])){
            $class['grade'] = 0;
          }
          if(empty($class['district'])){
            $class['district'] = 0;
          }
        }
        $sql_for_folders = 'select f.folderid,f.foldername,f.coursewarenum,f.img,tf.tid from ebh_folders f left join ebh_teacherfolders tf on f.folderid  = tf.folderid where f.crid = '.$crid.' AND f.grade = '.$class['grade'].' AND f.district = '.$class['district'].' AND folderlevel<>1 AND f.power<>2 and f.del=0';
        $folders = $this->db->query($sql_for_folders)->list_array();
        $teacherlist = EBH::app()->model('classes')->getClassTeacherByClassid($class['classid']);
       
        $myfolders = array();
        foreach ($folders as $folder) {
            $key = 'f_'.$folder['folderid'];
            if( array_key_exists($key, $myfolders) && !empty($myfolders[$key]['teacherid'])){
                continue;
            }
            foreach ($teacherlist as $teacher) {
                if($folder['tid'] == $teacher['uid']){
                    $folder['tid'] = $teacher['uid'];
                    $folder['teacherid'] = $teacher['uid'];
                    break;
                }
            }
            $myfolders[$key] = $folder;
        }
        return $myfolders;
    }


    /**
     * 获取某平台下教师的课程列表
     * @param int $crid 平台id
     * @param int $tid 教师编号
     * @return array    课程列表
     */
    function getteachersubjectlist($param = array()) {
        $sql = 'select f.folderid,f.foldername,f.img,f.coursewarenum from ebh_teacherfolders tf join ebh_folders f on (tf.folderid = f.folderid)';
        $wherearr = array();
        if(!empty($param['crid'])){
            $wherearr[] = 'tf.crid = '.$param['crid'];
        }
        if(!empty($param['tid'])){
            $wherearr[] = 'tf.tid = '.$param['tid'];
        }
        if(isset($param['power'])){
            if(is_array($param['power'])){
              $wherearr[] = 'f.power in('.implode(',', $param['power']).')';
            }else if(is_numeric($param['power'])){
              $wherearr[] = 'f.power = '.$param['power'];
            }
        }
        $wherearr[]='f.del=0';
        if(!empty($wherearr)){
            $sql.=' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['order'])){
            $sql.=' ORDER BY '.$param['order'];
        }else{
            $sql.= ' ORDER BY f.displayorder asc ';
        }
        if(!empty($param['limit']))
            $sql .= ' limit '.$param['limit'];
        else {
            if(empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
            $start = ($page - 1) * $pagesize ;
            $sql .= ' limit '.$start.','.$pagesize;
        }
        return $this->db->query($sql)->list_array();
    }

     /**
     * 获取某平台下教师的课程列表数量
     * @param int $crid 平台id
     * @param int $tid 教师编号
     * @return array    课程列表
     */
    function getteachersubjectlistCount($param = array()) {
        $sql = 'select count(f.folderid) count from ebh_teacherfolders tf join ebh_folders f on (tf.folderid = f.folderid)';
        $wherearr = array();
        if(!empty($param['crid'])){
            $wherearr[] = 'tf.crid = '.$param['crid'];
        }
        if(!empty($param['tid'])){
            $wherearr[] = 'tf.tid = '.$param['tid'];
        }
        if(isset($param['power'])){
            if(is_array($param['power'])){
              $wherearr[] = 'f.power in('.implode(',', $param['power']).')';
            }else if(is_numeric($param['power'])){
              $wherearr[] = 'f.power = '.$param['power'];
            }
        }
        $wherearr[]='f.del=0';
        if(!empty($wherearr)){
            $sql.='WHERE '.implode(' AND ',$wherearr);
        }
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }
}