<?php
class DModel extends CModel{
	public function getclassid($classname){
		$sql = 'select classid from ebh_classes where crid = 10383 and classname=\''.$classname.'\'';
		$class = $this->db->query($sql)->row_array();
		return $class;
	}
	public function getuid($username){
		$sql = 'select uid from ebh_users where username = \''.$username.'\'';
		$uids = $this->db->query($sql)->row_array();
		return $uids;
	}
	public function add($classes,$users,$usernamearr){
		$sql = 'insert into ebh_classstudents (classid,uid) values ';
		$exstr = '';
		foreach($classes as $k=>$class){
			if(!empty($users[$k])){
				$uid = $users[$k]['uid'];
				$classid = $class['classid'];
				$sql.= "($classid,$uid),";
			}
			else
				$exstr.=$usernamearr[$k].',';
		}
		$sql = rtrim($sql,',');
		echo $sql;
		echo '<br/>';
		echo $exstr;
		// $this->db->query($sql);
	}
}
?>