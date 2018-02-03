<?php
/**
 *教室与课件关系表
 */
class RoomcourseModel extends CModel{
	//获取教室课件列表
	public function getRoomCourseList($param =array()){
		$sql = 'select rc.crid,rc.cwid,rc.folderid from ebh_roomcourses rc';
		$wherearr = array();
		if(!empty($param['crid'])){
			$wherearr[] = 'rc.crid = '.$param['crid'];
		}
		if(!empty($param['cwid'])){
			$wherearr[] = 'rc.cwid = '.$param['cwid'];
		}
		if(!empty($param['cwid_in']) && is_array($param['cwid_in'])){
			$wherearr[] = 'rc.cwid in ('.implode(',', $param['cwid_in']).')';
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'rc.folderid = '.$param['folderid'];
		}
		if(!empty($wherearr)){
			$sql.= ' WHERE '.implode(' AND ', $wherearr);
		}
		if(!empty($param['order'])){
			$sql.=' order by '.$param['order'];
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}else{
			$sql.=' limit 10';
		}
		return $this->db->query($sql)->list_array();
	}

	//获取有课件但是没有课程的作业列表
	public function getExamWithCwidButNotFolderid($crid = 0){
		if(empty($crid)){
			return;
		}
		$sql = 'select se.eid,se.cwid from ebh_schexams se where se.crid = '.$crid.' and se.cwid > 0 and se.folderid = 0';
		return $this->db->query($sql)->list_array();
	}
	//获取学分表中有eid但是没有folderid记录的数据
	public function getSLogWithCwidButNotFolderid($crid = 0){
		if(empty($crid)){
			return;
		}
		$sql = 'select scl.logid,scl.cwid from ebh_schcreditlog scl where cwid > 0 and folderid = 0 and crid = '.$crid;
		return $this->db->query($sql)->list_array();
	}
	
