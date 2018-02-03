<?php
/*
 * 选课消息
 */
class XuankemsgModel extends CModel {
    /**
     * 教师申报课程失败
     */
    const MSG_REPORT_FAIL = 1;
    /**
     * 教师重新申报课程
     */
    const MSG_REPORT_AGAIN = 2;
    /**
     * 第一轮报名提交完成选课
     */
    const MSG_SIGN_FINISH = 3;

    /**
     * 课程申报成功
     */
    const MSG_SIGN_SUCCESS = 4;

    /**
     * 读取管理员消息
     * @param $aid
     * @return array
     */
    public function readManagerMsg($aid) {
        $aid = (int) $aid;
        $activity = $this->db->query(
            "SELECT xa.`starttime`,xa.`endtime`,xa.`datetime`,xa.`status`,xa.`finish_time`,xa.`survey_time`,".
            "xa.`first_t`,xa.`second_t`,xa.ispause FROM `ebh_xk_activitys` xa  WHERE xa.`xkid`=$aid AND `isdel`=1")->row_array();
        $msgs = array();
        if ($activity) {
            $course_count = 0;
            $student_count = 0;
            if ($count = $this->db->query(
                "SELECT COUNT(DISTINCT(`uid`)) AS `c` FROM `ebh_xk_courses` WHERE `xkid`=$aid AND `status`>0 AND `del`=0;")->row_array()) {
                $course_count = $count['c'];
            }

            //活动发布
            $data = null;
            $data = array(
                'object' => '活动已发布',
                'msg' => '等待老师申报选修课',
                'msg_time' => date('Y-m-d H:i', $activity['datetime']),
                'int_arg' => array(
                    'value' => $course_count,
                    'format' => '%s位老师申报'
                ),
                'guide' => array(
                    "<a href='/aroomv2/xuanke/reportcourse.html?xkid=$aid' class=\"hjisres\">查看申报课程</a>",
                    "<a href='/aroomv2/xuanke/xuanke_edit.html?xkid=$aid' class=\"hjisres\">修改活动</a>"
                )
            );
            if($activity['starttime'] > $activity['endtime']) {
                $data['str_arg'] = sprintf('申报时间：%s', date('Y-m-d H:i', $activity['starttime']));
            } else {
                $data['str_arg'] = sprintf('申报时间：%s 至 %s',
                    date('Y-m-d H:i', $activity['starttime']),
                    date('Y-m-d H:i', $activity['endtime']));
            }
            $msgs[] = $data;
            if ($activity['endtime'] > SYSTIME) {
                //课程申报中
                return $msgs;
            }
            //申报课程结束
            $course_count = 0;
            if ($count = $this->db->query(
                "SELECT COUNT(DISTINCT(`uid`)) AS `c` FROM `ebh_xk_courses` WHERE `xkid`=$aid AND `status`>0 AND `del`=0;")->row_array()) {
                $course_count = $count['c'];
            }
            $data = array(
                'object' => '课程申报结束',
                'msg_time' => date('Y-m-d H:i', $activity['endtime'])
            );
            if($course_count > 0) {
                $data['msg'] =  '请设置完课程规则及选课规则后，发布第一轮选课';
                $data['guide'] = array(
                    "<a href=\"/aroomv2/xuanke/reportcoursefinish_set.html?xkid=$aid\"  class=\"hjisres\">设置课程</a>"
                );
                $data['int_arg'] = array(
                    'value' => $course_count,
                    'format' => '%s位老师申报'
                );
            } else {
                $data['msg'] =  '课程申报结束，没有教师申报课程，活动结束。';
                array_unshift($msgs, $data);
                return $msgs;
            }
            array_unshift($msgs, $data);

            if($activity['status'] >= 3 &&
                $rule = $this->db->query(
                    "SELECT `start_t`,`end_t`,`step` FROM `ebh_xk_rules` WHERE `xkid`=$aid AND `step`=1;")->row_array()) {
                //第一轮选课进行中
                $student_count = 0;
                if ($s = $this->db->query(
                    "SELECT COUNT(DISTINCT(`a`.`uid`)) AS `c` FROM `ebh_xk_students` `a` JOIN `ebh_xk_courses` `b` ON `b`.`cid`=`a`.`cid` WHERE `a`.`xkid`=$aid AND `a`.`bout`=1 AND `b`.`status`>0 AND `b`.`del`=0;")->row_array()) {
                    $student_count = $s['c'];
                }
                $data = array(
                    'object' => '第一轮选课进行中',
                    'msg' => '等待学生们进行第一轮选课',
                    'msg_time' => date('Y-m-d H:i', $activity['first_t']),
                    'int_arg' => array(
                        'value' => $student_count,
                        'format' => '已有%s位学生报名'
                    ),
                    'guide' => array(
                        "<a href=\"/aroomv2/xuanke/firstcondition.html?xkid=$aid\"  class=\"hjisres\">查看选课情况</a>"
                    )
                );

                if($rule['start_t'] > $rule['end_t']) {
                    $data['str_arg'] = sprintf('选课时间：%s', date('Y-m-d H:i', $rule['start_t']));
                } else {
                    $data['str_arg'] = sprintf('选课时间：%s 至 %s',
                        date('Y-m-d H:i', $rule['start_t']),
                        date('Y-m-d H:i', $rule['end_t']));
                }

                array_unshift($msgs, $data);

                if ($rule['end_t'] < SYSTIME) {
                    //第一轮选课结束
                    $student_count = 0;
                    if ($s = $this->db->query(
                        "SELECT COUNT(DISTINCT(`a`.`uid`)) AS `c` FROM `ebh_xk_students` `a` JOIN `ebh_xk_courses` `b` ON `b`.`cid`=`a`.`cid` WHERE `a`.`xkid`=$aid AND `a`.`bout`=1 AND `a`.`status` IN(1,2) AND `b`.`status`>0 AND `b`.`del`=0;")
                        ->row_array()) {
                        $student_count = $s['c'];
                    }
                    array_unshift($msgs, array(
                        'object' => '第一轮选课结束',
                        'msg' => '对第一轮选课结果调整后，发布第二轮选课',
                        'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                        'int_arg' => array(
                            'value' => $student_count,
                            'format' => '共计%s位学生报名'
                        ),
                        'guide' => array(
                            "<a href=\"/aroomv2/xuanke/firstcondition.html?xkid=$aid&step=1\"  class=\"hjisres\">调整选课结果</a>"
                        )
                    ));
                }
            }
            if ($activity['status'] >= 5) {
                if ($rule = $this->db->query(
                    "SELECT `start_t`,`end_t`,`step` FROM `ebh_xk_rules` WHERE `xkid`=$aid AND `step`=2;")->row_array()) {
                    //第二轮选课进行中
                    $student_count = 0;
                    if ($s = $this->db->query(
                        "SELECT COUNT(DISTINCT(`uid`)) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$aid AND `status` IN(1,2)")
                        ->row_array()) {
                        $student_count = $s['c'];
                    }
                    $data = array(
                        'object' => '第二轮选课进行中',
                        'msg' => '等待学生们进行第二轮选课',
                        'msg_time' => date('Y-m-d H:i', $activity['second_t']),
                        'int_arg' => array(
                            'value' => $student_count,
                            'format' => '已有%s位学生报名'
                        ),
                        'guide' => array(
                            "<a href=\"/aroomv2/xuanke/secondcondition.html?xkid=$aid\"  class=\"hjisres\">查看选课情况</a>"
                        )
                    );
                    if($rule['start_t'] > $rule['end_t']) {
                        $data['str_arg'] = sprintf('选课时间：%s', date('Y-m-d H:i', $rule['start_t']));
                    } else {
                        $data['str_arg'] = sprintf('选课时间：%s 至 %s',
                            date('Y-m-d H:i', $rule['start_t']),
                            date('Y-m-d H:i', $rule['end_t']));
                    }
                    array_unshift($msgs, $data);
                    if ($rule['end_t'] < SYSTIME) {
                        //第二轮选课结束
                        $student_count = 0;
                        if ($s = $this->db->query(
                            "SELECT COUNT(DISTINCT(`uid`)) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$aid AND `status` IN(1,2)")
                            ->row_array()) {
                            $student_count = $s['c'];
                        }
                        array_unshift($msgs, array(
                            'object' => '第二轮选课结束',
                            'msg' => '对第二轮选课结果调整后，发布最终选课结果',
                            'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                            'int_arg' => array(
                                'value' => $student_count,
                                'format' => '共计%s位学生报名'
                            ),
                            'guide' => array(
                                "<a href=\"/aroomv2/xuanke/secondcondition.html?xkid=$aid&step=1\"  class=\"hjisres\">调整选课结果</a>"
                            )
                        ));
                    }
                }
            }

