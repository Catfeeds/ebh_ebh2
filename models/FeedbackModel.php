<?php
/*
听课反馈
*/
class FeedbackModel extends CModel{
	public function getFeedbackList($param){
		$sql = 'select f.fid,f.uid,f.cwid,f.feedback,f.difficulty,f.quality,f.level,f.dateline from ebh_feedbacks f';
		if(!empty($param['uid']))
			$wherearr[] = 'f.uid='.$param['uid'];
		if(!empty($param['uids']))
			$wherearr[] = 'f.uid in ('.$param['uids'].')';
		if(!empty($param['cwid']))
			$wherearr[] = 'f.cwid='.$param['cwid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	
	public function add($param){
		if(empty($param['uid']) || empty($param['cwid']))
			return false;
		$setarr['uid'] = $param['uid'];
		$setarr['cwid'] = $param['cwid'];
		if(isset($param['feedback']))
			$setarr['feedback'] = $param['feedback'];
		if(isset($param['difficulty']))
			$setarr['difficulty'] = $param['difficulty'];
		if(isset($param['quality']))
			$setarr['quality'] = $param['quality'];
		if(isset($param['level']))
			$setarr['level'] = $param['level'];
		if(isset($param['text']))
			$setarr['text'] = $param['text'];
		$setarr['dateline'] = SYSTIME;
		$this->db->insert('ebh_feedbacks',$setarr);
	}
	
	public function getCWList($queryarr){
		if(empty($queryarr['folderid']) && empty($queryarr['crid']))
			return FALSE;
        $sql = 'SELECT cw.cwid,cw.title,cw.cwsource,cw.dateline,cw.attachmentnum,cw.examnum,r.isfree,r.cdisplayorder,s.sid,s.sname,cw.cwurl,ifnull(s.displayorder,10000) sdisplayorder,f.foldername,f.folderid,cw.cwurl,cw.summary,fb.fid from ebh_roomcourses r ' .
                'JOIN ebh_coursewares cw ON r.cwid = cw.cwid ' .
                'LEFT JOIN ebh_sections s ON r.sid=s.sid ' .
				'LEFT JOIN ebh_folders f on f.folderid = r.folderid '.
				'LEFT JOIN ebh_feedbacks fb on fb.cwid=cw.cwid'
				;
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
		$sql .= ' GROUP BY cw.cwid';
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
        }//echo $sql;
        return $this->db->query($sql)->list_array();
	}
	
	public function getCWCount($queryarr){
		$count = 0;
		if(empty($queryarr['folderid']) && empty($queryarr['crid']))
			return $count;
        $sql = 'SELECT count(*) count from ebh_roomcourses r ' .
                'JOIN ebh_coursewares cw ON r.cwid = cw.cwid ';
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
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow))
            $count = $countrow['count'];
        return $count;
	}
}
?>