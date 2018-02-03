<?php
class AdminmenuModel extends CModel {
	/*
	顶部菜单
	*/
	public function getTopmenu(){
		$sql = 'select m.moduleid,m.name,m.redir,m.identifier from ebh_modules m where upid = 0 and visible = 1 ORDER BY displayorder,moduleid LIMIT 0,1000';
		//SELECT m.* FROM ebh_2012.ebh_modules m WHERE m.visible = 1 ORDER BY upid,displayorder,moduleid LIMIT 0,1000
		return $this->db->query($sql)->list_array();
	}
	/*
	侧边菜单
	@param int $upid 上级模块
	*/
	public function getSidemenu($upid=159){
		$sql = 'SELECT m.moduleid,m.name,m.upid,m.redir,m.identifier FROM ebh_modules m WHERE m.upid = '.$upid.' AND m.visible = 1 ORDER BY upid,displayorder,moduleid LIMIT 0,1000;';
		
		return $this->db->query($sql)->list_array();
	}
}
?>