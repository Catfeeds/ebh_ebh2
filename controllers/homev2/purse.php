<?php
/**
 * 钱包管理
 * @author eker
 * 2016年3月1日14:16:54
 */
class PurseController extends CControl {
	private $user = null;
	public function __construct(){
		parent::__construct();
		$this->user = Ebh::app()->user->getloginuser();
		Ebh::app()->user->checkUserLogin($this->user ,true);
		$this->assign('user',$this->user);
		$this->getassigintop();
	}
	
	/**
	 * 账户余额
	 */
	public function index(){
		$user = $this->user;
		//获取优惠码
		$couponsModel = $this->model('Coupons');
		$cashbackModel = $this->model('Cashback');
		$coupon = $couponsModel->getOne(array('uid'=>$user['uid']));
		
		//如果是老师 默认创建优惠码
		if(($user['groupid']==5)&&empty($coupon)){
			$coupon = $this->create($user);
		}
		//获取网校
		if (!empty($coupon)){
			if(!empty($coupon['crid'])){
				$roominfo = $this->model('classroom')->getclassroomdetail($coupon['crid']);
				$coupon['crname'] = !empty($roominfo) ? $roominfo['crname'] : 'e板会';
			}else{
				$coupon['crname'] = 'e板会';
			}
		}
		//获取未入账金额
		$unaccount = $cashbackModel->getCashbackreward(array('uid'=>$user['uid'],'status'=>0));
		$this->assign('unaccount',$unaccount);
		$this->assign('coupon',$coupon);
		$this->display('homev2/purse_blance');
	}
	
	
	/*****************************优惠券生成 @eker**************************************************/
	/**
	 * 生成优惠码
	 * @param unknown $user
	 */
	private function create($user){
		$couponarr = array();
		$couponarr['uid'] = $user['uid'];
		$couponarr['code'] = $this->getcouponcode();
		$couponarr['createtime'] = SYSTIME;
		$couponarr['fromtype'] = 1;
		$couponsModel = $this->model('Coupons');
		$myret = $couponsModel->add($couponarr);
		if(!empty($myret)){
			return 	$couponarr;
		}else{
			return false;
		}
	}
	
