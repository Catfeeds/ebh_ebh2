<?php
class LotteryController extends CControl{
	public function index(){

		//获取用户信息
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);

		//获取抽奖信息列表,用于滚动显示用户中奖信息
		$creditModel = $this->model('credit');
		$lotterylogs = $creditModel->getLotteryLogs();
		$lotterylogs = $this->_formatProducts($lotterylogs);
		$this->assign('lotterylogs',$lotterylogs);

		//获取积分兑换的产品列表
        $productmodel = $this->model('product');
		$param = array('status'=>0,'limit'=>'0,24','order'=>'p.displayorder asc,p.productid desc');
		$productchachekey = $this->cache->getcachekey('product',$param);
		$productList = $this->cache->get($productchachekey);
		if(empty($productList)) {
			$productList = $productmodel->getList($param);
			$this->cache->set($productchachekey,$productList,86400);
		}
		$this->title = "e板会-开启云教学互动时代-积分抽奖";
        $this->assign('productList', $productList);
		$this->display('portal/lottery');
	}

	/**
	 *兑换界面
	 */
	public function exchange_view(){
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
		$productid = intval($this->uri->itemid);
		if(empty($productid)){
			show_404();exit();
		}

		$productModel = $this->model('product');
		$product = $productModel->getOneByProductID($productid);
		if( empty($product) || ($product['status']!=0)){
			show_404();exit();
		}
		$roominfo = Ebh::app()->room->getcurroom();
		$this->assign('room', $roominfo);
		$user = Ebh::app()->user->getloginuser();
        $this->assign('user', $user);
	   
		$crid = $product['crid'];
		$classroommodel = $this->model('classroom');
		$roomvalue = $classroommodel->getclassroomdetail($crid);
        $this->assign('roomvalue', $roomvalue);	
		$this->assign('product',$product);
		$this->title = "e板会-开启云教学互动时代-积分兑换";
		$this->display('portal/lottery_exchange');
	}
	/**
	 *生成抽奖记录
	 */
	public function dox(){

		//设置从主数据库读取,防止主从服务器来不及同步的问题
		Ebh::app()->getDb()->set_con(0);

		$user = Ebh::app()->user->getloginuser();
		if( empty($user)  ){
			echo "-1";exit;//用户没有登录
		}
		if($user['credit'] < 20){
			echo "-3";exit;
		}

		
		$creditModel = $this->model('credit');
		//判断用户抽奖次数是否上限
		$count = $creditModel->getTodayLogsCount($user['uid']);
		$ruleInfo = $creditModel->getCreditRuleInfo(16);
		$maxaction = $ruleInfo['maxaction'];
		if($maxaction<=$count){
			echo "0";exit;//没有抽奖次数
		}

		$productid = "404";//默认不中奖

		$a = mt_rand(0,10000000) == mt_rand(0,10000000);//千万分之一
		$b = mt_rand(0,5000000) == mt_rand(0,5000000);//五百万分之一
		$c = mt_rand(0,2000000) == mt_rand(0,2000000);//二百万分之一
		$d = mt_rand(0,1000000) == mt_rand(0,1000000);//一百万分之一
		$e = mt_rand(0,500000) == mt_rand(0,500000);//五十万分之一
		$f = mt_rand(0,100000) ==  mt_rand(0,100000);//十万分之一
		$g = mt_rand(0,50) == mt_rand(0,50);//五十分之一
		$h = mt_rand(0,10) == mt_rand(0,10);//十分之一
		$i = mt_rand(0,100) == mt_rand(0,100);//百分之一
		if($a){
			$productid = "5";//微课大师
		}else if($b){
			$productid = "3";//ipad air
		}else if($c){
			$productid = "6";//xbox
		}else if($d){
			$productid = "8";//500充值卡
		}else if($e){
			$productid = "4";//手绘板
		}else if($f){
			$productid = "7";//100充值卡
		}else if($g){
			$productid = "1";//二十积分
		}else if($h){
			$productid = "2";//十积分
		}else if($i){
			$productid = "-2";//再来一次
		}
		//数据库写数据
		$param = array(
			'ruleid'=>16,
			'productid'=>intval($productid),
			'credit'=>20,
			'nocheck'=>true
		);
		if($productid=="-2"){
			$param['credit'] = 0;
		}
		//写入抽奖记录
		$res = $creditModel->addCreditlog($param);
		
		//如果用户抽中积分直接将积分打入账户
		if($productid === "2"){//十积分
			$creditModel->addCreditlog(17);
		}elseif($productid === "1"){//二十积分
			$creditModel->addCreditlog(18);
		}

		
		if(empty($res)){
			$productid = "-4";//数据库错误
		}
		$userinfo = $this->model('user')->getuserbyuid($user['uid']);
		$currCredit = $userinfo['credit'];
		$result = array($productid,$currCredit);
		echo json_encode($result);
	}

	private function _formatProducts($param = array()){
		$returnArr = array();
		$_map = array(
			'1'=>'20积分，表示很高兴！',
			'2'=>'10积分，表示很高兴！',
			'3'=>'iPad Air一台，表示很激动！',
			'4'=>'手绘板一台，表示十分激动！',
			'5'=>'微课大师软件一份，表示很激动！',
			'6'=>'Xbox游戏机一套，表示很很喜欢！',
			'7'=>'100元充值卡一张，表示很高兴！',
			'8'=>'500元充值卡一张，表示非常高兴！'
		);
		foreach ($param as $product) {
			array_key_exists($product['productid'],$_map) && ($product['productname'] = $_map[$product['productid']]) && ($returnArr[] = $product);
		}
		return $returnArr;
	}

	function get_keywords(){
		return parent::get_description();
	}
	function get_title(){
		return $this->title;
	}
	function get_description(){
		return parent::get_description();
	}
}