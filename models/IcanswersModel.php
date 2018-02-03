<?php

/**
 * Class Icanswers
 * 互动课堂互动表model
 */
class IcanswersModel extends CModel{
    //作用：获取互动答案
    public function getAnswers($param){
        if(empty($param['uid']) || empty($param['icid']) || empty($param['crid'])){
            return false;
        }
        $sql = 'select * from ebh_icanswers where uid = '.$param['uid'].' and icid = '.$param['icid'].' and crid = '.$param['crid'];
        return $this->db->query($sql)->list_array();
    }


    //获取未参加的互动数
    //$uid 用户id crid 网校id
    public function getUnJoinedNum($uid, $crid){
    	//已经参加的互动数目
    	if(! $uid || ! $crid){
    		return false;
    	}
    	$sql = 'select count(distinct(icid)) as count from ebh_icanswers where uid = '.$uid.' and crid = '.$crid;
    	$joinedNum = $this->db->query($sql)->row_array();
    	$sql = 'select count(distinct(u.uid)) as count from ebh_ics as s join ebh_icfolders as f on s.icid=f.icid join ebh_userpermisions as u on u.folderid = f.folderid';
    	$where = ' where s.crid = '.$crid. ' and u.uid ='.$uid.' and s.status = 1';
    	$sql .= $where;
    	$totalNum = $this->db->query($sql)->row_array();
    	return $totalNum['count'] - $joinedNum['count'];
    }
}
?>