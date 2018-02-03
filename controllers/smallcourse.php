<?php
/**
 * 课程列表课件控制器
 * 用于default等模版下，点击课程后显示课件列表
 */
class SmallcourseController extends CControl {
	/**
	* 课程详情（显示课件列表)
	* smallcourse-0-0-0-folderid 方式显示
	*/
	public function index() {
		$folderid = $this->uri->uri_attr(0);
		if(is_numeric($folderid) && $folderid > 0) {
			$this->_show_folder($folderid);
		}
	}
	/**
	*课程详情（显示课件列表)
	* smallcourse/folderid 方式显示
	*/
	public function view() {
		$folderid = $this->uri->itemid;
		$this->_show_folder($folderid);
	}
	/**
	* 根据课程编号显示课件列表
	* @param int $folder 课程编号
	*/
	private function _show_folder($folderid) {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
        $this->assign('uid', $user['uid']);
        $foldermodel = $this->model('Folder');
        $folder = $foldermodel->getfolderbyid($folderid);
        $this->assign('folder', $folder);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 14;
		$queryarr['pagesize'] = $pagesize;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count,$pagesize);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		//收藏信息
        $this->assign('sectionlist', $sectionlist);
        $this->assign('pagestr', $pagestr);
		$this->display('common/smallcourse');
	}
}
?>