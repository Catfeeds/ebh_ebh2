<?php
/**
 * e板会用户服务条款
 */
class AgreementController extends CControl {
	function index() {
		$codepath = $this->uri->path;
		if($codepath == 'agreement'){
			$this->agreement();
		}elseif($codepath == 'agreement/payment'){
			$this->payment();
		}
	}
	//e板会服务条款
	public function agreement(){
		$roominfo = Ebh::app()->room->getcurroom();
		$itemmodel = $this->model('item');
		$param = array('catid'=>231,'type'=>'news','displayorder'=>'c.displayorder','limit'=>'0,1');
		$itemsite = $itemmodel->getadit($param);
		$this->assign('itemsite', $itemsite);
		$this->display('common/agreement');
	}
	//e板会支付条款
	public function payment(){
		$roominfo = Ebh::app()->room->getcurroom();
		$itemmodel = $this->model('item');
		$param = array('catid'=>1060,'type'=>'news','displayorder'=>'c.displayorder','limit'=>'0,1');
		$itemsite = $itemmodel->getadit($param);
		$this->assign('itemsite', $itemsite);
		$this->display('common/agreement');
	}
}
?>