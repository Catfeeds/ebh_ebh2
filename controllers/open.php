<?php

/**
 * 开放接口
 */
class OpenController extends CControl {
    public function index() {
		//获取焦点广告列表
        $admodel = $this->model('Ad');
        $adlist = $this->cache->get('adopenlist');
        if(empty($adlist)) {
            $param = array('code'=>'headfocus','channel'=>'698','folder'=>2,'limit'=>'0,5');
            $adlist = $admodel->getAdList($param);
            $this->cache->set('adopenlist',$adlist,30);
        }
        $this->assign('adlist', $adlist);
        $this->display('common/open');
    }
}
?>
