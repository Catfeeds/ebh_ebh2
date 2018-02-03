<?php
/**
 * 课件笔记Model类
 */
class NoteModel extends CModel{

	/**
	*添加笔记记录
	*/
	function insert($param = array()){
		if(empty($param['cwid']) || empty($param['uid']))
			return FALSE;
		$setarr = array();
		if (isset($param['crid'])){
			$setarr['crid'] = $param['crid'];
		}
		if (isset($param['uid'])){
				$setarr['uid'] = $param['uid'];
		}
		if (isset($param['cwid'])){
			$setarr['cwid'] = $param['cwid'];
		}
		if (!empty($param['source'])){
			$setarr['source'] = $param['source'];
		}
		if (!empty($param['url'])){
			$setarr['url'] = $param['url'];
		}
		if (isset($param['size'])){
			$setarr['size'] = $param['size'];
		}
		$setarr['dateline'] = SYSTIME;
		return $this->db->insert('ebh_notes',$setarr);
	}
	/**
	*编辑笔记记录
	*/
	function update($param,$noteid){
		if(empty($noteid))
			return FALSE;
		$wherearr = array('noteid'=>$noteid);
		$setarr = array();
        if (!empty($param['source'])){
			$setarr['source'] = $param['source'];
		}
		if (!empty($param['url'])){
			$setarr['url'] = $param['url'];
		}
		if (isset($param['size'])){
			$setarr['size'] = $param['size'];
		}
		if(!empty($setarr))
			return FALSE;
		return $this->db->update('ebh_notes',$setarr,$wherearr);
	}
	/**
	*删除笔记
	*/
	public function delete($param) {
		if(empty($param['noteid']))	//笔记编号不能为空
			return FALSE;
		$wherearr = array('noteid'=>$param['noteid']);	
		if(!empty($param['uid']))	//笔记所有人编号
			$wherearr['uid'] = array('uid'=>$param['uid']);
		$afrows = $this->db->delete('ebh_notes',$wherearr);
		return $afrows;
	}
    public function getNote($param = array()) {
        if(empty($param['noteid']) && empty($param['uid']))
            return FALSE;
        $sql = 'select n.noteid,n.uid,n.cwid,n.crid,n.source,n.url,n.size,n.dateline from ebh_notes n';
        $wherearr = array();
        if(!empty($param['noteid']))
            $wherearr[] = 'n.noteid='.$param['noteid'];
        if(!empty($param['uid']))
            $wherearr[] = 'n.uid='.$param['uid'];
		if(!empty($param['cwid']))
            $wherearr[] = 'n.cwid='.$param['cwid'];
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        return $this->db->query($sql)->row_array();
    }
	/**
	*获取笔记列表
	*/
	public function getNoteList($param) {
		$sql = 'select n.noteid,n.uid,n.cwid,n.crid,n.source,n.url,n.size,n.dateline from ebh_notes n';
		$wherearr = array();	
		if(!empty($param['noteid']))	//根据笔记编号
            $wherearr[] = 'n.noteid='.$param['noteid'];
		if(!empty($param['uid']))	//根据用户编号
            $wherearr[] = 'n.uid='.$param['uid'];
		if(!empty($param['crid']))	//根据平台编号
			$wherearr[] = 'n.crid='.$param['crid'];
		if(emtpy($wherearr))
			return FALSE;
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' order by '.$param['order'];
		if(!empty($param['limit']))
			$sql .= ' limit '.$param['limit'];
		else
			$sql .= ' limit 0,10';
		return $this->db->query($sql)->list_array();
	}
    /**
     * 根据平台编号获取平台内学生的笔记
     * @param type $param
     * @return boolean
     */
    public function getnotelistbycrid($param) {
        if(empty($param['crid']))
            return FALSE;
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'SELECT n.noteid,n.uid,n.cwid,n.dateline,u.username,u.realname, c.title,c.cwsource FROM ebh_notes n '
            .'join ebh_users u on n.uid=u.uid '
            .'join ebh_coursewares c on n.cwid = c.cwid  ';
        $wherearr = array();
        $wherearr[] = 'n.crid='.$param['crid'];
		if(!empty($param['uid']))	//过滤会员笔记
			$wherearr[] = 'n.uid ='.$param['uid'];
        if(!empty($param['stardateline']))	//过滤笔记开始时间
            $wherearr[] = 'n.dateline>='.$param['stardateline'];
        if(!empty($param['enddateline']))	//过滤笔记结束时间
            $wherearr[] = 'n.dateline<'.$param['enddateline'];
        if(!empty($param['q'])) {
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = '(u.username like \'%'.$q.'%\' OR u.realname like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\')'; 
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['order']))
            $sql .= ' ORDER BY '.$param['order'];
        else
            $sql .= ' ORDER BY n.noteid desc ';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据平台编号获取平台内学生的笔记记录数
     * @param type $param
     * @return boolean
     */
    public function getnotelistcountbycrid($param) {
        $count = 0;
        if(empty($param['crid']))
            return $count;
        $sql = 'SELECT count(*) count FROM ebh_notes n '
            .'join ebh_users u on n.uid=u.uid '
            .'join ebh_coursewares c on n.cwid = c.cwid  ';
        $wherearr = array();
        $wherearr[] = 'n.crid='.$param['crid'];
		if(!empty($param['uid']))	//过滤会员笔记
			$wherearr[] = 'n.uid ='.$param['uid'];
        if(!empty($param['stardateline']))	//过滤笔记开始时间
            $wherearr[] = 'n.dateline>='.$param['stardateline'];
        if(!empty($param['enddateline']))	//过滤笔记结束时间
            $wherearr[] = 'n.dateline<'.$param['enddateline'];
        if(!empty($param['q'])) {
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = '(u.username like \'%'.$q.'%\' OR u.realname like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\')'; 
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
            $count = $row['count'];
        return $count;
    }
	/**
     * 根据平台编号和班级编号获取平台内学生的笔记
     * @param type $param
     * @return boolean
     */
    public function getnotelistbyclassid($param) {
        if(empty($param['crid']))
            return FALSE;
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'SELECT n.noteid,n.uid,n.cwid,n.dateline,u.username,u.realname, c.title,c.cwsource FROM ebh_notes n '
            .'join ebh_users u on n.uid=u.uid '
            .'join ebh_coursewares c on n.cwid = c.cwid '
			.'join ebh_classstudents cs on (cs.uid=n.uid) ';
        $wherearr = array();
        $wherearr[] = 'n.crid='.$param['crid'];
		if(!empty($param['uid']))	//过滤会员笔记
			$wherearr[] = 'n.uid ='.$param['uid'];
		if(!empty($param['classid']))	//所在班级的会员笔记
			$wherearr[] = 'cs.classid in ('.$param['classid'].')';
		if(!empty($param['tid']))	//过滤课件制作教师的编号
			$wherearr[] = 'c.uid = '.$param['tid'];
        if(!empty($param['stardateline']))	//过滤笔记开始时间
            $wherearr[] = 'n.dateline>='.$param['stardateline'];
        if(!empty($param['enddateline']))	//过滤笔记结束时间
            $wherearr[] = 'n.dateline<'.$param['enddateline'];
        if(!empty($param['q'])) {	//根据用户名/课件名称搜索
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = '(u.username like \'%'.$q.'%\' OR u.realname like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\')'; 
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['order']))
            $sql .= ' ORDER BY '.$param['order'];
        else
            $sql .= ' ORDER BY n.noteid desc ';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据平台编号和班级编号获取平台内学生的笔记记录数
     * @param type $param
     * @return boolean
     */
    public function getnotelistcountbyclassid($param) {
        $count = 0;
        if(empty($param['crid']))
            return $count;
        $sql = 'SELECT count(*) count FROM ebh_notes n '
            .'join ebh_users u on n.uid=u.uid '
            .'join ebh_coursewares c on n.cwid = c.cwid '
			.'join ebh_classstudents cs on (cs.uid=n.uid) ';
        $wherearr = array();
        $wherearr[] = 'n.crid='.$param['crid'];
		if(!empty($param['uid']))	//过滤会员笔记
			$wherearr[] = 'n.uid ='.$param['uid'];
		if(!empty($param['classid']))	//所在班级的会员笔记
			$wherearr[] = 'cs.classid in ('.$param['classid'].')';
		if(!empty($param['tid']))	//过滤课件制作教师的编号
			$wherearr[] = 'c.uid = '.$param['tid'];
        if(!empty($param['stardateline']))	//过滤笔记开始时间
            $wherearr[] = 'n.dateline>='.$param['stardateline'];
        if(!empty($param['enddateline']))	//过滤笔记结束时间
            $wherearr[] = 'n.dateline<'.$param['enddateline'];
        if(!empty($param['q'])) {	//根据用户名/课件名称搜索
            $q = $this->db->escape_str($param['q']);
            $wherearr[] = '(u.username like \'%'.$q.'%\' OR u.realname like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\' OR c.title like \'%'.$q.'%\')'; 
        }
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
            $count = $row['count'];
        return $count;
    }
	/**
     * 根据用户编号获取平台内该学生的笔记
     * @param type $param
     * @return boolean
     */
    public function getnotelistbyuid($param) {
        if(empty($param['uid']))
            return FALSE;
        if (empty($param['page']) || $param['page'] < 1)
            $page = 1;
        else
            $page = $param['page'];
        $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
        $start = ($page - 1) * $pagesize;
        $sql = 'SELECT n.noteid,n.uid,n.cwid,n.dateline,n.fdateline,n.ftext,c.title,c.cwsource,c.cwurl,c.ism3u8 FROM ebh_notes n '
            .'join ebh_coursewares c on n.cwid = c.cwid  ';
        $wherearr = array();
        $wherearr[] = 'n.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'n.crid='.$param['crid'];
		if(!empty($param['status']))
			$wherearr[] = 'c.status='.$param['status'];
        if(!empty($param['stardateline']))	//过滤笔记开始时间
            $wherearr[] = 'n.dateline>='.$param['stardateline'];
        if(!empty($param['enddateline']))	//过滤笔记结束时间
            $wherearr[] = 'n.dateline<'.$param['enddateline'];
		if(!empty($param['q']))	//按课件名称搜索
			$wherearr[] = 'c.title like \'%'.$this->db->escape_str($param['q']).'%\'';
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        if(!empty($param['order']))
            $sql .= ' ORDER BY '.$param['order'];
        else
            $sql .= ' ORDER BY n.noteid desc ';
        $sql .= ' limit ' . $start . ',' . $pagesize;
        return $this->db->query($sql)->list_array();
    }
    /**
     * 根据用户编号获取平台内该学生的笔记记录数
     * @param type $param
     * @return boolean
     */
    public function getnotelistcountbyuid($param) {
        $count = 0;
        if(empty($param['crid']))
            return $count;
        $sql = 'SELECT count(*) count FROM ebh_notes n '
            .'join ebh_coursewares c on n.cwid = c.cwid  ';
        $wherearr = array();
        $wherearr[] = 'n.uid='.$param['uid'];
		if(!empty($param['crid']))
			$wherearr[] = 'n.crid='.$param['crid'];
        if(!empty($param['stardateline']))	//过滤笔记开始时间
            $wherearr[] = 'n.dateline>='.$param['stardateline'];
        if(!empty($param['enddateline']))	//过滤笔记结束时间
            $wherearr[] = 'n.dateline<'.$param['enddateline'];
		if(!empty($param['q']))	//按课件名称搜索
			$wherearr[] = 'c.title like \'%'.$this->db->escape_str($param['q']).'%\'';
        $sql .= ' WHERE '.implode(' AND ', $wherearr);
        $row = $this->db->query($sql)->row_array();
        if(!empty($row))
            $count = $row['count'];
        return $count;
    }
	
	/*
	获取flash笔记内容
	*/
	public function getFlashNoteBycwid($param){
		if(empty($param['cwid']) || empty($param['uid']))
			return false;
		$sql = 'select fimage,ftext,fdateline from ebh_notes';
		$wherearr = array();
		$wherearr[]= 'cwid='.$param['cwid'];
		$wherearr[]= 'uid='.$param['uid'];
		$sql.= ' where '.implode(' AND ',$wherearr);
		// log_message($sql);
		return $this->db->query($sql)->row_array();
		
	}
	/*
	添加flash笔记
	*/
	public function addFlashNote($param){
		if(empty($param['cwid']) || empty($param['uid']))
			return FALSE;
		
		$setarr['uid'] = $param['uid'];
		$setarr['cwid'] = $param['cwid'];
		if(isset($param['crid']))
			$setarr['crid'] = $param['crid'];
		if(isset($param['ftext']))
			$setarr['ftext'] = $param['ftext'];
		if(isset($param['fimage']))
			$setarr['fimage'] = $param['fimage'];
		$setarr['fdateline'] = SYSTIME;
		return $this->db->insert('ebh_notes',$setarr);
	}
	/*
	修改flash笔记
	*/
	public function editFlashNote($param){
		if(empty($param['cwid']) || empty($param['uid']))
			return FALSE;
		
		$wherearr['uid'] = $param['uid'];
		$wherearr['cwid'] = $param['cwid'];
		if(isset($param['ftext']))
			$setarr['ftext'] = $param['ftext'];
		if(isset($param['fimage']))
			$setarr['fimage'] = $param['fimage'];
		$setarr['fdateline'] = SYSTIME;
		return $this->db->update('ebh_notes',$setarr,$wherearr);
	}
}
