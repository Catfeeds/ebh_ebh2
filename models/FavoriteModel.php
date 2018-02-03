<?php
/**
 * 收藏相关model类 FavoriteModel
 */
class FavoriteModel extends CModel{
	/**
	*添加收藏
	*/
	public function insert($param) {
		$setarr = array ();
		if(!empty($param ['uid'])){
			$setarr['uid'] = intval($param['uid']);
		}
		if(!empty($param ['crid'])){
			$setarr['crid'] = intval($param['crid']);
		}
		if(!empty($param ['cwid'])){
			$setarr['cwid'] = intval($param['cwid']);
		}
		if(!empty($param ['folderid'])){
			$setarr['folderid'] = intval($param['folderid']);
		}
		$setarr['dateline'] = SYSTIME;

		if(!empty($param ['type'])){
			$setarr['type'] = intval($param['type']);
		}
		if(!empty($param ['url'])){
			$setarr['url'] = $param['url'];
		}
		if(!empty($param ['title'])){
			$setarr['title'] = $param['title'];
		}
		if(!empty($param ['displayorder'])){
			$setarr['displayorder'] = intval($param['displayorder']);
		}
		$fid = $this->db->insert('ebh_favorites',$setarr);
		return $fid;
	}
	/**
	*删除收藏
	*/
	public function delete($fid){
		$wherearr = array('fid'=>$fid);
		return $this->db->delete('ebh_favorites',$wherearr);

	}
	/**
	*根据uid和fid删除收藏
	*/
	public function deleteByUid($uid,$fid){
		$wherearr = array('uid'=>$uid,'fid'=>$fid);
		return $this->db->delete('ebh_favorites',$wherearr);

	}
	/**
	*根据crid,uid和type删除收藏
	*/
	public function deleteByCrid($param){
		if(empty($param['crid']) || empty($param['uid']))
			return FALSE;
		$wherearr = array('crid'=>$param['crid'],'uid'=>$param['uid']);
		if(!empty($param['type']))
			$wherearr['type'] = $param['type'];
		return $this->db->delete('ebh_favorites',$wherearr);

	}
	/**
	*获取学员课件收藏列表
	*/
	public function getcoursefavoritelist($param) {
		if(empty($param['uid']))
			return FALSE;
		$sql = 'SELECT f.fid,f.dateline,c.cwid,c.title,c.status,c.cwurl,c.ism3u8,c.logo,c.uid,c.islive,c.reviewnum,c.summary,c.submitat,c.endat,c.truedateline,c.dateline cwdateline,c.cwlength
		from ebh_favorites f '.
				'JOIN ebh_coursewares c on (f.cwid = c.cwid) ';
		$wherearr = array();
		$wherearr[] = 'f.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'f.crid='.$param['crid'];
		if(!empty($param['cwid']))
			$wherearr[] = 'f.cwid='.$param['cwid'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
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
	/**
	*获取学员课件收藏列表记录数
	*/
	public function getcoursefavoritelistcount($param) {
		$count = 0;
		if(empty($param['uid']))
			return $count;
		$sql = 'SELECT count(*) count from ebh_favorites f '.
				'JOIN ebh_coursewares c on (f.cwid = c.cwid) ';
		$wherearr = array();
		$wherearr[] = 'f.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'f.crid='.$param['crid'];
		if(!empty($param['cwid']))
			$wherearr[] = 'f.cwid='.$param['cwid'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
	/**
	*获取学员课程收藏列表
	*/
	public function getfolderfavoritelist($param) {
		if(empty($param['uid']))
			return FALSE;
		$sql = 'SELECT f.fid,f.dateline,f.folderid,fo.foldername,fo.img from ebh_favorites f '.
				'JOIN ebh_folders fo on (f.folderid = fo.folderid) ';
		$wherearr = array();
		$wherearr[] = 'f.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'f.crid='.$param['crid'];
		if(!empty($param['folderid']))
			$wherearr[] = 'f.folderid='.$param['folderid'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else {
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
	/**
	*获取学员课程收藏列表记录数
	*/
	public function getfolderfavoritelistcount($param) {
		$count = 0;
		if(empty($param['uid']))
			return $count;
		$sql = 'SELECT count(*) count from ebh_favorites f '.
				'JOIN ebh_folders fo on (f.folderid = fo.folderid) ';
		$wherearr = array();
		$wherearr[] = 'f.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'f.crid='.$param['crid'];
		if(!empty($param['folderid']))
			$wherearr[] = 'f.folderid='.$param['folderid'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
}
