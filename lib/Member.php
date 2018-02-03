<?php
/*
前台会员操作
*/
class Member{
	/*
	左侧菜单信息
	*/
	public function getleftinfo($uid){
		$study = Ebh::app()->model('study');
		$leftinfo['study'] = $study->getweeklog($uid);
		$roomuser = Ebh::app()->model('roomuser');
		$leftinfo['room'] = $roomuser->getroomcount($uid);
		$examanswer = Ebh::app()->model('examanswer');
		$leftinfo['answer'] = $examanswer->getanswercount($uid);
		return $leftinfo;
	}
	/*
	分页面顶部菜单
	@param $type string 各控制器名
	*/
	public function getsimplatemenu($type){
		$upid=0;$position=0;$system=1;$visible=1;
		$category = Ebh::app()->model('category');
		if($type=='setting'){
			$upid=32;$position=3;$system=1;
		}elseif($type=="score"){
			$upid=848;$position=3;$system=0;
		}
		return $category->getCatlistByUpid($upid,$position,$system,$visible);
	}
}
?> 