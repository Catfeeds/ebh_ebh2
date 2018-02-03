<?php
/**
 * 微信支付类库
 */
class Weixinpay{
	public function checknotify(){
		require ("Wxpay/ResponseHandler.class.php");
		require ("Wxpay/RequestHandler.class.php");
		require ("Wxpay/client/TenpayHttpClient.class.php");
		$WxPayConfig = Ebh::app()->getConfig()->load('wxpay');
		/* 创建支付应答对象 */
		$resHandler = new ResponseHandler();
		$key = $WxPayConfig['PARTNER_KEY'];
		$resHandler->setKey($key);

		//初始化页面提交过来的参数
		// $resHandler->Init();
		//判断签名
		if($resHandler->isTenpaySign() == true) {
			//商户在收到后台通知后根据通知ID向财付通发起验证确认，采用后台系统调用交互模式	
			$notify_id = $resHandler->getParameter("notify_id");//通知id
		
			//商户交易单号
			$out_trade_no = $resHandler->getParameter("out_trade_no");
			
			
			//财付通订单号
			$transaction_id = $resHandler->getParameter("transaction_id");

			//商品金额,以分为单位
			$total_fee = $resHandler->getParameter("total_fee");

			//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
			$discount = $resHandler->getParameter("discount");

			//支付结果
			$trade_state = $resHandler->getParameter("trade_state");
            if('MWEB' == $resHandler->getParameter('trade_type')){//H5的支付类型
                $trade_state = $resHandler->getParameter('result_code');
            }
			//判断签名及结果
			if ("0" == $trade_state || 'SUCCESS' == $trade_state){
				return $resHandler->getAllParameters();
			}else{
				return array();
			}
		}
		return array();
	}
	/**
	*根据notify结果 处理notify输出notify页面
	* 如果输出fail 则微信以一定策略重发
	*/
	public function notify($verify_result) {
		if($verify_result)
			echo "success";		//请不要修改或删除
		else
			echo "fail";
	}
}