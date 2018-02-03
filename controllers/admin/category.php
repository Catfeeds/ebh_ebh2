<?php
/*
后台分类控制器
*/
	class CategoryController extends AdminControl{
		public function __construct(){
		parent::__construct();
		$user = Ebh::app()->user->getloginuser();
		$cparr = explode('/',$this->uri->codepath);
		$permission = $this->model('permission');
		$param['groupid'] = $user['groupid'];
		$param['controller'] = $cparr[1];
		$res = $permission->haspermission($param);
		if(!$res){
			echo '权限不足';
			exit;
		}
	}
		//新闻分类列表入口
		public function news(){
			$this->assign('type','news');
			$newsList = getTree($this->model('category')->getCategoriesByParam(array('type'=>'news')));
			$this->assign('category',$newsList);
			$this->display('admin/category');
		}
		//广告分类列表入口
		public function ad(){
			$this->assign('type','ad');
			$adsList = getTree($this->model('category')->getCategoriesByParam(array('type'=>'ad')));
			$this->assign('category',$adsList);
			$this->display('admin/category');
		}
		//投票分类列表入口
		public function poll(){
			$this->assign('type','poll');
			$adsList = getTree($this->model('category')->getCategoriesByParam(array('type'=>'poll')));
			$this->assign('category',$adsList);
			$this->display('admin/category');
		}
		//投票分类列表入口
		public function special(){
			$this->assign('type','special');
			$adsList = getTree($this->model('category')->getCategoriesByParam(array('type'=>'special')));
			$this->assign('category',$adsList);
			$this->display('admin/category');
		}
		//频道分类入口
		public function channel(){
			$position = $this->input->get('position');
			$position = empty($position)?1:$position;
			$channelList = getTree($this->model('category')->getCategoriesByParam(array('position'=>$position)));
			$this->assign('type','channel');
			$this->assign('position',$position);
			$this->assign('category',$channelList);
			$this->display('admin/channel');
		}
		//资源分类入口
		public function resources(){
			$this->assign('type','resources');
			$adsList = getTree($this->model('category')->getCategoriesByParam(array('type'=>'resources')));
			$this->assign('category',$adsList);
			$this->display('admin/category');
		}
		//根据where数组参数传回相关分类信息
		public function getCategories(){
				$where = (array)$this->input->post('where');
				$categories = $this->model('category')->getCategoriesByParam($where);
				//分类转换为树形结构
				$categoriesTree = getTree($categories);
				echo json_encode($categoriesTree);
		}


		//删除分类，删除传入分类的catid的对应的分类
		public function delete(){
			$message=array();
			$catid = intval($this->input->post('catid'));
			$system = intval($this->input->post('system'));
			$position = $this->input->post('position');
			$type = $this->input->post('type');
			if($system===1){
				$this->widget('note_widget',array('note'=>'存在系统目录,禁止删除!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
				exit();
			}else{
				if(empty($catid)){
					$this->widget('note_widget',array('note'=>'栏目错误，或者参数被篡改!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
				}
			}
			
			$res = $this->model('Category')->deleteHandle($catid);
			if($res===true){
				echo $this->widget('note_widget',array('note'=>'删除成功!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
			}else{
				echo $this->widget('note_widget',array('note'=>'删除失败,请检查该分类下是否存在系统目录!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
			}
		}

		//分类移动分发器，处理对应的参数，调用移动函数，上移，下移
		public function moveHandle(){
			$type = $this->input->post('type');
			$position = $this->input->post('position');
			$catid = intval($this->input->post('catid'));
			$upordown = intval($this->input->post('upordown'));
			$displayorder = intval($this->input->post('displayorder'));
			$res = $this->model('category')->move($catid,$upordown,$displayorder);
			if($res===true){
				$this->widget('note_widget',array('note'=>'移动成功!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
			}else{
				$this->widget('note_widget',array('note'=>'移动失败!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
			}
		
		}
		//分类编辑，根据传入的op判断是新增还是编辑，分配相关数据到视图
		public function edit(){
			$type = $this->input->get('type');
			$op = $this->input->get('op');
			$catid = $this->input->get('catid');
			$position = $this->input->get('position');
			$this->assign('position',$position);
			if($type==false){
				exit('参数有问题!');
			}
			if($catid!==false){
				if($op=='update'){
					$catinfo = $this->model('category')->getCatBycatid(intval($catid));
				}else{
					$catinfo2 = $this->model('category')->getCatBycatid(intval($catid));
					$catinfo=array('upid'=>$catid);
				}
				$this->assign('catinfo',$catinfo);
			}
			
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->assign('op',$op);
			$this->assign('type',$type);
			$this->assign('catid',$catid);
			$this->assign('token',createToken());
			if($type=='channel'){
				$this->assign('position',$this->input->get('position'));
				$this->display('admin/channel_add');
				exit();
			}
			if($type=='resources'){
				$this->display('admin/resources_addType');
				exit();
			}
			$this->display('admin/category_add');
		}

		//处理增加，编辑操作
		public function op(){
			$postArr = safeHtml($this->input->post());
			if(empty($postArr['tag'])){
				$type=$postArr['type'];
			}else{
				$type=$postArr['tag'];
			}
			
			$position = $postArr['position'];
			if(checkToken($postArr['token'])===false){
				$this->widget('note_widget',array('note'=>'请勿重复提交!','returnurl'=>'/admin/category/'.$type.'.html'.'?position='.$position));
				exit();
			}
			if(!in_array($postArr['op'],array('insert','update'))){
				$this->widget('note_widget',array('note'=>'操作失败,不能识别op!','returnurl'=>'/admin/category/'.$type.'.html'.'?position='.$position));
				exit();
			}
			if(empty($postArr['name'])||empty($postArr['code'])){
				$this->widget('note_widget',array('note'=>'操作失败,分类名称和分类ID不能为空!','returnurl'=>'/admin/category/'.$type.'.html'.'?position='.$position));
				exit();
			}
			if(preg_match('/_/',$postArr['code'])){
				$this->widget('note_widget',array('note'=>'操作失败,分类ID不能含有下划线!','returnurl'=>'/admin/category/'.$type.'.html'.'?position='.$position));
				exit();
			}
			if(is_array($this->model('category')->getCatByCode($postArr['code']))&&($postArr['op']=='insert')){
				$this->widget('note_widget',array('note'=>'操作失败,分类ID已存在!','returnurl'=>'/admin/category/'.$type.'.html'.'?position='.$position));
				exit();
			}
			$postArr['opvalue'] = empty($postArr['opvalue'])?array():$postArr['opvalue'];
			$postArr['opvalue'] = array_sum($postArr['opvalue']);
			if($this->model('category')->op($postArr)!==false){
				$this->widget('note_widget',array('note'=>'操作成功,跳转中!','returnurl'=>'/admin/category/'.$type.'.html'.'?position='.$position));
			}else{
				$this->widget('note_widget',array('note'=>'操作失败,跳转中!','returnurl'=>'/admin/category/'.$type.'.html'.'?position='.$position));
			}
			

		}

		//获取分类菜单，用于小挂件，已淘汰
		// public function getCM(){
		// 	$this->display('admin/categoryMenue');
		// }

		//获取分类列表，主要用于小挂件categories_widget
		public  function getGategoriesList($where=null){
			$key = md5(serialize($this->input->post()));
			if($this->cache->get($key)){
				echo $this->cache->get($key);exit;
			}
			$where=(array)json_decode($this->input->post('where'));
			$checked=trim($this->input->post('checked'));
			if(strpos($checked,',')!==false){
				$checked=explode(',',$checked);
			}
			$isad=trim($this->input->post('isad'));
			// $Clist = $this->model('category')->getNewsCategoriesByType($type);
			$Clist = $this->model('category')->getCategoriesByParam($where);
			if(is_array($Clist)){
				$Clist = getTree($Clist);
			}
			$options = '';



				if(is_array($checked)){
					if(in_array('nation', $checked)){
						$options.='<option value="nation" selected=selected >全国首页</option>';
					}else{
						if($where['type']=='courseware'&&$where['position']==1){
							$options.='<option value="nation" >全国首页</option>';
						}
					}
					
					if(in_array('all', $checked)){
						$options.='<option value="all" selected=selected >所有频道</option>';
					}else{
						if(isset($where['ischannel'])){
							$options.='<option value="all" >所有频道</option>';
							
						}
					}
					if(in_array('index', $checked)){
						$options.='<option value="index" selected=selected >首页频道</option>';
					}else{
						if(isset($where['ischannel'])){
							$options.='<option value="index" >首页频道</option>';
							
						}
					}

					foreach ($Clist as $v) {
						if(in_array($v['catid'], $checked)){
							$options.='<option value='.$v['catid'] .' selected=selected >'.$v['name'].'</option>';
						}else{
							$options.='<option value='.$v['catid'] .'>'.$v['name'].'</option>';
						}
				
					}
				}else{

					
					// if($checked=='nation'||$checked=='index'||$checked=='all'){
						if($checked=='nation'){
								$options.='<option value="nation" selected=selected >全国首页</option>';
								
						}else{
							if($where['type']=='courseware'&&$where['position']==1){
								$options.='<option value="nation" >全国首页</option>';
							}
						}
						if($checked=='all'){
								$options.='<option value="all" selected=selected >所有频道</option>';
								
						}else{
							if(isset($where['ischannel'])){
								$options.='<option value="all" >所有频道</option>';
							
							}
						}
						if($checked=='index'){
								$options.='<option value="index" selected=selected >首页频道</option>';
							
						}else{
							if(isset($where['ischannel'])){
								$options.='<option value="index" >首页频道</option>';
							
							}
						}

					// }
					foreach ($Clist as $v) {

						if($checked==$v['catid']){
							{
								$options.='<option value='.$v['catid'] .' selected=selected >'.$v['name'].'</option>';
							}

							
						}else{
							$options.='<option value='.$v['catid'] .'>'.$v['name'].'</option>';
						}
				
					}
				}
			$this->cache->set($key,$options,60);
			echo  $options;
		}

		//根据分类的catid获取单一分类的数据
		public function getCatNameByID(){
			$catid = trim($this->input->post('catid'));
			if($catid=='nation'){
				$message = '全国首页';
			}elseif($catid==false){
				$message = ''; 
			}else{
				$message = $this->model('channel')->getChannelByCatId($catid);
			}
			echo $message;

		}
		//批量排序处理函数
		public function sortopAll(){
			$candd=array();
			$type=$this->input->post('type');
			$position = $this->input->post('position');
			$param = rtrim($this->input->post('param'),';');
			$paramArr = explode(';',$param);
			foreach ($paramArr as $value) {
				$candd[] = explode(',',$value);
			}
			
			if($this->model('category')->sortopAll($candd)===true){
				$this->widget('note_widget',array('note'=>'批量排序成功!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
			}else{
				$this->widget('note_widget',array('note'=>'批量排序失败!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
			}
				

		}
		//批量移动函数
		public function moveopAll(){
			$param = rtrim($this->input->post('param'),';');
			$paramArr = explode(';',$param); //catid集合
			$category = $this->input->post('category');
			$position = $this->input->post('position');
			$tag = trim($this->input->post('tag'));
			$type=$this->input->post('type');
			if($this->model('category')->moveopAll($paramArr,$category,$tag)===true){
				echo $this->widget('note_widget',array('note'=>'批量移动分类成功!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
			}else{
				echo $this->widget('note_widget',array('note'=>'批量移动分类失败!','returnurl'=>geturl('admin/category/'.$type).'?position='.$position));
			}
		}
		//检查是否字段ID是否重复
		public function checkRepeatID(){
			$postInfo = safeHtml($this->input->post());
			$code = $postInfo['code'];
			$op = $postInfo['op'];
			if($op=='update'){
				echo 1;exit;
			}
			$res = $this->model('category')->getCatByCode($code);
			if(empty($res)){
				echo 1;
			}else{
				echo 0;
				
			}
		}
		/*
		分类列表，只含catid,name ajax
		*/
		public function getsimplelist(){
			$cat = $this->model('category');
			$catlist = $cat->getsimplecatlist();
			echo json_encode($catlist);
		}
	}