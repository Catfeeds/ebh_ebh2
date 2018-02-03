<?php 
class Items {
	public function getItems(){
//		$roominfo = Ebh::app()->room->getcurroom();
//		$crid = $roominfo['crid'];
		$itemmodel = Ebh::app()->model('Item');
		$param = array('crid'=>$crid,'catid'=>256,'displayorder'=>'displayorder','limit'=>'0,1');
		$item = $itemmodel->getadit($param);
		return $item;
	}

	/**
	*公共底部查询(友情链接)
	*/
	public function getitemslink(){
		$itemmodel = Ebh::app()->model('Item');
		$type = 'link';
		$itemfooter = $itemmodel->getitemslink($type);
		return $itemfooter;
	}
	/*
	*取stores头部图片
	*/
	public function getItemdetail(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$itemmodel = Ebh::app()->model('Item');
		$param = array('crid'=>$crid,'catid'=>256,'displayorder'=>'displayorder','limit'=>'0,1');
		$item = $itemmodel->getOneByParam($param);
		return $item;
	}

} 

?>