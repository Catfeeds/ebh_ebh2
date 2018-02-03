<?php
class QuestionModel extends CFreeResourceModel{
    /**
	 * 获取年级列表
	 */
	public function getGradeList($grade_type = 0, $grade_id = 0) {
		$grade_list = array();
		
		$sql = 'SELECT * FROM res_questiongrade';
		//grade_id为空时，列出所有年级，否则只列出该年级
		if (!empty($grade_id))
		{
			$whereArr[] = 'gradeid=' . intval($grade_id);
		}			
		if (!empty($grade_type))
		{
			$whereArr[] = 'gradetype=' . intval($grade_type);
		}
		if(!empty($whereArr)){
			$sql .= ' WHERE ' . implode(' AND ',$whereArr);
		}
		$sql .= ' ORDER BY gradeid';
		$grade_list = $this->freeresourcedb->query($sql)->list_array();

		return $grade_list;
	}
	
    /**
	 * 获取知识点列表
	 */
	public function getKnowledgepointList($grade_id = 0, $subject_id = 0) {
		$knowledgepoint_list = array();
		
		$sql = 'SELECT * FROM res_questionknowledgepoint';
		//grade_id为空时，列出所有年级，否则只列出该年级
		if (!empty($grade_id))
		{
			$whereArr[] = 'gradeid=' . intval($grade_id);
		}
		if (!empty($subject_id))
		{
			$whereArr[] = 'subjectid=' . intval($subject_id);
		}
		if(!empty($whereArr)){
			$sql .= ' WHERE ' . implode(' AND ',$whereArr);
		}
		$sql .= ' ORDER BY knowledgepointid';
		$knowledgepoint_list = $this->freeresourcedb->query($sql)->list_array();

		return $knowledgepoint_list;
	}
	
	//获得年级类型列表
	public function getGradeTypeList() {		
		$grade_type_list = array(
			'1' => array('gradetypename' => '小学', 'count' => '64264'),
			'2' => array('gradetypename' => '初中', 'count' => '289281'),
			'3' => array('gradetypename' => '高中', 'count' => '442526'),
		);
		return $grade_type_list;
	}
	
	//根据gradeid获得年级信息
	public function getOneGrade($gradeid) {
		$row = $this->freeresourcedb->query('SELECT * FROM res_questiongrade WHERE gradeid=' . intval($gradeid))->row_array();
		return $row;		
	}
	
	//获得学科列表
	public function getSubjectList($gradetype = 0) {
		$sql = 'SELECT * FROM res_questionsubject';
		if (!empty($gradetype))
		{
			$sql .= ' WHERE gradetype=' . intval($gradetype) . ' ORDER BY subjectid';
		}
		return $this->freeresourcedb->query($sql)->list_array();
	}
		
	//获得知识点信息
	public function getOneKnowledgePoint($knowledgepointid) {
		return $this->freeresourcedb->query('SELECT * FROM res_questionknowledgepoint WHERE knowledgepointid=' .intval($knowledgepointid))->row_array();	
	}
	
	//获取题目类型列表
	public function getQuestionTypeList($gradeid = 0, $subjectid = 0) {
		$sql = 'SELECT * FROM res_questiontype';
		if (!empty($gradeid))
		{
			$whereArr[] = "gradeid=" . intval($gradeid);
		}			
		if (!empty($subjectid))
		{
			$whereArr[] = "subjectid=" . intval($subjectid);
		}
		if(!empty($whereArr)){
			$sql .= ' WHERE ' . implode(' AND ',$whereArr);
		}
		$sql .= ' ORDER BY questiontypeid';

		return $this->freeresourcedb->query($sql)->list_array();
	}
	
	//获得该年级类型第一个年级，例：小学=>一年级
	public function getFirstGradeId($gradetype) {
		$sql = 'SELECT gradeid FROM res_questiongrade WHERE gradetype=' . intval($gradetype) . ' ORDER BY gradeid LIMIT 1';
		$row = $this->freeresourcedb->query($sql)->row_array();
		return $row['gradeid'];
	}
	
	//根据id数组获得知识点
	public function getKnowledgeArray($knowledgepointid = array()) {
		$knowledgepoint_list = array();
		$knowledgepoint_array = array();
		if (!empty($knowledgepointid) && is_array($knowledgepointid))
		{
			$knowledgepointid = array_map('intval', $knowledgepointid);
			$sql = 'SELECT * FROM res_questionknowledgepoint';
			$sql .= ' WHERE knowledgepointid in (' . implode(',', $knowledgepointid) . ')';
			$sql .= ' ORDER BY knowledgepointid';		$knowledgepoint_list = $this->freeresourcedb->query($sql)->list_array();
			foreach ($knowledgepoint_list as $value)
			{
				$knowledgepoint_array[$value['knowledgepointid']] = $value['title'];
			}
		}
		return $knowledgepoint_array;
	}
	
