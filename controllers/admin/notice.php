<?php
	/**
	 *后台内部公告控制器
	 *@author zkq
	 */
	class NoticeController extends AdminControl{
		/**
		 * 显示公共列表页视图
		 */
		public function index(){
			$grouplist = $this->model('groups')->getGroupsSelect();
			$this->assign('grouplist',$grouplist);
			$this->display('admin/notice');
		}
		/**
		 * 显示增加修改页面视图
		 */
		public function add(){
			$groupid=intval($this->input->get('groupid'));
			$logid=intval($this->input->get('logid'));
			if($logid!=0){
				$groupinfo = $this->model('log')->getOneLog(array('logid'=>$logid));
				$this->assign('op','edit');
				$this->assign('formhash',formhash($groupinfo['logid'].'edit'));
				$this->assign('groupinfo',$groupinfo);
			}else{
				$this->assign('formhash',formhash('add'));
				$this->assign('op','add');
			}
			$grouplist = $this->model('groups')->getGroupsSelect('toid','groupname',$groupid);
			$this->assign('grouplist',$grouplist);
			$this->assign('token',createToken());
			$this->display('admin/notice_add');
		}
		/**
		 * 新增公告和编辑公告的处理方法
		 */
		public function handle(){
			$rec = safeHtml($this->input->post());
			$this->check($rec);
			$userinfo = EBH::app()->user->getloginuser();
			$rec['uid'] = $userinfo['uid'];
			$rec['type'] = 'group';
			$rec['fromip'] = $this->input->getip();
			if($rec['op']=='add'){
				if($this->model('log')->_insert($rec)===true){
					$this->goback();
				}else{
					$this->goback('新增失败!');
				}
			}else{
				if(formhash($rec['logid'].'edit')!=$rec['formhash']){
					$this->goback('参数被篡改,编辑失败!');
				}
				if($this->model('log')->_update($rec,array('logid'=>intval($rec['logid'])))===true){
					$this->goback();
				}else{
					$this->goback('修改失败!');
				}
			}

			
		}
		/**
		 *获取LOG记录,用于列表页面分页显示
		 */
		public function getListAjax(){
			$param = $this->input->post();
			$pageNumber = empty($param['pageNumber'])?1:intval($param['pageNumber']);
			$pageSize = empty($param['pageSize'])?20:intval($param['pageSize']);
			$offset = max(0,($pageNumber-1)*$pageSize);
			parse_str($param['query'],$queryArr);
			$queryArr['limit'] = $offset.','.$pageSize;
			$NoticeModel = $this->model('log');
			$total = $NoticeModel->getsystemlogcount($queryArr);
			$NoticeList = $NoticeModel->getsystemloglist($queryArr);
			array_unshift($NoticeList,array('total'=>$total));
			echo json_encode($NoticeList);
		}
		/**
		 *批量删除记录
		 */
		public function delAll(){
			$logid=ltrim($this->input->post(param),';');
			echo $this->model('log')->deleteByLogId(explode(';',$logid));
		}
		/**
		 *删除单条记录
		 */
		public function delone(){
			$logid = $this->input->post('logid');
			echo $this->model('log')->deleteByLogId($logid);
		}
		/**
		 *操作成功或者失败时的跳转函数
		 */
		private function goback($note='操作成功!',$returnurl='/admin/notice.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}
		/**
		 * 对页面提交过来的数据进行二次验证
		 */
		private function check($param = array()){
			if(checkToken($param['token'])===false){
				$this->goback('请勿重复提交!');
			}
			$message = array();
			$message['code'] = true;
			if(empty($param['message'])){
				$message[] = '公告类容能为空';
				$message['code'] = false;
			}

			if($message['code']===false){
				$this->goback(implode('<br />',$message));
			}
		}
	}
?>