<?php
/**
 * roommodule数据更新
 */
class Temp_roommoduleController extends CControl {
	public function index() {
		$rmodel = $this->model('temp_roommodule');
		$list = $rmodel->getlist();
		
		$rmodel->_insert($list);
		
		echo 'ok';
	}
	/*添加一个系统的
	*/
	public function addsystem_view(){
		$moduleid = $this->uri->itemid;
		if(empty($moduleid))
			exit;
		// echo 11;
		$rmodel = $this->model('temp_roommodule');
		$res = $rmodel->addsystem($moduleid);
		echo 'affected_rows:'.$res;
	}
}
