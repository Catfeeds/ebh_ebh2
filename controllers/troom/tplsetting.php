<?php
/**
 * 教师网校模版设置控制器 TplsettingController
 */
class TplsettingController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }
	/*----------------------------- 公告处理开始 -------------------------------------*/
	/**
	*模版设置//对应公告管理（目前取消模版设置功能)
	*/
	public function index() {
		$sendmodel = $this->model('Sendinfo');
		$roominfo = Ebh::app()->room->getcurroom();
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$sendlist = $sendmodel->getSendList($queryarr);
		$count = $sendmodel->getSendCount($queryarr);
		$pagestr = show_page($count);
		$this->assign('sendlist',$sendlist);
		$this->assign('pagestr',$pagestr);
		$this->display('troom/tplsetting_announcement');
	}
	/**
	*删除公告
	*/
	public function delsend() {
		$roominfo = Ebh::app()->room->getcurroom();
		$infoid = $this->input->post('infoid');
		if(is_numeric($infoid) && $infoid > 0) {
			$sendmodel = $this->model('Sendinfo');
			$afrows = $sendmodel->del(array('crid'=>$roominfo['crid'],'infoid'=>$infoid));
			if($afrows > 0) {
				echo 'success';
			} else {
				echo 'fail';
			}
		}
	}
	/**
	* 添加公告
	*/
	public function announcement_add() {
		$message = $this->input->post('message');
		if(NULL !== $message) {	//处理表单
			$roominfo = Ebh::app()->room->getcurroom();
			$param = array('crid'=>$roominfo['crid'],'message'=>$message);
			$sendmodel = $this->model('Sendinfo');
			$infoid = $sendmodel->insert($param);
			if($infoid > 0) {
				echo 'success';
			} else {
				echo 'fail';
			}
		} else {
			$this->display('troom/tplsetting_announcement_add');
		}
	}
	/**
	*修改公告
	*/
	public function announcement_edit() {
		$infoid = $this->input->post('infoid');
		if(NULL !== $infoid) {	//处理表单提交
			$roominfo = Ebh::app()->room->getcurroom();
			$message = $this->input->post('message');
			if(empty($message)) {
				echo 'fail';
				exit();
			}
			$sendmodel = $this->model('Sendinfo');
			$param = array('crid'=>$roominfo['crid'],'infoid'=>$infoid,'message'=>$message);
			$afrows = $sendmodel->update($param);
			if($afrows !== FALSE) {
				echo 'success';
			} else 
				echo 'fail';
		} else {	//显示
			$infoid = $this->uri->uri_attr(0);
			if(is_numeric($infoid) && $infoid > 0) {
				$sendmodel = $this->model('Sendinfo');
				$send = $sendmodel->getSendById($infoid);
				if(!empty($send)) {
					$editor = Ebh::app()->lib('UMEditor');
					$this->assign('send',$send);
					$this->assign('editor',$editor);
					$this->display('troom/tplsetting_announcement_edit');
				}
			}
		}
	}
	/*----------------------------- 公告处理结束 -----------------------------------*/

	/*----------------------------- 师资团队开始 -----------------------------------*/
	public function teacherteam() {
		$roominfo = Ebh::app()->room->getcurroom();
		$rec = $this->input->post();
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['catid'] = 854;
		$teachers = $this->model('item')->getSimpleList($param);
		$teacherCount = $this->model('item')->getSimpleListCount($param);
		$this->assign('teachers',$teachers);
		$this->assign('show_page',show_page($teacherCount));
		if(!empty($param['q'])){
			$this->assign('q',$param['q']);
		}else{
			$this->assign('q','');
		}
		$this->display('troom/tplsetting_teacherteam');
	}
	public function teacherteam_add() {
		if($this->input->post()){
			$rec = safeHtml($this->input->post());
			$this->check_teacherteam($rec);
			$roominfo = Ebh::app()->room->getcurroom();
			$param['subject'] = $rec['subject'];
			$param['note'] = $rec['note'];
			$param['catid'] = 854;
			$param['crid'] = $roominfo['crid'];
			$userinfo = Ebh::app()->user->getloginuser();
			$param['uid'] = $userinfo['uid'];
			$param['thumb'] = $rec['thumb']['upfilepath'];
			if($this->model('item')->_insert($param)===true){
				echo 'success';
				exit;
			}else{
				echo 'fail';
				exit;
			};
		}else{
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->display('troom/tplsetting_teacherteam_add');
		}
		
	}
	public function teacherteam_edit() {
		if($this->input->get('itemid')){
			$teacher = $this->model('item')->getDetailByItemId(intval($this->input->get('itemid')));
			$this->assign('teacher',$teacher);
			$Upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('Upcontrol',$Upcontrol);
			$this->display('troom/tplsetting_teacherteam_edit');
		}else if($this->input->post()){
			$rec = safeHtml($this->input->post());
			$this->check_teacherteam($rec);
			$roominfo = Ebh::app()->room->getcurroom();
			$param['subject'] = $rec['subject'];
			$param['note'] = $rec['note'];
			$param['catid'] = 854;
			$param['crid'] = $roominfo['crid'];
			$userinfo = Ebh::app()->user->getloginuser();
			$param['uid'] = $userinfo['uid'];
			$param['thumb'] = $rec['thumb']['upfilepath'];
			$where = array('itemid'=>intval($rec['itemid']));
			if($this->model('item')->_update($param,$where)===true){
				echo 'success';
			}else{
				echo 'fail';
			};
		}
		
		
	}
	public function teacherteam_del(){
		$itemid = intval($this->input->post('itemid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$teacher = $this->model('item')->getDetailByItemId($itemid);
		if(!empty($teacher['itemid'])&&$teacher['crid']==$roominfo['crid']){
			if($this->model('item')->delById($itemid)!==false){
				echo 'success';
			}else{
				echo 'fali';
			}
		}

	}
	/*--------------------------------师资团队结束----------------------------------------*/

	/*--------------------------------资讯管理开始----------------------------------------*/
	public function information(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
		}
		$param = parsequery();
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$param['catid'] = 686;

		$news = $this->model('item')->getSimpleList($param);
		$newsCount = $this->model('item')->getSimpleListCount($param);
		$this->assign('news',$news);
		$this->assign('show_page',show_page($newsCount));
		if(!empty($param['q'])){
			$this->assign('q',$param['q']);
		}else{
			$this->assign('q','');
		}
		$this->assign('tag',$tag);
		$this->display('troom/tplsetting_information');
	}
	public function information_add(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
		}
		if($this->input->post()){
			$rec = safeHtml($this->input->post(),array('message'));
			$this->check_information($rec);
			$param['subject']=$rec['subject'];
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['note'] = $rec['note'];
			$param['message'] = $rec['message'];
			$param['catid'] = '686';
			$param['channel'] = 702;
			$userinfo = Ebh::app()->user->getloginuser();
			$param['uid'] = $userinfo['uid'];
			$param['folder'] = $rec['folder'];
			$param['dateline'] = time();
			if($this->model('item')->_insert($param)==false){
				echo 'fail';
				exit;
			}else{
				echo 'success';
				exit;
			}
		}
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('tag',$tag);
		$this->display('troom/tplsetting_information_add');
	}

	public function information_edit(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
		}
		if($this->input->get('itemid')){
			$itemid = intval($this->input->get('itemid'));
			$information = $this->model('item')->getDetailByItemId($itemid);
			$roominfo = Ebh::app()->room->getcurroom();
			if($information['crid']==$roominfo['crid']){
				$this->assign('information',$information);
			}else{
				echo '<script>alert("非法操作!")</script>';
				echo '<script>location.href="'.geturl('troom/tplsetting/information').'"</script>';
				exit;
			}
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('tag',$tag);
		$this->display('troom/tplsetting_information_edit');
		exit;
		}
		if($this->input->post()){
			$rec = safeHtml($this->input->post(),array('message'));
			$this->check_information($rec);
			$param['subject']=$rec['subject'];
			$roominfo = Ebh::app()->room->getcurroom();
			$param['crid'] = $roominfo['crid'];
			$param['note'] = $rec['note'];
			$param['message'] = $rec['message'];
			$param['catid'] = '686';
			$userinfo = Ebh::app()->user->getloginuser();
			$param['uid'] = $userinfo['uid'];
			$param['folder'] = $rec['folder'];
			$param['dateline'] = time();
			$where = array('itemid'=>intval($rec['itemid']));
			if($this->model('item')->_update($param,$where)!==false){
				echo 'success';
				exit;
			}else{
				echo 'fail';
				exit;
			}
		}
		
	}
	public function information_del(){
		$itemid = intval($this->input->post('itemid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$information = $this->model('item')->getDetailByItemId($itemid);
		if(!empty($information['itemid'])&&$information['crid']==$roominfo['crid']){
			if($this->model('item')->delById($itemid)!==false){
				echo 'success';
			}else{
				echo 'fali';
			}
		}

	}
	/*--------------------------------资讯管理结束----------------------------------------*/

	/*--------------------------------广告开始----------------------------------------*/
	public function advertisement(){
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
		$this->display('troom/tplsetting_advertisement');
	}
	public function advertisement_add(){
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
			$userinfo = Ebh::app()->user->getloginuser();
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
		$this->display('troom/tplsetting_advertisement_add');
	}
	public function advertisement_edit(){
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
		$this->display('troom/tplsetting_advertisement_edit');
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
			$userinfo = Ebh::app()->user->getloginuser();
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
	public function advertisement_del(){
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
	/*--------------------------------广告结束----------------------------------------*/


	/*--------------------------------联系我们开始----------------------------------------*/
	public function contact(){
		$tag = $this->uri->uri_attr(0);
		if(empty($tag)){
			$tag = 'about';
		}
		$catid = $this->model('category')->getCatidByCode($tag);
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'],'catid'=>$catid);
		$info = $this->model('item')->getOneByParam($param);
		if(empty($info)){
			$this->assign('op','add');
			$info = array('message'=>'');
			$this->assign('info',$info);
		}else{
			$this->assign('op','edit');
			$this->assign('info',$info);
		}
		$this->assign('tag',$tag);
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->display('troom/tplsetting_contact');
		
		
		
	}

	public function contactHandle(){
		$rec = safeHtml($this->input->post(),array('message'));
		$tag = $rec['tag'];
		$param = array();
		$catid = $this->model('category')->getCatidByCode($tag);
		$param['catid'] = $catid;
		if($tag=='about'){
		$param['subject'] = '关于我们';	
		}elseif ($tag=='join'){
			$param['subject'] = '加盟合作';
		}elseif ($tag=='copy'){
			$param['subject'] = '版权说明';
		}elseif ($tag=='payment'){
			$param['subject'] = '付款方式';
		}
		$editor = Ebh::app()->lib('UMEditor');
		$this->assign('editor',$editor);
		$this->assign('tag',$tag);
		
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] = $roominfo['crid'];
		$userinfo = Ebh::app()->user->getloginuser();
		$param['uid'] = $userinfo['uid'];
		$param['message'] = $rec['message'];
		if($rec['op']=='edit'){
			$where = array('itemid'=>$rec['itemid']);
			$oldInfo = $this->model('item')->getOneByParam($param);
			if(empty($oldInfo)){
				echo '非法修改!';
				exit;
			}
			$res = $this->model('item')->_update($param,$where);
			if($res===true){
				$message = array('msg'=>'修改成功!','type'=>'success','title'=>'操作提示');
				echo json_encode($message);
			}else{
				$message = array('msg'=>'修改失败!','type'=>'fail','title'=>'操作提示');
				echo json_encode($message);
			}
		}else{
			$res = $this->model('item')->_insert($param);
			if($res===true){
				$message = array('msg'=>'添加成功!','type'=>'success','title'=>'操作提示');
				echo json_encode($message);
			}else{
				$message = array('msg'=>'添加失败!','type'=>'fail','title'=>'操作提示');
				echo json_encode($message);
			}
		}
		
	}
	/*--------------------------------联系我们结束----------------------------------------*/

	private function check_information($param){
		$message = array();
		$message['code'] = true;
		if(!in_array($param['op'],array('edit','add'))){
			$message['code'] = false;
			$message[] = '操作数被篡改!';
		}
		if(strlen($param['subject'])<2){
			$message['code'] = false;
			$message[] = '资讯标题长度不对!';
		}
		if(!in_array($param['folder'],array(1,0))){
			$message['code'] = false;
			$message[] = '资讯状态被篡改!';
		}
		if(mb_strlen($param['note'])>100||mb_strlen($param['note'])<5){
			$message['code'] = false;
			$message[] = '资讯摘要长度不对!';
		}
		if(empty($param['message'])){
			$message['code'] = false;
			$message[] = '资讯内容长度不对!';
		}
		if($message['code']===false){
			$this->goback(implode('\r\n',$message),geturl('troom/tplsetting/information'));
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
			$this->goback(implode('\r\n',$message),geturl('troom/tplsetting/advertisement'));
		}
	}
	private function check_teacherteam($param){
		$message = array();
		$message['code'] = true;
		if(!in_array($param['op'],array('edit','add'))){
			$message['code'] = false;
			$message[] = '操作数被篡改!';
		}
		if(strlen($param['subject'])<2){
			$message['code'] = false;
			$message[] = '教师姓名长度不对!';
		}
		if(strlen($param['note'])<5||strlen($param['note'])>500){
			$message['code'] = false;
			$message[] = '教师简介长度不对!';
		}
		if($message['code']===false){
			$this->goback(implode('\r\n',$message),geturl('troom/tplsetting/teacherteam'));
		}
	}
	private function goback($message,$returnurl){
		echo $message;
		exit;
	}
}
