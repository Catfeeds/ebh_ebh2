<?php
/*
结算管理
*/
class SettlementController extends ARoomV3Controller{
	/*
	订单列表
	*/
	public function orderList(){
		$param = $this->input->get();
		
		$param['crid'] = $this->roominfo['crid'];
		$param['pagesize'] = empty($param['pagesize'])?100:$param['pagesize'];
		$param['page'] = empty($param['page'])?1:$param['page'];
		$param['payfrom'] = !isset($param['payfrom'])?"all":$param['payfrom'];
		if(isset($param['needtype']) && $param['needtype'] === ''){
			unset($param['needtype']);
		}
		//交易排序
		// if($param['sort']==1){
			// $param['order'] = ' o.totalfee ASC';
		// }elseif($param['sort']==2){
			// $param['order'] = ' o.totalfee DESC';
		// }else{
			$param['order'] = ' o.orderid DESC';
		// }
		
		$param['money'] = empty($param['money'])?-1:intval($param['money']);
		$list =  $this->apiServer->reSetting()->setService('Aroomv3.Settlement.payOrderList')->addParams($param)->request();
		$IPaddress =Ebh::app()->lib('IPaddress');
		foreach($list['list'] as &$order){
			$newip = !empty($order['ip']) && ($order['ip']!='127.0.0.1') ? $order['ip'] : $order['payip'];
		    if(!empty($newip) && ($newip !='127.0.0.1')){
		        $iprow = $IPaddress->find($order['ip']);
		        @ $order['ipaddr'] = $iprow[1].$iprow[2]." [".$newip."]";
		    }else{
		        $order['ipaddr'] = '未知IP';
		    }
		}
		$this->renderJson(0,'',$list);
	}
	
	/*
	订单详情
	*/
	public function orderDetail(){
		$param['orderid'] = $this->input->get('orderid');
		if(empty($param['orderid'])){
			$this->renderJson(1,'参数错误');
		}
		$param['crid'] = $this->roominfo['crid'];
		$list =  $this->apiServer->reSetting()->setService('Aroomv3.Settlement.payOrderDetail')->addParams($param)->request();
		$this->renderJson(0,'',$list);
	}
	
	/*
	交易列表
	*/
	public function earningList(){
		$param = $this->input->get();
		$param['crid'] = $this->roominfo['crid'];
		$param['pagesize'] = empty($param['pagesize'])?100:$param['pagesize'];
		$param['page'] = empty($param['page'])?1:$param['page'];
		$list =  $this->apiServer->reSetting()->setService('Aroomv3.Settlement.earningList')->addParams($param)->request();
		$this->renderJson(0,'',$list);
	}
	
	/*
	结算申请列表
	*/
	public function applyList(){
		$param = $this->input->get();
		$param['crid'] = $this->roominfo['crid'];
		$param['pagesize'] = empty($param['pagesize'])?100:$param['pagesize'];
		$param['page'] = empty($param['page'])?1:$param['page'];
		$list =  $this->apiServer->reSetting()->setService('Aroomv3.Settlement.applyList')->addParams($param)->request();
		$this->renderJson(0,'',$list);
	}
	
