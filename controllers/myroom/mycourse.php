<?php
/**
 * 学校学生学习课程课件相关控制器 MycourseController
 */
class MycourseController extends CControl {
	private $check = 1;
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
			$this->check = $check;
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
	/**
	*课程详情（课件列表页）
	*/
	public function view() {
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$roominfo = Ebh::app()->room->getcurroom();
		$from = $this->uri->uri_attr(0);	//来源，0或空为全校课程 1 为我的课程 2 为教师课程
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
        if(empty($course) || $course['status']!=1)
            exit();
        $user = Ebh::app()->user->getloginuser();
        $api = Ebh::app()->getApiServer('ebh');
        $classid = $api->reSetting()
            ->setService('Member.User.getStudentClassId')
            ->addParams('uid', $user['uid'])
            ->addParams('crid', $roominfo['crid'])
            ->request();
        if (!empty($course['classids'])) {
            $classids = explode(',', $course['classids']);
            $classids = array_filter($classids, function($classid) {
                return !empty($classid);
            });
            if (!empty($classids) && (empty($classid) || !in_array($classid, $classids))) {
                exit();
            }
        }
        //读取课程开场内容
        $intorModel = $this->model('Intro');
        $intro = $intorModel->getDetail($course['folderid']);
        if (!empty($intro)) {
            $intortype = intval($intro['introtype']);
            if ($intortype == 1) {
                //读取视频
                $vedio = $this->model('Attachment')->getIntro($intro['attid']);
                if (!empty($vedio)) {
                    $intro['sourceurl'] = trim($vedio['source'], '/').'/'.'attach.html?troid='.$intro['attid'];
                } else {
                    $intro = null;
                }
            }
            if ($intortype == 2) {
                $intro['slides'] = json_decode($intro['slides'], true);
                $intro['slides'] = array_filter($intro['slides'], function($slide) {
                   return intval($slide['interval']) > 0;
                });
            }
            $this->assign('intro', $intro);
        }
        if (empty($course['username'])) {
            //课件添加用户被删除，将课件的所有者设置为课件所在网校管理员
            $coursewareroom = $this->model('Classroom')->getclassroomdetail($course['crid']);
            $course['uid'] = $coursewareroom['uid'];
            $course['username'] = $coursewareroom['username'];
            $course['realname'] = $coursewareroom['realname'];
            $course['sex'] = $coursewareroom['sex'];
            $course['face'] = $coursewareroom['face'];
            unset($coursewareroom);
        }
        getcwlogo($course, $playimg, $course['logo']);
        if (strstr($course['logo'], 'kustgd2.png')) {
            $course['logo'] = 'http://static.ebanhui.com/ebh/tpl/2014/images/'.$playimg.'.png';;
        }
        if ($roominfo['template'] == 'plate') {
            $showimg = !empty($course['flogo']) ? $course['flogo'] : 'http://static.ebanhui.com/ebh/tpl/default/images/folderimgs/course_cover_default_243_144.jpg';
            $img = show_plate_course_cover($showimg);
            $img = show_thumb($img);
            $course['flogo'] = $img;
        } else if (empty($course['flogo'])){
            $course['flogo'] = 'http://static.ebanhui.com/ebh/images/nopic.jpg';
        }


        $notice = $coursemodel->getNotice($cwid);


        $course['notice'] = $notice;
		$other_config = Ebh::app()->getConfig()->load('othersetting');
		$other_config['zjdlr'] = !empty($other_config['zjdlr']) ? $other_config['zjdlr'] : 0;
		$other_config['newzjdlr'] = !empty($other_config['newzjdlr']) ? $other_config['newzjdlr'] : array();
		$is_zjdlr = ($roominfo['crid'] == $other_config['zjdlr']) || (in_array($roominfo['crid'],$other_config['newzjdlr']));
		$is_newzjdlr = in_array($roominfo['crid'],$other_config['newzjdlr']);

		$course_detail = $coursemodel->getCwinfoListRewardByCwid($cwid);
        $course_detail = $course_detail[0];
		//价格按服务项的价格判断
		$pimodel = $this->model('payitem');
		$payitem = $pimodel->getLastItemByFolderid($course['folderid'],$roominfo['crid']);
		if(!empty($payitem)){
			$course['fprice'] = $payitem['iprice'];
		}
		if($roominfo['domain'] == 'rqzx' && $this->check == 1 && $course['fprice'] > 0) {	//永康一中特殊处理IP 如果是已经付费的并且是非免费课件，则限制IP
			$checkip = $this->checkAllowIp();
			$this->assign('checkip',$checkip);
		}

		//检测是否开通了新版本作业，未开通的话作业用老数据
        $newExamPower = $this->model('appmodule')->checkRoomMoudle($roominfo['crid'],'/troomv2/examv2.html');
        if ($newExamPower) {
            $this->assign('examPower',1);
        } else {
            $this->assign('examPower',0);
        }

        $coursemodel = $this->model('Courseware');
        $foldermodel = $this->model('Folder');
		//添加课件查看数
		// $coursemodel->addviewnum($cwid);
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
        $folder_detail = $foldermodel->getfolderbyid($course['folderid']);
        $this->assign('folder_detail',$folder_detail);
		//我观看课件的次数
		$countmine = 0;
		$logarr = array();
		if(!empty($cwid) && !empty($user['uid'])){
			$logarr['uid'] = $user['uid'];
			$logarr['cwid'] = $cwid;
			$playlog = $this->model('Playlog');
			$count = $playlog->getCountByCwid($logarr);
		}
		$countmine = empty($count)?0:$count;
		$this->assign('mycount',$countmine);
        if ($roominfo['isschool'] == 7) {
            $perparam = array('crid'=>$roominfo['crid'],'folderid'=>$course['folderid'], 'cwid'=>$course['cwid']);
            $is_student = EBH::app()->room->checkstudent(true);
            $this->check = EBH::app()->room->checkStudentPermission($user['uid'],$perparam);
            if ($this->check != 1) {
                //无权限
                $is_course_free = $is_student && !empty($course['isschoolfree']) || $course['fprice'] == 0;
                $is_courseware_free = $is_student && !empty($course['cwpay']) && (!empty($course['isfree']) || $course['cprice'] == 0);
                $is_free = $is_course_free || $is_courseware_free;

                $itemid = intval($this->input->get('itemid'));
                $perparam['itemid'] = $itemid;
                $payitem = Ebh::app()->room->getUserPayItem($perparam);
                $this->assign('payitem',$payitem);

                if (!$is_free) {
                    if (!empty($course['cwpay']) && $roominfo['template'] == 'plate') {
                        //课件能单独开通，优先开通课件
                        $checkurl = '/ibuy.html?cwid='.$course['cwid'];
                        $this->assign('checkurl',$checkurl);
                    } else {
                        if(!empty($payitem)) {
                            if($payitem['iprice'] > 0 && $payitem['ptype'] < 2) {	//课件不免费并且服务项无播放权限则弹出购买
                                $checkurl = '/ibuy.html?itemid='.$payitem['itemid'];	//购买url
                                if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
                                    $checkurl = '/classactive/bank.html';
                                }
                                $this->assign('checkurl',$checkurl);
                            } else {	//服务项加个为0则直接能学习
                                $this->check = 1;
                                $this->assign('check',$this->check);
                            }
                        } else {
                            $checkurl = '/';	//不存在对应服务项，则直接跳转到首页
                            $this->assign('checkurl',$checkurl);
                        }
                    }

                }
                $this->assign('is_free', $is_free);
            }
            $this->assign('check',$this->check);
            $this->assign('sign_type', !empty($course['cwpay']) && $roominfo['template'] == 'plate' ? 'courseware' : 'course');
        } else {
            $this->assign('check', 0);
        }
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$type = $this->input->get('type');	//如果type为1则表示普通播放，即不采用m3u8方式播放
//		$ifover5 = (SYSTIME - $course['dateline']) > 60 ? TRUE : FALSE;	//如果课件时间上传已经超过1分钟，则基本上已经处理成m3u8并且文件已经存好。
		//不再判断1分钟时间 2017-10-18 即转码好学生端就可播放
		//去掉type=1播放原始视频处理 2017-10-18 安全性考虑 避免文件下载
        if($course['ism3u8'] == 1) {	//rtmp特殊处理
			if($roominfo['domain'] == 'dh') {
				$m3u8source = $serverutil->getZKM3u8CourseSource();
			} else {
				$m3u8source = $serverutil->getM3u8CourseSource();
			}
			if(!empty($m3u8source)) {
				$murl = $course['m3u8url'];
				$key = $this->getKey($user,$murl,$cwid);
				$key = urlencode($key);
				$m3u8url = "$m3u8source?k=$key&id=$cwid&.m3u8";
				$course['m3u8url'] = $m3u8url;
			}
		} else {
			$course['m3u8url'] = '';
		}
		
