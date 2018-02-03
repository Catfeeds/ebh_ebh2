<?php

/**
 * 附件下载请求控制器
 */
class AttachController extends CControl {
	private $curcourse = NULL;	//当前的课件对象
	private $curatt = NULL;	//当前的附件对象
	private $flag = 0;	//当前处理对象，1为课件 2为附件 3为通知附件
	public function index() {
		$cwid = $this->input->get('cwid');	//课件编号
		$attid = $this->input->get('attid');	//附件编号
		$noticeid = $this->input->get('noticeid'); //通知编号
		$examcwid = $this->input->get('examcwid'); //通知编号
		if(is_numeric($cwid) && $cwid > 0) {	//处理课件请求
			$this->flag = 1;
			return $this->_docourse();
		} else if(is_numeric($attid) && $attid > 0) {	//处理附件请求
			$this->flag = 2;
			return $this->_doattach();
		} else if(is_numeric($noticeid) && $noticeid > 0) {
			$this->flag = 3;
			return $this->_donotice();
		} else if(is_numeric($examcwid)){
			$this->flag = 4;
			return $this->_doexamattach();
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
			$user = Ebh::app()->user->getloginuser();
			if($course['isfree'] != 1 && $course['ispublic'] != 2) {	//不是免费课件的文件需要判断权限 不是免费试听学校 即 ispublic=2 的学校
				if(empty($user))
					return;
				if($user['groupid'] == 6 || $user['groupid'] == 5) {
					$crid = $course['crid'];
					if(!$this->checkpermission($crid,$fromid)) {	//无权限
						$roommodel = $this->model('classroom');
						$gkccconfig = Ebh::app()->getConfig()->load('gkccconfig');
						foreach($gkccconfig['parent'] as $pcrid){
							$usercheck = $roommodel->checkstudent($user['uid'],$pcrid);
							if($usercheck)
								break;
						}
						
						if(!$usercheck || $crid!=$gkccconfig['child'])
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
	*判断权限
	*@param int $crid 内容所在编号
	*@param int $fromid 来源crid，如在小学平台看全科复习的内容，则此id为小学平台的id
	*/
	private function checkpermission($crid,$fromid=0) {
		$roommodel = $this->model('Classroom');
		$user = Ebh::app()->user->getloginuser();
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
	
	private function _donotice(){
		$noticeid = $this->input->get('noticeid');
		$noticemodel = $this->model('notice');
		$notice = $noticemodel->getNoticeByNoticeid($noticeid);
		$user = Ebh::app()->user->getloginuser();
		$crmodel = $this->model('classroom');
		if($user['groupid']==6)
			$roomuser = $crmodel->checkstudent($user['uid'],$notice['crid']);
		else
			$roomteacher = $crmodel->checkteacher($user['uid'],$notice['crid']);
		if((!empty($roomuser)&&$roomuser==1) || (!empty($roomteacher)&&$roomteacher==1)){
			$attmodel = $this->model('attachment');
			$attachment = $attmodel->getAttachByIdForNotice($notice['attid']);
			$url = $attachment['url'];
			$filename = $attachment['filename'];
			getfile('attachment', $url, $filename);
		}
	}

	private function _doexamattach(){
		$examcwid = $this->input->get('examcwid'); //通知编号
		$ucoursemodel = $this->model('Usercourseware');
		$course = $ucoursemodel->getUserCourse($examcwid);
		if(!empty($course)){
			$url = $course['cwurl'];
			$filename = basename($course['cwurl']);
			getfile('attachment', $url, $filename);
		}
	}
}
