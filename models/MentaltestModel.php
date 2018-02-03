<?php
/*
心理测试
*/
class Mentaltestmodel extends CModel{
	public function insert($param){
		$setarr['answers'] = $this->db->escape_str($param['answers']);
		$setarr['uid'] = $param['uid'];
		$setarr['dateline'] = SYSTIME;
		$setarr['testtype'] = $param['testtype'];
		$setarr['score'] = $param['score'];
		$this->db->insert('ebh_mentaltests',$setarr);
	}

	public function getAnswers($param){
		$sql = 'select uid,answers,score from ebh_mentaltests';
		if(!empty($param['testid']))
			$wherearr[] = 'testid='.$param['testid'];
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.$param['uid'];
		if(isset($param['testtype']))
			$wherearr[] = 'testtype='.$param['testtype'];
		$sql.= ' where ' .implode(' AND ',$wherearr);
		return $this->db->query($sql)->row_array();
	}
}
?>