<?php

/**
 * 网校教师后台课程控制器类SubjectController
 */
class SubjectController extends CControl {

    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
    }

    /**
     * 课程列表
     */
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $queryarr = parsequery();
		$queryarr['pagesize'] = 15;
        $queryarr['crid'] = $roominfo['crid'];
        $foldermodel = $this->model('Folder');
        $folders = $foldermodel->getfolderlist($queryarr);
		$foldercount = $foldermodel->getcount($queryarr);
        $pagestr = show_page($foldercount,$queryarr['pagesize']);
        $this->assign('folders', $folders);
        $this->assign('pagestr', $pagestr);
        $this->display('troomv2/subject');
    }

    /**
     * 删除课程
     */
    public function delfolder() {
        $folderid = $this->input->post('folderid');
        if ($folderid > 0) {
            $roominfo = Ebh::app()->room->getcurroom();
            $param = array('crid' => $roominfo['crid'], 'folderid' => $folderid);
            $foldermodel = $this->model('Folder');
            $result = $foldermodel->deletecourse($param);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
        }
    }

    /**
     * 移动课程位置
     */
    public function move() {
        $folderid = $this->input->post('folderid');
        $flag = $this->input->post('flag');
        if ($folderid > 0) {
            $roominfo = Ebh::app()->room->getcurroom();
            if ($flag != 1) {
                $flag = 0;
            }
            $foldermodel = $this->model('Folder');
            $result = $foldermodel->move($roominfo['crid'], $folderid, $flag);
            if ($result) {
                echo 'success';
            } else {
                echo 'fail';
            }
        }
    }
    /**
     * 添加课程
     */
    public function add() {
        if ($this->input->post()) {
            $roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getloginuser();
            $folder = $this->model('folder');
            $param['crid'] = $roominfo['crid'];
            $param['folderlevel'] = 2;
            $roomfolder = $folder->getfolderlist($param);
            $param['upid'] = $roomfolder[0]['folderid'];
            $param['img'] = $this->input->post('img');
            $param['foldername'] = $this->input->post('foldername');
            $param['displayorder'] = $this->input->post('displayorder');
            $param['summary'] = $this->input->post('summary');
            $param['uid'] = $user['uid'];
            $param['folderpath'] = $roomfolder[0]['folderpath'];
            $folder->addfolder($param);
            header('location:' . geturl('troomv2/subject'));
        } else {
            $roominfo = Ebh::app()->room->getcurroom();
            $folder = $this->model('folder');
            $param['crid'] = $roominfo['crid'];
            $roomfolder = $folder->getfolderlist($param);
            $this->assign('imgarr', $this->getimages());
            $this->display('troomv2/subject_add');
        }
    }
    /**
     * 获取课程封面列表数组（此方法需改）
     * @return string
     */
    public function getimages() {
        $pre_path = 'http://static.ebanhui.com/ebh/tpl/default/images/folderimg/';
        $imgarr = array();
        for ($i = 1; $i <= 72; $i++) {
            $imgarr[] = $pre_path . $i . '.jpg';
        }
        $imgarr[] = $pre_path . 'guwen.jpg';
        return $imgarr;
    }

    public function img() {
        $this->display('troomv2/uploadimage');
    }
    /**
     * 编辑详情
     */
    public function edit_view() {
        $folder = $this->model('folder');
        $folderid = $this->uri->itemid;
        $coursedetail = $folder->getfolderbyid($folderid);
        $this->assign('imgarr', $this->getimages());
        $this->assign('coursedetail', $coursedetail);
        $this->display('troomv2/subject_edit');
    }
    /*
     * 处理编辑表单提交
     */
    public function edit() {
        $roominfo = Ebh::app()->room->getcurroom();
        $folder = $this->model('folder');
        $param['crid'] = $roominfo['crid'];
        $param['folderid'] = $this->input->post('folderid');
        $param['foldername'] = $this->input->post('foldername');
        $param['summary'] = $this->input->post('summary');
        $param['img'] = $this->input->post('img');
        $param['displayorder'] = $this->input->post('displayorder');
        $folder->editcourse($param);
        header('location:' . geturl('troomv2/subject'));
    }
    /**
     * 课程详情页面
     */
    public function view() {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $folderid = $this->uri->itemid;
        $foldermodel = $this->model('Folder');
        $folder = $foldermodel->getfolderbyid($folderid);
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
        $this->assign('pagestr', $pagestr);
        $this->assign('roominfo', $roominfo);
        $this->display('troomv2/subject_view');
    }
	
	/*
	免费课件页面
	*/
	public function freecourseware(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$folder = $this->model('folder');
		$farr['uid'] = $user['uid'];
		$farr['crid'] = $roominfo['crid'];
		$farr['pagesize'] = 1000;
		$folderlist = $folder->getfolderlist($farr);
		$param = parsequery();
		$param['crid'] = $roominfo['crid'];
		$param['isfree'] = is_numeric($this->input->get('isfree'))?$this->input->get('isfree'):null;
		$param['folderid'] = is_numeric($this->input->get('folderid'))?$this->input->get('folderid'):null;
		$courseware = $this->model('courseware');
		$cwlist = $courseware->getfolderseccourselist($param);
		$cwcount = $courseware->getfolderseccoursecount($param);
		$pagestr = show_page($cwcount);
		$this->assign('q',$param['q']);
		$this->assign('isfree',$param['isfree']);
		$this->assign('folderid',$param['folderid']);
		$this->assign('cwlist',$cwlist);
		$this->assign('cwcount',$cwcount);
		$this->assign('folderlist',$folderlist);
		$this->assign('pagestr',$pagestr);
		$this->display('troomv2/freecourseware');
	}
	
	/*
	修改课件是否免费
	*/
	public function upisfree(){
		$roominfo = Ebh::app()->room->getcurroom();
		$wherearr['crid'] = $roominfo['crid'];
		$wherearr['cwid'] = $this->input->post('cwid');
		$param['isfree'] = $this->input->post('isfree');
		$cwmodel = $this->model('courseware');
		$res = $cwmodel->update($param,$wherearr);
		if(isset($res)){
			echo json_encode(array('isfree'=>$param['isfree']));
		}
		
	}
}
