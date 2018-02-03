<?php
class TeacherGroupsModel extends CModel{
	/**
	 *获取分组列表
	 */
	public function getList($param = array()){
		$sql = 'select tg.groupid,tg.tid,tg.crid,u.username,u.realname from ebh_teachergroups tg left join ebh_users u on tg.tid = u.uid';
		$wherearr = array();
		if(!empty($param['groupid'])){
			$wherearr[] = 'tg.groupid='.$param['groupid'];
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'tg.crid='.$param['crid'];
		}
		if(!empty($param['tid'])){
			$wherearr[] = 'tg.tid='.$param['tid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		}
		
		return $this->db->query($sql)->list_array();
	}

	/*
	选择分组教师
	@param array $param
	*/
	public function chooseTeachers($param){
		if(!empty($param['groupid'])){
			$wherearr['groupid'] = $param['groupid'];
			$this->db->delete('ebh_teachergroups',$wherearr);
		}
		foreach($param['tids'] as $tid){
			$tfarr = array('tid'=>$tid,'groupid'=>$param['groupid'],'crid'=>$param['crid']);
			$this->db->insert('ebh_teachergroups',$tfarr);
		}
	}
	
	//删除记录
	public function _delete($param = array()){
		if(empty($param)){
			return 0;
		}
		return $this->db->delete('ebh_teachergroups',$param);
	}
}