<?php
class Review {
	/**
	* 显示积分数据
	*/
	public function getcoureview(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$uid = $roominfo['uid'];
		$reviewmodel = Ebh::app()->model('review');//我的评分
		$param = array('uid'=>$uid,'toid'=>$crid,'opid'=>8192,'type'=>'cloudscore');
		$rescourse = $reviewmodel->getReviewScore($param);
		return $rescourse;
	}
}
?>