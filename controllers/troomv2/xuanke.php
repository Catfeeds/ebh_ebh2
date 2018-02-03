<?php
/*
 * 选课
 */
class XuankeController extends CControl {
    private $user;
    private $timeRange;
    public function __construct()
    {
        parent::__construct();
        $this->user = Ebh::app()->user->getloginuser();
        if(empty($this->user) === true) {
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
        $_timeRange = Ebh::app()->getConfig()->load('othersetting');
        $room = Ebh::app()->room->getcurroom();
        if (isset($_timeRange['time_rangs'][$room['crid']])) {
            $this->timeRange = $_timeRange['time_rangs'][$room['crid']];
        } else if (isset($_timeRange['time_rangs'][0])) {
            $this->timeRange = $_timeRange['time_rangs'][0];
        } else {
            $this->timeRange = array(
                0 => '上午', 1 => '下午'
            );
        }

        $this->assign('timeRange', $this->timeRange);
    }

    /*
     * 选课活动列表
     */
	public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
        $param = parsequery();
        $activity = $this->model('Xuanke');
        $param['crid'] = $roominfo['crid'];
        $count = $activity->getListCount($param);
        $pagestr = show_page($count, $param['pagesize']);
        $activity_list = $activity->getListWithStatus($param);
        $this->assign('list', $activity_list);
        $this->assign('pagestr',$pagestr);
		//获取modulename
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'xuanke','tors'=>1,'crid'=>$roominfo['crid']));
        $this->display('troomv2/xuanke/teacher_activity');
	}

    /**
     * 消息列表
     */
	public function msglist() {
        $roominfo = Ebh::app()->room->getcurroom();
        $aid = intval($this->input->get('aid'));
        $xuanke = $this->model('xuanke');
        $activity = $xuanke->getXuanke(array(
            'xkid' => $aid,
            'crid' => $roominfo['crid']
        ));

        if(empty($activity)) {
            header("location:/troomv2/xuanke.html");
            exit;
        }
        $xuankemsg = $this->model('Xuankemsg');

        $uid = $this->user['uid'];//12187
        $messages = $xuankemsg->readTeacherMsg($aid, $uid);

        //print_r($messages);exit;

        $this->assign('messages', $messages);
        $this->assign('activity', $activity);
        $this->assign('aid', $aid);
        $this->display('troomv2/xuanke/teacher_msgs');
    }

    /**
     * 我的课程
     */
    public function mycourse() {
        $aid = intval($this->input->get('aid'));
        $roominfo = Ebh::app()->room->getcurroom();
        $xuanke = $this->model('xuanke');

        $t = $this->input->get('t');
        $activity = $xuanke->getXuanke(array(
            'xkid' => $aid,
            'crid' => $roominfo['crid']
        ));

        if(empty($activity)) {
            header("location:/troomv2/xuanke.html");
            exit;
        }

        $courses = $xuanke->getOwnCourse($aid, $this->user['uid']);

        if ($courses) {
            foreach ($courses as &$course) {
                if ($course['range_type'] == 1) {
                    $vArr = array(
                        1=> '一年级',
                        2 => '二年级',
                        3=> '三年级',
                        4 => '四年级',
                        5=> '五年级',
                        6 => '六年级',
                        7 => '初一',
                        8 => '初二',
                        9 => '初三',
                        10 => '高一',
                        11 => '高二',
                        12 => '高三'
                    );
                    $aArr = explode(',', $course['range_args']);
                    $tmp = array();
                    foreach($aArr as $item) {
                        if(array_key_exists($item, $vArr)) {
                            $tmp[] = $vArr[$item];
                        }
                    }
                    $course['range'] = implode('、', $tmp);
                } else if ($course['range_type'] == 2) {
                    $classes = $this->model('classes');
                    if ($classArr = $classes->getClassList($roominfo['crid'], $course['range_args'])) {
                        $tmp = array_column($classArr, 'classname');
                        $course['range'] = implode('、', $tmp);
                    }
                } else {
                    $course['range'] = '全年级';
                }

                $tmp = json_decode($course['images']);
                $images = array();
                $_UP = Ebh::app()->getConfig()->load('upconfig');
                $image_server = $_UP['xk']['showpath'];
                foreach($tmp as $item) {
                    $path_info = pathinfo($item);
                    $thumb = sprintf('%s%s/%s_th.%s', $image_server,
                        $path_info['dirname'], $path_info['filename'], $path_info['extension']);
                    $images[$thumb] = $image_server . $item;
                }
                $course['images'] = $images;
            }
        }
        $this->assign('courses', $courses);
        $this->assign('t', $t);
        $this->assign('aid', $aid);
        $this->assign('activity', $activity);
        $this->display('troomv2/xuanke/mycourse');
    }

    /**
     * 报名结果
     */
    public function signresult() {
        $aid = intval($this->input->get('aid'));
        $roominfo = Ebh::app()->room->getcurroom();
        $xuanke = $this->model('xuanke');
        $activity = $xuanke->getXuanke(array(
            'xkid' => $aid,
            'crid' => $roominfo['crid']
        ));
        if(empty($activity)) {
            header("location:/troomv2/xuanke.html");
            exit;
        }
        $cid = intval($this->input->get('cid'));
        $students_count = 0;
        if ($courses = $xuanke->getOwnCourse($aid, $this->user['uid'])) {
            //print_r($courses);exit;
            $course = $cid > 0 && isset($courses[$cid]) ? $courses[$cid] : reset($courses);
            if(true || $activity['status'] >= 7 || $course['classnum'] == $course['studentsnum']) {
                if ($course['range_type'] == 1) {
                    $vArr = array(
                        1=> '一年级',
                        2 => '二年级',
                        3=> '三年级',
                        4 => '四年级',
                        5=> '五年级',
                        6 => '六年级',
                        7 => '初一',
                        8 => '初二',
                        9 => '初三',
                        10 => '高一',
                        11 => '高二',
                        12 => '高三'
                    );
                    $aArr = explode(',', $course['range_args']);
                    $tmp = array();
                    foreach($aArr as $item) {
                        if(array_key_exists($item, $vArr)) {
                            $tmp[] = $vArr[$item];
                        }
                    }
                    $course['range'] = implode('、', $tmp);
                } else if ($course['range_type'] == 2) {
                    $classes = $this->model('classes');
                    $tmp = array();
                    if ($classArr = $classes->getClassList($roominfo['crid'], $course['range_args'])) {
                        $tmp = array_column($classArr, 'classname');
                    }
                    $course['range'] = implode('、', $tmp);
                } else {
                    $course['range'] = '全年级';
                }

                $tmp = json_decode($course['images']);
                $images = array();
                $_UP = Ebh::app()->getConfig()->load('upconfig');
                $image_server = $_UP['xk']['showpath'];
                foreach($tmp as $item) {
                    $path_info = pathinfo($item);
                    $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'],
                        $path_info['filename'], $path_info['extension']);
                    $images[$thumb] = $image_server . $item;
                }
                $course['images'] = $images;
                $students = $xuanke->getStudents(
                    array(
                        'xkid' => $aid,
                        'cid' => $course['cid']
                    )
                );

                if (empty($students) === false && is_array($students)) {
                    $students_count = count($students);
                }

                $this->assign('course', $course);
                $this->assign('students', $students);
                if (count($courses) > 1) {
                    $this->assign('courses', $courses);
                }
            }

        }
        $this->assign('students_count', $students_count);
        $this->assign('aid', $aid);
        $this->assign('activity', $activity);
        $this->display('troomv2/xuanke/signresult');
    }

	/*
	 * 选课申请
	 */
	public function report() {
        $roominfo = Ebh::app()->room->getcurroom();
        $xkid = (int) $this->input->get('xkid');
        $xuanke = $this->model('xuanke');
        $classes = $this->model('classes');
        $classlist = $classes->getroomClassList($roominfo['crid']);
        $ajax = intval($this->input->post('ajax'));
        $ajax = empty($ajax) ? false : true;
        $model = $xuanke->getXuanke(array(
            'xkid' => $xkid,
            'crid' => $roominfo['crid']
        ));
        if (!$model) {
            if($ajax) {
                echo json_encode(array(
                    'errno' => 1,
                    'msg' => '非法操作'
                ));
                exit;
            }
            header("location:/troomv2/xuanke.html");
            exit;
        }
        if ($model['status'] != 1 || $model['starttime'] > SYSTIME || $model['endtime'] < SYSTIME) {
            header("location:/troomv2/xuanke.html");
            exit;
        }
        $cid = intval($this->input->get('cid'));
        $v = $this->input->get('t');
        if (!empty($cid) && !empty($v)) {
            $course1 = $this->model('xuanke')->getCourse(array('cid'=>$cid));
            $grademsg=array();
            $classmsg=array();
            $grade = Ebh::app()->getConfig()->load('grademap');
            $grade[0]='其他班级';
            if($course1['range_type']==1){
                $ids = explode(',',$course1['range_args']);
                foreach($ids as $id){
                    $grademsg[$id]=$grade[$id];
                }
                $course1['rangemsg'] = $grademsg;
            }
            if($course1['range_type']==2){
                $classinfo = $this->model('classes')->getClassList($roominfo['crid'],$course1['range_args']);
                foreach($classinfo as $v){
                    $classmsg[$v['classid']]=$v['classname'];
                }
                $course1['rangemsg'] = $classmsg;
            }
            //图片
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $image_server = $_UP['xk']['showpath'];
            $tmp = json_decode($course1['images']);
            $images = array();
            foreach($tmp as $item) {
                $images[$item] = $image_server . $item;
            }
            $initStudents = $xuanke->getStudentList(array('cid'=> $cid, 'status'=>2, 'crid' => $roominfo['crid'], 'xkid' => $xkid));
            $course1['images'] = $images;
            $course1['initStudents'] = $initStudents;
            $this->assign('cid', $cid);
            $this->assign('course', $course1);
        } else {
            $this->assign('course',array());
        }

        $user = Ebh::app()->user->getloginuser();
        if($cid > 0) {
            $course = $xuanke->getCourseForUpdate($cid);
        } else {
            //$course = $xuanke->getCurrentCourse($xkid, $user['uid']);
        }
        $again = false;

        if(!empty($course)) {
            if($cid > 0) {
                if($course['xkid'] != $model['xkid'] || $course['uid'] != $user['uid']) {
                    header("location:/troomv2/xuanke.html");
                    exit;
                }
            } else {
                if($course['status'] != 0) {
                    if($ajax === true) {
                        echo json_encode(array(
                            'errno' => 1,
                            'msg' => '你已申报过课程，本次申报失败'
                        ));
                        exit;
                    }
                    header("location:/troomv2/xuanke.html");
                    exit;
                }
                $again = true;
            }
        }


        $class = $this->model('classes');
        $classes = $class->getClasses(array(
            'crid' => $roominfo['crid']
        ));
        $grade_class = array();
        if(empty($classes) === false) {
            foreach($classes as $item) {
                if(!array_key_exists($item['grade'], $grade_class)) {
                    $grade_class[$item['grade']] = array();
                }
                $grade_class[$item['grade']][] = $item;
            }
        }

        krsort($grade_class,SORT_NUMERIC);
        unset($classes);

        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $image_server = $_UP['xk']['showpath'];
        if ($this->isPost()) {
            $images = array();
            $post_images = $this->input->post('images');
            if (!empty($post_images)) {
                if (is_array($post_images)) {
                    $images = array_filter($post_images, function($img) {
                        return !empty($img);
                    });
                } else {
                    $images[] = strval($post_images);
                }
            }
            if(count($images) > 20) {
                $images = array_slice($images, 0, 20);
            }

            $images_str = json_encode($images);
            $range_type = intval($this->input->post('range_type'));

            $range_args = array();
            $post_range_args = $this->input->post('range_args');
            if (!empty($post_range_args)) {
                if (is_array($post_range_args)) {
                    $range_args = array_filter($post_range_args, function($arg) {
                        return !empty($arg);
                    });
                } else {
                    $range_args[] = strval($post_range_args);
                }
            }

            if(in_array($range_type, array(0,1,2)) === false) {
                $range_type = 0;
            }
            $ap = intval($this->input->post('ap'));
            $tr = array_keys($this->timeRange);
            if (!in_array($ap, $tr)) {
                $ap = 0;
            }
            $post_data = array(
                'xkid' => $model['xkid'],
                'crid' => $model['crid'],
                'uid' => $user['uid'],
                'coursename' => $this->input->post('coursename'),
                'introduce' => $this->input->post('introduce'),
                'starttime' => strtotime($this->input->post('starttime')),
                'endtime' => strtotime($this->input->post('endtime')) + 86399,
                'classtime' => $this->input->post('classtime'),
                'images' => $images_str,
                'place' => $this->input->post('place'),
                'classnum' => intval($this->input->post('classnum')),
                'range_type' => $range_type,
                'range_args' => implode(',', $range_args),
                'ap' => $ap
            );
            $studentids = $this->input->post('studentids');
            if (is_array($studentids)) {
                $studentids = array_filter($studentids, function($studentid) {
                   return is_numeric($studentid) && $studentid > 0;
                });
                $studentids = array_map('intval', $studentids);
            } else if (is_numeric($studentids)){
                $studentids = array(intval($studentids));
            }
            if (!empty($studentids)) {
                //查询学生的报名状态
                if (count($studentids) > $post_data['classnum']) {
                    echo json_encode(array(
                        'errno' => 1,
                        'msg' => '选择的学生超过名额限制'
                    ));
                    exit;
                }
                $studentReports = $xuanke->checkStudentReportStatus($studentids, $post_data['xkid'], $post_data['crid']);
                if (!empty($studentReports)) {
                    $studentReports = array_map(function($studentReport) {
                        $studentReport['ap'] = explode(',', $studentReport['ap']);
                        $studentReport['cid'] = explode(',', $studentReport['cid']);
                        return $studentReport;
                    }, $studentReports);
                    $st1 = $st2 = $msg = array();
                    foreach ($studentReports as $report) {
                        if ($cid > 0 && in_array($cid, $report['cid'])) {
                            continue;
                        }
                        $showname = !empty($report['realname']) ? $report['realname'] : $report['username'];
                        if (count($report['ap']) > 1) {
                            $st1[] = $showname;
                            continue;
                        }
                        if (in_array($post_data['ap'], $report['ap'])) {
                            $st2[] = $showname;
                        }
                    }
                    if (!empty($st1)) {
                        $msg[] = implode(',', $st1).'报名已达到上限';
                    }
                    if (!empty($st2)) {
                        $msg[] = implode(',', $st2).'已报名上课时间与本次冲突';
                    }
                    if (!empty($msg)) {
                        echo json_encode(array(
                            'errno' => 1,
                            'msg' => implode(';', $msg)
                        ));
                        exit;
                    }
                }
                $studentClass = $xuanke->getClassnameForStudents($studentids, $post_data['crid']);
                $post_data['studentids'] = array_flip($studentids);
                array_walk($post_data['studentids'], function(&$student, $k, $studentClass) {
                    $student = isset($studentClass[$k]) ? $studentClass[$k]['classname'] : '';
                }, $studentClass);
            }
            $valid = true;
            if(empty($post_data['coursename']) || empty($post_data['introduce']) ||
                empty($post_data['starttime']) || empty($post_data['endtime']) ||
                empty($post_data['classtime']) ||
                empty($post_data['place']) || empty($post_data['classnum'])) {
                $valid = false;
            }
            if($valid === true && ($post_data['starttime'] > $post_data['endtime'])) {
                $valid = false;
            }
            if($valid === true && $post_data['range_type'] > 0 && empty($post_data['range_args'])) {
                $valid = false;
            }

            if($valid === false && $ajax === true) {
                echo json_encode(array(
                    'errno' => 1,
                    'msg' => '课程申请失败'
                ));
                exit;
            }

            if($valid === true) {
                $xkmsg = $this->model('Xuankemsg');
                $nid = $xuanke->addCourse($post_data);
                if ($nid !== false) {
                    $xkmsg->reportSuccess($xkid, $this->user['uid'], $nid, $post_data['coursename']);
                    if($ajax === true) {
                        echo json_encode(array(
                            'errno' => 0
                        ));
                        exit;
                    }
                    header("location:/troomv2/xuanke/msglist.html?aid=$xkid");
                    exit;
                }
                /*if($again === false) {
                    //提交申请
                    //print_r($post_data);exit;
                    $nid = $xuanke->addCourse($post_data);
                    if ($nid !== false) {
                        $xkmsg->reportSuccess($xkid, $this->user['uid'], $nid, $post_data['coursename']);
                        if($ajax === true) {
                            echo json_encode(array(
                                'errno' => 0
                            ));
                            exit;
                        }
                        header("location:/troomv2/xuanke/msglist.html?aid=$xkid");
                        exit;
                    }
                } else {
                    //重新申请
                    if ($xuanke->reportAgain($post_data) !== false) {
                        if($ajax === true) {
                            echo json_encode(array(
                                'errno' => 0
                            ));
                            exit;
                        }
                        header("location:/troomv2/xuanke/msglist.html?aid=$xkid");
                        exit;
                    }
                }*/
            }
        }
        $this->assign('activity', $model);
        $this->assign('grade_class', $grade_class);
        $this->assign('image_server', $image_server);
        $this->assign('grade', $roominfo['grade']);
        $this->assign('classes', $classlist);
        $this->display('troomv2/xuanke/report');
	}

    /**
     * 报名查看
     */
    public function signview() {
        $step = intval($this->input->get('step'));
        $step = $step > 1 ? 2 : 1;
        $xkid = intval($this->input->get('xkid'));
        $roominfo = Ebh::app()->room->getcurroom();
        $xuanke = $this->model('xuanke');
        $activity = $xuanke->getXuanke(array(
            'xkid' => $xkid,
            'crid' => $roominfo['crid']
        ));
        if(empty($activity)) {
            header("location:/troomv2/xuanke.html");
            exit;
        }

        $courses = $xuanke->getOwnCourse($xkid, $this->user['uid']);
        if(empty($courses)) {
            header("location:/troomv2/xuanke.html");
            exit;
        }
        $cid = intval($this->input->get('cid'));
        $course = $cid > 0 && isset($courses[$cid]) ? $courses[$cid] : reset($courses);
        if ($course['range_type'] == 1) {
            $vArr = array(
                1=> '一年级',
                2 => '二年级',
                3=> '三年级',
                4 => '四年级',
                5=> '五年级',
                6 => '六年级',
                7 => '初一',
                8 => '初二',
                9 => '初三',
                10 => '高一',
                11 => '高二',
                12 => '高三'
            );
            $aArr = explode(',', $course['range_args']);
            $tmp = array();
            foreach($aArr as $item) {
                if(array_key_exists($item, $vArr)) {
                    $tmp[] = $vArr[$item];
                }
            }
            $course['range'] = implode('、', $tmp);
        } else if ($course['range_type'] == 2) {
            $classes = $this->model('classes');
            $tmp = array();
            if ($classArr = $classes->getClassList($roominfo['crid'], $course['range_args'])) {
                $tmp = array_column($classArr, 'classname');
                $course['range'] = implode('、', $tmp);
            }
            $course['range'] = implode('、', $tmp);
        } else {
            $course['range'] = '全年级';
        }

        $tmp = json_decode($course['images']);
        $images = array();
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $image_server = $_UP['xk']['showpath'];
        foreach($tmp as $item) {
            $path_info = pathinfo($item);
            $thumb = sprintf('%s%s/%s_th.%s', $image_server,
                $path_info['dirname'], $path_info['filename'], $path_info['extension']);
            $images[$thumb] = $image_server . $item;
        }
        $course['images'] = $images;

        $students_count = 0;
        $students = $xuanke->getStudents(
            array(
                'xkid' => $xkid,
                'cid' => $course['cid'],
                'bout' => $step
            )
        );
        if (empty($students) === false && is_array($students)) {
            $students_count = count($students);
        }
        $this->assign('step', $step);
        $this->assign('course', $course);
        $this->assign('students', $students);
        $this->assign('students_count', $students_count);
        if (count($courses) > 1) {
            $this->assign('courses', $courses);
        }
        $this->display('troomv2/xuanke/signview');
    }

    /**
     * 报名调整
     */
    public function signadjust() {
        $step = intval($this->input->get('step'));
        $step = $step > 1 ? 2 : 1;
        $xkid = intval($this->input->get('xkid'));
        $roominfo = Ebh::app()->room->getcurroom();
        $xuanke = $this->model('xuanke');
        $activity = $xuanke->getXuanke(array(
            'xkid' => $xkid,
            'crid' => $roominfo['crid']
        ));
        $cid = intval($this->input->get('cid'));
        if(empty($activity) || $activity['status'] != 3 && $step == 1 || $activity['status'] != 5 && $step == 2) {
            header("location:/troomv2/xuanke.html");
            exit;
        }

        $courses = $xuanke->getOwnCourse($xkid, $this->user['uid']);
        if(empty($courses)) {
            header("location:/troomv2/xuanke.html");
            exit;
        }
        if (isset($courses[$cid])) {
            $course = $courses[$cid];
        } else {
            $course = reset($courses);
        }

        if ($course['range_type'] == 1) {
            $vArr = array(
                1=> '一年级',
                2 => '二年级',
                3=> '三年级',
                4 => '四年级',
                5=> '五年级',
                6 => '六年级',
                7 => '初一',
                8 => '初二',
                9 => '初三',
                10 => '高一',
                11 => '高二',
                12 => '高三'
            );
            $aArr = explode(',', $course['range_args']);
            $tmp = array();
            $vTmp = array();
            foreach($aArr as $item) {
                if(array_key_exists($item, $vArr)) {
                    $tmp[] = $vArr[$item];
                    $vTmp[] = $item;
                }
            }
            $course['range'] = implode('、', $tmp);
            $classes = $xuanke->getCourseClasses($roominfo['crid'], 1, $vTmp);
        } else if ($course['range_type'] == 2) {
            $classes = $this->model('classes');
            $classArr = $classes->getClassList($roominfo['crid'], $course['range_args']);
            $tmp = array();
            $vTmp = array();
            if(empty($classArr) === false && is_array($classArr)) {
                $tmp = array_column($classArr, 'classname');
                $vTmp = array_column($classArr, 'classid');
            }
            $course['range'] = implode('、', $tmp);
            $classes = $xuanke->getCourseClasses($roominfo['crid'], 2, $vTmp);
        } else {
            $course['range'] = '全年级';
            $classes = $xuanke->getCourseClasses($roominfo['crid'], 0, null);
        }

        $tmp = json_decode($course['images']);
        $images = array();
        $_UP = Ebh::app()->getConfig()->load('upconfig');
        $image_server = $_UP['xk']['showpath'];
        foreach($tmp as $item) {
            $path_info = pathinfo($item);
            $thumb = sprintf('%s%s/%s_th.%s', $image_server, $path_info['dirname'],
                $path_info['filename'], $path_info['extension']);
            $images[$thumb] = $image_server . $item;
        }
        $course['images'] = $images;
        $students = $xuanke->getStudents(
            array(
                'xkid' => $xkid,
                'cid' => $course['cid'],
                'bout' => $step
            )
        );

        $students_count = 0;
        if (isset($students) === true && is_array($students) === true) {
            $students_count = count($students);
        }

        $grade_class = array();
        foreach($classes as $item) {
            if(!array_key_exists($item['grade'], $grade_class)) {
                $grade_class[$item['grade']] = array();
            }
            $grade_class[$item['grade']][] = $item;
        }
        krsort($grade_class, SORT_NUMERIC);
        unset($classes);
        $this->assign('grade_class', $grade_class);
        $this->assign('course', $course);
        $this->assign('students', $students);
        $this->assign('students_count', $students_count);
        $this->assign('courses', $courses);

        $this->assign('step', $step);
        $this->assign('xkid', $activity['xkid']);
        $this->display('troomv2/xuanke/signadjust');
    }

    /**
     * 导出报名列表
     */
    public function exportexcel() {
        $xkid = intval($this->input->get('xkid'));
        $cid = intval($this->input->get('cid'));
        if($xkid <= 0 || $cid <= 0) {
            header("location:/troomv2/xuanke.html");
            exit;
        }
        $xuanke = $this->model('xuanke');
        $coursename = $xuanke->getCourseName($xkid, $cid, $this->user['uid']);
        if($coursename == false) {
            header("location:/troomv2/xuanke.html");
            exit;
        }

        $objPHPExcel = Ebh::app()->lib('PHPExcel');
        // 以下是一些设置 ，什么作者  标题啊之类的
        $objPHPExcel->getProperties()
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        $titleArr = array(
            '学生帐号',
            '姓名',
            '班级',
            '报名时间'
        );
        $name = "选课《" .$coursename . "》学生列表";
        //设置第行文件描述
        $p = "A1";
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $pt = $objPHPExcel->getActiveSheet()->getStyle($p);
        $objPHPExcel->getActiveSheet()->setCellValue($p, $name);
        $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        $pt->getFont()->setSize(16);
        $pt->getFont()->setBold(true);


        $titleColor = "FF808080";
        // 设置列表标题
        if(is_array($titleArr)){
            $str = "A";
            foreach($titleArr as $k=>$v){
                $p = $str++.'2';//列A1,B1,C1,D1
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setAutoSize(true);//设置列宽_自适应
                $pt = $objPHPExcel->getActiveSheet()->getStyle($p);

                $pt->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $pt->getFont()->setSize(14);
                $pt->getFont()->setBold(true);

                //$pt->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置列填充模式 solid
                $pt->getFill()->getStartColor()->setARGB($titleColor);//设置列填充颜色
                //$pt->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//设置列边宽
                $objPHPExcel->getActiveSheet()->setCellValue($p, $v);//设置列名称
            }
        }

        $dataArr = $xuanke->getStudentsForExcel(array(
            'xkid' => $xkid,
            'cid' => $cid
        ));
        $column_count = count($titleArr);

        //传值
        if(is_array($dataArr)){
            foreach ($dataArr as $index => $row) {
                $str = "A";
                for($i = 0; $i < $column_count; $i++) {
                    $p = $str . ($index + 3);
                    if ($str == 'A') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['username']);
                        $str++;
                        continue;
                    }
                    if ($str == 'B') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['realname']);
                        $str++;
                        continue;
                    }
                    if ($str == 'C') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, $row['classname']);
                        $str++;
                        continue;
                    }
                    if ($str == 'D') {
                        $objPHPExcel->getActiveSheet()->setCellValue($p, !empty($row['sign_time']) ? date('Y-m-d H:i', $row['sign_time']) : '--');
                        $str++;
                        continue;
                    }
                }
            }
        }
