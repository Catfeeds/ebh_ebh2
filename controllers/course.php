<?php
/**
 * 课件详情
 */
class CourseController extends CControl {
	private $check = 1;
	function view() {
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$roominfo = Ebh::app()->room->getcurroom();
        if(empty($roominfo)){
            echo  '课件所属的学校不存在';
            exit;
        }
        //$roominfo['isdesign'] = 0;
		$user = Ebh::app()->user->getloginuser();
		$from = $this->uri->uri_attr(0);	//来源，0或空为全校课程 1 为我的课程 2 为教师课程
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
        if(empty($course) || $course['status'] != 1) {
            exit();
        }
        //免费试听列表
        //print_r($roominfo);exit;
        $currentdomain = getdomain();
        $this->assign('currentdomain', $currentdomain);
        $roommodel = $this->model('classroom');
        $roomdetail  = $roommodel->getclassroomdetail($roominfo['crid']);
        $administrator = null;
        $apiServer = Ebh::app()->getApiServer('ebh');
        if (empty($roominfo['isdesign']) && $roominfo['template'] == 'plate') {
            //plate模板输出头部
            $plate_model = $this->model('Plate');
            $top_components = $plate_model->getPublicTopComponent($roominfo['crid']);
            if (isset($top_components[2])) {
                //导航菜单
                $tourl = null;
                $navigatordata = $plate_model->getNavigator($roominfo['crid'], $tourl);
                $top_components[2]['menu'] = $navigatordata;
                if (!empty($user)) {
                    $top_components[2]['user'] = $user;
                    $top_components[2]['logined'] = true;
                    if ($user['uid'] == $roominfo['uid']) {
                        $top_components[2]['is_admin'] = true;
                    }
                }
                if (!empty($top_components[2]['arg_sign'])) {
                    $theme = $this->_get_course_menu_theme($top_components[2]['background_color']);
                    $this->assign('menu_theme', $theme);

                    $course_menus = $plate_model->getCourseMenu($roominfo['crid']);
                    $this->assign('course_menus', $course_menus);
                }
            }
            if (isset($top_components[1])) {
                $top_components[1]['forfreeware'] = true;
            }
            $this->assign('top_components', $top_components);
            $currentdomain = getdomain();
            $this->assign('currentdomain', $currentdomain);
            $roomdetail = array_merge($roominfo, $roomdetail);
            $this->assign('roomdetail', $roomdetail);
            $global_qcode = $roomdetail['wechatimg'];
            if (!empty($top_components[13]['custom_data']['options'][0]['image'])) {
                $global_qcode = show_plate_img($top_components[13]['custom_data']['options'][0]['image']);
            }
            $this->assign('global_qcode', $global_qcode);
        }

        if (!empty($roominfo['isdesign']) && $roominfo['template'] == 'plate') {
            $this->assign('isplate', true);
            $freeware_list = $apiServer->reSetting()
                ->setService('Courseware.Frees.index')
                ->addParams('crid', $roominfo['crid'])
                ->addParams('withAdmin', 1)
                ->request();
            if (empty($freeware_list)) {
                exit();
            }
        } else {
            $freeware_list = $this->model('Courseware')->getcourselist(array(
                'crid' => $roominfo['crid'],
                'isfree' => 1
            ), true);
        }

        if (!isset($freeware_list[$course['cwid']])) {
            exit();
        }
        if (isset($freeware_list[$course['cwid']]['administrator'])) {
            $administrator = $freeware_list[$course['cwid']]['administrator'];
        }
        if (!empty($course['islive']) && intval($this->input->get('review')) == 0) {
            //直播处理
            $this->_showLive($course, $administrator);
            exit();
        }
        //是否启用课程开场内容
        $othersetting = Ebh::app()->getConfig()->load('othersetting');
        if (!empty($othersetting['open-intro']) && is_array($othersetting['open-intro']) && in_array($roominfo['crid'], $othersetting['open-intro'])) {
            //读取课程开场内容
            $intorModel = $this->model('Intro');
            $intro = $intorModel->getDetail($course['folderid']);
            if (!empty($intro) && $intro['introtype'] != '0') {
                $intortype = intval($intro['introtype']);
                if ($intortype == 1) {
                    //读取视频
                    $vedio = $this->model('Attachment')->getIntro($intro['attid']);
                    if (!empty($vedio)) {
                        $intro['sourceurl'] = trim($vedio['source'], '/') . '/' . 'attach.html?troid=' . $intro['attid'];
                    } else {
                        $intro = null;
                    }
                }
                if ($intortype == 2) {
                    $intro['slides'] = json_decode($intro['slides'], true);
                    $intro['slides'] = array_filter($intro['slides'], function ($slide) {
                        return intval($slide['interval']) > 0;
                    });
                }
                $this->assign('intro', $intro);
            }
        }

        //已支持独立域名获取网校信息，以下代码不必要
		//$crid = $course['crid'];
		//$roominfo = $this->model('classroom')->getclassroomdetail($crid);
        if (!empty($user)) {
		    $this->assign('logined', true);
        }
		//判断用户是否点赞过
        $praised = $coursemodel->checkPraise($user['uid'], $course['cwid'], $roominfo['crid']);
        $this->assign('praised', $praised);
		//课件详情
		$coursedetail = $coursemodel->getcoursedetails($cwid);
		if(!empty($course)) {	//生成课件所在服务器地址
			$serverutil = Ebh::app()->lib('ServerUtil');
			$source = $serverutil->getCourseSource();
			if(!empty($source)) {
				$course['cwsource'] = $source;
			}
		}
		//$count = $coursemodel->getexamcount($cwid);
		$type = $this->input->get('type');	//如果type为1则表示普通播放，即不采用rtmp方式播放
		if($course['ism3u8'] == 1 && $type != 1) {	//rtmp特殊处理 
			if($roominfo['domain'] == 'dh') {
				$m3u8source = $serverutil->getZKM3u8CourseSource();
			} else {
				$m3u8source = $serverutil->getM3u8CourseSource();
			}
			if(!empty($m3u8source)) {
				$key = $this->getKey(!empty($administrator) ? $administrator : $user);
				$key = urlencode($key);
				$m3u8url = "$m3u8source?k=$key&id=$cwid&.m3u8";
				$course['m3u8url'] = $m3u8url;
			}
		} else if($course['isrtmp'] == 1 && $type != 1) {	//rtmp特殊处理 
			$rtmpsource = $serverutil->getRtmpCourseSource();
			if(!empty($rtmpsource)) {
				$key = $this->getKey(!empty($administrator) ? $administrator : $user);
				$cwurl = $course['cwurl'];
				$key = urlencode($key);
				$rtmpurl = "$rtmpsource?k=$key&id=$cwid/flv:$cwurl";
				$course['rtmpurl'] = $rtmpurl;
			}
		}

		$this->assign('course', $course);
		//读取课件所属教师信息
        $teacher = $this->model('Teacher')->getteacherdetail($course['uid']);
        $this->assign('teacher', $teacher);

		//$this->assign('count', $count);
		//添加课件查看数
		//添加课件查看数
		// $coursemodel->addviewnum($cwid);
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		$course['viewnum'] = $viewnumlib->getViewnum('courseware',$cwid);

        if (!empty($freeware_list)) {
            array_walk($freeware_list, function(&$v, $k, $lib) {
                $v['viewnum'] = $lib->getViewnum('courseware', $v['cwid'], $v['viewnum']);
            }, $viewnumlib);
            if ($course['crid'] == 14083) {
                //免费试听排序，临时代码
                $topIds = array(195001, 195003, 195005, 195007, 195009, 195011);
                $cwids = array();
                foreach ($freeware_list as $freedate) {
                    $cwids[] = in_array($freedate['cwid'], $topIds) ? $freedate['cwid'] : PHP_INT_MAX;
                }
                array_multisort($cwids, SORT_ASC, SORT_NUMERIC, $freeware_list);
            }
            if ($course['crid'] == 14283) {
                //http://xz.ebh.net/，望真艺教网校
                $topIds = array(207789 , 207791, 207793, 207795, 207797, 207799);
                $cwids = array();
                foreach ($freeware_list as $freedate) {
                    $cwids[] = in_array($freedate['cwid'], $topIds) ? $freedate['cwid'] : PHP_INT_MAX;
                }
                array_multisort($cwids, SORT_ASC, SORT_NUMERIC, $freeware_list);
            }
        }
        $this->assign('freewarelist', $freeware_list);
        //所属教师课程列表
        $folder_model = $this->model('Folder');
        $folderids = $folder_model->getMasterFolderids($course['uid'], $roominfo['crid']);
        $folders = $folder_model->getFolderForTeacherList($folderids, $roominfo['crid'], true);
        if (!empty($folders)) {
            array_walk($folders, function(&$v, $k, $lib) {
                $v['viewnum'] = $lib->getViewnum('folder', $v['folderid'], $v['viewnum']);
            }, $viewnumlib);
        }
        $this->assign('folders', $folders);
		$hasnobtn = $this->uri->uri_attr(0);	//是否不显示开始听课按钮
		if($hasnobtn == 1) {
			$hasnobtn = TRUE;
		} else {
			$hasnobtn = FALSE;
		}
		$this->assign('hasnobtn',$hasnobtn);
		$user = Ebh::app()->user->getloginuser();
		$this->assign('coursedetail', $coursedetail);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $reviewcount = $reviewmodel->getReviewCountByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);

		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//单个课件下的作业
		$exammodel  = $this->model('exam');
		$param = array('cwid'=>$cwid,'limit'=>'0,100');
		$examlist = $exammodel->getexamonlinelist($param);
		$this->assign('examlist', $examlist);
		//针对isschool为7并且价格不为0的情况还要判断是否有课程权限
		if($course['fprice'] > 0 && $roominfo['isschool'] == 7) {
			$perparam = array('crid'=>$roominfo['crid'],'folderid'=>$course['folderid'],'cwid'=>$cwid);
			if($this->check == 1) {	//有学校权限，那就判断是否有课程权限
				$this->check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
			}
			//$this->assign('check',$this->check);
			if($this->check != 1) {
				$payitem = Ebh::app()->room->getUserPayItem($perparam);
				$this->assign('payitem',$payitem);
				if(!empty($payitem)) {
					$checkurl = 'http://'.$roominfo['domain'].'.ebh.net/ibuy.html?itemid='.$payitem['itemid'];	//购买url
					if($roominfo['domain'] == 'yxwl') {	//易学网络 专门处理，直接跳转到转账
						$checkurl = '/classactive/bank.html';
					}
					$this->assign('checkurl',$checkurl);
				}
			} else {
				$course['looktime'] = 0;//有权限就把试听时间去掉
			}
		}
		if($course['isfree'] == 1 || ($course['fprice'] == 0 && $roominfo['isschool'] == 7) || $course['looktime']) {	//如果免费课程，则直接能播放，有试听的可以试听
			$this->check = 1;
		}
		if ($course['cprice'] == 0 && $course['looktime'] > 0) {
			$course['looktime'] = 0;//价格为0的，有试听时间就可以免费观看全部
		}
		if (!empty($administrator)) {
		    //验证是否主页装扮免费试听视频
            $this->check = 1;
        }
		if ($this->check != 1) {//没试听，且没权限
		    //无权限时直接跳到首页
            header('Location: /');
            exit();
        }
        $this->assign('course', $course);
		$this->assign('check',$this->check);
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$free = 2;
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		if($type != 'flv' && $course['ism3u8'] == 1) {
			$type = 'flv';
		}
		$this->assign('type',$type);
		$this->assign('free',$free);
		$this->assign('myfavorite',$myfavorite);
        if (!empty($user)) {
            $user['showname'] = !empty($user['realname']) ? $user['realname'] : $user['username'];
            $user['isadmin'] = $user['groupid'] == 5;
        }
		$this->assign('user',$user);
		$this->assign('from',$from);
        $this->assign('reviews', $reviews);
        $this->assign('reviewcount',$reviewcount);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
		$this->assign('count',$count);
		$auth = $this->input->get('k');
		$this->assign('k', $auth);

		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;

