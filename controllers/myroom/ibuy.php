<?php
/**
 * 服务产品开通和充值控制器
 */
class IbuyController extends CControl {
	//构造器 设置数据库主服务器
	public function __construct(){
		parent::__construct();
		Ebh::app()->getDb()->set_con(0);
	}
	/**
	 * [checkWallet 检验我的钱包内的钱 是否大于 需要支付的钱]
	 * @return [type] [description]
	 */
	public function checkWallet(){
		$money = $this->input->post('money');
		$money = floatval($money);
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			echo json_encode(array('status'=>-1,'message'=>'登录信息不存在'));
			exit();
		}
		if($money > $user['balance']){//若钱包中的钱少于扣除的钱
			echo json_encode(array('status'=>-2));
			exit();
		}else{
			echo json_encode(array('status'=>1,'balance'=>$user['balance']));
			exit();
		}
	}

	/**
	 * 使用钱包支付
	 */
	public function rewardByWallet(){
		$user = Ebh::app()->user->getloginuser();
		$totalfee = intval($this->input->post('money'));
		if($user['balance'] < $totalfee) {	//对生成订单前做一次余额是否充足判断
			$result['msg'] = '余额不足';
			echo json_encode($result);
			exit();
		}
		$myorder = $this->buildOrder(8);	//生成订单，8为余额支付
		if(empty($myorder) && empty($myorder['orderid'])) {	//订单生成失败
			$result['msg'] = '订单生成失败';
			echo json_encode($result);
			exit();
		}
		if($user['balance'] < $myorder['totalfee']) {	//生成订单后再做一次余额是否充足判断，避免 post totalfee造假
			echo json_encode(array('status'=>0,'message'=>'造假了'));
			exit();
		}
		//处理权限
		$param = array('orderid'=>$myorder['orderid'],'ordernumber'=>'','buyer_id'=>$user['uid'],'buyer_info'=>'');
		$doresult = $this->notifyOrder($param);
		if(empty($doresult)) {
			echo json_encode(array('status'=>0,'message'=>'开通失败'));
			exit();
		}
		//开通成功，则进行扣费操作
		$ubalance = $user['balance'] - $myorder['totalfee'];
		$usermodel = $this->model('User');
		$uparam = array('balance'=>$ubalance);
		$uresult = $usermodel->update($uparam,$user['uid']);
		$result['status'] = 1;
		$credit = $this->model('credit');
		$credit->addCreditlog(array('ruleid'=>23,'detail'=>$myorder['itemlist'][0]['oname']));
		echo json_encode(array('status'=>1,'message'=>'支付成功！'));
	}
	/**
	 * 支付宝生成订单
	 */
	public function alipayOrder(){
		$post = $this->input->post();
		$myorder = $this->buildOrder(9);
		if(empty($myorder) && empty($myorder['orderid'])) {
			json_encode(array('status'=>-1,'msg'=>'网站订单生成失败！'));
			exit();
		}
		if(!empty($post['money'])){
			$money = floatval($post['money']);
		}
		if(!empty($post['cwid'])){
			$cwid = intval($post['cwid']);
		}
		//检验通过，生成订单
		$param['cwid'] = $cwid;
		$param['totalfee'] = $money;
		$param['dateline'] = SYSTIME;
		$param['ip'] = getip();
		$ordinfo['ordernum'] = $myorder['orderid'];
		$ordinfo['ordername'] = $myorder['ordername'];
		$ordinfo['money'] = $money;
		$ordinfo['status'] = 1;
		if(!empty($ordinfo)){
			echo json_encode($ordinfo);
			exit();
		}
	}
	/**
	 * [alipayQRDate 生成支付宝支付二维码]
	 * @return [type] [description]
	 */
	public function alipayQRDate(){
		$user = Ebh::app()->user->getloginuser();
		$get = $this->input->get();
		if(!empty($get['ordernum'])){
			$ordernum = $get['ordernum'];
		}
		if(!empty($get['ordername'])){
			$ordername = $get['ordername'];
		}
		$cwid = intval($get['cwid']);
		$cw = $this->model('courseware')->getcwpay($cwid);
		$money = floatval($get['money']);
		if(empty($cw))
			return false;

        $width = !empty($get['w'])?$get['w']:0;
		if(!empty($ordernum) && is_numeric($ordernum)){
			$domain = getdomain();
			$notify_url = $domain.'/myroom/ibuy/alipay_notify.html';
			//页面跳转同步通知页面路径
			//$return_url = 'http://www.ebh.net/demo/alipay_return.html';
			$return_url  = "";
			//商品展示地址
			$show_url = "http://www.ebh.net";
			//必填
			//商户订单号
			$out_trade_no = $user['uid'].strval($ordernum);
			//商户网站订单系统中唯一订单号，必填
			//订单名称
			$subject = shortstr($ordername,80,'');			
			//必填
			//付款金额
			$total_fee = $cw['cprice'];
			//订单描述
			$body = $cw['title'].'_'.(empty($cw['cmonth']) ? $cw['cday'].' 天 _':$cw['cmonth'].' 月 _').$cw['cprice'].' 元';
			$param = array('notify_url'=>$notify_url,'return_url'=>$return_url,'trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'show_url'=>$show_url,'width'=>$width);
			//提交支付宝			
			$Alipay = Ebh::app()->lib('Alipay');
			$Alipay->alipayToQR($param);
		}
	}
	/**
	 * 支付状态通知页
	 */
	public function  alipay_notify(){
		$user = Ebh::app()->user->getloginuser();
		$alilib = Ebh::app()->lib('Alipay');
		$verify_result = $alilib->checknotify();
		if(!$verify_result) {	//验证不通过
			echo "fail";
		}
		//商户订单号
		$orderid = $this->input->post('out_trade_no');
		$orderid = substr($orderid, strlen($user['uid']));
		//支付宝交易号
		$ordernumber = $this->input->post('trade_no');
		$buyer_id = $this->input->post('buyer_id');
		$buyer_info = $this->input->post('buyer_email');
		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$alilib->notify(FALSE);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$alilib->notify(TRUE);
			exit();
		}
		$ordernumKey = md5($orderid);
		$redis->set($ordernumKey,1);
		echo 'success';
		log_message("支付宝支付成功:".$orderid);
		$alilib->notify(FALSE);
	}

	/***微信扫码支付逻辑开始***/
	//微信扫码订单生成
	public function wechatOrder(){
		$post = $this->input->post();
		$myorder = $this->buildOrder(9);
		if(empty($myorder) && empty($myorder['orderid'])) {
			json_encode(array('status'=>-1,'msg'=>'网站订单生成失败！'));
			exit();
		}
		if(!empty($post['money'])){
			$money = floatval($post['money']);
		}
		if(!empty($post['cwid'])){
			$cwid = intval($post['cwid']);
		}
		//检验通过，生成订单
		$param['cwid'] = $cwid;
		$param['totalfee'] = $money;
		$param['dateline'] = SYSTIME;
		$param['ip'] = getip();
		$ordinfo['ordernum'] = $myorder['orderid'];
		$ordinfo['ordername'] = $myorder['ordername'];
		$ordinfo['money'] = $money;
		$ordinfo['status'] = 1;
		if(!empty($ordinfo['ordernum'])){
			echo json_encode($ordinfo);
			exit();
		}
	}

	/**
	 * 微信生成二维码
	 */
	public function wxpayQRcode(){
		$get = $this->input->get();
		if(!empty($get['ordernum'])){
			$ordernum = $get['ordernum'];
		}
		if(!empty($get['ordername'])){
			$ordername = $get['ordername'];
		}
		$cwid = intval($get['cwid']);
		if(empty($ordernum) || !is_numeric($ordernum) || !$cwid){
			return false;
		}
		$cw = $this->model('courseware')->getcwpay($cwid);
		if(empty($cw))
			return false;
		$attach = md5($ordernum);
		//商户订单号
		$out_trade_no = strval($ordernum);
		//订单名称
		$subject = shortstr($ordername,80,'');
		//付款金额
		$total_fee = $cw['cprice']*100;
		//订单描述
		$body = $cw['title'].'_'.(empty($cw['cmonth']) ? $cw['cday'].' 天 _':$cw['cmonth'].' 月 _').$cw['cprice'].' 元';
		$domian = getdomain();
		$notify_url = $domian.'/myroom/ibuy/wx_notify.html';
		$param = array('out_trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'notify_url'=>$notify_url,'attach'=>$attach);
		$weixinlib = Ebh::app()->lib('WxNativePay');
		$res = $weixinlib->alipayTo($param);
		if( !empty($res) && ($res['status'] == 0) ){			
			$html_text =
					'<html>
					<head>
					<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
					<meta name="viewport" content="width=device-width, initial-scale=1" />
					<title>微信支付</title>
					</head>
					<body style="margin:0;padding:0;">
					<img alt="微信扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data='.urlencode($res['url']).'" style="width:115px;height:115px;"/>
					</body>
					</html>
							'; 
			echo $html_text;
		}
	}
	/**
	 *微信扫码支付接口通知
	 */
	public function wx_notify(){
		$weixinlib = Ebh::app()->lib('WxNativePay');
		$weixinlib->checknotify($this);
	}
	/**
	 *微信扫码支付接口通知LIB验证时的回调
	 */
	public function _wxnativenotify($verify_result) {
		if(empty($verify_result)) {
			return false;
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		if(!is_numeric($orderid)){
			return true;
		}
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';

		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			return false;
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			//写缓存用于前端验证刷新
			$ordernumKey = md5($param['out_trade_no']);
			$redis->set($ordernumKey,1);
			echo 'SUCCESS';
			log_message("微信支付成功:".$param['out_trade_no']);
			return true;
		}
		return false;
	}

	/**
	* 返回支付状态
	*/
	public function  getpaystatus(){
		$redis = Ebh::app()->getCache("cache_redis");
		$user = Ebh::app()->user->getloginuser();
		$post = $this->input->post();
		if(!empty($post['ordernum'])){
			$ordernum = $post['ordernum'];
			$ordernumKey = md5($ordernum);			
			$ck = $redis->get($ordernumKey);			
			if($ck){
				echo json_encode(array('code'=>1));
				fastcgi_finish_request();
				$redis->remove($ordernumKey);
			}else{
				echo json_encode(array('code'=>0));
			}
		}else{
			echo json_encode(array('code'=>0));
		}
	}
	/**
	*生成订单信息
	*@param $payfrom 来源
	*@param $couponcode 优惠码
	*/
	private function buildOrder($payfrom = 0, $couponcode = '') {
		header('content-type:text/html;charset=utf-8');
		$user = Ebh::app()->user->getloginuser();
		if(empty($user))
			return FALSE;
		$cwid = intval($this->input->post('cwid'));
		if(!empty($cwid)){
			return $this->buildOrder_cw($payfrom,$cwid);
		}
	}
	/**
	*支付成功后的订单处理
	*/
	private function notifyOrder($param) {
		$this->sync_crlist = array();//初始化同步学校列表
		$this->sync_classlist = array();//初始化同步班级列表
		$this->rsync_data = array(); //初始化即将发送给第三方服务器的数据包
		
		//商户订单号
		$orderid = $param['orderid'];
		//交易号
		$ordernumber = $param['ordernumber'];
		$buyer_id = empty($param['buyer_id'])?'':$param['buyer_id'];
		$buyer_info = empty($param['buyer_info'])?'':$param['buyer_info'];
		$pordermodel = $this->model('PayOrder');
		$myorder = $pordermodel->getOrderById($orderid);
		if(empty($myorder)) {//订单不存在
			return FALSE;
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			return $myorder;
		}
		//处理订单详情中的内容
		if(empty($myorder['detaillist'])) {
			return FALSE;
		}
		$providercrids = array();	//订单下内容提供商的crid列表，如果大于1，需要拆分订单
		foreach($myorder['detaillist'] as $detail) {
			$detail['uid'] = $myorder['uid'];
			$this->doOrderItem($detail);
			$detailprovidercrid = $detail['providercrid'];
			if(!isset($providercrids[$detailprovidercrid]))
				$providercrids[$detailprovidercrid] = $detailprovidercrid;
		}
		//更新订单状态
		$myorder['status'] = 1;
		$myorder['payip'] = $this->input->getip();
		$myorder['paytime'] = SYSTIME;
		$myorder['ordernumber'] = $ordernumber;
		$myorder['buyer_id'] = $buyer_id;
		$myorder['buyer_info'] = $buyer_info;
		//拆分订单处理，当订单明细的提供商crid不同时，则将订单改成每个订单明细对应一个订单。
		$providercount = count($providercrids);
		if($providercount > 1) {
			for ($i = 0; $i < count($myorder['detaillist']); $i ++) {
				if($i == 0) {
					$myorder['providercrid'] = $myorder['detaillist'][$i]['providercrid'];
					$myorder['totalfee'] = $myorder['detaillist'][$i]['fee'];
					$myorder['comfee'] = $myorder['detaillist'][$i]['comfee'];
					$myorder['roomfee'] = $myorder['detaillist'][$i]['roomfee'];
					$myorder['providerfee'] = $myorder['detaillist'][$i]['providerfee'];
					$myorder['ordername'] = '开通 '.$myorder['detaillist'][$i]['oname'].' 服务';
					$myorder['remark'] = $myorder['detaillist'][$i]['oname'].'_'.(empty($myorder['detaillist'][$i]['omonth']) ? $myorder['detaillist'][$i]['oday'].' 天 _':$myorder['detaillist'][$i]['omonth'].' 月 _').$myorder['detaillist'][$i]['fee'].' 元';
				} else {
					$neworder = $myorder;
					$neworder['providercrid'] = $myorder['detaillist'][$i]['providercrid'];
					$neworder['totalfee'] = $myorder['detaillist'][$i]['fee'];
					$neworder['comfee'] = $myorder['detaillist'][$i]['comfee'];
					$neworder['roomfee'] = $myorder['detaillist'][$i]['roomfee'];
					$neworder['providerfee'] = $myorder['detaillist'][$i]['providerfee'];
					$neworder['ordername'] = '开通 '.$myorder['detaillist'][$i]['oname'].' 服务';
					$neworder['remark'] = $myorder['detaillist'][$i]['oname'].'_'.(empty($myorder['detaillist'][$i]['omonth']) ? $myorder['detaillist'][$i]['oday'].' 天 _':$myorder['detaillist'][$i]['omonth'].' 月 _').$myorder['detaillist'][$i]['fee'].' 元';
					$neworderid = $pordermodel->addOrder($neworder,TRUE);
					$myorder['detaillist'][$i]['orderid'] = $neworderid;
				}
			}
		}

		$myorder['itemlist'] = $myorder['detaillist'];
		$pordermodel->updateOrder($myorder);

		//更新学校学生缓存和同步SNS数据
		if (!empty($this->sync_crlist))
		{
			foreach ($this->sync_crlist as $crid) {
				//更新学校学生缓存
				Ebh::app()->lib('Sns')->updateRoomUserCache(array('crid'=>$crid,'uid'=>$myorder['uid']));
				//同步SNS数据(网校操作)
				Ebh::app()->lib('Sns')->do_sync($myorder['uid'], 4);
			}
		}
		//更新班级学生缓存
		if (!empty($this->sync_classlist))
		{
			foreach ($this->sync_classlist as $classid)
			{
				//更新班级学生缓存
				Ebh::app()->lib('Sns')->updateClassUserCache(array('classid'=>$classid,'uid'=>$myorder['uid']));
			}
		}

		//通知第三方
		if(!empty($this->rsync_data)){
			foreach ($this->rsync_data as $data) {
				rsapi_call($data['crid'],'folder_buyed',$data);
			}
		}

		return $myorder;
	}
	/**
	*支付成功后处理订单详情（主要为生成权限）
	*/
	private function doOrderItem($orderdetail) {
		$crid = $orderdetail['crid'];
		$folderid = $orderdetail['folderid'];
		$uid = $orderdetail['uid'];
		$omonth= $orderdetail['omonth']; 
		$oday= $orderdetail['oday']; 
		$cwid = empty($orderdetail['cwid'])?0:$orderdetail['cwid'];
		$roommodel = $this->model('Classroom');
		$roominfo = $roommodel->getRoomByCrid($crid);
		if(empty($roominfo))
			return FALSE;
		$usermodel = $this->model('User');
		$user = $usermodel->getuserbyuid($uid);
		if(empty($user))
			return FALSE;
		//获取用户是否在此平台
		$rumodel = $this->model('Roomuser');
		$ruser = $rumodel->getroomuserdetail($crid,$uid);
		$type = 0;
		if(empty($ruser)) {	//不存在 
			$enddate = 0;
			if(!empty($crid)) {
				if(!empty($omonth)) {
					$enddate = strtotime("+$omonth month");
				} else {
					$enddate = strtotime("+$oday day");
				}
			}
			$param = array('crid'=>$crid,'uid'=>$user['uid'],'begindate'=>SYSTIME,'enddate'=>$enddate,'cnname'=>$user['realname'],'sex'=>$user['sex']);
			$result = $rumodel->insert($param);
			$type = 1;

			if($result !== FALSE) {
				if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {	//如果是收费学校，则会将账号默认添加到学校的第一个班级中
					$this->setmyclass($crid,$user['uid'],$folderid);
				} else {
					//更新教室学生数
					$roommodel->addstunum($crid);
				}
				//记录需要更新缓存和SNS同步操作的学校项目
				$this->sync_crlist[] = $crid;
			}
		} else {	//已存在
			if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7){
				$this->setmyclass($roominfo['crid'],$user['uid'],$folderid);//防止中途改变学校类型,导致学生在学校里面但是不在班级里面(网校改成学校) zkq 2014.07.22
			}
			$enddate=$ruser['enddate'];
			$newenddate=0;
			if(!empty($crid)) {
				if(!empty($omonth)) {
					if(SYSTIME>$enddate){//已过期的处理
						$newenddate=strtotime("+$omonth month");
					}else{	//未过期，则直接在结束时间后加上此时间
						$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$omonth month");
					}
				}else {
					if(SYSTIME>$enddate){//已过期的处理
						$newenddate=strtotime("+$oday day");
					}else{	//未过期，则直接在结束时间后加上此时间
						$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$oday day");
					}
				}
			}
			$param = array('crid'=>$crid,'uid'=>$user['uid'],'enddate'=>$newenddate,'cstatus'=>1);
			$result = $rumodel->update($param);
			$type = 2;
		}
		//处理用户权限
		$userpmodel = $this->model('UserPermission');
		if(!empty($orderdetail['cwid'])){//单课收费
			$myperm = $userpmodel->getPermissionByCwId($orderdetail['cwid'],$uid);
		}elseif(empty($orderdetail['folderid'])) {
			$myperm = $userpmodel->getPermissionByItemId($orderdetail['itemid'],$uid);
		} else {
			$myperm = $userpmodel->getPermissionByFolderId($orderdetail['folderid'],$uid,$crid);
		}
		$startdate = 0;
		$enddate = 0;
		if(empty($myperm)) {	//不存在则添加权限，否则更新
			$startdate = SYSTIME;
			if(!empty($omonth)) {
				$enddate = strtotime("+$omonth month");
			} else {
				$enddate = strtotime("+$oday day");
			}
			$ptype = 0;
			if(!empty($folderid) || !empty($crid)) {
				$ptype = 1;
			}
			$perparam = array('itemid'=>$orderdetail['itemid'],'type'=>$ptype,'uid'=>$uid,'crid'=>$crid,'folderid'=>$folderid,'cwid'=>$cwid,'startdate'=>$startdate,'enddate'=>$enddate);
			$result = $userpmodel->addPermission($perparam);
		} else {
			$enddate=$myperm['enddate'];
			$newenddate=0;
			if(!empty($omonth)) {
				if(SYSTIME>$enddate){//已过期的处理
					$newenddate=strtotime("+$omonth month");
				}else{	//未过期，则直接在结束时间后加上此时间
					$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$omonth month");
				}
			}else {
				if(SYSTIME>$enddate){//已过期的处理
					$newenddate=strtotime("+$oday day");
				}else{	//未过期，则直接在结束时间后加上此时间
					$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$oday day");
				}
			}
			$enddate = $newenddate;
			$myperm['enddate'] = $enddate;
			if(!empty($orderdetail['itemid'])) {
				$myperm['itemid'] = $orderdetail['itemid'];
			}
			$result = $userpmodel->updatePermission($myperm);
		}
		$this->rsync_data[] = array('crid'=>$crid,'uid'=>$uid,'fid'=>$folderid);
		//用户平台信息更新成功则生成记录并更新年卡信息
		
		//删除订单收藏
		//$this->model('collect')->del($uid,$crid,$folderid);
		
		return $result;
	}
	
	/*
	单课收费的订单
	*/
	private function buildOrder_cw($payfrom,$cwid){
		$user = Ebh::app()->user->getloginuser();
		$cwdetail = $this->model('courseware')->getcwpay($cwid);
		if(empty($cwdetail))
			return false;
		$payordermodel = $this->model('PayOrder');
		$orderparam = array();
		
		$orderparam['dateline'] = SYSTIME;
		$orderparam['ip'] = $this->input->getip();
		$orderparam['uid'] = $user['uid'];
		$orderparam['payfrom'] = $payfrom;
		$orderparam['couponcode'] = ''; //优惠码
		$ordername = '';	//订单名称
		$remark = '';		//订单备注
		$totalfee = 0;	//订单总额
		$comfee = 0;	//公司分到总额
		$roomfee = 0;	//平台分到总额
		$providerfee = 0;	//内容提供商分到总额
		
		$cw['fee'] = $cwdetail['cprice'];
		$cw['comfee'] = $cwdetail['comfee'];
		$cw['roomfee'] = $cwdetail['roomfee'];
		$cw['oname'] = $cwdetail['title'];
		$cw['omonth'] = $cwdetail['cmonth'];
		$cw['oday'] = $cwdetail['cday'];
		$cw['osummary'] = $cwdetail['summary'];
		$cw['uid'] = $user['uid'];
		$cw['rname'] = $cwdetail['crname'];
		$cw['folderid'] = $cwdetail['folderid'];
		$cw['crid'] = $cwdetail['crid'];
		$cw['cwid'] = $cwdetail['cwid'];
		$cw['domain'] = $cwdetail['domain'];
		$remark = $cw['oname'].'_'.(empty($cw['omonth']) ? $cw['oday'].' 天 _':$cw['omonth'].' 月 _').$cw['fee'].' 元';
		
		$itemlist = array($cw);
		$orderparam['crid'] = $cw['crid'];
		$orderparam['cwid'] = $cw['cwid'];
		// $orderparam['providercrid'] = $itemlist[0]['providercrid'];	//来源平台crid
		// $orderparam['pid'] = $pid;
		$orderparam['itemlist'] = $itemlist;
		$orderparam['totalfee'] = $cw['fee'];	//订单总额
		$orderparam['comfee'] = $cw['comfee'];	//公司分到总额
		$orderparam['roomfee'] = $cw['roomfee'];	//平台分到总额
		// $orderparam['providerfee'] = $providerfee;
		$orderparam['ordername'] = '开通 '.$cw['oname'].' 服务';
		$orderparam['remark'] = $remark;
		
		
		$orderid = $payordermodel->addOrder($orderparam);
		if($orderid > 0) {
			$orderparam['orderid'] = $orderid;
			return $orderparam;
		}	
		return $orderparam;
	}

	/**
	*设置用户的默认班级信息
	* 一般为收费学校用户开通学校服务时候处理，需要将学生加入到默认的班级中
	* 如果不存在新班级，则需要创建一个默认班级
	*/
	private function setmyclass($crid,$uid,$folderid) {
		$classmodel = $this->model('Classes');
		//先判断是否已经加入班级，已经加入则无需重新加入
		$myclass = $classmodel->getClassByUid($crid,$uid);
		if(empty($myclass)) {
			//获取课程对应的年级和地区信息
			$grade = 0;
			$district = 0;
			$folderInfo = $this->model('folder')->getfolderbyid($folderid);
			$classname = "默认班级";
			if(!empty($folderInfo)){
				$grade = $folderInfo['grade'];
				$district = $folderInfo['district'];
				$grademap = Ebh::app()->getConfig()->load('grademap');
				if(array_key_exists($grade, $grademap)){
					$classname = $grademap[$grade].'默认班级';
				}
			}

			$classid = 0;
			$defaultclass = $classmodel->getDefaultClass($crid,$grade,$district);
			if(empty($defaultclass)) {	//不存在默认班级，则创建默认班级
				$param = array('crid'=>$crid,'classname'=>$classname,'grade'=>$grade,'district'=>$district);
				$classid = $classmodel->addclass($param);
			} else {
				$classid = $defaultclass['classid'];
			}
			$param = array('crid'=>$crid,'classid'=>$classid,'uid'=>$uid);
			$classmodel->addclassstudent($param);

			//记录需要更新缓存的班级项目
			$this->sync_classlist[] = $classid;
		}
	}

}