		 //获取资源
        $courseSource = $this->model('Source')->getFileBySid($course['sourceid']);
        $this->assign('courseSource',$courseSource);
		$isliverun = FALSE;	//是否直播正在进行
		if($course['islive']) {	//直播课单独处理
			// echo 'curtime is :'.SYSTIME.'<br />';
			// echo "course['submitat'] - 1800 is :".($course['submitat'] - 1800).'<br />';
			// echo "course['submitat'] + course['cwlength'] + 1800 is :".($course['submitat'] + $course['cwlength'] + 1800).'<br />';exit();

            if($course['live_type'] != 4){
                $submitat = $course['submitat'] - 1800;
            }else{
                $submitat = $course['submitat'];
            }

			if($this->check == 1 && SYSTIME >= $submitat && SYSTIME <= ($course['submitat'] + $course['cwlength'] )) {	//开课时间前后半小时内，则直接进入直播界面
				// return $this->doLive($user,$course);
				$isliverun = TRUE;
				if(intval($this->input->get('flag')) == 1) {
					//进入直播页面则判定为出勤
					Ebh::app()->getApiServer('ebh')->reSetting()
                                ->setService('Classroom.Attendance.add')
                                ->addParams(array(
                                    'uid'  =>  $user['uid'],
                                    'cwid' =>  $cwid,
                                    'crid' =>  $roominfo['crid']
                                ))
                                ->request();
					return $this->doLive($user,$course);
				}
			}
		}
		$this->assign('isliverun',$isliverun);
		
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$course['viewnum'] = $viewnumlib->getViewnum('courseware',$cwid);
		//var_dump($course);die;
		if($is_zjdlr){//国土资源课件主讲人处理
			$cwuserinfo = $coursemodel->getcwUserinfo($course['cwid']);
			$this->assign('cwuser',$cwuserinfo);
		}
		if(!empty($course['islive']) && !empty($course['assistantid'])){
			$assistantlist = $this->model('user')->getUserInfoByUid(explode(',',$course['assistantid']));
			$this->assign('assistantlist',$assistantlist);
		}
        $this->assign('course', $course);
        $this->assign('course_detail',$course_detail);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
		$queryarr['filterstatus'] = -1;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $reviewcount = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($reviewcount);

