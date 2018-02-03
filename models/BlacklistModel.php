<?php
/*
黑名单
*/
class BlacklistModel extends CModel{
	/*
	ip黑名单记录
	*/
	public function getIpRecord($ip,$crid){
		$sql = 'select crid,ip from ebh_blacklists';
		$wherearr[] = 'ip='.$ip;
		$wherearr[] = "(crid=$crid or crid=0)";
		$wherearr[] = 'state=1';
		$wherearr[] = "(deny='LOGIN' or deny='All')";
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();
		
	}
	/*
	用户黑名单记录
	*/
	public function getUserRecord($uid,$crid){
		$sql = 'select crid,uid	from ebh_blacklists';
		$wherearr[] = 'uid='.$uid;
		$wherearr[] = "(crid=$crid or crid=0)";
		$wherearr[] = 'state=1';
		$wherearr[] = "(deny='LOGIN' or deny='All')";
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();
	}
}
?>