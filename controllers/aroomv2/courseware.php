<?php
/**
 * 课件审核
 */
class CoursewareController extends CControl {
	public function __construct(){
		parent::__construct();
		Ebh::app()->room->checkRoomControl();
		$this->roominfo = $roominfo = Ebh::app()->room->getcurroom();
		if (empty($this->roominfo['checktype']))
		{
			//非法访问
			exit;
		}
	}

	/**
	 * 课件列表
	 */
	public function index() {
		//全校课程列表
		$param2['crid'] = $this->roominfo['crid'];
		$param2['nosubfolder'] = 1;
		$param2['limit'] = 1000;
		$folderlist = $this->model('folder')->getfolderlist($param2);

		$param = parsequery();
		$param['role'] = 'teach';
		$param['crid'] = $this->roominfo['crid'];
		$param['type'] = 1;//类型为课件

		//审核状态
		$param['checkstatus'] = $this->input->get('checkstatus');
		$param['folderid'] = $this->input->get('folderid');
		$count = $this->model('courseware')->getCoursewareCheckCount($param);
		$coursewarelist = $this->model('courseware')->getCoursewareCheckList($param);

		$pagestr = show_page($count, $param['pagesize']);

		$this->assign('pagestr', $pagestr);
		$this->assign('checkstatus', $param['checkstatus']);
		$this->assign('folderid', $param['folderid']);
		$this->assign('folderlist', $folderlist);
		$this->assign('coursewarelist', $coursewarelist);
		$this->display('aroomv2/courseware_index');

	}

	/**
	 * 审核处理
	 *
	 */
	public function checkprocess(){
		$stat = $this->input->post('teach_status');
		$remark = $this->input->post('teach_remark');
		$toid = $this->input->post('toid');
		$ckmodel = $this->model('billchecks');
		$type = 1;
		$user = Ebh::app()->user->getloginuser();
		$param = array(
			'role' => 'teach',
			'teach_uid'		=> $user['uid'],
			'teach_status'	=> $stat,
			'teach_remark'	=> $remark,
			'toid'			=> $toid,
			'teach_ip'		=> getip(),
			'type'			=> $type
			);

		if($ckmodel->check($param)){
			echo json_encode(array('code'=>1));
			fastcgi_finish_request();
			if ($stat == 2)
			{
				$courseware = $this->model('courseware')->getcoursedetail($toid);
				$msg = '您的课件 ' . $courseware['title'] . ' 审核未通过。未通过原因：' . $remark . '。';
				Ebh::app()->lib('EMessage')->sendMessage(0, '系统管理员', $courseware['uid'], $courseware['cwid'], 1, $msg);
			}
		}else{
			echo json_encode(array('code'=>0));
		}

	}


    public function view() {
        $cwid = $this->uri->itemid;
        if(empty($cwid)){
        	$cwid = intval($this->uri->uri_attr(0));
        }
        $recuid = intval($this->uri->uri_attr(1));
		if(!is_numeric($cwid))
			exit();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course))
			exit();
			
		//课件人气
		$viewnumlib = Ebh::app()->lib('Viewnum');
		$viewnumlib->addViewnum('courseware',$cwid);
		$viewnumlib->addViewnum('folder',$course['folderid']);
		
		$user = Ebh::app()->user->getloginuser();
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('user',$user);

		$type = $this->input->get('type');	//如果type为1则表示普通播放，即不采用m3u8方式播放
		$ifover5 = (SYSTIME - $course['dateline']) > 120 ? TRUE : FALSE;	//如果课件时间上传已经超过5分钟，则基本上已经处理成m3u8并且文件已经存好。
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
		$askmodel = $this->model('askquestion');
		$askcount = $askmodel->getRequiredAnswersCount(array('cwid'=>$cwid));
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


}