<?php
/**
 * 网校课程列表内课件相关控制器类CourseController
 */
class CourseController extends CControl{
    public function __construct() {
        parent::__construct();
        Ebh::app()->room->checkteacher();
        
    }
    //所有课程->上传课件
    public function add() {
        if(NULL != $this->input->post('folderid')) {    //提交form表单
            $folderid = intval($this->input->post('folderid'));
            if($folderid < 0)
                return;
            $roominfo = Ebh::app()->room->getcurroom();
            $user = Ebh::app()->user->getloginuser();
            $crid = $roominfo['crid'];
            $uid = $user['uid'];
            $title = $this->input->post('title');
            $tag = $this->input->post('tag');
            $logo = $this->input->post('logo');
            if(!empty($logo) && !empty($logo['upfilepath'])) {
                $logo = $logo['upfilepath'];
            } else {
                $logo = '';
            }
            $summary = $this->input->post('summary');
            $message = (null !== $this->input->post('message')) ? $this->input->post('message') : $this->input->post('rich_message');
            $uparr = $this->input->post('up');
            $cwname = $uparr['upfilename'];
            $urlinfo = explode(',', $uparr['upfilepath']);
            $cwsource = $urlinfo[0];
            $cwurl = $urlinfo[1];
            $cwsize = $uparr['upfilesize'];
            $isclass = 1;
            $status = 1;
            $cdisplayorder = intval($this->input->post('cdisplayorder'));
            $sectionid = intval($this->input->post('sectionid'));
            $isfree = intval($this->input->post('isfree'));
            $param = array('crid'=>$crid,'folderid'=>$folderid,'uid'=>$uid,'title'=>$title,'tag'=>$tag,
                'logo'=>$logo,'summary'=>$summary,'message'=>$message,'cwname'=>$cwname,'cwsource'=>$cwsource,
                'cwurl'=>$cwurl,'cwsize'=>$cwsize,'isclass'=>$isclass,'status'=>$status,'cdisplayorder'=>$cdisplayorder,
                'sid'=>$sectionid,'isfree'=>$isfree);
            $coursemodel = $this->model('Courseware');
            $cwid = $coursemodel->insert($param);
            if($cwid) {
                $foldermodel = $this->model('Folder');
                $foldermodel->addcoursenum($folderid);
                $roommodel = $this->model('Classroom');
                $roommodel->addcoursenum($roominfo['crid']);
                echo json_encode(array('status'=>1,'msg'=>'添加成功'));
                exit();
            } else {
                echo json_encode(array('status'=>0,'msg'=>'添加失败'));
            }
            
        } else {
            $folderid = $this->uri->uri_attr(0);
            if(is_numeric($folderid)) {
                $upcontrol = Ebh::app()->lib('UpcontrolLib');
                $editor = Ebh::app()->lib('UMEditor');
                $foldermodel = $this->model('Folder');
                $folder = $foldermodel->getfolderbyid($folderid);
                $this->assign('folder', $folder);
                $this->assign('upcontrol', $upcontrol);
                $this->assign('editor', $editor);
                $this->display('troom/course_add');
            }
        }
//        $foldermodel = $this->model('Folder');
//        $folder = $foldermodel->getfolderbyid($folderid);
//        $this->assign('folder', $folder);
//        $this->display('troom/classcourse_add');
    }
    public function edit() {
        if (NULL != $this->input->post('cwid')) {
            $cwid = intval($this->input->post('cwid'));
            if(is_numeric($cwid)) {
                $roominfo = Ebh::app()->room->getcurroom();
                $coursemodel = $this->model('Courseware');
                $course = $coursemodel->getcoursedetail($cwid);
                if(empty($course) || $roominfo['crid'] != $course['crid'])
                    exit;
                
                $title = $this->input->post('title');
                $tag = $this->input->post('tag');
                $logo = $this->input->post('logo');
                if(!empty($logo) && !empty($logo['upfilepath'])) {
                    $logo = $logo['upfilepath'];
                } else {
                    $logo = '';
                }
                $summary = $this->input->post('summary');
                $message = (null !== $this->input->post('message')) ? $this->input->post('message') : $this->input->post('rich_message');
                $uparr = $this->input->post('up');
                $cwname = $uparr['upfilename'];
                $urlinfo = explode(',', $uparr['upfilepath']);
                $cwsource = $urlinfo[0];
                $cwurl = $urlinfo[1];
                $cwsize = $uparr['upfilesize'];
                $cdisplayorder = intval($this->input->post('cdisplayorder'));
                $sectionid = intval($this->input->post('sectionid'));
                $isfree = intval($this->input->post('isfree'));
                $param = array('title'=>$title,'tag'=>$tag,
                    'logo'=>$logo,'summary'=>$summary,'message'=>$message,'cwname'=>$cwname,'cwsource'=>$cwsource,
                    'cwurl'=>$cwurl,'cwsize'=>$cwsize,'cdisplayorder'=>$cdisplayorder,
                    'sid'=>$sectionid,'isfree'=>$isfree);
                $wherearr = array('cwid'=>$course['cwid'],'crid'=>$course['crid']);
                $result = $coursemodel->update($param,$wherearr);
                if($result !== FALSE) {
                    echo json_encode(array('status'=>1,'msg'=>'修改成功'));
                    exit();
                } else {
                    echo json_encode(array('status'=>0,'msg'=>'修改失败'));
                }
            }
        } else {
            $cwid = $this->uri->uri_attr(0);
            if(is_numeric($cwid)) {
                $coursemodel = $this->model('Courseware');
                $course = $coursemodel->getcoursedetail($cwid);
                if(empty($course))
                    exit;
                $folderid = $course['folderid'];
                $upcontrol = Ebh::app()->lib('UpcontrolLib');
                $editor = Ebh::app()->lib('UMEditor');
                $foldermodel = $this->model('Folder');
                $folder = $foldermodel->getfolderbyid($folderid);
                $this->assign('course', $course);
                $this->assign('folder', $folder);
                $this->assign('upcontrol', $upcontrol);
                $this->assign('editor', $editor);
                $this->display('troom/course_edit');
            }
        }
    }
    public function view() {
		$user = Ebh::app()->user->getloginuser();
        $cwid = $this->uri->itemid;
        if(empty($cwid)){
        	$cwid = intval($this->uri->uri_attr(0));
        }
        $recuid = intval($this->uri->uri_attr(1));
		if(!is_numeric($cwid))
			exit();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		$astatus = in_array($course['status'],array(0,1,-2));
		$bstatus = in_array($course['status'],array(0,-2));
		if(empty($course) || !$astatus || ($bstatus && $course['uid'] != $user['uid']))
			exit();
		if($course['islive'] == 1) {  //处理直播课
            return $this->doLive($user,$course);
        }
		//课件人气
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		
		
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('user',$user);

		$type = $this->input->get('type');	//如果type为1则表示普通播放，即不采用m3u8方式播放
		$ifover5 = (SYSTIME - $course['dateline']) > 20 ? TRUE : FALSE;	//如果课件时间上传已经超过20秒，则基本上已经处理成m3u8并且文件已经存好。
		if($course['ism3u8'] == 1 && $type != 1 && $course['dateline'] && $ifover5) {	//rtmp特殊处理 
			if($roominfo['domain'] == 'jx') {
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

        $this->assign('course', $course);
		$this->assign('source',$source);
		if(!empty($recuid)){
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$recuid,'limit'=>'0,100');
		}else{
			$examparam = array('cwid'=>$cwid,'crid'=>$roominfo['crid'],'uid'=>$user['uid'],'limit'=>'0,100');
		}
		//获取课件下的作业记录
		$exammodel = $this->model('Exam');
		if($roominfo['isschool']==2){
			$exams = $exammodel->getexamlistbycwid($examparam);
		}else{
			$exams = $exammodel->getschexamlistbycwid($examparam);
		}
		$this->assign('exams',$exams);
		//获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
		$queryarr['status'] = 1;
        $queryarr['cwid'] = $cwid;
		$queryarr['type'] = 'shield';
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
		//获取课件下的评论记录
		$reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $reviewcount = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($reviewcount);
		$this->assign('reviewcount',$reviewcount);
		//获取课件下的相关问题
		$shield = 0;
		$askmodel = $this->model('askquestion');
		$askcount = $askmodel->getRequiredAnswersCount(array('cwid'=>$cwid,'shield'=>$shield));
		$this->assign('askcount',$askcount);
		//$pagestr = $this->_show_page($count,1,10);
		$arr = explode('.',$course['cwurl']);
		$ext = $arr[count($arr)-1];
		if($ext != 'flv' && $course['ism3u8'] == 1) {
			$ext = 'flv';
		}
		$this->assign('ext',$ext);
		$reviews = parseEmotion($reviews);
		$subtitle = $course['title'];
		$this->assign('subtitle',$subtitle);
		$this->assign('emotionarr',getEmotionarr());
		$this->assign('roominfo', $roominfo);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);

        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
        
        if($is_iphone || $is_android || $is_ipad){
        	$this->display('troom/course_view_mobile');
        }else{
        	$this->display('troom/course_view');
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
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
				}
			}else{
				if($review['groupid']==5){
					$defaulturl='http://static.ebanhui.com/ebh/tpl/default/images/t_man.jpg';
				}else{
					$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
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
        $result = $coursemodel->delcourse($cwid);
        if($result) {
            //删除课件附件文件
            foreach ($attachs as $att) {
                delfile('attachment',$att['url']);
            }
            //删除课件文件
            delfile('course',$course['cwurl']);
            //修改课件数
            $foldermodel = $this->model('Folder');
            $foldermodel->addcoursenum($course['folderid'],-1);
            $roommodel = $this->model('Classroom');
            $roommodel->addcoursenum($roominfo['crid'],-1);
            $teachermodel = $this->model('Teacher');
            $teachermodel->addcoursenum($course['uid'],-1);
            echo json_encode(array('status'=>1,'msg'=>"删除成功"));
        } else {
            echo json_encode(array('status'=>-1,'msg'=>"删除失败，请联系管理员或稍后再试"));
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
			$coursemodel->addexamnum($cwid,-1,$roominfo['crid']);
			echo json_encode(array('status'=>1));
            exit();
		} else {
			echo json_encode(array('status'=>0,'msg'=>'删除失败'));
            exit();
		}
	}
	/**
	*上传附件
	*/
	public function upattach() {
		if(NULL !== $this->input->post('cwid')) {	//处理上传表单
			$this->_doupattach();
		} else {	//显示上传页面
			$cwid = $this->uri->uri_attr(0);
			if(!is_numeric($cwid))
				exit();
			$coursemodel = $this->model('Courseware');
			$course = $coursemodel->getcoursedetail($cwid);
			if(empty($course))
				exit();
			$upcontrol = Ebh::app()->lib('UpcontrolLib');
			$this->assign('upcontrol',$upcontrol);
			$this->assign('course',$course);
			$this->display('troom/course_upattach');
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
			$title= $this->input->post('title');
			$message= $this->input->post('message');
			$up = $this->input->post('up');
			$urlinfo = explode(',', $up['upfilepath']);
			$source = $urlinfo[0];
			$url = $urlinfo[1];
			$filename =  $up['upfilename'];
			$size = $up['upfilesize'];
			$suffix = substr($urlinfo[1], stripos($urlinfo[1],'.')+1,strlen($urlinfo[1]));
			$param = array('cwid'=>$cwid,'uid'=>$uid,'crid'=>$roominfo['crid'],'title'=>$title,'message'=>$message,'source'=>$source,'url'=>$url,'filename'=>$filename,'suffix'=>$suffix,'size'=>$size,'status'=>1);
			$attmodel = $this->model('Attachment');
			$result = $attmodel->insert($param);
			if($result) {
				$coursemodel = $this->model('Courseware');
				$coursemodel->addatachnum($cwid,1);
				echo json_encode(array('status'=>1));
			} else {
				echo json_encode(array('status'=>0));
			}
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
		$this->assign('attach',$attach);
		$this->assign('course',$course);
		$this->display('troom/course_editattach');
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
            $uid = $user['uid'];
			$title= $this->input->post('title');
			$message= $this->input->post('message');
			
			$param = array('attid'=>$attid,'title'=>$title,'message'=>$message);
			$attmodel = $this->model('Attachment');
			$result = $attmodel->update($param);
			if($result !== FALSE) {
				echo json_encode(array('status'=>1));
			} else {
				echo json_encode(array('status'=>0));
			}
		}
	}
	/**
	*附件管理
	*/
	/*
	public function attach() {
		$cwid = $this->uri->uri_attr(0);
		if(is_numeric($cwid) && $cwid > 0) {
			//获取附件列表，此处暂不分页,parsequery备用
			$attachmodel = $this->model('Attachment');
			$queryarr = parsequery();
			$queryarr['cwid'] = $cwid;
			$attachments = $attachmodel->getAttachmentListByCwid($queryarr);
			$this->assign('attachments',$attachments);
			$this->display('troom/attach');
		}
	}
	*/
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

			$attmodel = $this->model('Attachment');
			$result = $attmodel->deleteattachment($attid);
			if($result > 0) {
				$coursemodel->addatachnum($course['cwid'],-1);
				echo 'success';
			} else {
				echo 'fail';
			}
		}
	}

	/*
	屏蔽评论
	*/
	public function shield(){
		$cwid = $this->input->post('cwid');
		$logid = $this->input->post('logid');
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if ($cwid === NULL || !is_numeric($cwid) || $logid === NULL || !is_numeric($logid)) {
            echo 'fail';
            exit();
        }
		$param['crid'] = $roominfo['crid'];
		$param['cwid'] = $cwid;
		$reviewmodel = $this->model('review');
		$count = $reviewmodel->getByCridCount($param);
		if($count>0){
			$param = array('uid' => $user['uid'], 'logid'=>$logid);
			$result = $reviewmodel->upShield($param);
			if ($result) {
				$coursemodel = $this->model('Courseware');	//减少课件评论数
				$coursemodel->editreviewnum($cwid);
				echo json_encode(array('status'=>1));
				exit();
			} else {
				echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
				exit();
			}
		}else{
			echo json_encode(array('status'=>0,'msg'=>'屏蔽失败'));
			exit();
		}
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
	课件相关问题列表
	*/
	public function linkask(){
		$cwid = $this->input->post('cwid');
		if(!is_numeric($cwid))
			exit;
		$param['cwid'] = $cwid;
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
		echo json_encode($linkedquestions);
	}
    /**
    *处理直播课
    */
    public function doLive($user,$course) {
        $cwid = $course['cwid'];
        //课件人气
        $viewnumlib = Ebh::app()->lib('Viewnum');
        $viewnumlib->addViewnum('courseware',$cwid);
        $viewnumlib->addViewnum('folder',$course['folderid']);
        
        
        $roominfo = Ebh::app()->room->getcurroom();

        //获取课件下的作业记录
        $exammodel = $this->model('Exam');
        if($roominfo['isschool']==2){
            $exams = $exammodel->getexamlistbycwid($examparam);
        }else{
            $exams = $exammodel->getschexamlistbycwid($examparam);
        }
        $this->assign('exams',$exams);
        //获取课件下的附件记录
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['status'] = 1;
        $queryarr['cwid'] = $cwid;
        $queryarr['type'] = 'shield';
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
        $this->assign('attachments', $attachments);
        //获取课件下的评论记录
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $reviewcount = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($reviewcount);
        $this->assign('reviewcount',$reviewcount);
        //获取课件下的相关问题
        $shield = 0;
        $askmodel = $this->model('askquestion');
        $askcount = $askmodel->getRequiredAnswersCount(array('cwid'=>$cwid,'shield'=>$shield));
        $this->assign('askcount',$askcount);
        //$pagestr = $this->_show_page($count,1,10);

        $reviews = parseEmotion($reviews);
        $this->assign('emotionarr',getEmotionarr());
        $this->assign('roominfo', $roominfo);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
        $isexpired = FALSE;
        $url = "";
        if(SYSTIME > ($course['endat'] + 3600)) {
            $isexpired = TRUE;
        }
        if(!$isexpired && $course['uid'] == $user['uid']) {   //如果为结束，则加会处理
            $livelib = Ebh::app()->lib('live');
            $url =$livelib->joinLive($user['username'],$user['realname'],$course['title'],$course['liveid'],1);
//			if(!empty($url))
//				$url .= '&CDNPublishURL=rtmp://ebhrtmppub.satacdn.com/ebhlive/';
        }
        $subtitle = $course['title'];
        $tag = $course['tag'];
        $summary = $course['summary'];
        $this->assign('isexpired',$isexpired);
        $this->assign('url',$url);
        $this->assign('user',$user);
        $this->assign('course',$course);
        $this->assign('subtitle',$subtitle);
        $this->assign('subkeywords',$tag);
        $this->assign('subdescription',$summary);
        $this->display('troom/live_view');
    }
}
