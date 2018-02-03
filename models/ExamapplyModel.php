<?php

/**
 * 学生申请考试
 */
class ExamapplyModel extends CModel {

	/**
	 * 获取申请列表
	 */
	public function getapplylist($param){
		$wherearr = array();
		$sql = 'SELECT ea.applyid,ea.realname,ea.applydate,ea.verifydate,u.username FROM ebh_examapplys ea';
		$sql .= ' JOIN ebh_users u ON ea.uid=u.uid';
		if (!empty($param['crid']))
			$wherearr[] = 'ea.crid='.$param['crid'];
		if (isset($param['status']))
			$wherearr[] = 'ea.status='.$param['status'];
		if (!empty($param['q']))
			$wherearr[] = '(u.username like \'%'.$this->db->escape_str($param['q']).'%\''.
                    ' or ea.realname like \'%'.$this->db->escape_str($param['q']).'%\')';
		$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$sql.= ' ORDER BY applyid DESC';
		$res = $this->db->query($sql)->list_array();
		return $res;
	}

	/**
	 * 获取申请计数
	 */
	public function getapplycount($param){
		$wherearr = array();
		$sql = 'SELECT COUNT(*) count FROM ebh_examapplys ea';
		$sql .= ' JOIN ebh_users u ON ea.uid=u.uid';
		if (!empty($param['crid']))
			$wherearr[] = 'ea.crid='.$param['crid'];
		if (isset($param['status']))
			$wherearr[] = 'ea.status='.$param['status'];
		if (!empty($param['q']))
			$wherearr[] = '(u.username like \'%'.$this->db->escape_str($param['q']).'%\''.
                    ' or ea.realname like \'%'.$this->db->escape_str($param['q']).'%\')';
		$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
        return $count['count'];
    }

	/**
	 * 添加申请
	 */
	public function addapply($param){
		if(empty($param['crid']) || empty($param['uid']))
			return FALSE;
		$setarr['crid'] = $param['crid'];
		$setarr['uid'] = $param['uid'];
		if(isset($param['photo']))
			$setarr['photo'] = $param['photo'];
		if(isset($param['realname']))
			$setarr['realname'] = $param['realname'];
		if(isset($param['namespell']))
			$setarr['namespell'] = $param['namespell'];
		if(isset($param['sex']))
			$setarr['sex'] = $param['sex'];
		if(isset($param['birthyear']))
			$setarr['birthyear'] = $param['birthyear'];
		if(isset($param['birthmonth']))
			$setarr['birthmonth'] = $param['birthmonth'];
		if(isset($param['idcard']))
			$setarr['idcard'] = $param['idcard'];
		if(isset($param['mobile']))
			$setarr['mobile'] = $param['mobile'];
		if(isset($param['email']))
			$setarr['email'] = $param['email'];
		if(isset($param['citycode']))
			$setarr['citycode'] = $param['citycode'];
		if(isset($param['address']))
			$setarr['address'] = $param['address'];
		if(isset($param['zipcode']))
			$setarr['zipcode'] = $param['zipcode'];
		if(isset($param['schoolname']))
			$setarr['schoolname'] = $param['schoolname'];
		if(isset($param['major']))
			$setarr['major'] = $param['major'];
		if(isset($param['stuid']))
			$setarr['stuid'] = $param['stuid'];
		$setarr['applydate'] = SYSTIME;
		$this->db->insert('ebh_examapplys',$setarr);
	}

	/**
	 * 编辑申请
	 */
	public function editapply($param){
		if(empty($param['crid']) || empty($param['uid']) || empty($param['applyid']))
			return FALSE;
		$wherearr['crid'] = $param['crid'];
		$wherearr['uid'] = $param['uid'];
		$wherearr['applyid'] = $param['applyid'];
		if(isset($param['photo']))
			$setarr['photo'] = $param['photo'];
		if(isset($param['realname']))
			$setarr['realname'] = $param['realname'];
		if(isset($param['namespell']))
			$setarr['namespell'] = $param['namespell'];
		if(isset($param['sex']))
			$setarr['sex'] = $param['sex'];
		if(isset($param['birthyear']))
			$setarr['birthyear'] = $param['birthyear'];
		if(isset($param['birthmonth']))
			$setarr['birthmonth'] = $param['birthmonth'];
		if(isset($param['idcard']))
			$setarr['idcard'] = $param['idcard'];
		if(isset($param['mobile']))
			$setarr['mobile'] = $param['mobile'];
		if(isset($param['email']))
			$setarr['email'] = $param['email'];
		if(isset($param['citycode']))
			$setarr['citycode'] = $param['citycode'];
		if(isset($param['address']))
			$setarr['address'] = $param['address'];
		if(isset($param['zipcode']))
			$setarr['zipcode'] = $param['zipcode'];
		if(isset($param['schoolname']))
			$setarr['schoolname'] = $param['schoolname'];
		if(isset($param['major']))
			$setarr['major'] = $param['major'];
		if(isset($param['stuid']))
			$setarr['stuid'] = $param['stuid'];
		$setarr['status'] = 0;
		$setarr['applydate'] = SYSTIME;
		$this->db->update('ebh_examapplys',$setarr,$wherearr);
	}

