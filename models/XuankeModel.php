<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/15
 * Time: 13:17
 */
class XuankeModel extends CModel{

    public function __construct(){
        //强制使用主数据库
        parent::__construct();
        $this->db->set_con(0);
    }

    public function getActivity($param) {
        if(empty($param['crid'])){
            return false;
        }
        if(empty($param['xkid'])) {
            return false;
        }
        $sql = 'select * from ebh_xk_activitys';
        $where = ' where isdel=1 and crid = '.$param['crid'] . ' AND xkid=' . $param['xkid'];
        $sql.=$where;
        $list = $this->db->query($sql)->row_array();
        return $list;
    }

    /**
     * 获取班级名称
     * @param $crid
     * @param $classid
     * @return bool
     */
    public function getClassName($crid, $classid) {
        $crid = (int) $crid;
        $classid = (int) $classid;
        $sql = "SELECT `classname` FROM `ebh_classes` WHERE `classid`=$classid AND `crid`=$crid AND `status`=0";
        $ret = $this->db->query($sql)->row_array();
        if (empty($ret)) {
            return false;
        }
        return $ret['classname'];
    }

    /**
     * 班级学生报名情况
     * @param $xkid
     * @param $crid
     * @param $classid
     * @return array
     */
    public function getClassStudents($xkid, $crid, $classid) {
        $xkid = (int) $xkid;
        $crid = (int) $crid;
        $classid = (int) $classid;

        if ($xkid < 1 && $crid < 1 || $classid < 1) {
            return false;
        }

        $sql = "SELECT DISTINCT `uid` FROM `ebh_classstudents` WHERE `classid`=$classid";
        $uid_arr = $this->db->query($sql)->list_field('uid');
        if (empty($uid_arr)) {
            return false;
        }
        $sql = "SELECT `a`.`uid`,`a`.`cid` FROM `ebh_xk_students` `a` JOIN `ebh_classstudents` `b` ON `a`.`uid`=`b`.`uid`" .
            " AND `a`.`xkid`=$xkid AND `a`.`status` IN(1,2) AND `b`.`classid`=$classid";

        $sign_arr = $this->db->query($sql)->list_array();
        if (empty($sign_arr)) {
            //没有学生报名
            $uid_arr_str = implode(',', $uid_arr);
            $sql = "SELECT u.`sex`,u.`face`,u.`username`,u.`realname`,u.`groupid` FROM `ebh_users` u join ebh_roomusers ru on u.uid=ru.uid WHERE u.`uid` IN($uid_arr_str) and u.status=1 and ru.cstatus=1 and ru.crid=".$crid;
            return $this->db->query($sql)->list_array();
        }

        $sign_uid_arr = array_unique(array_column($sign_arr, 'uid'));
        $sign_uid_arr_str = implode(',', $sign_uid_arr);
        $unsign_uid_arr = array_diff($uid_arr, $sign_uid_arr);
        unset($sign_uid_arr);

        $sql = "SELECT u.uid,u.`sex`,u.`face`,u.`username`,u.`realname`,u.`groupid` FROM `ebh_users` u join ebh_roomusers ru on u.uid=ru.uid WHERE u.`uid` IN($sign_uid_arr_str) and u.status=1 and ru.cstatus=1 and ru.crid=".$crid;
        $students = $this->db->query($sql)->list_array('uid');
        if (empty($students)) {
            return false;
        }

        $courseid_arr = array_unique(array_column($sign_arr, 'cid'));
        $courseid_arr_str = implode(',', $courseid_arr);
        unset($courseid_arr);
        $courses = $this->db->query("SELECT `cid`,`coursename`,`ap`,`classtime`,`place` FROM `ebh_xk_courses` WHERE `cid` IN($courseid_arr_str) AND `status`>0 AND `del`=0")->list_array('cid');
        if (empty($courses)) {
            return false;
        }
        foreach ($sign_arr as $signitem) {
            if (!key_exists($signitem['uid'], $students)) {
                continue;
            }
            if (!key_exists('courses', $students[$signitem['uid']])) {
                $students[$signitem['uid']]['courses'] = array();
            }
            if (key_exists($signitem['cid'], $courses)) {
                $students[$signitem['uid']]['courses'][] = $courses[$signitem['cid']];
            }
        }
        $students = array_values($students);

        if (!empty($unsign_uid_arr)) {
            $unsign_uid_arr_str = implode(',', $unsign_uid_arr);
            unset($unsign_uid_arr);
            $sql = "SELECT u.`sex`,u.`face`,u.`username`,u.`realname`,`groupid` FROM `ebh_users` u join ebh_roomusers ru on u.uid=ru.uid WHERE u.`uid` IN($unsign_uid_arr_str) and ru.cstatus=1 and u.status=1 and ru.crid=".$crid;
            if ($unsign_students = $this->db->query($sql)->list_array()) {
                $students = array_merge($students, $unsign_students);
            }
        }
        return $students;
    }

