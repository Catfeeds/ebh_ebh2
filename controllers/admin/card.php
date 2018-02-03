<?php
	/**
	 * 后台充值卡控制器
	 * @author zkq
	 */
	class CardController extends AdminControl{
		/**
		 * 后台充值卡列表页视图跳转
		 * 
		 */
		public function index(){
			//获取批次的名称
			$bname = $this->input->get('bname');
			$this->assign('bname',$bname);
			//获取代理商的select控件,用于页面显示代理商下拉框
			$agentSelect = $this->model('agents')->getAgentsSelect();
			$this->assign('agentSelect',$agentSelect);
			$this->display('admin/card');
		}
		/**
		 * 批量生成充值卡视图跳转
		 *
		 */
		public function add(){
			//获取代理商的select控件,用于页面显示代理商下拉框
			$agentSelect = $this->model('agents')->getAgentsSelect();
			//获取页面传过来的充值卡的cardid用来获取对应的充值卡信息
			$cardid = intval($this->input->get('cardid'));
			//获取价格的select控件,用于页面显示代价格下拉框
			$priceSelect = $this->model('cardbatch')->getPriceSelect();
			$this->assign('priceSelect',$priceSelect);
			//分配操作数为add
			$this->assign('op','add');
			//分配表单hash值,用来防止数据的篡改
			$this->assign('formhash',formhash('add'));
			$this->assign('agentSelect',$agentSelect);
			$this->assign('token',createToken());
			$this->display('admin/card_add');
		}
		/**
		 * 处理充值卡批量生成时表单提交过来的数据
		 */
		public function handle(){
			//循环递归安全处理post传过来的值
			$rec = safeHtml($this->input->post());
			//安检
			$this->check($rec);
			$num = intval($rec['num']);
			if($num<=0){
				$this->goback('充值卡数量必须为正整数!','/admin/card/add.html');
			}
			$price = intval($rec['price']);
			$agentid = intval($rec['agentid']);
			$dateline=time();
			//获取登录用户的相关信息,不写成$uid=EBH::app()->user->getloginuser()['uid']的原因是php5.3及其以下版本不支持;
			$user=EBH::app()->user->getloginuser();
			$uid=$user['uid'];
			//批次名称获取
			$bname = $this->model('cardbatch')->createbname();
			//批次数据准备(用来新增一个批次)
			$bParamArr = array('bname'=>$bname,'uid'=>$uid,'dateline'=>$dateline,'price'=>$price,'status'=>0,'agentid'=>$agentid);
			//新增一个批次
			$batchid = $this->model('cardbatch')->addOne($bParamArr);
			if($batchid===false){
				$this->goback('添加批次失败');
			}
			//批量创建新的充值卡,注意$cardno为数组
			$cardno = $this->model('cards')->createcardno(6,$num);
			//操作ebh_cards表对应的字段
			$fields=array('cardno','cardpwd','price','dateline','uid','status','seocode','agentid','batchid');
			//充值卡信息组准备
			$param=array();
			do{
				$param[]=array(
					$cardno[$num-1],
					// strtoupper(random(8)),
					random(10,true),
					$price,
					$dateline,
					$uid,
					0,
					strtoupper(random(5)),
					$agentid,
					$batchid
					);
				$num--;
			}while($num>0);
			//调用模型_set批量新增充值卡
			$returnurl = isset($rec['nextsubmit'])?'/admin/card/add.html':'/admin/card.html';
			if($this->model('cards')->_set($fields,$param)!==false){
				$this->goback('添加成功',$returnurl);
			}else{
				$this->goback('添加失败',$returnurl);
			}
		}
		/**
		 *获取充值卡列表,不解释
		 */
		public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$CardsModel = $this->model('cards');
			$total = $CardsModel->getListCount($queryArr);
			$CardsList = $CardsModel->getList($queryArr);
			array_unshift($CardsList,array('total'=>$total));
			echo json_encode($CardsList);
		}
		/**
		 *批量修改充值卡的状态
		 **/
		public function changeStatus(){
			//获取充值卡即将要变成的状态的数值
			$status = intval($this->input->post('status'));
			//$cardsid为充值卡的cardid结合,格式为 'card1 card2 card3'的串
			$cardsid = $this->input->post('cardsid');
			if(!in_array($status,array(0,-1))){
				echo false;
			}else{
				//将充值卡合集串转为数组
				$cardsid = explode(' ',$cardsid);
			}
			//调用模型方法完成批量修改
			echo $this->model('cards')->changeStatus($status,$cardsid);
		}

		/**
		 * 充值卡详情视图跳转
		 */
		public function detail(){
			//递归过滤,获取绝对安全数据
			$rec= safeHtml($this->input->get());
			//获取操作数('edit'或者'add')
			$op = $rec['op'];
			//获取cardid,intval转换是为了安全,防止出现 $cardid=1 or 1的情况,防sql注入
			$cardid = intval($rec['cardid']);
			//根据cardid获取单条充值卡信息
			$oneCard = $this->model('cards')->getOne($cardid);
			$this->assign('oneCard',$oneCard);
			//根据操作数op判断代理<select>下拉框是否为disabled
			$isDisabled = $op=='view'?true:false;
			//获取代理商的<select>控件
			$agentSelect = $this->model('agents')->getAgentsSelect('agentid','agentid',$oneCard['agentid'],$isDisabled);
			$this->assign('op',$op);
			$this->assign('token',createToken());
			//根据相关数据分配formhash值,用来防止表单数据的恶意篡改
			if($op=='view'){
				$this->assign('formhash',formhash('view'));
			}else{
				$this->assign('formhash',formhash('edit'.$oneCard['cardid']));
			}
			$this->assign('agentSelect',$agentSelect);
			$this->display('admin/card_detail');
		}
		/**
		 *删除相应的充值卡
		 */
		public function delOne(){
			//获取即将要被消灭的充值卡的cardid
			$carid = intval($this->input->post('cardid'));
			echo $this->model('cards')->deleteByCardid($carid);
		}
		/**
		 *改变充值卡的信息
		 */
		public function changeInfo(){
			//不解释
			$rec = safeHtml($this->input->post());
			//安检
			$this->check($rec);
			//包装对应充值卡即将要改变成的信息
			$param=array(
				'agentid'=>intval($rec['agentid']),
				'status'=>intval($rec['status'])
				);
			//包装要修改的充值卡的where条件
			$where=array('cardid'=>intval($rec['cardid']));
			if($this->model('cards')->_update($param,$where)===true){
				$this->goback();
			}else{
				$this->goback('修改出错!');
			}
		}
		/**
		 *操作成功或者失败时的跳转函数
		 */
		private function goback($note='操作成功!',$returnurl='/admin/card.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}
		/**
		 *安检方法,用于检测用户提交过来的数据是否合法;
		 */
		private function check($param = array()){
			$returnurl = '/admin/card/add.html';
			$message = array();
			$message['code'] = true;
			if(checkToken($param['token'])===false){
				$this->goback('请勿重复提交表单!');
			}
			if(!in_array($param['op'],array('add','edit'))){
					$message[]='操作数被攒改!';
					$message['code'] = false;
			}
			if($param['op']=='edit'){
				$formhashbt = 'edit'.$param['cardid'];
				if(formhash($formhashbt)!=$param['formhash']){
					$message[]='表单数据被攒改!';
					$message['code'] = false;
				}
			}else{
				if(formhash($param['op'])!=$param['formhash']){
					$message[]='表单数据被攒改!';
					$message['code'] = false;
				}
			}
			if(empty($param['price'])){
				$message[] = '充值卡价值为0不是坑人吗?';
				$message['code'] = false;
			}else{
				// if($this->model('cardbatch')->checkPrice(intval($param['price']))===false){
				// 	$message[] = '充值卡价格被篡改';
				// 	$message['code'] = false;
				// }
			}
			if(!empty($param['agentid'])){
				if($this->model('agents')->ifAgentExits(intval($param['agentid']))===false){
					$message[]='代理商信息被攒改!';
					$message['code'] = false;
				}
			}
			if(!in_array($param['status'],array(0,-1))){
				$message[]='状态数据被攒改!';
				$message['code'] = false;
			}
			if($message['code']===false){
				$this->goback(implode('<br />',$message),$returnurl);
			} 
		}
	}
?>