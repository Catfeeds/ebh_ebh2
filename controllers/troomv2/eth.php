<?php
/**
 * @desc 微信控制器   weixin
 * @author eker
 * @time 2016年6月21日14:04:29
 */
class EthController extends CControl{
	private $model = null;
	public function __construct()
	{
	 	parent::__construct();
      //  Ebh::app()->room->checkteacher();
        $this->model = $this->model('Eth');
	}
	/**
	 * 首页--添加消息
	 */
	public function index()
	{
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classlist = $this->model('Weixin')->getTeacherClassList($roominfo['crid'],$user['uid']);
		$this->assign('classlist', $classlist);
		$this->assign('tuid', $roominfo['uid']);
		
		//获取modulename
		$mnlib = Ebh::app()->lib('Modulename');
		$mnlib->getmodulename($this,array('modulecode'=>'weixin','tors'=>1,'crid'=>$roominfo['crid']));
		if($roominfo['property'] != 3){
			$this->display('troomv2/eth/index');
		} else {
			$this->display('troomv2/eth/index_enterprise');
		}
	}

	/**
	 * 消息保存
	 * 
	 * redis存储规则
	 * uid%crid%mid%batchid%totalcount%indexcount;
	 */
	public function save(){
		//exit;
		set_time_limit(0);
		$datas = $this->input->post('datas',false);
		if(empty($datas)){
			echo 0;
		}
		$datas = json_decode($datas);
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$username = empty($user['realname']) ? $user['username'] : $user['realname'];
		$subject = h($this->input->post("subject"));
		$message = h($this->input->post("message"));
		
		$crid = $roominfo['crid'];
		$ethmodel = $this->model("Eth");
		//存储消息
		$message = array(
			'send_uid'=>$user['uid'],
			'send_user'=>$username,
			'subject'=>$subject,
			'message'=>$message,
			'dateline'=>SYSTIME,
			'crid'=>$crid,
			'type'=>0,
			'send_total_num'=>0
		);
		$mid = $ethmodel->addMessage($message);
		if($mid>0){
			//存储发件箱
			$outbox = array(
				'mid'=>$mid,
				'send_uid'=>$user['uid'],
				'send_user'=>$username,
				'batchid'=>'',
				'batch_staus'=>0,
				'subject'=>$subject,
				'crid'=>$crid,
				'crname'=>$roominfo['crname'],	
				'dateline'=>SYSTIME
			);
			$ethmodel->addOutbox($outbox);
		}
		//直接显示发送成功
		echo 1;
		fastcgi_finish_request();	//只要数据发送成功，则直接返回前端
		
		$redis = Ebh::app()->getCache('cache_redis');
		$batchid = md5(uniqid(md5(microtime(true)),true));
		$redis_list_key = 'wxt_list';
		//把uid处理存储在链表中
		$classlist = array();//班级数组
		$simplestudentlist = array();	//单独选择的学生数组
		$classstudentlist = array();//班级学生数组
		$uids = '';//独立选择的用户
		$receive_user = '';//收件人 字符串
		$totalcount  = 0;//处理总数
		$indexcount = 1;//当前所在第几
		
		foreach ($datas as $data) {
			if($data->isAllStu == true){
				$classlist[] = $data->classid;
				$receive_user.=$data->tag."、";
			}else{
				foreach ($data->stroage as $skey => $student) {
					$simplestudentlist[] = $student->suid;
					$receive_user.=$student->tag."、";
				}
			}
		}
		//组装班级uid
		if(!empty($classlist)){
			$classstudentlist = $ethmodel->getClassStudents($classlist);
		}
		
		//计算总数
		$totalcount = count($simplestudentlist)+count($classstudentlist);
		if(!empty($simplestudentlist)){
			foreach($simplestudentlist as $sstudent){
				$sdata = $sstudent."%".$crid."%".$mid."%".$batchid."%".$totalcount."%".$indexcount;
				$s = $redis->rpush($redis_list_key,$sdata);
				$indexcount++;
				//log_message(var_export($s,true));
			}
			$uids =!empty($simplestudentlist)?implode(",", $simplestudentlist):'';
			unset($simplestudentlist);
		}
		if(!empty($classstudentlist)){
			foreach($classstudentlist as $cstudent){
				$cdata = $cstudent['uid']."%".$crid."%".$mid."%".$batchid."%".$totalcount."%".$indexcount;
				$s2 = $redis->rpush($redis_list_key,$cdata);
				$indexcount++;
			//	log_message(var_export($s2,true));
			}
			unset($classstudentlist);
		}
		
		//修改邮件主表
		$classids = !empty($classlist)?implode(",", $classlist):'';
		$ethmodel->editMessage(array('type'=>($totalcount==1)?1:2,'send_total_num'=>$totalcount,'send_success_num'=>$totalcount,'classids'=>$classids,'uids'=>$uids),$mid);
		//修改发件箱
		$receive_user = !empty($receive_user) ? rtrim($receive_user,"、") : '' ;
		$ethmodel->editOutbox(array('batchid'=>$batchid,'classids'=>$classids,'send_total_num'=>$totalcount,'receive_user'=>$receive_user,'uids'=>$uids),$mid);
	}
	
