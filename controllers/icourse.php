<?php

/**
 * APP端课件请求控制器请求控制器
 */
class IcourseController extends CControl {
	private $user = NULL;	//当前用户
	private $democrid = 10520;	//演示平台的课件，可以随意播放。
	private $curcourse = NULL;	//当前的课件对象
	private $curatt = NULL;	//当前的附件对象
	private $flag = 0;	//当前处理对象，1为课件 2为附件 3为通知附件
	public function __construct() {
		parent::__construct();
        $this->user = $this->getLoginUser();
		if(empty($this->user)) {	//非法用户，则直接退出
			echo 'user fail';
			exit();
		}
	}
	public function index() {
		$cwid = $this->input->get('cwid');	//课件编号
		$attid = $this->input->get('attid');	//附件编号
		if(is_numeric($cwid) && $cwid > 0) {	//处理课件请求
			$this->flag = 1;
			return $this->_docourse();
		} else if(is_numeric($attid) && $attid > 0) {	//处理附件请求
			$this->flag = 2;
			return $this->_doattach();
		}
	}
	/**
	*处理附件的请求下载
	*/
	private function _doattach() {

		$attid = $this->input->get('attid');	//附件编号
		$moduleid = $this->input->get('moduleid');	//模块编号，如学习全科复习平台时会加上次字段
		$attachmodel = $this->model('Attachment');
		$attach = $attachmodel->getAttachById($attid);
		$this->curatt = $attach;
		if(!empty($attach)) {
			if($attach['isfree'] != 1) {	//不是免费课件的附件需要判断权限
				$crid = $attach['crid'];
				if(!$this->checkpermission($crid,$moduleid)) {	//无权限
					return;
				}
			}
			$url = $attach['url'];
			$name = $attach['filename'];
			$type = $this->input->get('type');
			if(!empty($type) && $type == 'preview' && $attach['ispreview'] == 1) {
				$suffix = '.swf';
				$name = strstr($name,'.',true).$suffix;
				$url = strstr($url,'.',true).$suffix;
			}
			getfile('attachment', $url, $name);
		}
	}
	/**
	*处理课件文件为附件格式的请求下载
	*/
	private function _docourse() {
		$type = $this->input->get('type');	//view表示网页详情显示，否则为下载
		if($type == 'view') {
			return $this->_docourseview();
		}
		$inajax = $this->input->get('inajax');	//是否ajax调用权限
		if($inajax == 1) {
			return $this->_initajax();
		}
		$cwid = $this->input->get('cwid');	//课件编号
		$fromid = $this->input->get('fromid');	//来源crid，如在小学平台看全科复习的内容，则此id为小学平台的id
		$coursemodel = $this->model('Courseware');
        $course = $coursemodel->getplaycoursedetail($cwid);
		$this->curcourse = $course;
		if(!empty($course)) {
			$user = $this->user;
			$crid = $course['crid'];
			if($course['isfree'] != 1 && $course['ispublic'] != 2 && $crid != $this->democrid) {	//不是免费课件的文件需要判断权限 不是免费试听学校 即 ispublic=2 的学校
				if(empty($user))
					return;
				if($user['groupid'] == 6 || $user['groupid'] == 5) {
					
					if(!$this->checkpermission($crid,$fromid)) {	//无权限
						return;
					}
				}
			}
			$url = $course['cwurl'];
            $name = $course['title'];
			$suffix = strstr($url,'.');
			if($suffix == '.ebh' || $suffix == '.ebhp'){
				getfile('course', $url, $name.$suffix);
			}else{
				$type = $this->input->get('type');
				if(!empty($type) && $type == 'preview' && $course['ispreview'] == 1) {
					$suffix = '.swf';
					$url = strstr($url,'.',true).$suffix;
				}
				getfile('attachment', $url, $name.$suffix);
			}
		}
	}
	private function _initajax() {
		$cwid = $this->input->get('cwid');	//课件编号
		$fromid = $this->input->get('fromid');	//来源crid，如在小学平台看全科复习的内容，则此id为小学平台的id
		$coursemodel = $this->model('Courseware');
        $course = $coursemodel->getplaycoursedetail($cwid);
		$this->curcourse = $course;
		$errorcode = 2;
		$cwsource = '';
		if(!empty($course)) {
			$user = Ebh::app()->user->getloginuser();
			if($course['isfree'] != 1) {	//不是免费课件的文件需要判断权限
				$user = Ebh::app()->user->getloginuser();
				if(empty($user))
					$errorcode = 1;
				if($errorcode != 1) {
					$crid = $course['crid'];
					if(!$this->checkpermission($crid,$fromid)) {	//无权限
						$errorcode = 2;
					} else {
						$errorcode = 0;
						$cwsource = $course['cwsource'];
					}
				}
			} else {
				$errorcode = 0;
			}
		}
		$result = array();
		if($errorcode == 0) {
			$result['status'] = 1;
			$serverlib = Ebh::app()->lib('Serverlib');
			$source = $serverlib->getCourseSource();	//默认从配置文件中读取课件所在服务器地址
			if(!empty($source)) {
				$cwsource = $source;
			}
			$result['source'] = $cwsource;
		} else if($errorcode == 1) {
			$result['status'] = -1;
		} else if($errorcode == 2) {
			$result['status'] = 0;
		}
		echo json_encode($result);
	}
	/**
	*网页预览
	*/
	private function _docourseview() {
		$cwid = $this->input->get('cwid');
		if(!is_numeric($cwid) || $cwid <= 0)
			exit();
        $coursemodel = $this->model('Courseware');
        $course = $coursemodel->getcoursedetail($cwid);
        if(empty($course))
            exit();
        $user = $this->user;
        //判断课件权限

        $is_student = $this->model('Roomuser')->isAlumni($course['crid'], $user['uid']);
        $is_allow = $is_student && !empty($course['isschoolfree']);
        if (!$is_allow) {
            $price = $this->model('PayItem')->getLastItemByFolderid($course['folderid'],$course['crid']);
            if (!empty($price)) {
                $price = $price['iprice'];
            } else {
                $price = $course['fprice'];
            }
            $is_allow = $price == 0;
        }
        if (!$is_allow) {
            $is_allow = $this->model('Userpermission')->isAllowed($this->user['uid'], $course['crid'], $course['cwid'], $course['folderid']);
        }
        if (empty($is_allow)) {
            exit();
        }

        $startdata = "";
        $enddata = "";
        $submitat = $course['submitat'];
        $endat = $course['endat'];
        $tag = 0;
        if(!empty($submitat)){
        	if($submitat >= time()){
	        	//有开课时间没有开课
	        	$tag = 1;
	        }
        }

        if(!empty($endat)){
        	if($endat <= time()){
        		//截止时间到了看不了了
        		$tag = 3;
        	}
        }

        $this->assign('tag',$tag);
        $this->assign('submitat',$submitat);
        $this->assign('endat',$endat);
		//添加课件查看数
		$coursemodel->addviewnum($cwid);

        $this->assign('course', $course);
        $reviewmodel = $this->model('Review');
		$queryarr = parsequery();
		$queryarr['cwid'] = $cwid;
		$queryarr['shield'] = 1;
        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
        $count = $reviewmodel->getReviewCountByCwid($queryarr);
        $pagestr = show_page($count);
		
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		$auth = $this->input->get('k');
		$this->assign('k',urlencode($auth));

		$arr = explode('.',$course['cwurl']);
		$types = $arr[count($arr)-1];
		if($types != 'flv' && $course['ism3u8'] == 1) {
			$types = 'flv';
		}
		$purl = $this->getPurl($auth,$cwid);
		$this->assign('purl',$purl);
		$this->assign('types',$types);
		//收藏信息
		$this->assign('user',$user);
        $this->assign('reviews', $reviews);
		$this->assign('count', $count);
        $this->assign('pagestr', $pagestr);
        $this->display('common/icourse');
	}
//	//ajax的评论分页
//	function getajaxpage(){
//		$queryarr['pagesize'] = 20;
//        $queryarr['cwid'] = $this->input->post('cwid');
//		$queryarr['page'] = $this->input->post('page');
//		$reviewmodel = $this->model('Review');
//        $reviews = $reviewmodel->getReviewListByCwid($queryarr);
//        $count = $reviewmodel->getReviewCountByCwid($queryarr);
//        $pagestr = $this->_show_page($count,$queryarr['page'],$queryarr['pagesize']);
//		
//		$reviews = parseEmotion($reviews);
//		$this->assign('emotionarr',getEmotionarr());
//		
//		//数据格式化 时间和头像缩略图
//		foreach($reviews as &$review){
//			$review['dateline'] = date('Y-m-d H:i:s', $review['dateline']);
//			if ($review['sex'] == 1)
//				$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
//			else
//				$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
//			$face = empty($review['face']) ? $defaulturl : $review['face'];
//			$face = getthumb($face, '50_50');			
//			$review['face'] =$face; 
//		}
//
//		//json输出
//		echo json_encode(array("reviews"=>$reviews,'pagestr'=>$pagestr));
//	}
	