	//生成优惠码
	private function getcouponcode(){
		$couponcode = $this->generatestr();
		//检测是否重复
		$model = $this->model('Coupons');
		$ck = $model->checkcoupon($couponcode);
		if($ck){
			$couponcode = $this->getcouponcode();
		}
		return $couponcode;
	}
	/**
	 * 生成随机数
	 * @param number $length
	 * @return string
	 */
	private function generatestr( $length = 6 ){
		// 密码字符集，可任意添加你需要的字符
		$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$password = '';
		for ( $i = 0; $i < $length; $i++ )
		{
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		return $password;
	}
	/***************************优惠券生成 @eker****************************************************/
	/**
	 * 用户提现
	 */
	public function applycash(){
		$user = $this->user;
		$bdmodel = $this->model("Bind");
		$tmpbank = $bdmodel->getUserBankInfo($user['uid']);
		$bankarr = empty($tmpbank['bank_str']) ? array() : json_decode($tmpbank['bank_str'],true);
		$_bank = Ebh::app()->getConfig()->load('bank');
		$this->assign('bank',$_bank);
		$this->assign('user',$user);
		$this->assign('mybank',$bankarr['bank']);
		$this->display('homev2/purse_applycash');
	}
	/**
	 * 提现第二步
	 */
	public function second(){
		$zftype = intval($this->input->get('zftype'));
		$money = trim($this->input->get('money'));
		$user = $this->user;
		//检验参数
		if(!(is_numeric($money) && $money >0)){
			echo 'param error...';
			exit;
		}
		if($zftype<=0 || $zftype >11 || $money>$user['balance']){
			echo 'param error...';
			exit;
		}
		$tmparr = explode('.', $money);
		if(count($tmparr) == 2 && strlen($tmparr[1]) > 2){
			echo 'param error...';
			exit;
		}
		if($money > 50000){
			echo 'param error...';
			exit;
		}
		//提现金额校验
		$hfee = $money >= 10000 ? 5 : 1;
		if($money + $hfee > $user['balance']){
			echo 'max money you can apply is '.($user['balance'] - $hfee);
			exit;
		}
		$bdmodel = $this->model("Bind");
		$tmpbank = $bdmodel->getUserBankInfo($user['uid']);
		$bankarr = empty($tmpbank['bank_str']) ? array() : json_decode($tmpbank['bank_str'],true);
		$_bank = Ebh::app()->getConfig()->load('bank');
		$this->assign('bank',$_bank);
		$this->assign('user',$user);
		$this->assign('mybank',$bankarr['bank']);
		$this->assign('zftype', $zftype);
		$this->assign('money',$money);
		if($zftype == 11){
			$this->display('homev2/purse_applyzfbsecond');
		}else{
			$this->display('homev2/purse_applybanksecond');
		}
	}
	/**
	 * 第三步提现处理
	 */
	public function doapplycash(){
		$zftype = intval($this->input->post('zftype'));
		$money = $this->input->post('money');
		$recaccount = trim($this->input->post('recaccount'));
		$recname = trim($this->input->post('recname'));
		$beizhu = trim($this->input->post('beizhu'));
		$recbank = '';
		$user = $this->user;
		//检验参数
		if(!(is_numeric($money) && $money >0)){
			echo json_encode(array('code'=>-1));
			exit;
		}
		if($zftype<=0 || $zftype >11 || $money>$user['balance'] || $money<=0 || $user['balance']<1){
			echo json_encode(array('code'=>-1));
			exit;
		}
		$tmparr = explode('.', $money);
		if(count($tmparr) == 2 && strlen($tmparr[1]) > 2){
			echo json_encode(array('code'=>-1));
			exit;
		}
		if($money > 50000){
			echo 'param error...';
			exit;
		}
		//提现金额校验
		$hfee = $money >= 10000 ? 5 : 1;
		if($money + $hfee > $user['balance']){
			echo json_encode(array('code'=>-5));
			exit;
		}
		//不是支付宝从绑定的银行卡中解析出相关信息
		if($zftype != 11){
			$bindModel = $this->model('bind');	
			$tmparr = $bindModel->getUserBankInfo($user['uid']);
			if(empty($tmparr['is_bank'])){
				echo json_encode(array('code'=>-2));
				exit;
			}
			$_bank = Ebh::app()->getConfig()->load('bank');
			$bankarr = json_decode($tmparr['bank_str'],true);
			foreach ($bankarr['bank'] as $mybank){
				if($mybank['bindex'] == $zftype){
					$bankinfo = $mybank;
					break;
				}
			}
			if(empty($bankinfo)){
				echo json_encode(array('code'=>-3));
				exit;
			}
			$recname = $bankinfo['khname'];
			$recaccount = $bankinfo['account'];
			$recbank = $_bank[$zftype]['name'];
		}
		Ebh::app()->getDb()->set_con(0);
		//入库
		$param['uid'] = $user['uid'];
		$param['username'] = $user['username'];
		$param['realname'] = $user['realname'];
		$param['dateline'] = SYSTIME;
		$param['fromip'] =  $this->input->getip();
		$param['applytype'] = $zftype == 11 ? 1 : 0;
		$param['recbank'] = $recbank;
		$param['recaccount'] = $recaccount;
		$param['recname'] = $recname;
		$param['desc'] = $beizhu;
		$param['recbprovince'] = '';
		$param['recbcity'] = '';
		$param['recsubbank'] = '';
		$param['applyvalue'] = $money;
		$param['paystatus'] = 0;
		$param['curvalue'] = $user['balance'] - $money - $hfee;
		$param['hfee'] = $hfee;
		$cashrecordsModel = $this->model('cashrecords');
		$result = $cashrecordsModel->applayCash($param);
		echo json_encode(array('code'=>$result ? 0 : -1));
		fastcgi_finish_request();
		if($result){//提现处理成功，进行发送短信和邮件进行提醒
			//发送短信处理
			$sms = Ebh::app()->lib('SMS');
			$roominfo = Ebh::app()->room->getcurroom();
			$config = Ebh::app()->getConfig()->load('othersetting');
			$applycash_sms = $config['applycash']['mobile'];
			$applycash_email = $config['applycash']['email'];
			if(!empty($user['realname'])){
				$name = $roominfo['crname'].'-'.$user['uid'].'-'.$user['realname'];
			}else{
				$name = $roominfo['crname'].'-'.$user['uid'].'-'.$user['username'];
			}
			//发送的姓名内容
			$info = array(
						'name' => $name,
						'time' => date('Y-m-d H:i:s',SYSTIME),
						'money' => $money.' 元'
						);
			if(!empty($applycash_sms)){
				foreach ($applycash_sms as $mobile) {
					$sms->send_applycash($mobile,$info);
					sleep(1);
				}
			}
			//发送邮件处理
			$emailLib = Ebh::app()->lib('EBHMailer');
			$email_message = $name.' 申请提现，请尽快处理！提现金额'.$money.' 元';
			foreach ($applycash_email as $email) {
				$toarr = array('email' => $email);
				$emailLib->sendMessage($toarr,'提现申请',$email_message);
				sleep(1);
			}
		}
	}
	/**
	 * 校验支付密码
	 */
	public function checkpaypwd(){
		$user = $this->user;
		$bdmodel = $this->model("Bind");
		$zfpasswd = $this->input->post('zfpasswd');
		$ret = $bdmodel->checkoldpaypwd($zfpasswd,$user['uid']);
		echo json_encode(array('code'=>$ret ? 0 : -1));
	}
	/**
	 * 提现处理成功后显示
	 */
	public function applysuccess(){
		$this->display('homev2/purse_applysuccess');	
	}
	/**
	 * 绑定银行卡
	 */
	public function bindbank(){
		$_bank = Ebh::app()->getConfig()->load('bank');
		$header = getallheaders();
		if(isset($header['Referer'])){
			$referer = $header['Referer'];
			$tmparr = parse_url($referer);
		}
		$refererurl = !empty($tmparr) ? $tmparr['path'] : '';
		$isbank = preg_match('/bank/', $refererurl);
		$this->assign('isbank', $isbank);	//是否从我的银行卡跳转过来标识
		$this->assign('bank',$_bank);
		$this->display('homev2/purse_bindbank');	
	}
	/**
	 * 我的银行卡
	 */
	public function bank(){
		$user = $this->user;
		$bdmodel = $this->model("Bind");
		$tmpbank = $bdmodel->getUserBankInfo($user['uid']);
		$bankarr = empty($tmpbank['bank_str']) ? array() : json_decode($tmpbank['bank_str'],true);
		$mybank = !empty($bankarr['bank']) ? $bankarr['bank'] : '';
		$_bank = Ebh::app()->getConfig()->load('bank');
		$this->assign('bank',$_bank);
		$this->assign('mybank',$mybank);
		$this->display('homev2/purse_bank');
	}
	
	/**
	 * 奖励记录
	 */
	public function reward(){
		$cashbackModel = $this->model('Cashback');
		$param = parsequery();
		$param['pagesize'] = 20;
		$param['uid'] = $this->user['uid'];
		$param['limit'] = max(0,($param['page'] - 1) * $param['pagesize']).', '.$param['pagesize'];
		$list = $cashbackModel->getCashbackList($param);
		$count = $cashbackModel->getCashbackcount($param);
		$totalreward = $cashbackModel->getCashbackreward(array('uid'=>$this->user['uid']));
		$pagebar = show_page($count,$param['pagesize']);
		$this->assign('totalreward',$totalreward);
		$this->assign('list',$list);
		$this->assign('pagebar',$pagebar);
		$this->display('homev2/purse_reward');
	}

	/**
	 * 充值记录
	 */
	public function charge(){
		$get = $this->input->get();
		if (isset($get['type'])) {
			$rdmodel = $this->model("Record");
			$param['page'] = intval($get['page']);
			$param['pagesize'] = intval($get['pagesize']);
			$share = !empty($get['share'])?intval($get['share']):0;
			if ($share) {
				$param['type'] = 12;
				$param['buyer_info'] = intval($get['type']);
			} else {
				$param['type'] = intval($get['type']);
			}
			$param['uid'] = $this->user['uid'];
			$param['status'] = 1;//有效
			$param['cate'] = 1;	//充值
			$param['limit'] = max(0,($param['page']-1)*$param['pagesize'])." , ".$param['pagesize'];
			$list = $rdmodel->getRecordChargeList($param);
			$count = $rdmodel->getRecordChargeCount($param);
			$res['count'] = $count;
			$res['list'] = $list;
			echo json_encode($res);
		} else {
			$share = intval($this->input->get('share'));
			$this->assign('share',$share);
			$this->display('homev2/purse_charge');
		}
	}

	/**
	 * 支付记录
	 */
	public function payment(){
		$get = $this->input->get();
		if (isset($get['type'])) {
			$rdmodel = $this->model("Paytorder");
			$param['page'] = intval($get['page']);
			$param['pagesize'] = intval($get['pagesize']);
			if ($get['type']) {
				$param['payfrom'] = intval($get['type']);
			}
			$param['uid'] = $this->user['uid'];
			$param['ptype'] = 1;
			$param['limit'] = max(0,($param['page']-1)*$param['pagesize'])." , ".$param['pagesize'];
			$list = $rdmodel->getOrderList($param);
			$count = $rdmodel->getOrderCount($param);
			$res['count'] = $count;
			$res['list'] = $list;
			echo json_encode($res);
		} else {
			$this->display('homev2/purse_payment');
		}
	}
	
	/**
	 * 提现记录
	 */
	public function cashrecords(){
		$user = $this->user;
		$cashrecordsModel = $this->model("Cashrecords");
		$param = parsequery();
		$param['pagesize'] = 20;
		$param['uid'] = $user['uid'];
		$param['limit'] = max(0,($param['page']-1)*$param['pagesize']).", ".$param['pagesize'];
		$list = $cashrecordsModel->getCashRecordsList($param);
		$count = $cashrecordsModel->getCashRecordsCount($param);
		$pagebar = show_page($count,$param['pagesize']);
		$this->assign('list',$list);
		$this->assign('pagebar',$pagebar);
		$this->display('homev2/purse_cashrecords');
	}

	/**
	 * 获取top信息
	 */
	public function getassigintop(){
		$user = $this->user;
		//uri
		$this->assign('controller',$this->uri->uri_control());
		$this->assign('action',$this->uri->uri_method());
        $clinfo = array();
        $clinfo['title']='';
		if($user['groupid']==5){//老师
			//积分等级
			$clconfig = Ebh::app()->getConfig()->load('creditlevel_t');
			foreach($clconfig as $clevel){
				if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
					$clinfo['title'] = $clevel['title'];
					if($user['credit']<=500){
						$clinfo['percent'] = 50*intval($user['credit'])/500;
					}elseif($user['credit']<=3000){
						$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
					}elseif($user['credit']<=10000){
						$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
					}else{
						$clinfo['percent'] = 100;
					}
					break;
				}
			}
		}elseif($user['groupid']==6){//学生
			//积分等级
			$clconfig = Ebh::app()->getConfig()->load('creditlevel');
			foreach($clconfig as $clevel){
				if($user['credit']>=$clevel['min'] && $user['credit']<=$clevel['max']){
					$clinfo['title'] = $clevel['title'];
					if($user['credit']<=500){
						$clinfo['percent'] = 50*intval($user['credit'])/500;
					}elseif($user['credit']<=3000){
						$clinfo['percent'] = 50+30*(intval($user['credit'])-500)/2500;
					}elseif($user['credit']<=10000){
						$clinfo['percent'] = 80+20*(intval($user['credit'])-3000)/7000;
					}else{
						$clinfo['percent'] = 100;
					}
					break;
				}
			}
		}
		$this->assign('clinfo',$clinfo);
		//完成度百分比
		$percent = Ebh::app()->user->getpercent($this->user);
		$this->assign('percent',$percent);
		 
		//粉丝
		$snsmodel = $this->model('Snsbase');
		$mybaseinfo = $snsmodel->getbaseinfo($this->user['uid']);
		$myfanscount = max(0,$mybaseinfo['fansnum']);
		//关注
		$myfavoritcount = max(0,$mybaseinfo['followsnum']);
		$this->assign('myfanscount',$myfanscount);
		$this->assign('myfavoritcount',$myfavoritcount);
	}
	/**
	 * 赞赏记录
	 */
	public function gratuity(){
		$user = Ebh::app()->user->getloginuser();
		$get = intval($this->input->get('get'));//学生获取字段,得到打赏记录
		if($user['groupid'] == 6 && !$get){//学生
			$param = parsequery();
			$param['pagesize'] = 20;
			$param['limit'] = max(0,($param['page']-1)*$param['pagesize']).", ".$param['pagesize'];
			$param['uid'] = $user['uid'];
			$param['type'] = intval($this->input->post('type'));
			$rwModel = $this->model('Reward');
			$rewardlist = array();
			$cwlist = array();
			$userrewardcount = $rwModel->getRwListByUidCount($param);
			$userrewardcount['sendreward'] = $userrewardcount['fee'];
			$userrewardcount['sendcount'] = $userrewardcount['c'];
			$rewardlist = $rwModel->getRwListByUid($param);
			if(!empty($rewardlist)){
				$cwidlist = array();
				foreach ($rewardlist as $list) {
					$cwidlist[$list['type']][] = $list['toid'];
				}
				if(!empty($cwidlist)){//查询课件信息
					$getQueName = 0;
					$isStudent = 1;
					$cwlist = $rwModel->getRwinfoListBytoids($cwidlist,$getQueName,$isStudent);
					if ($cwlist) {
						foreach ($rewardlist as &$relist) {//组装课件信息
							foreach ($cwlist as  $clist) {
								if($relist['toid'] == $clist['cwid'] && $relist['type'] == $clist['type']){
									$relist['title'] = shortstr(strip_tags($clist['title']),24,'...');
								}
							}
						}
					}
				}				
			}
			$showpage = show_page($userrewardcount['sendcount'],$param['pagesize']);
			$this->assign('showpage',$showpage);
			$this->assign('rewardlist',$rewardlist);
			$this->assign('rewardcount',$userrewardcount);
			$this->display('homev2/purse_gratuity_student');
		}else if($user['groupid'] == 5 || $get){//老师
			$param = parsequery();
			$param['type'] = intval($this->input->post('type'));
			$param['pagesize'] = 20;
			$param['limit'] = max(0,($param['page']-1)*$param['pagesize']).", ".$param['pagesize'];
			$param['touid'] = $user['uid'];
			$rewardlist = array();
			$cwlist = array();
			$rwModel = $this->model('Reward');
			$userrewardcount = $rwModel->getRwListByUidCount($param);
			$userrewardcount['getreward'] = $userrewardcount['fee'];
			$userrewardcount['getcount'] = $userrewardcount['c'];
			$rewardlist = $rwModel->getRwListByTouid($param);//获取打赏列表
			if(!empty($rewardlist)){
				$cwidlist = array();
				foreach ($rewardlist as $list) {
					$cwidlist[$list['type']][] = $list['toid'];
				}
				if(!empty($cwidlist)){//查询课件信息
					$getQueName = 1;
					$cwlist = $rwModel->getRwinfoListBytoids($cwidlist,$getQueName);				
					if ($cwlist) {
						foreach ($rewardlist as &$relist) {//组装课件信息
							foreach ($cwlist as  $clist) {
								if($relist['toid'] == $clist['cwid'] && $relist['type'] == $clist['type']){
									$relist['title'] = shortstr(strip_tags($clist['title']),24,'...');
									$relist['qusername'] = $clist['username'];
									$relist['qrealname'] = $clist['realname'];
									$relist['face'] = $clist['face'];
								}
							}
						}
					}
				}				
			}
			$showpage = show_page($userrewardcount['getcount'],$param['pagesize']);
			$this->assign('showpage',$showpage);
			$this->assign('rewardlist',$rewardlist);
			$this->assign('rewardcount',$userrewardcount);
			$this->display('homev2/purse_gratuity_teacher');
		}
		
	}
	/**
	 * 获取老师端 课件赞赏详情
	 */
	public function gratuitydetail(){
		$user = Ebh::app()->user->getloginuser();
		if($user['groupid'] == 5){
			$param = parsequery();
			$param['pagesize'] = 20;
			$param['limit'] = max(0,($param['page']-1)*$param['pagesize']).", ".$param['pagesize'];
			$param['type'] = intval($this->input->get('type'));
			$param['touid'] = $user['uid'];
			$rwModel = $this->model('Reward');
			$rewardlist = array();
			$rewardlist = $rwModel->getRwListByTouid($param);
			$rewardcount = $rwModel->getRwListDetailCountByTouid($param['touid']);
			$count = array();
			$total = 0;//总页数
			if (!empty($rewardcount)) {
				foreach ($rewardcount as $key => $value) {
					$reward[$value['toid']] = $value;
					if (isset($count[$value['type']])) {
						$count[$value['type']] += 1;
					} else {
						$count[$value['type']] = 1;
					}
					$total +=1; 
				}
			}
			if (!empty($param['type'])) {
				$total = $count[$param['type']];
			}
			$cwlist = array();
			if(!empty($rewardlist)){
				$cwidlist = array();
				foreach ($rewardlist as $list) {
					$cwidlist[$list['type']][] = $list['toid'];
				}
				if(!empty($cwidlist)){//查询课件信息
					$cwlist = $rwModel->getRwinfoListBytoids($cwidlist);
					if (!empty($cwlist)) {
						foreach ($cwlist as &$clist) {
							if (isset($reward[$clist['cwid']]) && $clist['type'] == $reward[$clist['cwid']]['type']) {
								$clist['rewardcount'] = $reward[$clist['cwid']]['c'];
								$clist['rewardmoney'] = $reward[$clist['cwid']]['fee'];
							} else {
								$clist['rewardcount'] = 0;
								$clist['rewardmoney'] = 0;
							}
							$clist['title'] = shortstr(strip_tags($clist['title']),24,'...');
						}
					}	
				}				
			}
			$showpage = show_page($total,$param['pagesize']);
			$this->assign('showpage',$showpage);
			$this->assign('cwlist',$cwlist);
			$this->assign('rewardcount',$count);
			$this->display('homev2/purse_gratuity_tdetail');
		}	
	}

