<?php
/*
folder表中coursewarenum数据修正
*/
class FolderfixModel extends CModel{
	/*
	初始化folder表中数据
	*/
	public function initCN(){
		$sql = 'update ebh_folders f set f.coursewarenum = 0;';
		$sql = 'update ebh_folders f left join ebh_roomcourses rc on (f.crid=rc.crid and f.folderid =rc.folderid)
				set f.coursewarenum = (select count(*) from ebh_roomcourses rc join ebh_coursewares c on rc.cwid=c.cwid where folderid=f.folderid and c.`status`=1);';
	}
	/*
	获取最高目录级数
	*/
	public function getMaxLevel(){
		$sql = 'select max(folderlevel) maxlevel from ebh_folders';
		$ml = $this->db->query($sql)->row_array();
		return $ml['maxlevel'];
	}
	/*
	根据folderlevel获取上一级
	*/
	public function getUpFolder($folderlevel){
		$sql = 'select ff.coursewarenum,ff.upid from ebh_folders f join ebh_folders ff on f.folderid=ff.upid where ff.folderlevel='.$folderlevel;
		return $this->db->query($sql)->list_array();
	}
	
	/*
	更新
	*/
	public function setCN($fcarr){
		$sql = '';
		foreach($fcarr as $k=>$num){
			$sql.= 'update ebh_folders set coursewarenum = '.$num.' where folderid='.$k.';<br/>';
		}
		$sql.= 'update ebh_classrooms c left join ebh_roomcourses rc on c.crid=rc.crid
				set c.coursenum = (select count(*) from ebh_roomcourses rc join ebh_coursewares c on rc.cwid=c.cwid where crid=c.crid and c.status=1);';
				
		echo $sql;
		$this->db->query($sql);
		
		
		
	}
}
?>