	//点击加载评论列表
	public function onclicklist(){
		$cwid = $this->input->post('cwid');
		$user = $this->user;
		if(empty($cwid) || !is_numeric($cwid) || $cwid <= 0) {	//验证cwid是否合法
			exit();
		}
		$uid = $user['uid'];
		$reviewmodel = $this->model('review');
		$queryarr = parsequery();
		$queryarr['cwid'] = $cwid;
		$queryarr['shield'] = 1;
		$queryarr['pagesize'] = 20;
		$queryarr['page'] = $this->input->post('page');
		$reviews = $reviewmodel->getReviewListByCwid($queryarr);
		$reviews = parseEmotion($reviews);
		$this->assign('emotionarr',getEmotionarr());
		//数据格式化 时间和头像缩略图
		foreach($reviews as &$review){
			$review['dateline'] = date('Y-m-d H:i:s', $review['dateline']);
			if ($review['sex'] == 1)
				$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_woman.jpg';
			else
				$defaulturl = 'http://static.ebanhui.com/ebh/tpl/default/images/m_man.jpg';
			$face = empty($review['face']) ? $defaulturl : $review['face'];
			$face = getthumb($face, '50_50');			
			$review['face'] =$face; 
		}
		echo json_encode($reviews);
		exit();
	}
	/**
	*判断权限
	*@param int $crid 内容所在编号
	*@param int $fromid 来源crid，如在小学平台看全科复习的内容，则此id为小学平台的id
	*/
	private function checkpermission($crid,$fromid=0) {
		$roommodel = $this->model('Classroom');
		$user = $this->user;
		$check = 0;
		$result = FALSE;
		$room = $roommodel->getclassroomdetail($crid);
		if($user['groupid'] == 6) {	//学生
			$charge = ($room['isschool'] == 6 || $room['isschool'] == 7) ? true : false;	//是否为收费平台
			$check = $roommodel->checkstudent($user['uid'], $crid,$charge);
			if($room['isschool'] == 7) {
				if($this->flag == 1) {
					if($this->curcourse['fprice'] == 0) {
						$check = 1;
					} else if($check == 1) {	//如果非免费课程，则要进行权限判断
						$perparam = array('crid'=>$crid,'folderid'=>$this->curcourse['folderid']);
						$check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
					}
				} else if($this->flag == 2) {	//附件权限暂不处理

				}

			}
		} else if($user['groupid'] == 5) {	//教师
			$check = $roommodel->checkteacher($user['uid'], $crid);
		}
		if($check == 1) {	//无权限
			$result = TRUE;
		} else if($room['isshare'] == 1 && !empty($fromid) ) {	//如果为共享平台，则需要判断共享权限
			$rpmodel = $this->model('Roompermission');
			$check = $rpmodel->checkmodule($crid,$fromid);
			$ucheck = $this->checkpermission($fromid,0);	//判断用户对来源的crid是否有权限
			if($check && $ucheck) 
				$result = TRUE;
		}
		return $result;
	}

