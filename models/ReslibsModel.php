<?php
/**
 *精品题库类
*/
class ReslibsModel extends CModel{
	//2015-04-20 新增添加题库insert start
	public function insert($param = array()) {
		if(empty($param['gid']))
			return FALSE;
        $setarr = array();
        if (!empty($param['gid']))
            $setarr['gid'] = $param['gid'];
        if (!empty($param['libname']))
            $setarr['libname'] = $param['libname'];
        if (!empty($param['viewnum']))
            $setarr['viewnum'] = $param['viewnum'];
        if (!empty($param['downnum']))
            $setarr['downnum'] = $param['downnum'];
        if (!empty($param['libpath']))
            $setarr['libpath'] = $param['libpath'];
        if (!empty($param['libsize']))
            $setarr['libsize'] = $param['libsize'];
        if (!empty($param['summary']))
            $setarr['summary'] = $param['summary'];
		if (!empty($param['previewtype']))
            $setarr['previewtype'] = $param['previewtype'];
		if (!empty($param['dateline']))
            $setarr['dateline'] = $param['dateline'];
		else
			$setarr['dateline'] = SYSTIME;
        $lid = $this->db->insert('ebh_reslibs', $setarr);
        return $lid;
    }
	//2015-04-20 新增添加题库insert end
	/**
	 *根据条件获取题库列表
	*/
	public function getList($param = array()){
		$sql = 'select r.*,rs.groupname from ebh_resgroups rs join ebh_reslibs r on r.gid = rs.gid ';
		$pageNumber = $param['page'];
		$offsetNumber = max(0,($pageNumber-1)*$param['pagesize']);
		$param['limit'] = $offsetNumber.','.$param['pagesize'];
		$param = $this->db->escape_str($param);
		$whereArr = array();
		if(!empty($param['gid'])){
			$whereArr[] = 'r.gid ='.$param['gid'];
		}
		if(!empty($param['grade'])){
			$whereArr[] = 'rs.grade ='.$param['grade'];
		}
		if(!empty($param['q'])){
			$whereArr[] = 'r.libname like"%'.$param['q'].'%"';
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		if(!empty($param['order'])) {
			$sql.=' order by '.$param['order'];
		}
		if(empty($param['limit'])){
			$sql.=' limit 20 ';
		}else{
			$sql.=' limit '.$param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	 *根据条件获取符合条件的题库的条数
	**/
	public function getListCount($param=array()){
		$sql = 'select count(*) count from ebh_resgroups rs join ebh_reslibs r on r.gid = rs.gid ';
		$param = $this->db->escape_str($param);
		$whereArr = array();
		if(!empty($param['gid'])){
			$whereArr[] = 'r.gid ='.$param['gid'];
		}
		if(!empty($param['grade'])){
			$whereArr[] = 'rs.grade ='.$param['grade'];
		}
		if(!empty($param['q'])){
			$whereArr[] = 'r.libname like"%'.$param['q'].'%"';
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}
	/**
	 *获取每个gid下面的试卷的个数
	 *@param null
	 *@return $param
	*/
	public function getEveCountGroupByGid(){
		$sql = 'select rs.gid,count(r.gid) count from ebh_resgroups rs left join ebh_reslibs r on rs.gid=r.gid group by gid';
		$res = $this->db->query($sql)->list_array();
		$eCount = array();
		foreach ($res as $ev) {
			$eCount[$ev['gid']] = $ev['count'];
		}
		return $eCount;
	}
	/**
	 *获取附件的信息
	 *@param int $lid
	 *@return array
	*/
	public function getAttchByLid($lid){
		$sql = 'select lid,libname,libpath,previewtype from ebh_reslibs where lid='.$lid.' limit 1';
		return  $this->db->query($sql)->row_array();
	}
	/**
	 *
	 *0表示浏览数和下载数加1,1表示下载数+1,-1表示浏览数+1
	*/
	public function _refresh($lid,$type=0){
		if($type==0){
			$sql = 'update  ebh_reslibs set viewnum = viewnum+1,downnum = downnum+1  where lid='.intval($lid);
		}elseif($type==-1){
			$sql = 'update  ebh_reslibs set viewnum = viewnum+1  where lid='.intval($lid);
		}elseif($type==1){
			$sql = 'update  ebh_reslibs set downnum = downnum+1  where lid='.intval($lid);
		}
		$res = $this->db->query($sql);
		if(empty($res)){
			return false;
		}else{
			return true;
		}
		
	}

	/**
	 *获取题库名称和题库试卷总数
	 *@return array(array('小学题库',4432),array('初中题库',33322),array('高中题库',3333));
	 *
	 */
	public function getPaperCountGroupByGrade(){
		$sql = 'select concat(left(rg.groupname,2),\'题库\') tkname,count(*) count from ebh_resgroups rg left join ebh_reslibs rl on rg.gid = rl.gid group by rg.grade';
		return $this->db->query($sql)->list_array();
	}
}
?>