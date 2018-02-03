<?php
/**
 * 关于e板会页
 */
class AboutusController extends CControl {
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$catemodel = Ebh::app()->model('Category');
		$thecat = $catemodel->getCatlistByUpid(0,2);
		$this->assign('thecat', $thecat);
		$itemmodel = $this->model('item');
		$param = array('catid'=>$thecat[0]['catid'],'type'=>'news','displayorder'=>'c.displayorder','limit'=>'0,1');
		$itemsite = $itemmodel->getadit($param);
		$this->assign('itemsite', $itemsite);
		$this->display('common/siteinfo');
	}
}
?>