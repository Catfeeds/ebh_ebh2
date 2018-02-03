<?php
/**
 *头像修复工具
 *ZKQ 2104/11/25
 *使用方法
 *用老师账号登录网站,再访问以下网址即可
 *http://www.ebanhui.com/facetool.html?islog=1&uid=13192 修复uid为13192的用户的头像(显示修复详情)
 *http://www.ebanhui.com/facetool.html?islog=1    修复所有用户的头像(显示修复详情)
 *
 *http://www.ebanhui.com/facetool.html?&uid=13192 修复uid为13192的用户的头像(不显示修复详情)
 *http://www.ebanhui.com/facetool.html    修复所有用户的头像(不显示修复详情)
 */
class FacetoolController extends CControl{
	/**
	 *修复工具入口
	 */
	public function index(){
		//权限检测
		$this->_checkPower();
		//初始化操作
		$this->_init();
		//修复开始
		$this->_go();
	}
	/**
	 *初始化必须参数
	 */
	private function _init(){
		set_time_limit(0);
		EBH::app()->helper('image');
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$this->savepath = $_UP['avatar']['savepath'];
		$this->showpath = $_UP['avatar']['showpath'];
		$this->page = 1;
		$this->pagesize = 10;
		//头像尺寸
		$this->faceSize = array(
			'120_120',
			'100_100',
			'78_78',
			'50_50',
			'40_40'
		);
		$this->message = array(
			'notfind'=>'原图不存在',
			'fixok'=>'修复成功',
			'notfixed'=>'无需修复'
		);

		foreach ($this->message as $status=>$mes) {
			$this->$status = 0;
		}
		$this->islog = $this->input->get('islog');
		$this->uid = $this->input->get('uid');
		$this->uid = intval($this->uid);

	}
	/**
	 *获取没有头像的用户的数据信息
	 */
	private function _getUser($pagesize = 10){
		$userModel = $this->model('user');
		$offset = ($this->page-1)*$pagesize;
		$limit = $offset.','.$pagesize;
		$param = array(
			'limit'=>$limit,
			'uid'=>$this->uid
		);
		$this->page+=1;
		return $userModel->getUserListWithFace($param);
	}
	/**
	 *修复工具选择器
	 */
	private function _go(){
		echo '修复开始!','<br />';
		if(empty($this->islog)){
			echo '修复中,请耐心等待...','<br />';
		}
		if(!empty($this->uid)){
			$this->_start_by_uid();
		}else{
			$this->_start();
		}
		echo '修复完成!','<br />';
		echo $this->getTotal();
	}
	/**
	 *修复启动...(全扫描)
	 */
	private function _start(){
		while( $users = $this->_getUser($this->pagesize) ){
			if(empty($users)){
				break;
			}
			$this->_check($users);
		}
	}

	/**
	 *修复启动...(扫描指定uid)
	 */
	private function _start_by_uid(){
		if( $users = $this->_getUser($this->pagesize) ){
			if(empty($users)){
				return;
			}
			$this->_check($users);
		}
		
	}
	/**
	 *修复检测...
	 */
	private function _check($users){
		foreach ($users as $user) {
			$faceFiles = $this->_getFacePath($user['face']);
			$res = $this->_pack($faceFiles);
			$this->_log($res,$user);
		}
	}
	/**
	 *修复中...
	 */
	private function _pack($faceFiles = array()){
		$ooFace = $faceFiles['oo'];
		if(!is_file($ooFace)){
			$this->fail+=1;
			return 'notfind';
		}
		$isok = false;
		foreach ($faceFiles as $fkey=>$faceFile) {
			if(!is_file($faceFile)){
				if(thumb($ooFace,$fkey) == ''){
					copyimg($ooFace,$fkey);
				}
				$isok = true;
			}
		}
		if($isok==false){
			return 'notfixed';
		}else{
			return 'fixok';
		}
		
	}
	/**
	 *获取用户头像实际路径数组
	 */
	private function _getFacePath($face){
		$faceArr = array();
		$faceArr['oo'] = $face = str_replace($this->showpath, $this->savepath, $face);
		foreach ($this->faceSize as $size) {
			$faceArr[$size] = getthumb($face,$size);
		}
		return $faceArr;
	}

	/**
	 *修复数据记录
	 */
	private function _log($status='notfind',$user){
		$this->$status+=1;
		if(empty($this->islog)){
			return;
		}
		echo $user['username'],'=====',$user['uid'],'=====',$this->message[$status],'<br />';
	}

	/**
	 *权限检测
	 */
	private function _checkPower(){
		 $user = Ebh::app()->user->getloginuser();
		 if( !empty($user['groupid']) && ($user['groupid'] == 5) ){
		 	return true;
		 }
		 exit('权限不足');
	}

	/**
	 *打印统计信息
	 */
	private function getTotal(){
		$totalInfo = array();
		foreach ($this->message as $status=>$msg) {
			$totalInfo[] = $msg.':'.$this->$status;
		}
		return implode(str_repeat('&nbsp;', 10), $totalInfo);
	}
}