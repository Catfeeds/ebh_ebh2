<?php
/**
 * 打赏控制器
 */
class RewardsController extends CControl {
	//构造器 设置数据库主服务器
	public function __construct(){
		parent::__construct();
		Ebh::app()->getDb()->set_con(0);
		$type = intval($this->input->post('type'));
		$this->type = empty($type)? 1: $type;
	}
	/**
	 * [checkWallet 检验我的钱包内的钱 是否大于 需要支付的钱]
	 * @return [type] [description]
	 */
	public function checkWallet(){
		$money = $this->input->post('money');
		$money = floatval($money);
		//检验金额
		$this->_checkReward($money);
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
		$post = $this->input->post();
		if(!empty($post['money'])){
			$money = floatval($post['money']);
		}
		if(!empty($post['cwid'])){
			$cwid = intval($post['cwid']);
		}
		//检验金额
		$this->_checkReward($money);
		//检验通过，生成订单
		$param['cwid'] = $cwid;
		$param['totalfee'] = $money;
		$param['dateline'] = SYSTIME;
		$param['ip'] = getip();
		$ordernum = $this->_bulidRewardsOrder($param);
		//检验余额是否满足
		$user = Ebh::app()->user->getloginuser();
		if($user['balance'] < $money){
			echo json_encode(array('status'=>-1,'message'=>'余额不足！'));
			exit();
		}
		if(empty($cwid)){
			echo json_encode(array('status'=>-1,'message'=>'参数错误！'));
			exit();
		}
		$cwModel = $this->model('Courseware');

		if ($this->type == 3) {//打赏类型，问题打赏
			$cwinfo = $this->model('Askquestion')->getAnswererByAid($cwid);
		} else {
			$cwinfo = $cwModel->getSimplecourseByCwid($cwid);
		}
		//进行扣款和余额加入被打赏者的钱包
		$rwModel = $this->model('Reward');
		$res = $rwModel->exchageBlance($user['uid'],$cwinfo['uid'],$money);
		if($res){//转账成功
			$updatearr = array();
			$updatearr['paytime'] = SYSTIME;
			$updatearr['payfrom'] = 8;//余额支付
			$updatearr['payip'] = getip();
			$updatearr['status'] = 1;//支付成功
			$upres = $rwModel->updateOrder($updatearr,$ordernum,false);
			if($upres){
				echo json_encode(array('status'=>1,'message'=>'支付成功！'));
				exit(); 
			}else{
				$failarr = array();
				$failarr['invalid'] = 1;//标记订单更新失败
				$rwModel->setInvalid($failarr,$ordernum);
				echo json_encode(array('status'=>-1,'message'=>'账单更新失败！请联系管理员！'));
				exit();
			}
		}else{//失败
			echo json_encode(array('status'=>-1,'message'=>'打赏失败，请重试！'));
			exit();
		}
	}
	/**
	 * 检验打赏数额
	 */
	private function _checkReward($money){
		if(empty($money)){
			echo json_encode(array('status'=>-1,'message'=>'支付的数额不能为空'));
			exit();
		}
		if($money < 0 ){
			echo json_encode(array('status'=>-1,'message'=>'支付的数额不能为负数'));
			exit();
		}
		if(!is_numeric($money)){
			echo json_encode(array('status'=>-1,'message'=>'支付的数额必须为数字'));
			exit();
		}
		//检验钱的数额最多只能有一个小数点
		if(substr_count($money,'.') >=2){
			echo json_encode(array('status'=>-1,'message'=>'支付数额不规范'));
			exit();
		}
		if (!preg_match('/^[0-9]+(.[0-9]{1,2})?$/',$money)) {  
		    echo json_encode(array('status'=>-1,'message'=>'支付的数额只能为两位小数'));
			exit(); 
		}
	}

