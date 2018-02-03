<?php
class Exam {
	/**
	* 根据教室编号返回该教室内的作业总数
	* @param int $crid 教室编号
	*/
	public function getexamcount($crid){
		$exammodel = Ebh::app()->model('Exam');
		$examcount = $exammodel->getexamcount($crid);
		return $examcount;
	}
}
?>