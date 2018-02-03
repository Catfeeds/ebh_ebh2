<?php

/**
 * CRoom 用于教室平台组件类
 */
class CRoom extends CComponent {

    private $_roominfo = NULL;
	private $_checkstudent = NULL;
	private $_checkteacher = NULL;
	private $_checkadmin = NULL;
    private $_checkadminv3 = NULL;//aroomv3使用
	private $_systemsetting = NULL;
	private $_roomtype = NULL;//网校类型
	
    /**
     * 获取当前平台简要信息
     * @return array 平台信息
     */
    public function getcurroom() {
        if (isset($this->_roominfo))
            return $this->_roominfo;
        $uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
        if ($domain != '' && $domain != 'www') {
			$roomcache = Ebh::app()->lib('Roomcache');
			$roominfo = $roomcache->getCache(0,'roominfo',$domain);	//通过缓存读取
			if(empty($roominfo)) {
				$roommodel = $this->model('Classroom');
				$roominfo = $roommodel->getroomdetailbydomain($domain);
				if(!empty($roominfo)) {
					$roomcache->setCache('0','roominfo',$domain,$roominfo,300);	//缓存5分钟
				}
			}
			if(!empty($roominfo['enddate']) && $roominfo['enddate']<SYSTIME){//网校过期
				header('Location: /loginlimit/expired.html');
				exit;
			}
			if (!empty($roominfo)) {
                if (is_mobile()) {
                    $roominfo['isdesign'] = $roominfo['isdesign'] >> 1;
                }
                $roominfo['isdesign'] = $roominfo['isdesign'] & 1;
            }
            $this->_roominfo = $roominfo;
            return $roominfo;
        }
        $this->_roominfo = FALSE;
        return FALSE;
    }

