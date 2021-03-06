<?php
/*
服务包
*/
class PaypackageModel extends CModel{
	/**
	*获取服务包列表
	*/
	public function getsplist($param){
		$sql = 'select p.pid,p.pname,p.dateline,p.summary,p.displayorder,p.status,p.itype,cr.crid,cr.crname,cr.profitratio from ebh_pay_packages p join ebh_classrooms cr on cr.crid=p.crid ';
		$wherearr = array();
		if(!empty($param['crid'])) {	//所属crid
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(cr.crname like \'%'.$q.'%\' or p.pname like \'%'.$q.'%\' )';
		}
		if(!empty($param['tid'])) {	//所属crid
			$wherearr[] = 'p.tid='.$param['tid'];
		}
		if(isset($param['status'])){
			$wherearr[] = 'p.status='.$param['status'];
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY pid desc';
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
	/**
	*获取服务包count
	*/
	public function getspcount($param){
		$count = 0;
		$sql = 'select count(*) count from ebh_pay_packages p join ebh_classrooms cr on cr.crid=p.crid';
		$wherearr = array();
		if(!empty($param['crid'])) {	//所属crid
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		if(!empty($param['q'])){
			$q = $this->db->escape_str($param['q']);
			$wherearr[] = '(cr.crname like \'%'.$q.'%\' or p.pname like \'%'.$q.'%\' )';
		}
		if(!empty($param['tid'])) {	//所属crid
			$wherearr[] = 'p.tid='.$param['tid'];
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$res = $this->db->query($sql)->row_array();
		if(!empty($res))
			$count = $res['count'];
		return $count;
	}
	
	public function add($param){
		if(empty($param['crid']) || empty($param['pname']))
			return false;
		$sparr['pname'] = $param['pname'];
		$sparr['crid'] = $param['crid'];
		$sparr['uid'] = $param['uid'];
		$sparr['dateline'] = SYSTIME;
		if(!empty($param['summary']))
			$sparr['summary'] = $param['summary'];
		$sparr['tid'] = empty($param['tid'])?0:$param['tid'];
		if(!empty($param['displayorder']))
			$sparr['displayorder'] = $param['displayorder'];
		if(!empty($param['limitdate']))
			$sparr['limitdate'] = $param['limitdate'];
		if(isset($param['itype'])){
			$sparr['itype'] = $param['itype'];
		}
		return $this->db->insert('ebh_pay_packages',$sparr);
	}
	public function edit($param){
		if(empty($param['pid']))
			exit;
		if(!empty($param['pname']))
			$sparr['pname'] = $param['pname'];
		if(!empty($param['crid']))
			$sparr['crid'] = $param['crid'];
		if(!empty($param['summary']))
			$sparr['summary'] = $param['summary'];
		if(isset($param['tid']))
			$sparr['tid'] = $param['tid'];
		if(isset($param['displayorder'])) {
			$sparr['displayorder'] = (int)$param['displayorder'];
		}

		if(isset($param['status']))
			$sparr['status'] = $param['status'];
		if(isset($param['limitdate']))
			$sparr['limitdate'] = $param['limitdate'];
		return $this->db->update('ebh_pay_packages',$sparr,'pid='.$param['pid']);
	}
	/**
	*根据itemid获取服务明细项详情
	*/
	public function getPackByPid($pid) {
		$sql = "select p.pid,p.pname,p.summary,p.crid,cr.crname,p.displayorder,p.limitdate from ebh_pay_packages p join ebh_classrooms cr on p.crid=cr.crid where pid=".$pid;
		return $this->db->query($sql)->row_array();
	}
	/*
	删除服务包
	*/
	public function deletepack($pid){
		return $this->db->delete('ebh_pay_packages','pid='.$pid);
	}
	
	/*
	删除服务包下的分类
	*/
	public function deletesort($pid){
		return $this->db->delete('ebh_pay_sorts','pid='.$pid);
	}
	
	/*
	学校的服务项列表,为组成服务包-课程对应关系
	*/
	public function getPackageFolders($param){
		$sql = 'select i.folderid,p.pid,p.pname,i.iname,i.itemid from ebh_pay_packages p join ebh_pay_items i on p.pid=i.pid';
		$wherearr = array();
		if(!empty($param['crid'])) {
			$wherearr[] = 'i.crid='.$param['crid'];
		}
		if(!empty($param['pid']))
			$wherearr[] = 'p.pid='.$param['pid'];
		if(!empty($param['itemid']))
			$wherearr[] = 'i.itemid='.$param['itemid'];
		$wherearr[] = 'i.status=0';
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$sql.= ' order by p.displayorder asc,p.pid desc';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	最早的
	*/
	public function getFirstLimitDate($param){
		$sql = 'select if(min(limitdate)>0,min(limitdate),0) firstday,i.folderid 
		from ebh_userpermisions u
		join ebh_pay_items i on u.itemid=i.itemid
		join ebh_pay_packages p on i.pid=p.pid
		';
		$wherearr = array();
		if(!empty($param['folderid'])) {
			$wherearr[] = 'i.folderid='.$param['folderid'];
			$arraytype = 'row_array';
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'p.crid='.$param['crid'];
			$arraytype = 'list_array';
		}
		$wherearr[] = 'u.uid='.$param['uid'];
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		$sql .= ' group by i.folderid';
		$result = $this->db->query($sql)->$arraytype();
		return $result;
	}
	
	/*
	按folderid获取服务包
	*/
	public function getPackByFolderid($param){
		$sql = 'select p.pid,p.pname,i.itemid,i.sid,i.folderid,f.folderid,f.foldername,f.coursewarenum,f.img,i.iname from ebh_pay_items i
				join ebh_pay_packages p on i.pid = p.pid
				join ebh_folders f on i.folderid = f.folderid
				where i.folderid in ('.$param['folderids'].')';
			if(!empty($param['crid'])) {
				$sql .= ' and i.crid=' . $param['crid'].' group by p.pid,f.folderid';
				$sql .= ' order by p.displayorder asc ,p.pid desc';
			}
		return $this->db->query($sql)->list_array();
		
	}

	public function checkRepeatPackage($arr) {
		if (empty($arr)) return false;
		$sql = "select sid from ebh_pay_sorts where sid in (".implode(',', $arr).')'.'and showbysort = 1';
		//echo $sql;
		$sidArr = $this->db->query($sql)->list_array();
		if ($sidArr) {
			$arr = array();
			foreach($sidArr as $v) {
				$arr[] = $v['sid'];
			}
			return $arr;
		} else { return false; }
	}
	
	/*
	简单的服务包查询
	*/
	public function getsimplesplist($param){
		$sql = 'select p.pid,p.pname,p.dateline,p.displayorder,p.status,p.itype,(select count(*) from ebh_pay_items i where i.pid=p.pid and i.status=0) itemcount from ebh_pay_packages p';
		$wherearr = array();
		if(!empty($param['crid'])) {	//所属crid
			$wherearr[] = 'p.crid='.$param['crid'];
		}
		
		if(isset($param['status'])){
			$wherearr[] = 'p.status='.$param['status'];
		}
		if(!empty($wherearr)) {
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		}
		if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY pid desc';
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
	
	/*
	获取学校下服务包最大的排序号
	*/
	public function getCurdisplayorder($param){
		$sql = 'select max(displayorder) mdis from ebh_pay_packages';
		$wherearr[] = 'crid='.$param['crid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$res = $this->db->query($sql)->row_array();
		return $res['mdis'];
	}
	
	public function hasCheck($param){
		if(empty($param['crid']) || empty($param['pid']) || !is_numeric($param['pid']))
			return false;
		$sql = 'select p.pid,count(i.itemid) itemcount from ebh_pay_packages p left join ebh_pay_items i on p.pid=i.pid';
		$wherearr[]= 'p.crid='.$param['crid'];
		$wherearr[]= 'p.pid='.$param['pid'];
		$wherearr[]= 'i.status=0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$hassp = $this->db->query($sql)->row_array();
		return $hassp;
	}

	/**
	 * 获取网校一有效的服务包ID集
	 * @param $crid
	 * @param int $limit
	 * @return bool
	 */
	public function getPackageIds($crid, $limit = 1000) {
		$crid = (int) $crid;
		if ($crid < 1) {
			return false;
		}
		if (is_array($limit)) {
			$page = isset($limit['page']) ? intval($limit['page']) : 1;
			$pagesize = isset($limit['pagesize']) ? intval($limit['page']) : 20;
			$page = max(1, $page);
			$pagesize = max(1, $pagesize);
			$offset = ($page - 1) * $pagesize;
			return $this->db->query(
				"SELECT `pid` FROM `ebh_pay_packages` WHERE `crid`=$crid AND `status`=1 LIMIT $offset, $pagesize")
				->list_field();
		}

		$limit = (int) $limit;
		$limit = max(1, $limit);
		return $this->db->query(
			"SELECT `pid` FROM `ebh_pay_packages` WHERE `crid`=$crid AND `status`=1 LIMIT $limit")
			->list_field();
	}

	/**
	 * 更新服务包排序，非关键性操作，不启用事务
	 * @param $pid
	 * @param $crid
	 * @param $is_increase 更改方式true:提高优先级，false:降低优先级
	 * @return bool
	 */
	public function changeOrder($pid, $crid, $is_increase) {
		$pid = (int) $pid;
		$crid = (int) $crid;
		if ($pid < 1 || $crid < 1) {
			return false;
		}
		$sql = "SELECT `pid`,`displayorder` FROM `ebh_pay_packages` WHERE `crid`=$crid AND `status`=1 ORDER BY `displayorder` ASC,`pid` DESC";
		$pid_orders = $this->db->query($sql)->list_array();
		if (empty($pid_orders)) {
			return false;
		}
		$orders = array_column($pid_orders, 'displayorder');
		$orders = array_unique($orders);
		$reset = count($pid_orders) > count($orders);
		if ($reset) {
			foreach ($pid_orders as $pk => $pid_order) {
                if ($pk == 0 && $pid_order['displayorder'] < 0) {
                    //最小排序号为-1，首页课程列表服务项定位到全部
                    $pid_orders[$pk]['displayorder'] = -1;
                } else {
                    $pid_orders[$pk]['displayorder'] = $pk + 1;
                }

				if ($pid_order['pid'] == $pid) {
					$pid_key = $pk;
				}
			}
		}
		if (!isset($pid_key)) {
			foreach ($pid_orders as $pk => $pid_order) {
				if ($pid_order['pid'] == $pid) {
					$pid_key = $pk;
					break;
				}
			}
		}
		if (!isset($pid_key)) {
			return false;
		}
		if ($is_increase && isset($pid_orders[$pid_key - 1])) {
			//提高优先级
			$ex_displayorder = $pid_orders[$pid_key - 1]['displayorder'];
			$pid_orders[$pid_key - 1]['displayorder'] = $pid_orders[$pid_key]['displayorder'];
			$pid_orders[$pid_key]['displayorder'] = $ex_displayorder;
			$change_key = $pid_key - 1;
		}
		if (!$is_increase && isset($pid_orders[$pid_key + 1])) {
			//降低优先级
			$ex_displayorder = $pid_orders[$pid_key + 1]['displayorder'];
			$pid_orders[$pid_key + 1]['displayorder'] = $pid_orders[$pid_key]['displayorder'];
			$pid_orders[$pid_key]['displayorder'] = $ex_displayorder;
			$change_key = $pid_key + 1;
		}
		if ($reset) {
			foreach ($pid_orders as $package) {
				$this->db->update('ebh_pay_packages', array(
					'displayorder' => $package['displayorder']
				), "`pid`={$package['pid']}");
			}
			return true;
		}
		if(isset($change_key)) {
			$this->db->update('ebh_pay_packages', array(
				'displayorder' => $pid_orders[$pid_key]['displayorder']
			), "`pid`={$pid_orders[$pid_key]['pid']}");
			$this->db->update('ebh_pay_packages', array(
				'displayorder' => $pid_orders[$change_key]['displayorder']
			), "`pid`={$pid_orders[$change_key]['pid']}");
			return true;
		}
		return false;
	}
}
