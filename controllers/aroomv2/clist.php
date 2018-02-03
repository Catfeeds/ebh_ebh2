<?php
/*
学校课程列表
*/
class ClistController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
	}
	
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$courselist = $folder->getfolderlist($param);
		$coursecount = $folder->getcount($param);
		$pagestr = show_page($coursecount);
		$teacher = $this->model('teacher');
		
		$courseteacherlist = $teacher->getcourseteacherlist($roominfo['crid']);
		$course = array();
		//处理课程拥有的教师
		foreach($courseteacherlist as $ct){
			if(!empty($course[$ct['folderid']]['teacherids'])){
				$course[$ct['folderid']]['teacherids'].= ','.$ct['tid'];
				$course[$ct['folderid']]['teachers'].= ','.$ct['realname'];
			}
			else{
				$course[$ct['folderid']]['teacherids'] = $ct['tid'];
				$course[$ct['folderid']]['teachers'] = $ct['realname'];
			}
		}
		
		$tempcount = count($courselist);
		for($i=0;$i<$tempcount;$i++){
			if(!empty($course[$courselist[$i]['folderid']]['teacherids'])){
				$courselist[$i]['teacherids'] = $course[$courselist[$i]['folderid']]['teacherids'];
				$courselist[$i]['teachers'] = $course[$courselist[$i]['folderid']]['teachers'];
			}
			else
				$courselist[$i]['teacherids'] = '';
		}
		$this->assign('room',$roominfo);
		$this->assign('pagestr',$pagestr);
		$this->assign('courselist',$courselist);
		$this->display('aroomv2/clist');
	}
	
}
?>