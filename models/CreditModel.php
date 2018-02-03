<?php
/*
积分
*/
class CreditModel extends CModel{
	/*
	会员积分明细列表
	@param int $uid
	@param array $param
	@return array 
	*/
	public function getCreditList($param){
		$sql = 'select c.credit,c.dateline,i.rulename,i.action,i.description,c.detail,c.type
		from ebh_creditlogs c
		left join ebh_creditrules i on c.ruleid = i.ruleid ';
		//$wherearr[] = '(c.toid='.$param['toid'].' or (c.type=1 and '.$param['toid'].'<=382685))';
		$wherearr[] = ' c.toid='.$param['toid'];
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if(!empty($param['isact']))
			$wherearr[] = 'isact='.$param['isact'];
		if(!empty($param['datefrom']))
			$wherearr[] = 'c.dateline>'.$param['datefrom'];
		if(!empty($param['dateto']))
			$wherearr[] = 'c.dateline<='.$param['dateto'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' order by c.logid desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
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
	 * 根据uids批量获取会员积分
	 * 对取数据进行优化，分部获取数据
	 */
	public function getCreditByUids($param){
		if(empty($param['uids'])){
			return false;
		}
		//1,先根据uid获取对应用户获取的最新积分logid
		$logidsql = 'select max(logid) as logid,toid from ebh_creditlogs where toid in ('.implode(',',$param['uids']).') group by toid';
		$logidlist = $this->db->query($logidsql)->list_array();
		if(empty($logidlist))
			return FALSE;
		$creditlist = array();
		$logidarr = array();
		foreach($logidlist as $logid) {
			$creditlist[$logid['toid']] = $logid;
			$logidarr[] = $logid['logid'];
		}
		//2，根据获取的logid获取积分记录
		$sql = 'select c.logid,c.credit,c.dateline,c.toid,i.rulename,i.action,i.description,c.detail '.
				'from ebh_creditlogs c left join ebh_creditrules i on c.ruleid = i.ruleid '.
				'where c.logid in  ('.implode(',',$logidarr).')';
		$list = $this->db->query($sql)->list_array();
		if(empty($list))
			return FALSE;
		foreach($list as $credit) {
			if(isset($creditlist[$credit['toid']])) {
				$creditlist[$credit['toid']] = $credit;
			}
		}
		return $creditlist;
	}
	
	/**
	 * 根据crid获取同个网校下的会员积分 
	 * 此方法待优化 暂时先返回FALSE
	 */
	public function getCreditByCrid($param){
		return FALSE;
		if(empty($param['crid'])){
			return false;
		}
		$where = "1";
		if(!empty($param['nuids'])){
			$where = " c.toid not in (".implode(',',$param['nuids']).")";
		}
		$sql = 'select u.uid,u.username,u.realname,u.face,u.sex,u.groupid,c.credit,c.dateline,i.rulename,i.action,i.description,c.detail
		from ebh_creditlogs c
		left join ebh_users u on c.toid = u.uid
		left join ebh_roomusers ru on ru.uid = u.uid 
		left join ebh_creditrules i on c.ruleid = i.ruleid
		where c.dateline=((select max(dateline) from `ebh_creditlogs` where toid = c.toid)) and ru.crid = '.$param['crid'].' and '.$where;
		$sql.= ' group by c.toid order by c.dateline desc, c.logid desc';
		
		if(!empty($param['limit'])){
			$sql.= ' limit '.$param['limit'];
		}else{
			if(empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
				
			$pagesize = empty($param['pagesize']) ? 5 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		return $this->db->query($sql)->list_array();
	}
	
	/*
	积分记录数量
	@param int $uid
	*/
	public function getUserCreditCount($param){
		$wherearr = array();
		$sql = 'select count(*) count from ebh_creditlogs';
		if(!empty($param['uid']))
			$wherearr[]= 'uid='.$param['uid'];
		if(!empty($param['toid']))
			$wherearr[]= 'toid='.$param['toid'];
		if(!empty($param['ruleid']))
			$wherearr[]= 'ruleid='.$param['ruleid'];
		if(!empty($param['credit']))
			$wherearr[]= 'credit='.$param['credit'];
		if(!empty($param['dateline']))//特殊条件
			$wherearr[]= $param['dateline'];
		if(!empty($param['type']))
			$wherearr[]= 'type='.$param['type'];
		if(!empty($param['crid']))
			$wherearr[] = 'crid='.$param['crid'];
		if(!empty($param['isact']))
			$wherearr[] = 'isact='.$param['isact'];
		if(!empty($param['datefrom']))
			$wherearr[] = 'dateline>'.$param['datefrom'];
		if(!empty($param['dateto']))
			$wherearr[] = 'dateline<='.$param['dateto'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		// log_message($sql);
		// echo $sql;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	积分兑换记录
	@param array $param
	*/
	public function getOrderList($param){
		$sql = 'SELECT o.*,p.productname,p.image,p.credit FROM ebh_orders o left join ebh_products p ON o.pid=p.productid';
		if(!empty($param['uid']))
			$sql.= ' WHERE o.uid = '.$param['uid'];
		$sql.=' ORDER BY o.oid desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
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
	积分兑换记录详细（包括用户名和平台名称）
	@param array $param
	*/
	public function getOrderListDetail($param){
		$sql = 'SELECT o.*,p.productname,p.image,p.credit FROM ebh_orders o
			left join ebh_products p ON o.pid=p.productid';
		if(!empty($param['uid']))
			$sql.= ' WHERE o.uid = '.$param['uid'];
		$sql.=' ORDER BY o.oid desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else{
			if(empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		$list = $this->db->query($sql)->list_array();

		//获取账号和平台名称
		if (!empty($list))
		{
			//获取用户ID数组
			$uidarray = array();
			foreach ($list as $value) {
				$uidarray[] = $value['uid'];
			}
			//查询用户数据
			$usql = 'SELECT u.uid,u.username,u.realname,cr.crname FROM ebh_users u
			left join ebh_roomusers ru ON u.uid = ru.uid
			left join ebh_classrooms cr ON cr.crid = ru.crid
			WHERE u.uid in ('.implode(',',$uidarray).') GROUP BY u.uid';
			$user_list = $this->db->query($usql)->list_array();
			$user_array = array();
			foreach ($user_list as $value) {
				$user_array[$value['uid']] = $value;
			}
			//组合用户数据
			foreach ($list as $key => $value) {
				$list[$key]['username'] = $user_array[$value['uid']]['username'];
				$list[$key]['realname'] = $user_array[$value['uid']]['realname'];
				$list[$key]['crname'] = $user_array[$value['uid']]['crname'];
				$list[$key]['expressNo'] = $value['expressNo'] === NULL ? '' : $value['expressNo'];
				$list[$key]['expressname'] = $value['expressname'] === NULL ? '' : $value['expressname'];
			}
		}
		return $list;
	}
	/*
	积分兑换数量
	*/
	public function getOrderCount($param){
		$sql = 'select count(*) count from ebh_orders';
		if(!empty($param['uid']))
			$sql.= ' where uid='.$param['uid'];
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	根据ruleid查看积分规则信息
	@param int $ruleid
	*/
	public function getCreditRuleInfo($ruleid){
		$sql = 'select r.rulename,r.action,r.credit,r.actiontype,r.maxaction
			from ebh_creditrules r where r.ruleid='.$ruleid;
		return $this->db->query($sql)->row_array();
	}
	/*
	添加积分日志,并修改积分
	@param array $param ruleid, toid/aid..
	*/
	public function addCreditlog($param){
		if(is_numeric($param))
			$logarr['ruleid'] = $param;
		else
			$logarr['ruleid'] = $param['ruleid'];
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($roominfo))
			$crid = 0;
		else 
			$crid = $roominfo['crid'];
		if(!empty($param['uid']))
			$logarr['uid'] = $param['uid'];
		else
			$logarr['uid'] = $user['uid'];
		
		
		
		$flag = 0;
		if(!empty($param['uid'])){//指定了受分对象的
			$logarr['toid'] = $param['uid'];
		}else if(!empty($param['aid'])){//指定了答疑号的,被采纳为最佳答案
			$sql = 'select q.uid,a.uid toid,q.title,q.qid from ebh_askanswers a 
				join ebh_askquestions q on (q.qid=a.qid)';
			$warr[] = 'a.aid='.$param['aid'];
			// $warr[] = 'q.uid='.$logarr['uid'];
			$sql.= ' where '.implode(' AND ',$warr);
			$temp = $this->db->query($sql)->row_array();
			//var_dump($sql);
			
			$logarr['uid'] = empty($param['qid']) ? $temp['qid'] : $param['qid'];//记录qid
			$logarr['toid'] = $temp['toid'];
			$logarr['type'] = 3;
			$logarr['detail'] = $temp['title'];
		}else if(!empty($param['qid'])){//指定了qid的,回答问题
			$sql = 'select q.title,q.qid from ebh_askquestions q';
			$warr[] = 'q.qid='.$param['qid'];
			$sql.= ' where '.implode(' AND ',$warr);
			$temp = $this->db->query($sql)->row_array();
			$logarr['toid'] = $logarr['uid'];
			$logarr['uid'] = $temp['qid'];
			$logarr['detail'] = $temp['title'];
			$logarr['type'] = 3;
		}else if(!empty($param['eid'])){//指定了eid的,完成作业
			$sql = 'select crid,totalscore/score*100 percent from ebh_schexams e 
					join ebh_schexamanswers a on e.eid=a.eid ';
			$warr[] = 'e.eid='.$param['eid'];
			$warr[] = 'a.uid='.$logarr['uid'];
			$sql.= ' where '.implode(' AND ',$warr);
			$temp = $this->db->query($sql)->row_array();
			if($temp['percent']==100)
				$param['credit'] = 10;
			elseif($temp['percent']>=80)
				$param['credit'] = 7;
			elseif($temp['percent']>=60)
				$param['credit'] = 6;
			else
				$param['credit'] = 5;
			$logarr['crid'] = $temp['crid'];
			$logarr['toid'] = $logarr['uid'];
			$logarr['detail'] = $param['detail'];
			$logarr['type'] = 4;
		}elseif(!empty($param['cwid']) && $param['ruleid'] != 5){
			$sql = 'select cw.title,cw.cwid,cw.uid from ebh_coursewares cw';
			$warr[] = 'cw.cwid='.$param['cwid'];
			$sql.= ' where '.implode(' AND ',$warr);
			$temp = $this->db->query($sql)->row_array();
			$logarr['uid'] = $param['cwid'];
			$logarr['detail'] = $temp['title'];
			$logarr['toid'] = $temp['uid'];
			// $logarr['type'] = 0;
		}else{//没有指定，则为自己
			$logarr['toid'] = $logarr['uid'];
		}
		$ruleinfo = $this->getCreditRuleInfo($logarr['ruleid']);
		//每次都增加
		if($ruleinfo['actiontype'] == 0){
			$flag = 1;
		}
		//只一次
		elseif($ruleinfo['actiontype'] == -1){
			$wherearr['toid'] = $logarr['toid'];
			$wherearr['ruleid'] = $logarr['ruleid'];
			$logcount = $this->getUserCreditCount($wherearr);
			if($logcount>0)
				return ;
			else{
				$flag=1;
			}
		}
		//每天增加有限次数
		elseif($ruleinfo['actiontype'] == -2){
			$today = strtotime(Date('Y-m-d'));
			$wherearr['toid'] = $logarr['toid'];
			$wherearr['ruleid'] = $logarr['ruleid'];
			$wherearr['dateline'] = ' dateline>'.$today.' and dateline<'.($today+86400);
			$logcount = $this->getUserCreditCount($wherearr);
			if($logcount>=$ruleinfo['maxaction']){
				if(!empty($param['nocheck'])&&($param['nocheck']==true)){//抽奖再来一次不需要检测最大次数;权限由控制器给出
					$flag=1;
				}else{
					return ;
				}
				
			}else{
				$uniqueconfirm = 0;
				if(!empty($param['cwid'])){
					$wherearr['uid'] = $param['cwid'];
					$wherearr['type'] = 2;
					$uniqueconfirm = 1;
				}elseif(!empty($param['qid'])){
					$wherearr['uid'] = $param['qid'];
					$wherearr['type'] = 3;
					$uniqueconfirm = 1;
				}
				if($uniqueconfirm){
					$logcount = $this->getUserCreditCount($wherearr);
					if($logcount>0)
						return;
					else{
						$logarr['type'] = $wherearr['type'];
						$logarr['uid'] = $wherearr['uid'];
					}
				}
				$flag=1;
			}
		}
		
		//课件特殊处理,学一次只得一次积分,改天再学也没有积分
		elseif($ruleinfo['actiontype'] == 1 && !empty($param['cwid'])){
			$wherearr = array();
			$wherearr['toid'] = $logarr['toid'];
			$wherearr['ruleid'] = $logarr['ruleid'];
			$wherearr['uid'] = $param['cwid'];
			$wherearr['type'] = 2;
			$logcount = $this->getUserCreditCount($wherearr);
			if($logcount>0)
				return;
			else{
				$logarr['type'] = $wherearr['type'];
				$logarr['uid'] = $wherearr['uid'];
				$flag = 1;
			}
		}
		//按时间段增加
		else{
			return;
		}
		
		//添加记录并增加toid的积分
		if($flag){
			if($logarr['ruleid'] == 16 && isset($param['productid']) && isset($param['credit'])){//积分兑换
				$logarr['credit'] = $param['credit'];
				$logarr['productid'] = $param['productid'];
			}
			elseif(isset($param['credit']))
				$logarr['credit'] = $param['credit'];
			else
				$logarr['credit'] = $ruleinfo['credit'];
			$logarr['dateline'] = SYSTIME;
			$logarr['fromip'] = getip();
			if(!empty($param['detail']))
				$logarr['detail'] = $param['detail'];
			
			//活动id添加crid
			$actids = array(5,7,13,14,15,21);
			if(in_array($logarr['ruleid'],$actids)){
				$logarr['crid'] = empty($logarr['crid'])?$crid:$logarr['crid'];
				$tsql = 'select logid from ebh_studentactivitys sa 
						join ebh_activitys a on sa.aid=a.aid';
				$twhere[] = 'uid='.$logarr['toid'];
				$twhere[] = 'sa.crid='.$logarr['crid'];
				$twhere[] = 'endtime+86400>'.SYSTIME;//截止日的23:59
				$twhere[] = 'starttime<='.SYSTIME;
				$tsql .= ' where '.implode(' AND ',$twhere);
				$actloglist = $this->db->query($tsql)->list_array();
				// var_dump($actloglist);
				// log_message($tsql);
				if($actloglist){
					$logarr['isact'] = 1;
					$actlogids = '';
					foreach($actloglist as $actlog){
						$actlogids .= $actlog['logid'].',';
					}
					$actlogids = rtrim($actlogids,',');
					$tuwhere = 'logid in ('.$actlogids.')';
					$this->db->update('ebh_studentactivitys',array(),$tuwhere,array('credit'=>'credit+'.$logarr['credit']));
				
				}
			}
			if(!empty($param['qid']) && $param['ruleid'] == 33){//屏蔽问题，扣除积分
				$sql = 'select u.credit,q.uid,q.title from `ebh_users` u left join `ebh_askquestions` q on(q.uid = u.uid) where q.qid ='.intval($param['qid']);
				$credit = $this->db->query($sql)->row_array();
				if(!empty($credit) && $credit['credit'] > 0){
					$logarr = array(
							'ruleid' => $param['ruleid'],
							'uid' => $param['qid'],
							'toid' => $credit['uid'],
							'credit' => '1',
							'dateline' => SYSTIME,
							'fromip' => getip(),
							'detail' => $credit['title'],
							'type' => 5
						);
					$res = $this->db->insert('ebh_creditlogs',$logarr);
					$sparam = array('credit'=>'credit'.$ruleinfo['action'].$logarr['credit']);
					$this->db->update('ebh_users',array(),'uid='.$credit['uid'],$sparam);
					return true;
				}
			}elseif(!empty($param['aid']) && $param['ruleid'] == 34){//屏蔽回答，扣除积分
				$sql = 'select u.credit,a.uid from `ebh_users` u left join `ebh_askanswers` a on(a.uid = u.uid) where a.aid ='.intval($param['aid']);
				$credit = $this->db->query($sql)->row_array();
				if(!empty($credit) && $credit['credit'] > 0){
					$logarr = array(
							'ruleid' => $param['ruleid'],
							'uid' => $param['aid'],
							'toid' => $credit['uid'],
							'credit' => '1',
							'dateline' => SYSTIME,
							'fromip' => getip(),
							'detail' => $logarr['detail'],
							'type' => 5
						);
					$res = $this->db->insert('ebh_creditlogs',$logarr);
					$sparam = array('credit'=>'credit'.$ruleinfo['action'].$logarr['credit']);
					$this->db->update('ebh_users',array(),'uid='.$credit['uid'],$sparam);
					return true;
				}
			}
			// exit;
			$res = $this->db->insert('ebh_creditlogs',$logarr);
			$sparam = array('credit'=>'credit'.$ruleinfo['action'].$logarr['credit']);
			$this->db->update('ebh_users',array(),'uid='.$logarr['toid'],$sparam);
			
			if($ruleinfo['action'] == '+' && $logarr['ruleid'] != 29){
				$redis = $redis = Ebh::app()->getCache('cache_redis');
				$crcache = $redis->hget('credit',$crid);
				if(!is_array($crcache))
					$crcache = unserialize($crcache);
				$day = Date('Y/m/d',SYSTIME);
				if(isset($crcache[$day]))
					$crcache[$day] += $logarr['credit'];
				else
					$crcache[$day] = $logarr['credit'];
				if(!empty($crid))
					$redis->hset('credit',$crid,$crcache);
			}
			return $res;
		}
	}
	/*
	积分规则列表
	*/
	public function getCreditRuleList($param=null){
		$sql = 'select ruleid,rulename,action,credit,actiontype,maxaction,description from ebh_creditrules';
		if(!empty($param['action']))
			$wherearr[] = 'action=\''.$param['action'].'\'';
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
	}
	/*
	修改积分规则
	*/
	public function update($param){
		if(empty($param['ruleid']))
			return false;
		$setarr['rulename'] = $param['rulename'];
		$setarr['action'] = $param['action'];
		$setarr['credit'] = $param['credit'];
		$setarr['actiontype'] = $param['actiontype'];
		$setarr['maxaction'] = $param['maxaction'];
		$setarr['description'] = $param['description'];
		$this->db->update('ebh_creditrules',$setarr,'ruleid='.$param['ruleid']);
	}
	/*
	添加积分规则
	*/
	public function insert($param){
		$setarr['rulename'] = $param['rulename'];
		$setarr['action'] = $param['action'];
		$setarr['credit'] = $param['credit'];
		$setarr['actiontype'] = $param['actiontype'];
		$setarr['maxaction'] = $param['maxaction'];
		$setarr['description'] = $param['description'];
		$this->db->insert('ebh_creditrules',$setarr);
		
	}
	/*
	删除积分规则
	*/
	public function delete($ruleid){
		if(!empty($ruleid))
			return $this->db->delete('ebh_creditrules','ruleid='.$ruleid);
	}
	
	public function addRegLogs($fromuid,$stunum,$offset=1){
		$sql = 'select credit from ebh_creditrules where ruleid = 1';
		$res = $this->db->query($sql)->row_array();
		$credit = $res['credit'];
		if (empty($offset))
			$offset = 1;
		$sql = 'insert into ebh_creditlogs (ruleid,uid,toid,credit,dateline,fromip) values ';
		$ip = getip();
		$dateline = SYSTIME;
		for($i=0;$i<$stunum;$i++){
			$uid = $fromuid + $i*$offset;
			$sql.= "(1,$uid,$uid,$credit,$dateline,'$ip'),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
	}

	/**
	 *获取用户抽奖记录(用于抽奖页面滚动显示)
	 *
	 */
	public function getLotteryLogs($param = array()){
		$sql = 'select c.productid,u.username,u.realname from ebh_creditlogs c left join ebh_users u on c.uid = u.uid where c.productid in(1,2,3,4,5,6,7,8) order by c.logid desc limit 32';
		return $this->db->query($sql)->list_array();
	}
	/**
	 *获取用户当天抽奖的次数(除了再来一次)(用于判断用户是否有权限再抽一次奖)
	 */
	public function getTodayLogsCount($uid = 0){
		$today = strtotime(Date('Y-m-d'));
		$wherearr['dateline'] = ' dateline>'.$today.' and dateline<'.($today+86400);
		$sql = 'select count(logid) count from ebh_creditlogs c where c.uid = '.$uid .' and ruleid = 16 and dateline>'.$today.' and dateline<'.($today+86400).' and productid !=-2';
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}
	
	/*
	签到记录
	*/
	public function getSignLog($param){
		$sql = 'select dateline from ebh_creditlogs';
		$wherearr[] = 'ruleid=22';
		$wherearr[] = 'toid='.$param['uid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' order by logid desc';
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		return $this->db->query($sql)->list_array();
	}
    /**
     * 获取签到记录,用于日历
     */
    public function getSign($param){
        $sql = "select count(*) e,DATE_FORMAT(FROM_UNIXTIME(dateline) ,'%Y-%m-%d') as d,dateline from ebh_creditlogs";
        $wherearr[] = 'ruleid=22';
        if(!empty($param['uid']))
            $wherearr[] = 'uid='.$param['uid'];
        if(!empty($param['startDate']))
            $wherearr[] = 'dateline>='.$param['startDate'];
        if(!empty($param['endDate']))
            $wherearr[] = 'dateline<'.$param['endDate'];
        $sql.= ' where '.implode(' AND ',$wherearr);
        $sql.= ' group by d';
        $sql.= ' order by d desc';
        if(!empty($param['limit']))
            $sql.= ' limit '.$param['limit'];
        // echo $sql;
        return $this->db->query($sql)->list_array();
    }
	/**
	 * 获取签到次数
	 */
	public function getSignLogCount($param){
		$sql = 'select count(*) count from ebh_creditlogs';
		$wherearr[] = 'ruleid=22';
		$wherearr[] = 'toid='.$param['uid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(empty($row['count'])){
			$count = 0;
		}else{
			$count = $row['count'];
		}
		return $count;
	}
	
	/*
	积分进账
	*/
	public function getCreditComingList($param){
		$sql = 'select toid,sum(credit) sumcredit,sum(ruleid=22) sumsign,dateline,from_unixtime(dateline,\'%Y-%m-%d\') d from ebh_creditlogs';
		if(!empty($param['uids']))
			$wherearr[] = 'toid in ('.$param['uids'].')';
		if(!empty($param['ruleids']))
			$wherearr[] = '(ruleid in ('.$param['ruleids'].') or type = 1)';
		if(!empty($param['datefrom']))
			$wherearr[] = 'dateline>='.$param['datefrom'];
		if(!empty($param['dateto']))
			$wherearr[] = 'dateline<='.$param['dateto'];
		if(!empty($param['startdate']))
			$wherearr[] = 'dateline>='.$param['startdate'];
		if(!empty($param['enddate']))
			$wherearr[] = 'dateline<='.($param['enddate']+86400);
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['group']))
			$sql.= ' group by '.$param['group'];
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		else
			$sql.= ' order by d asc';
		return $this->db->query($sql)->list_array();
		
	}
	
	/*
	学生首页积分排名列表
	*/
	public function getRankList($param){
		$sql = 'select u.uid,u.username,u.realname,u.face,u.credit,u.sex,u.groupid 
				from ebh_users u 
				join ebh_roomusers ru on u.uid=ru.uid';
		if(!empty($param['crid']))
			$wherearr[] = 'ru.crid='.$param['crid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		else
			$sql.= ' order by credit desc';
		
		if(!empty($param['limit']))
			$sql.= ' limit '.$param['limit'];
		else
			$sql.= ' limit 3';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	 学生首页积分排名列表
	*/
	public function getRankListCount($param){
		$sql = 'select count(*) count from ebh_users u join ebh_roomusers ru on u.uid=ru.uid';
		if(!empty($param['crid']))
			$wherearr[] = 'ru.crid='.$param['crid'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		if(empty($row['count'])){
			$count = 0;
		}else{
			$count = $row['count'];
		}
		return $count;
	}
	
	/**
	 * 根据问题编号获得悬赏奖励者名单
	 * @param  int $qid 问题标号
	 * @return array      奖励者列表
	 */
	public function getRewardList($qid){
		$wherearr = array();
		$sql = 'SELECT u.username,u.realname,c.credit FROM ebh_creditlogs c LEFT JOIN ebh_users u ON c.toid=u.uid';
		$wherearr[] = 'c.ruleid=27';
		if (!empty($qid))
		{
			$wherearr[] = 'c.uid=' .intval($qid);
		}
		if (!empty($wherearr))
			$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		return $this->db->query($sql)->list_array();
	}

	/**
	 * 设置积分订单状态
	 * @param 参数 $param oid订单编号,status状态
	 */
	public function setOrderStatus($param){
		if(empty($param['oid']))
			return false;
		$setarr = array();
		if (isset($param['status']))
			$setarr['status'] = $param['status'];
		if (isset($param['expressname']))
			$setarr['expressname'] = $param['expressname'];
		if (isset($param['expressNo']))
			$setarr['expressNo'] = $param['expressNo'];
		if (isset($param['remark']))
			$setarr['remark'] = $param['remark'];
		$this->db->update('ebh_orders',$setarr,'oid='.$param['oid']);
	}
    //获取本教师积分排名
    public function getTeacherCreditList($param){
        if(empty($param['crid'])){
            return false;
        }else{
            $where=' where crid = '.$param['crid'];
        }
        $sql = 'select u.username,u.realname,u.credit from ebh_roomteachers rt left JOIN ebh_users u on rt.tid=u.uid';
        $where.=' and rt.status = 1';
        if($param['type']=='h'){
            $where.=' and u.credit>'.$param['credit'];
            $sql.=$where;
            $sql.=' order by u.credit desc';
            $sql.=' limit 0,5';
            $res = $this->db->query($sql)->list_array();
            return $res;
        }else{
            $where.=' and u.credit<='.$param['credit'];
            $where.=' and rt.tid!='.$param['uid'];
            $sql.=$where;
            $sql.=' order by u.credit desc';
            $sql.=' limit 0,11';
            $res = $this->db->query($sql)->list_array();
            return $res;
        }
    }
	/**
	* 获取网校内班级的积分排名
	*/
	public function getClassCreditList($param, $isAvg = false) {
		if(empty($param['crid']) || intval($param['crid']) <= 0){
            return false;
        }
		$crid = intval($param['crid']);
		$me = $isAvg ? 'avg' : 'sum';// 国土资源厅单位排名按平均分数，其他总分数
		$sql = 	"select c.classid, ceil(".$me."(u.credit)) credit from ebh_classes c ".
				"left join ebh_classstudents cs on (c.classid=cs.classid) ".
				"left join ebh_users u on (u.uid=cs.uid) ".
				"where c.crid=$crid ".
				"group by c.classid order by credit desc, c.classid asc ";
		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
		}
		$rlist = $this->db->query($sql)->list_array();
		if(empty($rlist))
			return FALSE;
		$classidstr = '';
		$ranklist = array();
		foreach($rlist as $rank) {
			if(empty($classidstr))
				$classidstr = $rank['classid'];
			else
				$classidstr .= ','.$rank['classid'];
			if(empty($rank['credit']))
				$rank['credit'] = 0;
			$ranklist[$rank['classid']] = $rank;
		}
		$classsql = "select classid,classname from ebh_classes where classid in ($classidstr)";
		$classlist = $this->db->query($classsql)->list_array();
		if (empty($classlist))
			return FALSE;
		foreach($classlist as $c) {
			if(isset($ranklist[$c['classid']])) {
				$ranklist[$c['classid']]['classname'] = $c['classname'];
			}
		}
		return $ranklist;
	}
}
?>