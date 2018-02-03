<?php
/**
 *门户首页控制器
 */
EBH::app()->helper('portal');
class DefaultController extends PortalControl{
    //老版本首页
	public function old_index(){
		$this->_checkOtherBind();
		$this->_checkOtherUrl();
        $this->_getBestRoom();
        $this->_getXNums();
  	    $this->display('portal/index');
	}
	//新版本首页
    public function index(){
        $this->_checkOtherBind();
        $this->_checkOtherUrl();
        $this->display('portal/newindex');
    }

  //首页底部推荐广告
  private function _getBestRoom(){
    $param = parsequery();
    $param['code'] = 'portal_bestschool';
    $param['status'] = 1;
    $padsModel = $this->model('pads');
    $roomlists = $padsModel->getAds($param);
    $this->assign('roomlists',$roomlists);
  }
  //分配各种类型数据的数量
  private function _getXNums(){
    $xnums = Ebh::app()->lib('xNums')->get();
    $offset = array('teacher'=>500000,'room'=>16000,'user'=>24000000,'resource'=>82000000);
    array_walk($xnums, function(&$v,$k) use ($offset){
        array_key_exists($k, $offset) && ($v+=$offset[$k]);
    });
    $this->assign('nums',$xnums);
  }
  //检测外部域名链接，一般通过别名方式过来的
  private function _checkOtherUrl() {
	  $domainlist = array('51weiti.com'=>'http://wtxx.ebh.net/');
	  $curdomain = $this->uri->curdomain;
	  if(isset($domainlist[$curdomain])) {
		$jumpurl = $domainlist[$curdomain];
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $jumpurl");
		exit();
	  }
  }
  //检测其他域名非法绑定
  private function _checkOtherBind() {
	$curdomain = $this->uri->curdomain;
	if(!in_array($curdomain,array('ebh.net','ebanhui.com'))) {
		header("HTTP/1.1 403 Forbidden");
		$msg = '<html><head><title>403 Forbidden</title></head><body bgcolor="white"><center><h1>403 Forbidden</h1></center><hr><center>ebh.server/2.0</center></body></html>';
		echo $msg;
		exit();
	}
  }
}