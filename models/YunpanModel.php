<?php
class YunpanModel extends CModel {
	function __construct(){
		$this->db = Ebh::app()->getOtherDb("pandb");
	}

	/**
	 * 获取文件列表
	 */
	public function getFileList($param){
		$sql = 'SELECT f.fileid,f.isdir,f.title,f.path,f.dateline,f.size,f.suffix,f.uid,f.crid,f.isshare,ck.admin_status,s.ispreview,ck.teach_status,ck.teach_remark,ck.del FROM pan_files f LEFT JOIN pan_sources s ON f.sid=s.sid LEFT JOIN pan_billchecks ck ON ck.toid = f.fileid AND ck.type=11';
		$wherearr[] = 'f.isdir=0';
		if (isset($param['q'])&&$param['q']!=''){
            $qstr = $this->db->escape_str($param['q']);
            $wherearr[] = ' (f.title like \'%' . $qstr. '%\' )';
        }
        if(!empty($param['crid'])){
        	$wherearr[]='f.crid='.intval($param['crid']);
        }
        //管理员
        if($param['role']=='admin'){
            if($param['admin_status']>0){
                $wherearr[] = 'ck.admin_status ='.$param['admin_status'];
            }
            if($param['cat']==0){
                $wherearr[] = '(ck.admin_status is null or ck.admin_status = 0)';
            }
            if($param['cat']==1){
                $wherearr[] = 'ck.admin_status>0 and ck.del=0';
            }
            if($param['cat']==2){
                $wherearr[] = 'ck.del=1';
            }
        //教师    
        }elseif($param['role']=='teach'){
            if(!empty($param['teach_status'])){
                $wherearr[] = 'ck.teach_status ='.$param['teach_status'];
            }
            if($param['cat']==0){
                $wherearr[] = '(ck.teach_status is null or ck.teach_status=0)';
            }
            if($param['cat']==1){
                $wherearr[] = 'ck.teach_status>0 and ck.del=0';
            }
            if($param['cat']==2){
                $wherearr[] = 'ck.del=1';
            }
        }
		if (!empty($param['startdate']))
			$wherearr[]= 'f.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'f.dateline<='.$param['enddate'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);

		$sql.= ' order by fileid desc';
		if(!empty($param['limit'])) {
			$sql .= ' limit '.$param['limit'];
		} else {
			if (empty($param['page']) || $param['page'] < 1)
				$page = 1;
			else
				$page = $param['page'];
			$pagesize = empty($param['pagesize']) ? 300 : $param['pagesize'];
			$start = ($page - 1) * $pagesize;
			$sql .= ' limit ' . $start . ',' . $pagesize;
        }
		return $this->db->query($sql)->list_array();
	}

	/**
	 * 获取文件总数
	 */
	public function getFileCount($param){
		$count = 0;
		$sql = 'SELECT count(*) count FROM pan_files f LEFT JOIN pan_billchecks ck ON ck.toid = f.fileid AND ck.type=11';
		$wherearr[] = 'f.isdir=0';
		if (isset($param['q'])&&$param['q']!=''){
            $qstr = $this->db->escape_str($param['q']);
            $wherearr[] = ' (f.title like \'%' . $qstr. '%\' )';
        }
        if(!empty($param['crid'])){
        	$wherearr[]='f.crid='.intval($param['crid']);
        }
        //管理员
        if($param['role']=='admin'){
            if($param['admin_status']>0){
                $wherearr[] = 'ck.admin_status ='.$param['admin_status'];
            }
            if($param['cat']==0){
                $wherearr[] = '(ck.admin_status is null or ck.admin_status = 0)';
            }
            if($param['cat']==1){
                $wherearr[] = 'ck.admin_status>0 and ck.del=0';
            }
            if($param['cat']==2){
                $wherearr[] = 'ck.del=1';
            }
        //教师    
        }elseif($param['role']=='teach'){
            if(!empty($param['teach_status'])){
                $wherearr[] = 'ck.teach_status ='.$param['teach_status'];
            }
            if($param['cat']==0){
                $wherearr[] = '(ck.teach_status is null or ck.teach_status=0)';
            }
            if($param['cat']==1){
                $wherearr[] = 'ck.teach_status>0 and ck.del=0';
            }
            if($param['cat']==2){
                $wherearr[] = 'ck.del=1';
            }
        }
		if (!empty($param['startdate']))
			$wherearr[]= 'f.dateline>='.$param['startdate'];
		if (!empty($param['enddate']))
			$wherearr[]= 'f.dateline<='.$param['enddate'];
		if(!empty($wherearr))
			$sql.= ' where '.implode(' AND ',$wherearr);

		$row = $this->db->query($sql)->row_array();
		if(!empty($row))
			$count = $row['count'];
        return $count;
	}

