<?php
	/**
	 * 产品控制器
	 */
	class ProductController extends AdminControl{
		public function index(){
			$this->display('admin/product');
		}
		/**
		 * 产品增加页面数据分配，视图跳转
		 */
		public function add(){
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$productid = $this->input->get('productid');
			if(!empty($productid)){
				$this->assign('productid',$productid);
				$this->assign('op','edit');
				$product = $this->model('product')->getOneByProductID($productid);
				$this->assign('product',$product);
			}else{
				$this->assign('op','add');
			}
			$this->display('admin/product_add');
		}
		/**
		 * 根据参数获取相关产品数据列表,用于产品列表页面的数据获取;
		 * @return array $PList
		 */
		public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?10:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$PModel = $this->model('product');
			$total = $PModel->getListCount($queryArr);
			$PList = $PModel->getList($queryArr);
			array_unshift($PList,array('total'=>$total));
			echo json_encode($PList);
		}
		/**
		 * 产品新增，编辑 处理函数
		 * POST传值
		 * @param array
		 * @return bool
		 * 注意:比如$param = $this->input->post(); 其中$param['op']必须存在，且其值必须为'add'或者'edit'中的其中一个;	
		 */
		public function handle(){
			$param = safeHtml($this->input->post(),array('message'));
			$checkedResult = $this->checkParam($param);
			if($checkedResult!==true){
				$this->widget('note_widget',array('note'=>$checkedResult,'returnurl'=>geturl('admin/product')));
				exit;
			}
			$auth = $this->input->cookie('auth');
			if(!empty($auth)){
				@list($password, $uid) = explode("\t", authcode($auth, 'DECODE'));
           	 	$uid = intval($uid);
           	 		if ($uid <= 0) {
           	   	 	return false;
           	 	}
				$param['uid'] = $uid;
			}
			if($this->model('product')->save($param)===true){
				$this->widget('note_widget',array('note'=>'操作成功','returnurl'=>geturl('admin/product')));
				exit;
			}else{
				$this->widget('note_widget',array('note'=>'操作失败','returnurl'=>geturl('admin/product')));
				exit;
			}
		}

		/**
		 *产品上架下架处理
		 * 参数为Post传过来的
		 * @param int productid
		 * @param int status 
		 * @return bool
		 * status=0正常上架;status-1下架
		 */
		public function changestatus(){
			$param = safeHtml($this->input->post());
			if(empty($param['productid'])){
				echo  false;
			}else{
				echo  $this->model('product')->_update($param);
			}
		}
		/**
		 * 删除传入的productid对应的记录
		 * POST传参
		 * @param int $productid
		 * @return bool
		 */
		public function _delete(){
			$productid = $this->input->post('productid');
			echo $this->model('product')->deleteByProductID($productid);
		}
		/**
		 * 获取单条产品信息
		 * GET传值
		 * @param int $productid
		 * @return array $pinfo;
		 **/
		public function getOneProduct(){
			$productid = intval($this->input->get('productid'));
			$product = $this->model('product')->getOneByProductID($productid);
			$this->assign('p',$product);
			$this->display('admin/product_detail');
		}

		/**
		 * 检测参数是否合法，主要用于检测产品增加和修改页面传递过来的参数的合法性
		 * @param array $param
		 * @return bool tree(成功),String(失败) String中包含失败信息，比如 'productno为空，credit格式不对'等信息 
		 * 用于检查字段格式是否合法，比如productno字段不能为空等
		 */
		private function checkParam($param){
			$message = array();
			$message['code'] = true;
			if(!isset($param['op'])){
				$message[]= '操作数字段不存在!';
				$message['code'] = false;
			}
			if(empty($param['op'])){
				$message[]= '操作数为空!';
				$message['code'] = false;
			}else{
				if(!in_array($param['op'],array('add','edit'))){
					$message[] = '操作数非法!';
					$message['code'] = false;
				}
			}
			if(empty($param['productno'])){
				$message[] = '产品号为空!';
				$message['code'] = false;
			}else{
				if(mb_strlen($param['productno'],'UTF8')<2||mb_strlen($param['productno'],'UTF8')>50){
					$message[] = '产品号长度错误!';
					$message['code'] = false;
				}
			}
			if(empty($param['productname'])){
				$message[] = '产品号为空!';
				$message['code'] = false;
			}else{
				if(mb_strlen($param['productname'],'UTF8')<2||mb_strlen($param['productname'],'UTF8')>50){
					$message[] = '产品名称长度错误!';
					$message['code'] = false;
				}
			}
			if(!isset($param['marketprice'])){
				$message[] = '原价为空!';
				$message['code'] = false;
			}else{
				if(preg_match("/^\d+(\.\d{2})?$/",$param['marketprice'])==0){
					$message[] = '原价格式错误!';
					$message['code'] = false;
				}
			}
			if(!isset($param['memberprice'])){
				$message[] = '会员价为空!';
				$message['code'] = false;
			}else{
				if(preg_match("/^\d+(\.\d{2})?$/",$param['memberprice'])==0){
					$message[] = '会员价格式错误!';
					$message['code'] = false;
				}
			}
			if(!isset($param['credit'])){
				$message[] = '兑换积分为空!';
				$message['code'] = false;
			}else{
				if(preg_match("/^\d+?$/",$param['credit'])==0){
					$message[] = '兑换积分格式错误!';
					$message['code'] = false;
				}
			}
			if(!isset($param['stockqty'])){
				$message[] = '库存为空!';
				$message['code'] = false;
			}else{
				if(preg_match("/^\d+?$/",$param['stockqty'])==0){
					$message[] = '库存格式错误!';
					$message['code'] = false;
				}
			}
			if(!isset($param['displayorder'])){
				$message[] = '排序为空!';
				$message['code'] = false;
			}else{
				if(preg_match("/^\d+?$/",$param['displayorder'])==0){
					$message[] = '排序格式错误!';
					$message['code'] = false;
				}
			}
			if(!isset($param['type'])){
				$message[] = '类型为空!';
				$message['code'] = false;
			}else{
				if(!in_array($param['type'],array(0,1))){
					$message[] = '类型参数被篡改!';
					$message['code'] = false;
				}
			}	
			if(!isset($param['status'])){
				$message[] = '状态为空!';
				$message['code'] = false;
			}else{
				if(!in_array($param['status'],array(0,1,-1))){
					$message[] = '状态参数被篡改!';
					$message['code'] = false;
				}
			}				
			//处理结果
			if($message['code']===false){
				return implode('<br />',$message);
			}else{
				return true;
			}

		}
	}
?>