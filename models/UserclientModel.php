<?php
/**
 * 用户设备登录信息记录表
 */
class UserclientModel extends CModel{
	/*
	设备绑定信息
	@param array $param
	@return int
	*/
	public function add($param){
		if(empty($param['uid']))
			return FALSE;
		$setarr = array();
		$setarr['uid'] = $param['uid'];
		if(!empty($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(!empty($param['ismobile']))
			$setarr['ismobile'] = $param['ismobile'];
		if(!empty($param['system']))
			$setarr['system'] = $param['system'];
		if(!empty($param['browser']))
			$setarr['browser'] = $param['browser'];
		if(!empty($param['broversion']))
			$setarr['broversion'] = $param['broversion'];
		if(!empty($param['screen']))
			$setarr['screen'] = $param['screen'];
		if(!empty($param['ip']))
			$setarr['ip'] = $param['ip'];
		if(!empty($param['dateline']))
			$setarr['dateline'] = $param['dateline'];
		if(!empty($param['lasttime']))
			$setarr['lasttime'] = $param['lasttime'];
		if(!empty($param['isext']))
			$setarr['isext'] = $param['isext'];
		if(empty($setarr))
			return FALSE;
		$clientid = $this->db->insert('ebh_userclients',$setarr);
		return $clientid;
	}
	/**
	*编辑绑定信息，主要编辑绑定的时间
	*/
	public function update($param){
		if(empty($param['clientid']))
			return FALSE;
		$setarr = array();
		if(!empty($param['browser']))
			$setarr['browser'] = $param['browser'];
		if(!empty($param['broversion']))
			$setarr['broversion'] = $param['broversion'];
		if(!empty($param['screen']))
			$setarr['screen'] = $param['screen'];
		if(!empty($param['ip']))
			$setarr['ip'] = $param['ip'];
		if(!empty($param['dateline']))
			$setarr['dateline'] = $param['dateline'];
		if(!empty($param['lasttime']))
			$setarr['lasttime'] = $param['lasttime'];
		if(isset($param['isext']))
			$setarr['isext'] = $param['isext'];
		if(empty($setarr))
			return FALSE;
		$wherearr = array('clientid' => $param['clientid']);
		return $this->db->update('ebh_userclients', $setarr, $wherearr);
	}
	/**
	* 根据用户编号获取用户设备绑定信息
	* @param int $uid 用户uid
	*/
	public function getClientsByUid($uid,$crid) {
		$sql = "select clientid,crid,ismobile,system,browser,broversion,screen,ip,dateline,lasttime,isext from ebh_userclients where uid=$uid and crid=$crid";
		return $this->db->query($sql)->list_array();
	}

	/**
	 * 获取用户设备列表
	 */
	public function getUserClientList($param) {
		$sql = 'select uc.clientid,uc.uid,uc.ismobile,uc.system,uc.browser,u.username,u.realname from ebh_userclients uc join ebh_users u on uc.uid=u.uid';
		$wherearr = array();
		if (!empty($param['crid'])) {
			$wherearr[] = 'uc.crid=' . intval($param['crid']);
		}
		if (!empty($param['q'])) {
			$wherearr[] = '(u.username like \'%'.$this->db->escape_str($param['q']).'%\' or u.realname like \'%'.$this->db->escape_str($param['q']).'%\')';
		}
		if (!empty($param['uid'])) {
			$wherearr[] = 'uc.uid=' . intval($param['uid']);
		}

		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		if (!empty($param['order']))
			$sql .= ' ORDER BY '.$param['order'];
		else
			$sql .= ' ORDER BY uc.clientid DESC';
		if (!empty($param['limit'])) {
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
	 * 获取用户设备绑定列表(每个用户一条记录)
	 */
	public function getClientList($param) {
		$sql = 'select uc.clientid,uc.uid,uc.ismobile,uc.system,uc.browser,count(uc.clientid) as clientnum,u.username,u.realname from ebh_userclients uc join ebh_users u on uc.uid=u.uid';
		$wherearr = array();
		if (!empty($param['crid'])) {
			$wherearr[] = 'uc.crid=' . intval($param['crid']);
		}
		if (!empty($param['q'])) {
			$wherearr[] = '(u.username like \'%'.$this->db->escape_str($param['q']).'%\' or u.realname like \'%'.$this->db->escape_str($param['q']).'%\')';
		}
		if (!empty($param['uid'])) {
			$wherearr[] = 'uc.uid=' . intval($param['uid']);
		}

		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$sql .= ' GROUP BY uc.uid';
		if (!empty($param['order']))
			$sql .= ' ORDER BY '.$param['order'];
		else
			$sql .= ' ORDER BY uc.clientid DESC';
		if (!empty($param['limit'])) {
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
	 * 获取用户设备总数(每个用户一条记录)
	 */
	public function getClientCount($param) {
		$count = 0;
		$sql = 'select count(distinct(uc.uid)) as count from ebh_userclients uc join ebh_users u on uc.uid=u.uid';
		$wherearr = array();
		if (!empty($param['crid'])) {
			$wherearr[] = 'uc.crid=' . intval($param['crid']);
		}
		if (!empty($param['q'])) {
			$wherearr[] = '(u.username like \'%'.$this->db->escape_str($param['q']).'%\' or u.realname like \'%'.$this->db->escape_str($param['q']).'%\')';
		}
		if (!empty($param['uid'])) {
			$wherearr[] = 'uc.uid=' . intval($param['uid']);
		}

		$sql .= ' WHERE ' . implode(' AND ', $wherearr);

		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}

	/**
	 * 删除用户设备信息
	 */
	public function delete($param) {
		if (!empty($param['uid']))
			$wherearr['uid'] = $param['uid'];
		else
			return FALSE;

		return $this->db->delete('ebh_userclients',$wherearr);
	}
}