<?php
/**
 * 支付宝支付类库APP专用
 */
class AlipayForApp {
	public function checknotify() {
		require_once("alipayForApp/alipay.config.php");
		require_once("alipayForApp/lib/alipay_notify.class.php");
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {//验证成功
			//交易状态
			$trade_status = $_POST['trade_status'];
		    if(($_POST['trade_status'] == 'TRADE_FINISHED') || ($_POST['trade_status'] == 'TRADE_SUCCESS')) {
				$result = array(
					'out_trade_no'=>$_POST['out_trade_no'],
					'trade_no'=>$_POST['trade_no'],
					'buyer_id'=>$_POST['buyer_id'],
					'buyer_info'=>$_POST['buyer_email']
				);
				return $result;
		    }
		}
		else {
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