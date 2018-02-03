<?php

/**
 * 打赏model
 */
class RewardModel extends CModel{
	/**
	 * [insert 生成新的订单]
	 * @return [type] [description]
	 */
	public function insert($param = array()){
		$setarr = array();
		if(isset($param['sourceid'])){
			$setarr['sourceid'] = $param['sourceid'];
		}
		if(!empty($param['crid'])){
			$setarr['crid'] = $param['crid'];
		}
		if(!empty($param['uid'])){
			$setarr['uid'] = $param['uid'];
		}
		if(!empty($param['touid'])){
			$setarr['touid'] = $param['touid'];
		}
		if(!empty($param['toid'])){
			$setarr['toid'] = $param['toid'];
		}
		if(!empty($param['type'])){
			$setarr['type'] = $param['type'];
		}
		if(!empty($param['dateline'])){
			$setarr['dateline'] = $param['dateline'];
		}
		if(!empty($param['ordername'])){
			$setarr['ordername'] = $param['ordername'];
		}
		if(!empty($param['ordernumber'])){
			$setarr['ordernumber'] = $param['ordernumber'];
		}
		if(!empty($param['totalfee'])){
			$setarr['totalfee'] = $param['totalfee'];
		}
		if(!empty($param['ip'])){
			$setarr['ip'] = $param['ip'];
		}
		if(!empty($param['crid'])){
			$setarr['crid'] = $param['crid'];
		}
		if(!empty($param['remark'])){
			$setarr['remark'] = $param['remark'];
		}else{
			$setarr['remark'] = '';
		}
		return $this->db->insert('ebh_rewards', $setarr);
	}