            if ($activity['status'] >= 7) {
                //选课结束
                $student_count = 0;
                if ($s = $this->db->query(
                    "SELECT COUNT(DISTINCT(`a`.`uid`)) AS `c` FROM `ebh_xk_students` `a` JOIN `ebh_xk_courses` `b` ON `b`.`cid`=`a`.`cid` WHERE `a`.`xkid`=$aid AND `a`.`status` IN(1,2) AND `b`.`del`=0 AND `b`.`status`>0")->row_array()) {
                    $student_count = $s['c'];
                }
                array_unshift($msgs, array(
                    'object' => '选课活动结束',
                    'msg' => '本次选课活动已结束，等完成课程的线下教学后，别忘了来发布课程评价问卷',
                    'msg_time' => date('Y-m-d H:i', $activity['finish_time']),
                    'int_arg' => array(
                        'value' => $student_count,
                        'format' => '共计%s位学生报名'
                    ),
                    'guide' => array(
                        "<a href=\"/aroomv2/xuanke/baoming.html?xkid=$aid\"  class=\"hjisres\">查看结果</a>",
                        "<a href=\"/troomv2/survey/add.html?xkid=$aid\" target=\"_blank\" class=\"hjisres\">发布问卷</a>"
                    )
                ));
            }

            if ($activity['status'] == 8) {
                //发布问卷
                $single_course = $this->db->query(
                    "select cid from ebh_xk_courses where xkid=$aid and status>0 and del=0")->row_array();
                if(empty($single_course)) {
                    return $msgs;
                }
                $sur = $this->db->query(
                    "SELECT `startdate`,`enddate` FROM `ebh_surveys` WHERE `cid`=".$single_course['cid'] . " AND `startdate`>0")
                    ->row_array();
                if (empty($sur)) {
                    return $msgs;
                }
                array_unshift($msgs, array(
                    'object' => '课程评价问卷已发布',
                    'msg' => '等待学生们进行评价',
                    'msg_time' => date('Y-m-d H:i', $activity['survey_time']),
                    'str_arg' => sprintf('评价时间：%s 至 %s',
                        date('Y-m-d H:i', $sur['startdate']), date('Y-m-d H:i', $sur['enddate'])),
                    'guide' => array(
                        "<a href=\"/aroomv2/xuanke/assess.html?xkid=$aid\" class=\"hjisres\">查看评价</a>",
                    )
                ));
                if($sur['enddate']<SYSTIME){
                    array_unshift($msgs, array(
                        'object' => '课程评价问卷已结束',
                        'msg' => '可以查看最终的评价结果了',
                        'msg_time' => date('Y-m-d H:i', $sur['enddate']),
//                        'str_arg' => sprintf('评价日期：%s 至 %s',
//                            date('Y-m-d', $sur['startdate']), date('Y-m-d', $sur['enddate'])),
                        'guide' => array(
                            "<a href=\"/aroomv2/xuanke/assess.html?xkid=$aid\" class=\"hjisres\">查看评价</a>",
                        )
                    ));
                }
            }
        }
        return $msgs;
    }

    /**
     * 读取老师消息
     * @param $aid
     * @param $uid
     * @return array
     */
    public function readTeacherMsg($aid, $uid) {
        $aid = (int) $aid;
        $uid = (int) $uid;
        $activity = $this->db->query(
            "SELECT `starttime`,`endtime`,`datetime`,`status`,`finish_time`,`survey_time`,`first_t`,`second_t`".
            " FROM `ebh_xk_activitys` WHERE `xkid`=$aid AND `isdel`=1")->row_array();
        $msgs = array();
        if ($activity) {
            $cid = 0;
            $course_status = false;
            $isup = 0;
            $data = null;
            if ($course = $this->db->query("SELECT `cid`,`status`,`isup` FROM `ebh_xk_courses` WHERE ".
                "`xkid`=$aid AND `uid`=$uid AND `del`=0 ORDER BY `cid` DESC")->row_array()) {
                $cid = $course['cid'];
                $course_status = $course['status'] > 0;
                $isup = $course['isup'];
            }

            $cids = $this->db->query('SELECT `cid` FROM `ebh_xk_courses` WHERE `xkid`='.$aid.' AND `uid`='.$uid.' AND `del`=0')->list_field();

            $student_count = 0;
            if($activity['starttime'] > SYSTIME) {
                //课程未开始
                $data = array(
                    'object' => '等待课程申报',
                    'msg' => '根据实际情况开设自己的选修课',
                    'msg_time' => date('Y-m-d H:i', $activity['datetime'])
                );
                if($activity['starttime'] > $activity['endtime']) {
                    $data['str_arg'] = sprintf('申报时间：%s', date('Y-m-d H:i', $activity['endtime']));
                } else {
                    $data['str_arg'] = sprintf('申报时间：%s 至 %s',
                        date('Y-m-d H:i', $activity['starttime']),
                        date('Y-m-d H:i', $activity['endtime']));
                }
                $msgs[] = $data;
                return $msgs;
            } else {
                //课程申报中
                $guide_arr = array("<a href='/troomv2/xuanke/report.html?xkid=$aid' class=\"hjisres\">去开课</a>");
                /*if($course) {
                    $cid = $course['cid'];
                    $guide_arr[0] = "<a href='/troomv2/xuanke/mycourse.html?t=v&aid=$aid' class='hjisres'>查看课程</a>";
                    $guide_arr[1] = "<a href='/troomv2/xuanke/report.html?t=v&xkid=$aid&cid=$cid' class='hjisres'>修改课程</a>";
                }*/
                $data = array(
                    'object' => '课程申报中',
                    'msg' => '根据实际情况开设自己的选修课',
                    'msg_time' => date('Y-m-d H:i', $activity['datetime'])//, 'guide' => $guide_arr
                );
                if($activity['starttime'] > $activity['endtime']) {
                    $data['str_arg'] = sprintf('申报时间：%s', date('Y-m-d H:i', $activity['endtime']));
                } else {
                    $data['str_arg'] = sprintf('申报时间：%s 至 %s',
                        date('Y-m-d H:i', $activity['starttime']),
                        date('Y-m-d H:i', $activity['endtime']));
                }
                $msgs[] = $data;
            }

            //申请过程消息
            $finish_beforehand = null;
            $messages = $this->db->query(
                "SELECT `cid`,`object`,`msg`,`msg_time`,`int_arg`,`int_format`,`str_arg`,`arg_sign`,`guide`,`category`".
                " FROM `ebh_xk_msgs` WHERE `xkid`=$aid AND `uid`=$uid ORDER BY `msg_time` ASC")->list_array();
            if ($messages) {
                foreach ($messages as $target_msg) {
                    $guide = json_decode($target_msg['guide']);
                    if ($target_msg['category'] == self::MSG_REPORT_FAIL ||
                        $target_msg['category'] == self::MSG_REPORT_AGAIN ) {
                        $data = array(
                            'object' => $target_msg['object'],
                            'msg' => $target_msg['msg'],
                            'msg_time' => date('Y-m-d H:i', $target_msg['msg_time']),
                            'guide' => $guide
                        );
                        if($activity['starttime'] > $activity['endtime']) {
                            $data['str_arg'] = sprintf('申报时间：%s', date('Y-m-d H:i', $activity['endtime']));
                        } else {
                            $data['str_arg'] = sprintf('申报时间：%s 至 %s',
                                date('Y-m-d H:i', $activity['starttime']),
                                date('Y-m-d H:i', $activity['endtime']));
                        }
                        array_unshift($msgs, $data);
                        continue;
                    }
                    if ($target_msg['category'] == self::MSG_SIGN_SUCCESS) {
                        $data = array(
                            'object' => $target_msg['object'],
                            'msg' => $target_msg['msg'],
                            'msg_time' => date('Y-m-d H:i', $target_msg['msg_time']),
                            'guide' => $guide,
                            'category' => $target_msg['category']
                        );
                        array_unshift($msgs, $data);
                        continue;
                    }
                    if ($target_msg['category'] == self::MSG_SIGN_FINISH) {
                        $finish_beforehand = array(
                            'object' => $target_msg['object'],
                            'msg' => $target_msg['msg'],
                            'msg_time' => date('Y-m-d H:i', $target_msg['msg_time']),
                            'guide' => $guide
                        );
                    }
                }
            }

            if ($course_status === false && $activity['endtime'] <= SYSTIME) {
                //申请失败
                if ($activity['endtime'] <= SYSTIME) {
                    array_unshift($msgs, array(
                        'object' => '课程申报结束',
                        'msg' => '您未成功申报任何课程，敬请期待下次选课活动。',
                        'msg_time' => date('Y-m-d H:i', $activity['endtime'])
                    ));
                }
                return $msgs;
            }

            if ($activity['endtime'] <= SYSTIME) {
                //申报课程结束
                array_unshift($msgs, array(
                    'object' => '课程申报结束',
                    'msg' => '等待管理员设置选课规则，发布第一轮选课',
                    'msg_time' => date('Y-m-d H:i', $activity['endtime']),
                    'guide' => array(
                        "<a href=\"/troomv2/xuanke/mycourse.html?aid=$aid\"  class=\"hjisres\">查看我的课程</a>"
                    )
                ));
            }

            if ($activity['status'] >= 3 &&
                $rule = $this->db->query(
                    "SELECT `start_t`,`end_t`,`step` FROM `ebh_xk_rules` WHERE `xkid`=$aid AND `step`=1;")
                    ->row_array()) {
                //第一轮选课进行中
                $student_count = 0;
                if (!empty($cids)) {
                    if ($s = $this->db->query(
                        "SELECT COUNT(DISTINCT `uid`) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$aid AND `bout`=1 AND `cid` IN(".implode(',', $cids).')')
                        ->row_array()) {
                        $student_count = $s['c'];
                    }
                }

                $data = array(
                    'object' => '第一轮选课进行中',
                    'msg' => '等待学生们进行第一轮选课',
                    'msg_time' => date('Y-m-d H:i', $activity['first_t']),
                    'int_arg' => array(
                        'value' => $student_count,
                        'format' => '已有%s位学生报名'
                    ),
                    'guide' => array(
                        "<a href=\"/troomv2/xuanke/signview.html?step=1&xkid=$aid\"  class=\"hjisres\">查看选课情况</a>"
                    )
                );
                if($rule['start_t'] > $rule['end_t']) {
                    $data['str_arg'] = sprintf('选课时间：%s', date('Y-m-d H:i', $rule['start_t']));
                } else {
                    $data['str_arg'] = sprintf('选课时间：%s 至 %s',
                        date('Y-m-d H:i', $rule['start_t']),
                        date('Y-m-d H:i', $rule['end_t']));
                }
                array_unshift($msgs, $data);

                if ($rule['end_t'] <= SYSTIME) {
                    //第一轮选课结束
                    $student_count = 0;
                    if (!empty($cids)) {
                        if ($s = $this->db->query(
                            "SELECT COUNT(1) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$aid AND `bout`=1 AND ".
                            "`status` IN(1,2) AND `cid` IN(".implode(',', $cids).')')->row_array()) {
                            $student_count = $s['c'];
                        }
                    }
                    array_unshift($msgs, array(
                        'object' => '第一轮选课结束',
                        'msg' => '对报名学生进行调整后提交至管理员',
                        'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                        'int_arg' => array(
                            'value' => $student_count,
                            'format' => '共计%s位学生报名'
                        ),
                        'guide' => array(
                            "<a href=\"/troomv2/xuanke/signadjust.html?step=1&xkid=$aid\"  class=\"hjisres\">调整选课结果</a>"
                        )
                    ));
                }
            }

            //完成选课
            if (isset($finish_beforehand)) {
                array_unshift($msgs, $finish_beforehand);
            }

            if (!isset($finish_beforehand) && $activity['status'] >= 5 &&
                $rule = $this->db->query(
                    "SELECT `start_t`,`end_t`,`step` FROM `ebh_xk_rules` WHERE `xkid`=$aid AND `step`=2")
                    ->row_array()) {
                //第二轮选课进行中
                $student_count = 0;
                if (!empty($cids)) {
                    if ($s = $this->db->query(
                        "SELECT COUNT(DISTINCT `uid`) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$aid AND".
                        " `status` IN(1,2) AND `cid` IN(".implode(',', $cids).")")->row_array()) {
                        $student_count = $s['c'];
                    }
                }

                $data = array(
                    'object' => '第二轮选课进行中',
                    'msg' => '等待学生们进行第二轮选课',
                    'msg_time' => date('Y-m-d H:i', $rule['start_t']),
                    'int_arg' => array(
                        'value' => $student_count,
                        'format' => '已有%s位学生报名'
                    ),
                    'guide' => array(
                        "<a href=\"/troomv2/xuanke/signview.html?step=2&xkid=$aid\"  class=\"hjisres\">查看报名情况</a>"
                    )
                );
                if($rule['start_t'] > $rule['end_t']) {
                    $data['str_arg'] = sprintf('选课时间：%s', date('Y-m-d H:i', $rule['start_t']));
                } else {
                    $data['str_arg'] = sprintf('选课时间：%s 至 %s',
                        date('Y-m-d H:i', $rule['start_t']),
                        date('Y-m-d H:i', $rule['end_t']));
                }
                array_unshift($msgs, $data);
                if ($rule['end_t'] < SYSTIME) {
                    //第二轮选课结束
                    $student_count = 0;
                    if (!empty($cids)) {
                        if ($s = $this->db->query(
                            "SELECT COUNT(1) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$aid AND".
                            " `status` IN(1,2) AND `cid` IN(".implode(',', $cids).")")->row_array()) {
                            $student_count = $s['c'];
                        }
                    }

                    array_unshift($msgs, array(
                        'object' => '第二轮选课结束',
                        'msg' => '对报名学生进行调整后提交至管理员',
                        'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                        'int_arg' => array(
                            'value' => $student_count,
                            'format' => '共计%s位学生报名'
                        ),
                        'guide' => array(
                            "<a href=\"/troomv2/xuanke/signadjust.html?xkid=$aid&step=2\"  class=\"hjisres\">调整报名结果</a>"
                        )
                    ));
                }
            }

            if ($activity['status'] >= 7) {
                //选课结束
                $student_count = 0;
                if (!empty($cids)) {
                    if ($s = $this->db->query(
                        "SELECT COUNT(DISTINCT `uid`) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$aid AND `status` IN(1,2) AND `cid` IN(".implode(',', $cids).")")
                        ->row_array()) {
                        $student_count = $s['c'];
                    }
                }

                array_unshift($msgs, array(
                    'object' => '选课活动结束',
                    'msg' => '您可以通过“查看结果”来统计选修课的报名学生',
                    'msg_time' => date('Y-m-d H:i', $activity['finish_time']),
                    'int_arg' => array(
                        'value' => $student_count,
                        'format' => '共计%s位学生报名'
                    ),
                    'guide' => array(
                        "<a href=\"/troomv2/xuanke/signresult.html?aid=$aid\"  class=\"hjisres\">查看结果</a>"
                    )
                ));
            }

            if ($activity['status'] == 8) {
                if($sur = $this->db->query("SELECT sid,`startdate`,`enddate` FROM `ebh_surveys` WHERE `cid`=$cid")
                    ->row_array()) {
                    //查看课程评价
                    $sid = $sur['sid'];
                    array_unshift($msgs, array(
                        'object' => '查看课程评价',
                        'msg' => '学生们已对您的选修课进行了评价',
                        'msg_time' => date('Y-m-d H:i', $activity['survey_time']),
                        'str_arg' => sprintf('评价时间：%s 至 %s',
                            date('Y-m-d H:i', $sur['startdate']),
                            date('Y-m-d H:i', $sur['enddate'])),
                        'guide' => array(
                            "<a href=\"/aroomv2/xuanke/stat/$sid.html\" target=\"_blank\"  class=\"hjisres\">查看评价</a>",
                        )
                    ));
                }
            }
        }
        return $msgs;
    }

    /**
     * 读取学生消息
     * @param $aid
     * @param $uid
     * @return array
     */
    public function readStudentMsg($aid, $uid) {
        $aid = (int) $aid;
        $uid = (int) $uid;
        $activity = $this->db->query(
            "SELECT xa.`first_t`,xa.`second_t`,xa.`status`,xa.`finish_time`,xa.`survey_time` FROM `ebh_xk_activitys` xa".
            " WHERE xa.`xkid`=$aid AND `isdel`=1 AND `status`>=3")->row_array();
        $msgs = array();
        if ($activity) {
            $data = null;
            if ($rule = $this->db->query(
                "SELECT `start_t`,`end_t`,`step` FROM `ebh_xk_rules` WHERE `xkid`=$aid AND `step`=1")
                ->row_array()) {
                //第一轮选课进行中
                $data = array(
                    'object' => '第一轮选课进行中',
                    'msg' => '在选课日期内可随时调整选修课程',
                    'msg_time' => date('Y-m-d H:i')/*,
                    'guide' => array(
                        "<a href=\"/college/xuanke/sign.html?xkid=$aid\"  class=\"hjisres\">去选课</a>"
                    )*/
                );
                if($rule['start_t'] > $rule['end_t']) {
                    $data['str_arg'] = sprintf('选课时间：%s', date('Y-m-d H:i', $rule['start_t']));
                } else {
                    $data['str_arg'] = sprintf('选课时间：%s 至 %s',
                        date('Y-m-d H:i', $rule['start_t']),
                        date('Y-m-d H:i', $rule['end_t']));
                }
                array_unshift($msgs, $data);
                //读取报名消息
                $signMessages = $this->db->query('SELECT `object`,`msg`,`msg_time` FROM `ebh_xk_msgs` WHERE `uid`='.$uid.' AND `xkid`='.$aid.' AND `category`=10 ORDER BY `mid`')->list_array();
                if (!empty($signMessages)) {
                    foreach ($signMessages as $signMessage) {
                        array_unshift($msgs, array(
                            'object' => $signMessage['object'],
                            'msg' => $signMessage['msg'],
                            'msg_time' => date('Y-m-d H:i', $signMessage['msg_time'])
                        ));
                    }
                }
                if ($rule['end_t'] <= SYSTIME) {
                    //第一轮选课结束
                    array_unshift($msgs, array(
                        'object' => '第一轮选课结束',
                        'msg' => '等待系统处理完毕，可查看报名结果',
                        'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                        'guide' => array(
                            "<a href=\"/college/xuanke/signcourse.html?step=1&xkid=$aid\"  class=\"hjisres\">我报名的课程</a>"
                        )
                    ));
                }
            } else {
                return $msgs;
            }
            $cid = 0;
            if ($activity['status'] >= 5 &&
                $rule = $this->db->query(
                    "SELECT `start_t`,`end_t`,`step` FROM `ebh_xk_rules` WHERE `xkid`=$aid AND `step`=2")
                    ->row_array()) {
                //第一轮报名结果
                $sql = "SELECT `cid`,`failmsg`,`uptime`,`status` FROM `ebh_xk_students` WHERE ".
                    "`xkid`=$aid AND `uid`=$uid AND `bout`=1";
                if ($sign = $this->db->query($sql)->list_array()) {
                    $cids = array_column($sign, 'cid');
                    $cids = implode(',', $cids);
                    $courses = $this->db->query(
                        "select cid,coursename from ebh_xk_courses where cid in($cids) AND `del`=0")->list_array('cid');
                    foreach ($sign as $item) {
                        if ($item['status'] == 0) {
                            //报名失败
                            array_unshift($msgs, array(
                                'object' => '报名失败',
                                'msg' => sprintf('你报名的《%s》课程，%s',
                                    $courses[$item['cid']]['coursename'], $item['failmsg']),
                                'msg_time' => date('Y-m-d H:i', $item['uptime'])
                            ));
                            continue;
                        }
                        if ($item['status'] == 1) {
                            $cid = $item['cid'];
                            //报名成功
                            array_unshift($msgs, array(
                                'object' => '报名成功',
                                'msg' => sprintf('你已成功报名《%s》课程。', $courses[$item['cid']]['coursename']),
                                'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                                'guide' => array(
                                    "<a href=\"\"  class=\"hjisres\">我的课程</a>"
                                )
                            ));
                        }
                    }
                }
                //第二轮选课进行中
                $data = array(
                    'object' => '第二轮选课进行中',
                    'msg' => '你可根据第一轮选课结果及第二轮选课规则，考虑是否继续选课',
                    'msg_time' => date('Y-m-d H:i', $activity['second_t'])
                );
                if($rule['start_t'] > $rule['end_t']) {
                    $data['str_arg'] = sprintf('选课时间：%s', date('Y-m-d H:i', $rule['start_t']));
                } else {
                    $data['str_arg'] = sprintf('选课时间：%s 至 %s',
                        date('Y-m-d H:i', $rule['start_t']),
                        date('Y-m-d H:i', $rule['end_t']));
                }
                array_unshift($msgs, $data);
                //读取报名消息
                $signMessages = $this->db->query('SELECT `object`,`msg`,`msg_time` FROM `ebh_xk_msgs` WHERE `uid`='.$uid.' AND `xkid`='.$aid.' AND `category`=10 AND `msg_time`>'.$rule['start_t'].' ORDER BY `mid`')->list_array();
                if (!empty($signMessages)) {
                    foreach ($signMessages as $signMessage) {
                        array_unshift($msgs, array(
                            'object' => $signMessage['object'],
                            'msg' => $signMessage['msg'],
                            'msg_time' => date('Y-m-d H:i', $signMessage['msg_time'])
                        ));
                    }
                }
                if ($rule['end_t'] < SYSTIME) {
                    //第二轮选课结束
                    array_unshift($msgs, array(
                        'object' => '第二轮选课结束',
                        'msg' => '等待系统处理完毕，可查看报名结果',
                        'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                        'guide' => array(
                            "<a href=\"/college/xuanke/signcourse.html?step=2&xkid=$aid\"  class=\"hjisres\">我报名的课程</a>"
                        )
                    ));
                }
            }

            if ($activity['status'] >= 6) {
                //选课完成
                //第二轮报名结果
                $sql = "SELECT c.`coursename`,i.`realname`,s.`status`,s.`cid` FROM ".
                    "(SELECT `cid`,`uptime`,`status` FROM `ebh_xk_students` WHERE `xkid`=$aid AND `uid`=$uid AND `bout`=2) AS s".
                    " LEFT JOIN `ebh_xk_courses` c ON(`c`.`cid`=`s`.`cid`) LEFT JOIN `ebh_users` i ON(`c`.`uid`=`i`.`uid`);";

                $sql = "SELECT `cid`,`uptime`,`status`,`tid` FROM `ebh_xk_students` WHERE `xkid`=$aid AND `uid`=$uid AND `bout`=2";
                if ($sign = $this->db->query($sql)->list_array()) {
                    $cids = array_column($sign, 'cid');
                    $cids = implode(',', $cids);
                    $courses = $this->db->query(
                        "select cid,coursename from ebh_xk_courses where cid in($cids)")->list_array('cid');
                    $tids = array_column($sign, 'tid');
                    $tids = array_filter($tids, function($e) {
                        return $e > 0;
                    });
                    $tids = implode(',', $tids);
                    $teachers = array();
                    if(empty($tids) === false) {
                        $teachers = $this->db->query(
                            "select uid,realname,username from ebh_users where uid in($tids)")->list_array('uid');
                    }
                    foreach ($sign as $item) {
                        $cid = $item['cid'];
                        if ($item['status'] == 1) {
                            //报名成功
                            array_unshift($msgs, array(
                                'object' => '报名成功',
                                'msg' => sprintf('你已成功报名《%s》课程。', $courses[$item['cid']]['coursename']),
                                'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                                'guide' => array(
                                    "<a href=\"/college/xuanke/mycourse.html?xkid=$aid\"  class=\"hjisres\">我的课程</a>"
                                )
                            ));
                            continue;
                        }
                        if ($item['status'] == 2) {
                            //被教师添加
                            array_unshift($msgs, array(
                                'object' => '你被选中了',
                                'msg' => sprintf('你被%s老师选中，参加课程《%s》。',
                                    isset($teachers[$item['tid']]) ? $teachers[$item['tid']]['realname'] : '',
                                    $courses[$item['cid']]['coursename']),
                                'msg_time' => date('Y-m-d H:i', $rule['end_t']),
                                'guide' => array(
                                    "<a href=\"/college/xuanke/mycourse.html?xkid=$aid\"  class=\"hjisres\">我的课程</a>"
                                )
                            ));
                        }
                    }
                }
            }


            $c = $this->db->query(
                "SELECT COUNT(1) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$aid AND `uid`=$uid AND `status` IN(1,2)")
                ->row_array();

            if(empty($c)) {
                $c = 0;
            } else {
                $c = $c['c'];
            }
            if($activity['status'] >= 7 && $c == 0) {
                array_unshift($msgs, array(
                    'object' => '活动结束',
                    'msg' => '本次活动结束，你未成功报名任何课程。',
                    'msg_time' => date('Y-m-d H:i', $activity['finish_time'])
                ));
                return $msgs;
            }

            if ($activity['status'] == 8 && $c > 0) {
                //问卷调查
                if($sur = $this->db->query(
                    "SELECT `startdate`,`enddate` FROM `ebh_surveys` WHERE `cid`=$cid")->row_array()) {
                    array_unshift($msgs, array(
                        'object' => '参与课程评价问卷调查',
                        'msg' => '为了给同学们提供优质的课程，请积极参加课程评价调查',
                        'msg_time' => date('Y-m-d H:i', $activity['survey_time']),
                        'str_arg' => sprintf('评价时间：%s 至 %s',
                            date('Y-m-d H:i', $sur['startdate']),
                            date('Y-m-d H:i', $sur['enddate'])),
                        'guide' => array(
                            "<a href=\"/college/xuanke/mycourse.html?xkid=$aid\" class=\"hjisres\">参与评价</a>",
                        )
                    ));
                    if($sur['enddate'] < SYSTIME){
                        array_unshift($msgs, array(
                            'object' => '评价结束',
                            'msg' => '感谢你的参与',
                            'msg_time' => date('Y-m-d H:i', $sur['enddate']),
//                            'str_arg' => sprintf('评价日期：%s 至 %s',
//                                date('Y-m-d', $sur['startdate']),
//                                date('Y-m-d', $sur['enddate'])),
                            'guide' => array(
                                "<a href=\"/college/xuanke/mycourse.html?xkid=$aid\" class=\"hjisres\">查看评价</a>",
                            )
                        ));
                    }
                }
            }
        }
        return $msgs;
    }

    /**
     * 发消息
     * @param $aid 活动ID
     * @param $uid 消息目标用户ID
     * @param $msg_category 消息类型
     * @param $param 消息参数
     */
    public function sendMsg($aid, $uid, $msg_category, $param) {
        $aid = (int) $aid;
        $param['xkid'] = $aid;
        $param['uid'] = (int) $uid;
        $param['msg_time'] = SYSTIME;
        $param['category'] = $msg_category;

        return $this->db->insert('ebh_xk_msgs', $param);
    }

    /**
     * 申报课程消息
     * @param $aid
     * @param $uid
     * @param $cid
     * @param $coursename
     * @return mixed
     */
    public function reportSuccess($aid, $uid, $cid, $coursename) {
        $aid = (int) $aid;
        $course = $this->db->query('SELECT `coursename`,`starttime`,`endtime`,`classtime`,`classnum` FROM `ebh_xk_courses` WHERE `cid`='.$cid)->row_array();
        $param = array(
            'object' => '已申报《'.$coursename.'》',
            'cid' => (int) $cid,
            'msg' => '上课日期：'.date('Y-m-d', $course['starttime']).' 至 '.date('Y-m-d', $course['endtime']).'　　上课时间：'.$course['classtime'].'　　名额限制：'.$course['classnum'].'人',
            'guide' => json_encode(array("<a href=\"/troomv2/xuanke/mycourse.html?aid=$aid#c".$cid."\" class=\"hjisres\">查看</a>"))
        );
        return $this->sendMsg($aid, $uid, self::MSG_SIGN_SUCCESS, $param);
    }

    /**
     * 申报课程失败消息
     * @param $aid
     * @param $uid
     * @param $cid
     * @param $msg
     * @return mixed
     */
    public function reportFail($aid, $uid, $cid, $msg) {
        $aid = (int) $aid;
        $course = $this->db->query('SELECT `coursename`,`starttime`,`endtime`,`classtime`,`classnum` FROM `ebh_xk_courses` WHERE `cid`='.$cid)->row_array();
        $param = array(
            'object' => '课程《'.$course['coursename'].'》申报失败',
            'msg' => $msg,
            'cid' => (int) $cid//, 'guide' => json_encode(array("<a href=\"/troomv2/xuanke/report.html?xkid=$aid&again=1\" class=\"hjisres\">重新开课</a>"))
        );
        return $this->sendMsg($aid, $uid, self::MSG_REPORT_FAIL, $param);
    }

    /**
     * 重新申报课程消息
     * @param $aid
     * @param $uid
     * @param $cid
     * @param $msg
     * @return mixed
     */
    public function reportAgain($aid, $uid, $cid) {
        $aid = (int) $aid;
        $param = array(
            'object' => '课程申报中',
            'msg' => '根据实际情况开设自己的选修课',
            'cid' => (int) $cid,
            'guide' => json_encode(array("<a href=\"/troomv2/xuanke/mycourse.html?t=v&aid=$aid\" class=\"hjisres\">查看课程</a>"))
        );
        return $this->sendMsg($aid, $uid, self::MSG_REPORT_FAIL, $param);
    }

    public function finishBeforehand($aid, $uid, $cid) {
        $aid = (int) $aid;
        $param = array(
            'object' => '完成选课',
            'msg' => '您的课程已于第一轮选课中完成选课',
            'cid' => (int) $cid,
            'guide' => json_encode(array("<a href=\"/troomv2/xuanke/signresult.html?aid=$aid\" class=\"hjisres\">查看结果</a>"))
        );
        return $this->sendMsg($aid, $uid, self::MSG_SIGN_FINISH, $param);
    }

    /**
     * 报名消息
     * @param $aid
     * @param $cid
     * @param $uid
     * @param $eventType 事件类型：0-报名，1-取消报名
     * @return mixed
     */
    public function signMessage($aid, $cid, $uid, $eventType) {
        $course = $this->db->query('SELECT `coursename`,`starttime`,`endtime`,`classtime`,`classnum` FROM `ebh_xk_courses` WHERE `cid`='.$cid)->row_array();
        $param = array(
            'object' => (empty($eventType) ? '取消报名' : '已报名').'《'.$course['coursename'].'》',
            'msg' => '上课日期：'.date('Y-m-d', $course['starttime']).' 至 '.date('Y-m-d', $course['endtime']).'　　上课时间：'.$course['classtime'].'　　名额限制：'.$course['classnum'].'人',
            'cid' => $cid
        );
        return $this->sendMsg($aid, $uid, 10, $param);
    }
}