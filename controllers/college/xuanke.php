<?php
class XuankeController extends CControl {
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
     * 选课动态
     */
    public function index() {
        $roominfo = Ebh::app()->room->getcurroom();
        $param = parsequery();
        $activity = $this->model('Xuanke');
        $param['crid'] = $roominfo['crid'];
        $param['status'] = 3;
        $count = $activity->getListCount($param);
        $pagestr = show_page($count, $param['pagesize']);
        $activity_list = $activity->getListWithStatus($param);
        $this->assign('list', $activity_list);
        $this->assign('pagestr',$pagestr);
        $this->display('college/xuanke/index');
    }

    /**
     * 选课动态
     */
    public function msgs() {
        $roominfo = Ebh::app()->room->getcurroom();
        $aid = intval($this->input->get('xkid'));
        $xuanke = $this->model('xuanke');
        $activity = $xuanke->getActivity(array(
            'xkid' => $aid,
            'crid' => $roominfo['crid']
        ));
        if($activity === false) {
            header("location:/college/xuanke.html");
            exit;
        }

        $courselist = $xuanke->getActivityCourse(array(
            'xkid'=>$aid,
            'crid'=>$roominfo['crid']
        ));
        $valid = false;
        if(empty($courselist) === false) {
            $mycourses = $xuanke->getMySign($this->user['uid'], $aid, 0);
            if($class_info = $xuanke->getClassInfo($this->user['uid'], $roominfo['crid'])) {
                $my_grades = array_column($class_info, 'grade');
                $my_grades = array_unique($my_grades);
                $my_classes = array_column($class_info, 'classid');
                $my_classes = array_unique($my_classes);
                unset($class_info);
            } else {
                $my_grades = array();
                $my_classes = array();
            }


            foreach($courselist as $key => $value) {
                //过滤选课
                $range = explode(',', $value['range_args']);
                if (!empty($mycourses) && isset($mycourses[$key])) {
                    $courselist[$key]['v'] = true;
                } else if($value['range_type'] == 1) {
                    foreach($my_grades as $gi) {
                        if(in_array($gi, $range) === true) {
                            $courselist[$key]['v'] = true;
                            break;
                        }
                    }
                } else if($value['range_type'] == 2) {
                    foreach($my_classes as $ci) {
                        if(in_array($ci, $range) === true) {
                            $courselist[$key]['v'] = true;
                            break;
                        }
                    }
                } else {
                    $courselist[$key]['v'] = true;
                }
            }

            $courselist = array_filter($courselist, function($a) {
                return isset($a['v']);
            });

            if(empty($courselist) === false) {
                $valid = true;
            }
        }

        if ($valid === true) {
            $xuankemsg = $this->model('Xuankemsg');
            $uid = $this->user['uid'];
            $messages = $xuankemsg->readStudentMsg($aid, $uid);
            $this->assign('messages', $messages);
        }
        $rule = $this->model('xuanke')->getRule(array('xkid'=>$activity['xkid']));
        $this->assign('rule',$rule);
        $this->assign('activity', $activity);
        $this->assign('aid', $aid);
        $this->display('college/xuanke/msgs');
    }

