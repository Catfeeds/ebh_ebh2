<?php
/*
精品课程项目
*/
class BestitemModel extends CModel{
	/**
	*精品课程项目列表
	*/
	public function getItemList($param) {
		$sql = 'select i.itemid,i.folderid,i.iname,i.isummary,i.iprice,i.dateline,i.providercrid,i.comfee,i.roomfee,i.providerfee,i.isyouhui,i.iprice_yh,i.comfee_yh,i.roomfee_yh,i.providerfee_yh,i.labelids,i.iday,i.imonth,i.cannotpay,i.ssid,i.longblockimg,r.crname,r.domain,f.viewnum,f.coursewarenum from ebh_best_items i left join ebh_classrooms r on (i.providercrid = r.crid) left join ebh_folders f on (i.folderid =  f.folderid)';
		$wherearr = array();
		if(!empty($param['itemidlist'])) {	//根据itemid组合获取详情列表，如1,2形式
			$wherearr[] = 'i.itemid in('.$param['itemidlist'].')';
		}
		if(!empty($param['ssid'])) {	//根据itemid组合获取详情列表，如1,2形式
			$wherearr[] = 'i.ssid in('.$param['ssid'].')';
		}
		if(!empty($param['providercrid'])) {
			$wherearr[] = 'i.providercrid='.$param['providercrid'];
		}
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
		}
		if(!empty($param['price'])) {
			$wherearr[] = 'i.iprice=0';
		}
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(i.iname like \'%'.$q.'%\')';
		}			
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		if(!empty($param['time'])) {
            $sql .= ' ORDER BY i.dateline desc';
        } 
        elseif(!empty($param['viewnum'])){
        	$sql .= ' ORDER BY f.viewnum desc'; 
        }
        elseif(!empty($param['price_high'])){
        	$sql .=' ORDER BY i.iprice desc';
        }
        elseif(!empty($param['price_low'])){
        	$sql .=' ORDER BY i.iprice asc';
        }
		elseif(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY itemid desc';
        }
        if(!empty($param['nolimit'])){//无需分页
        	return $this->db->query($sql)->list_array();
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

	public function getItemcount($param){
		$sql = 'select count(*) from `ebh_best_items` where ssid in('.$param['ssid'].')';
		if(!empty($param['price'])){
			$sql.=' and iprice=0';
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	*获取精品课堂列表数量
	*/
	public function getItemListCount($param) {
		$count = 0;
		$sql = 'select count(*) count from ebh_best_items i';
		$wherearr = array();
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}
	
	/**
	*通过第三级分类获取精品课程
	*/
	public function getItemListByssid($ssid) {
		$sql = "select itemid,labelids from ebh_best_items i where i.ssid={$ssid}";
		$list = $this->db->query($sql)->list_array();
		return $list;
	}

	/**
	*根据itemid获取精品课堂明细项详情
	*/
	public function getItemByItemid($itemid) {
		$sql = "select i.itemid,i.iname,i.isummary,i.iprice,i.folderid,i.bsid,i.msid,i.ssid,i.labelids,cr.crid,cr.crname,i.providercrid,i.comfee,i.roomfee,i.providerfee,i.longblockimg,i.isyouhui,i.iprice_yh,i.comfee_yh,i.roomfee_yh,i.providerfee_yh,i.iday,i.imonth,i.cannotpay,f.viewnum,f.coursewarenum,cr.domain from ebh_best_items i join ebh_classrooms cr on i.providercrid=cr.crid join ebh_folders f on i.folderid = f.folderid where i.itemid=$itemid"; 
		return $this->db->query($sql)->row_array();
	}

	/*
	添加
	*/
	public function add($param){
		$spiarr['iname'] = $param['iname'];
		$spiarr['iprice'] = $param['iprice'];
		if(!empty($param['isummary']))
			$spiarr['isummary'] = $param['isummary'];
		if(!empty($param['folderid']))
			$spiarr['folderid'] = $param['folderid'];
		if(!empty($param['bsid']))
			$spiarr['bsid'] = $param['bsid'];
		if(!empty($param['msid']))
			$spiarr['msid'] = $param['msid'];
		if(!empty($param['ssid']))
			$spiarr['ssid'] = $param['ssid'];
		if(!empty($param['labelids']))
			$spiarr['labelids'] = $param['labelids'];
		// if(!empty($param['iday']))
			$spiarr['iday'] = empty($param['iday'])?0:$param['iday'];
		// elseif(!empty($param['imonth']))
			$spiarr['imonth'] = empty($param['imonth'])?0:$param['imonth'];
		if(!empty($param['providercrid']))
			$spiarr['providercrid'] = $param['providercrid'];
		if(!empty($param['comfee']))
			$spiarr['comfee'] = $param['comfee'];
		if(!empty($param['roomfee']))
			$spiarr['roomfee'] = $param['roomfee'];
		if(!empty($param['providerfee']))
			$spiarr['providerfee'] = $param['providerfee'];
		if(!empty($param['longblockimg']))
			$spiarr['longblockimg'] = $param['longblockimg'];
		$spiarr['dateline'] = SYSTIME;
		if(!empty($param['isyouhui']))
			$spiarr['isyouhui'] = $param['isyouhui'];
		if(!empty($param['iprice_yh']))
			$spiarr['iprice_yh'] = $param['iprice_yh'];
		if(!empty($param['comfee_yh']))
			$spiarr['comfee_yh'] = $param['comfee_yh'];
		if(!empty($param['roomfee_yh']))
			$spiarr['roomfee_yh'] = $param['roomfee_yh'];
		if(!empty($param['providerfee_yh']))
			$spiarr['providerfee_yh'] = $param['providerfee_yh'];
		return $this->db->insert('ebh_best_items',$spiarr);
	}
	
	/*
	编辑
	*/
	public function edit($param){
		if(empty($param['itemid']))
			exit;
		$spiarr['iname'] = $param['iname'];
		$spiarr['isummary'] = $param['isummary'];
		$spiarr['labelids'] = $param['labelids'];
		$spiarr['iprice'] = $param['iprice'];
		$spiarr['folderid'] = $param['folderid'];
		$spiarr['bsid'] = $param['bsid'];
		$spiarr['msid'] = $param['msid'];
		$spiarr['ssid'] = $param['ssid'];
		if(isset($param['providercrid']))
			$spiarr['providercrid'] = $param['providercrid'];
		if(isset($param['comfee']))
			$spiarr['comfee'] = $param['comfee'];
		if(isset($param['roomfee']))
			$spiarr['roomfee'] = $param['roomfee'];
		if(isset($param['providerfee']))
			$spiarr['providerfee'] = $param['providerfee'];
		if(!empty($param['iday'])){
			$spiarr['iday'] = $param['iday'];
			$spiarr['imonth'] = 0;
		}elseif(!empty($param['imonth'])){
			$spiarr['imonth'] = $param['imonth'];
			$spiarr['iday'] = 0;
		}
		if(isset($param['cannotpay']))
			$spiarr['cannotpay'] = $param['cannotpay'];
		if(isset($param['longblockimg']))
			$spiarr['longblockimg'] = $param['longblockimg'];
		if(isset($param['isyouhui']))
			$spiarr['isyouhui'] = $param['isyouhui'];
		if(isset($param['iprice_yh']))
			$spiarr['iprice_yh'] = $param['iprice_yh'];
		if(isset($param['comfee_yh']))
			$spiarr['comfee_yh'] = $param['comfee_yh'];
		if(isset($param['roomfee_yh']))
			$spiarr['roomfee_yh'] = $param['roomfee_yh'];
		if(isset($param['providerfee_yh']))
			$spiarr['providerfee_yh'] = $param['providerfee_yh'];
		return $this->db->update('ebh_best_items',$spiarr,'itemid='.$param['itemid']);
	}

	/*
	通过itemid删除精品课堂
	*/
	public function deleteitem($itemid){
		return $this->db->delete('ebh_best_items','itemid='.$itemid);
	}
	
	/*
	通过分类删除精品课堂
	*/
	public function deleteitemBySid($level, $sid){
		return $this->db->delete('ebh_best_items',"{$level}=".$sid);
	}

	/*
	通过分类获取精品课堂
	*/
	public function getitemBySidLevel($level, $sid){
		$sql = "select itemid,iname,folderid from `ebh_best_items` where {$level}={$sid}";
		return $this->db->query($sql)->list_array();
	}

	/*
	通过itemid删除标签和标签的对应表
	*/
	public function delLabelByitemid($itemid) {
		$sql = "delete from `ebh_best_itemlabels` where `itemid` in ({$itemid})";
		if ($this->db->query($sql)) {
			return true;
		} 
		return false;
	}

	/*
	检测是否已有老师开设精品课堂
	*/
	public function checkHasBuy($param) {
		$sql ='select s.selid from ebh_best_select s';
		if(!empty($param['itemidlist'])) {	//根据itemid组合获取详情列表，如1,2形式
			$wherearr[] = 's.itemid in('.$param['itemidlist'].')';
		}
		if(!empty($param['itemid'])) {
			$wherearr[] = 's.itemid='.$param['itemid'];
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		return $this->db->query($sql)->list_array();
	}


	/*
	当删除标签的时候，特殊方法更数据库，更新labelids
	*/
	public function updateItemlabelids($updates, $ids) {
		$sql = "UPDATE ebh_best_items SET labelids = CASE itemid ";
		foreach ($updates as $id => $ordinal) { 
		    $sql .= sprintf("WHEN %d THEN '%s' ", $id, $ordinal); 
		} 
		$sql .= "END WHERE itemid IN ($ids)";
		$this->db->query($sql);
	}
	/**
	 * [getBestItemListByfolderid 通过folderid获取精品课程表]
	 * @param  [type] $folderid [description]
	 * @return [type]           [description]
	 */
	public function getBestItemListByfolderid($folderid){
		$sql = 'select b.iname,b.folderid,b.longblockimg,c.coursewarenum from `ebh_best_items` b join `ebh_folders` c on(b.folderid = c.folderid) where b.folderid in('.$folderid.')';
		//return $sql;
		return $this->db->query($sql)->list_array();
	}
	/**
	 * [getmyclass 获取所购买的精品课]
	 * @param  [type] $uid [description]
	 * @return [type]      [description]
	 */
	public function getitemidbyuid($uid){
		$sql = 'select itemid from `ebh_userpermisions` where uid='.$uid;
		return $this->db->query($sql)->list_array();
	}
	/**
	 * [getmyclass 获取所得未过期的精品课的详细信息]
	 * @param  [type] $uid     [description]
	 * @param  [type] $itemstr [description]
	 * @return [type]          [description]
	 */
	public function getmyclass($uid,$itemstr){
		$sql = 'select p.itemid,p.folderid,p.enddate,i.iname,i.iprice,i.longblockimg,c.crname,f.coursewarenum,f.viewnum from `ebh_userpermisions` p left join `ebh_best_items` i on (p.itemid = i.itemid) left join `ebh_classrooms` c on(i.providercrid = c.crid) left join `ebh_folders` f on(p.folderid = f.folderid) where p.uid='.$uid.' and p.enddate >'.SYSTIME.' and p.itemid in('.$itemstr.')';
		return $this->db->query($sql)->list_array();
	}
}

?>