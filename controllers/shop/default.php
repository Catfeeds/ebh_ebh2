<?php
/**
 * 网校商城调整页
 */
class DefaultController extends CControl {
	public function index() {
	    $roominfo = Ebh::app()->room->getcurroom();
	    //p($roominfo);
	    if(!empty($roominfo)){
	        $crid = $roominfo['crid'];
	        header("location:http://shop.ebh.net/{$crid}.html");
	    }else{
	        header("location:http://shop.ebh.net");
	    }
	}
}