    /**
     * 我的课程
     */
    public function mycourse() {
        $xuanke = $this->model('xuanke');
        $roominfo = Ebh::app()->room->getcurroom();
        $aid = intval($this->input->get('xkid'));

        $activity = $xuanke->getActivity(array(
            'xkid' => $aid,
            'crid' => $roominfo['crid']
        ));
        if($activity === false) {
            header("location:/college/xuanke.html");
            exit;
        }

        /*if($activity['status'] >= 5) {
            $step = $activity['status'] >= 7 ? 0 : 1;
            $courselist = $xuanke->getStudentCourses($this->user['uid'], $aid, $step);
            if (empty($courselist) === false) {
                $_UP = Ebh::app()->getConfig()->load('upconfig');
                $image_server = $_UP['xk']['showpath'];
                foreach($courselist as $key => $value) {
                    $tmp = json_decode($value['images']);
                    $images = array();
                    foreach($tmp as $item) {
                        $path_info = pathinfo($item);
                        $thumb = sprintf('%s%s/%s_th.%s', $image_server,
                            $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                        $images[$thumb] = $image_server . $item;
                    }
                    $courselist[$key]['images'] = $images;
                    $survey = $this->model('survey')->getSurveyByCid(array('cid'=>$value['cid']));
                    if($survey){
                        $courselist[$key]['sid'] = $survey['sid'];
                        $courselist[$key]['s_starttime'] = $survey['startdate'];
                        $courselist[$key]['s_endtime'] = $survey['enddate'];
                        //是否做过该问卷
                        $surveyanswer = $this->model('survey')->ifAnswered(array('sid'=>$survey['sid'],'uid'=>$this->user['uid']));
                        if(!empty($surveyanswer)){
                            $courselist[$key]['join']=1;
                        }else{
                            $courselist[$key]['join']=0;
                        }
                    }

                }
            }
            $this->assign('courselist', $courselist);
        }*/

        $courselist = $xuanke->getStudentCourses($this->user['uid'], $aid, 0);
        if (empty($courselist) === false) {
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            foreach($courselist as $key => $value) {
                $tmp = json_decode($value['images']);
                $images = array();
                foreach($tmp as $item) {
                    $path_info = pathinfo($item);
                    $thumb = sprintf('%s%s/%s_th.%s', $image_server,
                        $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                    $images[$thumb] = $image_server . $item;
                }
                $courselist[$key]['images'] = $images;
                $survey = $this->model('survey')->getSurveyByCid(array('cid'=>$value['cid']));
                if($survey){
                    $courselist[$key]['sid'] = $survey['sid'];
                    $courselist[$key]['s_starttime'] = $survey['startdate'];
                    $courselist[$key]['s_endtime'] = $survey['enddate'];
                    //是否做过该问卷
                    $surveyanswer = $this->model('survey')->ifAnswered(array('sid'=>$survey['sid'],'uid'=>$this->user['uid']));
                    if(!empty($surveyanswer)){
                        $courselist[$key]['join']=1;
                    }else{
                        $courselist[$key]['join']=0;
                    }
                }

            }
        }
        $this->assign('courselist', $courselist);

        $this->assign('aid', $aid);
        $this->assign('activity', $activity);
        $this->display('college/xuanke/mycourse');
    }

    /**
     * 选课
     */
    public function sign() {
        $room = Ebh::app()->room->getcurroom();
        $_timeRange = Ebh::app()->getConfig()->load('othersetting');
        if (isset($_timeRange['time_rangs'][$room['crid']])) {
            $timeRange = $_timeRange['time_rangs'][$room['crid']];
        } else if (isset($_timeRange['time_rangs'][0])) {
            $timeRange = $_timeRange['time_rangs'][0];
        } else {
            $timeRange = array(
                0 => '上午', 1 => '下午'
            );
        }
        $xuanke = $this->model('xuanke');
        $roominfo = Ebh::app()->room->getcurroom();
        $aid = intval($this->input->get('xkid'));
        $activity = $xuanke->getActivity(array(
            'xkid' => $aid,
            'crid' => $roominfo['crid']
        ));
        if($activity === false) {
            header("location:/college/xuanke.html");
            exit;
        }
        $param = parsequery();
        $step = 0;
        if($activity['status'] == 3) {
            //第一轮选课
            $rule = $xuanke->getRule(array(
                'xkid' => $activity['xkid'],
                'step' => 1
            ));
            $step = 1;
        } else if($activity['status'] == 5) {
            //第二轮选课
            $rule = $xuanke->getRule(array(
                'xkid' => $activity['xkid'],
                'step' => 2
            ));
            $step = 2;
        }

        if(empty($rule) || $rule['end_t'] < SYSTIME) {
            header("location:/college/xuanke.html");
            exit;
        }
        $valid = $rule['start_t'] > SYSTIME  ? false : true;
        $courselist = $xuanke->getActivityCourse(array(
            'xkid'=>$aid,
            'crid'=>$roominfo['crid']
        ));


        if(empty($courselist) === false) {
            if ($class_info = $xuanke->getClassInfo($this->user['uid'], $roominfo['crid'])) {
                $my_grades = array_column($class_info, 'grade');
                $my_grades = array_unique($my_grades);
                $my_classes = array_column($class_info, 'classid');
                $my_classes = array_unique($my_classes);
            } else {
                $my_classes = array();
                $my_grades = array();
            }

            $aps = array();
            if ($mysign = $xuanke->getMySign($this->user['uid'], $activity['xkid'], 0)) {
                foreach ($mysign as $cid => $sign_item) {
                    if (array_key_exists($cid, $courselist)) {
                        $courselist[$cid]['sign_type'] = $sign_item['status'];
                        $aps[] = $courselist[$cid]['ap'];

                        if ($step == 2 && $sign_item['bout'] == 1) {
                            $courselist[$cid]['signed_finish'] = true;
                            continue;
                        }
                        $courselist[$cid]['signed'] = true;
                    }
                }
                unset($mysign);
            }
            if (in_array(2, $aps)) {
                $aps[] = 1;
                $aps[] = 0;
            }
            if (!empty($aps)) {
                $aps[] = 2;
            }
            $aps = array_unique($aps);
            if (!empty($activity['ispause'])) {
                //暂停报名
                $aps = array(0, 1, 2);
            }
            $this->assign('aps', $aps);

            foreach($courselist as $key => $value) {
                if (isset($value['sign_type']) && $value['sign_type'] == 2) {
                    $courselist[$key]['v'] = true;
                    continue;
                }
                //过滤选课
                $range = explode(',', $value['range_args']);
                if($value['range_type'] == 1) {
                    foreach($my_grades as $gi) {
                        if(in_array($gi, $range) === true) {
                            $courselist[$key]['v'] = true;
                            break;
                        }
                    }
                } else if($value['range_type'] == 2) {
                    foreach($my_classes as $ci) {
                        if(in_array($ci, $range) === true) {
                            $courselist[$key]['v'] = true;
                            break;
                        }
                    }
                } else {
                    $courselist[$key]['v'] = true;
                }
            }

            $courselist = array_filter($courselist, function($a) {
                return isset($a['v']);
            });

            if(empty($courselist) === false) {
                $_UP = Ebh::app()->getConfig()->load('upconfig');
                $image_server = $_UP['xk']['showpath'];
                foreach($courselist as $key => $value) {
                    $tmp = json_decode($value['images']);
                    $images = array();
                    foreach ($tmp as $item) {
                        $path_info = pathinfo($item);
                        $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                        $images[$thumb] = $image_server . $item;
                    }
                    $courselist[$key]['images'] = $images;
                }
            }

        }
        $ap = $this->input->get('ap');
        if ($ap !== null) {
            $ap = intval($ap);
            $ap = isset($timeRange[$ap]) ? $ap : 0;
            foreach ($courselist as $cid => $course) {
                if ($course['ap'] == $ap) {
                    continue;
                }
                unset($courselist[$cid]);
            }
            $this->assign('ap', $ap);
        }
        $page = $param['page'];
        $page = max(1, $page);
        $pagesize = 20;
        $offset = ($page - 1) * $pagesize;
        $count = count($courselist);
        $pagestr = show_page($count, $pagesize);
        $courselist = array_slice($courselist, $offset, $pagesize);
        $this->assign('activity', $activity);
        $this->assign('timeRange', $timeRange);
        $this->assign('valid', $valid);
        $this->assign('rule', $rule);
        $this->assign('courselist', $courselist);
        $this->assign('pagestr', $pagestr);
        $this->assign('step', $step);
        $this->display('college/xuanke/sign');
    }

    /**
     * 我报名的课程
     */
    public function signcourse() {
        $xuanke = $this->model('xuanke');
        $roominfo = Ebh::app()->room->getcurroom();
        $aid = intval($this->input->get('xkid'));
        $step = intval($this->input->get('step'));

        $activity = $xuanke->getActivity(array(
            'xkid' => $aid,
            'crid' => $roominfo['crid']
        ));
        if($activity === false || in_array($step, array(1,2)) === false) {
            header("location:/college/xuanke.html");
            exit;
        }

        $user = Ebh::app()->user->getloginuser();

        $courselist = $xuanke->getStudentCourses($user['uid'], $aid, $step);
        if(empty($courselist) === false) {
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            foreach($courselist as $key => $value) {
                $tmp = json_decode($value['images']);
                $images = array();
                foreach($tmp as $item) {
                    $path_info = pathinfo($item);
                    $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                    $images[$thumb] = $image_server . $item;
                }
                $courselist[$key]['images'] = $images;
            }
        }

        $this->assign('courselist', $courselist);

        $this->assign('aid', $aid);
        $this->assign('activity', $activity);

        $this->display('college/xuanke/signcourse');
    }

    public function _err_ajax() {
        $json = array(
            'errno' => 1,
            'msg' => '非法操作'
        );
        echo json_encode($json);
        exit;
    }
    /**
     * 学生报名
     */
    public function ajax_sign() {
        $user = Ebh::app()->user->getloginuser();
        $roominfo = Ebh::app()->room->getcurroom();
        $cid = intval($this->input->post('cid'));
        $xkid = intval($this->input->post('xkid'));

        $xuanke = $this->model('xuanke');

        $activity = $xuanke->getActivity(array('xkid'=>$xkid, 'crid'=>$roominfo['crid']));
        if(empty($activity)) {
            $this->_err_ajax();
        }
        if (!empty($activity['ispause'])) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '报名已暂停，本次操作无效'
            ));
            exit();
        }
        $course = $xuanke->getSingleCourse($cid, $xkid);
        if(empty($course)) {
            $this->_err_ajax();
        }
        $class_info = $xuanke->getClassInfo($user['uid'], $roominfo['crid']);
        $result = false;
        $room = Ebh::app()->room->getcurroom();
        $_timeRange = Ebh::app()->getConfig()->load('othersetting');
        if (isset($_timeRange['time_rangs'][$room['crid']])) {
            $timeRange = $_timeRange['time_rangs'][$room['crid']];
        } else if (isset($_timeRange['time_rangs'][0])) {
            $timeRange = $_timeRange['time_rangs'][0];
        } else {
            $timeRange = array(
                0 => '上午', 1 => '下午'
            );
        }
        if($activity['status'] == 3) {
            //第一轮报名
            if($course['studentsnum'] >= $course['classnum']) {
                $json = array(
                    'errno' => 2,
                    'msg' => '报名名额已满，报名失败'
                );
                echo json_encode($json);
                exit;
            }

            if($course['range_type'] == 1) {
                //限年级
                $my_grades = empty($class_info) === true ? array() : array_column($class_info, 'grade');
                $grade_range = explode(',', $course['range_args']);
                $valid = false;
                foreach($my_grades as $gitem) {
                    if(in_array($gitem, $grade_range) === true) {
                        $valid = true;
                        break;
                    }
                }
                if($valid === false) {
                    $json = array(
                        'errno' => 1,
                        'msg' => '你不在报名范围内，报名失败'
                    );
                    echo json_encode($json);
                    exit;
                }
            } else if($course['range_type'] == 2) {
                //限班级
                $my_classes = empty($class_info) === true ? array() : array_column($class_info, 'classid');
                $class_range = explode(',', $course['range_args']);
                $valid = false;
                foreach($my_classes as $classitem) {
                    if(in_array($classitem, $class_range) === true) {
                        $valid = true;
                        break;
                    }
                }
                if($valid === false) {
                    $json = array(
                        'errno' => 1,
                        'msg' => '你不在报名范围内，报名失败'
                    );
                    echo json_encode($json);
                    exit;
                }
            } else {
                $is_student = $xuanke->is_student($user['uid'], $roominfo['crid']);
                if (!$is_student) {
                    $json = array(
                        'errno' => 1,
                        'msg' => '你不在报名范围内，报名失败'
                    );
                    echo json_encode($json);
                    exit;
                }
            }

            $rule = $xuanke->getRule(array('xkid'=>$xkid,'step'=>1));
            if(empty($rule)) {
                $this->_err_ajax();
            }
            if($rule['end_t'] < SYSTIME) {
                $json = array(
                    'errno' => 1,
                    'msg' => '报名已结束'
                );
                echo json_encode($json);
                exit;
            }
            if($rule['start_t'] > SYSTIME) {
                $json = array(
                    'errno' => 1,
                    'msg' => '报名未开始'
                );
                echo json_encode($json);
                exit;
            }
            $sign_count = $xuanke->getStudentSignCount($xkid, $user['uid']);
            if($sign_count >= $rule['max_sign_count']) {
                $json = array(
                    'errno' => 1,
                    'msg' => sprintf('每个学生最多只能报名%d门课，报名失败', $sign_count)
                );
                echo json_encode($json);
                exit;
            }

            $repeat_ap = $xuanke->checkRepeatAp($user['uid'], $xkid, $course['ap']);
            if ($repeat_ap !== false) {
                $json = array(
                    'errno' => 1,
                    'msg' => sprintf('你已报过%s课程，报名失败', $timeRange[$repeat_ap])
                );
                echo json_encode($json);
                exit();
            }

            if ($xuanke->is_signed(array(
                'xkid'=>$xkid,
                'cid'=>$cid,
                'uid'=> $user['uid']))) {
                $json = array(
                    'errno' => 1,
                    'msg' => sprintf('你已报名%s课程', $course['coursename'])
                );
                echo json_encode($json);
                exit;
            }


            $result = $xuanke->sign(array(
                'xkid'=>$xkid,
                'cid'=>$cid,
                'uid'=> $user['uid'],
                'bout'=>1,
                'sign_time'=>SYSTIME,
                'classname'=>$class_info[0]['classname']
            ));
        }

        if($activity['status'] == 5) {
            //第二轮报名
            if($course['studentsnum'] >= $course['classnum']) {
                $json = array(
                    'errno' => 2,
                    'msg' => '报名名额已满，报名失败'
                );
                echo json_encode($json);
                exit;
            }

            if($course['range_type'] == 1) {
                //限年级
                $grade_range = explode(',', $course['range_args']);
                $my_grades = array_column($class_info, 'grade');
                $valid = false;
                foreach($my_grades as $gitem) {
                    if(in_array($gitem, $grade_range) === true) {
                        $valid = true;
                        break;
                    }
                }
                if($valid === false) {
                    $json = array(
                        'errno' => 1,
                        'msg' => '你不在报名范围内，报名失败'
                    );
                    echo json_encode($json);
                    exit;
                }
            } else if($course['range_type'] == 2) {
                //限班级
                $class_range = explode(',', $course['range_args']);
                $my_classes = array_column($class_info, 'classid');
                $valid = false;
                foreach($my_classes as $classitem) {
                    if(in_array($classitem, $class_range) === true) {
                        $valid = true;
                        break;
                    }
                }
                if($valid === false) {
                    $json = array(
                        'errno' => 1,
                        'msg' => '你不在报名范围内，报名失败'
                    );
                    echo json_encode($json);
                    exit;
                }
            } else {
                $is_student = $xuanke->is_student($user['uid'], $roominfo['crid']);
                if (!$is_student) {
                    $json = array(
                        'errno' => 1,
                        'msg' => '你不在报名范围内，报名失败'
                    );
                    echo json_encode($json);
                    exit;
                }
            }

            $rule = $xuanke->getRule(array('xkid'=>$xkid,'step'=>2));
            if(empty($rule)) {
                $this->_err_ajax();
            }
            if($rule['end_t'] < SYSTIME) {
                $json = array(
                    'errno' => 1,
                    'msg' => '报名已结束'
                );
                echo json_encode($json);
                exit;
            }
            if($rule['start_t'] > SYSTIME) {
                $json = array(
                    'errno' => 1,
                    'msg' => '报名未开始'
                );
                echo json_encode($json);
                exit;
            }
            $sign_count = $xuanke->getStudentSignCount($xkid, $user['uid']);
            if($sign_count >= $rule['max_sign_count']) {
                $json = array(
                    'errno' => 1,
                    'msg' => sprintf('每个学生最多只能报名%d门课，报名失败', $sign_count)
                );
                echo json_encode($json);
                exit;
            }
            $repeat_ap = $xuanke->checkRepeatAp($user['uid'], $xkid, $course['ap']);
            if ($repeat_ap !== false) {
                $json = array(
                    'errno' => 1,
                    'msg' => sprintf('你已报过%s课程，报名失败', $timeRange[$repeat_ap])
                );
                echo json_encode($json);
                exit();
            }
            if ($xuanke->is_signed(array(
                'xkid'=>$xkid,
                'cid'=>$cid,
                'uid'=> $user['uid']))) {
                $json = array(
                    'errno' => 1,
                    'msg' => sprintf('你已报名%s课程', $course['coursename'])
                );
                echo json_encode($json);
                exit;
            }

            $result = $xuanke->sign(array(
                'xkid'=>$xkid,
                'cid'=>$cid,
                'uid'=> $user['uid'],
                'bout'=>2,
                'sign_time'=>SYSTIME,
                'classname'=>$class_info[0]['classname']
            ));
        }

        if($result === true) {
            //报名成功后消息
            $msgModel = $this->model('Xuankemsg');
            $msgModel->signMessage($xkid, $cid, $user['uid'], 1);
            $json = array(
                'errno' => 0,
                'msg' => '报名成功'
            );
            echo json_encode($json);
            exit;
        }
        $json = array(
            'errno' => 1,
            'msg' => '报名失败'
        );
        echo json_encode($json);
        exit;
    }

    /**
     * 学生取消报名
     */
    public function ajax_cancel_sign() {
        $roominfo = Ebh::app()->room->getcurroom();
        $cid = intval($this->input->post('cid'));
        $xkid = intval($this->input->post('xkid'));
        $xuanke = $this->model('xuanke');
        $activity = $xuanke->getActivity(array('xkid'=>$xkid, 'crid'=>$roominfo['crid']));
        if(empty($activity)) {
            $this->_err_ajax();
        }
        if (!empty($activity['ispause'])) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '报名已暂停，本次操作无效'
            ));
            exit();
        }
        $rules = $xuanke->getRules($xkid);
        if (empty($rules) === true) {
            $json = array(
                'errno' => 100,
                'msg' => '非法操作'
            );
            echo json_encode($json);
            exit;
        }

        if ($rules[0]['start_t'] > SYSTIME || $rules[0]['end_t'] < SYSTIME) {
            $json = array(
                'errno' => 100,
                'msg' => '无法取消报名'
            );
            echo json_encode($json);
            exit;
        }
        if($xuanke->cancel_sign(array(
            'xkid'=>$xkid,
            'cid'=>$cid,
            'uid'=> $this->user['uid'],
            'bout' => $rules[0]['step']
        ))) {
            //取消报名消息
            $msgModel = $this->model('xuankemsg');
            $msgModel->signMessage($xkid, $cid, $this->user['uid'], 0);
            $json = array(
                'errno' => 0
            );
            echo json_encode($json);
            exit;
        }
        $json = array(
            'errno' => 1,
            'msg' => '取消报名失败'
        );
        echo json_encode($json);
        exit;
    }

    public function activityStatus($activity) {
        if($activity['status'] < 3) {
            if($activity['starttime'] > SYSTIME) {
                return '等待课程申报';
            }
            if($activity['endtime'] <= SYSTIME) {
                return '课程申报结束';
            }
            return '课程申报中';
        }

        if($activity['status'] == 3) {
            if(!empty($activity['end_t']) && $activity['end_t'] <= SYSTIME) {
                return '第一轮选课结束';
            }
            return '第一轮选课进行中';
        }

        if($activity['status'] == 5) {
            if(!empty($activity['end_t_2']) && $activity['end_t_2'] <= SYSTIME) {
                return '第二轮选课结束';
            }
            return '第二轮选课进行中';
        }

        if($activity['status'] == 7) {
            return '活动结束';
        }

        if($activity['status'] == 8) {
            $xuanke = $this->model('xuanke');
            $sur = $xuanke->getSurveyTime($activity['xkid']);
            if(empty($sur) === false) {
                if($sur['enddate'] < SYSTIME) {
                    return '课程评价结束';
                }
            }
            return '课程评价进行中';
        }

        if($activity['status'] > 8) {
            return '课程评价结束';
        }

        return $activity['status'];
    }

    //验证学生是否可以参与问卷
    public function isjoin(){
        $get = $this->input->get();
        $param['uid'] = intval($this->user['uid']);
        $param['sid'] = intval($get['sid']);//问卷id
        $res = $this->model('xuanke')->isJoin($param);
        if($res){
            header('location:/college/survey/fill/'.$get['sid'].'.html?autoclose=1');
        }else{
            echo '不能参与问卷';
        }

    }
}