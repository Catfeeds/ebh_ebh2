<?php
/**
 * 微信model类
 */
class WeixinModel extends CModel{
    /**
     * @desc 获取教师的班级列表
     * @param $crid,$uid
     * @return array
     */
    public function getTeacherClassList($crid,$uid) {
        $sql = 'select c.classid,c.classname,c.stunum from ebh_classteachers ct '.
                'join ebh_classes c on (ct.classid = c.classid) '.
                'where c.crid='.$crid.' and ct.uid = '.$uid.' and c.`status`=0 order by c.classid';
        return $this->db->query($sql)->list_array();
    }
    /**
	 * @desc 得到班级学生列表，（包含微信号信息）
	 * @param $classid int
	 * @retun array
	 */
    public function getClassStudents($classid,$crid)
    {
		//获取班级学生列表
		$sql = 'select cs.uid,u.username,u.realname,u.sex from ebh_classstudents cs '.
				'join ebh_users u on (cs.uid = u.uid) '.
				'join ebh_roomusers ru on cs.uid=ru.uid ';
		$wherearr[] = 'cs.classid='.$classid;
		$wherearr[] = 'ru.crid='.$crid;
		$wherearr[] = 'ru.cstatus=1';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$rows = $this->db->query($sql)->list_array();	
		$studentlist = array();
		if(!empty($rows)) {
			$idlist = '';
			foreach($rows as $row) {
				if(empty($idlist)) {
					$idlist = $row['uid'];
				} else {
					$idlist .= ','.$row['uid'];
				}
				$row['wx_names'] = '';
				$row['wx_openids'] = '';
				$studentlist[$row['uid']] = $row;
			}
			//获取学生账号与微信账号的绑定列表
			$getbindsql = 'select b.suid,b.wx_name_father,b.wx_name_mother from ebh_weixinbindings b where b.suid in ('.$idlist.')';
			$wxbinds = $this->db->query($getbindsql)->list_array();
			$wxnamelist = array();
			$wxnameliststr = '';
			if(!empty($wxbinds)) {
				foreach($wxbinds as $wxbind) {
					$wxopenids = '';	//学生绑定的父亲母亲微信号组合，以逗号隔开，如 'weixinhao1','weixinhao2' 主要用于sql搜索，后续步骤用到
					$wxopenidsnoquote = '';	//学生绑定的父亲母亲微信号组合，以逗号隔开，如 weixinhao1,weixinhao2
					if(!empty($wxbind['wx_name_father'])) {
						$wxnamelist[$wxbind['wx_name_father']][] = $wxbind['suid'];
						$wxopenids = "'".$wxbind['wx_name_father']."'";
						$wxopenidsnoquote = $wxbind['wx_name_father'];
					}
					if(!empty($wxbind['wx_name_mother'])) {
						$wxnamelist[$wxbind['wx_name_mother']][] = $wxbind['suid'];
						if(empty($wxopenids)) {
							$wxopenids = "'".$wxbind['wx_name_mother']."'";
						} else {
							$wxopenids .= ",'".$wxbind['wx_name_mother']."'";
						}
						$wxopenidsnoquote .= ','.$wxbind['wx_name_mother'];
					}
					if(empty($wxnameliststr)) {
						$wxnameliststr = $wxopenids;
					} else {
						$wxnameliststr .= ",".$wxopenids;
					}
					if(isset($studentlist[$wxbind['suid']])) {
						$studentlist[$wxbind['suid']]['wx_openids'] = $wxopenidsnoquote;
					}
				}
			}
			//根据绑定列表中的openid再获取微信账号昵称
			if(!empty($wxnameliststr)) {
				$wxusersql = "select wu.openid,wu.nickname from ebh_weixinuserinfos wu where wu.openid in (".$wxnameliststr.")";
				$wxuserlist = $this->db->query($wxusersql)->list_array();
				if(!empty($wxuserlist)) {
					foreach($wxuserlist as $wxusr) {
						if(isset($wxnamelist[$wxusr['openid']])) {
							$uidarr = $wxnamelist[$wxusr['openid']];
							foreach($uidarr as $uid) {
								if(empty($studentlist[$uid]['wx_names'])) {
									$studentlist[$uid]['wx_names'] = $wxusr['nickname'];
								} else {
									$studentlist[$uid]['wx_names'] .= ','.$wxusr['nickname'];
								}
							}
						}
					}
				}
			}
		}
		return $studentlist;
    }
	/**
	*获取班级下所有学生列表以及学生家长微信的回复列表
	*/
	public function getClassStudentReplyList($classid) {
		$studentlist = $this->getClassStudents($classid);
		if(empty($studentlist))
			return FALSE;
		$studentRList = array();
		$uidstr = '';
		foreach($studentlist as $student) {
			$student['replylist'] = array();
			$studentRList[$student['uid']] = $student;
			if(empty($uidstr))
				$uidstr = $student['uid'];
			else
				$uidstr .= ','.$student['uid'];
		}
		$sql = "select r.rid,r.uid,r.msg,r.hasreply,r.dateline from ebh_weixinreplies r where r.classid=$classid and r.uid in ($uidstr) order by rid desc";
		$replylist = $this->db->query($sql)->list_array();
		foreach($replylist as $myreply) {
			if(isset($studentRList[$myreply['uid']]))
				$studentRList[$myreply['uid']]['replylist'][] = $myreply;
		}
		return $studentRList;
	}
	/**
	*批量插入微信信息发送记录
	*需要通过组装SQL方式插入，提高效率
	*格式如 $paramlist[] = array('send_uid'=>$user['uid'],'receive_uid'=>$suid,'class_id'=>$classid,'htype'=>$htype,'weixin_name'=>$weixin_name,'weixin_content'=>$weixin_content);
	*@param array paramlist 信息记录列表
	*/
    public function batchInsertHistory($paramlist = array()){
		$curtime = SYSTIME;
		$sql = 'INSERT INTO ebh_weixinhistorys(send_uid,receive_uid,class_id,htype,weixin_name,weixin_content,dateline,batchid,crid) VALUES';
		foreach($paramlist as $param) {
			$weixin_name = $this->db->escape_str($param['weixin_name']);
			$content = $this->db->escape_str($param['weixin_content']);
			$batchid = $param['batchid'];
			$crid = $param['crid'];
			$itemsql = "({$param['send_uid']},{$param['receive_uid']},{$param['class_id']},{$param['htype']},'{$weixin_name}','{$content}',{$curtime},'{$batchid}',{$crid}),";
			$sql .= $itemsql;
		}
		if(strlen($sql) > 120) {
			$sql = substr($sql,0,strlen($sql) - 1);
		}
    	$result = $this->db->query($sql,FALSE);
		if($result > 0) {
			return TRUE;
		}
		return FALSE;
    }
    //微信客户端信息存储
    public function insertWeixinInfo($param = array()){
    	$openid = $param['openid'];
    	$sql = "SELECT openid,status FROM ebh_weixinuserinfos WHERE openid='{$openid}'";
    	//echo 'sdfdsf';
    	$res = $this->db->query($sql)->row_array();
    	if(!empty($res)){
    	    if($param['status']!=$res['status']){
    	        $status = isset($param['status']) ? intval($param['status']) : 1 ;
    	        return $this->subscribeUpdate($status,$openid);
    	    }else
    	        return true;
        }else{
            return $this->db->insert('ebh_weixinuserinfos',$param);
        }
    }
    //关注或取消关注更新表状态
    public function subscribeUpdate($status,$openid){
    	$setarr = array('status'=>$status);
    	$wherearr = array('openid'=>$openid);
        $result = $this->db->update('ebh_weixinuserinfos', $setarr, $wherearr);
    	return $result;
    }
	/**
	*绑定用户与微信公众号
	*如果用户的父母账号都已经跟账号绑定，则会覆盖掉最早绑定的账号
	*@param int $uid 用户编号
	*@param string $openid 微信号对用的openid
	*@return int 返回结果 0 绑定失败  1绑定成功 -1 已经绑定过了
	*/
    public function bindUid($uid,$openid){
		$result = 0;	//绑定失败
    	$sql = "SELECT wxid,wx_name_father,wx_name_mother,dateline_father,dateline_mother FROM ebh_weixinbindings  WHERE suid={$uid}";
		$bindrow = $this->db->query($sql)->row_array();
		if(empty($bindrow)){	//学生从未绑定过，则直接绑定父账号
			$param = array(
				'suid'=>$uid,
				'wx_name_father'=>$openid,
				'dateline_father'=>SYSTIME
			);
			$insertresult = $this->db->insert('ebh_weixinbindings',$param);
			if($insertresult > 0)
				$result = 1;
		} else if ($bindrow['wx_name_father'] == $openid || $bindrow['wx_name_mother'] == $openid) {	//已经绑定过则无需重新绑定
				$result = -1;
		}else {	//已有绑定记录的处理
			$wherearr = array('wxid'=>$bindrow['wxid']);
			$setarr = array();
			if(empty($bindrow['wx_name_father']) || $bindrow['dateline_father'] < $bindrow['dateline_mother']) {	//父账号未绑定，或者父账号先绑定的，则绑定父账号
				$setarr['wx_name_father'] = $openid;
				$setarr['dateline_father'] = SYSTIME;
			} else {
				$setarr['wx_name_mother'] = $openid;
				$setarr['dateline_mother'] = SYSTIME;
			}
			$upresult =  $this->db->update('ebh_weixinbindings',$setarr,$wherearr);
			if($upresult !== FALSE) 
				$result = 1;
		}
    	return $result;
    }
    /**
     * @desc 根据手机微信的openid得到用户的UID数组，因为一个账号可能绑定了多个学生号
     * @param $openid  int
     * @return array
     */
    public function getUidListByOpenid($openid){
		$list = FALSE;
    	if(!empty($openid)){
			$openid = $this->db->escape($openid);
    		$sql = "SELECT suid FROM ebh_weixinbindings WHERE (wx_name_father={$openid} or wx_name_mother={$openid})";
    		$list = $this->db->query($sql)->list_array();
    	}
    	return $list;
    }
	/**
	*获取学生所在班级信息
	*/
	public function getStudentClassList($uid) {
		$sql = 'select c.classid from ebh_classstudents c where c.uid='.$uid;
		return $this->db->query($sql)->list_array();
	}
	/**
	*根据用户id获取用户接收到的信息记录
	*@param array param
	*/
	public function getMessageListByUid($param) {
		if(empty($param['uid']))
			return FALSE;
		//查找所在班级，按照班级再找信息
		$myclasslist = $this->getStudentClassList($param['uid']);;
		if(empty($myclasslist))
			return FALSE;
		$classidstr = '';
		foreach($myclasslist as $myclass) {
			if(empty($classidstr))
				$classidstr = $myclass['classid'];
			else
				$classidstr .= ','.$myclass['classid'];
		}
		$msgsql = 'select h.send_uid,u.username,u.realname,h.weixin_content,h.dateline from ebh_weixinhistorys h '.
				'left join ebh_users u on (u.uid = h.send_uid) '.
				'where (h.receive_uid='.$param['uid'].' and h.htype=0) or (h.htype=1 and h.class_id in ('.$classidstr.'))';
		if(!empty($param['order']))
			$msgsql .= ' order by '.$param['order'];
		else
			$msgsql .= ' order by h.id desc';
		if(!empty($param['limit'])) {
            $msgsql .= ' limit '. $param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
            $msgsql .= ' limit ' . $start . ',' . $pagesize;
        }
		
		return $this->db->query($msgsql)->list_array();
	}
	/**
	*根据用户id获取用户接收到的信息记录
	*@param array param
	*/
	public function getMessageListByUidList($param) {
		if(empty($param['uidlist']))
			return FALSE;
		//查找所在班级，按照班级再找信息
		$myclasslists = array();
		$idstr = '';
		foreach($param['uidlist'] as $uiditem) {
			$myclasslist = $this->getStudentClassList($uiditem['suid']);
			$myclasslists = array_merge($myclasslists,$myclasslist);
			if(empty($idstr))
				$idstr = $uiditem['suid'];
			else
				$idstr .= ','.$uiditem['suid'];
		}
		if(empty($myclasslists))
			return FALSE;
		$classidstr = '';
		foreach($myclasslists as $myclass) {
			if(empty($classidstr))
				$classidstr = $myclass['classid'];
			else
				$classidstr .= ','.$myclass['classid'];
		}
		$msgsql = 'select h.send_uid,u.username,u.realname,u.sex,u.face,h.weixin_content,h.dateline,h.batchid,h.id,h.weixin_name,h.htype from ebh_weixinhistorys h '.
				'left join ebh_users u on (u.uid = h.send_uid) '.
				'where ((h.receive_uid in ('.$idstr.') and h.htype=0) or (h.htype=1 and h.class_id in ('.$classidstr.')))';
		if(!empty($param['q'])){
			$msgsql.=' AND h.weixin_content like"%'.$this->db->escape_str($param['q']).'%"';
		}
		if(!empty($param['order']))
			$msgsql .= ' order by '.$param['order'];
		else
			$msgsql .= ' order by h.id desc';
		if(!empty($param['limit'])) {
            $msgsql .= ' limit '. $param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
            $msgsql .= ' limit ' . $start . ',' . $pagesize;
        }
		return $this->db->query($msgsql)->list_array();
	}
	/**
	*根据班级编号获取已绑定微信号的学生列表
	*/
	public function getOpenidListByClassid($classid) {
		$sql = 'select cs.uid,wb.wx_name_father,wb.wx_name_mother from ebh_classstudents cs join ebh_weixinbindings wb on (cs.uid = wb.suid) '.
				'where cs.classid='.$classid;
		return $this->db->query($sql)->list_array();
	}

