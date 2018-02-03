<?php

/**
 * Created by PhpStorm.
 * User: ycq
 * Date: 2016/9/20
 * Time: 10:46
 */
class ChangeclassController extends CControl {
    private $user;
    private $is_ajax = false;
    public function __construct()
    {
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->is_ajax = true;
        }
        if(empty($this->user) === true) {
            if ($this->is_ajax) {
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

    public function index()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $model = $this->model('changeclass');
        $r_pid = 0;
        $r_classid = 0;
        $r_classname = '';
        $r_ctype = 1;
        $r_starttime = '';
        $r_endtime = '';
        $r_class_arr = array();
        $classes = $model->getClasses($roominfo['crid']);

        if ($this->isPost()) {
            if (empty($classes)) {
                if ($this->is_ajax) {
                    echo json_encode(array(
                        'errno' => 0
                    ));
                    exit;
                }
                //保存成功跳转
                header('location:/aroomv2/classes.html');
                exit;
            }
            $valid = true;
            $sourceid = intval($this->input->post('sourceid'));
            $r_ctype = intval($this->input->post('ctype'));
            $r_pid = intval($this->input->post('pid'));
            $r_classid = intval($this->input->post('classid'));
            $classid_arr = $this->input->post('classids');
            $r_starttime = strtotime($this->input->post('starttime'));
            $r_endtime = strtotime($this->input->post('endtime'));

            $msg = '';

            if ($r_ctype == 1 && ($r_classid < 1 || $sourceid < 1 || !key_exists($r_classid, $classes))) {
                $r_classid = 0;
                $msg = '升班目标班级无效';
                $valid = false;
            }
            if ($valid && $r_ctype == 2 &&
                ($sourceid < 1 || $r_starttime < 1 || $r_endtime < 1 || $r_starttime > $r_endtime || $r_endtime < SYSTIME || empty($classid_arr))) {
                $valid = false;
                $msg = '日期设置错误';
            }

            if (!$valid && $this->is_ajax) {
                echo json_encode(array(
                    'errno' => 2,
                    'msg' => $msg
                ));
                exit;
            }

            if ($r_ctype == 1 && $r_classid > 0) {
                $r_classname = $classes[$r_classid]['classname'];
                $r_class_arr = array();
            }

            if ($r_ctype == 2 && !empty($classid_arr)) {
                $keys = array_flip($classid_arr);
                $r_class_arr = array_intersect_key($classes, $keys);
                $r_classid = 0;
                $r_classname = '';
            }
            $errcode = 0;
            if ($valid) {
                if ($r_ctype == 1) {
                    $ret = $model->changeClass(array(
                        'crid' => $roominfo['crid'],
                        'sourceid' => $sourceid,
                        'uid' => $this->user['uid'],
                        'classid' => $r_classid
                    ), $errcode);
                } else {
                    $ret = $model->changeClass(array(
                        'crid' => $roominfo['crid'],
                        'sourceid' => $sourceid,
                        'starttime' => $r_starttime,
                        'endtime' => $r_endtime,
                        'uid' => $this->user['uid'],
                        'classids' => $classid_arr,
                        'pid' => $r_pid
                    ), $errcode);
                }
                if ($ret) {
                    if ($this->is_ajax) {
                        echo json_encode(array(
                            'errno' => 0
                        ));
                        exit;
                    }
                    //保存成功跳转
                    header('location:/aroomv2/classes.html');
                }
                if (!$ret) {
                    echo json_encode(array(
                        'errno' => $errcode,
                        'msg' => '升班设置失败'
                    ));
                    exit;
                }
            }
            //header('location:/aroomv2/classes.html');
        }
        $classid = intval($this->input->get('classid'));

        $classitem = $model->getClass(array(
            'uid' => $this->user['uid'],
            'crid' => $roominfo['crid'],
            'classid' => $classid
        ));

        if (empty($classitem)) {
            header("location:/aroomv2/classes.html");
            exit;
        }


        if (!$this->isPost() && ($change_plan = $model->getChangePlan($this->user['uid'], $roominfo['crid'], $classid))) {
            $r_pid = $change_plan['pid'];
            $r_ctype = 2;
            $r_starttime = date('Y-m-d H:i', $change_plan['starttime']);
            $r_endtime = date('Y-m-d H:i', $change_plan['endtime']);
            $r_class_arr = $change_plan['classes'];
        }
        unset($classes[$classid]);
        $this->assign('class', $classitem);
        $this->assign('classes', $classes);

        $this->assign('r_pid', $r_pid);
        $this->assign('r_ctype', $r_ctype);
        $this->assign('r_classid', $r_classid);
        $this->assign('r_classname', $r_classname);
        $this->assign('r_class_arr', $r_class_arr);
        $this->assign('r_starttime', $r_starttime);
        $this->assign('r_endtime', $r_endtime);

        $this->display('aroomv2/change_class');
    }
}