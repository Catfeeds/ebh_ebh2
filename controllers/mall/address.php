<?php
//地址管理
class AddressController extends CControl{
	private $shopconfig;
	public function __construct(){
		parent::__construct();
		Ebh::app()->user->checkUserLogin(null,true);
		$this->shopconfig = Ebh::app()->getConfig()->load('shopconfig');
	}
	//地址列表
	public function all(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$url = $this->shopconfig['address_list_url'];
		$data['uid'] = $user['uid'];
		$data['crid'] = $roominfo['crid'];		
		$data['page'] =Ebh::app()->getUri()->page;
		$address = do_shop_post($url,$data);
		$address = json_decode($address, true);
		$pagination = show_page($address['total']);
		$this->assign('address', $address['lists']);
		$this->assign('pagination', $pagination);
		$this->assign('total', $address['total']);
		$this->display('mall/address/list');
	}
	//新增收获地址
	public function add(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$post = $this->input->post();
		$params['crid'] = $roominfo['crid'];
		$params['uid'] = $user['uid'];
		$params['consignee'] = $post['consignee'];
		$params['mobile'] = $post['mobile'];
		$flag = $this->isMobile($params['mobile']);
		if(!$flag){
			echo json_encode(array('status'=>false,'msg'=>'添加失败，手机号码不符合规范'));
			exit;
		}
		$params['province'] = $post['province'];
		$params['city'] = $post['city'];
		$params['district'] = $post['district'];
		$params['address'] = $post['address'];
		$params['tagname'] = $post['tagname'];
		$params['fulladdress'] = $post['fulladdress'];
		$params['default'] = $post['default'];
		$params['addr_id'] = $post['aid'];
		$params['aid'] = $post['aid'];
		$url = $this->shopconfig['address_operation_url'];
		$data = do_shop_post($url, $params);
		echo $data;die;
	}
	//删除收获地址
	public function del(){
		$user = Ebh::app()->user->getloginuser();
		$roominfo = Ebh::app()->room->getcurroom();
		$post = $this->input->post();
		$params['crid'] = $roominfo['crid'];
		$params['uid'] = $user['uid'];
		$params['addr_id'] = $post['aid'];
		$url = $this->shopconfig['address_del_url'];
		$data = do_shop_post($url, $params);
		echo $data;die;
	}
	//获取地址详情
	public function getAddress(){
		$post = $this->input->post();
		if(!empty($post)){
			$param['addr_id'] = $post['aid'];
			$url = $this->shopconfig['address_detail_url'];
			$res = do_shop_post($url, $param);
			echo $res;
		}
	}
	/**
	 * [isMobile 检验手机号码]
	 * @param  [type]  $mobile [description]
	 * @return boolean         [description]
	 */
	public function isMobile($mobile) {
	    if (!is_numeric($mobile) || empty($mobile)) {
	        return false;
	    }
	    return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
	}
}