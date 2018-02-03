<?php

/**
 * 农行支付类库
 */
class Abcpayv2 {
	public function payTo($param) {
		class_exists('PaymentRequest') or require(dirname(__FILE__).'/abcpayv2/ebusclient/PaymentRequest.php');
		$tRequest=new PaymentRequest();

		//转换编号 UTF-8到 GB2312
		$param['OrderDesc'] = shortstr($param['OrderDesc'],47);

		$tRequest->order["PayTypeID"] = 'ImmediatePay'; //设定交易类型(直接支付)
		$tRequest->order["OrderNo"] = $param['OrderNo']; //设定订单编号
		$tRequest->order["ExpiredDate"] = $param['ExpiredDate']; //设定订单保存时间
		$tRequest->order["OrderAmount"] = round($param['OrderAmountStr'],2); //设定交易金额
		$tRequest->order["Fee"] = ''; //设定手续费金额
		$tRequest->order["CurrencyCode"] = '156'; //设定交易币种 156 人民币
		$tRequest->order["ReceiverAddress"] = ''; //收货地址
		$tRequest->order["InstallmentMark"] = '0'; //分期标识
		$tRequest->order["BuyIP"] = $param['BuyIP']; //IP
		$tRequest->order["OrderDesc"] = $param['OrderDesc']; //设定订单说明
		$tRequest->order["OrderURL"] = $param['OrderURL']; //设定订单地址
		$tRequest->order["OrderDate"] = $param['OrderDate']; //设定订单日期 （必要信息 - YYYY/MM/DD）
		$tRequest->order["OrderTime"] = $param['OrderTime']; //设定订单时间 （必要信息 - HH:MM:SS）
	//	$tRequest->order["orderTimeoutDate"] = ($_POST['orderTimeoutDate']); //设定订单有效期
		$tRequest->order["CommodityType"] = '0201'; //设置商品种类

	//2、生成定单订单对象，并将订单明细加入定单中（可选信息）
		$i = 0;
		foreach($param['itemlist'] as $myitem) {
			if($i > 1)
				break;
			$myitem['oname'] = shortstr($myitem['oname'],47,'');
			$orderitem = array ();
			$orderitem["SubMerName"] = "e板会"; //设定二级商户名称
			$orderitem["SubMerId"] = "0"; //设定二级商户代码
			$orderitem["SubMerMCC"] = "0000"; //设定二级商户MCC码 
			$orderitem["SubMerchantRemarks"] = "浙江新盛蓝科技有限公司"; //二级商户备注项
			$orderitem["ProductID"] = $myitem['itemid']; //商品代码，预留字段
			$orderitem["ProductName"] = $myitem['oname']; //商品名称
			$orderitem["UnitPrice"] = $myitem['fee']; //商品总价
			$orderitem["Qty"] = "1"; //商品数量
			$orderitem["ProductRemarks"] = $myitem['oname']; //商品备注项
			$orderitem["ProductType"] = "消费类"; //商品类型
			//$orderitem["ProductDiscount"] = "0.9"; //商品折扣
			$orderitem["ProductExpiredDate"] = "10"; //商品有效期
			$tRequest->orderitems[$i] = $orderitem;
			$i ++;
		}

		//3、生成支付请求对象
		if($param['PaymentType'] == '1')	//农行支付方式 从1改成A 合并了
			$param['PaymentType'] = 'A';

		$tRequest->request["PaymentType"] = $param['PaymentType']; //设定支付类型 A是合并支付，6为银联支付
		$tRequest->request["PaymentLinkType"] = empty($param['PaymentLinkType'])?1:$param['PaymentLinkType']; //设定支付接入方式
		if($tRequest->request["PaymentType"] == 6 && $tRequest->request["PaymentLinkType"] == 2){
			$tRequest->request["PaymentLinkType"] = 1;
		}
//		if ($_POST['PaymentType'] === "6" && $_POST['PaymentLinkType'] === "2") {
//			$tRequest->request["UnionPayLinkType"] = ($_POST['UnionPayLinkType']); //当支付类型为6，支付接入方式为2的条件满足时，需要设置银联跨行移动支付接入方式
//		}
		$tRequest->request["ReceiveAccount"] = ''; //设定收款方账号
		$tRequest->request["ReceiveAccName"] = ''; //设定收款方户名
		$tRequest->request["NotifyType"] = $param['NotifyType'].''; //设定通知方式
		
		$tRequest->request["ResultNotifyURL"] = $param['ResultNotifyURL']; //设定通知URL地址
		if(strlen($param['MerchantRemarks']) > 100) {
			$param['MerchantRemarks'] = shortstr($param['MerchantRemarks'],47);
		}
		$tRequest->request["MerchantRemarks"] = $param['MerchantRemarks']; //设定附言
		$tRequest->request["IsBreakAccount"] = '0'; //设定交易是否分账
		$tRequest->request["SplitAccTemplate"] = ''; //分账模版编号        

		$tResponse = $tRequest->postRequest();
		if($tResponse->isSuccess())
		{ //6、支付请求提交成功，将客户端导向支付页面
			$paymentUrl=$tResponse->getValue('PaymentURL');
			echo "<script language='javascript'>";
			echo "location.href='$paymentUrl'";
			echo "</script>";
		}
	}
	/**
	* 验证支付notify结果并返回验证结果
	*/
	public function getnotify() {
		class_exists('Result') or require(dirname(__FILE__).'/abcpayv2/ebusclient/Result.php');

		$tResult = new Result();
		$tResponse = $tResult->init($_POST['MSG']);

		//2、判断支付结果状态，进行后续操作
		$mynotify = FALSE;
		if($tResponse->isSuccess()) {
			$mynotify = array();
			$mynotify['TrxType'] = $tResponse->getValue('TrxType');
			$mynotify['OrderNo'] = $tResponse->getValue('OrderNo');
			$mynotify['Amount']  = $tResponse->getValue('Amount');
			$mynotify['BatchNo'] = $tResponse->getValue('BatchNo');
			$mynotify['VoucherNo'] = $tResponse->getValue('VoucherNo');
			$mynotify['HostDate']  = $tResponse->getValue('HostDate');
			$mynotify['HostTime'] = $tResponse->getValue('HostTime');
			$mynotify['MerchantRemarks'] = $tResponse->getValue('MerchantRemarks');
			$mynotify['PayType'] = $tResponse->getValue('PayType');
			$mynotify['NotifyType'] = $tResponse->getValue('NotifyType');
			$mynotify['TrnxNo'] = $tResponse->getValue('iRspRef');
		} else {
			$ReturnCode   = $tResponse->getReturnCode();
			$ErrorMessage = $tResponse->getErrorMessage();
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