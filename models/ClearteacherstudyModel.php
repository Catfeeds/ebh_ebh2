<?php
/**
 * 清除老师听课获得积分
 */
class ClearteacherstudyModel extends CModel{
	/*
	老师获得学习积分
	*/
	public function getteacherlist(){
		$sql = 'select from_unixtime(c.dateline),sum(c.credit) credit,c.toid uid from ebh_creditlogs c
				join ebh_users u on c.toid = u.uid 
				where u.groupid = 5 and ruleid=5
				group by u.uid
				';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	老师拥有的积分
	*/
	public function getcreditlist($param){
		$sql = 'select uid,credit from ebh_users where uid in ('.$param['uids'].')';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	减去学习获得的积分
	*/
	public function updatecredit($tcarr){
		$sql = 'update ebh_users set credit = CASE uid';
		$wtArr = array();
		$inArr = array();
		foreach($tcarr as $teacher){
			$wtArr[] = ' WHEN '.$teacher['uid'].' THEN credit-'.$teacher['credit'];
			$inArr[] = $teacher['uid'];
		}
		if(!empty($inArr)){
			$sql.= implode(' ', $wtArr).' END WHERE uid IN ('.implode(',', $inArr).')';
			echo '执行了: '.$sql.'<br>';
			$this->db->query($sql);
		}
	}
	
	/*
	删除学习获得积分记录
	*/
	public function delcreditlog($param){
		$sql = 'delete from ebh_creditlogs where ruleid = 5 and toid in ('.$param['uids'].')';
		$this->db->query($sql);
	}
}
