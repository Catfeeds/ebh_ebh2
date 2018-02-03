<?php
/**
 * 智能作业错题集model类 SmarterrorbookModel
 */
class SmarterrorbookModel extends CModel {
	/**
	*删除错题本
	*/
	public function delete($param) {
		if(empty($param['eid']))
			return FALSE;
		$wherearr = array('eid'=>$param['eid']);
		if(!empty($param['uid']))
			$wherearr['uid'] = $param['uid'];
		return $this->db->delete('ebh_smarterrorbook',$wherearr);
	}

	/**
	*学生智能作业我的错题本列表
	*/
	public function myscherrorbooklist($param = array()) {
		if(empty($param['uid']))
			return FALSE;
		$sql = 'SELECT e.exid,e.eid,ifnull(ex.title,"已删除") as etitle,q.ques,e.qid,e.dateline,q.quetype,q.falsenum,q.score,e.uid,e.erranswers,q.title,e.uid from ebh_schquestions q '.
				'join ebh_smarterrorbook e on (q.qid=e.quesid) '.
				'left join ebh_smartexams ex on (ex.eid = e.eid)';
		$wherearr = array();
		$wherearr[] = 'e.uid='.$param['uid'];
		$wherearr[] = 'q.ques !=\'\'';
		if(!empty($param['quetype'])){
			$wherearr[] = 'q.quetype =\''.$this->db->escape_str($param['quetype']).'\'';
		}else{
			$wherearr[] = 'q.quetype !=\'H\'';
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'q.folderid='.$param['folderid']; 
		}
		if(!empty($param['chapterid'])){
			$wherearr[] = 'q.chapterid='.$param['chapterid']; 
		}
		if(!empty($param['qids'])){
			$wherearr[] = ' q.qid in ('.implode(',', $param['qids']).')';
		}
		if(!empty($param['q']))
			$wherearr[] = 'q.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['startDate']))
			$wherearr[] = 'e.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'e.dateline<'.$param['endDate'];
		
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else
			$sql .= ' order by  e.eid desc';
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$list = $this->db->query($sql)->list_array();
		$errorbooks = array();
		foreach($list as $l) {
			$l['subject'] = preg_replace('/(<[^>]*>)|(<[^>]*$)/', ' ', $l['title']); 
			$l['ques'] =  base64str(unserialize($l['ques']));				
			$errorbooks [] = $l;
		}
		return $errorbooks;
	}
	/**
	*学生智能作业我的错题本列表记录总数
	*/
	public function myscherrorbooklistcount($param = array()) {
		$count = 0;
		if(empty($param['uid']))
			return $count;
		$sql = 'SELECT count(*) count from ebh_schquestions q '.
				'join ebh_smarterrorbook e on (q.qid=e.quesid) '.
				'join ebh_schexams ex on (ex.eid = e.eid) ';
		$wherearr = array();
		$wherearr[] = 'e.uid='.$param['uid'];
		if(!empty($param['quetype'])){
			$wherearr[] = 'q.quetype =\''.$this->db->escape_str($param['quetype']).'\'';
		}else{
			$wherearr[] = 'q.quetype !=\'H\'';
		}
		if(!empty($param['folderid'])){
			$wherearr[] = 'q.folderid='.$param['folderid']; 
		}
		if(!empty($param['chapterid'])){
			$wherearr[] = 'q.chapterid='.$param['chapterid']; 
		}
		if(!empty($param['qids'])){
			$wherearr[] = ' q.qid in ('.implode(',', $param['qids']).')';
		}
		$wherearr[] = 'ex.title !=\'\'';
		if(!empty($param['q']))
			$wherearr[] = 'q.title like \'%'.$this->db->escape_str($param['q']).'%\'';
		if(!empty($param['startDate']))
			$wherearr[] = 'e.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'e.dateline<'.$param['startDate'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
}