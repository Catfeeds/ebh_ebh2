<?php
/**
 * 群共享文件Model类
 */
class ImfileModel extends CModel{
	/**
	*根据群编号获取共享文件列表
	*/
	function getListByQunid($param){
		global $_SGLOBAL, $_SC, $_SGET;
		$sqlarr = $wherearr = array();
		if(empty($param['qunid']) )	//群id不能为空
			return FALSE;
		$sql = 'SELECT f.fileid,f.uid,f.source,f.name,f.suffix,f.size,f.downnum,f.dateline,u.username,u.realname FROM ebh_imfiles f '.
				'JOIN ebh_users u on (u.uid=f.uid) ';
		$wherearr = array();
		$wherearr[] = 'f.qunid='.$param['qunid'];
		$sql .= ' WHERE '.implode(' AND ',$wherearr);
		if(!empty($param['order']))
			$sql .= ' ORDER BY '.$param['order'];
		else
			$sql .= ' ORDER BY f.fileid desc';
		$flist = $this->db->query($sql)->list_array();
		$filelist = array();
		$row = 0;
		foreach($flist as $file) {
			$ymonth = date('Y-m',$file['dateline']);
			if(!isset($filelist[$ymonth])) {
				$filelist[$ymonth] = array('ymonthname'=> date('Y年m月',$file['dateline']));
			}
			$filelist[$ymonth]['list'][] = $file;
		}
		return $filelist;
	}
	/**
	*根据文件编号获取文件信息
	*/
	public function getfilebyid($fileid) {
		$sql = 'select f.uid,f.qunid,f.source,f.name,f.url from ebh_imfiles f where f.fileid='.$fileid;
		return $this->db->query($sql)->row_array();
	}
	/**
	*添加文件下载次数
	*/
	public function adddownnum($fileid,$num = 1) {
		$wherearr = array('fileid'=>$fileid);
		$setarr = array('downnum'=>'downnum+'.$num);
		return $this->db->update('ebh_imfiles',array(),$wherearr,$setarr);
	}
	/**
	*删除文件
	*/
	public function delete($fileid) {
		$wherearr = array('fileid'=>$fileid);
		return $this->db->delete('ebh_imfiles',$wherearr);
	}
	/**
	*判断用户是否有该群权限
	*/
	public function checkpermission($uid,$qunid) {
		$sql = "select count(*) count from ebh_imqunmembers where qunid=$qunid and uid=$uid";
		$countrow = $this->db->query($sql)->row_array();
		if(!empty($countrow) && $countrow['count']>0)
			return TRUE;
		return FALSE;
	}
}
