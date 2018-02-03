<?php

/**
 * 下载体验
 */
class ExpController extends PortalControl {
    public function index() {
        $this->_show_exp();
    }
	function _show_exp() {
		//获取焦点广告列表
        $admodel = $this->model('Ad');
        $adlist = $this->cache->get('adlist');
        if(empty($adlist)) {
            $param = array('code'=>'headfocus','channel'=>'681','folder'=>2,'limit'=>'0,5');
            $adlist = $admodel->getAdList($param);
            $this->cache->set('adlist',$adlist,30);
        }
        $this->assign('adlist', $adlist);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$this->display('common/exp');
	}
}
?>
