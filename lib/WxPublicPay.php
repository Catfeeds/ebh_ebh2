<?php
/**
 * 微信公众账号支付类库
 */
class WxPublicPay{
	public function __construct(){
		include_once("WxPayPubHelper/WxPayPubHelper.php");
		//使用通用通知接口
		$notify = new Notify_pub();
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$notify->saveData($xml);
		$this->notify = $notify;
	}
	public function checknotify(){
		$notify = $this->notify;
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
			echo $returnXml;
			return false;
		}
		return $notify->getData();
	}
	/**
	*根据notify结果 处理notify输出notify页面
	* 如果输出fail 则微信以一定策略重发
	*/
	public function notify($verify_result) {
		$notify = $this->notify;
		if($verify_result == true){
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}else{
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
		}
		$returnXml = $notify->returnXml();
		echo $returnXml;
	}
}