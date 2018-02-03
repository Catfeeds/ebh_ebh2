<?php
/*
 * 课件播放类
 */
include_once('./common.php');
$life = 1200;	//cookie和密匙有效期为2分钟
play();
/*
 * 课件播放
 */
function play() 
{
	$k = $_GET['k'];	//获取验证信息
	$cid = intval($_GET['cid']);
	$rflag = intval($_GET['rflag']);
	global $life,$_SGLOBAL;

	$key = authcode($k,'DECODE');
	list($ktime,$uid,$password,$clientip) = explode('\t', $key);
	$auth = authcode("$password\t$uid", 'ENCODE');

	$useragent = $_SERVER['HTTP_USER_AGENT'];
	//判断来源是否合法
	if ((strpos($useragent, 'www.ebanhui.com') === false) || empty($key))
	{
	//	error(1);
	}

	
	if (empty($ktime) || empty($clientip) || !is_numeric($ktime) || !is_numeric($cid) || $clientip != getip()) {
		error(2,'密匙不合法或已失效');
	}
	//判断用户登录,暂不考虑媒体中心用户的判断

	include_once (S_ROOT . './class/user.class.php');
	$userobj = new user();
	$chkresult = $userobj->checkloginbyauth($auth);
	if (!$chkresult) {
		error(2,'会员验证失败');
	}
	//判断用户身份类型1,代理商允许播放2,教师只允许看自己的3,后台用户需判断有无操作课件权限4,会员需要扣费处理
	$utype = $_SGLOBAL ['userinfo']['type'];
	$uid = $_SGLOBAL['userinfo']['uid'];
	$groupid = $_SGLOBAL['userinfo']['groupid'];
	$alltype = array('member','staff','teacher','agent');
	if (empty($utype) || !in_array($utype, $alltype)) {
		error(3,'非法的用户类型');
	}
	if ($utype == "staff") {	//后台用户
		//判断权限
	}

	include_once (S_ROOT . './class/onlinecourse.class.php');
	$courseobj = new onlinecourse();
	$course = $courseobj->getcourse($uid,$groupid,$cid);
	if (!empty($course)) {
		$cwname = $course['title'];
		if ($rflag == 1) {	//返回录播课件
			$cwurl = $course['recordurl'];
			if(empty($cwurl))
				exit;

		} else {
			$cwurl = $course['cwurl'];
			
			if(empty($cwurl))
				$cwurl = 'default.ebhp';
		}
		getfile('course',$cwurl,$cwname);
	}
	else {
		echo '课件不存在';
	}

}




?>