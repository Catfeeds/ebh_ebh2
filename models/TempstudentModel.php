<?php
/*

*/
class TempstudentModel extends CModel{
	public function getBuyList($username){
		$sql = 'SELECT t.*,c.crname FROM ebh_tempstudents t LEFT JOIN ebh_classrooms c ON t.crid=c.crid WHERE ( t.username =\''.$username.'\' ) AND t.status = 1 ORDER BY t.dateline desc LIMIT 0,100';
		
		return $this->db->query($sql)->list_array();
	}
}
?>