<?php
/**
 *获取指定尺寸的图片中转控制器
 */
class ImghandlerController extends CControl{
	public function index(){
		$size = $this->input->post('size');
		$type = $this->input->post('type');
		$cwid = $this->input->post('cwid');
		$data = array(
			'size'=>$size,
			'type'=>$type,
			'cwid'=>$cwid
		);
		$res = do_post('http://up.ebh.net/imghandler.html',$data);
		echo $res;
	}
}