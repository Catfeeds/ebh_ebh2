<?php

/**
 * 直播课回调验证接口
 */
class IonlineController extends CControl {
	private $user = NULL;	//当前用户
	public function __construct() {
		parent::__construct();
		$type = 0;
		if(NULL !== $this->input->get('type') && $this->input->get('type') == 'c') {	
			$type = 1;
		}
		if($type == 1) {
			$this->user = Ebh::app()->user->getloginuser();
		} else {
			$this->user = $this->getLoginUser();
		}
		if(empty($this->user)) {	//非法用户，则直接退出
			$result = array('status'=>-1,'msg'=>'非法用户');
			//echo json_encode($result);
			$this->echoCallback($result);
			exit();
		}
	}
	public function index() {
		$onlineid = $this->input->get('id');	//直播课编号
		if(is_numeric($onlineid) && $onlineid > 0) {	//处理课件请求
			return $this->_doonline($onlineid);
		}
		$result = array('status'=>-1,'msg'=>'非法请求');
//		echo json_encode($result);
		$this->echoCallback($result);
		exit();
	}
	/**
	*处理直播课
	*/
	private function _doonline($onlineid) {
		$user = $this->user;
		$onlinemodel = $this->model('Onlinecourse');
		$myonline = $onlinemodel->getOnlineDetailsById($onlineid);
		if(empty($myonline)) {
			$result = array('status'=>-1,'msg'=>'非法课程');
//			echo json_encode($result);
			$this->echoCallback($result);
			exit();
		}
		$crid = $myonline['crid'];
		$folderid = $myonline['folderid'];
		$perparam = array('crid'=>$crid,'folderid'=>$folderid);
		$role = -1;
		if($user['groupid'] == 5) {	//老师 则只有创建老师有权限
			if($myonline['tid'] == $user['uid'] || $myonline['auid'] == $user['uid']) {
				$check = 1;
				if($myonline['auid'] == $user['uid'])	//助教为2
					$role = 2;
			} else {
				$check = 0;
			}
		} else {	//学生则需要判断权限
			if($myonline['isschool'] == 7 && !empty($myonline['folderid'])) {	//收费分成学校单独判断权限
				if($myonline['fprice'] == 0) {	//免费课程的直接有权限
					$check = 1;
				} else {	//非免费课程需要判断是否有课程权限
					$check = Ebh::app()->room->checkStudentPermission($user['uid'],$perparam);
				}
			} else {
				$roommodel = $this->model('Classroom');
				$charge = ($myonline['isschool'] == 6 || $myonline['isschool'] == 7) ? true : false;	//是否为收费平台
				$check = $roommodel->checkstudent($user['uid'], $crid,$charge);
			}
		}
		if($check == 1) {
			$sex = empty($user['sex']) ? '男':'女';
			$showname = '';
			$teaname = '';
			if($user['groupid'] == 6) {
				$type = 'u';
				if(empty($user['realname'])) {
					$showname = $user['username'];
				} else {
					$u1 = substr($user['username'],0,2);
					$u2 = substr($user['username'],-2,2);
					$showname = $user['realname'].'('.$u1.'**'.$u2.')';
				}
				$usermodel = $this->model('User');
				$tuser = $usermodel->getuserbyuid($myonline['tid']);
				if(!empty($tuser)) {
					$teaname = empty($tuser['realname']) ? $tuser['username'] : $tuser['realname'];
				}
			} else {
				$type = 't';
				$showname = empty($user['realname']) ? $user['username'] : $user['realname'];
				if($role == 2) {	//助教
					$usermodel = $this->model('User');
					$tuser = $usermodel->getuserbyuid($myonline['tid']);
					if(!empty($tuser)) {
						$teaname = empty($tuser['realname']) ? $tuser['username'] : $tuser['realname'];
					}
				} else {
					$teaname = $showname;
				}
			}
			$face = $user['face'];
			if(!empty($face) && stripos($face,'http://') === false)
				$face = 'http://www.ebh.net'.$face;
					
			if (!empty($face)) {
				$face = getthumb($face, '40_40',''); //头像 40 * 40
			}
			$result = array('status'=>1,'showname'=>$showname,'teaname'=>$teaname,'sex'=>$sex,'type'=>$type,'face'=>$face,'tid'=>$myonline['tid'],'cname'=>$myonline['title'],'role'=>$role);
//			echo json_encode($result);
			$this->echoCallback($result);
			exit();
		} else {
			$result = array('status'=>-1,'msg'=>'无权限');
//			echo json_encode($result);
			$this->echoCallback($result);
			exit();
		}
	}
	/**
	*根据APP接口过来的key获取当前用户
	*/
	private function getLoginUser() {
		if (isset($this->user))
			return $this->user;
		$auth = $this->input->get('key');
		$usermodel = $this->model('user');
        if (!empty($auth)) {
			$deauth = authcode($auth, 'DECODE');
            @list($password, $uid,$ip,$time) = explode("\t", $deauth);
            $curip = $this->input->getip();
            if($curip != $ip)
                return FALSE;
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            return $user;
        }
        return FALSE;
	}
	/**
	*以jsonp跨域支持的形式输出json
	*/
	private function echoCallback($result) {
		//header('Content-type: application/x-javascript');
		$callback = $this->input->get('callback');
		echo $callback . '(' . json_encode($result) . ')';
	}
}
