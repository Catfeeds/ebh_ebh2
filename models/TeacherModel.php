<?php

/*
  教师
 */

class TeacherModel extends CModel {
    /*
      教师列表
      @param array $param
      @return array
     */

    public function getteacherlist($param) {
        $wherearr = array();
        $sql = 'select u.uid,u.realname,u.username,u.nickname,u.citycode,u.status,u.mobile,u.credit,u.logincount,t.tag,t.phone,t.agency,a.realname as agentname from ebh_teachers t left join ebh_users u on t.teacherid=u.uid left join ebh_agents a on t.agentid=a.agentid';
        if (!empty($param['q']))
            $wherearr[] = ' ( u.realname like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        $sql.=' order by teacherid desc';
        if (!empty($param['limit']))
            $sql.= ' limit ' . $param['limit'];

        return $this->db->query($sql)->list_array();
    }

    /*
      教师总数
      @param array $param
      @return int
     */

    public function getteachercount($param) {
        $wherearr = array();
        $sql = 'select count(*) count from ebh_teachers t left join ebh_users u on t.teacherid=u.uid';
        if (!empty($param['q']))
            $wherearr[] = ' ( u.realname like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
        if (!empty($wherearr))
            $sql.= ' WHERE ' . implode(' AND ', $wherearr);
        //var_dump($sql);
        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }
	/**
	* 添加教师的课件数
	* @param int uid 教师用户编号
	* @param int num 添加的课件数量
	*/
	public function addcoursenum($uid,$num = 1) {
		if (empty($uid)) {
			return false;
		}
		$where = 'teacherid='.$uid;
        $setarr = array('cwcount'=>'cwcount+'.$num);
        $this->db->update('ebh_teachers',array(),$where,$setarr);
	}
    /*
      修改教师信息(同时修改对应user表信息)
      $param array $param
      @return int
     */

    public function editteacher($param) {
        $afrows = FALSE;    //影响行数
        $userarr = array();
        //修改user表信息
        if (!empty($param['password']))
            $userarr['password'] = md5($param['password']);
        if (isset($param['status']))
            $userarr['status'] = $param['status'];
        if (isset($param['realname']))
            $userarr['realname'] = $param['realname'];
        if (isset($param['nickname']))
            $userarr['nickname'] = $param['nickname'];
        if (isset($param['sex']))
            $userarr['sex'] = $param['sex'];
        /*if (isset($param['mobile']))
            $userarr['mobile'] = $param['mobile'];
        if (isset($param['email']))
            $userarr['email'] = $param['email'];*/
        if (isset($param['citycode']))
            $userarr['citycode'] = $param['citycode'];
        if (isset($param['address']))
            $userarr['address'] = $param['address'];

        if (isset($param['face'])){
			if(!is_array($param['face']))
				$userarr['face'] = $param['face'];
			else
				$userarr['face'] = $param['face']['upfilepath'];
		}
        $wherearr = array('uid' => $param['uid']);
        if (!empty($userarr)) {
            $afrows = $this->db->update('ebh_users', $userarr, $wherearr);
        }
        //修改teacher表信息
        $teacherarr = array();
		
        if (isset($param['realname']))
            $teacherarr['realname'] = $param['realname'];
		if (isset($param['nickname']))
            $teacherarr['nickname'] = $param['nickname'];
        if (isset($param['phone']))
            $teacherarr['phone'] = $param['phone'];
		if (isset($param['fax']))
            $teacherarr['fax'] = $param['fax'];
		if (isset($param['sex']))
            $teacherarr['sex'] = $param['sex'];
		if (isset($param['mobile']))
            $teacherarr['mobile'] = $param['mobile'];
        if (isset($param['citycode']))
            $teacherarr['address'] = $param['citycode'];
        if (isset($param['message']))
            $teacherarr['message'] = $param['message'];
        if (isset($param['schoolage']))
            $teacherarr['schoolage'] = $param['schoolage'];
        if (isset($param['tag']))
            $teacherarr['tag'] = $param['tag'];
        if (isset($param['profile']))
            $teacherarr['profile'] = $param['profile'];
		if (isset($param['vitae']))
            $teacherarr['vitae'] = $param['vitae'];
		if (isset($param['profitratio']))
            $teacherarr['profitratio'] = $param['profitratio'];
        if (isset($param['bankcard']))
            $teacherarr['bankcard'] = $param['bankcard'];
        if (isset($param['agency']))
            $teacherarr['agency'] = $param['agency'];
        if(isset($param['agentid'])){
        	$teacherarr['agentid'] = $param['agentid'];
        }
        if(isset($param['degree'])){
        	$teacherarr['degree'] = $param['degree'];
        }
        if(isset($param['graduateschool'])){
        	$teacherarr['graduateschool'] = $param['graduateschool'];
        }
		if(isset($param['birthdate'])){
			$teacherarr['birthdate'] = $param['birthdate'];
		}
        if(isset($param['workunit'])){
        	$teacherarr['workunit'] = $param['workunit'];
        }
        if(isset($param['department'])){
        	$teacherarr['department'] = $param['department'];
        }
        if(isset($param['professionaltitle'])){
        	$teacherarr['professionaltitle'] = $param['professionaltitle'];
        }
        if(isset($param['position'])){
        	$teacherarr['position'] = $param['position'];
        }
		
        $wherearr = array('teacherid' => $param['uid']);
        if (!empty($teacherarr)) {
//echo json_encode(array($teacherarr,$wherearr));exit;
            $afrows += $this->db->update('ebh_teachers', $teacherarr, $wherearr);
        }
        return $afrows;
    }

