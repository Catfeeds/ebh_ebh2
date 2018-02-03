<?php

/**
 * 体质健康评语
 */
class HealthcommentModel extends CModel{
	/**
	 * [addcomment 添加评论]
	 * @param  [type] $param [description]
	 * @return [type]        [description]
	 */
	public function addcomment($param){
		if(empty($param)){
			return false;
		}
		$setarr = array();
		if(isset($param['comment'])){
			$setarr['comment'] = $param['comment'];
		}
		if(!empty($param['teacherid'])){
			$setarr['teacherid'] = $param['teacherid'];
		}
		if(!empty($param['studentid'])){
			$setarr['studentid'] = $param['studentid'];
		}
		if(!empty($param['type'])){
			$setarr['type'] = $param['type'];
		}
		if(!empty($param['sid'])){
			$setarr['sid'] = $param['sid'];
		}
		if(!empty($param['filename'])){
			$setarr['filename'] = $param['filename'];
		}
		if(!empty($param['classid'])){
			$setarr['classid'] = $param['classid'];
		}
		if(!empty($param['crid'])){
			$setarr['crid'] = $param['crid'];
		}
		if(!empty($param['dateline'])){
			$setarr['dateline'] = $param['dateline'];
		}else{
			$setarr['dateline'] = SYSTIME;
		}
		return $this->db->insert('ebh_health_comment',$setarr);
	}
	/**
	 * 通过学生studentid获取评论列表
	 */
	public function getcommentlist($studentid,$crid,$page){
		if(empty($studentid) || empty($page) || empty($crid)){
			return false;
		}
		$sql = 'select h.hcid,h.type,h.comment,h.sid,h.filename,h.teacherid,h.dateline,u.username,u.realname from `ebh_health_comment` h left join `ebh_users` u on (h.teacherid = u.uid) where h.studentid = '.intval($studentid).' and h.crid ='.intval($crid);
		if(!empty($page)){
			$sql.= ' limit '.(($page-1)*20).',20';
		}else{
			$sql.= ' limit 0,20';
		}
		return $this->db->query($sql)->list_array();
	}
	/**
	 * 读取学生的评价总数
	 */
	public function getcommentcount($studentid,$crid){
		if(empty($studentid) || empty($crid)){
			return false;
		}
		$sql = 'select count(*) as count from `ebh_health_comment` where studentid = '.intval($studentid).' and crid = '.intval($crid);
		return $this->db->query($sql)->row_array();
	}
	/**
	 * 获取班级学生的评价数
	 */
	public function getStudentCommentByclassid($classid,$crid){
		if(empty($classid) || empty($crid)){
			return false;
		}
		$sql = 'select studentid as uid,count(*) as count from `ebh_health_comment` where classid ='.intval($classid).' and crid = '.intval($crid).' group by uid';
		return $this->db->query($sql)->list_array();
	}
}