	/**
	 * ajax获取课件打赏更多详情信息
	 */
	public function getGratuityByCwidAjax(){
		$cwid = (int)$this->input->post('cwid');
		$type = (int)$this->input->post('type');
		if(!empty($cwid) && is_numeric($cwid)){
			$user = Ebh::app()->user->getloginuser();
			$rwModel = $this->model('Reward');
			$rewardlist = $rwModel->getRewardsListByCwid($cwid,$user['uid'],$type);
			$dataarr = array();
			if(!empty($rewardlist)){
				foreach ($rewardlist as &$list) {//数据格式的处理
					$list['paytime'] = date('Y-m-d H:i',$list['paytime']);
					$list['name'] = empty($list['realname'])?$list['username']:$list['realname'];
					if($list['payfrom'] == 3){
						$list['payfrom'] = '支付宝';
					}else if($list['payfrom'] == 8){
						$list['payfrom'] = '个人钱包';
					}else if($list['payfrom'] == 9){
						$list['payfrom'] = '微信';
					}else{
						$list['payfrom'] = '其他';
					}
				}
				$dataarr = array('status'=>1,'data'=>$rewardlist);
				echo json_encode($dataarr);
				exit();
			}else{
				$dataarr = array('status'=>0);
				echo json_encode($dataarr);
				exit();
			}
		}
	}
}