	/**
	 * 发信历史
	 */
	public function history(){
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
		$ethmodel = $this->model('Eth');
		$sendList = $ethmodel->getOutboxList($param);
		$count = $ethmodel->getOutboxCount($param);
		$pageStr = show_page($count,$param['pagesize']);
		$this->assign('pageStr',$pageStr);
		$this->assign('starttime',$starttime);
		$this->assign('endtime',$endtime);
		$this->assign('sendList',$sendList);
		if($roominfo['property'] != 3){
			$this->display('troomv2/eth/history');
		} else {
			$this->display('troomv2/eth/history_enterprise');
		}
	}
	
	/**
	 * 删除发件箱
	 */
	public function deloutbox(){
		$mid = intval($this->input->post('mid'));
		$user = Ebh::app()->user->getloginuser();
		if($mid>0){
			$ethmodel = $this->model('Eth');
			$minfo = $ethmodel->getMessage($mid);
			if(($minfo['del']==1) || ($minfo['send_uid'] !=$user['uid'])){
				exit();
			}
			//删除发件箱
			$ethmodel->editOutbox(array('del'=>1),$mid);
			//删除邮件
			$ethmodel->editMessage(array('del'=>1),$mid);
			echo 1;
		}
	}
	
	/**
	 * 删除收件箱
	 */
	public function delinbox(){
		$user = Ebh::app()->user->getloginuser();
		$inid = intval($this->input->post('inid'));
		if($inid>0){
			$inbox = $this->model('Eth')->getInbox($inid);
			if ($inbox['del'] == 1 || ($inbox['send_uid'] != $user['uid'] && $inbox['in_uid'] != $user['uid'])){
				echo '0';
				exit;
			}
			$this->model('Eth')->delInbox($inid);
			echo 1;
		}
	}
	
	public function delreply(){
		$user = Ebh::app()->user->getloginuser();
		$rid = intval($this->input->post('rid'));
		if($rid>0){
			$reply = $this->model('Eth')->getReply($rid);
			if ($reply['del'] == 1 || $reply['send_uid'] != $user['uid']){
				echo '0';
				exit;
			}
			$this->model('Eth')->delReply($rid);
			echo 1;
		}
	}

