<?php
/**
 * 关于e板会页
 */
class LinkController extends CControl {
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$catemodel = Ebh::app()->model('Category');
		$thecat = $catemodel->getCatlistByUpid(0,2);
		$this->assign('thecat', $thecat);
		$this->display('common/link');
	}
}
?>