	//批量修复课件对应的丢失课程的作业
	public function mupdate($params = array()){
		$sql = 'UPDATE ebh_schexams SET folderid = CASE eid ';
		$wtArr = array();
		$inArr = array();
		foreach ($params as $param) {
			$wtArr[] = ' WHEN '.$param['eid'].' THEN '.$param['folderid'];
			$inArr[] = $param['eid'];
		}
		if(empty($wtArr)){
			return -2;//不需要更新
		}
		$sql.= implode(' ', $wtArr).' END WHERE eid IN ('.implode(',', $inArr).')';
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	//批量修复课件对应的丢失课程的作业
	public function mupdate_logs($params = array()){
		$sql = 'UPDATE ebh_schcreditlog SET folderid = CASE logid ';
		$wtArr = array();
		$inArr = array();
		foreach ($params as $param) {
			$wtArr[] = ' WHEN '.$param['logid'].' THEN '.$param['folderid'];
			$inArr[] = $param['logid'];
		}
		if(empty($wtArr)){
			return -2;//不需要更新
		}
		$sql.= implode(' ', $wtArr).' END WHERE logid IN ('.implode(',', $inArr).')';
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	//获取指定课件对应对的folderid
	public function getFolderByCwid($cwid=0,$crid=0){
		if(empty($cwid) || empty($crid)){
			return 0;
		}
		$sql = 'select folderid from ebh_roomcourses rc where rc.crid = '.$crid.' and rc.cwid = '.$cwid.' limit 1';
		return $this->db->query($sql)->row_array();
	}

	//作业关联课件
	public function examLinkCourse($param = array()){
		if(empty($param) || empty($param['eid']) || !is_numeric($param['cwid']) || empty($param['uid']) || empty($param['crid']) ){
			return ;
		}

		if(!empty($param['cwid'])){
			$folderInfo = $this->getFolderByCwid($param['cwid'],$param['crid']);
			if(empty($folderInfo)){
				return;
			}
			$folderid = $folderInfo['folderid'];
			$setArr = array(
				'cwid'=>$param['cwid'],
				'folderid'=>$folderid,
			);
		}else{
			$setArr = array(
				'cwid'=>$param['cwid']
			);
		}
		

		$where = array(
			'eid'=>$param['eid'],
			'crid'=>$param['crid'],
			'uid'=>$param['uid']
		);
		return $this->db->update('ebh_schexams',$setArr,$where);
	}
	
	/*
	学校课件排行
	*/
	public function getRoomCourseRankList($param){
		$sql = 'select rc.crid,rc.cwid,cw.title from ebh_roomcourses rc
		join ebh_coursewares cw on rc.cwid=cw.cwid';
		$wherearr = array();
		if(!empty($param['crid'])){
			$wherearr[] = 'rc.crid = '.$param['crid'];
		}
		$wherearr[] = 'cw.status=1';
		if(!empty($wherearr)){
			$sql.= ' WHERE '.implode(' AND ', $wherearr);
		}
		if(!empty($param['order'])){
			$sql.=' order by '.$param['order'];
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}else{
			$sql.=' limit 10';
		}
		return $this->db->query($sql)->list_array();
	}
	
	/*
	批量更新课件免费状态
	*/
	public function updatefreecourse($param){
		$sql = 'update ebh_roomcourses set isfree = CASE cwid';
		foreach($param['checkarr'] as $cw){
			$wtArr[] = ' WHEN '.$cw['cwid'].' THEN '.$cw['isfree'];
			$inArr[] = $cw['cwid'];
		}
		$sql.= implode(' ', $wtArr).' END WHERE cwid IN ('.implode(',', $inArr).') and crid ='.$param['crid'];
		$this->db->query($sql);
	}
	
	
	/*
	学校课件统计
	*/
	public function getRoomcourseCount($param){
		$sql = 'select count(*) count,sum(cw.cwlength) lengthsum from ebh_coursewares cw 
				join ebh_roomcourses rc on cw.cwid=rc.cwid';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid='.$param['crid'];
		if(isset($param['islive']))
			$wherearr[] = 'cw.islive='.$param['islive'].' and (cw.status != -2 and cw.status != -3)';
		if(isset($param['isatt']))//附件类
			$wherearr[] = 'cw.cwlength=0';
		if(!empty($param['folderid']))
			$wherearr[] = 'rc.folderid='.$param['folderid'].' and (cw.status != -2 and cw.status != -3)';
		if(!empty($wherearr))
			$sql .= ' where '.implode(' AND ',$wherearr);
		$res = $this->db->query($sql)->row_array();
		return $res;
	}
	
	/*
	课件人气列表
	*/
	public function getCwviewnumList($param){
		$sql = 'select cw.cwid,viewnum,title from ebh_coursewares cw 
				join ebh_roomcourses rc on cw.cwid=rc.cwid';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'rc.crid='.$param['crid'];
		
		if(!empty($param['folderid']))
			$wherearr[] = 'rc.folderid='.$param['folderid'].' and (cw.status != -2 and cw.status != -3)';
		if(!empty($wherearr))
			$sql .= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	
	/*
	课程的作业数
	*/
	public function getFolderExamCount($param){
		$sql = 'select count(*) count from ebh_schexams e ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		if(!empty($param['folderid']))
			$wherearr[] = 'e.folderid='.$param['folderid'];
		if(isset($param['type']))
			$wherearr[] = 'e.type='.$param['type'];
		$wherearr[] = 'e.status=1';
		if(!empty($wherearr))
			$sql .= ' where '.implode(' AND ',$wherearr);
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}
	
	/*
	课程作业列表
	*/
	public function getFolderExamList($param){
		$sql = 'select eid,title from ebh_schexams e ';
		$wherearr = array();
		if(!empty($param['crid']))
			$wherearr[] = 'e.crid='.$param['crid'];
		if(!empty($param['folderid']))
			$wherearr[] = 'e.folderid='.$param['folderid'];
		if(isset($param['type']))
			$wherearr[] = 'e.type='.$param['type'];
		$wherearr[] = 'e.status=1';
		if(!empty($wherearr))
			$sql .= ' where '.implode(' AND ',$wherearr);
		
		if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
		$sql .= ' limit ' . $start . ',' . $pagesize;
		return $this->db->query($sql)->list_array();
		// return $res['count'];
	}
	
	/*
	根据eid集合获取课程作业得分率
	*/
	public function getScorePercentByeid($eidstr){
		$sql = 'select sum(totalscore)/(score*count(*)) percent,title,e.eid 
				from ebh_schexamanswers a join ebh_schexams e on a.eid=e.eid
				where e.eid in ('.$eidstr.') group by e.eid
				order by e.eid desc';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	课程提问数量
	*/
	public function getFolderAskCount($param){
		$sql = 'select count(*) count '.(empty($param['mdstr'])?'':$param['mdstr']).' from ebh_askquestions q';
		$wherearr = array();
		$wherearr[] = 'folderid='.$param['folderid'];
		$wherearr[] = 'shield=0';
		if(!empty($param['startdate']))
			$wherearr[] = 'dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[] = 'dateline<='.$param['enddate'];

		$sql .= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['group']))
			$sql.= ' group by '.$param['group'];
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		if(empty($param['group'])){
			$res = $this->db->query($sql)->row_array();
			return $res['count'];
		}else{
			return $this->db->query($sql)->list_array();
		}
	}
	
	/*
	课程回答数量
	*/
	public function getFolderAnswerCount($param){
		$sql = 'select count(*) count '.(empty($param['mdstr'])?'':$param['mdstr']).' from ebh_askquestions q  join ebh_askanswers a on q.qid=a.qid';
		$wherearr = array();
		$wherearr[] = 'q.folderid='.$param['folderid'];
		$wherearr[] = 'q.shield=0';
		$wherearr[] = 'a.shield=0';
		if(!empty($param['startdate']))
			$wherearr[] = 'a.dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[] = 'a.dateline<='.$param['enddate'];
		$sql .= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['group']))
			$sql.= ' group by '.$param['group'];
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		if(empty($param['group'])){
			$res = $this->db->query($sql)->row_array();
			return $res['count'];
		}else{
			return $this->db->query($sql)->list_array();
		}
		
	}

