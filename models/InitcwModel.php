<?php
class InitcwModel extends CModel{
	
	public function getcrs(){
		$sql = 'select crid from ebh_roomcourses group by crid';
		return $this->db->query($sql)->list_array();
	}
	
	public function updatedisplayorder($crid){
		$sqlauto = 'ALTER TABLE `temproomcourse` AUTO_INCREMENT=200;';
		$sqlinsert = 'insert into temproomcourse (crid,folderid,cwid,sid,isfree) (select crid,folderid,cwid,sid,isfree from ebh_roomcourses where crid='.$crid.' order by crid,folderid,sid,cdisplayorder,cwid desc );';
		$sqlupdate = 'update ebh_roomcourses rc,temproomcourse tc set rc.cdisplayorder=tc.tid where rc.cwid=tc.cwid';
		$sqldrop = 'truncate table temproomcourse';
		$this->db->begin_trans();
		$this->db->query($sqlauto);
		$this->db->query($sqlinsert);
		$this->db->query($sqlupdate);
		$this->db->query($sqldrop);
		// log_message($sqlupdate);
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
        return TRUE;
	}
	
	public function getcrsfolder(){
		$sql = 'select crid from ebh_folders group by crid';
		return $this->db->query($sql)->list_array();
	}
	public function updatedisplayorderfolder($crid){
		$sqlauto = 'ALTER TABLE `tempfolder` AUTO_INCREMENT=100;';
		$sqlinsert = 'insert into tempfolder (folderid) (select folderid from ebh_folders where crid='.$crid.' order by folderlevel,displayorder,folderid desc);';
		$sqlupdate = 'update ebh_folders f,tempfolder tf set f.displayorder=tf.tid where f.folderid=tf.folderid';
		$sqldrop = 'truncate table tempfolder';
		$this->db->begin_trans();
		$this->db->query($sqlauto);
		$this->db->query($sqlinsert);
		$this->db->query($sqlupdate);
		$this->db->query($sqldrop);
		// log_message($sqlupdate);
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
        return TRUE;
	}
}
?>