    //获取选课活动列表
    public function getList($param){
        if(empty($param['crid'])){
            return false;
        }
        $sql = 'select * from ebh_xk_activitys';
        $where = ' where isdel=1 and crid = '.$param['crid'];
        if(!empty($param['uid'])){
            $where .= ' and uid = '.$param['uid'];
        }
        $sql.=$where;
        $sql.=' order by datetime desc,xkid desc';
        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
            if (empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
        $list = $this->db->query($sql)->list_array();
        return $list;
    }

    /**
     * 获取选课活动状态列表
     * @param $param
     * @return bool
     */
    public function getListWithStatus($param){
        if(empty($param['crid'])){
            return false;
        }
        $crid = (int) $param['crid'];
        $sql = "SELECT * FROM `ebh_xk_activitys` WHERE isdel=1 and `crid`=$crid";

        if(!empty($param['uid'])){
            $sql .= " AND `uid`=" . $param['uid'];
        }
        if(empty($param['status']) === false) {
            $sql .= " AND `status`>=" . intval($param['status']);
        }

        $sql.= " ORDER BY `datetime` DESC";
        if(!empty($param['limit'])) {
            $sql .= ' LIMIT '.$param['limit'];
        } else {
            if (empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= ' LIMIT ' . $start . ',' . $pagesize;
        }

        $activitys = $this->db->query($sql)->list_array('xkid');

        if(empty($activitys)) {
            return false;
        }
        $xkids = array_column($activitys, 'xkid');
        $xkids = array_unique($xkids);


        $rules = $this->db->query("SELECT xkid,start_t,end_t,step FROM ebh_xk_rules WHERE xkid in(" . implode(',',$xkids). ")")
            ->list_array();
        if(!empty($rules)) {
            foreach($rules as $rule) {
                if($rule['step'] == 1) {
                    $activitys[$rule['xkid']]['start_t'] = $rule['start_t'];
                    $activitys[$rule['xkid']]['end_t'] = $rule['end_t'];
                    continue;
                }
                if($rule['step'] == 2) {
                    $activitys[$rule['xkid']]['start_t_2'] = $rule['start_t'];
                    $activitys[$rule['xkid']]['end_t_2'] = $rule['end_t'];
                    continue;
                }
            }
        }

        return $activitys;
    }

    //选课活动数
    public function getListCount($param){
        $sql = 'select count(*) as count from ebh_xk_activitys';
        $where = ' where isdel=1';
        if(!empty($param['crid'])){
            $where .= ' and crid ='.$param['crid'];
        }
        if(!empty($param['uid'])){
            $where .= ' and uid = '.$param['uid'];
        }
        $status = 0;
        if(empty($param['status']) === false) {
            $status = intval($param['status']);
            $status = max(0, $status);
            $where .= ' and status>=' . $status;
        }
        $sql.=$where;
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }

    //添加选课活动
    public function add($param){
        if(empty($param['crid'])){
            return false;
        }
        $param['explains'] = $this->db->escape_str($param['explains']);//防止sql注入
        return $this->db->insert('ebh_xk_activitys',$param);
    }


    //发布选课活动,或者编辑
    public function fbxk($param,$where){
        if(empty($where['xkid'])){
            return false;
        }
        $param['ispause'] = 0;
        $where['xkid'] = intval($where['xkid']);
        $ret = $this->db->update('ebh_xk_activitys',$param,$where);
        return $ret;
    }

    //获取选课详情
    public function getXuanke($param){
        if(empty($param['xkid'])||empty($param['crid'])){
            return false;
        }
        $sql = 'select xa.* from ebh_xk_activitys xa where isdel =1 and xkid='.$param['xkid'].' and crid ='.$param['crid'];
        return $this->db->query($sql)->row_array();
    }

    /**
     * 当前活动下的申报课程
     * @param $xkid
     * @return mixed
     */
    public function getCurrentCourse($xkid, $uid) {
        $xkid = (int) $xkid;
        $uid = (int) $uid;
        return $this->db->query("SELECT `cid`,`status` FROM `ebh_xk_courses` WHERE `xkid`=$xkid AND `uid`=$uid AND `del`=0 ORDER BY `cid` DESC;")->row_array();
    }

    /**
     * 获取课程
     * @param $cid
     */
    public function getCourseForUpdate($cid) {
        $cid = (int) $cid;
        return $this->db->query("SELECT * FROM `ebh_xk_courses` WHERE `cid`=$cid AND `status`=1 AND `del`=0")->row_array();
    }

    //获取课程列表
    public function getCourseList($param){
        if(empty($param['xkid'])||empty($param['crid'])||empty($param['uid'])){
            return false;
        }
        $this->db->set_con(0);
        $sql = 'select xc.*,u.username,u.realname from ebh_xk_courses xc LEFT JOIN ebh_users u on xc.uid = u.uid LEFT JOIN ebh_xk_activitys xa on xc.xkid=xa.xkid';
        $where = ' where xc.xkid ='.$param['xkid'].' and xc.crid ='.$param['crid'].' and (xc.uid ='.$param['uid'].' or xa.uid ='.$param['uid'].')';
        if (isset($param['ap'])) {
            $where .=' and xc.ap='.$param['ap'];
        }
        if(!empty($param['status'])){
            $where .= ' and xc.status='.$param['status'];
        }else{
            $where .= ' and xc.status in(1,2)';
        }
		$where .= ' and xc.del=0';
        $sql.=$where;
        $sql.=' order by xc.ordernum';
        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
            if (empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 20 : $param['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
        $result =  $this->db->query($sql)->list_array();
        $this->db->reset_con();
        return $result;
    }

    /**
     * 获取选课列表
     */
    public function getxklist($param){
        $where = array();
        $this->db->set_con(0);
        $sql = 'select xc.cid,xc.coursename,xs.classname,xs.bout,u.uid,u.username,u.realname from ebh_xk_students xs
                LEFT JOIN  ebh_xk_courses xc on xc.cid = xs.cid
                LEFT JOIN ebh_users u on xs.uid = u.uid
                LEFT JOIN ebh_xk_activitys xa on xc.xkid=xa.xkid';
        if(!empty($param['xkid'])){
            $where[] = ' xc.xkid ='.$param['xkid'];
        }
        if(!empty($param['crid'])){
            $where[] = ' xc.crid ='.$param['crid'];
        }
        if(!empty($param['uid'])){
            $where[] = ' xc.uid ='.$param['uid'];
        }
		$where[] = 'xc.del=0 and xs.status in(1,2)';
        if(!empty($where)){
            $sql.=' where '.implode(" AND ", $where);
        }
        if(!empty($param['orderby'])){
            $sql.=' order by '.$param['orderby'];
        }

        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        }
        //log_message($sql);

        $result =  $this->db->query($sql)->list_array();
        $this->db->reset_con();

        return $result;

    }


    /**
     * 判断是否网校学生
     * @param $uid
     * @param $crid
     * @return bool
     */
    public function is_student($uid, $crid) {
        $uid = (int) $uid;
        $crid = (int) $crid;
        $sql = "SELECT `uid` FROM `ebh_roomusers` WHERE `uid`=$uid AND `crid`=$crid LIMIT 1";
        $result = $this->db->query($sql)->row_array();
        if(empty($result)) {
            return false;
        }
        return true;
    }

    public function getActivityCourse($param) {
        if(empty($param['xkid']) || empty($param['crid'])) {
            return false;
        }
        $param['xkid'] = (int) $param['xkid'];
        $param['crid'] = (int) $param['crid'];
        $this->db->set_con(0);
        $courses = $this->db->query("SELECT * FROM `ebh_xk_courses` WHERE `status`>0 AND `xkid`=" .
            $param['xkid'] . " AND `crid`=" . $param['crid'] . " and del=0 ORDER BY `ordernum` ASC")->list_array('cid');
        $this->db->reset_con();
        if(empty($courses)) {
            return false;
        }
        $uids = array_column($courses, 'uid');
        $uids = array_unique($uids);

        $uids = implode(',', $uids);
        $users = $this->db->query("SELECT uid,realname,username FROM ebh_users WHERE uid IN($uids)")->list_array('uid');
        if(empty($users)) {
            return false;
        }
        foreach($courses as &$course) {
            if(isset($users[$course['uid']])) {
                $course['realname'] = empty($users[$course['uid']]['realname']) === false ?
                    $users[$course['uid']]['realname'] : $users[$course['uid']]['username'];
            }
        }
        return $courses;
    }

    //获取课程总数
    public function getCourseCount($param){
        if(empty($param['xkid'])||empty($param['crid'])){
            return false;
        }
        $sql = 'select count(*) as count from ebh_xk_courses xc';
        $where = ' where xkid ='.intval($param['xkid']).' and crid ='.intval($param['crid']).' and del=0';
        if(!empty($param['status'])){
            $where .= ' and xc.status='.intval($param['status']);
        }else{
            $where .= ' and xc.status in(1,2)';
        }
        $sql.=$where;
        $res = $this->db->query($sql)->row_array();
        return $res['count'];
    }

    /**
     * 获取课程名称
     * @param $xkid
     * @param $cid
     * @return bool
     */
    public function getCourseName($xkid, $cid) {
        $xkid = (int) $xkid;
        $cid = (int) $cid;
//        $uid = (int) $uid;
        $course = $this->db->query(
            "SELECT coursename from ebh_xk_courses WHERE xkid=$xkid AND cid=$cid AND status>0 AND del=0")->row_array();
        if(empty($course)) {
            return false;
        }
        return $course['coursename'];
    }
    //获取课程详情
    public function getCourse($param){
        if(empty($param['cid'])){
            return false;
        }
        $sql = 'select * from ebh_xk_courses xc';
        $where = ' where xc.cid ='.$param['cid'].' and xc.del=0';
        if(!empty($param['status'])){
            $where .= ' and xc.status='.$param['status'];
        }else{
            $where .= ' and xc.status in(1,2)';
        }
        $sql .= $where;

        $course = $this->db->query($sql)->row_array();
        if(empty($course) === true) {
            return false;
        }
        $uid = $course['uid'];
        $user = $this->db->query("SELECT uid,realname,username FROM ebh_users WHERE uid=$uid")->row_array();
        if(empty($user)) {
            return false;
        }
        $course['realname'] = $user['realname'];
        $course['username'] = $user['username'];
        return $course;
    }

    /**
     * 简单获取课程信息
     * @param $cid
     * @param $xkid
     */
    public function getSingleCourse($cid, $xkid) {
        $xkid = (int) $xkid;
        $cid = (int) $cid;
        $sql = "SELECT `cid`,`uid`,`range_type`,`range_args`,`classnum`,`classapplynum`,`studentsnum`,`coursename`,`ap` FROM `ebh_xk_courses`".
            " WHERE `cid`=$cid AND `xkid`=$xkid AND `del`=0 AND `status`=1;";
        return $this->db->query($sql)->row_array();
    }

    //保存课程
    public function saveCourse($param,$where, $xkid = 0){
        if(empty($where['cid'])){
            return false;
        }
        $where = array('cid'=>(int)$where['cid']);
        $sparam = array();
        if(isset($param['status']) === true) {
            $sparam['status'] = intval($param['status']);
        }
        if(isset($param['starttime']) === true) {
            $sparam['starttime'] = (int) $param['starttime'];
        }
        if(isset($param['datetime']) === true) {
            $sparam['datetime'] = (int) $param['datetime'];
        }
        if(isset($param['endtime']) === true) {
            $sparam['endtime'] = (int)$param['endtime'];
        }
        if(isset($param['classnum']) === true) {
            $sparam['classnum'] = (int)$param['classnum'];
        }
        if(isset($param['classapplynum']) === true) {
            $sparam['classapplynum'] = (int) $param['classapplynum'];
        }
        if(isset($param['failedmsg']) === true) {
            $sparam['failedmsg'] = $param['failedmsg'];
        }
        if(isset($param['coursename']) === true) {
            $sparam['coursename'] = $this->db->escape_str($param['coursename']);
        }
        if(isset($param['introduce']) === true) {
            $sparam['introduce'] = $this->db->escape_str($param['introduce']);
        }
        if(isset($param['images']) === true) {
            $sparam['images'] = $param['images'];
        }
        if(isset($param['place']) === true) {
            $sparam['place'] = $this->db->escape_str($param['place']);
        }
        if(isset($param['classtime']) === true) {
            $sparam['classtime'] = $this->db->escape_str($param['classtime']);
        }
        if(isset($param['range_type']) === true) {
            $sparam['range_type'] = intval($param['range_type']);
        }
        if(isset($param['range_args']) === true) {
            $sparam['range_args'] = $this->db->escape_str($param['range_args']);
        }
        if(isset($param['isup']) === true) {
            $sparam['isup'] = intval($param['isup']);
        }
        if(isset($param['studentsnum']) === true) {
            $sparam['studentsnum'] = intval($param['studentsnum']);
        }
        if(isset($param['firstnum']) === true) {
            $sparam['firstnum'] = intval($param['firstnum']);
        }
        if(isset($param['secondnum']) === true) {
            $sparam['secondnum'] = intval($param['secondnum']);
        }
        if(isset($param['ap'])) {
            $sparam['ap'] = $param['ap'];
        }
        if(empty($sparam) === true) {
            return false;
        }
        if (isset($param['studentids'])) {
            $sparam['studentsnum'] = $sparam['firstnum'] = count($param['studentids']);
            if (empty($param['studentids'])) {
                $sparam['studentsnum'] = $sparam['firstnum'] = 0;
            }
        }
        $param['ip'] = EBH::app()->getInput()->getip();
        $this->db->begin_trans();
        $ret = $this->db->update('ebh_xk_courses',$sparam,$where);
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        if (isset($param['studentids'])) {
            $this->db->delete('ebh_xk_students', array('xkid' => $xkid, 'status' => 2, 'bout' => 1, 'cid' => $where['cid']));
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
            foreach ($param['studentids'] as $studentid => $item) {
                $this->db->insert('ebh_xk_students', array(
                    'xkid' => $xkid,
                    'cid' => $where['cid'],
                    'uid' => $studentid,
                    'bout' => 1,
                    'sign_time' => 0,
                    'status' => 2,
                    'classname' => $item['classname'],
                    'tid' => $item['tid'],
                    'uptime' => SYSTIME
                ));
                if ($this->db->trans_status() === false) {
                    $this->db->rollback_trans();
                    return false;
                }
            }
        }

        $this->db->commit_trans();
        return $ret;
    }

    /**
     * 添加选课规则
     * @param $param
     */
    public function addRule($param) {
        if (empty($param['xkid']) || empty($param['start_t']) || empty($param['end_t']) || empty($param['remark'])) {
            return false;
        }
        $sparam = array();
        if (empty($param['max_sign_count']) === false) {
            $sparam['max_sign_count'] = (int) $param['max_sign_count'];
        } else {
            $sparam['max_sign_count'] = 1;
        }

        if (empty($param['step']) === false) {
            $sparam['step'] = (int) $param['step'];
        } else {
            $sparam['step'] = 1;
        }
        $sparam['xkid'] = (int) $param['xkid'];
        $sparam['start_t'] = (int) $param['start_t'];
        $sparam['end_t'] = (int) $param['end_t'];
        $sparam['remark'] = $this->db->escape_str($param['remark']);

        return $this->db->insert('ebh_xk_rules', $sparam);
    }

    public function checkStudentReportStatus($studentids = array(), $xkid, $crid) {
        if (empty($studentids)) {
            return array();
        }
        //学生报名状态验证，一个学生最多只能报两门课，上课时间段不能冲突,假设同一天上课
        $wheres = array(
            '`a`.`xkid`='.$xkid,
            '`a`.`uid` IN('.implode(',', $studentids).')',
            '`a`.`status` IN(1,2)',
            '`b`.`crid`='.$crid,
            '`b`.`status`>0',
            '`b`.`del`=0'
        );
        $sql = 'SELECT `a`.`uid`,GROUP_CONCAT(`a`.`cid`) AS `cid`,`c`.`realname`,`c`.`username`,GROUP_CONCAT(`b`.`ap`) AS `ap`,`b`.`uid` AS `tid`
                FROM `ebh_xk_students` `a`
                JOIN `ebh_xk_courses` `b` ON `b`.`cid`=`a`.`cid`
                JOIN `ebh_users` `c` ON `c`.`uid`=`a`.`uid`
                JOIN `ebh_roomusers` `d` ON `d`.`uid`=`a`.`uid` AND `d`.`crid`='.$crid.'
                WHERE '.implode(' AND ', $wheres).' GROUP BY `a`.`uid`';
        return $this->db->query($sql)->list_array('uid');
    }

    //添加课程
    public function addCourse($param) {
        if (empty($param['xkid']) || empty($param['crid']) || empty($param['uid'])
            || empty($param['coursename']) || empty($param['introduce']) || empty($param['images'])
            || empty($param['starttime']) || empty($param['endtime']) || empty($param['classtime'])
            || empty($param['classnum'])) {
            return false;
        }
        $sparam = array();
        $sparam['xkid'] = (int) $param['xkid'];
        $sparam['crid'] = (int) $param['crid'];
        $sparam['uid'] = (int) $param['uid'];
        $sparam['starttime'] = (int) $param['starttime'];
        $sparam['endtime'] = (int) $param['endtime'];
        $sparam['classnum'] = (int) $param['classnum'];
        $sparam['ap'] = (int) $param['ap'];
        $sparam['coursename'] = $this->db->escape_str($param['coursename']);
        $sparam['introduce'] = $this->db->escape_str($param['introduce']);
        $sparam['images'] = $param['images'];
        $sparam['place'] = $this->db->escape_str($param['place']);
        $sparam['classtime'] = $this->db->escape_str($param['classtime']);
        $sparam['range_type'] = intval($param['range_type']);
        $sparam['range_args'] = $this->db->escape_str($param['range_args']);
        $sparam['datetime'] = SYSTIME;
        $sparam['ip'] = EBH::app()->getInput()->getip();
        $initStudent = false;
        if (!empty($param['studentids']) && is_array($param['studentids'])) {
            $initStudent = true;
            $sparam['firstnum'] = $sparam['studentsnum'] = count($param['studentids']);
            $this->db->begin_trans();
        }

        $cid = $this->db->insert('ebh_xk_courses', $sparam);
        if ($initStudent && $this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        if ($initStudent) {
            foreach ($param['studentids'] as $studentid => $classname) {
                $this->db->insert('ebh_xk_students', array(
                    'xkid' => $sparam['xkid'],
                    'cid' => $cid,
                    'uid' => $studentid,
                    'bout' => 1,
                    'sign_time' => 0,
                    'status' => 2,
                    'classname' => $classname,
                    'tid' => $sparam['uid'],
                    'uptime' => SYSTIME,
                    'ip' => EBH::app()->getInput()->getip()
                ));
                if ($this->db->trans_status() === false) {
                    $this->db->rollback_trans();
                    return false;
                }
            }
        }
        if ($initStudent) {
            $this->db->commit_trans();
        }
        return $cid;
    }

    /**
     * 重新申报课程
     * @param $param
     * @return bool
     */
    public function reportAgain($param) {
        $this->db->begin_trans();
        $re = $this->addCourse($param);
        if($re === false) {
            $this->db->rollback_trans();
            return false;
        }

        $aid = (int) $param['xkid'];

        $param = array(
            'xkid' => $aid,
            'uid' => (int) $param['uid'],
            'msg_time' => SYSTIME,
            'category' => 1,
            'object' => '课程申报中',
            'msg' => '根据实际情况开设自己的选修课',
            'cid' => $re,
            'guide' => json_encode(array("<a href=\"/troomv2/xuanke/mycourse.html?t=v&aid=$aid\" class=\"hjisres\">查看课程</a>"))
        );

        $re = $this->db->insert('ebh_xk_msgs', $param);
        if($re === false || $re == 0) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->commit_trans();
        return true;
    }

    /**
     * 获取教师课程
     * @param $param
     */
    public function getOwnCourse($aid, $uid, $cid = 0) {
        $sql = 'SELECT `a`.`cid`,`a`.`xkid`,`a`.`coursename`,`a`.`introduce`,`a`.`images`,`a`.`starttime`,`a`.`endtime`,`a`.`classtime`,`a`.`classnum`,`a`.`place`,`a`.`range_type`,`a`.`range_args`,`a`.`studentsnum`,`a`.`ap`,`b`.`uid`,`b`.`realname`,`b`.`username` 
                FROM `ebh_xk_courses` `a` JOIN `ebh_users` `b` ON `b`.`uid`=`a`.`uid` 
                WHERE `a`.`xkid`='.$aid.' AND `a`.`uid`='.$uid.' AND `del`=0 AND `a`.`status`>0';
        if ($cid > 0) {
            $sql .= ' AND `a`.`cid`='.$cid;
        }
        return $this->db->query($sql)->list_array('cid');
    }

    /**
     * 报名学生列表
     * @param $param
     */
    public function getStudents($param) {
        if (empty($param['xkid']) || empty($param['cid'])) {
            return false;
        }
        $students = $this->db->query("select classname,uid,sign_time,sid from ebh_xk_students where status IN(1,2)".
            " and xkid=" . intval($param['xkid']) . " and cid=" . intval($param['cid']) . " ORDER BY sid DESC")->list_array();
        if(empty($students) === true) {
            return false;
        }
        $uids = array_column($students, 'uid');
        $uids = array_unique($uids);
        $uids = implode(',', $uids);
        $users = $this->db->query("SELECT uid,realname,username,sex,face,groupid FROM ebh_users WHERE uid IN($uids)")->list_array('uid');
        if(empty($users)) {
            return false;
        }
        foreach($students as &$student) {
            if(isset($users[$student['uid']])) {
                $student['realname'] = $users[$student['uid']]['realname'];
                $student['username'] = $users[$student['uid']]['username'];
                $student['sex'] = $users[$student['uid']]['sex'];
                $student['face'] = $users[$student['uid']]['face'];
                $student['groupid'] = $users[$student['uid']]['groupid'];
            }
        }
        return $students;
    }

    /**
     * 导出学生列表
     * @param $param
     */
    public function getStudentsForExcel($param) {
        if (empty($param['xkid']) || empty($param['cid']) || empty($param['crid'])) {
            return false;
        }
        $students = $this->db->query(
            "select classname,uid,sign_time from ebh_xk_students".
            " where status IN(1,2) and xkid=" . intval($param['xkid']) . " and cid=" . intval($param['cid']))->list_array();
        if(empty($students) === true) {
            return false;
        }
        $uids = array_column($students, 'uid');
        $uids = array_unique($uids);
        $uids = implode(',', $uids);

        $users = $this->db->query(
            "SELECT u.uid,realname,username FROM ebh_users u join ebh_roomusers ru on u.uid=ru.uid WHERE u.uid IN($uids) and ru.cstatus=1 and u.status=1 and ru.crid=".$param['crid'])->list_array('uid');
        if(empty($users) === true) {
            return false;
        }
        foreach($students as &$student) {
            if(isset($users[$student['uid']])) {
                $student['realname'] = $users[$student['uid']]['realname'];
                $student['username'] = $users[$student['uid']]['username'];
            }
        }

        return $students;
    }

    /**
     * 我报名的课程ID
     * @param $uid
     * @param $activityid
     * @param $step
     * @return mixed
     */
    public function getMySign($uid, $activityid, $step) {
        $uid = (int) $uid;
        $activityid = (int) $activityid;
        $sql = "SELECT `cid`,`bout`,`status` FROM `ebh_xk_students` WHERE `uid`=$uid AND `xkid`=$activityid AND `status` IN(1,2)";
        if($step == 1) {
            $sql .= " AND `bout`=1";
        } else if($step == 2) {
            $sql .= " AND `bout`=2";
        }
        $this->db->set_con(0);
        $result = $this->db->query($sql)->list_array('cid');
        $this->db->reset_con();
        return $result;
    }

    //获取选课规则
    public function getRule($param){
        if(empty($param['xkid'])){
            return array();
        }
        $sql = 'select * from ebh_xk_rules';
        $where = ' where xkid ='.$param['xkid'];
        if(!empty($param['step'])){
            $where.= ' and step ='.$param['step'];
        }
        $sql.=$where.' order by id desc';
        $this->db->set_con(0);
        $rule =  $this->db->query($sql)->row_array();
        //$this->db->reset_con();
        return $rule;
    }

    public function getRules($xkid) {
        $xkid = (int) $xkid;
        return $this->db->query("SELECT * FROM `ebh_xk_rules` WHERE `xkid`=$xkid ORDER BY `step` DESC;")->list_array();
    }

    //保存选课规则
    public function saveRule($param,$where){
        if(empty($where['xkid'])||empty($where['id'])){
            return false;
        }
        $param['remark'] = $this->db->escape_str($param['remark']);//防止sql注入
        return $this->db->update('ebh_xk_rules',$param,$where);
    }

    //获取课程学生列表
    public function getStudentList($param){
        if(empty($param['cid'])&&empty($param['xkid'])){
            return false;
        }
        $sql = 'select s.uid,s.cid,s.classname,s.sign_time,c.classid,c.grade from ebh_xk_students s
                LEFT JOIN ebh_classstudents cs on s.uid = cs.uid
                LEFT JOIN ebh_classes c on cs.classid = c.classid';
        if(!empty($param['status'])){
            $where = ' where s.status ='.$param['status'];
        }else{
            $where = ' where s.status in(1,2)';
        }
        if(!empty($param['crid'])){
            $where .= ' and c.crid ='.$param['crid'];
        }
        if(!empty($param['cid'])){
            $where .= ' and s.cid = '.$param['cid'];
        }
        if(!empty($param['xkid'])){
            $where .= ' and s.xkid = '.$param['xkid'];
        }
        if(!empty($param['bout'])) {
            $where .= ' and s.bout =' . $param['bout'];
        }
        if(isset($param['classid'])){
            $where .= ' and c.classid = '.$param['classid'];
        }
        if(isset($param['grade'])){
            $where .= ' and c.grade = '.$param['grade'];
        }
        $sql .= $where;
        if(!empty($param['group'])){
            $sql .=$param['group'];
        }
        if(!empty($param['order'])){
            $sql .=$param['order'];
        } else {
            $sql .= ' order by s.sign_time desc';
        }
        if(!empty($param['limit'])) {
            $sql .= ' limit '.$param['limit'];
        } else {
            if (empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10000 : $param['pagesize'];
            $start = ($page - 1) * $pagesize;
            $sql .= ' limit ' . $start . ',' . $pagesize;
        }
        $list = $this->db->query($sql)->list_array();
        if(!empty($list)){
			$uids = array_column($list,'uid');
			$usersql = 'select u.uid,u.sex,u.face,u.username,u.realname,u.groupid from ebh_users u 
						join ebh_roomusers ru on u.uid=ru.uid';
			$usersql.= ' where u.status=1 and ru.cstatus=1 and u.uid in('.implode(',',$uids).') and ru.crid='.$param['crid'];
			$userlist = $this->db->query($usersql)->list_array('uid');
            foreach($list as $k=>&$student){
				$uid = $student['uid'];
				if(!isset($userlist[$uid])){
					unset($list[$k]);
					continue;
				}
                $userinfo = $userlist[$uid];
                $student['sex'] = $userinfo['sex'];
                $student['face'] = $userinfo['face'];
                $student['username'] = $userinfo['username'];
                $student['realname'] = $userinfo['realname'];
                $student['groupid'] = $userinfo['groupid'];
            }
            return $list;
        }
    }

    //获取课程学生数
    public function getStudentCount($param){
        if(empty($param['cid'])&&empty($param['xkid'])){
            return false;
        }
        if(!empty($param['group'])){
            $sql = 'select count(DISTINCT xs.'.$param['group'].') as count from ebh_xk_students xs JOIN ebh_classstudents cs on xs.uid = cs.uid
                JOIN ebh_classes c on cs.classid = c.classid 
				join ebh_roomusers ru on xs.uid=ru.uid
				join ebh_users u on xs.uid=u.uid
				where xs.status > 0 and u.status=1 and ru.cstatus=1 and ru.crid='.$param['crid'];
        }else{
            $sql = 'select count(*) as count from ebh_xk_students xs where status in(1,2) ';
        }
        if(!empty($param['crid'])){
            $sql .= ' and c.crid ='.$param['crid'];
        }
        if(!empty($param['cid'])){
            $sql .= ' and cid ='.$param['cid'];
        }
        if(!empty($param['xkid'])){
            $sql .= ' and xkid ='.$param['xkid'];
        }
        if(!empty($param['bout'])){
            $sql .= ' and bout ='.$param['bout'];
        }
        if(isset($param['classid'])){
            $sql .= ' and c.classid = '.$param['classid'];
        }
        if(isset($param['grade'])){
            $sql .= ' and c.grade = '.$param['grade'];
        }

        $count = $this->db->query($sql)->row_array();
        return $count['count'];
    }

    //课程调整学生报名情况
    //$step第几轮报名
    public function updateStudents($param,$where,$step=1){
        if(empty($where['uid'])||empty($where['cid'])||empty($where['bout'])){
            return false;
        }
        $param['uptime'] = SYSTIME;
        if($param['failmsg']) {
            $param['failmsg'] = $this->db->escape_str($param['failmsg']);
        }
        $this->db->set_con(0);
        $this->db->begin_trans();
        $res = $this->db->update('ebh_xk_students',$param,$where);
        if($res){
            $cid = (int) $where['cid'];
            if($step==1){
                $course = $this->getCourse(array('cid'=>$cid));
                if($course['studentsnum']<=$course['classnum']){
                    $sql = "UPDATE `ebh_xk_courses` SET `isup`=1,`status`=1,`studentsnum`=(SELECT COUNT(`sid`) FROM `ebh_xk_students` WHERE `status` in(1,2) AND `cid`=$cid),`datetime`=" . SYSTIME .
                        " WHERE `cid`=$cid";
                }else{
                    //第一轮已调整
                    $sql = "UPDATE `ebh_xk_courses` SET `isup`=1,`studentsnum`=(SELECT COUNT(`sid`) FROM `ebh_xk_students` WHERE `status` in(1,2) AND `cid`=$cid),`datetime`=" . SYSTIME .
                        " WHERE `cid`=$cid";
                }
            }else{
                //第二轮已调整
                $sql = "UPDATE `ebh_xk_courses` SET `isup`=3,`studentsnum`=(SELECT COUNT(`sid`) FROM `ebh_xk_students` WHERE `status` in(1,2) AND `cid`=$cid), `datetime`=" . SYSTIME .
                    " WHERE `cid`=$cid";
            }
            $res = $this->db->simple_query($sql);
            if($res === false || $res == 0) {
                $this->db->rollback_trans();
                $this->db->reset_con();
                return false;
            }
            /* $course = $this->getCourse(array('cid'=>$where['cid']));
 //            if($step==1){
 //                $s_num = $course['firstnum'];
 //            }else{
 //                $s_num = $course['secondnum'];
 //            }
             $this->db->update('ebh_xk_courses',array('isup'=>$isup,'studentsnum'=>$course['studentsnum']-1),array('cid'=>$where['cid']));*/
            $this->db->commit_trans();
            $this->db->reset_con();
            return $res;
        }

    }

    public function adjustSignCount($xkid) {
        $xkid = (int) $xkid;
        $sql = "UPDATE `ebh_xk_courses` SET `studentsnum`=(SELECT COUNT(`sid`) FROM `ebh_xk_students` WHERE `status` in(1,2) AND `del`=0 AND `cid`=`ebh_xk_courses`.`cid`)" .
            " WHERE `xkid`=$xkid";
        $this->db->query($sql);
    }

    //课程批量调整学生报名情况
    //$bout:轮次
    public function updateStudents_mult($param,$where,$bout){
        if(empty($where['uid'])||empty($where['cid'])||empty($where['bout'])){
            return false;
        }
        if(!is_array($where['uid'])){
            return false;
        }
        $uidarr = $where['uid'];
        unset($where['uid']);
        foreach($uidarr as $uid){
            $where['uid'] = $uid;
            $res = $this->updateStudents($param,$where,$bout);
            if(!$res){
                return false;
            }
        }
        return true;
    }

    /**
     * 判断学生是否报名
     * @param $param
     * @return bool
     */
    public function is_signed($param) {
        $sparam = array();
        if(isset($param['uid']) === true) {
            $sparam['uid'] = (int)$param['uid'];
        } else {
            return false;
        }
        if(isset($param['xkid']) === true) {
            $sparam['xkid'] = (int)$param['xkid'];
        } else {
            return false;
        }
        if(isset($param['cid']) === true) {
            $sparam['cid'] = (int)$param['cid'];
        } else {
            return false;
        }
        $sql = "SELECT 1 AS `s` FROM `ebh_xk_students` WHERE `xkid`=" . $sparam['xkid'] . " AND `cid`=" .
            $sparam['cid'] . " AND `uid`=" . $param['uid'] . " AND `status` in(1,2) LIMIT 1";
        $result = $this->db->query($sql)->row_array();
        if (empty($result)) {
            return false;
        }
        return true;
    }

    /**
     * 学生报名
     * @param $param
     */
    public function sign($param) {
        $sparam = array();
        if(isset($param['uid']) === true) {
            $sparam['uid'] = (int)$param['uid'];
        } else {
            return false;
        }
        if(isset($param['xkid']) === true) {
            $sparam['xkid'] = (int)$param['xkid'];
        } else {
            return false;
        }
        if(isset($param['cid']) === true) {
            $sparam['cid'] = (int)$param['cid'];
        } else {
            return false;
        }
        if(isset($param['sign_time']) === true) {
            $sparam['sign_time'] = (int)$param['sign_time'];
        } else {
            $sparam['sign_time'] = SYSTIME;
        }
        if(isset($param['classname']) === true) {
            $sparam['classname'] = $this->db->escape_str($param['classname']);
        } else {
            $sparam['classname'] = '';
        }
        if(isset($param['bout']) === true) {
            $sparam['bout'] = (int)$param['bout'];
        } else {
            $sparam['bout'] = 1;
        }
        $sparam['ip'] = EBH::app()->getInput()->getip();
        $this->db->begin_trans();
        $course = $this->db->query('SELECT `classnum`,`studentsnum` FROM `ebh_xk_courses` WHERE `cid`='.$sparam['cid'])->row_array();
        if (!empty($course) && $course['studentsnum'] >= $course['classnum']) {
            $this->db->rollback_trans();
            return false;
        }
        $newid = $this->db->insert('ebh_xk_students', $sparam);
        if($this->db->trans_status() === false || $newid === false || $newid == 0) {
            $this->db->rollback_trans();
            return false;
        }
        if($param['bout'] == 1) {
            $re = $this->db->query('UPDATE `ebh_xk_courses` SET `firstnum`=`firstnum`+1,`studentsnum`=`studentsnum`+1 WHERE `cid`='.intval($param['cid']), false);
        } else {
            $re = $this->db->query('UPDATE `ebh_xk_courses` SET `secondnum`=`secondnum`+1,`studentsnum`=`studentsnum`+1 WHERE `cid`='.intval($param['cid']), false);
        }

        if($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }

        $this->db->commit_trans();
        return true;
    }

    /**
     * 学生取消报名
     * @param $param
     */
    public function cancel_sign($param) {
        if(empty($param['xkid']) || empty($param['cid']) || empty($param['uid']) || empty($param['bout'])) {
            return false;
        }
        $sparam = array(
            'xkid' => (int) $param['xkid'],
            'cid' => (int) $param['cid'],
            'uid' => (int) $param['uid'],
            'bout' => (int) $param['bout']
        );
        $row = $this->db->query("SELECT `bout`,`status` FROM `ebh_xk_students` WHERE `xkid`=" . $sparam['xkid'] .
            " AND `cid`=" . $sparam['cid'] . " AND `uid`=" . $sparam['uid'].' AND `status` IN(1,2) AND `bout`='.$sparam['bout'])->row_array();
        if(empty($row) === true || $row['status'] != 1) {
            return false;
        }
        $ip = EBH::app()->getInput()->getip();
        $this->db->begin_trans();
        //$affected_rows = $this->db->delete('ebh_xk_students', $sparam);
        $affected_rows = $this->db->update('ebh_xk_students', array('status' => 3, 'delip' => $ip), $sparam);
        if($affected_rows === false || $affected_rows == 0) {
            return false;
        }
        if($row['bout'] == 1) {
            $re = $this->db->simple_query(
                "UPDATE `ebh_xk_courses` SET `firstnum`=`firstnum`-1,`studentsnum`=`studentsnum`-1".
                " WHERE `cid`=" . $sparam['cid']);
        } else {
            $re = $this->db->simple_query(
                "UPDATE `ebh_xk_courses` SET `secondnum`=`secondnum`-1,`studentsnum`=`studentsnum`-1".
                " WHERE `cid`=" . $sparam['cid']);
        }
        if($re === false) {
            $this->db->rollback_trans();
            return false;
        }

        $this->db->commit_trans();
        return true;
    }

    //获取学生课程列表
    public function getStudentCourseList($param){
        if(empty($param['uid'])){
            return false;
        }
        $wheres = array(
            '`a`.`uid`='.intval($param['uid']),
            '`a`.`status` IN(1,2)',
            '`b`.`status`>0',
            '`b`.`del`=0'
        );
        if(!empty($param['xkid'])){
            $wheres[] = '`a`.`xkid`='.intval($param['xkid']);
        }
        $sql = 'SELECT `c`.`uid`,`c`.`realname`,`c`.`username`,`b`.* FROM `ebh_xk_students` `a` 
                JOIN `ebh_xk_courses` `b` ON `b`.`cid`=`a`.`cid` 
                JOIN `ebh_users` `c` ON `c`.`uid`=`a`.`uid` 
                WHERE '.implode(' AND ', $wheres);


        return $this->db->query($sql)->list_array();
    }

    /**
     * 获取学生的班级信息
     * @param $uid
     */
    public function getClassInfo($uid,$crid) {
        $uid = (int) $uid;
        $classstudents = $this->db->query("SELECT `classid` FROM `ebh_classstudents` WHERE `uid`=$uid")->list_array();
        if(empty($classstudents) === true) {
            return false;
        }
        $classids = array_column($classstudents, 'classid');
        $classids = array_unique($classids);
        if (count($classids) === 0) {
            return false;
        }

        $classids = implode(',', $classids);
        return $this->db->query(
            "select classname,classid,grade from ebh_classes where classid in($classids) and crid=" . intval($crid))->list_array();
    }

    /**
     * 获取学生报名课程数
     * @param $xkid
     * @param $uid
     */
    public function getStudentSignCount($xkid, $uid) {
        $xkid = (int) $xkid;
        $uid = (int) $uid;
        $sql = "SELECT COUNT(1) AS `c` FROM `ebh_xk_students` WHERE `status` IN(1,2) AND `xkid`=$xkid AND `uid`=$uid;";
        $result = $this->db->query($sql)->row_array();
        if(empty($result)) {
            return 0;
        }
        return $result['c'];
    }

    /**
     * 学生报名的课程
     * @param $uid
     * @param $xkid
     * @param $step
     */
    public function getStudentCourses($uid, $xkid, $step) {
        $uid = (int) $uid;
        $xkid = (int) $xkid;
        $step = (int) $step;
        $user = $this->db->query("select realname,username from ebh_users where uid=$uid")->row_array();
        if(empty($user) === true) {
            return false;
        }
        if($step == 1 || $step == 2) {
            $students = $this->db->query("SELECT `cid` FROM `ebh_xk_students` WHERE ".
                "`xkid`=$xkid AND `uid`=$uid AND `status` in(1,2) AND `bout`=$step")->list_array();
        } else {
            $students = $this->db->query("SELECT `cid` FROM `ebh_xk_students` WHERE ".
                "`xkid`=$xkid AND `uid`=$uid AND `status` in(1,2)")->list_array();
        }
        if(empty($students) === true) {
            return false;
        }
        $cids = array_column($students, 'cid');
        $cids = array_unique($cids);

        $cids = implode(',', $cids);
        $this->db->set_con(0);
        $courses = $this->db->query("select cid,xkid,uid,coursename,introduce,images,starttime,endtime,classtime,place from ebh_xk_courses where cid in($cids) and del=0 and status>0")->list_array();
        $this->db->reset_con();
        if(empty($courses) === true) {
            return false;
        }
        $teacherids = array_column($courses, 'uid');
        $teacherids = array_unique($teacherids);

        $teacherids_str = implode(',', $teacherids);
        $teachers = $this->db->query(
            "SELECT realname,username,uid FROM ebh_users WHERE uid IN($teacherids_str)")->list_array('uid');
        if(empty($teachers) === false) {
            foreach($courses as &$course) {
                $course['realname'] = empty($teachers[$course['uid']]['realname']) === false ?
                    $teachers[$course['uid']]['realname'] : $teachers[$course['uid']]['username'];
            }
        }
        return $courses;
    }

    //教师添加学生
    public function addStudents($param){
        $sparam = array();
        if(isset($param['uid']) === true) {
            $sparam['uid'] = (int)$param['uid'];
        } else {
            return false;
        }
        if(isset($param['xkid']) === true) {
            $sparam['xkid'] = (int)$param['xkid'];
        } else {
            return false;
        }
        if(isset($param['cid']) === true) {
            $sparam['cid'] = (int)$param['cid'];
        } else {
            return false;
        }
        if(isset($param['sign_time']) === true) {
            $sparam['sign_time'] = (int)$param['sign_time'];
        } else {
            $sparam['sign_time'] = SYSTIME;
        }
        if(isset($param['classname']) === true) {
            $sparam['classname'] = $this->db->escape_str($param['classname']);
        } else {
            return false;
        }
        if(isset($param['bout']) === true) {
            $sparam['bout'] = (int)$param['bout'];
        } else {
            $sparam['bout'] = 1;
        }
        $sparam['ip'] = EBH::app()->getInput()->getip();
        $sparam['status'] = 2;

        $this->db->begin_trans();
        $result = $this->db->insert('ebh_xk_students',$sparam);
        $re = $this->db->simple_query(
            "UPDATE `ebh_xk_courses` SET `studentsnum`=`studentsnum`+1,`isup`=3 WHERE `cid`=" . $param['cid']);
        if($result && $re) {
            $this->db->commit_trans();
        } else {
            $this->db->rollback_trans();
        }


        return $result;
    }

    /**
     * 完成课程调整
     * @param $step
     * @param $courseid
     */
    public function adjustCourse($step, $courseid) {
        $step = (int) $step;
        $courseid = (int) $courseid;
        $step = $step == 1 ? 2 : 5;
        return $this->db->update('ebh_xk_courses', array(
            'isup' => $step
        ), array(
            'cid' => $courseid
        ));
    }

    //根据uid查找报名学生
    public function getStudentByUid($param){
        if(empty($param['uid'])||empty($param['cid'])){
            return false;
        }
        $sql = 'select * from ebh_xk_students where status in(1,2) and uid ='.$param['uid'].' and cid ='.$param['cid'];
        return $this->db->query($sql)->row_array();
    }

    /**
     * 过滤学生
     * @param $crid
     * @param $groupParam
     * @param $classParam
     * @param int $pageIndex
     * @param string $username
     * @return mixed
     */
    public function getFilterStudents($crid, $groupParam, $classParam, $pageIndex = 1, $username = '') {
        $crid = (int) $crid;
        if(is_int($groupParam) === true) {
            if($groupParam >= 0) {
                $class_sql = "SELECT `classid`,`grade` FROM `ebh_classes` WHERE ".
                    "`status`=0 AND `crid`=$crid AND `grade`=$groupParam";
            } else {
                $class_sql = "SELECT `classid`,`grade` FROM `ebh_classes` WHERE ".
                    "`status`=0 AND `crid`=$crid";
            }
        } else if(is_array($groupParam)) {
            $values = implode(',', $groupParam);
            $class_sql = "SELECT `classid`,`grade` FROM `ebh_classes` WHERE ".
                "`status`=0 AND `crid`=$crid AND `grade` IN($values)";
        }

        if(is_int($classParam)) {
            if($classParam > 0) {
                $class_sql .= " AND `classid`=$classParam";
            }
        } else if(is_array($classParam)) {
            $values = implode(',', $classParam);
            $class_sql .= " AND `classid` IN($values)";
        }

        $classes = $this->db->query($class_sql)->list_array('classid');
        if(empty($classes) === true) {
            return false;
        }
        $classids = array_column($classes, 'classid');
        $classids = array_unique($classids);

        $classids = implode(',', $classids);

        $t = $this->db->query("select uid,classid from ebh_classstudents where classid in($classids)")->list_array('uid');
        if(empty($t) === true) {
            return array();
        }
        $uids = array_keys($t);
        $uids = implode(',', $uids);

        $pageSize = 50;
        $start = ($pageIndex - 1) * $pageSize;
        $start = max($start, 0);
        if(empty($username) === false) {
            $users = $this->db->query(
                "select uid,username,realname,face,sex,groupid from ebh_users where uid in($uids) and status=1".
                " AND realname LIKE '%" . $this->db->escape_str($username) . "%' LIMIT $start,$pageSize")->list_array();
        } else {
            $users = $this->db->query(
                "select uid,username,realname,face,sex,groupid from ebh_users where uid in($uids) and status=1".
                " LIMIT $start,$pageSize")->list_array();
        }

        if(empty($users) === true) {
            return array();
        }
        foreach($users as &$user) {
            $user['classid'] = $t[$user['uid']]['classid'];
            $user['grade'] = $classes[$t[$user['uid']]['classid']]['grade'];
        }
        return $users;
    }

    /**
     * 选课课程班级列表
     * @param $cid
     * @param $rangeType
     * @param $rangeArgs
     * @return bool
     */
    public function getCourseClasses($cid, $rangeType, $rangeArgs) {
        $cid = (int) $cid;
        if($rangeType == 1) {
            //限年级
            if(!is_array($rangeArgs)) {
                return false;
            }
            $arr = implode(',', $rangeArgs);
            $sql = "SELECT classid,classname,grade FROM `ebh_classes` WHERE `status`=0 AND `crid`=$cid AND `grade` IN($arr);";
            return $this->db->query($sql)->list_array();
        }

        if($rangeType == 2) {
            //限班级
            if(!is_array($rangeArgs)) {
                return false;
            }
            $arr = implode(',', $rangeArgs);
            $sql = "SELECT classid,classname,grade FROM `ebh_classes` WHERE `status`=0 AND `crid`=$cid AND `classid` IN($arr);";
            return $this->db->query($sql)->list_array();
        }

        //不限制
        $sql = "SELECT classid,classname,grade FROM `ebh_classes` WHERE `status`=0 AND `crid`=$cid;";
        return $this->db->query($sql)->list_array();
    }

    /**
     * 课程报名学生ID列表
     * @param $cid
     * @return mixed
     */
    public function getCourseStudentIds($cid) {
        $cid = (int) $cid;
        $sql = "SELECT `uid` FROM `ebh_xk_students` WHERE `cid`=$cid AND `status`in(1,2)";
        return $this->db->query($sql)->list_array('uid');
    }

    /**
     * 课程规则
     * @param $cid
     * @return mixed
     */
    public function courseRule($cid) {
        $course = $this->db->query(
            "SELECT `xkid` FROM `ebh_xk_courses` WHERE `cid`=$cid AND `status`=1 AND `del`=0")->row_array();
        if(empty($course) === true) {
            return false;
        }
        return $this->db->query("select xkid,max_sign_count from ebh_xk_rules where ".
            "xkid=" . $course['xkid'] . " and step=1 limit 1")->row_array();
    }

    public function studentSignCountList($xkid, $max) {
        $xkid = (int) $xkid;
        $max = (int) $max;
        $sql = "SELECT `uid`,COUNT(1) AS `c` FROM `ebh_xk_students` WHERE `xkid`=$xkid AND `status` in(1,2) GROUP BY `uid` HAVING `c`>=$max";
        return $this->db->query($sql)->list_array('uid');
    }

    //验证学生是可以参与问卷
    public function isJoin($param){
        if(empty($param['uid'])||empty($param['sid'])){
            return false;
        }
        $sql = ' select cid from ebh_surveys where sid='.$param['sid'];
        $cid = $this->db->query($sql)->row_array();
        $sql2 = ' select * from ebh_xk_students where cid='.$cid['cid'].' and uid ='.$param['uid'].' and status in(1,2)';
        return $this->db->query($sql2)->row_array();
    }

    //获取班级或年级学生列表
    public function getStudentList_all($param){
        $sql = 'select cs.classid,cs.uid,c.classname,u.uid,u.sex,u.face,u.username,u.realname from ebh_classstudents cs '.
            'join ebh_classes c on cs.classid=c.classid 
			join ebh_users u on u.uid=cs.uid
			join ebh_roomusers ru on u.uid=ru.uid';
        $where = ' where u.status=1 and ru.cstatus=1 and ru.crid='.$param['crid'];
        if(!empty($param['classid'])){
            $where .= ' and cs.classid ='.$param['classid'];
        }
        if(isset($param['grade'])){
            $where.= ' and c.grade ='.$param['grade'];
        }
        if(!empty($param['unuid'])){
            $where .= ' and cs.uid not in('.$param['unuid'].')';
        }
        if(!empty($param['crid'])){
            $where .= ' and c.crid ='.$param['crid'];
        }
        $sql .= $where;
        if(!empty($param['limit']))
            $sql .= ' limit '.$param['limit'];
        else {
            if(empty($param['page']) || $param['page'] < 1)
                $page = 1;
            else
                $page = $param['page'];
            $pagesize = empty($param['pagesize']) ? 10 : $param['pagesize'];
            $start = ($page - 1) * $pagesize ;
            $sql .= ' limit '.$start.','.$pagesize;
        }

        $list = $this->db->query($sql)->list_array();
        
		return $list;
    }

    //获取班级或年级学生数
    public function getStudentList_all_count($param){
        $sql = 'select count(*) as count from ebh_classstudents cs '.
            'join ebh_classes c on cs.classid=c.classid 
			join ebh_users u on u.uid=cs.uid
			join ebh_roomusers ru on u.uid=ru.uid';
        $where = ' where u.status=1 and ru.cstatus=1 and ru.crid='.$param['crid'];
        if(!empty($param['classid'])){
            $where .= ' and cs.classid ='.$param['classid'];
        }
        if(isset($param['grade'])){
            $where.= ' and c.grade ='.$param['grade'];
        }
        if(!empty($param['unuid'])){
            $where .= ' and cs.uid not in('.$param['unuid'].')';
        }
        if(!empty($param['crid'])){
            $where .= ' and c.crid ='.$param['crid'];
        }
        $sql .= $where;
        return $this->db->query($sql)->row_array();
    }

    //根据xkid获取问卷time
    public function getSurveyTime($xkid){
        if(empty($xkid)){
            return false;
        }
        $course = $this->db->query('select cid from ebh_xk_courses where xkid ='.$xkid)->row_array();
        if(empty($course)) {
            return false;
        }
        return $this->db->query('select startdate,enddate from ebh_surveys where type=3 and cid ='.$course['cid'])->row_array();
    }

    //删除课程,如果是最后一门课程,删除活动
    public function delCourse($param,$where){
        if(empty($where['xkid'])||empty($where['cid'])){
            return false;
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getAdminLoginUser();
        $coursecount = $this->getCourseCount(array('xkid'=>$where['xkid'],'crid'=>$roominfo['crid'],'uid'=>$user['uid']));
        $this->db->begin_trans();
        $res1 = $this->db->update('ebh_xk_courses',array('status'=>0,'failedmsg'=>$param['msg']),$where);
        if($coursecount==1){
            $res2 = $this->db->update('ebh_xk_activitys',array('isdel'=>0,'finish_time'=>SYSTIME),array('xkid'=>$where['xkid']));
            if($res1&&$res2){
                $this->db->commit_trans();
                return 2;
            }else{
                $this->db->rollback_trans();
            }
        }
        $this->db->commit_trans();
        if($res1){
            return 1;
        }else{
            return 0;
        }

    }

    public function getClassnameForStudents($studentids = array(), $crid) {
        if (empty($studentids)) {
            return array();
        }
        $sql = 'SELECT `b`.`uid`,`a`.`classname` FROM `ebh_classes` `a`
                JOIN `ebh_classstudents` `b` ON `b`.`classid`=`a`.`classid` AND `b`.`uid` IN('.implode(',', $studentids).')
                WHERE `a`.`crid`='.$crid;
        return $this->db->query($sql)->list_array('uid');
    }

    /**
     * 检查选修课上课时间是否冲突
     * @param int $studentid 学生ID
     * @param int $xkid 活动ID
     * @param int $ap 上午下午
     * @return bool
     */
    public function checkRepeatAp($studentid, $xkid, $ap) {
        $studentid = intval($studentid);
        $xkid = intval($xkid);
        $ap = intval($ap);
        $aps = array(
            0 => array(0, 2),
            1 => array(1, 2),
            2 => array(0, 1, 2)
        );
        $aps = $aps[$ap];
        $aps = implode(',', $aps);
        $sql = 'SELECT `a`.`cid`,`b`.`ap` FROM `ebh_xk_students` `a` JOIN `ebh_xk_courses` `b` ON `b`.`cid`=`a`.`cid` WHERE `a`.`uid`='.$studentid.' AND `a`.`xkid`='.$xkid.' AND `a`.`status` IN(1,2) AND `b`.`del`=0 AND `b`.`ap` IN('.$aps.') LIMIT 1';
        $c = $this->db->query($sql)->row_array();
        if (!empty($c)) {
            return $c['ap'];
        }
        return false;
    }
    //删除选课活动
    public function delxk($xkid){
        $result = false;
        $xkid = !empty($xkid) ? intval($xkid) : 0;
        if (empty($xkid)) {
            return $result;
        }
        $res = $this->db->update('ebh_xk_activitys', array('isdel' => 0, 'finish_time' => SYSTIME), array('xkid' => $xkid));
        if($res){
            $result = true;
        }
        return $result;
    }

    /**
     * 检查课程是否可编辑，可编辑返回课程ID，只有在活动课程申请阶段可编辑
     * @param int $cid 课程ID
     * @param int $uid 用户ID
     * @return bool
     */
    public function checkCourseEidtable($cid, $uid) {
        $wheres = array(
            '`a`.`cid`='.$cid,
            '`a`.`status`=1',
            '`a`.`del`=0',
            '`a`.`uid`='.$uid,
            '`b`.`status`=1',
            '`b`.`isdel`=1',
            '`b`.`starttime`<='.SYSTIME,
            '`b`.`endtime`>='.SYSTIME
        );
        $sql = 'SELECT `a`.`cid` FROM `ebh_xk_courses` `a` JOIN `ebh_xk_activitys` `b` ON `b`.`xkid`=`a`.`xkid` WHERE '.implode(' AND ', $wheres);
        $ret = $this->db->query($sql)->row_array();
        if (empty($ret)) {
            return false;
        }
        return $ret['cid'];
    }

    /**
     * 删除课程
     * @param $cid
     * @param $uid
     * @return mixed
     */
    public function removeCourse($cid, $uid) {
        $this->db->begin_trans();
        $ret = $this->db->update('ebh_xk_courses',
            array('del' => 1),
            array(
            'cid' => $cid,
            'uid' => $uid
        ));
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->update('ebh_xk_msgs', array('guide' => ''), array('cid' => $cid, 'uid' => $uid, 'category' => 4));
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return false;
        }
        $this->db->commit_trans();
        return $ret;
    }
	
	/*
	全校学生选课情况
	*/
	public function getExportDataAll($crid,$xkid){
		//班级
		$classsql = 'select classid,classname from ebh_classes where crid='.$crid.' and status=0';
		$classlist = $this->db->query($classsql)->list_array('classid');
		if(!empty($classlist)){//班级学生
			$classids = array_keys($classlist);
			$classstudentsql = 'select uid,classid from ebh_classstudents where classid in ('.implode(',',$classids).')'; 
			$classstudentlist = $this->db->query($classstudentsql)->list_array('uid');
		} else {
			return FALSE;
		}
		if(!empty($classstudentlist)){//全校学生
			$uids = array_keys($classstudentlist);
			$roomusersql = 'select ru.uid,u.realname,u.username from ebh_roomusers ru 
							join ebh_users u on ru.uid=u.uid
							join ebh_members m on u.uid=m.memberid
							where ru.crid='.$crid.' and u.status=1 and ru.cstatus=1 and ru.uid in('.implode(',',$uids).')';
			$roomuserlist = $this->db->query($roomusersql)->list_array('uid');
		} else {
			return FALSE;
		}
		$xkstudentlist = array();
		if(!empty($roomuserlist)){//选课情况
			$uids = array_keys($roomuserlist);
			$xkstudentsql = 'select s.uid,s.sign_time,s.bout,c.coursename,c.ap,c.place,c.classtime from ebh_xk_students s 
							join ebh_xk_courses c on s.xkid=c.xkid and s.cid=c.cid
							where c.crid='.$crid.' and s.uid in ('.implode(',',$uids).') and c.del=0 and c.status>0 and s.status in (1,2) and s.xkid='.$xkid;
			$xkstudentlist = $this->db->query($xkstudentsql)->list_array();
		} else {
			return FALSE;
		}
		// var_dump($xkstudentlist);
		$userlist = array();
		foreach($roomuserlist as &$user){//学生数据聚合
			$uid = $user['uid'];
			$classid = $classstudentlist[$uid]['classid'];
			$user['classname'] = $classlist[$classid]['classname'];
		}
		foreach($xkstudentlist as $student){//选课数据聚合
			$uid = $student['uid'];
			$roomuserlist[$uid]['xk'][] = $student;
		}
		return $roomuserlist;
		
	}
	/**
     * 暂停选课活动
     * @param $xkid
     * @param $uid
     * @param $pause
     * @return mixed
     */
    public function pauseActivity($xkid, $uid, $pause) {
        $sql = 'UPDATE `ebh_xk_activitys` SET `ispause`='.$pause.' WHERE `xkid`='.$xkid.' AND `uid`='.$uid.' AND `status` IN(3,5)';
        $ret = $this->db->query($sql, false);
        if ($ret === false) {
            return false;
        }
        return $this->db->affected_rows();
    }

    /**
     * 互斥报名帐号
     * @param $uids
     * @param $xkid
     * @param $aps
     * @return mixed
     */
    public function exclusiveUsers($uids, $xkid, $aps) {
        $wheres = array(
            '`a`.`uid` IN('.implode(',', $uids).')',
            '`a`.`xkid`='.$xkid,
            '`a`.`status` IN(1,2)',
            '`b`.`del`=0',
            '`b`.`status`>0',
            '`b`.`ap` IN('.implode(',', $aps).')'
        );
        $sql = 'SELECT `a`.`uid` FROM `ebh_xk_students` `a` JOIN `ebh_xk_courses` `b` 
                ON `b`.`cid`=`a`.`cid` WHERE '.implode(' AND ', $wheres);
        return $this->db->query($sql)->list_field();
    }

    /**
     * 第一轮选课发布，将初始选择的学生报名时间重置为当前时间
     */
    public function batchUpdateTime($xkid, $sign_time) {
        $this->db->update('ebh_xk_students', array('sign_time' => $sign_time), array('xkid' => $xkid, 'bout' => 1, 'status' => 2));
    }
}