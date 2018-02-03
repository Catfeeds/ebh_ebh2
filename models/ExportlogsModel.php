<?php
/**
 *提供逻辑相对复杂的统计信息查询的DAO
 *执行指定的方法(例如courseware()方法)返回该模型的实例，再调用该实例的getResult()方法获取数据列表和数据条数
 *目前实现了教师课件信息查询
 *zkq
 */
class ExportlogsModel extends CModel{
	public function __construct(){
		parent::__construct();
		set_time_limit(0);
		$this->rList = array();
		$this->rCount = 0;//
	}

/*******************************教师课件统计记录开始*******************************/
	/**
	 *获取教师在课件上传和点击量的记录
	 *@param $param $param = array('crid'=>10440,'starttime'=>3333333,'endtime'=>444444);
	 */
	public function courseware($param = array()){
		$this->_data_export = array();
		$this->param = $param;
		$this->gradelist = Ebh::app()->getConfig()->load('grademap');
		$this->viewLib = Ebh::app()->lib('Viewnum');
		$this->gradelist[0] = "未知年级";
		$this->_init_for_courseware();
		$this->_run_for_courseware();
		$this->rList = $this->_data_export;
		return $this;
	}

	private function _init_for_courseware(){
		$param = $this->param;
		$this->crid = $param['crid'];
		$this->classid = !empty($param['classid'])?$param['classid']:0;
		$this->starttime = !empty($param['starttime'])?$param['starttime']:0;
		$this->endtime = !empty($param['endtime'])?$param['endtime']:0;
	}

	private function _run_for_courseware(){
		$this->_getCwList();//获取课件列表
		if(empty($this->cwlist)){
			return $this;
		}
//		$this->_updateCwTime();//升级课件时间
		$this->_getFolderInfo();//提取课程信息
		$this->_getUserInfo();//提取教师信息
		$this->_combineData();//合并数据
		// $this->_export();//数据导出
	}

