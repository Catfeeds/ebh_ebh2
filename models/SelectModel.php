<?php
/*
 * 网校选择精品课程
 */
class SelectModel extends CModel{
	//选择精品课
	public function addCourse($param){
		if(!empty($param['crid'])){
			$setarr['crid'] = $param['crid'];
		}
		if(!empty($param['uid'])){
			$setarr['uid'] = $param['uid'];
		}
		if(isset($param['iskk'])){
			$setarr['iskk'] = $param['iskk'];
		}
		if(!empty($param['itemid'])){
			$setarr['itemid'] = $param['itemid'];
		}
		if(!empty($param['pid'])){
			$setarr['pid'] = $param['pid'];
		}
		if(!empty($param['sid'])){
			$setarr['sid'] = $param['sid'];
		}
		if(!empty($param['dateline'])){
			$setarr['dateline'] = $param['dateline'];
		}
		return $this->db->insert('ebh_best_select',$setarr);
	}
	//更新已选精品课
	public function updateCourse($param,$where){
		$setarr = array();
		if(!empty($param['uid'])){
			$setarr['uid'] = $param['uid'];
		}
		if(isset($param['iskk'])){
			$setarr['iskk'] = $param['iskk'];
		}
		if(isset($param['pid'])){
			$setarr['pid'] = $param['pid'];
		}
		if(isset($param['sid'])){
			$setarr['sid'] = $param['sid'];
		}
		if(!empty($param['dateline'])){
			$setarr['dateline'] = $param['dateline'];
		}
		return $this->db->update('ebh_best_select',$setarr,$where);
	}
	
	//获取选择的精品课列表
	public function getCourses($param){
		$sql = "select s.itemid, s.selid, s.iskk, s.pid, s.sid, s.topayitemid from `ebh_best_select` s";
		if(!empty($param['crid'])){
			$where[] = ' s.crid = '.$param['crid'];
		}
		if(isset($param['iskk'])){
			$where[] = ' s.iskk = '.$param['iskk'];
		}
		if(!empty($param['uid'])){
			$where[] = ' s.uid = '.$param['uid'];
		}
		if(!empty($param['pid'])){
			$where[] = ' s.pid = '.$param['pid'];
		}
		if(!empty($param['sid'])){
			$where[] = ' s.sid = '.$param['sid'];
		}
		if(!empty($where)){
			$sql .= ' where'.implode(' and ', $where);
		}
		if(!empty($param['limit'])) {
			$sql .= ' limit '. $param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}
	//获取选择的精品课数目
	public function getCoursesCount($param){
		$sql = "select count(*) count from `ebh_best_select` s";
		if(!empty($param['crid'])){
			$where[] = ' s.crid = '.$param['crid'];
		}
		if(isset($param['iskk'])){
			$where[] = ' s.iskk = '.$param['iskk'];
		}
		if(!empty($param['uid'])){
			$where[] = ' s.uid = '.$param['uid'];
		}
		if(!empty($param['pid'])){
			$where[] = ' s.pid = '.$param['pid'];
		}
		if(!empty($param['sid'])){
			$where[] = ' s.sid = '.$param['sid'];
		}
		if(!empty($where)){
			$sql .= ' where'.implode(' and ', $where);
		}
		$ret = $this->db->query($sql)->row_array();
		return $ret['count'] > 0 ? $ret['count'] : 0;
	}
	
	//获取一个已选择的精品课
	public function getOneCourse($param){
		$sql = 'select * from ebh_best_select b';
		$where = array();
		if(!empty($param['crid'])){
			$where[] = ' b.crid = '.$param['crid'];
		}
		if(!empty($param['itemid'])){
			$where[] = ' b.itemid = '.$param['itemid'];
		}
		if(!empty($where)){
			$sql .= ' where '.implode(' and ',$where); 
		}
		return $this->db->query($sql)->row_array();	
	}
	
	//获取精品课详情
	public function getDetailCourse($itemid){
		$sql = "select * from ebh_best_items where itemid = ".$itemid;
		return $this->db->query($sql)->row_array();
	}
	
	//删除已选精品课程及本地关联课程
	public function deleteLocalCourse($param){
		//直接删除
		if($param['iskk'] == 0){
			$where['crid'] = $param['crid'];
			$where['itemid'] = $param['itemid'];
			return $this->db->delete('ebh_best_select',$where);
		}else{
			//查询精品课相关记录是否存在
			$sql = "select folderid from ebh_best_items where itemid = ".$param['itemid'];
			$row = $this->db->query($sql)->row_array();
			if(empty($row)){
				return -2;
			}
			//查询是否有学生报名
			$sql = "select count(*) count from `ebh_userpermisions` as u left join `ebh_pay_items` i on u.itemid = i.itemid ";
			$sql .= " where i.itype = 1 and i.crid = ".$param['crid']." and i.pid = ".$param['pid']." and i.sid = ".$param['sid']." and u.folderid = ".$row['folderid'];
			$rrow = $this->db->query($sql)->row_array();
			if($rrow['count'] > 0){
				return -3;
			}
			//事务开始
			$this->db->begin_trans();
			$sql_1 = "delete from ebh_pay_items where pid = ".$param['pid']." and crid = ".$param['crid']." and sid = ".$param['sid']." and itype = 1 and folderid = ".$row['folderid'];
			$sql_2 = "delete from ebh_best_select where pid = ".$param['pid']." and crid = ".$param['crid']." and uid = ".$param['uid']." and itemid = ".$param['itemid'];
			$res1 = $this->db->query($sql_1,false);
			$res2 = $this->db->query($sql_2,false);
			if($res1 && $res2){
				//提交事务
				$this->db->commit_trans();
			}else{
				//回滚
				$this->db->rollback_trans();
			}
			return $res1 && $res2;
		}
	}
}