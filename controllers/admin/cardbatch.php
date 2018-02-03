<?php
	/**
	 *后台批次控制器
	 *@author zkq
	 */
	class CardbatchController extends AdminControl{
		/**
		 *充值卡批次首页视图
		 */
		public function index(){
			//获取代理商的<select>控件,用于页面显示
			$agentSelect = $this->model('agents')->getAgentsSelect('agentid','agentid');
			//获取价格的<select>控件,用于页面显示
			$priceSelect = $this->model('cardbatch')->getPriceSelect();
			$this->assign('priceSelect',$priceSelect);
			$this->assign('agentSelect',$agentSelect);
			$this->display('admin/cardbatch');
		}
		/**
		 *获取批次列表,不解释
		 */
		public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$CardbatchModel = $this->model('cardbatch');
			$total = $CardbatchModel->getListCount($queryArr);
			$CardbatchList = $CardbatchModel->getList($queryArr);
			array_unshift($CardbatchList,array('total'=>$total));
			echo json_encode($CardbatchList);
		}
		/**
		 *修改批次状态,同时批量修改批次下面的充值卡的状态
		*/
		public function changeStatus(){
			//获取安全的post值
			$rec = safeHtml($this->input->post());
			//获取批次的bid
			$bid = intval($rec['bid']);
			if($bid==0){
				echo false;exit;
			}
			//获取批次和充值卡即将要变成的状态值
			$status = intval($rec['status']);
			if(!in_array($status,array(0,-1))){
				echo false;exit;
			}
			//获取充值卡模型
			$cardsModel = $this->model('cards');
			//调用充值卡模型方法修改充值卡的状态
			if($cardsModel->changeStatus($status,null,$bid)===false){
				echo false;exit;
			}
			//获取批次模型
			$cardbatchModel = $this->model('cardbatch');
			//调用批次模型方法改变批次的状态
			if($cardbatchModel->changeStatus($status,$bid)===false){
				echo false;exit;
			}
			echo true;
		}
		/**
		 *批次详情视图
		 */
		public function detail(){
			//获取批次的bid,下面根据此获取对应的批次信息
			$bid = intval($this->input->get('bid'));
			//获取操作数('add' 或者 'edit')
			$op = $this->input->get('op');
			$this->assign('$op',$op);
			//批次查询条件打包
			$param = array('bid'=>$bid);
			//获取单条批次信息
			$oneInfo =$this->model('cardbatch')->getOne($param);
			//根据op判断很下面的agent的<select>控件是否由disabled属性
			$isDisable = $op=='view'?true:false;
			//生成表单hash值,防止表单数据被篡改
			if($op=='view'){
				$formhash = formhash('view');
			}else{
				//用于生成hash值得种子为$bid.'edit',表示用户不能篡改这两个信息
				$formhash = formhash($bid.'edit');
			}
			$this->assign('formhash',$formhash);
			//生成表单令牌,防止页面的重复提交
			$this->assign('token',createToken());
			//获取代理商的<select>控件
			$agentSelect = $this->model('agents')->getAgentsSelect('agentid','agentid',$oneInfo['agentid'],$isDisable);
			$this->assign('oneInfo',$oneInfo);
			$this->assign('agentSelect',$agentSelect);
			$this->assign('op',$op);
			$this->display('admin/cardbatch_add');
		}
		/**
		 *修改批次信息,修改批次对应的充值卡的状态
		 */
		public function changeInfo(){
			//不解释
			$rec = safeHtml($this->input->post());
			//安检
			$this->check($rec);
			$bid = intval($rec['bid']);
			$status = intval($rec['status']);
			$agentid = intval($rec['agentid']);
			//获取充值卡的模型
			$cardsModel = $this->model('cards');
			//调用充值卡模型方法批量修改充值卡的状态
			if($cardsModel->changeStatus($status,null,$bid)===false){
				$this->goback('充值卡状态批量修改错误!');
			}
			//获取批次的模型
			$cardbatchModel = $this->model('cardbatch');
			//调用批次模型的方法修改批次的状态
			if($cardbatchModel->changeStatus($status,$bid)===false){
				$this->goback('批次状态修改错误!');
			}
			//调用批次模型的方法修改批次所属的代理商的信息
			if($cardbatchModel->changeAgent($bid,$agentid)===false){
				$this->goback('代理商信息修改错误!');
			}
			$this->goback('修改成功!');
		}
		/**
		 * 安检函数
		 */
		public function check($param=array()){
			if(checkToken($param['token'])===false){
				$this->goback('请勿重复提交!');
			}
			$message=array();
			$message['code'] = true;
			if(!in_array($param['status'],array(0,-1))){
				$message[]='状态信息被攒改!';
				$message['code'] = false;
			}
			if(!empty($param['agentid'])){
				if($this->model('agents')->ifAgentExits(intval($param['agentid']))===false){
					$message[]='代理商信息被攒改!';
					$message['code'] = false;
				}
			}
			
			if($param['op']=='edit'){
				$hashbt = intval($param['bid']).'edit';
				if(formhash($hashbt)!=$param['formhash']){
					$this->goback('参数被篡改!');
				}
			}else{
				if(formhash('view')!=$param['formhash']){
					$this->goback('参数被篡改!');
				}
			}
			if($message['code']===false){
				$this->goback(implode('<br />',$message));
			}

		}
		/**
		 *操作成功或者失败时的跳转函数
		 */
		public function goback($note='操作成功!',$returnurl='/admin/cardbatch.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}

	}
?>