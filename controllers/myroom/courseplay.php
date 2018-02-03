<?php
/**
 * 网校学生学习课件详情相关控制器 CourseController
 */
class CourseplayController extends CControl {
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkstudent();
    }
	/**
	*所有课程中搜索课件
	*/
	public function index() {
		$q = $this->input->get('q');
		if(empty($q)) {	//搜索课件
			return;
		}
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
        $this->assign('uid', $user['uid']);
        $folder = array('folderid'=>0,'foldername'=>'搜索课件');
        $this->assign('folder', $folder);
		
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$queryarr['crid'] = $roominfo['crid'];
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
		
		$this->assign('myfavorite','');
		$this->assign('q',$q);
        $this->assign('sectionlist', $sectionlist);
        $this->assign('pagestr', $pagestr);
		$this->display('myroom/subject_view');
	}
	/**
	*课件详情（课件列表页）
	*/
	public function view() {
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$roominfo = Ebh::app()->room->getcurroom();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course))
			exit();
		$user = Ebh::app()->user->getloginuser();
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
        $this->assign('course', $course);
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'limit'=>'0,100');
		$exams = $exammodel->getexamlistbycwid($examparam);
		$this->assign('exams',$exams);
		//获取课件下的附件
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		//添加课件查看数
		$coursemodel->addviewnum($cwid);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('user',$user);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
        $this->display('myroom/courseplay_view');
	}

}