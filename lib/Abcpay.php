<?php

/**
 * 农行支付类库
 */
class Abcpay {
	public function payTo($param) {
		class_exists('TrxResponse') or require(dirname(__FILE__).'/abcpay/bin/core/TrxResponse.php');
		class_exists('TrxException') or require(dirname(__FILE__).'/abcpay/bin/core/TrxException.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/abcpay/bin/core/TrxRequest.php');
		class_exists('TrxType') or require(dirname(__FILE__).'/abcpay/bin/TrxType.php');
		class_exists('Order') or require(dirname(__FILE__).'/abcpay/bin/Order.php');
		class_exists('Insure') or require(dirname(__FILE__).'/abcpay/bin/Insure.php');
		class_exists('PaymentRequest') or require(dirname(__FILE__).'/abcpay/bin/PaymentRequest.php');
		//2、生成订单对象
		//转换编号 UTF-8到 GB2312
		$param['OrderDesc'] = shortstr($param['OrderDesc'],47);
		$param['OrderDesc'] = iconv("UTF-8","GB2312//IGNORE",$param['OrderDesc']) ;
		$param['MerchantRemarks'] = iconv("UTF-8","GB2312//IGNORE",$param['MerchantRemarks']) ;

		$ord=new Order();
		$ord->setOrderNo($param['OrderNo']);
		$ord->setExpiredDate($param['ExpiredDate']);
		$ord->setOrderDesc($param['OrderDesc']);
		$ord->setOrderDate($param['OrderDate']);
		$ord->setOrderTime($param['OrderTime']);
		$ord->setOrderAmount($param['OrderAmountStr']);
		$ord->setOrderURL($param['OrderURL']);
		$ord->setBuyIP($param['BuyIP']);
	//3、生成定单订单对象，并将订单明细加入定单中（可选信息）
		$ordItemOne=new OrderItem();

		$ordItemOne->__constructOrderItem('IP000001', $param['OrderDesc'], $param['OrderAmountStr'], 1);
		$ordItemOnexml=$ordItemOne->getXMLDocument();
//		
//		$ordItem2=new OrderItem();
//		$ordItem2->__constructOrderItem('IP000002', '网通ip卡', 90.1, 2);
//		$ordItem2xml=$ordItem2->getXMLDocument();
		$ord->addOrderItem($ordItemOnexml);
//		$ord->addOrderItem($ordItem2xml);
		$ordxml=$ord->getXMLDocument(3);
		//echo $ord->getXMLDocument(1);
	//4、生成支付请求对象
		$pr=new PaymentRequest();
		$pr->setOrder($ordxml);
		//echo $pr->getOrder();
		$pr->setProductType($param['ProductType']);
		$pr->setPaymentType($param['PaymentType']);
		$pr->setNotifyType($param['NotifyType']);
		//$pr->setResultNotifyURL('http://localhost:8118/WebSite4/Default.aspx');
		$pr->setResultNotifyURL($param['ResultNotifyURL']);
		$pr->setMerchantRemarks($param['MerchantRemarks']);
		$pr->setPaymentLinkType($param['PaymentLinkType']);
	//5、传送支付请求并取得支付网址
		if($param['PaymentType'] == 6) {
			$tTrxResponse = $pr->extendPostRequest(2);
		} else {
			$tTrxResponse = $pr->extendPostRequest(1);
		}
		if($tTrxResponse->isSuccess())
		{ //6、支付请求提交成功，将客户端导向支付页面
			$paymentUrl=$tTrxResponse->getValue('PaymentURL');
			echo "<script language='javascript'>";
			echo "location.href='$paymentUrl'";
			echo "</script>";
		}
	   //7、支付请求提交失败，商户自定后续动作
	}
	/**
	* 验证支付notify结果并返回验证结果
	*/
	public function getnotify() {
		class_exists('TrxResponse') or require(dirname(__FILE__).'/abcpay/bin/core/TrxResponse.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/abcpay/bin/core/TrxRequest.php');
		class_exists('PaymentResult') or require(dirname(__FILE__).'/abcpay/bin/PaymentResult.php');

		class_exists('TrxResponse') or require(dirname(__FILE__).'/abcpay/bin/core/TrxResponse.php');
		class_exists('TrxException') or require(dirname(__FILE__).'/abcpay/bin/core/TrxException.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/abcpay/bin/core/TrxRequest.php');
		class_exists('TrxType') or require(dirname(__FILE__).'/abcpay/bin/TrxType.php');
		class_exists('PaymentResult') or require(dirname(__FILE__).'/abcpay/bin/PaymentResult.php');


		//0、设定商户结果显示页面
		$tMerchantPage = '';
		//1、取得MSG参数，并利用此参数值生成支付结果对象
		$tResult = new PaymentResult($_POST['MSG']);
		//2、判断支付结果状态，进行后续操作
		$mynotify = FALSE;
		if($tResult->isSuccess()) {
			$mynotify = array();
			$mynotify['TrxType'] = $tResult->getValue('TrxType');
			$mynotify['OrderNo'] = $tResult->getValue('OrderNo');
			$mynotify['Amount']  = $tResult->getValue('Amount');
			$mynotify['BatchNo'] = $tResult->getValue('BatchNo');
			$mynotify['VoucherNo'] = $tResult->getValue('VoucherNo');
			$mynotify['HostDate']  = $tResult->getValue('HostDate');
			$mynotify['HostTime'] = $tResult->getValue('HostTime');
			$mynotify['MerchantRemarks'] = $tResult->getValue('MerchantRemarks');
			$mynotify['PayType'] = $tResult->getValue('PayType');
			$mynotify['NotifyType'] = $tResult->getValue('NotifyType');
			$mynotify['TrnxNo'] = $tResult->getValue('iRspRef');
		} else {
			$ReturnCode   = $tResult->getReturnCode();
			$ErrorMessage = $tResult->getErrorMessage();
			log_message("abc pay error,ReturnCode:$ReturnCode,ErrorMessage:$ErrorMessage");
		}
		return $mynotify;
	}
	/**
	*根据notify结果 处理notify输出notify页面
	* 如果输出fail 则支付宝会以一定策略重发
	*/
	public function notify($returnurl) {

		$result = '<HTML>'.
				'<HEAD>'.
				'<meta http-equiv="refresh" content="0; url='.$returnurl.'">'.
				'</HEAD>'.
				'</HTML>';
		echo $result;
		exit();
	}
	/*
	*退货请求 
	*主要传三个参数 TrxAmount 退款金额 OrderNo 原订单编号 NewOrderNo 新订单编号 payfrom 6 农行直接支付 7为农行银联
	*/
	public function refund($param) {
		class_exists('TrxResponse') or require(dirname(__FILE__).'/abcpay/bin/core/TrxResponse.php');
		class_exists('TrxException') or require(dirname(__FILE__).'/abcpay/bin/core/TrxException.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/abcpay/bin/core/TrxRequest.php');
		class_exists('TrxType') or require(dirname(__FILE__).'/abcpay/bin/TrxType.php');
		class_exists('RefundRequest') or require(dirname(__FILE__).'/abcpay/bin/RefundRequest.php');

		//1、取得退货所需要的信息
		$tTrxAmount = $param['TrxAmount'];
		$tOrderNo = $param['OrderNo'];
		$tNewOrderNo=$param['NewOrderNo'];
		$payfrom = empty($param['PayFrom']) ? 6 : intval($param['PayFrom']);
		
		//2、生成退货请求对象
		$refundRequest=new RefundRequest();
		$refundRequest->setOrderNo($tOrderNo);//订单号   （必要信息）
		$refundRequest->setNewOrderNo($tNewOrderNo);//新订单号   （必要信息）
		$refundRequest->setTrxAmount($tTrxAmount);//退货金额 （必要信息）
		//3、传送退货请求并取得退货结果
		if($payfrom == 7) {
			$tResponse=$refundRequest->extendPostRequest(2);
		} else {
			$tResponse=$refundRequest->extendPostRequest(1);
		}
		if($tResponse->isSuccess())
		{
			return TRUE;
		} else { //6、退货失败
			return FALSE;
		}
	}
	/**
	*根据日期获取农行交易对账单
	*@param string $tSettleDate 交易日期，格式为 YYYY/MM/DD
	*/
	public function getSettle($tSettleDate = '') {
		class_exists('TrxResponse') or require(dirname(__FILE__).'/abcpay/bin/core/TrxResponse.php');
		class_exists('TrxException') or require(dirname(__FILE__).'/abcpay/bin/core/TrxException.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/abcpay/bin/core/TrxRequest.php');
		class_exists('TrxType') or require(dirname(__FILE__).'/abcpay/bin/TrxType.php');
		class_exists('SettleRequest') or require(dirname(__FILE__).'/abcpay/bin/SettleRequest.php');
		class_exists('SettleFile') or require(dirname(__FILE__).'/abcpay/bin/SettleFile.php');
		//1、取得商户对账单下载所需要的信息
		if(empty($tSettleDate))	//如果为空，则为当前天
			$tSettleDate = date('Y/m/d',SYSTIME);
		//2、生成商户对账单下载请求对象
		$settleRequest = new SettleRequest();
		$settleRequest->setSettleDate($tSettleDate);//对账日期YYYY/MM/DD （必要信息）
		$settleRequest->setSettleType(SettleFile::SETTLE_TYPE_TRX);//对账类型 （必要信息）
		//3、传送商户对账单下载请求并取得对账单	
		$tResponse=$settleRequest->postRequest();
		//4、判断商户对账单下载结果状态，进行后续操作
		if($tResponse->isSuccess())
		{	//5、商户对账单下载成功，生成对账单对象
			$tSettleFile=new SettleFile();
			$tSettleFile->constructSettleFile($tResponse);
			echo "SettleDate        = [".$tSettleFile->getSettleDate()."]<br>";
			echo "SettleType        = [".$tSettleFile->getSettleType()."]<br>";
			echo "NumOfPayments        = [".$tSettleFile->getNumOfPayments()."]<br>";
			echo "SumOfPayAmount        = [".$tSettleFile->getSumOfPayAmount()."]<br>";
			echo "NumOfRefunds        = [".$tSettleFile->getNumOfRefunds()."]<br>";
			echo "SumOfRefundAmount        = [".$tSettleFile->getSumOfRefundAmount()."]<br>";
			//6、取得对账单明细
			$tRecords=$tSettleFile->getDetailRecords();
			for($i=0;$i<count($tRecords);$i++)
			{
				echo "Record-".$i." = [".$tRecords[$i]."]<br>";
			}
		}else {
			//7、商户账单下载失败
			//var_dump($tResponse);
			//echo $tResponse;
			echo "ReturnCode   = [".$tResponse->getReturnCode()."]<br>";
			echo "ErrorMessage = [".$tResponse->getErrorMessage()."]<br>";
		}

	}
	/**
	*获取订单详情
	*@param string $tOrderNo 订单编号
	*@param int $tQueryType 查询类型，1为获取详情
	*@param int $PaymentType 支付类型 6表示农行直接支付 7表示农行银联支付
	*/
	public function getOrder($tOrderNo,$tQueryType = 1,$PaymentType = 6) {
		class_exists('TrxResponse') or require(dirname(__FILE__).'/abcpay/bin/core/TrxResponse.php');
		class_exists('TrxException') or require(dirname(__FILE__).'/abcpay/bin/core/TrxException.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/abcpay/bin/core/TrxRequest.php');
		class_exists('TrxType') or require(dirname(__FILE__).'/abcpay/bin/TrxType.php');
		class_exists('Order') or require(dirname(__FILE__).'/abcpay/bin/Order.php');
		class_exists('QueryOrderRequest') or require(dirname(__FILE__).'/abcpay/bin/QueryOrderRequest.php');
		//1、取得商户订单查询所需要的信息
		$tEnableDetailQuery=FALSE;
		if($tQueryType=='1')
			$tEnableDetailQuery=TRUE;
		//2、生成商户订单查询请求对象
		$qor=new QueryOrderRequest();
		$qor->setOrderNo($tOrderNo);
		$qor->enableDetailQuery($tEnableDetailQuery);
		//3、传送商户订单查询请求并取得订单查询结果
		if($PaymentType == 6) {
			$tTrxResponse = $qor->extendPostRequest(1);
		} else {
			$tTrxResponse = $qor->extendPostRequest(2);
		}
		//$tTrxResponse=$qor->extendPostRequest(2);
		
		//4、判断商户订单查询结果状态，进行后续操作
		if($tTrxResponse->isSuccess())
		{//5、生成订单对象
			$tOrder=new Order();
			$tOrder->__constructXMlDocument($tTrxResponse->getValue('Order'));
			echo "OrderNo      = [".$tOrder->getOrderNo()."]<br>";
			echo "OrderAmount  = [".$tOrder->getOrderAmount()."]<br>";
			echo "OrderDesc    = [".$tOrder->getOrderDesc()."]<br>";
			echo "OrderDate    = [".$tOrder->getOrderDate()."]<br>";
			echo "OrderTime    = [".$tOrder->getOrderTime()."]<br>";
			echo "OrderURL     = [".$tOrder->getOrderURL()."]<br>";
			echo "PayAmount    = [".$tOrder->getPayAmount()."]<br>";
			echo "RefundAmount = [".$tOrder->getRefundAmount()."]<br>";
			echo "OrderStatus  = [".$tOrder->getOrderStatus()."]<br>";
			//6、取得订单明细
			//if($tEnableDetailQuery==true)
			//{
				$tOrderItems=$tOrder->getOrderItems();
				//var_dump($tOrderItems);
				//echo count($tOrderItems).'num';
				for($i=0;$i<count($tOrderItems);$i++)
				{
					$tOrderItem=$tOrderItems[$i];
					$tOI=new OrderItem();
					$tOI->__constructXMlDocument($tOrderItem);
					echo "ProductID   = [".$tOI->getProductID()."]<br>";
					echo "ProductName = [".$tOI->getProductName()."]<br>";
					echo "UnitPrice   = [".$tOI->getUnitPrice()."]<br>";
					echo "Qty         = [".$tOI->getQty()."]<br>";
				}
		//	}
		}
		else {
			//7、商户订单查询失败
			echo "ReturnCode   = [".$tTrxResponse->getReturnCode()."]<br>";
			echo "ErrorMessage = [".$tTrxResponse->getErrorMessage()."]<br>";
		}
	}
}