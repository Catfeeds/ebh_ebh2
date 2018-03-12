<?php

/**
 * CoursewareModel 课件Model类
 */
class CoursewareModel extends CModel {

    public function insert($param = array()) {
        $setarr = array();
        if (!empty($param['uid']))
            $setarr['uid'] = $param['uid'];
        if (!empty($param['catid']))
            $setarr['catid'] = $param['catid'];
        if (!empty($param['catpath']))
            $setarr['catpath'] = $param['catpath'];
        if (!empty($param['title']))
            $setarr['title'] = $param['title'];
        if (!empty($param['sub_title']))
            $setarr['sub_title'] = $param['sub_title'];
        if (!empty($param['author']))
            $setarr['author'] = $param['author'];
        if (!empty($param['tag']))
            $setarr['tag'] = $param['tag'];
        if (!empty($param['logo']))
            $setarr['logo'] = $param['logo'];
        if (!empty($param['images']))
            $setarr['images'] = $param['images'];
        if (!empty($param['summary']))
            $setarr['summary'] = $param['summary'];
        if (!empty($param['message']))
            $setarr['message'] = $param['message'];
        if (isset($param['cwname']))
            $setarr['cwname'] = $param['cwname'];
        if (isset($param['cwsource']))
            $setarr['cwsource'] = $param['cwsource'];
        if (isset($param['cwurl']))
            $setarr['cwurl'] = $param['cwurl'];
        if (!empty($param['cwsize']))
            $setarr['cwsize'] = $param['cwsize'];
        if (!empty($param['cwlength']))
            $setarr['cwlength'] = $param['cwlength'];
        if(!empty($param['hot'])){
            $setarr['hot'] = $param['hot'];
        }else
			$setarr['hot'] = 0;
        if(!empty($param['top'])){
            $setarr['top'] = $param['top'];
        }else
			$setarr['top'] = 0;
        if(!empty($param['best'])){
            $setarr['best'] = $param['best'];
        }else
			$setarr['best'] = 0;
        if(!empty($param['grade'])){
            $setarr['grade'] = $param['grade'];
        }
        if(!empty($param['edition'])){
            $setarr['edition'] = $param['edition'];
        }
        $setarr['dateline'] = SYSTIME;
		if(!empty($param['submitat'])){
			$setarr['submitat'] = $param['submitat'];
			$setarr['truedateline'] = $param['submitat'];
		}else{
			$setarr['truedateline'] = SYSTIME;
		}
		if(!empty($param['endat'])){
			$setarr['endat'] = $param['endat'];
		}
		if(isset($param['islive'])){
			$setarr['islive'] = $param['islive'];
		}
        if(!empty($param['liveid'])){
            $setarr['liveid'] = $param['liveid'];
        }
        if(isset($param['checksum'])){
            $setarr['checksum'] = $param['checksum'];
        }
        if (isset($param['verifyprice']))
            $setarr['verifyprice'] = $param['verifyprice'];
        if (isset($param['price']))
            $setarr['price'] = $param['price'];
        if (isset($param['isclass']))
            $setarr['isclass'] = $param['isclass'];
        if (isset($param['status']))
            $setarr['status'] = $param['status'];
        if (isset($param['ism3u8']))
            $setarr['ism3u8'] = $param['ism3u8'];
        if (isset($param['m3u8url']))
            $setarr['m3u8url'] = $param['m3u8url'];
        if (isset($param['sourceid']))
            $setarr['sourceid'] = $param['sourceid'];
        if (isset($param['ispreview']))
            $setarr['ispreview'] = $param['ispreview'];
        if (isset($param['apppreview']))
            $setarr['apppreview'] = $param['apppreview'];
        if (isset($param['displayorder']))
            $setarr['displayorder'] = $param['displayorder'];
        if (isset($param['assistantid'])) {
            $setarr['assistantid'] = $param['assistantid'];
        }

        if (isset($param['open_chatroom'])) {
            $setarr['open_chatroom'] = $param['open_chatroom'];
        }
        if (isset($param['live_type'])) {
            $setarr['live_type'] = $param['live_type'];
        }
		if (isset($param['askto'])) {
            $setarr['askto'] = $param['askto'];
        }
        $cwid = $this->db->insert('ebh_coursewares', $setarr);
        if ($cwid) {
            $rcsetarr = array();    //升级roomcourses
            if (!empty($param['crid']))
                $rcsetarr['crid'] = $param['crid'];
            $rcsetarr['cwid'] = $cwid;
            if (!empty($param['folderid']))
                $rcsetarr['folderid'] = $param['folderid'];
            if (!empty($param['cdisplayorder']))
                $rcsetarr['cdisplayorder'] = $param['cdisplayorder'];
            if (!empty($param['isfree']))
                $rcsetarr['isfree'] = $param['isfree'];
            if (!empty($param['sid']))
                $rcsetarr['sid'] = $param['sid'];
			if (!empty($param['cprice']))
				$rcsetarr['cprice'] = $param['cprice'];
			if (!empty($param['cmonth']))
				$rcsetarr['cmonth'] = $param['cmonth'];
			if (!empty($param['cday']))
				$rcsetarr['cday'] = $param['cday'];
			if (!empty($param['cwpay']) && empty($param['classids']))
				$rcsetarr['cwpay'] = $param['cwpay'];
			if (!empty($param['roomfee']))
				$rcsetarr['roomfee'] = $param['roomfee'];
			if (!empty($param['comfee']))
				$rcsetarr['comfee'] = $param['comfee'];
			if (isset($param['delaytime'])) {
			    $rcsetarr['delaytime'] = $param['delaytime'];
            }
            if (!empty($param['classids'])) {
                $rcsetarr['classids'] = $param['classids'];
            }
            $this->db->insert('ebh_roomcourses', $rcsetarr);
        }
        return $cwid;
    }

    public function update($param = array(), $wherearr = array()) {
        if (empty($wherearr['cwid']) && empty($wherearr['crid']))
            return FALSE;
        $setarr = array();
		$arows = 0;
        if (!empty($param['catid']))
            $setarr['catid'] = $param['catid'];
        if (!empty($param['catpath']))
            $setarr['catpath'] = $param['catpath'];
        if (!empty($param['title']))
            $setarr['title'] = $param['title'];
        if (!empty($param['sub_title']))
            $setarr['sub_title'] = $param['sub_title'];
        if (!empty($param['author']))
            $setarr['author'] = $param['author'];
        if (!empty($param['tag']))
            $setarr['tag'] = $param['tag'];
        if (isset($param['logo']))
            $setarr['logo'] = $param['logo'];
        if (!empty($param['images']))
            $setarr['images'] = $param['images'];
        if (!empty($param['summary']))
            $setarr['summary'] = $param['summary'];
        if (isset($param['message']))
            $setarr['message'] = $param['message'];
        if (isset($param['cwname']))
            $setarr['cwname'] = $param['cwname'];
        if (isset($param['cwsource']))
            $setarr['cwsource'] = $param['cwsource'];
        if (isset($param['cwurl']))
            $setarr['cwurl'] = $param['cwurl'];
        if (isset($param['cwsize']))
            $setarr['cwsize'] = $param['cwsize'];
        if (isset($param['cwlength']))
            $setarr['cwlength'] = $param['cwlength'];
        if(!empty($param['hot'])){
            $setarr['hot'] = $param['hot'];
        }
        if(!empty($param['top'])){
            $setarr['top'] = $param['top'];
        }
        if(!empty($param['best'])){
            $setarr['best'] = $param['best'];
        }
        $param['updatedateline'] = SYSTIME;
        if (isset($param['verifyprice']))
            $setarr['verifyprice'] = $param['verifyprice'];
        if (isset($param['price']))
            $setarr['price'] = $param['price'];
        if (isset($param['isclass']))
            $setarr['isclass'] = $param['isclass'];
        if (isset($param['status']))
            $setarr['status'] = $param['status'];
        if (isset($param['displayorder']))
            $setarr['displayorder'] = $param['displayorder'];
		if(isset($param['submitat']))
			$setarr['submitat'] = $param['submitat'];
		if(isset($param['endat']))
			$setarr['endat'] = $param['endat'];
		if(!empty($param['truedateline']))
			$setarr['truedateline'] = $param['truedateline'];
		if(isset($param['ispreview']))
			$setarr['ispreview'] = $param['ispreview'];
		if(isset($param['apppreview']))
			$setarr['apppreview'] = $param['apppreview'];
		if(isset($param['ism3u8']))
			$setarr['ism3u8'] = $param['ism3u8'];
		if(isset($param['m3u8url']))
			$setarr['m3u8url'] = $param['m3u8url'];
        if (isset($param['sourceid']))
            $setarr['sourceid'] = $param['sourceid'];
        if(!empty($param['liveid'])){
            $setarr['liveid'] = $param['liveid'];
        }
        if(isset($param['checksum'])){
            $setarr['checksum'] = $param['checksum'];
        }
        if (isset($param['assistantid'])) {
            $setarr['assistantid'] = $param['assistantid'];
        }

        if (isset($param['open_chatroom'])) {
            $setarr['open_chatroom'] = $param['open_chatroom'];
        }
        if (isset($param['live_type'])) {
            $setarr['live_type'] = $param['live_type'];
        }
		if (isset($param['askto'])) {
            $setarr['askto'] = $param['askto'];
        }
        $cwwhere = array('cwid' => $wherearr['cwid']);
        $arows += $this->db->update('ebh_coursewares', $setarr, $cwwhere);

        $rcsetarr = array();    //升级roomcourses
        if (!empty($param['cdisplayorder']))
            $rcsetarr['cdisplayorder'] = $param['cdisplayorder'];
        if (isset($param['isfree']))
            $rcsetarr['isfree'] = $param['isfree'];
        if (!empty($param['sid']))
            $rcsetarr['sid'] = $param['sid'];
		if (isset($param['cprice']))
			$rcsetarr['cprice'] = $param['cprice'];
		if (isset($param['cmonth']))
			$rcsetarr['cmonth'] = $param['cmonth'];
        if (isset($param['looktime']))
            $rcsetarr['looktime'] = $param['looktime'];
		if (isset($param['cday']))
			$rcsetarr['cday'] = $param['cday'];
		if (isset($param['cwpay']))
			$rcsetarr['cwpay'] = $param['cwpay'];
		if (isset($param['roomfee']))
			$rcsetarr['roomfee'] = $param['roomfee'];
		if (isset($param['comfee']))
			$rcsetarr['comfee'] = $param['comfee'];
        if (isset($param['delaytime'])) {
            $rcsetarr['delaytime'] = $param['delaytime'];
        }
		if (isset($param['classids'])) {
            $rcsetarr['classids'] = $param['classids'];
		}
		if(!empty($rcsetarr))
            $arows += $this->db->update('ebh_roomcourses', $rcsetarr, $wherearr);
        return $arows;
    }

