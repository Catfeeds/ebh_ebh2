<?php

/**
 * CUser用户组件类
 */
class CUser extends CComponent {

    private $user = NULL;
	private $auser = NULL;
	private $checklogin = NULL;//登录标识
	
    /**
	*获取普通登录用户信息
	*/
    public function getloginuser() {
        if (isset($this->user))
            return $this->user;
        $input = EBH::app()->getInput();
        $auth = $input->cookie('auth');
        if (!empty($auth)) {
			$usermodel = $this->model('user');
			$deauth = authcode($auth, 'DECODE');
			if(empty($deauth))
				return FALSE;
            @list($password, $uid) = explode("\t", $deauth);
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            if(!empty($user)) {
                $lastlogintime = $input->cookie('lasttime');
                $lastloginip = $input->cookie('lastip');
                $user['lastlogintime'] = empty($lastlogintime) ? '' : date('Y-m-d H:i',$lastlogintime);
                $user['lastloginip'] = $lastloginip;
				
				
            }
            $this->user = $user;
            return $user;
        }
        return FALSE;
    }
	/**
	*获取网校后台管理员登录用户信息
	*/
	public function getAdminLoginUser() {
		if (isset($this->auser))
            return $this->auser;
        $input = EBH::app()->getInput();
        $auth = $input->cookie('ak');
        if (!empty($auth)) {
			$deauth = authcode($auth, 'DECODE');
			if(empty($deauth))
				return FALSE;
            @list($password, $uid) = explode("\t", $deauth);
			$usermodel = $this->model('user');
            $uid = intval($uid);
            if ($uid <= 0) {
                return FALSE;
            }
            $user = $usermodel->getloginbyuid($uid,$password,TRUE);
            if(!empty($user)) {
                $lastlogintime = $input->cookie('lasttime');
                $lastloginip = $input->cookie('lastip');
                $user['lastlogintime'] = empty($lastlogintime) ? '' : date('Y-m-d H:i',$lastlogintime);
                $user['lastloginip'] = $lastloginip;
            }
            $this->auser = $user;
            return $user;
        }
        return FALSE;
	}

	/**
	 *获取当前用户加密信息，用于其他项目验证用户，如上传的验证
	 */
	public function getUserKey() {
		$user = $this->getLoginUser();
		if(empty($user))
			return FALSE;
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = Ebh::app()->getInput()->getip();
		$time = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$time";
		$auth = authcode($skey, 'ENCODE');
		return $auth;
	}
	
	/**
	 * 验证用户是否登录
	 * @author eker
	 * $user 用户user $location 是否跳转
	 */
	public function checkUserLogin($user=null,$location=false){
		if (isset($this->checklogin)){
			return $this->checklogin;
		}
		if(empty($user)){
			$user = $this->getLoginUser();
		}
		$this->checklogin = (!empty($user))? true: false;

		if(($location==true) && ($this->checklogin == false)){
			header('location:/login.html?returnurl='.$_SERVER['REQUEST_URI']);
			exit(0);
		}else{
			return $this->checklogin;
		}
	}
	
	//获取用户信息完整度百分比
	public function getpercent($user=null){
		if(empty($user)){
			$user = $this->getLoginUser();
		}
		$pc = 50;
		if($user['face'])
			$pc+=10;
		if($user['groupid']==5){//老师
			$info =$this->model('teacher')->getteacherdetail($user['uid']);
			unset($info['uid'],$info['realname'],$info['face'],$info['username']);
		}else{//学生
			$mmodel = $this->model('Member');
			$info = $mmodel->getfullinfo($user['uid']);
			unset($info['memberid'],$info['realname'],$info['face']);
		}
		foreach($info as $value){
			if(!empty($value))
				$pc+=3;
		}
		if($pc>100){$pc=100;}
		return $pc;
	}
	
	
}