        $room_type = Ebh::app()->room->getRoomType();
        if (!empty($roominfo['isdesign']) && $roominfo['template'] == 'plate') {
            $room_type = Ebh::app()->room->getRoomType();
            $roomtype = Ebh::app()->room->getRoomType();
            $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.getdesign')
                ->addParams('crid', $roomdetail['crid'])
                ->addParams('roomtype', $room_type)
                ->request();
            if (!empty($ret['status'])) {
                $head = stripslashes(isset($ret['data']['head']) ? $ret['data']['head'] : '' );
                //重置头部视频封面
                $vedioPattern = '/<div\s+class="player module.+?<\/div><\/div>/i';
                $head = preg_replace_callback($vedioPattern, function($m) {
                    if (preg_match('/thumb&quot;:&quot;(.+?)&quot;/i', $m[0], $thumbs)) {
                        $thumb = $thumbs[1];
                        $m[0] = preg_replace_callback('/<img\s+class="cover".+?>/', function($cover) use($thumb) {
                            return '<img class="cover" src="'.$thumb.'" />';
                        }, $m[0]);
                    };
                    return $m[0];
                }, $head);
                $this->assign('head', $head);
                $this->assign('foot', stripslashes(isset($ret['data']['foot']) ? $ret['data']['foot'] : ''));
                $settings = stripslashes(isset($ret['data']['settings']) ? $ret['data']['settings'] : '');
                $settings = json_decode($settings, true);
                $this->assign('settings', $settings);
                if (!empty($user)) {
                    $plateUser = array(
                        'showname' => $user['showname'],
                        'username' => $user['username'],
                        'realname' => $user['realname'],
                        'groupid' => $user['groupid'],
                        'isadmin' => $user['isadmin'],
                        'face' => getavater($user, '120_120'),
                        'lastlogtime' => $user['lastlogintime']
                    );
                    $this->assign('plateUser', $plateUser);
                }

            }
        }

