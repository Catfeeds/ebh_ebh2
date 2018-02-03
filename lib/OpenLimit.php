<?php
/**
 * 限制报名人数(课程,课程包)
 */
class OpenLimit{
	/*
	检查开通情况
	*/
	public function checkStatus(&$item){
		if(empty($item['bid']) && empty($item['itemid'])){
			return TRUE;
		}
		$idtype = empty($item['itemid'])?'bid':'itemid';
		$id = $item[$idtype];
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$ocdata['crid'] = $item['crid'];
		$ocdata[$idtype] = $id;
		$ocdata['uid'] = $user['uid'];
		$api = Ebh::app()->getApiServer('ebh');
		$opencount = $api->reSetting()->setService('Classroom.Item.openCount')->addParams($ocdata)->request();
		$item['opencount'] = $opencount['opencount'] > $item['limitnum']?$item['limitnum']:$opencount['opencount'];
		$item['selfcount'] = empty($opencount['selfcount'])?0:$opencount['selfcount'];
		//如果人数达到上限,且曾经未开通,则不能开通
		$cantpay = $item['opencount'] == $item['limitnum'] && empty($item['selfcount']);
		return !$cantpay;
	}
}