<?php

/**
 * 第三方直接登录入口
 */
class OloginController extends CControl {
	/**
	*http://sso.ebh.net/ologin.html?key=keyvalue
	*其中keyvalue对应值为base64_encode(登录账号+"\t"+用户密码+"\t"+ "608c8c9945f3cc"+"\t"+curdateline)
	*/
    public function index() {
		$key = $this->input->get('key');
		if(empty($key)) {
			exit();
		}
		$key = base64_decode($key);
		if(empty($key)) {
			echo 'error:600001<br />';
			echo 'msg:key is null<br />';
			exit();
		}
		$keylist = explode("\t",$key);
		if(!is_array($keylist) || count($keylist) != 4) {
			echo 'error:600002<br />';
			echo 'msg:key is not valid<br />';
			exit();
		}
		list($uname,$upass,$osign,$utime) = $keylist;
		if(empty($uname) || empty($upass) || empty($osign) || empty($utime)) {
			echo 'error:600002<br />';
			echo 'msg:key is not valid<br />';
			exit();
		}
		$oumodel = $this->model('Ouser');
		$ouser = $oumodel->getuserbyouser($uname,$upass,TRUE);
		if (empty($ouser)) {
			echo 'error:600003<br />';
			echo 'msg:user or pass is not valid<br />';
			exit();
		}
		$usermodel = $this->model('user');
        $user = $usermodel->login($ouser['username'], $ouser['password'],TRUE);
		if (!empty($user)) {
			//登录成功，则更新上次登录时间和IP信息
			$usermodel->update(array('lastlogintime'=>SYSTIME,'lastloginip'=>$this->input->getip()),$user['uid']);
			$this->savecookie($user);
			$roommodel = $this->model('Classroom');
			$room = $roommodel->getRoomByOsign($osign);
			if(empty($room)) {
				echo 'error:600004<br />';
				echo 'msg:osign is not valid<br />';
				exit();
			}
			$thepage = 'myroom.html';
			if($user['groupid'] == 5) {
				$thepage = 'troom.html';
			}
			$url = 'http://'.$room['domain'].'.ebh.net/'.$thepage;
			header("Location: $url");
		}
	}

	/**
	*保存登录状态
	*/
	private function savecookie($user){	
		$uid = $user['uid'];
		$pwd = $user['password'];
		$auth = authcode("$pwd\t$uid", 'ENCODE');
		$savestate = $this->input->post('cookietime');
		$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
		$this->input->setcookie('auth', $auth, $cookietime);
		$this->input->setcookie('lasttime', $user['lastlogintime'], $cookietime);
		$this->input->setcookie('thistime', SYSTIME, $cookietime);
		$this->input->setcookie('lastip', $user['lastloginip'], $cookietime);
		return 1;
	}
}
?>
