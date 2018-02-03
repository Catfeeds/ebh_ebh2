<?php
/**
 * 通知管理控制器
 */
class NotifyController extends CControl{
	public function __construct()
	{
		parent::__construct();
		Ebh::app()->room->checkteacher();
	}

	/**
	 * 显示模块
	 */
	public function index()
	{
		$this->display('troomv2/notify');
	}

}