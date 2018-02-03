<?php
/*
 * 精品课
 */
class JingpinModel extends CModel{
	/**
	 * 添加精品课大类
	 * @param unknown $param
	 */
	public function addMainType($param){
		if(!empty($param['pname'])){
			$sparr['pname'] = $param['pname'];
		}
		if(!empty($param['crid'])){
			$sparr['crid'] = $param['crid'];
		}
		if(!empty($param['summary'])){
			$sparr['summary'] = $param['summary'];
		}
		if(!empty($param['uid'])){
			$sparr['uid'] = $param['uid'];
		}
		if(empty($param['tid'])){
			$sparr['tid'] = 0;
		}else{
			$sparr['tid'] = $param['tid'];
		}
		if(isset($param['displayorder'])){
			$sparr['displayorder'] = $param['displayorder'];
		}
		if(!empty($param['dateline'])){
			$sparr['dateline'] = SYSTIME;
		}
		if(isset($param['limitdate'])){
			$sparr['limitdate'] = $param['limitdate'];
		}
		if(isset($param['itype'])){
			$sparr['itype'] = $param['itype'];
		}
		return $this->db->insert('ebh_pay_packages',$sparr);
	}
	/**
	 * 更新精品课大类
	 * @param unknown $param
	 */
	public function updateMainType($param,$where){
		$uparr = array();
		if(!empty($param['pname'])){
			$uparr['pname'] = $param['pname'];
		}
		return $this->db->update('ebh_pay_packages',$uparr,$where);
	}
	/**
	 * 删除精品课大类
	 * @param unknown $param
	 */
	public function deleteMainType($param){
		return $this->db->delete('ebh_pay_packages',$param);
	}
	/**
	 * 删除精品课类别
	 */
	public function deleteLocalType($param){
		$where = array();
		$sql = "select s.selid, s.itemid, s.iskk, i.folderid from `ebh_best_select` as s left join `ebh_best_items` i on s.itemid = i.itemid";
		if(!empty($param['uid'])){
			$where[] = " s.uid = ".$param['uid'];
		}
		if(!empty($param['crid'])){
			$where[] = " s.crid = ".$param['crid'];
		}
		if(!empty($param['pid'])){
			$where[] = " s.pid = ".$param['pid'];
		}
		if(!empty($param['sid'])){
			$where[] = " s.sid = ".$param['sid'];
		}
		if(!empty($where)){
			$sql .= " where ".implode(" and ", $where);	
		}
		$rows = $this->db->query($sql)->list_array();
		//直接删除大类和子类同时删除已选择的课程
		if(empty($rows)){
			if(empty($param['sid'])){
				$dsql = "delete from ebh_pay_packages where pid = ".$param['pid']." and itype = 1 and crid = ".$param['crid'];
				return $this->db->query($dsql,false);
			}else{
				$dsql = "delete from ebh_pay_sorts where pid = ".$param['pid']." and sid = ".$param['sid'];
				$res = $this->db->query($dsql,false);
				return $res;
			}
		}else{
			//已开课课程id
			$folderids = array();
			foreach($rows as $r){
				if($r['iskk'] == 1){
					$folderids[] = $r['folderid'];
				}
			}
			//查询是否有学生相关课程权限
			if(!empty($folderids)){
				$folderidstr = implode(',', $folderids);
				$sql = "select count(*) count from `ebh_userpermisions` as u left join `ebh_pay_items` i on u.itemid = i.itemid ";
				$sql .= " where i.itype = 1 and i.crid = ".$param['crid']." and i.pid = ".$param['pid']." and i.sid = ".$param['sid']." and u.folderid in (".$folderidstr.")";
				$frow = $this->db->query($sql)->row_array();
				if($frow['count'] > 0){
					return -2;
				}  
			}
			//依次删除该类别和已选的课程
			if($param['sid'] > 0){
				$dsql_11 = "delete from `ebh_best_select` where pid = ".$param['pid']." and sid = ".$param['sid']." and crid = ".$param['crid']." and uid = ".$param['uid'];
				$dsql_12 = "delete from `ebh_pay_sorts` where sid = ".$param['sid']." and pid = ".$param['pid'];
				$this->db->begin_trans();
				$res_1 = $this->db->query($dsql_11,false);
				$res_2 = $this->db->query($dsql_12,false);
				if($res_2 && $res_2){
					//提交事务
					$this->db->commit_trans();
				}else{
					//回滚
					$this->db->rollback_trans();
				}
				return $res_1 && $res_2;
			}else{
				$dsql_11 = "delete from `ebh_pay_packages` where pid = ".$param['pid']." and itype = 1 and crid = ".$param['crid'];
				$dsql_12 = "delete from `ebh_best_select` where pid = ".$param['pid']." and crid = ".$param['crid']." and uid = ".$param['uid'];
				$this->db->begin_trans();
				$res_1 = $this->db->query($dsql_11,false);
				$res_2 = $this->db->query($dsql_12,false);
				if($res_1 && $res_2){
					//提交事务
					$this->db->commit_trans();
				}else{
					//回滚
					$this->db->rollback_trans();
				}
				return $res_1 && $res_2;
			}
		}
	}
	
