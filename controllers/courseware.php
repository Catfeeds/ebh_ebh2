<?php
/**
 *课件信息对外接口
 */
class CoursewareController extends CControl{
	/**
	*课程详情（课件列表页）
	*/
	public function getSectionByFolderid() {
		$callback = $this->input->get('callback');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = intval($this->input->get('folderid'));
        $subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
        $coursemodel = $this->model('Courseware');
        $queryarr['folderid'] = $folderid;
        $queryarr['uid'] = $user['uid'];
		$queryarr['status'] = 1;
		$queryarr['pagesize'] = 10000000;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
        echo $callback.'('.json_encode($sectionlist).')';
	}
}