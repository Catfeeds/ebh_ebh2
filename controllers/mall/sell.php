<?php
//销售管理
class SellController extends CControl{
	private $shopconfig;
    public function __construct(){
        parent::__construct();
        Ebh::app()->user->checkUserLogin(null,true);
        $this->shopconfig = Ebh::app()->getConfig()->load('shopconfig');
    }
	/**
	 * [index 显示销售管理]
	 * @return [type] [description]
	 */
	public function index(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$param = parsequery();
		$param['payfrom'] = $this->input->get('payfrom');
		$param['payfrom'] = empty($param['payfrom']) ? 0 : $param['payfrom'];
		$param['seller_uid'] = $user['uid'];
		$param['crid'] = $roominfo['crid'];
		$page = empty($param['page']) ? 1 : $param['page'];
		$pagesize = 20;
		$url = $this->shopconfig['order_sell_url'];
		$res = do_shop_post($url,$param,false);
		$pagestr = show_page($res->count,$pagesize);
		$this->assign('pagestr',$pagestr);
		$this->assign('fee',$res->fee);
		$this->assign('totalfee',$res->totalfee);
		$this->assign('orderlist',$res->orderlist);
		$this->assign('payfrom',$param['payfrom']);
		$this->assign('count',$res->count);
		$this->assign('page',$page);
		$this->assign('q',$param['q']);
		$this->display('mall/sell/list');
	}
	/**
	 * 获取订单详情页
	 */
	public function getOrdersDetail(){
		$ordernum = $this->input->get('orderid');
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_getdetail_url'];
		$res = do_shop_post($url,array('ordernum'=>$ordernum),false);
		$room = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		$this->assign('room',$room);
		$this->assign('user',$user);
		$this->assign('orderlist',$res->orderdetail);
		$this->display('mall/sell/selldetail');
	}
}