	/**
	*根据APP接口过来的key获取当前用户
	*/
	private function getLoginUser() {
		if (isset($this->user))
			return $this->user;
		// $auth = str_replace(' ','+',$this->input->get('k'));
		$auth = $this->input->get('k');
		$usermodel = $this->model('user');
        if (!empty($auth)) {
            @list($password, $uid,$ip,$time) = explode("\t", authcode($auth, 'DECODE'));
            $curip = $this->input->getip();
//            if($curip != $ip)
//                return FALSE;
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            $cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
			$this->input->setcookie('auth', $auth, $cookietime);
            return $user;
        }
        return FALSE;
	}

	public function getPurl($key = "",$cwid = 0) {
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$isios = FALSE;
		if(strpos($useragent,'ios') !== FALSE) {
			$isios = TRUE;
		}
		if($isios && strpos($useragent,'iphone') !== FALSE && strpos($useragent,'1.0.3') !== FALSE ) {
			$isios = FALSE;
		}
		if($isios && strpos($useragent,'ipad') !== FALSE && strpos($useragent,'1.0.3') !== FALSE ) {
			$isios = FALSE;
		}
		$course = array();
		$user = $this->getLoginUser();
		if(!empty($user) && is_numeric($cwid) && $cwid > 0) {
			$key = urlencode($key);
			$course['purl'] = "http://www.ebh.net/icourse.html?cwid=$cwid&k=$key";
			$coursemodel = $this->model('Courseware');
			$mycourse = $coursemodel->getcoursedetail($cwid);
			
			//直播课purl处理
			if($mycourse['islive'] == 1) {
				$hlsservers = Ebh::app()->getConfig()->load('hlsservers');
				if(!empty($hlsservers[0])) {
					$hlsurl = str_replace('[liveid]', $mycourse['liveid'], $hlsservers[0]);
					$course['purl'] = $hlsurl;
				}
			}
			elseif($mycourse['ism3u8'] == 1 && !$isios) {	//rtmp特殊处理 
				$serverutil = Ebh::app()->lib('ServerUtil');	//生成课件和附件所在服务器地址
				$m3u8source = $serverutil->getM3u8CourseSource();
				if(!empty($m3u8source)) {
					$key = $this->getKey($user);
					$key = urlencode($key);
					$m3u8url = "$m3u8source?k=$key&id=$cwid&.m3u8";
					$course['purl'] = $m3u8url;
				}
			}
		}
		return $course['purl'];
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
