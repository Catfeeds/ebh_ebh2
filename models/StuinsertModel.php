<?php
class StuinsertModel extends CModel{
	public function getstulist($param){
		$sql = 'select stuid,username,realname,schoolname,classname from tempstuinsert';

		$wherearr[]= 'stuid >='.$param['idfrom'];
		$wherearr[]= 'stuid <='.$param['idto'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	
	public function addMultipleMembers($uarr){
		$sql='insert into ebh_users (username,password,realname,sex,dateline,status,groupid,schoolname,credit) values ';
		foreach($uarr as $user){
			$username = $user['username'];
			$password = md5($user['password']);
			$realname = $user['realname'];
			$sex = $user['sex'];
			$dateline = $user['dateline'];
			$status = 1;
			$groupid = 6;
			$schoolname = empty($user['schoolname'])?'':$user['schoolname'];
			$credit = $user['credit'];
			$sql.= "('$username','$password','$realname',$sex,$dateline,$status,$groupid,'$schoolname',$credit),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		$fromuid = $this->db->insert_id();
		if($fromuid != NULL){
			$sql = 'insert into ebh_members (memberid,realname,sex) values ';
			for($i=0;$i<count($uarr);$i++){
				$memberid = $fromuid + $i;
				$realname = $uarr[$i]['realname'];
				$sex = $uarr[$i]['sex'];
				$sql.= "($memberid,'$realname',$sex),";
			}
			$sql = rtrim($sql,',');
			$this->db->query($sql);
		}
		return $fromuid;
	}
}
?>