	/**
	 * 撤销申请
	 */
	public function cancelapply($param){
		$wherearr = array();
		if(empty($param['applyid']))
			return FALSE;
		else
			$wherearr['applyid'] = $param['applyid'];
		if(!empty($uid))
			$wherearr['uid'] = $param['uid'];
		if(!empty($crid))
			$wherearr['crid'] = $param['crid'];
		return $this->db->update('ebh_examapplys', array('status'=>-1), $wherearr);
	}

	/**
	 * 获取一条申请信息
	 * @param  array $param  参数
	 * @return mix        申请信息
	 */
	public function getOneApply($param){
		$wherearr= array();
		$sql = 'SELECT * FROM ebh_examapplys';
		if (!empty($param['uid']))
			$wherearr[] = 'uid=' . intval($param['uid']);
		if (!empty($param['crid']))
			$wherearr[] = 'crid=' . intval($param['crid']);
		if (!empty($param['applyid']))
			$wherearr[] = 'applyid=' . intval($param['applyid']);
		//$wherearr[] = 'status <> -1';
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if (!empty($row))
		{
			$citycode = $row['citycode'];
			if(substr($row['citycode'],0,2) == '00'){
				$provincecode = substr($citycode, 0,4);
			}else{
				$provincecode = substr($citycode,0,2);
			}
			$province = $this->db->query('SELECT cityname FROM ebh_cities WHERE citycode=' . $provincecode)->row_array();
			$city = $this->db->query('SELECT cityname FROM ebh_cities WHERE citycode=' . $citycode)->row_array();
			$row['provincename'] = empty($province) ? '' : $province['cityname'];
			$row['cityname'] = empty($city) ? '' : $city['cityname'];
		}
		return $row;
	}

	/**
	 * 获取下一条申请
	 */
	public function getNextOne($param){
		if (empty($param['applyid']))
			return FALSE;
		$wherearr = array();
		$sql = 'SELECT applyid FROM ebh_examapplys';
		if (!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if (isset($param['nexttype']))
			$wherearr[] = 'status='.$param['nexttype'];
		$wherearr[] = 'applyid<'.$param['applyid'];
		$sql.= ' WHERE '.implode(' AND ',$wherearr);
		$sql.= ' ORDER BY applyid DESC';
		$sql.= ' LIMIT 1';

		$nextapply = $this->db->query($sql)->row_array();
		if (!empty($nextapply['applyid']))
			return $this->getOneApply(array('applyid'=>$nextapply['applyid']));
		else
			return FALSE;
	}

	/**
	 * 审核
	 */
	public function check($param){
		if (empty($param['applyid'])){
			return FALSE;
		}
		$setarr = array();
		$setarr['status'] = $param['status'];
		$setarr['verifyuid'] = $param['verifyuid'];
		$setarr['verifydate'] = SYSTIME;
		$setarr['verifymessage'] = $param['verifymessage'];

		$wherearr = array();
		$wherearr['applyid'] = intval($param['applyid']);
		$wherearr['crid'] = $param['crid'];
		return $this->db->update('ebh_examapplys', $setarr, $wherearr);
	}
	/**
	 * 批量审核
	 */
	public function batchcheck($param){
		if (empty($param['ids']) || empty($param['status'])){
			return FALSE;
		}
		$setarr = array();
		$setarr['status'] = $param['status'];
		$setarr['verifyuid'] = $param['verifyuid'];
		$setarr['verifydate'] = SYSTIME;
		$wherestr = 'applyid in ('.$param['ids'].') AND crid='.intval($param['crid']);
		return $this->db->update('ebh_examapplys', $setarr, $wherestr);
	}
	/**
	 * 批量发证
	 */
	public function batchaward($param){
		if (empty($param['ids'])){
			return FALSE;
		}
		$idarr = explode(",", $param['ids']);
		if(!is_array($idarr)){
			return FALSE;
		}
		$setarr = array();
		$setarr['isaward'] = 1;
		$setarr['tid'] = $param['tid'];
		$setarr['dateline'] = SYSTIME;
		foreach($idarr as $id){
			$answer = $this->db->query('SELECT crid FROM ebh_schexamanswers ea LEFT JOIN ebh_schexams e ON ea.eid=e.eid WHERE ea.aid='.$id)->row_array();
			if (empty($answer['crid']) && $answer['crid'] != $param['crid']){
				return FALSE;
			}
			$award = $this->db->query('SELECT awardid FROM ebh_examawards WHERE aid='.$id)->row_array();
			$setarr['aid'] = $id;
			if (!empty($award)){
				$this->db->update('ebh_examawards', $setarr, array('awardid'=>$award['awardid']));
			} else {
				$this->db->insert('ebh_examawards', $setarr);
			}
		}
		return TRUE;
	}
}
?>