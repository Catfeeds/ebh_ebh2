<?php
/**
 *Plate模板教室数据初始化yexiaot
 * usage:
 * $lib = Ebh::app()->lib('InitPlate');
 *  	$param = array(
 * 		'scrid'=>'10622',
 *		'dcrid'=>'10643',
 *		'uid'=>'408420'
 *	);
 */
class InitPlate{
    private $scrid = 0; //源学校
    private $dcrid = 0; //目标学校
    private $uid = 0; //目标用户uid
    private $db = NULL;
    private $modules = array();
    private $now;
    private $folder_maps = array();
    private $class_maps = array();
    private $pid_maps = array();
    private $cwid_maps = array();
    public function __construct() {
        $this->now = time();
    }

    //参数配置
    public function init($params, $reset = false){
        if (empty($params['scrid']) || empty($params['dcrid']) || empty($params['uid'])) {
            return false;
        }
        $this->scrid = (int)$params['scrid'];
        $this->dcrid = (int)$params['dcrid'];
        $this->uid = (int)$params['uid'];
        $this->db = Ebh::app()->getDb();
        if ($reset) {
            $this->reset();
            echo "重置成功";
            return;
        }
        $this->_synchronize();
    }
    //同步数据
    private function _synchronize() {
        if (!$this->_cp_modules_set() || empty($this->modules)) {
            echo '同步模块失败，终止后续操作';
            return;
        }

        foreach ($this->modules as $module) {
            switch ($module) {
                case 2:
                    $this->_cp_navigation();
                    break;
                case 4:
                    $this->_cp_notice();
                    break;
                case 5:
                    $this->_cp_about();
                    break;
                case 8:
                    $this->_cp_news();
                    break;
                case 10:
                    $this->_cp_survey();
                    break;
                case 12:
                    $this->_cp_app();
                    break;
            }
        }
        //初始基本数据
        $this->_init_organization();
        //服务类数据
        $this->_init_service();

    }
    //step1:模块配置
    private function _cp_modules_set() {
        $exists = $this->db->query("SELECT `crid` FROM `ebh_component_schools` WHERE `crid`={$this->dcrid}")->row_array();
        if (!empty($exists)) {
            return true;
        }
        $items = $this->db->query(
            "SELECT `eid`,`mid`,`ititle`,`columns`,`rows`,`max_rows`,`tx`,`ty`,`width`,`height`,`position_x`,`position_y`,`zindex`,`background_color`
             FROM `ebh_component_items` WHERE `crid`={$this->scrid} AND `status`=0")->list_array('eid');
        if (empty($items)) {
            return false;
        }
        $this->modules = array_column($items, 'mid');
        $this->modules = array_filter($this->modules, function($module) {
            return !in_array($module, array(1,3,6,9,13,18,20));
        });
        $options = $this->db->query(
            "SELECT `eid`,`mid`,`image`,`href`,`zindex`,`label`,`bgcolor` 
              FROM `ebh_component_item_options` WHERE `crid`={$this->scrid} AND `status`=0")->list_array();
        $richtexts = $this->db->query(
            "SELECT `eid`,`richtext` FROM `ebh_component_richtexts` 
              WHERE `crid`={$this->scrid} AND `status`=1")->list_array();
        $this->db->begin_trans();
        $newid = $this->db->insert('ebh_component_schools', array('crid' => $this->dcrid));
        if (empty($newid)) {
            $this->db->rollback_trans();
            return false;
        }
        $items_map = array();
        foreach ($items as $item) {
            $item['crid'] = $this->dcrid;
            $item['tmpid'] = $newid;
            $eid = array_shift($item);
            $items_map[$eid] = $this->db->insert('ebh_component_items', $item);
            if (empty($items_map[$eid])) {
                $this->db->rollback_trans();
                return false;
            }
        }
        if (!empty($options)) {
            foreach ($options as $option) {
                $option['eid'] = $items_map[$option['eid']];
                $option['crid'] = $this->dcrid;
                $newid = $this->db->insert('ebh_component_item_options', $option);
                if (empty($newid)) {
                    $this->db->rollback_trans();
                    return false;
                }
            }
        }
        if (!empty($richtexts)) {
            foreach ($richtexts as $richtext) {
                if (!isset($items_map[$richtext['eid']])) {
                    continue;
                }
                $richtext['eid'] = $items_map[$richtext['eid']];
                $richtext['crid'] = $this->dcrid;
                $this->db->insert('ebh_component_richtexts', $richtext);
                if ($this->db->trans_status() === false) {
                    $this->db->rollback_trans();
                    return false;
                }
            }
        }
        $this->db->commit_trans();
        return true;
    }
    //step2:选项卡(头部菜单)
    private function _cp_navigation() {
        $sql = "SELECT `navigator` FROM `ebh_classrooms` WHERE `crid`={$this->scrid}";
        $res = $this->db->query($sql)->row_array();
        if (empty($res)) {
            return;
        }
        $navigator = unserialize($res['navigator']);
        if (empty($navigator['navarr'])) {
            return;
        }

        $main_menu_arr = array();
        $sub_menu_arr = array();

        foreach ($navigator['navarr'] as &$menu) {
            if (!preg_match('/^n(\d+)$/', $menu['code'], $match)) {
                continue;
            }
            $main_menu_arr[] = 'n'.$match[1];
            if (empty($menu['subnav']) || !is_array($menu['subnav'])) {
                continue;
            }

            $sub_menu_arr_tmp = array_column($menu['subnav'], 'subcode');
            $sub_menu_arr = array_merge($sub_menu_arr, $sub_menu_arr_tmp);
        }

        $serialize = serialize($navigator);
        $navigator_sql = "UPDATE `ebh_classrooms` SET `navigator`='$serialize' WHERE `crid`={$this->dcrid}";
        if (!empty($main_menu_arr)) {
            $main_menu_arr = array_map(function($m) {
                return "'$m'";
            }, $main_menu_arr);
            $main_menu_arr_str = implode(',', $main_menu_arr);
            unset($main_menu_arr);
            $ebh_custommessages_sql = "INSERT INTO `ebh_custommessages`(`crid`,`index`,`custommessage`) 
                  SELECT {$this->dcrid},`index`,`custommessage` FROM `ebh_custommessages` 
                  WHERE `crid`={$this->scrid} AND `index` IN($main_menu_arr_str)";
        }

        if (!empty($sub_menu_arr)) {
            $sub_menu_arr = array_map(function($m) {
                return "'$m'";
            }, $sub_menu_arr);
            $sub_menu_arr_str = implode(',', $sub_menu_arr);
            unset($sub_menu_arr);
            $news_sql = "INSERT INTO `ebh_news`(`navcode`,`subject`,`message`,`note`,`thumb`,`crid`,`uid`,`viewnum`,`dateline`,`displayorder`) 
                          SELECT `navcode`,`subject`,`message`,`note`,`thumb`,{$this->dcrid},{$this->uid},`viewnum`,`dateline`,`displayorder` 
                          FROM `ebh_news` WHERE `crid`={$this->scrid} AND `navcode` IN($sub_menu_arr_str) AND `status`=1";
        }
        $this->db->begin_trans();
        $this->db->query($navigator_sql);
        if ($this->db->trans_status() === false) {
            $this->db->rollback_trans();
            return;
        }
        if (!empty($ebh_custommessages_sql)) {
            $this->db->query($ebh_custommessages_sql);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return;
            }
        }
        if (!empty($news_sql)) {
            $this->db->query($news_sql);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return;
            }
        }
        $this->db->commit_trans();
        $this->_clear_cache('navigator', 'data');
        //更新导航成功后刷新导航相关缓存
        updateRoomCache($this->dcrid,'navigator');
    }
    //step3:滚动通知
    private function _cp_notice() {
        $sql = "INSERT INTO `ebh_sendinfo`(`toid`,`type`,`status`,`dateline`,`message`) 
                  SELECT {$this->dcrid},`type`,`status`,{$this->now},`message` 
                  FROM `ebh_sendinfo` WHERE `toid`={$this->scrid} AND `status`=0 AND `type`='announcement'";
        $this->db->query($sql);
        $this->_clear_cache('sendinfo', 'plate-notice');
    }
    //step4:网校简介与热门标签
    private function _cp_about() {
        $summary = $this->db->query(
            "SELECT `summary`,`cface`,`crlabel`,`message`,`craddress`,`crphone`,`kefu`,`kefuqq` FROM `ebh_classrooms` WHERE `crid`={$this->scrid}")->row_array();
        if (empty($summary)) {
            return;
        }
        $this->db->query(
            "UPDATE `ebh_classrooms` SET `summary`={$this->db->escape($summary['summary'])},
              `cface`='{$summary['cface']}',
              `crlabel`={$this->db->escape($summary['crlabel'])},
              `message`={$this->db->escape($summary['message'])},
              `craddress`={$this->db->escape($summary['craddress'])},
              `crphone`={$this->db->escape($summary['crphone'])},
              `kefu`={$this->db->escape($summary['kefu'])},
              `kefuqq`={$this->db->escape($summary['kefuqq'])}
              WHERE `crid`={$this->dcrid}");
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        $this->_clear_cache('roominfo', $domain, 0);
    }
    //新闻资讯
    private function _cp_news() {
        $sql = "INSERT INTO `ebh_news`(`crid`,`subject`,`note`,`message`,`dateline`,`thumb`,`viewnum`,`navcode`,`displayorder`,`status`)
                SELECT {$this->dcrid},`subject`,`note`,`message`,{$this->now},`thumb`,`viewnum`,'news',`displayorder`,1
                FROM `ebh_news` WHERE `crid`={$this->scrid} AND `navcode`='news' AND `status`=1";
        $this->db->query($sql);
        $this->_clear_cache('news', 'plate-news');
    }
    //调查问卷
    private function _cp_survey() {
        $sql = "SELECT `sid`,`type`,`folderid`,`cwid`,`title`,`content`,`istemplate`,`allowview`,`allowanonymous`,`cid`,`startdate`,`enddate`,`ispublish`
                FROM `ebh_surveys` 
                WHERE `crid`={$this->scrid} AND `isdelete`=0 AND `ispublish`=1";
        $surveys = $this->db->query($sql)->list_array('sid');
        if (empty($surveys)) {
            return;
        }
        $sid_arr = array_keys($surveys);
        $sid_arr_str = implode(',', $sid_arr);
        $sid_arr = array_flip($sid_arr);
        $survey_questions = $this->db->query(
            "SELECT `qid`,`sid`,`type`,`title`,`displayorder` FROM `ebh_surveyquestions` WHERE `sid` IN($sid_arr_str)")
            ->list_array(`qid`);
        $question_id_maps = array_keys($survey_questions);
        $question_id_maps = array_flip($question_id_maps);
        $survey_options = $this->db->query(
            "SELECT `qid`,`sid`,`content`,`displayorder` FROM `ebh_surveyoptions` WHERE `sid` IN($sid_arr_str)")
            ->list_array();
        $this->db->begin_trans();
        foreach ($surveys as $survey) {
            $sid = array_shift($survey);
            $survey['crid'] = $this->dcrid;
            $survey['ispublish'] = 1;

            if ($survey['enddate'] > 0) {
                $survey['enddate'] = $survey['enddate'] - $survey['startdate'] + $this->now;
            }
            $survey['dateline'] = $this->now;
            $survey['startdate'] = $this->now;
            $sid_arr[$sid] = $this->db->insert('ebh_surveys', $survey);
            if (empty($sid_arr[$sid])) {
                $this->db->rollback_trans();
                return;
            }
        }
        foreach ($survey_questions as $question) {
            $questionid = array_shift($question);
            $sid = array_shift($question);
            $question['sid'] = $sid_arr[$sid];
            $question_id_maps[$questionid] = $this->db->insert('ebh_surveyquestions', $question);
            if (empty($question_id_maps[$questionid])) {
                $this->db->rollback_trans();
                return;
            }
        }
        foreach ($survey_options as $option) {
            $qid = array_shift($option);
            $sid = array_shift($option);
            $option['qid'] = $question_id_maps[$qid];
            $option['sid'] = $sid_arr[$sid];
            $ret = $this->db->insert('ebh_surveyoptions', $option);
            if (empty($ret)) {
                $this->db->rollback_trans();
                return;
            }
        }
        $this->db->commit_trans();
        $this->_clear_cache('survey', 'plate-survey');
    }
    //应用
    private function _cp_app() {
        $sql = "SELECT `appstr` FROM `ebh_custommessages` WHERE `crid`={$this->scrid} AND `index`='1' ORDER BY `cid` DESC LIMIT 1";
        $appstr = $this->db->query($sql)->row_array();
        if (empty($appstr)) {
            return;
        }
        $exits = $this->db->query("SELECT `appstr` FROM `ebh_custommessages` WHERE `crid`={$this->dcrid} AND `index`='1' ORDER BY `cid` DESC LIMIT 1")->row_array();
        if (!empty($exits)) {
            $sql = "UPDATE `ebh_custommessages` SET `appstr`='{$appstr['appstr']}' WHERE `crid`={$this->dcrid} AND `index`='1'";
        } else {
            $sql = "INSERT INTO `ebh_custommessages`(`crid`,`index`,`custommessage`,`appstr`) VALUES({$this->dcrid},'1','','{$appstr['appstr']}')";
        }

        $this->db->query($sql);
        $this->_clear_cache('custommessage', 'plate-app');
    }
    //清空缓存
    private function _clear_cache($module, $params, $crid = -1) {
        if ($crid == -1) {
            $crid = $this->dcrid;
        }
        $roomcache = Ebh::app()->lib('Roomcache');
        $roomcache->removeCache($crid, $module, $params);
    }


    //服务包、分类
    private function _init_service() {
        $itemid_maps = $this->_cp_pay_service($this->folder_maps);
        if (empty($itemid_maps)) {
            return;
        }
        //$this->folder_maps = json_decode('{"3950":4184,"3957":4185,"3958":4186,"3959":4187,"3960":4188,"3961":4189,"3962":4190,"3963":4191,"3964":4192}', true);
        //$this->class_maps = json_decode('{"9666":9716}', true);
        $this->_cp_userpermisions($itemid_maps, $this->folder_maps, $this->class_maps);
    }
    //网校组织
    private function _init_organization() {
        $this->class_maps = $class_maps = $this->_cp_classes();
        $cp_room_reacher_ret = $this->_cp_roomteachers($class_maps);
        if ($cp_room_reacher_ret === false) {
            //拷贝网校教师关联表出错，中断后续所有操作
            return;
        }
        $tgroup_maps = $this->_cp_tgroup();
        if (!empty($tgroup_maps)) {
            $this->_cp_teachergroups($tgroup_maps);
        }
        $ret = $this->_cp_roomusers();
        if ($ret) {
            $this->_cp_classstudents($class_maps);
        }
        if (!($folder_maps = $this->_cp_folders())) {
            return;
        }
        $this->folder_maps = $folder_maps;
        $this->_cp_classteachers($class_maps, $folder_maps);
        $this->_cp_classcourses($class_maps, $folder_maps);
        $section_maps = $this->_cp_sections($folder_maps);
        $this->_cp_teacherfolders($folder_maps);
        $this->_cp_roomcourses($folder_maps, $class_maps, $section_maps);
        $this->_cp_playlogs();
    }

    /**
     * 拷贝班级，成功后返回班级ID映射表
     * @return array|bool
     */
    private function _cp_classes() {
        //班级
        $sql = "SELECT `classid`,`classname`,`grade`,`year`,`stunum`,`district`,`headteacherid` 
                FROM `ebh_classes` WHERE `crid`={$this->scrid} AND `status`=0";
        $classes = $this->db->query($sql)->list_array('classid');
        if (empty($classes)) {
            return false;
        }
        $class_maps = array_flip(array_keys($classes));
        $this->db->begin_trans();
        foreach ($classes as $classitem) {
            $classid = array_shift($classitem);
            $classitem['dateline'] = $this->now;
            $classitem['crid'] = $this->dcrid;
            $class_maps[$classid] = $this->db->insert('ebh_classes', $classitem);
            if ($this->db->trans_status() === false) {
                $this->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return $class_maps;
    }

    /**
     * 拷贝教研组，成功后返回教研组ID映射表
     * @return array|bool
     */
    private function _cp_tgroup() {
        //教研组
        $sql = "SELECT `groupid`,`upid`,`groupname`,`displayorder`,`summary` 
                FROM `ebh_tgroups` 
                WHERE `crid`={$this->scrid}";
        $tgroups = $this->db->query($sql)->list_array('groupid');
        if (empty($tgroups)) {
            return false;
        }
        $tgroup_maps = array_flip(array_keys($tgroups));
        $this->db->begin_trans();
        foreach ($tgroups as $tgroup) {
            $groupid = array_shift($tgroup);
            $tgroup['crid'] = $this->dcrid;
            $tgroup['uid'] = $this->uid;
            $tgroup_maps[$groupid] = $this->db->insert('ebh_tgroups', $tgroup);
            if (empty($tgroup_maps[$groupid])) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return $tgroup_maps;
    }

    /**
     * 拷贝教研组教师关联表
     * @param array $tgroup_maps 教研组ID映射表
     */
    private function _cp_teachergroups($tgroup_maps = array()) {
        if (empty($tgroup_maps)) {
            return;
        }
        $sql = "SELECT `tid`,`groupid` FROM `ebh_teachergroups` WHERE `crid`={$this->scrid}";
        $tearcher_groups = $this->db->query($sql)->list_array();
        if (empty($tearcher_groups)) {
            return;
        }
        foreach ($tearcher_groups as $teacher_group) {
            $groupid = array_pop($teacher_group);
            if (isset($tgroup_maps[$groupid])) {
                $teacher_group['groupid'] = $tgroup_maps[$groupid];
            } else {
                $teacher_group['groupid'] = 0;
            }

            $teacher_group['crid'] = $this->dcrid;
            $this->db->insert('ebh_teachergroups', $teacher_group);
        }
    }

    /**
     * 拷贝网校教师关联表
     * @param $class_maps 班级映射表
     * @return mixed
     */
    private function _cp_roomteachers($class_maps) {
        //网校教师
        return $this->db->simple_query("INSERT INTO `ebh_roomteachers`(`tid`,`crid`,`role`,`cdateline`,`status`) 
          SELECT `tid`,{$this->dcrid},1,{$this->now}, 1 FROM `ebh_roomteachers` 
          WHERE `crid`={$this->scrid} AND `status`=1 AND `role`=1");
    }

    /**
     * 拷贝网校学生关联表
     * @return int
     */
    private function _cp_roomusers() {
        //网校学生
        $sql = "SELECT `uid`,`cstatus`,`begindate`,`enddate`,`cnname`,`sex`,`birthday`,`mobile`,`email`,`telephone`,`school`,`grade`,`class`,`fathername`,`mothername`,`fathermobile`,`mothermobile`,`citycode`,`address`,`salesman`,`rbalance`
                FROM `ebh_roomusers` WHERE `crid`={$this->scrid}";
        $students = $this->db->query($sql)->list_array();
        if (empty($students)) {
            return 0;
        }
        $this->db->begin_trans();
        foreach ($students as $student) {
            $time = $student['enddate'] - $student['begindate'];
            $student['cdateline'] = $this->now;
            $student['crid'] = $this->dcrid;
            $student['enddate'] = $this->now + $time;
            $student['begindate'] = $this->now;
            $this->db->insert('ebh_roomusers', $student);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return true;
    }

    /**
     * 拷贝教室学生关联表
     * @param $class_maps
     * @return bool|int
     */
    private function _cp_classstudents($class_maps) {
        $classid_arr = array_keys($class_maps);
        $classid_arr_str = implode(',', $classid_arr);
        //教室学生
        $sql = "SELECT `uid`,`classid` FROM `ebh_classstudents` WHERE `classid` IN($classid_arr_str)";
        $class_students  = $this->db->query($sql)->list_array();
        if (empty($class_students)) {
            return 0;
        }
        $this->db->begin_trans();
        foreach ($class_students as $class_student) {
            $classid = array_pop($class_student);
            $class_student['classid'] = $class_maps[$classid];
            $this->db->insert('ebh_classstudents', $class_student);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return true;
    }

    /**
     * 拷贝课程，返回课程映射表
     * @return array|bool
     */
    private function _cp_folders() {
        //知识点
        /*$sql = "SELECT `chapterid`,`chaptername`,`pid`,`level`,`displayorder`,`folderid` FROM `ebh_schchapters` WHERE `crid`={$this->scrid} ORDER BY `level` ASC";
        $schchapters = $this->db->query($sql)->list_array('chapterid');
        $folderid_arr = array();*/

        if (false&&!empty($schchapters)) {
            //拷贝太慢，丢弃
            $schchapter_maps = array_flip(array_keys($schchapters));
            foreach ($schchapters as $schchapter) {
                $chapterid = array_shift($schchapter);
                $folderid_arr[] = array_pop($schchapter);
                $schchapter['crid'] = $this->dcrid;
                $schchapter['uid'] = $this->uid;
                $pid = $schchapter['pid'];
                if ($pid > 0) {
                    $schchapter['pid'] = $schchapter_maps[$pid];
                }
                $schchapter_maps[$chapterid] = $this->db->insert('ebh_schchapters', $schchapter);
                $path = array($schchapter_maps[$chapterid]);
                while($pid > 0) {
                    array_unshift($path, $schchapter_maps[$pid]);
                    $pid = $schchapters[$pid]['pid'];
                }
                $chapterpath = "/".implode('/', $path);
                $this->db->simple_query("UPDATE `ebh_schchapters` SET `chapterpath`='$chapterpath' WHERE `chapterid`={$schchapter_maps[$chapterid]}");
            }
        }
        //课程
        $sql = "SELECT `folderid`,`foldername`,`folderlevel`,`grade`,`district`,`displayorder`,`img`,`coursewarenum`,`summary`,`ispublic`,`fprice`,`isschoolfree`,`viewnum`,`speaker`,`detail`,`coursewarelogo`,`power`,`credit`,`creditrule`,`creditmode`,`credittime`,`playmode`,`isremind`,`remindmsg`,`remindtime`,`introduce`,`showmode`
                FROM `ebh_folders` WHERE `crid`={$this->scrid}";
        $folders = $this->db->query($sql)->list_array('folderid');
        if (empty($folders)) {
            return 0;
        }
        $folder_maps = array_flip(array_keys($folders));
        $this->db->begin_trans();
        foreach ($folders as $folder) {
            $folderid = array_shift($folder);
            //$chapterid = array_pop($folder);
            $folder['crid'] = $this->dcrid;
            $folder['uid'] = $this->uid;
            /*if (isset($schchapter_maps[$chapterid])) {
                $folder['chapterid'] = $schchapter_maps[$chapterid];
            }*/$folder['chapterid'] = 0;
            $folder_maps[$folderid] = $this->db->insert('ebh_folders', $folder);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return $folder_maps;
    }

    /**
     * 拷贝班级老师
     * @param $class_maps
     * @param $folder_maps
     */
    private function _cp_classteachers($class_maps, $folder_maps) {
        $classid_arr = array_keys($class_maps);
        $classid_arr_str = implode(',', $classid_arr);
        $sql = "SELECT `classid`,`uid`,`folderid` FROM `ebh_classteachers` WHERE `classid` IN($classid_arr_str)";
        $ct = $this->db->query($sql)->list_array();
        if (empty($ct)) {
            return 0;
        }
        foreach ($ct as $ctitem) {
            $classid = array_shift($ctitem);
            $folderid = array_pop($ctitem);
            $ctitem['classid'] = $class_maps[$classid];
            if ($folderid > 0) {
                $ctitem['folderid'] = $folder_maps[$folderid];
            } else {
                $ctitem['folderid'] = 0;
            }
            $this->db->insert('ebh_classteachers', $ctitem);
        }
    }

    /**
     * 拷贝班级课程
     * @param $class_maps
     * @param $folder_maps
     */
    private function _cp_classcourses($class_maps, $folder_maps) {
        $folderid_arr = array_keys($folder_maps);
        $classid_arr = array_keys($class_maps);
        $classid_arr_str = implode(',', $classid_arr);
        $folderid_arr_str = implode(',', $folderid_arr);
        $sql = "SELECT `classid`,`folderid` FROM `ebh_classcourses` WHERE `classid` IN($classid_arr_str) AND `folderid` IN($folderid_arr_str)";
        $classcourses = $this->db->query($sql)->list_array();
        if (empty($classcourses)) {
            return;
        }
        foreach ($classcourses as $classcourse) {
            $classid = array_shift($classcourse);
            $folderid = array_shift($classcourse);
            $classcourse['classid'] = $class_maps[$classid];
            $classcourse['folderid'] = $folder_maps[$folderid];
            $this->db->insert('ebh_classcourses', $classcourse);
        }
    }

    /**
     * 拷贝章节，返回章节ID映射表
     * @param $folder_maps
     * @return array|bool|mixed
     */
    private function _cp_sections($folder_maps) {
        $sql = "SELECT `sid`,`folderid`,`sname`,`displayorder`,`coursewarecount` FROM `ebh_sections` WHERE `crid`={$this->scrid}";
        $sections = $this->db->query($sql)->list_array('sid');
        if (empty($sections)) {
            return 0;
        }
        $section_maps = array_flip(array_keys($sections));
        $this->db->begin_trans();
        foreach ($sections as $section) {
            $sid = array_shift($section);
            $folderid = array_shift($section);
            if (isset($folder_maps[$folderid])) {
                $section['folderid'] = $folder_maps[$folderid];
            } else {
                continue;
            }

            $section['crid'] = $this->dcrid;
            $section['dateline'] = SYSTIME;
            $section_maps[$sid] = $this->db->insert('ebh_sections', $section);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return $section_maps;
    }

    /**
     * 拷贝教师课程表
     * @param $folder_maps
     */
    private function _cp_teacherfolders($folder_maps) {
        $adminid = $this->db->query("SELECT `uid` FROM `ebh_classrooms` WHERE `crid`={$this->scrid}")->row_array();
        if (!empty($adminid)) {
            $adminid = $adminid['uid'];
        } else {
            $adminid = 0;
        }
        $sql = "SELECT `tid`,`folderid` FROM `ebh_teacherfolders` WHERE `crid`={$this->scrid}";
        $teacherfolders = $this->db->query($sql)->list_array();
        if (empty($teacherfolders)) {
            return;
        }
        foreach ($teacherfolders as $teacherfolder) {
            $folderid = array_pop($teacherfolder);
            if (!isset($folder_maps[$folderid])){
                continue;
            }
            if ($teacherfolder['tid'] == $adminid) {
                $teacherfolder['tid'] = $this->uid;
            }
            $teacherfolder['folderid'] = $folder_maps[$folderid];
            $teacherfolder['crid'] = $this->dcrid;
            $this->db->insert('ebh_teacherfolders', $teacherfolder);
        }
    }

    /**
     * 拷贝课件
     * @param $folder_maps
     * @param $class_maps
     * @param $section_maps
     */
    private function _cp_roomcourses($folder_maps, $class_maps, $section_maps) {
        $folder_id_arr = array_keys($folder_maps);
        $folder_id_arr_str = implode(',', $folder_id_arr);
        $sql = "SELECT `cwid`,`cdisplayorder`,`isfree`,`sid`,`classid`,`folderid` FROM `ebh_roomcourses` WHERE `crid`={$this->scrid} AND `folderid` IN($folder_id_arr_str)";
        $roomcourses = $this->db->query($sql)->list_array();

        if (empty($roomcourses)) {
            return;
        }
        $cwid_arr = array_column($roomcourses, 'cwid');
        $cwid_arr_str = implode(',', $cwid_arr);
        $coursewares = $this->db->query("SELECT * FROM `ebh_coursewares` WHERE `cwid` IN($cwid_arr_str)")->list_array('cwid');
        foreach ($roomcourses as $roomcourse) {
            $folderid = array_pop($roomcourse);
            $classid = array_pop($roomcourse);
            $sectionid = array_pop($roomcourse);
            if (!isset($folder_maps[$folderid]) || !isset($coursewares[$roomcourse['cwid']])) {
                continue;
            }
            $roomcourse['crid'] = $this->dcrid;
            $roomcourse['folderid'] = $folder_maps[$folderid];
            $roomcourse['classid'] = !isset($class_maps[$classid]) ? 0 : $class_maps[$classid];
            $roomcourse['sid'] = !isset($section_maps[$sectionid]) ? 0 : $section_maps[$sectionid];

            $courseware = $coursewares[$roomcourse['cwid']];
            $cwid = $courseware['cwid'];
            unset($courseware['cwid']);
            unset($courseware['updatedateline']);
            unset($courseware['verifydateline']);
            $courseware['ordernum'] = 0;
            $courseware['rewardmoney'] = 0;
            $courseware['rewardcount'] = 0;
            $courseware['uid'] = $this->uid;
            $courseware['catid'] = 0;
            $courseware['reviewnum'] = 0;
            $courseware['dateline'] = SYSTIME;
            $courseware['status'] = 1;

            $this->db->begin_trans();
            $newid = $this->db->insert('ebh_coursewares', $courseware);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return;
            }
            $this->cwid_maps[$cwid] = $newid;
            $roomcourse['cwid'] = $newid;
                $this->db->insert('ebh_roomcourses', $roomcourse);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return;
            }
            $this->db->commit_trans();
        }
    }

    /**
     * 拷贝服务包、服务包分类、服务项，返回服务项ID映射
     * @param $folder_maps
     * @return array|bool
     */
    private function _cp_pay_service($folder_maps) {
        //return json_decode('{"379":452,"377":453,"378":454,"383":455,"384":456,"376":457,"380":458,"381":459,"382":460,"374":461,"375":462,"405":463,"385":464}', true);
        if (empty($folder_maps)) {
            return false;
        }
        $sql = "SELECT `pid`,`pname`,`summary`,`displayorder`,`itype` FROM `ebh_pay_packages` WHERE `crid`={$this->scrid} AND `status`=1";
        $pay_services = $this->db->query($sql)->list_array('pid');
        if (empty($pay_services)) {
            return array();
        }
        $pid_arr = array_keys($pay_services);
        $pid_arr_str = implode(',', $pid_arr);
        $pid_arr = array_flip($pid_arr);
        $sql = "SELECT `sid`,`pid`,`sname`,`content`,`sdisplayorder`,`discount`,`showbysort`,`imgurl`,`ishide`,`showaslongblock` 
                FROM `ebh_pay_sorts` WHERE `pid` IN($pid_arr_str)";
        $pay_sorts = $this->db->query($sql)->list_array('sid');
        $sql = "SELECT `itemid`,`pid`,`iname`,`isummary`,`providercrid`,`folderid`,`sid`,`iprice`,`comfee`,`roomfee`,`providerfee`,`imonth`,`iday`,`grade`,`cannotpay`,`longblockimg`,`isyouhui`,`iprice_yh`,`comfee_yh`,`roomfee_yh`,`providerfee_yh`,`itype`,`ptype`,`view_mode` 
                FROM `ebh_pay_items` WHERE `pid` IN($pid_arr_str) AND `crid`={$this->scrid}";
        $pay_items = $this->db->query($sql)->list_array('itemid');
        $this->db->begin_trans();
        foreach ($pay_services as $pay_service) {
            $service_id = array_shift($pay_service);
            $pay_service['crid'] = $this->dcrid;
            $pay_service['status'] = 1;
            $pay_service['uid'] = $this->uid;
            $pay_service['dateline'] = SYSTIME;
            $pay_service['limitdate'] = 0;
            $pid_arr[$service_id] = $this->db->insert('ebh_pay_packages', $pay_service);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->pid_maps = $pid_arr;
        $sid_arr = array();
        foreach ($pay_sorts as $pay_sort) {
            $sid = array_shift($pay_sort);
            $pay_sort['pid'] = $pid_arr[$pay_sort['pid']];
            $sid_arr[$sid] = $this->db->insert('ebh_pay_sorts', $pay_sort);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $itemid_arr = array();
        foreach ($pay_items as $pay_item) {
            $itemid = array_shift($pay_item);
            $pay_item['pid'] = $pid_arr[$pay_item['pid']];
            if (isset($sid_arr[$pay_item['sid']])) {
                $pay_item['sid'] = $sid_arr[$pay_item['sid']];
            } else {
                $pay_item['sid'] = 0;
            }
            $pay_item['crid'] = $this->dcrid;
            if (array_key_exists($pay_item['folderid'], $folder_maps)) {
                $pay_item['folderid'] = $folder_maps[$pay_item['folderid']];
            }
            $pay_item['dateline'] = SYSTIME;
            $itemid_arr[$itemid] = $this->db->insert('ebh_pay_items', $pay_item);
            if ($this->db->trans_status() === false) {
                $this->db->rollback_trans();
                return false;
            }
        }
        $this->db->commit_trans();
        return $itemid_arr;
    }

    /**
     * 拷贝用户权限表
     * @param $itemid_maps 服务项ID映射
     * @param $folderid_maps 课程ID映射
     * @param $classid_maps 教室ID映射
     */
    private function _cp_userpermisions($itemid_maps, $folderid_maps, $classid_maps) {
        //echo json_encode($itemid_maps);echo json_encode($folderid_maps);echo json_encode($classid_maps);
        $crid = $this->scrid;
        $sql = "SELECT `itemid`,`type`,`powerid`,`uid`,`classid`,`folderid`,`cwid`,`startdate`,`enddate` 
                FROM `ebh_userpermisions` WHERE `crid`=$crid";
        $userpermisions = $this->db->query($sql)->list_array();
        if (empty($userpermisions)) {
            return;
        }
        $uid_arr = array();
        $default_classid = 0;
        if (!empty($classid_maps)) {
            $default_classid = end($classid_maps);
        }
        if ($default_classid == 0) {
            $default_classid = $this->db->insert('ebh_classes', array(
                'classname' => '',
                'grade' => 0,
                'crid' => $this->dcrid,
                'year' => date('Y', $this->now),
                'stunum' => 0,
                'dateline' => $this->now,
                'district' => 0,
                'headteacherid' => 0
            ));
            if ($default_classid === false) {
                return;
            }
        }
        foreach ($userpermisions as $userpermision) {
            if (!isset($itemid_maps[$userpermision['itemid']]) || !isset($folderid_maps[$userpermision['folderid']])) {
                continue;
            }
            $uid_arr[] = $userpermision['uid'];
            $userpermision['crid'] = $this->dcrid;
            $userpermision['dateline'] = $this->now;
            $l = $userpermision['enddate'] - $userpermision['startdate'];
            $userpermision['startdate'] = $this->now;
            $userpermision['enddate'] = $this->now + $l;
            $userpermision['itemid'] = $itemid_maps[$userpermision['itemid']];
            $userpermision['folderid'] = $folderid_maps[$userpermision['folderid']];
            $userpermision['classid'] = !isset($classid_maps[$userpermision['classid']]) ? $default_classid : $classid_maps[$userpermision['classid']];
            $this->db->insert('ebh_userpermisions', $userpermision);
        }
        //$order = $this->db->query("SELECT `orderid`,`pid`,`ordername`,`` FROM `ebh_pay_orders` WHERE `crid`={$this->scrid}")->list_field();


        $this->_clear_cache('user', 'plate-latestreport');
    }

    /**
     * 拷贝学习记录
     */
    private function _cp_playlogs() {
        $cwid_arr = array_keys($this->cwid_maps);
        $cwid_arr_str = implode(',', $cwid_arr);
        $sql = "SELECT `cwid`,`uid`,`ctime`,`ltime`,`startdate`,`lastdate`,`totalflag`,`finished` 
                FROM `ebh_playlogs` WHERE `cwid` IN($cwid_arr_str)";
        $playlogs = $this->db->query($sql)->list_array();
        if (empty($playlogs)) {
            return;
        }
        foreach ($playlogs as $playlog) {
            $cwid = array_shift($playlog);
            $playlog['cwid'] = $this->cwid_maps[$cwid];
            $playlog['startdate'] = $this->now + 3600;
            $playlog['lastdate'] = $this->now + 7200;
            $this->db->insert('ebh_playlogs', $playlog);
        }
    }

    private function reset() {
        $sql_arr[] = "DELETE FROM `ebh_component_item_options` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_component_items` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_component_richtexts` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_component_schools` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_classes` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_roomteachers` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_tgroups` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_teachergroups` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_roomusers` WHERE `crid`={$this->dcrid}";
        $sql = "SELECT `classid` FROM `ebh_classes` WHERE `crid`={$this->dcrid}";
        $classid_arr = $this->db->query($sql)->list_field();
        $classid_arr_str = implode(',', $classid_arr);
        unset($classid_arr);
        $sql = "SELECT `cwid` FROM `ebh_roomcourses` WHERE `crid`={$this->dcrid}";
        $cwid_arr = $this->db->query($sql)->list_field();
        $cwid_arr_str = implode(',', $cwid_arr);
        unset($folderid_arr);
        $sql = "SELECT `pid` FROM `ebh_pay_packages` WHERE `crid`={$this->dcrid}";
        $pid_arr = $this->db->query($sql)->list_field();
        $pid_arr_str = implode(',', $pid_arr);
        unset($pid_arr);
        $sql_arr[] = "DELETE FROM `ebh_schchapters` WHERE `crid`={$this->dcrid}";
        if (!empty($classid_arr_str)) {
            $sql_arr[] = "DELETE FROM `ebh_classstudents` WHERE `classid` IN($classid_arr_str)";
            $sql_arr[] = "DELETE FROM `ebh_classteachers` WHERE `classid` IN($classid_arr_str)";
            $sql_arr[] = "DELETE FROM `ebh_classcourses` WHERE `classid` IN($classid_arr_str)";
        }

        $sql_arr[] = "DELETE FROM `ebh_sections` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_teacherfolders` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_roomcourses` WHERE `crid`={$this->dcrid}";
        if (!empty($cwid_arr_str)) {
            $sql_arr[] = "DELETE FROM `ebh_coursewares` WHERE `cwid` IN($cwid_arr_str)";
        }
        $sql_arr[] = "DELETE FROM `ebh_folders` WHERE `crid`={$this->dcrid}";
        if (!empty($pid_arr_str)) {
            $sql_arr[] = "DELETE FROM `ebh_pay_sorts` WHERE `pid` IN($pid_arr_str)";
        }
        $sql_arr[] = "DELETE FROM `ebh_pay_items` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_pay_packages` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_userpermisions` WHERE `crid`={$this->dcrid}";
        $sql_arr[] = "DELETE FROM `ebh_custommessages` WHERE `crid`={$this->dcrid}";
        foreach ($sql_arr as $sql) {
            $this->db->simple_query($sql);
        }
        $this->_clear_cache($this->dcrid, 'other', 'plate-cofing');
    }

}