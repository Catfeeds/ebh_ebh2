<?php
/*
*联系方式
*/
class ContactsController extends CControl {
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
		}
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$param = array('crid'=>$roominfo['crid'] ,'code'=>'headfocus','folder'=>2,'limit'=>'0,5');
		$roomadkey = $this->cache->getcachekey('ad',$param);
		$adlist = $this->cache->get($roomadkey);

        //客服浮窗
        $kefu=array();
        if($roominfo['kefuqq']!=0){
            $kefu['kefu'] = explode(',',$roominfo['kefu']);
            $kefu['kefuqq'] = explode(',',$roominfo['kefuqq']);
        }
        if(!empty($roominfo['crphone'])){
            $phone = array();
            $phone = explode(',',$roominfo['crphone']);
            $this->assign('phone',$phone);
        }

        $this->assign('kefu',$kefu);
		if(empty($adlist)) {
			$admodel = $this->model('Ad');        
			$adlist = $admodel->getAdList($param);
			$this->cache->set($roomadkey,$adlist,600);
		}
		$this->assign('adlist', $adlist);
		if($roominfo['template']=='zwx'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/zwx/contacts');

		}else if($roominfo['template']=='stores'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/stores/contacts');
		}else if($roominfo['template']=='mainschool'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/mainschool/contacts');
		}elseif($roominfo['template']=='scb'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/scb/contacts');
		}elseif($roominfo['template']=='hnm'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/hnm/contacts');
		}elseif($roominfo['template']=='qjb'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/qjb/contacts');
		}elseif($roominfo['template']=='one'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/one/contacts');
		}elseif($roominfo['template']=='zhh'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/zhh/contacts');
		}elseif($roominfo['template']=='zho'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/zho/contacts');
		}elseif($roominfo['template']=='drag'){
			$roominfo = Ebh::app()->room->getcurroom();
			$this->assign('room', $roominfo);
			$this->display('shop/drag/contacts');
		}elseif($roominfo['template'] == 'plate') {
			Ebh::app()->runAction('room/portfolio', 'contacts');
		}
	}
	//关于我们
	function about(){
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
		}
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		$about = $this->model('item');
		$param = array('crid'=>$crid,'catid'=>872,'displayorder'=>'i.itemid desc','limit'=>'0,1');
		$conabout = $about->getadit($param);
		$this->assign('conabout', $conabout);
		$this->display('shop/stores/about');
	}
	//付款方式
	function payment(){
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
		}
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		$payment = $this->model('item');
		$param = array('crid'=>$crid,'catid'=>875,'displayorder'=>'i.itemid desc','limit'=>'0,1');
		$conpayment = $payment->getadit($param);
		$this->assign('conpayment', $conpayment);

		$paycllist = $this->model('classroom');
		$conpaylist = $paycllist->getdetailclassroom($crid);
		$this->assign('conpaylist', $conpaylist);
		$this->display('shop/stores/payment');
	}
	//加盟合作
	function join(){
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
		}
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		$itemmodel = $this->model('item');
		$param = array('crid'=>$crid,'catid'=>221,'displayorder'=>'i.itemid desc','limit'=>'0,1');
		$conjoin = $itemmodel->getadit($param);
		$this->assign('conjoin', $conjoin);
		$this->display('shop/stores/join');
	}
	//版权说明
	function copy(){
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$roominfo = Ebh::app()->room->getcurroom();
		if (empty($roominfo)) {
			header("Location: http://www.ebh.net");
			exit();
		}
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		$copy = $this->model('item');
		$param = array('crid'=>$crid,'catid'=>874,'displayorder'=>'i.itemid desc','limit'=>'0,1');
		$concopy = $copy->getadit($param);
		$this->assign('concopy', $concopy);
		$this->display('shop/stores/copy');
	}
}
?>
