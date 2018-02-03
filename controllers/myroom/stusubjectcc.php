<?php
/**
 * 学校学生高考冲刺课程控制器 StusubjectController
 */
class StusubjectccController extends CControl {
    public function __construct() {
        parent::__construct();
		$roominfo = Ebh::app()->room->getcurroom();
		$this->gkccconfig = Ebh::app()->getConfig()->load('gkccconfig');
		if(!in_array($roominfo['crid'],$this->gkccconfig['parent']))
			exit;
        $check = TRUE;
		if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {
			$check = Ebh::app()->room->checkstudent(TRUE);
		} else {
			Ebh::app()->room->checkstudent();
		}
		$this->assign('check',$check);
    }
    public function index() {
		$roominfo = Ebh::app()->room->getcurroom();
		$foldermodel = $this->model('Folder');
		$queryarr = parsequery();
		$queryarr['crid'] = $this->gkccconfig['child'];
		$queryarr['pagesize'] = 100;
		$queryarr['nosubfolder'] = 1;
		$folders = $foldermodel->getfolderlist($queryarr);
		if($roominfo['isschool'] == 7) {	//收费分成学校，则未开通或已过期的课程，就显示阴影和开通按钮
			$user = Ebh::app()->user->getloginuser();
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$roominfo['crid'],'filterdate'=>1);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			$roomfolderlist = $userpermodel->getPayItemByCrid($roominfo['crid']);
			$folderlist = array();
			foreach($folders as $myfolder) {
				$myfolder['haspower'] = 0;
				$myfolder['payurl'] = '';
				if($myfolder['fprice'] == 0) {
					$myfolder['haspower'] = 1;
				}
				$folderlist[$myfolder['folderid']] = $myfolder;
			}
			foreach($myfolderlist as $myfolder1) {	//看看哪些有权限
				if(isset($folderlist[$myfolder1['folderid']])) {
					$folderlist[$myfolder1['folderid']]['haspower'] = 1;
				}
			}
			foreach($roomfolderlist as $myfolder2) {
				if(isset($folderlist[$myfolder2['folderid']])) {
					if($folderlist[$myfolder2['folderid']]['haspower'] == 0) {	//没有权限，则加上链接
						$checkurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$myfolder2['itemid'];	//购买url
						$folderlist[$myfolder2['folderid']]['payurl'] = $checkurl;
					}
				}
			}
			$folders = $folderlist;

		}
		//$count = $foldermodel->getcount($queryarr);
		//$pagestr = show_page($count,15);

		//filter
		$myfolders = array();
		$showids = array(3861,3862,3863,3864,3865,3866,3867,3868,3869);	//只显示高考冲刺几门课程

