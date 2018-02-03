<?php

/**
 * 网校后台教师管理控制器类 TeacherController
 */
class TeacherController extends CControl {

    private $tuser = NULL;

    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }

    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $rtmodel = $this->model('Roomteacher');
        $queryarr = parsequery();
        $q = $this->input->get('q');
        $queryarr['crid'] = $roominfo['crid'];
        $teachers = $rtmodel->getroomteacherlist($queryarr, TRUE);
        $count = $rtmodel->getroomteachercount($queryarr);
        $pagestr = show_page($count);
        $this->assign('teachers', $teachers);
        $this->assign('pagestr', $pagestr);
        $this->assign('q', $q);
        $this->assign('roominfo', $roominfo);
        $this->display('troom/teacher');
    }

    /**
     * 修改教室下教师信息/锁定/解锁/删除
     * @return boolean
     */
    public function upinfo() {
        $tid = $this->input->post('tid');
        $result = array('status' => 0);
        if ($tid !== NULL && is_numeric($tid)) {
            $roominfo = Ebh::app()->room->getcurroom();
            //判断权限
            if ($tid == $roominfo['uid'])    //所有者不允许被修改锁定
                return FALSE;
            if ($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7)    //学校教师后台不具备直接修改教师信息功能
                return FALSE;
            $roommodel = $this->model('Classroom');
            $checktea = $roommodel->checkteacher($tid, $roominfo['crid']);
            if ($checktea == -1) {   //不在此平台无权限
                return FALSE;
            }

            $rtmodel = $this->model('Roomteacher');
            $status = $this->input->post('status');
            if ($status !== NULL && is_numeric($status)) {  //修改状态
                $rtparam = array('crid' => $roominfo['crid'], 'tid' => $tid, 'status' => $status);
                $afrows = $rtmodel->update($rtparam);
                if ($afrows !== FALSE) {
                    $result['status'] = 1;
                    $result['msg'] = '修改成功';
                    echo json_encode($result);
                    exit();
                }
            }
            $type = $this->input->post('type');
            if ($type == 'del') {    //删除教师
                $rtparam = array('crid' => $roominfo['crid'], 'tid' => $tid);
                $afrows = $rtmodel->del($rtparam);
                if ($afrows !== FALSE) {
                    $result['status'] = 1;
                    $result['msg'] = '删除成功';
                    echo json_encode($result);
                    exit();
                }
            }
        }
    }

    /**
     * 添加教师
     */
    public function add() {
        $roominfo = Ebh::app()->room->getcurroom();
        $tname = $this->input->post('tname');
        if ($tname !== NULL) {   //表单提交
            $this->_addteacher();
        } else {
            $foldermodel = $this->model('Folder');
            $folderparam = array('crid' => $roominfo['crid']);
            $folders = $foldermodel->getfolderlist($folderparam);
            $this->assign('folders', $folders);
            $modulelist = $this->_getmodules();
            $this->assign('modulelist', $modulelist);
            $this->display('troom/teacher_add');
        }
    }

    /**
     * 处理添加教师表单
     */
    private function _addteacher() {
        $roominfo = Ebh::app()->room->getcurroom();
        $tname = $this->input->post('tname');   //教师username
        if (!empty($tname)) {
            $code = $this->_checkname($tname);
        } else {
            $code = -1;
        }
        $status = 0;
        $message = '';
        if ($code == 0 || $code == 1) {   //0表示教师账号已存在，只需添加关联关系 1表示教师账号不存在，需要添加教师账号
            $uid = 0;
            if ($code == 1) {    //账号未存在时，先添加教师账号
                $realname = $this->input->post('realname'); //教师真实姓名
                $pwd = $this->input->post('pwd');   //密码
                $confirmpwd = $this->input->post('confirmpwd'); //确认密码
                if ($pwd != $confirmpwd) {
                    $message = '两次密码不同，请重新确认';
                    $result = array('status' => $status, 'message' => $message);
                    echo json_encode($result);
                    exit();
                }
                $param = array('username' => $tname, 'realname' => $realname, 'password' => $pwd);
                $teachermodel = $this->model('Teacher');
                $uid = $teachermodel->addteacher($param);
            } else {
                if (!empty($this->tuser))
                    $uid = $this->tuser['uid'];
            }
            if ($uid > 0) {
                $rtparam = array('crid' => $roominfo['crid'], 'tid' => $uid, 'status' => 1, 'role' => 1);
                $rtmodel = $this->model('Roomteacher');
                $afrows = $rtmodel->insert($rtparam);
                if ($afrows !== FALSE) {   //插入成功后添加教室的教师数量 //添加教师对应权限
                    $status = 1;
                    $roommodel = $this->model('Classroom');
                    $roommodel->addteanum($roominfo['crid']);
                    $modules = $this->input->post('module');    //有权限的模块列表数组
                    $folders = $this->input->post('folder');    //有权限的课程列表数组
                    if (!empty($modules) || !empty($folders)) {
                        $rcmodel = $this->model('Roomcontrol');
                        $modulepower = implode(',', $modules);
                        $folderpath = implode(',', $folders);
                        $rcparam = array('rid' => $roominfo['crid'], 'tid' => $uid, 'modulepower' => $modulepower, 'folderpath' => $folderpath);
                        $rcresult = $rcmodel->insert($rcparam);
                    }
                }
            }
        } else {
            if ($code == 2) {
                $message = '该用户不允许被添加';
            } else if ($code == 3) {
                $message = '该用户已经在该教室内';
            } else {
                $message = '信息非法';
            }
        }
        $result = array('status' => $status, 'message' => $message);
        echo json_encode($result);
    }

    /**
     * 修改教师信息
     */
    public function edit_view() {
        $roominfo = Ebh::app()->room->getcurroom();
        $tid = $this->uri->itemid;
        if (empty($tid) || !is_numeric($tid))
            return FALSE;
        $teachermodel = $this->model('Teacher');
        $teacher = $teachermodel->getroomteacherdetail($tid);
        if (empty($teacher))
            return FALSE;
        $this->assign('teacher', $teacher);
        $foldermodel = $this->model('Folder');
        $folderparam = array('crid' => $roominfo['crid']);
        $folders = $foldermodel->getfolderlist($folderparam);
        $this->assign('folders', $folders);
        $modulelist = $this->_getmodules();
        $this->assign('modulelist', $modulelist);
        $rcmodel = $this->model('Roomcontrol');
        $rcparam = array('rid' => $roominfo['crid'], 'tid' => $tid);
        $power = $rcmodel->getcontrol($rcparam);
        $mymodules = array();
        if (!empty($power) && !empty($power['modulepower']))
            $mymodules = explode(',', $power['modulepower']);
        $myfolders = array();
        if (!empty($power) && !empty($power['folderpath']))
            $myfolders = explode(',', $power['folderpath']);
        $this->assign('mymodules', $mymodules);
        $this->assign('myfolders', $myfolders);
        $this->display('troom/teacher_edit');
    }

    /**
     * 处理教师编辑提交表单 
     */
    public function edit() {
        $status = 0;
        $msg = '';
        $tid = $this->input->post('tid');
        if ($tid !== NULL && is_numeric($tid)) {   //表单提交
            $roominfo = Ebh::app()->room->getcurroom();
            $modules = $this->input->post('module');    //有权限的模块列表数组
            $folders = $this->input->post('folder');    //有权限的课程列表数组
            if (!empty($modules) || !empty($folders)) {
                $rcmodel = $this->model('Roomcontrol');
                $modulepower = implode(',', $modules);
                $folderpath = implode(',', $folders);
                $rcparam = array('rid' => $roominfo['crid'], 'tid' => $tid, 'modulepower' => $modulepower, 'folderpath' => $folderpath);
                $rcresult = $rcmodel->update($rcparam);
                if($rcresult !== FALSE) {
                    $status = 1;
                }
            }
        }
        echo json_encode(array('status'=>$status,'message'=>$msg));
    }

    /**
     * 获取网校平台的功能模块
     */
    private function _getmodules() {
        $roominfo = Ebh::app()->room->getcurroom();
        //加载菜单模块信息
        $code = 'troom';
        $catmodel = $this->model('Category');
        $curcat = $catmodel->getCatByCode($code);
        $upid = $curcat['catid'];
        $subcat = $catmodel->getCatlistByUpid($upid, NULL, NULL, 1);
        $modulelist = array();
        $modulepower = $roominfo['modulepower'];
        $modulepowerarr = explode(',', $modulepower);
        //需要在学校平台显示的模块
        $schoolcatarr = array('classsubject', 'classexam', 'classstudent', 'teaexam', 'review', 'myask', 'stuexam', 'online', 'mysetting', 'exampaper', 'tastulog', 'statisticanalysis', 'teachingplan', 'reslibs');
        //不需要在网校平台显示的模块
        $noinroomcatarr = array('classsubject', 'classexam', 'classstudent', 'teaexam', 'stuexam', 'exampaper', 'tastulog', 'statisticanalysis', 'reslib');

        if ($roominfo['isschool'] == 3 || $roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {  //学校模块
            foreach ($subcat as $catitem) {
                if ($catitem['system'] == 1 && in_array($catitem['code'], $schoolcatarr)) {
                    $modulelist[] = $catitem;
                    continue;
                }
                if ($catitem['system'] == 0 && in_array($catitem['code'], $modulepowerarr) && in_array($catitem['code'], $schoolcatarr)) {
                    $modulelist[] = $catitem;
                    continue;
                }
            }
        } else {    //网校模块
            foreach ($subcat as $catitem) {
                if ($catitem['system'] == 1 && !in_array($catitem['code'], $noinroomcatarr)) {
                    $modulelist[] = $catitem;
                    continue;
                }
                if ($catitem['system'] == 0 && in_array($catitem['code'], $modulepowerarr) && !in_array($catitem['code'], $noinroomcatarr)) {
                    $modulelist[] = $catitem;
                    continue;
                }
            }
        }
        return $modulelist;
    }

    /**
     * 检测教师username是否存在
     */
    public function checkname() {
        $username = $this->input->post('sname');
        if ($username !== NULL) {
            $checkresult = $this->_checkname($username);
            $code = 0;
            $message = '';
            if ($checkresult == 1) {
                $code = 1;
                $message = '请为新用户设置密码';
            } else if ($checkresult == 2) {
                $code = 2;
                $message = '该用户不允许被添加';
            } else if ($checkresult == 3) {
                $code = 2;
                $message = '该用户已经在该教室内';
            }
            echo json_encode(array('code' => $code, 'message' => $message));
        }
    }

    /**
     * 根据username信息或者教室教师针对教师的信息
     * @param string $username
     * @return int
     */
    private function _checkname($username) {
        $code = 0;
        $roominfo = Ebh::app()->room->getcurroom();
        $usermodel = $this->model('User');
        $suser = $usermodel->getuserbyusername($username);
        if (empty($suser)) { //用户名还不存在
            $code = 1;
        } else if ($suser['groupid'] != 5) { //教师以外账号不允许添加
            $code = 2;
        } else {
            $roommodel = $this->model('Classroom');
            $checkresult = $roommodel->checkteacher($suser['uid'], $roominfo['crid']);
            if ($checkresult != -1) {    //该教师账号已存在教室中
                $code = 3;
            }
        }
        $this->tuser = $suser;
        return $code;
    }
    /**
     * 查看教师详情
     */
    public function view() {
         $teacherid = $this->uri->itemid;
        if(empty($teacherid) || !is_numeric($teacherid))
            return FALSE;
        $teachermodel = $this->model('Teacher');
        $teacher = $teachermodel->getteacherdetail($teacherid);
        $this->assign('teacher', $teacher);
        $this->display('troom/teacher_view');
    }

	/**---------------------------统计--------------------------------**/
	/*
	教师任课班级
	*/
	public function classes_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$classesmodel = $this->model('classes');
		$classlist = $classesmodel->getTeacherClassList($roominfo['crid'],$uid);
		
		$this->assign('tuser',$tuser);
		$this->assign('classlist',$classlist);
		$this->display('troom/teacher_classes');
	}

	/*
	教师的课程
	*/
	public function course_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$param['uid'] = $uid;
		$foldermodel = $this->model('folder');
		$param['crid'] = $roominfo['crid'];
		$param['limit'] = 100;
		$folderlist = $foldermodel->getTeacherFolderList1($param);
		$this->assign('folderlist',$folderlist);
		$this->assign('tuser',$tuser);
		$this->display('troom/teacher_course');
	}

	/*
	教师的课件列表
	*/
	public function courseware_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		//课程列表
		$param['uid'] = $uid;
		$param['crid'] = $roominfo['crid'];
		$param['limit'] = 100;
		$foldermodel = $this->model('folder');
		$folderlist = $foldermodel->getTeacherFolderList1($param);
		
		$param = parsequery();
		$param['uid'] = $uid;
		$param['uids'] = $uid;
		$param['crid'] = $roominfo['crid'];
		$cwmodel = $this->model('courseware');
		$param['folderid'] = $this->input->get('selfolderid');
		$cwcountlist = $cwmodel->getTeachersCWCount($param);
		$cwcount = $cwcountlist[0]['cwnum'];
		$param['order'] = ' truedateline desc';
		$cwlist = $cwmodel->getTeacherCoursewares($param);
		
		
		$pagestr = show_page($cwcount);
		$this->assign('folderlist',$folderlist);
		$this->assign('pagestr',$pagestr);
		$this->assign('tuser',$tuser);
		$this->assign('cwlist',$cwlist);
		$this->display('troom/teacher_courseware');
	}
	
	/*
	提问给教师的
	*/
	public function askme_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $uid;
		$param['limit'] = 100;
		$foldermodel = $this->model('folder');
		$folderlist = $foldermodel->getTeacherFolderList1($param);
		
		$askmodel = $this->model('askquestion');
		$param['tid'] = $uid;
		unset($param['uid']);
		unset($param['limit']);
		$param['folderid'] = $this->input->get('selfolderid');
		$asklist = $askmodel->getallasklist($param);
		$askcount = $askmodel->getallaskcount($param);
		$pagestr = show_page($askcount);
		
		$param['tids'] = $uid;
		$asksstate = $askmodel->getTeacherAnsweredList($param);
		$askstate['asknum'] = empty($asksstate[0]['asknum'])?0:$asksstate[0]['asknum'];
		$askstate['bestnum'] = empty($asksstate[0]['bestnum'])?0:$asksstate[0]['bestnum'];
		$this->assign('askstate',$askstate);
		$this->assign('pagestr',$pagestr);
		$this->assign('asklist',$asklist);
		$this->assign('folderlist',$folderlist);
		$this->assign('tuser',$tuser);
		$this->display('troom/teacher_askme');
		
		
	}
	
	/*
	教师回答
	*/
	public function answer_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $uid;
		$param['uids'] = $uid;
		$param['limit'] = 100;
		//课程列表
		$foldermodel = $this->model('folder');
		$folderlist = $foldermodel->getTeacherFolderList1($param);
		$param['folderid'] = $this->input->get('selfolderid');
		//回答列表以及数量
		unset($param['limit']);
		$askmodel = $this->model('askquestion');
		$answerlist = $askmodel->getAnswerListByDistinctQid($param);
		$answercount = $askmodel->getAnswerCountByDistinctQid($param);
		$answercount = $answercount[0]['answernum'];
		//回答总数
		if(empty($param['folderid']))
			$totalanswercount = $answercount;
		else{
			unset($param['folderid']);
			$totalanswercount = $askmodel->getAnswerCountByDistinctQid($param);
			$totalanswercount = $totalanswercount[0]['answernum'];
		}
		$pagestr = show_page($answercount);
		$this->assign('totalanswercount',$totalanswercount);
		$this->assign('pagestr',$pagestr);
		$this->assign('answerlist',$answerlist);
		$this->assign('tuser',$tuser);
		$this->assign('folderlist',$folderlist);
		$this->display('troom/teacher_answer');
	}
	
	/*
	教师收到的评论
	*/
	public function review_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$uid = $this->uri->itemid;
		$usermodel = $this->model('user');
		$tuser = $usermodel->getUserInfoByUid($uid);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $uid;
		
        $review = $this->model('review');
		$reviewlist = $review->getreviewlistbycrid($param);
        $reviewcount = $review->getreviewlistcountbycrid($param);
		$pagestr = show_page($reviewcount);
		$reviewlist = parseEmotion($reviewlist);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('reviewlist', $reviewlist);
		$this->assign('pagestr',$pagestr);
		$this->assign('tuser',$tuser);
		$this->display('troom/teacher_review');
	}
	
	/*
	教师查看
	*/
	public function teacherlist(){
		$roominfo = Ebh::app()->room->getcurroom();
		$teachermodel = $this->model('teacher');
		$param = parsequery();
		$crid = $roominfo['crid'];
		$teacherlist = $teachermodel->getroomteacherlist($crid,$param);
		$teachercount = $teachermodel->getroomteachercount($crid,$param);
		$pagestr = show_page($teachercount);
		$q = $this->input->get('q');
		$this->assign('q',$q);
		$this->assign('teacherlist',$teacherlist);
		$this->assign('pagestr',$pagestr);
		$this->display('troom/teacher_list');
	}
	
	/*
	教师查看导航页
	*/
	public function viewnav(){
		$this->display('troom/teacher_viewnav');
	}
	
	/*
	课件的学习监控
	*/
	public function cwstudylog_view(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid))
			exit;
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['cwid'] = $cwid;
		$playlogmodel = $this->model('playlog');
		$playloglist = $playlogmodel->getLogsByCwid($param);
		$playlogcount = $playlogmodel->getLogsCountByCwid($param);
		$cwmodel = $this->model('courseware');
		$cwinfo = $cwmodel->getcoursewaredetail($cwid);
		$this->assign('cwinfo',$cwinfo);
		$pagestr = show_page($playlogcount);
		$this->assign('playloglist',$playloglist);
		$this->assign('pagestr',$pagestr);
		$this->display('troom/courseware_studylog');
	}
	
	/*
	教师作业
	*/
	public function exam_view(){
		$uid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$exammodel = $this->model('exam');
		$param = parsequery();
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('enddate');
		$param['starttime'] = strtotime($startdate);
		$param['endtime'] = strtotime($enddate);
		$param['crid'] = $roominfo['crid'];
		$param['uid'] = $uid;
		$examlist = $exammodel->getschexamlist($param);
		$examcount = $exammodel->getschexamlistcount($param);
		// var_dump($examlist);
		$pagestr = show_page($examcount);
		$this->assign('startdate',$startdate);
		$this->assign('enddate',$enddate);
		$this->assign('pagestr',$pagestr);
		$this->assign('examlist',$examlist);
		$this->display('troom/exam_list');
	}
	
	/*
	课件详情
	*/
	public function classcourse_view() {
		$roominfo = Ebh::app()->room->getcurroom();
        $cwid = $this->uri->itemid;
        if(empty($cwid)){
        	$cwid = intval($this->uri->uri_attr(0));
        }
        $recuid = intval($this->uri->uri_attr(1));
		$user = Ebh::app()->user->getloginuser();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		$source = '';
		if(!empty($course)) {	//生成课件所在服务器地址
			$serverutil = Ebh::app()->lib('ServerUtil');
			$source = $serverutil->getCourseSource();
			if(!empty($source)) {
				$course['cwsource'] = $source;
			}
		}
        $this->assign('course', $course);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
		//单个课件下的作业
		$exammodel  = $this->model('exam');
		if(!empty($recuid)){
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$recuid,'limit'=>'0,100');
		}else{
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'limit'=>'0,100');
		}
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamonlinelist($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		$this->assign('exams',$exams);
		//课件评论
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		//$pagestr = $this->_show_page($count,1,10);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('roominfo', $roominfo);
		$this->assign('user',$user);
        $this->assign('reviews', $reviews);
		$this->assign('pagestr', $pagestr);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		$this->assign('type',$type);
		if($type == 'flv'){
			$this->display('troom/course_view');
		}else{
			$this->display('troom/classcourse_view');
		}
    }
	
	/*
	flv类型课件详情
	*/
	public function classcourseflv_view() {
        $cwid = $this->uri->itemid;
        if(empty($cwid)){
        	$cwid = intval($this->uri->uri_attr(0));
        }
        $recuid = intval($this->uri->uri_attr(1));
		if(!is_numeric($cwid))
			exit();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course) || $course['status']!=1)
			exit();
			
		//课件人气
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		
		$user = Ebh::app()->user->getloginuser();
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('user',$user);

		$type = $this->input->get('type');	//如果type为1则表示普通播放，即不采用m3u8方式播放
		$ifover5 = (SYSTIME - $course['dateline']) > 120 ? TRUE : FALSE;	//如果课件时间上传已经超过5分钟，则基本上已经处理成m3u8并且文件已经存好。
		if($course['ism3u8'] == 1 && $type != 1 && $course['dateline'] && $ifover5) {	//rtmp特殊处理 
			if($roominfo['domain'] == 'jx') {
				$m3u8source = $serverutil->getZKM3u8CourseSource();
			} else {
				$m3u8source = $serverutil->getM3u8CourseSource();
			}
			if(!empty($m3u8source)) {
				$murl = $course['m3u8url'];
				$key = $this->getKey($user,$murl,$cwid);
				$key = urlencode($key);
				$m3u8url = "$m3u8source?k=$key&id=$cwid&.m3u8";
				$course['m3u8url'] = $m3u8url;
			}
		} else {
			$course['m3u8url'] = '';
		}

        $this->assign('course', $course);
		$this->assign('source',$source);
		if(!empty($recuid)){
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$recuid,'limit'=>'0,100');
		}else{
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'limit'=>'0,100');
		}
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamlistbycwid($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		$this->assign('exams',$exams);
		//获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
		$queryarr['status'] = 1;
        $queryarr['cwid'] = $cwid;
		$queryarr['type'] = 'shield';
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
		//获取课件下的评论记录
		$reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $reviewcount = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($reviewcount);
		$this->assign('reviewcount',$reviewcount);
		$askmodel = $this->model('askquestion');
		$askcount = $askmodel->getRequiredAnswersCount(array('cwid'=>$cwid,'shield'=>0));
		$this->assign('askcount',$askcount);
		//$pagestr = $this->_show_page($count,1,10);
		$arr = explode('.',$course['cwurl']);
		$ext = $arr[count($arr)-1];
		if($ext != 'flv' && $course['ism3u8'] == 1) {
			$ext = 'flv';
		}
		$this->assign('ext',$ext);
		$reviews = parseEmotion($reviews);
		$subtitle = $course['title'];
		$this->assign('subtitle',$subtitle);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('roominfo', $roominfo);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
        $this->display('troom/course_view');
    }
	
	/**
	*生成包含用户信息的key，目前主要
	*/
	private function getKey($user,$cwurl='',$id=0) {
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time\t$cwurl\t$id";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}
}