	/**
	 * 获取文件详情
	 * @param  array $param [description]
	 * @return array        [description]
	 */
	public function getOneFile($param){
		$wherearr = array();
		$sql = 'SELECT fileid,sid,isdir,title,dateline,size,suffix,uid,crid,upid,path,isshare FROM pan_files';
		if(!empty($param['fileid'])){
			$wherearr[] = 'fileid=' . intval($param['fileid']);
		}
		if(!empty($param['path'])){
			$wherearr[] = 'path=\'' . $this->db->escape_str($param['path']) . '\'';
		}
		if(!empty($param['uid'])){
			$wherearr[] = 'uid='. intval($param['uid']);
		}
		if(!empty($param['crid'])){
			$wherearr[] = 'crid=' . intval($param['crid']);
		}
		if(!empty($wherearr))
			$sql .= ' WHERE '.implode(' AND ',$wherearr);
		$row = $this->db->query($sql)->row_array();
		return $row;
	}

	/**
	 * 获取文件审核详情
	 * @param  interger $fileid 文件编号
	 * @return mix         文件审核详情
	 */
	public function getFileById($fileid){
		$wherearr = array();
		$sql = 'SELECT f.fileid,f.title,f.dateline,f.size,f.suffix,f.uid,f.crid,ck.admin_status,ck.admin_remark,ck.teach_status,ck.teach_remark,ck.del,ck.admin_dateline,ck.teach_dateline,ck.delline,ck.admin_ip,ck.teach_ip FROM pan_files f LEFT JOIN pan_billchecks ck ON ck.toid=f.fileid AND ck.type=11 WHERE fileid='.intval($fileid);
		$row = $this->db->query($sql)->row_array();
		return $row;
	}

	/**
	 * 审核处理
	 *
	 */
	public function check($param){
		$toid = $param['toid'];
		$role = $param['role'];
		$type = $param['type'];
		if(!$toid){return false;}
		
		//检查是否持存在
		$sql = "select count(*) as count from pan_billchecks where toid = {$toid} and type = {$type}";
		$row = $this->db->query($sql)->row_array();

		if($row['count']>0){
			//更新
			if($role=='admin'){//管理员审核
				$setArr['admin_uid'] = $param['admin_uid'];
				$setArr['admin_status'] = $param['admin_status'];
				$setArr['admin_remark'] = htmlentities($param['admin_remark']);
				$setArr['admin_ip'] = $param['admin_ip'];
				$setArr['admin_dateline'] = time();
			}elseif($role=='teach'){//教师审核
				$setArr['teach_uid'] = $param['teach_uid'];
				$setArr['teach_status'] = $param['teach_status'];
				$setArr['teach_remark'] = $param['teach_remark'];
				$setArr['teach_ip'] = $param['teach_ip'];
				$setArr['teach_dateline'] = time();
			}
			
			$this->db->update("pan_billchecks",$setArr,array('toid'=>$toid,'type'=>$type));
			
			//网校对应修改课件等状态
			
		}else{
			//添加
			if($role=='admin'){//管理员审核
				$data = array(
					'toid'=>$toid,
					'type'=>$type,
					'admin_uid'=>$param['admin_uid'],
					'admin_status'=>$param['admin_status'],
					'admin_remark'=>htmlentities($param['admin_remark']),
					'admin_ip'=>$param['admin_ip'],
					'admin_dateline'=>time()			
				);
			}elseif($role=='teach'){//教师审核
				$data = array(
					'toid'=>$toid,
					'type'=>$type,
					'teach_uid'=>$param['teach_uid'],
					'teach_status'=>$param['teach_status'],
					'admin_remark'=>'',
					'teach_remark'=>$param['teach_remark'],
					'teach_ip'=>$param['teach_ip'],
					'admin_ip'=>'',
					'teach_dateline'=>time()			
				);
			}
			
			$this->db->insert("pan_billchecks",$data);				
		}
		
		//更新pan_files表
		if((!empty($param['teach_status']) && $param['teach_status']==1) || (!empty($param['admin_status']) && $param['admin_status']==1)){
			if ($type == 11) {
				$row = $this->db->query('SELECT * FROM pan_files WHERE fileid='.$toid)->row_array();
				$this->db->update('pan_files',array('status'=>0),array('fileid'=>$toid));
				//取消不通过时，增加网盘已用空间
				if (!empty($row) && $row['status'] > 0)
					$this->db->update('pan_userinfos', array(), array('uid'=>$row['uid'], 'crid'=>$row['crid']),array('filesize'=>'filesize+'.$row['size']));
			}
		}
		elseif((!empty($param['teach_status']) && $param['teach_status']==2) || (!empty($param['admin_status']) && $param['admin_status']==2)){
			if ($type == 11) {
				$row = $this->db->query('SELECT * FROM pan_files WHERE fileid='.$toid)->row_array();
				$this->db->update('pan_files',array('status'=>2),array('fileid'=>$toid));
				//第一次审核不通过时，减少网盘已用空间
				if (!empty($row) && $row['status'] == 0)
					$this->db->update('pan_userinfos', array(), array('uid'=>$row['uid'], 'crid'=>$row['crid']),array('filesize'=>'filesize-'.$row['size']));
			}
		}
		
		
		return $this->db->affected_rows();
		
	}
	
}