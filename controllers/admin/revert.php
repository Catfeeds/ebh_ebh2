<?php
	/**
	 *后台主贴管理模块控制器
	 */
	class RevertController extends AdminControl{
		/**
		 *主贴视图入口
		 */
		public function index(){
			$this->display('admin/revert');
		}
		/**
		 *根据参数获取主贴列表,用于主贴首页视图的列表显示
		 */
		public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$RevertModel = $this->model('revert');
			$total = $RevertModel->getListCount($queryArr);
			$revertList = $RevertModel->getList($queryArr);
			array_unshift($revertList,array('total'=>$total));
			echo json_encode($revertList);
		}
		/**
		 * 改变单个帖子的状态:锁定状态,正常状态
		 * POST传值
		 * @param int status 主贴将要变成的状态
		 * @param int rid 主贴对应的rid
		 * @return (ajaxreturn) bool
		 */
		public function changestatus(){
			$receive = safeHtml($this->input->post());
			//状态值判断,必须为0或者1,防止参数被篡改
			if(!in_array($receive['status'],array(0,1))){
				echo false;exit;
			}
			$param = array('status'=>intval($receive['status']));
			$where  = array('rid'=>intval($receive['rid']));
			echo $this->model('revert')->_update($param,$where);
		}
		/**
		 * 新增主贴和编辑主贴的页面入口
		 *
		 */
		public function edit(){
			$receive = $this->input->get();
			$rid = intval($receive['rid']);
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			$revert = $this->model('revert')->getOnerevert($rid);
			$this->assign('r',$revert);
			$this->display('admin/revert_edit');
		}
		/**
		 * 主贴回复编辑处理方法
		 * POST传值
		 * post传过来的值对应ebh_revert中的字段
		 */
		public function handle(){
			$receive = safeHtml($this->input->post(),array('rcontent'));
			$this->check($receive);
			$param = array();
			$param['rcontent'] = empty($receive['rcontent'])?'':$receive['rcontent'];
			$where = array('rid'=>intval($receive['rid']));
			$res = $this->model('revert')->_update($param,$where);
			if($res===true){
				$this->goback();
			}else{
				$this->goback('操作失败!');
			}
			
		}
		/**
		 * 功能方法,用来操作成功或者失败之后的跳转
		 * @param String $note (操作成功或者失败之后的提示信息)
		 * @param String $return (操作失败或者成功之后的回跳地址)
		 */
		private function goback($note='操作成功!',$returnurl='/admin/revert.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}
		/**
		 * 根据传入的rid删除ebh_revert表中的对应的记录
		 * post传值
		 * @param int $rid
		 * @return int (0,1) 0表失败,1表成功
		 */
		public function deleteByrid(){
			$rid = intval($this->input->post('rid'));
			if($rid<1){
				echo 0;exit;
			}
			$res = $this->model('revert')->_delete(array('rid'=>$rid));
			if($res===true){
				echo 1;
			}else{
				echo 0;
			}
		}
        /**
         * 根据传入的rid获取单条主贴数据
         * GET传值
         * @param int rid 
         * 主要用来显示主贴详细页面使用
         */
		public function detail(){
			$rid = intval($this->input->get('rid'));
			$revert = $this->model('revert')->getOnerevert($rid);
			$this->assign('r',$revert);
			$this->display('admin/revert_detail');
		}
		/**
		 * 检查主贴新增或者编辑时传过来的参数是否合理，防止数据被篡改
		 * @param array $param;
		 * 成功脚本继续执行;
		 * 失败脚本停止执行,并且回调到相应的url,并且显示相关的错误信息，默认为后台主贴列表页
		 */
		private function check($param){
			$message = array();
			$message['code'] = true;
			if(empty($param['rid'])){
				$message[]='回帖rid为空!';
				$message['code'] = false;
			}
			if(empty($param['rcontent'])){
				$message[]='内容为空';
				$message['code'] = false;
			}
			
			if($message['code']===false){
				$info = implode('<br />',$message);
				$this->goback($info);
			}
		}
	}