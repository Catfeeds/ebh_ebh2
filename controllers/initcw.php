<?php
class InitcwController extends CControl{
	public function index(){
		set_time_limit(0);
		$initcwmodel = $this->model('initcw');
		$crs = $initcwmodel->getcrs();
		
		foreach($crs as $cr){
			$initcwmodel->updatedisplayorder($cr['crid']);
			// exit;
		}
		debug_info();
	}
	public function folder(){
		set_time_limit(0);
		$initcwmodel = $this->model('initcw');
		$crs = $initcwmodel->getcrsfolder();
		
		foreach($crs as $cr){
			$initcwmodel->updatedisplayorderfolder($cr['crid']);
			// exit;
		}
		debug_info();
	}
}
?>