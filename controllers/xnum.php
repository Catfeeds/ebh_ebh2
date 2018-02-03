<?php
/**
 *获取平台教师数，教室数，用户数，资源数(虚假的)
 */
class XnumController extends CControl{
	public function index(){
		$nums = Ebh::app()->lib('xNums')->get();
		$offset = array('teacher'=>500000,'room'=>16000,'user'=>24000000,'resource'=>82000000);
		array_walk($nums, function(&$v,$k) use ($offset){
            array_key_exists($k, $offset) && ($v+=$offset[$k]);
        });
		echo json_encode($nums);
	}

}
?>