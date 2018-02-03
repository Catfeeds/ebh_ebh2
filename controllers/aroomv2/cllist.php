<?php
/*
学校班级列表（查看）
*/
class CllistController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	public function index(){
		$classes = $this->model('classes');
		$roominfo = Ebh::app()->room->getcurroom();
		$classlist = $classes->getroomClassList($roominfo['crid']);
		$teacher = $this->model('teacher');
		$classteacherlist = $teacher->getclassteacherlist($roominfo['crid']);
		
		$class = array();
		//处理班级拥有的教师
		foreach($classteacherlist as $ct){
			if(!empty($class[$ct['classid']]['teacherids'])){
				$class[$ct['classid']]['teacherids'].= ','.$ct['uid'];
				$class[$ct['classid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$class[$ct['classid']]['teacherids'] = $ct['uid'];
				$class[$ct['classid']]['teachers'] = $ct['realname'];
			}
		}
		$tempcount = count($classlist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($class[$classlist[$i]['classid']]['teacherids'])){
				$classlist[$i]['teacherids'] = $class[$classlist[$i]['classid']]['teacherids'];
				$classlist[$i]['teachers'] = $class[$classlist[$i]['classid']]['teachers'];
			}
			else
				$classlist[$i]['teacherids'] = '';
		}
		$this->assign('classlist',$classlist);
		$this->display('aroomv2/cllist');
	}
}
?>