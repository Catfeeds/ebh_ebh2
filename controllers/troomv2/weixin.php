<?php
/**
 * @desc 微信控制器   weixin
 */
class WeixinController extends CControl{
	public function __construct()
	{
	 	parent::__construct();
        Ebh::app()->room->checkteacher();
	}
	//首页
	public function index()
	{
		$this->display('troomv2/weixin/index');
	}
	/*
	*班级发信
	*针对班级内的学生，可选择某些学生是否发送，发送内容也可不同
	*此为加载模板处理
	*/
	// public function student_send_msg()
	// {
	// 	$roominfo = Ebh::app()->room->getcurroom();
 //        $user = Ebh::app()->user->getloginuser();
 //        $classlist = $this->model('Classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
	// 	$classid = $this->input->get('classid');
	// 	$classid = empty($classid) ? 0 : intval($classid);
	// 	$studentlist = array();
	// 	$verify = false;	//用于标示给定的classid是否在获取列表内
	// 	foreach($classlist as $tclass) {
	// 		if($tclass['classid'] == $classid) {
	// 			$verify = true;
	// 			break;
	// 		}
	// 	}
	// 	if(count($classlist) > 0 && !$verify) {
	// 		$classid = $classlist[0]['classid'];
	// 	}
	// 	if($classid>0){
	// 		$studentlist = self::model('Weixin')->getClassStudents($classid);
	// 	}
	// 	$this->assign('classid', $classid);
	// 	$this->assign('classlist', $classlist);
	// 	$this->assign('studentlist', $studentlist);
	// 	$this->display('troomv2/weixin/class_send');
	// }
	public function student_send_msg(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classlist = $this->model('Classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classid = $this->input->get('classid');
		$classid = empty($classid) ? 0 : intval($classid);
		$inajax = $this->input->get('inajax');
		$studentlist = array();
		$verify = false;	//用于标示给定的classid是否在获取列表内
		foreach($classlist as $tclass) {
			if($tclass['classid'] == $classid) {
				$verify = true;
				break;
			}
		}
		if(count($classlist) > 0 && !$verify) {
			$classid = $classlist[0]['classid'];
		}
		if($classid>0){
			$studentlist = self::model('Weixin')->getClassStudents($classid,$roominfo['crid']);
		}
		if($inajax == 1){
			$classname = "";
			foreach ($classlist as $class) {
				if($class['classid'] == $classid){
					$classname = $class['classname'];
					break;
				}
			}
			$returnArr = array(
				'classid'=>$classid,
				'classlist'=>$classlist,
				'studentlist'=>$studentlist,
				'stucount'=>count($studentlist),
				'classname'=>$classname
			);
			echo json_encode($returnArr);
			exit;
		}
		$this->assign('classid', $classid);
		$this->assign('classlist', $classlist);
		$this->assign('studentlist', $studentlist);
		$this->display('troomv2/weixin/class_send');
	}
	/**
	*班级群发
	*可针对多个班级发送信息
	*/
	public function class_send_msg()
	{
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classlist = $this->model('Weixin')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$this->assign('classlist', $classlist);
		$this->assign('tuid', $roominfo['uid']);
		$this->display('troomv2/weixin/some_classes');
	}
	//家长回复
	public function parent_send()
	{
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classlist = $this->model('Classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classid = $this->input->get('classid');
		$classid = empty($classid) ? 0 : intval($classid);
		$studentlist = array();
		$verify = false;	//用于标示给定的classid是否在获取列表内
		foreach($classlist as $tclass) {
			if($tclass['classid'] == $classid) {
				$verify = true;
				break;
			}
		}
		if(count($classlist) > 0 && !$verify) {
			$classid = $classlist[0]['classid'];
		}
		if($classid>0){
			$studentlist = $this->model('Weixin')->getClassStudentReplyList($classid);
		}
		$this->assign('classid', $classid);
		$this->assign('classlist', $classlist);
		$this->assign('studentlist', $studentlist);
		$this->display('troomv2/weixin/parent_send');
	}
	//历史信息
	// public function list_msg()
	// {
	// 	$roominfo = Ebh::app()->room->getcurroom();
 //        $user = Ebh::app()->user->getloginuser();
	// 	$curtime = SYSTIME;
	// 	$year = Date('Y',$curtime);
	// 	$month = Date('m',$curtime);
	// 	$starttime = mktime(0,0,0,$month,1,$year);
 //        $classlist = $this->model('Weixin')->getTeacherClassList($roominfo['crid'],$user['uid']);
	// 	$this->assign('starttime',$starttime);
	// 	$this->assign('endtime',$curtime);
	// 	$this->assign('classlist',$classlist);
	// 	$this->display('troomv2/weixin/list');
	// }
	/**
	*根据条件获取发信记录时间列表
	*/
	public function get_list_time() {
        $user = Ebh::app()->user->getloginuser();		
		$startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $roominfo = Ebh::app()->room->getcurroom();
		$htype = $this->input->post('htype');
		// $classid = $this->input->post('classid');
		$result = array();
   //      if($startDate == NULL || $endDate == NULL || empty($classid) || !is_numeric($classid) || !is_numeric($htype) ) {
   //          echo json_encode($result);
			// return;
   //      }
        if($startDate == NULL || $endDate == NULL || !is_numeric($htype) ) {
            echo json_encode($result);
			return;
        }
		$stardateline = '';
        $enddateline = '';
		if(!empty($startDate)) {
           $stardateline = strtotime($startDate);
        }
		if(!empty($endDate)) {
           $enddateline = strtotime($endDate);
		   if($enddateline !== FALSE) {
				$enddateline = $enddateline + 86400;	//结束时间要加上1天，不然不会包含当前的数据
		   }
        }
		// $param = array('send_uid'=>$user['uid'],'startDate'=>$stardateline,'endDate'=>$enddateline,'htype'=>$htype,'classid'=>$classid);
		$param = array('send_uid'=>$user['uid'],'startDate'=>$stardateline,'endDate'=>$enddateline,'crid'=>$roominfo['crid']);
		$weixinmodel = $this->model('Weixin');
		$msgtimelist = $weixinmodel->getHistoryTimelist($param);
		if(!empty($msgtimelist)) {
			for($i = 0; $i < count($msgtimelist); $i ++) {
				$msgtimelist[$i]['date'] = date('Y-m-d H:i:s',$msgtimelist[$i]['dateline']);
			}
		}
		echo json_encode($msgtimelist);
	}
	/**
	*根据条件获取发信记录
	*/
	public function get_list_msgs() {
		$user = Ebh::app()->user->getloginuser();		
		$curtime = $this->input->post('curtime');
		$htype = $this->input->post('htype');
		$classid = $this->input->post('classid');
		$result = array();
        if($curtime == NULL || !is_numeric($curtime) || empty($classid) || !is_numeric($classid) || !is_numeric($htype) ) {
            echo json_encode($result);
			return;
        }
		
		$param = array('send_uid'=>$user['uid'],'dateline'=>$curtime,'htype'=>$htype,'classid'=>$classid);
		$weixinmodel = $this->model('Weixin');
		$msglist = $weixinmodel->getHistoryMsglist($param);
		echo json_encode($msglist);
	}

	/**
	*处理班级发信表单请求
	*1，将所有选择记录插入数据库
	*2，将所有选择且绑定微信的，插入队列，读取队列后发送微信，如果发送失败一直存在队列中，发送成功后删除队列中内容
	*/
	public function do_send(){
		$uidlist = $this->input->post('wx_uid');	//所有选择的学生id 数组
		$classid = $this->input->post('classid');
		$classid = intval($classid);
		if(!$uidlist || empty($uidlist) || !is_array($uidlist) || $classid <= 0) {
			echo '提交数据为空或不准确，请稍后再试！';
			exit();
		}
		$binduidlist = $this->input->post('binduids');	//所有选择的学生且已经绑定有微信账号的学生id 数组
		$user = Ebh::app()->user->getloginuser();
		$username = empty($user['realname']) ? $user['username'] : $user['realname'];
		$allsendlist = array();	//所有选择的发送数据数组
		$wxsendlist = array();	//所有选择的且绑定有微信账号的发送数据数组
		$htype = 0;				//班级发信
		foreach($uidlist as $suid){
			$suid = intval($suid);	//学生uid 即 receive_uid
			if($suid <= 0)
				continue;
			
			$weixin_name = $this->input->post("wxname_{$suid}");//微信号
			$weixin_content = $this->input->post("content_{$suid}");//微信内容
			$sendarr = array('send_uid'=>$user['uid'],'send_name'=>$username,'receive_uid'=>$suid,'class_id'=>$classid,'htype'=>$htype,'weixin_name'=>$weixin_name,'weixin_content'=>$weixin_content);
			$allsendlist[] = $sendarr;
			if(!empty($weixin_name)){
				$wxsendlist[] = $sendarr;
			}
		}
		if(empty($allsendlist)) {
			echo '未选择任何学生';
			exit();
		}
		$wxmodel = $this->model('Weixin');
		$result = $wxmodel->batchInsertHistory($allsendlist);
		if($result > 0) {
			echo 'ok';
			fastcgi_finish_request();	//只要数据发送成功，则直接返回前端
			$sqslib = Ebh::app()->lib('EBH_httpsqs');
			//继续发送微信队列,后期可以做个本地程序定时发送队列信息
			//1,首先将发送数据放入队列
			foreach($wxsendlist as $wxsend) {
				$queue_name = 'wx_'.$wxsend['receive_uid'];
				$queue_value = serialize($wxsend);
				$sqslib->put($queue_name,$queue_value);
			}
			//2，从队列中取出数据，发送微信，如果发送成功，就删除队列
			foreach($wxsendlist as $wxsend) {
				$queue_name = 'wx_'.$wxsend['receive_uid'];
				$sresult = $this->send_queue($queue_name);
				
			}

		}
		echo '发送失败';
	}
	/**
	*根据queue_name将队列中的数据循环发送
	*队列项内容为数组，格式如：array('send_uid'=>$user['uid'],'receive_uid'=>$suid,'class_id'=>$classid,'htype'=>$htype,'weixin_name'=>$weixin_name,'weixin_content'=>$weixin_content);
	*/
	private function send_queue_old($queue_name) {
		$roominfo = Ebh::app()->room->getcurroom();
		$sqslib = Ebh::app()->lib('EBH_httpsqs');
		$queue_value = $sqslib->get($queue_name);
		$trycount = 0;	//发送消息失败后的尝试次数 //目前尝试3次
		$weixinlib = Ebh::app()->lib('WechatCallback');
		while(!empty($queue_value) && $queue_value != 'HTTPSQS_GET_END' && $trycount < 3) {
			$wxsend = unserialize($queue_value);
			if(!empty($wxsend)) {
				$openids = $wxsend['weixin_name'];
				$openidlist = explode(',',$openids);
				$msg = $wxsend['weixin_content'];
				$msg = shortstr($msg,100);
				if(!empty($wxsend['send_name']))
					$msg = $wxsend['send_name'].'对您说：'.$msg;
				foreach($openidlist as $openid) {
					$content = array(
						"url"=>"http://www.ebanhui.com/wxbind/wxdetail.html?batchid=".$this->batchid.'&weixin_name='.$openid.'&htype='.$wxsend['htype'],
						"data"=>array(
							"first"=>array(
								"value"=>$msg,
								"color"=>"#173177"
							),
							"keyword1"=>array(
								"value"=>$roominfo['crname'],
								"color"=>"#173177"
							),
							"keyword2"=>array(
								"value"=>date('Y-m-d H:i:s'),
								"color"=>"#173177"
							),
							"remark"=>array(
								"value"=>"点击查看",
								"color"=>"#173177"
							)
						)
					);
					$sresult = $weixinlib->sendMessageByOpenidWithTpl($openid,$content);
					if(!$sresult) {	//发送失败，则重新进入队列
						$cpwxsend = $wxsend;
						$cpwxsend['weixin_name'] = $openid;
						$sqslib->put($queue_name,serialize($cpwxsend));
						$trycount ++;
					}
				}
			}
			$queue_value = $sqslib->get($queue_name);
		}
		return TRUE;
	}


	private function send_queue($queue_name) {
		$roominfo = Ebh::app()->room->getcurroom();
		$sqslib = Ebh::app()->lib('EBH_httpsqs');
		$queue_value = $sqslib->get($queue_name);
		$trycount = 0;	//发送消息失败后的尝试次数 //目前尝试3次
		$weixinlib = Ebh::app()->lib('WechatCallback');
		while(!empty($queue_value) && $queue_value != 'HTTPSQS_GET_END' && $trycount < 3) {
			$wxsend = unserialize($queue_value);
			if(!empty($wxsend)) {
				$openids = $wxsend['weixin_name'];
				$openidlist = explode(',',$openids);
				$msg = $wxsend['weixin_content'];
				($sendname = $wxsend['send_name'].'老师' )|| ( $sendname = '老师' );
				foreach($openidlist as $openid) {
					$content = array(
						"url"=>"http://www.ebanhui.com/wxbind/wxdetail.html?batchid=".$this->batchid.'&weixin_name='.$openid.'&htype='.$wxsend['htype'],
						"data"=>array(
							"first"=>array(
								"value"=>shortstr($msg,40),
								"color"=>"#173177"
							),
							"keyword1"=>array(
								"value"=>$roominfo['crname'],
								"color"=>"#173177"
							),
							"keyword2"=>array(
								"value"=>$sendname,
								"color"=>"#173177"
							),
							"keyword3"=>array(
								"value"=>date('Y-m-d H:i:s'),
								"color"=>"#173177"
							),
							"keyword4"=>array(
								"value"=>shortstr($msg,1500,''),
								"color"=>"#173177"
							),
							"remark"=>array(
								"value"=>"点击查看",
								"color"=>"#173177"
							)
						)
					);
					$sresult = $weixinlib->sendMessageByOpenidWithTpl($openid,$content,false,2);
					if(!$sresult) {	//发送失败，则重新进入队列
						$cpwxsend = $wxsend;
						$cpwxsend['weixin_name'] = $openid;
						$sqslib->put($queue_name,serialize($cpwxsend));
						$trycount ++;
					}
				}
			}
			$queue_value = $sqslib->get($queue_name);
		}
		return TRUE;
	}

	/**
	*处理班级群发的消息请求
	*/
	public function do_send_class(){
		$user = Ebh::app()->user->getloginuser();
		$classlist = $this->input->post('classlist');
		if(empty($classlist) || !is_array($classlist)) {
			echo '提交数据为空或不准确，请稍后再试！';
			exit();
		}
		$username = empty($user['realname']) ? $user['username'] : $user['realname'];
		$allsendlist = array();	//所有选择的发送数据数组
		$htype = 1;				//班级群发
		foreach($classlist as $classid){
			$classid = intval($classid);	//学生uid 即 receive_uid
			if($classid <= 0)
				continue;
			
			$weixin_name = '';	//班级群发，微信号为空
			$weixin_content = $this->input->post("content_{$classid}");//微信内容
			$sendarr = array('send_uid'=>$user['uid'],'send_name'=>$username,'receive_uid'=>0,'class_id'=>$classid,'htype'=>$htype,'weixin_name'=>$weixin_name,'weixin_content'=>$weixin_content);
			$allsendlist[] = $sendarr;
			if(!empty($weixin_name)){
				$wxsendlist[] = $sendarr;
			}
		}
		if(empty($allsendlist)) {
			echo '未选择任何班级';
			exit();
		}
		//发送记录插入数据库
		$weixinmodel = $this->model('Weixin');
		$iresult = $weixinmodel->batchInsertHistory($allsendlist);
		if($iresult > 0) {
			echo 'ok';
			fastcgi_finish_request();	//只要数据发送成功，则直接返回前端
			$sqslib = Ebh::app()->lib('EBH_httpsqs');
			//获取班级下已绑定微信账号的用户列表，将微信信息入队列
			$uidlist = array();
			foreach($allsendlist as $sendinfo) {
				$studentlist = $weixinmodel->getOpenidListByClassid($sendinfo['class_id']);
				foreach($studentlist as $student) {
					$uidlist[] = $student['uid']; 
					$wxstudent = $sendinfo;
					$wxstudent['receive_uid'] = $student['uid'];
					$wx_name = '';
					if(!empty($student['wx_name_father']))
						$wx_name = $student['wx_name_father'];
					if(!empty($student['wx_name_mother'])) {
						if(empty($wx_name))
							$wx_name = $student['wx_name_mother'];
						else
							$wx_name .= ','.$student['wx_name_mother'];
					}
					$wxstudent['weixin_name'] = $wx_name;
					//1,首先将发送数据放入队列
					$queue_name = 'wx_classsend_'.$wxstudent['receive_uid'];
					$queue_value = serialize($wxstudent);
					$sqslib->put($queue_name,$queue_value);
				}
			}
			//循环所有学生，冲队列中取出数据发送
			foreach($uidlist as $uid) {
				$queue_name = 'wx_classsend_'.$uid;
				$sresult = $this->send_queue($queue_name);
			}
		}

		echo '发送失败';
	}
	/**
	*处理教师给学生家长的微信内容回复
	*/
    public function do_reply()
    {
    	$classid = $this->input->post('classid');	//选择的班级编号
		$uidlist = $this->input->post('wx_uid');	//选择要回复的用户
		$content = $this->input->post('content');	//要回复的内容
		if(NULL === $classid || !is_numeric($classid) || $classid <= 0) {	//班级信息需提交
			echo '提交信息不正确';
			exit();
		}
		if(empty($uidlist) || !is_array($uidlist)) {	//回复用户id提交不正确
			echo '提交信息不正确';
			exit();
		}
		if(empty($content)) {
			echo '回复内容不能为空';
			exit();
		}
		//验证提交的rid数组是否都为数字
		$checkok = TRUE;
		foreach($uidlist as $uid) {
			if(intval($uid) <= 0) {
				$checkok = FALSE;
				break;
			}
		}
		if(!$checkok) {
			echo '提交信息不正确';
			exit();
		}
		//验证教师是否是该班权限
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classlist = $this->model('Classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$verify = false;	//用于标示给定的classid是否在获取列表内
		foreach($classlist as $tclass) {
			if($tclass['classid'] == $classid) {
				$verify = true;
				break;
			}
		}
		if(!$verify) {
			echo '您无权回复此信息';
			exit();
		}
		/**
		*1,
		*/
		$username = empty($user['realname']) ? $user['username'] : $user['realname'];
		$allsendlist = array();	//所有选择的发送数据数组
		$wxsendlist = array();	//所有选择的且绑定有微信账号的发送数据数组
		$ridlist = array();	//回复用户对应的回复信息id数组，主要用于更新回复信息的状态为已读
		$htype = 0;
		foreach($uidlist as $uid) {
			$weixin_name = $this->input->post("wxname_{$uid}");//微信号
			$sendarr = array('send_uid'=>$user['uid'],'send_name'=>$username,'receive_uid'=>$uid,'class_id'=>$classid,'htype'=>$htype,'weixin_name'=>$weixin_name,'weixin_content'=>$content,'isreply'=>1);
			$allsendlist[] = $sendarr;
			if(!empty($weixin_name)){
				$wxsendlist[] = $sendarr;
			}
			$rids = $this->input->post("wx_{$uid}_rid");
			if(!empty($rids) && is_array($rids)) {
				foreach($rids as $rid) {
					if(is_numeric($rid) && $rid > 0)
						$ridlist[] = $rid;
				}
			}
		}
		if(empty($allsendlist)) {
			echo '未选择任何学生';
			exit();
		}
		$wxmodel = $this->model('Weixin');
		$result = $wxmodel->batchInsertHistory($allsendlist);
		if($result > 0) {
			echo 'ok';
			fastcgi_finish_request();	//只要数据发送成功，则直接返回前端
			$wxmodel->updateReplyStatus($ridlist,1);	//更新家长回复信息为已回复
			$sqslib = Ebh::app()->lib('EBH_httpsqs');
			//继续发送微信队列,后期可以做个本地程序定时发送队列信息
			//1,首先将发送数据放入队列
			foreach($wxsendlist as $wxsend) {
				$queue_name = 'wx_'.$wxsend['receive_uid'];
				$queue_value = serialize($wxsend);
				$sqslib->put($queue_name,$queue_value);
			}
			//2，从队列中取出数据，发送微信，如果发送成功，就删除队列
			foreach($wxsendlist as $wxsend) {
				$queue_name = 'wx_'.$wxsend['receive_uid'];
				$sresult = $this->send_queue($queue_name);
				
			}

		}
		echo '发送失败';

    }
	/**
	*处理教师删除家长回复
	*/
	public function do_delreply() {
		$classid = $this->input->post('classid');
		$ridlist = $this->input->post('wx_rid');
		if(NULL === $classid || !is_numeric($classid) || $classid <= 0) {	//班级信息需提交
			echo '提交信息不正确';
			exit();
		}
		if(empty($ridlist) || !is_array($ridlist)) {	//回复id提交不正确
			echo '提交信息不正确';
			exit();
		}
		//验证提交的rid数组是否都为数字
		$checkok = TRUE;
		foreach($ridlist as $rid) {
			if(intval($rid) <= 0) {
				$checkok = FALSE;
				break;
			}
		}
		if(!$checkok) {
			echo '提交信息不正确';
			exit();
		}
		//验证教师是否是该班权限
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classlist = $this->model('Classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$verify = false;	//用于标示给定的classid是否在获取列表内
		foreach($classlist as $tclass) {
			if($tclass['classid'] == $classid) {
				$verify = true;
				break;
			}
		}
		if(!$verify) {
			echo '您无权删除此信息';
			exit();
		}
		//删除数据
		$weixinmodel = $this->model('Weixin');
		$afrows = $weixinmodel->delReplys($ridlist,$classid);
		if($afrows !== FALSE) {
			echo 'ok';
			exit();
		}
		echo '删除失败';
		exit();
	}
	/**
	*处理清空家长回复
	*/
	public function do_clearreply() {
		$classid = $this->input->post('classid');
		if(NULL === $classid || !is_numeric($classid) || $classid <= 0) {	//班级信息需提交
			echo '提交信息不正确';
			exit();
		}

		//验证教师是否是该班权限
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classlist = $this->model('Classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$verify = false;	//用于标示给定的classid是否在获取列表内
		foreach($classlist as $tclass) {
			if($tclass['classid'] == $classid) {
				$verify = true;
				break;
			}
		}
		if(!$verify) {
			echo '您无权删除此信息';
			exit();
		}
		//删除数据
		$weixinmodel = $this->model('Weixin');
		$afrows = $weixinmodel->delReplysByClassid($classid);
		if($afrows !== FALSE) {
			echo 'ok';
			exit();
		}
		echo '删除失败';
		exit();
	}

	/**
	 *新版批量微信发送
	 *同时给班级和学生发送
	 */
	public function do_all_send(){
		$datas = $this->input->post('datas',false);
		if(empty($datas)){
			echo 0;
		}
		$datas = json_decode($datas);
		$this->batchid = uniqid();
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$username = empty($user['realname']) ? $user['username'] : $user['realname'];
		$classlist = array();
		$contentlist = array();
		$allsendlist = array();	//所有选择的发送数据数组
		$wxsendlist = array();	//所有选择的且绑定有微信账号的发送数据数组
		foreach ($datas as $data) {
			if($data->isAllStu == true){
				$classlist[] = $data->classid;
				$contentlist['content_'.$data->classid] = h($data->msg->content);
			}else{
				$htype = 0;
				foreach ($data->stroage as $skey => $student) {
					$sendarr = array('send_uid'=>$user['uid'],'send_name'=>$username,'receive_uid'=>$student->suid,'class_id'=>$data->classid,'htype'=>$htype,'weixin_name'=>$student->weixin_name,'weixin_content'=>h($student->msg->content),'batchid'=>$this->batchid,'crid'=>$roominfo['crid']);
					$allsendlist[] = $sendarr;
					if(!empty($student->weixin_name)){
						$wxsendlist[] = $sendarr;
					}
				}
			}
		}
		$res1 = $this->save_data_s($allsendlist);
		$res2 = $this->save_data_c($classlist,$contentlist);
		if(empty($res1) && empty($res2)){
			echo 0;exit;
		}else{
			echo 1;
		}
		fastcgi_finish_request();	//只要数据发送成功，则直接返回前端
		if(!empty($res1) && !empty($res2)){
			$this->do_send_s($wxsendlist);
			$this->do_send_c($res2);
		}else if(!empty($res1)){
			$this->do_send_s($wxsendlist);
		}else if(!empty($res2)){
			$this->do_send_c($res2);
		}
		
	}

	/**
	*处理针对学学生发信请求
	*1，将所有选择记录插入数据库
	*2，将所有选择且绑定微信的，插入队列，读取队列后发送微信，如果发送失败一直存在队列中，发送成功后删除队列中内容
	*/
	public function do_send_s($wxsendlist = array()){
			$sqslib = Ebh::app()->lib('EBH_httpsqs');
			//继续发送微信队列,后期可以做个本地程序定时发送队列信息
			//1,首先将发送数据放入队列
			foreach($wxsendlist as $wxsend) {
				$queue_name = 'wx_'.$wxsend['receive_uid'];
				$queue_value = serialize($wxsend);
				$sqslib->put($queue_name,$queue_value);
			}
			//2，从队列中取出数据，发送微信，如果发送成功，就删除队列
			foreach($wxsendlist as $wxsend) {
				$queue_name = 'wx_'.$wxsend['receive_uid'];
				$sresult = $this->send_queue($queue_name);
			}
	}

	/**
	*处理班级群发的消息请求
	*/
	public function do_send_c($allsendlist = array()){
			$sqslib = Ebh::app()->lib('EBH_httpsqs');
			//获取班级下已绑定微信账号的用户列表，将微信信息入队列
			$uidlist = array();
			foreach($allsendlist as $sendinfo) {
				$weixinmodel = $this->model('Weixin');
				$studentlist = $weixinmodel->getOpenidListByClassid($sendinfo['class_id']);
				foreach($studentlist as $student) {
					$uidlist[] = $student['uid']; 
					$wxstudent = $sendinfo;
					$wxstudent['receive_uid'] = $student['uid'];
					$wx_name = '';
					if(!empty($student['wx_name_father']))
						$wx_name = $student['wx_name_father'];
					if(!empty($student['wx_name_mother'])) {
						if(empty($wx_name))
							$wx_name = $student['wx_name_mother'];
						else
							$wx_name .= ','.$student['wx_name_mother'];
					}
					$wxstudent['weixin_name'] = $wx_name;
					//1,首先将发送数据放入队列
					$queue_name = 'wx_classsend_'.$wxstudent['receive_uid'];
					$queue_value = serialize($wxstudent);
					$sqslib->put($queue_name,$queue_value);
				}
			}
			//循环所有学生，冲队列中取出数据发送
			foreach($uidlist as $uid) {
				$queue_name = 'wx_classsend_'.$uid;
				$sresult = $this->send_queue($queue_name);
			}
	}

	/**
	 *给学生发送的微信写入数据库
	 */
	private function save_data_s($allsendlist = array()){
		if(empty($allsendlist)) {
			return 0;
		}
		$wxmodel = $this->model('Weixin');
		return $wxmodel->batchInsertHistory($allsendlist);
	}
	/**
	 *班级群发微信写入数据库
	 */
	private function save_data_c($classlist = array(),$contentlist = array()){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($classlist) || !is_array($classlist)) {
			return 0;
		}
		$username = empty($user['realname']) ? $user['username'] : $user['realname'];
		$allsendlist = array();	//所有选择的发送数据数组
		$htype = 1;				//班级群发
		foreach($classlist as $classid){
			$classid = intval($classid);	//学生uid 即 receive_uid
			if($classid <= 0)
				continue;
			
			$weixin_name = '';	//班级群发，微信号为空
			$weixin_content = $contentlist['content_'.$classid];//微信内容
			$sendarr = array('send_uid'=>$user['uid'],'send_name'=>$username,'receive_uid'=>0,'class_id'=>$classid,'htype'=>$htype,'weixin_name'=>$weixin_name,'weixin_content'=>$weixin_content,'batchid'=>$this->batchid,'crid'=>$roominfo['crid']);
			$allsendlist[] = $sendarr;
			if(!empty($weixin_name)){
				$wxsendlist[] = $sendarr;
			}
		}
		if(empty($allsendlist)) {
			return 0;
		}
		//发送记录插入数据库
		$weixinmodel = $this->model('Weixin');
		$res = $weixinmodel->batchInsertHistory($allsendlist);
		if(!empty($res)){
			return $allsendlist;
		}else{
			return 0;
		}
	}

	/*
	*班级发信
	*针对班级内的学生，可选择某些学生是否发送，发送内容也可不同
	*此为加载模板处理
	*/
	public function getClassAndStudentsInfo(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $classlist = $this->model('Classes')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$classid = $this->input->get('classid');
		$classid = empty($classid) ? 0 : intval($classid);
		$inajax = $this->input->get('inajax');
		$studentlist = array();
		$verify = false;	//用于标示给定的classid是否在获取列表内
		foreach($classlist as $tclass) {
			if($tclass['classid'] == $classid) {
				$verify = true;
				break;
			}
		}
		if(count($classlist) > 0 && !$verify) {
			$classid = $classlist[0]['classid'];
		}
		if($classid>0){
			$studentlist = self::model('Weixin')->getClassStudents($classid,$roominfo['crid']);
		}
		if($inajax == 1){
			$returnArr = array(
				'classid'=>$classid,
				'classlist'=>$classlist,
				'studentlist'=>$studentlist
			);
			echo json_encode($returnArr);
			exit;
		}
		$this->assign('classid', $classid);
		$this->assign('classlist', $classlist);
		$this->assign('studentlist', $studentlist);
		$this->display('troomv2/weixin/class_send');
	}

	//历史信息
	public function list_msg(){
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
		$startDate = $this->input->get('startDate');
		$endDate = $this->input->get('endDate');
		$starttime = $stardateline = (date("Y")-1).date("-m-d");
        $endtime = $enddateline = SYSTIME;
		if(!empty($startDate)) {
           $starttime = $stardateline = strtotime($startDate);
        }else{
        	$starttime = $stardateline = strtotime($stardateline);
        }
		if(!empty($endDate)) {
           $enddateline = strtotime($endDate);
		   if($enddateline !== FALSE) {
		   		$endtime = $enddateline;
				$enddateline = $enddateline + 86400;	//结束时间要加上1天，不然不会包含当前的数据
		   }
        }
        $param = parsequery();
		$param = array_merge($param,array(
				'starttime'=>$stardateline,
				'endtime'=>$enddateline,
				'send_uid'=>$user['uid'],
				'crid'=>$roominfo['crid']
			));
		$weixinModel = $this->model('Weixin');
        $sendList = $weixinModel->getSendList($param);
        $count = $weixinModel->getSendListCount($param);
        $pageStr = show_page($count,$param['pagesize']);
        $this->assign('pageStr',$pageStr);
		$this->assign('starttime',$starttime);
		$this->assign('endtime',$endtime);
		$this->assign('sendList',$sendList);
		$this->display('troomv2/weixin/list');
	}
	/**
	 *发信历史详情
	 */
	public function showDetail(){
		$batchid = $this->input->get('batchid');
		$id = $this->input->get('id');
		if(empty($batchid) || empty($id) || !is_numeric($id)){
			show_404();exit;
		}
		$roominfo = Ebh::app()->room->getcurroom();
        $user = Ebh::app()->user->getloginuser();
        $param = array(
        	'batchid'=>$batchid,
        	'send_uid'=>$user['uid'],
        	'crid'=>$roominfo['crid']
        );
        $weixinModel = $this->model('weixin');
        $details = $weixinModel->getWeixinDetail($param);
        if(empty($details)){
        	show_404();exit;
        }
        $details = EBH::app()->lib('UserUtil')->init($details,array('receive_uid'),true);
        $classes = $this->model('classes')->getClasses(array('crid'=>$roominfo['crid']));
        $newClasses = array();
        if(!empty($classes)){
        	foreach ($classes as $class) {
        		$key = 'class_'.$class['classid'];
        		$newClasses[$key] = $class['classname'];
        	}
        }
        $msgInfo = array(
        	'usernames'=>array(),
        	'classnames'=>array(),
        	'content'=>$details[0]['weixin_content']
        );
        foreach ($details as $detail) {
        	if(!empty($detail['receive_uid_name'])){
        		$msgInfo['usernames'][] = $detail['receive_uid_name'];
        	}else{
        		$key = 'class_'.$detail['class_id'];
        		$msgInfo['classnames'][] = $newClasses[$key];
        	}
        }
        $this->assign('msgInfo',$msgInfo);
        $this->display('troomv2/weixin/wxdetail');
	}
}
?>
