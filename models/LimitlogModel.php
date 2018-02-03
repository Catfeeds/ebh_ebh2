<?php
/**
 *用户LimitlogModel类 用于控制限制用户IP
 */
class LimitlogModel extends CModel {
	/*
	添加日志
	@param array $param
	@return int
	*/
	public function addlog($param){
		$setarr = array();
		if(!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
		if(!empty($param['fromip']))
			$setarr['fromip'] = $param['fromip'];
		if(!empty($param['startdate']))
			$setarr['startdate'] = $param['startdate'];
		if(!empty($param['enddate']))
			$setarr['enddate'] = $param['enddate'];
		if(!empty($param['finishfrom']))
			$setarr['finishfrom'] = $param['finishfrom'];
		if(!empty($param['isfinish']))
			$setarr['isfinish'] = $param['isfinish'];
		if(empty($setarr))
			return FALSE;
		$logid = $this->db->insert('ebh_limitlogs',$setarr);
		return $logid;
	}
	/**
     * 根据logid修改limitlog表记录信息
     * @param type $param
     * @param type $logid
    */
    public function update($param,$logid) {
        $afrows = FALSE;    //影响行数
		if(empty($logid))
			return FALSE;
        $setarr = array();
        //修改limitlog表信息
		if(!empty($param['startdate']))
			$setarr['startdate'] = $param['startdate'];
		if(!empty($param['enddate']))
			$setarr['enddate'] = $param['enddate'];
		if(!empty($param['finishfrom']))
			$setarr['finishfrom'] = $param['finishfrom'];
		if(!empty($param['isfinish']))
			$setarr['isfinish'] = $param['isfinish'];
        $wherearr = array('logid' => $logid);
        if (!empty($setarr)) {
            $afrows = $this->db->update('ebh_limitlogs', $setarr, $wherearr);
        }
        return $afrows;
	}
	/**
	*根据uid fromip等信息更新值
	*
	*/
	public function updateByWhere($param,$wherearr) {
		$afrows = FALSE;
		if(empty($wherearr) || empty($wherearr['uid']))
			return FALSE;
		$where = array();
		$setarr = array();
		if(!empty($param['enddate']))
			$setarr['enddate'] = $param['enddate'];
		if(!empty($param['finishfrom']))
			$setarr['finishfrom'] = $param['finishfrom'];
		if(isset($param['isfinish']))
			$setarr['isfinish'] = $param['isfinish'];

		if(!empty($wherearr['uid']))
			$where['uid'] = $wherearr['uid'];
		if(!empty($wherearr['fromip']))
			$where['fromip'] = $wherearr['fromip'];
		if(isset($wherearr['isfinish']))
			$where['isfinish'] = $wherearr['isfinish'];

		if(!empty($setarr)) {
			$afrows = $this->db->update('ebh_limitlogs', $setarr, $where);
		}
		return $afrows;
	}
	/**
	*根据Uid fromip等参数获取日志限制记录
	*/
	public function getLogByIp($param) {
		if(empty($param) || empty($param['uid']) || empty($param['fromip']) )
			return FALSE;
		$wherearr = array();
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.$param['uid'];
		if(!empty($param['fromip']))
			$wherearr[] = "fromip='".$param['fromip']."'";
		if(isset($param['isfinish']))
			$wherearr[] = 'isfinish='.$param['isfinish'];
		$sql = 'select *from ebh_limitlogs';
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();
	}
}
