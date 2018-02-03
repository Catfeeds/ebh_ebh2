<?php

/*
  作业
 */

class ExamanswerModel extends CModel {
    /*
      最近一周完成作业数
     */

    public function getanswercount($uid) {
        $dateline = SYSTIME - 7 * 24 * 3600;
        $sql = 'select count(*) count from ebh_examanswers where uid=' . $uid . ' and dateline>' . $dateline;
        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }

    /**
     * 获取教师网校学生最新提交的作业
     * @param type $param
     * @return type
     */
    public function getnewsanswers($param) {
        $sql = 'SELECT ea.aid,ea.eid,ea.dateline,ea.tid,e.title,e.dateline edateline,e.cwid,e.score,e.answercount,e.uid euid,u.username,u.realname,c.title ctitle FROM ebh_examanswers ea ' .
                'LEFT JOIN ebh_exams e ON ea.eid = e.eid ' .
                'LEFT JOIN ebh_users u ON ea.uid=u.uid ' .
                'LEFT JOIN ebh_coursewares c ON e.cwid = c.cwid ';
        $wherearr = array();
        if (!empty($param['crid']))
            $wherearr[] = 'e.crid = ' . $param['crid'];
        if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY ea.aid DESC ';
        if (!empty($param['limit']))
            $sql .= ' LIMIT ' . $param['limit'];
        else
            $sql .= ' LIMIT 0,5 ';
        return $this->db->query($sql)->list_array();
    }

    /**
     * 删除教师网校下的作业答题
     * @param type $eid
     */
    public function delanswer($eid) {
        $wherearr = array('eid' => $eid);
        return $this->db->delete('ebh_examanswers', $wherearr);
    }
    /**
     * 获取网校学生的作业答题记录
     * @param type $param
     */
    public function getexamanswers($param) {
        if(empty($param['crid']))
            return FALSE;
        if (empty($queryarr['page']) || $queryarr['page'] < 1)
            $page = 1;
        else
            $page = $queryarr['page'];
        $pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'SELECT ea.aid,ea.eid,ea.dateline,e.score,e.title,e.dateline edateline,e.cwid,e.score,e.answercount,e.uid euid,u.username,u.realname,u.groupid,c.title ctitle FROM ebh_examanswers ea '.
            'JOIN ebh_exams e ON ea.eid = e.eid '.
            'JOIN ebh_users u ON ea.uid=u.uid '.
            'JOIN ebh_coursewares c ON e.cwid = c.cwid ';
        $wherearr = array();
        $wherearr[]='e.crid='.$param['crid'];
        if(isset($param['tid'])) {  //批阅的教师编号
            $wherearr[]='ea.tid='.$param['tid'];
        }
        if(!empty($param['q'])) {   //作业名称搜索
            $wherearr[] = 'e.title like \'%'.$this->db->escape_str($param['q']).'%\'';
        }
        if(!empty($param['name'])) {    //学生搜索
            $wherearr[] = '(u.username like \'%'.$this->db->escape_str($param['name']).'%\' OR u.realname like \'%'.$this->db->escape_str($param['name']).'%\')';
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['order'])) {
            $sql .= ' ORDER BY '.$param['order'];
        } else {
            $sql .= ' ORDER BY ea.aid DESC ';
        }
        $sql .= 'limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
    /**
     * 获取网校学生的作业答题记录总数
     * @param type $param
     */
    public function getexamanswerscount($param) {
        $count = 0;
        if(empty($param['crid']))
            return $count;
        $sql = 'SELECT count(*) count FROM ebh_examanswers ea '.
            'JOIN ebh_exams e ON ea.eid = e.eid '.
            'JOIN ebh_users u ON ea.uid=u.uid '.
            'JOIN ebh_coursewares c ON e.cwid = c.cwid ';
        $wherearr = array();
        $wherearr[]='e.crid='.$param['crid'];
        if(isset($param['tid'])) {  //批阅的教师编号
            $wherearr[]='ea.tid='.$param['tid'];
        }
        if(!empty($param['q'])) {   //作业名称搜索
            $wherearr[] = 'e.title like \'%'.$this->db->escape_str($param['q']).'%\'';
        }
        if(!empty($param['name'])) {    //学生搜索
            $wherearr[] = '(u.username like \'%'.$this->db->escape_str($param['q']).'%\' OR u.realname like \'%'.$this->db->escape_str($param['q']).'%\')';
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
            $count = $row['count'];
        return $count;
    }
    /**
     *删除对应的答案
     *
     */
    public function deleteOne($param = array()){
        if(empty($param['aid'])||empty($param['uid'])){
            return false;
        }
        $where = $param;
        return $this->db->delete('ebh_schexamanswers',$where);
    }

    /**
     * 根据eid获取回答列表
     * @param  [type] $eid [description]
     * @return [type]      [description]
     */
    public function getexamanswerlist($eid)
    {
    	if(empty($eid))
    	{
    		return false;
    	}
    	else
    	{
    		$sql = 'SELECT uid FROM ebh_schexamanswers WHERE eid=' . intval($eid);
    		return $this->db->query($sql)->list_array();
    	}
    }
}

?>