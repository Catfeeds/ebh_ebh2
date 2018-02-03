<?php

/**
 * 企业选课，网校来源信息关联表
 */
class SchsourceModel extends CModel {
	/**
	 * 添加关联信息,添加课程
	 * @param array $param
	 * @return boolean
	 */
	public function add($param) {
		$this->db->begin_trans();
		$insertarr['crid'] = intval($param['crid']);
		$insertarr['sourcecrid'] = intval($param['sourcecrid']);
		$insertarr['name'] = $param['name'];
		$insertarr['dateline'] = SYSTIME;
        //总分成比例
        $insertarr['compercent'] = !empty($param['compercent']) ? intval($param['compercent']) : 0;
        $insertarr['roompercent'] = !empty($param['roompercent']) ? intval($param['roompercent']) : 0;
        $insertarr['providerpercent'] = !empty($param['providerpercent']) ? intval($param['providerpercent']) : 0;
		$sourceid = $this->db->insert('ebh_schsources',$insertarr);
		if(empty($sourceid)){
			return FALSE;
		}
		
		//添加课程信息
		$itemlist = $param['itemlist'];
		if(!empty($itemlist)){
			$this->doItems($insertarr['crid'],$insertarr['sourcecrid'],$itemlist);
		}
		if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->commit_trans();
		return TRUE;
	}
	
