<?php
class BestsortsModel extends CModel{
	/*
	获取分类列表
	*/
	public function getSortList($param){
		$sql = 'select s.sname,s.sid,s.spath,s.psid from ebh_best_sorts s';
		$wherearr = array();
		if(isset($param['psid']))
			$wherearr[].='s.psid='.$param['psid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}

	/*
	通过sid取分类
	*/
	public function getSortBysid($param){
		$sql = 'select s.sname,s.sid,s.spath,s.psid from ebh_best_sorts s where s.sid='.$param;
		return $this->db->query($sql)->row_array();
	}

	/*
	获取子分类
	*/
	public function getNextSort($path){
	    $sql = 'select sid,sname,spath from `ebh_best_sorts` where spath like \''.$this->db->escape_str($path).'%\'';
			return $this->db->query($sql)->list_array();
	}

	public function getBestItems($sorts,$sid,$param,$filter=array()){
		$sql = 'select i.itemid,i.iname,i.isummary,i.ifbestshow,i.longblockimg,i.folderid,i.iprice,i.labelids,f.viewnum,f.detail,f.introduce,f.img,f.coursewarenum,c.crname from `ebh_best_items` i  LEFT JOIN `ebh_folders` f on (i.folderid =  f.folderid) LEFT JOIN `ebh_classrooms` c on (i.providercrid = c.crid) ';
		//过滤
		$setarr = array();
		if(!empty($sorts) && !empty($sid)){
			$setarr[] = ' i.'.$sorts.'='.$sid;
		}
		if(!empty($filter['itemids'])){
			$setarr[] = ' i.itemid not in ('.implode(',',$filter['itemids']).')';	
		}
		if(!empty($param['price'])){
			$setarr[] = ' i.iprice = 0';
		}
		if(!empty($param['search'])){
		    $setarr[] =' (i.iname like \'%'.$this->db->escape_str($param['search']).'%\' or c.crname like \'%'.$this->db->escape_str($param['search']).'%\')';
		}
		if(!empty($setarr)){
			$sql.= ' where '.implode($setarr,' and ');
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
        else {
            $sql .= ' ORDER BY i.itemid desc';
        }//return $sql;
		return $this->db->query($sql)->list_array();
	}

	/*
	根据标签获取精品课程的itemid
	*/
	public function getSortByLabels($label_filter){
		$sql = 'select itemid from `ebh_best_itemlabels` where label in('.$label_filter.')';
		return $this->db->query($sql)->list_array();
	}
	/**
	 * [getBestItemsByItem 通过精品课的itemid获取精品课的详细信息]
	 * @param  [type] $itemsidstr [description]
	 * @param  array  $param      [description]
	 * @param  array  $filter     [description]
	 * @return [type]             [description]
	 */
	public function getBestItemsByItem($itemsidstr,$param=array(),$filter=array()){
		$sql = 'select i.itemid,i.iname,i.isummary,i.ifbestshow,i.longblockimg,i.folderid,i.iprice,i.labelids,f.viewnum,f.detail,f.introduce,f.img,f.coursewarenum,c.crname from `ebh_best_items` i  LEFT JOIN `ebh_folders` f on (i.folderid =  f.folderid) LEFT JOIN `ebh_classrooms` c on (i.providercrid = c.crid) where i.itemid in('.$itemsidstr.')';
		if(!empty($filter['itemids'])){
			$sql.= ' and i.itemid not in ('.implode(',',$filter['itemids']).')';
		}
		if(!empty($param['price'])){
			$sql.= ' and i.iprice = 0';
		}
		if(!empty($param['search'])){
		    $sql.=' and (i.iname like \'%'.$this->db->escape_str($param['search']).'%\' or c.crname like \'%'.$this->db->escape_str($param['search']).'%\')';
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
        else {
            $sql .= ' ORDER BY i.itemid desc';
        }
		return $this->db->query($sql)->list_array();
	}

	/*
	获取一级分类
	*/
	public function getSort($psid = 0){
		$sql = 'select `sid`,`sname`,`spath` from `ebh_best_sorts` where psid ='.$psid;
		return $this->db->query($sql)->list_array();
	}

	/*
	添加分类
	*/
	public function addsort($param){
		if(!empty($param['sname'])){
			$setarr['sname'] = $param['sname'];
		}
		if(!empty($param['path'])){
			$setarr['spath'] = $param['path'];
		}
		if(!empty($param['psid'])){
			$setarr['psid'] = $param['psid'];
		}
		$sid = $this->db->insert('ebh_best_sorts',$setarr);
		if($sid) {
			return $sid;
		} else {
			return 0;
		}
	}

	/*
	更新分类
	*/
	public function updatesort($param,$sid){
		if(isset($param['sname'])){
			$setarr['sname'] = $param['sname'];
		}
		if(isset($param['path'])){
			$setarr['spath'] = $param['path'];
		}
		if(isset($param['psid'])){
			$setarr['psid'] = $param['psid'];
		}
		return $this->db->update('ebh_best_sorts',$setarr,array('sid'=>$sid));
	}

	/*
	通过分类名检测分类是否存在
	*/
	public function check($sname){
	    $sql = 'select sid from `ebh_best_sorts` where sname ='.'\''.$this->db->escape_str($sname).'\'';
		return $this->db->query($sql)->list_array();
	}

	/*
	根据sid删除分类
	*/
	public function delsort($id) {
		$arr = array('sid' => $id);
		$mes = $this->db->delete('ebh_best_sorts', $arr);
		return $mes;
	}

	/*
	根据path删除一级分类和其子分类
	*/
	public function delSortByPath($path, $bsidpath = ''){
	    $sql = 'delete from `ebh_best_sorts` where spath like \'' . $this->db->escape_str($path) .'%\' ' . 'or spath=\'' .$this->db->escape_str($bsidpath) . '\'';
			return $this->db->query($sql);
	}

	/*
	通过sid删除标签
	*/
	public function delLabelBysid($sid) {
		$sql = "delete from `ebh_best_labels` where `sid` in ({$sid})";
		if ($this->db->query($sql)) {
			return true;
		} 
		return false;
	}

	/*
	通过sid获取标签
	*/
	public function getLabelBySid($sid){
		if(!empty($sid)){
			$sql = 'select sid, label from `ebh_best_labels` where `sid` = '.$sid;
			return $this->db->query($sql)->list_array();
		}
		return false;
	}

	/*
	通过sid获取分类
	*/
	public function getOneSort($sid){
		$sql = 'select sname,spath from `ebh_best_sorts` where `sid` in ('.$sid.')';
		return $this->db->query($sql)->list_array();
	}
}
?>