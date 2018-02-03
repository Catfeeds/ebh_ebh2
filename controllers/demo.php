<?php
/**
 * 测试demo
 */
class DemoController extends CControl {
	
	
	public function index(){
		$editor = Ebh::app()->lib('UMEditor');
		
		$this->assign("editor", $editor);
		$this->display('demo/editor');
	}	
	
	/**
	 * ueditor测试
	 */
	public function ueditor(){
	    $editor = Ebh::app()->lib('UEditor');
	    $this->assign("editor", $editor);
	    $this->display('demo/editor');
	}
	
	/**
	 * ueditor测试
	 */
	public function ueditor_old(){
	    $editor = Ebh::app()->lib('UMEditor');
	    $this->assign("editor", $editor);
	    $this->display('demo/editor');
	}
	
	
	
	
	
	
	
	
	
	
	Public function type(){
	    $type = Ebh::app()->room->getRoomType();
	    var_dump($type);
	    
	}
	
	public function  img(){
		$total = 0;
		$i=imagecreatefromjpeg("36.jpg");//测试图片，自己定义一个，注意路径
		
		echo imagesx($i);echo '--';
		echo imagesy($i);
		$arr = array();
		for ($x=0;$x<imagesx($i);$x++) {
			for ($y=0;$y<imagesy($i);$y++) {
				$rgb = imagecolorat($i,$x,$y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				
			if(count($arr)<10 && !in_array($rgb, $arr)){
					array_push($arr, $rgb);
				}
				
	/* 			if($y < 10){
					echo "<input  value='{$rgb}'  style=\"background-image: none; background-color: rgb({$r},{$g},{$b}); color: rgb(0, 0, 0);\">";
					echo '<br />';
				} */
/* 				$r=($rgb >>16) & 0xFF;
				$g=($rgb >>16)&0xFF;
				$b=$rgb & 0xFF;
				$rTotal += $r;
				$gTotal += $g;
				$bTotal += $b;
				$total++; */
			}
		}
		//echo count($arr);
		
		foreach($arr as $key=>$item){
			$r = ($item >> 16) & 0xFF;
			$g = ($item >> 8) & 0xFF;
			$b = $item & 0xFF;
			echo $key;
			echo "<input  value='{$item}'  style=\"background-image: none; background-color: rgb({$r},{$g},{$b}); color: rgb(0, 0, 0);\">";
			echo '<br />';
		}
		exit;
		$rAverage = round($rTotal/$total);
		$gAverage = round($gTotal/$total);
		$bAverage = round($bTotal/$total);
		//示例：
		echo '#'.dechex($rAverage).dechex($gAverage).dechex($bAverage);
		exit;
		
		
	//	echo getcwd();	
		
		//echo '<input type="button" value="扫码支付" />';
		
		$v = floatval('0.00');
		$f = 0.00;
		echo $v;
		var_dump($v);
		var_dump(empty($v));
		var_dump(empty($f));
		
		
		$post = $this->input->post();
		$cwid = (int)$this->input->post('cwid');
		
		//var_dump($post['cwid']);

		

		
		
		$this->display("demo/alipay");
		
	}
	
	/**
	 * 音乐播放器
	 */
	public function sound(){
		$this->display("demo/sound");
	}
	
	public function recorder(){
		
		$this->display("demo/recorder");
	}
	
	
	
	public function string (){
		$crid = 111;
		$module = 'roominfo';
		$memkey = 'abc';
		
		$memkey = "${crid}_${module}_${memkey}";
		$this->cache = Ebh::app()->getCache();
		//$this->cache = Ebh::app()->getCache('cache_redis');
		$updatevalues = array(1=>1);
		$updatekey = '123';
		//$this->cache->set($updatekey,serialize($updatevalues),31536000);	//memcache缓存1年
		$row = $this->cache->get($updatekey);
		var_dump($row);
		var_dump($this->cache);
 
		
		echo $memkey;
	}
	/**
	 * 测试ip
	 */
	public function ip(){
		$fromip = Ebh::app()->getInput()->getip();
		$fromip = '101.69.252.186';
		//$fromip = '10.69.252.186';
		//查找ip所在区域
		$IPObj = Ebh::app()->lib('IPaddress');
		$address = $IPObj ->find($fromip);
		$ucity = '其他';
		$province = $address['1'];
		$city = $address['2'];
		if(!empty($province) || !empty($city)){
			if(!empty($city)){
				if($province != $city){
					$ucity = $province.$city;
				}else{
					$ucity = $province;
				}
			}else{
				$ucity = !empty($province) ? $province : '其他';
			}
			
		}
		
		echo $ucity;
		var_dump($address);
		
	}
 
	
	/**
	 * 支付状态通知页
	 */
	public function  alipay_notify(){
		require_once(S_ROOT."lib/alipay/alipay.config.php");
		require_once(S_ROOT."lib/alipay/lib/alipay_notify.class.php");
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result){
			$redis = Ebh::app()->getCache("cache_redis");
			
			$ordernum = $_POST['out_trade_no'];
			
			$ordernumKey = md5($ordernum);
			$redis->set($ordernumKey,1);
			log_message("支付宝支付成功:".$ordernum);
		}else{
			$msg = 'alipay check fail...';
			log_message($msg);
			echo $msg;
		}
		

		
	}
	
