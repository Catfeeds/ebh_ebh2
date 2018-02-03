<?php
/**
 * 通知Model类 NoticeModel
 */
class NoticeModel extends CModel{
    /**
     * 获取通知列表
     * @param type $queryarr
     * @return type
     */
    public function getnoticelist($queryarr) {
        $sql = 'SELECT n.noticeid,n.uid,n.crid,n.title,n.message,n.ntype,n.type,n.dateline,n.cids,n.viewnum,u.username,u.realname FROM ebh_notices n '.
                'LEFT JOIN ebh_users u on (u.uid = n.uid) ';
        $wherearr = array();
		$gradestr = '';
		if(!empty($queryarr['needgrade'])){
			$sql2 = 'select grade,district from ebh_classes where classid='.$queryarr['classid'];
			$res = $this->db->query($sql2)->row_array();
			if(!empty($res['grade']))
			$gradestr = 'FIND_IN_SET('.$res['grade'].',n.grades) or ';
		}
		if(!empty($queryarr['needdistrict'])){
			$sql3 = 'select grade,district from ebh_classes where classid='.$queryarr['classid'];
			$res = $this->db->query($sql3)->row_array();
			if(!empty($res))
			$wherearr[] = '(FIND_IN_SET('.$res['district'].',n.districts) or n.districts=\'\')';
		}
        if(!empty($queryarr['crid']))   //所在学校
            $wherearr[] = 'n.crid='.$queryarr['crid'];
		if(!empty($queryarr['uid']))   //发送人编号
            $wherearr[] = 'n.uid='.$queryarr['uid'];
        if(!empty($queryarr['ntype']))  //通知类型,1为全校师生 2为全校教师 3为全校学生 4为班级学生
            $wherearr[] = 'n.ntype in ('.$queryarr['ntype'] .')';
		if(!empty($queryarr['classid']))	//过滤接收通知的班级编号
			$wherearr[] = '('.$gradestr.'FIND_IN_SET('.$queryarr['classid'].',n.cids) or n.ntype in(1,3))';
        if(!empty($queryarr['dateline'])){
        	$wherearr[] = 'n.dateline > '.$queryarr['dateline'];
        }
        if(!empty($queryarr['remind'])){
        	$wherearr[] = 'n.remind= '.$queryarr['remind'];
        }
        if(!empty($wherearr))
            $sql .= ' WHERE '.implode (' AND ', $wherearr);
        if(!empty($queryarr['order']))
            $sql .= ' ORDER BY '.$queryarr['order'];
        else
            $sql .= ' ORDER BY n.dateline desc ';
        if(!empty($queryarr['limit']))
            $sql .= 'limit '.$queryarr['limit'];
        else {
            if(empty($queryarr['page']) || $queryarr['page'] < 1)
                $page = 1;
            else
                $page = $queryarr['page'];
            $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
            $start = ($page - 1) * $pagesize ;
            $sql .= 'limit '.$start.','.$pagesize;
        }
        return $this->db->query($sql)->list_array();
    }
	/**
     * 获取通知列表记录总数
     * @param type $queryarr
     * @return type
     */
    public function getnoticelistcount($queryarr) {
		$count = 0;
        $sql = 'SELECT count(*) count FROM ebh_notices n '.
                'LEFT JOIN ebh_users u on (u.uid = n.uid) ';
        $wherearr = array();
		$gradestr = '';
		if(!empty($queryarr['needgrade'])){
			$sql2 = 'select grade,district from ebh_classes where classid='.$queryarr['classid'];
			$res = $this->db->query($sql2)->row_array();
			if(!empty($res['grade']))
			$gradestr = 'FIND_IN_SET('.$res['grade'].',n.grades) or ';
		}
		if(!empty($queryarr['needdistrict'])){
			$sql3 = 'select grade,district from ebh_classes where classid='.$queryarr['classid'];
			$res = $this->db->query($sql3)->row_array();
			if(!empty($res))
			$wherearr[] = '(FIND_IN_SET('.$res['district'].',n.districts) or n.districts=\'\')';
		}
        if(!empty($queryarr['crid']))   //所在学校
            $wherearr[] = 'n.crid='.$queryarr['crid'];
		if(!empty($queryarr['uid']))   //发送人编号
            $wherearr[] = 'n.uid='.$queryarr['uid'];
        if(!empty($queryarr['ntype']))  //通知类型,1为全校师生 2为全校教师 3为全校学生 4为班级学生
            $wherearr[] = 'n.ntype in ('.$queryarr['ntype'] .')';
		if(!empty($queryarr['classid']))	//过滤接收通知的班级编号
			$wherearr[] = '('.$gradestr.'FIND_IN_SET('.$queryarr['classid'].',n.cids) or n.ntype in(1,3))';
        if(!empty($queryarr['dateline'])){
        	$wherearr[] = 'n.dateline > '.$queryarr['dateline'];
        }
        if(!empty($queryarr['remind'])){
        	$wherearr[] = 'n.remind='.$queryarr['remind'];
        }
        if(!empty($wherearr))
            $sql .= ' WHERE '.implode (' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
			$count = $row['count'];
		return $count;
    }

    /**
     * 获取多个网校通知列表
     * @param type $queryarr
     * @return type
     */
    public function getallnoticelist($queryarr) {
        $sql = 'SELECT n.noticeid,n.uid,n.crid,n.title,n.message,n.ntype,n.type,n.dateline,n.cids,n.viewnum,u.username,u.realname FROM ebh_notices n '.
                'LEFT JOIN ebh_users u on (u.uid = n.uid) ';
        if (empty($queryarr['crids']) || !is_array($queryarr['crids']))
        	return FALSE;
        $multiwhere = array();
        foreach ($queryarr['crids'] as $crid){
        	$myclass = array();
        	$sql2 = 'SELECT cs.classid,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid='.$crid.' and cs.uid = '.$queryarr['uid'];
			$myclass = $this->db->query($sql2)->row_array();
	        $wherearr = array();
			$gradestr = '';

			if(!empty($myclass)){
				if(!empty($queryarr['needgrade'])){
					if(!empty($myclass['grade']))
					$gradestr = 'FIND_IN_SET('.$myclass['grade'].',n.grades) or ';
				}
				if(!empty($queryarr['needdistrict'])){
					if(!empty($myclass['district']))
					$wherearr[] = '(FIND_IN_SET('.$myclass['district'].',n.districts) or n.districts=\'\')';
				}
				if(!empty($myclass['classid']))	//过滤接收通知的班级编号
					$wherearr[] = '('.$gradestr.'FIND_IN_SET('.$myclass['classid'].',n.cids) or n.ntype in(1,3))';
			}
	        if(!empty($crid))   //所在学校
	            $wherearr[] = 'n.crid='.$crid;
	        if(!empty($queryarr['ntype']))  //通知类型,1为全校师生 2为全校教师 3为全校学生 4为班级学生
	            $wherearr[] = 'n.ntype in ('.$queryarr['ntype'] .')';
	        $multiwhere[] =  '('.implode (' AND ', $wherearr).')';
        }

        if(!empty($multiwhere))
            $sql .= ' WHERE '.implode (' OR ', $multiwhere);
        if(!empty($queryarr['order']))
            $sql .= ' ORDER BY '.$queryarr['order'];
        else
            $sql .= ' ORDER BY n.noticeid desc ';
        if(!empty($queryarr['limit']))
            $sql .= 'limit '.$queryarr['limit'];
        else {
            if(empty($queryarr['page']) || $queryarr['page'] < 1)
                $page = 1;
            else
                $page = $queryarr['page'];
            $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
            $start = ($page - 1) * $pagesize ;
            $sql .= 'limit '.$start.','.$pagesize;
        }
        return $this->db->query($sql)->list_array();
    }

	/**
     * 获取多个网校通知列表记录总数
     * @param type $queryarr
     * @return type
     */
    public function getallnoticecount($queryarr) {
		$count = 0;
        $sql = 'SELECT count(*) count FROM ebh_notices n '.
                'LEFT JOIN ebh_users u on (u.uid = n.uid) ';
        if (empty($queryarr['crids']) || !is_array($queryarr['crids']))
        	return FALSE;
        $multiwhere = array();
        foreach ($queryarr['crids'] as $crid){
        	$myclass = array();
        	$sql2 = 'SELECT cs.classid,c.grade,c.district from  ebh_classstudents cs JOIN ebh_classes c on (c.classid = cs.classid) WHERE c.crid='.$crid.' and cs.uid = '.$queryarr['uid'];
			$myclass = $this->db->query($sql2)->row_array();

	        $wherearr = array();
			$gradestr = '';

			if(!empty($myclass)){
				if(!empty($queryarr['needgrade'])){
					if(!empty($myclass['grade']))
					$gradestr = 'FIND_IN_SET('.$myclass['grade'].',n.grades) or ';
				}
				if(!empty($queryarr['needdistrict'])){
					if(!empty($myclass['district']))
					$wherearr[] = '(FIND_IN_SET('.$myclass['district'].',n.districts) or n.districts=\'\')';
				}
				if(!empty($myclass['classid']))	//过滤接收通知的班级编号
					$wherearr[] = '('.$gradestr.'FIND_IN_SET('.$myclass['classid'].',n.cids) or n.ntype in(1,3))';
			}
	        if(!empty($crid))   //所在学校
	            $wherearr[] = 'n.crid='.$crid;
	        if(!empty($queryarr['ntype']))  //通知类型,1为全校师生 2为全校教师 3为全校学生 4为班级学生
	            $wherearr[] = 'n.ntype in ('.$queryarr['ntype'] .')';
	        $multiwhere[] =  '('.implode (' AND ', $wherearr).')';
        }

        if(!empty($multiwhere))
            $sql .= ' WHERE '.implode (' OR ', $multiwhere);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
			$count = $row['count'];
		return $count;
    }
	
	/*
	添加通知
	@param array $param
	*/
	public function addNotice($param){
		if(!empty($param['crid']))
			$narr['crid'] = $param['crid'];
		if(!empty($param['uid']))
			$narr['uid'] = $param['uid'];
		if(!empty($param['title']))
			$narr['title'] = $param['title'];
		if(!empty($param['message']))
			$narr['message'] = $param['message'];
		if(!empty($param['ntype']))
			$narr['ntype'] = $param['ntype'];
		if(!empty($param['cids']))
			$narr['cids'] = $param['cids'];
		if(isset($param['type']))
			$narr['type'] = $param['type'];
		if(!empty($param['grades']))
			$narr['grades'] = $param['grades'];
		if(isset($param['districts']))
			$narr['districts'] = $param['districts'];
		if(!empty($param['attid']))
			$narr['attid'] = $param['attid'];
		if(!empty($param['ip']))
			$narr['ip'] = $param['ip'];
		
		$narr['dateline'] = SYSTIME;
			//var_dump($narr);
		return $this->db->insert('ebh_notices',$narr);
		
	}
	/*
	 * 修改通知
	 * @param array $param
	*/
	public function updateNotice($param){
		if(empty($param['noticeid']))
			return FALSE;
		$wherearr = array('noticeid'=>$param['noticeid']);
		if(!empty($param['crid']))	//过滤所在平台
			$wherearr['crid'] = $param['crid'];
		if(!empty($param['uid']))	//过滤发送人
			$wherearr['uid'] = $param['uid'];
		$setarr = array();
		if(!empty($param['title']))
			$setarr['title'] = $param['title'];
		if(!empty($param['message']))
			$setarr['message'] = $param['message'];
		if(!empty($param['cids']))
			$setarr['cids'] = $param['cids'];
		if(isset($param['ntype']))
			$setarr['ntype'] = $param['ntype'];
		if(isset($param['grades']))
			$setarr['grades'] = $param['grades'];
		if(isset($param['districts']))
			$setarr['districts'] = $param['districts'];
		if(!empty($param['attid']))
			$setarr['attid'] = $param['attid'];
		return $this->db->update('ebh_notices',$setarr,$wherearr);
		
	}
	
	/*
	获取通知详情
	*/
	public function getNoticeDetail($param){
		$wherearr = array();
		$sql = 'select u.realname,u.username,n.uid,n.viewnum,n.noticeid,n.title,n.message,n.ntype,n.cids,n.dateline,n.attid,n.grades,n.districts,n.isreceipt,n.receipt from ebh_notices n
					join  ebh_users  u  on u.uid = n.uid 
				';
		$wherearr[] = 'crid='.$param['crid'];
		$wherearr[] = 'noticeid='.$param['noticeid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		//echo $sql;
		return $this->db->query($sql)->row_array();
		
	}
	/*
	获取通知详情
	*/
	public function getNoticeByNoticeid($noticeid){
		$wherearr = array();
		$sql = 'select n.noticeid,n.crid,n.title,n.message,n.ntype,n.cids,n.dateline,n.attid from ebh_notices n where noticeid='.$noticeid;
		return $this->db->query($sql)->row_array();
		
	}
	public function deleteNotice($param){
		$wherearr['crid'] = $param['crid'];
		$wherearr['noticeid'] = $param['noticeid'];
		return $this->db->delete('ebh_notices',$wherearr);
	}
	/**
	*添加通知的浏览数
	*/
	public function addviewnum($noticeid) {
		$wherearr = array('noticeid'=>$noticeid);
		$setarr = array('viewnum'=>'viewnum+1');
		return $this->db->update('ebh_notices',array(),$wherearr,$setarr);
	}

	/**
	 *根据时间和教室获取通知
	 */
	public function getNewNoticeCountByTime($crid,$dateline){
		$param = array(
			'crid'=>$crid,
			'dateline'=>$dateline
			);
		return $this->getnoticelistcount($param);
	}
	/**
	 * [添加用户的通知浏览状态]
	 * @param   $uid     用户id
	 * @param   $noticeid  通知id
	 */
	public function adduserviewnum($uid,$noticeid,$groupid=0){
		if(empty($uid) || empty($noticeid)){
			return FALSE;
		}
		$readarr = array(
			'uid'=>$uid,
			'groupid'=>$groupid,
			'noticeid'=>$noticeid,
			'status'=>1, //1表示已读
			'readtime'=>SYSTIME
		);
		return $this->db->insert('ebh_usernotices',$readarr);
	}

	// 根据用户和通知id查询是否有通知记录
	public function getusernotice($uid,$idarr){
		if(empty($uid) || empty($idarr)){
			return FALSE;
		}
		if(!is_array($idarr)){
			$idarr = array($idarr);
		}
		$idstr=implode(',',$idarr);
		$sql="select id,uid,noticeid,status from ebh_usernotices where uid={$uid} and noticeid in({$idstr})";
		return $this->db->query($sql)->list_array();

	}
	// 查询用户已读的弹窗通知数量
	public function getusernoticeCount($uid,$idarr){
		if(empty($uid) || empty($idarr)){
			return FALSE;
		}
		if(!is_array($idarr)){
			$idarr = array($idarr);
		}
		$idstr = implode(',',$idarr);
		$sql="select count(*) count from ebh_usernotices where uid={$uid} and noticeid in({$idstr})";
		$row= $this->db->query($sql)->row_array();
		if(!empty($row)){
            $count = $row['count'];
        }
        return $count;
	}
	
	/**
	 *查询用户是否已有未读的消息
	 *@param $uid 用户id,$crid ,$groupid
	 *@return bool 
	 */
	public function checkExitNoRead($uid,$crid,$groupid=6){
		if(empty($uid) || empty($crid)){
			return FALSE;
		}
		$sql = 'select count(1) as count from ebh_notices n';
		if ($groupid == 6) {
			$wherearr[] = 'n.ntype in(1,3,4,5)';
		} else {
			$wherearr[] = 'n.ntype in(1,2)';
		}
		$wherearr[] = 'n.type=0';
		$wherearr[] = 'n.crid='.$crid;
		$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(empty($row['count'])){
            return false;
        }

        $userNoticeSql = 'select count(1) as c from ebh_usernotices un left join ebh_notices n using(noticeid) ';
        $wherearr[] = 'un.uid='.$uid;
        $userNoticeSql.= ' where '.implode(' AND ',$wherearr);
        $readRow = $this->db->query($userNoticeSql)->row_array();
        if(empty($readRow['c'])){
            return true;
        }
        if ($readRow['c'] < $row['count']) {
        	return true;
        } else {
        	return false;
        }
	}


}
