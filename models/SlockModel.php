<?php
/*
*屏幕锁屏
*/
class SlockModel extends CModel{
	//添加一条锁屏记录
	public function addLock($param = array()){
		$setArr =  array();
		$setArr['title'] = empty($param['title'])?'':$this->db->escape_str($param['title']);
		$setArr['uid'] = empty($param['uid'])?0:$param['uid'];
		$setArr['startdate'] = empty($param['startdate'])?0:$param['startdate'];
		$setArr['enddate'] = empty($param['enddate'])?0:$param['enddate'];
		$lockid = $this->db->insert('ebh_slock',$setArr);
		if(empty($lockid)){
			return 0;
		}
		$classes = $param['classes'];
		$crid = $param['crid'];
		foreach ($classes as $class) {
			$skey = md5($class['classid'].'_'.$class['grade'].'_'.$class['district'].'_'.$crid);
			$setArr = array(
				'lockid'=>$lockid,
				'crid'=>$crid,
				'classid'=>$class['classid'],
				'grade'=>$class['grade'],
				'district'=>$class['district'],
				'skey'=>$skey
			);
			$this->db->insert('ebh_classslock',$setArr);
		}
		return $lockid;
	}
	//编辑锁屏记录
	public function editLock($param = array()){
		$lockid = $param['lockid'];
		if(!is_numeric($lockid) || ($lockid <= 0) ){
			return false;
		}
		$setArr =  array();
		$setArr['title'] = empty($param['title'])?'':$this->db->escape_str($param['title']);
		$setArr['uid'] = empty($param['uid'])?0:$param['uid'];
		$setArr['startdate'] = empty($param['startdate'])?0:$param['startdate'];
		$setArr['enddate'] = empty($param['enddate'])?0:$param['enddate'];
		$whereArr = array(
			'lockid'=>$lockid
		);
		$res = $this->db->update('ebh_slock',$setArr,$whereArr);
		if($res === false){
			return false;
		}

		//删除原先关联信息
		$whereArr = array('lockid'=>$lockid);
		$res = $this->db->delete('ebh_classslock',$whereArr);

		$classes = $param['classes'];
		$crid = $param['crid'];
		foreach ($classes as $class) {
			$skey = md5($class['classid'].'_'.$class['grade'].'_'.$class['district'].'_'.$crid);
			$setArr = array(
				'lockid'=>$lockid,
				'crid'=>$crid,
				'classid'=>$class['classid'],
				'grade'=>$class['grade'],
				'district'=>$class['district'],
				'skey'=>$skey
			);
			$this->db->insert('ebh_classslock',$setArr);
		}
		return $res;
	}

	//删除锁屏记录
	public function delLock($lockid = 0){
		$whereArr = array('lockid'=>$lockid);
		$res1 = $this->db->delete('ebh_slock',$whereArr);
		$res2 = $this->db->delete('ebh_classslock',$whereArr);
		return $res1&&$res2;
	}

	//获取锁屏列表
	public function getList($param = array()){
		$sql = 'select s.uid,s.lockid,s.title,s.startdate,s.enddate from ebh_slock s';
		$whereArr = array();
		if(!empty($param['uid'])){
			$whereArr[] = 's.uid = '.$param['uid'];
		}
		if(!empty($param['lockid_not_in'])){
			$whereArr[] = 's.lockid not in ('.implode(',', $param['lockid_not_in']).')';
		}
		if(!empty($param['startdate'])){
			$whereArr[] = 's.startdate >= '.$param['startdate'];
		}
		if(!empty($param['enddate'])){
			if(empty($param['valide'])){
				$whereArr[] = 's.enddate <= '.$param['enddate'];
			}else{
				$whereArr[] = 's.enddate >= '.$param['enddate'];
			}
		}
		if(!empty($whereArr)){
			$sql .= ' WHERE '.implode(' AND ', $whereArr);
		}
		if (!empty($param['order'])) {
            $sql .= ' order by ' . $param['order'];
        } else {
            $sql .= ' order by s.lockid desc ';
        }
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
		return $this->db->query($sql)->list_array();
	}

