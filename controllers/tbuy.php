<?php
/**
 * 教师服务产品开通
 */
class TbuyController extends CControl {
	private $_item = array();
	public function __construct(){
		parent::__construct();
		$this->_item = array('itemid'=>1,'name'=>'网校公共课程运营服务','price'=>'3200'); 
	}
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		$redurl = '/';
		if(!empty($user)) {
			if($user['groupid'] != 5){
				header("Location: /");
				exit();
			}
			$this->second();
		} else {//必须先登录才能进行操作
			$url = geturl('login') . '?returnurl=' . $redurl;
            header("Location: $url");
            exit();
		}
    }
	/**
	*开通第二步，登录后的界面处理
	*/
	private function second() {
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($roominfo) || $roominfo === false){
			header("Location: /");
			exit();
		}
		$redeem = intval($this->input->get('redeem'));
		if ($redeem) {
			$this->_redeemPaySecond();
		}
		$this->assign('user', $user);
		$this->assign('item',$this->_item);
		$this->display('common/tbuy_second');
	}
	/**
	 * 兑换码支付
	 * 
	 */
	private function _redeemPaySecond(){
	    $roominfo = Ebh::app()->room->getcurroom();
	    $user = Ebh::app()->user->getloginuser();
	    $redeem = intval($this->input->get('redeem'));
	    $rmodel = $this->model('Redeem');
		$detail = $rmodel->getRedeem($redeem);
		$this->assign('roominfo', $roominfo);
		$this->assign('user', $user);
		$this->assign('detail', $detail);
	    $this->display('common/tbuy_second_redeem');
	    exit;
	}
	/**
	*充值或开通成功后显示页面
	*/
	public function success() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->display('common/tbuy_success');
	}
	/*
	 *支付失败页面
	 */
	public function fail(){
		header("Content-type: text/html; charset=utf-8");
		echo '<span style="font-size:16px;font-weight:bold;color:#f00;">支付失败</span>';
	}
	/**
	*生成订单信息
	*@param $payfrom 来源
	*/
	private function buildOrder($payfrom = 0) {
		$redeem = intval($this->input->post('redeem'));
		if($redeem > 0){
			return $this->buildOrder_redeem($payfrom,$redeem);
		}
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		if(empty($user))
			return FALSE;
		$item = $this->_item;
		$payordermodel = $this->model('Paytorder');
		$orderparam = array();
		$orderparam['ordername'] = '开通 '.$item['name'];
		$orderparam['uid'] = $user['uid'];
		$orderparam['crid'] = $room['crid'];
		$orderparam['dateline'] = SYSTIME;
		$orderparam['ip'] = $this->input->getip();
		$orderparam['payfrom'] = $payfrom;
		$orderparam['totalfee'] = $item['price'];
		$orderparam['remark'] = '开通 '.$item['name'];
		$orderparam['out_trade_no'] = 'torder'.SYSTIME.uniqid();
		$orderid = $payordermodel->addOrder($orderparam);
		if($orderid > 0) {
			$orderparam['orderid'] = $orderid;
			return $orderparam;
		}	
		return $orderparam;
	}

	/**
	 *教师支付兑换码押金订单
	 */
	private function buildOrder_redeem($payfrom,$redeem){
		$rmodel = $this->model('Redeem');
		$item = $rmodel->getRedeem($redeem);
		if(empty($item))
			return false;
		$user = Ebh::app()->user->getloginuser();
		$room = Ebh::app()->room->getcurroom();
		if(empty($user))
			return FALSE;
		$payordermodel = $this->model('Paytorder');
		$orderparam = array();
		$orderparam['ordername'] = $item['name'].'兑换码';
		$orderparam['uid'] = $user['uid'];
		$orderparam['crid'] = $room['crid'];
		$orderparam['dateline'] = SYSTIME;
		$orderparam['redeemcode'] = $item['lotcode'];
		$orderparam['ip'] = $this->input->getip();
		$orderparam['payfrom'] = $payfrom;
		$orderparam['totalfee'] = $item['price']*$item['number'];
		$orderparam['remark'] = $item['foldername'];
		$orderparam['itype'] = 1;//兑换码交易类型
		$orderparam['isbatchrefund'] = 0;
		$orderparam['ptype'] = 1;//兑换码交易类型 0 1支付押金 2 退还押金
		$orderparam['batchid'] = $redeem;//批次id
		$orderparam['out_trade_no'] = 'torder'.SYSTIME.uniqid();
		$orderid = $payordermodel->addOrder($orderparam);
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
		Ebh::app()->getDb()->set_con(0);
		//商户订单号
		$out_trade_no = $param['out_trade_no'];
		//交易号
		$ordernumber = $param['ordernumber'];
		$buyer_id = empty($param['buyer_id'])?'':$param['buyer_id'];
		$buyer_info = empty($param['buyer_info'])?'':$param['buyer_info'];
		$pordermodel = $this->model('Paytorder');
		$myorder = $pordermodel->getOrderByOutTradeNo($out_trade_no);
		if(empty($myorder)) {//订单不存在
			return FALSE;
		}
		if($myorder['status'] == 1) {//订单已处理，则不重复处理
			return $myorder;
		}
		//更新订单状态
		$myorder['status'] = 1;
		$myorder['payip'] = $this->input->getip();
		$myorder['paytime'] = SYSTIME;
		$myorder['ordernumber'] = $ordernumber;
		$myorder['buyer_id'] = $buyer_id;
		$myorder['buyer_info'] = $buyer_info;
		$result = $pordermodel->updateOrder($myorder);
		if(!$result){
			log_message('order update fail info:'.var_export($myorder,true));
		}
		//开通服务
		if ($myorder['itype'] == 0) {
			$serarr['opserviceuid'] = $myorder['uid'];
			$serarr['opservicetime'] = $myorder['paytime'];
			$serarr['service'] = 1;
			$serarr['crid'] = $myorder['crid'];
			$systemModel = $this->model('Systemsetting');
			$systemModel->update($serarr);
		} else {
			$rmodel = $this->model('Redeem');
			$param['status'] = 1;
			$param['lotid'] = $myorder['batchid'];
			$rmodel->updateRedeem($param);
		}
		return $result ? $myorder : array();
	}

	/**
	*选择支付宝充值操作
	*/
	public function alipay() {
		$user = Ebh::app()->user->getloginuser();
		$myorder = $this->buildOrder(1);
		if(empty($myorder)) {
			echo 'error';
			exit();
		}
		$domain = Ebh::app()->getUri()->uri_domain();
		$isthird = FALSE;
		if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
			$isthird = TRUE;
		}
		if($isthird) {
			$notify_url = 'http://'.$this->uri->curdomain.'/tbuy/alinotify.html';
			//页面跳转同步通知页面路径
			$return_url = 'http://'.$this->uri->curdomain.'/tbuy/alireturn.html';
			//商品展示地址
			$show_url = 'http://'.$this->uri->curdomain;

		} else {
			$notify_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/tbuy/alinotify.html';
			//页面跳转同步通知页面路径
			$return_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/tbuy/alireturn.html';
			//商品展示地址
			$show_url = 'http://'.$domain.'.'.$this->uri->curdomain;
		}
        //必填
        //商户订单号
        $out_trade_no = $myorder['out_trade_no'];
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
			exit();
		}
		//商户订单号
		$out_trade_no = $this->input->post('out_trade_no');
		
		//支付宝交易号
		$ordernumber = $this->input->post('trade_no');
		$buyer_id = $this->input->post('buyer_id');
		$buyer_info = $this->input->post('buyer_email');
		$param = array('out_trade_no'=>$out_trade_no,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
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
		$get = $this->input->get();
		$_GET = $get;
		$verify_result = $alilib->checknotify();
		$successurl = geturl('tbuy/success');
		header("Location: $successurl");
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
		if(empty($myorder) && empty($myorder['orderid'])) {	//订单生成失败
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
		$param = array('orderid'=>$myorder['orderid'],'out_trade_no'=>$myorder['out_trade_no'],'ordernumber'=>'','buyer_id'=>$user['uid'],'buyer_info'=>'');

		//来自教师优惠
		$redeem = intval($this->input->post('redeem'));
		if ($redeem) {
			$param['redeem'] = $redeem;
		}

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
		$credit = $this->model('credit');
		$credit->addCreditlog(array('ruleid'=>23,'detail'=>$myorder['itemlist'][0]['oname']));
		echo json_encode($result);
	}

	/**
	*农行支付请求
	*/
	public function abcpay() {
		$user = Ebh::app()->user->getloginuser();
		$param = $this->doAbcRequest(3);
		//生成支付请求对象并提交abc服务器
		$Abcpay = Ebh::app()->lib('Abcpayv2');
		$result = $Abcpay->payTo($param);
	}
	/**
	*农行支付请求
	*/
	public function abcallpay() {
		$user = Ebh::app()->user->getloginuser();
		$param = $this->doAbcRequest(4);
		//生成支付请求对象并提交abc服务器
		$Abcpay = Ebh::app()->lib('Abcpayv2');
		$result = $Abcpay->payTo($param);
	}
	/**
	*处理消费者农行和农行网银支付请求
	*通过前台消费者提交的充值信息，生成农行需要的接口请求
	*@param int $PaymentType （支付类型）3为农行卡 4为银联跨行支付
	*@return array $param 农行 RequestOrder 参数对象
	*/
	private function doAbcRequest($paymentType = 3) {
		$myorder = $this->buildOrder($paymentType);
		if(empty($myorder)) {
			echo 'error';
			exit();
		}
		$pType = $paymentType == 3 ? 1 : 6; 
		
		$domain = Ebh::app()->getUri()->uri_domain();
		$isthird = FALSE;
		if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
			$isthird = TRUE;
		}
		if($isthird) {
			$notify_url = 'http://'.$this->uri->curdomain.'/tbuy/abcnotify.html';
		} else {
			$notify_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/tbuy/abcnotify.html';
		}
		$item = $this->_item; 
		
        //页面跳转同步通知页面路径
     	//$return_url = 'http://'.$domain.'.'.$this->uri->curdomain.'/ibuy/alireturn.html?orderid='.$myorder['orderid'];

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
		$tOrderNo = $myorder['out_trade_no'];
		$tExpiredDate = 10;	//订单过期时间 10天
		$tOrderDesc = $subject;	//产品描述
		$tOrderDate = date('Y/m/d',SYSTIME);	//订单日期 YYYY/MM/DD
		$tOrderTime = date('H:i:s',SYSTIME);		//订单时间 HH:MM:SS
		$tOrderAmountStr = $total_fee;				//支付金额
		$tOrderURL = 'http://'.$domain.'.'.$this->uri->curdomain.'/';			//订单查询地址
		$tBuyIP = $this->input->getip();	//买方ip地址
		
		$tProductType = 1;	//产品类型（必要信息）1：非实体商品 2：实体商品  
		$tPaymentType = $pType;	//支付类型（必要信息）1：农行借记卡支付 3：农行贷记卡支付  6: 银联跨行支付
		$tNotifyType = 1;	//设定支付结果通知方式（必要信息，0：URL 页面通知  1：服务器通知）  
		$tResultNotifyURL = $notify_url;	
														//支付结果地址（必要信息）  
														//注意：  
														//如果支付结果通知方式选择了页面通知，此处填写就是支付结果回传网址；  
														//如果支付结果通知方式选择了服务器通知，此处填写的就是接收支付平台服务器发送响应信息的地址。  
		$tMerchantRemarks = $body;	//商户备注信息 
		$tPaymentLinkType = 1;	//接入方式       （必要信息）1：internet 网络接入 2：手机网络接入 3:数字电视网络接入 4:智能客户端
		
		//付款明细
		$orderitem = array();
		$orderitem['oname'] = $myorder['ordername'];
		$orderitem['itemid'] = $item['itemid'];
		$orderitem['fee'] = $item['price'];
		$orderitems[0] = $orderitem; 
		
		//生成支付请求对象并提交abc服务器
		$param = array('OrderNo'=>$tOrderNo,'ExpiredDate'=>$tExpiredDate,'OrderDesc'=>$tOrderDesc,'OrderDate'=>$tOrderDate,'OrderTime'=>$tOrderTime,'OrderAmountStr'=>$tOrderAmountStr,'OrderURL'=>$tOrderURL,'BuyIP'=>$tBuyIP,'ProductType'=>$tProductType,'PaymentType'=>$tPaymentType,'NotifyType'=>$tNotifyType,'ResultNotifyURL'=>$tResultNotifyURL,'MerchantRemarks'=>$tMerchantRemarks,'PaymentLinkType'=>$tPaymentLinkType,'itemlist'=>$orderitems);
		return $param;
	}
	/**
	*农行支付请求结果响应
	*/
	public function abcnotify() {
		$abclib = Ebh::app()->lib('Abcpayv2');
		$verify_result = $abclib->getnotify();
		$roominfo = Ebh::app()->room->getcurroom();
		$isthird = FALSE;
		if($this->uri->curdomain != 'ebh.net' && $this->uri->curdomain != 'ebanhui.com') {
			$isthird = TRUE;
		}
		if($isthird) {
			$successurl = 'http://'.$this->uri->curdomain.'/tbuy/success.html';	
			$failurl = 'http://'.$this->uri->curdomain.'/tbuy/fail.html';	
		} else {
			$successurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/tbuy/success.html';	
			$failurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/tbuy/fail.html';
		}
		if(empty($verify_result)) {	//支付失败
			$abclib->notify($failurl);
		}
		$out_trade_no = $verify_result['OrderNo'];
		//农行交易号
		$ordernumber = $verify_result['VoucherNo'];
		
		//商户订单号
		$buyer_id = $verify_result['VoucherNo'];	//交易凭证号，用于对账时使用
		$buyer_info = $verify_result['TrnxNo'];		//
		$param = array('out_trade_no'=>$out_trade_no,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
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
		$out_trade_no = $verify_result['out_trade_no'];
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';

		$param = array('out_trade_no'=>$out_trade_no,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
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
		$out_trade_no = $verify_result['out_trade_no'];
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';
		
		$param = array('out_trade_no'=>$out_trade_no,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
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
		$out_trade_no = $verify_result['out_trade_no'];
		//支付宝交易号
		$ordernumber = $verify_result['trade_no'];
		$buyer_id = $verify_result['buyer_id'];
		$buyer_info = $verify_result['buyer_info'];
		
		$param = array('out_trade_no'=>$out_trade_no,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
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
		$out_trade_no = $verify_result['out_trade_no'];
		//支付宝交易号
		$ordernumber = $verify_result['trade_no'];
		$buyer_id = $verify_result['buyer_id'];
		$buyer_info = $verify_result['buyer_info'];
		$param = array('out_trade_no'=>$out_trade_no,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
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
	/***微信扫码支付逻辑开始***/
	//微信扫码订单生成
	public function wxnativepay(){
		$user = Ebh::app()->user->getloginuser();
		$myorder = $this->buildOrder(2);
		if(empty($myorder)) {
			json_encode(array('status'=>-1,'msg'=>'网站订单生成失败！'));
			exit();
		}
		$attach = md5($user['uid'].'_'.$myorder['out_trade_no']);
        //商户订单号
        $out_trade_no = $myorder['out_trade_no'];
        //订单名称
        $subject = $myorder['ordername'];
        $subject = shortstr($subject,80,'');
        //付款金额
		$total_fee = $myorder['totalfee']*100;
        //订单描述
        $body = $myorder['remark'];
        $body = shortstr($body,80,'');
        $notify_url = 'http://www.ebh.net/tbuy/wxnativenotify.html';
		$param = array('out_trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'notify_url'=>$notify_url,'attach'=>$attach);
		$weixinlib = Ebh::app()->lib('WxNativePay');
		$res = $weixinlib->alipayTo($param);
		if(!empty($res)){
			$res['orderid'] = $myorder['orderid'];
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
			$ret['successurl'] = geturl('tbuy/success');
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
		$out_trade_no = $verify_result['out_trade_no'];
		//微信交易号
		$ordernumber = $verify_result['transaction_id'];
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';

		$param = array('out_trade_no'=>$out_trade_no,'ordernumber'=>$ordernumber,'buyer_id'=>$buyer_id,'buyer_info'=>$buyer_info);
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
	//生成优惠码
	private function getcouponcode(){
		$couponcode = $this->generatestr();
		//检测是否重复
		$model = $this->model('Coupons');
		$ck = $model->checkcoupon($couponcode);
		if($ck){
			$couponcode = $this->getcouponcode();
		}
		return $couponcode;
	}
	/**
	 * 生成随机数
	 * @param number $length
	 * @return string
	 */
	protected function generatestr( $length = 6 ){
		// 密码字符集，可任意添加你需要的字符
		$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$password = '';
		for ( $i = 0; $i < $length; $i++ )
		{
			// 这里提供两种字符获取方式
			// 第一种是使用 substr 截取$chars中的任意一位字符；
			// 第二种是取字符数组 $chars 的任意元素
			// $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		return $password;
	}
}