    /**
     * 删除课件信息，删除同时，需要删除课件相关的数据，如ebh_roomcourses,ebh_attachments等
     * 1，开启事务
     * 2，删除课件评论
     * 3，删除课件附件记录
     * 4，删除附件文件
     * 5，删除课件笔记文件
     * 6，删除课件文件
     * 7，删除课件记录
     * 8，更新课件数信息
     * 9，完成事务
     * @param type $cwid
     * @param array $course 课件信息数组
     * @return boolean
     */
    public function delcourse($cwid) {
        $this->db->begin_trans();
        //删除课件评论，ebh_logs和ebh_reviews
        $logsql = 'delete from ebh_reviews where type=\'courseware\' and toid=' . $cwid;
        $wherearr = array('cwid' => $cwid);
        $this->db->query($logsql, FALSE);
        //删除附件记录
        $this->db->delete('ebh_attachments', $wherearr);
        //删除课件笔记记录
        $this->db->delete('ebh_notes', $wherearr);
        //删除课件记录
        $this->db->delete('ebh_roomcourses', $wherearr);
        $this->db->delete('ebh_coursewares', $wherearr);
        if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
        return TRUE;
    }

    /**
     * 获取课件详情
     * @param int $cwid
	 * @param int $crid
     * @return array
     */
    public function getcoursedetail($cwid,$crid=0) {
        $sql = 'select c.cwid,c.uid,c.catid,c.title,c.tag,c.logo,c.images,c.isrtmp,c.ism3u8,c.m3u8url,c.thumb,c.summary,c.message,c.cwname,c.cwsource,c.cwurl,cwsize,c.dateline,c.ispreview,c.apppreview,c.status,c.submitat,c.endat,c.cwlength,c.islive,c.liveid,c.sourceid,c.checksum,c.zannum,c.assistantid,c.open_chatroom,c.live_type,u.username,u.realname,rc.crid,rc.folderid,rc.sid,rc.isfree,rc.cdisplayorder,rc.delaytime,rc.classids,f.foldername,f.fprice,f.isremind,f.remindtime,f.remindmsg,f.summary as fsummary,f.img as flogo,f.isschoolfree,c.viewnum,c.submitat,c.endat,c.cwlength,c.truedateline,u.sex,u.face,rc.cwpay,rc.cmonth,rc.cday,rc.cprice,rc.roomfee,rc.looktime,rc.comfee,rc.classids,c.askto ' .
                'from ebh_coursewares c ' .
                'join ebh_roomcourses rc on (c.cwid = rc.cwid) ' .
                'left join ebh_users u on (u.uid = c.uid) ' .
                'join ebh_folders f on (f.folderid = rc.folderid) ' .
                'where c.cwid=' . $cwid . ' and f.del=0';
		if($crid>0){
			$sql .= ' and rc.crid= '.$crid;
		}
        return $this->db->query($sql)->row_array();
    }
	/**
	*获取课件详情(stores模版适用)
	*/
	public function getcoursebycwid($cwid){
		$sql = 'select c.cwid,c.uid,c.catid,c.title,c.tag,c.logo,c.images,c.summary,c.message,c.cwname,c.cwsource,c.cwurl,cwsize,c.dateline,u.username,u.realname,rc.crid,rc.folderid,rc.sid,rc.isfree,rc.cdisplayorder '.
                'from ebh_coursewares c ' .
                'left join ebh_roomcourses rc on (c.cwid = rc.cwid) ' .
                'left join ebh_users u on (u.uid = c.uid) ' .
                'where c.cwid=' . $cwid;
        return $this->db->query($sql)->row_array();
	}

    /**
     * 获取课件详情及网校name及课件数coursenum
     * @param int $cwid
     * @return array
     */
    public function getcoursedetails($cwid) {
        $sql = 'select c.cwid,c.uid,c.title,c.tag,c.logo,c.images,c.summary,c.message,c.cwname,c.cwsource,c.cwurl,c.dateline,u.username,u.realname,rc.crid,rc.folderid,rc.sid,rc.isfree,f.foldername,cr.crname,cr.coursenum,cr.domain,cr.viewnum,c.cwurl,c.viewnum,f.coursewarenum,cr.domain ' .
                'from ebh_coursewares c ' .
                'join ebh_roomcourses rc on (c.cwid = rc.cwid) ' .
                'join ebh_users u on (u.uid = c.uid) ' .
                'join ebh_folders f on (f.folderid = rc.folderid) ' .
                'join ebh_classrooms cr on (cr.crid = rc.crid) ' .
                'where c.cwid=' . $cwid;
        return $this->db->query($sql)->row_array();
    }

    /**
     * 获取播放课件时用到的课件详情数据
     * @param int $cwid
     * @return array
     */
    public function getplaycoursedetail($cwid) {
        $sql = 'SELECT cw.cwurl,cw.cwsource,cw.title,cw.status,cw.ispreview,cw.apppreview,r.isfree,cr.isschool,cr.isshare,cr.ispublic,r.crid,cr.upid,f.fprice,f.folderid FROM ebh_coursewares cw JOIN '
                . 'ebh_roomcourses r ON cw.cwid=r.cwid  JOIN ebh_folders f ON r.folderid = f.folderid JOIN '
                . 'ebh_classrooms cr ON cr.crid = r.crid where cw.cwid=' . $cwid;
        return $this->db->query($sql)->row_array();
    }
	/**
     * 获取课件的简单信息
     * @param int $cwid
     * @return array
     */
	public function getSimplecourseByCwid($cwid) {
		$sql = "select cw.uid,cw.cwid,cw.cwsource,cw.title,cw.dateline,cw.viewnum,cw.submitat, cw.ism3u8 from ebh_coursewares cw where cw.cwid=$cwid";
		return $this->db->query($sql)->row_array();
	}

    public function getcourselist($param = array(), $setKey = false) {
        $sql = 'select c.cwid,c.title,c.logo,c.viewnum from ebh_coursewares c ' .
                'join ebh_roomcourses rc on (c.cwid = rc.cwid) ';
        $wherearr = array();
        $wherearr[] = 'status=1';
        if (isset($param['isfree']))
            $wherearr[] = 'rc.isfree='.$param['isfree'];
        if (isset($param['hot']))
            $wherearr[] = 'c.hot='.$param['hot'];
		if(isset($param['crid']))
			$wherearr[] = 'rc.crid='.intval($param['crid']);
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order'])) {
            $sql .= ' ORDER BY ' . $param['order'];
        } else {
            $sql .= ' ORDER BY c.cwid DESC';
        }
        if(isset($param['limit'])) {
            if (!empty($param['limit'])) {
                $sql .= ' limit ' . intval($param['limit']);
            } else {
                $sql .= ' limit 0,10';
            }
        }
        //echo $sql;
        //log_message($sql);

