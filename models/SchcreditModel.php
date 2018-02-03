<?php
/**
 *学校学分模型
 */
class SchcreditModel extends CModel{
	//获取学校的学分列表
	public function getScoreList($param = array()){
		$sql = 'select sc.scid,sc.grade,sc.crid,sc.score from ebh_schcredit as sc';
		$whereArr = array();
		if(!empty($param['scid'])){
			$whereArr[] = 'sc.scid='.$param['scid'];
		}
		if(!empty($param['crid'])){
			$whereArr[] = 'sc.crid='.$param['crid'];
		}
		if(!empty($param['grade'])){
			$whereArr[] = 'sc.grade='.$param['grade'];
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ', $whereArr);
		}
		return $this->db->query($sql)->list_array();
	}

	//添加一条记录
	public function _insert($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->insert('ebh_schcredit',$param);
	}

	//修改一条记录
	public function _update($param = array(),$where = array()){
		if(empty($param)||empty($where)){
			return 0;
		}
		return $this->db->update('ebh_schcredit',$param,$where);
	}
}