<?php
/*
*免费试听
*/
class FreedController extends CControl {
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$this->_show_stores();
    }
	function _show_stores(){
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$crid = $roominfo['crid'];
		//学习大纲左侧菜单列表
		$folder = $this->model('folder');
		$param = array('crid'=>$crid,'upid'=>1,'isfree'=>1,'limit'=>'0,1000');
		$folderlist = $folder->getfolderlist($param);
		foreach($folderlist as &$arr){
			$coursewaremodel = $this->model('courseware');
			$folderid = $arr['folderid'];
			$param = array('folderid'=>$folderid,'crid'=>$crid,'isfree'=>1);
			$arr['count'] = $coursewaremodel->getstudycount($param);
		}
		$this->assign('folderlist', $folderlist);
		//学习大纲免费课件列表显示
//		$itemid = $this->uri->itemid;
		$coursemodel = $this->model('courseware');
//		$params = parsequery();
//		if(!empty($itemid)){
//			//$params = array('crid'=>$crid,'folderid'=>$itemid,'isfree'=>1,'displayorder'=>'cdisplayorder,updatedateline desc');
//			$params['crid'] = $crid;
//			$params['folderid'] = $itemid;
//			$params['isfree'] = 1;
//			$params['displayorder'] = 'cdisplayorder,updatedateline desc';
//			$params['pagesize'] = 20;
//		}else{
//			//$params = array('crid'=>$crid,'isfree'=>1,'displayorder'=>'cdisplayorder,updatedateline desc');
//			$params['crid'] = $crid;
//			$params['folderid'] = $itemid;
//			$params['isfree'] = 1;
//			$params['displayorder'] = 'cdisplayorder,updatedateline desc';
//			$params['pagesize'] = 20;
//		}
//		$courselist = $courseware->getstudylist($params);
//		$this->assign('courselist', $courselist);

		$folderid = $this->uri->itemid;
		$queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['isfree'] = 1;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count);
        $sectionlist = array();
	//print_r($courses);
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
        $this->assign('sectionlist', $sectionlist);


		//显示数量
		$coursecount = $coursemodel->getstudycount($queryarr);
		$pagestr = show_page($coursecount,$queryarr['pagesize']);
		$this->assign('coursecount', $coursecount);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->display('shop/stores/freed');
	}
	function view(){
		$this->_show_stores();
	}
}
?>
