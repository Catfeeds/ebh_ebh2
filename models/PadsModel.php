<?php
/**
 *广告表模型
 */
class padsModel extends CPortalModel{
	/**
	 *根据参数获取广告列表
	 *@param array $param
	 *@return array
	 */
	public function getList($param = array()){
		$sql = 'select a.*,c.name as catename,c.upid as cateupid,t.name as typename from ebh_pads a left join ebh_pcategories c on a.catid = c.catid left join ebh_padstypes t on a.tid = t.tid ';
		$whereArr = array();
		if(!empty($param['catid'])){
			$whereArr[] = 'a.catid = '.intval($param['catid']);
		}
		if(!empty($param['in_catid'])){
			$whereArr[] = 'a.catid in ('.implode(',',$param['in_catid']).')';
		}
		if(!empty($param['in_tid'])){
			$whereArr[] = 'a.tid in ('.implode(',',$param['in_tid']).')';
		}
		if(!empty($param['status'])){
			$whereArr[] = 'a.status ='.intval($param['status']);
		}
		if(!empty($param['begintime1'])){
			$whereArr[] = 'a.begintime >'.strtotime($param['begintime1']);
		}
		if(!empty($param['begintime2'])){
			$whereArr[] = 'a.begintime <'.strtotime($param['begintime2']);
		}
		if(!empty($param['endtime1'])){
			$whereArr[] = 'a.endtime >'.strtotime($param['endtime1']);
		}
		if(!empty($param['endtime2'])){
			$whereArr[] = 'a.endtime <'.strtotime($param['endtime2']);
		}
		if(!empty($param['q'])){
			$whereArr[] = 'a.subject like \'%'.$this->portaldb->escape_str($param['q']).'%\'';
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		if(!empty($param['order'])){
			$sql.=' order by '.$this->portaldb->escape_str($param['order']);
		}else{
			$sql.=' order by a.lastpost desc,a.dateline desc';
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}
		return $this->portaldb->query($sql)->list_array();
	}
	/**
	 *获取符合条件的广告条数
	 *@param array $param
	 *@return int
	 */
	public function getListCount($param = array()){
		$sql = 'select count(*) count from ebh_pads a';
		$whereArr = array();
		if(!empty($param['catid'])){
			$whereArr[] = 'a.catid = '.intval($param['catid']);
		}
		if(!empty($param['in_catid'])){
			$whereArr[] = 'a.catid in ('.implode(',',$param['in_catid']).')';
		}
		if(!empty($param['in_tid'])){
			$whereArr[] = 'a.tid in ('.implode(',',$param['in_tid']).')';
		}
		if(!empty($param['status'])){
			$whereArr[] = 'a.status ='.intval($param['status']);
		}
		if(!empty($param['begintime1'])){
			$whereArr[] = 'a.begintime >'.strtotime($param['begintime1']);
		}
		if(!empty($param['begintime2'])){
			$whereArr[] = 'a.begintime <'.strtotime($param['begintime2']);
		}
		if(!empty($param['endtime1'])){
			$whereArr[] = 'a.endtime >'.strtotime($param['endtime1']);
		}
		if(!empty($param['endtime2'])){
			$whereArr[] = 'a.endtime <'.strtotime($param['endtime2']);
		}
		if(!empty($param['q'])){
			$whereArr[] = 'a.subject like \'%'.$this->portaldb->escape_str($param['q']).'%\'';
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		$res = $this->portaldb->query($sql)->row_array();
		return $res['count'];
	}
	/**
	 *新增一条数据
	 *@param array $param
	 *@return int 影响的行数
	 */
	public function _insert($param = array()){
		if(empty($param)){
			return 0;
		}
		$param = $this->portaldb->escape_str($param);
		return $this->portaldb->insert('ebh_pads',$param);
	}
	/**
	 *修改一条数据
	 *@param array $param
	 *@return int 影响的行数
	 */
	public function _update($param = array(),$where){
		if(empty($param)||empty($where)){
			return 0;
		}
		$param = $this->portaldb->escape_str($param);
		$where = $this->portaldb->escape_str($where);
		return $this->portaldb->update('ebh_pads',$param,$where);
	}
	/**
	 *获取一条数据
	 *@param int $aid
	 *@return array
	 */
	public function getOneByaid($aid = 0){
		$sql = 'select a.* from ebh_pads a where a.aid='.intval($aid).' limit 1';
		return $this->portaldb->query($sql)->row_array();
	}
	/**
	 *删除一条数据
	 *@param int $aid 或者 array $aid
	 *@return int 影响的行数
	 */
	public function _delete($aid){
		if(empty($aid)){
			return 0;
		}
		if(is_numeric($aid)){
			$where = array('aid'=>$aid);
		}else{
			$where = ' aid in '.$aid;
		}
		
		return $this->portaldb->delete('ebh_pads',$where);
	}
	/**
	 *执行一条sql语句
	 *@param array $param
	 *@return int 成功返回1失败返回0
	 */
	public function _query($sql){
		return $this->portaldb->query($sql)?1:0;
	}

	/**
	 *获取指定顶级分类下面的广告
	 *先获取该分类下面的广告,不存在则获取父级广告,还不存在则获取首页通用广告
	 */
	public function getCateAds($catid,$code,$num=6,$upid){
		if(intval($catid) <= 0 || empty($code)) {
			return FALSE;
		}
		$res = array();
		$sql = 'select a.* from ebh_pads a 
				left join ebh_padstypes t 
				on a.tid = t.tid where a.status=1 AND t.code = \''.$this->portaldb->escape_str($code).'\' AND a.catid = '.$catid.
				' order by a.displayorder,a.dateline desc limit '.$num;
		$res = $this->portaldb->query($sql)->list_array();
		if(empty($res)){
			$sql = 'select a.* from ebh_pads a 
				left join ebh_padstypes t 
				on a.tid = t.tid where a.status=1 AND  a.catid ='.intval($upid).' AND t.code = \''.$this->portaldb->escape_str($code).'\' '.
				' order by a.displayorder,a.dateline desc limit '.$num;
				$res =  $this->portaldb->query($sql)->list_array();
				if(empty($res)){
					$sql = 'select a.* from ebh_pads a 
						left join ebh_padstypes t 
						on a.tid = t.tid where a.status=1 AND  a.catid = 45 AND t.code = \''.$this->portaldb->escape_str($code).'\' '.
						' order by a.displayorder,a.dateline desc  limit '.$num;
						$res =  $this->portaldb->query($sql)->list_array();
				}
		}
		return $res;
	}

	/**
	 *根据标志获取对应的广告
	 */
	public function getAdsByCode($code,$num=1){
		$sql = 'select * from ebh_pads a left join ebh_padstypes at on a.tid = at.tid where at.code = \''.$this->portaldb->escape_str($code).'\'  order by a.displayorder asc limit '.$num;
		return $this->portaldb->query($sql)->list_array();
	}

	public function addviewnum($aid, $num = 1) {
        $where = 'aid=' . $aid;
        $setarr = array('viewnum' => 'viewnum+' . $num);
        $this->portaldb->update('ebh_pads', array(), $where, $setarr);
    }
	
	public function setviewnum($aid, $num = 1) {
		$where = 'aid=' . $aid;
        $setarr = array('viewnum' => $num);
        $this->portaldb->update('ebh_pads', array(), $where, $setarr);
	}

	//获取广告，处理分页
	public function getAds($param = array(),$fields = ""){
		if(empty($fields)){
			$fields = ' pa.subject,pa.thumb,pa.linkurl ';
		}
		$sql = 'select '.$fields.' from ebh_padstypes pat join ebh_pads pa on pat.tid = pa.tid';
		$wherearr = array();
		if(!empty($param['code'])){
			$wherearr[] = 'pat.code = \''.$this->portaldb->escape_str($param['code']).'\'';
		}
		if(!empty($param['status'])){
			$wherearr[] = 'pa.status = '.$this->portaldb->escape_str($param['status']);
		}		
		if(!empty($param['visible'])){
			$wherearr[] = 'pa.visible = '.$this->portaldb->escape_str($param['visible']);
		}		
		if(!empty($param['system'])){
			$wherearr[] = 'pa.system = '.$this->portaldb->escape_str($param['system']);
		}
		if (!empty($wherearr))
            $sql .= ' WHERE ' . implode(' AND ', $wherearr);
		if (!empty($param['order']))
            $sql .= ' ORDER BY ' . $param['order'];
        else
            $sql .= ' ORDER BY pa.displayorder ASC ';
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
        return $this->portaldb->query($sql)->list_array();
	}
	//获取广告条数
	public function getAdsCount($param = array()){
		$sql = 'select count(1) count from ebh_padstypes pat join ebh_pads pa on pat.tid = pa.tid';
		$wherearr = array();
		if(!empty($param['code'])){
			$wherearr[] = 'pat.code = \''.$this->portaldb->escape_str($param['code']).'\'';
		}
		if(!empty($param['status'])){
			$wherearr[] = 'pa.status = '.$this->portaldb->escape_str($param['status']);
		}		
		if(!empty($param['visible'])){
			$wherearr[] = 'pa.visible = '.$this->portaldb->escape_str($param['visible']);
		}		
		if(!empty($param['system'])){
			$wherearr[] = 'pa.system = '.$this->portaldb->escape_str($param['system']);
		}
        $res = $this->portaldb->query($sql)->row_array();
        return $res['count'];
	}
}