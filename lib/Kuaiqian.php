<?php

/**
 * 块钱支付类库
 */
class Kuaiqian {
	public function payTo($param) {
		require_once("99bill/99bill.config.php");
		//人民币网关账户号
		$merchantAcctId=$bill_config['merchantAcctId'];
		//人民币网关密钥
		$key=$bill_config['key'];
		$inputCharset=$bill_config['inputCharset'];
		//服务器接受支付结果的后台地址.与[pageUrl]不能同时为空。必须是绝对地址。
		$bgUrl=$param['notify_url'];
		//网关版本.固定值
		$version=$bill_config['version'];
		$language=$bill_config['language'];
		$signType=$bill_config['signType'];
		//支付人姓名
		///可为中文或英文字符
		$payerName=$param['username'];	//快钱多出支付宝部分
		//支付人联系方式类型.固定选择值
		///只能选择1
		///1代表Email
		$payerContactType=$bill_config['payerContactType'];	
		$payerContact=$param['payerContact'];
		//商户订单号
		$orderId=$param['trade_no'];
		//订单金额
		///以分为单位，必须是整型数字
		///比方2，代表0.02元
		$chargevalue = $param['total_fee'];
		$orderAmount=$chargevalue*100;
		//$orderTime=date('YmdHis');
		$orderTime=date('YmdHis',time());
		//商品名称
		///可为中文或英文字符
		$productName=$param['subject'];	

		//商品数量
		///可为空，非空时必须为数字
		$productNum="1";
		//商品代码
		///可为字符或者数字
		$productId=$param['productId'];	//快钱多出支付宝部分
		//商品描述
		$productDesc=$param['body'];	
		//扩展字段1
		///在支付结束后原样返回给商户
		$ext1=$param['ext1'];	//快钱多出支付宝部分
		
		//扩展字段2
		///在支付结束后原样返回给商户
		$ext2="";
		$payType="00";
		//同一订单禁止重复提交标志
		$redoFlag="1";
		$pid="";
		
		//生成加密签名串
		///请务必按照如下顺序和规则组成加密串！
		$signMsgVal = '';
		$signMsgVal=$this->appendParam($signMsgVal,"inputCharset",$inputCharset);
		$signMsgVal=$this->appendParam($signMsgVal,"bgUrl",$bgUrl);
		$signMsgVal=$this->appendParam($signMsgVal,"version",$version);
		$signMsgVal=$this->appendParam($signMsgVal,"language",$language);
		$signMsgVal=$this->appendParam($signMsgVal,"signType",$signType);
		$signMsgVal=$this->appendParam($signMsgVal,"merchantAcctId",$merchantAcctId);
		$signMsgVal=$this->appendParam($signMsgVal,"payerName",$payerName);
		$signMsgVal=$this->appendParam($signMsgVal,"payerContactType",$payerContactType);
		$signMsgVal=$this->appendParam($signMsgVal,"payerContact",$payerContact);
		$signMsgVal=$this->appendParam($signMsgVal,"orderId",$orderId);
		$signMsgVal=$this->appendParam($signMsgVal,"orderAmount",$orderAmount);
		$signMsgVal=$this->appendParam($signMsgVal,"orderTime",$orderTime);
		$signMsgVal=$this->appendParam($signMsgVal,"productName",$productName);
		$signMsgVal=$this->appendParam($signMsgVal,"productNum",$productNum);
		$signMsgVal=$this->appendParam($signMsgVal,"productId",$productId);
		$signMsgVal=$this->appendParam($signMsgVal,"productDesc",$productDesc);
		$signMsgVal=$this->appendParam($signMsgVal,"ext1",$ext1);
		$signMsgVal=$this->appendParam($signMsgVal,"ext2",$ext2);
		$signMsgVal=$this->appendParam($signMsgVal,"payType",$payType);	
		$signMsgVal=$this->appendParam($signMsgVal,"redoFlag",$redoFlag);
		$signMsgVal=$this->appendParam($signMsgVal,"pid",$pid);
		$signMsgVal=$this->appendParam($signMsgVal,"key",$key);
		$signMsg= strtoupper(md5($signMsgVal));
		$msg = array('inputCharset'=>$inputCharset,'bgUrl'=>$bgUrl,'version'=>$version,'language'=>$language,'signType'=>$signType,
			'signMsg'=>$signMsg,'merchantAcctId'=>$merchantAcctId,'payerName'=>$payerName,'payerContactType'=>$payerContactType,
			'payerContact'=>$payerContact,'orderId'=>$orderId,'orderAmount'=>$orderAmount,'orderTime'=>$orderTime,'productName'=>$productName,
			'productNum'=>$productNum,'productId'=>$productId,'productDesc'=>$productDesc,'ext1'=>$ext1,'ext2'=>$ext2,'payType'=>$payType,
			'redoFlag'=>$redoFlag,'pid'=>$pid);

		//建立请求
		$html_text = $this->buildRequestForm($msg,"get", "确认");
		$html_text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.
					'<html>'.
					'<head>'.
					'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.
					'<title>快钱支付接口</title>'.
					'</head>'.
					$html_text.
					'</body>'.
					'</html>';
		echo $html_text;
	}


