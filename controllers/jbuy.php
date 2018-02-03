<?php
/**
 * 服务产品开通和充值控制器
 */
class JbuyController extends CControl {
	//需要更新缓存和SNS同步操作的学校
	private $sync_crlist = array();
	//需要更新缓存的班级
	private $sync_classlist = array();
	//通知第三方服务器数据包
	private $rsync_data = array();
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		$redurl = $_SERVER['REQUEST_URI'];
		//$redurl = '/ke.html';
		$itemid = $this->input->get('itemid');	//服务项编号
		$sid = $this->input->get('sid');	//服务包分类编号
		if((empty($itemid) || !is_numeric($itemid) || $itemid <= 0) && (empty($sid) || !is_numeric($sid) || $sid <= 0)) {
			header("Location: $redurl");
				exit();
		}
		if(!empty($user)) {
			if($user['groupid'] != 6){
				header("Location: /");
				exit();
			}
			$this->second();
		} else {	//必须先登录才能进行充值等操作
			$url = geturl('login') . '?returnurl=' . $redurl;
            header("Location: $url");
            exit();
		}
		
    }
	/**
	*开通第一步，未登录时需要处理登录信息
	*/
	private function first() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
        $this->assign('user', $user);
		$this->display('common/ibuy');
	}
	/**
	*开通第二步，登录后的界面处理
	*/
	private function second() {
		$itemid = $this->input->get('itemid');
		$param = array();
		if(!empty($itemid)){
			$param['itemid'] = $itemid;
		}
		$user = Ebh::app()->user->getloginuser();
		$pitemmodel = $this->model('PayItem');
		$itemlist = $pitemmodel->getBestItemBySidOrItemid($param);	
		$user = Ebh::app()->user->getloginuser();
		//已开通课程列表
		$mylist = array();
		if(!empty($itemlist)) {
			$crid = 0;
			if(!empty($itemlist[0]['crid']))
				$crid = $itemlist[0]['crid'];
			$userpermodel = $this->model('Userpermission');
			$myperparam = array('uid'=>$user['uid'],'crid'=>$crid,'filterdate'=>1);
			$myfolderlist = $userpermodel->getUserPayFolderList($myperparam);
			foreach($myfolderlist as $myfolder) {
				$mylist[$myfolder['folderid']] = $myfolder;
			}
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('itemid',$itemid);
		$this->assign('itemlist',$itemlist);
		$this->assign('mylist',$mylist);
        $this->assign('user', $user);
        $this->assign('roominfo', $roominfo);
		$this->display('common/jbuy_second');
	}
	/**
	*充值或开通成功后显示页面
	*/
	public function success() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$itemid = intval($this->input->get('itemid'));
		$itemidlist['itemidlist'] = $itemid;
		$itemlist = $this->model('Bestitem')->getItemList($itemidlist);
		$this->assign('itemid',$itemlist);
		$this->display('common/classactive_jsuccess');
	}
	/**
	*生成订单信息
	*@param $payfrom 来源
	*@param $couponcode 优惠码
	*/
	private function buildOrder($payfrom = 0, $couponcode = '') {
		$user = Ebh::app()->user->getloginuser();
		if(empty($user))
			return FALSE;
		$itemidlist = $this->input->post('itemid');
		if(empty($itemidlist))
			return FALSE;
		foreach($itemidlist as $itemid) {	//详情编号必须都为正整数
			if(!is_numeric($itemid) || $itemid <= 0)
				return FALSE;
		}
		//$itemidstr = implode(',',$itemidlist);
		$pitemmodel = $this->model('PayItem');
		//$itemparam = array('itemidlist'=>$itemidstr);
		$itemlist = $pitemmodel->getBestItemList($itemidlist[0]);
		if(empty($itemlist))
			return FALSE;
		$payordermodel = $this->model('PayOrder');
		$orderparam = array();
		
		$orderparam['dateline'] = SYSTIME;
		$orderparam['ip'] = $this->input->getip();
		$orderparam['uid'] = $user['uid'];
		$orderparam['payfrom'] = $payfrom;
		//$orderparam['couponcode'] = !empty($couponcode) ? $couponcode : ''; //优惠码
		$ordername = '';	//订单名称
		$remark = '';		//订单备注
		$totalfee = 0;	//订单总额
		$comfee = 0;	//公司分到总额
		$roomfee = 0;	//平台分到总额
		$providerfee = 0;	//内容提供商分到总额
		for($i = 0; $i < count($itemlist); $i ++) {
			$itemlist[$i]['fee'] = $itemlist[$i]['iprice'];
			$itemlist[$i]['oname'] = $itemlist[$i]['iname'];
			$itemlist[$i]['omonth'] = $itemlist[$i]['imonth'];
			$itemlist[$i]['oday'] = $itemlist[$i]['iday'];
			$itemlist[$i]['osummary'] = $itemlist[$i]['isummary'];
			$itemlist[$i]['uid'] = $user['uid'];
			//$itemlist[$i]['pid'] = $itemlist[$i]['pid'];
			//$pid = $itemlist[$i]['pid'];
			//$itemlist[$i]['rname'] = $itemlist[$i]['crname'];
			//如果该课程参加了优惠并且使用优惠券处理
			if($itemlist[$i]['isyouhui'] && !empty($couponcode)){
				$itemlist[$i]['fee'] = $itemlist[$i]['iprice_yh'];
				$itemlist[$i]['comfee'] = $itemlist[$i]['comfee_yh'] + $itemlist[$i]['roomfee_yh'];
				$itemlist[$i]['roomfee'] = 0;
				$itemlist[$i]['providerfee'] = $itemlist[$i]['providerfee_yh'];
				$totalfee += $itemlist[$i]['iprice_yh'];
			}else{
				$itemlist[$i]['comfee'] = $itemlist[$i]['comfee'] + $itemlist[$i]['roomfee'];
				$itemlist[$i]['roomfee'] = 0;
				$itemlist[$i]['providerfee'] = $itemlist[$i]['providerfee'];
				$totalfee += $itemlist[$i]['iprice'];
			}
			$comfee += $itemlist[$i]['comfee'] + $itemlist[$i]['roomfee'];
			//$roomfee += $itemlist[$i]['roomfee'];
			$roomfee = 0;
			$providerfee += $itemlist[$i]['providerfee'];
			if(empty($ordername)) 
				$ordername = $itemlist[$i]['oname'];
			else
				$ordername .= ','.$itemlist[$i]['oname'];
			$theremark = $itemlist[$i]['iname'].'_'.(empty($itemlist[$i]['omonth']) ? $itemlist[$i]['oday'].' 天 _':$itemlist[$i]['omonth'].' 月 _').$itemlist[$i]['fee'].' 元';
			if(empty($remark)) {
				$remark = $theremark;
			} else {
				$remark .= '/'.$theremark;
			}
			$providercrid = $itemlist[$i]['providercrid'];
		}
		//$orderparam['crid'] = $itemlist[0]['crid'];
		$orderparam['crid'] = 0;
		$orderparam['providercrid'] = $itemlist[0]['providercrid'];	//来源平台crid
		//$orderparam['pid'] = $pid;
		$orderparam['itemlist'] = $itemlist;
		$orderparam['totalfee'] = $totalfee;
		$orderparam['comfee'] = $comfee;
		$orderparam['roomfee'] = $roomfee;
		$orderparam['providerfee'] = $providerfee;
		$orderparam['ordername'] = '开通 '.$ordername.' 服务';
		$orderparam['remark'] = $remark;
		$orderid = $payordermodel->addOrder($orderparam);
		$orderparam['crid'] = $itemlist[0]['providercrid'];
		if($orderid > 0) {
			$orderparam['orderid'] = $orderid;
			return $orderparam;
		}	
		return $orderparam;
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
		$myorder['detaillist'][0]['crid'] = $myorder['providercrid'];
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
		Ebh::app()->getDb()->set_con(0);
		$providercrids = array();	//订单下内容提供商的crid列表，如果大于1，需要拆分订单
		foreach($myorder['detaillist'] as $detail) {
			$detail['uid'] = $myorder['uid'];
			$this->doOrderItem($detail);
			$detailprovidercrid = $detail['providercrid'];
			if(!isset($providercrids[$detailprovidercrid]))
				$providercrids[$detailprovidercrid] = $detailprovidercrid;
		}
		$myorder['detaillist']['crid'] = 0;
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
					$myorder['comfee'] = $myorder['detaillist'][$i]['comfee'] + $myorder['roomfee'];
					$myorder['roomfee'] = 0;
					$myorder['providerfee'] = $myorder['detaillist'][$i]['providerfee'];
					$myorder['ordername'] = '开通 '.$myorder['detaillist'][$i]['oname'].' 服务';
					$myorder['remark'] = $myorder['detaillist'][$i]['oname'].'_'.(empty($myorder['detaillist'][$i]['omonth']) ? $myorder['detaillist'][$i]['oday'].' 天 _':$myorder['detaillist'][$i]['omonth'].' 月 _').$myorder['detaillist'][$i]['fee'].' 元';
				} else {
					$neworder = $myorder;
					$neworder['providercrid'] = $myorder['detaillist'][$i]['providercrid'];
					$neworder['totalfee'] = $myorder['detaillist'][$i]['fee'];
					$neworder['comfee'] = $myorder['detaillist'][$i]['comfee'] + $myorder['detaillist'][$i]['roomfee'];
					$neworder['roomfee'] = 0;
					$neworder['providerfee'] = $myorder['detaillist'][$i]['providerfee'];
					$neworder['ordername'] = '开通 '.$myorder['detaillist'][$i]['oname'].' 服务';
					$neworder['remark'] = $myorder['detaillist'][$i]['oname'].'_'.(empty($myorder['detaillist'][$i]['omonth']) ? $myorder['detaillist'][$i]['oday'].' 天 _':$myorder['detaillist'][$i]['omonth'].' 月 _').$myorder['detaillist'][$i]['fee'].' 元';
					$neworderid = $pordermodel->addOrder($neworder,TRUE);
					$myorder['detaillist'][$i]['orderid'] = $neworderid;
				}
			}
		}
		$myorder['itemlist'][0] = $myorder['detaillist'][0];
		$pordermodel->updateOrder($myorder);
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
		$roommodel = $this->model('Classroom');
		$roominfo = $roommodel->getRoomByCrid($crid);
		if(empty($roominfo))
			return FALSE;
		$usermodel = $this->model('User');
		$user = $usermodel->getuserbyuid($uid);
		if(empty($user))
			return FALSE;
		//处理用户权限
		$userpmodel = $this->model('UserPermission');
		if(empty($orderdetail['folderid'])) {
			$myperm = $userpmodel->getPermissionByItemId($orderdetail['itemid'],$uid);
		} else {
			$myperm = $userpmodel->getPermissionByFolderId($orderdetail['folderid'],$uid);
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
			$perparam = array('itemid'=>$orderdetail['itemid'],'type'=>$ptype,'uid'=>$uid,'crid'=>$crid,'folderid'=>$folderid,'startdate'=>$startdate,'enddate'=>$enddate);
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
		return $result;
	}
	/**
	*选择支付宝充值操作
	*/
	public function alipay() {
		$user = Ebh::app()->user->getloginuser();
		//优惠券处理
		$isusecoupon = intval($this->input->post('isusecoupon'));
		$couponcode = trim($this->input->post('couponcode'));
		//是否使用优惠券
		$iscoupon = false;
		if($isusecoupon){
			$couponModel = $this->model('Coupons');
			$coupon = $couponModel->getOne(array('code'=>$couponcode));
			if(!empty($coupon) && ($coupon['uid'] != $user['uid'])){
				$iscoupon = true;
			}
		}
		$couponcode = $iscoupon ? $couponcode : '';
		$myorder = $this->buildOrder(3,$couponcode);
		if(empty($myorder)) {
			echo 'error';
			exit();
		}
		$uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
		$isthird = FALSE;
		if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
			$isthird = TRUE;
		}
		if($isthird) {
			$notify_url = 'http://'.$this->uri->curdomain.'/jbuy/alinotify.html?orderid='.$myorder['orderid'];
			//页面跳转同步通知页面路径
			$return_url = 'http://'.$this->uri->curdomain.'/jbuy/alireturn.html?orderid='.$myorder['orderid'];
			//商品展示地址
			$show_url = 'http://'.$this->uri->curdomain;

		} else {
			$notify_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/jbuy/alinotify.html?orderid='.$myorder['orderid'];
			//页面跳转同步通知页面路径
			$return_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/jbuy/alireturn.html?orderid='.$myorder['orderid'];
			//商品展示地址
			$show_url = 'http://'.$domain.'.'.$this->uri->curdomain;
		}
        //必填
        //商户订单号
        $out_trade_no = $myorder['orderid'];
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = $myorder['ordername'];
		$total_fee = $myorder['totalfee'];
        //必填
        //付款金额
        
        //必填
        //订单描述
        $body = $myorder['remark'];
        
		$alilib = Ebh::app()->lib('Alipay');
		$param = array('notify_url'=>$notify_url,'return_url'=>$return_url,'trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'show_url'=>$show_url);
		//提交支付宝
		$alilib->alipayTo($param);

	}
	/**
	*alipay支付接口通知
	*/
	public function alinotify() {
		$get = $this->input->get();
		$alilib = Ebh::app()->lib('Alipay');
		$verify_result = $alilib->checknotify();
		if(!$verify_result) {	//验证不通过
			echo "fail";
		}
		//商户订单号
		$orderid = $this->input->post('out_trade_no');
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
		$alilib->notify(FALSE);
	}
	/**
	*成功返回页面
	*/
	public function alireturn() {
		$alilib = Ebh::app()->lib('Alipay');
		$orderid = intval($this->input->get('orderid'));
		$ord = $this->model('PayOrder')->getOrderById($orderid);
		$verify_result = $alilib->checknotify();
		$successurl = geturl('jbuy/success').'?itemid='.$ord['detaillist'][0]['itemid'];
		header("Location: $successurl");
	}

	/**
	*农行支付请求
	*/
	public function abcpay() {
		$user = Ebh::app()->user->getloginuser();
		$param = $this->doAbcRequest(1);
		//生成支付请求对象并提交abc服务器
		$Abcpay = Ebh::app()->lib('Abcpayv2');
		$result = $Abcpay->payTo($param);
	}
	/**
	*农行支付请求
	*/
	public function abcallpay() {
		$user = Ebh::app()->user->getloginuser();
		//优惠券处理
		$isusecoupon = intval($this->input->post('isusecoupon'));
		$couponcode = trim($this->input->post('couponcode'));
		//是否使用优惠券
		$iscoupon = false;
		if($isusecoupon){
			$couponModel = $this->model('Coupons');
			$coupon = $couponModel->getOne(array('code'=>$couponcode));
			if(!empty($coupon) && $coupon['uid'] != $user['uid']){
				$iscoupon = true;
			}
		}
		$couponcode = $iscoupon ? $couponcode : '';
		$payparam = array();
		$param = $this->doAbcRequest(6,$couponcode);
		//生成支付请求对象并提交abc服务器
		$Abcpay = Ebh::app()->lib('Abcpayv2');
		$result = $Abcpay->payTo($param);
	}
	/**
	*处理消费者农行和农行网银支付请求
	*通过前台消费者提交的充值信息，生成农行需要的接口请求
	*@param int $PaymentType （支付类型）1为农行卡 6为银联跨行支付
	*@param string $couponcode ($couponcode为空则不生效)
	*@return array $param 农行 RequestOrder 参数对象
	*/
	private function doAbcRequest($paymentType = 1,$couponcode = '') {
		$payfrom = 6;	//农行直接支付
		if($paymentType == 6)
			$payfrom = 7;	//农行银联支付
		$myorder = $this->buildOrder($payfrom);
		 if(empty($myorder)) {
		 	echo 'error';
		 	exit();
		 }
		$uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
		$isthird = FALSE;
		if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
			$isthird = TRUE;
		}
		if($isthird) {
			$notify_url = 'http://'.$this->uri->curdomain.'/jbuy/abcnotify.html?orderid='.$myorder['orderid'];
		} else {
			$notify_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/jbuy/abcnotify.html?orderid='.$myorder['orderid'];
		}
        //页面跳转同步通知页面路径
     //   $return_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/ibuy/alireturn.html?orderid='.$myorder['orderid'];

        //必填
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = $myorder['ordername'];
		$total_fee = $myorder['totalfee'];
        //必填
        //付款金额
        
        //必填
        //订单描述
        $body = $myorder['remark'];
		
		//1、取得支付请求所需要的信息
		$tOrderNo = $myorder['orderid'];
		$tExpiredDate = 10;	//订单过期时间 10天
		$tOrderDesc = $subject;	//产品描述
		$tOrderDate = date('Y/m/d',SYSTIME);	//订单日期 YYYY/MM/DD
		$tOrderTime = date('H:i:s',SYSTIME);		//订单时间 HH:MM:SS
		$tOrderAmountStr = $total_fee;				//支付金额
		$tOrderURL = 'http://'.$domain.'.'.$this->uri->curdomain.'/';			//订单查询地址
		$tBuyIP = $this->input->getip();	//买方ip地址
		
		$tProductType = 1;	//产品类型（必要信息）1：非实体商品 2：实体商品  
		$tPaymentType = $paymentType;	//支付类型（必要信息）1：农行借记卡支付 3：农行贷记卡支付  6: 银联跨行支付
		$tNotifyType = 1;	//设定支付结果通知方式（必要信息，0：URL 页面通知  1：服务器通知）  
		$tResultNotifyURL = $notify_url;	
														//支付结果地址（必要信息）  
														//注意：  
														//如果支付结果通知方式选择了页面通知，此处填写就是支付结果回传网址；  
														//如果支付结果通知方式选择了服务器通知，此处填写的就是接收支付平台服务器发送响应信息的地址。  
		$tMerchantRemarks = $body;	//商户备注信息 
		$tPaymentLinkType = 1;	//接入方式       （必要信息）1：internet 网络接入 2：手机网络接入 3:数字电视网络接入 4:智能客户端   
		//生成支付请求对象并提交abc服务器
		$param = array('OrderNo'=>$tOrderNo,'ExpiredDate'=>$tExpiredDate,'OrderDesc'=>$tOrderDesc,'OrderDate'=>$tOrderDate,'OrderTime'=>$tOrderTime,'OrderAmountStr'=>$tOrderAmountStr,'OrderURL'=>$tOrderURL,'BuyIP'=>$tBuyIP,'ProductType'=>$tProductType,'PaymentType'=>$tPaymentType,'NotifyType'=>$tNotifyType,'ResultNotifyURL'=>$tResultNotifyURL,'MerchantRemarks'=>$tMerchantRemarks,'PaymentLinkType'=>$tPaymentLinkType,'itemlist'=>$myorder['itemlist']);
		return $param;
	}
	/**
	*农行支付请求结果响应
	*/
	public function abcnotify() {
		$abclib = Ebh::app()->lib('Abcpayv2');
		$verify_result = $abclib->getnotify();
		//$roominfo = Ebh::app()->room->getcurroom();
		$isthird = FALSE;
		if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
			$isthird = TRUE;
		}
		$ord = $this->model('PayOrder')->getOrderById($verify_result['OrderNo']);
		$uri = Ebh::app()->getUri();
        $domain = $uri->uri_domain();
		if($isthird) {
			$successurl = 'http://'.$this->uri->curdomain.'/jbuy/success.html?itemid='.$ord['detaillist'][0]['itemid'];	
			$failurl = 'http://'.$this->uri->curdomain.'/jbuy/fail.html';	
		} else {
			$successurl = 'http://'.$domain.'.'.$this->uri->curdomain.'/jbuy/success.html?itemid'.$ord['detaillist'][0]['itemid'];	
			$failurl = 'http://'.$domiain.'.'.$this->uri->curdomain.'/jbuy/fail.html';
		}
		if(empty($verify_result)) {	//支付失败
			$abclib->notify($failurl);
		}
		$orderid = $verify_result['OrderNo'];
		//农行交易号
		$ordernumber = $verify_result['VoucherNo'];

		//商户订单号
		$buyer_id = $verify_result['VoucherNo'];	//交易凭证号，用于对账时使用
		$buyer_info = $verify_result['TrnxNo'];		//
		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$abclib->notify($failurl);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$abclib->notify($successurl);
			exit();
		}
		$abclib->notify($failurl);
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
	public function bank() {
		$room = Ebh::app()->room->getcurroom();
		$this->assign('room',$room);
		$this->display('common/classactive_bank');
	}
	/**
	*通过账户余额支付
	*/
	public function bpay() {
		$result = array('status'=>0);
		$user = Ebh::app()->user->getloginuser();
		$totalfee = intval($this->input->post('totalfee'));
		if($user['balance'] < $totalfee) {	//对生成订单前做一次余额是否充足判断
			$result['msg'] = '余额不足';
			echo json_encode($result);
			exit();
		}
		$myorder = $this->buildOrder(8);	//生成订单，8为余额支付
		if(empty($myorder)) {	//订单生成失败
			$result['msg'] = '订单生成失败';
			echo json_encode($result);
			exit();
		}
		if($user['balance'] < $myorder['totalfee']) {	//生成订单后再做一次余额是否充足判断，避免 post totalfee造假
			$result['msg'] = '余额不足';
			echo json_encode($result);
			exit();
		}
		//处理权限
		$param = array('orderid'=>$myorder['orderid'],'ordernumber'=>'','buyer_id'=>$user['uid'],'buyer_info'=>'');
		$doresult = $this->notifyOrder($param);
		if(empty($doresult)) {
			$result['msg'] = '开通失败';
			echo json_encode($result);
			exit();
		}
		//开通成功，则进行扣费操作
		$ubalance = $user['balance'] - $myorder['totalfee'];
		$usermodel = $this->model('User');
		$uparam = array('balance'=>$ubalance);
		$uresult = $usermodel->update($uparam,$user['uid']);
		$result['status'] = 1;
		$result['itemid'] = $myorder['itemlist'][0]['itemid'];
		$credit = $this->model('credit');
		$credit->addCreditlog(array('ruleid'=>23,'detail'=>$myorder['itemlist'][0]['oname']));
		echo json_encode($result);
	}
	/**
	*微信接口通知
	*/
	public function weixinnotify() {
		$weixinlib = Ebh::app()->lib('Weixinpay');
		$verify_result = $weixinlib->checknotify();
		if(empty($verify_result)) {	//验证不通过
			$weixinlib->notify(FALSE);
			exit();
		}
		if($verify_result['result_code'] == 'FAIL'){//支付失败啦,这里可以做删除订单处理
			$weixinlib->notify(TRUE);
			exit();
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';

		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$weixinlib->notify(FALSE);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$weixinlib->notify(TRUE);
			exit();
		}
		$weixinlib->notify(FALSE);
	}

	/**
	*微信公众账号支付接口通知
	*/
	public function wxpublicnotify() {
		$weixinlib = Ebh::app()->lib('WxPublicPay');
		$verify_result = $weixinlib->checknotify();
		if(empty($verify_result)) {	//验证不通过
			$weixinlib->notify(FALSE);
			exit();
		}
		if($verify_result['result_code'] == 'FAIL'){//支付失败啦,这里可以做删除订单处理
			$weixinlib->notify(TRUE);
			exit();
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		if(!is_numeric($orderid)){
			$weixinlib->notify(TRUE);//如果orderid不是数字则表示是之前的测试订单过来的回调，直接忽视
			exit;
		}
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';

		$param = array('orderid'=>$orderid,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
		$myorder = $this->notifyOrder($param);
		if(empty($myorder)) {//订单不存在
			$weixinlib->notify(FALSE);
			exit();
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			$weixinlib->notify(TRUE);
			exit();
		}
		$weixinlib->notify(FALSE);
	}


	/**
	*alipaywap支付接口通知
	*/
	public function aliwapnotify() {
		$get = $this->input->get();
		$alilib = Ebh::app()->lib('Alipaywap');
		$verify_result = $alilib->checknotify();
		if(!$verify_result) {	//验证不通过
			$alilib->notify(FALSE);exit;
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		//支付宝交易号
		$ordernumber = $verify_result['trade_no'];
		$buyer_id = $verify_result['buyer_id'];
		$buyer_info = $verify_result['buyer_info'];

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
		$alilib->notify(FALSE);
	}

	/**
	*成功返回页面
	*/
	public function aliwapreturn() {
		$alilib = Ebh::app()->lib('Alipaywap');
		$get = $this->input->get();
		$_GET = $get;
		$verify_result = $alilib->checknotify();
		header("Location: http://wap.ebh.net");
	}

	/**
	*alipayApp支付接口通知
	*/
	public function aliappnotify() {
		$alilib = Ebh::app()->lib('AlipayForApp');
		$verify_result = $alilib->checknotify();
		if(!$verify_result) {	//验证不通过
			$alilib->notify(FALSE);exit;
		}
		//商户订单号
		$orderid = $verify_result['out_trade_no'];
		//支付宝交易号
		$ordernumber = $verify_result['trade_no'];
		$buyer_id = $verify_result['buyer_id'];
		$buyer_info = $verify_result['buyer_info'];

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
		$alilib->notify(FALSE);
	}

	/**
	*通过激活卡支付
	*/
	public function scardpay() {
		$result = array('status'=>0);
		$itemidlist = $this->input->post('itemid');
		if(empty($itemidlist) || count($itemidlist)!=1){
			$result['msg'] = '单张激活卡只能开通一门课程';
			echo json_encode($result);
			exit;
		}
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($user)){
			$result['msg'] = '用户未登录';
			echo json_encode($result);
			exit;
		}
		if($user['groupid'] == 5){
			$result['msg'] = '教师账号不能开通';
			echo json_encode($result);
			exit;
		}
		if(empty($roominfo)){
			$result['msg'] = '当前学校信息无法获取';
			echo json_encode($result);
			exit;
		}
		//获取学校卡号
		$yearcardmodel = $this->model('yearcard');
		$cardnumber = $this->input->post('cardnumber');
		if(empty($cardnumber)){
			$result['msg'] = '激活码不能为空';
			echo json_encode($result);
			exit;
		}
		$cardnumber = strtoupper($cardnumber);
		$cardinfo = $yearcardmodel->getYearcardByCardnumber($cardnumber,$roominfo['crid']);
		if( empty($cardinfo) ){
			$result['msg'] = '激活码不正确，开通失败';
			echo json_encode($result);
			exit;
		}else if( $cardinfo['status'] == 1 ){
			$result['msg'] = '激活码已被使用，开通失败';
			echo json_encode($result);
			exit;
		}

		$myorder = $this->buildOrder(1);	//生成订单，激活卡当做年卡使
		
		if(empty($myorder)) {	//订单生成失败
			$result['msg'] = '订单生成失败';
			echo json_encode($result);
			exit();
		}
		$cardpass = $cardinfo['cardpass'];
		$myorder['ordernumber'] = $cardpass;
		//处理权限
		$doresult = $this->notifyOrder($myorder);
		if(empty($doresult)) {
			$result['msg'] = '开通失败';
			echo json_encode($result);
			exit();
		}
		//开通成功，则进行销卡操作
		$uparam = array(
			'cardid'=>$cardinfo['cardid'],
			'status'=>1,
			'activedate'=>SYSTIME
		);
		$uresult = $yearcardmodel->update($uparam);
		$result['status'] = 1;
		$credit = $this->model('credit');
		$credit->addCreditlog(array('ruleid'=>23,'detail'=>$myorder['itemlist'][0]['oname']));
		echo json_encode($result);
	}

	/***微信扫码支付逻辑开始***/
	//微信扫码订单生成
	public function wxnativepay(){
		$user = Ebh::app()->user->getloginuser();
		//优惠券处理
		$isusecoupon = intval($this->input->post('isusecoupon'));
		$couponcode = trim($this->input->post('couponcode'));
		//是否使用优惠券
		$iscoupon = false;
		if($isusecoupon){
			$couponModel = $this->model('Coupons');
			$coupon = $couponModel->getOne(array('code'=>$couponcode));
			if(!empty($coupon) && $coupon['uid'] != $user['uid']){
				$iscoupon = true;
			}
		}
		$couponcode = $iscoupon ? $couponcode : '';
		$myorder = $this->buildOrder(9,$couponcode);
		if(empty($myorder)) {
			json_encode(array('status'=>-1,'msg'=>'网站订单生成失败！'));
			exit();
		}
		$attach = md5($user['uid'].'_'.$myorder['orderid']);
        //商户订单号
        $out_trade_no = $myorder['orderid'];
        //订单名称
        $subject = $myorder['ordername'];
        $subject = shortstr($subject,80,'');
        //付款金额
		$total_fee = $myorder['totalfee']*100;
        //订单描述
        $body = $myorder['remark'];
        $body = shortstr($body,80,'');
        $notify_url = 'http://www.ebh.net/jbuy/wxnativenotify.html';
		$param = array('out_trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'notify_url'=>$notify_url,'attach'=>$attach);
		$weixinlib = Ebh::app()->lib('WxNativePay');
		$res = $weixinlib->alipayTo($param);
		if(!empty($res)){
			$res['orderid'] = $out_trade_no;
			$res['cachekey'] = $attach;
		}else{
			$res['orderid'] = 0;
			$res['cachekey'] = '';
		}
		if( !empty($res) && ($res['status'] == 0) ){
			$ret['status'] = 0;
			$ret['msg'] = '请求成功';
			$ret['url'] = 'http://paysdk.weixin.qq.com/example/qrcode.php?data='.$res['url'];
			$ret['cachekey'] = $res['cachekey'];
			$ret['successurl'] = geturl('jbuy/success').'?itemid='.$myorder['itemlist'][0]['itemid'];
		}
		echo json_encode($ret);
	}
	/**
	*微信扫码支付接口通知
	*/
	public function wxnativenotify(){
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
			$attach = $verify_result['attach'];
			$this->cache->set($attach,1,60);//支付成功标志
			return true;
		}
		return false;
	}

	//客户端校验支付结果(扫码)
	public function checkweixinbuy(){
		$cachekey = $this->input->post('cachekey');
		$ret = array('status'=>1,'msg'=>'还没有支付');
		if(empty($cachekey)){
			echo json_encode($ret);
			exit();
		}
		$res = $this->cache->get($cachekey);//支付成功标志
		if(!empty($res)){
			$ret['status'] = 0;
			$ret['msg'] = '支付成功';
			$ret['method'] = 'tvpayover';
		}
		echo json_encode($ret);
	}
	/***微信扫码支付逻辑结束***/
}
?>
