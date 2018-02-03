<?php 
class Sendinfo {
		/**
		*获取公告信息
		**/
	public function getSendinfo(){
		$roominfo = Ebh::app()->room->getcurroom();
		$toid = $roominfo['crid'];
		$type = 'announcement';
		$sendinfomodel = Ebh::app()->model('Sendinfo');
		$send = $sendinfomodel->getsend($toid,$type);
		return $send;

	}
} 

?>