<?php
Class PublishModel extends CModel{
	/*
	第一个学生
	*/
	public function getFirstStu($crid){
		$sql = 'select cdateline dateline,ru.uid,u.realname,u.username from ebh_roomusers ru join ebh_users u on ru.uid=u.uid where crid = '.$crid.' and realname<>\'\'';
		$sql .= ' order by cdateline limit 1';
		return $this->db->query($sql)->row_array();
	}
	
	/*
	第一个课件
	*/
	public function getFirstCourse($crid){
		$sql = 'select dateline,title from ebh_roomcourses rc join ebh_coursewares c on rc.cwid=c.cwid where crid ='.$crid;
		$sql .= ' order by dateline limit 1';
		return $this->db->query($sql)->row_array();
	}
	
	/*
	第一次互动
	*/
	public function getFirstIaclass($crid){
		$sql = 'select username,realname,l.dateline from ebh_iaclassroom i 
				join ebh_iaclassroomlog l on i.icid = l.icid 
				join ebh_users u on u.uid=l.uid
				where crid='.$crid.' and realname<>\'\'';
		$sql .= ' order by l.dateline limit 1';
		return $this->db->query($sql)->row_array();
	}
	
	/*
	第一条评论
	*/
	public function getFirstReview($crid){
		$sql = 'select username,realname,r.dateline from ebh_reviews r 
				join ebh_roomcourses rc on r.toid=rc.cwid
				join ebh_users u on r.uid=u.uid
				where r.type=\'courseware\' and rc.crid='.$crid.' and realname<>\'\'';
		$sql .= ' order by r.dateline limit 1';
		// echo $sql;
		return $this->db->query($sql)->row_array();
	}
	
	/*
	第一份作业
	*/
	public function getFirstExam($crid){
		$sql = 'select username,realname,classname,a.dateline from ebh_schexams e 
				join ebh_schexamanswers a on e.eid=a.eid
				join ebh_classes c on e.classid=c.classid
				join ebh_users u on a.uid = u.uid
				where e.crid='.$crid .' and realname<>\'\'';
		$sql .= ' order by a.dateline limit 1';
		// echo $sql;
		return $this->db->query($sql)->row_array();
	}
	
	/*
	第一次提问
	*/
	public function getFirstAsk($crid){
		$sql = 'select username,realname,a.dateline from ebh_askquestions a 
				join ebh_users u on a.uid = u.uid
				where a.crid='.$crid .' and realname<>\'\'';
		$sql .= ' order by a.dateline limit 1';
		// echo $sql;
		return $this->db->query($sql)->row_array();
	}
	
	/*
	第一个通知
	*/
	public function getFirstNotice($crid){
		$sql = 'select dateline from ebh_notices
				where crid='.$crid;
		$sql .= ' order by dateline limit 1';
		// echo $sql;
		return $this->db->query($sql)->row_array();
		
	}
	
	/*
	第一份调查问卷
	*/
	public function getFirstSurvey($crid){
		$sql = 'select dateline from ebh_surveys
				where crid='.$crid;
		$sql .= ' order by dateline limit 1';
		// echo $sql;
		return $this->db->query($sql)->row_array();	
	}
	
	/*
	学校课件数
	*/
	public function getIaclassroomCount($crid){
		$sql = 'select count(*) count from ebh_iaclassroom where crid = '.$crid;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	/*
	学校课件数
	*/
	public function getTeacherCount($crid){
		$sql = 'select count(*) count from ebh_roomteachers where crid = '.$crid;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	
	
	/*
	课程列表
	*/
	public function getCourseList($crid){
		$sql = 'select foldername,viewnum,img from ebh_folders where folderlevel <>1 and crid='.$crid;
		$sql .= ' order by viewnum desc';
		
		return $this->db->query($sql)->list_array();
	}
	
	
	/*
	积分记录
	*/
	public function getCreditLogList($crid){
		$sql = 'select face,u.sex,username,realname,action,description,l.dateline,l.credit,detail 
				from ebh_creditlogs l 
				join ebh_creditrules r on l.ruleid=r.ruleid
				join ebh_users u on l.toid=u.uid
				join ebh_roomusers ru on u.uid=ru.uid';
		$sql.= ' where ru.crid='.$crid.' and groupid=6';
		$sql.= ' order by l.dateline desc limit 5';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	积分排名
	*/
	public function getCreditList($crid){
		$sql = 'select username,realname,credit,face,u.sex from ebh_users u
				join ebh_roomusers ru on ru.uid=u.uid
				where crid='.$crid;
		$sql.= ' order by credit desc limit 6';
		return $this->db->query($sql)->list_array();
	}
	
	
	/*
	女生比例
	*/
	public function getFemalePercent($crid){
		$sql = 'select sum(u.sex)/count(*)*100 femalepercent 
			from ebh_roomusers ru 
			join ebh_users u on ru.uid=u.uid 
			where crid ='.$crid;
		return $this->db->query($sql)->row_array();
	}
	
	/*
	最后登录时间
	*/
	public function getLastloginList($crid){
		$sql = 'select FROM_UNIXTIME(u.lastlogintime,\'%k\') hour
				from ebh_users u 
				join ebh_roomusers ru on u.uid=ru.uid 
				where crid='.$crid;
		return $this->db->query($sql)->list_array();
	}
}

?>