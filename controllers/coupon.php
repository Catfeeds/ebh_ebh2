<?php
/**
 * 优惠码控制器
 */
class CouponController extends CControl{
	/**
	 * 优惠码首页
	 */
	public function index(){
		$param['code'] = $this->input->get('code');
		$coupon = $this->model('coupons')->getOne($param);
		if (!empty($coupon)){
			$roominfo = $this->model('classroom')->getclassroomdetail($coupon['crid']);
		}else{
		    $roominfo = array();
		}
		$this->assign('mycoupon', $coupon);
		$this->assign('roominfo', $roominfo);

		if(!empty($_SERVER['HTTP_USER_AGENT'])){
		    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		    $is_iphone = (strpos($agent, 'iphone')) ? true : false;
		    $is_android = (strpos($agent, 'android')) ? true : false;
		    $is_ipad = (strpos($agent, 'ipad')) ? true : false;
		}else{
		    $is_iphone = $is_android = $is_ipad  = false;
		}
        if($is_iphone || $is_android || $is_ipad){
			$this->display('common/coupon_mobile');
		} else {
			$this->display('common/coupon');
		}
	}
}