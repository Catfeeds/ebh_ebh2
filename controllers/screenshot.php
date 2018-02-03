<?php
/*
听课反馈
*/
class ScreenshotController extends CControl{

	public function view(){
		$imgSrc = $this->input->get('imgsrc');
		$upconfig = Ebh::app()->getConfig()->load('upconfig');
	    $this->assign('uppicapi',$upconfig['pic']['server'][0]);
		$this->assign('imgsrc', $imgSrc);
		$this->display('common/screenshot');
	}
}
?>