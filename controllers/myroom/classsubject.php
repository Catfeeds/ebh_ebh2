<?php
/**
 * 班级课程控制类
 */
class ClasssubjectController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        
    }
    /**
     * 班级课程
     */
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classsubjectmodel = $this->model('Classsubject');
        $page = $this->uri->page;
        $subjectlist = $classsubjectmodel->getsubjectlistbytid($roominfo['crid'],$user['uid']);
        $this->assign('subjectlist', $subjectlist);
        $this->display('troom/classsubject');
    }
	/**
	*班级课程详情页（课件列表）
	*/
    public function view() {
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		$foldermodel = $this->model('Folder');
        $folder = $foldermodel->getfolderbyid($folderid);
		$folderlevel = $folder['folderlevel'];
		$cridarr = array(10516);
		$needsubfolder = false;
		if(in_array($roominfo['crid'],$cridarr)){
			
			$subfolderlist = $foldermodel->getSubFolder($roominfo['crid'],$folderid);
			$this->assign('subfolderlist',$subfolderlist);
			$tempfolder = $folder;
			$uparr = array();
			$index = 0;
			while($folderlevel>2){
				$tempfolder = $foldermodel->getfolderbyid($tempfolder['upid']);
				$uparr[$index]['foldername']= $tempfolder['foldername'];
				$uparr[$index]['folderid']= $tempfolder['folderid'];
				$index ++ ;
				$folderlevel = $tempfolder['folderlevel'];
			}
			$needsubfolder = true;
			$this->assign('uparr',$uparr);
		}
		$this->assign('needsubfolder',$needsubfolder);
		
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $this->assign('folder', $folder);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
        $this->assign('sectionlist', $sectionlist);
        $this->assign('page', $pagestr);
        $this->display('troom/classsubject_view');
    }
    public function add() {
        
    }
}
