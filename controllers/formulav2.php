<?php
/**
*生成公式对应图片
*/
class Formulav2Controller extends CControl{
	public function index(){
		$data = array(
			'data'=>$this->input->post('data'),
			'callback'=>$this->input->get('callback')
		);
		$up_config = Ebh::app()->getConfig()->load('upconfig');
		$iroom_config = $up_config['formula'];
		$post_url = $iroom_config['posturl'];
		$res = do_post($post_url,$data);
		echo $res;
	}
}