<?php
/**
 * 选课模型 SelectCourseModel
 */
class SelectcourseModel extends CModel{
	/**
	 * 添加选课课程
	 * @param array $param 参数
	 * @return integar        insertid
	 */
	public function addSelectCourse($param)
	{
		$setarr = array();
		if (!empty($param['folderid']))
			$setarr['folderid'] = $param['folderid'];
		else
			return false;
		if (!empty($param['location']))
			$setarr['location'] = $param['location'];
		if (!empty($param['admitnum']))
			$setarr['admitnum'] = $param['admitnum'];
		if (isset($param['isforbidden']))
			$setarr['isforbidden'] = $param['isforbidden'];
		if (isset($param['allowgrade']))
			$setarr['allowgrade'] = $param['allowgrade'];

		return $this->db->insert('ebh_selectcourse', $setarr);
	}

	public function editSelectCourse($param)
	{
		$setarr = array();
		$wherearr = array();
		if (!empty($param['folderid']))
			$wherearr['folderid'] = $param['folderid'];
		else
			return false;
		if (isset($param['location']))
			$setarr['location'] = $param['location'];
		if (isset($param['admitnum']))
			$setarr['admitnum'] = $param['admitnum'];
		if (isset($param['isforbidden']))
			$setarr['isforbidden'] = $param['isforbidden'];
		if (isset($param['allowgrade']))
			$setarr['allowgrade'] = $param['allowgrade'];

		return $this->db->update('ebh_selectcourse',$setarr,$wherearr);
	}
	/**
	 * 选课列表
	 * @param  array $param 参数
	 * @return array       选课列表
	 */
	public function getCourseList($param)
	{
		$sql = 'SELECT sc.folderid,sc.location,sc.admitnum,sc.regnum,sc.totalnum,sc.isforbidden,sc.allowgrade,f.foldername,f.img,f.speaker,f.coursewarenum FROM ebh_selectcourse sc JOIN ebh_folders f ON sc.folderid=f.folderid';
		$wherearr = array();
		if (!empty($param['crid']))
			$wherearr[] = 'f.crid=' . intval($param['crid']);
		if (isset($param['nosubfolder']))
			$wherearr [] = ' f.folderlevel = 2';
		if (!empty($param['q']))
			$wherearr [] = 'f.foldername like \'%'.$this->db->escape_str($param['q']).'%\'';
		if (!empty($param['mygrade']))
			$wherearr [] = '(sc.allowgrade = \'0\' or sc.allowgrade like \'%,'.intval($param['mygrade']).',%\')';
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		if (!empty($param['order']))
			$sql .= ' ORDER BY '.$param['order'];
		else
			$sql .= ' ORDER BY f.displayorder';
		if (!empty($param['limit'])) {
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
	 * 获得选课总数
	 * @param  array $param 参数
	 * @return integer        总数
	 */
	public function getCourseCount($param)
	{
		$sql = 'SELECT count(*) as count FROM ebh_selectcourse sc JOIN ebh_folders f ON sc.folderid=f.folderid';
		$wherearr = array();
		if (!empty($param['crid']))
			$wherearr[] = 'f.crid=' . intval($param['crid']);
		if (isset($param['nosubfolder']))
			$wherearr [] = ' f.folderlevel = 2';
		if (!empty($param['q']))
			$wherearr [] = 'f.foldername like \'%'.$this->db->escape_str($param['q']).'%\'';
		if (!empty($param['mygrade']))
			$wherearr [] = '(sc.allowgrade = \'0\' or sc.allowgrade like \'%,'.intval($param['mygrade']).',%\')';
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}

	//获得选课详情
	public function getCourseDetail($folderid)
	{
		if (empty($folderid))
			return false;
		$sql = 'SELECT sc.folderid,sc.location,sc.admitnum,sc.regnum,sc.isforbidden,sc.allowgrade,f.foldername,f.img,f.speaker,f.summary,f.detail FROM ebh_selectcourse sc LEFT JOIN ebh_folders f ON sc.folderid=f.folderid WHERE sc.folderid=' . intval($folderid);
		return $this->db->query($sql)->row_array();
	}

	/**
	 * 删除选课课程
	 * @param  [type] $param [description]
	 * @return [type]        [description]
	 */
	public function deletecourse($param){
		$this->db->begin_trans();
		if(!empty($param['folderid']) && !empty($param['crid'])){
			$wherearr['folderid'] = $param['folderid'];
			$this->db->delete('ebh_selectcourse',$wherearr);
			$this->db->delete('ebh_selectcourseusers',$wherearr);
			$wherearr['crid'] = $param['crid'];
			$this->db->delete('ebh_folders',$wherearr);
			$this->db->delete('ebh_teacherfolders',$wherearr);
		}
		if($this->db->trans_status()===FALSE) {
            $this->db->rollback_trans();
            return FALSE;
        } else {
            $this->db->commit_trans();
        }
		return TRUE;
	}

	/*
	 * 选课课程移动
	*/
	public function moveit($param){
		if(empty($param['folderid']))
			return false;
		$sql = "SELECT f.folderid,f.upid,f.displayorder,f.folderlevel FROM ebh_folders f WHERE f.folderid=".$param['folderid']." and f.crid=".$param['crid'];
		$thisfolder = $this->db->query($sql)->row_array();
		$sqlsameorder = "SELECT f.folderid,f.displayorder FROM ebh_folders f WHERE f.folderlevel=".$thisfolder['folderlevel']." and f.crid=".$param['crid']." and displayorder=".$thisfolder['displayorder']." and f.folderid<>".$thisfolder['folderid'];
		$sameorder = $this->db->query($sqlsameorder)->row_array();
		if(!empty($sameorder)){
			if($param['compare'] == '<')
				$op = '-';
			else
				$op = '+';
			$sqlAllforone = 'update ebh_folders set displayorder=displayorder'.$op.'1 where crid='.$param['crid'].' and displayorder'.$param['compare'].'='.$thisfolder['displayorder'].' and folderlevel='.$thisfolder['folderlevel'].' and folderid<>'.$thisfolder['folderid'];
			$this->db->query($sqlAllforone);
		}

		$sql2 = 'select f.folderid,f.upid,f.displayorder,f.folderlevel from ebh_selectcourse sc LEFT JOIN ebh_folders f ON sc.folderid=f.folderid ';
		$wherearr[] = 'f.crid='.$param['crid'];
		$wherearr[] = 'f.displayorder'.$param['compare'].$thisfolder['displayorder'];
		$wherearr[] = 'f.folderlevel='.$thisfolder['folderlevel'];
		$sql2 .= ' where '.implode(' AND ',$wherearr);
		$sql2 .= ' order by '.$param['order'];
		$sql2 .= ' limit 1';
		$desfolder = $this->db->query($sql2)->row_array();
		if(empty($desfolder))
			return false;
		$this->db->update('ebh_folders',array('displayorder'=>$desfolder['displayorder']),array('folderid'=>$thisfolder['folderid']));
        $this->db->update('ebh_folders',array('displayorder'=>$thisfolder['displayorder']),array('folderid'=>$desfolder['folderid']));
        return true;
	}

	/**
	 * 获得已报名课程信息
	 * @return [type] [description]
	 */
	public function getRegCourse($param) {
		$sql = 'SELECT scu.folderid,scu.regtime,f.foldername FROM ebh_selectcourseusers scu LEFT JOIN ebh_folders f ON scu.folderid=f.folderid';
		$wherearr = array();
		if (!empty($param['uid']))
			$wherearr[] = 'scu.uid=' . intval($param['uid']);
		else
			return false;
		if (!empty($param['crid']))
			$wherearr[] = 'f.crid=' . intval($param['crid']);
		if (!empty($param['folderid']))
			$wherearr[] = 'scu.folderid=' . intval($param['folderid']);
		$wherearr[] = 'isnew=1';
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$sql .= ' LIMIT 1';
		return $this->db->query($sql)->row_array();
	}

	/**
	 * 报名
	 * @param  [type] $param [description]
	 * @return [type]        [description]
	 */
	public function regCourse($param) {
		$setarr = array();
		if (!empty($param['uid']))
			$setarr['uid'] = $param['uid'];
		else
			return false;
		if (!empty($param['folderid']))
			$setarr['folderid'] = $param['folderid'];
		else
			return false;
		if (!empty($param['crid']))
			$crid = $param['crid'];
		else
			return false;
		$setarr['regtime'] = SYSTIME;
		$setarr['isnew'] = 1;

		$regcourse = $this->getRegCourse(array(
			'uid'=>$param['uid'],
			'crid'=>$crid
		));
		if (!empty($regcourse))
		{
			//退订
			$this->unRegCourse(array(
				'uid' => $param['uid'],
				'folderid' => $regcourse['folderid']
			));
		}

		$this->db->begin_trans();
		$this->db->insert('ebh_selectcourseusers', $setarr);
		$this->db->update('ebh_selectcourse', array(), array('folderid' => $param['folderid']), array('regnum' => 'regnum+1'));
		if($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        } else {
            $this->db->commit_trans();
        }
		return true;
	}

	/**
	 * 退订
	 * @param  [type] $param 参数
	 * @return boolean        是否成功
	 */
	public function unRegCourse($param) {
		if (!empty($param['uid']))
			$wherearr['uid'] = $param['uid'];
		else
			return false;
		if (!empty($param['folderid']))
			$wherearr['folderid'] = $param['folderid'];
		else
			return false;
		$wherearr['isnew'] = 1;

		$this->db->begin_trans();
		$this->db->delete('ebh_selectcourseusers',$wherearr);
		$this->db->update('ebh_selectcourse', array(), array('folderid' => $param['folderid']), array('regnum' => 'regnum-1'));
		if($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        } else {
            $this->db->commit_trans();
        }
		return true;
	}

	/**
	 * 获取某门课报名学生列表
	 * @param  array $param 参数
	 * @return arary        列表
	 */
	public function getStudentList($param) {
		$sql = 'SELECT u.uid,u.sex,u.username,u.realname,u.face,u.email,u.mobile,cl.classid,cl.classname FROM ebh_selectcourseusers scu';
		$sql .= ' LEFT JOIN ebh_folders f ON scu.folderid=f.folderid';
		$sql .= ' LEFT JOIN ebh_users u ON scu.uid=u.uid';
		$sql .= ' LEFT JOIN ebh_classstudents st ON u.uid=st.uid';
		$sql .= ' LEFT JOIN ebh_classes cl ON st.classid = cl.classid';
		$wherearr = array();
		if (!empty($param['folderid']))
			$wherearr[] = 'scu.folderid=' . intval($param['folderid']);
		if (!empty($param['crid']))
			$wherearr[] = 'f.crid=' . intval($param['crid']);
			$wherearr[] = 'cl.crid=' . intval($param['crid']);
		if (isset($param['isnew']))
			$wherearr[] = 'scu.isnew=' . intval($param['isnew']);
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		if (!empty($param['limit'])) {
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

	public function getStudentCount($param) {
		$sql = 'SELECT count(*) as count FROM ebh_selectcourseusers scu';
		$sql .= ' LEFT JOIN ebh_folders f ON scu.folderid=f.folderid';
		$sql .= ' LEFT JOIN ebh_users u ON scu.uid=u.uid';
		$sql .= ' LEFT JOIN ebh_classstudents st ON u.uid=st.uid';
		$sql .= ' LEFT JOIN ebh_classes cl ON st.classid = cl.classid';
		$wherearr = array();
		if (!empty($param['folderid']))
			$wherearr[] = 'scu.folderid=' . intval($param['folderid']);
		if (!empty($param['crid']))
			$wherearr[] = 'f.crid=' . intval($param['crid']);
			$wherearr[] = 'cl.crid=' . intval($param['crid']);
		if (isset($param['isnew']))
			$wherearr[] = 'scu.isnew=' . intval($param['isnew']);
		$sql .= ' WHERE ' . implode(' AND ', $wherearr);
		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
		return $count;
	}

	/**
	 * 获取报名时间期限
	 * @param  integer $crid 学校编号
	 * @return array       报名时间
	 */
	public function getRegTime($crid = 0){
		$regtime = array();
		$sql = 'SELECT begintime,endtime FROM ebh_selectcourseterms WHERE crid=' . intval($crid);
		$row = $this->db->query($sql)->row_array();
		$regtime['begintime'] = empty($row['begintime']) ? '' : $row['begintime'];
		$regtime['endtime'] = empty($row['endtime']) ? '' : $row['endtime'];
		return $regtime;
	}

	/**
	 * 设置报名时间
	 * @param [type] $param 参数
	 */
	public function setRegTime($param){
		$setarr = array();
		if (empty($param['crid']) || empty($param['uid']) || empty($param['begintime']) || empty($param['endtime']))
		{
			return FALSE;
		}
		$sql = 'SELECT termid FROM ebh_selectcourseterms WHERE crid=' . intval($param['crid']);
		$row = $this->db->query($sql)->row_array();
		$setarr['begintime'] = $param['begintime'];
		$setarr['endtime'] = $param['endtime'];
		$setarr['uid'] = $param['uid'];
		if (!empty($row))
		{
			$this->db->update('ebh_selectcourseterms', $setarr, array('termid' => $row['termid']));
		}
		else
		{
			$this->db->insert('ebh_selectcourseterms', $param);
		}
	}

	public function resetreg($crid){
		if (empty($crid))
			return FALSE;
		$param['crid'] = $crid;
		$param['nosubfolder'] = 1;
		$param['limit'] = 1000;
		$courselist = $this->getCourseList($param);
		$folderids = '';
		if (!empty($courselist))
		{
			foreach ($courselist as $course)
			{
				$folderids .= $course['folderid'] . ',';
			}
			$folderids = rtrim($folderids, ',');

			$this->db->update('ebh_selectcourse', array(), 'folderid in ('. $folderids .')',array('totalnum' => 'totalnum+regnum'));
			$this->db->update('ebh_selectcourse', array('regnum' => 0), 'folderid in ('. $folderids .')');
			$this->db->query('UPDATE ebh_selectcourseusers SET isnew=0 WHERE folderid in ('. $folderids .') AND isnew=1');
		}

		$this->db->update('ebh_selectcourseterms', array('begintime'=>0, 'endtime'=>0), 'crid='.intval($crid));
		return TRUE;
	}
}