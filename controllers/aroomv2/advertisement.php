<?php
/*
广告管理
*/
class AdvertisementController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getloginuser();
		$this->assign('user',$this->user);
	}
	
	public function index(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
			$param = parsequery();
			$param['in'] = "(256,258)";
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$ads = $this->model('item')->getSimpleList($param);
			$adsCount = $this->model('item')->getSimpleListCount($param);
			$this->assign('show_page',show_page($adsCount));
			$this->assign('ads',$ads);

		}
		$this->assign('tag',$tag);
		$this->display('aroomv2/advertisement');
	}
	public function add(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
		}
		if($this->input->post()){
			$rec = safeHtml($this->input->post(),array('message'));
			$this->check_advertisement($rec);
			$param['subject']=$rec['subject'];
		
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['catid'] = $rec['catid'];
			$param['itemurl'] = $rec['itemurl'];
			$param['channel'] = 702;
			if ($param['itemurl'] == ''){
				$param['itemurl'] = '#';
			}elseif(strpos($param['itemurl'],'javascript:') !== false){
				$param['itemurl'] = '';
			}else{
			$regexurl='/^.*?\.com\//';
			$itemurl = preg_replace($regexurl, "", $param['itemurl']);
			}

			$param['folder'] = $rec['folder'];
			$userinfo = Ebh::app()->user->getAdminLoginUser();
			$param['uid'] = $userinfo['uid'];
			$param['thumb'] = $rec['thumb']['upfilepath'];
			if($this->model('item')->_insert($param)===true){
				echo 'success';exit;
			}else{
				echo 'fail';exit;
			}
		}
		$Upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('Upcontrol',$Upcontrol);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('tag',$tag);
		$this->display('aroomv2/advertisement_add');
	}

	public function edit(){
		if($this->input->get('itemid')){
			$itemid = intval($this->input->get('itemid'));
			$ad = $this->model('item')->getDetailByItemId($itemid);
			$roominfo = Ebh::app()->room->getcurroom();
			if($ad['crid']==$roominfo['crid']){
				$this->assign('ad',$ad);
			}else{
				echo 'fail';exit;
			}
		$Upcontrol = Ebh::app()->lib('UpcontrolLib');
		$this->assign('Upcontrol',$Upcontrol);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->display('aroomv2/advertisement_edit');
		exit;
		}
		if($this->input->post()){
			$rec = safeHtml($this->input->post(),array('message'));
			$this->check_advertisement($rec);
			$param['subject']=$rec['subject'];
		
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['catid'] = $rec['catid'];
			$param['itemurl'] = $rec['itemurl'];
			if ($param['itemurl'] == ''){
				$param['itemurl'] = '#';
			}elseif(strpos($param['itemurl'],'javascript:') !== false){
				$param['itemurl'] = '';
			}else{
			$regexurl='/^.*?\.com\//';
			$itemurl = preg_replace($regexurl, "", $param['itemurl']);
			}

			$param['folder'] = $rec['folder'];
			$userinfo = Ebh::app()->user->getAdminLoginUser();
			$param['uid'] = $userinfo['uid'];
			$param['thumb'] = $rec['thumb']['upfilepath'];
			$where = array('itemid'=>intval($rec['itemid']));
			if($this->model('item')->_update($param,$where)!==false){
				echo 'success';exit;
			}else{
				echo 'fail';exit;
			}
		}
		
	}
	
	public function del(){
		$itemid = intval($this->input->post('itemid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$advertisement = $this->model('item')->getDetailByItemId($itemid);
		if(!empty($advertisement['itemid'])&&$advertisement['crid']==$roominfo['crid']){
			if($this->model('item')->delById($itemid)!==false){
				echo 'success';
			}else{
				echo 'fali';
			}
		}

	}
	
	private function check_advertisement($param){
		$message = array();
		$message['code'] = true;
		if(!in_array($param['op'],array('edit','add'))){
			$message['code'] = false;
			$message[] = '操作数被篡改!';
		}
		if(strlen($param['subject'])<2){
			$message['code'] = false;
			$message[] = '广告标题长度不对!';
		}
		if(!in_array($param['catid'],array(256,258))){
			$message['code'] = false;
			$message[] = '广告分类被篡改或者没有选择!';
		}
		if(!in_array($param['folder'],array(1,2))){
			$message['code'] = false;
			$message[] = '广告状态被篡改!';
		}

		if($message['code']===false){
			$this->goback(implode('\r\n',$message),geturl('aroom/datasetting/advertisement'));
		}
	}
}
?>