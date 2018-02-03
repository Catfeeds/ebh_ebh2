<?php
/**
 * sns相关操作
 */
class SnsController extends CControl {
	public function index() {
		echo 'usage:/sns/initroom.html /sns/initroomuser.html /sns/initclassuser.html';	
	}
	/**
	*初始化网校信息缓存
	*/
	public function initroom() {
		set_time_limit(0);
		$snslib = Ebh::app()->lib('Sns');
		$snslib->initRoominfoCache();
		debug_info();
	}
	/**
	*初始化网校学生列表缓存
	*/
	public function initroomuser() {
		set_time_limit(0);
		$snslib = Ebh::app()->lib('Sns');
		$snslib->initRoomUserCache();
		debug_info();
	}
	/**
	*初始哈网校班级学生列表缓存
	*/
	public function initclassuser() {
		set_time_limit(0);
		$snslib = Ebh::app()->lib('Sns');
		$snslib->initClassuserCache();
		debug_info();
	}
	
	public function getroom(){
		$snslib = Ebh::app()->lib('Sns');
		$snslib->getRoomcache();
	}
}
?>