		foreach($folders as $myfolder) {
			if(in_array($myfolder['folderid'],$showids)) {
				$myfolders[] = $myfolder;
			}
		}
		$pagestr = '';
		$from = 0;	//表示全校课程
		$this->assign('from',$from);
		$this->assign('pagestr',$pagestr);
		$this->assign('folders',$myfolders);
		$this->assign('roominfo',$roominfo);
		$this->display('myroom/mycoursecc');
    }
	
	
	/**
	*课程详情（课件列表页）
	*/
	public function view() {
		
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$from = $this->uri->uri_attr(0);	//课程来源。空为全校课程 1为我的课程 2为全校教师
        $this->assign('uid', $user['uid']);
        $folderid = $this->uri->itemid;
		
        $subfolderlib = Ebh::app()->lib('SubFolder');
		$subfolderlib->getSubFolder($this,$folderid);
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($folderid);
		$this->assign('folder',$folder);
        $coursemodel = $this->model('Courseware');
        $queryarr = parsequery();
		$q = $this->input->get('q');
        $queryarr['folderid'] = $folderid;
		$pagesize = 40;
		$queryarr['pagesize'] = $pagesize;
		$queryarr['status'] = 1;
        $courses = $coursemodel->getfolderseccourselist($queryarr);
        $count = $coursemodel->getfolderseccoursecount($queryarr);
        $pagestr = show_page($count,$pagesize);
        $sectionlist = array();
        foreach($courses as $course) {
            if(empty($course['sid'])) {
                $course['sid'] = 0;
                $course['sname'] = '其他';
            }
            $sectionlist[$course['sid']][] = $course;
        }
		//获取直播课信息
		$onlinelist = array();
		$onlinesource = '';
		if($roominfo['isschool'] == 7) {	//目前只针对收费学校开放直播课
			$check = 1;
			$key = '';
			//针对isschool为7并且价格不为0的情况还要判断是否有课程权限
			if($folder['fprice'] > 0 && $roominfo['isschool'] == 7) {
				$perparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid);
				$check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
				if($check != 1) {
					$payitem = Ebh::app()->room->getUserPayItem($perparam);
					$this->assign('payitem',$payitem);
					if(!empty($payitem)) {
						$checkurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/ibuy.html?itemid='.$payitem['itemid'];	//购买url
						$this->assign('checkurl',$checkurl);
					}
				}
				
			}
			if($check == 1) {
				$key = $this->_getOnlineKey();
				$key = urlencode($key);
			}
			$this->assign('check',$check);
			$this->assign('key',$key);
			$onlinemodel = $this->model('Onlinecourse');
			$onlineparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'limit'=>200);
			if(!empty($q))
				$onlineparam['q'] = $q;
			$onlinelist = $onlinemodel->getListByFolder($onlineparam);
			$serverUtil = Ebh::app()->lib('ServerUtil');
			$onlinesource = $serverUtil->getOnlineSource();
		}
		$this->assign('onlinesource',$onlinesource);
		$this->assign('onlinelist',$onlinelist);
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'folderid'=>$folderid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getfolderfavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('from',$from);
		$this->assign('q',$q);
        $this->assign('sectionlist', $sectionlist);
        $this->assign('pagestr', $pagestr);
		$this->display('myroom/stusubjectcc_view');
	}
	
	public function course_view() {
		$cwid = $this->uri->itemid;
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
		$roominfo = Ebh::app()->room->getcurroom();
		$from = $this->uri->uri_attr(0);	//来源，0或空为全校课程 1 为我的课程 2 为教师课程
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
		if(empty($course) || $course['status']!=1)
			exit();
		//添加课件查看数
		$coursemodel->addviewnum($cwid);
		$foldermodel = $this->model('folder');
		$folder = $foldermodel->getfolderbyid($course['folderid']);
		if($folder['viewnum']==0){
			$viewnum = rand(100,300);
			$foldermodel->updateviewnum($course['folderid'],$viewnum);
		}else{
			$foldermodel->addviewnum($course['folderid']);
		}
		$user = Ebh::app()->user->getloginuser();
		//针对isschool为7并且价格不为0的情况还要判断是否有课程权限
		
		$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
		$source = $serverutil->getCourseSource();
		if(!empty($source))
			$course['cwsource'] = $source;
		$type = $this->input->get('type');	//如果type为1则表示普通播放，即不采用m3u8方式播放
		if($course['ism3u8'] == 1 && $type != 1) {	//rtmp特殊处理 
			$crid = $roominfo['crid'];
			$m3u8source = $serverutil->getM3u8CourseSource();
			if(!empty($m3u8source)) {
				$key = $this->getKey($user);
				$key = urlencode($key);
				$m3u8url = "$m3u8source?k=$key&id=$cwid&fromid=$crid&.m3u8";
				$course['m3u8url'] = $m3u8url;
			}
		}
        $this->assign('course', $course);
        $attachmodel = $this->model('Attachment');
        $queryarr = parsequery();
        $queryarr['cwid'] = $cwid;
		$queryarr['status'] = 1;
        $attachments = $attachmodel->getAttachmentListByCwid($queryarr);
		$this->assign('source',$source);
        $this->assign('attachments', $attachments);
        $reviewmodel = $this->model('Review');
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		
		//收藏信息
		$favoritemodel = $this->model('Favorite');
		$fparam = array('crid'=>$roominfo['crid'],'cwid'=>$cwid,'uid'=>$user['uid']);
		$myfavorites = $favoritemodel->getcoursefavoritelist($fparam);
		$myfavorite = empty($myfavorites) ? '' : $myfavorites[0];
		$isfree = 0;
		$this->assign('isfree',$isfree);
		$this->assign('myfavorite',$myfavorite);
		$this->assign('user',$user);
		$this->assign('from',$from);
        $this->assign('reviews', $reviews);
        $this->assign('pagestr', $pagestr);
		$this->assign('roominfo',$roominfo);
		$arr = explode('.',$course['cwurl']);
		$type = $arr[count($arr)-1];
		$this->assign('type',$type);
		
		
		if($type == 'flv' || empty($course['cwurl'])){

			$this->display('myroom/coursecc');
		}else{
			$this->display('myroom/mycoursecc_view');
		}
	}
	
	/**
	*生成直播课对应的key，主要用于直播课权限验证
	*/
	private function _getOnlineKey() {
		$clientip = $this->input->getip();
        $ktime = SYSTIME;
        $auth = $this->input->cookie('auth');
        $sauth = authcode($auth, 'DECODE');
        @list($password, $uid) = explode("\t", $sauth);
        $skey = "$password\t$uid\t$clientip\t$ktime";
        $key = authcode($skey, 'ENCODE');
		return $key;
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
}