	public function getListCount($param = array()){
		$sql = 'select count(1) as count from ebh_slock s';
		$whereArr = array();
		if(!empty($param['uid'])){
			$whereArr[] = 's.uid = '.$param['uid'];
		}
		if(!empty($param['lockid_not_in'])){
			$whereArr[] = 's.lockid not in ('.implode(',', $param['lockid_not_in']).')';
		}
		if(!empty($param['startdate'])){
			$whereArr[] = 's.startdate >= '.$param['startdate'];
		}
		if(!empty($param['enddate'])){
			$whereArr[] = 's.enddate <= '.$param['enddate'];
		}
		if(!empty($whereArr)){
			$sql .= ' WHERE '.implode(' AND ', $whereArr);
		}
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}

	//获取锁屏详情(包含班级年级信息)
	public function getDetail($lockid = 0){
		$ret = array();
		$sql = 'select s.lockid,s.title,s.startdate,s.enddate from ebh_slock s where s.lockid = '.$lockid.' limit 1';
		$slock = $this->db->query($sql)->row_array();
		if(empty($slock)){
			return $ret;
		}
		$ret['slock'] = $slock;
		$ret['flag'] = 1; //默认按年级
		//获取班级关联信息
		$sql = 'select cs.classid,cs.grade,cs.district from ebh_classslock cs where cs.lockid = '.$lockid;
		$classes = $this->db->query($sql)->list_array();
		if( !empty($classes) && ($classes[0]['classid'] > 0) ){
			$ret['flag'] = 0; //按班级锁屏
		}
		$ret['classes'] = $classes;
		return $ret;
	}

	//获取锁屏详情(不包含班级年级信息)
	public function getSimpleDetail($lockid = 0){
		$sql = 'select s.lockid,s.title,s.startdate,s.enddate,s.uid from ebh_slock s where s.lockid = '.$lockid.' limit 1';
		return $this->db->query($sql)->row_array();
	}

	//获取当前时间到当天结束之间的锁屏记录
	public function getTodayList($param = array()){
		$todaystart = strtotime(date('Y-m-d',SYSTIME));
		$param['startdate'] = $todaystart;
		$param['enddate'] = $todaystart+86400;
		return $this->getList($param);
	}

	//获取锁屏对象
	public function getLockTarget($lockids = array()){
		$ret = array();
		if(empty($lockids)){
			return $ret;
		}
		$sql = 'select cs.lockid,cs.classid,cs.grade,cs.district from ebh_classslock cs where cs.lockid in ('.implode(',', $lockids).')';
		$targetlist = $this->db->query($sql)->list_array();
		if(empty($targetlist)){
			return $ret;
		}
		$classids = $this->_getFieldArr($targetlist,'classid');
		$sql_for_classes = 'select classid,classname from ebh_classes where classid in ('.implode(',', $classids).')';
		$classes = $this->db->query($sql_for_classes)->list_array();
		$classes = $this->_modifyKeys($classes,'c','classid');
		$grademap = Ebh::app()->getConfig()->load('grademap');

		foreach ($targetlist as $target) {
			$key = 'lockid_'.$target['lockid'];
			if(!array_key_exists($key, $ret)){
				$ret[$key] = array();
			}
			if($target['classid'] > 0){
				$ckey = 'c_'.$target['classid'];
				if(array_key_exists($ckey, $classes)){
					$ret[$key][] = $classes[$ckey]['classname'];
				}
			}else{
				if(array_key_exists($target['grade'], $grademap)){
					$ret[$key][] = $grademap[$target['grade']];
				}
			}
		}
		return $ret;
	}

	/**
	 *获取二维数组指定的字段集合
	 */
	private function _getFieldArr($param = array(),$filedName=''){
		
		$reuturnArr = array();

		if(empty($filedName)||empty($param)){
			return $reuturnArr;
		}

		foreach ($param as $value) {
			array_push($reuturnArr, $value[$filedName]);
		}

		return array_unique($reuturnArr);
	}

	/**
	 *将索引数组变成关联数组
	 */
	private function _modifyKeys($objs = array(),$prefix = 'p',$filedName = ''){
		$returnArr = array();
		foreach ($objs as $obj) {
			$key = $prefix.'_'.$obj[$filedName];
			$returnArr[$key] = $obj;
		}
		return $returnArr;
	}

	//获取有效锁屏列表
	public function getValidSlockList($param = array()){
		$param['enddate'] = SYSTIME;
		$param['valide'] = true;
		$param['limit'] = 10000;
		return $this->getList($param);
	}
}
?>