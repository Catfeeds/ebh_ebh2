<?php
/**
 * test 
 */
class T1Controller extends CControl {
	public function index() {
		echo "test";
	}
	public function s() {
		$roomcache = Ebh::app()->lib('Roomcache');
		$crid = 11;
		$roomdetail = array('crid'=>$crid,'crname'=>'testroom');
		$roomcache->setCache($crid,'roominfo','detail',$roomdetail,0,TRUE);	//后台自动更新还待观察
	}
	public function g() {
		$roomcache = Ebh::app()->lib('Roomcache');
		$crid = 11;
		$room = $roomcache->getCache($crid,'roominfo','detail');
		var_dump($room);
	}
	public function r() {
		$roomcache = Ebh::app()->lib('Roomcache');
		$crid = 11;
		$roomcache->removeCache($crid,'roominfo','detail');
	}
	public function rs() {
		$roomcache = Ebh::app()->lib('Roomcache');
		$crid = 11;
		$roomcache->removeCaches($crid,'roominfo');
		echo "success";
	}
}