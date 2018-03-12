<?php
/*
伪直播，答疑
*/
class AskController extends CControl{
    private $user = null;
    public function __construct(){
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        if(empty($this->user)){
            header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
            exit;
        }
        $this->assign('user',$this->user);
    }
	/*
	提问页面
	*/
    public function index(){

        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'], $other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'], $other_config['newzjdlr']);
        if (NULL === $this->input->post('title')) {
            $upcontrol = Ebh::app()->lib('UpcontrolLib');
            $editor = Ebh::app()->lib('UEditor');
            $classsubjectmodel = $this->model('Classsubject');
            $subjects = $classsubjectmodel->getsubjectlist($roominfo['crid']);
            $this->assign('subjects', $subjects);
            $teachArr = array();
            $teachsubjects = array();
            if(is_array($subjects)){
                foreach ($subjects as $key => $sbj) {
                    $teacherid = $sbj['uid'];
                    $face = $this->_getfaceurl($sbj['face'], $sbj['sex']);
                    $sbj['face'] = $face;
                    if (!in_array($teacherid, $teachArr)) {
                        $teachArr[] = $teacherid;
                    }
                $teachsubjects[$teacherid][] = $sbj;
                } 
            }
            
            $roominfo = Ebh::app()->room->getcurroom();
            $myfolders = $classsubjectmodel->getMyfoldersForSMS($roominfo['crid'], $user['uid']);
            $myfolders = EBH::app()->lib('UserUtil')->init($myfolders, array('tid'), true);
            $showTeacherSelect = false;
            if (!$is_zjdlr) {
                //获取教师分组信息
                $groupInfo = $this->model('tgroups')->getRoomGroupInfo($roominfo['crid'], $user['schoolname']);
                if (!empty($groupInfo))
                    $showTeacherSelect = true;
                else {
                    $teachermodel = $this->model('teacher');
                    $teachers = $teachermodel->getroomteacherlist($roominfo['crid'], array('schoolname' => $user['schoolname'], 'limit' => 1000));
                    $teachers[0]['groupname'] = '所有老师';
                    $groupInfo['group_0'] = $teachers;
                    $showTeacherSelect = true;
                }
                $tid = $this->input->get('tid');
                if (is_numeric($tid)) {
                    $usermodel = $this->model('user');
                    $teacher = $usermodel->getUserInfoByUid($tid);
                    $this->assign('teacher', $teacher[0]);
                }
                $this->assign('groupInfo', $groupInfo);
            } else {
                //国土资源厅向学生提问
                $class_model = $this->model('classes');
                $classes = $class_model->getroomClassList($roominfo['crid']);
                if (!empty($classes)) {
                    $first_class = current($classes);
                    $students = $class_model->getClassStudentList(array(
                        'classid' => $first_class['classid'],
                        'order' => 'cs.classid asc,u.uid desc',
                        'limit' => 35
                    ));
                    $tid = $this->input->get('tid');
                    if (is_numeric($tid)) {
                        $usermodel = $this->model('user');
                        $student = $usermodel->getUserInfoByUid($tid);
                        $this->assign('student', $student[0]);
                    }
                    $this->assign('classes', $classes);
                    $this->assign('students', $students);
                }
            }
            $folderid = intval($this->input->get('folderid'));
            $foldermodel = $this->model('Folder');
            $folder = $foldermodel->getfolderbyid($folderid);
            $imgsrc = $this->input->get('imgsrc');//视频截图提问的图片地址
            $this->assign('folder', $folder);

            $cwid = $this->input->get('cwid');
            if (is_numeric($cwid)) {
                $cwmodel = $this->model('courseware');
                $courseware = $cwmodel->getSimplecourseByCwid($cwid);
                $userinfo = $cwmodel->getcwUserinfo($cwid);
                $this->assign('cw', $courseware);
                $this->assign('userinfo', $userinfo);
            }
            $tid = $this->input->get('tid');
            if (is_numeric($tid)) {
                $usermodel = $this->model('user');
                $teacher = $usermodel->getUserInfoByUid($tid);
                $this->assign('teacher', $teacher[0]);
            }
            $this->assign('myfolders', $myfolders);


            //所有的课程
            $allfolders = $classsubjectmodel->getfolders($roominfo['crid']);
            foreach ($allfolders as $arr) {
                $arrayall[$arr['folderid']] = array('foldername' => $arr['foldername'], 'realname' => $arr['realname'], 'tid' => $arr['tid']);
            }
            if (!empty($myfolders)) {
                foreach ($myfolders as $arr) {
                    $arraymy[$arr['folderid']] = $arr['foldername'];
                }
                $this->assign("myfolders", $arraymy);
                //其他课程
                $otherfolders = array_diff_key($arrayall, $arraymy);
            } else {
                $otherfolders = array();
                foreach ($allfolders as $folder) {
                    $otherfolders[$folder['folderid']] = $folder;
                }
            }
            $this->assign('iszjdlr', $is_zjdlr);
            $this->assign('isnewzjdlr', $is_newzjdlr);
            $this->assign("allfolders", $allfolders);
            $this->assign('myfolders', $myfolders);
            $this->assign('user', $user);
            $this->assign('roominfo', $roominfo);
            // $this->assign('_SMS', $_SMS);
            $this->assign('otherfolders', $otherfolders);

            $this->assign('teachsubjects', $teachsubjects);
            $this->assign('upcontrol', $upcontrol);
            $this->assign('editor', $editor);
            $this->assign('imgsrc', $imgsrc);
            $this->assign('showTeacherSelect', $showTeacherSelect);
            $forcoursedialog = $this->input->get('forcoursedialog');
            
            $this->display('im/ask');
            
        }
    }
	
	/*
	该课件的提问列表
	*/
	public function all(){
		$roominfo = Ebh::app()->room->getcurroom();
		$cwid = $this->input->get('cwid');
		$queryarr['crid'] = $roominfo['crid'];
        $queryarr['shield'] = 0;
        $queryarr['cwid'] = intval($cwid);
		$res = $this->model('askquestion')->getAskListSimple($queryarr);
		echo json_encode(array('error'=>0,'msg'=>empty($res)?array():$res));
	}
	
	/**
     * 获取课程关联的教师头像
     *
     */
    protected function _getfaceurl($face = '', $sex) {
        $defaulturl = $sex == 1 ? 'm_woman.jpg' : 'm_man.jpg';
        $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/' . $defaulturl;
        $face = empty($face) ? $defaulturl : $face;
        return $face = getthumb($face, '40_40');
    }

}