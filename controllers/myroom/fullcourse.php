<?php
/**
 * 全科复习控制器类FullcourseController
 * 对于有权限的学校可以显示此全科课程内容，主要可课件学习
 * 如某平台具有高中全科复习模块权限，那会显示高中全科复习学校的课程
 */
class FullcourseController extends CControl {
	private $helpcrid = 10372;
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('roominfo',$roominfo);
		$this->assign('check',$check);
		$moduleid = $this->uri->uri_attr(0);
		if($moduleid != $this->helpcrid) {
			$rpmodel = $this->model('Roompermission');
			$moduleid = $this->uri->uri_attr(0);
			$checkmodule = $rpmodel->checkmodule($roominfo['crid'],$moduleid);
			if(!$check) {
				exit();
			}
		}
    }
    public function index() {
        $moduleid = $this->uri->uri_attr(0);
        if(is_numeric($moduleid) && $moduleid > 0) {

				$foldermodel = $this->model('Folder');
				$queryarr = parsequery();
				$queryarr['crid'] = $moduleid;
				$queryarr['filternum'] = 1;
				$pagesize = 15;
				$queryarr['pagesize'] = $pagesize;
				$folders = $foldermodel->getfolderlist($queryarr);
				$count = $foldermodel->getcount($queryarr);
				$pagestr = show_page($count,$pagesize);
				$this->assign('folders',$folders);
				$this->assign('pagestr',$pagestr);
				$this->assign('moduleid',$moduleid);
                $this->display('myroom/fullcourse');
        }
    }
    /**
     * 全科复习课程
     * 由于list与PHP系统方法冲突，方法名改成lists
     */
    public function lists() {
		$moduleid = $this->uri->uri_attr(0);
        if(is_numeric($moduleid) && $moduleid > 0) {
			$folderid = $this->uri->uri_attr(1);
			$q = $this->input->get('q');
			
				//课程信息
				if(is_numeric($folderid) && $folderid > 0) {
					$foldermodel = $this->model('Folder');
					$folder = $foldermodel->getfolderbyid($folderid);
				}
				if(empty($folder)) {
					$folder = array('folderid'=>0,'foldername'=>'搜索课件');
				}
				$this->assign('folder',$folder);
				//课件信息
				$coursemodel = $this->model('Courseware');
				$queryarr = parsequery();
				$queryarr['folderid'] = $folderid;
				$queryarr['crid'] = $moduleid;
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
				$this->assign('moduleid',$moduleid);
				$this->assign('helpcrid',$this->helpcrid);
				$this->assign('q',$q);
				$this->assign('pagestr',$pagestr);
				$this->display('myroom/fullcourse_list');
		}
    }
	/**
	*全科复习课件详情页
	*/
	public function view() {
		$moduleid = $this->uri->uri_attr(0);
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid))
			exit();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course))
			exit();
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('user',$user);
        $this->assign('course', $course);
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		$examparam = array('cwid'=>$cwid,'crid'=>$moduleid,'limit'=>'0,100');
		$examlist = $exammodel->getexamlistbycwid($examparam);
		$this->assign('examlist',$examlist);
		//获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
		//获取课件下的评论记录
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
		$this->assign('moduleid',$moduleid);
		$this->assign('helpcrid',$this->helpcrid);
		$this->assign('roominfo',$roominfo);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		if($type == 'flv' || empty($course['cwurl'])){
			$this->display('myroom/course');
		}else{
			$this->display('myroom/mycourse_view');
		}
	}
}