    /*
      教师详情
      @param int $uid
      @return array
     */

    public function getteacherdetail($uid) {
    	if (empty($uid)) {
			return false;
		}
        $sql = 'select rt.mobile tmobile,u.uid,u.username,u.realname,u.nickname,u.face,u.citycode,u.address,u.email,u.mysign,t.tag,t.schoolage,u.sex,t.phone,u.mobile,t.profile,t.fax,t.schoolage,t.message,t.bankcard,t.profitratio,t.vitae,t.agentid,t.agency,t.degree,t.graduateschool,t.birthdate,t.workunit,t.department,t.professionaltitle,t.position from ebh_users u left join ebh_teachers t on u.uid = t.teacherid left join ebh_roomteachers rt on t.teacherid=rt.tid where teacherid = ' . $uid;
        return $this->db->query($sql)->row_array();
    }

    /*
      删除教师
      @param int $uid
      @return bool
     */

    public function deleteteacher($uid) {
    	if (empty($uid)) {
			return false;
		}
		$this->db->begin_trans();
		$this->db->delete('ebh_teachers','teacherid='.$uid);
		$this->db->delete('ebh_users','uid='.$uid);
		$sql = 'select crid from ebh_roomteachers where tid='.$uid;
		$cridarr = $this->db->query($sql)->row_array();
		if(!empty($cridarr)){
			$this->db->delete('ebh_roomteachers','tid='.$uid);
			foreach($cridarr as $crid)
				$this->db->update('ebh_classrooms', array(), array('crid' => $crid), array('teanum' => 'teanum-1'));
		}
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
    }

    /*
      添加教师
      @param array $param
      @return int
     */

