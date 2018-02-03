<?php
	/**
	 *充值卡模型,针对ebh_cards表
	 *@author zkq
	 */
	class CardsModel extends CModel{
		/**
		 * 获取充值卡列表信息
		 * @author zkq
		 * @param array $param
		 * @return array
		 */
		public function getList($param = array()){
			$sql = 'select c.*,u.username,b.bname,b.lastmodified from ebh_cards c left join ebh_users u on c.uid = u.uid left join ebh_cardbatch b on b.bid = batchid ';
			$whereArr = array();
			if(!empty($param['cardid'])){
				$whereArr[] = 'c.cardid='.intval($param['cardid']);
			}
			if(!empty($param['searchkey'])){
				$whereArr[] = 'c.cardno like \'%'.$param['searchkey'].'%\'';
			}
			if(!empty($param['bname'])){
				$whereArr[] = 'b.bname =\''.$param['bname'].'\'';
			}
			if(!empty($param['price'])){
				$whereArr[] = 'c.price ='.$param['price'];
			}
			if(!empty($param['status']) && strlen($param['status'])>=1){
				$whereArr[] = 'c.status ='.intval($param['status']);
			}
			if(!empty($param['agentid'])){
				$whereArr[] = 'b.agentid ='.$param['agentid'];
			}
			if(!empty($param['begindateline'])){
				$whereArr[] = 'c.dateline >'.strtotime($param['begindateline']);
			}
			if(!empty($param['enddateline'])){
				$whereArr[] = 'c.dateline <'.strtotime($param['enddateline']);
			}
			if(!empty($param['beginusedateline'])){
				$whereArr[] = 'c.usedateline >'.strtotime($param['beginusedateline']);
			}
			if(!empty($param['endusedateline'])){
				$whereArr[] = 'c.usedateline <'.strtotime($param['endusedateline']);
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			if(empty($param['order'])){
				$sql.=' order by c.dateline desc';
			}else{
				$sql.=' order by '.$param['order'];
			}
			if(empty($param['limit'])){
				$sql.=' limit 20 ';
			}else{
				$sql.=' limit '.$param['limit'];
			}
			return $this->db->query($sql)->list_array();
		}
		/**
		 * 获取充值卡符合条件的个数
		 * @author zkq
		 * @param array $param
		 * @return int
		 */
		public function getListCount($param = array()){
			$sql = 'select count(*) count from ebh_cards c left join ebh_cardbatch b on b.bid = batchid ';
			$whereArr = array();
			if(!empty($param['cardid'])){
				$whereArr[] = 'c.cardid='.intval($param['cardid']);
			}
			if(!empty($param['searchkey'])){
				$whereArr[] = 'c.cardno like \'%'.$param['searchkey'].'%\'';
			}
			if(!empty($param['bname'])){
				$whereArr[] = 'b.bname =\''.$param['bname'].'\'';
			}
			if(!empty($param['price'])){
				$whereArr[] = 'c.price ='.$param['price'];
			}
			if(strlen($param['status'])>=1){
				$whereArr[] = 'c.status ='.intval($param['status']);
			}
			if(!empty($param['agentid'])){
				$whereArr[] = 'b.agentid ='.$param['agentid'];
			}
			if(!empty($param['begindateline'])){
				$whereArr[] = 'c.dateline >'.strtotime($param['begindateline']);
			}
			if(!empty($param['enddateline'])){
				$whereArr[] = 'c.dateline <'.strtotime($param['enddateline']);
			}
			if(!empty($param['beginusedateline'])){
				$whereArr[] = 'c.usedateline >'.strtotime($param['beginusedateline']);
			}
			if(!empty($param['endusedateline'])){
				$whereArr[] = 'c.usedateline <'.strtotime($param['endusedateline']);
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			$res = $this->db->query($sql)->row_array();
			return $res['count'];
		}
		/**
		 *修改cards的状态
		 *@author zkq
		 *@param int $status
		 *@param int $cardsid 或者array $cardsid
		 *@param int $bid
		 * 注:status为要改变成的状态;
		 * 用法1:changeStatus(-1,1);表示将cardid为1的充值卡状态改为-1
		 * 用法2:changeStatus(0,array(1,2));表示将cardid为1或者2的充值卡的状态改为0
		 * 用法3:changeStatus(0,null,1);表示将batchid为1的所有未使用的充值卡的状态改为0,其中第二个参数随便传
		 */
		public function changeStatus($status,$cardsid,$bid){

			if(!in_array($status,array(0,1,-1))){
				return false;
			}
			if(!empty($bid)){
				$where = 'batchid ='.intval($bid).' AND status!=1';
				if($this->db->update('ebh_cards',array('status'=>intval($status)),$where)!==false){
					return true;
				}else{
					return false;
				}
			}
			if(is_scalar($cardsid)){
				$cardsid = array($cardsid);
			}
			$cardsid = $this->filterUsedCardid($cardsid);
			$where='';
			foreach ($cardsid as $cv) {
				$where.=' or cardid='.intval($cv);
			}
			$where = ltrim($where,' or');
			if($this->db->update('ebh_cards',array('status'=>$status),$where)!==false){
				return true;
			}else{
				return false;
			}

		}
		/**
		 * 判断充值卡是否被使用
		 * @author zkq
		 * @param $where
		 * @return bool
		 */
		private function ifhasusedcard($where){
			$sql='select sum(if(status=1,1,0)) as s from ebh_cards where '.$where;
			$res = $this->db->query($sql)->row_array();
			if($res['s']>0){
				return false;
			}else{
				return true;
			}
		}
		/**
		 * 将传入数组中的已经充值的充值卡的cardid剔除
		 * @author zkq
		 * $param array $cardsid
		 * 注:其中 cardsid为cardid的集合,比如$cardsid = array(cardid1,cardid2....);
		 */
		private function filterUsedCardid($cardsid){
			$sql = 'select cardid from ebh_cards where status=1';
			$usedCardsid = $this->db->query($sql);
			if($usedCardsid!==false){
				$usedCardsidArr = $usedCardsid->list_array();
			}
			$usedCardsidArr2=array();
			foreach ($usedCardsidArr as  $uv) {
				$usedCardsidArr2[]=$uv['cardid'];
			}
			return array_diff($cardsid,array_intersect($cardsid,$usedCardsidArr2));
		}
		/**
		 * 根据cardid删除对应的充值卡
		 * @author zkq
		 * @param array $cardsid 或者 int $cardsid
		 * @return bool 成功返回true,失败返回false 
		 * 注:传入的参数$cardsid可以为int类型和array类型,传int类型删除单个充值卡,传入数组表示批量删除
		 * 如果传数组格式为array(cardid1,cardid2,...);
		 *
		 */
		public function deleteByCardid($cardsid){
			if(empty($cardsid)){
				return false;
			}
			if(is_scalar($cardsid)){
				$cardsid = array($cardsid);
			}
			$where='';
			foreach ($cardsid as $cv) {
				$where.=' or cardid='.intval($cv);
			}
			$where = ltrim($where,' or');
			if($this->db->delete('ebh_cards',$where)!==false){
				return true;
			}else{
				return false;
			}
		}

		/**
		 * 根据bit(也就是批次id)获取该批次下面的所有充值卡的cardid信息
		 * @author zkq
		 * @param int $bid
		 * @return bool false 或者 array  (成功返回array,失败返回false)
		 */
		public function getCardidByBid($bid=0){
			$bid=intval($bid);
			if($bid==0){
				return false;
			}
			$sql = 'select cardid from ebh_cards where batchid='.intval($bid);
			$res = $this->db->query($sql);
			if($res===false){
				return false;
			}
			$cardsidArr2 = $res->list_array();
			$cardsidArr=array();
			foreach($cardsidArr2 as $cv) {
				$cardsidArr[]=$cv['cardid'];
			}
			return $cardsidArr;
		}
		/**
		 * 根据$cardid获取单条充值卡信息
		 * @author zkq
		 * @param int $cardid
		 * @return array (一维数组)
		 */
		public function getOne($cardid=0){
			$cardid=intval($cardid);
			if($cardid==0){
				return false;
			}
			$param = array(
				'cardid'=>$cardid,
				'limit'=>1,
				);
			$getOneArr = $this->getList($param);
			return $getOneArr[0];
		}
		/**
		 * 修改充值卡的相关信息
		 * @author zkq 
		 * @param array $param (修改的字段的键值对)
		 * @param array $where (条件键值对) 
		 * @return bool (成功返回true,失败返回false)
		 * 注：本方法只负责修改相关数据,不进行数据的额外处理,数据请在控制器里面弄好
		 */
		public function _update($param=array(),$where=array()){
			if(empty($where)){
				return false;
			}
			if($this->db->update('ebh_cards',$param,$where)!==false){
				return true;
			}else{
				return false;
			}
		}
		/**
		 * 新增充值卡的相关信息
		 * @author zkq 
		 * @param array $param (新增的字段的键值对)
		 * @return bool (成功返回true,失败返回false)
		 * 注：本方法只负责新增相关数据,不进行数据的额外处理,数据请在控制器里面弄好
		 */		
		public function _insert($param=array()){
			if(empty($param)){
				return false;
			}
			if($this->db->insert('ebh_cards',$param)!==false){
				return true;
			}else{
				return false;
			}
		}
		/**
		 * 批量新增充值卡
		 * @author zkq 
		 * @param array $fields (对应的字段)
		 * @param array $param (参数键值对) 
		 * @return bool (成功返回true,失败返回false)
		 * 注：本方法只负责修改相关数据,不进行数据的额外处理,数据请在控制器里面弄好
		 * 使用简洁 传入$fields=array('a','b'),$param=array(array('av1','bv1'),array('av2','bv2'),..),生成sql语句为:
		 * insert into ebh_cards ('a','b') values ('av1','bv1'),('av2','bv2')
		 * 这里的values里面的值统统当做字符串处理加上'',数据库那边会自动转成对应的类型,不要担心
		 */
		public function _set($fields=array(),$param=array()){
			$fields='('.implode(',',$fields).')';
			$valuesArr=array();
			foreach ($param as $v) {
				$v = $this->db->escape_str($v);
				$valuesArr[]='(\''.implode('\',\'',$v).'\')';
			}
			$values = implode(',',$valuesArr);
			$sql='insert into ebh_cards '.$fields.' values '.$values;
			if($this->db->query($sql)!==false){
				return true;
			}else{
				return false;
			}
		}
		/**
		 *批量生成充值卡卡号
		 *@author zkq
		 *@param int $length 
		 *@param int $num
		 *@return array
		 *注:传入的$length表示要生成的卡号的长度,$num表示生成的卡号数量
		 */
		public function createcardno($length=8,$num=1){
			set_time_limit(0);
			$cardnos = array();
			do {
				$cardno = date('Y',time()) . strtoupper ( random ( $length , 1) );
				$sql = 'select count(*) count from ebh_cards where cardno=\''.$cardno.'\' limit 1 ';
				$res = $this->db->query($sql)->row_array();
					if(($res['count']==0)&&(!in_array($cardno, $cardnos))){
						$cardnos[]=$cardno;
						$num--;
					}
				} while ($num>0);
			return $cardnos;
		}
	}
?>