<?php
/**
 *试题库分类类
 *
*/
class ResgroupsModel extends CModel{
	/**
	 *根据年级获取其下面的子类
	 *@param $grade
	 *@return array
	*/
	public function getListByGrade($grade){
		$sql = 'select r.* from ebh_resgroups r ';
		if(!empty($grade))
			$sql.='where r.grade = '.intval($grade);
		return $this->db->query($sql)->list_array();
	}
	/**
	* 根据分类id获取试题分类详情
	*/
	public function getGroupById($gid) {
		$sql = "select gid,groupname,grade,lnum from ebh_resgroups where gid=$gid";
		return $this->db->query($sql)->row_array();
	}
}
?>