	public function getSubjectArray() {
		$subject_list = $this->getSubjectList();
		$subject_array = array();
		foreach ($subject_list as $value)
		{
			$subject_array[$value['subjectid']] = $value['subjectname'];
		}
		return $subject_array;
	}
	
	public function getQuestionTypeArray($questiontypeid = array()) {
		$questiontype_list = array();
		$questiontype_array = array();
		if (!empty($questiontypeid) && is_array($questiontypeid))
		{
			$questiontypeid = array_map('intval', $questiontypeid);
			$sql = 'SELECT * FROM res_questiontype';
			$sql .= ' WHERE questiontypeid in (' . implode(',', $questiontypeid) . ')';
			$sql .= ' ORDER BY questiontypeid';
			$questiontype_list = $this->freeresourcedb->query($sql)->list_array();
			foreach ($questiontype_list as $value)
			{
				$questiontype_array[$value['questiontypeid']] = $value['title'];
			}
		}
		return $questiontype_array;
	}
	
	/**
	 * 获得列表
	 */	
	public function getList($param) {
	    $sql = 'SELECT questionid,subjectid,serialnumber,knowledgepointid,typeid,gradeid,question,answer,analysis FROM res_question';
		if (!empty($param['knowledgepointid']))
		{
			$whereArr[] = 'knowledgepointid=' . intval($param['knowledgepointid']);
		}
		else
		{
			if (!empty($param['gradeid']))
			{
				$whereArr[] = 'gradeid=' . intval($param['gradeid']);
			}
			if (!empty($param['subjectid']))
			{
				$whereArr[] = 'subjectid=' . intval($param['subjectid']);
			}
		}
		if (!empty($param['typeid']))
		{
			$whereArr[] = 'typeid=' . intval($param['typeid']);
		}
		if (!empty($param['knowledgepointid']) && !empty($param['q'])){
			$whereArr[] = 'question like \'%'.$this->freeresourcedb->escape_str($param['q']).'%\'';
		}
		if (!empty($whereArr)){
			$sql .= ' WHERE ' . implode(' AND ',$whereArr);
		}		
		//$sql .= ' ORDER BY questionid DESC';		
		if (!empty($param['limit'])){
			$sql .= ' LIMIT ' . $param['limit'];
		}
						
		return $this->freeresourcedb->query($sql)->list_array();
	}

	/**
	 * 获得记录总数
	 */	
	public function getListCount($param) {
	    $sql = 'SELECT count(*) AS count FROM res_question';
		if (!empty($param['knowledgepointid']))
		{
			$whereArr[] = 'knowledgepointid=' . intval($param['knowledgepointid']);
		}
		else
		{
			if (!empty($param['gradeid']))
			{
				$whereArr[] = 'gradeid=' . intval($param['gradeid']);
			}
			if (!empty($param['subjectid']))
			{
				$whereArr[] = 'subjectid=' . intval($param['subjectid']);
			}
		}
		if (!empty($param['typeid']))
		{
			$whereArr[] = 'typeid=' . intval($param['typeid']);
		}
		if (!empty($param['knowledgepointid']) && !empty($param['q'])){
			$whereArr[] = 'question like \'%'.$this->freeresourcedb->escape_str($param['q']).'%\'';
		}
		if (!empty($whereArr)){
			$sql .= ' WHERE ' . implode(' AND ',$whereArr);
		}
		$row = $this->freeresourcedb->query($sql)->row_array();
		return $row['count'];		
	}

	/**
	 * 通过缓存获取记录总数
	 */	 
	public function getListCountCached($param) {
		$count = 0;
		$knowledgepoint_id = empty($param['knowledgepointid']) ? 0 : $param['knowledgepointid'];
		$type_id = empty($param['typeid']) ? 0 : $param['typeid'];
		$grade_id = empty($param['gradeid']) ? 0 : $param['gradeid'];
		$subject_id = empty($param['subjectid']) ? 0 : $param['subjectid'];
		
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = $knowledgepoint_id . ':' . $type_id . ':' . $grade_id . ':' . $subject_id;//key由“知识点:类型:年级:学科”组成
		
		//搜索关键字为空时，从缓存读取。否则，从数据库查询。
		if (empty($param['q']))
		{
			$count = $redis->hget('questionlistcount', $redis_key);
			if ($count === false)
			{
				$count = $this->getListCount($param);
				if ($count !== false)
				{
					$redis->hset('questionlistcount', $redis_key, $count);
				}
			}
		}
		else
		{
			$count = $this->getListCount($param);
		}
		return $count;		
	}

}