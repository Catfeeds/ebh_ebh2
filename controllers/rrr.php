<?php
/**
 * redis测试
 */
class RrrController extends CControl {
	
    public function index(){
		$url = "http://www.ebh.net/myroom/rewards/alipay_notify.html";
		$post = array('out_trade_no'=>1111111);
		do_post($url,$post);
    }
}
?>
