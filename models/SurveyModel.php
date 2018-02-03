<?php
class SurveyModel extends CModel{
	public function getSurveyList($param){
		$sql = 'select s.folderid, s.sid,s.title,s.type,s.dateline,s.ispublish,s.allowview,s.answernum,s.uid,s.startdate,s.enddate,c.title cwname from ebh_surveys s left join ebh_coursewares c on s.cwid=c.cwid';
		if(!empty($param['answered']) && !empty($param['uid']))
			$sql = 'select s.folderid, s.sid,s.title,s.type,s.dateline,s.ispublish,s.allowview,s.answernum,s.uid,s.startdate,s.enddate,c.title cwname,sa.aid from ebh_surveys s left join ebh_coursewares c on s.cwid=c.cwid left join ebh_surveyanswers sa on s.sid=sa.sid and sa.uid=' . intval($param['uid']);
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if(isset($param['type']))
			$wherearr[] = 's.type='.$param['type'];
        if(!empty($param['untype'])){
            $wherearr[] = 's.type<>'.$param['untype'];
        }
		if(!empty($param['folderid']))
			$wherearr[] = 's.folderid='.$param['folderid'];
		if(isset($param['ispublish']))
			$wherearr[] = 'ispublish='.$param['ispublish'];
		if(!empty($param['teacherid']))
			$wherearr[] = 's.uid='.$param['teacherid'];
		if(!empty($param['filteruid']))
			$wherearr[] = 's.uid<>'.$param['filteruid'];
		if(!empty($param['isopening']))
			$wherearr[] = '(s.startdate<' . SYSTIME . ' AND (s.enddate>' . SYSTIME . ' OR s.enddate=0))';
		if(!empty($param['q']))
			$wherearr[] = 's.title like \'%'.$param['q'].'%\'';
		$wherearr[] = 'isdelete=0';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		else
			$sql.= ' order by sid desc';
		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
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

	public function getSurveyCount($param){
		$count = 0;
		$sql = 'select count(*) count from ebh_surveys s';
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if(isset($param['type']))
			$wherearr[] = 's.type='.$param['type'];
		if(!empty($param['folderid']))
			$wherearr[] = 's.folderid='.$param['folderid'];
		if(isset($param['ispublish']))
			$wherearr[] = 'ispublish='.$param['ispublish'];
		if(!empty($param['teacherid']))
			$wherearr[] = 's.uid='.$param['teacherid'];
        if(!empty($param['untype'])){
            $wherearr[] = 's.type<>'.$param['untype'];
        }
		if(!empty($param['filteruid']))
			$wherearr[] = 's.uid<>'.$param['filteruid'];
		if(!empty($param['isopening']))
			$wherearr[] = '(s.startdate<' . SYSTIME . ' AND (s.enddate>' . SYSTIME . ' OR s.enddate=0))';
		if(!empty($param['q']))
			$wherearr[] = 's.title like \'%'.$param['q'].'%\'';
		$wherearr[] = 'isdelete=0';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
        return $count;
	}

	public function getUnAnsweredCount($param){
		$count = 0;
		$sql = 'select count(*) count from ebh_surveys s left join ebh_surveyanswers sa on s.sid=sa.sid and sa.uid=' . intval($param['uid']);
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if(isset($param['type']))
			$wherearr[] = 's.type='.$param['type'];
		if(!empty($param['folderid']))
			$wherearr[] = 's.folderid='.$param['folderid'];
		if(isset($param['ispublish']))
			$wherearr[] = 'ispublish='.$param['ispublish'];
		if(!empty($param['q']))
			$wherearr[] = 's.title like \'%'.$param['q'].'%\'';
		$wherearr[] = 'isdelete=0';
		$wherearr[] = 'sa.aid IS NULL';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
        return $count;
	}

	public function add($param){
		if(isset($param['title']))
			$setarr['title'] = $param['title'];
		if(!empty($param['content']))
			$setarr['content'] = $param['content'];
		if(!empty($param['type']))
			$setarr['type'] = $param['type'];
		if(!empty($param['folderid']))
			$setarr['folderid'] = $param['folderid'];
		if(!empty($param['cwid']))
			$setarr['cwid'] = $param['cwid'];
		if(isset($param['ispublish']))
			$setarr['ispublish'] = $param['ispublish'];
		if(!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
        if(!empty($param['cid']))
			$setarr['cid'] = $param['cid'];
        if(!empty($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(isset($param['allowview']))
			$setarr['allowview'] = $param['allowview'];
		if(isset($param['answernum']))
			$setarr['answernum'] = $param['answernum'];
		if(isset($param['allowanonymous']))
			$setarr['allowanonymous'] = $param['allowanonymous'];
		if(!empty($param['startdate']))
			$setarr['startdate'] = $param['startdate'];
		if(!empty($param['enddate']))
			$setarr['enddate'] = $param['enddate'];
		$setarr['dateline'] = SYSTIME;
		return $this->db->insert('ebh_surveys',$setarr);
	}
	
	public function getSurveyDetail($param){
		if(empty($param['crid']) || empty($param['sid']))
			return false;
		$sql = 'select sid,content,title,type,folderid,cwid,answernum,allowview,allowanonymous,uid,startdate,enddate from ebh_surveys where crid='.$param['crid'].' and sid='.$param['sid'];
		return $this->db->query($sql)->row_array();
	}
	
	public function edit($param){
		if(empty($param['crid']) || empty($param['sid']))
			return false;
		if(isset($param['title']))
			$setarr['title'] = $param['title'];
        if(!empty($param['cid']))
			$setarr['cid'] = $param['cid'];
		if(!empty($param['content']))
			$setarr['content'] = $param['content'];
		if(isset($param['type']))
			$setarr['type'] = $param['type'];
		if(isset($param['folderid']))
			$setarr['folderid'] = $param['folderid'];
		if(isset($param['cwid']))
			$setarr['cwid'] = $param['cwid'];
		if(isset($param['ispublish']))
			$setarr['ispublish'] = $param['ispublish'];
		if(isset($param['allowview']))
			$setarr['allowview'] = $param['allowview'];
		if(isset($param['answernum']))
			$setarr['answernum'] = $param['answernum'];
		if(isset($param['allowanonymous']))
			$setarr['allowanonymous'] = $param['allowanonymous'];
		if(!empty($param['startdate']))
			$setarr['startdate'] = $param['startdate'];
		if(!empty($param['enddate']))
			$setarr['enddate'] = $param['enddate'];
		$wherearr['crid'] = $param['crid'];
		$wherearr['sid'] = $param['sid'];
		return $this->db->update('ebh_surveys',$setarr,$wherearr);
		
	}
	
	public function delete($param){
		$wherearr = array();
		if(empty($param['crid']) || empty($param['sid']))
			return false;
		$wherearr['sid'] = $param['sid'];
		$wherearr['crid'] = $param['crid'];
		if(!empty($param['uid']))
			$wherearr['uid'] = $param['uid'];
		return $a=$this->db->update('ebh_surveys',array('isdelete'=>1),$wherearr);
	}
	
	public function answer($param){
		$setarr['uid'] = $param['uid'];
		$setarr['sid'] = $param['sid'];
		$setarr['answers'] = $param['answers'];
		$setarr['dateline'] = SYSTIME;
		return $this->db->insert('ebh_surveyanswers',$setarr);
	}
	
	/*
	学生是否回答过
	*/
	public function ifAnswered($param){
		$sql = 'select sid from ebh_surveyanswers where sid='.$param['sid'].' and uid='.$param['uid'];
		return $this->db->query($sql)->row_array();
		
	}
	
	/*
	按课件id获取，用来判断是否需要课后弹出
	*/
	public function getSurveyByCwid($cwid,$uid){
		$sql = 'select s.sid,s.title,s.dateline,s.allowview,s.startdate,s.enddate,if(a.aid is null,0,1) answered from ebh_surveys s left join ebh_surveyanswers a on (s.sid = a.sid and a.uid= '.$uid.') where cwid = '.$cwid . ' and isdelete=0 and ispublish=1';
		return $this->db->query($sql)->row_array();
	}

    //选课是否有问卷
    public function getSurveyByCid($param){
        $sql = 'select * from ebh_surveys where type=3 and startdate >0 and enddate>0 and ispublish=1 and isdelete=0 and cid ='.$param['cid'];
        return $this->db->query($sql)->row_array();
    }
	
	public function getAnswers($param){
		if(empty($param['sid']))
			return false;
		$sql = 'select answers from ebh_surveyanswers a ';
		
		$wherearr[] = 'a.sid='.$param['sid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
		
	}
	
	public function delanswers($param){
		if(empty($param['sid']) && empty($param['aid']))
			return false;
		if(!empty($param['sid']))
			$wherearr['sid'] = $param['sid'];
		if(!empty($param['aid']))
			$wherearr['aid'] = $param['sid'];
		
		return $this->db->delete('ebh_surveyanswers',$wherearr);
	}

	/**
	 * 获取一份调查问卷内容
	 * @param  integer $sid  调查问卷编号
	 * @param  integer $crid 学校编号
	 * @return array       问卷内容
	 */
	public function getOne($sid, $crid) {
		$survey = array();
		$sql = 'SELECT s.sid,s.crid,s.type,s.folderid,s.cwid,s.title,s.content,s.dateline,s.istemplate,s.ispublish,s.isdelete,s.allowview,s.answernum,s.allowanonymous,s.uid,s.cid,s.startdate,s.enddate,us.realname';
        $sql .=' FROM ebh_surveys s LEFT JOIN ebh_users us ON s.uid=us.uid WHERE s.sid=' . intval($sid) . ' AND s.crid=' . intval($crid);
		$survey = $this->db->query($sql)->row_array();
		if (!empty($survey))
		{
			$survey_question = $this->getQuestionList($survey['sid']);
		}
		if (!empty($survey_question))
		{
			foreach ($survey_question as $key => $value) {
			    if ($value['type'] != 3) {
                    $sql_option = 'SELECT * FROM ebh_surveyoptions WHERE qid=' . $value['qid'] . ' ORDER BY displayorder,opid';
                    $survey_question[$key]['optionlist'] = $this->db->query($sql_option)->list_array();
                }
			}
			$survey['questionlist'] = $survey_question;
		}
		return $survey;
	}

	/**
	 * 获得一份答题记录
	 * @param  interger $sid 问卷编号
	 * @param  interger $uid 用户编号
	 * @return array        答题记录
	 */
	public function getOneAnswer($sid, $uid){
		$sql = 'select answers from ebh_surveyanswers a ';
		$wherearr[] = 'a.sid='.$sid;
		$wherearr[] = 'a.uid='.$uid;
		$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if (!empty($row['answers']))
			return unserialize($row['answers']);
		else
			return FALSE;
	}

	/**
	 * 检查编辑权限
	 */
	public function checkEdit($param) {
		$wherearr = array();
		$sql = 'SELECT crid FROM ebh_surveys';
		if(empty($param['sid']))
			return FALSE;
		else
			$wherearr[] = 'sid='.intval($param['sid']);
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.intval($param['crid']);
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.intval($param['uid']);
		if(!empty($wherearr))
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if ( ! empty($row))
			return TRUE;
		else
			return FALSE;
	}

	/**
	 * 保存问卷标题、问题、选项
	 * @param  [type] $param [description]
	 * @return [type]        [description]
	 */
	public function save($param) {
		if (empty($param['sid']) || empty($param['etype']) || empty($param['eid']) || ! isset($param['content']))
			return FALSE;

		$setarr = array();
		$wherearr = array();

		if ($param['etype'] == 'title')
		{
			$setarr['title'] = $param['content'];
			$wherearr['sid'] = $param['sid'];
			return $this->db->update('ebh_surveys', $setarr, $wherearr);
		}
		elseif ($param['etype'] == 'question')
		{
			$setarr['title'] = $param['content'];
			$wherearr['qid'] = $param['eid'];
			$wherearr['sid'] = $param['sid'];
			return $this->db->update('ebh_surveyquestions', $setarr, $wherearr);
		}
		elseif ($param['etype'] == 'option')
		{
			$setarr['content'] = $param['content'];
			$wherearr['opid'] = $param['eid'];
			$wherearr['sid'] = $param['sid'];
			return $this->db->update('ebh_surveyoptions', $setarr, $wherearr);
		}
		return FALSE;
	}

	/**
	 * 获取问题详情
	 * @param  integer $qid 问题编号
	 * @return mix      问题详情
	 */
	public function getOneQuestion($qid) {
		$sql = 'SELECT * FROM ebh_surveyquestions WHERE qid='.intval($qid);
		return $this->db->query($sql)->row_array();
	}

	/**
	 * 获取选项详情
	 * @param  integer $opid 选项编号
	 * @return mix      选项详情
	 */
	public function getOneOption($opid) {
		$sql = 'SELECT * FROM ebh_surveyoptions WHERE opid='.intval($opid);
		return $this->db->query($sql)->row_array();
	}

	/**
	 * 获取问题列表
	 * @return [type] [description]
	 */
	public function getQuestionList($sid = 0) {
		$sql = 'SELECT * FROM ebh_surveyquestions WHERE sid=' . intval($sid) . ' ORDER BY displayorder,qid';
		return $this->db->query($sql)->list_array();
	}

	//获取问卷下的问题总数
	public function getQuestionCount($sid = 0) {
		$count = 0;
		$sql = 'SELECT count(*) as count FROM ebh_surveyquestions WHERE sid='.intval($sid);
		$row = $this->db->query($sql)->row_array();
		if ( ! empty($row))
			$count = $row['count'];
        return $count;
	}

	/**
	 * 添加一个选问题
	 * @param integer $sid 问卷编号 integer $type 问题类型
	 */
	public function addQuestion($param) {
		if (empty($param['sid']) || empty($param['type']))
			return FALSE;
		//查找现有问题中最大的排序数
		$maxorder = 0;
		$sql_maxorder = 'SELECT max(displayorder) as maxorder FROM ebh_surveyquestions WHERE sid=' . intval($param['sid']);
		$row_maxorder = $this->db->query($sql_maxorder)->row_array();
		if (!empty($row_maxorder))
			$maxorder = $row_maxorder['maxorder'];

		//insert
		$setarr['sid'] = $param['sid'];
		$setarr['type'] = $param['type'];
		if (!empty($param['title'])){
			$setarr['title'] = h($param['title']);
		}
		else if ($param['type'] == 1) {
			$setarr['title'] = '单选题';
		}
		else if($param['type'] == 2) {
			$setarr['title'] = '多选题';
		}else if($param['type'] == 4) {
            $setarr['title'] = '问答题';
        }
		$setarr['displayorder'] = $maxorder + 1;
		$qid = $this->db->insert('ebh_surveyquestions',$setarr);

		//返回信息
		if ($qid) {
			$setarr['qid'] = $qid;
			return $setarr;
		}
		else {
			return FALSE;
		}

	}

	/**
	 * 删除问题
	 * @param  参数 $param $param['qid']问题编号 
	 * @return [type]        [description]
	 */
	public function deleteQuestion($param){
		if (empty($param['qid']) || empty($param['sid']))
			return FALSE;
		$this->db->begin_trans();
		$wherearr['qid'] = $param['qid'];
		$wherearr['sid'] = $param['sid'];
		$this->db->delete('ebh_surveyquestions',$wherearr);
		$this->db->delete('ebh_surveyoptions',$wherearr);
		if($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}

	/**
	 * 移动问题
	 */
	public function moveQuestion($param) {
		if (empty($param['qid']) || empty($param['sid']) || !isset($param['direction']))
			return FALSE;
		$this_question = $this->getOneQuestion($param['qid']);
		//向下移动
		if ($param['direction'] == 1)
		{
			$sql = 'SELECT qid,displayorder FROM ebh_surveyquestions WHERE sid='.intval($param['sid']) . ' AND displayorder>' . $this_question['displayorder'] . ' ORDER BY displayorder ASC LIMIT 1';
		}
		//向上移动
		else
		{
			$sql = 'SELECT qid,displayorder FROM ebh_surveyquestions WHERE sid='.intval($param['sid']) . ' AND displayorder<' . $this_question['displayorder'] . ' ORDER BY displayorder DESC LIMIT 1';
		}
		$that_question = $this->db->query($sql)->row_array();
		if(empty($that_question))
			return FALSE;
		$this->db->update('ebh_surveyquestions',array('displayorder'=>$that_question['displayorder']),array('qid'=>$this_question['qid']));
        $this->db->update('ebh_surveyquestions',array('displayorder'=>$this_question['displayorder']),array('qid'=>$that_question['qid']));
        return TRUE;

	}
	/**
	 * 添加一个选项
	 * @param integer $qid 问题编号 integer $sid 问卷编号
	 */
	public function addOption($param) {
		if (empty($param['qid']) || empty($param['sid']))
			return FALSE;
		//查找现有选项中最大的排序数
		$maxorder = 0;
		$sql_maxorder = 'SELECT max(displayorder) as maxorder FROM ebh_surveyoptions WHERE qid=' . intval($param['qid']) . ' AND sid=' . intval($param['sid']);
		$row_maxorder = $this->db->query($sql_maxorder)->row_array();
		if (!empty($row_maxorder))
			$maxorder = $row_maxorder['maxorder'];

		//insert
		$setarr['qid'] = $param['qid'];
		$setarr['sid'] = $param['sid'];
		$setarr['displayorder'] = $maxorder + 1;
		if (!empty($param['content'])){
			$setarr['content'] = $param['content'];
		} else {
			$setarr['content'] = '选项' . $setarr['displayorder'];
		}
		
		$setarr['count'] = 0;
		$opid = $this->db->insert('ebh_surveyoptions',$setarr);

		//返回信息
		if ($opid) {
			$setarr['opid'] = $opid;
			return $setarr;
		}
		else {
			return FALSE;
		}

	}

	/**
	 * 删除选项
	 * @param  参数 $param $param['qid']选项编号
	 */
	public function deleteOption($param){
		if (empty($param['opid']) || empty($param['sid']))
			return FALSE;
		$wherearr['opid'] = $param['opid'];
		$wherearr['sid'] = $param['sid'];
		return $this->db->delete('ebh_surveyoptions',$wherearr);
	}

	/**
	 * 移动选项
	 */
	public function moveOption($param) {
		if (empty($param['opid']) || empty($param['sid']) || !isset($param['direction']))
			return FALSE;
		$this_option = $this->getOneOption($param['opid']);
		//向下移动
		if ($param['direction'] == 1)
		{
			$sql = 'SELECT opid,displayorder FROM ebh_surveyoptions WHERE qid=' . $this_option['qid'] . ' AND sid='.intval($param['sid']) . ' AND displayorder>' . $this_option['displayorder'] . ' ORDER BY displayorder ASC LIMIT 1';
		}
		//向上移动
		else
		{
			$sql = 'SELECT opid,displayorder FROM ebh_surveyoptions WHERE qid=' . $this_option['qid'] . ' AND sid='.intval($param['sid']) . ' AND displayorder<' . $this_option['displayorder'] . ' ORDER BY displayorder DESC LIMIT 1';
		}
		$that_option = $this->db->query($sql)->row_array();
		if(empty($that_option))
			return FALSE;
		$this->db->update('ebh_surveyoptions',array('displayorder'=>$that_option['displayorder']),array('opid'=>$this_option['opid']));
        $this->db->update('ebh_surveyoptions',array('displayorder'=>$this_option['displayorder']),array('opid'=>$that_option['opid']));
        return TRUE;

	}

	/**
	 * 选项计数清零
	 */
	public function resetOptionCount($param) {
		if (empty($param['sid']))
			return FALSE;
		else
			$wherearr['sid'] = $param['sid'];
		return $this->db->update('ebh_surveyoptions', array('count'=>0), $wherearr);

	}

	/**
	 * 添加回答
	 * @param  array $answers 回答
	 * @param  array $param   参数
	 * @return boolean        true成功 false失败
	 */
	public function addanswer($answers, $param) {
		if (empty($param['sid']))
			return FALSE;

		$checked_option = array();
		foreach($answers as $k => $question)
		{
		    if (is_array($question)) {
                foreach ($question as $option)
                {
                    $checked_option[] = $option;
                }
            } else if(is_object($question)){
		        //echo $question->id.':'.$question->value;
		        $checked_option[] = $question->id;
		        $answers[$k] = $question->value;
            }
		}
		//print_r($checked_option);
		//exit;
		//保存回答
		$setarr['sid']		= $param['sid'];
		$setarr['answers']	= serialize($answers);
		$setarr['uid']		= empty($param['uid']) ? 0 :intval($param['uid']);
		$setarr['dateline'] = SYSTIME;
		$setarr['ip']		= getip();
		//保存回答
		$aid = $this->db->insert('ebh_surveyanswers', $setarr);
		if (!empty($aid))
		{
			//回答数加1
			$this->db->update('ebh_surveys', array(), array('sid'=>$param['sid']), array('answernum'=>'answernum+1'));
			if (!empty($checked_option)) {
                //选项计数加1
                $this->db->update('ebh_surveyoptions', array(), 'opid in(' . implode(',',$checked_option) . ')', array('count'=>'count+1'));
            }
		}
		return TRUE;
	}

    /**
     * 用户回答列表
     * @param $sid
     * @return mixed
     */
	public function getAnswerWithUserName($sid) {
	    $sid = (int) $sid;
	    $sql = "SELECT `b`.`username`,`b`.`realname`,`a`.`answers` FROM `ebh_surveyanswers` `a` LEFT JOIN `ebh_users` `b` ON `a`.`uid`=`b`.`uid` WHERE `a`.`sid`=$sid";
	    return $this->db->query($sql)->list_array();
    }

	/**
	 * 用户回答列表：学生姓氏、学生账号、学生所在班级
	 * @param $sid 问卷ID
	 */
	public function getAnswerWithUserClassInfo($sid, $crid) {
		$sid = intval($sid);
		$crid = intval($crid);
		$sql = 'SELECT `b`.`username`,`b`.`realname`,`a`.`answers`,`d`.`classname` FROM `ebh_surveyanswers` `a` JOIN `ebh_users` `b` ON `a`.`uid`=`b`.`uid` JOIN `ebh_classstudents` `c` ON `c`.`uid`=`b`.`uid` JOIN `ebh_classes` `d` ON `d`.`classid`=`c`.`classid` WHERE `a`.`sid`='.$sid.' AND `d`.`crid`='.$crid;
		return $this->db->query($sql)->list_array();
	}
    /**
     * 获取开通服务前的调查问卷ID
     * @param $crid
     * @return bool
     */
    public function getSurveyIdBeforeBuy($crid) {
	    $crid = (int) $crid;
	    if ($crid < 1) {
	        return false;
        }
        $sql = "SELECT `sid` FROM `ebh_surveys` 
                WHERE `crid`=$crid AND `type`=4 AND `ispublish`=1 AND `isdelete`=0 AND `allowview`=1 AND 
                `startdate`<".SYSTIME." AND (`enddate`=0 OR `enddate`>".SYSTIME.") ORDER BY `sid` DESC LIMIT 1";
	    $ret = $this->db->query($sql)->row_array();
	    if (!empty($ret['sid'])) {
	        return $ret['sid'];
        }
        return false;
    }

    /**
     * 是否已做答卷
     * @param $sid
     * @param $uid
     * @return bool
     */
    public function answered($sid, $uid) {
        $sid = (int) $sid;
        $uid = (int) $uid;
        if ($sid < 1 || $uid < 1) {
            return false;
        }
        $sql = "SELECT `aid` FROM `ebh_surveyanswers` WHERE `uid`=$uid AND `sid`=$sid LIMIT 1";
        $ret = $this->db->query($sql)->row_array();
        return !empty($ret['aid']);
    }
    
    
 
    /**
     *  验证用户是否做过该网校的特定问卷
     * @param unknown $crid
     * @param unknown $uid
     * @param number $type
     * @return boolean
     */
    public function checksurvey($uid,$crid,$type=5){
        $return = false;
        $sql = "select count(*) count ,s.sid from ebh_surveyanswers a inner join ebh_surveys s on a.sid = s.sid and s.type = {$type}  where s.crid = {$crid} and a.uid = {$uid} and type = {$type} limit 1";
        $ret = $this->db->query($sql)->row_array();
        if(empty($ret['count'])){
            $ssql = "select sid from ebh_surveys s where s.crid = {$crid}   and type = {$type}  order by sid desc limit 1";
            $row = $this->db->query($ssql)->row_array();
            $return = $row['sid'];
        }

        return $return;
    }

    
}
