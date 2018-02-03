<?php
/**
* SitecpController 控制器
* 为了兼容之前的跳转功能，如制作软件跳转troom等功能
* 主要一个工作是针对老的 http://www.ebanhui.com/sitecp.html?action=ctlogin 的处理
*/
class SitecpController extends CControl {
	private $user = NULL;
	public function index() {
		$key = $this->input->get('k');	//从软件传来的key值
		$action = $this->input->get('action');
		if($action == 'forget') {
			$url = 'http://www.ebanhui.com/forget.html';
			header("Location: $url");
			exit();
		}
		if($action == 'login') {
			$url = 'http://www.ebanhui.com/login.html';
			header("Location: $url");
			exit();
		}


		if($action != 'ctlogin') {	//非ctlogin请求则直接退出
			exit();
		}
		$type = (NULL !== $this->input->get('type')) ? $this->input->get('type') : '';
		//新增 ebhexam 类型，用于e板会平台过来的作业处理 apple浏览器需要这样跳转处理
		if($type == 'mexam' || $type == 'mque' || $type == 'iask' || $type == 'sapiexam' || $type == 'ebhexam') {	//移动端的作业接口，专门处理，因为移动 app接口的key和api的key生成方式不同
			//验证key是否有效
			if(!$this->_checkmkey($key)) {
				log_message('key check error');
				exit();
			}
		} else {
			//验证key是否有效
			if(!$this->_checkkey($key)) {
				log_message('key check error');
				exit();
			}
		}
		$troompath = $this->input->get('troom');
		
		$crid = $this->input->get('rid');
		$allowtype = array('info','avatar','setting','file','sapiexam');
		if($crid <= 0 && (!in_array($type,$allowtype)))
			exit();
		if(!empty($type)) {	//优先根据type来导航页面
			$this->_gotoWithType($type);
		} else {	//其次再根据troom参数进行导航
			$this->_gotoWithPath($troompath);
		}
	
	}
	/**
	*根据type参数进行导航
	* 请求链接 如 http://www.ebanhui.com/sitecp.html?action=ctlogin&type=c&rid=教室编号&cwid=课件编号&k=k值
	* @param string $type 请求的参数 c 学生课件详情 exam 学生我的作业 sexam 手机或者平板端学生我的作业 mexam 学生答题和查看作业详情页面
	* info 用户信息详情 avatar 用户修改头像 setting 用户修改资料 home 学生或教师的云平台主页 file 群共享文件页面
	*/
	private function _gotoWithType($type) {
		$crid = $this->input->get('rid');
		$cwid = $this->input->get('cwid');
		$fid = $this->input->get('fid');	//好友ID
		$nobtn = (NULL !== $this->input->get('nobtn')) ? $this->input->get('nobtn') : 0;
		if (empty($cwid))
			$cwid = $this->input->get('courseid');
		$param = array('crid'=>$crid,'cwid'=>$cwid,'fid'=>$fid,'nobtn'=>$nobtn);
		if($type == 'c') {	//课件详情页面
			$myurl = $this->mycoursedetail($param);
		} else if($type == 'exam'){	//学生我的作业页面
			$myurl = $this->myexam($param);
		}  else if($type == 'sexam'){	//学生我的作业页面，针对于手机平台页面专门处理
			$myurl = $this->smyexam($param);
		}  else if($type == 'mexam'){	//学生移动端我的作业答题和查看作业
			$myurl = $this->mexam($param);
		}  else if($type == 'mque'){	//学生移动端查看试题详情解析
			$myurl = $this->mque($param);
		}  else if($type == 'iask'){	//学生移动端问题详情页面
			$myurl = $this->iask($param);
		}  else if($type == 'info') {	//查看其他用户详情
			$myurl = $this->useinfo($param);
		} else if($type == 'avatar') {	//修改头像
			$myurl = 'http://www.ebanhui.com/member/setting/eqavatar.html';
		} else if($type == 'setting') {	//基本信息设置
			if($this->user['groupid'] == 5) {	//教师修改信息
				$myurl = 'http://www.ebanhui.com/teacher/setting/eqprofile-0-0-0-roomprofile.html';
			} else if($this->user['groupid'] == 6) {	//学生修改信息
				$myurl = 'http://www.ebanhui.com/member/setting/eqprofile.html';
			}
		} else if($type == 'home') {	
			$myurl = $this->userhome($param);
		} else if($type == 'file') {	//群文件共享页面
			$qunid = $_GET['qunid'];
			if(is_numeric($qunid))
				$myurl = 'http://www.ebanhui.com/qunfiles-0-0-0-'.$qunid.'.html';
		}else if($type == 'sapiexam'){//第三方直接做作业
			$eid = $this->input->get('eid');
			$returnurl = $this->input->get('returnurl');
			if(is_numeric($eid)){
				if(!empty($returnurl)){
					$myurl = 'http://exam.ebanhui.com/edo/'.$eid.'.html?returnurl='.urlencode($returnurl);
				}else{
					$myurl = 'http://exam.ebanhui.com/edo/'.$eid.'.html';
				}
			}else{
				echo 'eid error ';
				exit;
			}
		} else if($type == 'ebhexam'){	//学生移动端我的作业答题和查看作业
			$myurl = $this->ebhexam($param);
		}  
		if (!empty($myurl)) {
			$durl = $this->savecookie();
			echo '<script>var img = new Image();img.src =" '.$durl.'";img.onload = function(){location.href="'.$myurl.'";};</script>';
		}
	}
	/**
	*学生/老师课件详情的处理
	*/
	private function mycoursedetail($param = array()) {
		$myurl = '';
		$crid = $param['crid'];
		$cwid = $param['cwid'];
		if(!is_numeric($cwid) || $cwid <= 0 || !is_numeric($crid) || $crid <= 0)
			exit;
		$roommodel = $this->model('Classroom');
		$room = $roommodel->getRoomByCrid($crid);
		if(empty($room))
			return '';
		$myurl = $room['domain'];
		if(empty($param['nobtn']) || $param['nobtn'] != 1) {
			if ($this->user['groupid'] == 5) 
				$myurl = 'http://'.$myurl.'.ebanhui.com/troom/scourse/'.$cwid.'.html';
			else
				$myurl = 'http://'.$myurl.'.ebanhui.com/myroom/scourse/'.$cwid.'.html';
		} else {
			if ($this->user['groupid'] == 5) 
				$myurl = 'http://'.$myurl.'.ebanhui.com/troom/scourse/'.$cwid.'-0-0-0-1.html';
			else
				$myurl = 'http://'.$myurl.'.ebanhui.com/myroom/scourse/'.$cwid.'-0-0-0-1.html';
		}
		return $myurl;
	}
	/**
	*学生我的作业的处理
	*/
	private function myexam($param = array()) {
		$myurl = '';
		$crid = $param['crid'];
		$roommodel = $this->model('Classroom');
		$room = $roommodel->getRoomByCrid($crid);
		if(empty($room))
			return '';
		$myurl = $room['domain'];
		if($room['isschool'] == 3)	//如果是学校版本，就进入班级课程
			$myurl = 'http://'.$myurl.'.ebanhui.com/myroom/myexam.html';
		else
			$myurl = 'http://'.$myurl.'.ebanhui.com/myroom/exam.html';
		return $myurl;
	}
	/**
	*学生我的作业的处理
	*针对手机平板等专门处理
	*/
	private function smyexam($param = array()) {
		$myurl = '';
		$crid = $param['crid'];
		$roommodel = $this->model('Classroom');
		$room = $roommodel->getRoomByCrid($crid);
		if(empty($room))
			return '';
		$myurl = $room['domain'];
		if($room['isschool'] == 3)	//如果是学校版本，就进入班级课程
			$myurl = 'http://'.$myurl.'.ebanhui.com/myroom/sexam.html';
		else
			$myurl = 'http://'.$myurl.'.ebanhui.com/myroom/exam.html';
		return $myurl;
	}
	/**
	*学生我的作业的处理
	*针对手机平板等专门处理
	*/
	private function mexam($param = array()) {
		$myurl = '';
		$eid = $this->input->get('eid');
		$from = $this->input->get('from');
		$flag = $this->input->get('flag');
		$user = $this->user;
		$examModel = $this->model('exam');
		$param_a = array(
			'eid'=>$eid,
			'uid'=>$user['uid'],
			'status'=>1
		);
		$res = $examModel->getStuExamAnswerInfo($param_a);
		if(!empty($res)){
			$flag = 2;
		}
		if($flag == 2) {
			if($from == 'wap'){
				$myurl = "http://exam.ebanhui.com/wapemark/$eid.html";
			}else{
				$myurl = "http://exam.ebanhui.com/iemark/$eid.html";
			}
			
		} else {
			if($from == 'wap'){
				$myurl = "http://exam.ebanhui.com/wapedo/$eid.html";
			}else{
				$myurl = "http://exam.ebanhui.com/iedo/$eid.html";
			}
		}
		return $myurl;
	}
	/**
	*学生我的作业的处理
	*针对apple浏览器不支持跨域cookie设置的跳转处理
	*/
	private function ebhexam($param = array()) {
		$myurl = '';
		$eid = $this->input->get('eid');
		$from = $this->input->get('from');
		$flag = $this->input->get('flag');
		$user = $this->user;
		$examModel = $this->model('exam');
		$param_a = array(
			'eid'=>$eid,
			'uid'=>$user['uid'],
			'status'=>1
		);
		$res = $examModel->getStuExamAnswerInfo($param_a);	
		if(!empty($res)){	//已经答题
			$flag = 2;
		}
		if($flag == 2) {
			if($from == 'wap'){
				$myurl = "http://exam.ebanhui.com/wapemark/$eid.html";
			}else{
				$myurl = "http://exam.ebanhui.com/emark/$eid.html";
			}
			
		} else {
			if($from == 'wap'){
				$myurl = "http://exam.ebanhui.com/wapedo/$eid.html";
			}else{
				$myurl = "http://exam.ebanhui.com/edo/$eid.html";
			}
		}
		return $myurl;
	}
	/**
	*扫描查看试题解析详情
	*/
	private function mque($param = array()) {
		$myurl = '';
		$eid = intval($this->input->get('eid'));
		$qid = intval($this->input->get('qid'));
		$from = $this->input->get('from');
		$version = intval($this->input->get('version'));
		if(empty($version) || $version!=2)
			$myurl = "http://exam.ebanhui.com/wapqview/{$eid}/{$qid}.html";
		else
			$myurl = "http://www.ebh.net/wapqview.html?eid={$eid}&qid={$qid}";
		return $myurl;
	}
	/**
	*学生答疑问题详情
	*针对手机平板等专门处理
	*/
	private function iask($param = array()) {
		$myurl = '';
		$qid = $this->input->get('qid');
		$crid = $this->input->get('rid');
		$from = $this->input->get('from');
		if(empty($from)){
			$myurl = "http://www.ebanhui.com/iask/$qid.html";
		}else{
			$myurl = "http://www.ebanhui.com/iask/$qid.html?from=".$from;
		}
		return $myurl;
	}
	