	/**
	 * 添加精品课子类
	 * @param unknown $param
	 */
	public function addSubType($param){
		if(!empty($param['pid'])){
			$sarr['pid'] = $param['pid'];
		}
		if(!empty($param['sname'])){
			$sarr['sname'] = $param['sname'];
		}
		if(!empty($param['content'])){
			$sarr['content'] = $param['content'];
		}
		if(isset($param['sdisplayorder'])){
			$sarr['sdisplayorder'] = $param['sdisplayorder'];
		}
		if(isset($param['showbysort'])){
			$sarr['showbysort'] = $param['showbysort'];
		}
		if(isset($param['showaslongblock'])){
			$sarr['showaslongblock'] = $param['showaslongblock'];
		}
		if(isset($param['image']['upfilepath'])){
			$sarr['imgurl'] = $param['image']['upfilepath'];
		}
		if(isset($param['image']['upfilename'])){
			$sarr['imgname'] = $param['image']['upfilename'];
		}
		return $this->db->insert('ebh_pay_sorts',$sarr);
	}
	/**
	 * 更新精品课子类
	 */
	public function updateSubType($param,$where){
		$sarr = array();
		if(!empty($param['sname'])){
			$sarr['sname'] = $param['sname'];
		}
		return $this->db->update('ebh_pay_sorts',$sarr,$where);
	}
	/**
	 * 获取精品课所有的主类
	 */
	public function getMainType($param){
		$sql = "select pid, pname from `ebh_pay_packages`";
		if(!empty($param['crid'])){
			$where[] = ' crid = '.$param['crid'];
		}
		if(isset($param['itype'])){
			$where[] = ' itype = '.$param['itype'];
		}
		if(!empty($param['uid'])){
			$where[] = ' uid = '.$param['uid'];
		}
		if(!empty($where)){
			$sql .= ' where'.implode(' and ', $where);
		}
		if(!empty($param['limit'])) {
			$sql .= ' limit '. $param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 获取精品课子类
	 */
	public function getSubType($param){
		$sql = "select pid, sid, sname from `ebh_pay_sorts`";
		if(!empty($param['pids'])){
			$where[] = ' pid in ('.$param['pids'].')';
		}
		if(!empty($where)){
			$sql .= ' where'.implode(' and ', $where);
		}
		if(!empty($param['limit'])) {
			$sql .= ' limit '. $param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 根据条件获取精品课详情
	 */
	public function getOneCourse($itemid){
		$sql = "select itemid, folderid, longblockimg from `ebh_best_items` where itemid = $itemid";
		return $this->db->query($sql)->row_array();
	}
	/**
	 * 根据条件检查是否是已选择的精品课程
	 */
	public function isSelectedCourse($param){
		$where = array();
		$sql = "select count(*) count from `ebh_best_select`";
		if(!empty($param['uid'])){
			$where[] = ' uid = '.$param['uid'];
		}
		if(!empty($param['crid'])){
			$where[] = ' crid = '.$param['crid'];
		}
		if(!empty($param['folderid'])){
			$where[] = ' folderid = '.$param['folderid'];
		}
		if(!empty($param['itemid'])){
			$where[] = ' itemid = '.$param['itemid'];
		}
		if(!empty($where)){
			$sql .= ' where'.implode(' and ', $where);
		}
		$row = $this->db->query($sql)->row_array();
		return empty($row['count']) ? 0 : $row['count'];
	}
	/**
	 * 开课
	 */
	public function selectCourse($param){
		$sql_1 = "insert into `ebh_pay_items` (`pid`,`iname`,`isummary`,`crid`,`providercrid`,`folderid`,`sid`,`iprice`,`comfee`,`roomfee`,`providerfee`";
		$sql_1 .= ",`imonth`,`iday`,`dateline`,`cannotpay`,`longblockimg`,`isyouhui`,`iprice_yh`,`comfee_yh`,`roomfee_yh`,`itype`) ";
		$sql_1 .= " values (".$param['pid'].","."'".$param['iname']."','".$param['isummary']."',".$param['crid'].",".$param['providercrid'].",".$param['folderid'];
		$sql_1 .= ",".$param['sid'].",".$param['iprice'].",".$param['comfee'].",".$param['comfee'].",".$param['providerfee'].",".$param['imonth'].",".$param['iday'];
		$sql_1 .= ",".$param['dateline'].",".$param['cannotpay'].",'".$param['longblockimg']."',".$param['isyouhui'].",".$param['iprice_yh'].",".$param['comfee_yh'];
		$sql_1 .= ",".$param['roomfee_yh'].",1)";
		
		//事务开始
		$this->db->begin_trans();
		//插入记录后，立即获取最新id
		$res1 = $this->db->query($sql_1,false);
		$maxid = $this->db->insert_id();		
		$sql_2 = "update ebh_best_select set `iskk` = 1, `dateline` = ".$param['dateline'].", `topayitemid` = ".$maxid." where itemid = ".$param['itemid'];
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