	/**
	 * 对余额支付的用户和被打赏者双方的余额扣除和增加
	 */
	public function exchageBlance($uid,$touid,$money){
		if(empty($uid) || empty($touid) || empty($money)){
			return false;
		}	
			$sql = 'select balance from ebh_users where uid ='.intval($uid);
			$res = $this->db->query($sql)->row_array();
			if($res['balance'] < $money){
				log_message('扣款失败，支付用户余额不足！uid：'.$uid);
				return false;
			}
            $this->db->begin_trans();
            $sqluser = "update ebh_users set balance = balance - $money where uid =".intval($uid)." and balance >= $money";
            $resuser = $this->db->simple_query($sqluser);
            $sqltouser = "update ebh_users set balance = balance + $money where uid =".intval($touid);
            $restouser = $this->db->simple_query($sqltouser);
            if($this->db->trans_status() === FALSE || empty($resuser)){
            	$this->db->rollback_trans();
            	return false;
            }else{
            	$this->db->commit_trans();
           		return true;
            }      
	}
	/**
	 * 对于支付宝支付和微信支付 支付成功后将支付后的金额加入被打赏者的钱包
	 */
	public function transferByOrdernum($ordernum){
		if(empty($ordernum) || !is_numeric($ordernum)){
			return false;
		}
		//先根据订单号查询出打赏金额 和 被打赏者的uid
		$sql = 'select touid,totalfee from `ebh_rewards` where ordernumber ='.$ordernum.' limit 1';
		$rewardinfo = $this->db->query($sql)->row_array();
		if(!empty($rewardinfo)){
			$sqltouser = "update ebh_users set balance = balance + ".$rewardinfo['totalfee']." where uid =".intval($rewardinfo['touid']);
			$restouser = $this->db->simple_query($sqltouser);
			return $restouser;
		}
		return false;
	}
	/**
	 * 对打赏统计表更新或插入数据
	 */
	public function rewardStatistics($ordernum){
		if(!is_numeric($ordernum)){
			return false;
		}
		//先根据订单号 查出打赏者id 被打赏者的id 和课件评论的cwid
		$sql = 'select touid,totalfee,uid,type,toid from `ebh_rewards` where ordernumber =' . $ordernum . ' limit 1';
		$rewardinfo = $this->db->query($sql)->row_array();
		if(!empty($rewardinfo)){
			//根据uid和touid检查数据库中是否有记录
			$sqlcheck = 'select uid from `ebh_reward_totals` where uid ='.intval($rewardinfo['uid']).' or uid ='.intval($rewardinfo['touid']);
			$checklist = $this->db->query($sqlcheck)->list_array();
			if(count($checklist) == 2){//直接更新
				$rwtgetup = 'update ebh_reward_totals set getreward = getreward + '.$rewardinfo['totalfee'].' ,getcount = getcount+1 where uid ='.$rewardinfo['touid'];
				$rwtsendup = 'update ebh_reward_totals set sendreward = sendreward + '.$rewardinfo['totalfee'].' ,sendcount = sendcount+1 where uid ='.$rewardinfo['uid'];
				$upresultget = $this->db->simple_query($rwtgetup);
				$upresultsend = $this->db->simple_query($rwtsendup);
				if($upresultget && $upresultsend){
					$rewardres = true;
				}else{
					$rewardres = false;
				}
			} else if(count($checklist) == 0){//直接插入
				$insertsql = 'insert into `ebh_reward_totals` (uid,getreward,sendreward,getcount,sendcount) values ('.$rewardinfo['uid'].',0,'.$rewardinfo['totalfee'].',0,1),('.$rewardinfo['touid'].','.$rewardinfo['totalfee'].',0,1,0)';
				$updateres = $this->db->query($insertsql,false);
				if($updateres){
					$rewardres = true;
				}else{
					$rewardres = false;
				}
			} else {//有一个没有记录
				if($rewardinfo['uid'] == $checklist[0]['uid']){//打赏者有记录，被打赏者没有
					$insertid = $rewardinfo['touid'];
					$updateid = $rewardinfo['uid'];
					$insertsql = 'insert into `ebh_reward_totals` (uid,getreward,sendreward,getcount,sendcount) values ('.$insertid.','.$rewardinfo['totalfee'].',0,1,0)';
					$updatesql = 'update ebh_reward_totals set sendreward = sendreward +'.$rewardinfo['totalfee'].' ,sendcount = sendcount+1 where uid='.$updateid;
				}else{//打赏者没有记录，被打赏者有记录
					$insertid = $rewardinfo['uid'];
					$updateid = $rewardinfo['touid'];
					$insertsql = 'insert into `ebh_reward_totals` (uid,getreward,sendreward,getcount,sendcount) values ('.$insertid.',0,'.$rewardinfo['totalfee'].',0,1)';
					$updatesql = 'update ebh_reward_totals set getreward = getreward +'.$rewardinfo['totalfee'].' ,getcount = getcount+1 where uid='.$updateid;
				}
				$updateres = $this->db->query($insertsql,false);
				$upresultsend = $this->db->simple_query($updatesql);
				if($updateres && $upresultsend){
					$rewardres = true;
				}else{
					$rewardres = false;
				}
			}
			if($rewardinfo['type'] == 1){//课件打赏课件更新
				$cwup = 'update ebh_coursewares set rewardmoney = rewardmoney + '.$rewardinfo['totalfee'].' ,rewardcount = rewardcount + 1 where cwid ='.$rewardinfo['toid'];
				$cwres = $this->db->simple_query($cwup);
			} else {
				$cwres = true;
			}
			if($rewardres && $cwres){
				return true;
			}else{
				return false;
			}
		}
	}
	/**
	 * 支付成功，更新数据库
	 */
	public function updateOrder($param = array(),$ordernum,$istransfer = true){
		if(empty($ordernum) || !is_numeric($ordernum)){
			return false;
		}
		$setarr = array();
		if(!empty($param['paytime'])){
			$setarr['paytime'] = $param['paytime'];
		}else{
			$setarr['paytime'] = SYSTIME;
		}
		if(!empty($param['payfrom'])){
			$setarr['payfrom'] = $param['payfrom'];
		}
		if(!empty($param['payip'])){
			$setarr['payip'] = $param['payip'];
		}
		if(!empty($param['status'])){
			$setarr['status'] = $param['status'];
		}
		if(!empty($param['paycode'])){
			$setarr['paycode'] = $param['paycode'];
		}
		if(!empty($param['remark'])){
			$setarr['remark'] = $param['remark'];
		}
		if(!empty($param['buyer_id'])){
			$setarr['buyer_id'] = $param['buyer_id'];
		}
		if(!empty($param['buyer_info'])){
			$setarr['buyer_info'] = $param['buyer_info'];
		}
		if(!empty($param['out_trade_no'])){
			$setarr['out_trade_no'] = $param['out_trade_no'];
		}

            $this->db->begin_trans();
            $res = $this->db->update('ebh_rewards',$setarr,array('ordernumber'=>$ordernum));//更新订单
            $upres = $this->rewardStatistics($ordernum);
            if($istransfer){
            	$transfer = $this->transferByOrdernum($ordernum);//如果是微信和支付宝转账，则对被打赏者进行钱包钱的增加	
            }
            //打赏成功，发送私信
            $selectsql = 'select rw.type,rw.crid,rw.uid,rw.touid,rw.toid,rw.totalfee from ebh_rewards rw where rw.ordernumber ='.$ordernum.' limit 1';
            $rewardinfo = $this->db->query($selectsql)->row_array();
            if(!empty($rewardinfo)){
            	switch ($rewardinfo['type']) {
            		case 1://课件信息获取
            			$cwinfo = $this->db->query('select title from ebh_coursewares where cwid='.$rewardinfo['toid'].' limit 1')->row_array();
            			$rewardinfo['title'] = $cwinfo['title'];
            			break;
            		case 3://答题信息获取
            			$rewardinfo['title'] = '答题打赏';
            			break;
            		default:
            			$rewardinfo['title'] = 'sns 打赏';
            			break;
            	}
            	$msgmodel = Ebh::app()->model('Message');
            	$sendarr = array('fromid'=>$rewardinfo['uid'],'toid'=>$rewardinfo['touid'],'ulist'=>'0=系统管理员','sourceid'=>$rewardinfo['toid'],'type'=>6,'message'=>json_encode(array('title'=>$rewardinfo['title'],'totalfee'=>$rewardinfo['totalfee'])),'isread'=>0,'crid'=>$rewardinfo['crid']);
				$msgmodel->insert($sendarr);
				//插入数据库成功，则更新只读和未读数据
				$redis = Ebh::app()->getCache('cache_redis');
				//每个用户一个hash，格式为 hash表明为m_uid hash key为 对应type
				$redis->hIncrBy('msg_'.$rewardinfo['touid'].'_'.$rewardinfo['crid'],6);
            }
            if($this->db->trans_status() === FALSE){
            	$this->db->rollback_trans();
            	return false;
            }else{
            	$this->db->commit_trans();
           		return true;
            }		
	}