		$shield = 0;
		$askmodel = $this->model('askquestion');
		$askcount = $askmodel->getRequiredAnswersCount(array('cwid'=>$cwid,'shield'=>$shield));
		$this->assign('askcount',$askcount);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());

		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$isfree = 0;
		$this->assign('iszjdlr',$is_zjdlr);
		$this->assign('isnewzjdlr',$is_newzjdlr);
		$this->assign('isfree',$isfree);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('user',$user);
		$this->assign('from',$from);
        $this->assign('reviews', $reviews);
		$this->assign('reviewcount',$reviewcount);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		if($type != 'flv' && $course['ism3u8'] == 1) {
			$type = 'flv';
		}
		//var_dump($type);

		$this->assign('type',$type);
		//做笔记
		$upcontrol = Ebh::app()->lib('UpcontrolLib');
		$editor = Ebh::app()->lib('UEditor');
		$this->assign('upcontrol', $upcontrol);
		$this->assign('editor', $editor);
		$param = array();
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		$notemodel = $this->model('note');
		$mynote = $notemodel->getFlashNoteBycwid($param);//获取笔记
		$this->assign('mynote', $mynote);

		//单个课件下的作业
		$exammodel  = $this->model('exam');
		$cwid = $this->uri->itemid;
		$param = array('cwid'=>$cwid,'stuid'=>$user['uid'],'status'=>1,'limit'=>'0,100');
		if($roominfo['isschool']==2){
			$examlist = $exammodel->getexamonlinelist($param);
		}else{
			$examlist = $exammodel->getschexamlistbycwid($param);
			$examlist = $this->_filterSchexams($examlist);
		}
		$this->assign('examlist', $examlist);

		//调查问卷
		$surveymodel = $this->model('survey');
		$survey = $surveymodel->getSurveyByCwid($cwid,$user['uid']);


		$this->assign('survey',$survey);
		$isapple = $this->_isApple();
		if($isapple) {
			$key = $this->getKey($user);
			$this->assign('isapple',$isapple);
			$this->assign('key',$key);
		} else {
			$this->assign('isapple',0);
			$this->assign('key',0);
		}
		$Zanmodel = $this->model('Userzan');
		$check = $Zanmodel->checkStatus(array('cwid'=>$cwid,'uid'=>$user['uid'],'crid'=>$roominfo['crid']));//验证是否点过赞
		if(!empty($check)){
			$this->assign('zan',1);
		}else{
			$this->assign('zan',0);
		}

		//获取word课件翻页等待时间
		$this->getAssignStime($course,$type);

        //如果是直播 获取liveinfo
        $showebhbrowser = false;
        if($course['islive']) {
            $othersetting = Ebh::app()->getApiServer('ebh')->reSetting()
                ->setService('Aroomv3.Room.othersetting')
                ->addParams('crid', $roominfo['crid'])->request();
            $useragent = $_SERVER['HTTP_USER_AGENT'];

            if(stripos($useragent,'window') !== false && stripos($useragent,'ebhbrowser') === false && stripos($useragent,'MSIE 6.0') === false && $othersetting && $othersetting['ebhbrowser'] == 1){
                $showebhbrowser = true;
            }

            $liveInfoModel = $this->model('Liveinfo');
            $liveinfo = $liveInfoModel->getLiveInfoByCwid($cwid);
            $this->assign('liveinfo',$liveinfo);
        }
        $this->assign('showebhbrowser',$showebhbrowser);

		//$stime
		if($type == 'flv' || $type == 'mp3' || empty($course['cwurl'])){

			$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
			$is_iphone = (strpos($agent, 'iphone')) ? true : false;
	        $is_android = (strpos($agent, 'android')) ? true : false;
	        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
	        $upconfig = Ebh::app()->getConfig()->load('upconfig');
	        $this->assign('uppicapi',$upconfig['pic']['server'][0]);
			if($is_iphone || $is_android || $is_ipad){
                $this->assign('is_mobile',true);
                if(isApp()){
                    $this->assign('is_app',true);
                    $time = SYSTIME;
                    $ip = $this->input->getip();
                    $auth = "$user[password]\t$user[uid]\t$ip\t$time\t$cwid";
                    $auth = authcode($auth, 'ENCODE');
                    $auth = base64_encode($auth);
                    $runlink = 'ebhlauncher://'.$auth;
                    $this->assign('runlink',$runlink);
                }
                if($course['islive']) {
                    $hlsservers = Ebh::app()->getConfig()->load('livetestserver');
                    if(!empty($hlsservers[0])) {
                        $hlsurl = str_replace('[liveid]', $course['liveid'], $hlsservers[0]);

                        $this->assign('liveurl',$hlsurl);
                    }
                }
				$this->display('myroom/course');
			}else{
				$this->display('myroom/course');
			}
		}else{

			$this->display('myroom/course');
		}
	}

	/*
	 获取学习记录，上次看到哪里
	*/
	public function getcurtimeajax(){
		$uid = intval($this->input->post('uid'));
		$cwid = intval($this->input->post('cwid'));
		$curtime = 0;
		if($uid > 0 && $cwid > 0){
			$data = array('uid'=>$uid,'cwid'=>$cwid);
			$apiServer = Ebh::app()->getApiServer('ebh');
			//通过接口方式调用最后一次学习记录
			$result = $apiServer->reSetting()->setService('Study.Log.get')->addParams($data)->request();
			if (!empty($result) && !empty($result['curtime']))
				$curtime = $result['curtime'];
		}
		echo $curtime;
	}
	//ajax的评论分页
	function getajaxpage(){
		$queryarr['pagesize'] = 10;
        $queryarr['cwid'] = intval($this->input->post('cwid'));
		$queryarr['page'] = intval($this->input->post('page'));
        $queryarr['upvote'] = intval($this->input->post('upvote'));

		$room = Ebh::app()->room->getcurroom();

    	$conf = Ebh::app()->getConfig()->load('othersetting');
    	$conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
    	$conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] :array();
    	$is_zjdlr = ($room['crid'] == $conf['zjdlr']) || (in_array($room['crid'],$conf['newzjdlr']));
    	$is_newzjdlr = in_array($room['crid'],$conf['newzjdlr']);
		if ($is_zjdlr) {
			$queryarr['audit'] = 1; //0 待审核, 1 审核通过, 2 审核不通过
		}

        $flushcache = intval($this->input->post('flushcache'));


		//取缓存造成删除不及时,刷新重复存在
		/*$reviewkey = $this->cache->getcachekey('course_review',$queryarr);
        if($flushcache != 1){
            $reviewlist = $this->cache->get($reviewkey);

            if(!empty($reviewlist)){
                echo json_encode($reviewlist);
                exit;
            }
        }*/
		$reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwidOnRecUrsion($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);

		$pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);
        $user = Ebh::app()->user->getloginuser();
		if(!empty($reviews)){
		    if ($is_zjdlr && !empty($user)) {
		        //国土局，评论显示点赞
                $reids = array_column($reviews, 'logid');
                $upvotes = $reviewmodel->upvotes($reids, $user['uid']);
            }
            $ipLib = Ebh::app()->lib('IPaddress');
            foreach ($reviews as $key => $review) {
                if(!empty($review['fromip'])){
                    $IPaddress = $ipLib->find($review['fromip']);
                    $reviews[$key]['ipaddress'] = rtrim(implode('-',$IPaddress),'-');
                }
                if (!empty($upvotes[$review['logid']])) {
                    $reviews[$key]['upvoted'] = true;
                }
            }
        }
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//数据格式化 时间和头像缩略图

		$reviewlist = array("reviews"=>$reviews,'pagestr'=>$pagestr,'count'=>$count);
		//$this->cache->set($reviewkey,$reviewlist,60);
		//json输出
		echo json_encode($reviewlist);
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
		$multipage = '<div class="pages"><div class="listPage">';
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
		$multipage .= '<script type="text/javascript">' . "\n"
				. '$(function(){' . "\n"
				. '$("#gopage").keypress(function(e){' . "\n"
				. 'if (e.which == 13){' . "\n"
				. '$(this).next("#page_go").click()' . "\n"
				. 'cancelBubble(this,e);' . "\n"
				. '}' . "\n"
				. '})' . "\n"
				. '})</script>';
		return $multipage;

	}

	/**
	 *按课程布置的作业筛选为当前用户有权限的作业
	 */
	private  function _filterSchexams($schexamlist = array()){

		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();

		$classModel = $this->model('classes');
		$myclass = $classModel->getClassByUid($roominfo['crid'],$user['uid']);

		if(empty($myclass)){
			return array();
		}
		$newSchexamList = array();
		if(!empty($schexamlist)){
			$folderid = $schexamlist[0]['folderid'];
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1,'folderid'=>$folderid);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);

			foreach ($schexamlist as $schexam) {
				if($schexam['classid'] == $myclass['classid']){
					$newSchexamList[] = $schexam;
					continue;
				}

				if(!empty($myclass['grade'])) {
					if($myclass['grade'] == $schexam['grade'] && $myclass['district'] == $schexam['district']){
						$newSchexamList[] = $schexam;
						continue;
					}
				}
				if(!empty($myfolderlist)){
					$newSchexamList[] = $schexam;
				}
			}


		}

		return $newSchexamList;
	}
	/**
	*生成包含用户信息的key，目前主要
	*/
	private function getKey($user,$cwurl='',$id=0) {
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time\t$cwurl\t$id";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}
	/*
	*提交笔记
	*/
	public function addnote(){
		$cwid = $this->input->post('cwid');
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = array();
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		$notemodel = $this->model('note');
		$mynote = $notemodel->getFlashNoteBycwid($param);//获取笔记
		$param['ftext'] = $this->input->post('message');
		$param['crid'] = $roominfo['crid'];

		if(empty($mynote)){//新增笔记
			$res = $notemodel->addFlashNote($param);
		}else{//修改笔记
			$res = $notemodel->editFlashNote($param);
		}
		if($res !== false)
			echo 'success';
		else
			echo 'error';
	}

	/*
	课件相关问题列表
	*/
	public function linkask(){
		$cwid = $this->input->post('cwid');
		if(!is_numeric($cwid))
			exit;
		$param['cwid'] = $cwid;

		//从缓存取第一页数据 -memcache-
		$linkedquestionskey = $this->cache->getcachekey('linkedquestionskey',array('cwid'=>intval($cwid),'page'=>1,'pagesize'=>10));
	    $linkedquestions = $this->cache->get($linkedquestionskey);
	    if(!empty($linkedquestions)){
	    	echo json_encode($linkedquestions);
	    	exit;
	    }
	    Ebh::app()->getDb()->set_con(0);//主数据库读取，防止数据来不及同步
		$askmodel = $this->model('askquestion');
		// $linkedquestions['list'] = $askmodel->getRequiredAnswers($param);
		// $linkedquestions['list'] = EBH::app()->lib('UserUtil')->init($linkedquestions['list'],array('uid','tid','lastansweruid'),true);
		// $linkedquestions['count'] = $askmodel->getRequiredAnswersCount($param);
		$param['shield'] = 0;
		$linkedquestions['list'] = $askmodel->getallasklist($param);
        $linkedquestions['count'] = $askmodel->getallaskcount($param);

		foreach($linkedquestions['list'] as $akey=>$avalue) {
			if(!empty($avalue['face'])){
				$linkedquestions['list'][$akey]['face'] = getthumb($avalue['face'],'50_50');
			}else{
				if($avalue['sex']==1){
					if($avalue['groupid']==5){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_woman.jpg';
					}else{
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
					}
				}else{
					if($avalue['groupid']==5){
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
					}else{
						$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
					}
				}

				$linkedquestions['list'][$akey]['face'] = getthumb($defaulturl,'50_50');
			}
		}
		//第一页60s
		$this->cache->set($linkedquestionskey,$linkedquestions,60);
		echo json_encode($linkedquestions);
	}
	/**
	*验证IP
	*/
	private function checkAllowIp() {
		$limittime = 10800;	//限制3小时
		$user = Ebh::app()->user->getloginuser();
		$curip = $this->input->getip();
		$allowip = $user['allowip'];
		$curtime = SYSTIME;
		$usermodel = $this->model('User');
		if(empty($allowip)) {
			$userparam = array('allowip'=>$curip);
			$usermodel->update($userparam,$user['uid']);
			return TRUE;
		} else {
			if($curip != $allowip) {	//如果允许的IP和当前IP不同，则跳转到等待页面
				$limitmodel = $this->model('Limitlog');
				$limitparam = array('uid'=>$user['uid'],'fromip'=>$curip,'isfinish'=>0);
				$mylog = $limitmodel->getLogByIp($limitparam);
				if(empty($mylog)) {	//不存在，则新生成记录
					$limitparam['startdate'] = $curtime;
					$limitmodel->addlog($limitparam);
				} else {
					if(($curtime - $mylog['startdate']) >= $limittime) {	//等待时间够了，则更新
						$userparam = array('allowip'=>$curip);
						$usermodel->update($userparam,$user['uid']);
						$limitparam['isfinish'] = 1;
						$limitparam['enddate'] = $curtime;
						$limitmodel->update($limitparam,$mylog['logid']);
						return TRUE;
					}
				}
//				$url = '/safe.html';
//				header("Location: $url");
//				exit();
				return FALSE;
			}
			return TRUE;
		}
	}
	/**
	*处理直播信息
	*/
	private function doLive($user,$course) {

	    $h5 = $this->input->get('h5');

	    if(!empty($h5)){
            $this->doH5Live($user,$course);
        }else{
            $this->doNewLive($user,$course);
        }

	}

    /**
     * h5版本直播
     * @param $user
     * @param $course
     */
    private function doH5Live($user,$course){
        $user = Ebh::app()->user->getloginuser();
        $input = EBH::app()->getInput();
        $auth = $input->cookie('auth');

        $this->assign('auth',$auth);

        $this->assign('user',$user);


        $liveInfoModel = $this->model('Liveinfo');
        $liveconfig = Ebh::app()->getConfig()->load('live');
        $live = $liveInfoModel->getLiveInfoByCwid($course['cwid']);

        if(!$live){
            echo "该课件不支持h5版本";
        }

        $hlsurl = str_replace('[liveid]', $course['liveid'].'s', $live['httppullurl']);
        $course['purl'] = $hlsurl;
        $cameraurl = str_replace('[liveid]', $course['liveid'].'c', $live['httppullurl']);
        $course['cameraurl'] = $cameraurl;
        $this->assign('course',$course);
        $this->display('im/h5livecourse');

    }
    private function doNewLive($user,$course){
        $user = Ebh::app()->user->getloginuser();
        $input = EBH::app()->getInput();
        $auth = $input->cookie('auth');

        $this->assign('auth',$auth);

        $this->assign('user',$user);
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
        if($is_iphone || $is_android || $is_ipad){
            /*$hlsservers = Ebh::app()->getConfig()->load('hlsservers');
            if(!empty($hlsservers['teacherdoc'])) {
                $hlsurl = str_replace('[liveid]', $course['liveid'], $hlsservers['teacherdoc']);
                $course['purl'] = $hlsurl;
            }
            if(!empty($hlsservers['teachercamera'])){
                $cameraurl = str_replace('[liveid]', $course['liveid'], $hlsservers['teachercamera']);
                $course['cameraurl'] = $cameraurl;
            }*/

            $liveInfoModel = $this->model('Liveinfo');
            $liveconfig = Ebh::app()->getConfig()->load('live');
            $live = $liveInfoModel->getLiveInfoByCwid($course['cwid']);
            if(!$live){//如果直播信息不存在 则直接读取Sata信息
                $live['httppullurl'] = '';
                $live['hlspullurl'] = $liveconfig['Sata']['hlsPurllUrl'];
                $live['rtmppullurl'] = $liveconfig['Sata']['rtmpPullUrl'];
                $live['pushurl'] = $liveconfig['Sata']['pushUrl'];
            }

            $hlsurl = str_replace('[liveid]', $course['liveid'].'s', $live['hlspullurl']);
            $course['purl'] = $hlsurl;
            $cameraurl = str_replace('[liveid]', $course['liveid'].'c', $live['hlspullurl']);
            $course['cameraurl'] = $cameraurl;

            $this->assign('course',$course);
            $this->display('im/wap_live_view');
        }else{

            $liveInfoModel = $this->model('Liveinfo');
            $liveconfig = Ebh::app()->getConfig()->load('live');
            $live = $liveInfoModel->getLiveInfoByCwid($course['cwid']);
            if(!$live){//如果直播信息不存在 则直接读取Sata信息
                $live['httppullurl'] = '';
                $live['hlspullurl'] = $liveconfig['Sata']['hlsPurllUrl'];
                $live['rtmppullurl'] = $liveconfig['Sata']['rtmpPullUrl'];
                $live['pushurl'] = $liveconfig['Sata']['pushUrl'];
            }

            $hlsurl = str_replace('[liveid]', $course['liveid'].'s', $live['hlspullurl']);
            $course['purl'] = $hlsurl;
            $cameraurl = str_replace('[liveid]', $course['liveid'].'c', $live['hlspullurl']);
            $course['cameraurl'] = $cameraurl;
            $this->assign('course',$course);
            $this->display('im/livecourse');
        }



    }



    private function doNewLiveTest($user,$course){
        $user = Ebh::app()->user->getloginuser();
        $input = EBH::app()->getInput();
        $auth = $input->cookie('auth');

        $this->assign('auth',$auth);

        $this->assign('course',$course);
        $this->assign('user',$user);
        $this->display('im/livecourse');
    }
	/**
	*连接直播测试环境
	*/
	private function doLiveTest($user,$course) {
		$liveapi = Ebh::app()->getConfig()->load('liveapi');
        $meetingPwd = $liveapi['defaultPwd'];
		$ts = SYSTIME;
		$d = $course['liveid'];
		$m = $user['username'];
		$t = urlencode(base64_encode($course['title']));
		$j = 'Join';
		$n = 1;
		$p = $meetingPwd;
		$meetingStartTime  = $course['truedateline'];
		$lessonDurationTime = $course['cwlength'];
		$Teachinfo = empty($course['realname'])?$course['username']:$course['realname'];
		$Teachinfo = urlencode($Teachinfo);
		$r = empty($user['realname'])?$user['username']:$user['realname'];
		$r = urlencode($r);
		$isSynchronization = 1;
		$isCDN = 1;
		$receiveDataType  = 'all';
		$needJoinSystem = 1;
		$cdnIp = 'rtmp://ebhrtmpplay.satacdn.com/ebhlive/'; //sataCDN
//		$cdnIp = 'rtmp://tangqiaortmpplay.dnion.com/tangqiao/'; //dnionCDN
		//$IMUrl = 'chat.ebh.net';
		$IMUrl = 'im.knowle.cn';	//测试环境im
		$mp = 'chat81.ebh.net';
		$isie89 = FALSE;
		if(stripos($_SERVER["HTTP_USER_AGENT"],'MSIE 8.0') || stripos($_SERVER["HTTP_USER_AGENT"],'MSIE 9.0')) {
			$isie89 = TRUE;
		}
		$prefix = $isie89 ? 'https' : 'http';
		$url = "$prefix://im.knowle.cn/flash/TBMeetingFlaClient.php?ts=$ts&d=$d&m=$m&t=$t&j=$j&n=$n&p=$p&meetingStartTime=$meetingStartTime&lessonDurationTime=$lessonDurationTime&Teachinfo=$Teachinfo&r=$r&isSynchronization=$isSynchronization&isCDN=$isCDN&receiveDataType=$receiveDataType&needJoinSystem=$needJoinSystem&cdnIp=$cdnIp&IMUrl=$IMUrl&mp=$mp";
		header("Location: $url");
//echo $url;
		exit();

		//$url = "http://chat.ebh.net/flash/TBMeetingFlaClient.php?ts=1465309577&d=352424416&m=xuesheng7&t=5Y6L5Yqb5Y6L5Yqb&j=Join&n=1&p=techbridge-inc&meetingStartTime=1465287660&lessonDurationTime=35100&Teachinfo=%E6%88%91%E6%98%AF%E8%A8%80%E5%8D%88&r=%E5%AD%A6%E7%94%9F7&isSynchronization=1&isCDN=1&receiveDataType=all&needJoinSystem=1&cdnIp=rtmp://ebhrtmpplay.satacdn.com/ebhlive/ &IMUrl=chat.ebh.net&mp=192.168.0.153";
	}
	/**
	*连接直播正式环境
	*/
	private function doLiveOnline($user,$course) {
		$liveapi = Ebh::app()->getConfig()->load('liveapi');
        $meetingPwd = $liveapi['defaultPwd'];
		$ts = SYSTIME;
		$d = $course['liveid'];
		$m = $user['username'];
		$t = urlencode(base64_encode($course['title']));
		$j = 'Join';
		$n = 1;
		$p = $meetingPwd;
		$meetingStartTime  = $course['truedateline'];
		$lessonDurationTime = $course['cwlength'];
		$Teachinfo = empty($course['realname'])?$course['username']:$course['realname'];
		$Teachinfo = urlencode($Teachinfo);
		$r = empty($user['realname'])?$user['username']:$user['realname'];
		$r = urlencode($r);
		$isSynchronization = 1;
		$isCDN = 1;
		$receiveDataType  = 'all';
		$needJoinSystem = 1;
		$cdnIp = 'rtmp://ebhrtmpplay.satacdn.com/ebhlive/';
		$IMUrl = 'chat.ebh.net';
		$mp = 'chat3.ebh.net';
		$isie89 = FALSE;
		if(stripos($_SERVER["HTTP_USER_AGENT"],'MSIE 8.0') || stripos($_SERVER["HTTP_USER_AGENT"],'MSIE 9.0')) {
			$isie89 = TRUE;
		}
		$prefix = $isie89 ? 'https' : 'http';
		$url = "$prefix://chat.ebh.net/flash/TBMeetingFlaClient.php?ts=$ts&d=$d&m=$m&t=$t&j=$j&n=$n&p=$p&meetingStartTime=$meetingStartTime&lessonDurationTime=$lessonDurationTime&Teachinfo=$Teachinfo&r=$r&isSynchronization=$isSynchronization&isCDN=$isCDN&receiveDataType=$receiveDataType&needJoinSystem=$needJoinSystem&cdnIp=$cdnIp&IMUrl=$IMUrl&mp=$mp";
		header("Location: $url");
//echo $url;
		exit();

		//$url = "http://chat.ebh.net/flash/TBMeetingFlaClient.php?ts=1465309577&d=352424416&m=xuesheng7&t=5Y6L5Yqb5Y6L5Yqb&j=Join&n=1&p=techbridge-inc&meetingStartTime=1465287660&lessonDurationTime=35100&Teachinfo=%E6%88%91%E6%98%AF%E8%A8%80%E5%8D%88&r=%E5%AD%A6%E7%94%9F7&isSynchronization=1&isCDN=1&receiveDataType=all&needJoinSystem=1&cdnIp=rtmp://ebhrtmpplay.satacdn.com/ebhlive/ &IMUrl=chat.ebh.net&mp=192.168.0.153";
	}
	/**
	*判断当前是否为Apple系统产品浏览器
	*/
	private function _isApple() {
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if (strpos($useragent, 'ipad') !== FALSE || stripos($useragent, 'iphone') !== FALSE)
			return TRUE;
		return FALSE;
	}
	/**
	 * [getanalysisajax 通过ajax进行课件分析统计的读取]
	 * @return [type] [description]
	 */
	public function getanalysisajax(){
		$cwid = intval($this->input->post('cwid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$rcmodel = $this->model('roomcourse');
		$folder = $rcmodel->getFolderByCwid($cwid,$roominfo['crid']);
		$foldermodel = $this->model('Folder');
		$coursemodel = $this->model('Courseware');
		$cwlength = $coursemodel->getcwlengthBycwid($cwid);
		//var_dump($cwdetail);
		$myfolder = $foldermodel->getfolderbyid($folder['folderid']);//获取对应课件所在课程的详细属性
		if($roominfo['isschool'] == 7){
			$uidstr = '';
			if($myfolder['isschoolfree'] == 1){//免费
				$grade = -1;
				$classmodel = $this->model('Classes');
				$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade);//该网校对应年级所有的学生信息
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
			}elseif($myfolder['isschoolfree']==0 && $myfolder['fprice']==0){
					$uidstr = '';
					$grade = -1;
					$classmodel = $this->model('Classes');
					$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade);//该网校对应年级所有的学生信息
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
				$uidlist = $upmodel->getUserIdListByFolder($folder['folderid']);
				if(!empty($uidlist)) {
					foreach($uidlist as $uiditem) {
						if(empty($uidstr)) {
							$uidstr = $uiditem['uid'];
						} else {
							$uidstr .= ','.$uiditem['uid'];
						}
					}
					$userlist = $upmodel->getUserAndClassListByUidStr($roominfo['crid'],$folder['folderid'],$uidstr,'');
					$userscount = count($userlist);
				}
			}
		}else{
			$uidstr = '';
			$grade = $myfolder['grade'];
			$classmodel = $this->model('Classes');
			if(!empty($grade)) {//按年级
				$userlist = $classmodel->getStudentListByGrade($roominfo['crid'],$grade);
			}else{//按班级
				$classlist = $classmodel->getTeacherClassList($roominfo['crid'],$myfolder['uid']);
				$classids = '';
				foreach ($classlist as $c) {
					$classids .= $c['classid'].',';
				}
				$classids = rtrim($classids,',');
				$userlist = $classmodel->getClassStudentList(array('classidlist'=>$classids,'limit'=>1000));

			}
			if(!empty($userlist)){
				foreach($userlist as $uiditem) {
					if(empty($uidstr)) {
						$uidstr = $uiditem['uid'];
					} else {
						$uidstr .= ','.$uiditem['uid'];
					}
				}
			}
			$userscount = count($userlist);
		}
		$ltimemine = 0;$ord = 0;$ltimeave = 0;
		$user = Ebh::app()->user->getloginuser();
		if(!empty($cwid) && !empty($uidstr) && !empty($user['uid'])){
			$plmodel = $this->model('Playlog');
			$studycount = $plmodel->getCWStudyByUidStr(array('cwids'=>$cwid,'uids'=>$uidstr));
			//var_dump($studycount);
			$studycount = ($studycount == null)?0:$studycount;
			//var_dump($playloglist);
			$playlogarr = array();
			//累计时长
			$sumlist = $plmodel->getCWSumltimeList(array('cwid'=>$cwid,'uids'=>$uidstr));
			$sum = 0;
			foreach ($sumlist as $key => $sl) {
						if($sl['uid'] == $user['uid']){
							$ltimemine = $sl['sumltime'];
							$ord = $key + 1;
						}
						$sum+= $sl['sumltime'];
					}
			if($studycount !=0){
				$ltimeave = $sum/$studycount;
			}
			$setarr = array();
			$setarr['uid'] = $user['uid'];
			$setarr['cwid'] = $cwid;
			$times = $plmodel->getCountByCwid($setarr);
		}
		$userscount = empty($userscount)?1:$userscount;
		$studycount = ($studycount>$userscount)?$userscount:$studycount;
		$cwtime = empty($cwlength['cwlength'])?0:$cwlength['cwlength'];
		$setarr = array('userscount'=>$userscount,
						'studycount'=>$studycount,
						'cwtime'=>ceil($cwtime/60),
						'ltimemine'=>round($ltimemine/60),
						'ord'=>$ord,
						'ltimeave'=>round($ltimeave/60),
						'times'=>$times
			);
		echo json_encode($setarr);
	}
	/**
	 * [addzan 课件点赞]
	 * @return [type] [description]
	 */
	public function addzan(){
		$cwid = intval($this->input->post('cwid'));
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(empty($cwid) || empty($roominfo) || empty($user)){
			echo json_encode(array('status'=>0,'msg'=>'非法请求'));
			exit;
		}
		//检查是否点过赞
		$param =array();
		$param['uid'] = $user['uid'];
		$param['cwid'] = $cwid;
		$param['crid'] = $roominfo['crid'];
		$Zanmodel = $this->model('Userzan');
		$check = $Zanmodel->checkStatus($param);
		if(!empty($check)){
			echo json_encode(array('status'=>0,'msg'=>'您已经赞过啦！'));
			exit;
		}
		$res = $Zanmodel->add($param);
		$coursemodel = $this->model('Courseware');
		$coursemodel->addzan($cwid);
		if(!empty($res)){
			echo json_encode(array('status'=>1));
		}
	}

	/*
	 * 获取word等课件翻页需要等待的时间,主要是针对国土厅网校
	 */
	private function getAssignStime($course,$type){
	    //word等課件每頁等待時間
	    $stime = 0;
	    if(in_array($type,array('doc','docx'))!==false){
	        $setting = Ebh::app()->room->getSystemSetting();
	        $jsonobj = json_decode($setting['creditrule']);
	        if(!empty($jsonobj) && !empty( $jsonobj->notvideo)){
	            if($jsonobj->notvideo->on==1){
	                $needtime = $jsonobj->notvideo->needtime;
	            }
	        }
	        //从课件设置中读取
	        $delaytime = !empty($course['delaytime']) ? intval($course['delaytime']) :  0;
	        $stime = !empty($delaytime) ? $delaytime : (!empty($needtime) ? intval($needtime) : 0 );
	    }
	    $this->assign('stime',$stime);
	}

    /**
     * 评论点赞
     */
    public function ajax_upvote() {
	    if (!$this->isPost()) {
	        echo json_encode(array(
	            'errno' => 1,
                'msg' => '非法访问'
            ));
	        exit();
        }
        $user = Ebh::app()->user->getloginuser();
	    if (empty($user)) {
            echo json_encode(array(
                'errno' => 2,
                'msg' => '未登录'
            ));
            exit();
        }
        $logid = intval($this->input->post('logid'));
	    if ($logid < 1) {
            echo json_encode(array(
                'errno' => 3,
                'msg' => '参数错误'
            ));
            exit();
        }
        $roominfo = Ebh::app()->room->getcurroom();
        $model = $this->model('Review');
	    $ret = $model->upvote($logid, $user['uid'], $roominfo['crid']);
	    if (!$ret) {
            echo json_encode(array(
                'errno' => 4,
                'msg' => '点赞失败'
            ));
            exit();
        }
        echo json_encode(array(
            'errno' => 0
        ));
        exit();
    }
}