	private function _getCwList(){
		$param = $this->param;
		
		$sql = 'select cw.uid,cw.cwid,cw.title,cw.cwlength,cw.dateline,cw.viewnum,cw.cwurl,rc.folderid from ebh_coursewares  cw join ebh_roomcourses rc on cw.cwid = rc.cwid ';
		
		$sql_for_count  = 'select count(cw.cwid) count from ebh_coursewares  cw join ebh_roomcourses rc on cw.cwid = rc.cwid ';

		$whereArr = array();
		if(!empty($param['crid'])){
			$whereArr[] = 'rc.crid = '.$param['crid'];
		}
		if(!empty($param['classid'])){
			$tids = $this->_getTidList();
			if(!empty($tids)){
				$whereArr[] = 'cw.uid in ('.implode(',', $tids).')';
			}
		}
		if(!isset($param['status'])){
			$whereArr[] = 'cw.status = 1';
		}else{
			$whereArr[] = 'cw.status = '.$param['status'];
		}
		if(!empty($param['starttime'])){
			$whereArr[] = 'cw.dateline >='.$param['starttime'];
		}
		if(!empty($param['endtime'])){
			$whereArr[] = 'cw.dateline <='.$param['endtime'];
		}
		if(!empty($whereArr)){
			$where_str = ' WHERE '.implode(' AND ', $whereArr);
			$sql .= $where_str;
			$sql_for_count .= $where_str;
		}
		$sql .= ' order by cw.uid,rc.folderid,cw.cwid desc';
		if(!empty($param['limit'])){
			$sql.= ' limit '.$param['limit'];
		}else{
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$cwlist = $this->db->query($sql)->list_array();
		$cwCount = $this->db->query($sql_for_count)->row_array();
		$this->cwlist = $cwlist;
		$this->rCount = $cwCount['count'];
	}

	private function _updateCwTime(){
		$viewLib = $this->viewLib;
		//获取所有的课件的cwid
		$cwids = $this->_getFieldArr($this->cwlist,'cwid');
		if(empty($cwids)){
			log_message("没有待升级的课件");
			return;
		}
		//从课件记录里面获取指定的cwid的记录
		$sql = 'select distinct(p.cwid),p.ctime from ebh_playlogs p where p.cwid in ('.implode(',', $cwids).')';
		$loglist = $this->db->query($sql)->list_array();
		$loglist = $this->_modifyKeys($loglist,'cwid','log');
		$this->loglist = $loglist;
		$new_cwlist = array();
		$when_then = array();
		$cwids_where_when_then = array();
		foreach ($this->cwlist as $cw) {
			$key = 'log_'.$cw['cwid'];
			if(array_key_exists($key, $loglist)){
				if($cw['cwlength'] != $loglist[$key]['ctime']){
					$cwlength = $loglist[$key]['ctime'];
					$cw['cwlength'] = $cwlength;
					$when_then[] = ' WHEN cwid ='.$cw['cwid'].' THEN '.$cwlength;
					$cwids_where_when_then[] = $cw['cwid'];
				}
			}else{
				//记录么有被播放的课件
				if(empty($cw['cwlength'])){
					$cw['cwlength'] = 0;
				}
			}
			$ext = $this->_getFileExt($cw['cwurl']);
			$cw['title'] = $cw['title'].$ext;
			$viewnum_cache = $viewLib->getViewnum('courseware',$cw['cwid']);
			if(!empty($viewnum_cache)){
				$cw['viewnum'] = $viewnum_cache;
			}
			$new_cwlist[] = $cw;
		}
		$this->cwlist = $new_cwlist;
		if(empty($when_then)){
			//么有要升级课件
			return;
		}
		$sql = 'UPDATE ebh_coursewares SET cwlength = (CASE '.implode(' ', $when_then).' END ) WHERE cwid in ('.implode(',', $cwids_where_when_then).')';
		$result = $this->db->query($sql);
		if(empty($result)){
			log_message("数据库课件升级时间失败,脚本退出执行");
			//数据库执行失败
			exit();
		}
		$affected_rows = $this->db->affected_rows();
		log_message("数据库课件时间更新条数:".$affected_rows);
	}

	//根据folderid数组获取课程信息
	private function _getFolderInfo(){
		$folderidArr = $this->_getFieldArr($this->cwlist,'folderid');
		if(empty($folderidArr)){
			$this->folderlist = array();
			return;
		}
		$sql = 'select folderid,foldername,grade from ebh_folders where folderid in ('.implode(',', $folderidArr).')';
		$res = $this->db->query($sql)->list_array();
		$folderlist = $this->_modifyKeys($res,'folderid','fid');
		$this->folderlist = $folderlist;
	}

	//根据classid获取教师uid数组
	private function _getTidList(){
		$ret = array();
		if(!empty($this->classid)){
			$sql = 'SELECT uid from ebh_classteachers ct where ct.classid ='.$this->classid;
		}
		$tidList = $this->db->query($sql)->list_array();
		if(!empty($tidList)){
			$ret = $this->_getFieldArr($tidList,'uid');
		}
		return $ret;
	}

	//根据uid数组获取用户信息
	private function _getUserInfo(){
		$uidArr = $this->_getFieldArr($this->cwlist,'uid');
		if(empty($uidArr)){
			$this->userlist = array();
			return;
		}
		$sql = 'select uid,username,realname from ebh_users where uid in ('.implode(',', $uidArr).')';
		$res = $this->db->query($sql)->list_array();
		$userlist = $this->_modifyKeys($res,'uid','uid');
		$this->userlist = $userlist;
	}
	//组合导出数据
	private function _combineData(){
		$data_export = array();
		$folderlist = $this->folderlist;
		$cwlist = $this->cwlist;
		$userlist = $this->userlist;
		$gradelist = $this->gradelist;
		foreach ($cwlist as $cw) {
			$fkey = 'fid_'.$cw['folderid'];
			$ukey = 'uid_'.$cw['uid'];
			if(array_key_exists($fkey, $folderlist)){
				$cw['foldername'] = $folderlist[$fkey]['foldername'];
				$grade = intval($folderlist[$fkey]['grade']);
				$cw['gradename']  = !empty($gradelist[$grade])?$gradelist[$grade]:"未知年级";
				$cw['grade'] = $grade;
			}else{
				$cw['foldername'] = "未知课程";
				$cw['gradename']  = "未知年级";
				$cw['grade'] = 0;
			}
			$cw['foldername'] = array_key_exists($fkey, $folderlist)?$folderlist[$fkey]['foldername']:"未知课程";
			if(array_key_exists($ukey, $userlist)){
				$cw['name'] = empty($userlist[$ukey]['realname'])?$userlist[$ukey]['username']:$userlist[$ukey]['realname'];
				$cw['username'] = $userlist[$ukey]['username'];
			}else{
				$cw['name'] = "未知老师";
				$cw['username'] = "userx";
			}
			$data_export[]= $cw;
		}
		$this->_data_export = $this->_sortList($data_export);
	}

	//按年级格式化数据
	private function _sortList($data_export = array()){
		$returnArr = array();
		$restmp = array();
		foreach ($data_export as $data) {
			$key = 'g_'.$data['grade'];
			if(!array_key_exists($key, $restmp)){
				$restmp[$key] = array();
			}
			$restmp[$key][] = $data;
		}
		ksort($restmp);
		foreach ($restmp as $res) {
			$returnArr = array_merge($returnArr,$res);
		}
		return $returnArr;
	}

/*************************教师课件统计记录结束*******************************/

/*************************模型工具开始*******************************/
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
	private function _modifyKeys($objs = array(),$fieldName,$prefix){
		if(empty($objs) || empty($fieldName) || empty($prefix)){
			// var_export("转换数据不对");
			return array();
		}
		$returnArr = array();
		foreach ($objs as $obj) {
			$key = $prefix.'_'.$obj[$fieldName];
			$returnArr[$key] = $obj;
		}
		return $returnArr;
	}

	/**
     * 获取文件扩展名
     * @return string
     */
    private function _getFileExt($url){
        return '.'.substr($url, strrpos($url,'.')+1);
    }
/*************************模型工具结束*******************************/

/*************************模型结果集对外接口开始*******************************/
	public function getResult(){
		$ret = array(
			'data'=>$this->rList,
			'count'=>$this->rCount
		);
		return $ret;
	}
/*************************模型结果集对外接口结束*******************************/
}