<?php
class Exam {
	/**
	* ���ݽ��ұ�ŷ��ظý����ڵ���ҵ����
	* @param int $crid ���ұ��
	*/
	public function getexamcount($crid){
		$exammodel = Ebh::app()->model('Exam');
		$examcount = $exammodel->getexamcount($crid);
		return $examcount;
	}
}
?>