	/*
	申请结算
	*/
	public function apply(){
		$param = $this->input->post();
		$param['crid'] = $this->roominfo['crid'];
		if(empty($param['money']) || $param['money'] <= 0){
			$this->renderJson(1,'参数错误');
		}
		if(empty($param['isinvoice'])){//没发票，税率8%
			$param['taxrat'] = 0.08;
			$param['moneyaftertax'] = round($param['money']*(1-$param['taxrat']),2);
		} else {
			$param['taxrat'] = 0;
		}
		Ebh::app()->getDb()->set_con(0);//防止身份验证提交后，获取不到
		$authstatus = $this->authStatus(true);
		if(!empty($param['aid'])){//第一次伴随身份验证
			if(empty($authstatus) || $authstatus['status'] != 2){
				$this->renderJson(1,'没有进行中的审核');
			}
			$list =  $this->apiServer->reSetting()->setService('Aroomv3.Settlement.applyList')->addParams(array('crid'=>$param['crid'],'aid'=>$param['aid']))->request();
			if(!empty($list['list'])){
				$this->renderJson(1,'已有申请');
			}
		} elseif(!empty($param['smscode'])) {//之后短信验证,
			if(empty($authstatus) || $authstatus['status'] != 1){
				$this->renderJson(1,'尚未通过身份验证');
			}
			//简易验证
			$mcode = md5($param['smscode']);
			$smscode_cache = $this->cache->get($mcode);
			$str = authcode($smscode_cache,'DECODE');
			if(empty($str)){
				$this->renderJson(1,'校验码填写不正确或者已过期');
				return;
			}
			@list($crid,$mobile,$ip) = explode('\t', $str);
			if($crid != $this->roominfo['crid'] || $ip != getip()){
				$this->renderJson(1,'信息验证失败');
			}
		} else {
			$this->renderJson(1,'参数错误');
		}
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.apply')->addParams($param)->request();
		
		$this->renderJson($res['status'],$res['msg'],array(),FALSE);
		if($res['status'] == 0){
			fastcgi_finish_request();
			$smsconfig = Ebh::app()->getConfig()->load('auditsms');
			if(!empty($smsconfig['com_phones'])){
				foreach($smsconfig['com_phones'] as $mobile){
					if(preg_match("/^1[3-8]{1}\d{9}$/",$mobile)){
						Ebh::app()->lib('SMS')->jsSend($mobile,array('name'=>$this->roominfo['crname'],'price'=>$param['money']),1);
					} else {
						log_message('配置的手机号不正确,from结算申请');
					}
				}
			}
		}
		
		
	}
	
	/*
	获取绑定信息
	*/
	public function getBind(){
		$param['uid'] = $this->user['uid'];
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.getBind')->addParams($param)->request();
		$this->renderJson(0,'',$res);
	}
	
	/*
	申请限制查询
	*/
	public function checkApplyLimit(){
		$param['crid'] = $this->roominfo['crid'];
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.checkApplyLimit')->addParams($param)->request();
		$this->renderJson(0,'',$res);
	}
	
	/*
	审核验证进行状态,status,0:没有进行中的审核(或者全是失败),1:审核成功,2:有正在进行中的审核
	*/
	public function authStatus($isreturn=FALSE,$aid=0){
		$param['crid'] = $this->roominfo['crid'];
		$param['aid'] = $aid;
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.authStatus')->addParams($param)->request();
		if(!$isreturn){
			$this->renderJson(0,'',$res);
		} else {
			return $res;
		}
	}
	
	/*
	提交身份验证
	*/
	public function doAuth(){
		$param = $this->input->post();
		$param['uid'] = $this->user['uid'];
		$bind = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.getBind')->addParams($param)->request();
		if($bind['ismobile'] == 1 && !empty($bind['mobile'])){
			$param['mobile'] = $bind['mobile'];
		} else {
			$this->renderJson(1,'尚未绑定手机');
		}
		$param['crid'] = $this->roominfo['crid'];
		if(empty($param['idcard_z']) || empty($param['idcard_b'])){
			$this->renderJson(1,'参数错误');
		}
		Ebh::app()->getDb()->set_con(0);
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.doAuth')->addParams($param)->request();
		if($res != FALSE){
			$this->renderJson(0,'成功',$res,FALSE);
			fastcgi_finish_request();
			$smsconfig = Ebh::app()->getConfig()->load('auditsms');
			if(!empty($smsconfig['auth_phones'])){
				foreach($smsconfig['auth_phones'] as $mobile){
					if(preg_match("/^1[3-8]{1}\d{9}$/",$mobile)){
						Ebh::app()->lib('SMS')->jsSend($mobile,array('name'=>$this->roominfo['crname']),0);
					} else {
						log_message('配置的手机号不正确,from身份验证');
					}
				}
			}
		} else {
			$this->renderJson(1,'失败');
		}
	}
	
