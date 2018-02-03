<?php
/**
 * 支付宝支付类库(wap版本)
 */
class Alipaywap{
	public function checknotify(){
		require_once(dirname(__FILE__).'/alipaywap/alipay.config.php');
		require_once(dirname(__FILE__).'/alipaywap/lib/alipay_notify.class.php');
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代

			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			
			//解析notify_data
			//注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件
			$doc = new DOMDocument();	
			if ($alipay_config['sign_type'] == 'MD5') {
				$doc->loadXML($_POST['notify_data']);
			}
			
			if ($alipay_config['sign_type'] == '0001') {
				$doc->loadXML($alipayNotify->decrypt($_POST['notify_data']));
			}
			
			if( ! empty($doc->getElementsByTagName( "notify" )->item(0)->nodeValue) ) {
				//商户订单号
				$out_trade_no = $doc->getElementsByTagName( "out_trade_no" )->item(0)->nodeValue;
				//支付宝交易号
				$trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;
				//交易状态
				$trade_status = $doc->getElementsByTagName( "trade_status" )->item(0)->nodeValue;

				$buyer_id = $doc->getElementsByTagName( "buyer_id" )->item(0)->nodeValue;
				$buyer_email = $doc->getElementsByTagName( "buyer_email" )->item(0)->nodeValue;
				
				if($trade_status == 'TRADE_FINISHED') {
					$param = array(
						'out_trade_no'=>$out_trade_no,
						'trade_no'=>$trade_no,
						'buyer_id'=>$buyer_id,
						'buyer_email'=>$buyer_email
					);	
					return $param;
				}else if ($trade_status == 'TRADE_SUCCESS') {
					$param = array(
						'out_trade_no'=>$out_trade_no,
						'trade_no'=>$trade_no,
						'buyer_id'=>$buyer_id,
						'buyer_email'=>$buyer_email
					);	
					return $param;
				}
			}
			
		}else {
		    //验证失败
		    return false;
		}
	}
	/**
	*根据notify结果 处理notify输出notify页面
	* 如果输出fail 则支付宝会以一定策略重发
	*/
	public function notify($verify_result) {
		if($verify_result)
			echo "success";		//请不要修改或删除
		else
			echo "fail";
	}
}	
?>
