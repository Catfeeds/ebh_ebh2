<?php
/**
 * 免费超市首页
 */
class FreeController extends PortalControl {
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		//免费课件显示上部三个
		$itemmodel  = $this->model('Item');
		$itemparam = array('type'=>'ad','code'=>'headfocus','channel'=>'1008','folder'=>2,'displayorder'=>'displayorder','limit'=>'0,8');
		$itemchachekey = $this->cache->getcachekey('item',$itemparam);
		$itemlist = $this->cache->get($itemchachekey);
        if(empty($itemlist)) {
			$itemlist = $itemmodel->getitemlist($itemparam);
			$this->cache->set($itemchachekey,$itemlist,86400);
		}
        $this->assign('itemlist', $itemlist);
		
		//免费课件显示下部16个
		$param = array('type'=>'ad','code'=>'catfocus','folder'=>2,'displayorder'=>'displayorder','limit'=>'0,16');
		$itemcachekey = $this->cache->getcachekey('item',$param);
		$items = $this->cache->get($itemcachekey);
		if(empty($items)) {
			$items = $itemmodel->getitemlist($param);
			$this->cache->set($itemcachekey,$items,86400);
		}
		$this->assign('items', $items);
		$this->display('common/free');
	}
}
?>
