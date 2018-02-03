<?php
	/**
	 * 主贴类,针对ebh_posts表
	 */
	class PostsModel extends CModel{
		/**
		 *根据参数条件获取主贴列表
		 *@param array $param
		 *@return array
		 */
		public function getList($param = array()){
 			$sql = 'select p.*,c.crname from ebh_posts p left join ebh_classrooms c on p.cid = c.crid ';
 			$whereArr = array();
 			if(!empty($param['searchkey'])){
 				$whereArr[]=' p.subject like \'%'.$param['searchkey'].'%\' or p.content like \'%'.$param['searchkey'].'%\' '.' or c.crname like \'%'.$param['searchkey'].'%\' ';
 			}
 			if(strlen($param['status'])==1){
 				$whereArr[]=' p.status = '.intval($param['status']);
 			}
 			if(!empty($param['begintime'])){
 				$whereArr[]=' p.dateline > '.strtotime($param['begintime']);
 			}
 			if(!empty($param['endtime'])){
 				$whereArr[]=' p.dateline < '.strtotime($param['endtime']);
 			}
 			if(!empty($whereArr)){
 				$sql.=' WHERE '.implode(' AND ',$whereArr);
 			}
 			if(!empty($param['order'])){
 				$sql.=' order by '.$param['order'];
 			}else{
 				$sql.=' order by p.lastline desc,p.postsid desc';
 			}
 			if(!empty($param['limit'])){
 			 	$sql.= ' limit '.$param['limit'];	
 			}
 			return $this->db->query($sql)->list_array();
		}
		/**
		 *根据参数条件获取主贴条数
		 *@param array $param
		 *@return int
		 */
		public function getListCount($param = array()){
			$sql = 'select count(*) count from ebh_posts p left join ebh_classrooms c on p.cid = c.crid ';
			$whereArr = array();
 			if(!empty($param['searchkey'])){
 				$whereArr[]=' p.subject like \'%'.$param['searchkey'].'%\' or p.content like \'%'.$param['searchkey'].'%\' '.' or c.crname like \'%'.$param['searchkey'].'%\' ';
 			}
 			if(strlen($param['status'])==1){
 				$whereArr[]=' p.status = '.intval($param['status']);
 			}
 			if(!empty($param['begintime'])){
 				$whereArr[]=' p.dateline > '.strtotime($param['begintime']);
 			}
 			if(!empty($param['endtime'])){
 				$whereArr[]=' p.dateline < '.strtotime($param['endtime']);
 			}
 			if(!empty($whereArr)){
 				$sql.=' WHERE '.implode(' AND ',$whereArr);
 			}
			$res = $this->db->query($sql)->row_array();
			return $res['count'];
		}
		/**
		 *编辑单条主贴内容
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
			if($this->db->update('ebh_posts',$param,$where)!=-1){
				return true;
			}else{
				return false;
			}
		}
		/**
		 *新增单条主贴内容
		 *@param array $param
		 *@return bool
		 *$param为键值对,键对表的字段,值代表该字段将的值
		 */
		public function _insert($param=array()){
			if(empty($param)){
				return false;
			}
			if($this->db->insert('ebh_posts',$param)!=-1){
				return true;
			}else{
				return false;
			}
		}
		/**
		 *删除单条主贴记录
		 *@param array $param
		 *@return bool
		 *$where为键值对,键表示表的字段,值表示该字段的值
		 */
		public function _delete($param = array()){
			if(empty($param)){
				return false;
			}
			$res = $this->db->delete('ebh_posts',$param);
			if($res==-1){
				return fasle;
			}else{
				return true;
			}
		}
		/**
		 *根据传入的postsid获取单条主贴记录
		 *@param int $post
		 *@return array
		 */
		public function getOnePosts($postsid=0){
			$postsid = intval($postsid);
			if($postsid==0){
				return array();
			}else{
				$sql = 'select p.*,c.crname,u.username from ebh_posts p left join ebh_classrooms c on p.cid = c.crid left join ebh_users u on c.uid = u.uid where p.postsid = '.$postsid.' limit 1 ';
				return $this->db->query($sql)->row_array();
			}
		}
	}
?>