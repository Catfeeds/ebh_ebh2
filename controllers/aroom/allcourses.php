<?php
/*
所有课程
*/
class AllcoursesController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getAdminLoginUser();
		$this->assign('user',$this->user);
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$param = parsequery();
		$param['pagesize'] = 15;
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$courselist = $folder->getfolderlist($param);
		// var_dump($courselist);
		$coursecount = $folder->getcount($param);
		
		$pagestr = show_page($coursecount,$param['pagesize']);
		$this->assign('coursecount',$coursecount);
		$this->assign('courselist',$courselist);
		$this->assign('pagestr',$pagestr);
		$this->display('aroom/allcourses');
	}
	public function view(){
		$courseware = $this->model('courseware');
		$folder = $this->model('folder');
		
		$param = parsequery();
		$param['folderid'] = $this->uri->itemid;
		$folderdetail = $folder->getfolderbyid($param['folderid']);
		$param['status'] = 1;
		// var_dump($param);
		$coursewares = $courseware->getFolderSeccourseList($param);
        $coursecount = $courseware->getFolderSeccourseCount($param);
		$sectionlist = array();
        foreach($coursewares as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		$pagestr = show_page($coursecount);
		
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$param['folderid']);
		$this->assign('folderdetail',$folderdetail);
		$this->assign('search',$param['q']);
		$this->assign('sectionlist', $sectionlist);
		$this->assign('pagestr',$pagestr);
		// var_Dump($sectionlist);
		$this->display('aroom/allcourses_list');
	}
	public function course_view(){
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$roominfo = Ebh::app()->room->getcurroom();
		$from = $this->uri->uri_attr(0);	//来源，0或空为全校课程 1 为我的课程 2 为教师课程
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course))
			exit();
		$user = Ebh::app()->user->getAdminLoginUser();
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$this->assign('course', $course);
        $this->assign('source', $source);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//收藏信息
		// $favoritemodel = $this->model('Favorite');
		// $fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		// $myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'limit'=>'0,100');
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamlistbycwid($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		
		$this->assign('exams',$exams);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$this->assign('myfavorite',$myfavorite);
		$this->assign('user',$user);
		$this->assign('from',$from);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
        $this->display('aroom/allcourses_view');
	}
}
?>