    /**
     * 验证当前用户是否有当前平台学生权限
	 * @param $return boolean 是否直接返回值而不跳转
     * @return boolean
     */
    public function checkstudent($return = FALSE) {
		if(isset($this->_checkstudent))
			return $this->_checkstudent;
        $user = Ebh::app()->user->getloginuser();
        $room = $this->getcurroom();
        if (empty($user) || $user['groupid'] != 6) {
        	$conf = Ebh::app()->getConfig()->load('othersetting');
        	$conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        	$conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        	$is_zjdlr = ($room['crid'] == $conf['zjdlr']) || (in_array($room['crid'],$conf['newzjdlr']));
        	$is_newzjdlr = in_array($room['crid'],$conf['newzjdlr']);
        	$domain = getdomain();
        	if($is_zjdlr){
        		$url = $domain;
        	}else{
				//myroom的returnurl带上完整域名，以防www域名下出错（第三方登录回调）
				$domainurl = $this->getDomainUrl();
        		$url = geturl('login') . '?returnurl=' . $domainurl.geturl('myroom');
        	}
            header("Location: $url");
            exit();
        }
        if (empty($room)) {
            $url = geturl('');
            header("Location: $url");
            exit();
        }
		if($room['ispublic'] == 2) {	//免费试听平台，则学生都能进去
			return true;
		}
        $roommodel = $this->model('Classroom');
        $charge = ($room['isschool'] == 6 || $room['isschool'] == 7) ? true : false;	//是否为收费平台
        $check = $roommodel->checkstudent($user['uid'], $room['crid'],$charge);
		$this->_checkstudent = $check == 1 ? true : $check;
        if ($check != 1 && !$return) {
            if ($check == 2) {
                $url = geturl('over');
            } else {
                $url = geturl('member');
            }
            header("Location: $url");
            exit();
        }
		if($return && $check != 1) {
			return $check;
		}
        return true;
    }
	/**
	*判断用户是否有平台权限
	* @return int 返回验证结果，1表示有权限 2表示已过期 0表示用户已停用 -1表示无权限 -2参数非法
	*/
	public function checkStudentPermission($uid,$param = array()) {
		if(empty($uid))
			return -2;
		$upmodel = $this->model('Userpermission');
		return $upmodel->checkUserPermision($uid,$param);
	}
	/**
	*根据功能点或者平台等信息获取支付服务项
	*@param array $param
	*/
	public function getUserPayItem($param) {
		$upmodel = $this->model('Userpermission');
		return $upmodel->getUserPayItem($param);
	}
    /**
     * 验证当前用户是否对此平台有教师权限
	 * @param $return boolean 是否直接返回值而不跳转
     * @return boolean
     */
    public function checkteacher($return = FALSE) {
		if(isset($this->_checkteacher))
			return $this->_checkteacher;
        $user = Ebh::app()->user->getloginuser();
        if (empty($user) || $user['groupid'] != 5) {
			$room = $this->getcurroom();
			$troomurl = gettroomurl($room['crid']);
			//troom的returnurl带上完整域名，以防www域名下出错（第三方登录回调）
			$domainurl = $this->getDomainUrl();
            $url = geturl('login') . '?returnurl=' . $domainurl.$troomurl;
            header("Location: $url");
            exit();
        }
		$room = $this->getcurroom();
        if (empty($room)) {
            $url = geturl('');
            header("Location: $url");
            exit();
        }
        $roommodel = $this->model('Classroom');
        $check = $roommodel->checkteacher($user['uid'], $room['crid']);
        if ($check != 1 && !$return) {
            $url = geturl('teacher/choose');
            header("Location: $url");
            return true;
        }
        if($return && $check != 1) {
			return $check;
		}
        return true;
    }
	/**
	* 验证当前用户是否对此平台有控制权限，即学校后台aroom权限 
	* 如果有管理权限则返回1，有控制查看权限（即此学校的上级学校管理者等），则返回2
	*/
	public function checkRoomControl() {
		if(isset($this->_checkadmin))
			return $this->_checkadmin;
		$user = Ebh::app()->user->getAdminLoginUser();
        if (empty($user) || $user['groupid'] != 5) {
			$room = $this->getcurroom();
			$troomurl = gettroomurl($room['crid']);
			$conf = Ebh::app()->getConfig()->load('othersetting');
        	$conf['zjdlr'] = !empty($conf['zjdlr']) ? $conf['zjdlr'] : 0;
        	$conf['newzjdlr'] = !empty($conf['newzjdlr']) ? $conf['newzjdlr'] : array();
        	$is_zjdlr = ($room['crid'] == $conf['zjdlr']) || (in_array($room['crid'],$conf['newzjdlr']));
        	$is_newzjdlr = in_array($room['crid'],$conf['newzjdlr']);
            $domain = getdomain();
			if($is_zjdlr){
//				$url = 'http://zjdlr.ebh.net';
				$url = $domain;
			}else{
				//troom的returnurl带上完整域名，以防www域名下出错（第三方登录回调）
				$domainurl = $this->getDomainUrl();
				$url = geturl('login') . '?returnurl=' . $domainurl.$troomurl;
			}

            header("Location: $url");
            exit();
       }
        $room = $this->getcurroom();
        if (empty($room)) {
            $url = geturl('');
            header("Location: $url");
            exit();
        }
		if($room['uid'] == $user['uid']) {	//当前用户为所有者，则表示有管理权限
			$this->_checkadmin = 1;
			return 1;
		}
		if(!empty($room['upid'])) {	//如果当前用户为平台的父级平台的所有者，则具有查看权限。
			$roommodel = $this->model('Classroom');
			$haspower = $roommodel->checkcontrolteacher($user['uid'],$room['crid']);
			if($haspower) {
				$this->_checkadmin = 2;
				return 2;
			}
		}
        if($room['uid'] != $user['uid']) {
            //如果是管理员端角色，表示有部分权限
            $teacherRoleModel = $this->model('Teacherrole');
            $role = $teacherRoleModel->getTeacherRole($user['uid'], $room['crid']);
            if (!empty($role) && is_array($role) && $role['category'] == 2 && isset($role['status']) && intval($role['status']) == 1) {
				$permissions = json_decode($role['permissions'], true);
				if(!empty($permissions)){
					$this->_checkadminv3 = 3;
					return true;
				}
            }
        }
		//其他教师，则跳转到教师教室选择页面
		$url = geturl('teacher/choose');
        header("Location: $url");
		return 0;
	}

