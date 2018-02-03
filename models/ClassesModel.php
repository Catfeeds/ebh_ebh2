<?php
/**
 * 班级ClassesModel类
 */
class ClassesModel extends CModel{
    /**
     * 获取教师的班级列表
     * @param type $crid
     * @param type $uid
     * @return type
     */
    public function getTeacherClassList($crid,$uid) {
        $sql = 'select c.classid,c.classname,c.stunum,c.grade,c.district,c.headteacherid from ebh_classteachers ct '.
                'join ebh_classes c on (ct.classid = c.classid) '.
                'where c.crid='.$crid.' and ct.uid = '.$uid.' and c.`status`=0 order by c.classid';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 获取教师的班级列表
     * @param type $crid
     * @param type $uid
     * @return type
     */
    public function getTeacherClassListarr($crid,$uid) {
        $sql = 'select c.classid,c.classname,c.stunum,c.grade,c.district,c.headteacherid from ebh_classteachers ct '.
                'join ebh_classes c on (ct.classid = c.classid) '.
                'where c.crid='.$crid.' and ct.uid in('.$uid.') and c.`status`=0 order by c.classid';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 获取班级学生列表
     * @param array $queryarr
     * @return array
     */
    public function getClassStudentList($queryarr) {
       
        $sql = 'select cs.classid,cs.uid,u.username,u.realname,u.sex,u.email,u.mobile,u.face,u.mysign,u.groupid from ebh_classstudents cs '.
                'join ebh_users u on (u.uid = cs.uid) ';
        $wherearr = array();
        $wherearr[] = 'u.status = 1';
        if(!empty($queryarr['noself'])){
        	$wherearr[] = 'cs.uid !='.$queryarr['uid'];
        }
        if(!empty($queryarr['unid'])){
            $wherearr[] = 'cs.uid not in('.$queryarr['unid'].')';
        }
        if(!empty($queryarr['classid']))
            $wherearr[] = 'cs.classid in('.$queryarr['classid'].')';
        if(!empty($queryarr['classidlist']))
            $wherearr[] = 'cs.classid in ('.$queryarr['classidlist'].')';
        if(!empty($queryarr['q'])) {
            $wherearr[] = '(u.username like \'%'.$this->db->escape_str($queryarr['q']).'%\''.
                    ' or u.realname like \'%'.$this->db->escape_str($queryarr['q']).'%\')';
        }
        if(!empty($queryarr['uids'])){
        	$wherearr[] = 'u.uid in ('.implode(',',$queryarr['uids']).')';
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($queryarr['group'])){
        	$sql .= ' GROUP BY '.$queryarr['group'];
        }
        if(!empty($queryarr['order'])) {
            $sql .= ' ORDER BY '.$queryarr['order'];
        } else {
            $sql .= ' ORDER BY cs.classid';
        }
		if(!empty($queryarr['limit']))
			$sql .= ' limit '.$queryarr['limit'];
		else {
			 if(empty($queryarr['page']) || $queryarr['page'] < 1)
				$page = 1;
			else
				$page = $queryarr['page'];
			$pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
			$start = ($page - 1) * $pagesize ;
			$sql .= ' limit '.$start.','.$pagesize;
		}
        return $this->db->query($sql)->list_array();
    }
    /**
     * 检测班级学生是否存在
     */
    public function existstu($classid = 0,$uid = 0){
    	$sql = 'select cs.classid,cs.uid,u.username,u.realname,u.sex,u.email,u.mobile,u.face,u.mysign from ebh_classstudents cs '.
                'join ebh_users u on (u.uid = cs.uid) where cs.classid = '.$classid." and cs.uid = ".$uid;
    	return $this->db->query($sql)->row_array();
    }
    
    /**
     * 获取班级学生记录数
     * @param array $queryarr
     * @return array
     */
    public function getClassStudentCount($queryarr) {
        $count = 0;
        $sql = 'select count(*) count from ebh_classstudents cs '.
                'join ebh_users u on (u.uid = cs.uid) ';
        $wherearr = array();
        $wherearr[] = 'u.status = 1';
        if(!empty($queryarr['classid']))
            $wherearr[] = 'cs.classid='.$queryarr['classid'];
        if(!empty($queryarr['classidlist']))
            $wherearr[] = 'cs.classid in ('.$queryarr['classidlist'].')';
		if(!empty($queryarr['uids']))
			$wherearr[] = 'u.uid in ('.implode(',',$queryarr['uids']).')';
        if(!empty($queryarr['q'])) {
            $wherearr[] = '(u.username like \'%'.$this->db->escape_str($queryarr['q']).'%\''.
                    ' or u.realname like \'%'.$this->db->escape_str($queryarr['q']).'%\')';
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        $countrow = $this->db->query($sql)->row_array();
        if(!empty($countrow))
            $count = $countrow['count'];
        return $count;
    }
	/**
	*获取教师所在班级的班级作业
	*/
    public function getTeacherclassexam($param) {
        if(empty($param['uid']) || empty($param['crid']))
            return FALSE;
        $sql = 'select c.classid,c.classname,c.stunum,c.grade,c.district from ebh_classteachers ct '.
                'join ebh_classes c on (ct.classid=c.classid) '.
                'where ct.uid='.$param['uid'].' and c.crid='.$param['crid'].' and c.status=0';
        $cexams = $this->db->query($sql)->list_array();

        for($i = 0; $i < count($cexams); $i ++) {
            $cexams[$i]['examscount'] = 0;
            $cexams[$i]['quescount'] = 0;
            $cexams[$i]['lastexamdate'] = '';
			if(!empty($cexams[$i]['grade'])) {	//按所在年级算，那么就要算上教师的科目
				$fid_in = $this->getFoldersByGrade($param['crid'],$cexams[$i]['grade'],$param['uid'],$cexams[$i]['district']);
				if(isset($param['type']) && is_numeric($param['type'])){
					$type = $param['type'];
					$countsql = 'select count(se.eid) examscount ,sum(se.quescount) as quescount from ebh_schexams se '.
					'where (se.classid='.$cexams[$i]['classid'].' and se.uid='.$param['uid'].' and se.type='.$type.') or (se.grade='.$cexams[$i]['grade'].' and se.district='.$cexams[$i]['district'].' and se.type = '.$type.' and se.folderid in'.$fid_in.')';
					
					$lastsql = 'SELECT se.dateline from ebh_schexams se where (se.classid='.$cexams[$i]['classid'].' and se.uid='.$param['uid'].' and se.type='.$type.') or (se.grade='.$cexams[$i]['grade'].' and se.district='.$cexams[$i]['district'].' and se.type='.$type.' and se.folderid in'.$fid_in.') order by se.eid desc limit 0,1';
				}else{
					$countsql = 'select count(se.eid) examscount ,sum(se.quescount) as quescount from ebh_schexams se '.
					'where (se.classid='.$cexams[$i]['classid'].' and se.uid='.$param['uid'].') or (se.grade='.$cexams[$i]['grade'].' and se.district='.$cexams[$i]['district'].' and se.folderid in'.$fid_in.')';
					
					$lastsql = 'SELECT se.dateline from ebh_schexams se where (se.classid='.$cexams[$i]['classid'].' and se.uid='.$param['uid'].') or (se.grade='.$cexams[$i]['grade'].' and se.district='.$cexams[$i]['district'].' and se.folderid in'.$fid_in.') order by se.eid desc limit 0,1';
				}
			} else {
				if(isset($param['type']) && is_numeric($param['type'])){
					$type = $param['type'];
					$countsql = 'select count(se.eid) examscount ,sum(se.quescount) as quescount from ebh_schexams se '.
					'where se.classid='.$cexams[$i]['classid'].' and se.uid='.$param['uid'].' and se.type='.$type;

					$lastsql = 'SELECT se.dateline from ebh_schexams se where se.classid='.$cexams[$i]['classid'].' and se.type='.$type.' order by se.eid desc limit 0,1';
				}else{
					$countsql = 'select count(se.eid) examscount ,sum(se.quescount) as quescount from ebh_schexams se '.
					'where se.classid='.$cexams[$i]['classid'].' and se.uid='.$param['uid'];

					$lastsql = 'SELECT se.dateline from ebh_schexams se where se.classid='.$cexams[$i]['classid'].' order by se.eid desc limit 0,1';
				}
			}
            $countrow = $this->db->query($countsql)->row_array();
            if(!empty($countrow)) {
                $cexams[$i]['examscount'] = $countrow['examscount'];
                $cexams[$i]['quescount'] = $countrow['quescount'];
            }
            $lastrow = $this->db->query($lastsql)->row_array();
            if(!empty($lastrow['dateline']))
                $cexams[$i]['lastexamdate'] = $lastrow['dateline'];
        } 
        return $cexams;
    }
	/**
	*根据年级等信息获取教师对应的科目编号
	*/
	public function getFolderByGrade($crid,$grade,$uid,$district) {
		if (empty($crid) || empty($uid)) {
			return false;
		}
		$sql = "select f.folderid,f.foldername from ebh_teacherfolders tf join ebh_folders f ".
				"ON(tf.folderid = f.folderid) ".
				"where f.crid=$crid and tf.tid=$uid and f.grade=$grade and f.district=$district";
		return $this->db->query($sql)->row_array();
	}
	public function getFoldersByGrade($crid,$grade,$uid,$district) {
		if (empty($crid) || empty($uid)) {
			return false;
		}
		$sql = "select f.folderid,f.foldername from ebh_teacherfolders tf join ebh_folders f ".
				"ON(tf.folderid = f.folderid) ".
				"where f.crid=$crid and tf.tid=$uid and f.grade=$grade and f.district=$district";
		$foldersList = $this->db->query($sql)->list_array();
		if(!empty($foldersList)){
			foreach ($foldersList as $folder) {
				$fids[] = $folder['folderid'];
			}
			return '('.implode(',', $fids).')';
		}else{
			return '(0)';
		}
	}
	
	/*
	添加班级
	@param array $param crid,classname
	@return int $classid 班级号
	*/
	public function addclass($param){
		$setarr['crid'] = $param['crid'];
		$setarr['classname'] = trim($param['classname'],' ');
		$setarr['classname'] = str_replace('　','',$setarr['classname']);
		if(isset($param['grade']))
			$setarr['grade'] = $param['grade'];
		if(isset($param['district']))
			$setarr['district'] = $param['district'];
		$setarr['dateline'] = SYSTIME;
		return $this->db->insert('ebh_classes',$setarr);
	}
	
	/*
	班级名是否存在
	@param array $param crid,classname
	*/
	public function classnameexists($param){
		$wherearr[] = 'crid='.$param['crid'];
		$wherearr[] = 'classname=\''.$this->db->escape_str($param['classname']).'\'';
		if(!empty($param['classid']))
			$wherearr[] = 'classid='.$param['classid'];
		$sql = 'select 1 from ebh_classes';
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();
	}
	
	/**
     * 获取学校的班级列表
     * @param type $crid
	 * @param type $classid
     * @return array
     */
    public function getroomClassList($crid,$classid = 0,$limit='') {
        $sql = 'select c.classid,c.classname,c.stunum,c.grade,c.headteacherid,c.code,c.superior from ebh_classes c '.
                'where c.crid='.$crid.' and c.`status`=0 ';
		if($classid>0){
			$sql .= 'and c.classid=' .$classid;
		}else{
			$sql .= ' order by c.classid';
		}
		if(!empty($limit)) {
			$sql .= ' limit '. $limit;
		}
        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取限定ID班级列表
     * @param $crid
     * @param $ids
     * @return mixed
     */
    public function getClassList($crid, $ids) {
        $crid = (int) $crid;
        $sql = "SELECT `classid`,`classname` FROM `ebh_classes` WHERE `crid`=$crid AND `classid` IN($ids)";
        return $this->db->query($sql)->list_array();
    }

    /*
     * 根据班级或年级获取班级列表
     */
    public function getClassListByGrade($param){
        if(empty($param['crid'])){
            return false;
        }
        $crid = (int) $param['crid'];
        $sql = 'select classid,classname,stunum,grade from ebh_classes';
        $where = ' where crid = '.$crid;
        if(!empty($param['classids'])){
            $where .=' and classid in('.$param['classids'].')';
        }
        if(isset($param['grade'])){
            $where .=' and grade in('.$param['grade'].')';
        }
        $sql .=$where;
        return $this->db->query($sql)->list_array();

    }

    /*
     * 获取网校年级id
     */
    public function getRoomGrade($param){
        if(empty($param['crid'])){
            return false;
        }
        $sql = ' select grade from ebh_classes where crid = '.$param['crid'];
        $sql .= ' group by grade';
        return $this->db->query($sql)->list_array();
    }

	/*
	获取学校的班级数量
	@param int $crid
	*/
	public function getroomclasscount($crid){
		if (empty($crid)) {
			return false;
		}
		$sql = 'select count(*) count from ebh_classes c
			where c.crid='.$crid.' and c.`status`=0';
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	删除班级
	@param array $param  classid
	*/
	public function deleteclass($param){
		$wherearr['classid'] = $param['classid'];
		$this->db->begin_trans();
		$this->db->delete('ebh_classteachers',$wherearr);
		$this->db->delete('ebh_classes',$wherearr);
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}
	/*
	班级详情
	@param array $param  classid,crid
	*/
	public function getclassdetail($param){
		$sql = 'select classid,classname,stunum,grade,district from ebh_classes
			where classid = '.$param['classid'].' and crid='.$param['crid'];
		return $this->db->query($sql)->row_array();
	}
	/*
	修改班级
	@param array $param  classname,classid
	*/
	public function editclass($param){
		$setarr = array();
		$ssetarr = array();
		if(!empty($param['classname'])){
			$setarr['classname'] = trim($param['classname'],' ');
			$setarr['classname'] = str_replace('　','',$setarr['classname']);
		}
		if(!empty($param['stunum']))
			$ssetarr['stunum'] = 'stunum+'.$param['stunum'];
		if(isset($param['grade']))
			$setarr['grade'] = $param['grade'];
		$wherearr = array('classid'=>$param['classid']);
		
		return $this->db->update('ebh_classes',$setarr,$wherearr,$ssetarr);
	}
	/**
	 * 根据crid和classid获取批量的classroom信息
	 */
	public function getclassroombyclassid($crid,$classids){
		if(empty($crid) || empty($classids)){
			return false;
		}
		$sql = 'select classid,classname,stunum,grade,district from ebh_classes
			where classid in('.$classids.') and crid='.$crid;
		return $this->db->query($sql)->list_array();
	}
	/*
	选择班级的任课教师
	@param array $param  classid,teacherids
	*/
	public function chooseteacher($param){
		if(!empty($param['classid'])){
			$wherearr['classid'] = $param['classid'];
			//return $wherearr;
			$this->db->delete('ebh_classteachers',$wherearr);
		}
		$idarr = explode(',',$param['teacherids']);
		foreach($idarr as $id){
			//$param['teacherids']为空时,$id为空字符串,需要排除这种情况
			if (!empty($id))
			{
				$ctarr = array('uid'=>$id,'classid'=>$param['classid']);
				$this->db->insert('ebh_classteachers',$ctarr);
			}
		}
	}
	
	/**
	 * 选择班主任
	 * @param  array $param headteacherid,classid
	 * @return boolean        是否成功
	 */
	public function chooseheadteacher($param){
		if(!isset($param['headteacherid']) || empty($param['classid']))
			return FALSE;
		return $this->db->update('ebh_classes',array('headteacherid'=>$param['headteacherid']),array('classid'=>$param['classid']));
	}
	/*
	删除班级学生
	@param array $param crid classid uid
	*/
	public function deletestudent($param){
		$this->db->begin_trans();
		if(!empty($param['classid']) && !empty($param['uid'])){
			$classarr['classid'] = $param['classid'];
			$classarr['uid'] = $param['uid'];
			$this->db->update('ebh_classes',array(),array('classid'=>$param['classid']),array('stunum'=>'stunum-1'));			
			$this->db->delete('ebh_classstudents',$classarr);
		}
		if(!empty($param['crid']) && !empty($param['uid'])){
			$roomarr['crid'] = $param['crid'];
			$roomarr['uid'] = $param['uid'];
			$this->db->update('ebh_classrooms',array(),array('crid'=>$param['crid']),array('stunum'=>'stunum-1'));
			$this->db->delete('ebh_roomusers',$roomarr);
		}
		if($this->db->trans_status()===FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
        return TRUE;
	}
	
	/*
	添加学生到classstudent表
	@param array $param crid classid uid
	*/
	public function addclassstudent($param){
		$setarr['uid'] = $param['uid'];
		$setarr['classid'] = $param['classid'];
		$this->db->update('ebh_classes',array(),array('classid'=>$param['classid']),array('stunum'=>'stunum+1'));
		$this->db->update('ebh_classrooms',array(),array('crid'=>$param['crid']),array('stunum'=>'stunum+1'));
		return $this->db->insert('ebh_classstudents',$setarr);
	}
	/**
	*获取用户所在的班级信息
	*@param int $crid教室编号
	*@param int $uid 用户编号
	*/
	public function getClassByUid($crid,$uid,$needlist=false) {
		if(empty($crid) || empty($uid)){
			return FALSE;
		}
		$sql = "SELECT cs.classid,c.classname,c.grade,c.district,c.headteacherid from  ebh_classstudents cs ".
				"JOIN ebh_classes c on (c.classid = cs.classid) ".
				"WHERE c.crid=$crid and cs.uid = $uid";
		if($needlist === TRUE){
			$classinfo = $this->db->query($sql)->list_array();
		}else{
			$classinfo = $this->db->query($sql)->row_array();
		}
		return $classinfo;
	}
	
	/**
	 * 获取学生用户所有的班级id
	 */
	public function getClassidsByUid($crid,$uid){
		if(empty($crid) || empty($uid)){
			return FALSE;
		}
		$sql = "SELECT cs.classid,c.classname,c.grade,c.district,c.headteacherid from  ebh_classstudents cs ".
				"JOIN ebh_classes c on (c.classid = cs.classid) ".
				"WHERE c.crid=$crid and cs.uid = $uid";
		$classes = $this->db->query($sql)->list_array();
		$classids = array();
		if(!empty($classes)){
			foreach ($classes as $cla){
				$classids[] = $cla['classid'];
			}
		}
		return $classids;
	}
	
	/*
	获取学校班级列表与作业数
	*/
	public function getRoomClassListExamCount($param) {
        $sql = 'select c.classid,c.classname,c.stunum,st.count,st.quescount,st.lastexamdate from ebh_classes c 
				left join (select se.classid,count(*) as count,sum(se.quescount) as quescount,max(se.dateline) as lastexamdate from ebh_schexams se where se.crid ='.$param['crid'].' group by se.classid) st on (st.classid=c.classid)';
                // 'where c.crid='.$param['crid'].' and c.`status`=0 order by c.classid';
		if(!empty($param['uid'])){
			$sql.='join ebh_classteachers ct on(ct.classid = c.classid)';
			$wherearr[]= 'ct.uid='.$param['uid'];
		}
		$wherearr[]= 'c.crid='.$param['crid'];
		$wherearr[]= 'c.`status`=0';
		$sql.=' where '.implode(' AND ',$wherearr);
		$sql.=' order by c.classid';
        return $this->db->query($sql)->list_array();
    }
	/**
	*获取教室下默认的班级信息，一般是最新添加的班级
	*/
	public function getDefaultClass($crid,$grade=0,$district=0) {
		if(!empty($grade) || !empty($district)){
			$sql = "select classid,classname from ebh_classes where crid=$crid and status=0 and grade=$grade and district=$district order by classid asc limit 1";
		}else{
			$sql = "select classid,classname from ebh_classes where crid=$crid and status=0 order by classid asc limit 1";
		}
		return $this->db->query($sql)->row_array();

	}
	
	/*
	按班级名(和crid)获取班级信息
	*/
	public function getClassByClassname($param){
		if( empty($param['crid']) || empty($param['classname']) )
			return false;
		$sql = 'select classid from ebh_classes where crid='.$param['crid'].' and classname=\''.$this->db->escape_str($param['classname']).'\'';
		return $this->db->query($sql)->row_array();
	}
	
	/*
	添加一个教师到班级
	*/
	public function addTeacherToClass($classtarr){
		// $ctarr = array('uid'=>$param['tid'],'classid'=>$param['classid']);
		// $this->db->insert('ebh_classteachers',$ctarr);
		$sql = 'insert into ebh_classteachers (uid,classid) values ';
		$oldsql = $sql;
		foreach($classtarr as $teacher){
			if(!empty($teacher['classidarr'])){
				foreach($teacher['classidarr'] as $classid){
					// $classid = $teacher['classid'];
					$uid = $teacher['uid'];
					$sql.= "($uid,$classid),";
				}
			}
		}
		if($sql == $oldsql){
			return;
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}
	
	public function addMultipleStudent($classarr){
		$sql = 'insert into ebh_classstudents (uid,classid) values ';
		$uniqueclasses = array();
		foreach($classarr as $class){
			$classid = $class['classid'];
			$uid = $class['uid'];
			$sql.= "($uid,$classid),";
			if(!isset($uniqueclasses[$classid])){
				$uniqueclasses[$classid]=1;
			}
			else{
				$uniqueclasses[$classid]++;
			}
		}
		$crid = $classarr[0]['crid'];
		$stunum = count($classarr);
		foreach($uniqueclasses as $k=>$v){
			$this->db->update('ebh_classes',array(),array('classid'=>$k),array('stunum'=>'stunum+'.$v));
		}
		$this->db->update('ebh_classrooms',array(),array('crid'=>$crid),array('stunum'=>'stunum+'.$stunum));
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}

	//获取一个学校下面的所有的年级
	public function getAllGrades($crid = 0){
		if(empty($crid)){
			return false;
		}
		$sql = 'select c.classid,c.classname,grade,district from ebh_classes c where c.grade>0 AND c.crid ='.intval($crid);
		return $this->db->query($sql)->list_array();
	}
	/**
	 *获取一个学校的所有老师布置的作业(包含已经提交的[istj],未提交的[nottj],提交已经批改的[pg])
	 *用于学校导出作业用
	 *
	 */
	public function getschoolexams($crid){
		$sql = 'select c.classname,c.stunum,se.eid,(select count(*) from ebh_schexamanswers scaa where scaa.eid = se.eid and scaa.tid!=0) as pg,se.answercount as tj ,se.title,se.crid,se.classid,se.grade,se.district,se.dateline,u.username,u.realname,f.foldername,se.folderid from ebh_classes  c 
				join ebh_schexams se on c.classid = se.classid   
				join ebh_users u on u.uid = se.uid
				left join ebh_folders f on f.folderid = se.folderid 
				where c.crid = '.$crid.' and se.status= 1 order by se.grade desc';
		return $this->db->query($sql)->list_array();
	}
	public function getstunum($crid,$grade,$district){
		$sql = 'select sum(stunum) as stunum from  ebh_classes  where crid = '.$crid.' AND grade='.$grade.' AND district = '.$district;
		$res =  $this->db->query($sql)->row_array();
		return $res['stunum'];
	}
	/**
	 *获取学校下对应年级所有的班级
	 */
	public function getClasses($param = array(), $set_key = false){
		$sql = 'select * from ebh_classes cs ';
		$whereArr = array();
        $whereArr[] = 'cs.status=0';
		if(!empty($param['crid'])){
			$whereArr[] = 'cs.crid = '.$param['crid'];
		}
		if(!empty($param['grade'])){
			$whereArr[] = 'cs.grade = '.$param['grade'];
		}
		if(!empty($whereArr)){
			$sql.= ' WHERE '.implode(' AND ', $whereArr);
		}
		if ($set_key) {
            return $this->db->query($sql)->list_array('classid');
        }
        return $this->db->query($sql)->list_array();
	}
	
	/*
	升班批量删除原有的班级对应关系,并添加新的对应关系
	*/
	public function studentUpgrade($param,$userlist,$isschool = 0){
		
		$sql = 'select cs.uid,cs.classid from ebh_classstudents cs join ebh_classes c on cs.classid=c.classid join ebh_classrooms cr on cr.crid=c.crid join ebh_users u on u.uid=cs.uid';
		$wherearr[] = ' cr.crid='.$param['crid'];
		$wherearr[] = ' u.username in ('.$param['usernames'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$clsstulist = $this->db->query($sql)->list_array();
		//更新缓存
		$snslib = Ebh::app()->lib('Sns');
		$snslib->delClassUserCacheM($clsstulist);
		$snslib->updateClassUserCacheM($userlist);
		//删除旧的对应
		$csstr = '';
		$oldclassarr = array();
		$dclassarr = array();
		foreach($clsstulist as $cs){
			$dclassarr[$cs['classid']][] = $cs['uid'];
			$classid = $cs['classid'];
			$csstr.= '('.$cs['uid'].','.$classid.'),';
			if(isset($oldclassarr[$classid]))
				$oldclassarr[$classid]++;
			else
				$oldclassarr[$classid] = 1;
		}
		$csstr = rtrim($csstr,',');
		$delsql = 'delete from ebh_classstudents where (uid,classid) in ('.$csstr.');';
		$this->db->query($delsql);
		foreach($oldclassarr as $k=>$v){
			$this->db->update('ebh_classes',array(),array('classid'=>$k),array('stunum'=>'stunum-'.$v));
		}
		//删除旧班级课程权限
		if(!empty($dclassarr) && $isschool != 7){
			foreach ($dclassarr as $key=>$darr){
				$sql = "select folderid from ebh_classcourses where classid = ".$key;
				$folders = $this->db->query($sql)->list_array();
				if(!empty($folders)){
					foreach ($folders as $fd){
						$dfids[] = $fd['folderid'];	
					}
					$sql = "delete from `ebh_userpermisions` where uid in (".implode(',',$darr).") and folderid in (".implode(',',$dfids)." and type = 2) and classid = ".$key;
					$this->db->query($sql,false);
				}
			}
		}
		//增加新的对应
		$newcsstr = '';
		$classarr = array();
		foreach($userlist as $iuser) {
			$uid = $iuser['uid'];
			$classid = $iuser['classid'];
			$newcsstr.= '('.$uid.','.$classid.'),';
			$classarr[$classid][] = $uid;
			if(isset($newclassarr[$classid]))
				$newclassarr[$classid]++;
			else
				$newclassarr[$classid] = 1;
		}
		$newcsstr = rtrim($newcsstr,',');
		$insertsql = 'insert into ebh_classstudents (uid,classid) values '.$newcsstr;
		$this->db->query($insertsql);
		foreach($newclassarr as $k=>$v){
			$this->db->update('ebh_classes',array(),array('classid'=>$k),array('stunum'=>'stunum+'.$v));
		}
		//增加新的班级学生课程权限
		if(!empty($classarr) && $isschool != 7){
			foreach($classarr as $key=>$user){
				$sql = "select folderid from ebh_classcourses where classid = ".$key;
				$flist = $this->db->query($sql)->list_array();
				if(!empty($flist)){
					$dateline = SYSTIME;
					$sql = "insert into ebh_userpermisions (itemid,type,uid,crid,folderid,dateline,classid) values ";
					foreach ($flist as $folder){
						foreach ($user as $uid){
							$sql .= "("."0,2,".$uid.",".$param['crid'].",".$folder['folderid'].",".$dateline.",".$key."),";
						}
					}
					$sql = rtrim($sql,',');
					$this->db->query($sql,false);
				}
			}
		}
	}
	/**
	 *获取一个班级的老师
	 *
	 */
	public function getClassTeacherByClassid($classid = 0){
		$sql = 'select uid,classid,folderid from ebh_classteachers where classid = '.$classid;
		return $this->db->query($sql)->list_array();
	}

	public function getClassTeacherUid($classid = 0){
		$sql = 'select uid from ebh_classteachers where classid = '.$classid;
		return $this->db->query($sql)->list_array();
	}
	/*
	班级学生的id
	*/
	public function getClassStudentUid($classid = 0){
		$sql = 'select uid from ebh_classstudents where classid='.$classid;
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据年级获取学生uid列表
	*/
	public function getStudentListByGrade($crid,$grade,$q='') {
		if(empty($crid) || empty($grade))
			return FALSE;
		$classsql = 'select u.face,cs.uid,cs.classid,c.classname,u.groupid from ebh_classstudents cs join ebh_classes c on (cs.classid = c.classid) left join ebh_users u on cs.uid = u.uid where c.crid='.$crid;
        if(!empty($grade)&&$grade != -1){
           $classsql.= ' and c.grade='.$grade;
        }
        if(!empty($q)){
			$q = $this->db->escape_str($q);
			$classsql.= ' and (u.realname like \'%'.$q.'%\' or u.username like \'%'.$q.'%\')';
        }
        $classsql .=' order by c.classid';
		$classlist = $this->db->query($classsql)->list_array();
		if(empty($classlist))
			return FALSE;
		$uidstr = '';
		$studentlist = array();
		foreach($classlist as $myclass) {
			if(empty($uidstr))
				$uidstr = $myclass['uid'];
			else
				$uidstr .= ','.$myclass['uid'];
			$studentlist[$myclass['uid']] = $myclass;
		}
		//获取用户列表
		$usersql = 'select u.uid,u.username,u.realname,u.sex,u.face from ebh_users u where u.uid in ('.$uidstr.')';
        if(!empty($q)){
			$usersql.= ' and (u.realname like \'%'.$q.'%\' or u.username like \'%'.$q.'%\')';
        }
		$userlist = $this->db->query($usersql)->list_array();
		foreach($userlist as $myuser) {
			if(isset($studentlist[$myuser['uid']])) {
				$studentlist[$myuser['uid']]['username'] = $myuser['username'];
				$studentlist[$myuser['uid']]['realname'] = $myuser['realname'];
				$studentlist[$myuser['uid']]['sex'] = $myuser['sex'];
			}
		}
		return $studentlist;

	}
	/*
	批量删除班级学生并移出学校
	*/
	public function deleteMultiStudentFromClass($param,$flag = false){
		$this->db->begin_trans();
		$this->db->delete('ebh_classstudents','classid='.$param['classid'].' and uid in('.$param['uids'].')');
		if(!empty($param['uids'])){
			$sql = 'delete from ebh_roomusers where crid='.$param['crid'].' and uid in ('.$param['uids'].')';
			$this->db->query($sql);
		}
		if($flag){
			$this->db->update('ebh_classes',array('stunum'=>1),array('classid'=>$param['classid']));
		}else{
			$this->db->update('ebh_classes',array('stunum'=>0),array('classid'=>$param['classid']));
		}
		$this->db->update('ebh_classrooms',array(),array('crid'=>$param['crid']),array('stunum'=>'stunum-'.$param['stunum']));
		//清除教师后台添加的权限记录
		$this->db->delete('ebh_userpermisions','crid = '.$param['crid'].' and uid in ('.$param['uids'].') and type = 2 and classid = '.$param['classid']);
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}
	//获取班级信息
	public function getClassInfo($classid = 0){
		$sql = 'select classid,grade,classname,district from ebh_classes where classid = '.$classid;
		return $this->db->query($sql)->row_array();
	}
	//获取班级信息（多个）
	public function getallClassInfo($classid){
		if(empty($classid))
			return false;
		$sql = 'select classid,grade,classname,district from ebh_classes where classid in('.$classid.')';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	获取多个老师的班级数
	*/
	public function getTeachersClassCount($param){
		$sql = 'select count(*) classnum,uid from ebh_classteachers ct
		join ebh_classes c on ct.classid=c.classid';
		if(!empty($param['crid']))
			$wherearr[] = 'c.crid='.$param['crid'];
		if(!empty($param['uids']))
			$wherearr[] = 'ct.uid in ('.$param['uids'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by ct.uid';
		return $this->db->query($sql)->list_array();
	}

	/**
	*获取学校所有学生
	*/
	public function getAllstudent($param) {
		$sql = "SELECT cs.classid,c.classname,c.grade,c.district,u.username,u.realname,u.sex,u.credit,u.face,u.uid from  ebh_classstudents cs ".
				"JOIN ebh_classes c on (c.classid = cs.classid) ".
				"JOIN ebh_users u on (u.uid = cs.uid)".
				" WHERE c.crid= ".$param['crid'];
		if(!empty($param['order'])) {
            $sql .= ' ORDER BY '.$param['order'];
        } else {
            $sql .= ' ORDER BY cs.classid';
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
	*获取学校所有学生数量
	*/
	public function getAllstudentcount($param) {
		$sql = "SELECT count(*) count from  ebh_classstudents cs ".
				"JOIN ebh_classes c on (c.classid = cs.classid) ".
				"JOIN ebh_users u on (u.uid = cs.uid)".
				"WHERE u.status = 1 and c.crid= ".$param['crid'];
        if(isset($param['abegindate'])&&!empty($param['abegindate'])){
            if(empty($param['aenddate'])){
                $sql.= ' and u.dateline > '.$param['abegindate'];
            }
        }
        if(isset($param['aenddate'])&&!empty($param['aenddate'])){
            $sql.= ' and u.dateline < '.$param['aenddate'];
        }
        if(isset($param['sex'])){
            $sql .= ' and u.sex ='.$param['sex'];
        }
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
    /*
     * 获取学校年级学生数
     */
    public function getGradeStudentCount($param){
        $sql = 'select classid from ebh_classes';
        $where = ' where status=0';
        if(!empty($param['grade'])){
            $where .= ' and grade = '.$param['grade'];
        }
        if(!empty($param['crid'])){
            $where .= ' and crid = '.$param['crid'];
        }
        $sql.=$where;
        $classidlist = $this->db->query($sql)->list_array();
        $classid = '';
        foreach($classidlist as &$class){
            if(empty($classid)){
                $classid = $class['classid'];
            }else{
                $classid .= ','.$class['classid'];
            }
        }
        return $this->getClassStudentCount(array('classidlist'=>$classid));
    }
    /**
     * 根据classname获取班级列表
     */
    public function getclasslistbyclassname($crid,$classnamelist){
    	$sql = 'select classname from ebh_classes where classname in ('.$classnamelist.') and crid='.$crid;
    	return $this->db->query($sql)->list_array();
    }
    /**
     * 批量插入班级数据
     */
    public function addMulticlasses($classes){
    	$sql = 'insert into ebh_classes (classname,crid,stunum,dateline) values ';
    	foreach($classes as $class){
    		$crid = $class['crid'];
    		$classname = $class['classname'];
    		$stunum = $class['stunum'];
    		$dateline = $class['dateline'];
    		$sql.= "('".$classname."',$crid,$stunum,$dateline),";
    	}
    	$sql = rtrim($sql,',');
    	$this->db->query($sql);
    	$fromclassid = $this->db->insert_id();
    	return $fromclassid;
    }
    /**
     * 批量插入数据至教师班级关联表
     */
     public function addMultiTeacherClasses($tclasses){
     	$sql = 'insert into ebh_classteachers (uid,classid,folderid) values ';
     	foreach($tclasses as $class){
     		$uid = $class['uid'];
     		$classid = $class['classid'];
     		$folderid = $class['folderid'];
     		$sql.= "($uid,$classid,$folderid),";
     	}
     	$sql = rtrim($sql,',');
     	$this->db->query($sql);
     	$fromclassid = $this->db->insert_id();
     	return $fromclassid;
     }
     /**
      * 根据classid获取老师的uid
      */
     
     public function getteacheridByclassid($classid){
     	if(empty($classid)){
     		return false;
     	}
     	$sql = 'select uid from ebh_classteachers where classid in ('.$classid.')';
     	return $this->db->query($sql)->list_array();
     }
     /**
      * 根据crid获取网校下所有学生
      */
     public function getAllstudentBycrid($param) {
		$sql = "SELECT cs.classid,c.classname,c.grade,c.district,u.username,u.realname,u.sex,u.credit,u.face,u.uid from  ebh_classstudents cs ".
				"JOIN ebh_classes c on (c.classid = cs.classid) ".
				"JOIN ebh_users u on (u.uid = cs.uid)".
				" WHERE c.crid= ".$param['crid'];
		if(!empty($param['order'])) {
            $sql .= ' ORDER BY '.$param['order'];
        } else {
            $sql .= ' ORDER BY cs.classid';
        }
        return $this->db->query($sql)->list_array();
	}
     /**
	*根据年级获取学生uid列表
	*/
	public function getStudentListByGradearr($crid,$grade,$realname='') {
		if(empty($crid) || empty($grade))
			return FALSE;
		$classsql = 'select u.face,cs.uid,cs.classid,c.classname,u.groupid from ebh_classstudents cs join ebh_classes c on (cs.classid = c.classid) left join ebh_users u on cs.uid = u.uid where c.crid='.$crid;
        if(!empty($grade)){
           $classsql.= ' and c.grade in('.$grade.')';
        }
        if(!empty($realname)){
            $classsql.= ' and u.realname like \'%'.$realname.'%\'';
        }
        $classsql .=' order by c.classid';
		$classlist = $this->db->query($classsql)->list_array();
		if(empty($classlist))
			return FALSE;
		$uidstr = '';
		$studentlist = array();
		foreach($classlist as $myclass) {
			if(empty($uidstr))
				$uidstr = $myclass['uid'];
			else
				$uidstr .= ','.$myclass['uid'];
			$studentlist[$myclass['uid']] = $myclass;
		}
		//获取用户列表
		$usersql = 'select u.uid,u.username,u.realname,u.sex,u.face from ebh_users u where u.uid in ('.$uidstr.')';
        if(!empty($realname)){
            $usersql.= ' and u.realname like\'%'.$realname.'%\'';
        }
		$userlist = $this->db->query($usersql)->list_array();
		foreach($userlist as $myuser) {
			if(isset($studentlist[$myuser['uid']])) {
				$studentlist[$myuser['uid']]['username'] = $myuser['username'];
				$studentlist[$myuser['uid']]['realname'] = $myuser['realname'];
				$studentlist[$myuser['uid']]['sex'] = $myuser['sex'];
			}
		}
		return $studentlist;

	}
	/**
	 * 获取网校下的所有班级以及对班级进行搜索
	 */
	public function getSchoolClassList($crid,$limit,$keyword){
		if(empty($crid)){
			return false;
		}
		$sql = 'select c.classid,c.classname,c.stunum from ebh_classes c '.
                'where c.crid='.intval($crid).' and c.`status`=0 ';
		if(!empty($keyword)){
			$sql.= ' and c.classname like \'%'.$this->db->escape_str($keyword).'%\'';
		}
		if(!empty($limit)) {
			$sql .= ' limit '. $limit;
		}
        return $this->db->query($sql)->list_array();
	}
	/**
	 * 获取网校下删选后的班级数量
	 */
	public function getSchoolClassCount($crid,$limit,$keyword){
		if(empty($crid)){
			return false;
		}
		$sql = 'select count(c.classid) as count from ebh_classes c '.
                'where c.crid='.intval($crid).' and c.`status`=0 ';
		if(!empty($keyword)){
			$sql.= ' and c.classname like \'%'.$this->db->escape_str($keyword).'%\'';
		}
		return $this->db->query($sql)->row_array();
	}
	/**
	 * 获取网校下的教师对应所有班级以及对班级进行搜索
	 */
	public function getSchoolClassListByuid($crid,$uid,$limit,$keyword){
		if(empty($crid) || empty($uid)){
			return false;
		}
		$sql = 'SELECT c.classname,c.stunum,c.classid from `ebh_classes` c LEFT JOIN `ebh_classteachers` ct on (ct.classid = c.classid) where c.crid = '.intval($crid).' and ct.uid = '.intval($uid).' and c.`status` = 0';
		if(!empty($keyword)){
			$sql.= ' and c.classname like \'%'.$this->db->escape_str($keyword).'%\'';
		}
		if(!empty($limit)) {
			$sql .= ' limit '. $limit;
		}
        return $this->db->query($sql)->list_array();
	}
	/**
	 * 获取网校下教师对应的删选后的班级数量
	 */
	public function getSchoolClassCountListByuid($crid,$uid,$keyword){
		if(empty($crid) || empty($uid)){
			return false;
		}
		$sql = 'select count(c.classid) as count from `ebh_classes` c LEFT JOIN `ebh_classteachers` ct on (ct.classid = c.classid) where c.crid = '.intval($crid).' and ct.uid = '.intval($uid).' and c.`status` = 0';
		if(!empty($keyword)){
			$sql.= ' and c.classname like \'%'.$this->db->escape_str($keyword).'%\'';
		}
		return $this->db->query($sql)->row_array();
	}
	/**
	 * 获取网校下的班级列表
	 */
	public function getclasslistBycrid($cridstr){
		if(empty($cridstr)){
			return false;
		}
		$sql = 'select classid,classname,stunum,crid from ebh_classes where crid in('.$cridstr.')';
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 获取用户的班级信息
	 */
	public function getClassInfoByCrid($crid,$uidarr){
		if(empty($crid) || empty($uidarr)){
			return false;
		}
		$sql = 'select c.classname,c.classid,cs.uid from `ebh_classes` c left join `ebh_classstudents` cs on(c.classid = cs.classid) where c.crid ='.intval($crid).' and cs.uid in('.implode(',',$uidarr).')';
		return $this->db->query($sql)->list_array();
	}

    /**
     * 跟据学生ID获取班级名称
     * @param $userids
     * @param $crid
     * @return bool
     */
	public function getClassInfoByUserids($userids, $crid) {
        $crid = (int) $crid;
        if ($crid < 1) {
            return false;
        }
        if (!is_array($userids)) {
            $uid = (int) $userids;
            $sql = "SELECT `a`.`uid`,`b`.`classid`,`b`.`classname` 
                    FROM `ebh_classstudents` `a` JOIN `ebh_classes` `b` ON `a`.`classid`=`b`.`classid` 
                    WHERE `a`.`uid`=$uid AND `b`.`crid`=$crid";
            return $this->db->query($sql)->list_array('uid');
        }
        $userids = array_filter($userids, function($userid) {
           return is_numeric($userid) && $userid > 0;
        });
        $userids_str = implode(',', $userids);
        $sql = "SELECT `a`.`uid`,`b`.`classid`,`b`.`classname` 
                FROM `ebh_classstudents` `a` JOIN `ebh_classes` `b` ON `a`.`classid`=`b`.`classid` 
                WHERE `a`.`uid` IN($userids_str) AND `b`.`crid`=$crid";
        return $this->db->query($sql)->list_array('uid');
    }

    /**
     * 根据部门编号获取部门ID
     * @param $crid 网校ID
     * @param $code 部门编号
     * @return mixed
     */
    public function getDeptByCode($crid, $code) {
	    $crid = intval($crid);
	    $code = intval($code);
	    $sql = 'SELECT `classid` FROM `ebh_classes` WHERE `crid`='.$crid.' AND `code`='.$code.' LIMIT 1';
	    return $this->db->query($sql)->row_array();
    }

    /**
     * 获取学员所在班级ID
     * @param $uids
     * @param $crid
     * @return array
     */
    public function getStudentClassId($uids, $crid) {
        if (is_array($uids)) {
            $uids = array_map('intval', $uids);
        } else {
            $uids = array(intval($uids));
        }
        if (empty($uids)) {
            return array();
        }
        $uids = implode(',', $uids);
        $sql = 'SELECT `a`.`uid`,`a`.`classid` FROM `ebh_classstudents` `a` 
            LEFT JOIN `ebh_classes` `b` ON `a`.`classid`=`b`.`classid` 
            WHERE `b`.`crid`='.intval($crid).' AND `a`.`uid` IN('.$uids.')';
        return $this->db->query($sql)->list_array();
    }

	/**
	 * 班级学生的id
	 * @param $classid array or int
	 * @return array
	 */
	public function getStudentUidByClassid($classid = 0){
		if (is_array($classid)) {
            $classids = array_map('intval', $classid);
        } else {
            $classids = array(intval($classid));
        }
        foreach ($classids as $key=>$value) {
        	if (empty($value))
        		unset($classids[$key]);
        }
        if (empty($classids)) {
            return array();
        }
        $classids = implode(',', $classids);
		$sql = 'select distinct uid from ebh_classstudents where classid in('.$classids.') and uid > 0';
		return $this->db->query($sql)->list_array();
	}

	/* start 部门*/
    /**
     * 获取部门列表
     * @param $crid
     * @return mixed
     */
    public function getDeptmentList($crid) {
        $sql = 'SELECT `classid`,`classname`,`category`,`superior`,`displayorder` FROM `ebh_classes` WHERE `crid`='.intval($crid);
        return $this->db->query($sql)->list_array('classid');
    }

    /**
     * 添加部门
     * @param $crid 网校ID
     * @param $param 部门参数
     * @return bool 添加成功返回ID
     */
    public function addDeptment($crid, $param) {
        $crid = intval($crid);
        $superior = intval($param['superior']);
        if ($crid < 1 || empty($param['classname']) || $superior < 0 || empty($param['path'])) {
            return false;
        }
        $code = intval($param['code']);
        $lft = intval($param['lft']);
        $rgt = intval($param['rgt']);
        $category = intval($param['category']) == 1 ? 1 : 0;
        //验证唯一性
        $wheres = array(
            '`code`='.$code,
            '`lft`='.$lft,
            '`rgt`='.$rgt,
            '`classname`'
        );
        if ($category == 0) {
            //判断上级部门是否存在
            $exists = $this->db->query(
                'SELECT `classid` FROM `ebh_classes` WHERE `crid`='.$crid.' AND `classid`='.$superior)
                ->row_array();
            if (empty($exists)) {
                return false;
            }
            //判断唯一性
            $exists = $this->db->query(
                'SELECT `classid` FROM `ebh_classes` WHERE `crid`='.$crid.' AND (`code`='.$code.' OR `path`='.$this->db->escape($param['path']).' OR `classname`='.$this->db->escape($param['classname']).' OR `lft`='.$lft.' OR `rgt`='.$rgt.')')
                ->row_array();
            if (!empty($exists)) {
                return false;
            }
        }

        $sets = array(
            'crid' => $crid,
            'classname' => $param['classname'],
            'dateline' => SYSTIME,
            'category' => $category,
            'path' => $param['path'],
            'code' => $code,
            'lft' => $lft,
            'rgt' => $rgt,
            'superior' => $superior
        );
        return $this->db->insert('ebh_classes', $sets);
    }

    /**
     * 重置部门数据
     * @param $depts 部门数组
     * @param $crid 所在网校
     * @return bool
     */
    public function resetDeptment($depts, $crid) {
        if (!is_array($depts)) {
            return false;
        }
        $categorys = $superiors = $lfts = $rgts = $paths = $whens = $codes = array();
        $code = 1001;
        foreach ($depts as $dept) {
            $categorys[] = ' WHEN '.$dept['classid'].' THEN '.$dept['category'];
            $superiors[] = ' WHEN '.$dept['classid'].' THEN '.$dept['superior'];
            $lfts[] = ' WHEN '.$dept['classid'].' THEN '.$dept['lft'];
            $rgts[] = ' WHEN '.$dept['classid'].' THEN '.$dept['rgt'];
            $paths[] = ' WHEN '.$dept['classid'].' THEN '.$this->db->escape($dept['path']);
            if ($dept['category'] == 0) {
                $codes[] = ' WHEN '.$dept['classid'].' THEN '.($code++);
            } else {
                $codes[] = ' WHEN '.$dept['classid'].' THEN 0';
            }
            $whens[] = $dept['classid'];
        }
        $sql = 'UPDATE `ebh_classes` SET `category`=CASE `classid`'.implode('', $categorys).
            ' END,`superior`=CASE `classid`'.implode('', $superiors).
            ' END,`lft`=CASE `classid`'.implode('', $lfts).
            ' END,`rgt`=CASE `classid`'.implode('', $rgts).
            ' END,`code`=CASE `classid`'.implode('', $codes).
            ' END,`path`=CASE `classid`'.implode('', $paths).
            ' END WHERE `classid` IN('.implode(',', $whens).') AND `crid`='.intval($crid);
        return $this->db->query($sql, false);
    }
    /* end 部门*/

    /**
     * 批量添加班级学生
     * @param $param
     * @return bool
     */
    public function addManyClassStudents($param){
        if(empty($param)){
            return FALSE;
        }
        $res = [];
        foreach($param as $user){
            array_push($res,$this->db->insert('ebh_classstudents',$user));
        }
        return $res;

    }
}
