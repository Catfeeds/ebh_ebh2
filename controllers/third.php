<?php
/*
*��������������ҳ
*/
class ThirdController extends CControl {
    public function index() {
		$url = $this->input->get('url');
		if(!empty($url)) {
			$this->assign('url',$url);
			$this->display('common/third');
		}
	}
}
?>