	/**
	 * [获取手机验证码]
	 */
	public function getSmsCode(){
		$param['uid'] = $this->user['uid'];
		$authstatus = $this->authStatus(true);
		if(empty($authstatus) || $authstatus['status'] != 1){
			$this->renderJson(1,'尚未通过身份验证');
		}
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.getBind')->addParams($param)->request();
		if($res['ismobile'] == 1 && !empty($res['mobile'])){
			$code = $this->ticketget($res['mobile']);
			$ip = getip();
			$mip = md5($ip);
			$powertag = !$this->cache->get($mip);
			if($powertag){
				$this->cache->set($mip,1,60);
			}else{
				$this->renderJson(1,'距离上次发送短信时间间隔小于60秒，请稍后再试！');
			}
			//发送短信
			$this->smsSend($code,$res['mobile']);
		} else {
			$this->renderJson(1,'绑定信息不正确');
		}
	}
	
	/**
	 * [发送短信逻辑]
	 */
	public function smsSend($code,$mobile){
		$msg = $code.'（手机验证码，请完成验证）如非本人操作，请忽略此短信。';
		$fix = $this->input->get('fix');
		if(!empty($fix)){
			$res = Ebh::app()->lib('SMS')->send_fix($mobile,$msg);
		}else{
			$res = Ebh::app()->lib('SMS')->send_dayu($mobile,$code);
		}
		$this->renderJson(0,'短信校验码已发送');
	}

	/**
	 * [生成验证码，有效期120秒]
	 */
	private function ticketget($mobile){
		//生成票据
		$ip = getip();
		$str = $this->roominfo['crid'].'\t'.$mobile.'\t'.$ip;
		$k = authcode($str,'ENCODE');
		do{
			$code = random(6,true);
			$mcode = md5($code);
		}while($this->cache->get($mcode));
		$this->cache->set($mcode,$k,120);
		return $code;
	}
	
	
	/**
	 * [短信验证码校验]
	 */
	public function smsCheck(){
		$code = trim($this->input->post('smscode'));
		if(empty($code)){
			$this->renderJson(1,'短信验证码不能为空');
			return;
		}
		$mcode = md5($code);
		$smscode_cache = $this->cache->get($mcode);
		$str = authcode($smscode_cache,'DECODE');
		if(empty($str)){
			$this->renderJson(1,'校验码填写不正确或者已过期');
			return;
		}
		@list($crid,$mobile,$ip) = explode('\t', $str);
		if(empty($mobile) || empty($ip)){
			$this->renderJson(1,'短信验证码校验失败');
			return;
		}else{
			$curip = getip();
			if($curip!= $ip){
				$this->renderJson(1,'IP发生改变，校验失败');
				return;
			}
			$param['uid'] = $this->user['uid'];
			$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.getBind')->addParams($param)->request();
			if($res['ismobile'] == 1 && !empty($res['mobile'])){
				if($res['mobile'] != $mobile){
					$this->renderJson(1,'手机号不匹配，校验失败');
					return;
				}
				$this->renderJson(0,'校验成功');
			} else {
				$this->renderJson(1,'校验失败');
			}
			
		}
	}
	
	/*
	余额,可提取统计
	*/
	public function moneyStats(){
		$param['crid'] = $this->roominfo['crid'];
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.moneyStats')->addParams($param)->request();
		$this->renderJson(0,'',$res);
	}
	/*
	收入统计
	*/
	public function earningStats(){
		$param['crid'] = $this->roominfo['crid'];
		$param['starttime'] = $this->input->get('starttime');
		$param['endtime'] = $this->input->get('endtime');
		$param['bywhich'] = $this->input->get('bywhich');//day，month，type
		$res = $this->apiServer->reSetting()->setService('Aroomv3.Settlement.earningStats')->addParams($param)->request();
		$this->renderJson(0,'',$res);
	}
}