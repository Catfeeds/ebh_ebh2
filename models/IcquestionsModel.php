<?php

/**
 * Class IcquestionsModel 
 * 互动课堂问题表model
 */

class IcquestionsModel extends CModel{
    //添加问题
	public function addQuestion($param){
		if(empty($param)){
			return false;
		}
		$this->db->begin_trans();
		foreach ($param as $question) {
			$setarr = array();
			if(!empty($question['order'])){
				$setarr['order'] = $question['order'];
			}
			if(!empty($question['title'])){
				$setarr['title'] = $question['title'];
			}
			if(!empty($question['type'])){
				$setarr['type'] = $question['type'];
			}
			if(!empty($question['crid'])){
				$setarr['crid'] = $question['crid'];
			}
			if(!empty($question['icid'])){
				$setarr['icid'] = $question['icid'];
			}
			$icqid = $this->db->insert('ebh_icquestions',$setarr);
			$itemsetarr = array();
			if(!empty($icqid) && isset($question['item'])){//针对单选，多选，主观题，选项以及内容加入ebh_icitems表
				if(!empty($question['item'])){
					$sql = 'insert into ebh_icitems (icqueid,qid,urlpath,content,crid) values ';
					foreach ($question['item'] as $k => $item) {
						if($question['type'] == 0 || $question['type'] == 1){//单选多选题
							$sql.='(';
							$sql.= $icqid;
							$sql.= ','. ($k+1);
							$sql.= ',\'\'';
							$sql.= ','.$this->db->escape($item);
							$sql.= ','.$question['crid'];
							$sql.='),';
						}else{
							$sql.='(';
							$sql.= $icqid;
							$sql.= ',0';
							$sql.= ','.$this->db->escape($item);
							$sql.= ',\'\'';
							$sql.= ','.$question['crid'];
							$sql.='),';
						}
					}
					$sql = trim($sql,',');
					$res = $this->db->query($sql,false);
				}
			}
		}
		if($this->db->trans_status() === FALSE){
        	$this->db->rollback_trans();
        	return false;
        }else{
        	$this->db->commit_trans();
       		return true;
        }
	}
	//获取互动问题详情
	public function getquestionInfo($icid){
		if(empty($icid)){
			return false;
		}
		$sql = 'select q.icqid,q.type,q.title,q.order,t.qid,t.urlpath,t.content,t.icqueid,q.count,t.choosecount from `ebh_icquestions` q left join `ebh_icitems` t on(q.icqid = t.icqueid) where q.icid = '.intval($icid);
		return $this->db->query($sql)->list_array();
	}
	//更新互动的题目与选项
	public function editIcquestion($question,$icid,$folderidarr){
		if(empty($question) || empty($icid) || empty($folderidarr)){
			return false;
		}
		$this->db->begin_trans();
		//删除原有的相关记录
		$resdel = $this->delRealtionRecord($icid);
		//插入新纪录
		$resinsq = $this->addnewQuestion($question);
		$resinsf = $this->addIcFolders($icid,$folderidarr);
		if($this->db->trans_status() === FALSE || !($resdel && $resinsq && $resinsf)){
        	$this->db->rollback_trans();
        	return false;
        }else{
        	$this->db->commit_trans();
       		return true;
        }
	}

