<?php

/**
 * 视频播放rtm协议请求控制器
 */
class AuthController extends CControl {
	private $user = NULL;
	private $curcourse = NULL;	//当前的课件对象
	public function index() {
		header('HTTP/1.1 200 OK');
		exit();
		if(!$this->_checkSource()) {
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		$haspower = $this->_docourse();
		if($haspower) {
			header('HTTP/1.1 200 OK');
		} else {
			header('HTTP/1.1 403 Forbidden');
		}
		exit();
	}
    /**
	*验证来源页面是否合法
	*/
	private function _checkSource() {
		$pageurl = $this->input->post('pageurl');
		if(stripos($pageurl,'.ebanhui.com/') !== FALSE || stripos($pageurl,'.ebh.net/') !== FALSE)
			return TRUE;
		return FALSE;
	}
	/**
	*处理课件文件为附件格式的请求下载
	*/
	private function _docourse() {
		$cwid = $this->input->post('id');	//课件编号
		if(empty($cwid) || !is_numeric($cwid) || $cwid <= 0)
			return FALSE;
		$fromid = $this->input->post('fromid');	//来源crid，如在小学平台看全科复习的内容，则此id为小学平台的id
		$coursemodel = $this->model('Courseware');
        $course = $coursemodel->getplaycoursedetail($cwid);
		$this->curcourse = $course;
		if(empty($course))	//课件不存在
			return FALSE;
		if(!empty($course)) {
			$user = $this->getloginuser();
			if($course['isfree'] != 1 && $course['ispublic'] != 2) {	//不是免费课件的文件需要判断权限 不是免费试听学校 即 ispublic=2 的学校
				if(empty($user))
					return FALSE;
				if($user['groupid'] == 6 || $user['groupid'] == 5) {
					$crid = $course['crid'];
					if(!$this->checkpermission($crid,$fromid)) {	//无权限
						return FALSE;
					}
				}
			}
		}
		return TRUE;
	}
	/**
	*判断权限
	*@param int $crid 内容所在编号
	*@param int $fromid 来源crid，如在小学平台看全科复习的内容，则此id为小学平台的id
	*/
	private function checkpermission($crid,$fromid=0) {
		$roommodel = $this->model('Classroom');
		$user = $this->getloginuser();
		$check = 0;
		$result = FALSE;
		$room = $roommodel->getclassroomdetail($crid);
		if($user['groupid'] == 6) {	//学生
			$charge = ($room['isschool'] == 6 || $room['isschool'] == 7) ? true : false;	//是否为收费平台
			$check = $roommodel->checkstudent($user['uid'], $crid,$charge);	//普通平台权限判断
			if($room['isschool'] == 7) {	//对分成学校要加一层判断
				if($this->curcourse['fprice'] == 0) {
					$check = 1;
				} else if($check == 1) {	//如果非免费课程，则要进行权限判断
					$perparam = array('crid'=>$crid,'folderid'=>$this->curcourse['folderid']);
					$check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
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
	*根据rtmp协议传的加密参数获取用户信息
	*/
    private function getloginuser() {
		if (isset($this->user))
			return $this->user;
        $usermodel = $this->model('user');
        $auth = $this->input->post('k');
        if (!empty($auth)) {
            @list($password, $uid,$ip,$time) = explode("\t", authcode($auth, 'DECODE'));
            $curip = $this->input->post('addr');	//判断也是从服务器端发送，所以此处ip判断已经无意义
            if($curip != $ip)
                return FALSE;
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            $this->user = $user;
            return $user;
        }
        return FALSE;
    }
}