	/**
	*查看会员详情页面跳转
	*/
	private function useinfo($param = array()) {
		$myurl = '';
		if(!empty($param['fid']))
			$myurl = 'http://www.ebanhui.com/member/myinfo/'.$param['fid'].'.html';
		else
			$myurl = 'http://www.ebanhui.com/member/myinfo.html';
		return $myurl;
	}
	/**
	*学生或会员跳转到平台首页/myroom/troom
	*/
	private function userhome($param = array()) {
		$crid = $param['crid'];
		$myurl = '';
		if(!is_numeric($crid) || $crid <= 0)
			return false;
		$roommodel = $this->model('Classroom');
		$room = $roommodel->getRoomByCrid($crid);
		if(empty($room))
			return '';
		$myurl = $room['domain'];
		if($this->user['groupid'] == 5) {
			$myurl = 'http://'.$myurl.'.ebanhui.com/troom.html';
		} else {
			$myurl = 'http://'.$myurl.'.ebanhui.com/myroom.html';
		}
		return $myurl;
	}
	/**
	*根据troom参数进行导航
	* 请求链接 如 http://www.ebanhui.com/sitecp.html?action=ctlogin&troom=subject&rid=教室编号&k=k值
	* @param string $troompath 请求的参数 subject 教师课程列表 addexam 添加作业 section 课程目录页
	*/
	private function _gotoWithPath($troompath) {
		$myurl = '';
		$crid = $this->input->get('rid');
		$cwid = $this->input->get('cwid');
		if(!is_numeric($crid) || $crid <= 0)
			return FALSE;
		$param = array('crid'=>$crid);
		if ($troompath == 'subject' || $troompath == 'subject.html') {
			$myurl = $this->subject($param);
		} elseif ($troompath == 'addexam') {
			if(is_numeric($cwid) && $cwid > 0) {
				$param['cwid'] = $cwid;
				$myurl = $this->addexam($param);
			}
		} elseif ($troompath == 'atta') {	//课件附件下载地址
			$attid = $this->input->get('eaid');
			if (is_numeric($attid) && $attid > 0) {
				$param['attid'] = $attid;
				$myurl = $this->atta($param);
			}
		} elseif ($troompath == 'cw') {
			if(is_numeric($cwid) && $cwid > 0) {
				$param['cwid'] = $cwid;
				$myurl = $this->courseatta($param);
			}
		} elseif ($troompath == 'exam') {	//学生答题
			$eaid = $this->input->get('eaid');
			if(is_numeric($eaid) || $eaid > 0)
				$myurl = 'http://exam.ebanhui.com/do/'.$eaid.'.html';
		} elseif ($troompath == 'texam') {	//教师编辑作业
			$eaid = $this->input->get('eaid');
			if(is_numeric($eaid) || $eaid > 0)
				$myurl = 'http://exam.ebanhui.com/edit/'.$eaid.'.html';
		} elseif ($troompath == 'stuexam'){	//普通网校学生答题
			$eid = $this->input->get('eid');
			if(is_numeric($eid) || $eid > 0)
				$myurl = 'http://exam.ebanhui.com/do/'.$eid.'.html';
		} elseif ($troompath == 'stusexam'){	//学校版本学生答题
			$eid = $this->input->get('eid');
			if(is_numeric($eid) || $eid > 0)
				$myurl = 'http://exam.ebanhui.com/edo/'.$eid.'.html';
		} elseif ($troompath == 'section') {	//教师课程目录列表管理页
			$cid = $this->input->get('cid');	//课程编号
			if(is_numeric($cid) || $cid > 0) {
				$param['cid'] = $cid;
				$myurl = $this->section($param);
			}
		}
		if (!empty($myurl)) {
			$durl = $this->savecookie();
			echo '<script>var img = new Image();img.src =" '.$durl.'";img.onload = function(){location.href="'.$myurl.'";};</script>';
		}
	}
	/**
	* 获取教师后台班级课程列表
	*/
	private function subject($param) {
		$crid = $param['crid'];
		$roommodel = $this->model('Classroom');
		$room = $roommodel->getRoomByCrid($crid);
		if(empty($room))
			return '';
		$myurl = $room['domain'];
		if($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7)	//如果是学校版本，就进入班级课程
			$myurl = 'http://'.$myurl.'.ebanhui.com/troom/classsubject.html';
		else
			$myurl = 'http://'.$myurl.'.ebanhui.com/troom/subject.html';
		return $myurl;
	}
	/**
	* 获取教师后台课程目录页面
	*/
	private function section($param) {
		$crid = $param['crid'];
		$cid = $param['cid'];	//课程编号
		$roommodel = $this->model('Classroom');
		$room = $roommodel->getRoomByCrid($crid);
		if(empty($room))
			return '';
		$myurl = $room['domain'];
		$myurl = 'http://'.$myurl.'.ebanhui.com/troom/section-0-0-0-'.$cid.'.html';
		return $myurl;
	}
	/**
	* 获取课件附件下载地址
	*/
	private function atta($param) {
		$attid = $param['attid'];
		$attmodel = $this->model('Attachment');
		$attach = $attmodel->getSimpleAttachById($attid);
		if(empty($attach))
			return '';
		$source = $attach['source'];
		$myurl = $source.'attach.html?attid='.$attid;
		return $myurl;
	}
	/**
	* 获取课件文件为附件时的下载地址
	*/
	private function courseatta($param) {
		$cwid = $param['cwid'];
		$coursemodel = $this->model('Courseware');
		$course = $coursemodel->getSimplecourseByCwid($cwid);
		if(empty($course))
			return '';
		$source = $course['cwsource'];
		$myurl = $source.'attach.html?cwid='.$cwid;
		return $myurl;
	}
	/**
	*获取教师后台布置作业界面，如果为学校，则直接到班级作业
	*/
	private function addexam($param) {
		$crid = $param['crid'];
		$cwid = $param['cwid'];
		$roommodel = $this->model('Classroom');
		$room = $roommodel->getRoomByCrid($crid);
		if(empty($room))
			return '';
		if($room['isschool'] == 3 || $room['isschool'] == 6 || $room['isschool'] == 7) {	//学校版本
			$myurl = 'http://'.$room['domain'].'.ebanhui.com/troom/classexam.html';
		} else {	//网校版本
			$myurl = 'http://exam.ebanhui.com/new/'.$crid.'/'.$cwid.'.html';
		}
		return $myurl;
	}
	/**
	* 验证传递的key是否有效
	*/
	private function _checkkey($key) {
		if (empty($key)) {
			return FALSE;
		}
		$clientip = $this->input->getip();
		$userdata = $this->cache->get($key);
		if (empty($userdata)) {	//如果用户缓存已过期，则验证key对应的用户信息
			$skey = authcode($key,'DECODE');
			if(empty($skey))
				return FALSE;
			list($ktime,$uid,$password,$cip) = explode('\t',$skey);
			if(empty($ktime) || empty($uid) || empty($password) || empty($cip) || $cip != $clientip)
				return FALSE;
			$usermodel = $this->model('User');
			$userdata = $usermodel->getloginbyuid($uid, $password,TRUE);
		} else {
			$cip = $userdata['ip'];
			$username = $userdata['username'];
			$password = $userdata['password'];
			$uid = $userdata['uid'];
			if (empty($username) || empty($password) || empty($cip) || $cip != $clientip) {	//非法参数
				return FALSE;
			}
		}
		if(empty($userdata)) {
			return FALSE;
		}
		$usermodel = $this->model('User');
		$user = $usermodel->login($userdata['username'], $userdata['password'],TRUE);
		if (!$user)
			return FALSE;
		$this->user = $user;
		$uid = $user['uid'];
        $pwd = $user['password'];
        $auth = authcode("$pwd\t$uid", 'ENCODE');
        $this->input->setcookie('auth', $auth);
		return TRUE;
	}
	/**
	* 验证传递的key是否有效(只针对APP接口中的exam接口)
	*/
	private function _checkmkey($key) {
		if (empty($key)) {
			return FALSE;
		}
		$clientip = $this->input->getip();
		$userdata = $this->cache->get($key);
		if (empty($userdata)) {	//如果用户缓存已过期，则验证key对应的用户信息
			$skey = authcode($key,'DECODE');
			if(empty($skey))
				return FALSE;
			@list($password,$uid,$cip,$ktime) = explode("\t",$skey);
			if(empty($ktime) || empty($uid) || empty($password) || empty($cip))
				return FALSE;
			$usermodel = $this->model('User');
			$userdata = $usermodel->getloginbyuid($uid, $password,TRUE);
		} else {
			$cip = $userdata['ip'];
			$username = $userdata['username'];
			$password = $userdata['password'];
			$uid = $userdata['uid'];
			$ktime = $userdata['ktime'];
			if(empty($ktime) || empty($uid) || empty($password) || empty($cip)){
				return FALSE;
			}
		}
		if(empty($userdata)) {
			return FALSE;
		}
		$usermodel = $this->model('User');
		$user = $usermodel->login($userdata['username'], $userdata['password'],TRUE);
		if (!$user)
			return FALSE;
		$this->user = $user;
		$uid = $user['uid'];
        $pwd = $user['password'];
		$ip = $this->input->getip();
		$ktime = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$ktime";
        $auth = authcode($skey, 'ENCODE');
        $this->input->setcookie('auth', $auth);
		return TRUE;
	}

