<?php
/**
 * 体质测试数据model
 */
class ConstitutionModel extends CModel{
	/**
	 * 批量插入学生体质测试数据记录
	 */
	public function addMultipleConstitution($userlist,$fid){
		if(empty($userlist) || empty($fid)){
			return false;
		}
		$newarr = array_chunk($userlist,100);//进行分批插入 一次插入500条 若有错误 则回滚
		try{//这是个整体的成功与失败的关系
            $this->db->begin_trans();
            foreach ($newarr as $userlist) {
            	$sql = 'insert into ebh_constitution (syid,crid,fid,cid,gradeid,classid,classname,studentname,sex,birthdate,studentcode,nationalcode,address,height,weight,weight_score,weight_grade,vitalcapacity,vitalcapacity_score,vitalcapacity_grade,running50,running50_score,running50_grade,sit_and_reach,sit_and_reach_score,sit_and_reach_grade,running50_8,running50_8_score,running50_8_grade,situp,situp_score,situp_grade,situp_extras,jump,jump_score,jump_grade,jump_extras,standard,extras,total,total_grade,uid) values ';
	            foreach($userlist as $value){
		                $sql.= '(';
		                $sql.= intval($value['syid']);
		                $sql.= ','.intval($value['crid']);
		                $sql.= ','.intval($fid);
		                $sql.= ','.intval($value['cid']);
		                $sql.= ','.intval($value['gradeid']);
		                $sql.= ','.intval($value['classid']);
		                $sql.= ','.$this->db->escape($value['classname']);
		                $sql.= ','.$this->db->escape($value['studentname']);
		                $sql.= ','.intval($value['sex']);
		                $sql.= ','.$this->db->escape($value['birthdate']);
		                $sql.= ','.$this->db->escape($value['studentcode']);
		                $sql.= ','.intval($value['nationalcode']);
		                $sql.= ','.$this->db->escape($value['address']);
		                $sql.= ','.floatval($value['height']);
		                $sql.= ','.floatval($value['weight']);
		                $sql.= ','.intval($value['weight_score']);
		                $sql.= ','.$this->db->escape($value['weight_grade']);
		                $sql.= ','.intval($value['vitalcapacity']);
		                $sql.= ','.intval($value['vitalcapacity_score']);
		                $sql.= ','.$this->db->escape($value['vitalcapacity_grade']);
		                $sql.= ','.floatval($value['running50']);
		                $sql.= ','.intval($value['running50_score']);
		                $sql.= ','.$this->db->escape($value['running50_grade']);
		                $sql.= ','.floatval($value['sit_and_reach']);
		                $sql.= ','.intval($value['sit_and_reach_score']);
		                $sql.= ','.$this->db->escape($value['sit_and_reach_grade']);
		                $sql.= ','.intval($value['running50_8']);
		                $sql.= ','.intval($value['running50_8_score']);
		                $sql.= ','.$this->db->escape($value['running50_8_grade']);
		                $sql.= ','.intval($value['situp']);
		                $sql.= ','.intval($value['situp_score']);
		                $sql.= ','.$this->db->escape($value['situp_grade']);
		                $sql.= ','.intval($value['situp_extras']);
		                $sql.= ','.intval($value['jump']);
		                $sql.= ','.intval($value['jump_score']);
		                $sql.= ','.$this->db->escape($value['jump_grade']);
		                $sql.= ','.intval($value['jump_extras']);
		                $sql.= ','.floatval($value['standard']);
		                $sql.= ','.intval($value['extras']);
		                $sql.= ','.floatval($value['total']);
		                $sql.= ','.$this->db->escape($value['total_grade']);
		                $sql.= ','.intval($value['uid']);
		                $sql.= '),';
	            	}
                $sql = rtrim($sql,',');
                $res = $this->db->query($sql,false);
                if(!$res){
                	throw new Exception();
                	return false;
                }
            }
            $this->db->commit_trans();
           	return true;   
        }catch(Exception $e){
            $this->db->rollback_trans();
            return false;
        }
	}
	/**
	 * 获取网校下的每个班级体质测试份数
	 */
	public function getClassConstitutionCount($crid){
		if(empty($crid)){
			return false;
		}
		$sql = 'select cid from `ebh_constitution` where crid ='. intval($crid) .' group by syid,cid';
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 根据cid获取网校下班级的历年体质测试数据
	 */
	public function getConstitutionList($cid,$crid){
		if(empty($cid) || empty($crid)){
			return false;
		}
		$sql = 'SELECT c.syid,sy.syname,sy.dateline,c.classname,c.cid from `ebh_constitution` c LEFT JOIN `ebh_school_year` sy on (c.syid = sy.syid) where c.crid = ' .intval($crid). ' and c.cid = ' .intval($cid). ' GROUP BY c.syid';
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 根据cid，crid获取网校下班级下学生列表和体质测试份数
	 */
	public function getStudentDateBycid($cid,$crid,$keywords = ''){
		if(empty($cid) || empty($crid)){
			return false;
		}
		$sql = 'SELECT c.studentname,count(c.studentname) as count,c.uid,c.sex,u.face,u.username from `ebh_constitution` c left join `ebh_users` u on(c.uid = u.uid) where crid = ' .intval($crid). ' and cid = ' .intval($cid);
		if(!empty($keywords)) {
			$sql.= ' and (u.username like \'%'.$this->db->escape_str($keywords).'%\' or c.studentname like \'%'.$this->db->escape_str($keywords).'%\')';
		}
		$sql.= ' GROUP BY studentname';
		if(!empty($page)){
			$sql.= ' limit '.$page;
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 根据cid，crid获取网校下班级下学生列表的数量
	 */
	public function getStudentCountBycid($cid,$crid,$keywords = ''){
		if(empty($cid) || empty($crid)){
			return false;
		}
		$sql = 'SELECT count(distinct c.studentname) as count from `ebh_constitution` c left join `ebh_users` u on (u.uid = c.uid) where crid = ' .intval($crid). ' and cid =' . intval($cid);
		if(!empty($keywords)) {
			$sql.= ' and (u.username like \'%'.$this->db->escape_str($keywords).'%\' or c.studentname like \'%'.$this->db->escape_str($keywords).'%\')';
		}
		return $this->db->query($sql)->row_array();
	}
	/**
	 * 根据uid和cid获取学生的成绩信息
	 */
	public function getStudentRank($cid,$uid,$param){
		if(empty($cid) || empty($uid) || empty($param)){
			return false;
		}
		if($param['field'] !='running50' || $param['field'] != 'running50_8'){
			if($param['field'] == 'total' || $param['field'] == 'height'){

			}else{
				if(strstr($param['field'],'_score')){
					$param['field'] = $param['field'].','.strstr($param['field'],'_score',true);
				}else{
					$param['field'] = $param['field'].','.$param['field'].'_score';
				}
			}
		}
		$sql = 'select ' .$param['field']. ',syid,uid from ebh_constitution where cid = ' .intval($cid);
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 根据cid，syid和字段信息获取班级的相关数据
	 */
	public function getClassData($cid,$syid,$param){
		if(empty($cid) || empty($syid) || empty($param)){
			return false;
		}
		if($param['field'] == 'height'){

		}else{
			if($param['type'] == 'grade'){
				$param['field'] = $param['field'].'_'.$param['type'];
			}
			if($param['type'] == 'score'){
				if($param['field'] == 'total'){
					$param['field'] = $param['field'];
				}
			}
		}
		if($param['type'] == 'grade'){
			$sql = 'select c.' .$param['field']. ',c.studentname,u.face from ebh_constitution c left join ebh_users u on(c.uid = u.uid) where c.cid ='.intval($cid).' and c.syid='.intval($syid);
		}else{
			$sql = 'select c.' .$param['field']. ' as data ,c.studentname,u.face,c.sex from ebh_constitution c left join ebh_users u on(c.uid = u.uid) where c.cid ='.intval($cid).' and c.syid='.intval($syid);
		}
		if($param['type'] == 'score'){
			if($param['field'] == 'running50' || $param['field'] == 'running50_8'){
				$sql.=" order by c.".$param['field']." asc";
			}else{
				$sql.=" order by c.".$param['field']." desc";
			}
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 根据cid,syid读取数据
	 */
	public function getListBycid($cid,$syid){
		if(empty($cid) || empty($syid)){
			return false;
		}
		$sql = 'select gradeid,classid,classname,studentcode,nationalcode,studentname,sex,birthdate,address,height,weight,weight_score,weight_grade,vitalcapacity,vitalcapacity_score,vitalcapacity_grade,running50,running50_score,running50_grade,sit_and_reach,sit_and_reach_score,sit_and_reach_grade,running50_8,running50_8_grade,running50_8_score,situp,situp_score,situp_grade,situp_extras,jump,jump_score,jump_grade,jump_extras,standard,extras,total,total_grade from `ebh_constitution` where cid='.intval($cid).' and syid='.intval($syid);
		return $this->db->query($sql)->list_array();
	}
}
?>