<?php
/*
学习进度
*/
class ProgressModel extends CModel{
	/*
	依据folderid获取课件进度
	*/
	public function getFolderProgressByFolderid($param){
		if(empty($param['folderid']))
			return array();
		$wherearr = array();
		$sql = 'select logid,max(ltime)/ctime percent,title,cw.cwid,cwurl,rc.folderid from ebh_coursewares cw join ebh_roomcourses rc on rc.cwid=cw.cwid left join ebh_playlogs p on p.cwid=cw.cwid ';
		$wherearr[] = 'rc.folderid in('.$param['folderid'].')';
		$wherearr[] = 'cw.status=1';
		// $wherearr[] = '(right(cw.cwurl,4)=\'.flv\' or right(cw.cwurl,5)=\'.ebhp\')';
		$wherearr[] = 'cw.ism3u8=1';
		if(!empty($param['uid']))
			$wherearr[] = 'p.uid='.$param['uid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by cw.cwid ';
		$sql.= ' order by cw.displayorder ASC,cw.cwid DESC ';
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		// echo $sql.'________';
		return $this->db->query($sql)->list_array();

	}
	/*
	依据folderid获取课件进度
	*/
	public function getFolderProgressCountByFolderid($param){
		$sql = 'select count(*) count,folderid from ebh_roomcourses rc join ebh_coursewares cw on(rc.cwid = cw.cwid)';
		$wherearr[] = 'rc.folderid in('.$param['folderid'].')';
		$wherearr[] = 'cw.status=1';
		$wherearr[] = 'cw.ism3u8=1';
		// $wherearr[] = '(right(cw.cwurl,4)=\'.flv\' or right(cw.cwurl,5)=\'.ebhp\')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by rc.folderid';
		// echo $sql.'__________';
		$countlist = $this->db->query($sql)->list_array();
		return $countlist;
	}
	
	/*
	获取课件列表
	*/
	public function getCWByFolderid($param){
		$sql = 'select cw.cwid,rc.folderid,cw.cwurl,cw.title,rc.sid from ebh_coursewares cw join ebh_roomcourses rc on cw.cwid=rc.cwid';
		$wherearr = array();
		$wherearr[] = 'rc.folderid in('.$param['folderid'].')';
		$wherearr[] = 'cw.status=1';
		$wherearr[] = 'cw.ism3u8=1';
		// $wherearr[] = '(right(cw.cwurl,4)=\'.flv\' or right(cw.cwurl,5)=\'.ebhp\')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		// echo $sql.'____________';
		return $this->db->query($sql)->list_array();
	}

    /*
     * 获取课件播放总时长
     */
    public function getCWlenthFolderid($param){
        $sql = 'select sum(cw.cwlength) as length from ebh_coursewares cw join ebh_roomcourses rc on cw.cwid=rc.cwid';
        $wherearr = array();
        $wherearr[] = 'rc.folderid in('.$param['folderid'].')';
        $wherearr[] = 'cw.status=1';
        $wherearr[] = 'cw.ism3u8=1';
        // $wherearr[] = '(right(cw.cwurl,4)=\'.flv\' or right(cw.cwurl,5)=\'.ebhp\')';
        $sql.= ' where '.implode(' AND ',$wherearr);
        // echo $sql.'____________';
        $res = $this->db->query($sql)->row_array();
        return $res['length'];
    }
	/*
	依据cwid获取课件进度
	*/
	public function getFolderProgressByCwid($param){
		$sql = 'select cwid,ltime/ctime percent from ebh_playlogs';
		$wherearr[] = ' cwid in('.$param['cwid'].')';
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.$param['uid'];
		$wherearr[] = ' totalflag=1';
		$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql.'___________';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	依据cwid获取课件进度，课件听课累计时长
	*/
	public function getFolderProgressByCwid_cwsum($param){
		$sql = 'select cwid,sum(ltime)/ctime percent from ebh_playlogs';
		$wherearr[] = ' cwid in('.$param['cwid'].')';
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.$param['uid'];
		$wherearr[] = 'totalflag=0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by cwid';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	课程各目录中分别小于某cdisplayorder的课件进度情况
	*/
	public function getProgressBeforeInSection($param){
		$sql = 'select pl.cwid,max(pl.ltime/pl.ctime) p from ebh_playlogs pl';
		$wherearr[] = 'pl.uid='.$param['uid'];
		$wherearr[] = 'pl.cwid in ('.$param['cwids'].')';
		$sql.= ' where '.implode(' AND ',$wherearr);
		// echo $sql;
		return $this->db->query($sql)->list_array();
	}
	
	public function getBeforeInSection($param){
		$sql = 'select rc.cwid,rc.cdisplayorder,c.cwid,rc.sid 
				from ebh_roomcourses rc 
				left join ebh_coursewares c on c.cwid=rc.cwid ';
		$wherearr[] = 'rc.crid='.$param['crid'];
		$wherearr[] = 'rc.folderid='.$param['folderid'];
		$wherearr[] = 'rc.sid='.$param['sid'];
		$wherearr[] = 'c.status=1';
		$wherearr[] = 'rc.cdisplayorder<'.$param['cdisplayorder'];
		
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by rc.sid,rc.cwid';
		// echo $sql.'___';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	学生课程学习总时间
	*/
	public function getCourseSumTime($param){
		$sql = 'select cwid,sum(ltime) sumtime from ebh_playlogs ';
		$wherearr[] = ' cwid in('.$param['cwid'].')';
		if(!empty($param['uid']))
			$wherearr[] = 'uid='.$param['uid'];
		$wherearr[] = ' totalflag=0';
		$sql.= ' where '.implode(' AND ',$wherearr);
		$sql.= ' group by cwid';
		// echo $sql.'___________';
		return $this->db->query($sql)->list_array();
	}
	
	/*
	学校下,学习记录
	*/
	public function getRoomStudyRecord($param){
		$sql = 'select p.cwid,max(ltime) ltime,sum(ltime) sumtime,ctime,count(p.cwid) rcount,cw.title,min(startdate) startdate,f.folderid,f.foldername,cw.logo,cw.cwlength
				from ebh_playlogs p
				join ebh_roomcourses rc on p.cwid=rc.cwid
				join ebh_coursewares cw on p.cwid=cw.cwid
				join ebh_folders f on f.folderid=rc.folderid';
		$wherearr[] = 'p.uid = '.$param['uid'];
		$wherearr[] = 'rc.crid = '.$param['crid'];
		$wherearr[] = 'cw.status = 1';
		
		$sql .= ' where '.implode(' AND ',$wherearr);			
		$sql .= ' group by f.folderid,p.cwid';
		if(!empty($param['order'])){
			$sql .= $param['order'];
		}
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
		else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
		}
		// echo $sql;
		return $this->db->query($sql)->list_array();
		
	}
	
	/*
	学校下,学习记录数量
	*/
	public function getRoomStudyRecordCount($param){
		$sql = 'select count(1) count from (select p.cwid
				from ebh_playlogs p 
				join ebh_roomcourses rc on p.cwid=rc.cwid
				join ebh_coursewares cw on p.cwid=cw.cwid';
		$wherearr[] = 'p.uid = '.$param['uid'];
		$wherearr[] = 'rc.crid = '.$param['crid'];
		$wherearr[] = 'cw.status = 1';
		$sql .= ' where '.implode(' AND ',$wherearr);
		$sql .= ' group by p.cwid) as t';
		// echo $sql;
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	依据folderid获取课件进度
	*/
	public function getCWProgressByFolderid($param){
		if(empty($param['folderid']) || empty($param['uid']))
			return FALSE;
		$wherearr = array();
		$sql = 'select cw.cwid,p.ctime,p.ltime from ebh_coursewares cw join ebh_roomcourses rc on rc.cwid=cw.cwid left join ebh_playlogs p on p.cwid=cw.cwid and p.uid='.$param['uid'].' and p.totalflag=1';
		$wherearr[] = 'rc.folderid ='.$param['folderid'];
		$wherearr[] = 'cw.status=1';
		$wherearr[] = 'cw.ism3u8=1';
		$sql.= ' where '.implode(' AND ',$wherearr);

		return $this->db->query($sql)->list_array();
	}

	/*
	学校下,获取某个学生播放过的课件
	*/
	public function getRoomStudyCourse($param){
		if(empty($param['crid']) || empty($param['uid']))
			return FALSE;
		$sql = 'select c.cwid,c.cwlength as ctime,c.logo,c.cwlength,c.title,f.folderid,f.foldername,l.ltime,l.startdate from  ebh_coursewares c
				join ebh_playlogs l on (c.cwid=l.cwid)
				join ebh_roomcourses rc on (c.cwid=rc.cwid)
				join ebh_folders f on (f.folderid=rc.folderid)';
		$wherearr[] = 'l.uid = '.$param['uid'];
		$wherearr[] = 'l.totalflag = 1';
		$wherearr[] = 'l.crid = '.$param['crid'];
		$wherearr[] = 'c.status = 1';
		
		$sql .= ' where '.implode(' AND ',$wherearr);			
		if(!empty($param['order'])){
			$sql .= $param['order'];
		}
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
		else {
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
	学校下,获取某个学生播放过的课件的记录数
	*/
	public function getRoomStudyCourseCount($param){
		if(empty($param['crid']) || empty($param['uid']))
			return 0;
		$sql = 'select count(*) count from  ebh_coursewares c
				join ebh_playlogs l on (c.cwid=l.cwid)
				join ebh_roomcourses rc on (c.cwid=rc.cwid)';
		$wherearr[] = 'l.uid = '.$param['uid'];
		$wherearr[] = 'l.totalflag = 1';
		$wherearr[] = 'l.crid = '.$param['crid'];
		$wherearr[] = 'c.status = 1';
		$sql .= ' where '.implode(' AND ',$wherearr);
		$count = $this->db->query($sql)->row_array();
		return $count['count'];
	}
	/*
	学校下,根据课件编号组合获取相关的课件信息，主要用于进度显示
	*/
	public function getRoomCourseByIds($param){
		if(empty($param['crid']))
			return FALSE;
		$sql = 'select c.cwid,c.cwlength as ctime,c.logo,c.cwlength,c.title,f.folderid,f.foldername from  ebh_coursewares c
				join ebh_roomcourses rc on (c.cwid=rc.cwid)
				join ebh_folders f on (f.folderid=rc.folderid)';
		$wherearr[] = 'rc.crid = '.$param['crid'];
		$wherearr[] = 'c.status = 1';
		if (!empty($param['cwids'])) {
			$wherearr[] = 'c.cwid in ('.$param['cwids'].')';
		}
		
		$sql .= ' where '.implode(' AND ',$wherearr);			
		if(!empty($param['order'])){
			$sql .= $param['order'];
		}
		if(!empty($param['limit'])) {
            $sql .= ' limit '. $param['limit'];
        }
		else {
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
}
?>