	/**
	*获取发信历史记录时间点
	*/
	public function getHistoryTimelist($param) {
		$sql = 'select distinct h.dateline from ebh_weixinhistorys h';
		$wherearr = array();
		if(!empty($param['send_uid']))
			$wherearr[] = 'h.send_uid='.$param['send_uid'];
		if(!empty($param['classid']))
			$wherearr[] = 'h.class_id='.$param['classid'];
		if(isset($param['htype']))
			$wherearr[] = 'h.htype='.$param['htype'];
		if(!empty($param['startDate']))
			$wherearr[] = 'h.dateline>='.$param['startDate'];
		if(!empty($param['endDate']))
			$wherearr[] = 'h.dateline<'.$param['endDate'];
		if(empty($wherearr))
			return FALSE;
		$sql .= ' where '.implode(' and ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		else 
			$sql .= ' order by h.id desc ';
		return $this->db->query($sql)->list_array();
	}
	/**
	*获取发信历史记录//可根据时间点
	*/
	// public function getHistoryMsglist($param) {
	// 	if($param['htype'] == 1) {	//班级群发
	// 		$sql = 'select c.classname,c.stunum,h.weixin_content from ebh_weixinhistorys h '.
	// 			'left join ebh_classes c on (c.classid = h.class_id)';
	// 	} else {	//班级发信（单独发信）
	// 		$sql = 'select u.username,u.realname,h.weixin_content from ebh_weixinhistorys h '.
	// 			'left join ebh_users u on (h.receive_uid = u.uid)';
	// 	}
		
	// 	$wherearr = array();
	// 	if(!empty($param['send_uid']))
	// 		$wherearr[] = 'h.send_uid='.$param['send_uid'];
	// 	if(!empty($param['class_id']))
	// 		$wherearr[] = 'h.class_id='.$param['class_id'];
	// 	if(isset($param['htype']))
	// 		$wherearr[] = 'h.htype='.$param['htype'];
	// 	if(!empty($param['dateline']))
	// 		$wherearr[] = 'h.dateline='.$param['dateline'];
	// 	if(empty($wherearr))
	// 		return FALSE;
	// 	$sql .= ' where '.implode(' and ',$wherearr);
	// 	if(!empty($param['order']))
	// 		$sql .= ' order by '.$param['order'];
	// 	else 
	// 		$sql .= ' order by h.id desc ';
	// 	return $this->db->query($sql)->list_array();
	// }
	/**
	*
	*添加家长回复信息
	*/
	public function addReply($param) {
		if(empty($param['uid']) || empty($param['openid']) || empty($param['classid']) )
			return FALSE;
		$setarr = array();
		$setarr['uid'] = $param['uid'];
		$setarr['openid'] = $param['openid'];
		$setarr['classid'] = $param['classid'];
		$setarr['msg'] = $param['msg'];
		if(empty($param['dateline']))
			$setarr['dateline'] = SYSTIME;
		else
			$setarr['dateline'] = $param['dateline'];
		return $this->db->insert('ebh_weixinreplies',$setarr);
	}
	/**
	*删除家长回复列表
	*@param array $ridlist 回复记录rid数组
	*@param int $classid 班级编号
	*/
	public function delReplys($ridlist,$classid) {
		$ridstr = implode(',',$ridlist);
		$sql = "DELETE FROM ebh_weixinreplies where classid=$classid and rid in ($ridstr)";
		return $this->db->query($sql,FALSE);
	}
	/**
	*删除家长回复列表
	*@param array $ridlist 回复记录rid数组
	*@param int $classid 班级编号
	*/
	public function delReplysByClassid($classid) {
		$sql = "DELETE FROM ebh_weixinreplies where classid=$classid";
		return $this->db->query($sql,FALSE);
	}
	/**
	*更新家长回复信息状态
	*@param array $ridlist 回复信息id数组
	*@param int $status 需要更新的状态
	*@return int 返回更新的影响行数
	*/
	public function updateReplyStatus($ridlist,$status = 1) {
		$ridstr = implode(',',$ridlist);
		$sql = "UPDATE ebh_weixinreplies SET hasreply={$status} WHERE rid in ({$ridstr})";
		return $this->db->query($sql,FALSE);
	}
	/**
	 *获取微信详情(手机端点击进入详情页获取内容)
	 */
	public function getDetail($param = array()){
		$sql = 'select h.id,h.weixin_content,h.send_uid,h.dateline from ebh_weixinhistorys h ';
		$wherearr = array();
		if(!empty($param['batchid'])){
			$wherearr[] = 'h.batchid=\''.$this->db->escape_str($param['batchid']).'\'';
		}
		if(!empty($param['htype'])){
			$wherearr[] = 'h.htype='.$param['htype'];
		}else if(!empty($param['weixin_name'])){
			$wherearr[] = 'h.weixin_name=\''.$this->db->escape_str($param['weixin_name']).'\'';
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ', $wherearr);
		}
		$sql.=' limit 1';
		return $this->db->query($sql)->row_array();
	}

	/**
	*根据批次获取发信历史
	*/
	public function getSendList($param) {
		$sql = 'select h.id,h.batchid,h.class_id,h.receive_uid,h.weixin_content,h.dateline from ebh_weixinhistorys h';
		$wherearr = array();
		if(!empty($param['send_uid'])){
			$wherearr[] = 'h.send_uid='.$param['send_uid'];
		}
		if(!empty($param['isreply'])){
			$wherearr[] = 'h.isreply='.$param['isreply'];
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'h.crid='.$param['crid'];
		}
		if(!empty($param['starttime'])){
			$wherearr[] = 'h.dateline>='.$param['starttime'];
		}
		if(!empty($param['endtime'])){
			$wherearr[] = 'h.dateline<='.$param['endtime'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ', $wherearr);
		}
		$sql .= ' GROUP BY h.batchid';
		if(!empty($param['order'])){
			$sql.= ' order by '.$param['order'];
		}else{
			$sql.= ' order by h.id desc';
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
		return  $this->db->query($sql)->list_array();
	}

	public function getSendListCount($param){
		$sql = 'select count(distinct(h.batchid)) count from ebh_weixinhistorys h';
		$wherearr = array();
		if(!empty($param['send_uid'])){
			$wherearr[] = 'h.send_uid='.$param['send_uid'];
		}
		if(!empty($param['isreply'])){
			$wherearr[] = 'h.isreply='.$param['isreply'];
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'h.crid='.$param['crid'];
		}
		if(!empty($param['starttime'])){
			$wherearr[] = 'h.dateline>='.$param['starttime'];
		}
		if(!empty($param['endtime'])){
			$wherearr[] = 'h.dateline<='.$param['endtime'];
		}
		if(!empty($wherearr)){
			$sql .= ' WHERE '.implode(' AND ', $wherearr);
		}
		$res = $this->db->query($sql)->row_array();
		return $res['count'];
	}

	/**
	 *
	 */
	public function getWeixinDetail($param = array()){
		$sql = 'select h.* from ebh_weixinhistorys h ';
		$wherearr = array();
		if(!empty($param['id'])){
			$wherearr[] = 'h.id='.$param['id'];
		}
		if(!empty($param['batchid'])){
			$wherearr[] = 'h.batchid=\''.$param['batchid'].'\'';
		}
		if(!empty($param['send_uid'])){
			$wherearr[] = 'h.send_uid='.$param['send_uid'];
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'h.crid='.$param['crid'];
		}
		if(!empty($wherearr)){
			$sql.=' WHERE '.implode(' AND ', $wherearr);
		}
		return $this->db->query($sql)->list_array();
	}
}
