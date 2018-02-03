<?php
// 订单管理
class OrderController extends CControl{
	private $shopconfig;
    public function __construct(){
        parent::__construct();
        Ebh::app()->user->checkUserLogin(null,true);
        $this->shopconfig = Ebh::app()->getConfig()->load('shopconfig');
    }
	const PAGE_SIZE = 20;
	//订单管理列表
	public function all(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['seller_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders = do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('type', $type);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'all');
		$this->display('mall/order/list');
	}
	// 待付款
	public function waitpay(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['seller_uid'] = $user['uid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 1;
		$data['crid'] = $roominfo['crid'];
		$data['pagesize'] = self::PAGE_SIZE;
		$orders = do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'waitpay');
		$this->display('mall/order/list');
	}
	// 待发货
	public function waitsend(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['seller_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 2;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders = do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'waitsend');
		$this->display('mall/order/list');
	}
	// 已发货
	public function sended(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['seller_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 3;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders = do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'sended');
		$this->display('mall/order/list');
	}
	// 交易成功
	public function succeed(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['seller_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 4;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders = do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'succeed');
		$this->display('mall/order/list');
	}
	// 交易关闭
	public function closed(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['seller_uid'] = $user['uid'];
		$data['status'] = 7;
		$data['page'] =Ebh::app()->getUri()->page;
		$data['crid'] = $roominfo['crid'];
		$data['pagesize'] = self::PAGE_SIZE;
		$orders = do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'closed');
		$this->display('mall/order/list');
	}
	//订单详情
	public function detail_view(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$data['seller'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['ordernum'] =$this->uri->itemid;
		$url = $this->shopconfig['order_detail_url'];
		$order = do_shop_post($url,$data);
		$order = json_decode($order, true);
		$this->assign('order', $order);
		$this->assign('user',$user);
		return $this->display('mall/order/detail');
	}
    /*************买家订单管理*******************/
    //普通订单
    public function cgeneral(){
    	$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid']; //买家
		$data['crid'] = $roominfo['crid'];
		$data['type'] = 1;
		$data['page'] =Ebh::app()->getUri()->page;
		$data['pagesize'] = self::PAGE_SIZE;
		// p($data);die;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		// var_dump($orders['orders']);
		// p($orders);die;
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('type', $type);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'cgeneral');
		if(!empty($data['status']) && $data['status'] != 0 && $data['status'] != 1){
			$this->display('mall/order/general'); //非全部和代付款的搜索
		} else {
			$this->display('mall/order/general_new');	
		}
    }
    //积分订单
     public function cscore(){
    	$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid']; //买家
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['type'] = 2;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		// p($orders);die;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('type', $type);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'cscore');
		$this->display('mall/order/score');	
    }
    // 待付款
	public function cwaitpay(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 1;
		$data['crid'] = $roominfo['crid'];
		$data['type'] = 1;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'cwaitpay');
		$this->display('mall/order/general_new');
	}
	// 待发货
	public function cwaitsend(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 2;
		$data['type'] = 1;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'cwaitsend');
		$this->display('mall/order/general');
	}
	// 已发货
	public function csended(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 3;
		$data['type'] = 1;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'csended');
		$this->display('mall/order/general');
	}
	// 交易成功
	public function csucceed(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 4;
		$data['type'] = 1;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'csucceed');
		$this->display('mall/order/general');
	}
	// 交易关闭
	public function cclosed(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid'];
		$data['status'] = 7;
		$data['page'] =Ebh::app()->getUri()->page;
		$data['crid'] = $roominfo['crid'];
		$data['type'] = 1;
		$type = isset($data['type']) ? $data['type'] : 1;
		$orders = do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		// p($orders);die;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'cclosed');
		$this->display('mall/order/general');
	}
	//关闭交易
	public function closeorder(){
		$user = Ebh::app()->user->getloginuser();
		$ordernum = $this->input->post('ordernum');
		$url = $this->shopconfig['order_close_url'];
		$data['ordernum'] = $ordernum;
		$data['uid'] = $user['uid'];
		$data =  do_shop_post($url,$data);
		// p(json_decode($data,true));die;
		echo $data;die;
	}

	//已买到的积分商品
	// 待发货
	public function cswaitsend(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 2;
		$data['type'] = 2;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'cswaitsend');
		$this->display('mall/order/score');
	}
	// 已发货
	public function cssended(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 3;
		$data['type'] = 2;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'cssended');
		$this->display('mall/order/score');
	}
	// 交易成功
	public function cssucceed(){
		$params = $this->input->get(); //订单查询参数
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['order_list_url'];
		$data = $this->input->get();
		$data['buyer_uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];
		$data['page'] =Ebh::app()->getUri()->page;
		$data['status'] = 4;
		$data['type'] = 2;
		$type = isset($data['type']) ? $data['type'] : 1;
		$data['pagesize'] = self::PAGE_SIZE;
		$orders =  do_shop_post($url,$data);
		$orders = json_decode($orders, true);
		$type = isset($data['type']) ? $data['type'] : 1;
		$pagination = show_page($orders['total'],self::PAGE_SIZE);
		$this->assign('pagination', $pagination);
		$this->assign('type', $type);
		$this->assign('user', $user);
		$this->assign('data', $data);
		$this->assign('orders', $orders['orders']);
		$this->assign('roominfo', $roominfo);
		$this->assign('method', 'cssucceed');
		$this->display('mall/order/score');
	}
	//确认收货
	public function confirm(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$oids = $this->input->post('oids');
		$url = $this->shopconfig['order_confirm_url'];
		$data['ordernums'] = $oids;
		$ret =  do_shop_post($url,$data);
		echo $ret;die;
	}
	//修改价格
	public function change_view(){
		$post = $this->input->post();
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(empty($post)){
			$data['orderid'] = $this->uri->itemid;
			$data['type'] = 1;//1为获取订单详情
			$url = $this->shopconfig['order_modifyorder_url'];
			$orderlist = do_shop_post($url,$data);
			$orderlist = json_decode($orderlist,true);
			if($orderlist['orderlist'][0]['seller_uid'] != $user['uid']){
				header('Location: /mall/order/all.html');
				exit;
			}
			$this->assign('orderid',$data['orderid']);
			$this->assign('orderlist',$orderlist['orderlist']);
			$this->display('mall/order/change');
		}else{
			$gid = $post['gid'];
			$price = $post['price'];
			if(!empty($gid) && !empty($price)){
				$gparr = array_combine($gid, $price);
				$data['data'] = json_encode($gparr);
				$data['type'] = 2;
				$data['orderid'] = $this->uri->itemid;
				$data['uid'] = $user['uid'];
				$url = $this->shopconfig['order_modifyorder_url'];
				$res = do_shop_post($url,$data);
				echo $res;
				exit;
			}
		}
	}
	/**
	 * [conreceipt_view 确认收货]
	 * @return [type] [description]
	 */
	public function conreceipt_view(){
		$ordernum = $this->uri->itemid;
		$roominfo = Ebh::app()->room->getcurroom();
		$user = Ebh::app()->user->getloginuser();
		if(!empty($ordernum)){
			$data['ordernum'] = $ordernum;
			$data['uid'] = $user['uid'];
			$url = $this->shopconfig['order_conreceipt_url'];
			$orderinfo = do_shop_post($url, $data);
			$orderinfo = json_decode($orderinfo,true);
			if($orderinfo['status'] == 1){
				$this->assign('ordernum',$ordernum);
				$this->assign('orderlist',$orderinfo['orderlist']);
				$this->assign('address',$orderinfo['address']);
				$this->assign('user',$orderinfo['user']);
				$this->display('mall/order/conreceipt');
			}
		}
	}
	/**
	 * 确认收货，修改订单
	 */
	public function conreceiptOrder(){
		$post = $this->input->post();
		$user = Ebh::app()->user->getloginuser();
		if(!empty($post)){
			$ordernum = $post['ordernum'];
			$ppassword = $post['ppassword'];
			$pparr = array(
					'ppassword' => $ppassword,
					'uid' => $user['uid']
				);
			$purl = $this->shopconfig['order_check_url'];
			$status = do_shop_post($purl, $pparr);
			$status = json_decode($status,true);
			if($status['status']){//支付密码正确
				$url = $this->shopconfig['order_conreceiptorder_url'];
				$orderarr = array(
							'ordernum' => $ordernum,
							'uid' => $user['uid']
					);
				$updatestatus = do_shop_post($url, $orderarr);
				$updatestatus = json_decode($updatestatus,true);
				echo json_encode(array('status'=>$updatestatus));exit;
			}
		}
	}
	
	/*
	卖家确认退款
	*/
	public function refund(){
		$ordernum = $this->input->post('ordernum');
		if(!is_numeric($ordernum)){
			echo json_encode(array('status'=>-1));
			exit;
		}
		$url = $this->shopconfig['order_refund_url'];
		
		$user = Ebh::app()->user->getloginuser();
		$orderarr = array(
			'ordernum' => $ordernum,
			'uid' => $user['uid']
		);
		$status = do_shop_post($url, $orderarr);
		echo json_encode(array('status'=>$status));
	}
}