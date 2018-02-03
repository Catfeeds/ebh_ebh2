<?php

/**
 * 第三方登录密码修改接口
 * 格式为 http://sso.ebh.net/opass.html?key=base64(username\toldpass\tnewpass\tsign\ttime)
 * username:登录名
 * oldpass:老的原始密码
 * newpass:新的md5密码
 * sign:每个学校有个凭证号
 * time:操作的当前时间：格式为 20140630113001
 */
class OpassController extends CControl {
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
		if(!is_array($keylist) || count($keylist) != 5) {
			echo 'error:600002<br />';
			echo 'msg:key is not valid<br />';
			exit();
		}
		list($uname,$upass,$newpass,$osign,$utime) = $keylist;
		if(empty($uname) || empty($upass) || empty($newpass) || empty($osign) || empty($utime)) {
			echo 'error:600002<br />';
			echo 'msg:key is not valid<br />';
			exit();
		}
		$oumodel = $this->model('Ouser');
		$ouser = $oumodel->getOuserbyOuser($uname,$upass,TRUE);
		if (empty($ouser)) {
			echo 'error:600003<br />';
			echo 'msg:user or pass is not valid<br />';
			exit();
		}

		$wherearr = array('ouid'=>$ouser['ouid']);
		$param = array('userpass'=>$newpass);
		$result = $oumodel->update($param,$wherearr);
		echo 'ok';
	}
}
?>
