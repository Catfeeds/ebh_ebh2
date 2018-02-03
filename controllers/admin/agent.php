<?php
	/**
	 * 后台代理商管理控制器
	 */
	class AgentController extends AdminControl{
		/**
		 * 后台代理商管理列表页视图
		 */
		public function index(){
			$this->display('admin/agent');
		}
		/**
		 *新增代理商视图
		 */
		public function add(){
			$rec = $this->input->get();
			$this->assign('token',createToken());
			if(!empty($rec['op'])){
				if(in_array($rec['op'], array('add','edit'))&&isset($rec['agentid'])){
					$param = array('agentid'=>$rec['agentid']);
					$AgentsModel = $this->model('agents');
					$oneAgent = $AgentsModel->getOneAgent($param);
					$upname = $AgentsModel->getAgentName($oneAgent['upid']);
					$this->assign('upname',$upname);
					$this->assign('op','edit');
					$this->assign('a',$oneAgent);
					$this->assign('formhash',formhash($rec['agentid'].'edit'));
				}else{
					$this->goback('操作数有误!');
				}
			}else{
				$upid = empty($rec['upid'])?0:$rec['upid'];
				$this->assign('formhash',formhash('add'));
				$upname = empty($rec['upname'])?'顶级代理':$rec['upname'];
				$this->assign('a',array('upid'=>$upid));
				$this->assign('upname',$upname);
				$this->assign('op','add');
			}
			$this->display('admin/agent_add');
		}
		/**
		 *批量添加代理商视图
		 */
		public function batchadd(){
			$this->display('admin/agent_batchadd');
		}
		/**
		 *代理商详情视图
		 */
		public function detail(){
			$agentid = $this->input->get('agentid');
			$AgentsModel = $this->model('agents');
			$oneAgent = $AgentsModel->getOneAgent(array('agentid'=>intval($agentid)));
			$agentname = $AgentsModel->getAgentName($oneAgent['upid']);
			$this->assign('oneAgent',$oneAgent);
			$this->assign('agentname',$agentname);
			$this->display('admin/agent_detail');
		}
		/**
		 *代理商选择视图
		 *
		 */
		public function lite(){
			$this->display('admin/agent_lite');
		}
		/**
		 *获取代理商列表
		 */
		public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$AgentModel = $this->model('agents');
			$total = $AgentModel->getListCount($queryArr);
			$PostsList = $AgentModel->getList($queryArr);
			array_unshift($PostsList,array('total'=>$total));
			echo json_encode($PostsList);
		}
		/**
		 *代理商批量添加处理方法
		 *@param String $addtype
		 *@param int $num
		 *
		 */
		public function _batchadd(){
			$uparam = $param = array();
			$rec = $this->input->post();
			$num = intval($rec['num']);
			$upid = intval($rec['upid']);
			$db = $this->model('agents')->_db();
			$db->begin_trans();
			for($i=0;$i<$num;$i++){
				$uparam['password'] = $uparam['username'] = $this->createuserdiyname('8');
				$userinfo = array(
					'username'=>$uparam['username'],
					'password'=>$uparam['password'],
					'groupid'=>2,
					'status'=>2,
					);
				$uid = $this->model('user')->_insert($userinfo);
				if($uid==0){
					$db->rollback_trans();
					$this->goback('操作失败');
				}
				$param = array(
					'agentid'=>$uid,
					'upid'=>$upid
					);
				if($this->model('agents')->_insert($param)!==true){
					$db->rollback_trans();
					$this->goback('操作失败');
				}
			}
			$db->commit_trans();
			$this->goback();
			
		}
		/**
		 *代理商增加和编辑处理函数
		 *
		 */
		public function handle(){
			$rec = safeHtml($this->input->post());
			$this->check($rec);
			$param = array();
			$param['upid'] =!isset($rec['upid'])?0:intval($rec['upid']);
			$param['contractno'] =!isset($rec['contractno'])?'':$rec['contractno'];
			if(isset($rec['agentdate'])){
				$param['agentdate'] = strtotime($rec['agentdate']);
			}
			$param['realname'] = !isset($rec['realname'])?'':$rec['realname'];
			if(isset($rec['profile'])){
				$param['profile'] = $rec['profile'];
			}
			if(isset($rec['phone'])){
				$param['phone'] = $rec['phone'];
			}
			if(isset($rec['fax'])){
				$param['fax'] = $rec['fax'];
			}
			if(isset($rec['mobile'])){
				$param['mobile'] = $rec['mobile'];
			}
			if(isset($rec['address_sheng'])){
				$param['citycode'] = $rec['address_sheng'];
			}
			if(isset($rec['address_shi'])){
				$param['citycode'] = $rec['address_shi'];
			}
			if(isset($rec['address_qu'])){
				$param['citycode'] = $rec['address_qu'];
			}
			if(!empty($rec['bankname'])&&!empty($rec['bankcard'])){
				$param['bankcard'] = serialize(array('card'=>$rec['bankcard'],'bankname'=>$rec['bankname']));
			}
			if($rec['op']=='add'){
				$uparam['password'] = empty($rec['password'])?md5(123456):md5($rec['password']);
				$uparam['username'] = empty($rec['username'])?$this->createuserdiyname('8'):$rec['username'];
				$userinfo = array(
					'username'=>$uparam['username'],
					'realname'=>$param['realname'],
					'password'=>$uparam['password'],
					'groupid'=>2,
					'status'=>2,
					);
				$uid = $this->model('user')->_insert($userinfo);
				if($uid==0){
					$this->goback('新增失败!');
				}
				$param['agentid'] = $uid;
				if($this->model('agents')->_insert($param)===true){
					$this->goback();
				}else{
					$this->goback('操作失败!');
				}
			}else{
				if(formhash($rec['agentid'].'edit')!=$rec['formhash']){
					$this->goback('参数被篡改!');
				}
				if(empty($rec['agentid'])){
					$this->goback('操作失败!');
				}
				$where = array('agentid'=>intval($rec['agentid']));
				if($this->model('agents')->_update($param,$where)===false){
					$this->goback('操作失败!');
				}else{
					$this->goback();
				}
			}
		}
		/**
		 *改变代理商状态函数
		 */
		public function changestatus(){
			$agentid = intval($this->input->post('agentid'));
			$status = intval($this->input->post('status'));
			if(!in_array($status,array(0,1))){
				$this->goback('参数被篡改,操作失败!');
			}
			$param = array('status'=>$status);
			$where = array('uid'=>$agentid);
			echo $this->model('agents')->changeinfo($param,$where);
		}
		/**
		 *根据代理商agentid删除对应的代理商
		 */
		public function deleteByagentid(){
			$isok = true;
			$agentid = intval($this->input->post('agentid'));
			if(strlen($agentid)<1){
				echo false;
			}
			
			echo $this->model('user')->deletebyuid($agentid)&&$this->model('agents')->_delete(array('agentid'=>$agentid));
		}
		/**
		 *操作成功或者失败时的跳转行数,带提示功能
		 */
		private function goback($note='操作成功',$returnurl='/admin/agent.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}
		/**
		 *检测参数是否合理,防止前台的重复提交和恶意修改js造成的数据格式不对
		 */
		private function check($param){
			if(checkToken($param['token'])===false){
				$this->goback('请勿重复提交!');
			}
			$message = array();
			$message['code'] = true;
			if($param['op']=='add'){
				if(empty($param['username'])){
					$message[] = '用户名为空!';
					$message['code'] = false;
				}
				if(empty($param['password'])){
					$message[] = '密码为空!';
					$message['code'] = false;
				}else{
					if(strlen($param['password'])<6||strlen($param['password'])>16){
						$message[] = '密码长度不对!';
						$message['code'] = false;
					}else{
						if($param['password']!=$param['forpassword']){
							$message[] = '两次密码不匹配!';
							$message['code'] = false;
						}
					}
				}
			}
			if(empty($param['bankname'])!=empty($param['bankcard'])){
				$message[] = '银行卡号和银行名称只存在一项!';
				$message['code'] = false;
			}
			if(!empty($param['agentdate'])){
				$pattern ="/^(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29)$/";
				if(preg_match($pattern, $param['agentdate'])==0){
					$message[] = '日期格式不对!';
					$message['code'] = false;
				}
			}
			if($message['code']===false){
				$this->goback(implode('<br />',$message));
			}
		}
	    /**
	     * 生成代理商账号
	     * 根据前缀和长度生成账号
	     * @param int $len 账号长度
	     * @param String $prefix 账号前缀
	    */
	    function createuserdiyname($prefix,$len=6){
			if(empty($len))
			{
				$len=6;
			}
			if(empty($prefix))
			{
				$prefix=8;
			}
			$username='';
			$sql='SELECT username FROM ebh_users WHERE username LIKE \''.$prefix.'%\' AND length(username)='.$len.' ORDER BY username DESC ';
			$query=$this->model('agents')->_queryone($sql);
			if(empty($query))
			{
				$countzero=$len-strlen($prefix)-1;
				for($i=0;$i<$countzero;$i++)
				{
					$prefix.='0';
				}
				$username=$prefix.'1';
			}
			else
			{
				$username=$query['username']+1;
			}
			while(strpos($username, '4'))//去掉有任何一个4的号码
			{
				$username+=1;
			}
			return $username;
				
	 	}
	}