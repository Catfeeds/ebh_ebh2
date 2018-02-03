<?php
/**
 * 用户状态处理Model类UserstateModel
 */
class UserstateModel extends CModel{
    /**
     * 生成或更新用户状态时间记录
     * @param type $crid
     * @param type $userid
     * @param type $typeid
     * @param type $time
     * @return type
     */
    public function insert($crid,$userid,$typeid,$time,$folderid=0){
        $sql = "REPLACE INTO ebh_userstates (crid,userid,typeid,subtime,folderid) VALUES($crid,$userid,$typeid,$time,$folderid)";
	$result = $this->db->query($sql);
        return $result;
    }
    /**
     * 获取用户的最后状态时间
     * @param type $crid
     * @param type $uid
     * @param type $typeid
     * @return type
     */
    public function getsubtime($crid,$uid,$typeid) {
        $subtime = 0;
    	if (empty($crid) || empty($uid) || empty($typeid)){
    		return $subtime;
    	}
        $sql = "SELECT subtime FROM ebh_userstates WHERE crid=$crid AND userid=$uid AND typeid=$typeid";
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
            $subtime = $row['subtime'];
        return $subtime;
    }
	
	/*
	课程最后状态
	*/
	public function getfoldersubtime($param){
		$sql = 'SELECT subtime,folderid FROM ebh_userstates';
		$wherearr[] = 'crid='.$param['crid'];
		$wherearr[] = 'typeid='.$param['typeid'];
		$wherearr[] = 'userid='.$param['uid'];
		if(!empty($param['folderids']))
			$wherearr[] = 'folderid in ('.$param['folderids'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
}
