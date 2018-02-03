<?php

/**
 * 帮助中心列表页
 */

class HelpController extends CControl {
    public function index() {
        $this->_show_help();
    }
	function _show_help() {
		//帮助中心热点问题
		$itemmodel = Ebh::app()->model('item');
		$in = 'c.catid in(691,692,693,694,695,789,790,791,792,793,794,795,796,797,798,799,800,801,802,804,805,806,807,808,809,810,861,862,863,864,883,884,931,932,811,812,813,814,815,816,817,818,819,820,821,822,823,824,825,826,827,836,828,837,829,838,830,839)';
		$param = array('type'=>'news','in'=>$in,'ischild'=>1,'hot'=>1,'displayorder'=>'displayorder,itemid desc','limit'=>'0,10');
		$itemkey = $this->cache->getcachekey('item',$param);
		$itemlist = $this->cache->get($itemkey);
		if(empty($itemlist)) {
			$itemlist = $itemmodel->getitemlist($param);
			$this->cache->set($itemkey,$itemlist,86400);	
		}
		$this->assign('itemlist', $itemlist);
		$this->display('common/help');
	}
	function view(){
		$param['itemid'] = $this->uri->itemid;
		$helpmodel = Ebh::app()->model('help');
		$itemdetail = $helpmodel->getitembyid($param);
		$this->assign('itemdetail', $itemdetail);
		$this->display('common/help_view');
	}
}
?>
