<?php
class LinkcourseController extends CControl{
    public function __construct(){
        parent::__construct();
        $roominfo = Ebh::app()->room->getcurroom();
        if(empty($roominfo)){
            header("Location:/");exit;
        }
        Ebh::app()->room->checkteacher();
    }
	
	/*
	*关联课件(显示班级列表，用来选择班级)
	*/
	public function index(){
        Ebh::app()->room->checkteacher();
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classmodel = $this->model('Classes');
        $param = array('uid'=>$user['uid'],'crid'=>$roominfo['crid']);
        $cexams = $classmodel->getTeacherclassexam($param);

        $this->assign('cexams', $cexams);
        $this->display('troom/linkcourse_cor');
	}
	/**
	*班级作业对应的具体班级
	*/
	public function my() {
        Ebh::app()->room->checkteacher();
		$classid = intval($this->uri->uri_attr(0));
       
        $classmodel = $this->model('Classes');
		$roominfo = Ebh::app()->room->getcurroom();
        $param = parsequery();
        $param['crid'] = $roominfo['crid'];
       
		if($classid>0){
            $param['classid'] = $classid;
            $myclass = $classmodel->getclassdetail(array('crid'=>$roominfo['crid'],'classid'=>$classid));
            if(!empty($myclass['grade'])) { //加上年级作业信息
                $grade = $param['grade'] = $myclass['grade'];
                $district = $param['district'] = $myclass['district'];
            }
            if(empty($myclass))
            exit;
        }else{
            $myclass['classname'] = "所有班级";
            $param['classid'] = 0;
        }
        $user = Ebh::app()->user->getloginuser();
        $classList = $classmodel->getTeacherClassList($roominfo['crid'],$user['uid']);

        $classDb = array();
        $gradeDb = array();
        $gradeClassDb = array();

        if(!empty($classList)){
            foreach ($classList as $class) {
                $classDb['c_'.$class['classid']] = $class;
                if($class['grade'] > 0){
                    $key = 'g_'.$class['grade'].'_'.$class['district'];
                    if(!array_key_exists($key, $gradeDb)){
                        $gradeDb[$key] = array('stunum'=>$class['stunum'],'grade'=>$class['grade'],'district'=>$class['district']);
                    }else{
                        $gradeDb[$key]['stunum']+=$class['stunum'];
                    }
                    if(empty($gradeClassDb[$class['grade'].'_'.$class['district']])){
                        $gradeClassDb[$class['grade'].'_'.$class['district']] = array();
                    }
                    $gradeClassDb[$class['grade'].'_'.$class['district']][] = '<a href="/troom/linkcourse/my-0-0-0-'.$class['classid'].'.html">'.$class['classname'].'</a>';
                }
            }
        }
        $this->assign('classDb',$classDb);
        $this->assign('gradeDb',$gradeDb);
        $this->assign('gradeClassDb',$gradeClassDb);
        $grademap = Ebh::app()->getConfig()->load('grademap');
        $this->assign('grademap',$grademap);
        $param['uid'] = $user['uid'];
        $param['tid'] = $user['uid'];
       
		$exammodel = $this->model('Exam');
		

		$exams = $exammodel->getschexamlist($param);
		$count = $exammodel->getschexamlistcount($param);
		$pagestr = show_page($count);

		$coursewareList = array();
		$coursewareDb = array();
        $cwids = array();
		if(!empty($exams)){
			foreach ($exams as $exam) {
				if(!empty($exam['cwid'])){
					$cwids[] = $exam['cwid'];
				}
			}
			$cwids = array_unique($cwids);
		}
		$coursewareList = $this->model('courseware')->getCourseListByCwids($cwids);
		if(!empty($coursewareList)){
			foreach ($coursewareList as $courseware) {
				$key = 'cw_'.$courseware['cwid'];
				$coursewareDb[$key] = $courseware;
			}
		}
		$this->assign('coursewareDb',$coursewareDb);
        $this->assign('classid',$classid);
		$this->assign('exams',$exams);
		$this->assign('pagestr',$pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('uid',$user['uid']);
		$this->assign('myclass',$myclass);
		$this->display('troom/linkcourse_my');
	}

	/**
     * 班级课程
     */
    public function coursesDialog() {
        Ebh::app()->room->checkteacher();
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classsubjectmodel = $this->model('Classsubject');
        $param = parsequery();
        $param['tid'] = $user['uid'];
        $param['crid'] = $roominfo['crid'];
        $param['power'] = array(0,1);
        $subjectlist = $classsubjectmodel->getteachersubjectlist($param);
        $subjectlistCount = $classsubjectmodel->getteachersubjectlistCount($param);
        $pagestr = show_page($subjectlistCount,$param['pagesize']);
        $this->assign('subjectlist', $subjectlist);
        $this->assign('pagestr', $pagestr);
        $this->assign('notop',true);
        $this->display('troom/classsubject_fordialog');
    }

    /**
	*班级课程详情页（课件列表）
	*/
    public function view() {
        Ebh::app()->room->checkteacher();
		$roominfo = Ebh::app()->room->getcurroom();
		$folderid = $this->uri->itemid;
		
		$subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$cridarr = Ebh::app()->getConfig()->load('subfolder');
		if(in_array($roominfo['crid'],$cridarr['noteacher']))
			$this->assign('needsubfolder',false);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
		$queryarr['status'] = 1;
		$queryarr['uid'] = $user['uid'];
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
        $this->assign('from',1);
        $this->assign('pagestr', $pagestr);
        //分配folderid
        $this->assign('folderid',$folderid);
        //分配教室信息
        $this->assign('roominfo',$roominfo);
        //分配作业信息
        
        $this->display('troom/classsubject_view_fordialog');
    }

    //作业关联课件
    public function dolink(){
        $roominfo = Ebh::app()->room->getcurroom();
    	$user = Ebh::app()->user->getloginuser();
    	$cwid = intval($this->input->post('cwid'));
    	$eid = intval($this->input->post('eid'));
    	$msg = array();
    	if(empty($roominfo) || empty($user) || !is_numeric($cwid) || $user['groupid']!=5 || empty($eid)){
    		$msg['code'] = -4;
    		$msg['info'] = '参数不正确或者没有权限！';
    		echo json_encode($msg);
    		exit;
    	}
    	$crid = $roominfo['crid'];
    	$uid = $user['uid'];

    	$param = array(
    		'eid'=>$eid,
    		'crid'=>$crid,
    		'cwid'=>$cwid,
    		'uid'=>$user['uid']
    	);
    	$res = $this->model('roomcourse')->examLinkCourse($param);
    	if(is_numeric($res) && $res>0){
    		$msg['code'] = 1;
    		$msg['info'] = '操作成功！';
    		echo json_encode($msg);
    	}else{
    		$msg['code'] = $res;
    		if(is_numeric($res) && $res ==0){
				$msg['info'] = '操作没有生效';
    		}else{
    			$msg['info'] = '操作失败';
    		}
    		echo json_encode($msg);
    	}
    	
    }
}