	/**
     * 当章节被删除时，原本章节下的sid置为0
     */
    public function setSidBysid($sid,$crid){
    	if(empty($sid) || empty($crid))
    		return false;
    	return $this->db->update('ebh_roomcourses',array('sid'=>0),array('sid'=>$sid,'crid'=>$crid));
    }
	
	/*
	 *按课程分组查询课件数量，学分计算用
	*/
	public function getCountForFolderCredit($crid){
		if(empty($crid)){
			return FALSE;
		}
		$sql = 'select f.folderid ,count(*) cwcount,credit,creditmode,creditrule,credittime from ebh_folders f 
				join ebh_roomcourses rc on f.folderid=rc.folderid
				join ebh_coursewares cw on rc.cwid=cw.cwid';
		$wherearr[] = 'f.crid='.$crid;
		$wherearr[] = 'f.credit<>0';
		$wherearr[] = 'cw.status=1';
		$wherearr[] = 'cw.ism3u8=1';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by folderid';
		return $this->db->query($sql)->list_array();
	}

	/*
	 *按课程分组查询课件数量，学分计算用
	*/
	public function getCwlistByFolderids($folderids='',$crid=0){
		if(empty($crid) || empty($folderids)){
			return FALSE;
		}
		$sql = 'select c.cwurl,rc.folderid from ebh_coursewares c left join ebh_roomcourses rc using(cwid) where rc.folderid in('.$folderids.') and rc.crid='.$crid.' and c.status=1 group by rc.folderid';
		return $this->db->query($sql)->list_array();
	}

	/**
	 *获取课程下的所有课件得分，主要是为了统计国土的非视频课
	 */
	public function getFoldersScore($folderids='',$crid=0,$uid=0) {
		if(empty($crid) || empty($folderids) || empty($uid)){
			return FALSE;
		}
		$sql = 'select f.folderid,sum(s.score) as score from ebh_folders f 
				join ebh_roomcourses rc on f.folderid=rc.folderid
				join ebh_coursewares cw on rc.cwid=cw.cwid left join ebh_studycreditlogs s on s.cwid=cw.cwid';
		$wherearr[] = 'f.crid='.$crid;
		$wherearr[] = 'f.folderid in('.$folderids.')';
		$wherearr[] = 'cw.status=1';
		$wherearr[] = 's.uid='.$uid;
		$wherearr[] = 's.type=4';
		$wherearr[] = 's.del=0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by folderid';
		return $this->db->query($sql)->list_array();

	}

	/**
	 *获取所有课件评论、发布文章、阅读文章获得的总学分
	 */
	public function getNotFoldersScore($uid=0,$crid=0,$types='2,3,5') {
		if(empty($crid) || empty($uid)){
			return FALSE;
		}
		$sql = 'select sum(s.score) as score from ebh_studycreditlogs s ';
		$wherearr[] = 's.crid='.$crid;
		$wherearr[] = 's.uid='.$uid;
		if (!empty($types)) {
			$wherearr[] = 's.type in('.$types.') ';
		}
		$wherearr[] = 's.del=0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();

	}
}