        //新版手机端免费试听
        //$showMobile = intval($this->input->get('showMobile'));
        if (is_mobile()) {
            $this->room = Ebh::app()->room->getcurroom();
            $this->user = Ebh::app()->user->getloginuser();
            $this->getHeaderAndFooter();
        	$this->display('shop/plate/course_mobile');
        	exit;
        }

		if($is_iphone || $is_android || $is_ipad){
			$this->display('common/course_mobile');
		}else{
        	$this->display('common/course');
        }
	}

	private function _showLive($course, $administrator) {
        $system_setting = Ebh::app()->room->getSystemSetting();
        if (!empty($system_setting)) {
            $this->assign('system_setting', $system_setting);
        }
        $user = Ebh::app()->user->getloginuser();
        /*$input = EBH::app()->getInput();
        $auth = $input->cookie('auth');

        $this->assign('auth',$auth);

        $this->assign('user',$user);*/
        //获取资源
        $courseSource = $this->model('Source')->getFileBySid($course['sourceid']);
        $this->assign('courseSource',$courseSource);
        $roominfo = Ebh::app()->room->getcurroom();
        $isliverun = false;
        if($course['live_type'] != 4){
            $submitat = $course['submitat'] - 1800;
        }else{
            $submitat = $course['submitat'];
        }
        if (SYSTIME >= $submitat && SYSTIME <= ($course['submitat'] + $course['cwlength'])) {
            //直播进入中
            $isliverun = true;
        }
        $this->assign('isliverun', $isliverun);
        if($course['ism3u8'] == 1) {	//rtmp特殊处理
            $serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
            if($roominfo['domain'] == 'dh') {
                $m3u8source = $serverutil->getZKM3u8CourseSource();
            } else {
                $m3u8source = $serverutil->getM3u8CourseSource();
            }
            if(!empty($m3u8source)) {
                $cwid = $course['cwid'];
                $key = $this->getKey(!empty($administrator) ? $administrator : $user);
                $key = urlencode($key);
                $m3u8url = "$m3u8source?k=$key&id=$cwid&.m3u8";
                $course['m3u8url'] = $m3u8url;
            }
        } else {
            $course['m3u8url'] = '';
        }
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
        $this->assign('liveinfo', $live);
        $this->assign('flag', intval($this->input->get('flag')));
        if (is_mobile()) {
            $this->display('common/wap_live_view');
            return;
        }
        $this->display('common/livecourse');
    }

	//ajax的评论分页
	function getajaxpage(){
		$queryarr['pagesize'] = 10;
        $cwid = $this->input->post('cwid');
		$page = $this->input->post('page');
		if(empty($cwid) || !is_numeric($cwid) || $cwid <= 0) {	//验证cwid是否合法
			exit();
		}
		if(empty($page) || !is_numeric($page) || $page <= 0) {	//验证page是否合法
			exit();
		}
        $queryarr['cwid'] = $cwid;
		$queryarr['page'] = $page;
		$reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwidOnRecUrsion($queryarr);
        if(!empty($reviews)){
            $ipLib = Ebh::app()->lib('IPaddress');
            foreach ($reviews as $key => $review) {
                if(!empty($review['fromip'])){
                    $IPaddress = $ipLib->find($review['fromip']);
                    $reviews[$key]['ipaddress'] = rtrim(implode('-',$IPaddress),'-');
                }
            }
        }
        $count = $reviewmodel->getReviewCountByCwid($queryarr);

        $pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		

		//json输出
		echo json_encode(array("reviews"=>$reviews,'pagestr'=>$pagestr,'count'=>$count));
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
     * [addzan 课件点赞]
     * @return [type] [description]
     */
    public function ajax_addzan(){
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

	/**
	*生成包含用户信息的key，目前主要
	*/
	private function getKey($user) {
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}

    /**
     * 分类菜单背景颜色主题映射
     * @param $bgcolor
     * @return string
     */
    private function _get_course_menu_theme($bgcolor) {
        switch ($bgcolor) {
            case 'ff9b28ae':
                return 'theme_1';
            case 'ff663db5':
                return 'theme_2';
            case 'ff4052b4':
                return 'theme_3';
            case 'ff1f96f2':
                return 'theme_4';
            case 'ffff753f':
                return 'theme_5';
            case 'ff00bcd2':
                return 'theme_6';
            case 'fffea000':
                return 'theme_7';
            case 'fff2c300':
                return 'theme_8';
            case 'ffb7c500':
                return 'theme_9';
            case 'ff89c34a':
                return 'theme_10';
            case 'ff4daf51':
                return 'theme_11';
            case 'ff009687':
                return 'theme_12';
            case 'fff47d00':
                return 'theme_13';
            case 'fff34637':
                return 'theme_14';
            case 'ffe71e62':
                return 'theme_15';
            case 'ffc11759':
                return 'theme_16';
        }
        return '';
    }
    
    /**
     * 获取课程课件/附件转码状态
     * @return 0 转码中 1 转码成功
     */
    public function getstatus(){
        $ret = array('code'=>0);
        $input =$this->input->post();
        $cwid = intval($input['cwid']);
        if($cwid>0){
            $row = $this->model('Courseware')->getSimplecourseByCwid($cwid);
            if(!empty($row) && ($row['ism3u8']==1)){
                $ret['code'] = 1;
            }
        }
        echo json_encode($ret);
    }
    /**
     * 课件分享
	 * 课件分享逻辑处理
	 * 1,WAP端，则到WAP端学习课件页面
	 *		A。如果未登录则到登录页面，登录后继续跳转回
			B。如果已登录则到课件学习页面，如果免费则直接进入，否则到付费页面
			C。如果没有账号，则微信登录的话 直接创建账号
	 * 2,PC端，如果免费试听课，则到免费试听页面
	 * 3,PC端，如果非免费试听课，则到学生学习页面
     */
    public function share_view(){
        $cwid = $this->uri->itemid;
        if(empty($cwid)){
            header("Location:/");//跳转首页
            exit;
        }
        $this->apiServer = Ebh::app()->getApiServer('ebh');
        $courseinfo = $this->apiServer->reSetting()->setService('Classroom.Course.detail')->addParams(array('cwid'=>intval($cwid)))->request();
        if(isset($courseinfo['status']) && $courseinfo['status'] == 1){
            if(empty($courseinfo['data']['crid'])){
                header("Location:/");//跳转首页
                exit;
            }
            $crid = $courseinfo['data']['crid'];

            //独立域名判断,存在则跳转到独立域名
            $roominfo = Ebh::app()->room->getcurroom();
            $thedomain = !empty($roominfo['fulldomain']) ? $roominfo['fulldomain'] : $_SERVER['HTTP_HOST'];

            $ismoblile = is_mobile() ? 1 : 0 ;
			//判断分享的课件是否手机终端打开,是则跳转到wap页面
            if(!empty($ismoblile) && !empty($courseinfo['data']['crid'])){
                header("Location:http://wap.ebh.net/myroom/course/".$cwid.".html?crid=".$crid);//跳转wap端
                exit;
            }
			//PC端免费课件到免费试听
			if(!empty($courseinfo['data']['isfree'])){
                header("Location:http://".$thedomain."/course/".$cwid.".html");//跳转免费试听
                exit;
            }
			//PC端收费则到学生播放后台
            header("Location:http://".$thedomain."/myroom/mycourse/".$cwid.".html");
            exit;
        }
        header("Location:/");//跳转首页
    }

     /**
     *获取共用的头部和尾部数据
     */
    public function getHeaderAndFooter($roomdetail=NULL) {
        $model = $this->model('portfolio');
        if (!empty($this->user)) {
            $this->user['isadmin'] = $this->user['groupid'] == 5;
            $this->user['showname'] = !empty($this->user['realname']) ? $this->user['realname'] : $this->user['username'];
            $this->user['face'] = getavater($this->user, '120_120');
            $user = array(
                'showname' => $this->user['showname'],
                'groupid' => $this->user['groupid'],
                'isadmin' => $this->user['isadmin'],
                'face' => getthumb($this->user, '50_50'),
                'lastlogtime' => $this->user['lastlogintime']
            );
            $this->assign('plateUser', $user);
        }
        if (!empty($this->room)) {
            $room = array(
                'crname' => $this->room['crname'],
                'crphone' => $this->room['crphone'],
                'kefuqq' => $this->room['kefuqq'],
                'summary' => $this->room['summary'],
                'wechatimg' => $this->room['wechatimg'],
                'cface' => $this->room['cface'],
                'lat' => $this->room['lat'],
                'lng' => $this->room['lng'],
                'craddress' => $this->room['craddress']
            );
            $this->assign('plateRoom', $room);
        }
        $this->assign('user', $this->user);
        $this->assign('roominfo', $this->room);
        if (empty($roomdetail)) {
            $roomdetail = $model->getClassroomDetail($this->room['crid']);
        }
        if (!empty($roomdetail['isdesign'])) {
            $room_type = Ebh::app()->room->getRoomType();
            $apiServer = Ebh::app()->getApiServer('ebh');
            $roomtype = Ebh::app()->room->getRoomType();
            $ret = $apiServer->reSetting()
                ->setService('Classroom.Design.getdesign')
                ->addParams('crid', $roomdetail['crid'])
                ->addParams('roomtype', $room_type)
                ->addParams('clientType', is_mobile())
                ->request();
            if (!empty($ret['status']) && !empty($ret['data'])) {
                if (!empty($ret['data']['head'])) {
                    $this->assign('head', str_replace('\"', '"', $ret['data']['head']));
                } else {
                    $this->assign('head', '');
                }
                if (!empty($ret['data']['foot'])) {
                    $this->assign('foot', str_replace('\"', '"', $ret['data']['foot']));
                } else {
                    $this->assign('foot', '');
                }
                if (!empty($ret['data']['settings'])) {
                    $settings = str_replace('\"', '"', $ret['data']['settings']);
                    $settings = json_decode($settings, true);
                } else {
                    $settings = array();
                }
                $this->assign('settings', $settings);
            }
        }
    }
}
