<?php
/**
 * 网校学生所有课程控制器 SubjectController
 */
class SubjectController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkstudent();
    }
    public function index() {
		$q = $this->input->get('q');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$foldermodel = $this->model('Folder');
		$queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
		$queryarr['uid'] = $user['uid'];
		$queryarr['filternum'] = 1;
		$queryarr['haschoose'] = 1;
		$folderschoose = $foldermodel->getmemberfolderlist($queryarr);
		$count = $foldermodel->getmemberfoldercount($queryarr); 
		$pagestr = show_page($count);
		$this->assign('folderschoose',$folderschoose);
		$this->assign('pagestr',$pagestr);
		$queryarr['haschoose'] = 0;
		$queryarr['limit'] = '0,100';
		$foldersnochoose = $foldermodel->getmemberfolderlist($queryarr);
		$this->assign('foldersnochoose',$foldersnochoose);
		$q = $this->input->get('q');
		$this->assign('q',$q);
        $this->display('myroom/subject');
    }
	/**
	*学生选课
	*/
	public function choose() {
		$choose = $this->input->post('choose');
		if($choose !== NULL) {	//处理选课表单
			$result = TRUE;
			$folderidlist = $this->input->post('folderid');
			if(!empty($folderidlist)) {
				foreach($folderidlist as $folderid) {
					if(!is_numeric($folderid) || $folderid <= 0) {
						break;
					}
				}
			}
			$user = Ebh::app()->user->getloginuser();
			$roominfo = Ebh::app()->room->getcurroom();
			$favoritemodel = $this->model('Favorite');
			$param = array('crid'=>$roominfo['crid'],'uid'=>$user['uid']);
			$result = $favoritemodel->deleteByCrid($param);
			if($result !== FALSE && !empty($folderidlist)) {
				$arr = array(
					'type'=>3, 
					'crid'=>$roominfo['crid'],
					'uid'=>$user['uid']
				);
				foreach($folderidlist as $folderid) {
					$arr['folderid'] = $folderid;
					$result = $favoritemodel->insert($arr);
					if($result === FALSE)
						break;
				}
			}
			if($result!== FALSE) {
				echo 'success';
			} else {
				echo 'fail';
			}
		} else {
			$user = Ebh::app()->user->getloginuser();
			$roominfo = Ebh::app()->room->getcurroom();
			$foldermodel = $this->model('Folder');
			$queryarr = parsequery();
			$queryarr['crid'] = $roominfo['crid'];
			$queryarr['uid'] = $user['uid'];
			$queryarr['filternum'] = 1;
			$queryarr['limit'] = '0,200';
			$folders = $foldermodel->getmemberfolderlist($queryarr);
			$this->assign('folders',$folders);
			$this->display('myroom/subject_choose');
		}
	}
	/**
	*课程详情
	*/
	public function view() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
        $this->assign('uid', $user['uid']);
        $folderid = $this->uri->itemid;
        $foldermodel = $this->model('Folder');
        $folder = $foldermodel->getfolderbyid($folderid);
        $this->assign('folder', $folder);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 20;
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
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getfolderfavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$this->assign('roominfo',$roominfo);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('q',$q);
        $this->assign('sectionlist', $sectionlist);
        $this->assign('pagestr', $pagestr);
		$this->display('myroom/subject_view');
	}
	

}
