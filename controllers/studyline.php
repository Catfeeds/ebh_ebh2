<?php
class StudylineController extends CControl {
    public function index() {
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$this->_show_stores();
    }
	function _show_stores(){
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//学习大纲左侧菜单列表
		$foldermodel = $this->model('folder');
		$param = array('crid'=>$crid,'upid'=>1,'limit'=>'0,1000');
		$folderlist = $foldermodel->getfolderlist($param);
		$this->assign('folderlist', $folderlist);

		
		$coursemodel = $this->model('courseware');
		//大纲显示目录
		$folderid = $this->uri->itemid;
		$queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		$queryarr['crid'] = $roominfo['crid'];
		
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count);
        $sectionlist = array();
	//print_r($courses);
        if(!empty($courses)){
        	foreach($courses as $course) {
	            if(empty($course['sid'])) {
	                $course['sid'] = 0;
	                $course['sname'] = '其他';
	            }
	            $sectionlist[$course['sid']][] = $course;
        	}
        }
        $this->assign('sectionlist', $sectionlist);

		
		//学习大纲列表显示
		
		$q = $this->input->get('q');
		$itemid = $this->uri->itemid;
		$params = parsequery();
		$params['crid'] = $crid;
		$params['displayorder'] = 'cdisplayorder,cwid desc';
		if(!empty($itemid)){
			$params['folderid'] = $itemid;
		}
		$courselist = $coursemodel->getstudylist($params);
		$this->assign('courselist', $courselist);
		//显示数量
		$coursecount = $coursemodel->getstudycount($params);
		$pagestr = show_page($coursecount);
		$this->assign('coursecount', $coursecount);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo', $roominfo);
		$this->display('shop/stores/studyline');
	}
	function view(){
		$this->_show_stores();
	}
	
}
?>
