<?php
class WurenjiController extends CControl{
	//默认显示一个空白页
	public function index(){
		$this->display('common/blank');
	}
}