	/*
	处理添加课程
	*/
	private function doItems($crid,$sourcecrid,$itemlist){
		$sql = 'insert into ebh_schsourceitems (crid,sourcecrid,folderid,itemid,price,month,compercent,roompercent,providerpercent) values ';
		$itemids = array_column($itemlist,'itemid');
		$itemids = implode(',',$itemids);
		$deletesql = 'DELETE FROM ebh_schsourceitems where itemid in ('.$itemids.') and crid='.$crid;
		$this->db->query($deletesql);
		foreach($itemlist as $item){
			$folderid = $item['folderid'];
			$itemid = $item['itemid'];
			$price = $item['price'];
			$month = $item['month'];
            //单分成比例
            $compercent = !empty($item['compercent']) ? intval($item['compercent']) : 0;
            $roompercent = !empty($item['roompercent']) ? intval($item['roompercent']) : 0;
            $providerpercent = !empty($item['providerpercent']) ? intval($item['providerpercent']) : 0;
			$sql.= "($crid,$sourcecrid,$folderid,$itemid,$price,$month,$compercent,$roompercent,$providerpercent),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}
	/**
	 * 更新信息
	 * @param array $param
	 * @return boolean
	 */
	public function edit($param) {
		if(empty($param['sourceid'])){
			return FALSE;
		}
		$sourceid = $param['sourceid'];
		$crinfo = $this->getCrinfoBySourceid($sourceid);
        if(empty($crinfo)){
			return FALSE;
		}
		$wherearr['sourceid'] = $sourceid;
        $setarr = array();
        $setarr['name'] = !empty($param['name']) ? $this->db->escape_str($param['name']) : '';
        $setarr['compercent'] = !empty($param['compercent']) ? intval($param['compercent']) : 0;
        $setarr['roompercent'] = !empty($param['roompercent']) ? intval($param['roompercent']) : 0;
        $setarr['providerpercent'] = !empty($param['providerpercent']) ? intval($param['providerpercent']) : 0;
		$nameres = TRUE;
		if (!empty($setarr)){
			$nameres = $this->db->update('ebh_schsources', $setarr, $wherearr);
		}
		$returnres = 0;
		if($nameres !== FALSE){
			$returnres = 1;
		}
		
		$oldlist = $this->getSelectedItems(array('sourceid'=>$sourceid,'del'=>0));
		$olditems = array_column($oldlist,'itemid');
		$itemlist = $param['itemlist'];
		$items = array_column($itemlist,'itemid');
		$delarr = array_diff($olditems,$items);
		$this->db->begin_trans();
		if(!empty($delarr)){//删除,del标记为1
			$delitemids = implode(',',$delarr);
			// $this->db->update('ebh_schsourceitems',array('del'=>1),'itemid in ('.$delitemids.')');
			$updatesql = 'update ebh_schsourceitems set del=1 where itemid in ('.$delitemids.') and crid='.$crinfo['crid'];
			$this->db->query($updatesql);
		}
		
		if(!empty($itemlist)){//更新课程,删除旧的,加上新的
			$additemids = implode(',',$items);
			// $this->db->delete('ebh_schsourceitems','itemid in ('.$additemids.')');
			$this->doItems($crinfo['crid'],$crinfo['sourcecrid'],$itemlist);
		}
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
        } else {
			$returnres += 2;
			$this->db->commit_trans();
		}
		return $returnres;
	}

	/**
	 * 获取来源信息列表
	 * @param array $param
	 * @return boolean
	 */
	public function getSourceList($param) {
		$sql = 'select sourceid,s.crid,s.sourcecrid,name,sum(if(si.del=1 or isnull(si.del),0,1)) coursecount,s.dateline,s.compercent,s.roompercent,s.providerpercent,cr.crname,cr2.crname scrname from ebh_schsources s 
				left join ebh_schsourceitems si on s.crid=si.crid and s.sourcecrid=si.sourcecrid
				join ebh_classrooms cr on cr.crid=s.crid
				join ebh_classrooms cr2 on cr2.crid=s.sourcecrid
				';
		$wherearr = array();
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = "(cr.crname like '%$q%' or cr2.crname like '%$q%' or s.name like '%$q%')";
		}
		if(!empty($param['crid'])){
			$wherearr[] = 's.crid='.$param['crid'];
		}
		if(!empty($param['sourcecrid'])){
			$wherearr[] = 's.sourcecrid='.$param['sourcecrid'];
		}
		if(!empty($param['sourceid'])){
			$wherearr[] = 'sourceid='.$param['sourceid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$sql .= ' group BY s.crid,s.sourcecrid ';
		$sql .= ' ORDER BY sourceid DESC ';
		if (!empty($param['limit'])){
			$sql .= ' LIMIT ' . $param['limit'];
		} else {
			if (empty($queryarr['page']) || $queryarr['page'] < 1)
				$page = 1;
			else
				$page = $queryarr['page'];
			$pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= 'limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}

	/**
	 * 获取来源信息数量
	 * @param array $param
	 * @return int
	 */
	public function getSourceCount($param) {
		$count = 0;
		$sql = 'select count(*) count from ebh_schsources s
				join ebh_classrooms cr on cr.crid=s.crid
				join ebh_classrooms cr2 on cr2.crid=s.sourcecrid';
		$wherearr = array();
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = "(cr.crname like '%$q%' or cr2.crname like '%$q%' or s.name like '%$q%')";
		}
		if(!empty($param['crid'])){
			$wherearr[] = 's.crid='.$param['crid'];
		}
		if(!empty($param['sourcecrid'])){
			$wherearr[] = 's.sourcecrid='.$param['sourcecrid'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$row = $this->db->query($sql)->row_array();
		if (!empty($row)){
			$count = $row['count'];
		}
		return $count;
	}

	/**
	 * 获取课程列表
	 * @param array $param
	 * @return list
	 */
	public function getItemList($param) {
		if (empty($param['crid']) && empty($param['itemids']))
			return FALSE;
		$sql = 'select i.iname,i.itemid,i.folderid,p.pname,s.sname,i.pid,i.sid,i.crid,iprice,imonth 
				from ebh_pay_items i
				left join ebh_pay_sorts s on i.sid=s.sid
				join ebh_pay_packages p on p.pid=i.pid';
		$wherearr = array('i.`status`=0','p.`status`=1');
		if(!empty($param['pid'])){
			$wherearr[] = 'i.pid=' . $param['pid'];
			if(!empty($param['sid'])){
				$wherearr[] = 'i.sid=' . $param['sid'];
			}
		}
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(i.iname like \'%'.$q.'%\' or p.pname like \'%'.$q.'%\' or s.sname like \'%'.$q.'\')';
		}
		if(!empty($param['itemids'])){
			$wherearr[] = 'i.itemid in ('.$param['itemids'].')';
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'i.crid='.$param['crid'];
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		if (!empty($param['sid'])) {
			$sql .= ' displayorder asc,folderid asc';
		} else {
			$sql .= ' order by itemid desc ,i.folderid desc';
		}
		return $this->db->query($sql)->list_array();
	}
	
	/**
	 * 获取课程数量
	 * @param array $param
	 * @return int
	 */
	public function getItemCount($param) {
		if (empty($param['crid']) && empty($param['itemids']))
			return FALSE;
		$count = 0;
		$sql = 'select count(*) count
				from ebh_pay_items i
				left join ebh_pay_sorts s on i.sid=s.sid
				join ebh_pay_packages p on p.pid=i.pid';
		$wherearr = array('i.`status`=0','p.`status`=1');
		if(!empty($param['pid'])){
			$wherearr[] = 'i.pid=' . $param['pid'];
			if(!empty($param['sid'])){
				$wherearr[] = 'i.sid=' . $param['sid'];
			}
		}
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(i.iname like \'%'.$q.'%\' or p.pname like \'%'.$q.'%\' or s.sname like \'%'.$q.'\')';
		}
		if(!empty($param['itemids'])){
			$wherearr[] = 'i.itemid in ('.$param['itemids'].')';
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'i.crid='.$param['crid'];
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if (!empty($row)){
			$count = $row['count'];
		}
		return $count;
	}
	
	/**
	 * 根据记录id,获取已选课程
	 * @param int $sourceid
	 * @return array
	 */
	public function getSelectedItems($param){
		if(empty($param['sourceid']) && empty($param['crid'])){
			return FALSE;
		}
		$sql = 'select s.sourceid,itemid,folderid,price,month,del,s.crid,s.sourcecrid,s.name,si.compercent,si.roompercent,si.providerpercent,s.compercent as scompercent,s.roompercent as sroompercent,s.providerpercent as sproviderpercent from ebh_schsourceitems si 
				join ebh_schsources s on s.crid=si.crid and s.sourcecrid=si.sourcecrid';
		if(!empty($param['sourceid'])){
			$wherearr[]= 's.sourceid='.$param['sourceid'];
		}
		if(!empty($param['crid'])){
			$wherearr[]= 's.crid='.$param['crid'];
		}
		if(isset($param['del'])){
			$wherearr[]= 'si.del ='.$param['del'];
		}
		if(!empty($param['itemid'])){
			$wherearr[]= 'si.itemid='.$param['itemid'];
		}
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' ORDER BY `s`.`sort` ASC,`s`.`dateline` DESC';
        return $this->db->query($sql)->list_array('itemid');
	}
	
	
	/**
	 * 根据记录id,获取学校id
	 * @param int $sourceid
	 * @return array
	 */
	private function getCrinfoBySourceid($sourceid){
		$sql = 'select crid,sourcecrid,name from ebh_schsources where sourceid='.$sourceid;
		return $this->db->query($sql)->row_array();
	}
	
	/*
	删除
	*/
	public function delSource($sourceid){
		if(empty($sourceid)){
			return FALSE;
		}
		$crinfo = $this->getCrinfoBySourceid($sourceid);
		if(empty($crinfo)){
			return FALSE;
		}
		$this->db->begin_trans();
		$this->db->delete('ebh_schsources','sourceid='.$sourceid);
		$setarr['del'] = 1;
		$wherearr['crid'] = $crinfo['crid'];
		$wherearr['sourcecrid'] = $crinfo['sourcecrid'];
		$this->db->update('ebh_schsourceitems',$setarr,$wherearr);
		if ($this->db->trans_status() === FALSE) {
            $this->db->rollback_trans();
			return FALSE;
        } else {
			$this->db->commit_trans();
		}
		return TRUE;
	}

	/**
	 * [设置排序]
	 * @param [int] $sortNumber
	 */
	public function setSort($sortNumber,$sourceid){
		$setArr['sort'] = $sortNumber;
		$whereArr['sourceid'] = $sourceid; 
		return $this->db->update('ebh_schsources',$setArr,$whereArr);
	}
	
	/**
	 * 判断是不是企业选课还是本网校自己的课程
	 */
	public function getcourse($itemid,$crid){
	    $ckrow = false;
	    //先从本网校查询
	    $sql = 'select crid,providercrid,folderid,iprice,itemid from ebh_pay_items pt where pt.itemid = '.$itemid.' and pt.crid = '.$crid.' and pt.status = 0 limit 1';
	    $localRow =  $this->db->query($sql)->row_array($sql);
	    if(!empty($localRow)){
	        if(!empty($localRow['providercrid'])){//第三方来源
	            $localRow['coursetype']='third';
	        }else{
	            $localRow['coursetype']='local';//本网校服务项 
	        }
	        $localRow['sourcecrid'] = 0;
	        $ckrow = $localRow;
	    }else {
	        //查询企业选课
	        $qysql = 'select crid,sourcecrid,itemid,folderid,price,month from  ebh_schsourceitems si where crid = '.$crid.' and  itemid = '.$itemid.' and del = 0 limit 1';
	        $qyRow = $this->db->query($qysql)->row_array($sql);
	        if(!empty($qyRow)){
	            $qyRow['coursetype']='select';//企业选课过来的
	            $ckrow = $qyRow;
	        }
	    }
	    
	    return $ckrow;
	}
	
}