	/**
	 * 对于订单更新失败的将invalid字段置为1
	 */
	public function setInvalid($param = array(),$ordernum){
		if(empty($ordernum) || !is_numeric($ordernum)){
			return false;
		}
		$setarr = array();
		if(!empty($param['invalid'])){
			$setarr['invalid'] = $param['invalid'];
		}
		return $this->db->update('ebh_rewards',$setarr,array('ordernumber'=>$ordernum));
	}

	//检查订单状态
	public function getOrderStatusByOrderNum($ordernum){
		if(empty($ordernum) || !is_numeric($ordernum)){
			return -1;
		}
		$sql = 'select status from `ebh_rewards` where ordernumber = ' . $ordernum;
		return $this->db->query($sql)->row_array();
	}

	//获取老师界面中的赞赏列表
	public function getRwListByTouid($param){
		if(empty($param['touid'])){
			return false;
		}
		if (!empty($param['type'])) {
			$sql = 'select rw.uid,rw.type,rw.toid,rw.paytime,rw.totalfee,u.realname,u.username from `ebh_rewards` rw left join `ebh_users` u on (rw.uid = u.uid) where rw.touid ='.intval($param['touid']).' and rw.status = 1 and type='.$param['type'].' group by rw.paytime desc';
		} else {
			$sql = 'select rw.uid,rw.type,rw.toid,rw.paytime,rw.totalfee,u.realname,u.username from `ebh_rewards` rw left join `ebh_users` u on (rw.uid = u.uid) where rw.touid ='.intval($param['touid']).' and rw.status = 1 group by rw.paytime desc';
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}
	//获取打赏总信息
	public function getRewardsCount($uid){
		if(empty($uid)){
			return false;
		}
		$sql = 'select getreward,sendreward,getcount,sendcount from `ebh_reward_totals` where uid='.intval($uid).' limit 1';
		return $this->db->query($sql)->row_array();
	}
	//获取学生界面中的赞赏列表
	public function getRwListByUid($param){
		if(empty($param['uid']) && empty($param['touid'])){
			return false;
		}
		if(!empty($param['type'])){
            $whereArr[] = " rw.type=".$param['type'];
        }
        if(!empty($param['uid'])){
            $whereArr[] = " rw.uid=".$param['uid'];
        }
        if(!empty($param['toid'])){
            $whereArr[] = " rw.toid=".$param['toid'];
        }
        if(!empty($param['touid'])){
            $whereArr[] = " rw.touid=".$param['touid'];
        }
        if(!empty($param['status'])){
            $whereArr[] = " rw.status=".$param['status'];
        } else {
        	$whereArr[] = " rw.status=1";
        }
        $sql = 'select u.username,u.realname,u.face,u.sex,rw.type,rw.uid,rw.toid,rw.paytime,rw.totalfee,rw.payfrom from `ebh_rewards` rw left join ebh_users u on u.uid=rw.touid ';
		if(!empty($whereArr)){
            $sql.=' WHERE '.implode(' AND ',$whereArr);
        }
        $sql .= ' order by rw.paytime desc';
        if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}

	//获取学生界面中的赞赏列表
	public function getRwListByUidCount($param){
		if(!empty($param['type'])){
            $whereArr[] = " rw.type=".$param['type'];
        }
        if(!empty($param['uid'])){
            $whereArr[] = " rw.uid=".$param['uid'];
        }
         if(!empty($param['touid'])){
            $whereArr[] = " rw.touid=".$param['touid'];
        }
        if(!empty($param['status'])){
            $whereArr[] = " rw.status=".$param['status'];
        } else {
        	$whereArr[] = " rw.status=1";
        }
		$sql = 'select count(1) as c,sum(totalfee) as fee from `ebh_rewards` rw ';
		if(!empty($whereArr)){
            $sql.=' WHERE '.implode(' AND ',$whereArr);
        }
		$row = $this->db->query($sql)->row_array();
		if (empty($row['c'])) {
			$row['c'] = 0;
		}
		if (empty($row['fee'])) {
			$row['fee'] = 0;
		}
		return $row;
	}
	//老师端课件打赏明细列表
	public function getRwListDetailByTouid($param){
		if(empty($param['touid'])){
			return false;
		}
		if (!empty($param['type'])) {
			$sql = 'select toid from `ebh_rewards` where touid = '.intval($param['touid']).' and type='.$param['type'].' and status = 1 group by toid asc';
		} else {
			$sql = 'select toid from `ebh_rewards` where touid = '.intval($param['touid']).' and status = 1 group by toid asc';
		}
		if(!empty($param['limit'])){
			$sql.=' limit '.$param['limit'];
		}
		return $this->db->query($sql)->list_array();
	}
	//获取老师端被打赏课件总数
	public function getRwListDetailCountByTouid($touid,$type){
		if(empty($touid)){
			return false;
		}
		$sql = 'SELECT toid,type,count(1) as c,sum(totalfee) as fee FROM ebh_rewards where `status` = 1 and `touid` = '.intval($touid).' GROUP BY toid,type';
		$reslist = $this->db->query($sql)->list_array();
		return $reslist;
	}
	//教师端 获取 某个课件的所以打赏记录
	public function getRewardsListByCwid($cwid,$uid,$type=0){
		if(empty($cwid) || empty($uid)){
			return false;
		}
		if ($type) {
			$sql = 'SELECT rw.uid,rw.paytime,rw.totalfee,rw.payfrom,u.username,u.realname from ebh_rewards rw left join ebh_users u on (u.uid = rw.uid) where rw.toid = '.intval($cwid).' and rw.status = 1 and rw.type='.intval($type).' order by rw.paytime desc';
		} else {
			$sql = 'SELECT rw.uid,rw.paytime,rw.totalfee,rw.payfrom,u.username,u.realname from ebh_rewards rw left join ebh_users u on (u.uid = rw.uid) where rw.toid = '.intval($cwid).' and type =1 and rw.status = 1 order by rw.paytime desc';
		}
		
		return $this->db->query($sql)->list_array();
	}
	//检查订单号是否已存在
	public function checkOrdernum($ordernum){
		if(empty($ordernum) || !is_numeric($ordernum)){
			return -1;
		}
		$sql = 'select rwid from `ebh_rewards` where ordernumber='.$ordernum.' limit 1';
		return $this->db->query($sql)->row_array();
	}

	/**
	 * 获取toid赞赏人数
	 * 
	 */
	public function getRecordCountGroup($param) {
		if (empty($param['type']) || empty($param['toids'])) {
			return false;
		}
		$sql = ' select count(1) as c,toid from ebh_rewards where toid in ('.$param['toids'].') and type = '.$param['type'].' and status='.$param['status'].' group by toid ';
		return $this->db->query($sql)->list_array();

	}

	/**
	 *根据type获取赞赏的信息
	 *@param $getName int 是否要获取到问题的发布者信息
	 */
    public function getRwinfoListBytoids($toid,$getName=0,$student=0){
        if(empty($toid)){
            return false;
        }
        $row = array();
        foreach ($toid as $key=>$value) {
            if ($key==1) {
                $sql = " select title,cwid,logo,uid,dateline from ebh_coursewares where cwid in ( "."'" . implode("','", array_unique($value)) . "'"." ) order by dateline desc";
                $row[$key] = $this->db->query($sql)->list_array();
                $cwidarr=array();
                if(!empty($row[$key])){
                	if ($getName) {
                		foreach ($row[$key] as $rkey => $rval){
	                        $cwidarr[$rkey]=$rval['cwid'];
	                        $uidArr[] = $rval['uid'];
	                    }
                	} else {
                		 foreach ($row[$key] as $rkey => $rval){
	                        $cwidarr[$rkey]=$rval['cwid'];
	                    }
                	}
                    $folders=$this->getFoldersByCwid($cwidarr);
                    if (!empty($folders)) {
                        foreach ($row[$key] as &$val){
                            foreach ($folders as &$v){
                                if($val['cwid']==$v['cwid']){
                                    $val['foldername']=$v['foldername'];
                                }
                            }
                        }
                    }
                   
                }
            } else if($key==3) {
            	if ($student) {
                 	$sql = " select q.uid as uid,a.uid as auid,a.dateline,a.message as title,a.aid as cwid,a.qid,q.folderid from ebh_askanswers a left join ebh_askquestions q using(qid) where a.aid in ( "."'" . implode("','", array_unique($value)) . "'"." )";
            	} else {
            		$sql = " select q.uid as uid,a.uid as auid,a.dateline,q.title,a.aid as cwid,a.qid,q.folderid from ebh_askanswers a left join ebh_askquestions q using(qid) where a.aid in ( "."'" . implode("','", array_unique($value)) . "'"." )";
            	}
                $row[$key] = $this->db->query($sql)->list_array();
                $folderidarr = array();
                if (!empty($row[$key])) {
                	if (!isset($uidArr)) {
                		$uidArr = array();
                	}
            		if ($getName) {
                		foreach ($row[$key] as $rkey => $rval){
	                        $folderidarr[$rkey]=$rval['folderid'];
	                        $uidArr[] = $rval['uid'];
	                    }
                	} else {
                		foreach ($row[$key] as $rkey => $rval){
	                        $folderidarr[$rkey]=$rval['folderid'];
	                    }
                	}
                    $folders=$this->getFoldersByFolderid($folderidarr);
                    if (!empty($folders)) {
                        foreach ($row[$key] as &$val){
                            foreach ($folders as &$v){
                                if($val['folderid']==$v['folderid']){
                                    $val['foldername']=$v['foldername'];
                                }
                            }
                        }
                    }
                }
            }
        }
        $res = array();
        if ($getName &&!empty($uidArr)) {
        	$useSql = 'select realname,username,face,uid from ebh_users where uid in('.implode(",", array_unique($uidArr)).')';
        	$user_infos = $this->db->query($useSql)->list_array();
        	if (!empty($user_infos)) {
        		if (!empty($row)) {
        			foreach ($user_infos as $ukey => $uvalue) {
        				$user[$uvalue['uid']] = $uvalue;
        			}
		            foreach ($row as $key => $value) {
		                foreach ($value as $vkey => $vvalue) {
		                	if (isset($user[$vvalue['uid']])) {
		                		$vvalue['face'] = $user[$vvalue['uid']]['face'];
		                		$vvalue['realname'] = $user[$vvalue['uid']]['realname'];
		                		$vvalue['username'] = $user[$vvalue['uid']]['username'];
		                	}
		                   $vvalue['type'] = $key;
		                   $res[] = $vvalue;
		                }
		            }
		        }
        	}
        } else {
        	if (!empty($row)) {
	            foreach ($row as $key => $value) {
	                foreach ($value as $vkey => $vvalue) {
	                   $vvalue['type'] = $key;
	                   $res[] = $vvalue;
	                }
	            }
	        }
        } 
        return $res;
    }

     //获取课程
    public function getFoldersByCwid($cwid){
        if(empty($cwid)){
            return false;
        }
        $sql = " select c.folderid ,c.cwid,f.foldername from ebh_roomcourses c left join ebh_folders f  on(c.folderid=f.folderid)  where cwid in ( "."'" . implode("','", $cwid) . "'"." )";
        $row = $this->db->query($sql)->list_array();
        return $row;

    }
    //获取课程
    public function getFoldersByFolderid($folderid){
        if(empty($folderid)){
            return false;
        }
        $sql = " select foldername,folderid from  ebh_folders where folderid in ( "."'" . implode("','", $folderid) . "'"." )";
        $row = $this->db->query($sql)->list_array();
        return $row;

    }
}