    /**
     * aroomv3接口使用权限验证 不直接跳转
     * @return int|null
     */
    public function checkRoomControlV3(&$verifyCode=NULL) {
        if(isset($this->_checkadminv3))
            return $this->_checkadminv3;
        $user = Ebh::app()->user->getAdminLoginUser();
        $room = $this->getcurroom();
        if (empty($user) || $user['groupid'] != 5 ||empty($room) ) {
            if (empty($user)) {
                $verifyCode = 1;
            } else if ($user['groupid'] != 5) {
                $verifyCode = 2;
            } else if (empty($room)) {
                $verifyCode = 3;
            }
            return false;
        }
        if($room['uid'] == $user['uid']) {	//当前用户为所有者，则表示有管理权限
            $this->_checkadminv3 = 1;
            return true;
        }
        if(!empty($room['upid'])) {	//如果当前用户为平台的父级平台的所有者，则具有查看权限。
            $roommodel = $this->model('Classroom');
            $haspower = $roommodel->checkcontrolteacher($user['uid'],$room['crid']);
            if($haspower) {
                $this->_checkadminv3 = 2;
                return true;
            }
        }
        if($room['uid'] != $user['uid']) {
            //如果是管理员端角色，表示有部分权限
            $teacherRoleModel = $this->model('Teacherrole');
            $role = $teacherRoleModel->getTeacherRole($user['uid'], $room['crid']);
            if (!empty($role) && is_array($role) && $role['category'] == 2 && isset($role['status']) && intval($role['status']) == 1) {
				$permissions = json_decode($role['permissions'], true);
				if(!empty($permissions)){
					$this->_checkadminv3 = 3;
					return true;
				}
				//菜单权限判断，目前不支持
				//$uri = Ebh::app()->getUri();
				//$method = $uri->uri_method();
            }
        }
        //其他教师，则跳转到教师教室选择页面
        return false;
    }


	/**
	 * 获取系统设置
	 */
	public function getSystemSetting() {
    	if (isset($this->_systemsetting))
        	return $this->_systemsetting;

		$room = $this->getcurroom();
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_key = 'room_systemsetting_' . $room['crid'];

		$this->_systemsetting = $redis->hget($redis_key);
		if (empty($this->_systemsetting)){
            $this->_systemsetting['crid'] = $room['crid'];
			$this->_systemsetting = $this->model('systemsetting')->getSetting($room['crid']);
			$redis->hMset($redis_key, $this->_systemsetting);
		}

		return $this->_systemsetting;
	}

	/**
	 * 获取网校类型,主要是区别教育版和企业版
	 * 默认 edu 教育版
	 * 其他返回 com 企业版
	 */
	public function getRoomType(){
	    if (isset($this->_roomtype)){
	        return $this->_roomtype;
	    }
	    $room = $this->getcurroom();
	    if(isset($room['property']) && ($room['property']==3) &&
	       ( $room['isschool']==7)){
	          $this->_roomtype = 'com';
	    }else{
	        $this->_roomtype = 'edu';
	    }
	    
	    return $this->_roomtype;
	}
	
	/*
	 *获取网站域名完整地址（普通的和独立域名），供login的returnurl使用
	 * http://zxc.ebh.net   http://www.zxc.com
	*/
	private function getDomainUrl(){
		$uri = Ebh::app()->getUri();
		$uri_domain = ($uri->curdomain != 'ebh.net' && $uri->curdomain != 'ebanhui.com')?'':($uri->uri_domain().'.');
		$domainurl = 'http://'.$uri_domain.$uri->curdomain;
		return $domainurl;
	}
}
