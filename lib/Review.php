<?php
class Review {
	/**
	* ��ʾ��������
	*/
	public function getcoureview(){
		$roominfo = Ebh::app()->room->getcurroom();
		$crid = $roominfo['crid'];
		$uid = $roominfo['uid'];
		$reviewmodel = Ebh::app()->model('review');//�ҵ�����
		$param = array('uid'=>$uid,'toid'=>$crid,'opid'=>8192,'type'=>'cloudscore');
		$rescourse = $reviewmodel->getReviewScore($param);
		return $rescourse;
	}
}
?>