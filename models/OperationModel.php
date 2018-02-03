<?php
	/**
	 * operation的model,对应ebh_operation表
	 */
	class OperationModel extends CModel{
		/**
		 *获取operation列表
		 *@author zkq
		 *@param String $in
		 *@return array
		 *$in中的值对应ebh_position，如$in = '0,1';则表示去除ebh_operation表中的position为0,1的数据
		 */
		public function getSimpleList($in=null){
			if(is_null($in)){
				$in = '0,1,2,3,5,6';
			}
			$sql = 'select o.opid,o.opname from ebh_operations o where o.position in('.$in.') order by o.opid asc';
			return $this->db->query($sql)->list_array();
		}
		/**
		 *获取operation所有列表
		 *@author zkq
		 *@param null
		 *@return array
		 */
		public function getList(){
			$sql = 'select o.* from ebh_operations o ';
			return $this->db->query($sql)->list_array();
		}
		/**
		 *根据opid获取表ebh_operation中对应的一条记录
		 *@author zkq
		 *@param int $opid
		 *@return array
		 */
		public function getOne($opid = null){
			if(is_null($opid)){
				return array();
			}
			$sql = 'select o.* from ebh_operations o where o.opid = '.$opid.' limit 1';
			return $this->db->query($sql)->row_array();
		}
		/**
		 *新增一个操作
		 *@author zkq
		 *@param array $param
		 *@return bool
		 *$param中的字段必须对应ebh_operation表($param中可以有别的字段)
		 */ 
		public function _insert($param=array()){
			if(empty($param)){
				return false;
			}
			$setArr = array();
			$setArr['opid'] = $this->createOpid();
			if($setArr['opid']==false){
				return false;
			}
			$setArr['opcode'] = isset($param['opcode'])?$param['opcode']:'';
			$setArr['opname'] = isset($param['opname'])?$param['opname']:'';
			$setArr['description'] = isset($param['description'])?$param['description']:'';
			$setArr['position'] = isset($param['position'])?intval($param['position']):'';
			$setArr['iscredit'] = isset($param['iscredit'])?intval($param['iscredit']):'';
			if($this->db->insert('ebh_operations',$setArr)>0){
				return true;
			}else{
				return false;
			}

		}
		/**
		 *编辑一个操作
		 *@author zkq
		 *@param array $param
		 *@param array $where
		 *@return bool
		 *$param中的字段必须对应ebh_operation表($param中可以有别的字段)
		 *$where 对应条件 如$where = array('a'=>'b')表示条件为a=b
		 */ 		
		public function _update($param=array(),$where=array()){
			if(empty($param)||empty($where)){
				return false;
			}
			$setArr = array();
			$setArr['opcode'] = isset($param['opcode'])?$param['opcode']:'';
			$setArr['opname'] = isset($param['opname'])?$param['opname']:'';
			$setArr['description'] = isset($param['description'])?$param['description']:'';
			$setArr['position'] = isset($param['position'])?intval($param['position']):'';
			$setArr['iscredit'] = isset($param['iscredit'])?intval($param['iscredit']):'';
			if($this->db->update('ebh_operations',$setArr,$where)!==false){
				return true;
			}else{
				return false;
			}

		}
		/**
		 *用来生成新的操作opid,新增操作时用到此函数
		 *@author zkq
		 *@param null
		 *@return int 新的opid
		 * 注：数据库为opid字段为Int类型目前已经不能再添加,溢出
		 */
		public function createOpid(){
			$sql = 'select max(opid) as opid from ebh_operations';
			$res = $this->db->query($sql)->row_array();
			$newopid = $res['opid'];
			if($newopid==1073741824){
				return false;
			}
			return $res['opid']<<1;
		}
	}
?>