	/**
	 * 返回支付状态
	 */
	public function  getpaystatus(){
		$redis = Ebh::app()->getCache("cache_redis");
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
	 * 支付成功返回
	 */
	public function alipay_return(){
		
		echo "<script>window.parent.location.href='http://www.ebh.net/demo.html';</script>";
	}
	
	/**
	 * 支付宝二维码
	 */
	public  function alipayqr(){
		$ordernum = $this->input->get("ordernum");
		$ordernum = $ordernum ? $ordernum :'1000635'.SYSTIME ;
		$domain = "www";
		$notify_url = 'http://www.ebh.net/demo/alipay_notify.html';
		//页面跳转同步通知页面路径
		//$return_url = 'http://www.ebh.net/demo/alipay_return.html';
		$return_url  = "";
		
		//商品展示地址
		$show_url = "http://www.ebh.net";
		//必填
		//商户订单号
		$out_trade_no = $ordernum;
		//商户网站订单系统中唯一订单号，必填
		//订单名称
		$subject = '研发大黄--扫码测试0.01元--订单名称';
		$total_fee = '0.01';
		//必填
		//付款金额
		
		//必填
		//订单描述
		$body = '订单描述';
		
		//$alilib = Ebh::app()->lib('Alipay');
		$param = array('notify_url'=>$notify_url,'return_url'=>$return_url,'trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'show_url'=>$show_url);
		//提交支付宝
		//$alilib->getQr($param);
		
		$this->alipayTo($param);
		
	
	}
	
	public function alipayTo($param) {
		
		require_once(S_ROOT."lib/alipay/alipay.config.php");
		require_once(S_ROOT."lib/alipay/lib/alipay_submit.class.php");
		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径
		$notify_url = $param['notify_url'];
		//需http://格式的完整路径，不能加?id=123这类自定义参数
		//页面跳转同步通知页面路径
		$return_url = $param['return_url'];
		//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
	
		//必填
		//商户订单号
		$out_trade_no = $param['trade_no'];
		//商户网站订单系统中唯一订单号，必填
		//订单名称
		$subject = $param['subject'];
		//必填
		//付款金额
		$total_fee = $param['total_fee'];
		//必填
		//订单描述
		$body = $param['body'];
		//商品展示地址
		$show_url = $param['show_url'];
		//需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html
		//防钓鱼时间戳
		$anti_phishing_key = "";
		//若要使用请调用类文件submit中的query_timestamp函数
		//客户端的IP地址
		$exter_invoke_ip = "";
		//非局域网的外网IP地址，如：221.0.0.1
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $alipay_config['seller_email'],
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
				
				//二维码参数
				"qr_pay_mode"=>4,
				"qrcode_width"=>108
		);
	
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		//过滤submit标签
		//<input type='submit' value='确认'>
		$patten = "/<input\s+type=\'submit\'.*?>/si";
		$html_text=preg_replace($patten,"",$html_text);
		
		$html_text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.
				'<html>'.
				'<head>'.
				'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.
				'<title>支付宝即时到账交易接口</title>'.
				'</head>'.
				$html_text.
				'</body>'.
				'</html>';
		
		//log_message($html_text);
		echo $html_text;
	}
	
	
	
	/******************************微信扫码支付*****************************************************/
	
	

	/***微信扫码支付逻辑开始***/
	//微信扫码订单生成
	public function wxpayqr(){

		$ordernum = $this->input->get('ordernum');
		$attach = md5($ordernum);
		//商户订单号
		$out_trade_no = $ordernum;
		//订单名称
		$subject = '大黄-微信扫码支付-0.01元';
		//付款金额
		$total_fee = 0.01*100;
		//订单描述
		$body = '微信扫码支付';
		$notify_url = 'http://www.ebh.net/demo/wx_notify.html';
		$param = array('out_trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'notify_url'=>$notify_url,'attach'=>$attach);
		 
		//var_dump($param);
		$weixinlib = Ebh::app()->lib('WxNativePay');
		$res = $weixinlib->alipayTo($param);
		if( !empty($res) && ($res['status'] == 0) ){
			//$ret['status'] = 0;
			//$ret['msg'] = '请求成功';
			//$ret['url'] = 'http://paysdk.weixin.qq.com/example/qrcode.php?data='.$res['url'];
			//$ret['cachekey'] = $res['cachekey'];
			
			$html_text =
					'<html>
					<head>
					<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
					<meta name="viewport" content="width=device-width, initial-scale=1" />
					<title>微信支付样例-退款</title>
					</head>
					<body>
					<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data='.urlencode($res['url']).'" style="width:150px;height:150px;"/>
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
			return false;
		}
		//返回信息 确认金额
		$ordernum = $verify_result['out_trade_no'];	//商户订单号
		$ordernumber = $verify_result['transaction_id'];//微信交易号
		$buyer_id = $verify_result['openid'];
		$buyer_info = '';
		 
		$ordernumKey = md5($ordernum);
		$redis->set($ordernumKey,1,60);
		log_message("微信支付成功:".$ordernum);
		 
		return true;
	}
	
	/***微信扫码支付逻辑结束***/
	
}