	/**
	 * 发信历史-查看
	 */
	public function history_view(){
		$mid = intval($this->uri->itemid);
		$this->assign("mid", $mid);

		$message = $this->model('Eth')->getMessage($mid);
		$replycount = empty($message['reply_count']) ? 0 : $message['reply_count'];
		$this->assign('replycount', $replycount);
		
		$ethmodel = $this->model('Eth');
		$minfo = $ethmodel->getMessage($mid);
		$user = Ebh::app()->user->getloginuser();
		if($minfo['send_uid'] !=$user['uid']){
			exit(0);
		}
		
		$this->assign("minfo", $minfo);
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['property'] != 3){
			$this->display('troomv2/eth/history_view');
		} else {
			$this->display('troomv2/eth/history_view_enterprise');
		}
	}
	
	/**
	 * 发信历史-发送失败
	 */
	public function history_error_view(){
		$mid = intval($this->uri->itemid);
		if(empty($mid)){
			$mid = $this->uri->uri_attr(0);
		}

		$message = $this->model('Eth')->getMessage($mid);
		$replycount = empty($message['reply_count']) ? 0 : $message['reply_count'];
		$this->assign('replycount', $replycount);

		$type = $this->uri->uri_attr(1);
		if (!is_numeric($type))
			$type = 0;

		$param = parsequery();
		$param = array_merge($param,array(
				'mid'=>$mid,
				'type'=>$type,
				'pagesize'=>50
		));

		$inboxList = $this->model('Eth')->getInboxList($param);
		$count = $this->model('Eth')->getInboxCount($param);

		$pageStr = show_page($count,$param['pagesize']);

		if(!empty($inboxList)){
			$inboxList = $this->model('Eth')->getUserInfo($inboxList,'in_uid');
		}

		$this->assign('pagestr',$pageStr);
		$this->assign('inboxList',$inboxList);
		$this->assign("mid", $mid);
		$this->assign("type", $type);
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['property'] != 3){
			$this->display('troomv2/eth/history_error');
		} else {
			$this->display('troomv2/eth/history_error_enterprise');
		}
	}
	/**
	 * 发信历史-统计分析
	 */
	public function history_tong_view(){
		$mid = intval($this->uri->itemid);

		$message = $this->model('Eth')->getMessage($mid);
		$replycount = empty($message['reply_count']) ? 0 : $message['reply_count'];
		$this->assign('replycount', $replycount);
		$this->assign('message', $message);
		$this->assign("mid", $mid);
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['property'] != 3){
			$this->display('troomv2/eth/history_tong');
		} else {
			$this->display('troomv2/eth/history_tong_enterprise');
		}
	}
	/**
	 * 发信历史-查看回复
	 */
	public function history_reply_view(){
		$mid = intval($this->uri->itemid);

		$message = $this->model('Eth')->getMessage($mid);
		$replycount = empty($message['reply_count']) ? 0 : $message['reply_count'];
		$this->assign('replycount', $replycount);

		$param = parsequery();
		$param['mid'] = $mid;
		$param['pagesize'] = 50;
		$replylist = $this->model('Eth')->getReplyList($param);
		$count = $this->model('Eth')->getReplyCount($param);

		$pageStr = show_page($count,$param['pagesize']);

		if(!empty($replylist)){
			$replylist = $this->model('Eth')->getUserInfo($replylist,'uid');
		}

		$this->assign('pagestr',$pageStr);
		$this->assign('replylist',$replylist);
		$this->assign("mid", $mid);
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['property'] != 3){
			$this->display('troomv2/eth/history_reply');
		} else {
			$this->display('troomv2/eth/history_reply_enterprise');
		}
	}
	
	/**
	 * 收件箱
	 */
	public function inbox(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param = array_merge($param,array(
				'in_uid'=>$user['uid'],
				'crid'=>$roominfo['crid'],
				'pagesize'=>50,
		));
		$ethmodel = $this->model('Eth');
		$inboxList = $ethmodel->getInboxList($param);
		$count = $ethmodel->getInboxCount($param);
		$pageStr = show_page($count,$param['pagesize']);
		
		if(!empty($inboxList)){
			$inboxList = $ethmodel->getUserInfo($inboxList,'send_uid');
		}
		$this->assign('pagestr',$pageStr);
		$this->assign('inboxList',$inboxList);
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['property'] != 3){
			$this->display('troomv2/eth/inbox');
		} else {
			$this->display('troomv2/eth/inbox_enterprise');
		}
	}

	/**
	 * 查看收件箱详情
	 */
	public function inbox_view() {
		$user = Ebh::app()->user->getloginuser();
		$inid = $this->uri->itemid;
		$inbox = $this->model('Eth')->getInbox($inid);
		if (!empty($inbox['isreply'])) {
			$param['mid'] = $inbox['mid'];
			$param['uid'] = $user['uid'];
			$param['limit'] = 50;
			$replylist = $this->model('Eth')->getReplyList($param);
			$this->assign('replylist', $replylist);
		}

		$this->assign('inbox', $inbox);
		$this->display('troomv2/eth/inbox_view');

	}

	/**
	 * 回复信息
	 */
	public function inbox_reply_view() {
		$user = Ebh::app()->user->getloginuser();
		$inid = $this->uri->itemid;
		$inbox = $this->model('Eth')->getInbox($inid);

		$this->assign('inbox', $inbox);
		$this->display('troomv2/eth/inbox_reply_view');

	}

	/**
	 * 教师回复
	 */
	public function savereply() {
		$user = Ebh::app()->user->getloginuser();
		$inid = $this->input->post('inid');
		$param['mid'] = $this->input->post('mid');
		$param['comment'] = $this->input->post('comment');
		$param['quote'] = $this->input->post('quote');
		$param['uid'] = $user['uid'];
		$param['dateline'] = SYSTIME;
		$param['type'] = 1;
		$param['touid'] = $this->input->post('touid');
		$roominfo = Ebh::app()->room->getcurroom();
		$param['crid'] =$roominfo['crid'];
		$result = $this->model('Eth')->addReply($param);

		if ($result){
			//收件箱设为已回复
			$this->model('Eth')->editInbox(array('inid'=>$inid,'isreply'=>1));
			//信息回复数加1
			$this->model('Eth')->editMessage(array(),$param['mid'],array('reply_count'=>'reply_count+1'));
			//家长未读回复数加1
			$parentlist = $this->model('Eth')->getParentPid($param['touid']);
			if (!empty($parentlist)) {
				foreach ($parentlist as $parent) {
					$this->model('Eth')->editParent(array(),$parent['pid'],array('noreply'=>'noreply+1'));
				}
			}
			echo '1';
		} else {
			echo '0';
		}
	}
	
	/**
	 * 绑定详情
	 */
	public function bind(){
		$request = $this->input->get();
		$classid = !empty($request['classid']) ? intval($request['classid']): '';
		$type = !empty($request['type']) ? $request['type'] : 'ALL';
		
		//获取所有班级
		$room = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$classlist = $this->model('Weixin')->getTeacherClassList($room['crid'],$user['uid']);
		//var_dump($classlist);
	
		$this->assign('classlist', $classlist);
		$this->assign('request', $request);
		
		$classidarr = array();
		foreach($classlist as $class){
			array_push($classidarr,$class['classid']);
		}
		if($classid>0){
			$classidarr = $classid;
		}
		$param = parsequery();

		if($type=="ALL"){//获取所有
			$param = array_merge($param,
					array('classid'=>$classidarr),
					array('crid'=>$room['crid'])
			);
			$count = $this->model('Eth')->getClassStudentWithBindCount($param);
			$studentlist = $this->model('Eth')->getClassStudentWithBindList($param);
			$pagestr = show_page($count);
			$this->assign('studentlist', $studentlist);
			$this->assign('pagestr', $pagestr);
			$this->assign('totalcount', $count);
		}elseif($type=='binded'){//已绑定
			$bindUidArr = $this->model("Eth")->getBindStudent($room['crid']);
			$uidarr = array();
			foreach($bindUidArr as $bind){
				array_push($uidarr, $bind['uid']);
			}
			$condition = !empty($uidarr) ? "1 = 1": " 1 != 1";
			$param = array_merge($param,
					array('classid'=>$classidarr),
					array('crid'=>$room['crid']),
					array('uidarr'=>$uidarr),
					array('condition'=>$condition)
			);
			$count = $this->model('Eth')->getClassStudentWithBindCount($param);
			$studentlist = $this->model('Eth')->getClassStudentWithBindList($param);
			$pagestr = show_page($count);
			$this->assign('studentlist', $studentlist);
			$this->assign('pagestr', $pagestr);
			
			$this->assign('bindcount', $count);
		}elseif($type=='nobind'){//未绑定
			$bindUidArr = $this->model("Eth")->getBindStudent($room['crid']);
			$uidarr = array();
			foreach($bindUidArr as $bind){
				array_push($uidarr, $bind['uid']);
			}
			//$condition = !empty($uidarr) ? "1 = 1": " 1 != 1";
			$param = array_merge($param,
					array('classid'=>$classidarr),
					array('crid'=>$room['crid']),
					array('nouidarr'=>$uidarr)
			);
			$count = $this->model('Eth')->getClassStudentWithBindCount($param);
			$studentlist = $this->model('Eth')->getClassStudentWithBindList($param);
			$pagestr = show_page($count);
			$this->assign('studentlist', $studentlist);
			$this->assign('pagestr', $pagestr);
				
			$this->assign('nobindcount', $count);
		}
		$roominfo = Ebh::app()->room->getcurroom();
		if($roominfo['property'] != 3){
			$this->display('troomv2/eth/bind');
		} else {
			$this->display('troomv2/eth/bind_enterprise');
		}
	}
	
	
	
	/***************************************以下是微信推送 定时发送处理*****************************************************/
	/**
	 * 定时发送处理
	 * 
	 * 发送处理接口
	 */
	public function send(){
		$redis = Ebh::app()->getCache('cache_redis');
		$redis_list_key = 'wxt_list';
		$process_count = 100;
		
		//获取链表的长度
		//$len = $redis->llen($redis_list_key);
		
		
		//测试
		//log_message(var_export(date("Y-m-d H:i:s"),true));
		//$input = EBH::app()->getInput();
		//$cookie = $input->cookie('auth');
		//log_message(var_export($cookie,true));
		
		
		
		$listarr = $redis->lrange($redis_list_key,0,$process_count-1);
		//echo '<pre>';
		//var_dump($listarr);
		$len = count($listarr);
		if($len<=0) return ;
		
		//删除链表数据 
		$redis->ltrim($redis_list_key,$len,-1);
		
		//发送微信消息
		foreach($listarr as $list){
			$trycount = 0;	//发送消息失败后的尝试次数 //目前尝试3次
			$docheck = false;
			while (!$docheck){
				if($trycount < 3){
					$sresult = $this->send_weixin($list);
					if(!$sresult) {	//发送失败，则重新尝试发送
						$sresult = $this->send_weixin($list);
						$trycount ++;
					}else{//发送成功
						$docheck = true;
						$this->save_inbox($list);
					}
				}else{//三次尝试 发送失败 
					$this->save_inbox($list,false);
					break;
				}
			}
		}
		
	}
	/**
	 * 发送消息到微信账号
	 * @return unknown
	 */
	protected function send_weixin($list){
		//$openid = 'o5TnfjmDmAq0mO7h4OlkEl1pMYXI';
		//$openid = 'o5TnfjqPjtS9k54Og7G2r4V6cFR0';
		
		//list($uid,$mid,$batchid) = explode("%", $list);
		$listarr = $this->getListData($list);
		//log_message(var_export($listarr,true));
		//获取消息信息
		$message = $this->model("Eth")->getMessage($listarr['mid']);
		$msg = $message['subject'];
		$weixinlib = Ebh::app()->lib('Wechat');
		$config = $this->model("Eth")->getConfigByCrid($listarr['crid']);
		$weixinlib->init($config);
		
		//读取授权域名
		$domain =$weixinlib->getDomain();
		$show_msg_url = !empty($domain) ? $domain : "http://eth.ebh.net"  ;
		
		$content = array(
				"url"=>$show_msg_url."/wxt/msg/{$listarr['mid']}.html?student={$listarr['uid']}&ebhcode={$config['ebhcode']}",
				"data"=>array(
						"first"=>array(
								"value"=>shortstr($msg,40),
								"color"=>"#173177"
						),
						"keyword1"=>array(
								"value"=>$message['crname'],
								"color"=>"#173177"
						),
						"keyword2"=>array(
								"value"=>$message['send_user'],
								"color"=>"#173177"
						),
						"keyword3"=>array(
								"value"=>date('Y-m-d H:i:s'),
								"color"=>"#173177"
						),
						"keyword4"=>array(
								"value"=>$msg,
								"color"=>"#173177"
						),
						"remark"=>array(
								"value"=>"点击查看",
								"color"=>"#173177"
						)
				)
		);
		
		//暂时先去掉消息标题
		$content['data']['first'] = array();
		//获取用户绑定的父母openid
		$sresult = true;//暂时 默认是有绑定了
		$parents = $this->model("Eth")->getParentOpenid($listarr['uid']);
		if(!empty($parents)){
			foreach($parents as $parent){
				if($parent['crid'] == $listarr['crid']){//向绑定该网校下的父母发送推送
					$openid = $parent['openid'];
					$sresult = $weixinlib->sendMessageByOpenidWithTpl($openid,$content,false);
					//log_message(var_export($openid,true));
					//父母收件未读数+1
					$this->model("Eth")->incrNoread($openid);
				}

			}
		}
	
		return $sresult;
	}
	
	/**
	 * 发送成功/失败 写入收件箱
	 */
	protected function save_inbox($list,$success=true){
		//list($uid,$mid,$batchid) = explode("%", $list);
		$listarr = $this->getListData($list);
		$mid = $listarr['mid'];
		$uid = $listarr['uid'];
		$message = $this->model("Eth")->getMessage($mid);
		$ceceive_user = $this->model("Eth")->getUserInfo(array(array('uid'=>$uid)));
		$ceceive_user = $ceceive_user[0];
		//写收件箱
		$inbox = array(
			'in_uid'=>$uid,
			'in_user'=>getusername($ceceive_user),
			'mid'=>$mid,
			'crid'=>$listarr['crid'],
			'status'=>($success==true)?1:0,
			'dateline'=>SYSTIME					
		);
		$this->model("Eth")->addInbox($inbox);
		
		//更新邮件计数
		if($success==false){
			$incrarr = array(
				"send_success_num"=>"send_success_num - 1",
				"send_error_num"=>"send_error_num + 1"
				);
			$this->model->editMessage(null,$mid,$incrarr);
			$this->model->editOutbox(null,$mid,$incrarr);
		}
		
		//批次是否处理完
		if($listarr['totalcount'] == $listarr['indexcount']){
			//标记处理完成
			$this->model->updateBatchStatus($listarr['batchid']);
		}
	}
	
	/**
	 * 处理redis链表存储数据-单个数据
	 */
	private function getListData($list){
		$ret = false;
		if(empty($list) || (strpos($list, "%")==false)){
			return false;
		}
		list($uid,$crid,$mid,$batchid,$totalcount,$indexcount) = explode("%", $list);
		$ret = array(
			'uid'=>$uid,
			'mid'=>$mid,
			'crid'=>$crid,	
			'batchid'=>$batchid,
			'totalcount'=>$totalcount,
			'indexcount'=>$indexcount,			
		);
		return $ret;
	}
	
	/**
	 * 测试...
	 */
	public function demo(){
		$ceceive_user = $this->model("Eth")->getUserInfo(array(array("uid"=>10269)));
		$ceceive_user = $ceceive_user[0];
		var_dump($ceceive_user);
	}
	
}
?>
