<?php

/**
 * Class ActivityModel
 * 活动相关model
 */
class ActivityModel extends CModel{
    /**
     * 获取网校活动列表
     */
    public function getList($param){
        $sql = 'select * from ebh_activitys';
        $where = ' where del=0';
        if(!empty($param['crid'])){
            $where.= ' and crid = '.$param['crid'];
        }
        if(!empty($param['aid'])){
            $where.= ' and aid = '.$param['aid'];
            $sql.=$where;
            return $this->db->query($sql)->row_array();//aid唯一,直接输出
        }
        $sql.=$where;
        $sql.= ' order by isgoing desc , parter desc , date desc';
        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
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
     * 获取活动总数
     */
    public function getCount($param){
        if(empty($param)){
            return false;
        }
        $sql='select count(*) as count from ebh_activitys where del = 0 and crid = '.$param;
        return $this->db->query($sql)->row_array();
    }
    /**
     * 更据网校管理员id获得学校id
     */
    public function getCridByUid($uid){
        $sql = 'select crid from ebh_classrooms where uid ='.$uid;
        return $this->db->query($sql)->row_array();
    }
    /**
     * 添加活动
     */
    public function add($param){
        $param['subject'] = $this->db->escape_str($param['subject']);//防止sql注入
        $param['summary'] = $this->db->escape_str($param['summary']);//防止sql注入
        return $this->db->insert('ebh_activitys',$param);
    }
    /**
     * 删除活动
     * $param 活动id
     */
    public function del($param){
        $sql = ' select starttime,endtime,parter from ebh_activitys where aid ='.$param;
        $info = $this->db->query($sql)->row_array();
        if($info['parter']>0&&$info['endtime']+86400>time()){
            return false;
        }
        return $this->db->update('ebh_activitys',array('del'=>'1'),array('aid'=>$param));
    }
    /**
     * 获取参与活动人数
     */
    public function getParter($param){
        $sql = 'select parter as count from ebh_activity';
        $where = ' where del = 0';
        if(!empty($param['crid'])){
            $where .= ' and crid ='.$param['crid'];
        }
        if(!empty($param['aid'])){
            $where .= ' and aid = '.$param['aid'];
        }
        $sql.=$where;
        return $this->db->query($sql)->row_array();
    }
    /**
     * 编辑活动
     */
    public function edit($param,$where){
        $param['subject'] = $this->db->escape_str($param['subject']);//防止sql注入
        $param['summary'] = $this->db->escape_str($param['summary']);//防止sql注入
        return $this->db->update('ebh_activitys',$param,$where);
    }

    /**
     * 获取活动详情
     */
    public function getActivity($id){
        if(!empty($id)){
            $sql='select * from ebh_activitys where aid ='.$id;
            return $this->db->query($sql)->row_array();
        }
    }

    /**
     * 更新表置顶字段
     */
    public function flashTop(){
        $sql = "update ebh_activitys set isgoing = 1 where unix_timestamp(now())<endtime+86400";
        $sql2 = "update ebh_activitys set isgoing = 0 where unix_timestamp(now())>endtime+86400";
        $this->db->query($sql);
        $this->db->query($sql2);
    }
    /**
     * 获取活动评论
     */
	public function getReview($param){
		$sql = 'select a.*,u.nickname,u.realname,u.face,u.sex,u.face from ebh_areviews a join ebh_users u on a.uid = u.uid where a.aid = '.$param['aid'].' and a.isdel = 0';
		
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
		$res = $this->db->query($sql)->list_array();
		// if($param['needquote']){
			// foreach($res as &$v){
				// if($v['upid'])
				// $v = $this->moreReview($v);
			// }
		// }
		return $res;
    }

    /**
     * 递归,组成评论引用tree
     * @param $prarm
     * @return mixed
     */
    private function moreReview($prarm){
		if(!empty($prarm['upid'])){
            $sql = 'select a.*,u.nickname,u.realname,u.face,u.sex from ebh_areviews a join ebh_users u on a.uid = u.uid where a.cid = '.$prarm['upid'];
            $prarm['up'] = $this->db->query($sql)->row_array();
        }
        if(!empty($prarm['up']['upid'])){
            $prarm['up'] = $this->moreReview($prarm['up']);
        }
        return $prarm;
    }
    /**
     * 获得获得评论总数
     */
    public function getReviewCount($aid){
        if(empty($aid)){
            return false;
        }
        $sql = 'select count(*) as count from ebh_areviews where isdel = 0 and aid = '.$aid;
        return $this->db->query($sql)->row_array();
    }

    /**
     * 屏蔽活动评论
     */
    public function shieldReview($cid){
        if(empty($cid)){
            return false;
        }
        return $this->db->update('ebh_areviews',array('isshield'=>'1'),array('cid'=>$cid));
    }
	
	/*
	添加评论
	*/
	public function addReview($param){
		if(empty($param['uid']) || empty($param['review']) || empty($param['aid']))
			exit;
		$setarr['uid'] = $param['uid'];
		$setarr['aid'] = $param['aid'];
		$setarr['review'] = $param['review'];
		$setarr['date'] = SYSTIME;
		$setarr['upid'] = empty($param['upid'])?0:$param['upid'];
		$setarr['oid'] = empty($param['oid'])?0:$param['oid'];
		return $this->db->insert('ebh_areviews',$setarr);
	}
	
    /*
     * 获得获得学生信息
     */
    public function getParterList($param){
        $sql = 'select s.*,u.nickname,u.realname,u.username,u.face,u.sex,u.face,u.uid from ebh_studentactivitys s LEFT JOIN ebh_users u on s.uid = u.uid';
        $sql2 = 'select count(*) as count from ebh_studentactivitys';
        $where = ' where 1=1';
        if(!empty($param['aid'])){
            $where.= ' and aid ='.$param['aid'];
            $sql.=$where;
            $sql2.=$where;
        }
        $count = $this->db->query($sql2)->row_array();//获取数量
		$sql .= ' order by '.(empty($param['order'])?'s.credit desc,pdateline':$param['order']);
		if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
        $res = $this->db->query($sql)->list_array();
        $res['count'] = $count['count'];
        return $res;
    }

    /**
     * @param $param
     * @return mixed
     * 获取学生所在班级
     */
    public function getRoom($param){
        $sql = 'select classname from ebh_classstudents cs left join ebh_classes c on cs.classid=c.classid';
        $where = ' where 1=1';
        if(!empty($param['uid'])){
            $where.= ' and uid ='.$param['uid'];
        }
        if(!empty($param['crid'])){
            $where.= ' and crid ='.$param['crid'];
        }
        $sql.=$where;
        return $this->db->query($sql)->row_array();
    }

    /**
     * @param $param
     * 获取活动积分明细
     */
    public function getActivityDetails($param){
        $sql = 'select c.*,cr.action,cr.description from ebh_creditlogs c join ebh_creditrules cr on c.ruleid = cr.ruleid ';
        $sql2 = 'select count(*) as count from ebh_creditlogs';
        $where = ' where isact=1';
        if(!empty($param['uid'])){
            $where.= ' and toid = '.$param['uid'];
        }
        if(!empty($param['crid'])){
            $where.= ' and crid = '.$param['crid'];
        }
        if(!empty($param['starttime'])&&!empty($param['endtime'])){
            $where.= ' and dateline>'.$param['starttime'].' and dateline<'.$param['endtime'];
        }
        $sql.=$where;
        $sql2.=$where;
        $sql.=' order by c.logid desc';
        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
        $count = $this->db->query($sql2)->row_array();
        $res = $this->db->query($sql)->list_array();
        $res['count'] = $count['count'];
        return $res;
    }
	
	/*
	获取列表以及学生报名情况
	参数有aid获取row_array; 没有aid,获取list_array
	*/
	public function getStudentActivity($param){
		if(empty($param['uid']))
			return false;
		$sql = 'select a.aid,date,subject,message,starttime,endtime,parter,pdateline,viewnum,credit,imgurl,summary,type,tidstr
			from ebh_activitys a 
			left join ebh_studentactivitys sa 
			on (a.aid=sa.aid and uid in('.$param['uid'].'))';
		// $wherearr[] = '(uid in('.$param['uid'].') or uid is null)';
		$wherearr[] = 'a.crid='.$param['crid'];
		// if(isset($param['del']))
			$wherearr[] = 'del=0';
		if(!empty($param['aid']))
			$wherearr[] = 'a.aid='.$param['aid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql.= ' order by '.$param['order'];
		// if(!empty($param['limit'])) {
  //           $sql .= ' limit '.$param['limit'];
  //       } else {
		// 	if (empty($param['page']) || $param['page'] < 1)
		// 		$page = 1;
		// 	else
		// 		$page = $param['page'];
		// 	$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
		// 	$start = ($page - 1) * $pagesize;
		// 	$sql .= ' limit ' . $start . ',' . $pagesize;
  //       }
		// echo $sql;
		if(empty($param['aid']))
			return $this->db->query($sql)->list_array();
		else
			return $this->db->query($sql)->row_array();
	}
	
	/*
	学生报名
	*/
	public function addStudentActivity($param){
		$sql = 'select 1 from ebh_studentactivitys where uid='.$param['uid'].' and aid='.$param['aid'];
		$res = $this->db->query($sql)->row_array();
		if(!empty($res))
			return false;
		$setarr['crid'] = $param['crid'];
		$setarr['uid'] = $param['uid'];
		$setarr['aid'] = $param['aid'];
		$setarr['pdateline'] = SYSTIME;
		
		$where = 'aid=' . $setarr['aid'];
		
        $uparr = array('parter' => 'parter+1');
        $this->db->update('ebh_activitys', array(), $where, $uparr);
		return $this->db->insert('ebh_studentactivitys',$setarr);
	}
	
	/*
	增加人气
	*/
	public function addviewnum($aid, $num = 1) {
        $where = 'aid=' . $aid;
        $setarr = array('viewnum' => 'viewnum+' . $num);
        $this->db->update('ebh_activitys', array(), $where, $setarr);
    }
	
	/*
	根据cid获取评论(被引用的) 以及楼层
	*/
	public function getReviewByCid($param){
		$sql = 'select cid,aid,a.uid,review,a.date,a.isshield,a.upid,u.realname
					,(select count(*)+1 from ebh_areviews ua where ua.cid<a.cid and aid='.$param['aid'].') as floor
				from ebh_areviews a 
				join ebh_users u on a.uid=u.uid';
		$wherearr[]= 'cid in ('.$param['cid'].')';
		$wherearr[]= 'aid='.$param['aid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		return $this->db->query($sql)->list_array();
		
	}
	
	/*
	获取楼层
	*/
	public function getFloor($param){
		$sql = 'select count(*)+1 floor from ebh_areviews a';
		$wherearr[]= 'cid<'.$param['cid'];
		$wherearr[]= 'aid='.$param['aid'];
        $wherearr[]= 'isdel= 0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$res = $this->db->query($sql)->row_array();
		return $res['floor'];
	}
	
	/*
	获取排名
	*/
	public function getRank($param){
		$sql = 'select count(*)+1 rank from ebh_studentactivitys';
		$wherearr[]= 'aid='.$param['aid'];
		$wherearr[]= '(credit='.$param['credit'].' and pdateline<'.$param['pdateline'].' or credit>'.$param['credit'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql;
		$res = $this->db->query($sql)->row_array();
		return $res['rank'];
	}
    /**
     * [getactivecount 获取正在进行中的活动条数]
     * @return [type] [description]
     */
    public function getactivecount($param){
        if(empty($param)){
            return false;
        }
        $sql = 'select count(*) as count from `ebh_activitys` where crid = '.$param.' and (endtime+86400) >'.SYSTIME;
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }

    public function delReview($cid){
        if(empty($cid)){
            return false;
        }
        $sql = "UPDATE ebh_areviews SET isdel='1' WHERE cid = ".$cid." or upid = ".$cid;
        return $this->db->query($sql);
    }  
}
?>