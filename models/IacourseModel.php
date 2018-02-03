<?php
/**
 *互动课堂模型
 */
class IacourseModel extends CModel{
	/**
	 * 添加互动记录
	 */
	public function add($param){
		if(empty($param)){
			return false;
		}
		$setarr = array();
		if(!empty($param['title'])){
			$setarr['title'] = $param['title'];
			$setarr['titlenotag'] = strip_tags($param['title']);
		}
		if(!empty($param['crid'])){
			$setarr['crid'] = $param['crid'];
		}
		if(!empty($param['uid'])){
			$setarr['uid'] = $param['uid'];
		}
		if(!empty($param['folderids'])){
			$setarr['folderids'] = $param['folderids'];
		}
		if(!empty($param['foldernames'])){
			$setarr['foldernames'] = $param['foldernames'];
		}
		if(!empty($param['editdateline'])){
			$setarr['editdateline'] = $param['editdateline'];
		}
		if(!empty($param['questioncount'])){
			$setarr['questioncount'] = $param['questioncount'];
		}
		return $this->db->insert('ebh_ics',$setarr);
	}
	/**
	 * 添加互动和课程之间的关系
	 */
	public function addIcFolders($icid,$folderids){
		if(empty($icid) || empty($folderids)){
			return false;
		}
		$sql = 'insert into ebh_icfolders (icid,folderid) values ';
		foreach ($folderids as $folderid) {
			$sql.= '(';
			$sql.= $icid.',';
			$sql.= $folderid;
			$sql.= '),';
		}
		$sql = trim($sql,',');
		return $this->db->query($sql,false);
	}
	/**
	 * 获取互动列表
	 */
	public function geticList($param){
		if(empty($param['uid']) || empty($param['crid'])){
			return false;
		}
		$sql = 'select icid,title,answercount,questioncount,dateline,foldernames,folderids,editdateline,status from `ebh_ics` where uid ='.intval($param['uid']).' and crid ='.intval($param['crid']);
		if(!empty($param['q'])){
			$sql.= ' and titlenotag like \'%'.$param['q'].'%\'';
		}
		$sql.= ' order by icid desc';
		
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
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
	//根据icid获取互动详情
	public function geticInfo($icid){
		if(empty($icid)){
			return false;
		}
		$sql = 'select title,questioncount,folderids,foldernames,answercount,totaltime from `ebh_ics` where icid ='.intval($icid);
		return $this->db->query($sql)->row_array();
	}
	//更新互动title
	public function updateIacouse($param,$icid){
		if(empty($param) || empty($icid)){
			return false;
		}
		$setarr = array();
		if(!empty($param['title'])){
			$setarr['title'] = $param['title'];
			$setarr['titlenotag'] = strip_tags($param['title']);
		}
		if(!empty($param['folderids'])){
			$setarr['folderids'] = $param['folderids'];
		}
		if(!empty($param['foldernames'])){
			$setarr['foldernames'] = $param['foldernames'];
		}
		if(!empty($param['editdateline'])){
			$setarr['editdateline'] = $param['editdateline'];
		}
		if(!empty($param['questioncount'])){
			$setarr['questioncount'] = $param['questioncount'];
		}
		return $this->db->update('ebh_ics',$setarr,array('icid'=>intval($icid)));
	}
	//获取互动列表数量
	public function geticListCount($param){
		if(empty($param['uid']) || empty($param['crid'])){
			return false;
		}
		$sql = 'select count(*) as count from `ebh_ics` where uid ='.intval($param['uid']).' and crid ='.intval($param['crid']);
		if(!empty($param['q'])){
			$sql.= ' and titlenotag like \'%'.$param['q'].'%\'';
		}
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	//发布操作
	public function publish($icid,$uid){
		if(empty($icid) || empty($uid)){
			return false;
		}
		return $this->db->update('ebh_ics',array('status'=>1,'dateline'=>SYSTIME),array('icid'=>$icid,'uid'=>$uid));
	}
	//删除操作
	public function del($icid,$uid){
		if(empty($icid) || empty($uid)){
			return false;
		}
		return $this->db->delete('ebh_ics',array('icid'=>$icid,'uid'=>$uid));
	}
	//检验互动是否存在
    public function checkexist($icid){
    	if(empty($icid)){
    		return false;
    	}
    	$sql = 'select icid from `ebh_ics` where icid ='.intval($icid);
    	return $this->db->query($sql)->row_array();
    }
}