	//功能函数。将变量值不为空的参数组成字符串
	public function appendParam($returnStr,$paramId,$paramValue){

		if($returnStr!=""){
			
				if($paramValue!=""){
					
					$returnStr.="&".$paramId."=".$paramValue;
				}
			
		}else{
		
			If($paramValue!=""){
				$returnStr=$paramId."=".$paramValue;
			}
		}
		
		return $returnStr;
	}
	/**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
	function buildRequestForm($para_temp, $method, $button_name) {
		//待请求参数数组		
		$sHtml = "<form id='kqPay' name='kqPay' action='https://www.99bill.com/gateway/recvMerchantInfoAction.htm' method='".$method."'>";
		while (list ($key, $val) = each ($para_temp)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";
		
		$sHtml = $sHtml."<script>document.forms['kqPay'].submit();</script>";
		
		return $sHtml;
	}
	/**
	*验证支付回来通知信息是否有效
	*/
	public function checknotify() {
		require_once("99bill/99bill.config.php");
		require_once("99bill/secury.php");
		$client_ip = Ebh::app()->getInput()->getip();
		if (!in_array($client_ip, $_SECURY['99bill']['server'])) {	//判断是否为合法的IP来源
			return FALSE;
		}
		//获取人民币网关账户号
		$merchantAcctId=trim($_REQUEST['merchantAcctId']);

		//人民币网关密钥
		$key=$bill_config['key'];
		///本代码版本号固定为v2.0
		$version=trim($_REQUEST['version']);
		$language=trim($_REQUEST['language']);
		$signType=trim($_REQUEST['signType']);
		$payType=trim($_REQUEST['payType']);
		$bankId=trim($_REQUEST['bankId']);
		//获取商户订单号
		$orderId=trim($_REQUEST['orderId']);
		$orderTime=trim($_REQUEST['orderTime']);
		$orderAmount=trim($_REQUEST['orderAmount']);
		$dealId=trim($_REQUEST['dealId']);
		$bankDealId=trim($_REQUEST['bankDealId']);
		$dealTime=trim($_REQUEST['dealTime']);

		//获取实际支付金额
		///单位为分
		///比方 2 ，代表0.02元
		$payAmount=trim($_REQUEST['payAmount']);

		//获取交易手续费
		///单位为分
		///比方 2 ，代表0.02元
		$fee=trim($_REQUEST['fee']);

		//获取扩展字段1
		$ext1=trim($_REQUEST['ext1']);

		//获取扩展字段2
		$ext2=trim($_REQUEST['ext2']);

		//获取处理结果
		///10代表 成功; 11代表 失败
		$payResult=trim($_REQUEST['payResult']);

		//获取错误代码
		///详细见文档错误代码列表
		$errCode=trim($_REQUEST['errCode']);

		//获取加密签名串
		$signMsg=trim($_REQUEST['signMsg']);

		//生成加密串。必须保持如下顺序。
			$merchantSignMsgVal = '';
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"merchantAcctId",$merchantAcctId);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"version",$version);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"language",$language);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"signType",$signType);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"payType",$payType);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"bankId",$bankId);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"orderId",$orderId);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"orderTime",$orderTime);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"orderAmount",$orderAmount);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"dealId",$dealId);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"bankDealId",$bankDealId);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"dealTime",$dealTime);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"payAmount",$payAmount);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"fee",$fee);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"ext1",$ext1);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"ext2",$ext2);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"payResult",$payResult);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"errCode",$errCode);
			$merchantSignMsgVal=$this->appendParam($merchantSignMsgVal,"key",$key);
		$merchantSignMsg= md5($merchantSignMsgVal);
		//初始化结果及地址
		$rtnOk=0;
		$rtnUrl="";
		//商家进行数据处理，并跳转会商家显示支付结果的页面
		///首先进行签名字符串验证
		if(strtoupper($signMsg)==strtoupper($merchantSignMsg)){
			return $payResult;
		}
		return FALSE;
	}
	/**
	*根据notify结果 处理notify输出notify页面
	*/
	public function notify($result,$url) {
		$msg = "<result>$result</result><redirecturl>$url</redirecturl>";
		echo $msg;
	}
}