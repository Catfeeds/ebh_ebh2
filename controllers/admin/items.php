<?php
    /**
     * item相关控制器
     */
	class ItemsController extends CControl{
		//前台页面异步调用返回items相关列表
		public function getListAjax(){
			$query = $this->input->post('query');
			$pageNumber= intval($this->input->post('pageNumber'));
			$pageSize = intval($this->input->post('pageSize'));
			parse_str($query,$queryArr);
			$queryArr['catid'] = $this->getChildrenCatidByUpid($queryArr['catid'],$queryArr['type']);
			$total = (int)$this->model('item')->getitemlistCount($queryArr);
			$offset=max(($pageNumber-1)*$pageSize,0);
			$queryArr['limit']=$offset.','.$pageSize;
			$list = $this->model('item')->getitemlist($queryArr);
			if($queryArr['type']=='resources'){
				array_unshift($list, array('total'=>$total));
				echo json_encode($list);
				exit;
			}
			
			$list = $this->listHandle($list,$queryArr['type']);
			array_unshift($list, array('total'=>$total));
			echo json_encode($list);

		}

	public function add(){
		//item编辑，新增页面数据分配器
		$itemid = (int)$this->input->get('itemid');
		$type = $this->input->get('type');
		$this->assign('token',createToken());
		$this->assign('type',$type);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$Upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('Upcontrol',$Upcontrol);
		if($itemid>0){
			$item = $this->model('item')->getItemByItemid($itemid);
			$this->assign('item',$item);
			$this->assign('itemid',$itemid);
			$this->assign('op','edit');
		}else{
			$this->assign('op','add');
		}
		$this->display('admin/'.$type.'_add');
	}
	//处理添加数据或者修改数据
	public function handle(){
		$param = $this->input->post();
		$type=$param['type'];
		if(checkToken($param['token'])===false){
			$this->widget('note_widget',array('note'=>'请勿重复提交!','returnurl'=>geturl('admin/'.$type)));
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
		if(!in_array($param['op'],array('add','edit'))){
			$this->widget('note_widget',array('note'=>'操作数字段错误,跳转中!','returnurl'=>geturl('admin/'.$type)));
			exit;
		}
		if(trim($param['op'])=='add'){
			if($this->model('item')->op($param)===true){
				if(isset($param['nextsubmit'])){
					$this->widget('note_widget',array('note'=>'添加成功,跳转中!','returnurl'=>geturl('admin/'.$type.'/add')));
				}else{
					$this->widget('note_widget',array('note'=>'添加成功,跳转中!','returnurl'=>geturl('admin/'.$type)));
				}
				
			}else{
				if(isset($param['nextsubmit'])){
					$this->widget('note_widget',array('note'=>'添加失败,提交参数非法或者服务器故障,跳转中!','returnurl'=>geturl('admin/'.$type.'/add')));
				}else{
					$this->widget('note_widget',array('note'=>'添加失败,提交参数非法或者服务器故障,跳转中!','returnurl'=>geturl('admin/'.$type)));
				}
			}
			
		}
		if(trim($param['op'])=='edit'){
			if($this->model('item')->op($param)===true){
				if(isset($param['nextsubmit'])){
					$this->widget('note_widget',array('note'=>'编辑成功,跳转中!','returnurl'=>geturl('admin/'.$type.'/add')));
				}else{
					$this->widget('note_widget',array('note'=>'编辑成功,跳转中!','returnurl'=>geturl('admin/'.$type)));
				}
			}else{
				if(isset($param['nextsubmit'])){
					$this->widget('note_widget',array('note'=>'编辑失败,提交参数非法或者服务器故障,跳转中!','returnurl'=>geturl('admin/'.$type.'/add')));
				}else{
					$this->widget('note_widget',array('note'=>'编辑失败,提交参数非法或者服务器故障,跳转中!','returnurl'=>geturl('admin/'.$type)));
				}
			}
			
		}
		
	}



	/*
	异步删除
	*/
	public function del(){
		$message = array();
		$id = $this->input->post('itemid');
		$item = $this->model('item');
		$res = $item->delById($id);
		if($res===true){
			$message['success'] = true;
		}else{
			$message['success'] = false;
			$message['errorMsg'] = 'delete fail;';
		}
		echo json_encode($message);

	}

	//批量移动处理器
	public function moveorderAll(){
		$param = trim($this->input->post('param'),';');
		$items = array();
		$orders = array();
		if($param!=false){
			$paramArr = explode(';',$param);
		}
		foreach ($paramArr as $value) {
			list($items[],$orders[]) = explode(',', $value);
		}
		echo $this->model('item')->moveorderAll(array_combine($items,$orders));
	}

	public function delAll(){
		$param = trim($this->input->post('param'),';');
		$tag = (int)trim($this->input->post('tag'));//1审核0删除
		$paramArr = explode(';',$param);
		echo $this->model('item')->delAll($paramArr,$tag);

	}
	//best,top,hot批量操作
	public function bthAll(){
		$param = trim($this->input->post('param'),';');//where条件
		$tag = (int)trim($this->input->post('tag'));
		$bth = trim($this->input->post('bth'));
		$setArray = array($bth=>$tag);
		$paramArr = explode(';',$param);
		echo $this->model('item')->bthAll($paramArr,$setArray);
	}

	//移动到新的category
	public function movecategoryAll(){
		$param = trim($this->input->post('param'),';');//where条件
		$itemCategory = (int)$this->input->post('itemCategory');
		$paramArr = explode(';',$param);
		echo $this->model('item')->movecategoryAll($paramArr,$itemCategory);
	}
	//列表结果集处理函数，返回频道列的金子塔结构
	public function listHandle($listArray,$type=null){
		if(is_null($type)){
			return $listArray;
		}
		$res = array();
		foreach ($listArray as $v) {
			$v['channel'] = $this->getChannleTower($v['channel'],$type);
			$res[]=$v;
		}
		return $res;
	}
	//得到投放频道的金字塔结构
	private function getChannleTower($channel=null,$type){
		$OkTowerArr = array();
		if(is_null($channel)){
			// exit();
		}
		// $channel='38,nation';
		$channelArr = explode(',',$channel);
		if($type=='news'){
			$channelList = $this->model('category')->getsimplecatlist();
		}elseif($type=='ad'){
			$channelList = $this->model('category')->getsimplecatlistad();
		}
		
		foreach ($channelArr as $vArr) {
			if($vArr=='nation'){
				$OkTowerArr[] = array('全国首页');
				continue;
			}
			if($vArr=='index'){
				$OkTowerArr[] = array('首页频道');
				continue;
			}
			if($vArr=='all'){
				$OkTowerArr[] = array('所有频道');
				continue;
			}
			foreach ($channelList as $vList) {
				if($vList['catid']==$vArr){
					$res = $this->getUpidTool($vList['upid'],$channelList);
					$res[] = $vList['name'];
					$OkTowerArr[]=$res;
				}
			}		
		}
		$OkTowerStr = '';
		foreach ($OkTowerArr as $vTower) {
			$OkTowerStr.=implode('» »',$vTower).'<br />';
		}
		return $OkTowerStr;

	}
	//金字塔辅助函数
	private function getUpidTool($v,$channelList){
		$linkedList = array();
		foreach ($channelList as  $channel) {
			if($channel['catid']==$v){
				$linkedList = array_merge($linkedList,$this->getUpidTool($channel['upid'],$channelList));
				$linkedList[]=$channel['name'];
			}
		}
		return $linkedList;
	}
	//获取后代分类函数
	private function getChildrenCatidByUpid($upid,$type){

		$catidList = $this->model('category')->getsimplelist($type);
		$AllChildren = $this->getChildrenCatidByUpidHandle($upid,$catidList);
		// return array_unique($AllChildren);//验证bug,老版本只搜索父类下面的后代类而父类本身不搜索
		return array_unique(array_merge(array($upid),$AllChildren));
	}
	//获取后代分类辅助函数
	private function getChildrenCatidByUpidHandle($upid,$catidList){
		$childList = array();
		foreach ($catidList as $v) {
			if($v['upid']==$upid){
				$childList[] = $v['catid'];
				$afterHandle = $this->getChildrenCatidByUpidHandle($v['catid'],$catidList);
				$childList = array_merge($childList,$afterHandle);
				
			}
		}
		return $childList;
	}
	
}
?>