	/**
	 * 生成打赏订单
	 */
	private function _bulidRewardsOrder($param , $isorderno = false){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($user)){
			echo json_encode(array('status'=>-1,'message'=>'登录信息不存在'));
			exit();
		}
		if(empty($roominfo)){
			echo json_encode(array('status'=>-1,'message'=>'登录网校信息不存在'));
			exit();
		}
		if(empty($param['cwid'])){
			echo json_encode(array('status'=>-1,'message'=>'打赏课件id不存在'));
			exit();
		}
		$cwModel = $this->model('Courseware');
		if ($this->type == 3) {
			$joinQue = 1;
			$cwinfo = $this->model('Askquestion')->getAnswererByAid($param['cwid'],$joinQue);
			$cwinfo['title'] = ' '.shortstr($cwinfo['title'],80).',';
		} else {
			$cwinfo = $cwModel->getSimplecourseByCwid($param['cwid']);
		}
		$param['type'] = $this->type;//课件打赏
		$param['uid'] = $user['uid'];
		$param['touid'] = $cwinfo['uid'];
		$param['toid'] = $param['cwid'];
		$param['crid'] = $roominfo['crid'];
		$param['ordername'] = $user['username'] . ' 打赏 ' . $cwinfo['title'] . ' ' . $param['totalfee'] . '元';
		$param['ordernumber'] = $this->_build_order_no();//生成订单号
		$rwModel = $this->model('Reward');
		$rwid = $rwModel->insert($param);
		if($isorderno){
			return array('ordernum'=>$param['ordernumber'],'rwid'=>$rwid,'ordername'=>$param['ordername']);
		}else{
			return $param['ordernumber'];
		}
		
	}

	/**
	 * 得到新订单号
	 * @return  string
	 */
	private function _build_order_no(){
	    list($usec, $sec) = explode(" ", microtime());
        $usec = substr(str_replace('0.', '', $usec), 0 ,4);
        $str  = rand(10,99);
        $ordernum = date("YmdHis").$usec.$str;
        $rwModel = $this->model('Reward');
        $check = $rwModel->checkOrdernum($ordernum);
        if(empty($check)){
        	return $ordernum;
        }else{
        	$this->_build_order_no();
        }
        
	}

	/**
	 * 支付宝生成订单
	 */
	public function alipayOrder(){
		$post = $this->input->post();
		if(!empty($post['money'])){
			$money = floatval($post['money']);
		}
		if(!empty($post['cwid'])){
			$cwid = intval($post['cwid']);
		}
		//检验金额
		$this->_checkReward($money);
		//检验通过，生成订单
		$param['cwid'] = $cwid;
		$param['totalfee'] = $money;
		$param['dateline'] = SYSTIME;
		$param['ip'] = getip();
		$ordinfo = $this->_bulidRewardsOrder($param,true);
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
		$get = $this->input->get();
		if(!empty($get['ordernum'])){
			$ordernum = $get['ordernum'];
		}
		if(!empty($get['ordername'])){
			$ordername = $get['ordername'];
		}
		if(!empty($get['money'])){
			$money = floatval($get['money']);
		}

        $width = !empty($get['w'])?$get['w']:0;
		$this->_checkReward($money);
		if(!empty($ordernum) && is_numeric($ordernum)){
			$domain = getdomain();
			$notify_url = $domain.'/myroom/rewards/alipay_notify.html';
			//页面跳转同步通知页面路径
			//$return_url = 'http://www.ebh.net/demo/alipay_return.html';
			$return_url  = "";
			//商品展示地址
			$show_url = "http://www.ebh.net";
			//必填
			//商户订单号
			$out_trade_no = strval($ordernum);
			//商户网站订单系统中唯一订单号，必填
			//订单名称
			$subject = 'e板会打赏 ';			
			//必填
			//付款金额
			$total_fee = $money;			
			//必填
			//订单描述
			$body = 'e板会打赏 ';
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
		$Alipay = Ebh::app()->lib('Alipay');
		$verify_result = $Alipay->checknotify();
		if($verify_result){
			$redis = Ebh::app()->getCache("cache_redis");
			$param = array();
			$param['out_trade_no'] = $_POST['out_trade_no'];//商户网站唯一订单号
			$param['paycode'] = $_POST['trade_no'];//交易号
			$param['buyer_id'] = $_POST['buyer_id'];//买家支付宝账户号
			$param['buyer_info'] = $_POST['buyer_email'];//买家支付宝账号
			$param['status'] = 1;//支付成功
			$param['payip'] = getip();//支付ip
			$param['payfrom'] = 3;//支付方式为支付宝
			$param['paytime'] = SYSTIME;
			if(!empty($param['out_trade_no'])){
				$rwModel = $this->model('Reward');
				//检查订单状态
				$status = $rwModel->getOrderStatusByOrderNum($param['out_trade_no']);
				if($status['status'] == 1){
					echo 'success';
				}else if(empty($status['status']) && isset($status['status'])){
					$res = $rwModel->updateOrder($param,$param['out_trade_no']);
					if($res){//更新成功
						$ordernumKey = md5($param['out_trade_no']);
						$redis->set($ordernumKey,1);
						echo 'success';
						log_message("支付宝支付成功:".$param['out_trade_no']);
					}
				}
			}
		}	
	}

	/***微信扫码支付逻辑开始***/
	//微信扫码订单生成
	public function wechatOrder(){
		$post = $this->input->post();
		if(!empty($post['money'])){
			$money = floatval($post['money']);
		}
		if(!empty($post['cwid'])){
			$cwid = intval($post['cwid']);
		}
		//检验金额
		$this->_checkReward($money);
		//检验通过，生成订单
		$param['cwid'] = $cwid;
		$param['totalfee'] = $money;
		$param['dateline'] = SYSTIME;
		$param['ip'] = getip();
		$ordinfo = $this->_bulidRewardsOrder($param,true);
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
		if(!empty($get['money'])){
			$money = $get['money'];
		}
		$this->_checkReward($money);
		if(empty($ordernum) || !is_numeric($ordernum)){
			return false;
		}
		$attach = md5($ordernum);
		//商户订单号
		$out_trade_no = strval($ordernum);
		//订单名称
		$subject = 'e板会打赏';
		//付款金额
		$total_fee = $money*100;
		//订单描述
		$body = 'e板会打赏';
		$domian = getdomain();
		$notify_url = $domian.'/myroom/rewards/wx_notify.html';
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
		$redis = Ebh::app()->getCache("cache_redis");
		if(empty($verify_result)) {
			log_message("微信支付,微信服务器验证失败!");
			return false;
		}
		//返回信息 确认金额
		$param['out_trade_no'] = $verify_result['out_trade_no'];//商户网站唯一订单号
		$param['paycode'] = $verify_result['transaction_id'];//微信交易号
		$param['buyer_id'] = $verify_result['openid'];//买家appid
		$param['status'] = 1;//支付成功
		$param['payip'] = getip();//支付ip
		$param['payfrom'] = 9;//支付方式为微信支付
		$param['paytime'] = SYSTIME;
		if(!empty($param['out_trade_no'])){
			$rwModel = $this->model('Reward');
			//检查订单状态
			$status = $rwModel->getOrderStatusByOrderNum($param['out_trade_no']);
			if($status['status'] == 1){
				echo 'SUCCESS';
			}else if(empty($status['status']) && isset($status['status'])){
				$res = $rwModel->updateOrder($param,$param['out_trade_no']);
				if($res){//更新成功
					$ordernumKey = md5($param['out_trade_no']);
					$redis->set($ordernumKey,1);
					echo 'SUCCESS';
					log_message("微信支付成功:".$param['out_trade_no']);
				}
			}
		} 
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

}