<?php
	/**
	 * 主贴评论类,针对ebh_revert表
	 */
	class RevertModel extends CModel{
		/**
		 *根据参数条件获取主贴评论评论列表
		 *@param array $param
		 *@return array
		 */
		public function getList($param = array()){
 			$sql = 'select p.subject,u.username,r.*,c.crname from ebh_revert r left join ebh_classrooms c on r.cid = c.crid left join ebh_posts p on r.postsid = p.postsid left join ebh_users u on r.uid = u.uid ';
 			$whereArr = array();
 			if(!empty($param['searchkey'])){
 				$whereArr[]=' r.rcontent like \'%'.$param['searchkey'].'%\' '.' or  p.subject like \'%'.$param['searchkey'].'%\' '.' or  u.username like \'%'.$param['searchkey'].'%\' '.' or  c.crname like \'%'.$param['searchkey'].'%\' ';
 			}
 			if(strlen($param['status'])==1){
 				$whereArr[]=' r.status = '.intval($param['status']);
 			}
 			if(!empty($param['begintime'])){
 				$whereArr[]=' r.rtime > '.strtotime($param['begintime']);
 			}
 			if(!empty($param['endtime'])){
 				$whereArr[]=' r.rtime < '.strtotime($param['endtime']);
 			}
 			if(!empty($whereArr)){
 				$sql.=' WHERE '.implode(' AND ',$whereArr);
 			}
 			if(!empty($param['order'])){
 				$sql.=' order by '.$param['order'];
 			}
 			if(!empty($param['limit'])){
 			 	$sql.= ' limit '.$param['limit'];	
 			}
 			return $this->db->query($sql)->list_array();
		}
		/**
		 *根据参数条件获取主贴评论条数
		 *@param array $param
		 *@return int
		 */
		public function getListCount($param = array()){
			$sql = 'select count(*) count from ebh_revert r left join ebh_classrooms c on r.cid = c.crid left join ebh_posts p on r.postsid = p.postsid left join ebh_users u on r.uid = u.uid ';
			$whereArr = array();
 			if(!empty($param['searchkey'])){
 				$whereArr[]=' r.rcontent like \'%'.$param['searchkey'].'%\' '.' or  p.subject like \'%'.$param['searchkey'].'%\' '.' or  u.username like \'%'.$param['searchkey'].'%\' '.' or  c.crname like \'%'.$param['searchkey'].'%\' ';
 			}
 			if(strlen($param['status'])==1){
 				$whereArr[]=' r.status = '.intval($param['status']);
 			}
 			if(!empty($param['begintime'])){
 				$whereArr[]=' r.rtime > '.strtotime($param['begintime']);
 			}
 			if(!empty($param['endtime'])){
 				$whereArr[]=' r.rtime < '.strtotime($param['endtime']);
 			}
 			if(!empty($whereArr)){
 				$sql.=' WHERE '.implode(' AND ',$whereArr);
 			}
			$res = $this->db->query($sql)->row_array();
			return $res['count'];
		}
		/**
		 *编辑单条主贴评论内容
		 *@param array $param
		 *@param array $where
		 *@return bool
		 *$param为键值对,键对表的字段,值代表该字段将要被修改成的值
		 *$where为键值对,键表示表的字段,值表示该字段的值
		 */
		public function _update($param=array(),$where=array()){
			if(empty($where)){
				return false;
			}
			if($this->db->update('ebh_revert',$param,$where)!=-1){
				return true;
			}else{
				return false;
			}
		}

		/**
		 *删除单条主贴评论记录
		 *@param array $param
		 *@return bool
		 *$where为键值对,键表示表的字段,值表示该字段的值
		 */
		public function _delete($param = array()){
			if(empty($param)){
				return false;
			}
			$res = $this->db->delete('ebh_revert',$param);
			if($res==-1){
				return fasle;
			}else{
				return true;
			}
		}
		/**
		 *根据传入的revertid获取单条主贴评论记录
		 *@param int $rid
		 *@return array
		 */
		public function getOnerevert($rid=0){
			$rid = intval($rid);
			if($rid==0){
				return array();
			}else{
				$sql = 'select r.*,p.subject,p.content,c.crname,u.username as username, uu.username as teacher from ebh_revert r left join ebh_classrooms c on r.cid = c.crid left join ebh_users u on c.uid = u.uid left join ebh_users uu on c.uid = uu.uid left join ebh_posts p on p.postsid = r.postsid where r.rid = '.$rid.' limit 1 ';
				return $this->db->query($sql)->row_array();
			}
		}
	}
?>