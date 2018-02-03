<?php
	/**
	 *后台主贴管理模块控制器
	 */
	class PostsController extends AdminControl{
		/**
		 *主贴视图入口
		 */
		public function index(){
			$this->display('admin/posts');
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
			$PostsModel = $this->model('posts');
			$total = $PostsModel->getListCount($queryArr);
			$PostsList = $PostsModel->getList($queryArr);
			array_unshift($PostsList,array('total'=>$total));
			echo json_encode($PostsList);
		}
		/**
		 * 改变单个帖子的状态:锁定状态,正常状态
		 * POST传值
		 * @param int status 主贴将要变成的状态
		 * @param int postsid 主贴对应的postsid
		 * @return (ajaxreturn) bool
		 */
		public function changestatus(){
			$receive = safeHtml($this->input->post());
			//状态值判断,必须为0或者1,防止参数被篡改
			if(!in_array($receive['status'],array(0,1))){
				echo false;exit;
			}
			$param = array('status'=>intval($receive['status']));
			$where  = array('postsid'=>intval($receive['postsid']));
			echo $this->model('posts')->_update($param,$where);
		}
		/**
		 * 新增主贴和编辑主贴的页面入口
		 *
		 */
		public function add(){
			$receive = safeHtml($this->input->get(),array('content'));
			$postsid = $receive['postsid'];
			$editor = Ebh::app()->lib('UMEditor');
			$this->assign('editor',$editor);
			if(!empty($postsid)){
				$posts = $this->model('posts')->getOnePosts($postsid);
				$this->assign('posts',$posts);
				$this->assign('op','edit');
			}else{
				$this->assign('op','add');
			}
			$this->display('admin/posts_add');
		}
		/**
		 * 主贴编辑和新增处理方法
		 * POST传值
		 * post传过来的值对应ebh_posts中的各个字段
		 * $this->input->post()['op'] 必须存在,且必须为'add'或者'edit'其中的一个,add表示新增一条主贴,edit表示删除一条主贴;
		 *
		 */
		public function handle(){
			$receive = safeHtml($this->input->post(),array('content'));
			$this->check($receive);
			$user = EBH::app()->user->getloginuser();
			$param = array();
			$param['subject'] = empty($receive['subject'])?'':$receive['subject'];
			$param['content'] = empty($receive['content'])?'':$receive['content'];
			$param['tag'] = empty($receive['tag'])?'':$receive['tag'];
			$param['encl'] = empty($receive['encl'])?'':$receive['encl'];
			$param['viewnum'] = empty($receive['viewnum'])?'':intval($receive['viewnum']);
			$param['postline'] = time();
			$param['top'] = empty($receive['top'])?'':intval($receive['top']);
			$param['hot'] = empty($receive['hot'])?'':intval($receive['hot']);
			$param['best'] = empty($receive['best'])?'':intval($receive['best']);
			$param['status'] = empty($receive['status'])?'':intval($receive['status']);
			$param['rnum'] = empty($receive['rnum'])?'':intval($receive['rnum']);
			$param['cid'] = empty($receive['cid'])?'':intval($receive['cid']);
			$param['lastuid'] = $user['uid'];
			$param['lastline'] = time();

			if($receive['op']=='add'){
				$param['uid'] = $param['lastuid'] = $user['uid']; 
				$param['dateline'] = time();
				$res = $this->model('posts')->_insert($param);
				if($res===true){
					$this->goback();
				}else{
					$this->goback('操作失败!');
				}
			}else{
				$param['lastuid'] = $user['uid']; 
				$where = array('postsid'=>intval($receive['postsid']));
				$res = $this->model('posts')->_update($param,$where);
				if($res===true){
					$this->goback();
				}else{
					$this->goback('操作失败!');
				}
			}
		}
		/**
		 * 功能方法,用来操作成功或者失败之后的跳转
		 * @param String $note (操作成功或者失败之后的提示信息)
		 * @param String $return (操作失败或者成功之后的回跳地址)
		 */
		private function goback($note='操作成功!',$returnurl='/admin/posts.html'){
			$this->widget('note_widget',array('note'=>$note,'returnurl'=>$returnurl));
			exit;
		}
		/**
		 * 根据传入的postsid删除ebh_posts表中的对应的记录
		 * post传值
		 * @param int $postsid
		 * @return int (0,1) 0表失败,1表成功
		 */
		public function deleteByPostsId(){
			$postsid = intval($this->input->post('postsid'));
			if($postsid<1){
				echo 0;exit;
			}
			$res = $this->model('posts')->_delete(array('postsid'=>$postsid));
			if($res===true){
				echo 1;
			}else{
				echo 0;
			}
		}
        /**
         * 根据传入的postsid获取单条主贴数据
         * GET传值
         * @param int postsid 
         * 主要用来显示主贴详细页面使用
         */
		public function detail(){
			$postsid = intval($this->input->get('postsid'));
			$posts = $this->model('posts')->getOnePosts($postsid);
			$this->assign('posts',$posts);
			$this->display('admin/posts_detail');
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
			if(empty($param['subject'])){
				$message[]='标题为空!';
				$message['code'] = false;
			}
			if(empty($param['content'])){
				$message[]='内容为空';
				$message['code'] = false;
			}
			if(isset($param['hot'])&&preg_match("/^[ 0123]$/",$param['hot'])==0){
				$message[]='热门级别参数被篡改!';
				$message['code'] = false;
			}
			if(isset($param['top'])&&preg_match("/^[ 0123]$/",$param['top'])==0){
				$message[]='置顶级别参数被篡改!';
				$message['code'] = false;
			}
			if(isset($param['best'])&&preg_match("/^[ 0123]$/",$param['best'])==0){
				$message[]='精华级别参数被篡改!';
				$message['code'] = false;
			}
			if($message['code']===false){
				$info = implode('<br />',$message);
				$this->goback($info);
			}
		}
	}