    public function addteacher($param) {
		if(!empty($param['username']))
			$userarr['username'] = $param['username'];
		if(!empty($param['password']))
			$userarr['password'] = md5($param['password']);
		if (!empty($param['mpassword']))	//md5加密后的用户密码
                $userarr['password'] = $param['mpassword'];
		if(!empty($param['realname']))
			$userarr['realname'] = $param['realname'];
		if(isset($param['nickname']))
			$userarr['nickname'] = $param['nickname'];
		if(!empty($param['dateline']))
			$userarr['dateline'] = $param['dateline'];
		if(isset($param['sex']))
			$userarr['sex'] = $param['sex'];
		if(!empty($param['mobile']))
			$userarr['mobile'] = $param['mobile'];
		if(!empty($param['citycode']))
			$userarr['citycode'] = $param['citycode'];
        //$userarr['address'] = $param['address'];
        //$userarr['email'] = $param['email'];
		if(!empty($param['face']))
			$userarr['face'] = $param['face'];
		$userarr['status'] = 1;
		$userarr['groupid'] = 5;
        //var_dump($userarr);
        $uid = $this->db->insert('ebh_users', $userarr);
        if ($uid) {
            $teacherarr['teacherid'] = $uid;
			if(!empty($param['realname']))
				$teacherarr['realname'] = $param['realname'];
			if(isset($param['nickname']))
				$teacherarr['nickname'] = $param['nickname'];
			if(isset($param['sex']))
				$teacherarr['sex'] = $param['sex'];
            //$teacherarr['birthdate'] = $param['birthdate'];
			if(!empty($param['phone']))
				$teacherarr['phone'] = $param['phone'];
			if(!empty($param['mobile']))
				$teacherarr['mobile'] = $param['mobile'];
            //$teacherarr['native'] = $param['native'];
            //$teacherarr['citycode'] = $param['citycode'];
			if(!empty($param['citycode']))
				$teacherarr['address'] = $param['citycode'];
            //$teacherarr['msn'] = $param['msn'];
            //$teacherarr['qq'] = $param['qq'];
            //$teacherarr['email'] = $param['email'];
            //$teacherarr['face'] = $param['face'];
			if(!empty($param['vitae']))
				$teacherarr['vitae'] = $param['vitae'];
			if(!empty($param['fax']))
				$teacherarr['fax'] = $param['fax'];
			if(!empty($param['tag']))
				$teacherarr['tag'] = $param['tag'];
			if(isset($param['schoolage']))
				$teacherarr['schoolage'] = $param['schoolage'];
			if(!empty($param['profile']))
				$teacherarr['profile'] = $param['profile'];
            //var_dump($teacherarr);
            if(isset($param['profitratio']))
            $teacherarr['profitratio'] = $param['profitratio'];
        	if(isset($param['bankcard']))
            $teacherarr['bankcard'] = $param['bankcard'];
        	if(isset($param['agentid'])){
        		$teacherarr['agentid'] = $param['agentid'];
        	}
        	if (isset($param['agency']))
            	$teacherarr['agency'] = $param['agency'];
            if (isset($param['message']))
            $teacherarr['message'] = $param['message'];
            $res = $this->db->insert('ebh_teachers', $teacherarr);
            //var_dump($uid.'___'.$res.'````');
            
        }return $uid;
    }

    /*
      代理商列表
      @return array
     */

