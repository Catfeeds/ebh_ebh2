<?php 
class Sendinfo {
		/**
		*��ȡ������Ϣ
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