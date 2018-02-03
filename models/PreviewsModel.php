<?php
/**
 *评论表模型
 *
 */
class PreviewsModel extends CPortalModel{
	public function getList($param = array()){
		$sql = 'select r.*,i.subject as isubject,i.itemid from ebh_previews r left join ebh_pitems i on r.itemid = i.itemid';
		$whereArr = array();
		if(!empty($param['itemid']))
			$whereArr[] = 'r.itemid='.intval($param['itemid']);
		if(!empty($param['q'])){
			$whereArr[] = '(r.subject like \'%'.$this->portaldb->escape_str($param['q']).'%\' or i.subject like \'%'.$this->portaldb->escape_str($param['q']).'%\')';
		}
		if(!empty($param['status'])){
			$whereArr[] = 'r.status ='.$param['status'];
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		if(empty($param['order'])){
			$sql.= ' order by r.dateline desc,r.reviewid desc ';
		}else{
			$sql.= ' order by '.$this->portaldb->escape_str($param['order']);
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}else{
			$sql.=' limit 20';
		}


		return $this->portaldb->query($sql)->list_array();
	}

	public function getListCount($param = array()){
		$sql = 'select count(*) count from ebh_previews r left join ebh_pitems i on r.itemid = i.itemid ';
		$whereArr = array();
		if(!empty($param['itemid']))
			$whereArr[] = 'r.itemid='.intval($param['itemid']);
		
		if(!empty($param['q'])){
			$whereArr[] = '(r.subject like \'%'.$this->portaldb->escape_str($param['q']).'%\' or i.subject like \'%'.$this->portaldb->escape_str($param['q']).'%\')';
		}
		if(!empty($param['status'])){
			$whereArr[] = 'r.status ='.$param['status'];
		}
		if(!empty($whereArr)){
			$sql.=' WHERE '.implode(' AND ',$whereArr);
		}
		$res = $this->portaldb->query($sql)->row_array();
		return $res['count'];
	}

	public function _delete($reviewid){
		if(empty($reviewid)){
			return 0;
		}
		if(is_numeric($reviewid)){
			$where = array('reviewid'=>$reviewid);
		}else{
			$where = ' reviewid in '.$reviewid;
		}
		
		return $this->portaldb->delete('ebh_previews',$where);
	}
	public function _update($param = array(),$where){
		if(empty($param)||empty($where)){
			return 0;
		}
		$param = $this->portaldb->escape_str($param);
		$where = $this->portaldb->escape_str($where);
		return $this->portaldb->update('ebh_previews',$param,$where);
	}
	/**
	 *新增一条数据
	 *
	 */
	public function _insert($param = array()){
		if(empty($param)){
			return 0;
		}
		$param = $this->portaldb->escape_str($param);
		return $this->portaldb->insert('ebh_previews',$param);
	}
	/**
	 *根据itemid删除评论
	 */
	public function deleteReviewByItemid($itemid = 0){
		if(empty($itemid)){
			return 0;
		}
		if(is_numeric($itemid)){
			$where = array('itemid'=>$itemid);
		}else{
			$where = ' itemid in '.$itemid;
		}
		
		return $this->portaldb->delete('ebh_previews',$where);
	}
}