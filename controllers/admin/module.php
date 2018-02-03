<?php
	/**
	 *Module控制器
	*/
	class ModuleController extends AdminControl{
		public function index(){
			if($this->cache->get('moduleTree')){
				$modules = unserialize($this->cache->get('moduleTree'));
			}else{
				$modules = $this->model('module')->getList(true);
				$this->cache->set('moduleTree',serialize($modules),6000);
			}
			// $modules = $this->model('module')->getList(true);
			$this->assign('modules',$modules);
			$this->display('admin/module');
		}
		//增加module，编辑module时根据get传过来的参数op分类相应的数据跳转到相应的视图
		public function add(){
			$op = $this->input->get('op');

			if(empty($op)){
				$op = 'add';
				$this->assign('upid',$this->input->get('moduleid'));
			}else{
				$op = 'edit';
			}
			if($op=='edit'){
				$upid = intval($this->input->get('upid'));
				$moduleid = intval($this->input->get('moduleid'));
				$module = $this->model('module')->getModuleByModuleId($moduleid);
				$this->assign('module',$module);
				$this->assign('upid',$upid);
			}
			$this->assign('token',createToken());
			$this->assign('op',$op);
			$this->display('admin/module_add');
		}
		//编辑，新增module信息是的处理函数
		public function handle(){
			$post = safeHtml($this->input->post());
			$validate = $this->validate($post);
			if($validate['code']===false){
				$this->widget('note_widget',array('note'=>implode('<br />',$validate),'returnurl'=>geturl('admin/module/add')));
				exit();
			}
			if(!in_array($post['op'],array('add','edit'))){
				$this->widget('note_widget',array('note'=>'操作数被篡改!','returnurl'=>geturl('admin/module/add')));
				exit();
			}
			if(checkToken($post['token'])===false){
				$this->widget('note_widget',array('note'=>'请勿重复提交!','returnurl'=>geturl('admin/module')));
				exit;
			}
			if($this->model('module')->op($post)!==false){
				$this->clearCache();
				if(isset($post['nextop'])){
					$this->widget('note_widget',array('note'=>'操作成功,跳转中!','returnurl'=>geturl('admin/module/add')));
				}else{
					$this->widget('note_widget',array('note'=>'操作成功,跳转中!','returnurl'=>geturl('admin/module')));
				}
			}
		}
		/**
		 * 删除对应的module
		 * get格式 array('moduleid'=>3);
		 * 表示删除moduleid为3的module
		 * *注意*(调用的model会递归删除moduleid=3下面的后代module)
		 */
		public function del(){
			$moduleid = intval($this->input->get('moduleid'));
			$res = $this->model('module')->delHandle($moduleid);
			if($res===true){
				$this->clearCache();
				$this->widget('note_widget',array('note'=>'删除成功,跳转中!','returnurl'=>geturl('admin/module')));
				
			}else{
				$this->widget('note_widget',array('note'=>'删除失败,跳转中!','returnurl'=>geturl('admin/module')));
			}

		}
		/**
		 * 将传入的moduleid对应的记录的displayorder改变为传入的order
		 * get格式 array(
		 *				moduleid=>3,
		 *				order=>20
		 *			);
		 * 表示将moduleid为3的moudle的displayorder改变为20
		 *
		 *
		 */
		public function moveorder(){
			$info = $this->input->get();
			$moduleid = intval($info['moduleid']);
			$order = intval($info['order']);
			if($this->model('module')->moveorder($moduleid,$order)!==false){
				$this->clearCache();
				$this->widget('note_widget',array('note'=>'移动成功!','returnurl'=>geturl('admin/module')));
			}else{
				$this->widget('note_widget',array('note'=>'移动失败!','returnurl'=>geturl('admin/module')));
			}
		}
		/**
		 *获取module列表，用于小挂件
		 *@param int $selected
		 *返回格式 text/html: <option moduleid="33">modulename1</option><option moduleid="44" selected=selected>*modulename2</option>
		 *$selected 为要默认选中的module的moduleid
		 */
		public function getModuleListAjax($selected=null){
			$selected = intval($this->input->post('selected'));
			if($this->cache->get('moduleSimpleTree')){
				$modules = unserialize($this->cache->get('moduleSimpleTree'));
			}else{
				$modules = $this->model('module')->getModuleSimpleList(true);
				$this->cache->set('moduleSimpleTree',serialize($modules),6000);
			}
			$ajaxReturn = '';
			foreach ($modules as $v) {
				if($v['moduleid']==$selected){
					$ajaxReturn.= '<option value='.$v['moduleid'].' selected=selected>'.$v['name'].'</option>';
				}else{
					$ajaxReturn.= '<option value='.$v['moduleid'].'>'.$v['name'].'</option>';
				}
			}
			echo $ajaxReturn;
		}
		/**
		 * 批量删除控制器 
		 * post传值 
		 * post 格式为 array(
		 *     			'moduleids'=>'moduleid1;moduleid2;moduleid3;'	
		 *     			'tag'=>0
		 *				)
		 *其中tag为0表示影藏module，为1表示删除
		 *
		 *
		 */
		public function delAll(){
			$moduleids = explode(';',trim($this->input->post('moduleids'),';'));
			$tag = intval($this->input->post('tag'));
			if($tag===0){
				//隐藏
				if($this->model('module')->hideAll($moduleids)===true){
					$this->widget('note_widget',array('note'=>'批量隐藏成功,跳转中!','returnurl'=>geturl('admin/module')));
				}
			}else{
				//删除或者强制删除
				if($this->model('module')->delHandle($moduleids,$tag)===true){
					$this->clearCache();
					$this->widget('note_widget',array('note'=>'批量删除成功,跳转中!','returnurl'=>geturl('admin/module')));
				}else{
					$this->widget('note_widget',array('note'=>'操作失败,跳转中!','returnurl'=>geturl('admin/module')));
				}

			}
		}
		/**
		 * 批量排序控制器 
		 * post传值 
		 * post 格式为 array(
		 *     			'data'=>'moduleid1,order1;moduleid2,order2;moduleid3,order3;'
		 *				)
		 *
		 *
		 */
		public function saveAll(){
			$data = trim($this->input->post('data'),';');
			$dataArr = explode(';',$data);
			$res = $this->model('module')->saveAll($dataArr);
			if($res===true){
				$this->clearCache();
				$this->widget('note_widget',array('note'=>'批量排序成功,跳转中!','returnurl'=>geturl('admin/module')));
			}else{
				$this->widget('note_widget',array('note'=>'批量排序失败,跳转中!','returnurl'=>geturl('admin/module')));
			}

		}
		/**
		 * 将module批量移动到对应的module里面
		 * post传值 
		 * post 格式为 array(
		 *     			'moduleids'=>'moduleid1;moduleid2;moduleid3;'
		 *				'toWhere'=>moduleid100
		 *				)
		 * 表示将moduleid1,moduleid2,moduleid3移动到moduleid100里面
		 *
		 */
		public function movecatAll(){
			$data = trim($this->input->post('moduleids'),';');
			$dataArr = explode(';',$data);
			$toWhere = intval($this->input->post('toWhere'));
			$res = $this->model('module')->movecatAll($dataArr,$toWhere);
			if($res===true){
				$this->clearCache();
				$this->widget('note_widget',array('note'=>'移动成功,跳转中!','returnurl'=>geturl('admin/module')));
			}else{
				$this->widget('note_widget',array('note'=>'操作失败,跳转中!','returnurl'=>geturl('admin/module')));
			}
 
		}
		/**
		 * 模块上移或者下移,tag为-1表示上移,为1表示下移
		 * get传值格式 array(
		 *					'moduled'=>33,
		 *					'tag'=>1,
		 *				);
		 * 
		 */
		public function moveupordown(){
			$moduleid = intval($this->input->get('moduleid'));
			$tag = intval($this->input->get('tag'));
			if(!in_array($tag,array(-1,1))){
				$this->widget('note_widget',array('note'=>'参数非法!','returnurl'=>geturl('admin/module')));
				exit();
			}
			$isok = $this->model('module')->moveupordown($moduleid,$tag);
			
			if($isok===true){
				$this->clearCache();
				$this->widget('note_widget',array('note'=>'移动成功!','returnurl'=>geturl('admin/module')));
			}else{
				$this->widget('note_widget',array('note'=>'移动失败!','returnurl'=>geturl('admin/module')));
			}
		}

		private function clearCache(){
			$this->cache->remove('moduleTree');
			$this->cache->remove('moduleSimpleTree');
		}
		//验证字段，用于新增或者编辑module时验证参数是否合法
		private function validate($param=array()){
			$message = array();
			$message['code'] = true;
			if(empty($param['name'])){
				$message[]='模块名称为空,或者参数非法!';
				$message['code'] = false;
			}else{
				if(mb_strlen($param['name'],'UTF8')<2||mb_strlen($param['name'],'UTF8')>10){
					$message[]='模块名称长度不对!';
					$message['code'] = false;
				}
			}

			if(empty($param['identifier'])){
				$message[]='模块标识为空!';
				$message['code'] = false;
			}else{
				if(strlen($param['identifier'])<1){
					$message[]='模块标识长度不对!';
					$message['code'] = false;
				}
			}

			if(preg_match("/^\d+$/",$param['displayorder'])==0){
				$message[]='排序格式不对,必须为数字!';
				$message['code'] = false;
			}
		
			return $message;
		}
	}