<?php
	/**
	* 学习记录model对应的ebh_playlog表	
	* 学生每次播放课件完成后都会添加学习时间记录
	*/
	class PlaylogModel extends CModel{
		/**
		 * 根据参数获取对应的学习记录列表
		 * @param array $param
		 * @return array
		 */
		public function getList($param=array()){
			$sql = 'select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,c.cwurl,c.ism3u8 from ebh_playlogs p '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) ';
			$wherearr = array();
			if(!empty($param['uid']))
				$wherearr[] = 'p.uid='.$param['uid'];
			if(!empty($param['crid']))
				$wherearr[] = 'rc.crid='.$param['crid'];
			if(!empty($param['startDate']))
				$wherearr[] = 'p.lastdate>='.$param['startDate'];
			if(!empty($param['endDate']))
				$wherearr[] = 'p.lastdate<'.$param['endDate'];
			if(!empty($param['q'])){
				$wherearr[] = ' c.title like \'%'.$param['q'].'%\'';
			}
			if(isset($param['totalflag'])){
				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
			}else{
				$wherearr[] = 'p.totalflag=1';
			}
			if(!empty($param['folderid'])){
				$wherearr[] = 'rc.folderid = '.$param['folderid'];
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			if(!empty($param['order'])){
				$sql.=' order by '.$param['order'];
			}else{
				$sql.=' order by p.lastdate desc ';
			}
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
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 根据参数获取对应的学习记录条数
		 * @param array $param
		 * @return int
		 */
		public function getListCount($param){
			$count = 0;
			$sql = 'select count(*) count from ebh_playlogs p '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) ';
			$wherearr = array();
			if(!empty($param['uid']))
				$wherearr[] = 'p.uid='.$param['uid'];
			if(!empty($param['crid']))
				$wherearr[] = 'rc.crid='.$param['crid'];
			if(!empty($param['startDate']))
				$wherearr[] = 'p.lastdate>='.$param['startDate'];
			if(!empty($param['endDate']))
				$wherearr[] = 'p.lastdate<'.$param['endDate'];
			if(!empty($param['q'])){
				$wherearr[] = ' c.title like \'%'.$param['q'].'%\'';
			}
			if(isset($param['totalflag'])){
				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
			}else{
				$wherearr[] = 'p.totalflag=1';
			}
			if(!empty($param['folderid'])){
				$wherearr[] = 'rc.folderid = '.$param['folderid'];
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			$row = $this->db->query($sql)->row_array();
			if(!empty($row))
				$count = $row['count'];
			return $count;
		}
		/**
		 * 根据教室编号和班级编号获取对应的学生学习记录列表
		 * @param array $param
		 * @return array
		 */
		public function getListByClassid($param=array()){
			$sql = 'select p.logid,p.cwid,p.ctime,p.ltime,p.startdate,p.lastdate,c.title,u.username,u.realname from ebh_playlogs p '.
					'join ebh_users u on (u.uid = p.uid) '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) '.
					'join ebh_classstudents cs on (cs.uid=p.uid) ';
			$wherearr = array();
			if(!empty($param['uid']))
				$wherearr[] = 'p.uid='.$param['uid'];
			if(!empty($param['classid']))
				$wherearr[] = 'cs.classid in ('.$param['classid'].')';
			if(!empty($param['crid']))
				$wherearr[] = 'rc.crid='.$param['crid'];
			if(!empty($param['startDate']))
				$wherearr[] = 'p.lastdate>='.$param['startDate'];
			if(!empty($param['endDate']))
				$wherearr[] = 'p.lastdate<'.$param['endDate'];
			if(!empty($param['q'])) {	//根据用户名/课件名称搜索
				$q = $this->db->escape_str($param['q']);
				$wherearr[] = '(u.username like \'%'.$q.'%\' OR u.realname like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\')'; 
			}
			if(isset($param['totalflag'])){
				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
			}else{
				$wherearr[] = 'p.totalflag=1';
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			if(!empty($param['order'])){
				$sql.=' order by '.$param['order'];
			}else{
				$sql.=' order by p.lastdate desc ';
			}
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
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 根据教室编号和班级编号获取对应的学生学习记录列表记录条数
		 * @param array $param
		 * @return int
		 */
		public function getListCountByClassid($param){
			$count = 0;
			$sql = 'select count(*) count from ebh_playlogs p '.
					'join ebh_users u on (u.uid = p.uid) '.
					'join ebh_coursewares c on (p.cwid = c.cwid) '.
					'join ebh_roomcourses rc on (rc.cwid = p.cwid) '.
					'join ebh_classstudents cs on (cs.uid=p.uid) ';
			$wherearr = array();
			if(!empty($param['uid']))
				$wherearr[] = 'p.uid='.$param['uid'];
			if(!empty($param['classid']))
				$wherearr[] = 'cs.classid in ('.$param['classid'].')';
			if(!empty($param['crid']))
				$wherearr[] = 'rc.crid='.$param['crid'];
			if(!empty($param['startDate']))
				$wherearr[] = 'p.lastdate>='.$param['startDate'];
			if(!empty($param['endDate']))
				$wherearr[] = 'p.lastdate<'.$param['endDate'];
			if(!empty($param['q'])) {	//根据用户名/课件名称搜索
				$q = $this->db->escape_str($param['q']);
				$wherearr[] = '(u.username like \'%'.$q.'%\' OR u.realname like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\')'; 
			}
			if(isset($param['totalflag'])){
				$wherearr[] = 'p.totalflag in ('.$param['totalflag'].')';
			}else{
				$wherearr[] = 'p.totalflag=1';
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			$row = $this->db->query($sql)->row_array();
			if(!empty($row))
				$count = $row['count'];
			return $count;
		}
		
		/*
		学校学生学习统计
		*/
		public function getListForClassroom($param){
			$wherearr = array();
			$sql = 'select u.username,u.realname,f.foldername,cl.classname,sum(pl.ltime) stime,count(pl.ltime) scount from ebh_playlogs pl 
			join ebh_roomcourses rc on rc.cwid=pl.cwid
			join ebh_classrooms cr on cr.crid=rc.crid
			join ebh_folders f on f.folderid=rc.folderid
			join ebh_users u on pl.uid=u.uid
			join ebh_classstudents cs on cs.uid=pl.uid
			join ebh_classes cl on cs.classid=cl.classid';
			$wherearr[]= 'cr.crid='.$param['crid'];
			$wherearr[]= 'cl.crid='.$param['crid'];
			$wherearr[]= 'pl.totalflag=0';
			if(!empty($param['starttime'])){
				$wherearr[] = 'pl.startdate >= '.$param['starttime'];
			}
			if(!empty($param['endtime'])){
				$wherearr[] = 'pl.startdate <= '.$param['endtime'];
			}
			if(!empty($param['classid']))
				$wherearr[]= 'cl.classid='.$param['classid'];
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.= ' group by username,foldername order by cl.classid,u.uid';
			// echo $sql;
			$studylist = $this->db->query($sql)->list_array();
			return $studylist;
		}

		//获取学生对应课件的播放记录
		public function getStuLog($param = array()){
			if(empty($param)){
				return array();
			}
			$sql='select p.uid,p.cwid,p.totalflag,p.finished from ebh_playlogs p';
			$wherearr = array();
			if(!empty($param['uid'])){
				$wherearr[] = 'p.uid = '.$param['uid'];
			}
			if(!empty($param['cwid'])){
				$wherearr[] = 'p.cwid = '.$param['cwid'];
			}
			if(!empty($param['finished'])){
				$wherearr[] = 'p.finished = '.$param['finished'];	
			}
			if(!empty($param['checkTime'])){
				$wherearr[] = 'p.ctime*0.9 <= p.ltime';
			}
			if(!empty($param['totalflag'])){
				$wherearr[] = 'p.totalflag = '.$param['totalflag'];
			}
			if(!empty($wherearr)){
				$sql.=' WHERE '.implode(' AND ',$wherearr);
			}
			return $this->db->query($sql)->list_array();
		}
		/**
		*根据课件编号和用户编号组合字符串获取对应的学习日志
		*/
		public function getLogListByUidStr($cwid,$uidstr,$group=false) {
			if(empty($cwid) || empty($uidstr)) {
				return FALSE;
			}
			$logsql = 'select *from ebh_playlogs pl where pl.cwid='.$cwid.' and pl.uid in ('.$uidstr.')';
            if($group){
                $logsql.= ' group by pl.uid';
            }
            $logsql .=' order by pl.uid';
			return $this->db->query($logsql)->list_array();
		}
		/**
		 *获取学生的听课记录 (课程或者课件或者学生从数据库删除了则忽略该记录)
		 */
		public function getListForClassroom2($queryarr = array()){
			//获取班级学生(包括user表里面有的和没的)
			if(!empty($queryarr['classid'])){
				$sql_for_uid = "select cs.uid as uid,cs.classid,classname from ebh_classstudents cs join ebh_classes c on cs.classid = c.classid  where c.classid = ".$queryarr['classid'];
				$wherearr[]= 'cl.classid='.$queryarr['classid'];	
			}else{
				$sql_for_uid = 'select cs.uid as uid,cs.classid,classname from ebh_classstudents cs join ebh_classes c on cs.classid = c.classid  where cs.classid in (select classid from ebh_classes where crid = '.$queryarr['crid'].')';
			}
			
		    $uidArrList = $this->db->query($sql_for_uid)->list_array();
		    if(empty($uidArrList)){
		    	//班级或者学校没有一个学生
		    	return array();
		    }
		   	$uid_classname_map = array();
		    $uid_in = array();
		    foreach ($uidArrList as $uidArr) {
		    	$uid_classname_map['udm_'.$uidArr['uid']] = $uidArr['classname'];
		    	$uid_in[] = $uidArr['uid'];
		    }
		    //获取班级学生(剔除掉user表里面没有的学生)
			$othercolumns = '';
			$showschoolname = FALSE;
			if(isset($queryarr['showschoolname'])) {	//如果需要显示学生单位信息（即schoolname字段）
				$othercolumns = ',schoolname';
				$showschoolname = TRUE;
			}
		    $sql_for_uid_filter = 'select u.uid,u.username,u.realname'.$othercolumns.' from ebh_users u where uid in ('.implode(',', $uid_in).')';
		    if(!empty($queryarr['limit'])) {
		        $sql_for_uid_filter .= ' limit '. $queryarr['limit'];
		        } else {
					if (empty($queryarr['page']) || $queryarr['page'] < 1)
						$page = 1;
					else
						$page = $queryarr['page'];
					$pagesize = empty($queryarr['pagesize']) ? 10 : $queryarr['pagesize'];
					$start = ($page - 1) * $pagesize;
		            $sql_for_uid_filter .= ' limit ' . $start . ',' . $pagesize;
		    }

		    $userList = $this->db->query($sql_for_uid_filter)->list_array();
		    if(empty($userList)){
		    	//虽然班级里面有学生但是用户表里面一个也没有对应的学生,也就是说符合条件的学生在users表里不存在
		    	return array();
		    }
		    $uid_userinfo_map = array();
		    $uid_in = array();
		    foreach ($userList as $user) {
		    	$uid_userinfo_map['uum'.$user['uid']] = $user;
		    	$uid_in[] = $user['uid'];
		    }
		    $wherearr = array();

		    //$sql_for_playlogs = "select pl.uid,pl.ctime,pl.ltime,pl.cwid,f.folderid,f.foldername from ebh_playlogs pl join ebh_roomcourses rc on pl.cwid = rc.cwid join ebh_folders f on rc.folderid = f.folderid join ebh_coursewares cw on pl.cwid = cw.cwid";
		    
		    $sql_for_playlogs = "select pl.uid,pl.ctime,pl.ltime,pl.cwid,rc.folderid from ebh_playlogs pl join ebh_roomcourses rc on pl.cwid = rc.cwid";
			
			if(!empty($uid_in)){
				$wherearr[] = 'pl.uid in ('.implode(',', $uid_in).')';
			}
			if(!empty($queryarr['starttime'])){
				$wherearr[] = 'pl.lastdate >='.$queryarr['starttime'];
			}
			if(!empty($queryarr['endtime'])){
				$wherearr[] = 'pl.lastdate <='.$queryarr['endtime'];
			}
			$wherearr[] = 'pl.totalflag = 0';
			$wherearr[] = 'rc.crid = '.$queryarr['crid'];
			if(!empty($wherearr)){
				$sql_for_playlogs .= ' WHERE '.implode(' AND ', $wherearr);
			}
			$sql_for_playlogs .= ' order by pl.uid,pl.cwid';
			$loglist = $this->db->query($sql_for_playlogs)->list_array();
			if(empty($loglist)){
				if(!empty($queryarr['get_nologs'])){
					$reuturnArr = array();
					foreach ($uid_in as $uid) {
							$userinfo = $uid_userinfo_map['uum'.$uid];
							$item = array(
								'uid'=>$uid,
								'scount'=>0,
								'stime'=>0,
								'ctime'=>0,
								'classname'=>$uid_classname_map['udm_'.$uid],
								'foldername'=>'无',
								'folderid'=>0,
								'username'=>$userinfo['username'],
								'realname'=>$userinfo['realname'],
								'tag'=>1
							);
							if($showschoolname) {
								$item['schoolname'] = $userinfo['schoolname'];
							}
							$reuturnArr[] = $item;
					}
					return $reuturnArr;
				}else{
					return array();
				}
			}

			$folderid_in = $this->_getFieldArr($loglist,'folderid');
			$sql_for_folderinfo = 'select f.folderid,f.foldername from ebh_folders f where f.folderid in ('.implode(',',$folderid_in).')';
			$folderList = $this->db->query($sql_for_folderinfo)->list_array();
			if(empty($folderList)){
				//课程全删了 什么都没有了
				return array();
			}
			$folderid_foldername_map = array();
			foreach ($folderList as $folder) {
				$folderid_foldername_map['ffm_'.$folder['folderid']] = $folder['foldername'];
			}

			$cwid_in = $this->_getFieldArr($loglist,'cwid');
			$sql_for_cwid = 'select cw.cwid from ebh_coursewares cw where cw.cwid in ('.implode(',', $cwid_in).')';
			$cwidList = $this->db->query($sql_for_cwid)->list_array();
			if(empty($cwidList)){
				//课件都没了，什么都没了
				return array();
			}
			$cwid_cwid_map = array();
			foreach ($cwidList as $cwidinfo) {
				$cwid_cwid_map['ccm_'.$cwidinfo['cwid']] = $cwidinfo;
			}

			$reuturnArr = array();

			foreach ($loglist as $log) {
				if(empty($cwid_cwid_map['ccm_'.$log['cwid']])){
					//这一步主要用来剔除掉课件不存在[课件被彻底删除了]的记录
					continue;
				}
				$key = $log['uid'].$log['folderid'];
				if(!array_key_exists($key, $reuturnArr)){
					if(empty($folderid_foldername_map['ffm_'.$log['folderid']])){
						//这一步主要用来剔除掉课程不存在[课程被删除了]的记录
						continue;
					}else{
						$foldername = $folderid_foldername_map['ffm_'.$log['folderid']];
					}
					$userinfo = $uid_userinfo_map['uum'.$log['uid']];
					$item = array(
						'uid'=>$log['uid'],
						'scount'=>1,
						'stime'=>$log['ltime'],
						'ctime'=>$log['ctime'],
						'classname'=>$uid_classname_map['udm_'.$log['uid']],
						'foldername'=>$foldername,
						'folderid'=>$log['folderid'],
						'username'=>$userinfo['username'],
						'realname'=>$userinfo['realname']
					);
					if($showschoolname) {
						$item['schoolname'] = $userinfo['schoolname'];
					}
					$reuturnArr[$key] = $item;
				}else{
					$reuturnArr[$key]['scount']++;
					$reuturnArr[$key]['stime'] += $log['ltime'];
				}

			}

			//是否获取没有记录的学生列表
			if(!empty($queryarr['get_nologs'])){
				$hasLogUids = $this->_getFieldArr($reuturnArr,'uid');
				foreach ($uid_in as $uid) {
					if(!in_array($uid, $hasLogUids)){
						$userinfo = $uid_userinfo_map['uum'.$uid];
						$item = array(
							'uid'=>$uid,
							'scount'=>0,
							'stime'=>0,
							'ctime'=>0,
							'classname'=>$uid_classname_map['udm_'.$uid],
							'foldername'=>'无',
							'folderid'=>0,
							'username'=>$userinfo['username'],
							'realname'=>$userinfo['realname'],
							'tag'=>1
						);
						if($showschoolname) {
							$item['schoolname'] = $userinfo['schoolname'];
						}
						$reuturnArr[] = $item;
					}
				}
			}
			return array_values($reuturnArr);
		}

		public function getListForClassroomCount2($queryarr = array()){
			//获取班级学生(包括user表里面有的和没的)
			if(!empty($queryarr['classid'])){
				$sql_for_uid = "select cs.uid as uid,cs.classid,classname from ebh_classstudents cs join ebh_classes c on cs.classid = c.classid  where c.classid = ".$queryarr['classid'];
				$wherearr[]= 'cl.classid='.$queryarr['classid'];	
			}else{
				$sql_for_uid = 'select cs.uid as uid,cs.classid,classname from ebh_classstudents cs join ebh_classes c on cs.classid = c.classid  where cs.classid in (select classid from ebh_classes where crid = '.$queryarr['crid'].')';
			}
			
		    $uidArrList = $this->db->query($sql_for_uid)->list_array();
		    if(empty($uidArrList)){
		    	//班级或者学校没有一个学生
		    	return 0;
		    }
		   	$uid_classname_map = array();
		    $uid_in = array();
		    foreach ($uidArrList as $uidArr) {
		    	$uid_classname_map['udm_'.$uidArr['uid']] = $uidArr['classname'];
		    	$uid_in[] = $uidArr['uid'];
		    }
		    //获取班级学生(剔除掉user表里面没有的学生)
		    $sql_for_uid_filter = 'select count(uid) as count from ebh_users u where uid in ('.implode(',', $uid_in).')';
		    $ret = $this->db->query($sql_for_uid_filter)->row_array();
		    return $ret['count'];	
		}

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
		
		/*
		课件的学习监察
		*/
		public function getLogsByCwid($param){
			$sql = 'select u.username,u.face,u.sex,u.realname,p.ltime,sum(totalflag=0) logcount,p.startdate,p.lastdate,c.classname from ebh_playlogs p 
				join ebh_roomusers ru on p.uid=ru.uid
				join ebh_users u on ru.uid=u.uid
				join ebh_classstudents cs on cs.uid=ru.uid
				join ebh_classes c on cs.classid=c.classid';
			$wherearr[] = 'p.cwid='.$param['cwid'];
			$wherearr[] = 'ru.crid='.$param['crid'];
			$wherearr[] = 'c.crid='.$param['crid'];
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.= ' group by p.uid';
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
			return $this->db->query($sql)->list_array();
		}
		/*
		课件的学习监察数量
		*/
		public function getLogsCountByCwid($param){
			$sql = 'select count(*) count from ebh_playlogs p 
				join ebh_roomusers ru on p.uid=ru.uid
				join ebh_users u on ru.uid=u.uid
				join ebh_classstudents cs on cs.uid=ru.uid
				join ebh_classes c on cs.classid=c.classid';
			$wherearr[] = 'p.cwid='.$param['cwid'];
			$wherearr[] = 'ru.crid='.$param['crid'];
			$wherearr[] = 'c.crid='.$param['crid'];
			$wherearr[] = 'totalflag=1';
			$sql.= ' where '.implode(' AND ',$wherearr);
			$count = $this->db->query($sql)->row_array();
			return $count['count'];
		}
		
		/*
		学校学员动态
		*/
		public function getRoomRecentLog($param){
			$sql = 'select u.realname,u.username,p.lastdate,u.sex,u.face,c.title from ebh_playlogs p 
				join ebh_roomcourses rc on p.cwid=rc.cwid 
				join ebh_users u on u.uid=p.uid
				join ebh_coursewares c on c.cwid=p.cwid';
			$wherearr[] = 'rc.crid='.$param['crid'];
			// $wherearr[] = 'rc.crid='.$param['crid'];
			$sql .= ' where '.implode(' AND ',$wherearr);
			$sql .= ' order by p.lastdate desc';
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
			return $this->db->query($sql)->list_array();
		}
		
		/*
		多个课件学生学习人数,param:cwid,uids
		*/
		public function getCWStudynumByUidStr($param){
			$sql = 'select cwid,count(*) count,uid from ebh_playlogs pl where pl.cwid in ('.$param['cwids'].') and totalflag=1 and pl.uid in ('.$param['uids'].') group by pl.cwid ';
			return $this->db->query($sql)->list_array();
		}
		
		/*
		每个学生单课累积时长
		*/
		public function getCWSumltimeList($param){
			$sql = 'select sum(ltime) sumltime,uid from ebh_playlogs';
			$wherearr[] = 'uid in ('.$param['uids'].')';
			$wherearr[] = 'cwid='.$param['cwid'];
			$wherearr[] = 'totalflag=0';
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.=' group by uid order by sumltime desc';
			return $this->db->query($sql)->list_array();
		}

        /*
        * 获取学生课件学习时长
        */
        public function getPlayTime($param){
            $sql = 'select sum(ltime) as ltime from ebh_playlogs pl left join ebh_roomcourses rc on rc.cwid=pl.cwid';
            $where = ' where totalflag=0';
            if(!empty($param['uid'])){
                $where.=' and pl.uid ='.$param['uid'];
            }
            if(!empty($param['crid'])){
                $where.= ' and rc.crid ='.$param['crid'];
            }
            if(!empty($param['Y'])){
                $where .= ' and FROM_UNIXTIME(pl.lastdate,\'%Y\') = '.$param['Y'];
            }
            if(!empty($param['m'])){
                $where .= ' and FROM_UNIXTIME(pl.lastdate,\'%c\') = '.$param['m'];
            }
            if(!empty($param['day'])){
                $where .= ' and FROM_UNIXTIME(pl.lastdate,\'%e\') = '.$param['day'];
            }
            $sql.=$where;
            $time = $this->db->query($sql)->row_array();
            return $time['ltime'];

        }

        /**
         * 根据uid和cwid来获取用户观看课件的次数
         */
        public function getCountByCwid($param){
        	$sql = 'select count(*) as count from `ebh_playlogs`';
        	$where = ' where totalflag = 0';
        	if(!empty($param['uid'])){
        		$where.=' and uid = '.$param['uid'];
        	}
        	if(!empty($param['cwid'])){
        		$where.=' and cwid = '.$param['cwid'];
        	}
        	$sql.=$where;
        	$count = $this->db->query($sql)->row_array();
        	return $count['count'];
        }
        /**
         * [getCWStudyByUidStr 根据uid和cwid获取一个课件的观看的人数]
         * @param  [type] $param [description]
         * @return [type]        [description]
         */
        public function getCWStudyByUidStr($param){
        	$sql = 'select count(cwid) as count from `ebh_playlogs`';
        	$where = ' where totalflag = 1';
        	if(!empty($param['cwids'])){
        		$where.=' and cwid = '.$param['cwids'];
        	}
        	if(!empty($param['uids'])){
        		$where.=' and uid in('.$param['uids'].')';
        	}
        	$sql.=$where;
        	//echo $sql;
        	$count = $this->db->query($sql)->row_array();
        	return $count['count'];
        }
		
		/*
		 * 课程累计学习时长,按学生分组
		*/
		public function getFolderStudyByUidStr($param){
			if(empty($param['folderid']) || empty($param['uidstr'])){
				return FALSE;
			}
			$sql = 'select sum(ltime) ltime,uid from ebh_playlogs';
			$wherearr[] = 'totalflag=0';
			$wherearr[] = 'folderid='.$param['folderid'];
			$wherearr[] = 'uid in ('.$param['uidstr'].')';
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.= ' group by uid';
			return $this->db->query($sql)->list_array('uid');
		}
		
		/*
		 * 完成的课件统计
		*/
		public function getFolderFinishedByUidStr($param){
			if(empty($param['folderid']) || empty($param['uidstr'])){
				return FALSE;
			}
			$sql = 'select count(*) count,uid from ebh_playlogs';
			$wherearr[] = 'totalflag=1';
			$wherearr[] = 'folderid='.$param['folderid'];
			$wherearr[] = 'uid in ('.$param['uidstr'].')';
			$wherearr[] = 'finished=1';
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.= ' group by uid';
			return $this->db->query($sql)->list_array('uid');
		}
		
		/*
		 * 学生整个学校的学习时间
		 * @param $param [array]  uid,crid
		*/
		public function getTimeByCrid($param){
			if(empty($param['uid']) || empty($param['crid'])){
				return FALSE;
			}
			$sql = 'select sum(ltime) ltime from ebh_playlogs ';
			$wherearr[] = 'uid='.$param['uid'];
			$wherearr[] = 'crid='.$param['crid'];
			$wherearr[] = 'totalflag=0';
			$sql.= ' where '.implode(' AND ',$wherearr);
			$row = $this->db->query($sql)->row_array();
			return $row['ltime'];
		}
		
		/*
		 * 学生累计时间 和 完成数量(同一课件只记一次) 按课程分组
		 * @param $param [array]  uid,folderids
		*/
		public function getTimeForForFolderCredit($param){
			if(empty($param['uid']) || empty($param['folderids'])){
				return FALSE;
			}
			$sql = 'select sum(ltime) ltime,folderid,count(DISTINCT CASE WHEN finished=1 THEN cwid END) finishedcount from ebh_playlogs';
			$wherearr[] = 'uid='.$param['uid'];
			$wherearr[] = 'folderid in ('.$param['folderids'].')';
			$wherearr[] = 'totalflag=0';
			$sql.= ' where '.implode(' AND ',$wherearr);
			$sql.= ' group by folderid';
			return $this->db->query($sql)->list_array('folderid');
		}
	}