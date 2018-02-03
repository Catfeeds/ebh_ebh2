<?php
/**
 * 课件点赞model
 */
class UserzanModel extends CModel{
	/**
	 * [checkStatus 通过uid cwid 和 crid 来读取 是否点过赞]
	 * @return [type] [description]
	 */
	public function checkStatus($param){
		if(empty($param['uid']) || empty($param['cwid']) || empty($param['crid'])){
			return false;
		}
        if (empty($param['ztype'])) {
            $param['ztype'] = 0;
        }
        $sql = 'select zid from `ebh_userzan` where uid ='.$param['uid'].' and cwid ='.$param['cwid'].' and crid ='.$param['crid'].' and `ztype`='.$param['ztype'];
        return $this->db->query($sql)->row_array();
	}
	/**
	 * [add 插入点赞记录]
	 * @param [type] $param [description]
	 */
	public function add($param){
        if (empty($param['ztype'])) {
            $param['ztype'] = 0;
        }
        $exists = $this->db->query('SELECT `zid` FROM `ebh_userzan` WHERE `uid`='.$param['uid'].' AND `cwid`='.$param['cwid'].' AND `ztype`='.$param['ztype'].' LIMIT 1')->row_array();
        if (!empty($exists)) {
            return false;
        }
        if (empty($param['ip'])) {
            $ip =  EBH::app()->getInput()->getip();
            $param['ip'] = ip2long($ip);
        }
        if (!isset($param['dateline'])) {
            $param['dateline'] = SYSTIME;
        }
		return $this->db->insert('ebh_userzan',$param);
	}
}