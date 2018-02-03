<?php
class MyclassController extends CControl {
    private $user;
    public function __construct()
    {
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        if (empty($this->user) === true) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) === true) {
                echo json_encode(array(
                    'errno' => 1,
                    'msg' => '未登录'
                ));
                exit;
            }
            header("location:/");
            exit;
        }
    }

    /**
     * 班级同学
     */
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $param = parsequery();
        $cmodel = $this->model('changeclass');

        $myclass = $cmodel->getCurrentClassForStudent($this->user['uid'], $roominfo['crid']);

        if (empty($myclass)) {
            $this->display('college/my_classmate');
            exit;
        }
        $conf = Ebh::app()->getConfig()->load('othersetting');
        $conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        $conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $conf['zjdlr']) || (in_array($roominfo['crid'],$conf['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'],$conf['newzjdlr']);
        if ($is_zjdlr) {
            //国土局
            $classes = $this->model('Classes')->getClasses(array('crid' => $roominfo['crid']), true);
            $this->assign('classes', $classes);
            $this->assign('is_newzjdlr',$is_newzjdlr);
            $this->assign('is_zjdlr', true);
            $classid = intval($this->input->get('classid'));
            if (!isset($classes[$classid])) {
                $classid = $myclass['classid'];
            }

            //搜索同学
            $q = trim($this->input->get('q'));
            if (!empty($q)) {
                $classid = 0;
                $this->assign('q', $q);
            }

            $this->assign('classid', $classid);
            $param['pagesize'] = 20;
            $my_classmates_count = $cmodel->getStudentCount($roominfo['crid'], $this->user['uid'], $classid, $q);
            if ($my_classmates_count > 0) {
                $students = $cmodel->getStudents($roominfo['crid'], $this->user['uid'], $classid, $q, $param['page'], $param['pagesize']);
                $first_student = current($students);
                $class_info = $this->model('Classes')->getClassInfoByUserids($first_student['uid'], $roominfo['crid']);
                if (!empty($class_info) && !empty($q)) {
                    $this->assign('classid', $class_info[$first_student['uid']]['classid']);
                }
                $this->assign('students', $students);
            }
        } else {
            //我的同学数＝班级学生数-1
            $my_classmates_count = $myclass['stunum'] - 1;
            if ($my_classmates_count > 0) {
                $my_classmates = $cmodel->myClassmates($myclass['classid'],
                    $this->user['uid'], $param['page']);
                $this->assign('students', $my_classmates);
            }
        }


        $pagestr = show_page($my_classmates_count, $param['pagesize']);

        $change_info = $cmodel->getChangeInfo($this->user['uid'], $roominfo['crid'], $myclass['classid']);
        $this->assign('roominfo', $roominfo);
        $this->assign('myclass', $myclass);
        $this->assign('change_info', $change_info);
        $this->assign('pagestr',$pagestr);
        $this->display('college/my_classmate');
    }

    /**
     * 班级教师
     */
    public function teachers() {
        $roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo',$roominfo);
        $param = parsequery();
        $cmodel = $this->model('changeclass');
        $myclass = $cmodel->getCurrentClassForStudent($this->user['uid'], $roominfo['crid']);
        if (empty($myclass)) {
            exit;
        }
        //班级教师人数统计
        $teacher_count = $cmodel->classTeacherCount($myclass['classid']);
        if ($teacher_count === false) {
            exit;
        }
        $pagestr = show_page($teacher_count, $param['pagesize']);

        if ($teacher_count > 0) {
            $teachers = $cmodel->classTeacher($myclass['classid'], $this->user['uid'], $param['page']);
            $this->assign('teachers', $teachers);
        }


        $change_info = $cmodel->getChangeInfo($this->user['uid'], $roominfo['crid'], $myclass['classid']);

        $this->assign('myclass', $myclass);
        $this->assign('change_info', $change_info);
        $this->assign('pagestr',$pagestr);
        $this->display('college/my_teachers');
    }

    /**
     * 关注
     */
    public function ajax_follow() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '非法操作'
            ));
            exit;
        }
        $fuid = intval($this->input->post('fuid'));
        if ($fuid < 1) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '非法操作'
            ));
            exit;
        }
        $cmodel = $this->model('changeclass');
        $ret = $cmodel->follow($this->user['uid'], $fuid);
        if (empty($ret)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '关注失败'
            ));
            exit;
        }
        echo json_encode(array(
            'errno' => 0,
            'data' => array(
                'newid' => $ret
            )
        ));
        exit;
    }

    /**
     * 取消关注
     */
    public function ajax_unfollow() {
        echo json_encode(array(
            'errno' => 20,
            'msg' => '已禁用取消关注功能'
        ));
        exit;
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '非法操作'
            ));
            exit;
        }
        $fuid = intval($this->input->post('fuid'));
        if ($fuid < 1) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '非法操作'
            ));
            exit;
        }
        $cmodel = $this->model('changeclass');
        $ret = $cmodel->unfollow($this->user['uid'], $fuid);
        if (empty($ret)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '取消失败'
            ));
            exit;
        }
        echo json_encode(array(
            'errno' => 0
        ));
        exit;
    }

    /**
     * 发私信
     */
    public function ajax_send_message() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '非法操作'
            ));
            exit;
        }
        $tid = intval($this->input->post('tid'));
        $message = H(strval($this->input->post('message')));
        if (empty($message) || $tid < 1) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '参数不完整'
            ));
            exit;
        }
        $messageLib = Ebh::app()->lib('EMessage');

        if ($messageLib->sendMessage($this->user['uid'], $this->user['username'], $tid, 0, 3, $message)) {
            echo json_encode(array(
                'errno' => 0
            ));
            exit;
        }
        echo json_encode(array(
            'errno' => 4,
            'msg' => '未知错误'
        ));
        exit;
    }

    /**
     * 升班操作
     */
    public function ajax_change_class() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '非法操作'
            ));
            exit;
        }
        $sourceid = intval($this->input->post('sourceid'));
        $classid = intval($this->input->post('classid'));
        $changelogid = intval($this->input->post('changelogid'));
        if ($sourceid < 1 || $classid < 1) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '非法操作'
            ));
            exit;
        }
        $errcode = 0;
        $roominfo = Ebh::app()->room->getcurroom();
        $model = $this->model('changeclass');
        $ret = $model->changeClassBySelf(array(
            'uid' => $this->user['uid'],
            'crid' => $roominfo['crid'],
            'sourceid' => $sourceid,
            'classid' => $classid,
            'changelogid' => $changelogid
        ), $errcode);

        if ($ret) {
            echo json_encode(array(
                'errno' => 0,
                'data' => array('newid' => $ret)
            ));
            exit;
        }
        if ($errcode == 1) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '不在升班截止时间内，升班失败'
            ));
            exit;
        }
        echo json_encode(array(
            'errno' => 4,
            'msg' => '未知错误'
        ));
        exit;
    }
}