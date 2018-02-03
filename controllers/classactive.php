<?php
/**
 * 平台开通和充值控制器
 */
class ClassactiveController extends CControl {
	//后台验证
	private $inner_check = false;
	private $errorno = 0;
	private $errormsg = '';
    public function index() {
		$user = Ebh::app()->user->getloginuser();
		if(!empty($user)) {
			$roominfo = Ebh::app()->room->getcurroom();
			if(empty($roominfo)) {
				header("Location: http://www.ebanhui.com/");
				exit();
			}
			$this->second();
		} else {	//必须先登录才能进行充值等操作
			$url = geturl('login') . '?returnurl=' . geturl('classactive');
            header("Location: $url");
            exit();
		}
		
    }
	/**
	*开通第一步，未登录时需要处理登录信息
	*/
	private function first() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
        $this->assign('user', $user);
		$this->display('common/classactive');
	}
	/**
	*开通第二步，登录后的界面处理
	*/
	private function second() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
        $this->assign('user', $user);
		$this->display('common/classactive_second');
	}
	/**
	*充值或开通成功后显示页面
	*/
	public function success() {
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->display('common/classactive_success');
	}
	/**
	*年卡激活处理
	*/
	public function cardactive() {
		$cardnumber = $this->input->post('cardnumber');
		$cardpass = $this->input->post('cardpass');
		//验证年卡信息
		if(empty($cardnumber) || empty($cardpass)) {
			echo '卡号或密码不能为空';
			exit();
		}
		$cardmodel = $this->model('Yearcard');
		$card = $cardmodel->getYearcardByCardnumber($cardnumber);
		if(empty($card) || $card['cardpass'] != $cardpass) {
			echo '年卡信息有误，请重新输入';
			exit();
		}
		if($card['status'] == 1) {
			echo '年卡已失效，请重新输入';
			exit();
		}
		//年卡信息正确，则进行年卡充值操作
		/*
		1，判断用户是否已经在此平台，如果在，则进入步骤2 否则进入步骤3
		2，进行充值操作
		3，进行开通操作
		4，添加开通记录
		*/
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		//获取用户是否在此平台
		$rumodel = $this->model('Roomuser');
		$ruser = $rumodel->getroomuserdetail($roominfo['crid'],$user['uid']);
		$cardmonth = $card['time'];	//年卡的服务周期，一般为12个月
		$type = 0;
		if(empty($ruser)) {	//不存在 
			$enddate = strtotime("+$cardmonth month");
			$param = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'begindate'=>SYSTIME,'enddate'=>$enddate,'cnname'=>$user['realname'],'sex'=>$user['sex']);
			$result = $rumodel->insert($param);
			$type = 1;
			if($result !== FALSE) {
				if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {	//如果是收费学校，则会将账号默认添加到学校的第一个班级中
					$this->setmyclass($roominfo['crid'],$user['uid']);
				} else {
					//更新教室学生数
					$roommodel = $this->model('Classroom');
					$roommodel->addstunum($roominfo['crid']);
				}
			}
		} else {	//已存在
			if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7){
				$this->setmyclass($roominfo['crid'],$user['uid']);//防止中途改变学校类型,导致学生在学校里面但是不在班级里面(网校改成学校) zkq 2014.07.22
			}
			$enddate=$ruser['enddate'];
			$newenddate=0;
			if(SYSTIME>$enddate){//已过期的处理
				$newenddate=strtotime("+$cardmonth month");
			}else{	//未过期，则直接在结束时间后加上此时间
				$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$cardmonth month");
			}

			$param = array('crid'=>$roominfo['crid'],'uid'=>$user['uid'],'enddate'=>$newenddate,'cstatus'=>1);
			$result = $rumodel->update($param);
			$type = 2;
		}
		//用户平台信息更新成功则生成记录并更新年卡信息
		if($result !== FALSE) {
			$cardparam = array('cardid'=>$card['cardid'],'status'=>1);
			$cardmodel->update($cardparam);	//更新年卡信息，为已激活
			$openmodel = $this->model('Opencount');
			$openparam = array('uid'=>$user['uid'],'username'=>$user['username'],'realname'=>$user['realname'],'sex'=>$user['sex'],
				'type'=>$type,'paytime'=>SYSTIME,'addtime'=>$cardmonth,'status'=>1,'ip'=>$this->input->getip(),'crid'=>$roominfo['crid'],'payfrom'=>1,'ordernumber'=>$cardnumber);
			$openmodel->insert($openparam);
			echo 'success';
		} else {	//更新失败
			echo '开通失败，请联系系统管理员';
		}
	}
	/**
	*选择支付宝充值操作
	*/
	public function alipay() {
		$roominfo = Ebh::app()->room->getcurroom();
		$total_fee = $this->input->post('total_fee');
		$month = $this->input->post('month');
		$pay_fee = $this->input->post('total_fee');
		if(!is_numeric($pay_fee))
			$pay_fee = 0;
		$month = intval($month);
		$total_fee = $roominfo['crprice'];
		if($month/12*$total_fee == $pay_fee) {
			$total_fee = $pay_fee;
		}

		$user = Ebh::app()->user->getloginuser();
		
		
		$type = 0;	//支付返回时候再更新此值 
		
		
		//生成订单信息
		$openmodel = $this->model('Opencount');
		$openparam = array('uid'=>$user['uid'],'username'=>$user['username'],'realname'=>$user['realname'],'sex'=>$user['sex'],
				'type'=>$type,'money'=>$total_fee,'paytime'=>SYSTIME,'addtime'=>$month,'status'=>0,'ip'=>$this->input->getip(),'crid'=>$roominfo['crid'],'payfrom'=>3);
		$stid = $openmodel->insert($openparam);
		if($stid <= 0) {
			echo 'error';
			exit;
		}
		$notify_url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/alinotify.html';
        //页面跳转同步通知页面路径
        $return_url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/alireturn.html';

        //必填
        //商户订单号
        $out_trade_no = $stid;
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = '开通e板会 '.$roominfo['crname'].' 服务';
        //必填
        //付款金额
        
        //必填
        //订单描述
        $body = $subject;
        //商品展示地址
        $show_url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain;
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
		}
		//商户订单号
		$out_trade_no = $this->input->post('out_trade_no');
		//支付宝交易号
		$trade_no = $this->input->post('trade_no');
		$openmodel = $this->model('Opencount');
		$myopen = $openmodel->getOpenCountByStid($out_trade_no);
		if(empty($myopen)) {//订单不存在
			$alilib->notify(FALSE);
			exit();
		}
		if($myopen['status'] == 1) {//订单已处理，则不重复处理
			$alilib->notify(TRUE);
			exit();
		}
		$crid = $myopen['crid'];
		$username = $myopen['username'];
		$addtime = $myopen['addtime']; 
		$usermodel = $this->model('User');
		$user = $usermodel->getuserbyusername($username);

		$roommodel = $this->model('Classroom');
		$roominfo = $roommodel->getRoomByCrid($crid);
		//获取用户是否在此平台
		$rumodel = $this->model('Roomuser');
		$ruser = $rumodel->getroomuserdetail($crid,$user['uid']);
		$cardmonth = $addtime;	//充值的服务周期，一般为12个月
		$type = 0;
		if(empty($ruser)) {	//不存在 
			$enddate = strtotime("+$cardmonth month");
			$param = array('crid'=>$crid,'uid'=>$user['uid'],'begindate'=>SYSTIME,'enddate'=>$enddate,'cnname'=>$user['realname'],'sex'=>$user['sex']);
			$result = $rumodel->insert($param);
			$type = 1;
			if($result !== FALSE) {
				if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {	//如果是收费学校，则会将账号默认添加到学校的第一个班级中
					$this->setmyclass($crid,$user['uid']);
				} else {
					//更新教室学生数
					
					$roommodel->addstunum($crid);
				}
			}
		} else {	//已存在
			if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7){
				$this->setmyclass($roominfo['crid'],$user['uid']);//防止中途改变学校类型,导致学生在学校里面但是不在班级里面(网校改成学校) zkq 2014.07.22
			}
			$enddate=$ruser['enddate'];
			$newenddate=0;
			if(SYSTIME>$enddate){//已过期的处理
				$newenddate=strtotime("+$cardmonth month");
			}else{	//未过期，则直接在结束时间后加上此时间
				$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$cardmonth month");
			}

			$param = array('crid'=>$crid,'uid'=>$user['uid'],'enddate'=>$newenddate,'cstatus'=>1);
			$result = $rumodel->update($param);
			$type = 2;
		}
		//用户平台信息更新成功则生成记录并更新年卡信息
		if($result !== FALSE) {
			$openmodel = $this->model('Opencount');
			$openparam = array('type'=>$type,'paytime'=>SYSTIME,'addtime'=>$cardmonth,'status'=>1,'ip'=>$this->input->getip(),'crid'=>$crid,'payfrom'=>3,'ordernumber'=>$trade_no);
			$wherearr = array('stid'=>$out_trade_no);
			$openmodel->update($openparam,$wherearr);
			$alilib->notify(TRUE);
		} else {	//更新失败
			$alilib->notify(FALSE);
		}
	}
	/**
	*成功返回页面
	*/
	public function alireturn() {
		$alilib = Ebh::app()->lib('Alipay');
		$get = $this->input->get();
		$_GET = $get;
		$verify_result = $alilib->checknotify();
		$successurl = geturl('classactive/success');
		header("Location: $successurl");
	}
	/**
	*选择快钱支付
	*/
	public function kuaiqian() {
		$pay_fee = $this->input->post('total_fee');
		$month = $this->input->post('month');
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(!is_numeric($pay_fee))
			$pay_fee = 0;
		//付款金额
        $total_fee = $roominfo['crprice'];
		$month = intval($month);
		if($month/12*$total_fee == $pay_fee) {
			$total_fee = $pay_fee;
		}
		
		$type = 0;	//支付返回时候再更新此值 

		//生成订单信息
		$openmodel = $this->model('Opencount');
		$openparam = array('uid'=>$user['uid'],'username'=>$user['username'],'realname'=>$user['realname'],'sex'=>$user['sex'],
				'type'=>$type,'money'=>$total_fee,'paytime'=>SYSTIME,'addtime'=>$month,'status'=>0,'ip'=>$this->input->getip(),'crid'=>$roominfo['crid'],'payfrom'=>2);
		$stid = $openmodel->insert($openparam);
		if($stid <= 0) {
			echo 'error';
			exit;
		}
		$notify_url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/kqnotify.html';
        //页面跳转同步通知页面路径
        $return_url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/kqreturn.html';

        //必填
        //商户订单号
        $out_trade_no = $stid;
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = '开通e板会 '.$roominfo['crname'].' 服务';
        //必填
        
        //必填
        //订单描述
        $body = $subject;
		$payerContact = $user['email'];
        //商品展示地址
        $show_url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain;
		$kqlib = Ebh::app()->lib('Kuaiqian');
		$param = array('notify_url'=>$notify_url,'return_url'=>$return_url,'trade_no'=>$out_trade_no,'subject'=>$subject,'total_fee'=>$total_fee,'body'=>$body,'show_url'=>$show_url,'payerContact'=>$payerContact);
		$param['username'] = $user['username'];
		$param['productId'] = $roominfo['domain'];
		$param['ext1'] = '';
		//提交快钱
		$kqlib->payTo($param);
	}
	/**
	*块钱支付接口通知
	*/
	public function kqnotify() {
		$kqlib = Ebh::app()->lib('Kuaiqian');
		$verify_result = $kqlib->checknotify();
		$roominfo = Ebh::app()->room->getcurroom();
		if($verify_result === FALSE || $verify_result == 11) {
			$url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/success.html?msg=error!';
			return $kqlib->notify(0,$url);
		}
		//商户订单号
		$out_trade_no = $this->input->get('orderId');
		//快钱交易号
		$trade_no = $this->input->get('dealId');
		$openmodel = $this->model('Opencount');
		$myopen = $openmodel->getOpenCountByStid($out_trade_no);
		if(empty($myopen) || $myopen['status'] == 1) {//订单不存在或已处理
			$url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/success.html?msg=error!';
			$kqlib->notify(0,$url);
			exit();
		}
		$crid = $myopen['crid'];
		$username = $myopen['username'];
		$addtime = $myopen['addtime']; 
		$usermodel = $this->model('User');
		$user = $usermodel->getuserbyusername($username);
		
		//获取用户是否在此平台
		$rumodel = $this->model('Roomuser');
		$ruser = $rumodel->getroomuserdetail($crid,$user['uid']);
		$cardmonth = $addtime;	//充值的服务周期，一般为12个月
		$type = 0;
		if(empty($ruser)) {	//不存在 

			$enddate = strtotime("+$cardmonth month");
			$param = array('crid'=>$crid,'uid'=>$user['uid'],'begindate'=>SYSTIME,'enddate'=>$enddate,'cnname'=>$user['realname'],'sex'=>$user['sex']);
			$result = $rumodel->insert($param);
			$type = 1;
			if($result !== FALSE) {
				if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {	//如果是收费学校，则会将账号默认添加到学校的第一个班级中
					$this->setmyclass($roominfo['crid'],$user['uid']);
				} else {
					//更新教室学生数
					$roommodel = $this->model('Classroom');
					$roommodel->addstunum($roominfo['crid']);
				}
			}
		} else {	//已存在
			if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7){
				$this->setmyclass($roominfo['crid'],$user['uid']);//防止中途改变学校类型,导致学生在学校里面但是不在班级里面(网校改成学校) zkq 2014.07.22
			}
			$enddate=$ruser['enddate'];
			$newenddate=0;
			if(SYSTIME>$enddate){//已过期的处理
				$newenddate=strtotime("+$cardmonth month");
			}else{	//未过期，则直接在结束时间后加上此时间
				$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$cardmonth month");
			}

			$param = array('crid'=>$crid,'uid'=>$user['uid'],'enddate'=>$newenddate,'cstatus'=>1);

			$result = $rumodel->update($param);
			$type = 2;
		}
		//用户平台信息更新成功则生成记录并更新年卡信息
		if($result !== FALSE) {
			$openmodel = $this->model('Opencount');
			$openparam = array('type'=>$type,'paytime'=>SYSTIME,'addtime'=>$cardmonth,'status'=>1,'ip'=>$this->input->getip(),'crid'=>$crid,'payfrom'=>2,'ordernumber'=>$trade_no);
			$wherearr = array('stid'=>$out_trade_no);
			$openmodel->update($openparam,$wherearr);
			$url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/success.html';
			$kqlib->notify(1,$url);
			exit();
		} else {	//更新失败
			$url = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/success.html?msg=error!';
			$kqlib->notify(0,$url);
			exit();
		}
	}
	public function kqreturn() {
		
	}
	private function doOrder($orderID) {
		
	}
	/**
	*农行支付请求
	*/
	public function abcpay() {
		$param = $this->doAbcRequest();
		//生成支付请求对象并提交abc服务器
		$Abcpay = Ebh::app()->lib('Abcpay');
		$result = $Abcpay->payTo($param);
	}
	/**
	*农行支付请求
	*/
	public function abcallpay() {
		$payparam = array();
		$param = $this->doAbcRequest(6);
		//生成支付请求对象并提交abc服务器
		$Abcpay = Ebh::app()->lib('Abcpay');
		$result = $Abcpay->payTo($param);
	}
	/**
	*处理消费者农行和农行网银支付请求
	*通过前台消费者提交的充值信息，生成农行需要的接口请求
	*@param int $PaymentType （支付类型）1为农行卡 6为银联跨行支付
	*@return array $param 农行 RequestOrder 参数对象
	*/
	private function doAbcRequest($paymentType = 1) {
		//生成e板会订单
		$roominfo = Ebh::app()->room->getcurroom();
		$total_fee = $this->input->post('total_fee');
		$month = $this->input->post('month');
		$pay_fee = $this->input->post('total_fee');
		if(!is_numeric($pay_fee))
			$pay_fee = 0;
		$month = intval($month);
		$total_fee = $roominfo['crprice'];
		if($month/12*$total_fee == $pay_fee) {
			$total_fee = $pay_fee;
		}

		$user = Ebh::app()->user->getloginuser();
		
		
		$type = 0;	//支付返回时候再更新此值 
		
		
		//生成订单信息
		$payfrom = 6;	//农行直接支付
		if($paymentType == 6)
			$payfrom = 7;	//农行银联支付
		$openmodel = $this->model('Opencount');
		$openparam = array('uid'=>$user['uid'],'username'=>$user['username'],'realname'=>$user['realname'],'sex'=>$user['sex'],
				'type'=>$type,'money'=>$total_fee,'paytime'=>SYSTIME,'addtime'=>$month,'status'=>0,'ip'=>$this->input->getip(),'crid'=>$roominfo['crid'],'payfrom'=>$payfrom);
		$stid = $openmodel->insert($openparam);
		if($stid <= 0) {
			return FALSE;
		}
		//1、取得支付请求所需要的信息
		$tOrderNo = $stid;
		$tExpiredDate = 10;	//订单过期时间 10天
		$tOrderDesc = '开通e板会 '.$roominfo['crname'].' 服务';	//产品描述
		$tOrderDate = date('Y/m/d',SYSTIME);	//订单日期 YYYY/MM/DD
		$tOrderTime = date('H:i:s',SYSTIME);		//订单时间 HH:MM:SS
		$tOrderAmountStr = $total_fee;				//支付金额
		$tOrderURL = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain;			//订单查询地址
		$tBuyIP = $this->input->getip();	//买方ip地址
		
		$tProductType = 1;	//产品类型（必要信息）1：非实体商品 2：实体商品  
		$tPaymentType = $paymentType;	//支付类型（必要信息）1：农行借记卡支付 3：农行贷记卡支付  6: 银联跨行支付
		$tNotifyType = 1;	//设定支付结果通知方式（必要信息，0：URL 页面通知  1：服务器通知）  
		$tResultNotifyURL = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/abcnotify.html';	
														//支付结果地址（必要信息）  
														//注意：  
														//如果支付结果通知方式选择了页面通知，此处填写就是支付结果回传网址；  
														//如果支付结果通知方式选择了服务器通知，此处填写的就是接收支付平台服务器发送响应信息的地址。  
		$tMerchantRemarks = 'e板会';	//商户备注信息 
		$tPaymentLinkType = 1;	//接入方式       （必要信息）1：internet 网络接入 2：手机网络接入 3:数字电视网络接入 4:智能客户端   
		//生成支付请求对象并提交abc服务器
		$param = array('OrderNo'=>$tOrderNo,'ExpiredDate'=>$tExpiredDate,'OrderDesc'=>$tOrderDesc,'OrderDate'=>$tOrderDate,'OrderTime'=>$tOrderTime,'OrderAmountStr'=>$tOrderAmountStr,'OrderURL'=>$tOrderURL,'BuyIP'=>$tBuyIP,'ProductType'=>$tProductType,'PaymentType'=>$tPaymentType,'NotifyType'=>$tNotifyType,'ResultNotifyURL'=>$tResultNotifyURL,'MerchantRemarks'=>$tMerchantRemarks,'PaymentLinkType'=>$tPaymentLinkType);
		return $param;
	}
	/**
	*农行支付请求结果响应
	*/
	public function abcnotify() {
		$abclib = Ebh::app()->lib('Abcpay');
		$verify_result = $abclib->getnotify();
		$roominfo = Ebh::app()->room->getcurroom();
		$successurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/success.html';	
		$failurl = 'http://'.$roominfo['domain'].'.'.$this->uri->curdomain.'/classactive/fail.html';	
		if(empty($verify_result)) {	//支付失败
			
			$abclib->notify($failurl);
		}
		//商户订单号
		$out_trade_no = $verify_result['OrderNo'];
		//农行交易号
		$trade_no = $verify_result['VoucherNo'];
		if(empty($trade_no)) {
			$trade_no = $out_trade_no;
		}
		$openmodel = $this->model('Opencount');
		$myopen = $openmodel->getOpenCountByStid($out_trade_no);
		if(empty($myopen)) {//订单不存在
			$abclib->notify($failurl);
			exit();
		}
		if($myopen['status'] == 1) {//订单已处理，则不重复处理
			$abclib->notify($successurl);
			exit();
		}
		$crid = $myopen['crid'];
		$username = $myopen['username'];
		$addtime = $myopen['addtime']; 
		$usermodel = $this->model('User');
		$user = $usermodel->getuserbyusername($username);

		$roommodel = $this->model('Classroom');
		//$roominfo = $roommodel->getRoomByCrid($crid);
		//获取用户是否在此平台
		$rumodel = $this->model('Roomuser');
		$ruser = $rumodel->getroomuserdetail($crid,$user['uid']);
		$cardmonth = $addtime;	//充值的服务周期，一般为12个月
		$type = 0;
		if(empty($ruser)) {	//不存在 
			$enddate = strtotime("+$cardmonth month");
			$param = array('crid'=>$crid,'uid'=>$user['uid'],'begindate'=>SYSTIME,'enddate'=>$enddate,'cnname'=>$user['realname'],'sex'=>$user['sex']);
			$result = $rumodel->insert($param);
			$type = 1;
			if($result !== FALSE) {
				if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7) {	//如果是收费学校，则会将账号默认添加到学校的第一个班级中
					$this->setmyclass($crid,$user['uid']);
				} else {
					//更新教室学生数
					
					$roommodel->addstunum($crid);
				}
			}
		} else {	//已存在
			if($roominfo['isschool'] == 6 || $roominfo['isschool'] == 7){
				$this->setmyclass($roominfo['crid'],$user['uid']);//防止中途改变学校类型,导致学生在学校里面但是不在班级里面(网校改成学校) zkq 2014.07.22
			}
			$enddate=$ruser['enddate'];
			$newenddate=0;
			if(SYSTIME>$enddate){//已过期的处理
				$newenddate=strtotime("+$cardmonth month");
			}else{	//未过期，则直接在结束时间后加上此时间
				$newenddate=strtotime( date('Y-m-d H:i:s',$enddate)." +$cardmonth month");
			}

			$param = array('crid'=>$crid,'uid'=>$user['uid'],'enddate'=>$newenddate,'cstatus'=>1);
			$result = $rumodel->update($param);
			$type = 2;
		}
		//用户平台信息更新成功则生成记录并更新年卡信息
		if($result !== FALSE) {
			$openmodel = $this->model('Opencount');
			$openparam = array('type'=>$type,'paytime'=>SYSTIME,'addtime'=>$cardmonth,'status'=>1,'ip'=>$this->input->getip(),'crid'=>$crid,'ordernumber'=>$trade_no);
			$wherearr = array('stid'=>$out_trade_no);
			$openmodel->update($openparam,$wherearr);
			$abclib->notify($successurl);
		} else {	//更新失败
			$abclib->notify($failurl);
		}
	}
	/**
	*设置用户的默认班级信息
	* 一般为收费学校用户开通学校服务时候处理，需要将学生加入到默认的班级中
	* 如果不存在新班级，则需要创建一个默认班级
	*/
	private function setmyclass($crid,$uid) {
		$classmodel = $this->model('Classes');
		//先判断是否已经加入班级，已经加入则无需重新加入
		$myclass = $classmodel->getClassByUid($crid,$uid);
		if(empty($myclass)) {
			$classid = 0;
			$defaultclass = $classmodel->getDefaultClass($crid);
			if(empty($defaultclass)) {	//不存在默认班级，则创建默认班级
				$param = array('crid'=>$crid,'classname'=>'默认班级');
				$classid = $classmodel->addclass($param);
			} else {
				$classid = $defaultclass['classid'];
			}
			$param = array('crid'=>$crid,'classid'=>$classid,'uid'=>$uid);
			$classmodel->addclassstudent($param);
		}
	}
	/**
	 *以下几个方法为表单数据验证方法 
	 */
	public function check_fee(){
		$fee = $this->input->post('fee');
		if(!is_numeric($fee)){
			$this->_ret_msg(-1,'汇款金额不对');
		}else{
			$this->_ret_msg(0);
		}
	}
	public function check_contact(){
		$contact = $this->input->post('contact');
		if(empty($contact)){
			$this->_ret_msg(-1,'联系方式不能为空');
		}else{
			$this->_ret_msg(0);
		}
	}
	public function check_billfield(){
		$billfield = $this->input->post('billfield');
		if(empty($billfield)){
			$this->_ret_msg(-1,'没有上传汇款单');
		}else{
			$this->_ret_msg(0);
		}
	}
	public function check_product(){
		$product = trim($this->input->post('productstr'));
		if(empty($product)){
			$this->_ret_msg(-1,'没有选择任何课程');
		}else{
			$this->_ret_msg(0);
		}
	}
	public function check_remark(){
		$this->_ret_msg(0);
	}
	public function bank() {	
		/*暂时去掉，改为人工审核的方式
		if($room['domain'] == 'yxwl') {	//如果是易学，则用易学模板
			$this->display('common/classactive_bank_yx');
		} else if($room['domain'] == 'gdlzzx') {
			$this->display('common/classactive_bank_gd');
		}else {
			$this->display('common/classactive_bank');
		}
		*/
		//获取网校转账信息
		$roominfo = Ebh::app()->room->getcurroom();	
		$user = Ebh::app()->user->getloginuser();
		if(empty($user)){
			$url = geturl('login') . '?returnurl=' . geturl('classactive/bank');
			header("Location: $url");
			exit;
		}
		$classroom = $this->model('classroom');
		$transferarr = $classroom->getcustommessage(array('crid'=>$roominfo['crid'],'index'=>'\'t1\''));
		$package = $this->fetchpaypackage();
		$transferinfo = !empty($transferarr[0]['custommessage']) ? $transferarr[0]['custommessage'] : $this->getdeftransfer();
		//汇款单上传路径
		$_UP = Ebh::app()->getConfig()->load('upconfig');
		$this->assign('user', $user);
		$this->assign('roominfo',$roominfo);
		$this->assign('transferinfo',$transferinfo);
		$this->assign('package',$package);
		$this->assign('upurl',$_UP['bill']['upurl']);
		$this->display('common/classactive_man');
	}
	//处理汇款单
	public function doaddorder(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		if(empty($user)){
			echo json_encode(array('status'=>false,code=>-1,'msg'=>'您还没有登录，请登录后重试'));
			exit;
		}
		//后台数据校验
		$result = $this->check_submit();
		if(!$result){
			echo json_encode(array('status'=>false,'msg'=>'参数错误'));
			exit;
		}
		$billimg = $this->input->post('billfield'); //汇款单底图
		$fee = $this->input->post('fee'); //汇款金额
		$contact = $this->input->post('contact'); //联系方式
		$remark = $this->input->post('remark'); //其他说明
		$itemids = $this->input->post('productstr'); //服务项id
		$itemarr = explode(',',$itemids);
		$state = true;
		//入库
		$OrdercashModel = $this->model('Ordercash'); 
		$param['uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$param['contact'] = trim($contact);
		$param['remark'] = trim($remark);
		$param['itemids'] = trim($itemids);
		$param['imgpath'] = trim($billimg);
		$param['remit'] = $fee;
		$param['ip'] = getip();
		$param['dateline'] = SYSTIME;
		$result = $OrdercashModel->add($param);
		echo json_encode(array('status'=>$result > 0 ? true : false));
	}
	//汇款单提交成功后回显页
	public function aosuccess(){
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('roominfo',$roominfo);
		$this->assign('user',$user);
		$this->display('common/orderadd_success');
	}
	
	//获取服务包选择形式的数据
	public function getselpaypackage(){
		$fcate = intval($this->input->post('fcate'));
		$scate = intval($this->input->post('scate'));
		$type = intval($this->input->post('type'));
		$jsonarr = array();
		if($fcate <=0){
			echo 'error...';exit;
		}
		$package = $this->fetchpaypackage();
		$data = $package[$fcate];
		
		if($type == 0){
			if(count($data['itemlist']) == 1){
				$jsonarr[0]['sid'] = 0;
				$jsonarr[0]['tit'] = '所有课程';
			}else{
				$inarr = array();
				foreach ($data['itemlist'] as $key=>$item){
					if(in_array($item['sid'], $inarr)){
						continue;
					}
					$inarr[] = $item['sid'];
					if($item['sid'] >0){
						$tmparr['sid'] = $item['sid'];
						$tmparr['tit'] = $item['sname'];
						$jsonarr[] = $tmparr;
					}else{
						$tmparr['sid'] = 0;
						$tmparr['tit'] = '其他课程';
						$jsonarr[] = $tmparr;
					}
				}
			}
		}else{
			foreach ($data['itemlist'] as $key=>$item){
				if($item['sid'] == $scate){
					$date = $item['imonth'] > 0 ? $item['imonth'].'个月' : $item['iday'].'天';
					$tmparr['itemid'] = $item['itemid'];
					$tmparr['iname'] = $item['iname'];
					$tmparr['data'] = $tmparr['itemid'].'###'.$item['iname'].'###'.$date.'###'.$item['iprice'];
					$jsonarr[] = $tmparr;
				}
			}
		}
		echo json_encode($jsonarr);
	}
    //获取默认转账信息
    private function getdeftransfer(){
        $str = '<p class="dfassrt sead"><img style="vertical-align:middle;" src="http://static.ebanhui.com/ebh/images/abcicon.jpg"> 账号：1901 7801 0400 07975</p>';
        $str .= '<p class="etwyht">账户名：浙江新盛蓝科技有限公司</p>';
        $str .= '<p class="etwyht">开户行：农业银行杭州市艮山支行</p>';
        $str .= '<p class="rtygew">转账成功后，请及时将您的<span class="chste">网校登录账号，姓名，要开通的课程</span>';
        $str .=	'通过短信<br>发送至<span class="lstbe">手机</span>';
        $str .=	'<span class="sead">13957170417</span> 或 <span class="sead">13757168928</span>，也可以直接联系以上电话。<br></p>';
        $str .= '<p class="rtygew">为了使您的开通更顺畅，网校除缴费以外问题请咨询告家长书中所留老师的联系电话，<br>此处号码仅供网银转账确认使用。</p>';
        return $str;
    }
	//获取网校服务包
	private function fetchpaypackage(){
		$room = Ebh::app()->room->getcurroom();
		//获取服务包
		$spmodel = $this->model('PayPackage');
		$thelist = $spmodel->getsplist(array('crid'=>$room['crid'],'status'=>1,'displayorder'=>'displayorder asc,pid desc','limit'=>1000));
		$splist = array();
		$spidlist = '';
		//将结果数组以pid为下标排列,并记录pid合集字符串
		foreach($thelist as $mysp) {
			$splist[$mysp['pid']] = $mysp;
			$splist[$mysp['pid']]['itemlist'] = array();
			if(empty($spidlist)) {
				$spidlist = $mysp['pid'];
			} else {
				$spidlist .= ','.$mysp['pid'];
			}
		}
		//根据pid合集获取服务项
		if(!empty($spidlist)) {
			$pitemmodel = $this->model('PayItem');
			$power = '0';
			$itemparam = array('limit'=>100,'pidlist'=>$spidlist,'displayorder'=>'s.sdisplayorder is null,sdisplayorder,i.pid,f.displayorder','power'=>$power);
			$itemlist = $pitemmodel->getItemFolderList($itemparam);
			if(!empty($itemlist)) {
				foreach($itemlist as $myitem) {
					if($myitem['ishide'] == 1) {	//如果分类设置隐藏则不显示
						continue;
					}
					if(isset($splist[$myitem['pid']])) {
						$splist[$myitem['pid']]['itemlist'][] = $myitem;
					}
				}
			}
		}
		return $splist;
	}
	//逐项校验数据项
	private function check_submit(){
		$this->inner_check = true;
		$this->check_billfield();
		if($this->errorno == -1){
			return false;
		}
		$this->check_fee();
		if($this->errorno == -1){
			return false;
		}
		$this->check_contact();
		if($this->errorno == -1){
			return false;
		}
		$this->check_remark();
		if($this->errorno == -1){
			return false;
		}
		$this->check_product();
		if($this->errorno == -1){
			return false;
		}
		return true;
	}
	
	//信息反馈
	private function _ret_msg($status,$msg = '',$attr = array()){
		if($this->inner_check == true){
			$this->errorno = $status;
			$this->errormsg = $msg;
		}else{
			echo json_encode(array(
					'status'=>$status,
					'msg'=>$msg,
					'attr'=>$attr
			));
			exit;
		}
	}
}
?>
