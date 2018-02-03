<?php

/**
 * 学生我的答疑控制器类 MyaskController
 */
class MyaskController extends CControl
{
    private $check = NULL;

    public function __construct()
    {
        parent::__construct();
        $roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
        if ($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
            $check = Ebh::app()->room->checkstudent(TRUE);
        } else {
            Ebh::app()->room->checkstudent();
        }
        $this->check = $check;
        $this->assign('roominfo', $roominfo);
        $this->assign('check', $check);
    }

    public function index()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $key = $this->_getplaykey();
        $this->assign('crid', $roominfo['crid']);
        $this->assign('key', $key);
        $this->display('myroom/myask');
    }

    public function all()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $askdate = $this->input->get('d');
        $aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
        $cwid = $this->input->get('cwid');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['shield'] = 0;
        $queryarr['aq'] = $aq;
        $queryarr['cwid'] = intval($cwid);
        $folderid = intval($folderid);
        if (!empty($folderid)) {
            $queryarr['folderid'] = $folderid;
        }
        if (!empty($askdate)) {    //过滤提问时间
            $asktime = strtotime($askdate);
            if ($asktime !== FALSE) {
                $queryarr['abegindate'] = $asktime;
                $queryarr['aenddate'] = $asktime + 86400;
            } else {
                $askdate = '';
            }
        }
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();
        //更新评论用户状态时间
        $statemodel = $this->model('Userstate');
        $typeid = 2;
        $statemodel->insert($roominfo['crid'], $user['uid'], $typeid, SYSTIME);

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('aq', $aq);
        $this->assign('key', $key);
        $this->display('myroom/myask_all');
        $this->_updateuserstate();
    }

    public function addquestion()
    {
        $nav = '当前位置 > <a href="' . geturl('myroom/myask') . '">学生答疑</a> > 我的问题';
        $this->inRoomCheck('您没有操作权限', $nav);
        $roominfo = Ebh::app()->room->getcurroom();
        $other_config = Ebh::app()->getConfig()->load('othersetting');
        $other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
        $other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
        $is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'], $other_config['newzjdlr']));
        $is_newzjdlr = in_array($roominfo['crid'], $other_config['newzjdlr']);
        $user = Ebh::app()->user->getloginuser();
        if (NULL === $this->input->post('title')) {
            $upcontrol = Ebh::app()->lib('UpcontrolLib');
            $editor = Ebh::app()->lib('UMEditor');
            $classsubjectmodel = $this->model('Classsubject');
            $subjects = $classsubjectmodel->getsubjectlist($roominfo['crid']);
            $this->assign('subjects', $subjects);
            $teachArr = array();
            $teachsubjects = array();

            foreach ($subjects as $key => $sbj) {
                $teacherid = $sbj['uid'];
                $face = $this->_getfaceurl($sbj['face'], $sbj['sex']);
                $sbj['face'] = $face;
                if (!in_array($teacherid, $teachArr)) {
                    $teachArr[] = $teacherid;
                }
                $teachsubjects[$teacherid][] = $sbj;
            }

            $roominfo = Ebh::app()->room->getcurroom();
            $myfolders = $classsubjectmodel->getMyfoldersForSMS($roominfo['crid'], $user['uid']);
            $myfolders = EBH::app()->lib('UserUtil')->init($myfolders, array('tid'), true);
            $showTeacherSelect = false;
            if (!$is_zjdlr) {
                //普通网校向教师提问
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
            $this->assign('folder', $folder);

            $cwid = $this->input->get('cwid');
            if (is_numeric($cwid)) {
                $cwmodel = $this->model('courseware');
                $courseware = $cwmodel->getSimplecourseByCwid($cwid);
                $this->assign('cw', $courseware);
            }

            $this->assign('myfolders', $myfolders);
            //var_dump($myfolders);
            //echo '<pre>';
            //var_dump($teachsubjects);

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
            $this->assign("allfolders", $allfolders);
            $this->assign('myfolders', $myfolders);
            $this->assign('user', $user);
            $this->assign('roominfo', $roominfo);
            // $this->assign('_SMS', $_SMS);
            $this->assign('otherfolders', $otherfolders);

            $this->assign('teachsubjects', $teachsubjects);
            $this->assign('upcontrol', $upcontrol);
            $this->assign('editor', $editor);


            $this->assign('showTeacherSelect', $showTeacherSelect);
            $forcoursedialog = $this->input->get('forcoursedialog');
            if (!empty($forcoursedialog)) {
                $this->display('myroom/myask_add_forcoursedialog');
            } else {
                $this->display('myroom/myask_add');
            }
        } else {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
            $tid = $this->input->post('tid');
            if (!isset($title) || !isset($message))
                return false;
            else {
                $title = h($title);
                $message = h($message);
                $tid = intval($tid);
            }
            $imagesrc = $this->input->post('images');
            $imagename = $this->input->post('imagesname');
            if (count($imagesrc) > 9) {
                $result = array('status' => 0, 'message' => '上传图片不能超过9张！');
                echo json_encode($result);
                exit();
            }
            $imagesrc = empty($imagesrc) ? '' : implode(',', $imagesrc);
            $imagename = empty($imagename) ? '' : implode(',', $imagename);

            $audiosrc = $this->input->post('audio');
            $setaudio['audiosrc'] = array();
            $setaudio['audioname'] = array();
            $setaudio['audiotime'] = array();
            if (!empty($audiosrc)) {
                $audioarr = array();
                $setaudio = array();
                foreach ($audiosrc as $k => $src) {
                    $audioarr = explode('_', $src);
                    $audioname = substr($audioarr[0], strrpos($audioarr[0], '/') + 1);
                    $setaudio['audiosrc'][] = $audioarr[0];
                    $setaudio['audioname'][] = $audioname;
                    $setaudio['audiotime'][] = $audioarr[1];
                }
                $setaudio['audiosrc'] = json_encode($setaudio['audiosrc']);
                $setaudio['audioname'] = json_encode($setaudio['audioname']);
                $setaudio['audiotime'] = json_encode($setaudio['audiotime']);
            }
            $folderid = $this->input->post('folderid');
            $fromip = $this->input->getip();
            if ($folderid === NULL || !is_numeric($folderid)) {
                $result = array('status' => 0, 'message' => '请选择课程');
                echo json_encode($result);
                exit();
            }
            $cwid = intval($this->input->post('cwid'));
            $cwname = h($this->input->post('cwname'));
            $reward = 0;
            $rewardid = $this->input->post('reward');
            $askreward = EBH::app()->getConfig()->load('askreward');
            if (!empty($rewardid) && $askreward[$rewardid] <= $user['credit'])
                $reward = $askreward[$rewardid];
            $param = array('uid' => $user['uid'], 'folderid' => $folderid, 'crid' => $roominfo['crid'], 'title' => $title, 'message' => $message, 'imagename' => $imagename, 'imagesrc' => $imagesrc, 'audioname' => $setaudio['audioname'], 'audiosrc' => $setaudio['audiosrc'], 'fromip' => $fromip, 'tid' => $tid, 'cwid' => $cwid, 'cwname' => $cwname, 'reward' => $reward, 'audiotime' => $setaudio['audiotime']);
            $askmodel = $this->model('Askquestion');
            $qid = $askmodel->insert($param);
            if ($qid > 0) {
                $result = array('status' => 1, 'message' => '添加成功');
                echo json_encode($result);
                fastcgi_finish_request();
                //提问悬赏
                if (!empty($reward)) {
                    $credit = $this->model('credit');
                    $credit->addCreditlog(array('ruleid' => 26, 'qid' => $qid, 'credit' => $reward));
                }
                //添加教师私信
                if (!empty($tid)) {
                    $uname = empty($user['realname']) ? $user['username'] : $user['realname'];
                    $type = 5;    //答疑新提问(针对老师)
                    $msg = $title;
                    Ebh::app()->lib('EMessage')->sendMessage($user['uid'], $uname, $tid, $qid, $type, $msg);
                }
                //短信发送
                EBH::app()->lib('SMS')->run($qid, $tid, 1);
                Ebh::app()->lib('PushUtils')->PushAskToTeacher($qid);//信鸽推送
                if (!empty($roominfo['crid'])) {
                    //更新答疑数
                    $roommodel = $this->model('Classroom');
                    $roommodel->addasknum($roominfo['crid'], 1);
                }

                //视频播放页面的相关问题列表缓存清除
                $linkedquestionskey = $this->cache->getcachekey('linkedquestionskey', array('cwid' => intval($cwid), 'page' => 1, 'pagesize' => 10));
                $this->cache->remove($linkedquestionskey);

                //同步SNS数据(当成功提问时同步)
                Ebh::app()->lib('Sns')->do_sync($user['uid'], 1);
				
				//清除userstate数量缓存
				$userstatelib = Ebh::app()->lib('Userstate');
				$userstatelib->clearCache_count($roominfo['crid'],0,4);

            } else {
                $result = array('status' => 0, 'message' => '添加失败，请稍后再试或联系管理员');
                echo json_encode($result);
            }
        }
    }

    /**
     * 编辑问题
     */
    public function editquestion_view()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $qid = $this->uri->itemid;
        if ($qid === NULL || !is_numeric($qid)) {
            exit();
        }
        if (NULL === $this->input->post('title')) {
            $editor = Ebh::app()->lib('UMEditor');
            $upcontrol = Ebh::app()->lib('UpcontrolLib');
            $askmodel = $this->model('Askquestion');
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
            $classsubjectmodel = $this->model('Classsubject');
            $subjects = $classsubjectmodel->getsubjectlist($roominfo['crid']);
            $this->assign('subjects', $subjects);
            $teachArr = array();
            $teachsubjects = array();

            foreach ($subjects as $key => $sbj) {
                $teacherid = $sbj['uid'];
                $face = $this->_getfaceurl($sbj['face'], $sbj['sex']);
                $sbj['face'] = $face;
                if (!in_array($teacherid, $teachArr)) {
                    $teachArr[] = $teacherid;
                }
                if ($sbj['folderid'] == $ask['folderid']) {
                    $folder = $sbj;
                }
                $teachsubjects[$teacherid][] = $sbj;
            }
            $showTeacherSelect = false;
            // $_SMS = EBH::app()->getConfig()->load('sms');
            $roominfo = Ebh::app()->room->getcurroom();
            // if(in_array($roominfo['crid'], $_SMS['crids'])){
            $myfolders = $classsubjectmodel->getMyfoldersForSMS($roominfo['crid'], $user['uid']);
            $myfolders = EBH::app()->lib('UserUtil')->init($myfolders, array('tid'), true);
            // $showTeacherSelect = true;
            // }else{
            // $myfolders= $classsubjectmodel->getMyfolders($roominfo['crid'],$user['uid']);
            // }

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
                $otherfolders = $allfolders;
            }

            $groupInfo = $this->model('tgroups')->getRoomGroupInfo($roominfo['crid']);
            if (!empty($groupInfo))
                $showTeacherSelect = true;
            else {
                $teachermodel = $this->model('teacher');
                $teachers = $teachermodel->getroomteacherlist($roominfo['crid'], array('limit' => 1000));
                $teachers[0]['groupname'] = '所有老师';
                $groupInfo['group_0'] = $teachers;
                $showTeacherSelect = true;
            }
            $this->assign('groupInfo', $groupInfo);
            $teacherModel = $this->model('teacher');
            if (!empty($ask['tid'])) {
                $requiredTeacher = $teacherModel->getteacherdetail($ask['tid']);
                $this->assign('requiredTeacher', $requiredTeacher);
            } else {
                $this->assign('requiredTeacher', array());
            }
            //组装语音消息
            if (!empty($ask['audiosrc'])) {
                $audiosrc = json_decode($ask['audiosrc']);
                $audioname = json_decode($ask['audioname']);
                $audiotime = json_decode($ask['audiotime']);
                $audio = array();
                foreach ($audiosrc as $k => $src) {
                    $audio[$k]['audiosrc'] = $src;
                    $audio[$k]['audioname'] = $audioname[$k];
                    $audio[$k]['audiotime'] = $audiotime[$k];
                }
                $ask['audio'] = $audio;
            }
            $this->assign('myfolders', $myfolders);
            //var_dump($ask);
            $this->assign('teachsubjects', $teachsubjects);
            $this->assign('folder', $folder);
            $this->assign('ask', $ask);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->assign('upcontrol', $upcontrol);
            $this->assign("allfolders", $allfolders);
            $this->assign('user', $user);
            $this->assign('roominfo', $roominfo);
            // $this->assign('_SMS', $_SMS);
            $this->assign('otherfolders', $otherfolders);

            $this->assign('showTeacherSelect', $showTeacherSelect);
            $this->display('myroom/myask_edit');
        } else {
            $title = $this->input->post('title');
            $message = $this->input->post('message');
            $tid = $this->input->post('tid');
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
            if (!isset($title) || !isset($message) || empty($ask))
                return false;
            else {
                $title = h($title);
                $message = h($message);
                $tid = intval($tid);
            }
            $cwid = intval($this->input->post('cwid'));
            $cwname = h($this->input->post('cwname'));
            $imagesrc = $this->input->post('images');
            $imagename = $this->input->post('imagesname');
            if (count($imagesrc) > 9) {
                $result = array('status' => 0, 'message' => '上传图片不能超过9张！');
                echo json_encode($result);
                exit();
            }
            $imagesrc = empty($imagesrc) ? '' : implode(',', $imagesrc);
            $imagename = empty($imagename) ? '' : implode(',', $imagename);
            $audiosrc = $this->input->post('audio');
            $setaudio['audiosrc'] = '';
            $setaudio['audioname'] = '';
            $setaudio['audiotime'] = '';
            if (!empty($audiosrc)) {
                $audioarr = array();
                foreach ($audiosrc as $k => $src) {
                    $audioarr = explode('_', $src);
                    $audioname = substr($audioarr[0], strrpos($audioarr[0], '/') + 1);
                    $setaudio['audiosrc'][] = $audioarr[0];
                    $setaudio['audioname'][] = $audioname;
                    $setaudio['audiotime'][] = $audioarr[1];
                }
                $setaudio['audiosrc'] = json_encode($setaudio['audiosrc']);
                $setaudio['audioname'] = json_encode($setaudio['audioname']);
                $setaudio['audiotime'] = json_encode($setaudio['audiotime']);
            }
            $folderid = $this->input->post('folderid');
            $fromip = $this->input->getip();
            if ($folderid === NULL || !is_numeric($folderid)) {
                $result = array('status' => 0, 'message' => '请选择分类');
                echo json_encode($result);
                exit();
            }
            $reward = $ask['reward'];
            $rewardid = $this->input->post('reward');
            $askreward = EBH::app()->getConfig()->load('askreward');
            if (empty($ask['answercount']) && $askreward[$rewardid] <= $user['credit'] + $ask['reward']) {
                $reward = $askreward[$rewardid];
                if (empty($ask['reward'])) {
                    $ruleid = 26;
                    $newreward = $reward;
                } elseif ($reward > $ask['reward']) {
                    $ruleid = 28;
                    $newreward = $reward - $ask['reward'];
                } elseif ($reward < $ask['reward']) {
                    $ruleid = 29;
                    $newreward = $ask['reward'] - $reward;
                }

            }
            $param = array('qid' => $qid, 'uid' => $user['uid'], 'folderid' => $folderid, 'crid' => $roominfo['crid'], 'title' => $title, 'message' => $message, 'imagename' => $imagename, 'imagesrc' => $imagesrc, 'audioname' => $setaudio['audioname'], 'audiosrc' => $setaudio['audiosrc'], 'fromip' => $fromip, 'tid' => $tid, 'cwid' => $cwid, 'cwname' => $cwname, 'reward' => $reward, 'audiotime' => $setaudio['audiotime']);
            $askmodel = $this->model('Askquestion');
            $result = $askmodel->update($param);
            if ($result !== FALSE) {
                $resultarr = array('status' => 1, 'message' => '修改成功');
                echo json_encode($resultarr);
                fastcgi_finish_request();
                //提问悬赏
                if (!empty($newreward) && !empty($ruleid)) {
                    $credit = $this->model('credit');
                    $credit->addCreditlog(array('ruleid' => $ruleid, 'qid' => $qid, 'credit' => $newreward));
                }
            } else {
                $resultarr = array('status' => 0, 'message' => '修改失败，请稍后再试或联系管理员');
                echo json_encode($resultarr);
            }
        }
    }

    /**
     * 问题详情
     */
    public function view()
    {
        $qid = $this->uri->itemid;
        if (is_numeric($qid)) {
            $roominfo = Ebh::app()->room->getcurroom();
            $crid = $roominfo['crid'];
            $editor = Ebh::app()->lib('UMEditor');
            $param = parsequery();
            $param['qid'] = $qid;
            $param['pagesize'] = 10;
            $askmodel = $this->model('Askquestion');
            $user = Ebh::app()->user->getloginuser();
            //人气数+1
            $askmodel->addviewnum($qid);
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid'], $crid);
            if (empty($ask)) {
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题不存在或已删除";
                echo '<a href="' . $url . '">返回</a>';
                exit;
            } elseif (!empty($ask) && $ask['shield'] == 1) {
                $url = getenv("HTTP_REFERER");
                header("Content-type:text/html;charset=utf-8");
                echo "问题被屏蔽，无法查看";
                echo '<a href="' . $url . '">返回</a>';
                exit;
            }
            if (!empty($ask['audiosrc']) && empty($ask['audiotime'])) {//检验语音是否已经读取过语音时长
                //组装成保存路径
                //读取配置文件
                $config = Ebh::app()->getConfig()->load('upconfig');
                $audioconfig = $config['ask'];
                $showpath = $audioconfig['showpath'];
                $savepath = $audioconfig['savepath'];
                $path = trim($ask['audiosrc'], $showpath);
                $path = $savepath . $path;
                if (!empty($path)) {
                    $time = $this->_checkAudioTime($path);
                    if (isset($time['playtime_seconds'])) {
                        $audiotime = ceil($time['playtime_seconds']);
                        $setarr = array();
                        $setarr['audioname'] = json_encode(array(0 => $ask['audioname']));
                        $setarr['audiosrc'] = json_encode(array(0 => $ask['audiosrc']));
                        $setarr['audiotime'] = json_encode(array(0 => $audiotime));
                        $askmodel->updateAudio($setarr, $qid);
                        $ask['audiotime'] = $setarr['audiotime'];
                        $ask['audioname'] = $setarr['audioname'];
                        $ask['audiosrc'] = $setarr['audiosrc'];
                    }
                }
            }
            $answers = $askmodel->getdetailanswersbyqid($param);
            //p($answers);die;
            if (!empty($answers)) {
                foreach ($answers as $key => $answer) {
                    if (!empty($answer['audiosrc']) && empty($answer['audiotime'])) {
                        $config = Ebh::app()->getConfig()->load('upconfig');
                        $audioconfig = $config['ask'];
                        $showpath = $audioconfig['showpath'];
                        $savepath = $audioconfig['savepath'];
                        $path = trim($answer['audiosrc'], $showpath);
                        $path = $savepath . $path;
                        if (!empty($path)) {
                            $time = $this->_checkAudioTime($path);
                            if (isset($time['playtime_seconds'])) {
                                $audiotime = round($time['playtime_seconds']);
                                $setarr = array();
                                $setarr['audioname'] = json_encode(array(0 => $answer['audioname']));
                                $setarr['audiosrc'] = json_encode(array(0 => $answer['audiosrc']));
                                $setarr['audiotime'] = json_encode(array(0 => $audiotime));
                                $askmodel->updateAnswerAudioTime($setarr, $answer['aid']);
                                $answers[$key]['audiotime'] = $setarr['audiotime'];
                                $answers[$key]['audioname'] = $setarr['audioname'];
                                $answers[$key]['audiosrc'] = $setarr['audiosrc'];
                            }
                        }
                    }
                    if (!empty($answers[$key]['audiosrc'])) {
                        $anaudio = array();
                        $anaudiochild = array();
                        $anaudiosrc = json_decode($answers[$key]['audiosrc']);
                        $anaudiotime = json_decode($answers[$key]['audiotime']);
                        $anaudioname = json_decode($answers[$key]['audioname']);
                        foreach ($anaudiosrc as $k => $ansrc) {
                            $anaudiochild['audiosrc'] = $ansrc;
                            $anaudiochild['audiotime'] = $anaudiotime[$k];
                            $anaudiochild['audioname'] = $anaudioname[$k];
                            $anaudio[] = $anaudiochild;
                            //unset($anaudiochild);
                        }
                        $answers[$key]['audio'] = $anaudio;
                    }
                }
            }
            $count = $askmodel->getdetailanswerscountbyqid($qid);
            $pagestr = show_page($count, $param['pagesize']);

            //悬赏奖励者名单
            $rewardlist = array();
            if ($ask['isrewarded'] == 1) {
                $rewardlist = $this->model('credit')->getRewardList($qid);
            }
            if (!empty($ask['audiosrc'])) {
                $audio = array();
                $audiochild = array();
                $audiosrc = json_decode($ask['audiosrc']);
                $audiotime = json_decode($ask['audiotime']);
                $audioname = json_decode($ask['audioname']);
                foreach ($audiosrc as $k => $src) {
                    $audiochild['audiosrc'] = $src;
                    $audiochild['audiotime'] = $audiotime[$k];
                    $audiochild['audioname'] = $audioname[$k];
                    $audio[] = $audiochild;
                    unset($audiochild);
                }
            }
            //p($answers);die;
            $this->assign('audioque', $audio);
            $this->assign('rewardlist', $rewardlist);

            $answerers = $askmodel->getanswerer(array('qid' => $qid));
            $this->assign('answerers', $answerers);
            $this->assign('ask', $ask);
            $this->assign('answers', $answers);
            $this->assign('pagestr', $pagestr);
            $this->assign('user', $user);
            $this->assign('qid', $qid);
            $this->assign('editor', $editor);
            $this->display('myroom/myask_view');
        }
    }

    /**
     * 教师我的问题
     */
    public function myquestion()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
        $queryarr['shield'] = 0;
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('key', $key);
        $this->display('myroom/myquestion');

        $this->_updateuserstate();
    }

    /**
     * 我的回答
     */
    public function myanswer()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
        $queryarr['qshield'] = 0;
        $queryarr['ashield'] = 0;
        $d = $this->input->get('d');
        if (!empty($d)) {
            $thetime = strtotime($d);
            if ($thetime !== FALSE) {
                $startdate = $thetime;
                $enddate = $thetime + 86400;
                $queryarr['startDate'] = $startdate;
                $queryarr['endDate'] = $enddate;
            }
        }
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getasklistbyanswers($queryarr);
        $count = $askmodel->getaskcountbyanswers($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('d', $d);
        $this->assign('key', $key);
        $this->display('myroom/myanswer');
    }

    /**
     * 我的关注
     */
    public function myfavorit()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getasklistbyfavorit($queryarr);
        $count = $askmodel->getaskcountbyfavorit($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('key', $key);
        $this->display('myroom/myfavorit');
    }

    /**
     * 删除我的提问
     */
    public function delask()
    {
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $ask = $askmodel->getaskbyqid($qid);
        if (empty($ask) || $ask['crid'] != $roominfo['crid'] || $ask['uid'] != $user['uid']) {
            echo 'fail';
            exit();
        }
        //删除回答对应的文件
//        $answerlist = $askmodel->getanswersbyqid($qid);
//        foreach($answerlist as $myanswer) {
//            
//        }
        $result = $askmodel->delask($qid);
        if ($result) {
            if (!empty($roominfo['crid'])) {
                //更新答疑数
                $roommodel = $this->model('Classroom');
                $roommodel->addasknum($roominfo['crid'], -1);
            }
            echo 'success';
            fastcgi_finish_request();
            //同步SNS数据(当删除问题时，问题数-1)
            Ebh::app()->lib('Sns')->do_sync($ask['uid'], -1);
            exit();
        } else {
            echo 'fail';
            exit();
        }
    }

    /**
     * 取消关注
     */
    public function delfavorit()
    {
        $aid = $this->input->post('aid');
        if ($aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('Askquestion');
        $param = array('uid' => $user['uid'], 'aid' => $aid);
        $result = $askmodel->delfavorit($param);
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 关注获取消关注问题
     */
    public function addfavorit()
    {
        $qid = $this->input->post('qid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $flag = $this->input->post('flag');
        $param = array('uid' => $user['uid'], 'qid' => $qid);
        $askmodel = $this->model('Askquestion');
        if ($flag == 1) {
            $result = $askmodel->addfavorit($param);
        } else {
            $result = $askmodel->delfavorit($param);
        }
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 添加感谢
     */
    public function addthank()
    {
        $qid = $this->input->post('qid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        $reviewmodel = $this->model('Review');
        $logparam = array('uid' => $user['uid'], 'toid' => $qid, 'opid' => 1, 'type' => 'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
        $lasttime = $reviewmodel->getLastLogTime($logparam);
        $today = date('Y-m-d');
        $todaybegintime = strtotime($today);
        if (!empty($lasttime) && ($lasttime >= $todaybegintime)) {    //一天只能一次投票
            echo 'thatday';
            exit();
        }
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addthank($qid);
        if ($result > 0) {
            $logparam['message'] = '回答感谢';
            $logparam['fromip'] = $this->input->getip();
            $reviewmodel->insertlog($logparam);
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 添加回答的感谢
     */
    public function addthankanswer()
    {
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
        $reviewmodel = $this->model('Review');
        $logparam = array('uid' => $user['uid'], 'toid' => $aid, 'opid' => 1, 'type' => 'addthankanswer');//value 0为投票，不需要加入review表 1为评论 需要加入review表
        $lasttime = $reviewmodel->getLastLogTime($logparam);
        $today = date('Y-m-d');
        $todaybegintime = strtotime($today);
        if (!empty($lasttime) && ($lasttime >= $todaybegintime)) {    //一天只能一次投票
            echo 'thatday';
            exit();
        }
        $param = array('qid' => $qid, 'aid' => $aid);
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addthankanswer($param);
        if ($result > 0) {
            $logparam['message'] = '回答感谢';
            $logparam['fromip'] = $this->input->getip();
            $reviewmodel->insertlog($logparam);
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 添加回答
     */
    public function addanswer()
    {
        $qid = $this->input->post('qid');
        if ($qid === NULL || !is_numeric($qid)) {
            echo 'fail';
            exit();
        }
        if ($this->check != 1) {    //如果没有权限，则不提供解答功能
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $param = array();
        $param['qid'] = $qid;
        $param['uid'] = $user['uid'];
        $param['message'] = $this->input->post('message');
        if (!isset($param['message']))
            return false;
        else {
            $param['message'] = h($param['message']);
        }
        //   $param['audioname'] = $this->input->post('audioname');
        $audiosrc = $this->input->post('audio');
        $setaudio['audiosrc'] = array();
        $setaudio['audioname'] = array();
        $setaudio['audiotime'] = array();
        if (!empty($audiosrc)) {
            $audioarr = array();
            $setaudio = array();
            foreach ($audiosrc as $k => $src) {
                $audioarr = explode('_', $src);
                $audioname = substr($audioarr[0], strrpos($audioarr[0], '/') + 1);
                $setaudio['audiosrc'][] = $audioarr[0];
                $setaudio['audioname'][] = $audioname;
                $setaudio['audiotime'][] = $audioarr[1];
            }
            $setaudio['audiosrc'] = json_encode($setaudio['audiosrc']);
            $setaudio['audioname'] = json_encode($setaudio['audioname']);
            $setaudio['audiotime'] = json_encode($setaudio['audiotime']);
        }

        $param['audiosrc'] = $setaudio['audiosrc'];
        $param['audioname'] = $setaudio['audioname'];
        $param['audiotime'] = $setaudio['audiotime'];
        $param['imagename'] = $this->input->post('imagename');
        $param['imagesrc'] = $this->input->post('imagesrc');
        $param['attname'] = $this->input->post('attname');
        $param['attsrc'] = $this->input->post('attsrc');
        $param['cwid'] = intval($this->input->post('cwid'));
        $param['cwsource'] = $this->input->post('cwsource');
        $param['fromip'] = $this->input->getip();
        //p($param);die;
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->addanswer($param);
        if ($result > 0) {
            echo 'success';
            fastcgi_finish_request();
            Ebh::app()->lib('PushUtils')->PushAskToStudent($qid);//信鸽推送
            Ebh::app()->lib('ThirdPushUtils')->PushAskToStudent($qid);//第三方推送
            $ask = $askmodel->getdetailaskbyqid($qid, $user['uid']);
            $upparam = array(
                'qid' => $qid,
                'uid' => $ask['uid'],
                'lastansweruid' => $user['uid']
            );
            $askmodel->update($upparam);
            $credit = $this->model('credit');
            $credit->addCreditlog(array('ruleid' => 21, 'qid' => $param['qid']));
            //新回答通过私信告诉提问人
            $msglib = Ebh::app()->lib('EMessage');
            $type = 2; //答疑新回答
            $lastmsg = $msglib->getLastUnReadMessage($ask['uid'], $qid, $type);
            $uname = empty($user['realname']) ? $user['username'] : $user['realname'];
            if (empty($lastmsg)) {    //如果当前的答疑私信没有未读的，则直接添加消息
                $title = $ask['title'];
                $msg = $title;
                $msglib->sendMessage($user['uid'], $uname, $ask['uid'], $qid, $type, $msg);
            } else {    //否则更新消息即可
                $ulist = $lastmsg['ulist'];
                parse_str($ulist, $uarr);
                if (!isset($uarr[$user['uid']])) {
                    if (empty($ulist)) {
                        $ulist = $user['uid'] . '=' . $uname;
                    } else {
                        $ulist .= '&' . $user['uid'] . '=' . $uname;
                    }
                    $lastmsg['ulist'] = $ulist;
                    $lastmsg['dateline'] = SYSTIME;
                    $msglib->updateMessage($lastmsg);
                }
            }
            exit();
        }
        echo 'fail';
        exit();
    }

    /**
     * 删除解答
     */
    public function delanswer()
    {
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
        $user = Ebh::app()->user->getloginuser();
        $param = array('qid' => $qid, 'aid' => $aid, 'uid' => $user['uid']);
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->delanswer($param);
        if ($result > 0) {
            echo 'success';
            exit();
        }
        echo 'fail';
        exit();
    }

    /*
    设置最佳答案
    */
    public function setbest()
    {
        exit;//学生不能设最佳答案了2017.08.09
        $qid = $this->input->post('qid');
        $aid = $this->input->post('aid');
        $user = Ebh::app()->user->getloginuser();
        if ($qid === NULL || !is_numeric($qid) || $aid === NULL || !is_numeric($aid)) {
            echo 'fail';
            exit();
        }
        $param = array('uid' => $user['uid'], 'qid' => $qid, 'aid' => $aid);
        $askmodel = $this->model('Askquestion');
        $result = $askmodel->setbest($param);
        if ($result) {
            echo 'success';
            $credit = $this->model('credit');
            $credit->addCreditlog(array('ruleid' => 14, 'aid' => $aid));
            exit();
        } else {
            echo 'fail';
            exit();
        }
    }

    /**
     *获取播放器提问和播放器回答所需的key值
     */
    private function _getplaykey()
    {
        $clientip = $this->input->getip();
        $ktime = SYSTIME;
        $auth = $this->input->cookie('auth');
        $sauth = authcode($auth, 'DECODE');
        @list($password, $uid) = explode("\t", $sauth);
        $skey = $ktime . '\t' . $uid . '\t' . $password . '\t' . $clientip;
        $key = authcode($skey, 'ENCODE');
        return $key;
    }

    /**
     *更新新作业用户状态时间
     */
    private function _updateuserstate()
    {
        //更新评论用户状态时间
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $typeid = 4;
        $userstatelib = Ebh::app()->lib('Userstate');
		$userstatelib->updateUserstate($roominfo['crid'], $user['uid'],$typeid);
    }

    /*
    获取全部问题，我的问题，我的回答，我的关注数量
    */
    public function getcountinfo()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('askquestion');
        $param['crid'] = $roominfo['crid'];
        $param['shield'] = 0;
        $count['all'] = $askmodel->getallaskcount($param);
        // $param['uid'] = $user['uid'];
        // $count['myquestion'] = $askmodel->getallaskcount($param);
        // $count['myanswer'] = $askmodel->getaskcountbyanswers($param);
        // $count['myfavorite'] = $askmodel->getaskcountbyfavorit($param);
        echo json_encode($count);
    }

    /**
     * 获取课程关联的教师头像
     *
     */
    protected function _getfaceurl($face = '', $sex)
    {
        $defaulturl = $sex == 1 ? 'm_woman.jpg' : 'm_man.jpg';
        $defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/' . $defaulturl;
        $face = empty($face) ? $defaulturl : $face;
        return $face = getthumb($face, '40_40');
    }

    /**
     *提问问题页面(针对弹框)
     */
    public function addquestion_fordialog()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $upcontrol = Ebh::app()->lib('UpcontrolLib');
        $editor = Ebh::app()->lib('UMEditor');
        $classsubjectmodel = $this->model('Classsubject');
        $subjects = $classsubjectmodel->getsubjectlist($roominfo['crid']);
        $this->assign('subjects', $subjects);
        $teachArr = array();
        $teachsubjects = array();

        foreach ($subjects as $key => $sbj) {
            $teacherid = $sbj['uid'];
            $face = $this->_getfaceurl($sbj['face'], $sbj['sex']);
            $sbj['face'] = $face;
            if (!in_array($teacherid, $teachArr)) {
                $teachArr[] = $teacherid;
            }
            $teachsubjects[$teacherid][] = $sbj;
        }
        $myfolders = $classsubjectmodel->getMyfoldersForSMS($roominfo['crid'], $user['uid']);
        $myfolders = EBH::app()->lib('UserUtil')->init($myfolders, array('tid'), true);
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
            $otherfolders = $allfolders;
        }

        //获取教师分组信息
        $groupInfo = $this->model('tgroups')->getRoomGroupInfo($roominfo['crid']);
        $this->assign('groupInfo', $groupInfo);
        $this->assign('myfolders', $myfolders);
        $this->assign('teachsubjects', $teachsubjects);
        $this->assign('upcontrol', $upcontrol);
        $this->assign('editor', $editor);
        $showTeacherSelect = false;
        $_SMS = EBH::app()->getConfig()->load('sms');
        $roominfo = Ebh::app()->room->getcurroom();
        if (in_array($roominfo['crid'], $_SMS['crids'])) {
            $showTeacherSelect = true;
        }
        $this->assign('showTeacherSelect', $showTeacherSelect);
        $this->assign("allfolders", $allfolders);
        $this->assign('user', $user);
        $this->assign('roominfo', $roominfo);
        $this->assign('_SMS', $_SMS);
        $this->assign('otherfolders', $otherfolders);
        $this->display('myroom/myask_add_fordialog');
    }

    public function inRoomCheck($msg = "您没有操作权限", $nav = "没有权限")
    {
        //判断用户是否在该学校里面
        $inRoom = TRUE;
        if ($this->check != 1)
            $inRoom = FALSE;
//        $roominfo = Ebh::app()->room->getcurroom();
//        $user = Ebh::app()->user->getloginuser();
//        $inRoom = true;
//        if(!empty($user) && !empty($roominfo)){
//            $roommodel = $this->model('Classroom');
//            if($user['groupid'] == 6){//学生
//                $check = $roommodel->checkstudent($user['uid'], $roominfo['crid']);
//            }else if($user['groupid'] == 5){//老师
//                $check = $roommodel->checkteacher($user['uid'], $roominfo['crid']);
//            }
//            if($check == -1){
//                $inRoom = false;
//            }
//        }else{
//            $inRoom = false;
//        }
        if ($inRoom == false) {
            $this->assign('nav', $nav);
            $this->assign('msg', $msg);
            $this->display('common/permission_denied');
            exit;
        }
    }

    public function box_cw_view()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $folderid = $this->uri->itemid;

        $subfolderlib = Ebh::app()->lib('SubFolder');
        $subfolderlib->getSubFolder($this, $folderid);
        $cridarr = Ebh::app()->getConfig()->load('subfolder');
        if (in_array($roominfo['crid'], $cridarr['noteacher']))
            $this->assign('needsubfolder', false);
        $user = Ebh::app()->user->getloginuser();
        $this->assign('uid', $user['uid']);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
        $queryarr['folderid'] = $folderid;
        $queryarr['status'] = 1;
        // $queryarr['uid'] = $user['uid'];
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count);
        $sectionlist = array();
        foreach ($courses as $course) {
            if (empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
        $this->assign('sectionlist', $sectionlist);
        $this->assign('from', 1);
        $this->assign('pagestr', $pagestr);
        //分配folderid
        $this->assign('folderid', $folderid);
        //分配教室信息
        $this->assign('roominfo', $roominfo);
        //分配作业信息

        $this->display('myroom/myask_cwbox');
    }

    public function reward()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $askmodel = $this->model('askquestion');

        $qid = $this->input->post('qid');
        $detail = $askmodel->getdetailaskbyqid($qid);
        if ($detail['uid'] != $user['uid']) {
            echo json_encode(array('status' => 0, 'msg' => '没有操作权限'));
            exit;
        }
        if ($detail['isrewarded'] == 1) {
            echo json_encode(array('status' => 0, 'msg' => '该问题已经发放过悬赏积分'));
            exit;
        }
        $aids = $this->input->post('aids');
        $rewards = $this->input->post('rewards');
        if ($detail['reward'] != array_sum($rewards)) {
            log_message($user['uid'] . '试图修改悬赏分数');
            echo json_encode(array('status' => 0, 'msg' => '分配积分与悬赏积分不一致'));
            exit;
        }
        $credit = $this->model('credit');
        $askmodel->update(array('qid' => $qid, 'uid' => $user['uid'], 'isrewarded' => 1));
        echo json_encode(array('status' => 1, 'msg' => '悬赏完成'));
        fastcgi_finish_request();
        foreach ($rewards as $k => $reward) {
            // echo $aid;
            if ($reward > 0) {
                $credit->addCreditlog(array('ruleid' => 27, 'aid' => $aids[$k], 'credit' => $reward, 'qid' => $qid));

                //发送私信给回答者
                $answerers = $askmodel->getanswerer(array('qid' => $qid));
                foreach ($answerers as $value) {
                    $answerer_array[$value['aid']] = $value['uid'];
                }
                if (array_key_exists($aids[$k], $answerer_array)) {
                    $toid = $answerer_array[$aids[$k]];
                } else {
                    continue;
                }
                $type = 1;    //系统消息
                $msg = serialize(array(
                        'title' => $detail['title'],
                        'reward' => $reward
                    )
                );//由问题和积分组合
                Ebh::app()->lib('EMessage')->sendMessage(0, '系统管理员', $toid, $qid, $type, $msg);
            }
        }

    }

    //已解决(已经有最佳答案的)
    public function settled()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $askdate = $this->input->get('d');
        $aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
        $cwid = $this->input->get('cwid');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['shield'] = 0;
        $queryarr['aq'] = $aq;
        $queryarr['cwid'] = intval($cwid);
        $folderid = intval($folderid);
        if (!empty($folderid)) {
            $queryarr['folderid'] = $folderid;
        }
        if (!empty($askdate)) {    //过滤提问时间
            $asktime = strtotime($askdate);
            if ($asktime !== FALSE) {
                $queryarr['abegindate'] = $asktime;
                $queryarr['aenddate'] = $asktime + 86400;
            } else {
                $askdate = '';
            }
        }
        $queryarr['status'] = 1;
        $queryarr['hasbest'] = 1;
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();
        //更新评论用户状态时间
        $statemodel = $this->model('Userstate');
        $typeid = 2;
        $statemodel->insert($roominfo['crid'], $user['uid'], $typeid, SYSTIME);

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('aq', $aq);
        $this->assign('key', $key);
        $this->display('myroom/myask_settled');
        $this->_updateuserstate();
    }

    //热门(回答最多倒叙,却没有最佳答案的)
    public function hot()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $askdate = $this->input->get('d');
        $aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
        $cwid = $this->input->get('cwid');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['shield'] = 0;
        $queryarr['aq'] = $aq;
        $queryarr['cwid'] = intval($cwid);
        $folderid = intval($folderid);
        if (!empty($folderid)) {
            $queryarr['folderid'] = $folderid;
        }
        if (!empty($askdate)) {    //过滤提问时间
            $asktime = strtotime($askdate);
            if ($asktime !== FALSE) {
                $queryarr['abegindate'] = $asktime;
                $queryarr['aenddate'] = $asktime + 86400;
            } else {
                $askdate = '';
            }
        }
        $queryarr['status'] = 0;
        $queryarr['hasbest'] = 0;
        $queryarr['order'] = 'q.answercount desc';
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();
        //更新评论用户状态时间
        $statemodel = $this->model('Userstate');
        $typeid = 2;
        $statemodel->insert($roominfo['crid'], $user['uid'], $typeid, SYSTIME);

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('aq', $aq);
        $this->assign('key', $key);
        $this->display('myroom/myask_hot');
        $this->_updateuserstate();
    }

    //推荐(回答数最多倒叙)
    public function recommend()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $q = $this->input->get('q');
        $askdate = $this->input->get('d');
        $aq = $this->input->get('aq');
        $folderid = $this->input->get('fid');
        $cwid = $this->input->get('cwid');
        $queryarr = parsequery();
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['shield'] = 0;
        $queryarr['aq'] = $aq;
        $queryarr['cwid'] = intval($cwid);
        $folderid = intval($folderid);
        if (!empty($folderid)) {
            $queryarr['folderid'] = $folderid;
        }
        if (!empty($askdate)) {    //过滤提问时间
            $asktime = strtotime($askdate);
            if ($asktime !== FALSE) {
                $queryarr['abegindate'] = $asktime;
                $queryarr['aenddate'] = $asktime + 86400;
            } else {
                $askdate = '';
            }
        }
        $queryarr['order'] = 'q.answercount desc';
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getallasklist($queryarr);
        $count = $askmodel->getallaskcount($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();
        //更新评论用户状态时间
        $statemodel = $this->model('Userstate');
        $typeid = 2;
        $statemodel->insert($roominfo['crid'], $user['uid'], $typeid, SYSTIME);

        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('aq', $aq);
        $this->assign('key', $key);
        $this->display('myroom/myask_recommend');
        $this->_updateuserstate();
    }

    //等待回复(我没有回复过的)
    public function wait()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $aq = $this->input->get('aq');
        $q = $this->input->get('q');
        $folderid = $this->input->get('fid');
        $cwid = $this->input->get('cwid');
        $queryarr = parsequery();
        $queryarr['aq'] = $aq;
        $queryarr['crid'] = $roominfo['crid'];
        $queryarr['uid'] = $user['uid'];
        $queryarr['qshield'] = 0;
        $queryarr['ashield'] = 0;
        $queryarr['cwid'] = intval($cwid);
        $folderid = intval($folderid);
        if (!empty($folderid)) {
            $queryarr['folderid'] = $folderid;
        }
        $d = $this->input->get('d');
        if (!empty($d)) {
            $thetime = strtotime($d);
            if ($thetime !== FALSE) {
                $startdate = $thetime;
                $enddate = $thetime + 86400;
                $queryarr['startDate'] = $startdate;
                $queryarr['endDate'] = $enddate;
            }
        }
        $askmodel = $this->model('Askquestion');
        $asks = $askmodel->getasklistbynoanswers($queryarr);
        $count = $askmodel->getaskcountbynoanswers($queryarr);
        $pagestr = show_page($count);

        $key = $this->_getplaykey();

        $this->assign('aq', $aq);
        $this->assign('asks', $asks);
        $this->assign('pagestr', $pagestr);
        $this->assign('user', $user);
        $this->assign('crid', $roominfo['crid']);
        $this->assign('q', $q);
        $this->assign('d', $d);
        $this->assign('key', $key);
        $this->display('myroom/myask_wait');
    }

    //ajax上传图片
    public function uploadimg()
    {
        $askconfig = Ebh::app()->getConfig()->load('upconfig');
        $url = $askconfig['ask']['multipleserver'][0];
        $savepath = $askconfig['ask']['savepath'];
        $showpath = $askconfig['ask']['showpath'];
        $data = $_POST;
        $count = count($_POST) / 2;
        if ($count > 9) {
            echo json_encode(array('success' => false, 'message' => '上传图片不能超过9张！'));
        }
        $result = $this->do_post($url, $data);
        //返回的图片信息
        $imgarr = json_decode($result, 1);
        if ($imgarr['success']) {
            echo json_encode(array('data' => $imgarr['data'], 'success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => '上传失败，图片格式只支持jpg,jpeg,gif,png'));
        }
    }

    /**
     * ajax请求学生列表
     */
    function ajax_students()
    {
        $classid = intval($this->input->get('cid'));
        $page = max(intval($this->input->get('page')), 1);
        $q = trim($this->input->get('q'));
        $class_model = $this->model('classes');
        $params = array(
            'page' => $page,
            'pagesize' => 35,
            'order' => 'cs.classid asc,u.uid desc'
        );
        if ($classid > 0) {
            $params['classid'] = $classid;
        }
        if (!empty($q)) {
            $params['q'] = $q;
        }
        $students = $class_model->getClassStudentList($params);
        if (!empty($students)) {
            foreach ($students as &$student) {
                $show_name = !empty($student['realname']) ? $student['realname'] : $student['username'];
                $student['photo'] = getavater($student, '50_50');
                $student['shortname'] = shortstr($show_name, 8);
                if (strlen($show_name) > 8) {
                    $student['showname'] = $show_name;
                }
            }
            echo json_encode($students);
            exit();
        }
        echo 'null';
        exit();
    }

    function do_post($url, $data, $retJson = true)
    {
        $auth = Ebh::app()->getInput()->cookie('auth');
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //有文件上传
        if (!empty($data['upfile']) || !empty($data['Filedata'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {//无文件上传
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        //  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIE, 'ebh_auth=' . urlencode($auth) . ';ebh_domain=' . $domain);
        $ret = curl_exec($ch);
        curl_close($ch);
        if ($retJson == false) {
            $ret = json_decode($ret);
        }
        return $ret;
    }

    //检测语音的时长
    private function _checkAudioTime($audiosrc)
    {
        if (!empty($audiosrc)) {
            $GetId3 = Ebh::app()->lib('Getid3Lib');
            return $GetId3->analyze($audiosrc);
        }
    }

    //返回json数据获取比例

    /***
     * 获取问答百分比数据
     * @return
     */
    public function getRateToJson()
    {
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()
            ->user
            ->getloginuser();
        $return = Ebh::app()
            ->getApiServer('ebh')
            ->reSetting()
            ->setService('Study.Ask.getRate')
            ->addParams('uid', $user['uid'])
            ->addParams('realname', $user['realname'] ? $user['realname'] : $user['username'])
            ->addParams('sex', $user['sex'] == 0 ? 'man' : 'woman')
            ->addParams('crid', $roominfo['crid'])
            ->request();
        if ($return === false) {//请求数据失败处理
            $return['rate'] = array(
                'cNumber' => 0
            , 'notNumber' => 0
            , 'solveNumber' => 0
            , 'rewardNumber' => 0
            , 'praise' => 0
            , 'reward' => 0
            , 'username' => $user['realname'] ? $user['realname'] : $user['username']);
            $return['list'] = array();

        }

        renderjson(0, '获取成功', $return);
    }
}
