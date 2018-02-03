<?php
	/**
	 *产品model,针对表ebh_products
	 */
	class ProductModel extends CModel{
		/**
		 * 根据传入的参数返回产品列表
		 * @param array $param;
		 * @return array;
		 */
		public function getList($param=array()){
			$sql = 'select p.* from ebh_products p ';
			$whereArr = array();
			if(!empty($param['productno'])){
				$whereArr[] = ' p.productno like \'%'.$param['productno'].'%\'';
			}
			if(isset($param['status'])) {
				$whereArr[] = 'status = '.$param['status'];
			}
			if(!empty($whereArr)){
				$sql.=' WHERE '.implode(' AND ',$whereArr);
			}
			if(!empty($param['order'])){
				$sql.=' order by '.$param['order'];
			}else{
				$sql.=' order by productid desc';
			}
			if(!empty($param['limit'])){
				$sql.=' limit '.$param['limit'];
			}else{
				$sql.=' limit 10';
			}
			return $this->db->query($sql)->list_array();

		}
		/**
		 * 根据传入的参数返回产品条数
		 * @param array $param;
		 * @return int;
		 */
		public function getListCount($param=array()){
			$sql = 'select count(*) count from ebh_products p ';
			$whereArr = array();
			if(!empty($param['productno'])){
				$whereArr[] = ' p.productno like \'%'.$param['productno'].'%\'';
			}
			if(!empty($whereArr)){
				$sql.='WHERE '.implode(' AND ',$whereArr);
			}
			$res = $this->db->query($sql)->row_array();
			return $res['count'];
		}
		/**
		 * 根据传入的参数进行产品的增加或者编辑
		 * @param array $param
		 * @return bool
		 * 说明 : $param['op'] 必须传递 且其值必须为 add 或者 edit其中的一个，add 表示新添加,edit表示编辑
		 *        当$param['op'] 为 edit时 $param['productid'] 必须存在且必须为int类型
		 */
		public function save($param=array()){
			$isok = true;
			$setArr = array();
			$setArr['uid'] = intval($param['uid']);
			$setArr['productno'] = empty($param['productno'])?'':$param['productno'];
			$setArr['productname'] = empty($param['productname'])?'':$param['productname'];
			$setArr['brand'] = empty($param['brand'])?'':$param['brand'];
			$setArr['specification'] = empty($param['specification'])?'':$param['specification'];
			$setArr['vendorname'] = empty($param['vendorname'])?'':$param['vendorname'];
			$setArr['factoryname'] = empty($param['factoryname'])?'':$param['factoryname'];
			$setArr['marketprice'] = empty($param['marketprice'])?'':(float)$param['marketprice'];
			$setArr['memberprice'] = empty($param['memberprice'])?'':(float)$param['memberprice'];
			$setArr['credit'] = empty($param['credit'])?'':intval($param['credit']);
			$setArr['weight'] = empty($param['weight'])?'':(float)$param['weight'];
			$setArr['sellqty'] = empty($param['sellqty'])?'':intval($param['sellqty']);
			$setArr['stockqty'] = empty($param['stockqty'])?'':intval($param['stockqty']);
			$setArr['stockmin'] = empty($param['stockmin'])?'':intval($param['stockmin']);
			$setArr['color'] = empty($param['color'])?'':$param['color'];
			$setArr['dateline'] = empty($param['dateline'])?'':strtotime($param['dateline']);
			$setArr['viewnum'] = empty($param['viewnum'])?'':intval($param['viewnum']);
			$setArr['new'] = empty($param['new'])?'':intval($param['new']);
			$setArr['hot'] = empty($param['hot'])?'':intval($param['hot']);
			$setArr['special'] = empty($param['special'])?'':intval($param['special']);
			if(!empty($param['image'])){
				if(is_array($param['image'])){{
					$setArr['image'] = $param['image']['upfilepath'];
				}}else{
					$setArr['image'] = $param['image'];
				}
			}
			$setArr['summary'] = empty($param['summary'])?'':$param['summary'];
			$setArr['message'] = empty($param['message'])?'':$param['message'];
			$setArr['displayorder'] = empty($param['displayorder'])?'':intval($param['displayorder']);
			$setArr['type'] = empty($param['type'])?'':intval($param['type']);
			$setArr['crid'] = empty($param['crid'])?'':intval($param['crid']);
			$setArr['days'] = empty($param['days'])?'':intval($param['days']);
			$setArr['endtime'] = empty($param['endtime'])?'':strtotime($param['endtime']);
			$setArr['status'] = empty($param['status'])?'':intval($param['status']);
			if($param['op']=='add'){
				if($this->db->insert('ebh_products',$setArr)==-1){
					$isok = false;
				};
			}else{
				if(empty($param['productid'])){
					$isok = false;
				}else{
					if($this->db->update('ebh_products',$setArr,array('productid'=>intval($param['productid'])))==-1){
						$isok = false;
					}
				}
			}

			return $isok;
		}
		/**
		 * 根据传入的productid获取单条product信息
		 * @param int $productid
		 * @return 成功返回array,失败返回bool false
		 */
		public function  getOneByProductID($productid = 0){
			$productid = intval($productid);
			if($productid==0){
				return false;
			}else{
				$sql = 'select p.* from ebh_products p where productid ='.$productid;
				return $this->db->query($sql)->row_array();
			}
		}

		/**
		 * 删除对应传入的productid的记录
		 * @param int productid
		 * @return bool 
		 */
		 public function deleteByProductID($productid=0){
		 	$productid = intval($productid);
		 	if($productid==0){
		 		return false;
		 	}
		 	if($this->db->delete('ebh_products',array('productid'=>$productid))!=-1){
		 		return true;
		 	}else{
		 		return false;
		 	}
		 }
		 /**
		  * 更新productid记录
		  * @param array $param
		  * @return bool
		  * $param 为关联数组,其中键名必须和数据库中的ebh_products中的字段保持一致(字段可以少于表中的字段，但$param中存在的键名不能有和表中不一样的);
		  */ 
		 public function _update($param = array()){
		 	$param = safeHtml($param);
		 	if(empty($param['productid'])){
		 		return false;
		 	}
		 	$res = $this->db->update('ebh_products',$param,array('productid'=>intval($param['productid'])));
		 	if($res!=-1){
		 		return true;
		 	}else{
		 		return false;
		 	}
		 }
	}
?>