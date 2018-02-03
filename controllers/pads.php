<?php
/**
 *处理广告人气
 */
class PadsController extends CControl{
	public function view(){
		$aid = $this->uri->itemid;
		$url = $this->input->get('redirect');
		if(is_numeric($aid) && empty($url)){
			header("Location:/");
			exit;
		}
		//广告增加人气一个人气
		Ebh::app()->lib('Viewnum')->addViewnum('pads',$aid);
		header("Location:".$url);
	}
}