        return $this->db->query($sql)->list_array($setKey ? 'cwid' : '');
    }

    /**
     * 根据课程编号或教室编号获取按照章节排名的课件列表
     * @param int $folderid 课程编号
     * @return array 课件列表数组
     */
    public function getfolderseccourselist($queryarr = array()) {
		if(empty($queryarr['folderid']) && empty($queryarr['crid']))
			return FALSE;
        $sql = 'SELECT cw.cwid,cw.uid,cw.notice,cw.open_chatroom,cw.islive,u.username,u.realname,u.sex,u.face,cw.title,cw.cwsource,cw.dateline,cw.attachmentnum,cw.examnum,cw.ism3u8,cw.logo,cw.zannum,r.isfree,r.cdisplayorder,s.sid,s.sname,cw.cwurl,cw.islive,ifnull(s.displayorder,10000) sdisplayorder,f.foldername,f.folderid,cw.cwurl,cw.summary,cw.viewnum,cw.reviewnum,cw.submitat,cw.endat,cw.cwsize,cw.cwlength,cw.status,r.looktime,r.cwpay,r.cprice,r.cmonth,r.cday,r.crid,cw.truedateline from ebh_roomcourses r ' .
                'JOIN ebh_coursewares cw ON r.cwid = cw.cwid ' .
                'LEFT JOIN ebh_sections s ON r.sid=s.sid ' .
                'LEFT JOIN ebh_users u on (u.uid = cw.uid) ' .
				'LEFT JOIN ebh_folders f on f.folderid = r.folderid'
				;
		$wherearr = array();
		if(!empty($queryarr['uid'])) {
            $wherearr[] = '(cw.uid='.$queryarr['uid'].' or cw.islive=1 and FIND_IN_SET('.$queryarr['uid'].',cw.assistantid))';
        }
		if(!empty($queryarr['folderid']))
			$wherearr[] = 'r.folderid='.$queryarr['folderid'];
		if(!empty($queryarr['crid']))
			$wherearr[] = 'r.crid='.$queryarr['crid'];
		if(isset($queryarr['isfree']))
			$wherearr[] = 'r.isfree='.$queryarr['isfree'];
        if (!empty($queryarr['q']))
            $wherearr[] = ' cw.title like \'%' . $this->db->escape_str($queryarr['q']) . '%\'';
		if(isset($queryarr['status']))
			$wherearr[] = 'cw.status in('.$queryarr['status'].')';
		if(!empty($queryarr['sid']))
			$wherearr[] = 'r.sid='.$queryarr['sid'];
		if(!empty($queryarr['startDate']))
			$wherearr[] = 'cw.truedateline>='.$queryarr['startDate'];
		if(!empty($queryarr['endDate']))
			$wherearr[] = 'cw.truedateline<'.$queryarr['endDate'];
		if(isset($queryarr['power']))
			$wherearr[] = 'f.power in ('.$queryarr['power'].')';
		if(isset($queryarr['cwpay']))
			$wherearr[] = 'r.cwpay='.$queryarr['cwpay'];
		if(!empty($queryarr['cwids']))
			$wherearr[] = 'r.cwid in ('.$queryarr['cwids'].')';
		$wherearr[] = 'f.del=0';

		if (isset($queryarr['classids'])) {
            if (empty($queryarr['classids'])) {
                $wherearr[] = '(r.classids=\'\' OR r.classids=\'0\')';
            } else {
                $wherearr[] = '(r.classids=\'\' OR r.classids=\'0\' OR find_in_set('.$queryarr['classids'].',r.classids))';
            }
        }
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($queryarr['freeorder']))
			$sql.= ' order by '.$queryarr['freeorder'];
		else
			$sql .= ' ORDER BY sdisplayorder ASC,s.sid ASC,r.cdisplayorder ASC,cw.displayorder ASC,cw.cwid DESC ';
		if(!empty($queryarr['limit'])) {
            $sql .= ' limit '. $queryarr['limit'];
        } else {
			if (empty($queryarr['page']) || $queryarr['page'] < 1)
				$page = 1;
			else
				$page = $queryarr['page'];
			$pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
			$start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
        return $this->db->query($sql)->list_array();
    }

    public function getfolderseccoursecount($queryarr = array()) {
        $count = 0;
		if(empty($queryarr['folderid']) && empty($queryarr['crid']))
			return $count;
        $sql = 'SELECT count(*) count from ebh_roomcourses r ' .
                'JOIN ebh_coursewares cw ON r.cwid = cw.cwid ';
        $wherearr = array();
		if(!empty($queryarr['uid'])) {
            $wherearr[] = '(cw.uid='.$queryarr['uid'].' or cw.islive=1 and FIND_IN_SET('.$queryarr['uid'].',cw.assistantid))';
        }
		if(!empty($queryarr['folderid']))
			$wherearr[] = 'r.folderid='.$queryarr['folderid'];
		if(!empty($queryarr['crid']))
			$wherearr[] = 'r.crid='.$queryarr['crid'];
		if(isset($queryarr['isfree']))
			$wherearr[] = 'r.isfree='.$queryarr['isfree'];
        if (!empty($queryarr['q']))
            $wherearr[] = ' cw.title like \'%' . $this->db->escape_str($queryarr['q']) . '%\'';
		if(isset($queryarr['status']))
			$wherearr[] = 'cw.status in('.$queryarr['status'].')';
		if(isset($queryarr['sid']))
			$wherearr[] = 'r.sid='.$queryarr['sid'];
		if(!empty($queryarr['cwids']))
			$wherearr[] = 'r.cwid in ('.$queryarr['cwids'].')';
		if(isset($queryarr['ism3u8']))
			$wherearr[] = 'cw.ism3u8='.$queryarr['ism3u8'];
		if (isset($queryarr['classids'])) {
            if (empty($queryarr['classids'])) {
                $wherearr[] = '(r.classids=\'\' OR r.classids=\'0\')';
            } else {
                $wherearr[] = '(r.classids=\'\' OR r.classids=\'0\' OR find_in_set('.$queryarr['classids'].',r.classids))';
            }
        }

		$sql .= ' WHERE '.implode(' AND ',$wherearr);
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow))
            $count = $countrow['count'];
        return $count;
    }

	/*
	获取老师的课件数和课时
	*/
	public function getTcoursecount($param) {
		//print_r($param);
    	$count = 0;
    	$sql = 'SELECT count(*) as count, sum(cw.cwlength) as cwlength FROM ebh_coursewares cw left join ebh_roomcourses r on cw.cwid=r.cwid ';
    	$wherearr = array();
    	if (!empty($param['crid']))
            $wherearr[] = 'r.crid=' . $param['crid'];
        if (!empty($param['uid']))
            $wherearr[] = 'cw.uid=' . $param['uid'];
		if (isset($param['folderid']))
            $wherearr[] = 'r.folderid=' . $param['folderid'] .' and (cw.status != -2 and cw.status != -3)';
    	if (!empty($wherearr))
    		$sql.= ' WHERE ' . implode(' AND ', $wherearr);
    	$count = $this->db->query($sql)->row_array();
    	return $count;
    }

    //学校的作业数
    public function getexamcount($cwid) {
        $count = 0;
     //   $sql = 'SELECT count(1) as num from ebh_exams e left join ebh_coursewares c ON c.cwid = e.cwid left join ebh_roomcourses r on r.cwid = c.cwid left join ebh_folders f on f.folderid = f.folderid where c.cwid = ' . $cwid;
		$sql = 'SELECT count(1) as num from ebh_exams e where e.cwid = ' . $cwid;
        $ecount = $this->db->query($sql)->row_array();
        if (!empty($ecount))
            $count = $ecount['num'];
        return $count;
    }

    //同类课件推荐
    public function getcommoncourses($param) {
        $sql = 'select cw.title,cw.cwid from ebh_coursewares cw left join ebh_roomcourses r on cw.cwid=r.cwid left join ebh_folders f on r.folderid = f.folderid';
        $wherearr = array();
        if (!empty($param['folderid'])) {
            $wherearr[] = 'f.folderid IN (' . $param['folderid'] . ')';
        }
        if (!empty($param['status'])) {
            $wherearr[] = 'cw.status IN (' . $param['status'] . ')';
        }
        if (!empty($param['isclass'])) {
            $wherearr[] = 'cw.isclass = ' . $param['isclass'];
        }
        if (!empty($param['isfree'])) {
            $wherearr[] = 'r.isfree = ' . $param['isfree'];
        }
        if (!empty($wherearr)) {
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        }
        if (!empty($param['displayorder'])) {
            $sql .= ' ORDER BY ' . $param['displayorder'];
        } else {
            $sql .= ' ORDER BY cw.displayorder';
        }
        if (!empty($param['limit'])) {
            $sql .= ' limit ' . $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
    }

    //免费超市获取免费课件
    public function getallcourseware($param = array()) {
        $sql = 'SELECT r.cwid,c.uid,u.username,u.realname,c.catid,c.catpath,c.title,c.images,c.summary,c.message,c.dateline,cr.domain,cr.cface,f.foldername,cr.crname '
		.'FROM ebh_roomcourses r '
        .'LEFT JOIN ebh_classrooms cr ON cr.crid = r.crid '
		.'LEFT JOIN ebh_coursewares c ON c.cwid = r.cwid '
        .'LEFT JOIN ebh_users u ON c.uid = u.uid '
		.'LEFT JOIN ebh_folders f ON f.folderid=r.folderid ';
        $wherearr = array();
        if (!empty($param['keyname'])) {
            $wherearr [] = 'c.title like \'%'. $this->db->escape_str($param['keyname']) .'%\'';
        }
        if (!empty($param['catid'])) {
            $wherearr[] = 'c.catid=' . $param['catid'];
        }
        if (!empty($param['type'])) {
            $wherearr[] = 'c.type=\'' . $param['type'] . '\'';
        }
        if (!empty($param['citycode'])) {
            $wherearr[] = 'c.citycode=\'' . $param['citycode'] . '\'';
        }
        if (!empty($param['crid'])) {
            $wherearr[] = 'cr.crid=' . $param['crid'];
        }
        if (!empty($param['best'])) {
            $wherearr[] = 'cr.best=' . $param['best'];
        }
        if (!empty($param['status'])) {
            $wherearr[] = 'c.status in (' . $param['status'] . ')';
        }
        if (!empty($param['isfree'])) {
            $wherearr[] = 'r.isfree=' . $param['isfree'];
        }
        //广告类型
        if (!empty($param['code'])) {
            if ($param['code'])
                $wherearr[] = 'c.code =\'' . $param['code'] . '\' ';
        }
        if (!empty($wherearr)) {
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        }
        if (!empty($param['displayorder'])) {
            $sql .= ' ORDER BY ' . $param['displayorder'];
        } else {
            $sql .= ' ORDER BY cr.displayorder asc,r.crid ';
        }
        if (!empty($param['limit'])) {
            $sql .= ' limit ' . $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
    }
    //免费超市获取免费课件数量
    public function getallcoursewareCount($param = array()) {
        $sql = 'SELECT count(*) count '
        .'FROM ebh_roomcourses r '
        .'LEFT JOIN ebh_classrooms cr ON cr.crid = r.crid '
        .'LEFT JOIN ebh_coursewares c ON c.cwid = r.cwid '
        .'LEFT JOIN ebh_folders f ON f.folderid=r.folderid ';
        $wherearr = array();
        if (!empty($param['keyname'])) {
            $wherearr [] = 'c.title like \'%'. $this->db->escape_str($param['keyname']) .'%\'';
        }
        if (!empty($param['catid'])) {
            $wherearr[] = 'c.catid=' . $param['catid'];
        }
        if (!empty($param['type'])) {
            $wherearr[] = 'c.type=\'' . $param['type'] . '\'';
        }
        if (!empty($param['citycode'])) {
            $wherearr[] = 'c.citycode=\'' . $param['citycode'] . '\'';
        }
        if (!empty($param['crid'])) {
            $wherearr[] = 'cr.crid=' . $param['crid'];
        }
        if (!empty($param['best'])) {
            $wherearr[] = 'cr.best=' . $param['best'];
        }
        if (!empty($param['status'])) {
            $wherearr[] = 'c.status in (' . $param['status'] . ')';
        }
        if (!empty($param['isfree'])) {
            $wherearr[] = 'r.isfree=' . $param['isfree'];
        }
        //广告类型
        if (!empty($param['code'])) {
            if ($param['code'])
                $wherearr[] = 'c.code =\'' . $param['code'] . '\' ';
        }
        if (!empty($wherearr)) {
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        }

        $res =  $this->db->query($sql)->row_array();
        return $res['count'];
    }
    /*
      后台获取课件列表
      @param array $param
      @return array 列表数组
     */

    public function getcoursewarelist($param) {
        $sql = 'select c.cwid,c.title,c.dateline,c.sub_title,c.cwurl,c.cwsource,c.viewnum,c.status,c.price,u.realname,cat.name,c.top,c.best,c.hot
			from ebh_coursewares c
			left join ebh_users u on u.uid = c.uid
			left join ebh_categories cat on c.catid = cat.catid';
        if (isset($param['q']))
            $wherearr[] = ' (c.title like \'%' . $param['q'] . '%\' or u.realname like \'%' . $param['q'] . '%\')';
        if(strlen($param['status'])>0){
            $wherearr[] = 'c.status='.intval($param['status']);
        }
        if(!empty($param['in'])){
            $wherearr[] = 'c.catid in'.$param['in'];
        }
        if(strlen($param['hot'])>0){
            $wherearr[] = 'c.hot='.intval($param['hot']);
        }
        if(strlen($param['top'])>0){
            $wherearr[] = 'c.top='.intval($param['top']);
        }
        if(strlen($param['best'])>0){
            $wherearr[] = 'c.best='.intval($param['best']);
        }
        if (!empty($wherearr))
            $sql.= ' where ' . implode(' AND ', $wherearr);
        $sql.=' order by cwid desc';
        if (!empty($param['limit']))
            $sql.= ' limit ' . $param['limit'];
        //var_dump($sql);
        return $this->db->query($sql)->list_array();
    }

    /*
      后台获取课件数量
      @param array $param
      @return int
     */

    public function getcoursewarecount($param) {
        $sql = 'select count(*) count
			from ebh_coursewares c
			left join ebh_users u on u.uid = c.uid';
        if (isset($param['q']))
            $wherearr[] = ' (c.title like \'%' . $param['q'] . '%\' or u.realname like \'%' . $param['q'] . '%\')';
        if(strlen($param['status'])>0){
            $wherearr[] = 'c.status='.intval($param['status']);
        }
        if(!empty($param['in'])){
            $wherearr[] = 'c.catid in'.$param['in'];
        }
        if(strlen($param['hot'])>0){
            $wherearr[] = 'c.hot='.intval($param['hot']);
        }
        if(strlen($param['top'])>0){
            $wherearr[] = 'c.top='.intval($param['top']);
        }
        if(strlen($param['best'])>0){
            $wherearr[] = 'c.best='.intval($param['best']);
        }
        if (!empty($wherearr))
            $sql.= ' where ' . implode(' AND ', $wherearr);

        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }
	/*
	*前台获取课件数量
	*/
	 public function getcoursecounts($param) {
        $sql = 'select count(*) count
			from ebh_coursewares cw left join ebh_teachers t on cw.uid = t.teacherid left join ebh_roomcourses r on cw.cwid = r.cwid left join ebh_folders f on r.folderid = f.folderid left join ebh_classrooms cr on cr.crid= r.crid';
		$wherearr = array();
		if (isset($param['q']))
			$wherearr[] = 'cw.title like \'%'. $this->db->escape_str($param['q']) .'%\'';
		if (!empty($param['status'])) {
            $wherearr[] = 'cw.status in (' . $param['status'] . ')';
        }
        if (!empty($param['isfree'])) {
            $wherearr[] = 'r.isfree=' . $param['isfree'];
        }
		 if (!empty($param['isclass'])) {
            $wherearr[] = 'cw.isclass=' . $param['isclass'];
        }
        if(!empty($param['crid'])){
            $wherearr[] = 'r.crid=' . $param['crid'];
        }
        if(!empty($param['folderid'])){
            $wherearr[] = 'r.folderid=' . $param['folderid'];
        }
        if(!empty($param['sid'])){
            $wherearr[] = 'r.sid=' . $param['sid'];
        }
		if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }
	/*
	*前台获取课件列表
	*/
	 public function getcourselists($param) {
        $sql = 'select cw.cwid,cw.title,cw.tag,cw.catid,cw.summary,cw.cwname,cw.viewnum,cw.status,f.foldername,cw.dateline,t.realname,cr.crname,cr.domain,cw.sub_title,cw.logo,cw.cwsource from ebh_coursewares cw left join ebh_teachers t on cw.uid = t.teacherid left join ebh_roomcourses r on cw.cwid = r.cwid left join ebh_folders f on r.folderid = f.folderid left join ebh_classrooms cr on cr.crid= r.crid';
        if (isset($param['q']))
            $wherearr[] = 'cw.title like \'%'. $this->db->escape_str($param['q']) .'%\'';
		if (!empty($param['status'])) {
            $wherearr[] = 'cw.status in (' . $param['status'] . ')';
        }
        if (!empty($param['isfree'])) {
            $wherearr[] = 'r.isfree=' . $param['isfree'];
        }
		 if (!empty($param['isclass'])) {
            $wherearr[] = 'cw.isclass=' . $param['isclass'];
        }
        if(!empty($param['crid'])){
            $wherearr[] = 'r.crid=' . $param['crid'];
        }
        if(!empty($param['folderid'])){
            $wherearr[] = 'r.folderid=' . $param['folderid'];
        }
        if(!empty($param['sid'])){
            $wherearr[] = 'r.sid=' . $param['sid'];
        }
		if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY r.cdisplayorder';
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



    /*
      删除课件
      @param int $cwid
      @return bool
     */

    public function deletecourseware($cwid) {
        $sql = 'delete c.* from ebh_coursewares c where c.cwid=' . $cwid;
        return $this->db->simple_query($sql);
    }

    /*
      编辑课件
      @param array $param
      @return int
      @modified by zkq in 2014-04-25
     */

    public function editcourseware($param=array()) {
        if(empty($param)){
            return false;
        }
        if(empty($param['cwid']))
            return false;
        $setarr = array();
        if(!empty($param['uid'])){
            $setarr['uid']=$param['uid'];
        }
        if (!empty($param['catid']))
            $setarr['catid'] = $param['catid'];
        if (!empty($param['catpath']))
            $setarr['catpath'] = $param['catpath'];
        if (!empty($param['title']))
            $setarr['title'] = $param['title'];
        if (!empty($param['sub_title']))
            $setarr['sub_title'] = $param['sub_title'];
        if (!empty($param['author']))
            $setarr['author'] = $param['author'];
        if (!empty($param['tag']))
            $setarr['tag'] = $param['tag'];
        if (!empty($param['logo']))
            $setarr['logo'] = $param['logo'];
        if (!empty($param['images']))
            $setarr['images'] = $param['images'];
        if (!empty($param['summary']))
            $setarr['summary'] = $param['summary'];
        if (!empty($param['message']))
            $setarr['message'] = $param['message'];
        if (!empty($param['cwname']))
            $setarr['cwname'] = $param['cwname'];
        if (!empty($param['cwsource']))
            $setarr['cwsource'] = $param['cwsource'];
        if (!empty($param['cwurl']))
            $setarr['cwurl'] = $param['cwurl'];
        if (!empty($param['cwsize']))
            $setarr['cwsize'] = $param['cwsize'];
        if (!empty($param['cwlength']))
            $setarr['cwlength'] = $param['cwlength'];
        if(isset($param['hot'])){
            $setarr['hot'] = $param['hot'];
        }
        if(isset($param['top'])){
            $setarr['top'] = $param['top'];
        }
        if(isset($param['best'])){
            $setarr['best'] = $param['best'];
        }
        if(!empty($param['edition'])){
            $setarr['edition'] = $param['edition'];
        }

        if (isset($param['assistantid'])) {
            $setarr['assistantid'] = $param['assistantid'];
        }
        $param['updatedateline'] = SYSTIME;
        if (isset($param['verifyprice']))
            $setarr['verifyprice'] = $param['verifyprice'];
        if (isset($param['price']))
            $setarr['price'] = $param['price'];
        if (isset($param['isclass']))
            $setarr['isclass'] = $param['isclass'];
        if (isset($param['status']))
            $setarr['status'] = $param['status'];
        if (isset($param['displayorder']))
            $setarr['displayorder'] = $param['displayorder'];
        $wherearr = array('cwid' => $param['cwid']);
        $row = $this->db->update('ebh_coursewares', $setarr, $wherearr);
        return $row;
    }

    /*
      添加课件
      @param array $param
      @return int
      @modified by zkq in 2014-04-25
     */

    public function addcourseware($param) {
        if(empty($param))
            return false;
        $setarr = array();
        if (!empty($param['uid']))
            $setarr['uid'] = $param['uid'];
        if (!empty($param['catid']))
            $setarr['catid'] = $param['catid'];
        if (!empty($param['catpath']))
            $setarr['catpath'] = $param['catpath'];
        if (!empty($param['title']))
            $setarr['title'] = $param['title'];
        if (!empty($param['sub_title']))
            $setarr['sub_title'] = $param['sub_title'];
        if (!empty($param['author']))
            $setarr['author'] = $param['author'];
        if (!empty($param['tag']))
            $setarr['tag'] = $param['tag'];
        if (!empty($param['logo']))
            $setarr['logo'] = $param['logo'];
        if (!empty($param['images']))
            $setarr['images'] = $param['images'];
        if (!empty($param['summary']))
            $setarr['summary'] = $param['summary'];
        if (!empty($param['message']))
            $setarr['message'] = $param['message'];
        if (!empty($param['cwname']))
            $setarr['cwname'] = $param['cwname'];
        if (!empty($param['cwsource']))
            $setarr['cwsource'] = $param['cwsource'];
        if (!empty($param['cwurl']))
            $setarr['cwurl'] = $param['cwurl'];
        if (!empty($param['cwsize']))
            $setarr['cwsize'] = $param['cwsize'];
        if (!empty($param['cwlength']))
            $setarr['cwlength'] = $param['cwlength'];
        if(!empty($param['hot'])){
            $setarr['hot'] = $param['hot'];
        }else
			$setarr['hot'] = 0;
        if(!empty($param['top'])){
            $setarr['top'] = $param['top'];
        }else
			$setarr['top'] = 0;
        if(!empty($param['best'])){
            $setarr['best'] = $param['best'];
        }else
			$setarr['best'] = 0;
        if(!empty($param['grade'])){
            $setarr['grade'] = $param['grade'];
        }
        if(!empty($param['edition'])){
            $setarr['edition'] = $param['edition'];
        }
        $setarr['dateline'] = SYSTIME;
        if (isset($param['verifyprice']))
            $setarr['verifyprice'] = $param['verifyprice'];
        if (isset($param['price']))
            $setarr['price'] = $param['price'];
        if (isset($param['isclass']))
            $setarr['isclass'] = $param['isclass'];
        if (isset($param['status']))
            $setarr['status'] = $param['status'];
        if (isset($param['displayorder']))
            $setarr['displayorder'] = $param['displayorder'];
        $res = $this->db->insert('ebh_coursewares', $setarr);
        return $res;
    }

    /*
      课件详情
      @param int $cwid
      @param array 详情数组
     */

    public function getcoursewaredetail($cwid) {
        $sql = 'select c.title,c.sub_title,c.uid,c.dateline,u.username,c.catid,c.status,c.tag,c.summary,c.message,c.cwid,cat.name,c.top,c.hot,c.best,c.grade,c.edition,c.cwurl,c.cwsource,c.cwsize,c.cwname,c.logo,c.images,c.verifyprice,c.price,c.displayorder
			from ebh_coursewares c
			left join ebh_users u on c.uid=u.uid
			left join ebh_categories cat on c.catid = cat.catid
			where cwid =' . $cwid;
        return $this->db->query($sql)->row_array();
    }

    /**
     * 获取平台最新发布的课件
     */
       public function getnewcourselist($queryarr) {
        $sql = 'SELECT c.cwid,c.title,c.summary,c.viewnum,c.reviewnum,c.dateline,c.logo,u.username,u.realname,c.cwurl,f.foldername,f.folderid,f.coursewarelogo,u.face,u.sex,c.submitat,c.endat,c.ism3u8,c.cwlength,c.truedateline,c.islive,c.uid,c.assistantid FROM ebh_coursewares c ' .
                'JOIN ebh_roomcourses rc on (c.cwid = rc.cwid) '.
				'JOIN ebh_users u on (u.uid = c.uid) '.
				'JOIN ebh_folders f on f.folderid=rc.folderid';
        $wherearr = array();
        $wherearr[] = ' c.status != -3 ';
        if (!empty($queryarr['crid'])) {
            $wherearr[] = 'rc.crid=' . $queryarr['crid'];
        }
        if (!empty($queryarr['status'])) {
            $wherearr[] = 'c.status = 1';
        }
        if (!empty($queryarr['uid'])) {
            $wherearr[] = 'c.uid=' . $queryarr['uid'];
        }
		if(!empty($queryarr['abegindate'])) {
			$wherearr[] = 'c.dateline>='.$queryarr['abegindate'];
		}
		if(!empty($queryarr['aenddate'])) {
			$wherearr[] = 'c.dateline<'.$queryarr['aenddate'];
		}
		if (!empty($queryarr['classids'])) {
            if (empty($queryarr['classids'])) {
                $wherearr[] = '(rc.classids=\'\' OR rc.classids=\'0\')';
            } else {
                $wherearr[] = '(rc.classids=\'\' OR rc.classids=\'0\' OR find_in_set('.$queryarr['classids'].',rc.classids))';
            }
        }
		if(!empty($queryarr['truedatelinefrom']))
			$wherearr[] = 'c.truedateline>='.$queryarr['truedatelinefrom'];
		if(!empty($queryarr['truedatelineto']))
			$wherearr[] = 'c.truedateline<'.$queryarr['truedatelineto'];
		if(isset($queryarr['power']))
			$wherearr[] = 'f.power in ('.$queryarr['power'].')';
		if(!empty($queryarr['folderids']))
			$wherearr[] = 'rc.folderid in ('.$queryarr['folderids'].')';
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($queryarr['order']))
            $sql .= ' ORDER BY ' . $queryarr['order'];
        else
            $sql .= ' ORDER BY c.cwid DESC ';
        if (!empty($queryarr['limit']))
            $sql .= ' limit ' . $queryarr['limit'];
        else {
            $sql .= ' limit 0,10 ';
        }
      //  log_message($sql);
        return $this->db->query($sql)->list_array();
    }
	/**
     * 获取平台最新发布的课件数
     */
       public function getnewcourselistcount($queryarr) {
		$count = 0;
        $sql = 'SELECT count(*) count FROM ebh_coursewares c ' .
                'JOIN ebh_roomcourses rc on (c.cwid = rc.cwid) ';
        $wherearr = array();
        if (!empty($queryarr['crid'])) {
            $wherearr[] = 'rc.crid=' . $queryarr['crid'];
        }
        if (!empty($queryarr['status'])) {
            $wherearr[] = 'c.status = 1';
        }
        if (!empty($queryarr['uid'])) {
            $wherearr[] = 'c.uid=' . $queryarr['uid'];
        }
		if(!empty($queryarr['folderids']))
			$wherearr[] = 'rc.folderid in ('.$queryarr['folderids'].')';
		if (isset($queryarr['subtime']))
			$wherearr[] = 'c.dateline > '.$queryarr['subtime'];
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
        return $count;
    }

	//根据id查询课件
	public function getfoldercourse($folderid,$crid){
		$sql= 'select rc.crid,c.cwsource,c.title,rc.folderid from ebh_coursewares c join ebh_roomcourses rc on (c.cwid = rc.cwid) WHERE rc.crid = '.$crid.' AND c.status=1 AND rc.isfree = 1 and rc.folderid = '.$folderid.' order by rc.folderid,rc.cdisplayorder';
		 return $this->db->query($sql)->list_array();
	}

    /**
     * 添加课件的作业数
     * @param int $cwid
     * @param int $num
     */
    public function addexamnum($cwid, $num = 1) {
        $where = 'cwid=' . $cwid;
        $setarr = array('examnum' => 'examnum+' . $num);
        $this->db->update('ebh_coursewares', array(), $where, $setarr);
    }
	/**
     * 添加课件的附件数
     * @param int $cwid
     * @param int $num
     */
    public function addatachnum($cwid, $num = 1) {
        $where = 'cwid=' . $cwid;
        $setarr = array('attachmentnum' => 'attachmentnum+' . $num);
        $this->db->update('ebh_coursewares', array(), $where, $setarr);
    }
	/**
     * 添加课件的评论数
     * @param int $cwid
     * @param int $num
     */
    public function addreviewnum($cwid, $num = 1) {
        $where = 'cwid=' . $cwid;
        $setarr = array('reviewnum' => 'reviewnum+' . $num);
        $this->db->update('ebh_coursewares', array(), $where, $setarr);
    }
	/**
     * 屏蔽减少课件的评论数
     * @param int $cwid
     * @param int $num
     */
    public function editreviewnum($cwid, $num = 1) {
        $where = 'cwid=' . $cwid;
        $setarr = array('reviewnum' => 'reviewnum-' . $num);
        $this->db->update('ebh_coursewares', array(), $where, $setarr);
    }
	/**
     * 添加课件的查看数
     * @param int $cwid
     * @param int $num
     */
    public function addviewnum($cwid, $num = 1) {
        $where = 'cwid=' . $cwid;
        $setarr = array('viewnum' => 'viewnum+' . $num);
        $this->db->update('ebh_coursewares', array(), $where, $setarr);
    }

	public function setviewnum($cwid, $num = 1) {
		$where = 'cwid=' . $cwid;
        $setarr = array('viewnum' => $num);
        $this->db->update('ebh_coursewares', array(), $where, $setarr);
	}
	/*
	一次设置多个viewnum
	*/
	public function setMultiViewnum($viewnumlist){
		$sql = 'update ebh_coursewares set viewnum= CASE cwid';
		$wtArr = array();
		$inArr = array();
		foreach($viewnumlist as $cwid=>$viewnum){
			$wtArr[] = ' WHEN '.$cwid.' THEN '.$viewnum;
			$inArr[] = $cwid;
		}
		$sql.= implode(' ', $wtArr).' END WHERE cwid IN ('.implode(',', $inArr).')';
		// echo $sql;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	/*
	*stores的学习大纲列表
	*/
	public function getstudylist($param){
		$sql = 'select c.title,c.cwid,rc.isfree,c.examnum,u.realname,c.dateline,c.summary from ebh_roomcourses rc join ebh_coursewares c on(rc.cwid = c.cwid) left join ebh_users u on (u.uid = c.uid)';
		$wherearr = array();
		if (!empty($param['crid'])) {
            $wherearr[] = ' rc.crid = '.$param['crid'] ;
        }
		if (!empty($param['q'])) {
            $wherearr[] = ' c.title like \'%'. $this->db->escape_str($param['q']) .'%\'';
        }
		if (!empty($param['isfree'])) {
            $wherearr[] = ' rc.isfree = '.$param['isfree'] ;
        }
		if (!empty($param['folderid'])) {
            $wherearr[] = ' rc.folderid = '.$param['folderid'] ;
        }
		if (!empty($param['examnum'])) {
            $wherearr[] = ' c.examnum >= '.$param['examnum'] ;
        }
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY rc.cdisplayorder';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }else {
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
	*学习大纲在线试听
	*/
	public function getexamlist($param){
		$sql = 'select c.title,c.cwid,rc.isfree,c.examnum,u.realname,c.dateline,c.summary from ebh_roomcourses rc join ebh_coursewares c on(rc.cwid = c.cwid) left join ebh_exams e on (e.cwid = rc.cwid) left join ebh_users u on (u.uid = c.uid)';
		$wherearr = array();
		if (!empty($param['crid'])) {
            $wherearr[] = ' rc.crid = '.$param['crid'] ;
        }
		if (!empty($param['q'])) {
            $wherearr[] = ' c.title like \'%'. $this->db->escape_str($param['q']) .'%\'';
        }
		if (!empty($param['isfree'])) {
            $wherearr[] = ' rc.isfree = '.$param['isfree'] ;
        }
		if (!empty($param['folderid'])) {
            $wherearr[] = ' rc.folderid = '.$param['folderid'] ;
        }
		if (!empty($param['examnum'])) {
            $wherearr[] = ' c.examnum >= '.$param['examnum'] ;
        }
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY rc.cdisplayorder';
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
	* 根据folderid求的课程下的课件数量(试用于学习大纲)
	* @param array $param folderid crid
	*/
	public function getstudycount($param){
		$sql = 'select count(*) count from ebh_roomcourses r join ebh_coursewares c on(r.cwid = c.cwid)';

		$wherearr = array();
		if (!empty($param['crid'])) {
            $wherearr[] = ' r.crid = '.$param['crid'] ;
        }
		if (!empty($param['folderid'])) {
            $wherearr[] = ' r.folderid = '.$param['folderid'] ;
        }
		if (!empty($param['q'])) {
            $wherearr[] = ' c.title like \'%'. $this->db->escape_str($param['q']) .'%\'';
        }
		if (!empty($param['isfree'])) {
            $wherearr[] = ' r.isfree = '.$param['isfree'] ;
        }
		if (!empty($param['examnum'])) {
            $wherearr[] = ' c.examnum >= '.$param['examnum'] ;
        }
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
		$row = $this->db->query($sql)->row_array();
        return $row['count'];
	}
	/*
	*学习大纲在线试听课程的作业数量
	*/
	public function getexamcounts($param){
		$sql = 'select count(*) count from ebh_roomcourses rc join ebh_coursewares c on(rc.cwid = c.cwid) join ebh_exams e on (e.cwid = rc.cwid) ';
		$wherearr = array();
		if (!empty($param['crid'])) {
            $wherearr[] = ' rc.crid = '.$param['crid'] ;
        }
		if (!empty($param['q'])) {
            $wherearr[] = ' c.title like \'%'. $this->db->escape_str($param['q']) .'%\'';
        }
		if (!empty($param['isfree'])) {
            $wherearr[] = ' rc.isfree = '.$param['isfree'] ;
        }
		if (!empty($param['folderid'])) {
            $wherearr[] = ' rc.folderid = '.$param['folderid'] ;
        }
		if (!empty($param['examnum'])) {
            $wherearr[] = ' c.examnum >= '.$param['examnum'] ;
        }
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
		$row = $this->db->query($sql)->row_array();
        return $row['count'];
	}

	/*
	有子站的平台课件列表
	*/
	public function getCWlistForPlatform($param){
		$sql = 'select c.cwid,c.title from ebh_coursewares c ' .
                'join ebh_roomcourses rc on (c.cwid = rc.cwid) join ebh_classrooms cr on cr.crid = rc.crid';
        $wherearr = array();
        $wherearr[] = 'c.status=1';
        if (isset($param['isfree']))
            $wherearr[] = 'rc.isfree='.$param['isfree'];
        if (isset($param['hot']))
            $wherearr[] = 'c.hot='.$param['hot'];
		if(!empty($param['crid']))
			$wherearr[] = '(cr.crid='.$param['crid'].' or cr.upid='.$param['crid'].')';
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order'])) {
            $sql .= ' ORDER BY ' . $param['order'];
        } else {
            $sql .= ' ORDER BY c.cwid DESC';
        }
        if (!empty($param['limit'])) {
            $sql .= ' limit ' . $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
	}
	/**
	*更新课件的预览状态，1为可预览
	*/
	public function updateIspreview($cwid,$ispreview = 1,$apppreview) {
		$where = 'cwid=' . $cwid;
        $setarr = array('ispreview' => $ispreview);
		if(isset($apppreview))
			$setarr['apppreview'] = $apppreview;
        return $this->db->update('ebh_coursewares', $setarr, $where);
	}
	/**
	*更新课件的rtmp状态，1为可用于rtmp，以及更新视频图片
	*/
	public function updateIsrtmp($cwid,$param) {
		$where = 'cwid=' . $cwid;
		$setarr = array();
		if(!empty($param['cwurl'])) {
			$setarr['cwurl'] = $param['cwurl'];
		}
		if(isset($param['isrtmp'])) {
			$setarr['isrtmp'] = $param['isrtmp'];
		}
		if(isset($param['ism3u8'])) {
			$setarr['ism3u8'] = $param['ism3u8'];
		}
		if(!empty($param['m3u8url'])) {
			$setarr['m3u8url'] = $param['m3u8url'];
		}
		if(!empty($param['thumb'])) {
			$setarr['thumb'] = $param['thumb'];
		}
		if(!empty($param['cwlength'])) {
			$setarr['cwlength'] = $param['cwlength'];
		}
        if(empty($setarr))
			return FALSE;
        return $this->db->update('ebh_coursewares', $setarr, $where);
	}

    /**
     *根据cwid数组获取包含教师教室信息的课件列表
     *
     */
    public function getListWithDetailInfo($cwidArr){
        $sql = 'select cw.cwid,cw.title,cw.cwname,cw.images,u.username,u.realname,gd.gradename from ebh_coursewares cw left join ebh_users u on cw.uid = u.uid left join ebh_grades gd on cw.grade = gd.gradeid ';
        if(is_scalar($cwidArr)){
            $cwidArr = array($cwidArr);
        }
        $in = '('.implode(',',$cwidArr).')';
        $sql.=' WHERE cw.cwid in '.$in;
        return $this->db->query($sql)->list_array();
    }

	/*
	批量添加课件
	*/
	public function addMultipleCW($param){
		$coursenum = count($param);
		$sql = 'insert into ebh_coursewares (uid,title,tag,summary,cwname,cwurl,cwsize,dateline,truedateline,isclass,displayorder,status,cwsource) values ';
		foreach($param as $cw){
			$uid = $cw['uid'];
			$title = $this->db->escape_str($cw['title']);
			$tag = $cw['tag'];
			$summary = $this->db->escape_str($cw['summary']);
			$cwname = $this->db->escape_str($cw['cwname']);
			$cwurl = $cw['cwurl'];
			$cwsize = $cw['cwsize'];
			$dateline = SYSTIME;
			$truedateline = SYSTIME;
			$isclass = 1;
			$displayorder = $cw['cdisplayorder'];
			$status = 1;
			$cwsource = $cw['cwsource'];
			$sql.= "($uid,'$title','$tag','$summary','$cwname','$cwurl',$cwsize,$dateline,$truedateline,$isclass,$displayorder,$status,'$cwsource'),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		$fromcwid = $this->db->insert_id();

		$sql = 'insert into ebh_roomcourses (crid,cwid,folderid,cdisplayorder,sid) values ';
		for($i=0;$i<$coursenum;$i++){
			$cw = $param[$i];
			$cwid = $fromcwid + $i;
			$crid = $cw['crid'];
			$folderid = $cw['folderid'];
			$cdisplayorder = $cw['cdisplayorder'];
			$sid = $cw['sid'];
			$sql.= "($crid,$cwid,$folderid,$cdisplayorder,$sid),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);

		$this->db->update('ebh_classrooms',array(),array('crid'=>$crid),array('coursenum'=>'coursenum+'.$coursenum));

		$sql = 'select f.folderid,f.upid,f.folderlevel,f.folderpath from ebh_folders f where f.folderid='.$folderid;
		$folder = $this->db->query($sql)->row_array();
		$folderlevel = $folder['folderlevel'];
		while($folderlevel>1){
			$where = 'folderid='.$folderid;
			$setarr = array('coursewarenum'=>'coursewarenum+'.$coursenum);
			$this->db->update('ebh_folders',array(),$where,$setarr);
			$sql = 'select f.folderid,f.upid,f.folderlevel,f.folderpath from ebh_folders f where f.folderid='.$folder['upid'];
			$folder = $this->db->query($sql)->row_array();
			$folderlevel = $folder['folderlevel'];
			$folderid = $folder['folderid'];
		}
		// $this->db->update('ebh_folders',array(),array('folderid'=>$folderid),array('coursewarenum'=>'coursewarenum+'.$coursenum));
		return array('fromcwid'=>$fromcwid,'coursenum'=>$coursenum);
	}

    /**
     *获取学校的课件，用于统计
     *
     */
    public function getSchoolCourseware($crid){
        $sql = 'select cw.cwid,cw.title,f.foldername,cw.viewnum,r.classid,c.classname,cw.grade,cw.dateline,t.realname from ebh_coursewares cw
                left join ebh_teachers t on cw.uid = t.teacherid
                left join ebh_roomcourses r on cw.cwid = r.cwid left join ebh_folders f on r.folderid = f.folderid
                left join ebh_classrooms cr on cr.crid= r.crid
                left join ebh_classes c on c.classid = r.classid where r.crid = '.$crid.' order by f.grade asc,cw.uid asc,cw.cwid asc';
        return $this->db->query($sql)->list_array();
    }
	/*
	课件数量,用于学生后台首页日历
	*/
	public function getRecentCourseCount($param){
		$sql = "select count(*) e,DATE_FORMAT(FROM_UNIXTIME(cw.truedateline) ,'%Y-%m-%d') as d,cw.dateline,cw.truedateline from ebh_coursewares cw join ebh_roomcourses rc on cw.cwid=rc.cwid";

		$wherearr[]= 'rc.crid='.$param['crid'];
		$wherearr[]= 'cw.status=1';
		if(!empty($param['uid']))
			$wherearr[] = 'cw.uid='.$param['uid'];
		if(!empty($param['startDate']))
			$wherearr[] = 'cw.truedateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'cw.truedateline<'.$param['endDate'];
		if(!empty($param['folderids']))
			$wherearr[] = 'rc.folderid in ('.$param['folderids'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by d';
		$sql.= ' order by d desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		// echo $sql;
		return $this->db->query($sql)->list_array();

	}
	/*
	作业数量,用于学生后台首页日历
	*/
	public function getRecentExamCount($param){
		$sql = "select count(*) e,DATE_FORMAT(FROM_UNIXTIME(se.dateline) ,'%Y-%m-%d') as d,se.dateline from ebh_schexams se ";
		$wherearr[]= 'se.crid='.$param['crid'];
		if(!empty($param['uid']))
			$wherearr[] = 'se.uid='.$param['uid'];
		if(!empty($param['classid']))
			$wherearr[]= 'se.classid='.$param['classid'];
		if(!empty($param['startDate']))
			$wherearr[] = 'se.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'se.dateline<'.$param['endDate'];
        if(isset($param['status']))
            $wherearr[] = 'se.status = '.$param['status'];
        else
            $wherearr[] = 'se.status in (0,1)';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by d';
		$sql.= ' order by d desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
			// echo $sql;\
		return $this->db->query($sql)->list_array();

	}
	/*
	作业数量,用于学生后台首页日历
	*/
	public function getRecentAskCount($param){
		$sql = "select count(*) e,DATE_FORMAT(FROM_UNIXTIME(q.dateline) ,'%Y-%m-%d') as d,q.dateline from ebh_askquestions q";

		$wherearr[]= 'q.crid='.$param['crid'];
		$wherearr[]= 'q.shield=0';
		if(!empty($param['uid']))
			$wherearr[] = 'q.uid='.$param['uid'];
		if(!empty($param['startDate']))
			$wherearr[] = 'q.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'q.dateline<'.$param['endDate'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by d';
		$sql.= ' order by d desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		// echo $sql;
		return $this->db->query($sql)->list_array();

	}

	/*
	开通的课程id
	*/
	public function getActiveFolderids($param){
		$sql = 'select distinct(folderid) from ebh_pay_orders o
			join ebh_pay_packages p on o.pid=p.pid
			join ebh_pay_items i on (i.pid=p.pid and i.pid=o.pid)
			where o.uid='.$param['uid'].' and p.crid='.$param['crid'];
			//echo $sql;
		return $this->db->query($sql)->list_array();
	}
    /**
     * 根据课程编号或教室编号获取按照章节排名的课件列表
     * @param int $folderid 课程编号
     * @return array 课件列表数组
     */
    public function getsimplefolderseccourselist($queryarr = array()) {
        if(empty($queryarr['folderid']) && empty($queryarr['crid']))
            return FALSE;
        $sql = 'SELECT cw.cwid,cw.title,s.sid,s.sname from ebh_roomcourses r ' .
                'JOIN ebh_coursewares cw ON r.cwid = cw.cwid ' .
                'LEFT JOIN ebh_sections s ON r.sid=s.sid ' .
                'JOIN ebh_users u on (u.uid = cw.uid) ';
        $wherearr = array();
        if(!empty($queryarr['uid']))
            $wherearr[] = 'cw.uid='.$queryarr['uid'];
        if(!empty($queryarr['folderid']))
            $wherearr[] = 'r.folderid='.$queryarr['folderid'];
        if(!empty($queryarr['crid']))
            $wherearr[] = 'r.crid='.$queryarr['crid'];
        if(isset($queryarr['isfree']))
            $wherearr[] = 'r.isfree='.$queryarr['isfree'];
        if (!empty($queryarr['q']))
            $wherearr[] = ' cw.title like \'%' . $this->db->escape_str($queryarr['q']) . '%\'';
        if(isset($queryarr['status']))
            $wherearr[] = 'cw.status='.$queryarr['status'];
        $sql .= ' WHERE '.implode(' AND ',$wherearr);
        $sql .= ' ORDER BY s.sid ASC,r.cdisplayorder ASC,cw.displayorder ASC,cw.cwid DESC ';
        return $this->db->query($sql)->list_array();
    }

    //根据cwid数组获取课件信息
    public function getCourseListByCwids($cwids = array()){
        if(empty($cwids)||!is_array($cwids)){
            return;
        }
        $sql = 'select cw.title,cw.cwid from ebh_coursewares cw where cw.cwid in ('.implode(',', $cwids).')';
        return $this->db->query($sql)->list_array();
    }

	/*
	获取课程分类下最小的排序号
	*/
	public function getCurdisplayorder($param){
		$sql = 'select min(cdisplayorder) mdis from ebh_roomcourses';
		$wherearr[] = 'crid='.$param['crid'];
		$wherearr[] = 'folderid='.$param['folderid'];
		$wherearr[] = 'sid='.$param['sid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$res = $this->db->query($sql)->row_array();
		return $res['mdis'];
	}

	/*
	上移下移课件
	*/
	public function moveit($param){
		if(empty($param['cwid']))
			return false;
		$sql = 'select cwid,sid,folderid,cdisplayorder from ebh_roomcourses where cwid='.$param['cwid'];
		$thiscw = $this->db->query($sql)->row_array();

		$sqlsameorder = 'select cwid,sid,folderid,cdisplayorder from ebh_roomcourses where cdisplayorder='.$thiscw['cdisplayorder'].' and sid='.$thiscw['sid'].' and folderid='.$thiscw['folderid'].' and cwid<>'.$thiscw['cwid'];
		$sameorder = $this->db->query($sqlsameorder)->row_array();
		if(!empty($sameorder)){
			if($param['compare'] == '<')
				$op = '-';
			else
				$op = '+';
			$sqlAllforone = 'update ebh_roomcourses set cdisplayorder=cdisplayorder'.$op.'1 where sid='.$thiscw['sid'].' and folderid='.$thiscw['folderid'].' and cdisplayorder'.$param['compare'].'='.$thiscw['cdisplayorder'].' and cwid<>'.$thiscw['cwid'];
			$this->db->query($sqlAllforone);
		}

		$sql2 = 'select rc.cwid,sid,folderid,cdisplayorder from ebh_roomcourses rc join ebh_coursewares c on rc.cwid=c.cwid';
		$wherearr[] = 'folderid='.$thiscw['folderid'];
		$wherearr[] = 'sid='.$thiscw['sid'];
		$wherearr[] = 'cdisplayorder'.$param['compare'].$thiscw['cdisplayorder'];
		$wherearr[] = 'status=1';
		$sql2 .= ' where '.implode(' AND ',$wherearr);
		$sql2 .= ' order by '.$param['order'];
		$sql2 .= ' limit 1';
		$descw = $this->db->query($sql2)->row_array();
		if(empty($descw))
			return false;
		$this->db->update('ebh_roomcourses',array('cdisplayorder'=>$descw['cdisplayorder']),array('cwid'=>$thiscw['cwid']));
        $this->db->update('ebh_roomcourses',array('cdisplayorder'=>$thiscw['cdisplayorder']),array('cwid'=>$descw['cwid']));
        return true;

	}

	/*
	获取多个老师的课件数
	*/
	public function getTeachersCWCount($param){
		$sql = 'select count(*) cwnum,c.uid from ebh_roomcourses rc
		join ebh_coursewares c on rc.cwid=c.cwid';
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid='.$param['crid'];
		if(!empty($param['uids']))
			$wherearr[] = 'c.uid in ('.$param['uids'].')';
		if(!empty($param['folderid']))
			$wherearr[] = 'rc.folderid='.$param['folderid'];
		if(!empty($param['startdate']))
			$wherearr[] = 'c.dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[] = 'c.dateline<='.($param['enddate']+86400);
		$wherearr[] = 'c.status=1';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by c.uid';
		return $this->db->query($sql)->list_array();
	}

	/*
	教师的课件列表
	*/
	public function getTeacherCoursewares($param){
		$sql = 'select c.cwid,c.cwlength,c.cwsize,c.cwname,c.title,c.truedateline,c.summary,c.viewnum,f.folderid,f.foldername,c.cwurl from ebh_coursewares c
		join ebh_roomcourses rc on c.cwid = rc.cwid
		join ebh_folders f on f.folderid = rc.folderid';
		if(empty($param['crid']) || empty($param['uid']))
			return false;
		if(!empty($param['uid']))
			$wherearr[] = 'c.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid='.$param['crid'];
		$wherearr[] = 'c.status=1';
		if(!empty($param['folderid']))
			$wherearr[] = 'rc.folderid='.$param['folderid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
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
	 * 获得课件审核列表
	 * @return [type] [description]
	 */
	public function getCoursewareCheckCount($param) {
		$sql = 'SELECT COUNT(*) as count FROM ebh_coursewares c
				LEFT JOIN ebh_roomcourses rc on rc.cwid = c.cwid
				LEFT JOIN ebh_billchecks ck on ck.toid = c.cwid AND ck.type=1';
		//审核状态 0 全部 1未审核 2审核已通过 3审核未通过
		if($param['role']=='teach'){
			if($param['checkstatus'] == 1){
				$wherearr[] = '(ck.teach_status is null or ck.teach_status=0)';
			}
			elseif($param['checkstatus'] == 2){
				$wherearr[] = 'ck.teach_status=1';
			}
			elseif($param['checkstatus'] == 3){
				$wherearr[] = 'ck.teach_status=2';
			}
		}

		if(!empty($param['crid'])){
			if(is_array($param['crid'])){
				$wherearr[] = 'rc.crid in( '.implode(',', $param['crid']).')';
			}else{
				$wherearr[] = 'rc.crid ='.$param['crid'];
			}
		}
		if (!empty($param['folderid']))
			$wherearr[] = 'rc.folderid ='.$param['folderid'];
		if (!empty($wherearr))
			$sql.= ' where ' . implode(' AND ', $wherearr);

		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}

	/**
	 * 获得课件审核总数
	 * @param  array $param 参数
	 * @return integer        总数
	 */
	public function getCoursewareCheckList($param) {
		$sql = 'select c.uid,c.cwid,c.cwurl,c.title,c.dateline,ck.teach_status,ck.teach_remark,ck.teach_dateline,rc.folderid,u.username,u.realname,u.sex,u.face,f.foldername
				from ebh_coursewares c
				left join ebh_roomcourses rc on rc.cwid = c.cwid
				left join ebh_billchecks ck on ck.toid = c.cwid and ck.type=1
				left join ebh_users u on u.uid=c.uid
				left join ebh_folders f on f.folderid = rc.folderid';
		//审核状态 0 全部 1未审核 2审核已通过 3审核未通过
		if($param['role']=='teach'){
			if($param['checkstatus'] == 1){
				$wherearr[] = '(ck.teach_status is null or ck.teach_status=0)';
			}
			elseif($param['checkstatus'] == 2){
				$wherearr[] = 'ck.teach_status=1';
			}
			elseif($param['checkstatus'] == 3){
				$wherearr[] = 'ck.teach_status=2';
			}
		}
		if(!empty($param['crid'])){
			if(is_array($param['crid'])){
				$wherearr[] = 'rc.crid in( '.implode(',', $param['crid']).')';
			}else{
				$wherearr[] = 'rc.crid ='.$param['crid'];
			}
		}
		if (!empty($param['folderid']))
			$wherearr[] = 'rc.folderid ='.$param['folderid'];
		if (!empty($wherearr))
			$sql.= ' where ' . implode(' AND ', $wherearr);
			$sql.=' order by cwid desc';
		if (!empty($param['limit'])) {
			$sql.= ' limit ' . $param['limit'];
		} else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$rows =  $this->db->query($sql)->list_array();

		return $rows;
	}
    /**
    *更新课件的直播课程信息
    */
    public function updateCourseLive($cwid,$liveid) {
        if (empty($cwid) || empty($liveid))
            return FALSE;
        $setarr = array();
        $setarr['liveid'] = $liveid;

        $wherearr = array('cwid' => $cwid);
        return $this->db->update('ebh_coursewares', $setarr, $wherearr);
    }
    /**
    *获取直播课信息
    */
    public function getLiveInfo($cwid) {
        $sql = "select c.cwid,c.title,c.uid,c.cwlength,c.submitat,c.islive,c.liveid,rc.crid,rc.folderid from ebh_coursewares c join ebh_roomcourses rc on (c.cwid = rc.cwid) where c.cwid=$cwid";
        $liveinfo = $this->db->query($sql)->row_array();
        return $liveinfo;
    }

    /**
     * 根据cwid获取课件的长度
     */
    public function getcwlengthBycwid($cwid){
        if(empty($cwid)){
            return false;
        }
        $sql = 'select cwlength from `ebh_coursewares` where cwid='.$cwid;
        return $this->db->query($sql)->row_array();
    }

    /**
     * 根据cwid 对课件点赞数加一
     */
    public function addzan($cwid){
        if(empty($cwid)){
            return false;
        }
        $sql = 'update `ebh_coursewares` set zannum=zannum+1 where cwid ='.$cwid;
        return $this->db->query($sql)->row_array();
    }
    /**
     * 根据cwid获取课件的信息
     */
    public function getCwinfoListByCwid($cwidstr){
        if(empty($cwidstr)){
            return false;
        }
        $sql = 'select cw.cwid,cw.uid,cw.title,cw.logo,u.username,u.realname,u.face,u.sex,cw.viewnum,cw.reviewnum,cw.dateline,cw.summary,cw.islive,cw.submitat,cw.endat,cw.cwurl,cw.logo from `ebh_coursewares` cw left join `ebh_users` u on (cw.uid = u.uid) where cw.cwid in('.$cwidstr.')';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据cwid获取课件详细信息
     */
    public function getCwinfoListRewardByCwid($cwidstr){
        if(empty($cwidstr)){
            return false;
        }
        $sql = 'select cw.cwid,cw.title,cw.logo,cw.dateline,cw.rewardmoney,cw.rewardcount from `ebh_coursewares` cw  where cw.cwid in('.$cwidstr.') order by cw.dateline desc';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据cwid获取国土资源课件对应讲课人的信息
     */
    public function getcwUserinfo($cwid){
        if(empty($cwid)){
            return false;
        }
        $sql = 'select cw.uid,u.username,u.realname,cw.toid,u.sex,u.face from `ebh_cwusers` cw left join `ebh_users` u on(cw.uid = u.uid) where cw.cwid ='.intval($cwid);
        return $this->db->query($sql)->row_array();
    }
    /**
     * 添加国土资源厅课件和对应讲课人的关系表
     */
    public function addcwusers($uid,$cwid,$toid = 0){
        if(empty($uid) || empty($cwid)){
            return false;
        }
        return $this->db->insert('ebh_cwusers', array('uid'=>$uid,'cwid'=>$cwid,'toid'=>$toid));
    }
    /**
     * 修改国土资源课件信息
     */
    public function updatecwuser($uid,$cwid,$toid = 0){
        if(empty($uid) || empty($cwid)){
            return false;
        }
        $this->db->delete('ebh_cwusers',array('cwid'=>$cwid));
        return $this->addcwusers($uid,$cwid,$toid);
    }
    /**
     * 获取国土资源讲课人的列表
     */
    public function getcwuserlist($cwarr){
        if(empty($cwarr) || !is_array($cwarr)){
            return false;
        }
        $cwstr = implode(',',$cwarr);
        $sql = 'select cw.cwid,cw.toid,u.uid,u.face,u.groupid,u.username,u.realname,u.sex from `ebh_cwusers` cw left join `ebh_users` u on (cw.uid = u.uid) where cw.cwid in('.$cwstr.')';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据cwid获取课件对应的课程信息
     */
    public function getFolderinfoByCwid($cwarr){
        if(empty($cwarr)){
            return false;
        }
        $sql = 'select f.foldername,c.cwid from `ebh_roomcourses` c left join `ebh_folders` f on(c.folderid = f.folderid) where cwid in('.implode(',',$cwarr).')';
        return $this->db->query($sql)->list_array();
    }


    /**
     * @param $cwid
     * @return bool
     * 根据cwid设置公告
     */
    public function setNotice($cwid,$notice = ''){
        if(empty($cwid)){
            return false;
        }
        $setarr = array();
        $setarr['notice'] = $notice;

        $wherearr = array('cwid' => $cwid);
        $redis = Ebh::app()->getCache('cache_redis');
        $redis->hset('coursenotice_'.$cwid,'notice',$notice);
        $redis->hset('coursenotice_'.$cwid,'lastset',time());
        return $this->db->update('ebh_coursewares', $setarr, $wherearr);
    }

    /**
     * 根据cwid获取公告
     * @param $cwid
     * @return string
     */
    public function getNotice($cwid){
        if(empty($cwid)){
            return '';
        }

        $redis = Ebh::app()->getCache('cache_redis');
        $notice = $redis->hget('coursenotice_'.$cwid,'notice');
        if($notice){
            return $notice;
        }
        $sql = 'select notice from `ebh_coursewares` where cwid='.$cwid;
        $row = $this->db->query($sql)->row_array();
        if($row){
            return $row['notice'];
        }else{
            return '';
        }
    }

	/*
	获取单课收费信息,ibuy用
	*/
	public function getcwpay($cwid){
		if(empty($cwid))
			return false;
		$sql = 'select c.cwid,c.title,rc.cprice,rc.cmonth,rc.cday,cr.crname,c.summary,cr.crid,f.folderid,c.logo,rc.roomfee,rc.comfee,c.cwurl,c.islive,cr.domain
				from ebh_coursewares c
				join ebh_roomcourses rc on c.cwid=rc.cwid
				join ebh_folders f on f.folderid = rc.folderid
				join ebh_classrooms cr on rc.crid=cr.crid';
		// $wherearr[] = 'rc.crid='.$crid;
		$wherearr[] = 'rc.cwid='.$cwid;
		$wherearr[] = 'f.power=0';
		$wherearr[] = 'f.del=0';
		$wherearr[] = 'rc.cwpay=1';
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();

	}

	/*
	查看收费课件列表
	*/
	public function getcwpaylist($param){
		$sql = 'select c.cwid,c.title,rc.cprice,rc.cmonth,rc.cday,cr.crname,c.summary,cr.crid,c.logo,f.del,f.power,c.dateline,f.folderid,cr.domain
				from ebh_roomcourses rc
				join ebh_coursewares c on c.cwid=rc.cwid
				left join ebh_folders f on f.folderid = rc.folderid
				left join ebh_classrooms cr on rc.crid=cr.crid';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid='.$param['crid'];
		if(!empty($param['folderids']))
			$wherearr[] = 'rc.folderid in ('.$param['folderids'].')';
		elseif(isset($param['folderids']))
			return array();
		if(!empty($param['q']))
			$wherearr[] = 'c.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		$wherearr[] = 'rc.cwpay=1';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' order by c.cwid desc';
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
	/*
	收费课件数量
	*/
	public function getcwpaycount($param){
		$sql = 'select count(*) count from ebh_roomcourses rc';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid='.$param['crid'];
		if(!empty($param['folderids']))
			$wherearr[] = 'rc.folderid in ('.$param['folderids'].')';
		elseif(isset($param['folderids']))
			return 0;
		if(!empty($param['q']))
			$wherearr[] = 'c.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		$wherearr[] = 'rc.cwpay=1';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}

	/*
	获取课程下收费课件数量
	*/
	public function getFolderCwpayCount($param){
		if($param['my'] == true){//我开通的
			$sql = 'select count(*) count,p.folderid from ebh_userpermisions p join ebh_folders f on p.folderid=f.folderid join ebh_coursewares c on p.cwid=c.cwid';
			$wherearr = array();
			$wherearr[] = 'p.cwid<>0';
			$wherearr[] = 'f.crid='.$param['crid'];
			$wherearr[] = 'c.status >= 0';
			$wherearr[] = 'p.folderid in ('.$param['folderids'].')';
			$wherearr[] = 'p.uid = ('.$param['uid'].')';

			$enddate = SYSTIME - 86400;
			$wherearr[] = 'p.enddate>'.$enddate;
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.= ' group by p.folderid';
			return $this->db->query($sql)->list_array();
		}else{//未开通的,先查已开通的课件
			$cwsql = 'select cwid from ebh_userpermisions p';
			$wherearr = array();
			$wherearr[] = 'p.cwid<>0';
			$wherearr[] = 'p.crid='.$param['crid'];
			$wherearr[] = 'p.uid = ('.$param['uid'].')';
			$wherearr[] = 'p.folderid in ('.$param['folderids'].')';
			$enddate = SYSTIME - 86400;
			$wherearr[] = 'p.enddate>'.$enddate;
			$cwsql.= ' where '.implode(' AND ',$wherearr);
			$cwlist = $this->db->query($cwsql)->list_array();
			$cwids = '';
			if(!empty($cwlist))
				$cwids = implode(',',array_column($cwlist,'cwid'));

			$sql = 'select count(*) count,f.folderid from ebh_folders f join ebh_roomcourses r on f.folderid=r.folderid join ebh_coursewares c on r.cwid=c.cwid';
			$wherearr = array();
			$wherearr[] = 'r.cwpay=1';
			$wherearr[] = 'c.status >= 0';
			if(!empty($cwids))
				$wherearr[] = 'r.cwid not in ('.$cwids.')';
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.= ' group by f.folderid';
			return $this->db->query($sql)->list_array();
		}
	}

    /**
     * 判断用户是否赞过课件
     * @param $uid 用户ID
     * @param $cwid 课件ID
     * @param $crid 网校ID
     * @return bool
     */
    public function checkPraise($uid, $cwid, $crid) {
        $zan = $this->db->query(
            'SELECT 1 AS `z` FROM `ebh_userzan` WHERE `uid`='.intval($uid).' AND `cwid`='.intval($cwid).' AND `crid`='.intval($crid).' LIMIT 1')
            ->row_array();
        if (!empty($zan['z'])) {
            return true;
        }
        return false;
    }

     /**
     * 获取课件的简单信息
     * @param int $cwid
     * @return array
     */
    public function getSimpleInfoByCwid($cwid) {
        $sql = "select cw.cwlength,rc.looktime from ebh_coursewares cw left join ebh_roomcourses rc using(cwid) where cw.cwid=$cwid";
        return $this->db->query($sql)->row_array();
    }

    /***
     * 获取学习进度和课程比例
     * @param int $uid 用户uid
     * @return array
     */
    public function getProgressAndRate($uid){
       $sql = 'SELECT COUNT(*) AS c,SUM(if(finished=1,1,0)) AS su FROM ebh_playlogs WHERE uid='.$uid;
              $count = $this->db->query($sql)->row_array();
       if(!empty($count)){
           $progress = round($count['su']/$count['c'] *100);
       }else{
           $progress = 0;
       }
       //获取用户的所有课程
        $sql = 'SELECT co.cwurl,co.islive FROM ebh_playlogs p';
        $sql .= ' INNER JOIN ebh_coursewares co ON p.cwid=co.cwid WHERE p.uid='.$uid;
        $list = $this->db->query($sql)->list_array();

        $rate = array('video'=>0,'broadcast'=>0,'ppt'=>0,'word'=>0,'other'=>0);
        if(!empty($list)){
            foreach ($list as $value){
                if($value['islive'] == 1){
                    $rate['broadcast'] ++;
                }else{
                    if(empty($value['cwurl'])){
                        $rate['other']++;
                    }else{
                    $postfix = explode('.',$value['cwurl']);
                    $postfix = is_array($postfix)?end($postfix):$postfix;
                    $postfix = strtolower($postfix);
                    $videoArr = array('wma','mp4','ebhp','flv','mp3');
                    $wordArr  = array('doc','docx');
                    $pptArr   = array('pps');
                    if(in_array($postfix,$videoArr)){
                        $rate['video']++;
                    }elseif (in_array($postfix,$wordArr)){
                        $rate['word']++;
                    }elseif (in_array($postfix,$pptArr)){
                        $rate['ppt']++;
                    }else{
                        $rate['other']++;
                       }
                    }
                }
            }
        }

        return array('progress'=>$progress,'rate'=>$rate);
    }
}