	//删除相关记录
	public function delRealtionRecord($icid){
		if(empty($icid)){
			return false;
		}
		$sql = 'select icqid from `ebh_icquestions` where icid ='.intval($icid);
		$icqid = $this->db->query($sql)->list_array();
		if(!empty($icqid)){
			$icqidstr = '';
			foreach ($icqid as $icq) {
				$icqidstr.= $icq['icqid'].',';
			}
			$icqidstr = rtrim($icqidstr,',');
			$delitem = 'delete from `ebh_icitems` where icqueid in ('.$icqidstr.')';
			$resi = $this->db->simple_query($delitem);
			$delque = 'delete from `ebh_icquestions` where icid ='.intval($icid);
			$resq = $this->db->simple_query($delque);
			$delfolder = 'delete from `ebh_icfolders` where icid ='.intval($icid);
			$resf = $this->db->simple_query($delfolder);
		}
		if( $resi && $resq && $resf){
			return true;
		}else{
			return false;
		}
	}
	//插入新的记录
	public function addnewQuestion($param){
		if(empty($param)){
			return false;
		}
		foreach ($param as $question) {
			$setarr = array();
			if(!empty($question['order'])){
				$setarr['order'] = $question['order'];
			}
			if(!empty($question['title'])){
				$setarr['title'] = $question['title'];
			}
			if(!empty($question['type'])){
				$setarr['type'] = $question['type'];
			}
			if(!empty($question['crid'])){
				$setarr['crid'] = $question['crid'];
			}
			if(!empty($question['icid'])){
				$setarr['icid'] = $question['icid'];
			}
			$icqid = $this->db->insert('ebh_icquestions',$setarr);
			$itemsetarr = array();
			if(!empty($icqid) && isset($question['item'])){//针对单选，多选，主观题，选项以及内容加入ebh_icitems表
				if(!empty($question['item'])){
					$sql = 'insert into ebh_icitems (icqueid,qid,urlpath,content,crid) values ';
					foreach ($question['item'] as $k => $item) {
						if($question['type'] == 0 || $question['type'] == 1){//单选多选题
							$sql.='(';
							$sql.= $icqid;
							$sql.= ','. ($k+1);
							$sql.= ',\'\'';
							$sql.= ','.$this->db->escape($item);
							$sql.= ','.$question['crid'];
							$sql.='),';
						}else{
							$sql.='(';
							$sql.= $icqid;
							$sql.= ',0';
							$sql.= ','.$this->db->escape($item);
							$sql.= ',\'\'';
							$sql.= ','.$question['crid'];
							$sql.='),';
						}
					}
					$sql = trim($sql,',');
					$res = $this->db->query($sql,false);
				}
			}
		}
		if($icqid){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 添加互动和课程之间的关系
	 */
	public function addIcFolders($icid,$folderids){
		if(empty($icid) || empty($folderids)){
			return false;
		}
		$sql = 'insert into ebh_icfolders (icid,folderid) values ';
		foreach ($folderids as $folderid) {
			$sql.= '(';
			$sql.= $icid.',';
			$sql.= $folderid;
			$sql.= '),';
		}
		$sql = trim($sql,',');
		return $this->db->query($sql,false);
	}
	/**
	 * 获取已回答的学生列表
	 */
	public function getanswerStudent($param){
		if(empty($param['crid']) || empty($param['icid'])){
			return false;
		}
		$sql = 'select a.uid,a.dateline,a.totaltime,u.realname,u.username,u.face,u.sex,u.groupid from `ebh_icanswers` a left join `ebh_users` u on (a.uid = u.uid) where a.icid ='.intval($param['icid']).' and a.crid='.intval($param['crid']).' group by a.uid order by a.dateline desc';
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
	/**
	 * 获取已回答学生的数量
	 */
	public function getanswerStudentcount($icid,$crid){
		if(empty($icid) || empty($crid)){
			return false;
		}
		$sql = 'select count(distinct(uid)) as count from`ebh_icanswers` where icid ='.intval($icid).' and crid='.intval($crid).' group by uid';
		$count = $this->db->query($sql)->list_array();
		return count($count);
	}
	/**
	 * 获取问题信息
	 */
	public function getQuestionDetail($icqid){
		if(empty($icqid)){
			return false;
		}
		$sql = 'select title,count,icid from `ebh_icquestions` where icqid='.intval($icqid);
		return $this->db->query($sql)->row_array();
	}
	/**
	 * 获取问题回答的记录总数
	 */
	public function getAnswersCount($icqid){
		if(empty($icqid)){
			return false;
		}
		$sql = 'select count(*) as count from ebh_icanswers where qid ='.intval($icqid);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/**
	 * 获取问题回答列表
	 */
	public function getAnswers($param){
		if(empty($param['icqid'])){
			return false;
		}
		$sql = 'select a.uid,a.answercontent,a.dateline,u.username,u.realname,u.sex,u.face,u.groupid from `ebh_icanswers` a left join `ebh_users` u on (a.uid = u.uid) where a.qid ='.$param['icqid'].' order by a.dateline asc ';
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
	/**
	 * 获取已答用户uid列表
	 */
	public function getanswerStudentuid($icid){
		if(empty($icid)){
			return false;
		}
		$sql = 'select distinct(uid) from `ebh_icanswers` where icid ='.intval($icid);
		return $this->db->query($sql)->list_array();
	}
	/**
     * 获取对应互动的问题列表
     */
    public function getListByIcid(array $parm){
    	if(empty($parm['icid'])){
    		return false;
    	}
        $sql = 'select * from ebh_icquestions';
        $where = ' where icid = '.$parm['icid'];
        $sql .= $where;
        $questions = $this->db->query($sql)->list_array();
        foreach ($questions as &$question) {
             $sql = 'select * from ebh_icitems';
             $where = ' where icqueid = '.$question['icqid'];
             $sql .= $where;
             $options = $this->db->query($sql)->list_array();
             $question['options'] = $options;
        }
        return $questions;
    }

    //获取问题信息
    public function getQuestionDetailByIcqid($icqid){
    	if(!$icqid){
    		return false;
    	}
        $sql = 'select * from ebh_icquestions  where icqid = '.$icqid;
        $question = $this->db->query($sql)->row_array();
        $sql = 'select * from ebh_icitems';
        $where = ' where icqueid = '.$question['icqid'];
        $sql .= $where;
        $options = $this->db->query($sql)->row_array();
        $question['options'] = $options;
        return $question;
    }

    //作用：问题 回答人数+1 
    //$ids 问题id数组
    public function increaseCount($ids){
    	if(!empty($ids)){
			$sql = 'update ebh_icquestions set count = count + 1 where icqid in ('.implode(',', $ids).')';
			$this->db->query($sql);
    	}
        
    }

    //问题对应的选项加一
    public function increaseCountOfOptions($answers){
        foreach ($answers as $key => $answer) {
            if($answer['hasOptions']){
                $options = implode(',',json_decode($answer['answercontent']));
                if(!empty($options)){
                	$sql = 'update ebh_icitems set choosecount = choosecount + 1 where itemid in ('. $options.')';
                $this->db->query($sql);
                }
            }
        }
    }

    //添加答案
    public function addAnswer($param){
    	if(empty($param)){
    		return false;
    	}
    	$this->db->insert('ebh_icanswers', $param);
    }
}
?>