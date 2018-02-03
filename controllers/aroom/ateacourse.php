<?php
/*
教师课件查看
*/
class AteacourseController extends CControl{
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->user = Ebh::app()->user->getAdminLoginUser();
		$this->assign('user',$this->user);
	}
	public function index(){
		$roominfo = Ebh::app()->room->getcurroom();
		$classroom = $this->model('classroom');
		$roomdetail = $classroom->getdetailclassroom($roominfo['crid']);
		$classes = $this->model('classes');
		$roomdetail['classnum'] = $classes->getroomclasscount($roominfo['crid']);
		$folder = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['folderlevel'] = 1;
		$param['nosubfolder'] = 1;
		$roomdetail['foldernum'] = $folder->getcount($param);
		
		$teacher = $this->model('teacher');
		$roomteacherlist = $teacher->getRoomTeacherListCWCount($roominfo['crid']);
		
		// var_dump($roomteacherlist);
		$this->assign('roomteacherlist',$roomteacherlist);
		$this->assign('roomdetail',$roomdetail);
		$this->display('aroom/ateacourse');
	}
	/*
	课程列表
	*/
	public function course_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$folder = $this->model('folder');
		$param = parsequery();
		$param['pagesize'] = 15;
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $this->uri->itemid;
		$param['folderlevel'] = 1;
		$courselist = $folder->getTeacherFolderList1($param);
		$coursecount = $folder->getTeacherFolderCount($param);
		$this->assign('uid',$param['uid']);
		$this->assign('coursecount',$coursecount);
		$this->assign('courselist',$courselist);
		$this->assign('pagesize',$param['pagesize']);
		$this->display('aroom/ateacourse_courses');
	}
	/*
	课件列表
	*/
	public function course_courselist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$courseware = $this->model('courseware');
		$uid = $this->uri->uri_attr(1);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['folderid'] = $this->uri->uri_attr(0);
		$param['uid'] = $this->uri->uri_attr(1);
		$param['status'] = 1;
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
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$param['folderid']);
		$this->assign('folderid',$param['folderid']);
		$this->assign('search',$param['q']);
		$this->assign('sectionlist', $sectionlist);
		$this->assign('coursecount',$coursecount);
		$this->assign('uid',$uid);
		// var_dump($sectionlist);
		$this->display('aroom/ateacourse_list');
	}
	
	/*
	课件查看
	*/
	public function course_view_view(){
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
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source', $source);
        $this->assign('attachments', $attachments);
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		//收藏信息
		// $favoritemodel = $this->model('Favorite');
		// $fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		// $myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$this->assign('myfavorite',$myfavorite);
		$this->assign('user',$user);
		$this->assign('from',$from);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
        $this->display('aroom/ateacourse_view');
	}
	
	/*
	删除课件
	*/
	public function del(){
		$cwid = $this->input->post('cwid');
        if($cwid == NULL || !is_numeric($cwid)) {
            echo json_encode(array('status'=>-1,'msg'=>'参数非法'));
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
        if(empty($course) || $roominfo['crid'] != $course['crid'] || $roominfo['uid'] != $user['uid']) {
            echo json_encode(array('status'=>-1,'msg'=>'您无权删除此课件'));
            exit();
        }
        $attachmodel = $this->model('Attachment');
        $queryarr = array('cwid'=>$cwid);
        $attachs = $attachmodel->getAttachmentListByCwid($queryarr);
        // $result = $coursemodel->delcourse($cwid);
		$result = $coursemodel->editcourseware(array('cwid'=>$cwid,'status'=>-3));
        if($result) {
            //删除课件附件文件
            // foreach ($attachs as $att) {
                // delfile('attachment',$att['url']);
            // }
            //删除课件文件
            // delfile('course',$course['cwurl']);
            //修改课件数
            $foldermodel = $this->model('Folder');
			$folderid = $course['folderid'];
			$folder = $foldermodel->getfolderbyid($folderid);
			$folderlevel = $folder['folderlevel'];
			while($folderlevel>1){
				$foldermodel->addcoursenum($folderid,-1);
				$folder = $foldermodel->getfolderbyid($folder['upid']);
				$folderlevel = $folder['folderlevel'];
				$folderid = $folder['folderid'];
			}
            
            $roommodel = $this->model('Classroom');
            $roommodel->addcoursenum($roominfo['crid'],-1);
            $teachermodel = $this->model('Teacher');
            $teachermodel->addcoursenum($course['uid'],-1);
            echo json_encode(array('status'=>1,'msg'=>"删除成功"));
        } else {
            echo json_encode(array('status'=>-1,'msg'=>"删除失败，请联系管理员或稍后再试"));
        }
	}
}
?>