    public function getagentlist() {
        $sql = 'select u.uid,u.username from ebh_users u join ebh_agents a on a.agentid=u.uid order by uid desc';
        return $this->db->query($sql)->list_array();
    }
	
	
	/*
	获取班级的教师列表
	@param int $crid
	*/
	public function getclassteacherlist($crid){
		if (empty($crid)) {
			return false;
		}
		$sql = 'select ct.*,u.username,u.realname,c.crid 
			from ebh_classteachers ct 
			join ebh_users u on (u.uid = ct.uid) 
			join ebh_classes c on (c.classid = ct.classid) 
			where c.crid='.$crid;
		return $this->db->query($sql)->list_array();
	}
	/*
	获取学校的教师列表
	@param int $crid
	@param array $param
	*/
	public function getroomteacherlist($crid,$param){
		$sql = 'SELECT u.credit,u.sex,u.face,u.mobile,u.uid,u.username,t.teacherid,t.realname,0 as folderid 
			from ebh_roomteachers rt 
			join ebh_users u on(rt.tid=u.uid) 
			join ebh_teachers t on(t.teacherid=u.uid)';
		if (isset($param['groupid']))
		{
			$sql = 'SELECT u.sex,u.face,u.mobile,u.uid,u.username,t.teacherid,t.realname,tg.groupid,0 as folderid 
			from ebh_roomteachers rt 
			join ebh_users u on(rt.tid=u.uid) 
			join ebh_teachers t on(t.teacherid=u.uid) 
			left join ebh_teachergroups tg on t.teacherid=tg.tid';
		}
		$wherearr[] = 'rt.crid='.$crid;
		if (!empty($param['q']))
            $wherearr[] = ' (u.username like \'%' . $this->db->escape_str($param['q']) . '%\' or u.realname like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if(isset($param['schoolname'])){
			$wherearr[] = 'u.schoolname = \''.$this->db->escape_str($param['schoolname']).'\'';
		}
		if(!empty($param['uid'])){
			$wherearr[] = 'u.uid = '.$param['uid'];
		}
		if(!empty($param['uids'])){
			$wherearr[] = 'u.uid in ('.implode(',',$param['uids']).')';
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else {
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
	
	/*
	获取学校的教师数量
	@param int $crid
	@param array $param
	*/
	public function getroomteachercount($crid,$param){
		$sql = 'select count(*) count from ebh_roomteachers rt
			join ebh_users u on(rt.tid=u.uid) 
			join ebh_teachers t on(t.teacherid=u.uid)';
		$wherearr[] = 'rt.crid='.$crid;
		if (!empty($param['q']))
            $wherearr[] = ' (u.username like \'%' . $this->db->escape_str($param['q']) . '%\' or u.realname like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	/*
	添加学校教师
	@param array $param
	*/
	public function addroomteacher($param){
		if(!empty($param['tid']))
			$setarr['tid'] = $param['tid'];
		if(!empty($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(isset($param['status']))
			$setarr['status'] = $param['status'];
		if(!empty($param['cdateline']))
			$setarr['cdateline'] = $param['cdateline'];
		if(!empty($param['role']))
			$setarr['role'] = $param['role'];
		$this->db->update('ebh_classrooms',array(),array('crid'=>$param['crid']),array('teanum'=>'teanum+1'));
		return $this->db->insert('ebh_roomteachers',$setarr);
		
	}
	
	/*
	删除学校教师
	@param array $param   tid,crid
	*/
	public function deleteroomteacher($param){
		$wherearr['tid'] = $param['tid'];
		$wherearr['crid'] = $param['crid'];
		$this->db->begin_trans();
		$this->db->update('ebh_classrooms',array(),array('crid'=>$param['crid']),array('teanum'=>'teanum-1'));
		$this->db->delete('ebh_roomteachers',$wherearr);
		$this->db->delete('ebh_teacherfolders',$wherearr);
		$sql = 'select classid from ebh_classes where crid='.$param['crid'];
		$classes = $this->db->query($sql)->list_array();
		if(!empty($classes)){
			$classids ='';
			foreach($classes as $class){
				if(!empty($classids))
					$classids.=','.$class['classid'];
				else
					$classids = $class['classid'];
			}
			$sql = 'delete from ebh_classteachers where uid = '.$param['tid'].' and classid in ('.$classids.')';
			$this->db->query($sql);
		}
		
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
        return TRUE;
		
	}
	
	/*
	学校教师的信息
	@param int $uid
	@param int $crid
	*/
	public function getroomteacherdetail($uid,$crid=0){
		$sql = 'select u.uid,u.username,u.realname,u.mobile'.($crid>0?',r.status':'').' from ebh_users u ';
		if(!empty($uid)){
			$wherearr[] = 'u.uid = '.$uid;
		}
		if($crid > 0){
			$sql .= ' left join ebh_roomteachers r on (r.tid = u.uid) ' ;
			$wherearr[] = 'r.crid='.$crid ;
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();
	}

	//zwx取教师名字
	public function getteachername($uid){
		$sql = 'select realname from ebh_teachers where teacherid = '.$uid;
		return $this->db->query($sql)->row_array();
	}
	
	/*
	获取课程的教师列表
	@param array $param
	*/
	public function getcourseteacherlist($crid){
		$sql = 'select tf.folderid,tf.tid,u.username,u.realname
			from ebh_teacherfolders tf 
			join ebh_users u on tf.tid = u.uid
			join ebh_folders f on f.folderid = tf.folderid
			where tf.crid = '.$crid;
	//echo $sql;
		return $this->db->query($sql)->list_array();
	}

	/*
	大学获取课程的教师列表
	@param array $param
	*/
	public function getcourseteacher($param){
		$sql = 'select tf.folderid,tf.tid,u.username,u.realname,u.face,u.mysign,t.profile,u.sex,u.credit
			from ebh_teacherfolders tf
			join ebh_users u on tf.tid = u.uid
			join ebh_folders f on f.folderid = tf.folderid 
			join ebh_teachers t on u.uid = t.teacherid ';

		if (!empty($param['q']))
            $wherearr[] = ' (u.username like \'%' . $this->db->escape_str($param['q']) . '%\' or u.realname like \'%' . $this->db->escape_str($param['q']) . '%\')';
		if(isset($param['crid'])){
			$wherearr[] = 'tf.crid = '.$param['crid'];
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'f.folderid = '.$param['folderid'];
		}
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else {
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

	/*
	获取教师的课件数
	@param array $param
	*/
	public function getteachercwcount($param){
		// if(!empty($param['crid']))
			// $wherearr['crid'] = $param['crid'];
		$wherearr = array();
		if(!empty($param['uids']))
			$wherearr[] = 'uid in('.$param['uids'].')';
		$sql = 'select count(*) count from ebh_coursewares ';
		$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	/*
	学校教师列表及回答数
	@param array $param
	*/
	public function getRoomTeacherListAnswerCount($param){
		if(!empty($param['startdate']))
			$joinarr[]= 'q.dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$joinarr[]= 'q.dateline<='.$param['enddate'];
		$joinparam = '';
		if(!empty($joinarr))
			$joinparam = ' and '.implode(' AND ',$joinarr);
		$sql = 'select u.username,u.realname,u.uid,count(q.tid) asknum,sum(answered) answernum
			from ebh_users u
			left join ebh_askquestions q on (u.uid=q.tid and q.crid ='.$param['crid'].' '.$joinparam.')
			join ebh_roomteachers rt on(rt.tid=u.uid)';
		
		$wherearr[]= 'rt.crid='.$param['crid'];
		if(!empty($param['uids']))
			$wherearr[] = 'u.uid in('.$param['uids'].')';
		
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by rt.tid';
		// echo $sql;
		return $this->db->query($sql)->list_array();
	}
	
	/*
	学校教师列表及作业数
	@param int $crid
	*/
	public function getRoomTeacherListExamCount($crid){
		$sql = 'SELECT u.uid,u.username,t.teacherid,t.realname,st.count,st.quescount,0 as folderid 
			from ebh_roomteachers rt 
			join ebh_users u on(rt.tid=u.uid) 
			join ebh_teachers t on(t.teacherid=u.uid)
			left join (select se.uid,count(*) as count,sum(se.quescount) as quescount from ebh_schexams se where se.crid ='.$crid.' group by se.uid) st on (st.uid=t.teacherid)
			where rt.crid='.$crid;
		
		return $this->db->query($sql)->list_array();
	}
	/*
	学校教师列表及课件数
	@param int $crid
	*/
	public function getRoomTeacherListCWCount($crid){
		$sql = 'SELECT u.mobile,u.uid,u.username,t.teacherid,t.realname,(select count(*) from ebh_coursewares cw join ebh_roomcourses rc on rc.cwid = cw.cwid where uid = t.teacherid and cw.status = 1 and rc.crid ='.$crid.') as cwcount,0 as folderid 
			from ebh_roomteachers rt 
			join ebh_users u on(rt.tid=u.uid) 
			join ebh_teachers t on(t.teacherid=u.uid)
			where rt.crid='.$crid;
		
		return $this->db->query($sql)->list_array();
	}
/**
     *获取教师的select控件
     *@author zkq
     *@param String $name
     *@param String $uid
     *@param int $selected
     *@return String
     */
    public function getTeacherSelect($name='uid',$id='uid',$selected=0){
		$sql = 'select u.uid,u.username from ebh_teachers t join ebh_users u on t.teacherid = u.uid';
        $teacherarr = $this->db->query($sql)->list_array();
        $s='<select name="'.$name.'" id="'.$id.'">';
        foreach ($teacherarr as $tv) {
            if($selected==$tv['uid']){
                $s.='<option value='.$tv['uid'].' selected=selected>'.$tv['username'].'</option>';
            }else{
                $s.='<option value='.$tv['uid'].'>'.$tv['username'].'</option>';
            }
            
        }
        $s.='</select>';
        return $s;
    }
    /**
     *判断教师是否存在
     *@author zkq
     *@param int $teacherid
     *@return  bool
     */
    public function isExits($teacherid=0){
    	$teacherid = intval($teacherid);
    	if(empty($teacherid)){
    		return false;
    	}
    	$sql = 'select count(*) count from ebh_teachers t where t.teacherid = '.$teacherid.' limit 1 ';
    	$res = $this->db->query($sql)->row_array();
    	if(empty($res['count'])){
    		return false;
    	}else{
    		return true;
    	}
    }
	
	public function addMultipleTeachers($tarr,$crid,$offset = 1){
		$teanum = count($tarr);
		$sql='insert into ebh_users (username,password,realname,dateline,status,groupid,sex,schoolname) values ';
		foreach($tarr as $user){
			$username = $user['username'];
			$password = md5($user['password']);
			$realname = $user['realname'];
			$dateline = SYSTIME;
			$status = 1;
			$groupid = 5;
			$sex = $user['sex'];
			$schoolname = $user['schoolname'];
			$sql.= "('$username','$password','$realname',$dateline,$status,$groupid,$sex,'$schoolname'),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		$fromuid = $this->db->insert_id();
		if (empty($offset))
			$offset = 1;
		$sql = 'insert into ebh_teachers (teacherid,realname) values ';
		for($i=0;$i<$teanum;$i++){
			$teacherid = $fromuid + $i*$offset;
			$realname = $tarr[$i]['realname'];
			$sql.= "($teacherid,'$realname'),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		
		$sql = 'insert into ebh_roomteachers (crid,tid,status,cdateline,role,mobile) values ';
		for($i=0;$i<$teanum;$i++){
			$tid = $fromuid + $i*$offset;
			$status = 1;
			$cdateline = SYSTIME;
            $mobile = $tarr[$i]['mobile'];
			$role = 1;
			$mobile = $tarr[$i]['mobile'];
			$sql.= "($crid,$tid,$status,$cdateline,$role,'$mobile'),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		
		$this->db->update('ebh_classrooms',array(),array('crid'=>$crid),array('teanum'=>'teanum+'.$teanum));
		return $fromuid;
		
	}
	/**
	 *返回教室老师select控件
	 *@param int $crid
	 *@param String $attr 用户自定义节点
	 *@param int $seleted 默认选中的老师uid
	 *@param int $hidden 不需要显示的老师的uid
	 */
	public function getSchoolTeacherSelect($crid,$attr='',$selected=-1,$hidden=-1,$hasqxz=true){
		$sql = 'select u.uid,u.username,u.realname from ebh_roomteachers rt 
				left join ebh_teachers t on rt.tid = t.teacherid
				left join ebh_users u on t.teacherid = u.uid 
				WHERE rt.crid = '.intval($crid);
		$teachers = $this->db->query($sql)->list_array();
		$s = '<select '.$attr.'>';
		if($hasqxz===true){
			$s.='<option value="">请选择</option>';
		}
		foreach ($teachers as $teacher) {
			if($teacher['uid']==$hidden){
				continue;
			}
			$realname = empty($teacher['realname'])?'':'('.$teacher['realname'].')';
			if($teacher['uid']==$selected){
				$s.='<option selected=selected value="'.$teacher['uid'].'">'.$teacher['username'].$realname.'</option>';
			}else{
				$s.='<option value="'.$teacher['uid'].'">'.$teacher['username'].$realname.'</option>';
			}
			
		}
		$s.='</select>';
		return $s;
	}
	
	/*
	获取教师的年级信息
	*/
	public function getTeacherGradeList($crid){
		$sql = 'select u.realname,ct.uid,c.classid,c.grade from ebh_classteachers ct '.
			'join ebh_classes c on (ct.classid = c.classid) '.
			'join ebh_users u on (ct.uid=u.uid)'.
			'where c.crid='.$crid.' and c.status=0 order by grade desc,uid';
		return $this->db->query($sql)->list_array();
	}

	//根据用户名获取教师信息
	public function getteacherbyusername($username) {
        $sql = 'select u.uid,u.username,u.password,u.realname,u.nickname,u.face,u.citycode,u.address,u.email,u.mysign,t.tag,t.schoolage,u.sex,t.phone,u.mobile,t.teacherid,t.profile,t.fax,t.schoolage,t.message,t.bankcard,t.profitratio,t.vitae,t.agentid,t.agency,t.address 
                from ebh_users u left join ebh_teachers t on u.uid = t.teacherid 
                where username = \'' . $this->db->escape_str($username).'\'  limit 1';
        if(preg_match("/^1[34578]\d{9}$/", $username)){
            $sql = 'select u.uid,u.username,u.password,u.realname,u.nickname,u.face,u.citycode,u.address,u.email,u.mysign,t.tag,t.schoolage,u.sex,t.phone,u.mobile,t.teacherid,t.profile,t.fax,t.schoolage,t.message,t.bankcard,t.profitratio,t.vitae,t.agentid,t.agency,t.address
                from ebh_users u left join ebh_teachers t on u.uid = t.teacherid
                where username = \'' . $this->db->escape_str($username).'\' or u.mobile= \'' . $this->db->escape_str($username).'\' limit 1';
        }
        return $this->db->query($sql)->row_array();
    }

    //判断教师是否在教室里
    public function isTeacherHasInRoom($uid = 0,$crid = 0){
    	$sql = 'select count(1) count from ebh_roomteachers rt where rt.tid = '.$uid.' AND rt.crid = '.$crid;
    	$res = $this->db->query($sql)->row_array();
    	return $res['count'];
    }
    
    /**
     * 批量导入教师账号
     */
    public function addMultipleTeacher($teachers){
    	$sql = 'insert into ebh_teachers (teacherid,realname,nickname,sex) values ';
		if(!empty($teachers)){
			foreach($teachers as $teacher){
				$teacherid = $teacher['teacherid'];
				$realname = $teacher['realname'];
				$nickname = $teacher['nickname'];
				$sex = $teacher['sex'];
				$sql .= "(".$teacherid.",'".$realname."','".$nickname."'".",$sex),";
			}
			$sql = rtrim($sql,',');
			$this->db->query($sql);
		}
    }

    /**
     * 助教老师
     * @param $crid 网校ID
     * @param $filter_uid 过滤的用户ID
     * @param bool $is_filter_empty 是否过滤空组
     * @return array
     */
    public function getTeachersGroupBy($crid, $filter_uid, $is_filter_empty = false) {
        $crid = (int) $crid;
        $sql = "SELECT `groupid`,`groupname` FROM `ebh_tgroups` WHERE `crid`=$crid";
        $group = $this->db->query($sql)->list_array('groupid');
        if (empty($group) === true) {
            $group = array();
        }

        $sql = "SELECT `t`.`realname`,`t`.`sex`,`u`.`uid`,`u`.`username`,`u`.`face`,0 AS `groupnum` FROM ".
            "`ebh_roomteachers` AS `rt` LEFT JOIN `ebh_teachers` AS `t` ON `rt`.`tid`=`t`.`teacherid`".
            " LEFT JOIN `ebh_users` AS `u` ON `rt`.`tid`=`u`.`uid` WHERE `rt`.`crid`=$crid AND `rt`.`status`=1";
        $teachers = $this->db->query($sql)->list_array('uid');

        if ($filter_uid > 0) {
            unset($teachers[$filter_uid]);
        }

        $sql = "SELECT `groupid`,`tid` FROM `ebh_teachergroups` WHERE `crid`=$crid";
        $g = $this->db->query($sql)->list_array();
        if (empty($g) == true) {
            $group['other'] = array(
                'groupname' => '未分组',
                'teacherlist'=> $teachers
            );
            return $group;
        }

        foreach ($g as $gitem) {
            if (key_exists($gitem['groupid'], $group) === false) {
                continue;
            }
            if (key_exists('teacherlist', $group[$gitem['groupid']]) === false) {
                $group[$gitem['groupid']]['teacherlist'] = array();
            }
            if (key_exists($gitem['tid'], $teachers) === true) {
                $group[$gitem['groupid']]['teacherlist'][] =  $teachers[$gitem['tid']];
                $teachers[$gitem['tid']]['groupnum']++;
            }
        }
        $ungrouped_teachers = array_filter($teachers, function($e) {
            return $e['groupnum'] == 0;
        });
        if (empty($ungrouped_teachers) === false) {
            $group['other'] = array(
                'groupname' => '未分组',
                'teacherlist'=> $ungrouped_teachers
            );
        }
        if ($is_filter_empty) {
            $group = array_filter($group, function($e) {
                return empty($e['teacherlist']) === false;
            });
        }
        return $group;
    }

    /**
     *根据老师的uid,和网校得到班级列表
     * @param int $uid int $crid
     * @return array
     */
	function getTeacherClasses($uid,$crid){
		$uid = intval($uid);
		$crid = intval($crid);
		if ($uid && $crid) {
			$sql = 'select c.classid,c.classname,c.grade,c.district FROM ebh_classteachers ct left JOIN ebh_classes c on ct.classid = c.classid where uid='.$uid.' and crid='.$crid;
			$result = $this->db->query($sql)->list_array();
			return $result;
		} else {
			return array();
		}
	}
	
	/*
	查看教师是否和课程关联，判断权限用
	*/
	public function checkTeacherFolder($param){
		if(empty($param['folderid']) || empty($param['uid']) || empty($param['crid'])){
			return FALSE;
		}
		if(empty($param['isenterprise'])){//非企业版
			$sql = 'select 1 from ebh_teacherfolders';
			$wherearr[] = 'tid='.$param['uid'];
			$wherearr[] = 'folderid='.$param['folderid'];
			$wherearr[] = 'crid='.$param['crid'];
			$sql.= ' where '.implode(' AND ',$wherearr);
			return $this->db->query($sql)->row_array();
		} else {//企业版
			$sql = 'select distinct c2.classid from ebh_classes c
					join ebh_classteachers ct on c.classid=ct.classid
					join ebh_classes c2 on c2.lft>=c.lft and c2.rgt<=c.rgt';
			$wherearr[] = 'uid='.$param['uid'];
			$wherearr[] = 'c.crid='.$param['crid'];
			$wherearr[] = 'c2.crid='.$param['crid'];
			$sql.= ' where '.implode(' AND ',$wherearr);
			$classids = $this->db->query($sql)->list_array();//教师有权限的部门，部门及下级部门
			if(empty($classids)){
				return FALSE;
			}
			$classids = array_column($classids,'classid');
			$classids = implode(',',$classids);
			$wherearr = array();
			$sql = 'select 1 from ebh_classcourses';
			$wherearr[] = 'folderid='.$param['folderid'];
			$wherearr[] = 'classid in('.$classids.')';
			$sql.= ' where '.implode(' AND ',$wherearr);
			return $this->db->query($sql)->row_array();
		}
	}

	/**
	 *获取教师的网校
	 */
	public function getRoomByUidArr($uidArr=array()) {
		if (empty($uidArr)) {
			return false;
		}
		$sql = 'select uid from ebh_classrooms where uid in('. implode(',', $uidArr).');';
		return $this->db->query($sql)->list_array();
	}

	/*
	获取班级课程的教师列表
	@param arr $param
	*/
	public function getClassFolderTeacherlist($param){
		if (empty($param['folderid']) || empty($param['crid'])) {
			return false;
		}
		$sql = 'select u.username,u.realname,u.uid from ebh_teacherfolders tf left join ebh_users u on u.uid=tf.tid ';
		if (!empty($param['classids'])) {
			$sql .= ' left join ebh_classteachers ct on ct.uid=tf.tid ';
			$wherearr[] = 'ct.classid in('.$param['classids'].')';
		}
		if (!empty($param['q'])) {
            $wherearr[] = ' ( u.realname like \'%' . $this->db->escape_str($param['q']) . '%\' or u.username like \'%' . $this->db->escape_str($param['q']) . '%\')';
		}
		$wherearr[] = 'tf.folderid='.$param['folderid'];
		$wherearr[] = 'tf.crid='.$param['crid'];
		
		$sql .= ' where '.implode(' AND ',$wherearr);
		$sql .= ' group by tf.tid ';
		return $this->db->query($sql)->list_array();
	}
}

?>