//return;
        /*if(!empty($manuallywidth)){
            $str = 'A';
            foreach($manuallywidth as $width){
                $objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
                $str++;
            }
        }*/
        //exit(0);
        // 输出下载文件 到浏览器
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);


        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || stripos($_SERVER['HTTP_USER_AGENT'], 'trident')) {
            $name = urlencode($name);
        } else {
            $name = str_replace(' ', '', $name);
        }

        $filename  = $name.".xls";//文件名,带格式
        header("Content-type: text/csv");//重要 屏蔽ie等安全提醒
        header('Content-Type:application/x-msexecl;name="'.$name.'"');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter->save('php://output');
    }

    /**
     * 调整报名：删除学生
     */
    public function ajax_delete_student() {
        $json_str = array('errno' => 0);
        $xkid = intval($this->input->post('xkid'));
        $cid = intval($this->input->post('cid'));
        $studentid = $this->input->post('uid');
        if(isset($studentid) && is_array($studentid) === false) {
           $studentid = intval($studentid);
        }
        $failmsg = $this->input->post('failmsg', true);
        if ($xkid <=0 || $cid <= 0) {
            $json_str['errno'] = 2;
            $json_str['msg'] = '非法操作';
            echo json_encode($json_str);
            exit;
        }

        $xuanke = $this->model('xuanke');
        $roominfo = Ebh::app()->room->getcurroom();
        $activity = $xuanke->getActivity(array(
            'xkid' => $xkid,
            'crid' => $roominfo['crid']
        ));

        if (empty($activity) === true) {
            $json_str['errno'] = 2;
            $json_str['msg'] = '非法操作';
            echo json_encode($json_str);
            exit;
        }

        $rule = $xuanke->getRules($xkid);
        $is_super = $activity['uid'] == $this->user['uid'] ? true : false;
        if (empty($rule) === true) {
            $json_str['errno'] = 2;
            $json_str['msg'] = '非法操作';
            echo json_encode($json_str);
            exit;
        }

        if ($rule[0]['step'] == 2) {
            $json_str['errno'] = 2;
            $json_str['msg'] = '第二轮无法取消学生报名';
            echo json_encode($json_str);
            exit;
        }
        $course = $xuanke->getCourseName($xkid, $cid, $this->user['uid']);
        if($is_super === false && empty($course) === true) {
            $json_str['errno'] = 2;
            $json_str['msg'] = '无权取消学生报名';
            echo json_encode($json_str);
            exit;
        }
        if(is_array($studentid)) {
            if ($xuanke->updateStudents_mult(array('tid'=>$this->user['uid'],'status'=>0, 'failmsg'=> $failmsg),
                array('xkid'=>$xkid,'cid'=>$cid,'uid'=>$studentid,'bout'=>1), 1)) {
                $json_str['errno'] = 0;
                $json_str['msg'] = '删除成功';
                echo json_encode($json_str);
                return;
            }
        } else {
            if ($xuanke->updateStudents(array('tid'=>$this->user['uid'],'status'=>0, 'failmsg'=> $failmsg),
                array('xkid'=>$xkid,'cid'=>$cid,'uid'=>$studentid,'bout'=>1), 1)) {
                $json_str['errno'] = 0;
                $json_str['msg'] = '删除成功';
                echo json_encode($json_str);
                return;
            }
        }

        $json_str['errno'] = 3;
        $json_str['msg'] = '删除失败';
        echo json_encode($json_str);
        return;
    }

    /**
     * 调整报名状态
     */
    public function ajax_adjust_course() {
        if($this->isPost()) {
            $cid = intval($this->input->post('cid'));
            $step = intval($this->input->post('step'));

            $xuanke = $this->model('xuanke');
            if($xuanke->adjustCourse($step, $cid)) {
                $json = array(
                    'errno' => 0
                );
                echo json_encode($json);
                exit;
            }

            $json = array(
                'errno' => 1,
                'msg' => '调整失败'
            );
            echo json_encode($json);
            exit;
        }
        $json = array(
            'errno' => 1,
            'msg' => '非法操作'
        );
        echo json_encode($json);
        exit;
    }

    /**
     * 老师添加学生
     */
    public function ajax_add_students(){
        if($this->isPost()) {
            $xkid = intval($this->input->post('xkid'));
            $cid = intval($this->input->post('cid'));
            $uid = $this->input->post('uid');

            $xuanke = $this->model('xuanke');
            $roominfo = Ebh::app()->room->getcurroom();
            $activity = $xuanke->getActivity(array(
                'xkid' => $xkid,
                'crid' => $roominfo['crid']
            ));
            if (empty($activity) === true) {
                $json = array(
                    'errno' => 1,
                    'msg' => '找不到该活动'
                );
                echo json_encode($json);
                exit;
            }
            $is_surper = $activity['uid'] == $this->user['uid'] ? true : false;
            if($course = $xuanke->getSingleCourse($cid, $xkid)) {
                if (!$is_surper && $course['uid'] != $this->user['uid']) {
                    $json = array(
                        'errno' => 1,
                        'msg' => '没有权限,非法操作'
                    );
                    echo json_encode($json);
                    exit;
                }
                $rule = $xuanke->getRule(array(
                    'xkid' => $xkid,
                    'step' => 1
                ));
                $roominfo = Ebh::app()->room->getcurroom();
                $students = array();
                if(is_array($uid)) {
                    $uid = array_unique($uid);
                    $uid = array_filter($uid, function($id) {
                        return !empty($id);
                    });
                    $new_count = count($uid);
                    if($course['classnum'] < $course['studentsnum'] + $new_count) {
                        $json = array(
                            'errno' => 1,
                            'msg' => '添加的学生超过名额限制，请重新添加'
                        );
                        echo json_encode($json);
                        exit;
                    }
                    foreach($uid as $id) {
                        if($course['classnum'] > $course['studentsnum']) {
                            $userinfo = $this->_add_student($rule['max_sign_count'], $roominfo['crid'], array(
                                'xkid' => $xkid,
                                'cid' => $cid,
                                'uid' => $id,
                                'bout' => 2,
                                'sign_time' => SYSTIME,
                                'status' => 2,
                                'classname' => '',
                                'tid' => $this->user['uid'],
                                'uptime' => SYSTIME
                            ), $course, $xuanke);
                            if($userinfo !== false) {
                                $students[] = $userinfo;
                                $course['studentsnum']++;
                                $sign_info = $this->model('user')->getuserbyuid($id);
                                $sign_students[] = empty($sign_info['realname'])?$sign_info['username']:$sign_info['realname'];
                            }
                        }

                    }
                } else {
                    if($course['classnum'] <= $course['studentsnum']) {
                        $json = array(
                            'errno' => 1,
                            'msg' => '添加的学生超过名额限制，请重新添加'
                        );
                        echo json_encode($json);
                        exit;
                    }

                    $uid = intval($uid);
                    $userinfo = $this->_add_student($rule['max_sign_count'], $roominfo['crid'], array(
                        'xkid' => $xkid,
                        'cid' => $cid,
                        'uid' => $uid,
                        'bout' => 2,
                        'sign_time' => SYSTIME,
                        'status' => 2,
                        'tid' => $this->user['uid'],
                        'uptime' => SYSTIME
                    ), $course, $xuanke);
                    if($userinfo !== false) {
                        $students[] = $userinfo;
                    }
                }
                if(empty($students)){
                    $json = array(
                        'errno' => 0,
//                        'data' => json_encode($students),
                        'msg'=>'不在选课人员范围内'
                    );
                }else{
                    //成功报名学生
                    $stu_mag = '';
                    $sign_student = array();
                    if(!empty($sign_students)){
                        foreach($sign_students as $stu){
                            $sign_student[] = $stu;
                        }
                    }
                    $stu_mag = implode('、',$sign_student);
                    $json = array(
                        'errno' => 0,
                        'data' => json_encode($students),
                        'msg'=>$stu_mag.'添加成功'
                    );
                }

                echo json_encode($json);
                exit;
            }
        }
        $json = array(
            'errno' => 1,
            'msg' => '未接受到数据'
        );
        echo json_encode($json);
        exit;
    }

    /**
     * 老师添加学生
     * @param $max
     * @param $crid
     * @param $param
     * @param $course
     * @param $model
     * @return bool
     */
    public function _add_student($max, $crid, $param, $course, $model) {
        $xkid = $param['xkid'];
        $uid = $param['uid'];
        $sign_count = $model->getStudentSignCount($xkid, $uid);
        if($sign_count >= $max) {
            return false;
        }
        $class_info = $model->getClassInfo($uid, $crid);
        $classname = '未知';
        if($course['range_type'] == 1) {
            if (empty($class_info) === false) {
                $grade_arr = explode(',', $course['range_args']);
                $valid = false;
                foreach ($class_info as $gitem) {
                    if (in_array($gitem['grade'], $grade_arr) === true) {
                        $classname = $gitem['classname'];
                        $valid = true;
                        break;
                    }
                }

                if($valid === false) {
                    return false;
                }
            }
        } else if($course['range_type'] == 2) {
            if (empty($class_info) === false) {
                $class_arr = explode(',', $course['range_args']);
                $valid = false;
                foreach($class_info as $classitem) {
                    if(in_array($classitem['classid'], $class_arr) === true) {
                        $valid = true;
                        $classname = $classitem['classname'];
                        break;
                    }
                }
                if($valid === false) {
                    return false;
                }
            }
        } else {
            $classname = $class_info[0]['classname'];
        }
        $param['classname'] = $classname;
        if ($model->is_signed(array(
            'xkid'=>$xkid,
            'cid'=>$course['cid'],
            'uid'=> $param['uid']))) {
            return false;
        }
        if($model->addStudents($param)) {
            $students = $model->getStudents(
                array(
                    'xkid' => $xkid,
                    'cid' => $course['cid'],
                    'bout' => 2,
                )
            );
            return $students[0];
        }
        return false;
    }

    /**
     * 学生列表
     */
    public function ajax_students() {
        if($this->isPost()) {
            $filter_type = intval($this->input->post('filterType'));
            if(is_array($this->input->post('id'))) {
                $id = $this->input->post('id');
            } else {
                $id = intval($this->input->post('id'));
            }
            $keyword = strval($this->input->post('keyword', true));
            $cid = intval($this->input->post('cid'));
            $xuanke = $this->model('xuanke');
            if ($cid > 0) {
                $course = $xuanke->getCourse(array('cid'=> $cid));
            }

            if(($filter_type === 1 || $filter_type === 2 && empty($id) === false) && (!empty($course) || $cid == 0)) {
                $roominfo = Ebh::app()->room->getcurroom();
                $gradeParam = $filter_type === 1 ? $id : -1;
                $classParam = $filter_type === 2 ? $id : 0;
                if ($this->input->post('id') === null) {
                    $gradeParam = -1;
                }
                $page = intval($this->input->post('page'));
                $page = max($page, 1);
                if ($filter_type == 1 && !empty($course) && $course['range_type'] == 2) {
                    $classParam = explode(',', $course['range_args']);
                }
                $students = $xuanke->getFilterStudents($roominfo['crid'], $gradeParam, $classParam, $page, $keyword);
                if($cid > 0) {
                    $studentids = $xuanke->getCourseStudentIds($cid);

                    $r = $xuanke->courseRule($cid);
                    if(empty($r)) {
                        echo json_encode(array(
                            'errno' => 1,
                            'msg' => '非法操作'
                        ));
                        exit;
                    }
                    $maxList = $xuanke->studentSignCountList($r['xkid'], $r['max_sign_count']);
                    $uids = array_column($students, 'uid');
                    $aps = array(
                        0 => array(0, 2),
                        1 => array(1, 2),
                        2 => array(0, 1, 2)
                    );
                    $aps = $aps[$course['ap']];
                    $auids = $xuanke->exclusiveUsers($uids, $course['xkid'], $aps);
                    if (!empty($auids)) {
                        $auids = array_flip($auids);
                    }
                }
                foreach($students as $k => $student) {
                    $students[$k]['face'] = getavater($student,'50_50');
                    if(empty($student['realname'])) {
                        $students[$k]['realname'] = $student['username'];
                    }
                    $students[$k]['showname'] = shortstr(empty($student['realname'])?$student['username']:$student['realname'],4,'');

                    $students[$k]['lab'] = substr_ext($student['realname'], 0, 4);

                    if($cid > 0) {
                        if(is_array($studentids) && key_exists($student['uid'], $studentids) || isset($auids[$student['uid']])) {
                            //已报名
                            $students[$k]['signed'] = true;
                        }
                        if(is_array($maxList) && key_exists($student['uid'], $maxList)) {
                            $students[$k]['overflow'] = true;
                        }
                    }
                }

                $finish = count($students) < 50;
                $page++;
                echo json_encode(array(
                    'errno' => 0,
                    'data' => $students,
                    'page' => $page,
                    'finish' => $finish
                ));
                exit;
            }
        }
        echo json_encode(array(
            'errno' => 1,
            'msg' => '非法操作'
        ));
        exit;
    }

    public function activityStatus($activity) {
        if($activity['status'] < 3) {
            if($activity['starttime'] > time()) {
                return '等待课程申报';
            }
            if($activity['endtime'] <= time()) {
                return '课程申报结束';
            }
            return '课程申报中';
        }

        if($activity['status'] == 3) {
            if(!empty($activity['end_t']) && $activity['end_t'] <= time()) {
                return '第一轮选课结束';
            }
            return '第一轮选课进行中';
        }

        if($activity['status'] == 5) {
            if(!empty($activity['end_t_2']) && $activity['end_t_2'] <= time()) {
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

    public function showName($realname, $username) {
        if(empty($realname)) {
            return $username;
        }
        return shortstr($realname, 8);
    }

    //修改课程
    public function edit()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $post = $this->input->post();
        $xkid = intval($this->input->get('xkid'));
        $cid = intval($this->input->post('cid'));
        if(!empty($post) || $xkid > 0 || $cid > 0){
            $xuanke = $this->model('xuanke');
            $course = $xuanke->getCourse(array('cid' => $cid, 'status' => 1));
            if (empty($course) || $course['xkid'] != $xkid) {
                echo json_encode(array(
                    'errno' => 1,
                    'msg' => '课程申请失败'
                ));
                exit();
            }
            $post_images = $this->input->post('images');
            if (!empty($post_images)) {
                if (is_array($post_images)) {
                    $images = array_filter($post_images, function($img) {
                        return !empty($img);
                    });
                } else {
                    $images[] = strval($post_images);
                }
            }
            if(count($images) > 20) {
                $images = array_slice($images, 0, 20);
            }
            $images_str = json_encode($images);
            $post['images'] = $images_str;
            if(!empty($post['range_args'])){
                $post['range_args'] = implode(',',$post['range_args']);
            }
            $post['datetime'] = SYSTIME;
            $where = array('cid'=>$post['cid']);
            $post['starttime'] = strtotime($post['starttime']);
            $post['endtime'] = strtotime($post['endtime'])+86399;
            if (isset($post['ap'])) {
                $tr = array_keys($this->timeRange);
                if (!in_array($post['ap'], $tr)) {
                    unset($post['ap']);
                }
            }
            if (isset($post['studentids'])) {
                $studentids = $this->input->post('studentids');
                if (is_array($studentids)) {
                    $studentids = array_filter($studentids, function($studentid) {
                        return is_numeric($studentid) && $studentid > 0;
                    });
                    $studentids = array_map('intval', $studentids);
                } else if (is_numeric($studentids)){
                    $studentids = array(intval($studentids));
                }
                if (!empty($studentids)) {
                    //查询学生的报名状态
                    if (count($studentids) > $post['classnum']) {
                        echo json_encode(array(
                            'errno' => 1,
                            'msg' => '选择的学生超过名额限制'
                        ));
                        exit;
                    }
                    $studentReports = $xuanke->checkStudentReportStatus($studentids, $xkid, $roominfo['crid']);
                    if (!empty($studentReports)) {
                        $studentReports = array_map(function($studentReport) {
                            $studentReport['ap'] = explode(',', $studentReport['ap']);
                            $studentReport['cid'] = explode(',', $studentReport['cid']);
                            return $studentReport;
                        }, $studentReports);
                        $st1 = $st2 = $msg = array();
                        foreach ($studentReports as $report) {
                            if ($post['cid'] > 0 && in_array($post['cid'], $report['cid']) && $course['ap'] == $post['ap']) {
                                continue;
                            }
                            $showname = !empty($report['realname']) ? $report['realname'] : $report['username'];
                            if (in_array($post['ap'], $report['ap'])) {
                                $st2[] = $showname;
                                continue;
                            }
                            if (count($report['ap']) > 1) {
                                $st1[] = $showname;
                            }
                        }
                        if (!empty($st1)) {
                            $msg[] = implode(',', $st1).'报名已达到上限';
                        }
                        if (!empty($st2)) {
                            $msg[] = implode(',', $st2).'已报名上课时间与本次冲突';
                        }
                        if (!empty($msg)) {
                            echo json_encode(array(
                                'errno' => 1,
                                'msg' => implode(';', $msg)
                            ));
                            exit;
                        }
                    }
                    $studentClass = $xuanke->getClassnameForStudents($studentids, $roominfo['crid']);
                    $post['studentids'] = array_flip($studentids);
                    array_walk($post['studentids'], function(&$student, $k, $userData) {
                        $student = array(
                            'classname' => isset($userData['studentClass'][$k]) ? $userData['studentClass'][$k]['classname'] : '',
                            'tid' => isset($userData['reports'][$k]) ? $userData['reports'][$k]['tid'] : $userData['uid']
                        );
                    }, array(
                        'studentClass' => $studentClass,
                        'uid' => $this->user['uid'],
                        'reports' => $studentReports
                    ));
                }
            }
            $res = $xuanke->saveCourse($post,$where, $xkid);
            if($res){
                echo json_encode(array(
                    'errno' => 2
                ));
                exit;
//                header("location:/troomv2/xuanke/msglist.html?aid=$xkid");
//                exit;
            }
            echo json_encode(array(
                'errno' => 1,
                'msg' => '课程申请失败'
            ));
        }else{
            echo json_encode(array(
                'errno' => 1,
                'msg' => '课程申请失败'
            ));
        }

    }

    /**
     * 删除课程
     */
    public function ajax_remove_course() {
        if (!$this->isPost()) {
            echo json_encode(array(
                'errno' => 1,
                'msg' => '非法操作'
            ));
            exit();
        }
        $cid = intval($this->input->post('cid'));
        if ($cid < 1) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '缺少参数'
            ));
            exit();
        }
        $model = $this->model('xuanke');
        $cid = $model->checkCourseEidtable($cid, $this->user['uid']);
        if ($cid === false) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '删除失败'
            ));
            exit();
        }
        $ret = $model->removeCourse($cid, $this->user['uid']);
        if (!empty($ret)) {
            echo json_encode(array(
                'errno' => 0
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => 2,
            'msg' => '删除失败'
        ));
        exit();
    }
}