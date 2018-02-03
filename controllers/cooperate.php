<?php
/**
 *介绍页面控制器
 */
class CooperateController extends CControl{
	var $title;
	public function __construct() {
        parent::__construct();
        $this->title = $this->get_title();	//默认介绍页面的title都从config.php文件中读取
		$this->assign('title', $this->title);
    }
	//qyy网校关闭或过期提示页
	public function index(){
		$user = array();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user',$user);
		$this->display('shop/qyy/cooperate');
	}
}