	/**
	*保存登录状态，同时生成多域名处理请求
	*/
	private function savecookie(){
		$user = $this->user;
		$uid = $user['uid'];
		$pwd = $user['password'];
		$ip = $this->input->getip();
		$ktime = SYSTIME;
		$skey = "$pwd\t$uid\t$ip\t$ktime";
        $auth = authcode($skey, 'ENCODE');
		$savestate = $this->input->post('cookietime');
		$cookietime = empty($savestate) ? 0 : 31536000; //如果保存登录状态，则保存1年
		
		$durl = '';
		if(!empty(Ebh::app()->domains)) {	//处理多域名配置，如果存在多域名，则需要对其他域名cookie注入操作
			$curdomain = $this->uri->curdomain;
			if(!empty($curdomain) && in_array($curdomain,Ebh::app()->domains)) {
				$ctime = SYSTIME;	//当前时间，主要用于验证此SSO请求是否是已过期的
				$ssovalue = $auth.'___'.$user['lastlogintime'].'___'.SYSTIME.'___'.$user['lastloginip'].'___'.$cookietime.'___'.$ctime;
				$ssovalue = base64_encode($ssovalue);
				foreach(Ebh::app()->domains as $mydomain) {
					if($mydomain != $curdomain) {
						$durl = 'http://www.'.$mydomain.'/sso.html?k='.$ssovalue;
						break;
					}
				}
			}
		}
		return $durl;
	}

}