<?php

class LoginlimitController extends CControl {
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('crphone', $roominfo['crphone']);
		$this->display('common/loginlimit');
	}
	
	/*
	ip黑名单限制
	*/
	public function blackList_ip(){
		$this->display('common/blacklist_ip');
	}
	/*
	用户黑名单限制
	*/
	public function blackList_user(){
		$this->display('common/blacklist_user');
	}
	
	public function expired(){
		$this->display('common/expired');
	}
}