<?php
	//评论类
class ReviewModel extends CModel{
	/*
	评论列表
	@param array $param
	@return array
	*/
	public function getreviewlist($param){
		$sql = ' select r.logid,r.subject,r.toid,u.username,u.realname,r.uid,r.good,r.useful,r.bad,r.dateline,r.fromip,r.type,u.sex,u.face,u.groupid,r.score,r.subject from ebh_reviews r left join ebh_users u on r.uid = u.uid';
		$setarr = array();
		if(!empty($param['q']))
			$wherearr[] = ' (r.subject like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']) .'%\')';
        if(!empty($param['ql'])){
            $wherearr[] = ' (r.subject like \'%'. $this->db->escape_str($param['ql']) .'%\')';
        }
		if (!empty($param['type']))
            $wherearr[] = 'r.type = \''.$param['type'].'\'';
		if (!empty($param['toid']))
            $wherearr[] = 'toid = '.$param['toid'];
        if (!empty($param['toidarr']))
            $wherearr[] = 'toid in('.implode(',',$param['toidarr']).')';
		if (!empty($param['opid']))
            $wherearr[] = 'opid = '.$param['opid'];
		if (!empty($param['upid']))
            $wherearr[] = 'r.upid = '.$param['upid'];
        if (!empty($param['audit']))
            $wherearr[] = 'r.audit = '.$param['audit'];
        if (!empty($param['uid']))
            $wherearr[] = 'r.uid = '.$param['uid'];
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by ' .$param['order'];
		else
			$sql.= ' order by r.logid desc';
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
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

    /**
     * 根据ID获取评论
     * @param $logid
     * @return mixed
     */
    public function getReviewByLogid($logid){
        $sql = 'select * from ebh_reviews where logid = '.$logid;

        return $this->db->query($sql)->row_array();
    }

	/*
	评论数量
	@param array $param
	@return int
	*/
	public function getreviewcount($param){
		if(!empty($param['rev'])){//老师回复评论
			$sql = 'select count(*) count from ebh_reviews r join ebh_users u on (u.uid = r.uid) join ebh_coursewares c on (c.cwid = r.toid) join ebh_roomcourses rc on (rc.cwid = c.cwid) join ebh_teachers t on (t.teacherid = c.uid ) ';

		}else if(!empty($param['rcrid'])){//用于学生的评论列表
			$sql = 'select count(*) count from ebh_reviews r join ebh_users u  on u.uid=r.uid join ebh_coursewares c on (c.cwid = r.toid) join ebh_roomcourses rc on (rc.cwid = c.cwid) join ebh_teachers t on (t.teacherid = c.uid )';
		}else{
			$sql = 'select count(*) count from ebh_reviews r left join ebh_users u  on u.uid=r.uid  ';
		}
		if(!empty($param['q'])){
			if(!empty($param['rev'])){//查询老师的真实姓名及评论
				$wherearr[] = ' (r.subject like \'%'. $this->db->escape_str($param['q']) .'%\' or t.realname like \'%' . $this->db->escape_str($param['q']) .'%\')';
			}else{
				$wherearr[] = ' (r.subject like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']) .'%\')';
			}
		}
        if(!empty($param['ql'])){
            $wherearr[] = ' (r.subject like \'%'. $this->db->escape_str($param['ql']) .'%\')';
        }
		if (!empty($param['crid'])) {
			$wherearr[] = 'rc.crid ='.$param['crid'];
		}
		if (!empty($param['type']))
            $wherearr[] = 'r.type = \''.$param['type'].'\'';
		if (!empty($param['toid']))
            $wherearr[] = 'toid = '.$param['toid'];
        if (!empty($param['toidarr']))
            $wherearr[] = 'toid in('.implode(',',$param['toidarr']).')';
		if (!empty($param['opid']))
            $wherearr[] = 'opid = '.$param['opid'];
		if (!empty($param['upid']))
            $wherearr[] = 'r.upid = '.$param['upid'];
		if (!empty($param['uid']))
            $wherearr[] = 'r.uid = '.$param['uid'];
		if (isset($param['status']))
			$wherearr[] = 'c.status = '.$param['status'];
        if (!empty($param['audit']))
            $wherearr[] = 'r.audit = '.$param['audit'];
		if (isset($param['shield']))
			$wherearr[] = 'r.shield != '.$param['shield'];
		if (isset($param['replysubject']))
			$wherearr[] = 'r.replysubject != \'\'';
		if (!empty($param['folderid']))
            $wherearr[] = 'rc.folderid = '.$param['folderid'];
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	删除评论
	@param int $logid
	@return bool
	*/
	public function deletereview($param = array()){
		return $this->db->delete('ebh_reviews',$param);
		// $sql = 'delete r.* from ebh_reviews r where r.logid='.$logid;
		// return $this->db->simple_query($sql);
	}

    /**
     * 插入评论数据
     * @param type $param
     * @return type
     */
    public function insert($param = array()) {
            $setarr = array();
            if (!empty($param['upid'])) {
                $setarr['upid'] = $param['upid'];
            }
            if (!empty($param['crid'])) {
                $setarr['crid'] = $param['crid'];
            }
            if (isset($param['service'])) {
                $setarr['service'] = $param['service'];
            }
            if (isset($param['environment'])) {
                $setarr['environment'] = $param['environment'];
            }
            if (isset($param['score'])) {
                $setarr['score'] = $param['score'];
            }
            if (isset($param['useful'])) {
                $setarr['useful'] = $param['useful'];
            }
            if (isset($param['useless'])) {
                $setarr['useless'] = $param['useless'];
            }
            if (isset($param['viewnum'])) {
                $setarr['viewnum'] = $param['viewnum'];
            }
            if (isset($param['replynum'])) {
                $setarr['replynum'] = $param['replynum'];
            }
            if (!empty($param['subject'])) {
                $setarr['subject'] = $param['subject'];
            }
            if (isset($param['good'])) {
                $setarr['good'] = $param['good'];
            }
            if (isset($param['bad']) ) {
                $setarr['bad'] = $param['bad'];
            }
			if (!empty($param['type'])) {
                $setarr['type'] = $param['type'];
            }
			if (!empty($param['uid'])) {
                $setarr['uid'] = $param['uid'];
            }
			if (!empty($param['levels'])) {
                $setarr['levels'] = $param['levels'];
            }
			if (!empty($param['toid'])) {
                $setarr['toid'] = $param['toid'];
            }
			if (!empty($param['opid'])) {
                $setarr['opid'] = $param['opid'];
            }
			if (!empty($param['fromip'])) {
                $setarr['fromip'] = $param['fromip'];
            }
			if (!empty($param['dateline'])) {
                $setarr['dateline'] = $param['dateline'];
            }
			if (isset($param['audit'])) {
                $setarr['audit'] = $param['audit'];
            }
			 $logid = $this->db->insert('ebh_reviews', $setarr);
        return $logid;
    }

    /**
     * 插入ebh_logs表记录
     * @param type $param
     * @return boolean
     */
    public function insertlog($param) {
        $setarr = array();
        if (empty($param['uid']) || empty($param['opid']) || empty($param['toid']) || empty($param['type']))
            return FALSE;
        $setarr['uid'] = $param['uid'];
        $setarr['opid'] = $param['opid'];
        $setarr['toid'] = $param['toid'];
        $setarr['type'] = $param['type'];
        if (!empty($param['subject'])) {
            $setarr['message'] = $param['subject'];
        }
        if (!empty($param['value'])) {
            $setarr['value'] = $param['value'];
        }
        if (!empty($param['credit'])) {
            $setarr['credit'] = $param['credit'];
        }
        if (!empty($param['fromip'])) {
            $setarr['fromip'] = $param['fromip'];
        }
        $setarr['dateline'] = SYSTIME;
        $logid = $this->db->insert('ebh_logs', $setarr);
        return $logid;
    }

    /**
     * 根据课件编号获取评论列表
     * @param type $queryarr
     * @return boolean
     */
    public function getReviewListByCwid($queryarr = array()) {
        if (empty($queryarr['cwid']))
            return FALSE;
        if (empty($queryarr['page']) || $queryarr['page'] < 1)
            $page = 1;
        else
            $page = $queryarr['page'];
        $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'select r.logid,r.dateline,r.subject,r.score,r.uid,u.uid,u.username,u.realname,u.sex,u.face,u.groupid,r.replyuid,r.replysubject,r.replydateline from ebh_reviews r ' .
                'join ebh_users u on (u.uid = r.uid) ' .
                'where r.toid=' . $queryarr['cwid'] . ' and r.type=\'courseware\' and r.shield=0 order by r.logid desc ';
        $sql .= 'limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();

    }
    /**
     * 根据crid递归获取评论列表以及评论回复内容
     * @param array $queryarr
     * @param int $parent_id
     */
    public function getReviewListByCridOnRecUrsion($queryarr = array(),$parent_id = 0,&$result = array()){
        if (empty($queryarr['crid']))
            return FALSE;
        if (empty($queryarr['page']) || $queryarr['page'] < 1)
            $page = 1;
        else
            $page = $queryarr['page'];

        $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
        $start = ($page - 1) * $pagesize;

        // audit值：0 为待审核状态，1 为审核通过，2 为审核不通过
        $where = '';
        if (!empty($queryarr['audit'])) {
            $where = ' and audit = 1 ';
        }

        if($parent_id == 0){
            $sql = 'select r.logid,r.dateline,r.subject,r.score,r.uid,r.toid,u.uid,u.username,u.realname,u.sex,u.face,u.groupid as groupid,r.replyuid,r.replysubject,r.replydateline from ebh_reviews r ' .
                'join ebh_users u on (u.uid = r.uid) ' .
                'join ebh_coursewares c on c.cwid=r.toid ' .
                'join ebh_roomcourses rc on (c.cwid = rc.cwid) '.
                'where rc.crid=' . $queryarr['crid'] . ' and r.type=\'courseware\' and r.shield=0 and r.upid=' . $parent_id .$where.' order by r.logid desc limit '. $start . ',' . $pagesize;
        }else{
            $sql = 'select r.logid,r.dateline,r.subject,r.score,r.uid,r.toid,u.uid,u.username,u.realname,u.sex,u.face,u.groupid,r.replyuid,r.replysubject,r.replydateline,u2.realname as torealname,u2.username as tousername from ebh_reviews r ' .
                'join ebh_users as u on (u.uid = r.uid) ' .
                'join ebh_users u2 on (u2.uid = r.toid) ' .
                'where r.shield=0 and r.upid=' . $parent_id .$where.' order by r.logid asc';
        }

        $arr = $this->db->query($sql)->list_array();

        if(empty($arr)){
            return array();
        }
        foreach ($arr as $review) {
            $thisArr=&$result[];
            $review['children'] = $this->getReviewListByCridOnRecUrsion($queryarr,$review['logid'],$thisArr);
            $thisArr = $review;
        }
        return $result;
    }

    /**
     * 根据课件编号递归获取评论列表以及评论回复内容
     * @param array $queryarr
     * @param int $parent_id
     */
    public function getReviewListByCwidOnRecUrsion($queryarr = array(),$parent_id = 0,&$result = array()){
        if (empty($queryarr['cwid']))
            return FALSE;
        if (empty($queryarr['page']) || $queryarr['page'] < 1)
            $page = 1;
        else
            $page = $queryarr['page'];

        $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
        $start = ($page - 1) * $pagesize;
        /*if($parent_id == 0){
            $where = ' r.toid=' . $queryarr['cwid'] . ' and r.type=\'courseware\' and r.shield=0 and r.upid=' . $parent_id .' order by r.logid desc ';
        }else{
            $where = ' r.shield=0 and r.upid=' . $parent_id . ' order by r.logid asc ';
        }
        $sql = 'select r.logid,r.dateline,r.subject,r.score,r.uid,u.uid,u.username,u.realname,u.sex,u.face,u.groupid,r.replyuid,r.replysubject,r.replydateline from ebh_reviews r ' .
            'join ebh_users u on (u.uid = r.uid) ' .
            'where ' . $where ;

        if($parent_id == 0){
            $sql .= 'limit ' . $start . ',' . $pagesize;
        }*/

        // audit值：0 为待审核状态，1 为审核通过，2 为审核不通过
        $where = '';
        if (!empty($queryarr['audit'])) {
            $where = ' and audit = 1 ';
        }

        if (!empty($queryarr['upvote'])) {
            //按点赞数排序
            $orderStr = 'r.toptime desc,r.upvotenum desc,r.logid desc';
        } else {
            //按时间排序
            $orderStr = 'r.toptime desc,r.logid desc';
        }

        if($parent_id == 0){
            $sql = 'select r.logid,r.dateline,r.subject,r.score,r.uid,r.toid,u.uid,u.username,u.realname,u.sex,u.face,u.groupid as groupid,r.replyuid,r.replysubject,r.replydateline,r.fromip,r.upvotenum,r.toptime from ebh_reviews r ' .
                'join ebh_users u on (u.uid = r.uid) ' .
                'where r.toid=' . $queryarr['cwid'] . ' and r.type=\'courseware\' and r.shield=0 and r.upid=' . $parent_id .$where.' order by '.$orderStr.' limit '. $start . ',' . $pagesize;
        }else{
            $sql = 'select r.logid,r.dateline,r.subject,r.score,r.uid,r.toid,u.uid,u.username,u.realname,u.sex,u.face,u.groupid,r.replyuid,r.replysubject,r.replydateline,u2.realname as torealname,u2.username as tousername,r.fromip,r.upvotenum,r.toptime from ebh_reviews r ' .
                'join ebh_users as u on (u.uid = r.uid) ' .
                'join ebh_users u2 on (u2.uid = r.toid) ' .
                'where r.shield=0 and r.upid=' . $parent_id .$where.' order by '.$orderStr;
        }

        $arr = $this->db->query($sql)->list_array();

        if(empty($arr)){
            return array();
        }
        foreach ($arr as $review) {
            $thisArr=&$result[];
            $review['children'] = $this->getReviewListByCwidOnRecUrsion($queryarr,$review['logid'],$thisArr);
            $thisArr = $review;
        }
        return $result;
    }

	 /**
     * 根据用户编号获取评论列表及课件详情信息(用于评论交流)
     * @params type $params
     * @return boolean
     */
    public function getReviewListByUid($params) {
		if(!empty($params['rev'])){
			 $sql = 'select  r.logid,r.subject,r.`type`,r.uid,r.`type`,c.message,r.toid,c.title,c.tag,c.summary,c.message,c.cwname,c.dateline,c.displayorder,r.score,u.realname,u.username,c.cwurl,t.realname,t.nickname,r.shield,rc.crid,r.replyuid,r.replysubject,r.replydateline,c.ism3u8,c.status from ebh_reviews r join ebh_users u on (u.uid = r.uid) join ebh_coursewares c on (c.cwid = r.toid) join ebh_roomcourses rc on (rc.cwid = c.cwid) join ebh_teachers t on (t.teacherid = c.uid ) ';
		}else{
			$sql = 'select r.logid,r.subject,r.`type`,r.uid,r.`type`,c.message,r.toid,c.title,c.tag,c.summary,c.message,c.cwname,c.dateline,c.displayorder,r.score,u.realname,u.username,c.cwurl,t.realname,t.nickname,r.shield,u.sex,u.face,rc.crid,r.replyuid,r.replysubject,r.replydateline,c.ism3u8,c.status from ebh_reviews r join ebh_users u on (u.uid = r.uid) join ebh_coursewares c on (c.cwid = r.toid) join ebh_roomcourses rc on (rc.cwid = c.cwid) join ebh_teachers t on (t.teacherid = c.uid )';
		}
        $wherearr = array();

		if (!empty($params ['uid'])) {
            $wherearr[] = ' r.uid ='.$params['uid'];
        }
		if (!empty($params ['crid'])) {
			$wherearr[] = ' rc.crid ='.$params['crid'];
        }
		if (isset($params ['upid'])) {
			$wherearr[] = ' r.upid !='.$params['upid'];
        }
		if (isset($params ['shield'])) {
			$wherearr[] = ' r.shield !='.$params['shield'];
        }
		if (isset($params ['replysubject'])) {
			$wherearr[] = ' r.replysubject !=\'\' ';
        }
		if(!empty($params['q']))
			$wherearr[] = ' (r.subject like \'%'. $this->db->escape_str($params['q']) .'%\' or t.realname like \'%' . $this->db->escape_str($params['q']) .'%\')';
		if(isset($params['status'])){
			$wherearr[] = ' c.status ='.$params['status'];
		}
		if (!empty($params ['type'])) {
            $wherearr[] = ' r.type = \''.$params['type'].'\'';
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($params['order'])) {
            $sql .= ' ORDER BY '.$params['order'];
        } else {
            $sql .= ' ORDER BY r.logid desc';
        }
        if(!empty($params['limit'])) {
            $sql .= ' limit '.$params['limit'];
        } else {
			if (empty($params['page']) || $params['page'] < 1)
				$page = 1;
			else
				$page = $params['page'];
			$pagesize = empty($params['pagesize']) ? 10 : $params['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
        $reviews = $this->db->query($sql)->list_array();
        return $reviews;
    }


    /**
     * 根据课件编号获取评论列表记录数(评论数不包括账号已删除的评论)
     * @param type $queryarr
     * @return type
     */
    public function getReviewCountByCwid($queryarr = array()) {
        $count = 0;

        // audit值：0 为待审核状态，1 为审核通过，2 为审核不通过
        $where = '';
        if (!empty($queryarr['audit'])) {
            $where = ' and audit = 1 ';
        }

        $sql = 'SELECT count(*) count from ebh_reviews r join ebh_users u on (u.uid = r.uid) ' .
                'where r.toid=' . $queryarr['cwid'] . ' and shield = 0 and r.type=\'courseware\''.$where;
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow))
            $count = $countrow['count'];
        return $count;
    }

    /**
     * 获取平台下的评论和回复信息
     */
    public function getreviewlistbycrid($param, $status = false) {

        $sql = 'select r.logid,r.upid,r.dateline,r.subject,r.audit,u.username,u.realname,c.uid as authorid,c.cwid,c.title,c.cwurl,r.shield,u.uid,u.sex,u.groupid,u.face,r.replyuid,r.replysubject,r.replydateline,c.ism3u8,t.teacherid,t.realname as trealname from  ebh_reviews r ' .
                'join ebh_users u on (u.uid = r.uid) ' .
                'join ebh_coursewares c on c.cwid=r.toid ' .
				'join ebh_teachers t on t.teacherid = c.uid ' .
                'join ebh_roomcourses rc on (c.cwid = rc.cwid) ';
        $wherearr = array();
        if (!empty($param['crid']))  //教室编号
            $wherearr[] = 'rc.crid=' . $param['crid'];
        if (!empty($param['uid']))   //教师编号
            $wherearr[] = 'c.uid=' . $param['uid'];
		if (isset($param['status']))
			$wherearr[] = 'c.status=' . $param['status'];
		// else
			// $wherearr[] = 'c.status=1';
		if(!empty($param['stuid']))
			$wherearr[] = 'r.uid='.$param['stuid'];
		if (!empty($param['startdate']))
			$wherearr[]= 'r.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'r.dateline<='.$param['enddate'];

        if ($status) {
            if (isset($param['shield'])) {
                $wherearr[] = 'r.audit=' . $param['shield'];
            }
        } else {
            if (isset($param['shield'])) {
                $wherearr[] = 'r.shield=' . $param['shield'];
            }
        }

        $wherearr[] = 'r.opid=8192';
        $wherearr[] = 'r.type=\'courseware\'';
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY r.logid DESC ';
        if (!empty($param['limit']))
            $sql .= ' LIMIT ' . $param['limit'];
        else {
            if (empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= 'limit ' . $start . ',' . $pagesize;
        }
        $reviews = $this->db->query($sql)->list_array();
		return $reviews;
    }

    /*
     * 获取学校最新评论
     * $crid 网校 ID
     * $num 获取最新几条
     */
    public function getTheLatestReview($crid, $num = 5){
        if (empty($crid)) return false;
        // 取出该学校下所有学生
        $roomUserSql = "select uid from ebh_roomusers where crid = ".$crid;
        $roomUserData = $this->db->query($roomUserSql)->list_array();

        $uidArr = array();
        if (!empty($roomUserData)) {
            foreach($roomUserData as $val) {
                $uidArr[] = $val['uid'];
            }
        }

        if (empty($uidArr)) return false;

        // 获取该学校的最新评论
        $uidStr = implode(',',$uidArr);
        $reviewsSql = "select logid,subject,uid,toid from ebh_reviews where uid in ($uidStr) and audit = 1 and type = 'courseware' order by logid DESC limit ".intval($num);
        $reviewData = $this->db->query($reviewsSql)->list_array();
        if (empty($reviewData)) return false;
        $newUidArr = array();
        foreach($reviewData as $v) {
            $newUidArr[] = $v['uid'];
        }
        $newUidArr = array_unique($newUidArr);
        $newUidStr = implode(',', $newUidArr);

        // 获取最新评论下的用户信息
        $sql = "select u.uid,u.username,u.realname,u.face,u.sex,c.classname from ebh_users u ".
                "join ebh_classstudents cs on u.uid = cs.uid ".
                "join ebh_classes c on cs.classid = c.classid ".
                "where c.crid = ".$crid." and u.status != 0 and c.status = 0 and u.uid in ($newUidStr) ".
                "group by uid";
        $userInfo = $this->db->query($sql)->list_array();
        if (empty($userInfo)) return false;

        // 组装最新用户评论
        $userInfoArr = array();
        foreach($userInfo as $v) {
            $userInfoArr[$v['uid']] = $v;
        }
       $userReviewArr = array();
        foreach($reviewData as $k=>$v) {
            if(!empty($userInfoArr[$v['uid']])) {
                $userReviewArr[$k] = $v;
                $userReviewArr[$k]['username'] = $userInfoArr[$v['uid']]['username'];
                $userReviewArr[$k]['realname'] = $userInfoArr[$v['uid']]['realname'];
                $userReviewArr[$k]['face'] = $userInfoArr[$v['uid']]['face'];
                $userReviewArr[$k]['sex'] = $userInfoArr[$v['uid']]['sex'];
                $userReviewArr[$k]['classname'] = $userInfoArr[$v['uid']]['classname'];
            }
        }

        return $userReviewArr;

    }

    /**
     * 获取平台下的评论和回复信息记录数
     */
    public function getreviewlistcountbycrid($param, $status = false) {
        $count = 0;
        $sql = 'select count(*) count from ebh_reviews r ' .
                'join ebh_coursewares c on c.cwid=r.toid ' .
                'join ebh_roomcourses rc on (c.cwid = rc.cwid) ';
        $wherearr = array();
        if (!empty($param['crid']))  //教室编号
            $wherearr[] = 'rc.crid=' . $param['crid'];
        if (!empty($param['uid']))   //教师编号
            $wherearr[] = 'c.uid=' . $param['uid'];
        if (isset($param['time']))   //时间，可根据时间来获取评论数
            $wherearr[] = 'r.dateline>' . $param['time'];
		if (!empty($param['startdate']))
			$wherearr[]= 'r.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'r.dateline<='.$param['enddate'];
		if (isset($param['status']))
			$wherearr[] = 'c.status=' . $param['status'];


		 // else
			 // $wherearr[] = 'c.status=1';
		if(!empty($param['stuid']))
			$wherearr[] = 'r.uid='.$param['stuid'];

        if ($status) {
            if (isset($param['shield'])) {
                $wherearr[] = 'r.audit=' . $param['shield'];
            }
        } else {
            if (isset($param['shield'])) {
                $wherearr[] = 'r.shield=' . $param['shield'];
            }
        }

		if (isset($param['replysubject']))
			$wherearr[] = 'r.replysubject= \'\' ';
        $wherearr[] = 'r.opid=8192';
        $wherearr[] = 'r.type=\'courseware\'';
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if (!empty($row))
            $count = $row['count'];
        return $count;
    }

	/**
	* 根据条件获取最后一次评论等日志的时间
	*/
	public function getLastLogTime($param) {
		$lasttime = 0;
		$sql = 'select l.dateline from ebh_logs l';
		$wherearr = array();
		if(!empty($param['logid'])) {
            $wherearr[] = 'l.logid = '.$param['logid'];
        }
		if(!empty($param['uid'])) {
            $wherearr[] = 'l.uid = '.$param['uid'];
        }
		if(!empty($param['toid'])) {
            $wherearr[] = 'l.toid = '.$param['toid'];
        }
		if(!empty($param['opid'])) {
            $wherearr[] = 'l.opid = '.$param['opid'];
        }
		if(!empty($param['value'])) {
            $wherearr[] = 'l.value = '.$param['value'];
        }
		if(!empty($param['type'])) {
            $wherearr[] = 'l.type = \''.$param['type'].'\'';
        }
		if(empty($wherearr))
			return FALSE;
        $sql .= ' WHERE '.implode(' AND ',$wherearr);
		$sql .= ' order by l.logid desc ';
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$lasttime = $row['dateline'];
		return $lasttime;
	}
	/**
	* 根据条件获取最后一次评论等日志的时间(shop模板的评论应用)
	*/
	public function getLastLogTimes($param) {
		$lasttime = 0;
		$sql = 'select r.dateline from ebh_reviews r';
		$wherearr = array();
		if(!empty($param['logid'])) {
            $wherearr[] = 'r.logid = '.$param['logid'];
        }
		if(!empty($param['uid'])) {
            $wherearr[] = 'r.uid = '.$param['uid'];
        }
		if(!empty($param['toid'])) {
            $wherearr[] = 'r.toid = '.$param['toid'];
        }
		if(!empty($param['opid'])) {
            $wherearr[] = 'r.opid = '.$param['opid'];
        }
		if(!empty($param['value'])) {
            $wherearr[] = 'r.value = '.$param['value'];
        }
		if(!empty($param['type'])) {
            $wherearr[] = 'r.type = \''.$param['type'].'\'';
        }
		if(empty($wherearr))
			return FALSE;
        $sql .= ' WHERE '.implode(' AND ',$wherearr);
		$sql .= ' order by r.logid desc ';
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$lasttime = $row['dateline'];
		return $lasttime;
	}
	/**
	*获取个人评论的评分值
	*/
	public function getReviewScore($params){
		$score = 0;
		$sql = ' select r.score from ebh_reviews r ';
		$wherearr = array();
		if (!empty($params['type']))
            $wherearr[] = 'r.type = \''.$params['type'].'\'';
		if (!empty($params['uid']))
            $wherearr[] = 'r.uid= '.$params['uid'];
		if (!empty($params['toid']))
            $wherearr[] = 'r.toid = '.$params['toid'];
		if (!empty($params['opid']))
            $wherearr[] = 'r.opid= '.$params['opid'];
		if (!empty($params['value']))
            $wherearr[] = 'r.value= '.$params['value'];
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($params['order']))
			$sql.= ' order by '.$params['order'];
		if(!empty($params['limit']))
			$sql.= ' limit ' . $params['limit'];
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$score = $row['score'];
		return $score;
	}

	 /**
     * 对评论的屏蔽(教师屏蔽该课件的学生评论)
     */
    function upShield($param) {
        $setarr = array('shield' => 1);
        $wherearr = array('logid' => $param['logid']);
        $afrows = $this->db->update('ebh_reviews', array(), $wherearr, $setarr);
        return $afrows;

    }

	/**
     * 取消评论的屏蔽(管理员取消屏蔽该课件的学生评论)
     */
    function cancleShield($param) {
        $setarr = array('shield' => 0);
        $wherearr = array('logid' => $param['logid']);
        $afrows = $this->db->update('ebh_reviews', array(), $wherearr, $setarr);
        return $afrows;

    }

	 /**
     * 回复评论
     */
    function update($param) {
        $wherearr = array('logid' => $param['logid']);
		if (!empty($param ['replyuid'])) {
            $setarr['replyuid'] = $param['replyuid'];
        }
		if (!empty($param ['replysubject'])) {
            $setarr['replysubject'] = $param['replysubject'];
        }
		if (!empty($param ['replydateline'])) {
            $setarr['replydateline'] = $param['replydateline'];
        }
		$replay = $this->db->update('ebh_reviews', $setarr, $wherearr);
		return $replay;
    }

	/*
	获取多个老师收到的评论数
	*/
	public function getTeachersReviewCount($param){
		$sql = 'select count(*) reviewnum,cw.uid from ebh_coursewares cw
			join ebh_roomcourses rc on cw.cwid=rc.cwid
			join ebh_reviews r on r.toid = rc.cwid';
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid='.$param['crid'];
		if(!empty($param['uids']))
			$wherearr[] = 'cw.uid in ('.$param['uids'].')';
		if(!empty($param['startdate']))
			$wherearr[]= 'r.dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[]= 'r.dateline<='.$param['enddate'];
		$wherearr[] = 'r.type=\'courseware\'';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by cw.uid';
		return $this->db->query($sql)->list_array();

	}

	/*
	单个教室下的课件评论数,用来判断课件评论是否是对该学校的评论
	*/
	public function getByCridCount($param){
		$sql = 'select count(*) as count from ebh_reviews r left join ebh_roomcourses rc on (rc.cwid = r.toid) ';
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid=' .$param['crid'];
		if(!empty($param['cwid']))
			$wherearr[] = 'rc.cwid=' .$param['cwid'];
		$wherearr[] = 'r.type=\'courseware\'';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
        return $count['count'];
	}

    /**
     * 根据课件编号获取评论列表
     * @param type $queryarr
     * @return boolean
     */
    public function getReviewListAllByCwid($queryarr = array()) {
        if (empty($queryarr['cwid']))
            return FALSE;
        $sql = 'select r.uid,u.username from ebh_reviews r ' .
                'join ebh_users u on (u.uid = r.uid) ' .
                'where r.toid=' . $queryarr['cwid'] . ' and r.type=\'courseware\' and r.shield=0 order by r.logid desc ';
        return $this->db->query($sql)->list_array();

    }

    // 编辑审核状态
    public function editaudit($logid, $audit) {
        if (empty($logid) || empty($audit)) return false;
        return $this->db->update('ebh_reviews', array('audit'=>intval($audit)), array('logid'=>intval($logid)));
    }

    /**
     * 用户评论点赞记录
     * @param array $logids 评论ID集
     * @param int $uid 用户ID
     * @return mixed
     */
    public function upvotes($logids, $uid) {
        $sql = 'SELECT `cwid` AS `reid` FROM `ebh_userzan` WHERE `cwid` IN('.implode(',', $logids).') AND `uid`='.$uid.' AND `ztype`=1';
        return $this->db->query($sql)->list_array('reid');
    }

    /**
     * 评论点赞
     * @param int $logid 评论ID
     * @param int $uid 用户ID
     * @param int $crid 网校ID
     * @return bool
     */
    public function upvote($logid, $uid, $crid) {
        $exists = $this->db->query('SELECT `zid` FROM `ebh_userzan` WHERE `uid`='.$uid.' AND `cwid`='.$logid.' AND `ztype`=1 LIMIT 1')->row_array();
        if (!empty($exists)) {
            return false;
        }
        $ip =  EBH::app()->getInput()->getip();
        $ip = ip2long($ip);
        $this->db->begin_trans();
        $this->db->insert('ebh_userzan', array(
            'cwid' => $logid,
            'uid' => $uid,
            'dateline' => SYSTIME,
            'ztype' => 1,
            'crid' => $crid,
            'ip' => $ip
        ));
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->query('UPDATE `ebh_reviews` SET `upvotenum`=`upvotenum`+1 WHERE `logid`='.$logid);
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->commit_trans();
        return true;
    }
    /**
     * 评论置顶
     * @param int $logid 评论ID
     * @param int $topstatus置顶开关
     * @return bool
     */
    public function topreview($param) {
        $setarr = array();
        $where = array();
        $return = FALSE;
        $where['logid'] = !empty($param['logid']) ? intval($param['logid']) : 0;
        $topstatus = !empty($param['topstatus']) ? intval($param['topstatus']) : 0;
        if(empty($where['logid']) || !isset($topstatus)){
            return $return;
        }
        if($topstatus == 1){
            $setarr['toptime'] = SYSTIME;
        }elseif($topstatus == 0){
            $setarr['toptime'] = 0;
        }else{
            return $return;
        }
        $ret = $this->db->update('ebh_reviews',$setarr,$where);
        if(!empty($ret)){
            $return = TRUE;
        }
        return $return;
    }
}