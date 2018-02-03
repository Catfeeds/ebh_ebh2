<?php
	/**
	 *cardbatch模型,对应ebh_cardbatch表
	 *@author zkq
	 */
	class CardbatchModel extends CModel{
		/**
		 *根据条件获取批次列表
		 *@author zkq
		 *@param array $param
		 *@return array 
		 */
		public function getList($param = array()){
			$sql = 'select cb.bid,cb.bname,cb.dateline,cb.lastmodified,cb.price,cb.status,cb.agentid,u1.username as uidname,u2.username as lastmodifiedname,u3.username as agentidname from ebh_cardbatch cb left join ebh_users u1 on cb.uid = u1.uid left join ebh_users u2 on cb.lastmodifieduid = u2.uid left join ebh_users u3 on cb.agentid = u3.uid ';
			$whereArr = array();
			if(!empty($param['bid'])){
				$whereArr[] = 'cb.bid ='.intval($param['bid']);
			}
			if(!empty($param['searchkey'])){
				$whereArr[] = 'cb.bname like \'%'.$param['searchkey'].'%\'';
			}
			if(!empty($param['price'])){
				$whereArr[] = 'cb.price ='.$param['price'];
			}
			if(strlen($param['status'])>=1){
				$whereArr[] = 'cb.status ='.intval($param['status']);
			}
			if(!empty($param['agentid'])){
				$whereArr[] = 'cb.agentid ='.$param['agentid'];
			}
			if(!empty($param['begindateline'])){
				$whereArr[] = 'cb.dateline >'.strtotime($param['begindateline']);
			}
			if(!empty($param['enddateline'])){
				$whereArr[] = 'cb.dateline <'.strtotime($param['enddateline']);
			}
			if(!empty($param['beginlastmodified'])){
				$whereArr[] = 'cb.lastmodified >'.strtotime($param['beginlastmodified']);
			}
			if(!empty($param['endlastmodified'])){
				$whereArr[] = 'cb.lastmodified <'.strtotime($param['endlastmodified']);
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			if(empty($param['limit'])){
				$sql.=' limit 20 ';
			}else{
				$sql.=' limit '.$param['limit'];
			}
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 根据条件获取符合条件的批次的数量
		 * @author zkq
		 * @param array $param
		 * @return int 
		 */
		public function getListCount($param = array()){
			$sql='select count(*) count from ebh_cardbatch cb';
			$whereArr = array();
			if(!empty($param['bid'])){
				$whereArr[] = 'cb.bid ='.intval($param['bid']);
			}
			if(!empty($param['searchkey'])){
				$whereArr[] = 'cb.bname like \'%'.$param['searchkey'].'%\'';
			}
			if(!empty($param['price'])){
				$whereArr[] = 'cb.price ='.$param['price'];
			}
			if(strlen($param['status'])>=1){
				$whereArr[] = 'cb.status ='.intval($param['status']);
			}
			if(!empty($param['agentid'])){
				$whereArr[] = 'cb.agentid ='.$param['agentid'];
			}
			if(!empty($param['begindateline'])){
				$whereArr[] = 'cb.dateline >'.strtotime($param['begindateline']);
			}
			if(!empty($param['enddateline'])){
				$whereArr[] = 'cb.dateline <'.strtotime($param['enddateline']);
			}
			if(!empty($param['beginlastmodified'])){
				$whereArr[] = 'cb.lastmodified >'.strtotime($param['beginlastmodified']);
			}
			if(!empty($param['endlastmodified'])){
				$whereArr[] = 'cb.lastmodified <'.strtotime($param['endlastmodified']);
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			$res = $this->db->query($sql)->row_array();
			return $res['count'];
		}
		/**
		 *自动生成批次号
		 *@author zkq
		 *@param null
		 *@return String
		 */
		public function createbname(){
			do{
				$bname = date('Ymd',time()).strtoupper(random(3));
				
			}while($this->ifExits(array('bname'=>$bname))===false);
			return $bname;
		}
		/**
		 *检测批次号是否存在
		 *@author zkq
		 *@param array $param
		 *@return bool
		 *存在返回true;不存在返回false
		 */
		public function ifExits($param){
			$whereArr = array();
			$sql = 'select count(*) count from ebh_cardbatch ';
			if(!empty($param['bid'])){
				$whereArr[] = 'bid='.intval($param['bid']);
			}
			if(!empty($param['bname'])){
				$whereArr[] = 'bname=\''.$param['bname'].'\'';
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			$sql.=' limit 1';
			if($this->db->query($sql)===false){
				return false;
			}else{
				return true;
			}
		}

		/**
		 *获取price的<select>控件
		 *@author zkq
		 *@param String $name
		 *@param String $id
		 *@return String
		 *注:参数可以不传
		 *用法:传值$name='a',$id='b',返回如:
		 *<select name='a' id='b'>
		 *<option value=100.00>100.00</option>
		 *<option value=500.00>500.00</option>
		 *</select>
		 *的格式
		 */
		public function getPriceSelect($name='price',$id='price'){
			$sql = 'select price from ebh_cardbatch group by price';
			$allPrice = $this->db->query($sql)->list_array();
			$s='<select name='.$name.' id='.$id.'>';
			$s.='<option value="0">全部</option>';
			foreach ($allPrice as $av) {
				$s.='<option value="'.$av['price'].'">'.intval($av['price']).'</option>';
			}
			$s.='</select>';
			return $s;
		}
		/**
		 *修改批次的状态
		 *@author zkq
		 *@param int $status
		 *@param int $bid
		 *@return bool
		 *用法如下:
		 * changeStatus(1,4)表示将表ebh_cardbatch表中的bid为4的状态改为1,并且同时更新lastmodified,lastmodifieduid字段
		 */
		public function changeStatus($status,$bid){
			if(intval($bid)==0){
				return false;
			}
			if(!in_array($status,array(0,-1))){
				return false;
			}
			$userinfo = EBH::app()->user->getloginuser();
			$param = array(
				'status'=>intval($status),
				'lastmodified'=>time(),
				'lastmodifieduid'=>$userinfo['uid'],
				);
			$where = array(
				'bid'=>intval($bid),
				);
			if($this->db->update('ebh_cardbatch',$param,$where)!==false){
				return true;
			}else{
				return false;
			}
		}
		/**
		 * 获取单条批次信息
		 * @author zkq
		 * @param array $param
		 * @return array 
		 * 注:其中$param为筛选条件的键值对
		 */
		public function getOne($param = array()){
			$param['limit'] = '1';
			$oneInfo = $this->getList($param);
			return $oneInfo[0];
		}
		/**
		 *更改批次的代理商信息
		 *@author zkq
		 *@param int $bid
		 *@param int $agentid
		 *@return bool (成功返回true,失败返回false)
		 *实例:changeAgent(3,33333);表示将批号bid为3的代理商改为33333
		 *注:$agentid为代理商的agentid不是代理商的名字
		 **/
		public function changeAgent($bid=0,$agentid=0){
			if(empty($bid)){
				return false;
			}
			if(empty($agentid)){
				return true;
			}
			$param = array('agentid'=>intval($agentid));
			$where = array('bid'=>intval($bid));
			if($this->db->update('ebh_cardbatch',$param,$where)!==false){
				return true;
			}else{
				return false;
			}
		}
		/**
		 *根据参数新增一条代理商
		 *@author zkq
		 *@param array $param
		 *@return int 或者 false
		 *注：成功时返回最新生成的代理商对应的bid,失败时返回false
		 */
		public function addOne($param=array()){
			if(empty($param)){
				return false;
			}
			return $this->db->insert('ebh_cardbatch',$param);
		}
		/**
         *检测价格是否存在,防止用户修改页面传入非法的price
         *@author zkq
         *@param int $price
         *@return bool
         *存在返回true,不存在返回false
         */
		public function checkPrice($price=0){
			$sql = 'select count(*) count from ebh_cardbatch where price='.$price.' limit 1';
			$res=$this->db->query($sql)->row_array();
			if($res['count']==0){
				return false;
			}else{
				return true;
			}
		}
	}
?>