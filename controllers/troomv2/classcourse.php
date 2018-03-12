<?php
/**
 * 课件上传处理
 * @author eker
 */
class ClasscourseController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();

    }
    var $userlist = NULL;

    /**
     * 创建一个直播地址
     */
    public function addLive(){
        $submitat = strtotime($this->input->post('submitat'));
        $roominfo = Ebh::app()->room->getcurroom();
        $crid = $roominfo['crid'];
        $liveConfig = Ebh::app()->getConfig()->load('live');

        $rtmpServer = isset($liveConfig[$crid]) ? $liveConfig[$crid] : $liveConfig['default'];

        $liveLib = Ebh::app()->lib($rtmpServer,'Live');

        $liveInfo = $liveLib->createLive($submitat,365*24*3600);

        if(!$liveInfo){
            echo json_encode(array('status'=>0,'msg'=>'生成直播地址失败'));
            exit();
        }

        echo json_encode(array('status'=>1,'data'=>$liveInfo));
    }

    /**
     * 班级课程->上传课件
     */
    public function add() {
    	$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $systemsetting = Ebh::app()->room->getSystemSetting();
        $creditrule = isset($systemsetting['creditrule'])?$systemsetting['creditrule']:'';
        $coursewaresettings = json_decode($creditrule,true);
		$roomtype = Ebh::app()->room->getRoomType();
        //是否开启助教老师选项
        $assistant_enabled = true;
		$other_config = Ebh::app()->getConfig()->load('othersetting');
		$other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
		$other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
		$is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
		$is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
        if(NULL != $this->input->post('folderid')) {    //提交form表单
            $folderid = intval($this->input->post('folderid'));
            if($folderid <= 0){
            	return;
            }
			$this->checkpower($folderid);
            if($is_zjdlr){
               $tid = $this->input->post('tid');
               if(empty($tid)){
                return;
               }
            }
			if ($is_zjdlr) {
				$delaytime = intval($this->input->post('delaytime'));
				if ($delaytime < 0 || $delaytime > 99) {
					echo json_encode(array('status'=>0,'msg'=>'阅读间隔最大值不能超过99'));
					exit();
				}
			}

			if ($roomtype == 'edu') {
				$viewPower = intval($this->input->post('view_power'));
				if ($viewPower == 1) {
					$viewPowerClasses = $this->input->post('view_power_classes');
					if (!is_array($viewPowerClasses)) {
						echo json_encode(array('status'=>0,'msg'=>'请选择具有观看权限的班级'));
						exit();
					}
					$viewPowerClasses = array_map('intval', $viewPowerClasses);
					$viewPowerClasses = array_filter($viewPowerClasses, function($classid) {
						return $classid > 0;
					});
					if (empty($viewPowerClasses)) {
						echo json_encode(array('status'=>0,'msg'=>'请选择具有观看权限的班级'));
						exit();
					}
				}
			}
            $crid = $roominfo['crid'];
            $uid = $user['uid'];
            $isclass = 1;
            $title = $this->input->post('title');
            $tag = $this->input->post('tag');
            $cwtype = $this->input->post('cwtype');
            $logo = $this->input->post('logo');
            $logo = !empty($logo) ? $logo :"";
            $newsummary = $this->input->post('summary');
            $newmessage = $this->input->post('message');
            $rmessage = $this->input->post('rich_message');
            $message = !empty($message) ? $message : $rmessage;
            //过滤换行,回车等符号
            $summary= !empty($newsummary) ? str_replace("\r\n","",trim($newsummary)) : '';
            //上传文件处理 @eker 2016年1月28日11:37:31
            $uparr = $this->input->post('up');
            //直播类型
            $live_type = intval($this->input->post('live_type'));
			//指定答疑回答老师uid
			$askto = intval($this->input->post('askto'));
            /*
            //老的上传暂时注释，供新方法参考
            if(!empty($uparr['upfilename'])&&!empty($uparr['upfilepath']) && ($cwtype=='course')){
            	$upfilname = explode('.',$uparr['upfilename']);
            	$cwname = $upfilname[0].'.'.strtolower($upfilname[1]);
            	$urlinfo = explode(',', $uparr['upfilepath']);
            	$cwsource = $urlinfo[0];
            	$cwurl = $urlinfo[1];
            	$cwsize = $uparr['upfilesize'];
            	//有上传文件时，判断上传信息是否完整
            	if (empty($cwname) || empty($cwsource) || empty($cwurl) || empty($cwsize)){
            		echo json_encode(array('status'=>0,'msg'=>'添加失败'));
            		exit;
            	}
            }else{
            	$cwname = '';
            	$cwsource = '';
            	$cwurl = '';
            	$cwsize = '';
            }
            */
            $cwname = '';
            $cwsource = '';
            $cwurl = '';
            $cwsize = '';
            $cwlength = 0;
            $ism3u8 = 0;
            $m3u8url = '';
            $sourceid = 0;
            $ispreview = 0;
            $apppreview = 0;
            $checksum = '';
            $assistantid = '';//助教改为字符串存储
            $islive = $cwtype == 'live' ? 1: 0;
            if((!empty($uparr['sid']) && intval($uparr['sid'] > 0) && !empty($uparr['checksum'])) && ($islive != 1 || $live_type == 4)) {   //不为空说明有文件上传
                $sid = intval($uparr['sid']);
                $sourcemodel = $this->model('Source');
                $source = $sourcemodel->getFileBySid($sid);
                if(!empty($source) && $source['checksum'] == $uparr['checksum']) {  //存在则数据从source表中取
                    $cwname = empty($uparr['filename']) ? $source['filename'] : $uparr['filename'];
                    $cwsource = $source['source'];
                    $cwurl = $source['filepath'];
                    $cwsize = $source['filesize'];
                    $cwlength = $source['filelength'];
                    $ism3u8 = $source['ism3u8'];
                    if($ism3u8 == 1)
                        $m3u8url = $source['previewurl'];
                    $sourceid = $source['sid'];
                    $ispreview = $source['ispreview'];
                    $apppreview = $source['apppreview'];
                    $checksum = $source['checksum'];
                }
            }
			$status = empty($roominfo['checktype']) ? 1 : 0;
			$submitat = strtotime($this->input->post('submitat'));
			$endat = strtotime($this->input->post('endat'));
			$sectionid = intval($this->input->post('sectionid'));
			$coursemodel = $this->model('Courseware');
            $cdisplayorder = $coursemodel->getCurdisplayorder(array('crid'=>$crid,'sid'=>$sectionid,'folderid'=>$folderid));
            $cdisplayorder = $cdisplayorder == NULL ? 1000 :  ( $cdisplayorder - 1);


            $assistantidArr = array();
            if($islive) {

                if($live_type == 3){

                    $liveInfo = $this->input->post('liveInfo');

                    if(empty($liveInfo) || $liveInfo['liveid'] == ''){
                        echo json_encode(array('status'=>0,'msg'=>'请先生成推流地址'));
                        exit();
                    }

                    //如果直播类型等于3 设备直播 给一个持续较长的时间
                    $cwlength = 3600*24*365;
                }else{
                    $cwlength = intval($this->input->post('cwlength'));
                    $cwlength = $cwlength * 60;
                }

                $assistantidArrInput = $this->input->post('assistantid');
				if(!empty($assistantidArrInput)){
					foreach($assistantidArrInput as $assistantIdItem){
						if(intval($assistantIdItem) > 0){
							$assistantidArr[] = $assistantIdItem;
						}
					}
				}
            }
            $assistant = null;
            if ($assistant_enabled === true && is_array($assistantidArr) && count($assistantidArr) > 0) {
                //验证助教老师
                /*$assistant = $this->model('roomteacher')->getTeacherById($assistantid, $roominfo['crid']);
                if (empty($assistant)) {
                    $assistantid = 0;
                }*/
                $assistant = $this->model('roomteacher')->getTeachersByIds($assistantidArr, $roominfo['crid']);
                if(is_array($assistant) && count($assistant) > 0){
                    $assistantIdsArr = array();
                    foreach($assistant as $v){
                        $assistantIdsArr[] = $v['uid'];
                    }
                    $assistantArr = array();
                    foreach($assistantidArr as $v){
                        if(in_array($v,$assistantIdsArr)){
                            $assistantArr[] = $v;
                        }
                    }

                    $assistantid = implode(',',$assistantArr);
                }else{
                    $assistantid = '';
                }

            } else {
                $assistantid = '';
            }

            $open_chatroom = intval($this->input->post('open_chatroom'));


            //入课程表
            $param = array(
            		'crid'=>$crid,
            		'folderid'=>$folderid,
            		'uid'=>$uid,
            		'title'=>$title,
            		'tag'=>$tag,
                	'logo'=>$logo,
            		'summary'=>$summary,
            		'message'=>$message,
            		'cwname'=>$cwname,
            		'cwsource'=>$cwsource,
                	'cwurl'=>$cwurl,
            		'cwsize'=>$cwsize,
            		'isclass'=>$isclass,
            		'status'=>$status,
            		'cdisplayorder'=>$cdisplayorder,
                	'sid'=>$sectionid,
            		'submitat'=>$submitat,
            		'endat'=>$endat,
            		'islive'=>$islive,
                    'ism3u8'=>$ism3u8,
                    'm3u8url'=>$m3u8url,
                    'cwlength'=>$cwlength,
                    'sourceid'=>$sourceid,
                    'ispreview'=>$ispreview,
                    'apppreview'=>$apppreview,
                    'checksum'=>$checksum,
                    'assistantid' => $assistantid,
                    'open_chatroom' => $open_chatroom,
                    'live_type' =>  $live_type,
					'askto'=>$askto
            );
			if (!empty($viewPowerClasses)) {
				$param['classids'] = implode(',', $viewPowerClasses);
                if (strlen($param['classids']) > 512) {
                    echo json_encode(array('status' => 0, 'msg' => '班级数超过最大限制'));
                    exit();
                }
			}

            //添加直播课程
            if($islive == 1) {
                /*$livelib = Ebh::app()->lib('live');
                //$liveid = $livelib->createLive($user['username'],$user['realname'],$title,$submitat,$cwlength);
                $liveid = $livelib->createLiveId($submitat,$cwlength);
                if(!empty($liveid)) {   //将会议ID写入到课程表
                    $param['liveid'] = $liveid;
                    $param['endat'] = $submitat + $cwlength;
                } else {
                    echo json_encode(array('status'=>0,'msg'=>'添加失败'));
                    exit();
                }*/
                $liveConfig = Ebh::app()->getConfig()->load('live');

                $rtmpServer = isset($liveConfig[$crid]) ? $liveConfig[$crid] : $liveConfig['default'];
                if($live_type != 3){

                    $liveLib = Ebh::app()->lib($rtmpServer,'Live');

                    $liveInfo = $liveLib->createLive($submitat,$cwlength);
                }



                if(!$liveInfo){
                    echo json_encode(array('status'=>0,'msg'=>'添加失败'));
                    exit();
                }else{
                    $param['liveid'] = $liveInfo['liveid'];
                    $param['endat'] = $submitat + $cwlength;

                }

            }
			//单课收费信息，plate模板并且课程收费才有
			if(empty($viewPowerClasses) && $roominfo['template'] == 'plate' && $roominfo['isschool'] == 7){
				$folder = $this->model('folder')->getfolderbyid($folderid);
				if(!empty($folder) && $folder['fprice']!= 0){
					$param['cwpay'] = $this->input->post('cwpay');
					if(!empty($param['cwpay'])){
						$param['cprice'] = $this->input->post('cprice');
						$feepercent = $this->getfeepercent($roominfo['crid']);

						$param['comfee'] = $param['cprice']*$feepercent['compercent'];
						$param['roomfee'] = $param['cprice']*$feepercent['roompercent'];
						$monthorday = array('cmonth','cday');
						$bywhich = $this->input->post('bywhich');
						$param[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);
					}
				}
			}
			$delaytime = $this->input->post('delaytime');
			if ($delaytime !== null) {
			    $param['delaytime'] = intval($delaytime);
            }
            $cwid = $coursemodel->insert($param);
            if($cwid) {
                echo json_encode(array('status'=>1,'msg'=>'添加成功'));
                fastcgi_finish_request();	//添加成功，则直接返回前端输出
                if($islive == 1){
                    //更新直播信息表
                    $liveInfoModel = $this->model('Liveinfo');
                    $liveInfo['type'] = $rtmpServer;
                    //增加回看标识
                    $liveInfo['review'] = intval($this->input->post('review'));
                    //回看增加时间限制
                    if($liveInfo['review'] == 1){
						$review_start = $this->input->post('review_start');
                        $review_end = $this->input->post('review_end');
                        $liveInfo['review_start'] = !empty($review_start) ? strtotime($this->input->post('review_start')) : 0;
                        $liveInfo['review_end'] = !empty($review_end) ? strtotime($this->input->post('review_end')) : 0;
                    }
                    $liveInfoModel->addLiveInfo($cwid,$liveInfo);
                }
                $foldermodel = $this->model('Folder');
                $param['folderid'] = $folderid;
                $param['crid'] = $roominfo['crid'];
                $param['teacherids'] = $assistantidArr;
                $foldermodel->addteacher($param);
				$folder = $foldermodel->getfolderbyid($folderid);
				$logname = !empty($folder['foldername']) ? $folder['foldername'] : '';
				$folderlevel = $folder['folderlevel'];
				while($folderlevel>1){
					$foldermodel->addcoursenum($folderid);
					$folder = $foldermodel->getfolderbyid($folder['upid']);
					$folderlevel = $folder['folderlevel'];
					$folderid = $folder['folderid'];
				}
                if($is_zjdlr){//国土资源厅
                    $toid = $this->input->get('toid');
                    $cwModel = $this->model('courseware');
                    $cwModel->addcwusers($tid,$cwid,$toid);
                }
                $roommodel = $this->model('Classroom');
                $roommodel->addcoursenum($roominfo['crid']);

				// $this->previewSwf($cwid,$cwurl);	//将doc/ppt/xls/pdf文件转换成可预览swf格式
				// //$this->rtmpFlv($cwid,$cwurl);	//处理flv视频
				// $this->m3u8Flv($cwid,$cwurl);	//处理m3u8视频
                $this->doPreview($cwid,$cwurl); //将doc/ppt/xls/pdf和视频文件转换成可预览格式格式
				$credit = $this->model('credit');
				$credit->addCreditlog(array('ruleid'=>31,'cwid'=>$cwid));
				Ebh::app()->lib('PushUtils')->PushCourseToStudent($cwid);//信鸽推送
                Ebh::app()->lib('ThirdPushUtils')->PushCourseToStudent($cwid);//第三方推送
                $param['toid'] = intval($cwid);
                $param['cprice'] = isset($param['cprice']) ? $param['cprice'] : 0;
                $param['foldername'] = $logname;
                Ebh::app()->lib('OperationLog')->addLog($param,'addcw');//操作成功记录到操作日志
            } else {
                echo json_encode(array('status'=>0,'msg'=>'添加失败'));
            }

        } else {
            $folderid = intval($this->uri->uri_attr(0));
            if ($roomtype == 'edu') {
                //获取用户任教班级
                $api = Ebh::app()->getApiServer('ebh');
                $classes = $api->reSetting()
                    ->setService('Organization.ClassTeacher.getClassesForTeacher')
                    ->addParams('crid', $roominfo['crid'])
                    ->addParams('uid', $user['uid'])
                    ->request();
                $this->assign('classes', $classes);
				
				//课程的老师
				$askteacherlist = $this->model('folder')->getFolderTeacherByCrid($folderid,$roominfo['crid']);
				$this->assign('askteacherlist',$askteacherlist);
            }
            $this->assign('folderid', $folderid);
            $cwtype = $this->uri->uri_attr(1);
            $foldermodel = $this->model('folder');
            $subfolder = $foldermodel->getSubFolder($roominfo['crid'],$folderid);
            $user = Ebh::app()->user->getloginuser();
            if(!empty($subfolder)){
            	header('location:'.geturl('troomv2/classsubject/'.$folderid));
            	exit;
            }
            if ($assistant_enabled === true) {
                $grouparray = $this->model('teacher')->getTeachersGroupBy($roominfo['crid'], $user['uid'], true);
            }
            if($is_zjdlr){//国土资源厅
                $class_model = $this->model('classes');
                $classes = $class_model->getroomClassList($roominfo['crid']);
                array_unshift($classes, array(
                            'classid' => -1,
                            'classname' => '管理员',
                            'stunum' => 1,
                            'grade' => 0,
                            'headteacherid' => 0
                ));
                if (!empty($classes)) {
                    $first_class = current($classes);
                    $students[0] = $user;
                    $this->assign('student',$user);
                    $this->assign('classes', $classes);
                    $this->assign('students', $students);
                }
            }
			if (isset($coursewaresettings['notvideo']['needtime'])) {
				$this->assign('delaytime', $coursewaresettings['notvideo']['needtime']);
			}
            $upcontrol = Ebh::app()->lib('UpcontrolLib');
            $editor = Ebh::app()->lib('UEditor');
            $foldermodel = $this->model('Folder');
            $folder = $foldermodel->getfolderbyid($folderid);
            $this->assign('folder', $folder);
            $this->assign('iszjdlr',$is_zjdlr);
            $this->assign('isnewzjdlr',$is_newzjdlr);
            $this->assign('upcontrol', $upcontrol);
            $this->assign('editor', $editor);
            $this->assign('roominfo',$roominfo);
            $this->assign('grouparray',$grouparray);
            $this->assign('assistant_enabled', $assistant_enabled);
            $this->assign('user',$user);
            $this->assign('cwtype',$cwtype);//live 直播课件  course 普通课件
			$this->assign('roomtype', $roomtype);
            //课件类别 写入cookie
            $this->input->setcookie('cwtype',$cwtype);

			//单课收费信息，plate模板并且课程收费才有
			if($roominfo['template'] == 'plate' && $roominfo['isschool'] == 7 && !empty($folder) && $folder['fprice'] != 0){
				$this->assign('cwpay',true);
			}
            if($is_zjdlr){
                $toid = $this->input->get('toid');
                if(empty($toid)){
                    $this->display('troomv2/classcourse_add');
                }else{
                    $this->display('troomv2/classcourse_add_news');
                }
            }else{
                $this->display('troomv2/classcourse_add');
            }
        }
    }

    /**
     * 编辑课件
     * @author eker
     */
    public function edit() {
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$roomtype = Ebh::app()->room->getRoomType();
		$other_config = Ebh::app()->getConfig()->load('othersetting');
		$other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
		$other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
		$is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
		$is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);
        //是否开启助教老师选项
        $assistant_enabled = true;
        if (NULL != $this->input->post('cwid')) {
            $cwid = $this->input->post('cwid');
			$cwid = intval($cwid);
            if ($is_zjdlr) {
                $delaytime = intval($this->input->post('delaytime'));
                if ($delaytime < 0 || $delaytime > 99) {
                    echo json_encode(array('status'=>0,'msg'=>'阅读间隔最大值不能超过99'));
                    exit();
                }
            }
            if(is_numeric($cwid) && $cwid > 0) {
                $coursemodel = $this->model('Courseware');
                $course = $coursemodel->getcoursedetail($cwid);
                if(empty($course) || $roominfo['crid'] != $course['crid']
                || (!empty($roominfo['checktype']) && $course['status'] == 1)){
                	return ;
                }
                if($course['uid'] != $user['uid'])
                    return;

                $title = $this->input->post('title');
                $tag = $this->input->post('tag');
                $logo = $this->input->post('logo');
                $logo = !empty($logo) ? $logo : "";
                $newsummary = $this->input->post('summary');
                //过滤换行,回车等符号
                $summary= !empty($newsummary) ? str_replace("\r\n","",trim($newsummary)) : '';

                $message = $this->input->post('message');
                $rmessage = $this->input->post('rich_message');
                $message = !empty($message)?$message:$rmessage;
                $cwtype = $this->input->post('cwtype');

                //直播类型
                $live_type = intval($this->input->post('live_type'));
				//指定答疑回答老师uid
                $askto = intval($this->input->post('askto'));


                //上传处理
                $sectionid = intval($this->input->post('sectionid'));

                $status = empty($roominfo['checktype']) ? 1 : 0;

                $open_chatroom = intval($this->input->post('open_chatroom'));
				if ($roomtype == 'edu') {
                    $viewPower = intval($this->input->post('view_power'));
                    if ($viewPower == 1) {
                        $viewPowerClasses = $this->input->post('view_power_classes');
                        if (!is_array($viewPowerClasses)) {
                            echo json_encode(array('status' => 0, 'msg' => '请选择具有观看权限的班级'));
                            exit();
                        }
                        $viewPowerClasses = array_map('intval', $viewPowerClasses);
                        $viewPowerClasses = array_filter($viewPowerClasses, function ($classid) {
                            return $classid > 0;
                        });
                        if (empty($viewPowerClasses)) {
                            echo json_encode(array('status' => 0, 'msg' => '请选择具有观看权限的班级'));
                            exit();
                        }
                        $viewPowerClassIds = implode(',', $viewPowerClasses);
                        if (strlen($viewPowerClassIds) > 512) {
                            echo json_encode(array('status' => 0, 'msg' => '班级数超过最大限制'));
                            exit();
                        }
                    }
                }
                //组装数据
                $param = array(
                    'title'=>$title,
                    'tag'=>$tag,
                    'logo'=>$logo,
                    'summary'=>$summary,
                    'message'=>$message,
                    'sid'=>$sectionid,
                    'status'=>$status,
                    'open_chatroom'=>$open_chatroom,
                    'live_type' =>  $live_type,
					'askto'=>$askto
                    // 'cwname'=>$cwname,
                    // 'cwsource'=>$cwsource,
                    // 'cwurl'=>$cwurl,
                    // 'cwsize'=>$cwsize,
                    // 'cwlength'=>$cwlength,
                    // 'ism3u8'=>$ism3u8,
                    // 'm3u8url'=>$m3u8url,
                    // 'sourceid'=>$sourceid,
                    // 'ispreview'=>$ispreview,
                    // 'apppreview'=>$apppreview,
                    // 'thumb'=>$thumb,
                    // 'checksum'=>$checksum
                );
                $delaytime = $this->input->post('delaytime');
                if ($delaytime !== null) {
                    $param['delaytime'] = intval($delaytime);
                }
				if($sectionid != $course['sid']){
					$cdisplayorder = $coursemodel->getCurdisplayorder(array('crid'=>$roominfo['crid'],'sid'=>$sectionid,'folderid'=>$course['folderid']));
					$cdisplayorder = $cdisplayorder == null?1000:$cdisplayorder-1;
					$param['cdisplayorder'] = $cdisplayorder;
				}
                $uparr = $this->input->post('up');
                if((!empty($uparr['sid']) && intval($uparr['sid'] > 0) && !empty($uparr['checksum']))  &&  ($course['islive'] != 1 || $live_type == 4)) {   //不为空说明有文件上传
                    $sid = intval($uparr['sid']);
                    $sourcemodel = $this->model('Source');
                    $source = $sourcemodel->getFileBySid($sid);
                    if(!empty($source) && $source['checksum'] == $uparr['checksum']) {  //存在则数据从source表中取
                        $cwname = empty($uparr['filename']) ? $source['filename'] : $uparr['filename'];
                        $cwsource = $source['source'];
                        $cwurl = $source['filepath'];
                        $cwsize = $source['filesize'];
                        $cwlength = $source['filelength'];
                        $ism3u8 = $source['ism3u8'];
                        if($ism3u8 == 1)
                            $m3u8url = $source['previewurl'];
                        $sourceid = $source['sid'];
                        $ispreview = $source['ispreview'];
                        $apppreview = $source['apppreview'];
                        $thumb = $source['thumb'];
                        $checksum = $source['checksum'];
                        $param['cwname'] = $cwname;
                        $param['cwsource'] = $cwsource;
                        $param['cwurl'] = $cwurl;
                        $param['cwsize'] = $cwsize;
                        $param['cwlength'] = $cwlength;
                        $param['ism3u8'] = $ism3u8;
                        $param['m3u8url'] = empty($m3u8url)?'':$m3u8url;
                        $param['sourceid'] = $sourceid;
                        $param['ispreview'] = $ispreview;
                        $param['apppreview'] = $apppreview;
                        $param['thumb'] = $thumb;
                        $param['checksum'] = $checksum;
                    }
                }
				if (!empty($viewPowerClasses)) {
					$param['classids'] = implode(',', $viewPowerClasses);
				} else {
					$param['classids'] = '';
				}
                $assistantid = '';
                $assistantidArr = array();
				if($course['islive'] == 1) {    //直播课的处理
                    $submitat = strtotime($this->input->post('submitat'));


                    if($live_type == 3){

                        $liveInfo = $this->input->post('liveInfo');

                        if(empty($liveInfo) || $liveInfo['liveid'] == ''){
                            echo json_encode(array('status'=>0,'msg'=>'请先生成推流地址'));
                            exit();
                        }

                        //如果直播类型等于3 设备直播 给一个持续较长的时间
                        $cwlength = 3600*24*365;
                    }else{
                        if($live_type != 4) {
                            $cwlength = intval($this->input->post('cwlength')) * 60;
                        }
                    }

                    $assistantidArrInput = $this->input->post('assistantid');
					if(!empty($assistantidArrInput)){
						foreach($assistantidArrInput as $assistantIdItem){
							if(intval($assistantIdItem) > 0){
								$assistantidArr[] = $assistantIdItem;
							}
						}
					}

                    /*$livelib = Ebh::app()->lib('live');
                    if($submitat != $course['submitat'] || $cwlength != $course['cwlength']) {  //如果时间有变化则需要重新创建会议
                        //$liveid = $livelib->createLive($user['username'],$user['realname'],$title,$submitat,$cwlength);
                        $liveid =  $livelib->createLiveId($submitat,$cwlength);
                        if(!empty($liveid)) {   //将会议ID写入到课程表
                            $param['liveid'] = $liveid;
                            $param['submitat'] = $submitat;
                            $param['cwlength'] = $cwlength;
                            $param['endat'] = $submitat + $cwlength;
                            $param['truedateline'] = $submitat;
                        } else {
                            echo json_encode(array('status'=>0,'msg'=>'添加失败'));
                            exit();
                        }
                    }*/
                    $liveInfoModel = $this->model('Liveinfo');
                    /*
                    if($submitat != $course['submitat'] || $cwlength != $course['cwlength'] || $live_type == 3) {  //如果时间有变化则需要重新创建会议
                        $crid = $roominfo['crid'];
                        $liveConfig = Ebh::app()->getConfig()->load('live');

                        $rtmpServer = isset($liveConfig[$crid]) ? $liveConfig[$crid] : $liveConfig['default'];

                        if($live_type != 3){

                            $liveLib = Ebh::app()->lib($rtmpServer,'Live');

                            $liveInfo = $liveLib->createLive($submitat,$cwlength);
                        }


                        if(!$liveInfo){
                            echo json_encode(array('status'=>0,'msg'=>'修改失败'));
                            exit();
                        }else{
                            $param['liveid'] = $liveInfo['liveid'];
                            $param['submitat'] = $submitat;
                            //编辑时伪直播不取时间
                            if($live_type != 4){
                                $param['cwlength'] = $cwlength;
                            }

                            $param['endat'] = $submitat + $cwlength;
                            $param['truedateline'] = $submitat;
                            //更新直播信息表
                            $liveInfo['type'] = $rtmpServer;
                            //增加回看标识
                            $liveInfo['review'] = intval($this->input->post('review'));
                            //回看增加时间限制
                            if($liveInfo['review'] == 1){
								$review_start = $this->input->post('review_start');
                                $liveInfo['review_start'] = !empty($review_start) ? strtotime($this->input->post('review_start')) : 0;
                                $liveInfo['review_end'] = !empty($review_start) ? strtotime($this->input->post('review_end')) : 0;
                            }
                            if(($course['liveid'] != $liveInfo['liveid'] ) && $live_type != 4 ) {
                                //liveid变化 清空原来的信息 或者回看被关闭
                                $liveInfo['camera_sourceid'] = 0;
                                $liveInfo['video_sourceid'] = 0;

                                //清空课件中的信息
                                $param['cwname'] = '';
                                $param['cwsource'] = '';
                                $param['cwurl'] = '';
                                $param['cwsize'] = 0;
                                //$param['cwlength'] = 0;
                                $param['ism3u8'] = 0;
                                $param['m3u8url'] = '';
                                $param['sourceid'] = 0;
                                $param['ispreview'] = 0;
                                $param['apppreview'] = 0;
                                $param['thumb'] = '';
                                $param['checksum'] = '';
                            }
                            $liveInfoModel->addLiveInfo($cwid,$liveInfo);

                        }
                    }else{
                        */
                        //注释掉liveid变化
                        $param['submitat'] = $submitat;
                        //编辑时伪直播不取时间
                        if($live_type != 4){
                            $param['cwlength'] = $cwlength;
                        }

                        $param['endat'] = $submitat + $cwlength;
                        $param['truedateline'] = $submitat;
                        //时间没变
                        //增加回看标识
                        $liveInfo['review'] = intval($this->input->post('review'));
                        //回看增加时间限制
                        if($liveInfo['review'] == 1){
							$review_start = $this->input->post('review_start');
                            $review_end = $this->input->post('review_end');
                            $liveInfo['review_start'] = !empty($review_start) ? strtotime($this->input->post('review_start')) : 0;
                            $liveInfo['review_end'] = !empty($review_end) ? strtotime($this->input->post('review_end')) : 0;
                        }
                        $liveInfoModel->addLiveInfo($cwid,$liveInfo);
                    //}

                }



                if ($assistant_enabled === true && is_array($assistantidArr) && count($assistantidArr) > 0) {
                    //验证助教老师
                    /*$assistant = $this->model('roomteacher')->getTeacherById($assistantid, $roominfo['crid']);
                    if (empty($assistant)) {
                        $assistantid = 0;
                    }*/
                    $assistant = $this->model('roomteacher')->getTeachersByIds($assistantidArr, $roominfo['crid']);

                    if(is_array($assistant) && count($assistant) > 0){
                        $assistantIdsArr = array();
                        foreach($assistant as $v){
                            $assistantIdsArr[] = $v['uid'];
                        }
                        $assistantArr = array();
                        foreach($assistantidArr as $v){
                            if(in_array($v,$assistantIdsArr)){
                                $assistantArr[] = $v;
                            }
                        }

                        $assistantid = implode(',',$assistantArr);
                    }else{
                        $assistantid = '';
                    }

                } else {
                    $assistantid = '';
                }
                $param['assistantid'] = $assistantid;
                if($is_zjdlr){//国土资源厅
                    $tid = $this->input->post('tid');
                    $toid = $this->input->get('toid');
                    if(empty($toid)){
                        $toid = 0;
                    }
                    $coursemodel->updatecwuser($tid,$cwid,$toid);
                }
				//单课收费信息，plate模板并且课程收费才有
				if(empty($viewPowerClasses) && $roominfo['template'] == 'plate' && $roominfo['isschool'] == 7){
					$folder = $this->model('folder')->getfolderbyid($course['folderid']);
					if(!empty($folder) && $folder['fprice']!= 0){
						$param['cwpay'] = $this->input->post('cwpay');
						if(!empty($param['cwpay'])){
							$param['cprice'] = $this->input->post('cprice');
							if($course['roomfee'] == 0 && $course['comfee'] == 0){//上一次没有分成信息,按照总后台设置的分成比例来
								$feepercent = $this->getfeepercent($roominfo['crid']);
							}else{//上一次有分成信息,按上一次的比例来
								$feepercent['compercent'] = $course['comfee']/$course['cprice'];
								$feepercent['roompercent'] = 1 - $feepercent['compercent'];
							}
							$param['comfee'] = $param['cprice']*$feepercent['compercent'];
							$param['roomfee'] = $param['cprice']-$param['comfee'];
							$monthorday = array('cmonth','cday');
							$bywhich = $this->input->post('bywhich');
							$param[$monthorday[$bywhich]] = $this->input->post($monthorday[$bywhich]);
							$param[$monthorday[1-$bywhich]] = 0;
						}
					}
				}
				if (!empty($viewPowerClasses)) {
				    $param['cwpay'] = 0;
                }

                $wherearr = array('cwid'=>$course['cwid'],'crid'=>$course['crid']);
                $result = $coursemodel->update($param,$wherearr);
                if($result !== FALSE) {
                    //修改直播群聊的配置
                    $redis = Ebh::app()->getCache('cache_redis');
                    $redis->remove('chatroom_'.$cwid.'_config','issetgag');
                    if($course['islive'] == 1){
                        //如果设置为开启取消禁言状态
                        if($open_chatroom == 0){
                            $redis->hset('chatroom_'.$cwid.'_config','gag',0);
                        }
                    }else{
                        //如果设置为开启取消禁言状态
                        if($open_chatroom == 1){
                            $redis->hset('chatroom_'.$cwid.'_config','gag',0);
                        }
                    }

                    $folder = $this->model('folder');
                    $param['folderid'] = $course['folderid'];
                    $param['crid'] = $roominfo['crid'];
                    $param['teacherids'] = $assistantidArr;
                    $folder->addteacher($param);

                    echo json_encode(array('status'=>1,'msg'=>'修改成功'));
                    fastcgi_finish_request();	//修改成功，则直接返回前端输出
                    if(empty($sid) === false && $sid != $course['sourceid']) {	//如果编辑了课件文件，则重新生成预览文件
						// $this->previewSwf($cwid,$cwurl);	//将doc/ppt/xls/pdf文件转换成可预览swf格式
						// //$this->rtmpFlv($cwid,$cwurl);	//处理flv视频
						// $this->m3u8Flv($cwid,$cwurl);	//处理m3u8视频
                        $this->doPreview($cwid,$cwurl); //将doc/ppt/xls/pdf和视频文件转换成可预览格式格式
					}
					if(!empty($roominfo['checktype']) && $course['status'] == -2){
						$billcheck = $this->model('billchecks');
						$billcheck->updateTeacher(array('toid'=>$cwid,'type'=>1,'teach_status'=>0));
					}
					if(isset($course['cprice']) && !empty($course['foldername']) && !empty($course['cwid'])){
					    $params = $param;
                        $params['toid'] = intval($course['cwid']);
                        $params['cprice'] = isset($params['cprice']) ? intval($params['cprice']) : 0;
                        $params['ipriceold'] = isset($course['cprice']) ? intval($course['cprice']) : 0;
                        $params['titleold'] = !empty($course['title']) ? $course['title'] : 0;
                        $params['foldername'] = $course['foldername'];
                        if(($params['ipriceold'] != $params['cprice']) || ($params['titleold'] != $params['title'])){
                            Ebh::app()->lib('OperationLog')->addLog($params,'editcw');//操作成功记录到操作日志
                        }
                    }
                    exit();
                } else {
                    echo json_encode(array('status'=>0,'msg'=>'修改失败'));
                }
            }
        } else {
            $cwid = $this->uri->uri_attr(0);
            $cwtype = $this->uri->uri_attr(1);
            if(is_numeric($cwid)) {
                $coursemodel = $this->model('Courseware');
                $course = $coursemodel->getcoursedetail($cwid);
                if(empty($course) || $roominfo['crid'] != $course['crid'] || (!empty($roominfo['checktype']) && $course['status'] == 1))
                    exit;
                if ($assistant_enabled === true) {
                    $grouparray = $this->model('teacher')->getTeachersGroupBy($roominfo['crid'], $user['uid'], true);
                }

                /*if ($course['assistantid'] > 0) {
                    if ($assistant = $this->model('user')->getuserbyuid($course['assistantid'])) {
                        $course['assistant'] = empty($assistant['realname']) === false ?
                            $assistant['realname'] : $assistant['username'];
                    }
                }*/
                $course['assistant'] = array();
                if($course['assistantid'] != 0 && $course['assistantid'] != ''){
                    $assistantidArr = explode(',',$course['assistantid']);
                    if(count($assistantidArr) > 0 && is_array($assistantidArr)){
                        $course['assistant'] = $this->model('roomteacher')->getTeachersByIds($assistantidArr, $roominfo['crid']);
                    }
                }
                if($is_zjdlr){//国土资源厅//国土资源厅则读取所指定的学生

                    $userinfo = $coursemodel->getcwUserinfo($cwid);
                    if(!empty($userinfo)){
                        $this->assign('userinfo',$userinfo);
                    }else{
                        $this->assign('userinfo',array());
                    }
                    $class_model = $this->model('classes');
                    $classes = $class_model->getroomClassList($roominfo['crid']);
                    array_unshift($classes, array(
                                'classid' => -1,
                                'classname' => '管理员',
                                'stunum' => 1,
                                'grade' => 0,
                                'headteacherid' => 0
                    ));
                    if (!empty($classes)) {
                        $first_class = current($classes);
                        $students[0] = $user;
                        $this->assign('student',$user);
                        $this->assign('classes', $classes);
                        $this->assign('students', $students);
                    }

					$systemsetting = Ebh::app()->room->getSystemSetting();
					$coursewaresettings = json_decode($systemsetting['creditrule'], true);
					if (empty($course['delaytime']) && !empty($coursewaresettings['notvideo']['needtime'])) {
						$course['delaytime'] = $coursewaresettings['notvideo']['needtime'];
					}
                }

                //如果是直播课件 读取出直播信息
                if($course['islive'] == 1){
                    $liveInfoModel = $this->model('Liveinfo');
                    $liveInfo = $liveInfoModel->getLiveInfoByCwid($cwid);

                    $this->assign('liveInfo',$liveInfo);
                }
				if ($roomtype == 'edu') {
					//获取用户任教班级
					$api = Ebh::app()->getApiServer('ebh');
					$classes = $api->reSetting()
						->setService('Organization.ClassTeacher.getClassesForTeacher')
						->addParams('crid', $roominfo['crid'])
						->addParams('uid', $user['uid'])
						->request();
					$this->assign('classes', $classes);
					if (!empty($course['classids'])) {
						$course['classids'] = explode(',', $course['classids']);
						$course['classids'] = array_flip($course['classids']);
                        $course['classids'] = array_intersect_key($classes, $course['classids']);
					}
					//课程的老师
					$askteacherlist = $this->model('folder')->getFolderTeacherByCrid($course['folderid'],$roominfo['crid']);
					$this->assign('askteacherlist',$askteacherlist);
				}
                $folderid = $course['folderid'];
                $upcontrol = Ebh::app()->lib('UpcontrolLib');
                $editor = Ebh::app()->lib('UEditor');
                $foldermodel = $this->model('Folder');
                $folder = $foldermodel->getfolderbyid($folderid);
                $this->assign('folderid', $folderid);
                $this->assign('course', $course);
                $this->assign('folder', $folder);
                $this->assign('upcontrol', $upcontrol);
                $this->assign('editor', $editor);
                $this->assign('user',$user);
                $this->assign('roominfo',$roominfo);
                $this->assign('iszjdlr',$is_zjdlr);
                $this->assign('isnewzjdlr',$is_newzjdlr);
				$this->assign('roomtype',$roomtype);
                if ($assistant_enabled === true) {
                    $this->assign('grouparray', $grouparray);
                }
                $this->assign('assistant_enabled', $assistant_enabled);
                $this->assign('cwtype',$cwtype);//live 直播课件  course 普通课件
				//单课收费信息，plate模板并且课程收费才有
				if($roominfo['template'] == 'plate' && $roominfo['isschool'] == 7 && !empty($folder) && $folder['fprice'] != 0){
					$this->assign('cwpay',true);
				}

                if($is_zjdlr){
                    $this->assign('toid',$userinfo['toid']);
                    if(empty($userinfo['toid'])){
                        $this->display('troomv2/classcourse_edit');
                    }else{
                        $this->display('troomv2/classcourse_edit_news');
                    }
                }else{
                    $this->display('troomv2/classcourse_edit');
                }
            }
        }
    }
    public function view() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
        $cwid = $this->uri->itemid;
        if(empty($cwid)){
        	$cwid = intval($this->uri->uri_attr(0));
        }
        $recuid = intval($this->uri->uri_attr(1));
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		$astatus = in_array($course['status'],array(0,1,-2));
		$bstatus = in_array($course['status'],array(0,-2));
		if(empty($course) || !$astatus || ($bstatus && $course['uid'] != $user['uid']))
			exit();
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		$source = '';
		if(!empty($course)) {	//生成课件所在服务器地址
			$serverutil = Ebh::app()->lib('ServerUtil');
			$source = $serverutil->getCourseSource();
			if(!empty($source)) {
				$course['cwsource'] = $source;
			}
		}
        $this->assign('course', $course);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
		//单个课件下的作业
		$exammodel  = $this->model('exam');
		if(!empty($recuid)){
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$recuid,'limit'=>'0,100');
		}else{
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'limit'=>'0,100');
		}
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamonlinelist($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		$this->assign('exams',$exams);
		//课件评论
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		//$pagestr = $this->_show_page($count,1,10);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('roominfo', $roominfo);
		$this->assign('user',$user);
        $this->assign('reviews', $reviews);
		$this->assign('pagestr', $pagestr);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		$this->assign('type',$type);
		if($type == 'flv'){
			$this->display('troomv2/course_view');
		}else{
			$this->display('troomv2/classcourse_view');
		}
    }
	/**
	*删除作业
	*/
	public function delexam() {
		$cwid = $this->input->post('cwid');
        if($cwid == NULL || !is_numeric($cwid) || $cwid <= 0) {
            echo json_encode(array('status'=>-1,'msg'=>'参数非法'));
            exit();
        }
		$eid = $this->input->post('eid');
        if($eid == NULL || !is_numeric($eid) || $eid <= 0) {
            echo json_encode(array('status'=>-1,'msg'=>'参数非法'));
            exit();
        }
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'eid'=>$eid);
		$exammodel = $this->model('Exam');
		$exam = $exammodel->getexamlistbycwid($param);
		if(empty($exam)) {
			echo json_encode(array('status'=>-1,'msg'=>'权限不足'));
            exit();
		}
		$result = $exammodel->delexambyeid($eid);
		if($result) {
			$coursemodel = $this->model('Courseware');
			$coursemodel->addexamnum($cwid,-1);
			echo json_encode(array('status'=>1));
            exit();
		} else {
			echo json_encode(array('status'=>0,'msg'=>'删除失败'));
            exit();
		}
	}

	//ajax的评论分页
	function getajaxpage(){
		$queryarr['pagesize'] = 10;
        $queryarr['cwid'] = $this->input->post('cwid');
		$queryarr['page'] = $this->input->post('page');
		$reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);

		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//数据格式化 时间和头像缩略图
		foreach($reviews as &$review){
			$review['dateline'] = date('Y-m-d H:i:s', $review['dateline']);
			if ($review['sex'] == 1){
				if($review['groupid']==5){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
				}else{
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
				}
			}else{
				if($review['groupid']==5){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
				}else{
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
				}
			}
			$face = empty($review['face']) ? $defaulturl : $review['face'];
			$face = getthumb($face, '50_50');
			$review['face'] =$face;
		}

		//json输出
		echo json_encode(array("reviews"=>$reviews,'pagestr'=>$pagestr));
	}

	/**
	 * 获取分页html代码
	 *	重写common下的show_page函数
	 * @param int $listcount总记录数
	 * @param int $pagesize分页大小
	 * @return string
	 */
	private function _show_page($listcount, $curpage,$pagesize = 20) {
		//print_r($listcount.$curpage.$pagesize);
		$pagecount = @ceil($listcount / $pagesize);

		if ($curpage > $pagecount) {
			$curpage = $pagecount;
		}
		if ($curpage < 1) {
			$curpage = 1;
		}
		//这里写前台的分页
		$centernum = 10; //中间分页显示链接的个数
		$multipage = '<div class="pages" style="padding-top:0px;"><div class="listPage">';
		if ($pagecount <= 1) {
			$back = '';
			$next = '';
			$center = '';
		//	$gopage = '';
		} else {
			$back = '';
			$next = '';
			$center = '';
//			$gopage = '<input id="gopage" maxpage="' . $pagecount . '" onblur="if($(this).val()>' . $pagecount . '){$(this).val(' .
//					$pagecount . ')}" type="text" size="3" value="" onfocus="this.select();"  onkeyup="this.value=this.value.replace(/\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\D/g,\'\')"><a id="page_go" >跳转</a>';
			if ($curpage == 1) {
				for ($i = 1; $i <= $centernum; $i++) {
					if ($i > $pagecount) {
						break;
					}
					if ($i != $curpage) {
						$center .= '<a >' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
				$next .= '<a  id="next">下一页&gt;&gt;</a>';
			} elseif ($curpage == $pagecount) {
				$back .= '<a  id="next">&lt;&lt;上一页</a>';
				for ($i = $pagecount - $centernum + 1; $i <= $pagecount; $i++) {
					if ($i < 1) {
						$i = 1;
					}
					if ($i != $curpage) {
						$center .= '<a>' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
			} else {
				$back .= '<a  id="next">&lt;&lt;上一页</a>';
				$left = $curpage - floor($centernum / 2);
				$right = $curpage + floor($centernum / 2);
				if ($left < 1) {
					$left = 1;
					$right = $centernum < $pagecount ? $centernum : $pagecount;
				}
				if ($right > $pagecount) {
					$left = $centernum < $pagecount ? ($pagecount - $centernum + 1) : 1;
					$right = $pagecount;
				}
				for ($i = $left; $i <= $right; $i++) {
					if ($i != $curpage) {
						$center .= '<a >' . $i . '</a>';
					} else {
						$center .= '<a class="none">' . $i . '</a>';
					}
				}
				$next .= '<a  id="next">下一页&gt;&gt;</a>';
			}
		}
		$multipage .= $back . $center . $next . '</div></div>';
//		$multipage .= '<script type="text/javascript">' . "\n"
//				. '$(function(){' . "\n"
//				. '$("#gopage").keypress(function(e){' . "\n"
//				. 'if (e.which == 13){' . "\n"
//				. '$(this).next("#page_go").click()' . "\n"
//				. 'cancelBubble(this,e);' . "\n"
//				. '}' . "\n"
//				. '})' . "\n"
//				. '})</script>';
		return $multipage;

	}

    /**
     * 删除课件
     */
    public function del() {
        $cwid = $this->input->post('cwid');
        if($cwid == NULL || !is_numeric($cwid)) {
            echo json_encode(array('status'=>-1,'msg'=>'参数非法'));
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
        if(empty($course) || $roominfo['crid'] != $course['crid'] || $course['uid'] != $user['uid']) {
            echo json_encode(array('status'=>-1,'msg'=>'您无权删除此课件'));
            exit();
        }
        $attachmodel = $this->model('Attachment');
        $queryarr = array('cwid'=>$cwid);
        $attachs = $attachmodel->getAttachmentListByCwid($queryarr);
        // $result = $coursemodel->delcourse($cwid);
		$result = $coursemodel->editcourseware(array('cwid'=>$cwid,'status'=>-3));
        if($result) {
            echo json_encode(array('status'=>1,'msg'=>"删除成功"));
            fastcgi_finish_request();
            //删除课件附件文件
            // foreach ($attachs as $att) {
                // delfile('attachment',$att['url']);
            // }
            //删除课件文件
            // delfile('course',$course['cwurl']);
            //修改课件数
            $foldermodel = $this->model('Folder');
			$folderid = $course['folderid'];
			$folder = $foldermodel->getfolderbyid($folderid);
			$foldername = !empty($folder['foldername']) ? $folder['foldername'] : '';
			$folderlevel = $folder['folderlevel'];
			while($folderlevel>1){
				$foldermodel->addcoursenum($folderid,-1);
				$folder = $foldermodel->getfolderbyid($folder['upid']);
				$folderlevel = $folder['folderlevel'];
				$folderid = $folder['folderid'];
			}

            $roommodel = $this->model('Classroom');
            $roommodel->addcoursenum($roominfo['crid'],-1);
            $teachermodel = $this->model('Teacher');
            $teachermodel->addcoursenum($course['uid'],-1);
            $param = array();
            $param['toid'] = $cwid;
            $param['foldername'] = $foldername;
            $param['title'] = !empty($course['title']) ? $course['title'] : '';
            Ebh::app()->lib('OperationLog')->addLog($param,'delcw');//操作成功记录到操作日志
        } else {
            echo json_encode(array('status'=>-1,'msg'=>"删除失败，请联系管理员或稍后再试"));
        }
    }
	/**
	*上传附件
	*/
	public function upattach() {
		$roominfo = Ebh::app()->room->getcurroom();
		if(NULL !== $this->input->post('cwid')) {	//处理上传表单
			$this->_doupattach();
		} else {	//显示上传页面
			$cwid = $this->uri->uri_attr(0);
			if(!is_numeric($cwid))
				exit();
			$coursemodel = $this->model('Courseware');
			$course = $coursemodel->getcoursedetail($cwid,$roominfo['crid']);
			if(empty($course))
				exit();

			//兼容troomv2 导航
			$folderid = $course['folderid'];
			$this->assign('folderid', $folderid);
			$folder = $this->model('folder')->getfolderbyid($folderid);
			$this->assign('folder', $folder);
			$this->assign('index', 6);

			$this->assign('course',$course);
			$this->display('troomv2/classcourse_upattach');
		}
	}
	/**
	*处理附件上传表单提交
	*/
	private function _doupattach() {
		$cwid = $this->input->post('cwid');
		if(!is_numeric($cwid)) {
			echo 'fail';
		} else {
			$roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getloginuser();
            $crid = $roominfo['crid'];
            $uid = $user['uid'];
			$uparr = $this->input->post('up');
            if(!empty($uparr['sid']) && is_array($uparr['sid'])) {
                $sourcemodel = $this->model('Source');
                foreach ($uparr['sid'] as $index => $sid) {
                    $sid = intval($sid);
                    if($sid <= 0) { //验证不通过则失败
                        echo 'fail';
                        exit();
                    }
                    $source = $sourcemodel->getFileBySid($sid);
                    $checksum = $uparr['checksum'][$index];
                    if($source['checksum'] != $checksum) {  //验证不通过则失败
                        echo 'fail';
                        exit();
                    }
                    $filename = $uparr['filename'][$index];
                    $param[$index]['crid'] = $crid;
                    $param[$index]['uid'] = $uid;
                    $param[$index]['cwid'] = $cwid;
                    $param[$index]['title'] = $filename;
                    $param[$index]['source'] = $source['source'];
                    $param[$index]['url'] = $source['filepath'];
                    $param[$index]['filename'] = $filename;
                    $param[$index]['size'] = $source['filesize'];
                    $param[$index]['suffix'] = $source['filesuffix'];
                    $param[$index]['sourceid'] = $sid;
                    $param[$index]['checksum'] = $checksum;
                    $param[$index]['ispreview'] = $source['ispreview'];
                    $param[$index]['apppreview'] = $source['apppreview'];
                }
            }
			$attmodel = $this->model('Attachment');
			$res = $attmodel->addMultipleAtt($param);
			if($res !== false){
				echo json_encode(array('status'=>1));
			}else{
				echo 0;
				exit;
			}
			fastcgi_finish_request();
			$coursemodel = $this->model('Courseware');
			$coursemodel->addatachnum($cwid,$res['attnum']);
			for($i=0;$i<$res['attnum'];$i++){
				$this->doPreview($res['fromattid']+$i,$param[$i]['url'],'att');
			}
			// $title= $this->input->post('title');
			// $message= $this->input->post('message');
			// $up = $this->input->post('up');
			// $urlinfo = explode(',', $up['upfilepath']);
			// $source = $urlinfo[0];
			// $url = $urlinfo[1];
			// $filename =  $up['upfilename'];
			// $size = $up['upfilesize'];
			// $suffix = substr($urlinfo[1], stripos($urlinfo[1],'.')+1,strlen($urlinfo[1]));
			// $param = array('cwid'=>$cwid,'uid'=>$uid,'crid'=>$roominfo['crid'],'title'=>$title,'message'=>$message,'source'=>$source,'url'=>$url,'filename'=>$filename,'suffix'=>$suffix,'size'=>$size,'status'=>1);
			// $attmodel = $this->model('Attachment');
			// $result = $attmodel->insert($param);
			// if($result) {
				// $coursemodel = $this->model('Courseware');
				// $coursemodel->addatachnum($cwid,1);
				// echo json_encode(array('status'=>1));
				// fastcgi_finish_request();	//添加成功，则直接返回前端输出
				// $this->previewSwf($result,$url,'att');	//将doc/ppt/xls/pdf文件转换成可预览swf格式
			// } else {
				// echo json_encode(array('status'=>0));
			// }
		}
	}
	/**
	*编辑附件
	*/
	public function editattach_view() {
		$attid = $this->uri->itemid;
		if($attid <= 0)
			exit();
		$attachmodel = $this->model('Attachment');
		$attach = $attachmodel->getAttachById($attid);
		if(empty($attach))
			exit();
		$coursemodel = $this->model('Courseware');
		$course = $coursemodel->getcoursedetail($attach['cwid']);
		if(empty($course))
			exit();

		//兼容troomv2 导航
		$folderid = $course['folderid'];
		$this->assign('folderid', $folderid);
		$folder = $this->model('folder')->getfolderbyid($folderid);
		$this->assign('folder', $folder);
		$this->assign('index', 6);

		$this->assign('attach',$attach);
		$this->assign('course',$course);
		$this->display('troomv2/classcourse_editattach');
	}
	/**
	*处理编辑附件表单
	*/
	public function editattach() {
		$attid = $this->input->post('attid');
		if(!is_numeric($attid)) {
			echo 'fail';
		} else {
			$roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getloginuser();
            $crid = $roominfo['crid'];
			$title= $this->input->post('title');
			$message= $this->input->post('message');

			$attmodel = $this->model('Attachment');
			$attach = $attmodel->getAttachById($attid);
			if(empty($attach) || $attach['uid'] != $user['uid']){
				echo json_encode(array('status'=>0));
				exit;
			}
			$param = array('attid'=>$attid,'title'=>$title,'message'=>$message);
			$result = $attmodel->update($param);
			if($result !== FALSE) {
				echo json_encode(array('status'=>1));
			} else {
				echo json_encode(array('status'=>0));
			}
		}
	}
	/**
	*删除课件下的附件
	*/
	public function delattach() {
		$attid = $this->input->post('attid');
		if(!is_numeric($attid)) {
			echo 'fail';
		} else {
			$attachmodel = $this->model('Attachment');
			$attach = $attachmodel->getAttachById($attid);
			if(empty($attach)) {
				echo 'fail';
				exit();
			}
			$coursemodel = $this->model('Courseware');
			$course = $coursemodel->getcoursedetail($attach['cwid']);
			if(empty($course)) {
				echo 'fail';
				exit();
			}
			$user = Ebh::app()->user->getloginuser();
			$attmodel = $this->model('Attachment');
			$attach = $attmodel->getAttachById($attid);
			if(empty($attach) || $attach['uid'] != $user['uid']){
				echo 'fail';
				exit;
			}
			$result = $attmodel->deleteattachment($attid);
			if($result > 0) {
				$coursemodel->addatachnum($course['cwid'],-1);
				echo 'success';
			} else {
				echo 'fail';
			}
		}
	}
	/**
	*将doc/ppt/xls/pdf文件转换成可预览swf格式
	*/
	private function previewSwf($cwid,$cwurl,$type = "") {

		$ext = strtolower( strrchr( $cwurl , '.' ) );
		$previewExt = array('.doc','.docx','.ppt','.pptx','.xls','.xlsx','.pdf');	//允许预览处理的文件类型
		if(in_array($ext,$previewExt)) {
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$up_type = 'attachment';
			$savepath = $_UP[$up_type]['savepath'];
			$filepath = $savepath.$cwurl;
			$uploadurl = $_UP['preview']['url'];
			$webutil = Ebh::app()->lib('WebUtil');
			$result = $webutil->postfile($filepath,$uploadurl);
			if($result != "error") {
				if($type == 'att') {
					$attmodel = $this->model('Attachment');
					$attmodel->updateIspreview($cwid,1,1);
				} else {
					$coursemodel = $this->model('Courseware');
					$coursemodel->updateIspreview($cwid,1,1);
				}
			}
		}
		return true;
	}
	/**
	*将flv文件加入关键帧，并且截图
	*/
	private function rtmpFlv($cwid,$cwurl,$type = "") {
		$ext = strtolower( strrchr( $cwurl , '.' ) );
		$previewExt = array('.flv');	//允许预览处理的文件类型
		if(in_array($ext,$previewExt)) {
			$preurl = substr($cwurl,0,strlen($cwurl) - strlen($ext));
			$desturl = $preurl.'i'.$ext;
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$up_type = 'attachment';
			$savepath = $_UP[$up_type]['savepath'];
			$soursepath = $savepath.$cwurl;
			$destpath = $savepath.$desturl;

			$ffmpeglib = Ebh::app()->lib('Ffmpeg');
			$flvresult = $ffmpeglib->setFlvKeyFrame($soursepath,$destpath);	//插入关键帧
			if($flvresult) {
				$param = array('cwurl'=>$desturl,'isrtmp'=>1);
				//处理视频截图
				$img_type = 'pic';
				$picsavepath = $_UP[$img_type]['savepath'];
				$picshowpath = $_UP[$img_type]['showpath'];
				$preipos = strripos($preurl,'/');
				$preimg = substr($preurl,0,$preipos+1);
				$imgpath = $picsavepath.$preimg;
				$filetime = SYSTIME;
				Ebh::app()->helper('file');
				mkfolder($imgpath);
				$imgdestpath = $picsavepath.$preimg.$filetime.'.jpg';
				$imgsize = '960*570';
				$imgresult = $ffmpeglib->getVideoImage($destpath,$imgdestpath,$imgsize,1);
				if($imgresult) {
					$imgshowpath = $picshowpath.$preimg.$filetime.'.jpg';
					$param['thumb'] = $imgshowpath;
				}
				$coursemodel = $this->model('Courseware');
				$coursemodel->updateIsrtmp($cwid,$param);
			}
		}
		return true;
	}
	/**
	*将flv文件加入关键帧，并且截图
	*@param $cwid int 课件编号 10399
	*@param $cwurl string 课件存放相对路径 2014/10/22/1432342343.flv
	*/
	private function m3u8Flv($cwid,$cwurl,$type = "") {

		$ext = strtolower( strrchr( $cwurl , '.' ) );	//.flv
		$previewExt = array('.flv','.avi','.mpeg','.mpg','.mp4','.rmvb','.rm','.mp3','.mov');	//允许预览处理的文件类型
		if(in_array($ext,$previewExt)) {
			//将视频转码请求到对应服务器
			$_UP = Ebh::app()->getConfig()->load('upconfig');
			$up_type = 'attachment';
			$notifyurl = $_UP[$up_type]['notify'];	// /data0/uploads/docs/
			$notifyurl = $notifyurl.'?cwid='.$cwid;
			$webutil = Ebh::app()->lib('WebUtil');
			$webutil->getfile($notifyurl);
		}
		return true;
	}
    /**
    *处理课件视频，文档等的预览
    */
    private function doPreview($cwid,$cwurl,$type = "") {
        $ext = strtolower( strrchr( $cwurl , '.' ) );   //.flv
        $previewExt = array('.flv','.avi','.mpeg','.mpg','.mp4','.rmvb','.rm','.mp3','.mov','.doc','.docx','.ppt','.pptx','.xls','.xlsx','.pdf');   //允许预览处理的文件类型
        if(in_array($ext,$previewExt)) {
            //将视频转码请求到对应服务器
            $_UP = Ebh::app()->getConfig()->load('upconfig');
            $up_type = 'attachment';
            $notifyurl = $_UP[$up_type]['notifyv2'];  // /data0/uploads/docs/
            if($type == 'att') {
                $notifyurl = $notifyurl.'?attid='.$cwid;
            } else {
                $notifyurl = $notifyurl.'?cwid='.$cwid;
            }
            $webutil = Ebh::app()->lib('WebUtil');
            $webutil->getfile($notifyurl);
        }
        return true;
    }

	/*
	批量添加课件
	*/
	public function addmulti(){
		if(NULL != $this->input->post('folderid')) {
			$postarr = $this->input->post();
	//	print_r($postarr);
			$roominfo = Ebh::app()->room->getcurroom();
			$user = Ebh::app()->user->getloginuser();

			$coursemodel = $this->model('Courseware');
            $displayarr = array();
			foreach(array_keys($postarr['title']) as $k){
				if(!isset($postarr['title'][$k]) || $postarr['title'][$k]=='')
					continue;
				$param[$k]['title'] = htmlspecialchars($postarr['title'][$k]);
				if(!empty($postarr['sectionid']))
					$param[$k]['sid'] = intval($postarr['sectionid'][$k]);
				else
					$param[$k]['sid'] = 0;
				if(!isset($displayarr[$param[$k]['sid']])){
					$cdisplayorder = $coursemodel->getCurdisplayorder(array('crid'=>$roominfo['crid'],'sid'=>$param[$k]['sid'],'folderid'=>intval($postarr['folderid'])));
					if($cdisplayorder == null)
						$cdisplayorder = 1000;
					else
						$cdisplayorder = $cdisplayorder - 1;
					$displayarr[$param[$k]['sid']] = $cdisplayorder;
				}
				else{
					$cdisplayorder = --$displayarr[$param[$k]['sid']];
				}
				$param[$k]['cdisplayorder'] = $cdisplayorder;
				$param[$k]['tag'] = htmlspecialchars($postarr['tag'][$k]);
				$param[$k]['summary'] = htmlspecialchars($postarr['summary'][$k]);
				$upfilname = explode('.',$postarr['upfilename'][$k]);
				$param[$k]['cwname'] = $upfilname[0].'.'.strtolower($upfilname[1]);
				$cwfile = explode(',',$postarr['upfilepath'][$k]);
				$param[$k]['cwsource'] = $cwfile[0];
				$param[$k]['cwurl'] = $cwfile[1];
				$param[$k]['cwsize'] = intval($postarr['upfilesize'][$k]);
				$param[$k]['folderid'] = intval($postarr['folderid']);
				$param[$k]['crid'] = $roominfo['crid'];
				$param[$k]['uid'] = $user['uid'];
				if(empty($postarr['upfilename'][$k]) || empty($param[$k]['cwsource']) || empty($param[$k]['cwurl']) || empty($param[$k]['cwsize'])){
					echo 0;
					exit;
				}

			}
            $res = $coursemodel->addMultipleCW($param);
			if($res !== false){
				echo json_encode(array('status'=>1));
			}else{
				echo 0;
				exit;
			}
			fastcgi_finish_request();
			$credit = $this->model('credit');
			for($i=0;$i<$res['coursenum'];$i++){
				$this->previewSwf($res['fromcwid']+$i,$param[$i]['cwurl']);
				//$this->rtmpFlv($res['fromcwid']+$i,$param[$i]['cwurl']);	//处理flv视频
				$this->m3u8Flv($res['fromcwid']+$i,$param[$i]['cwurl']);	//处理m3u8视频
				$credit->addCreditlog(array('ruleid'=>31,'cwid'=>$res['fromcwid']+$i));
			}


		}else{
			$folderid = $this->uri->uri_attr(0);
			if(is_numeric($folderid)) {
				$upcontrol = Ebh::app()->lib('UpcontrolLib');
				$editor = Ebh::app()->lib('UEditor');
				$foldermodel = $this->model('Folder');
				$folder = $foldermodel->getfolderbyid($folderid);
				$this->assign('folder', $folder);
				$this->assign('upcontrol', $upcontrol);
				$this->assign('editor', $editor);
				$this->display('troomv2/classcourse_addmulti');
			}
		}
	}
	/**
	*学习监控页面
	*1，获取课件对应课程
	*2，获取有课程权限的学生 如果是学校 则当前年级学生 如果是分成学校 则为已开通课程权限学生
	*3，学生对应的听课记录

	*/
	public function jk() {
		$cwid = $this->uri->uri_attr(0);
		$course = array();
		$myfolder = array();
		$userlist = array();
		$type = $this->uri->uri_viewmode();	//1表示显示未学名单 0表示显示已学名单

		if($type == '1') //未学名单
			$type = 1;
		else
			$type = 0;
		if(is_numeric($cwid) && $cwid > 0) {
			$roominfo = Ebh::app()->room->getcurroom();
			$rcmodel = $this->model('Roomcourse');
			$folderid = 0;
			$uidstr = '';
			$folderinfo = $rcmodel->getFolderByCwid($cwid,$roominfo['crid']);
			if(!empty($folderinfo)) {
				$folderid = $folderinfo['folderid'];
			}
			$cwmodel = $this->model('Courseware');
			$course = $cwmodel->getSimplecourseByCwid($cwid);
			$foldermodel = $this->model('Folder');
			$myfolder = $foldermodel->getfolderbyid($folderid);
			if($roominfo['isschool'] == 7 && $roominfo['domain'] != 'khzx') {	//如果分成学校，则获取已开通的学生
				$upmodel = $this->model('Userpermission');
				$uidlist = $upmodel->getUserIdListByFolder($folderid);
				if(!empty($uidlist)) {
					foreach($uidlist as $uiditem) {
						if(empty($uidstr)) {
							$uidstr = $uiditem['uid'];
						} else {
							$uidstr .= ','.$uiditem['uid'];
						}
					}
					$userlist = $upmodel->getUserAndClassListByUidStr($roominfo['crid'],$folderid,$uidstr);
				}
			} else {	//否则获取课程对应年级的学生
				$grade = $myfolder['grade'];
				if(!empty($grade)) {
					$classmodel = $this->model('Classes');
					$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade);
					if(!empty($userlist)){
						foreach($userlist as $uiditem) {
							if(empty($uidstr)) {
								$uidstr = $uiditem['uid'];
							} else {
								$uidstr .= ','.$uiditem['uid'];
							}
						}
					}
				}
			}
			$plmodel = $this->model('Playlog');
			$loglist = $plmodel->getLogListByUidStr($cwid,$uidstr);
			if(!empty($loglist)) {
				foreach($loglist as $mylog) {
					if(isset($userlist[$mylog['uid']])) {
						if($mylog['totalflag'] == 1) {
							$userlist[$mylog['uid']]['startdate'] = $mylog['startdate'];	//首次学习时间
							$userlist[$mylog['uid']]['lastdate'] = $mylog['lastdate'];		//末次学习时间
							if(empty($userlist[$mylog['uid']]['sumltimes'])) {	//总学习时间
								$userlist[$mylog['uid']]['sumltimes'] = 0;
							}
							if(empty($userlist[$mylog['uid']]['sumtimes'])) {	//总学习次数
								$userlist[$mylog['uid']]['sumtimes'] = 0;
							}
							$userlist[$mylog['uid']]['totalltime'] = $mylog['ltime'];
						} else {
							$userlist[$mylog['uid']]['sumltimes'] = $userlist[$mylog['uid']]['sumltimes'] + $mylog['ltime'];
							$userlist[$mylog['uid']]['sumtimes'] = $userlist[$mylog['uid']]['sumtimes'] + 1;
						}
					}
				}
			}
		}
		$myuserlist = array();
		$learncount = 0;	//已学数
		$nolearncount = 0;	//未学数
		if(!empty($userlist)){
			foreach($userlist as $theuser) {
				if(empty($theuser['startdate'])) {
					if($type == 1) {
						$myuserlist[] = $theuser;
					}
					$nolearncount ++;
				} else {
					if($type == 0) {
						if(empty($theuser['sumltimes']) || $theuser['sumltimes'] <= 0) {
							$theuser['sumltimes'] = $theuser['totalltime'];
						}
						if(empty($theuser['sumtimes']) || $theuser['sumtimes'] <= 0) {
							$theuser['sumtimes'] = 1;
						}
						$myuserlist[] = $theuser;
					}
					$learncount ++;
				}
			}
		}
		$course['learncount'] = $learncount;
		$course['nolearncount'] = $nolearncount;
		if(empty($course['title'])){
			$course['title'] = '';
		}
		if(empty($course['dateline'])){
			$course['dateline'] = 0;
		}
		if(empty($course['cwid'])){
			$course['cwid'] = 0;
		}
		$this->assign('course',$course);
		$this->assign('myfolder',$myfolder);
		$this->assign('myuserlist',$myuserlist);
		if($type == 0) {
			$this->display('troomv2/classcourse_jk');
		} else {
			$this->display('troomv2/classcourse_jkno');
		}
	}

	/**
	 *学习监控页面
	 *1，获取课件对应课程
	 *2，获取有课程权限的学生 如果是学校 则当前年级学生 如果是分成学校 则为已开通课程权限学生
	 *3，学生对应的听课记录

	 */
	public function jkv2() {
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo', $roominfo);
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user', $user);


		$cwid = $this->uri->uri_attr(0);
        $this->assign('cwid',$cwid);
		$course = array();
		$myfolder = array();

//		$type = $this->uri->uri_viewmode();	//1表示显示未学名单 0表示显示已学名单
//		if($type == '1') //未学名单
//			$type = 1;
//		else
//			$type = 0;
        $type = $this->input->get('type');
//        echo $type;die;
		$q = $this->input->get('q');
		$get = $this->input->get();

		//顶部统计
		$topcount = Ebh::app()->lib('Topcount');

		$uidstr = $topcount->getTopcount($cwid,$this);
		$userlist = array();
		if (!empty($this->userlist))
			$userlist = $this->userlist;
		if(is_numeric($cwid) && $cwid > 0) {
			$cwmodel = $this->model('courseware');
			$course = $cwmodel->getcoursedetail($cwid);
			$plmodel = $this->model('Playlog');
			$loglist = $plmodel->getLogListByUidStr($cwid,$uidstr);
			if(!empty($loglist)) {
				foreach($loglist as $mylog) {
					if(isset($userlist[$mylog['uid']])) {
						if($mylog['totalflag'] == 1) {
							$userlist[$mylog['uid']]['startdate'] = $mylog['startdate'];	//首次学习时间
							$userlist[$mylog['uid']]['lastdate'] = $mylog['lastdate'];		//末次学习时间
							if(empty($userlist[$mylog['uid']]['sumltimes'])) {	//总学习时间
								$userlist[$mylog['uid']]['sumltimes'] = 0;
							}
							if(empty($userlist[$mylog['uid']]['sumtimes'])) {	//总学习次数
								$userlist[$mylog['uid']]['sumtimes'] = 0;
							}
							$userlist[$mylog['uid']]['totalltime'] = $mylog['ltime'];
						} else {
                            if (empty($userlist[$mylog['uid']]['sumltimes'])) {
                                $userlist[$mylog['uid']]['sumltimes'] = 0 + $mylog['ltime'];
                                $userlist[$mylog['uid']]['sumtimes'] = 0 + 1;
                            } else {
                                $userlist[$mylog['uid']]['sumltimes'] = $userlist[$mylog['uid']]['sumltimes'] + $mylog['ltime'];
                                $userlist[$mylog['uid']]['sumtimes'] = $userlist[$mylog['uid']]['sumtimes'] + 1;
                            }

						}
					}
				}
			}
		}
		$myuserlist = array();
		$learncount = 0;	//已学数
		$nolearncount = 0;	//未学数
		$course['sumltimes'] = 0;
		if(!empty($userlist)){
			foreach($userlist as $theuser) {
				if(empty($theuser['startdate'])) {
					if($type == 1) {
						$myuserlist[] = $theuser;
					}
					$nolearncount ++;
				} else {
					if($type == 0) {
						if(empty($theuser['sumltimes']) || $theuser['sumltimes'] <= 0) {
							$theuser['sumltimes'] = $theuser['totalltime'];
						}
						if(empty($theuser['sumtimes']) || $theuser['sumtimes'] <= 0) {
							$theuser['sumtimes'] = 1;
						}
						$myuserlist[] = $theuser;
					}
					$learncount ++;
					$course['sumltimes'] += $theuser['sumltimes'];
				}
			}
		}
//        p($myuserlist);die;

        $redis = Ebh::app()->getCache('cache_redis');
        $viewnum = $redis->hget('coursewareviewnum',$course['cwid']);
        if(!empty($viewnum)){
            $course['viewnum'] = $viewnum;
        }
		if(empty($course['title'])){
			$course['title'] = '';
		}
		if(empty($course['dateline'])){
			$course['dateline'] = 0;
		}
		if(empty($course['cwid'])){
			$course['cwid'] = 0;
		}
//		var_dump($myuserlist);
        $this->assign('q',$q);
        $this->assign('get',$get);

		$this->assign('course',$course);
        $this->assign('type',$type);
		$this->assign('myfolder',$myfolder);
		$this->assign('myuserlist',$myuserlist);

//		if($type == 0) {
			$this->display('troomv2/classcourse_jkv2');
//		} else {
//			$this->display('troomv2/classcourse_jknov2');
//		}
	}

	/**
	*学习监控页面
	*1，获取课件对应课程
	*2，获取有课程权限的学生 如果是学校 则当前年级学生 如果是分成学校 则为已开通课程权限学生
	*3，学生对应的听课记录

	*/
	public function jkexcel() {
		$cwid = $this->uri->uri_attr(0);
		$course = array();
		$myfolder = array();
		$userlist = array();
		$type = $this->uri->uri_viewmode();	//1表示显示未学名单 0表示显示已学名单

		if($type == '1') //未学名单
			$type = 1;
		else
			$type = 0;
		if(is_numeric($cwid) && $cwid > 0) {
			$roominfo = Ebh::app()->room->getcurroom();
			$rcmodel = $this->model('Roomcourse');
			$folderid = 0;
			$uidstr = '';
			$folderinfo = $rcmodel->getFolderByCwid($cwid,$roominfo['crid']);
			if(!empty($folderinfo)) {
				$folderid = $folderinfo['folderid'];
			}
			$cwmodel = $this->model('Courseware');
			$course = $cwmodel->getSimplecourseByCwid($cwid);
			$foldermodel = $this->model('Folder');
			$myfolder = $foldermodel->getfolderbyid($folderid);
			if($roominfo['isschool'] == 7  && $roominfo['domain'] != 'khzx') {	//如果分成学校，则获取已开通的学生 开化中学 按照学校处理
				if($myfolder['isschoolfree']==1 || $myfolder['fprice'] == 0){//免费
					if(empty($myfolder['grade'])){
						$grade = -1;
					}else{
						$grade = $myfolder['grade'];
					}
					$classmodel = $this->model('Classes');
					$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade,$q);
					if(!empty($userlist)){
						foreach($userlist as $uiditem) {
							if(empty($uidstr)) {
								$uidstr = $uiditem['uid'];
							} else {
								$uidstr .= ','.$uiditem['uid'];
							}
						}
						$userscount = count($userlist);//总人数
					}
				}else{
					$upmodel = $this->model('Userpermission');
					$uidlist = $upmodel->getUserIdListByFolder($folderid);
					if(!empty($uidlist)) {
						foreach($uidlist as $uiditem) {
							if(empty($uidstr)) {
								$uidstr = $uiditem['uid'];
							} else {
								$uidstr .= ','.$uiditem['uid'];
							}
						}
						$userlist = $upmodel->getUserAndClassListByUidStr($roominfo['crid'],$folderid,$uidstr,$q);
						$userscount = count($userlist);
					}
				}
			} else {	//否则获取课程对应年级的学生
				if(empty($myfolder['grade'])){
                    $grade = -1;
                }else{
                    $grade = $myfolder['grade'];
                }
				$classmodel = $this->model('Classes');
				$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade);
				foreach($userlist as $uiditem) {
					if(empty($uidstr)) {
						$uidstr = $uiditem['uid'];
					} else {
						$uidstr .= ','.$uiditem['uid'];
					}
				}

			}
			$plmodel = $this->model('Playlog');
			$loglist = $plmodel->getLogListByUidStr($cwid,$uidstr);
			foreach($loglist as $mylog) {
				if(isset($userlist[$mylog['uid']])) {
					if($mylog['totalflag'] == 1) {
						$userlist[$mylog['uid']]['startdate'] = $mylog['startdate'];	//首次学习时间
						$userlist[$mylog['uid']]['lastdate'] = $mylog['lastdate'];		//末次学习时间
						if(empty($userlist[$mylog['uid']]['sumltimes'])) {	//总学习时间
							$userlist[$mylog['uid']]['sumltimes'] = 0;
						}
						if(empty($userlist[$mylog['uid']]['sumtimes'])) {	//总学习次数
							$userlist[$mylog['uid']]['sumtimes'] = 0;
						}
						$userlist[$mylog['uid']]['totalltime'] = $mylog['ltime'];
					} else {
						$userlist[$mylog['uid']]['sumltimes'] = $userlist[$mylog['uid']]['sumltimes'] + $mylog['ltime'];
						$userlist[$mylog['uid']]['sumtimes'] = $userlist[$mylog['uid']]['sumtimes'] + 1;
					}
				}
			}

		}
		$myuserlist = array();

		foreach($userlist as $theuser) {
			if(empty($theuser['startdate'])) {
				if($type == 1) {
					$sex = $theuser['sex'] == 1?'女':'男';
					$useritem = array($theuser['classname'],$theuser['username'],$theuser['realname'],$sex);
					$myuserlist[] = $useritem;
				}
			} else {
				if($type == 0) {
					$sex = $theuser['sex'] == 1?'女':'男';
					$startdate = date('Y-m-d H:i',$theuser['startdate']);
					$lastdate = date('Y-m-d H:i',$theuser['lastdate']);
					$sumltimes = secondToStr($theuser['sumltimes']);
					$sumtimes = $theuser['sumtimes'];
					if(empty($sumltimes) || $sumltimes <= 0) {
						$sumltimes = $theuser['totalltime'];
					}
					if(empty($sumtimes) || $sumtimes <= 0) {
						$sumtimes = 1;
					}
					$useritem = array($theuser['classname'],$theuser['username'],$theuser['realname'],$sex,$startdate,$lastdate,$sumltimes,$sumtimes);
					if(empty($sumltimes)) {
						$useritem['sumltimes'] = $theuser['totalltime'];
					}

					$myuserlist[] = $useritem;
				}
			}
		}

		if($type == 1) {
			$filename = $course['title'].'未学名单';
			$titlearr = array('班级','账号','姓名','性别');
			$widtharr = array(20,20,20,10);
		} else {
			$filename = $course['title'].'学习监控';
			$titlearr = array('班级','账号','姓名','性别','首次学习','最后学习','总时长','次数');
			$widtharr = array(20,20,20,10,20,20,20,10);
		}

		$this->_exportExcel($titlearr,$myuserlist,'FF808080',$filename,$widtharr);

	}
	/**
	 * 导出excel
	 * @param Array array("编号",'用户名','性别'....)
	 * @param Array array('1','李华','男'...)
	 * @param String rgbColor
	 * @param String execl文件名称
	 *
	 */
	protected  function _exportExcel($titleArr,$dataArr,$titleColor="FF808080",$name,$manuallywidth=array()){
		$objPHPExcel = Ebh::app()->lib('PHPExcel');

		// 以下是一些设置 ，什么作者  标题啊之类的
		$objPHPExcel->getProperties()
					->setTitle("数据EXCEL导出")
					->setSubject("数据EXCEL导出")
					->setDescription("备份数据")
					->setKeywords("excel")
					->setCategory("result file");

		// 设置列表标题
		if(is_array($titleArr)){
			$str = "A";
			foreach($titleArr as $k=>$v){
				$p = $str++.'1';//列A1,B1,C1,D1
				if(empty($manuallywidth))
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
		//传值
		if(is_array($dataArr)){
			foreach ($dataArr as $k=>$v) {
				$str = "A";
				foreach($titleArr as $kt=>$vt){
					$p = $str.($k+2);//从第二列填充内容 A22,B22...A33 B33
					$pt = $objPHPExcel->getActiveSheet();
					if(empty($manuallywidth))
					$pt->getColumnDimension($str)->setAutoSize(true);//单元格每项内容自适应
					if(is_numeric($v[$kt])){
						if(empty($manuallywidth))
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);//A列头标题自适应
						$pt->getStyle($p)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//设置单元格文本存储类型
						$pt->getColumnDimension($str)->setWidth(20);//设置单元格宽度
						$pt->setCellValue($p, $v[$kt].' ');//填充内容
					}else{
						$pt->setCellValue($p, $v[$kt]);
					}

					$str++;
				}
			}
		}
		if(!empty($manuallywidth)){
			$str = 'A';
			foreach($manuallywidth as $width){
				$objPHPExcel->getActiveSheet()->getColumnDimension($str)->setWidth($width);
				$str++;
			}
		}
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

	/*
	课件统计分析
	*/
	public function analysis_view(){
		$cwid = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('roominfo', $roominfo);
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
		$this->assign('user', $user);
		$topcount = Ebh::app()->lib('Topcount');
		$topcount->getTopcount($cwid,$this);
		$this->display('troomv2/classcourse_analysis');
	}
	/**
     * ajax请求学生列表
     */
    function ajax_students() {
        $classid = intval($this->input->get('cid'));
        $page = max(intval($this->input->get('page')), 1);
        $q = trim($this->input->get('q'));
        $class_model = $this->model('classes');
        $params = array(
            'page' => $page,
            'pagesize' => 35,
            'order' => 'cs.classid asc,u.uid desc',
            'group' => 'uid'
        );
        if($classid == -1){
            $user = Ebh::app()->user->getloginuser();
            $students[] = $user;
        }else{
            if ($classid > 0) {
                $params['classid'] = $classid;
            }else{
                $roominfo = Ebh::app()->room->getcurroom();
                $classlist = $class_model->getroomClassList($roominfo['crid']);
                if(!empty($classlist)){
                    $classid = array();
                    foreach ($classlist as $list) {
                        $classid[] = $list['classid'];
                    }
                    $params['classid'] = implode(',',$classid);
                }
            }
            if (!empty($q)) {
                $params['q'] = $q;
            }
            $students = $class_model->getClassStudentList($params);
        }
        if (!empty($students)) {
            foreach ($students as &$student) {
                $show_name = !empty($student['realname']) ? $student['realname'] : $student['username'];
                $student['photo'] = getavater($student,'50_50');
                $student['shortname'] = shortstr($show_name, 6);
                $student['showname'] = $show_name;
            }
            echo json_encode($students);
            exit();
        }
        echo 'null';
        exit();
    }

    /**
     * 异步设置课件聊天室公告
     */
    function ajax_notice(){
        $cwid = intval($this->input->post('cwid'));
        $notice = h($this->input->post('notice'));
        $result = array();
        if(is_numeric($cwid) && $cwid > 0) {
            $coursemodel = $this->model('Courseware');
            $course = $coursemodel->getcoursedetail($cwid);
            if(!$course){
                $result['status'] = 0;
                $result['msg'] = '课件不存在';
            }else{

                if($coursemodel->setNotice($cwid,$notice) !== false){
                    $result['status'] = 1;
                    $result['msg'] = '设置公告成功';
                }else{
                    $result['status'] = 0;
                    $result['msg'] = '设置公告失败,请稍后在试';
                }
            }
        }else{
            $result['status'] = 0;
            $result['msg'] = '课件ID不合法';
        }

        echo json_encode($result);exit;
    }

    /**
     * 获取课件公告
     */
    public function ajax_getnotice(){
        $cwid = intval($this->input->post('cwid'));
        $result = array();
        if(is_numeric($cwid) && $cwid > 0) {
            $coursemodel = $this->model('Courseware');
            $notice = $coursemodel->getNotice($cwid);
            $result['status'] = 1;
            $result['data'] = $notice ? $notice : '';
        }else{
            $result['status'] = 0;
            $result['msg'] = '课件ID不合法';
        }

        echo json_encode($result);exit;
    }

	/*
	获取总后台设置的分成比例
	*/
	private function getfeepercent($crid){
		$roomdetail = $this->model('classroom')->getdetailclassroom($crid);
		if(!empty($roomdetail['profitratio'])){
			$profitratio = unserialize($roomdetail['profitratio']);
			$feepercent['compercent'] = $profitratio['company']/100;
			$feepercent['roompercent'] = 1 - $feepercent['compercent'];
		}else{
			$feepercent['compercent'] = 0.3;
			$feepercent['roompercent'] = 0.7;
		}
		return $feepercent;
	}

	/*
	教师操作权限判断
	*/
	private function checkpower($folderid){
		$uid = $this->input->post('uid');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if($user['uid'] != $uid){
			echo json_encode(array('status'=>0,'showerrmsg'=>1,'errmsg'=>'登录用户已改变，请刷新后重试。'));
			exit;
		}
		$roomtype = Ebh::app()->room->getRoomType();
		$teachermodel = $this->model('Teacher');
		$param = array('uid'=>$user['uid'],'folderid'=>$folderid,'crid'=>$roominfo['crid']);
		$param['isenterprise'] = $roomtype == 'com'?1:0;
		$check = $teachermodel->checkTeacherFolder($param);

		if(empty($check)){
			echo json_encode(array('status'=>0,'showerrmsg'=>1,'errmsg'=>'您没有该课程的权限，请刷新后重试。'));
			exit;
		}

	}
}
