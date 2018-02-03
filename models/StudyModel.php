<?php

/**
 * StudyModel课件学习model
 */
class StudyModel extends CModel {

    private $isoneday = NULL;   //是否在规定时间段内已经插入过记录
    public function getloglist($param = array()) {
        $sql = 'select l.logid,l.uid,l.cwid,l.dateline,c.title,u.username from ebh_studylogs l ' .
                'join ebh_coursewares c on (l.cwid = c.cwid) ' .
                'join ebh_users u on (u.uid = l.uid) ';
        $wherearr = array();
        $wherearr[] = 'c.status = 1';
        if (!empty($param['cwid']))
            $wherearr[] = 'l.cwid = ' . $param['cwid'];
        if (!empty($param['uid']))
            $wherearr[] = 'l.uid = ' . $param['uid'];
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY l.logid DESC';
        if (!empty($param['limit']))
            $sql .= ' limit ' . $param['limit'];
        else
            $sql .= ' limit 10';
        return $this->db->query($sql)->list_array();
    }
    /**
     * 获取课件学习记录数
     */
    public function getlogcount($param = array()){
        if(empty($param)){
            return false;
        }
        $sql = 'select count(*) as count from ebh_studylogs l ' .
                'join ebh_coursewares c on (l.cwid = c.cwid) ' .
                'join ebh_users u on (u.uid = l.uid) ';
        $wherearr = array();
        $wherearr[] = 'c.status = 1';
        if (!empty($param['cwid']))
            $wherearr[] = 'l.cwid = ' . $param['cwid'];
        if (!empty($param['uid']))
            $wherearr[] = 'l.uid = ' . $param['uid'];
        $sql .= ' WHERE ' . implode(' AND ', $wherearr);
        return $this->db->query($sql)->row_array();
    }
    /**
     * 判断是否在同一天点的学习
     * @param int $uid		学员的uid
     * @param int $cwid		课件id
     * @param int $timeOut	有效时间
     * @return boolean $flag   TRUE是在同一天，false表示不再同一天，需要写日志
     */
    public function judgeOneDay($uid, $cwid, $timeOut = 86400) {
        //这里需要对时间进行判断，一天以后的需要重新加入，否则就不记录了
        $timeout = SYSTIME - $timeOut;
        $sql = "SELECT COUNT(*) count FROM ebh_studylogs WHERE uid='$uid' AND cwid='$cwid' AND dateline>$timeout";
        $flag = FALSE;
        $countrow = $this->db->query($sql)->row_array();
        if (!empty($countrow) && $countrow['count'] > 0)
            $flag = TRUE;
        else
            $flag = FALSE;
        $this->isoneday = $flag;
        return $flag;
    }
/**
 * 对播放课件采取扣费，如果课件价格为0,则不进行扣费
 * @param int $crid
 * @param int $uid
 * @param int $cwid
 * @param float $price
 * @param int $credit
 * @param string $ip
 * @param int $timeOut
 * @return boolean
 */
    public function pay($crid, $uid, $cwid, $price, $credit = 0, $ip, $timeOut = 86400) {
        $flag = $this->isoneday;
        if (!isset($flag)) {
            $flag = $this->judgeOneDay($uid, $cwid, $timeOut);
        }
        if($flag == TRUE)   //在有效期内已经处理过，则不再继续扣费
            return $flag;
        if ($price > 0) {
            $wherearr = array('crid' => $crid, 'uid' => $uid);
            $setarr = array('rbalance' => 'rbalance-' . $price);
            $upresult = $this->db->update('ebh_roomusers', array(), $wherearr, $setarr);
            if ($upresult > 0) {
                $this->record($uid, $cwid, $price, $ip, $credit);
                $flag = TRUE;
                $this->isoneday = TRUE;
            }
        } else {
            $this->record($uid, $cwid, $price, $ip, $credit);
            $flag = TRUE;
            $this->isoneday = TRUE;
        }
        return $flag;
    }

    /**
     * 插入一条学习记录
     * @param int $uid 用户的编号
     * @param int $cwid	课件的编号
     * @param float $price	本次消费费用
     * @param int $credit	产生的积分，预留
     * @param int $timeOut	多长时间以后需要重新记录(点击一次播放的有效时限，单位为秒)
     */
    public function record($uid, $cwid, $price, $ip, $credit = 0) {
        $now = SYSTIME;
        $setarr = array('uid' => $uid, 'cwid' => $cwid, 'price' => $price, 'credit' => $credit, 'fromip' => $ip, 'dateline' => $now);
        $logid = $this->db->insert('ebh_studylogs', $setarr);
        return $logid;
    }

	/*用于软件专题及金华学员动态*/
	public function studyfor($param){
		$sql = 'SELECT c.title title,s.dateline studydataline,u.username username FROM ebh_studylogs s LEFT JOIN ebh_coursewares c ON s.cwid=c.cwid LEFT JOIN ebh_users u ON s.uid = u.uid LEFT JOIN ebh_commisions cm ON cm.studylogid=s.logid';
		$wherearr = array();
		if(!empty($param['isclass'])) {
            $wherearr[] = 'c.isclass = '.$param['isclass'];
        }
		if(!empty($wherearr)) {
            $sql .= ' WHERE '.implode(' AND ',$wherearr);
        }
        if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY s.cwid';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
            $sql .= ' limit 0,10';
        }
        return $this->db->query($sql)->list_array();
	}
	/*
	最近一周的学习记录数
	@param int $uid
	*/
	public function getweeklog($uid){
		$dateline = time()-7*24*3600;
		$sql = 'select count(*) count from ebh_studylogs where uid='.$uid.' and dateline>'.$dateline;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
}
