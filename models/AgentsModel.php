<?php
	/**
	 *代理商的model类,针对ebh_agents表
	 *@author zkq
	 */
	class AgentsModel extends CModel{
		/**
		 * 根据参数获取代理商列表
		 * POST传值
		 * @param array $param
		 * @return array
		 * 
		 */
		public function getList($param = array()){
			$sql = 'select a.*,u.username,u.status from ebh_agents a join ebh_users u on a.agentid = u.uid ';
			$whereArr = array();
			if(!empty($param['agentid'])){
				$whereArr[] = ' a.agentid = '.intval($param['agentid']);
			}
			if(!empty($param['searchkey'])){
				$whereArr[] = 'u.username like \'%'.$param['searchkey'].'%\' or a.mobile like \'%'.$param['searchkey'].'%\' ';
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			if(empty($param['order'])){
				$sql.=' order by a.agentid desc ';
			}else{
				$sql.=' order by '.$param['order'];
			}
			if(empty($param['limit'])){
				$sql.=' limit 10 ';
			}else{
				$sql.=' limit '.$param['limit'];
			}
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 根据参数获取符合条件的代理商的数据记录总数
		 * POST传值
		 * @param array $param
		 * @return int
		 * 
		 */
		public function getListCount(){
			$sql = 'select count(*) count from ebh_agents a join ebh_users u on a.agentid = u.uid ';
			$whereArr = array();
			if(!empty($param['agentid'])){
				$whereArr[] = ' a.agentid = '.intval($param['agentid']);
			}
			if(!empty($param['searchkey'])){
				$whereArr[] = 'u.username like \'%'.$param['searchkey'].'%\' or a.mobile like \'%'.$param['searchkey'].'%\' ';
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			$res = $this->db->query($sql)->row_array();
			return $res['count'];
		}
		/**
		 * 根据参数获取单条代理商信息,本方法调用该类中的getList方法
		 * @param array $param
		 * @return array
		 */
		public function getOneAgent($param = array()){
			$param['limit'] = 1;
			$oneArr = $this->getList($param);
			return $oneArr[0];
		}
		/**
		 * 新增一个代理商 
		 * @param array $param
		 * @return bool
		 * 参数请在控制器里面弄好,本方法只负责插入数据
		 */
		public function _insert($param=array()){
			if(empty($param)){
				return false;
			}
			if($this->db->insert('ebh_agents',$param)===false){
				return false;
			}else{
				return true;
			}
			
		}
		/**
		 * 修改一个代理商信息 
		 * @param array $param
		 * @param array $where
		 * @return bool
		 * 参数请在控制器里面弄好,本方法只负责修改符合$where条件的数据库中的记录
		 */
		public function _update($param=array(),$where=array()){
			if(empty($where)){
				return false;
			}
			if($this->db->update('ebh_agents',$param,$where)>0){
				return true;
			}else{
				return false;
			}
		}
		/**
		 * 修改一个代理商状态 
		 * @param array $param
		 * @param array $where
		 * @return bool
		 * 参数请在控制器里面弄好,本方法只负责修改符合$where条件的数据库中的记录
		 */		
		public function changeinfo($param=array(),$where=array()){
			if(empty($where)){
				return false;
			}
			if($this->db->update('ebh_users',$param,$where)>0){
				return true;
			}else{
				return false;
			}
		}
		/**
		 * 删除一个代理商信息 
		 * @param array $param
		 * @param array $where
		 * @return bool
		 * 参数请在控制器里面弄好,本方法只负责删除符合$where条件的数据库中的记录
		 */
		public function _delete($where=array()){
			
			if(empty($where)){
				return false;
			}
			if($this->db->delete('ebh_agents',$where)>0){
				return true;
			}else{
				return false;
			}			
		}
		/**
		 * 根据agentid获取一个代理商信息 
		 * @param int $uid
		 * @return String 
		 * 参数请在控制器里面弄好,本方法只负责查询
		 */
		public function getAgentName($uid = 0){
			if($uid==0){
				return '顶级代理';
			}else{
				$sql = 'select u.username as username from ebh_users u where uid ='.intval($uid).' limit 1';
				$res = $this->db->query($sql)->row_array();
				return $res['username'];
			}
		}
		/**
		 *执行sql语句,返回一条记录
		 *@param String $sq;
		 *@return array
		 */
		public function _queryone($sql = null){
			if(is_null($sql)){
				return false;
			}
			return $this->db->query($sql)->row_array();
		}

		/**
		 *返回数据库资源
		 */
		public function _db(){
			return $this->db;
		}
		/**
		 *获取所有的代理商简单信息列表,供$this->getAgentsSelect()生成<select>控件使用
		 *
		 */
		public function getSimpleList(){
			$sql = 'select a.agentid,u.username from ebh_agents a join ebh_users u on a.agentid = u.uid order by a.agentid desc';
			return $this->db->query($sql)->list_array();
		}
		/**
		 *返回agents列表,格式为<select><option agentid=444>xxx</option></select>
		 *
		 */
		public function getAgentsSelect($name='agentid',$id='agentid',$select = 0,$isDisable=false){
			$aList = $this->getSimpleList();
			if($isDisable===false){
				$s = '<select name='.$name.' id='.$id.'>';
			}else{
				$s = '<select name='.$name.' id='.$id.' disabled=disabled >';
			}
			$s.='<option value="0">请选择</option>';
			foreach ($aList as $av) {
				if($select==$av['agentid']){
					$s.='<option value="'.$av['agentid'].'" selected=selected >'.$av['username'].'</option>';
				}else{
					$s.='<option value="'.$av['agentid'].'">'.$av['username'].'</option>';
				}
			}
			$s.='</select>';
			return $s;
		}
		/**
		 *判断代理商是否存在(一般对页面提交过来的数据进行验证,防止用户在页面上恶意修改agentid)
		 *@param int agentid
		 *@return bool
		 * 注:存在返回true,失败返回false 
		 */
		public function ifAgentExits($agentid=0){
			$sql = 'select count(*) count from ebh_agents where agentid='.intval($agentid).' limit 1';
			$res = $this->db->query($sql)->row_array();
			if($res['count']==1){
				return true;
			}else{
				return false;
			}
		}
	}	
?>