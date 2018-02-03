<?php
/*
会员
*/
class MemberModel extends CModel{
	/*
	会员列表
	@param array $param
	@return array
	*/
	public function getmemberlist($param){
		$wherearr = array();
		$sql = 'select u.schoolname,u.logincount,u.credit,u.lastloginip,u.lastlogintime,u.uid,u.realname,u.nickname,m.citycode,u.email,u.sex,u.face,u.credit,u.username,u.dateline,u.logincount,u.status,m.phone,m.mobile,m.qq from ebh_members m join ebh_users u on m.memberid=u.uid ';
		if(!empty($param['showregip'])){
			$sql = 'select (select fromip from ebh_creditlogs where toid=u.uid and ruleid=1) regip,u.schoolname,u.logincount,u.credit,u.lastloginip,u.lastlogintime,u.uid,u.realname,u.nickname,m.citycode,u.email,u.sex,u.face,u.credit,u.username,u.dateline,u.logincount,u.status,m.phone,m.mobile,m.qq from ebh_members m join ebh_users u on m.memberid=u.uid';
		}

		if(!empty($param['q']))
			//如果$param['aq']为真则表示按username精确查询,否则按realname,username模糊查询
			if(!empty($param['aq'])){
				$wherearr[] =  ' u.username = \''.$this->db->escape_str($param['q']).'\'';
			}else{
                //模糊查找

                //加载sphinx
                $sphinxClient = Ebh::app()->lib('SphinxClient');
                $sphinx_config = Ebh::app()->getConfig()->load('sphinx');
                $sphinxClient->setServer($sphinx_config['host'], $sphinx_config['port']);
                $sphinxClient->setMatchMode(SPH_MATCH_ANY);
                //设置超时时间（毫秒）
                $sphinxClient->setMaxQueryTime(30000);

                $limit = explode(',',$param['limit']);
                //设置分页
                $sphinxClient->SetLimits($limit[0],$limit[1]);

                $sphinxClient->SetSortMode(SPH_SORT_EXTENDED,'@id DESC,@weight DESC');
                $res = $sphinxClient->query('*'.$param['q'].'*','user');
                if($res && $res['total'] > 0){
                    $ids = array();
                    foreach($res['matches'] as $uid=>$resultItem){
                        $ids[] = $uid;
                    }

                    $wherearr[] = 'u.uid in (' .implode(',',$ids) . ')';
                    unset($param['limit']);
                }else{
                    return array();
                }
                //var_dump($param['limit']);
                //var_dump($res);
				//$wherearr[] =  ' ( u.realname like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']).'%\' or u.nickname like \'%' . $this->db->escape_str($param['q']).'%\')';

            }
			
		if (!empty($wherearr)) {
			$sql.= ' WHERE '.implode(' AND ',$wherearr);	
		} else {
			return array();
		}
		if(!empty($param['displayorder'])) {
            $sql .= ' ORDER BY '.$param['displayorder'];
        } else {
            $sql .= ' ORDER BY uid desc';
        }
		if(!empty($param['limit']))
			$sql.= ' limit ' . $param['limit'];
		return $this->db->query($sql)->list_array();
	}
	/*
	会员总数
	@param array $param
	@return int
	*/
	public function getmembercount($param){
		$wherearr = array();
		$sql = 'select count(*) count from ebh_members m join ebh_users u on m.memberid=u.uid';
		if(!empty($param['q']))
			//如果$param['aq']为真则表示按username精确查询,否则按realname,username模糊查询
			if(!empty($param['aq'])){
				$wherearr[] =  ' u.username = \'' . $this->db->escape_str($param['q']).'\'';
			}else{

                //加载sphinx
                $sphinxClient = Ebh::app()->lib('SphinxClient');
                $sphinx_config = Ebh::app()->getConfig()->load('sphinx');
                $sphinxClient->setServer($sphinx_config['host'], $sphinx_config['port']);
                $sphinxClient->setMatchMode(SPH_MATCH_ANY);
                //设置超时时间（毫秒）
                $sphinxClient->setMaxQueryTime(30000);

                //设置分页
                //$sphinxClient->SetLimits(0,1000);
                $res = $sphinxClient->query('*'.$param['q'].'*','user');
                return $res['total'];
                /*if($res && $res['total'] > 0){
                    $ids = array();
                    foreach($res['matches'] as $uid=>$resultItem){
                        $ids[] = $uid;
                    }

                    $wherearr[] = 'u.uid in (' .implode(',',$ids) . ')';
                }else{
                    return 0;
                }*/
				//$wherearr[] =  ' ( u.realname like \'%'. $this->db->escape_str($param['q']) .'%\' or u.username like \'%' . $this->db->escape_str($param['q']).'%\' or u.nickname like \'%' . $this->db->escape_str($param['q']).'%\')';
			}
		if(!empty($wherearr)) {
			$sql.= ' WHERE '.implode(' AND ',$wherearr);
		} else {
			return 0;
		}
		//var_dump($sql);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	修改会员
	@param array $param
	@return int
	*/
	public function editmember($param){
		$afrows=0;
		//修改user表信息
		if(!empty($param['password']))
			$userarr['password'] = md5($param['password']);
		if(isset($param['status']))
			$userarr['status'] = $param['status'];
		if(isset($param['cnname']))
			$userarr['realname'] = $param['cnname'];
		if(isset($param['nickname']))
			$userarr['nickname'] = $param['nickname'];
		if(isset($param['sex']))
			$userarr['sex'] = $param['sex'];
		if(isset($param['mobile']))
			$userarr['mobile'] = $param['mobile'];
		if(isset($param['email']))
			$userarr['email'] = $param['email'];
		if(isset($param['citycode']))
			$userarr['citycode'] = $param['citycode'];
		if(isset($param['address']))
			$userarr['address'] = $param['address'];
		if(isset($param['face']))
			$userarr['face'] = $param['face'];
		if(isset($param['lastlogintime']))
			$userarr['lastlogintime'] = $param['lastlogintime'];
		$wherearr = array('uid'=>$param['uid']);
		if (!empty($userarr)) {
            $afrows+= $this->db->update('ebh_users', $userarr, $wherearr);
        }
		//修改member表信息
		
		if(isset($param['birthdate']))
			$memberarr['birthdate'] = $param['birthdate'];
		if(isset($param['phone']))
			$memberarr['phone'] = $param['phone'];
		if(isset($param['qq']))
			$memberarr['qq'] = $param['qq'];
		if(isset($param['msn']))
			$memberarr['msn'] = $param['msn'];
		if(isset($param['native']))
			$memberarr['native'] = $param['native'];
		if(isset($param['profile']))
			$memberarr['profile'] = $param['profile'];
		if(isset($param['realname']))
			$memberarr['realname'] = $param['realname'];
		if(isset($param['nickname']))
			$memberarr['nickname'] = $param['nickname'];
		if(isset($param['sex']))
			$memberarr['sex'] = $param['sex'];
		if(isset($param['mobile']))
			$memberarr['mobile'] = $param['mobile'];
		if(isset($param['email']))
			$memberarr['email'] = $param['email'];
		if(isset($param['citycode']))
			$memberarr['citycode'] = $param['citycode'];
		if(isset($param['address']))
			$memberarr['address'] = $param['address'];
        if(isset($param['face']))
            $memberarr['face'] = $param['face'];
		if(isset($param['familyname']))
			$memberarr['familyname'] = $param['familyname'];
		if(isset($param['familyphone']))
			$memberarr['familyphone'] = $param['familyphone'];
		if(isset($param['familyjob']))
			$memberarr['familyjob'] = $param['familyjob'];
		if(isset($param['familyemail']))
			$memberarr['familyemail'] = $param['familyemail'];
		if(isset($param['hobbies']))
			$memberarr['hobbies'] = $param['hobbies'];
		if(isset($param['lovemusic']))
			$memberarr['lovemusic'] = $param['lovemusic'];
		if(isset($param['lovemovies']))
			$memberarr['lovemovies'] = $param['lovemovies'];
		if(isset($param['lovegames']))
			$memberarr['lovegames'] = $param['lovegames'];
		if(isset($param['lovecomics']))
			$memberarr['lovecomics'] = $param['lovecomics'];
		if(isset($param['lovesports']))
			$memberarr['lovesports'] = $param['lovesports'];
		if(isset($param['lovebooks']))
			$memberarr['lovebooks'] = $param['lovebooks'];
			
		$wherearr = array('memberid'=>$param['uid']);
		if (!empty($memberarr)) {
            $afrows+= $this->db->update('ebh_members', $memberarr, $wherearr);
        }
		return $afrows;
	}
	/*
	会员详情
	@param int $uid
	@return array
	*/
	public function getmemberdetail($uid){
		$sql = 'select u.uid,u.username,u.realname,u.nickname,u.face,u.citycode,u.address,u.email,u.sex,m.phone,u.mobile,u.mysign,m.birthdate,m.qq,m.msn,m.native,m.credit,m.profile from ebh_users u join ebh_members m on u.uid = m.memberid where memberid = '.$uid;
		//var_dump($sql);
		return $this->db->query($sql)->row_array();
	}
	/*
	删除会员
	@param int $uid
	@return bool
	*/
	public function deletemember($uid){
		if(empty($uid)){
			return false;
		}
		$sql = 'select groupid from ebh_users where uid ='.intval($uid);
		$groupid = $this->db->query($sql)->row_array();
		if($groupid['groupid'] == 5){//老师
			$sqltea = 'select crid from ebh_roomteachers where tid ='.intval($uid);
			$list = $this->db->query($sqltea)->list_array();
			if(!empty($list)){
				$cridstr = '';
				foreach ($list as $lis) {
					$cridstr = $lis['crid'].',';
				}
				$cridstr = rtrim($cridstr,',');
				$update = 'update ebh_classrooms set teanum = teanum-1 where crid in ('.$cridstr.')';
				$this->db->query($update);
			}
		}elseif ($groupid['groupid'] == 6) {//学生
			$sqlstu = 'select crid from ebh_roomusers where uid='.intval($uid);
			$list = $this->db->query($sqlstu)->list_array();
			$stuclass = 'select classid from ebh_classstudents where uid = '.intval($uid);
			$classlist = $this->db->query($stuclass)->list_array();

			if(!empty($list)){
				$cridstr = '';
				foreach ($list as $lis) {
					$cridstr = $lis['crid'].',';
				}
				$cridstr = rtrim($cridstr,',');
				$update = 'update ebh_classrooms set stunum = stunum-1 where crid in ('.$cridstr.')';
				$this->db->simple_query($update);
			}
			if(!empty($classlist))	{
				$classstr = '';
				foreach ($classlist as $clis) {
					$classstr = $clis['classid'].',';
				}
				$classstr = rtrim($classstr,',');
				$updateclass = 'update ebh_classes set stunum = stunum-1 where classid in ('.$classstr.')';
				$this->db->simple_query($updateclass);
				$this->db->delete('ebh_classstudents','classid in('.$classstr.') and uid ='.intval($uid));
			}	
		}
		$m = $this->db->delete('ebh_members','memberid='.$uid);
		$u = $this->db->delete('ebh_users','uid='.$uid);
		$c = $this->db->delete('ebh_creditlogs','toid='.$uid);

		//$sql = 'delete m.*,u.* from ebh_members m ,ebh_users u where m.memberid = '.$uid.' and u.uid='.$uid;
		return $m&&$u;
	}
	/*
	添加会员
	@param array $param
	@return int
	*/
	public function addmember($param){
		if(!empty($param['username']))
			$userarr['username'] = $param['username'];
		if(!empty($param['password']))
			$userarr['password'] = md5($param['password']);
		if (!empty($param['mpassword']))	//md5加密后的用户密码
                $userarr['password'] = $param['mpassword'];
		if(isset($param['realname']))
			$userarr['realname'] = $param['realname'];
		if(isset($param['nickname']))
			$userarr['nickname'] = $param['nickname'];
		if(!empty($param['dateline']))
			$userarr['dateline'] = $param['dateline'];
		if(isset($param['sex']))
			$userarr['sex'] = $param['sex'];
		if(!empty($param['mobile']))
			$userarr['mobile'] = $param['mobile'];
		if(!empty($param['citycode']))
			$userarr['citycode'] = $param['citycode'];
		if(isset($param['address']))
			$userarr['address'] = $param['address'];
		if(!empty($param['email']))
			$userarr['email'] = $param['email'];
		if(!empty($param['face']))
			$userarr['face'] = $param['face'];
		if(!empty($param['qqopid']))
			$userarr['qqopid'] = $param['qqopid'];
		if(!empty($param['sinaopid']))
			$userarr['sinaopid'] = $param['sinaopid'];
		
		if(!empty($param['wxopenid']))
			$userarr['wxopenid'] = $param['wxopenid'];
		
		if(!empty($param['schoolname']))
			$userarr['schoolname'] = $param['schoolname'];
		$userarr['status'] = 1;
		$userarr['groupid'] = 6;
		// var_dump($userarr);
		$uid = $this->db->insert('ebh_users',$userarr);
		if($uid){
			$memberarr['memberid'] = $uid;
			if(isset($param['realname']))
				$memberarr['realname'] = $param['realname'];
			if(isset($param['nickname']))
				$memberarr['nickname'] = $param['nickname'];
			if(isset($param['sex']))
				$memberarr['sex'] = $param['sex'];
			if(!empty($param['birthdate']))
				$memberarr['birthdate'] = $param['birthdate'];
			if(!empty($param['phone']))
				$memberarr['phone'] = $param['phone'];
			if(!empty($param['mobile']))
				$memberarr['mobile'] = $param['mobile'];
			if(!empty($param['native']))
				$memberarr['native'] = $param['native'];
			if(!empty($param['citycode']))
				$memberarr['citycode'] = $param['citycode'];
			if(isset($param['address']))
				$memberarr['address'] = $param['address'];
			if(!empty($param['msn']))
				$memberarr['msn'] = $param['msn'];
			if(!empty($param['qq']))
				$memberarr['qq'] = $param['qq'];
			if(!empty($param['email']))
				$memberarr['email'] = $param['email'];
			if(!empty($param['face']))
				$memberarr['face'] = $param['face'];
			if(isset($param['profile']))
				$memberarr['profile'] = $param['profile'];
			$memberid = $this->db->insert('ebh_members',$memberarr);
			// var_dump($uid.'___'.$memberid.'````');
			
		}
		return $uid;
	}
	/*
	前台会员查看自己信息
	@param int $uid
	
	*/
	public function getfullinfo($uid){
		$sql = 'select ru.mobile smobile, m.*,u.realname,c.cityname,u.username from ebh_members m
			left join ebh_cities c on m.citycode = c.citycode left join ebh_users u on u.uid = m.memberid left join ebh_roomusers ru on u.uid=ru.uid
			where memberid='.$uid;
		return $this->db->query($sql)->row_array();
	}
	/*
	前台教师查看自己信息
	@param int $uid
	
	*/
	public function getfullinfoT($uid){
		$sql = 'select u.*,c.cityname from ebh_users u
			left join ebh_cities c on u.citycode = c.citycode where u.uid='.$uid;
		return $this->db->query($sql)->row_array();
	}
	/**
	 *根据年份获取会员数量列表
	 *@author zkq
	 *@return array (一维数组);
	 * 实例: getMemberCOuntGroupByYear(2013);返回 array(11,22,33,44,55,66,77,88,99,111,222,333);格式的数组,共计12个月的
	 */
    public function getMemberCountGroupByYear($year){
        $countArr = array();
        for($i=1;$i<=12;$i++){
            $startTime = strtotime($year.'-'.$i.'-1');
            if($i==12){
                $endTime = strtotime(($year+1).'-1-1');
            }else{
                $endTime = strtotime($year.'-'.($i+1).'-1');
            }
            $sql ='select count(*) count from ebh_members m left join ebh_users u on m.memberid = u.uid where u.dateline>='.$startTime.' AND u.dateline<'.$endTime;
            $res = $this->db->query($sql)->row_array();
            $countArr[] = $res['count'];
        }
       
        return $countArr;
    }
	
	public function addMultipleMembers($uarr){
		$sql='insert into ebh_users (username,password,realname,sex,dateline,status,groupid,schoolname,credit,mobile) values ';
		$creditsql = 'select credit from ebh_creditrules where ruleid = 1';
		$res = $this->db->query($creditsql)->row_array();
		$credit = $res['credit'];
		foreach($uarr as $user){
			$username = $user['username'];
			$password = md5($user['password']);
			$realname = $user['realname'];
			$sex = $user['sex'];
			$dateline = $user['dateline'];
			$status = 1;
			$groupid = empty($user['groupid']) ? 6 : $user['groupid'];
			$schoolname = $user['schoolname'];
			$mobile = empty($user['mobile'])?'':$user['mobile'];
			$sql.= "('$username','$password','$realname',$sex,$dateline,$status,$groupid,'$schoolname','$credit','$mobile'),";
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		$fromuid = $this->db->insert_id();
		
		$sql = 'insert into ebh_members (memberid,realname,sex,mobile) values ';
		$i = 0;
		$incoffset = $this->getAutoIncrementOffset();	//数据库自增ID的增量，本地为1  服务器由于双主已变2 此值需要通过最新增加的两条记录计算得出
		foreach($uarr as $user){
			$memberid = $fromuid + $i;
			$realname = $user['realname'];
			$sex = $user['sex'];
			$mobile = empty($user['mobile'])?'':$user['mobile'];
			$sql.= "($memberid,'".$realname."',$sex,'$mobile'),";
			$i = $i + $incoffset;
		}
		$sql = rtrim($sql,',');
		$this->db->query($sql);
		return $fromuid;
	}
	/**
	 * 获取数据库对应的AUTO_INCREMENT自增偏移量，默认都为1，线上环境已变成2，通过 用户表users最后两条记录来取出偏移量
	 */
	public function getAutoIncrementOffset() {
		$offset = 1;
		$sql = 'select uid from ebh_users order by uid desc limit 2';
		$uidlist = $this->db->query($sql)->list_array();
		if (count($uidlist) == 2) {
			$offset = $uidlist[0]['uid'] - $uidlist[1]['uid'];
		}
		return $offset;
	}

	/**
	 * 查询在网校班级中的用户信息
	 */
	public function getStudentInfoByClassid($classid,$realname){
		if(empty($classid) || empty($realname)){
			return false;
		}
		$sql = 'SELECT m.memberid,m.realname,cl.classid from ebh_members m 
				LEFT JOIN ebh_classstudents cl on cl.uid = m.memberid
				where cl.classid = '.intval($classid).' and m.realname in ('.$realname.') GROUP BY m.memberid';
		return $this->db->query($sql)->list_array(); 
	}
}
?>